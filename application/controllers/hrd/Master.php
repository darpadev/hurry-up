<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Master extends MY_Controller
{
	protected $view = 'contents/hrd/master/';
	protected $organization = 'organizations';
	protected $position = 'positions';
	protected $employee_position = 'employee_position';
	protected $group = 'user_group';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->hrd();
	}

	public function organization()
	{
		$data['content']	= $this->view.'organization/content';
		$data['css']		= $this->view.'organization/css';
		$data['javascript']	= $this->view.'organization/javascript';
		$data['title']		= 'Master';
		$data['sub_title']	= 'Organisasi';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$org_unit = NULL;
		$type = NULL;
		$is_active = TRUE;

		if (isset($_GET['type']) && $_GET['type'] != 'Semua') {
			$type = $_GET['type'];
		}

		if (isset($_GET['org_unit']) && $_GET['org_unit'] != 'Semua') {
			$org_unit = $_GET['org_unit'];
		}

		if (isset($_GET['is_active']) && $_GET['is_active'] != 'Semua') {
			$is_active = $_GET['is_active'];
		}

		$data['data']		= $this->general->getAllOrganizations($is_active, $org_unit, $type);

		$this->load->view('includes/main', $data);
	}

	public function store_organization()
	{
		$data = array(
			'org_unit' => $this->input->post('org_unit'),
			'parent_id' => $this->input->post('parent_id'),
			'type_id' => $this->input->post('type_id'),
			'code' => $this->input->post('code'),
			'level' => $this->input->post('level'),
			'is_active' => 1,
			'created_by' => $this->session->userdata('id'),
			'updated_by' => $this->session->userdata('id')
		);

		if ($this->db->insert($this->organization, $data)) {
			$this->session->set_flashdata('success', 'Organisasi berhasil ditambah');
		} else {
			$this->session->set_flashdata('error', 'Organisasi gagal ditambah');
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function edit_organization()
	{
		$data['content']	= $this->view.'organization/edit';
		$data['css']		= $this->view.'organization/css';
		$data['javascript']	= $this->view.'organization/javascript';
		$data['title']		= 'Master';
		$data['sub_title']	= 'Organisasi';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['org_unit']	= $this->db->get('organizations');
		$data['data']		= $this->db->select('o.*')->from('organizations as o')->where('id', $this->uri->segment(4))->get()->row();

		$this->load->view('includes/main', $data);
	}

	public function update_organization()
	{
		if ($this->input->post('is_active') == 'TRUE') {
			$is_active = 1;
		} else {
			$is_active = 0;
		}

		$data = array(
			'org_unit' => $this->input->post('org_unit'),
			'parent_id' => $this->input->post('parent_id'),
			'type_id' => $this->input->post('type_id'),
			'code' => $this->input->post('code'),
			'level' => $this->input->post('level'),
			'is_active' => $is_active,
			'updated_by' => $this->session->userdata('id')
		);

		if ($this->db->where('id', $this->uri->segment(4))->update($this->organization, $data)) {
			$this->session->set_flashdata('success', 'Organisasi berhasil diubah');
		} else {
			$this->session->set_flashdata('error', 'Organisasi gagal diubah');
		}

		redirect('/hrd/master/organization');
	}

	public function delete_organization()
	{
		try {
			if ($this->db->where('id', $this->uri->segment(4))->delete($this->organization)) {
				$this->session->set_flashdata('success', 'Organisasi berhasil dihapus');
			} else {
				$db_error = $this->db->error();
				if ($db_error) {
					throw new Exception('Database error! Error Number [' . $db_error['code'] . '] : ' . $db_error['message']);
					return false;
				}
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
		}

		redirect('/hrd/master/organization');
	}

	public function position()
	{
		$data['content']	= $this->view.'position/content';
		$data['css']		= $this->view.'position/css';
		$data['javascript']	= $this->view.'position/javascript';
		$data['title']		= 'Master';
		$data['sub_title']	= 'Jabatan';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['organizations'] = $this->db->select('id, org_unit')->from('organizations')->get();
		$data['positions'] = $this->db->select('id, position')->from('positions')->get();

		$org_unit = NULL;
		$position = NULL;
		$is_active = TRUE;

		if (isset($_GET['position']) && $_GET['position'] != 'Semua') {
			$position = $_GET['position'];
		}

		if (isset($_GET['org_unit']) && $_GET['org_unit'] != 'Semua') {
			$org_unit = $_GET['org_unit'];
		}

		if (isset($_GET['is_active']) && $_GET['is_active'] != 'Semua') {
			$is_active = $_GET['is_active'];
		}

		$data['data']		= $this->general->getAllPositions($org_unit, $position, $is_active);

		$this->load->view('includes/main', $data);
	}

	public function show_position()
	{
		$id = $this->uri->segment(4);

		$data['content']	= $this->view.'position/show';
		$data['css']		= $this->view.'position/css';
		$data['javascript']	= $this->view.'position/javascript';
		$data['title']		= 'Master';
		$data['sub_title']	= 'Jabatan';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data']		= $this->db->select('ept.id, ep.nip, ept.flag, ept.end_date, e.name, ept.start_date')->from('employee_position as ept')
								->join('positions as p', 'p.id = ept.position_id')
								->join('employee_pt as ep', 'ep.employee_id = ept.employee_id')
								->join('employees as e', 'e.id = ep.employee_id')
								->where('ept.position_id', $id)
								->where('ep.status', self::ACTIVE)
								->order_by('ep.nip', 'ASC')
								->get();

		$data['tupoksi']	= $this->db->get_where('tupoksi', array('position_id' => $id));

		$this->load->view('includes/main', $data);
	}

	public function edit_employee_position()
	{
		$id = $this->uri->segment(4);

		$data['content']	= $this->view.'position/edit_employee';
		$data['css']		= $this->view.'position/css';
		$data['javascript']	= $this->view.'position/javascript';
		$data['title']		= 'Master';
		$data['sub_title']	= 'Jabatan';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data']		= $this->db->select('ept.id, ep.nip, ept.flag, ept.end_date, e.name, ept.start_date, p.position, ept.position_id')
								->from('employee_position as ept')
								->join('employee_pt as ep', 'ep.employee_id = ept.employee_id')
								->join('employees as e', 'e.id = ep.employee_id')
								->join('positions as p', 'p.id = ept.position_id')
								->where('ept.id', $id)
								->get()->row();

		$this->load->view('includes/main', $data);
	}

	public function update_employee_position ()
	{
		$id = $this->uri->segment(4);
		$start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
		$end_date = NULL;

		if ($this->input->post('end_date')) {
			$end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
		}

		$data = array(
			'start_date' => $start_date,
			'end_date' => $end_date,
			'flag' => $this->input->post('flag')
		);

		if ($this->db->where('id', $id)->update('employee_position', $data)) {
			$this->session->set_flashdata('success', 'Jabatan pegawai berhasil diubah');
		} else {
			$this->session->set_flashdata('error', 'Jabatan pegawai  gagal diubah');
		}

		redirect('/hrd/master/show_position/'.$this->input->post('position_id'));
	}

	public function store_employee_position ()
	{
		$i = 0;
	    foreach ($this->input->post('employee_id') as $value) {			
			$data = array(
				'employee_id' => $value,
				'position_id' => $this->input->post('position_id')[$i],
				'start_date' => date('Y-m-d', strtotime($this->input->post('start_date')[$i])),
				// 'end_date' => date('Y-m-d', strtotime($this->input->post('end_date')[$i])),
			);

			$i++;

			if ($this->db->insert($this->employee_position, $data)) {
				$this->session->set_flashdata('success', 'Pegawai berhasil ditambah');
			} else {
				$this->session->set_flashdata('error', 'Pegawai gagal ditambah');
			}
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function remove_employee_position () 
	{
		$id = $this->uri->segment(4);

		try {			
			$position = $this->db->get_where($this->employee_position, array('id' => $id))->row();

			if ($this->db->where('id', $id)->delete($this->employee_position)) {
				$this->session->set_flashdata('success', 'Pegawai berhasil dihapus');
			} else {
				$db_error = $this->db->error();
				if ($db_error) {
					throw new Exception('Database error! Error Number [' . $db_error['code'] . '] : ' . $db_error['message']);
					return false;
				}
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
		}

		redirect('hrd/master/show_position/'.$position->position_id);
	}

	public function edit_tupoksi_position()
	{
		$id = $this->uri->segment(4);

		$data['content']	= $this->view.'position/edit_tupoksi';
		$data['css']		= $this->view.'position/css';
		$data['javascript']	= $this->view.'position/javascript';
		$data['title']		= 'Master';
		$data['sub_title']	= 'Jabatan';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data']		= $this->db->get_where('tupoksi', array('id' => $id))->row();
		$data['position']	= $this->db->get_where('positions', array('id' => $data['data']->position_id))->row();

		$this->load->view('includes/main', $data);
	}

	public function update_tupoksi_position ()
	{
		$id = $this->uri->segment(4);
		
		$data = array(
			'tupoksi' => $this->input->post('tupoksi'),
			'weight' => $this->input->post('weight')
		);

		if ($this->db->where('id', $id)->update('tupoksi', $data)) {
			$this->session->set_flashdata('success', 'Tupoksi jabatan berhasil diubah');
		} else {
			$this->session->set_flashdata('error', 'Tupoksi jabatan gagal diubah');
		}

		redirect('/hrd/master/show_position/'.$this->input->post('position_id'));
	}

	public function store_tupoksi_position ()
	{
		$i = 0;
	    foreach ($this->input->post('tupoksi') as $value) {			
			$data = array(
				'position_id' => $this->input->post('position_id'),
				'tupoksi' => $this->input->post('tupoksi')[$i],
				'weight' => $this->input->post('weight')[$i]
			);

			$i++;

			if ($this->db->insert('tupoksi', $data)) {
				$this->session->set_flashdata('success', 'Tupoksi jabatan berhasil ditambah');
			} else {
				$this->session->set_flashdata('error', 'Tupoksi jabatan gagal ditambah');
			}
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function remove_tupoksi_position () 
	{
		$id = $this->uri->segment(4);
		
		try {
			$data = $this->db->get_where('tupoksi', array('id' => $id))->row();

			if ($this->db->where('id', $id)->delete('tupoksi')) {
				$this->session->set_flashdata('success', 'Tupoksi berhasil dihapus');
			} else {
				$db_error = $this->db->error();
				if ($db_error) {
					throw new Exception('Database error! Error Number [' . $db_error['code'] . '] : ' . $db_error['message']);
					return false;
				}
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
		}

		redirect('hrd/master/show_position/'.$data->position_id);
	}

	public function store_position()
	{
		$data = array(
			'org_unit' => $this->input->post('org_unit'),
			'position' => $this->input->post('position'),
			'parent_id' => $this->input->post('parent_id'),
			'level' => $this->input->post('level'),
			'is_active' => TRUE,
			'created_by' => $this->session->userdata('id'),
			'updated_by' => $this->session->userdata('id')
		);

		$this->db->trans_begin();
		if ($this->db->insert($this->position, $data)) {
			$this->session->set_flashdata('success', 'Jabatan '.$this->input->post('position').' berhasil ditambah');
		} else {
			$error = $this->db->error();
			$this->session->set_flashdata('error', $error);
		}

		if ($this->db->trans_status() === FALSE){
	        $this->db->trans_rollback();
	    }
	    else{
	        $this->db->trans_commit();
	    }
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function edit_position()
	{
		$data['content']	= $this->view.'position/edit';
		$data['css']		= $this->view.'position/css';
		$data['javascript']	= $this->view.'position/javascript';
		$data['title']		= 'Master';
		$data['sub_title']	= 'Ubah Jabatan';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['organizations'] = $this->db->select('*')->from('organizations')->get();
		$data['positions'] = $this->db->select('*')->from('positions')->get();
		$data['data']		= $this->db->select('t.*')->from('positions as t')->where('id', $this->uri->segment(4))->get()->row();

		$this->load->view('includes/main', $data);
	}

	public function update_position()
	{
		if ($this->input->post('is_active') == 'TRUE') {
			$is_active = 1;
		} else {
			$is_active = 0;
		}

		$data = array(
			'org_unit' => $this->input->post('org_unit'),
			'level' => $this->input->post('level'),
			'parent_id' => $this->input->post('parent_id'),
			'position' => $this->input->post('position'),
			'is_active' => $is_active,
			'updated_by' => $this->session->userdata('id')
		);

		if ($this->db->where('id', $this->uri->segment(4))->update($this->position, $data)) {
			$this->session->set_flashdata('success', 'Jabatan '.$this->input->post('position').' berhasil diubah');
		} else {
			$this->session->set_flashdata('error', 'Jabatan gagal diubah');
		}

		redirect('/hrd/master/position');
	}

	public function delete_position()
	{
		try {
			if ($this->db->where('id', $this->uri->segment(4))->delete($this->position)) {
				$this->session->set_flashdata('success', 'Jabatan berhasil dihapus');
			} else {
				$db_error = $this->db->error();
				if ($db_error) {
					throw new Exception('Database error! Error Number [' . $db_error['code'] . '] : ' . $db_error['message']);
					return false;
				}
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
		}

		redirect('/hrd/master/position');
	}

	public function group()
	{
		$data['content']	= $this->view.'group/content';
		$data['css']		= $this->view.'group/css';
		$data['javascript']	= $this->view.'group/javascript';
		$data['title']		= 'Master';
		$data['sub_title']	= 'Group';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data'] 		= $this->db->select('*')->from($this->group)->get();

		$this->load->view('includes/main', $data);
	}

	public function store_group()
	{
		$data = array(
			'due_time' => $this->input->post('due_time'),
			'name' => $this->input->post('name')
		);

		if ($this->db->insert($this->group, $data)) {
			$this->session->set_flashdata('success', 'Grup berhasil ditambah');
		} else {
			$this->session->set_flashdata('error', 'Grup gagal ditambah');
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function edit_group()
	{
		$data['content']	= $this->view.'group/edit';
		$data['css']		= $this->view.'group/css';
		$data['javascript']	= $this->view.'group/javascript';
		$data['title']		= 'Master';
		$data['sub_title']	= 'Ubah Group';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data'] 		= $this->db->select('*')->from($this->group)->where('id', $this->uri->segment(4))->get()->row();

		$this->load->view('includes/main', $data);
	}

	public function update_group()
	{
		$data = array(
			'due_time' => $this->input->post('due_time'),
			'name' => $this->input->post('name')
		);

		if ($this->db->where('id', $this->uri->segment(4))->update($this->group, $data)) {
			$this->session->set_flashdata('success', 'Grup berhasil diubah');
		} else {
			$this->session->set_flashdata('error', 'Grup gagal diubah');
		}

		redirect('/hrd/master/group');
	}

	public function delete_group()
	{
		try {
			if ($this->db->where('id', $this->uri->segment(4))->delete($this->group)) {
				$this->session->set_flashdata('success', 'Grup berhasil dihapus');
			} else {
				$db_error = $this->db->error();
				if ($db_error) {
					throw new Exception('Database error! Error Number [' . $db_error['code'] . '] : ' . $db_error['message']);
					return false;
				}
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
		}

		redirect('/hrd/master/group');
	}
}
