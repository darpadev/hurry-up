<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Holiday extends MY_Controller
{
	protected $view = 'contents/hrd/holiday/';
	protected $table = 'holiday';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->hrd();
	}

	public function index()
	{
		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Hari Libur';
		$data['sub_title']	= '';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data']		= $this->db->select('t.id, t.day_off, t.description, e.name as created')->from('holiday as t')->join('users as u', 'u.id = t.updated_by')->join('employee_pt as ep', 'ep.user_id = u.id')->join('employees as e', 'ep.employee_id = e.id')->get();

		$this->load->view('includes/main', $data);
	}

	public function store()
	{
		$data = array(
			'day_off' => date('Y-m-d', strtotime($this->input->post('day_off'))),
			'description' => $this->input->post('description'),
			'created_by' => $this->session->userdata('id'),
			'updated_by' => $this->session->userdata('id')
		);

		if ($this->db->insert($this->table, $data)) {
			$this->session->set_flashdata('success', 'Hari libur berhasil ditambah');
		} else {
			$this->session->set_flashdata('error', 'Hari libur gagal ditambah');
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function edit()
	{
		$data['content']	= $this->view.'edit';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Hari Libur';
		$data['sub_title']	= 'Ubah';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data']		= $this->db->select('t.id, t.day_off, t.description')->from('holiday as t')->where('id', $this->uri->segment(4))->get()->row();

		$this->load->view('includes/main', $data);
	}

	public function update()
	{
		$data = array(
			'day_off' => date('Y-m-d', strtotime($this->input->post('day_off'))),
			'description' => $this->input->post('description'),
			'updated_by' => $this->session->userdata('id')
		);

		if ($this->db->where('id', $this->uri->segment(4))->update($this->table, $data)) {
			$this->session->set_flashdata('success', 'Hari libur berhasil diubah');
		} else {
			$this->session->set_flashdata('error', 'Hari libur gagal diubah');
		}

		redirect('/hrd/holiday');
	}

	public function delete()
	{
		if ($this->db->where('id', $this->uri->segment(4))->delete($this->table)) {
			$this->session->set_flashdata('success', 'Hari libur berhasil dihapus');
		} else {
			$this->session->set_flashdata('error', 'Hari libur gagal dihapus');
		}

		redirect('/hrd/holiday');
	}
}
