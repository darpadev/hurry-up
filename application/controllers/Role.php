<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Role extends MY_Controller
{
	protected $view = 'contents/';

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['content']	= $this->view.'change_role';
		$data['css']		= '';
		$data['javascript']	= '';
		$data['title']		= 'Ganti Peran';
		$data['sub_title']	= '';

		if ($this->session->userdata('role') == 2) {			
			$data['notif']		= $this->general->countEmployeeAbsence();
		}

		$data['promotion']	= $this->general->countEmployeePromotion();

		$this->load->view('includes/main', $data);
	}

	public function select()
	{
		$this->session->set_userdata('role', $this->input->post('role'));
		$role = $this->session->userdata('role');

		if ($role == 1) {
			redirect('admin/home');
		} elseif ($role == 2){
			redirect('hrd/home');
		} elseif ($role == 3){
			redirect('employee/home');
		} else {
			$this->authorization->guard();
		}
	}
}
