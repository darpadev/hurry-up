<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Password extends MY_Controller
{
	protected $view = 'contents/';

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['content']	= $this->view.'change_password';
		$data['css']		= '';
		$data['javascript']	= '';
		$data['title']		= 'Ganti Password';
		$data['sub_title']	= '';

		if ($this->session->userdata('role') == 2) {			
			$data['notif']		= $this->general->searchEmployeeAbsence();
		}

		$data['promotion'] = $this->general->countEmployeePromotion();

		$this->load->view('includes/main', $data);
	}

	public function update()
	{
		if ($this->input->post('password') != $this->input->post('confirm')) {
			$this->session->set_flashdata('error', 'Password tidak sama');
		} else {			
			$data = array(
				'password' => md5($this->input->post('password'))
			);

			if ($this->db->where('id', $this->uri->segment(3))->update('users', $data)) {
				$this->session->set_flashdata('success','Password berhasil diubah');
			} else {
				$this->session->set_flashdata('error', $this->upload->display_errors());
			}
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_password()
	{
		$id = $this->uri->segment(3);
		// $username = $this->db->select('username')->from('users')->where('id', $id)->get()->row()->username;

		$employee = $this->db->select('user_id, nip')->from('employee_pt')->where('employee_id', $id)->get()->row();
		
		if ($this->db->where('id', $employee->user_id)->update('users', array('password' => md5($employee->nip)))) {
			$this->session->set_flashdata('success','Kata sandi berhasil disetel ulang');
		} else {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
}
