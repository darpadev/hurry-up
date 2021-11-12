<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Approver extends MY_Controller
{
	protected $view = 'contents/hrd/approver/';
	protected $leave = 'leave_approver';
	protected $overtime = 'overtime_approver';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->hrd();
		$this->load->model('employees');
	}

	public function index()
	{
		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Jabatan';
		$data['sub_title']	= 'Approver';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['leaves']		= $this->employees->getLeaveApprover($this->uri->segment(4));
		$data['overtimes']	= $this->employees->getOvertimeApprover($this->uri->segment(4));

		$this->load->view('includes/main', $data);
	}

	public function store_leave()
	{
		foreach ($this->input->post('approver_cuti') as $value) {			
			$data = array(
				'child_position' => $this->uri->segment(4),
				'parent_position' => $value,
				'created_by' => $this->session->userdata('id'),
				'updated_by' => $this->session->userdata('id')
			);

			if ($this->db->insert($this->leave, $data)) {
				$this->session->set_flashdata('success', 'Approver Cuti berhasil ditambah');
			} else {
				$this->session->set_flashdata('error', 'Approver Cuti gagal ditambah');
			}
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_leave()
	{
		if ($this->db->where('id', $this->uri->segment(4))->delete($this->leave)) {
			$this->session->set_flashdata('success', 'Approver Cuti berhasil dihapus');
		} else {
			$this->session->set_flashdata('error', 'Approver Cuti gagal dihapus');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function store_overtime()
	{		
		$data = array(
			'child_position' => $this->uri->segment(4),
			'parent_position' => $this->input->post('approver_lembur'),
			'created_by' => $this->session->userdata('id'),
			'updated_by' => $this->session->userdata('id')
		);

		if ($this->db->insert($this->overtime, $data)) {
			$this->session->set_flashdata('success', 'Approver lembur berhasil ditambah');
		} else {
			$this->session->set_flashdata('error', 'Approver lembur gagal ditambah');
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_overtime()
	{
		if ($this->db->where('id', $this->uri->segment(4))->delete($this->overtime)) {
			$this->session->set_flashdata('success', 'Approver lembur berhasil dihapus');
		} else {
			$this->session->set_flashdata('error', 'Approver lembur gagal dihapus');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
}
