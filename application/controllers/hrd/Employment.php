<?php

/**
 * @author          Mohammad Milzam Kasyfillah Hutomo | milzam.khutomo@gmail.com
 * @link            https://linktr.ee/m.hutomo
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Employment extends MY_Controller
{
	protected $view = 'contents/hrd/employment/';
	protected $employee = 'employees';
	protected $employee_pt = 'employee_pt';
	protected $employee_position = 'employee_position';
	protected $user = 'users';
	protected $login = 'login';
	protected $educations = 'educations';
	protected $agreement = 'work_agreement_docs';
	protected $status_update = 'status_updates';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->hrd();
		$this->load->model('employments');
	}

	public function index()
	{
		$data['content']		= $this->view.'content';
		$data['css']			= $this->view.'css';
		$data['javascript']		= $this->view.'js_content';
		$data['title']			= 'Pegawai';
		$data['sub_title']		= '';
		$data['notif']			= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['provinces']		= $this->db->get('provinces');
		$data['cities']			= $this->db->get('cities');
		$data['districts']		= $this->db->get('districts');
		$data['organizations']	= $this->db->get('organizations');
		$data['positions']		= $this->db->get('positions');
		$data['employees'] 		= $this->employments->getAllEmployeeActive();
		$data['status']			= $this->db->get('employment_statuses')->result();
		$data['active_status']	= $this->db->get('employment_active_statuses')->result();

		$group = NULL;
		$status = NULL;
		$active_status = NULL;
		$position = NULL;
		$org_unit = NULL;
		$start = NULL;
		$finish = NULL;

		if (isset($_GET['group']) && $_GET['group'] != 'Semua') {
			$group = $_GET['group'];
		}

		if (isset($_GET['position']) && $_GET['position'] != 'Semua') {
			$position = $_GET['position'];
		}

		if (isset($_GET['org_unit']) && $_GET['org_unit'] != 'Semua') {
			$org_unit = $_GET['org_unit'];
		}

		if (isset($_GET['status']) && $_GET['status'] != 'Semua') {
			$status = $_GET['status'];
		}

		if (isset($_GET['active_status']) && $_GET['active_status'] != 'Semua'){
			$active_status = $_GET['active_status'];
		}

		$result = $this->employments->searchEmployeeByFilter($group, $position, $org_unit, $status, $active_status);
		
		$data['data']	= $result;
		$data['employee_null_position'] = $this->employments->getEmployeeNullPosition($status);

		$this->load->view('includes/main', $data);
	}

	public function show()
	{
		$data['content']	= $this->view.'show';
		$data['css']		= $this->view.'css';
		$data['javascript']	= '';
		$data['title']		= 'Pegawai';
		$data['sub_title']	= 'Detail';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['employee']	= $this->employments->showEmployee($this->uri->segment(4))->row();

		if (!isset($data['employee'])) {	
			$this->session->set_flashdata('error', 'Data pegawai tidak ditemukan');
			redirect('hrd/employment');
		}

		$data['organizations']	= $this->employments->showEmployeeOrgUnit($this->uri->segment(4));
		$data['educations']	= $this->employments->showEmployeeEducation($this->uri->segment(4));
		// $data['overtimes']	= $this->employments->showEmployeeOvertime($this->uri->segment(4));

		$mulai = $data['employee']->join_date;
		$selesai = date('Y-m-d', strtotime(date('Y-m-d', strtotime($mulai)). " + 1 year"));
		$selesai = date('Y-m-d', strtotime(date('Y-m-d', strtotime($selesai)). " - 1 day"));
		$diff = abs(strtotime(date('Y-m-d')) - strtotime($mulai));
		$years = floor($diff / (365*60*60*24));
		$periode = array();

		for ($i=0; $i <= $years ; $i++) { 
			if ($i > 0) {
				$mulai =  date('Y-m-d', strtotime(date('Y-m-d', strtotime($mulai)). " + 1 year"));
				$selesai = date('Y-m-d', strtotime(date('Y-m-d', strtotime($selesai)). " + 1 year"));
			}

			$join['start'] = $mulai;
			$join['end'] = $selesai;
			array_push($periode, $join);
		}

		$data['period'] = $periode;

		$start = NULL;
		$end = NULL;

		if (isset($_GET['period'])) {
			$date = explode(' - ', $_GET['period']);
			$start = date('Y-m-d', strtotime($date[0]));
			if (isset($date[1])) {
				$end = date('Y-m-d', strtotime($date[1]));
			}
		}

		$data['leaves']		= $this->employments->showEmployeeLeave($this->uri->segment(4), $start, $end);
		$count_leave = $this->employments->showEmployeeLeave($this->uri->segment(4), $start, $end, 2);
		$sum = 0;

		foreach ($count_leave->result() as $key) {
			$awal = new DateTime($key->start);
			$akhir = new DateTime($key->finish);
			$interval = $awal->diff($akhir);
			$elapsed = $interval->format('%d');
			if ($key->type == 'Cuti') {
				$sum = $sum + $elapsed + 1;
			}
		}

		$data['count_leave']= $sum;

		$this->load->view('includes/main', $data);
	}

	public function store()
	{
		if ($this->db->get_where('employee_pt', $this->input->post('nip'))->num_rows() > 0) {			
			$this->session->set_flashdata('error', 'NIP pegawai telah terdaftar');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->trans_begin();

		$employees = array(			
			'name' => $this->input->post('name'),
			'religion' => $this->input->post('religion'),
			'sex' => $this->input->post('sex'),
			'phone' => $this->input->post('phone'),
			'birthday' => date('Y-m-d', strtotime($this->input->post('birthday'))),
			'province_id' => $this->input->post('province_id'),
			'city_id' => $this->input->post('city_id'),
			'district_id' => $this->input->post('district_id'),
			'postal_code' => $this->input->post('postal_code'),
			'address' => $this->input->post('address'),
			'npwp' => $this->input->post('npwp'),
			'sid' => $this->input->post('sid'),
			'email' => $this->input->post('email'),
			'marital_status' => $this->input->post('marital_status'),
			'created_by' => $this->session->userdata('id'),
			'updated_by' => $this->session->userdata('id')
		);

		$users = array(
			'username' => $this->input->post('nip'),
			'password' => md5($this->input->post('nip')),
			'created_by' => $this->session->userdata('id'),
			'updated_by' => $this->session->userdata('id')			
		);

		$login = array(
			'role_id' => self::EMPLOYEE,
			'created_by' => $this->session->userdata('id')
		);

		if($this->input->post('active_status') === NULL){
			$active_status = NULL;
		}else{
			$active_status = $this->input->post('active_status');
		}
		
		$employee_pt = array(
			'group_id' => $this->input->post('group_id'),
			'nip' => $this->input->post('nip'),
			'rfid' => $this->input->post('rfid'),
			'nitk' => $this->input->post('nitk'),
			'nidk' => $this->input->post('nidk'),
			'nidn' => $this->input->post('nid'),
			'status' => $this->input->post('status'),
			'active_status' => $active_status,
			'functional_position_id' => $this->input->post('functional_position_id'),
			'work_agreement_status' => $this->input->post('work_agreement_status'),
			'join_date' => $this->input->post('join_date'),
			'effective_date' => $this->input->post('effective_date'),
			'created_by' => $this->session->userdata('id'),
			'updated_by' => $this->session->userdata('id')
		);

		$employee_position = array(
			'position_id' => $this->input->post('position_id'),
			'start_date' => $this->input->post('join_date'),
			'end_date' => $this->input->post('end_date')
		);

		// Insert users
		$this->db->insert($this->user, $users);
		$user_id = $this->db->insert_id();

		if ($user_id) {
			$login['user_id'] = $user_id;
			// Insert logins
			$this->db->insert($this->login, $login);

			// Insert employees
			$this->db->insert($this->employee, $employees);
			$employee_id = $this->db->insert_id();

			if ($employee_id) {
				for ($x=0; $x < count($this->input->post('educations')); $x++) {			
					$educations = array(
						'employee_id' => $employee_id,
						'level' => $this->input->post('educations')[$x],
						'institution' => $this->input->post('institutions')[$x],
						'graduate' => $this->input->post('graduates')[$x],
						'created_by' => $this->session->userdata('id'),
						'updated_by' => $this->session->userdata('id')
					);

					$this->db->insert($this->educations, $educations);
				}

				$employee_pt['user_id'] = $user_id;
				$employee_pt['employee_id'] = $employee_id;

				// Insert employee_pt
				$this->db->insert($this->employee_pt, $employee_pt);

				// Insert status_updates
				$this->db->insert(
					$this->status_update, 
					array(
						'employee_id' 	=> $employee_id,
						'status'		=> $this->input->post('status'),
						'active_status'	=> $active_status,
						'updated_by'	=> $this->session->userdata('id')
					)
				);

				// Work Agreement File Upload
				$file = $_FILES['work_agreement_file'];
		
				if(strlen($file['name'])){
					$f_name = $file['name'];
					$f_type = $file['type'];
					$f_content = file_get_contents($file['tmp_name']);

					$agreement = array(
						'employee_id' 	=> $employee_id,
						'name'			=> $f_name,
						'doc_type'		=> $f_type,
						'doc'			=> $f_content,
						'uploaded_by'	=> $this->session->userdata('id')
					);
				}

				// Insert work_agreement_docs
				$this->db->insert($this->agreement, $agreement);

				if ($employee_id) {
					$employee_position['employee_id'] = $employee_id;

					// Insert employee_positions
					$this->db->insert($this->employee_position, $employee_position);
				} else {
					$error = $this->db->error();
					$this->session->set_flashdata('error', $error);
				}
			} else {
				$error = $this->db->error();
				$this->session->set_flashdata('error', $error);
			}
		} else {
			$error = $this->db->error();
			$this->session->set_flashdata('error', $error);
		}

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	    } else {
			$this->session->set_flashdata('success', 'Pegawai berhasil ditambahkan');
	        $this->db->trans_commit();
	    }
		
		redirect('/hrd/employment/show/'.$employee_id);
	}

	public function edit()
	{
		$data['content']	= $this->view.'edit';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'js_edit';
		$data['title']		= 'Pegawai';
		$data['sub_title']	= 'Ubah';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data']		= $this->employments->showEmployee($this->uri->segment(4))->row();
		$data['agreement']	= $this->employments->showEmployeeAgreement($this->uri->segment(4))->row();
		$data['employee_position']	= $this->employments->showEmployeeOrgUnit($this->uri->segment(4))->row();
		$data['provinces']	= $this->db->get('provinces');
		$data['cities']		= $this->db->get('cities');
		$data['districts']	= $this->db->get('districts');
		$data['organizations']	= $this->db->get('organizations');
		$data['positions']	= $this->db->get('positions');
		$data['educations']	= $this->db->select('*')->from('educations')->where('employee_id', $data['data']->employee_id)->get();

		$this->load->view('includes/main', $data);
	}

	public function update()
	{
		$this->db->trans_begin();

		if ($this->input->post('province_id') == '') {
			$province_id = NULL;
		} else {
			$province_id = $this->input->post('province_id');
		}

		if ($this->input->post('city_id') == '') {
			$city_id = NULL;
		} else {
			$city_id = $this->input->post('city_id');
		}

		if ($this->input->post('district_id') == '') {
			$district_id = NULL;
		} else {
			$district_id = $this->input->post('district_id');
		}

		$employees = array(			
			'name' => $this->input->post('name'),
			'religion' => $this->input->post('religion'),
			'sex' => $this->input->post('sex'),
			'phone' => $this->input->post('phone'),
			'birthday' => $this->input->post('birthday'),
			'province_id' => $province_id,
			'city_id' => $city_id,
			'district_id' => $district_id,
			'postal_code' => $this->input->post('postal_code'),
			'address' => $this->input->post('address'),
			'npwp' => $this->input->post('npwp'),
			'sid' => $this->input->post('sid'),
			'email' => $this->input->post('email'),
			'marital_status' => $this->input->post('marital_status'),
			'updated_by' => $this->session->userdata('id')
		);

		if($this->input->post('active_status') === NULL){
			$active_status = NULL;
		}else{
			$active_status = $this->input->post('active_status');
		}

		$check_status = $this->employments->getCurrentStatus($this->uri->segment(4))->row();

		if($check_status->status != $this->input->post('status') || $check_status->active_status != $this->input->post('active_status')){
			$data = array(
				'employee_id' => $this->uri->segment(4),
				'status' => $this->input->post('status'),
				'active_status' => $this->input->post('active_status'),
				'updated_by' => $this->session->userdata('id')
			);
			
			// Insert status_updates
			$this->db->insert($this->status_update, $data);
		}

		if ($this->input->post('status') != MY_Controller::CONTRACT) {
			$this->db->where('employee_id', $this->uri->segment(4));
			$this->db->delete('employment_promotion'); 
		}

		$employee_pt = array(
			'group_id' => $this->input->post('group_id'),
			'nip' => $this->input->post('nip'),
			'rfid' => $this->input->post('rfid'),
			'status' => $this->input->post('status'),
			'active_status' => $active_status,
			'work_agreement_status' => $this->input->post('work_agreement_status'),
			'join_date' => $this->input->post('join_date'),
			'effective_date' => $this->input->post('effective_date'),
			'updated_by' => $this->session->userdata('id')
		);

		$employee_position = array(
			'position_id' => $this->input->post('position_id'),
			'start_date' => date('Y-m-d'),
			'end_date' => $this->input->post('end_date')
		);

		$ept_id = $this->input->post('employee_position_id');
		
		// Insert employee_pt
		$this->db->where('employee_id', $this->uri->segment(4))->update($this->employee_pt, $employee_pt);

		// echo $this->db->last_query();die();
		// if ($this->input->post('province_id') && $this->input->post('city_id') && $this->input->post('district_id')) {
			$this->db->where('id', $this->uri->segment(4))->update($this->employee, $employees);

		// echo $this->db->last_query();
		// die();	
		// } else {
		// 	$this->session->set_flashdata('error', 'Data pribadi pegawai belum berubah, harap lengkapi data terlebih dahulu');
		// }

		$this->db->where('id', $ept_id)->update($this->employee_position, $employee_position);

		for ($x=0; $x < count($this->input->post('u_educations')); $x++) {	
			$edu_id = $this->input->post('u_education_id')[$x];

			$u_educations = array(
				'level' => $this->input->post('u_educations')[$x],
				'institution' => $this->input->post('u_institutions')[$x],
				'graduate' => date('Y-m-d', strtotime($this->input->post('u_graduates')[$x])),
				'updated_by' => $this->session->userdata('id')
			);

			$this->db->where('id', $edu_id)->update($this->educations, $u_educations);
		}

		for ($y=0; $y < count($this->input->post('educations')); $y++) {			
			$educations = array(
				'employee_id' => $this->uri->segment(4),
				'level' => $this->input->post('educations')[$y],
				'institution' => $this->input->post('institutions')[$y],
				'graduate' => date('Y-m-d', strtotime($this->input->post('graduates')[$y])),
				'created_by' => $this->session->userdata('id'),
				'updated_by' => $this->session->userdata('id')
			);

			$this->db->insert($this->educations, $educations);
		}

		// Work Agreement File Upload
		$file = $_FILES['work_agreement_file'];
		
		if(strlen($file['name'])){
			$f_name = $file['name'];
			$f_type = $file['type'];
			$f_content = file_get_contents($file['tmp_name']);

			$agreement = array(
				'employee_id' 	=> $this->uri->segment(4),
				'name'			=> $f_name,
				'doc_type'		=> $f_type,
				'doc'			=> $f_content,
				'uploaded_by'	=> $this->session->userdata('id')
			);
			// Insert work_agreement_docs
			$this->db->insert($this->agreement, $agreement);
		}


		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Data pegawai gagal diubah');
	        $this->db->trans_rollback();
	        redirect($_SERVER['HTTP_REFERER']);
	    } else {
	    	$this->session->set_flashdata('success', 'Data pegawai berhasil diubah');
	        $this->db->trans_commit();
	    }

		redirect('/hrd/employment/show/'.$this->uri->segment(4));
	}

	public function delete_education()
	{
		try {	
			$this->db->trans_begin();

			if ($this->db->where('id', $this->uri->segment(4))->delete($this->educations)) {
				$this->session->set_flashdata('success', 'Riwayat pendidikan berhasil dihapus');
			} else {
				$db_error = $this->db->error();
				if ($db_error) {
					throw new Exception('Database error! Error Number [' . $db_error['code'] . '] : ' . $db_error['message']);
					return false;
				}
			}

			if ($this->db->trans_status() === FALSE) {
		        $this->db->trans_rollback();
		    } else {		    	
		        $this->db->trans_commit();
		    }
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete()
	{
		try {	
			$this->db->trans_begin();

			if (
			$this->db->where('user_id', $this->uri->segment(5))->delete($this->login) &&
			$this->db->where('employee_id', $this->uri->segment(4))->delete($this->employee_pt) &&
			$this->db->where('id', $this->uri->segment(5))->delete($this->user) &&
			$this->db->where('id', $this->uri->segment(4))->delete($this->employee)
			) {
				$this->session->set_flashdata('success', 'Pegawai berhasil dihapus');
			} else {
				$db_error = $this->db->error();
				if ($db_error) {
					throw new Exception('Database error! Error Number [' . $db_error['code'] . '] : ' . $db_error['message']);
					return false;
				}
			}

			if ($this->db->trans_status() === FALSE) {
		        $this->db->trans_rollback();
		    } else {		    	
		        $this->db->trans_commit();
		    }
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function agreement()
	{
		$data['agreement'] = $this->employments->showAgreement($this->uri->segment(4))->row(); 
		$this->load->view($this->view.'agreement', $data);
	}
}
