<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Leave extends MY_Controller
{
	protected $view = 'contents/employee/leave/';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->employee();
		$this->load->model('employees');
		$this->load->model('leaves');
	}

	public function index()
	{
		$id = $this->session->userdata('employee');

		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Izin Kerja';
		$data['sub_title']	= '';
		$data['message']	= '';
		$data['param_leave']= $this->db->select('join_date')
		->from('employee_pt')
		->where('employee_id', $id)
		->get()->row();

		$group = NULL;
		$start = NULL;
		$finish = NULL;
		$approval = NULL;
		$calendar = array();

		if (isset($_GET['approval']) && $_GET['approval'] != 'Semua') {
			$approval = $_GET['approval'];
		}

		if (isset($_GET['date'])) {
			$date = explode(' - ', $_GET['date']);
			$start = date('Y-m-d', strtotime($date[0]));
			if (isset($date[1])) {
				$finish = date('Y-m-d', strtotime($date[1]));
			}
		}

		$result = $this->leaves->searchLeaveByFilter($group, $start, $finish, $approval, $id);

		if (isset($_GET['date'])) {
			foreach ($result->result() as $cal) {
				if ($cal->status != 'Rejected' && $cal->status != 'Cancelled') {
					array_push($calendar, array(
						'title' => $cal->type,
						'start' => $cal->start,
						'end' => date('Y-m-d', strtotime($cal->finish.'+1 day')),
						'url' => base_url().'employee/leave/show/'.$cal->id
					));
				}
			}
		}

		$data['data']	= $result;
		$data['calendar'] = $calendar;

		$this->load->view('includes/main', $data);
	}

	public function show()
	{
		$id = $this->uri->segment(4);

		$data['content']	= $this->view.'show';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Izin Kerja';
		$data['sub_title']	= 'Lihat Izin Kerja';
		$data['message']	= '';
		$data['data']		= $this->leaves->showEmployeeLeaveByLeaveId($id);
		$data['leave']		= $this->leaves->showEmployeeLeave($id)->row();
		
		$this->load->view('includes/main', $data);
	}

	public function edit()
	{		
		$id = $this->uri->segment(4);

		$data['content']	= $this->view.'show';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Izin Kerja';
		$data['sub_title']	= 'Ubah';
		$data['message']	= '';
		$data['data']		= $this->leaves->showEmployeeLeaveByLeaveId($id);
		$data['leave']		= $this->leaves->showEmployeeLeave($id)->row();
		
		$this->load->view('includes/main', $data);
	}

	public function update()
	{
		redirect('employee/leave/show/'.$id);
	}

	public function store()
	{
		$employee_id = $this->session->userdata('employee');
		$positions = $this->session->userdata('position');

		$date = explode(' - ', $this->input->post('date'));
		$start = date('Y-m-d', strtotime($date[0]));
		if (isset($date[1])) {
			$finish = date('Y-m-d', strtotime($date[1]));
		}

		$this->db->trans_begin();

		$data = array(
			'employee_id' => $employee_id,
			'start' => $start,
			'finish' => $finish,
			'description' => $this->input->post('description'),
			'type' => $this->input->post('type')
		);

		$this->db->insert('leaves', $data);
		$leave_id = $this->db->insert_id();

		$approver = array();
		$level_approver = 2;
		$level_type = array(1,2,3,4);

		foreach ($positions as $position) {
			$child = $this->db->select('parent_id')->from('positions')->where('id', $position)->get()->row();
			$parents = $this->general->getParentPositions($child->parent_id);

			foreach ($parents as $par) {
				$approver[] = $par;
			}
		}

		$constraint = 0;
		foreach (array_unique($approver) as $value) {
			$check_level = $this->db->select('level')->from('positions')->where('id', $value)->where_in('level', $level_type)->get()->row();

			if ($check_level) {
				if ($constraint < $level_approver) {
					$data_approver = array(
						'leave_id' => $leave_id,
						'approver_id' => $value,
					);

					$this->db->insert('approval_leaves', $data_approver);
				}

				$constraint++;				
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Izin kerja gagal ditambah');
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Izin kerja berhasil ditambah');
	        $this->db->trans_commit();
	    }

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function cancel()
	{
		$id = $this->uri->segment(4);
		$employee_id = $this->session->userdata('employee');

		$this->db->trans_begin();

		$this->db->where('id', $id)->update('leaves', array('approval' => self::CANCELLED, 'updated_by' => $employee_id));
		$this->db->where(array('leave_id' => $id, 'flag !=' => self::APPROVED))->update('approval_leaves', array('flag' => self::CANCELLED));

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Izin kerja gagal dibatalkan');
	        $this->db->trans_rollback();
		} else {
			$this->session->set_flashdata('success', 'Izin kerja berhasil dibatalkan');
	        $this->db->trans_commit();
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
}
