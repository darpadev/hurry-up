<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Biodata extends MY_Controller
{
	protected $view = 'contents/employee/biodata/';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->employee();
		$this->load->model('employees');
	}

	public function index()
	{
		$id = $this->session->userdata('employee');

		$data['content']		= $this->view.'content';
		$data['css']			= $this->view.'css';
		$data['javascript']		= $this->view.'javascript';
		$data['title']			= 'Biodata';
		$data['sub_title']		= '';
		$data['data']			= $this->employees->showEmployee($id)->row();
		$data['message']		= '';
		$data['notif']			= $this->general->countEmployeeAbsence();
		$data['promotion']		= $this->general->countEmployeePromotion();
		$data['organizations']	= $this->employees->showEmployeeOrgUnit($id);
		$data['educations']		= $this->employees->showEmployeeEducation($id);

		$mulai 		= $data['data']->join_date;
		$selesai 	= date('Y-m-d', strtotime(date('Y-m-d', strtotime($mulai)). " + 1 year"));
		$selesai 	= date('Y-m-d', strtotime(date('Y-m-d', strtotime($selesai)). " - 1 day"));
		$diff 		= abs(strtotime(date('Y-m-d')) - strtotime($mulai));
		$years 		= floor($diff / (365*60*60*24));
		$periode 	= array();

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

		$data['leaves']		= $this->employees->showEmployeeLeave($id, $start, $end);
		
		$count_leave = $this->employees->showEmployeeLeave($id, $start, $end, 2);
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

		$data['count_leave'] = $sum;
		$data['position_history'] = $this->employees->getEmployeePositionHistory($id);

		$this->load->view('includes/main', $data);
	}

	public function edit()
	{
		$data['content']	= $this->view.'edit';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Biodata';
		$data['sub_title']	= 'Ubah';
		$data['message']	= '';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data']		= $this->employees->showEmployee($this->session->userdata('employee'))->row();
		$data['provinces']	= $this->db->get('provinces');
		$data['cities']		= $this->db->get('cities');
		$data['districts']	= $this->db->get('districts');

		$this->load->view('includes/main', $data);
	}

	public function update()
	{
		$id = $this->db->select('t.id')->from('employees as t')->join('employee_pt as ep', 'ep.employee_id = t.id')->where('ep.employee_id', $this->session->userdata('employee'))->get()->row()->id;

		$this->db->trans_begin();

		if ($this->input->post('province_id') == '') {
			$province = NULL;
		} else {
			$province = $this->input->post('province_id');			
		}

		$employees = array(			
			'religion' => $this->input->post('religion'),
			'sex' => $this->input->post('sex'),
			'phone' => $this->input->post('phone'),
			'birthday' => date('Y-m-d', strtotime($this->input->post('birthday'))),
			'province_id' => $province,
			'city_id' => $this->input->post('city_id'),
			'district_id' => $this->input->post('district_id'),
			'postal_code' => $this->input->post('postal_code'),
			'address' => $this->input->post('address'),
			'npwp' => $this->input->post('npwp'),
			'sid' => $this->input->post('sid'),
			'email' => $this->input->post('email'),
			'marital_status' => $this->input->post('marital_status'),
			'updated_by' => $this->session->userdata('id')
		);
		
		$this->db->where('id', $id)->update('employees', $employees);

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Biodata gagal diubah');
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Biodata berhasil diubah');
	        $this->db->trans_commit();
	    }

		redirect('/employee/biodata');
	}
}
