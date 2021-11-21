<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Home extends MY_Controller
{
	protected $view = 'contents/hrd/';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->hrd();
	}

	public function index()
	{
		$data['content']	= $this->view.'dashboard';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Beranda';
		$data['sub_title']	= '';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['company']	= $this->db->select('*')->from('company')->get()->row();
		$data['employees']	= $this->db->select('e.name, t.join_date')->from('employee_pt as t')->join('employees as e', 'e.id = t.employee_id')->limit(8)->order_by('t.join_date', 'DESC')->get();

		$data['functional'] = $this->general->getFunctionalPosition();
		// echo "<pre>";var_dump($data['functional']->result());echo "</pre>";die();
		$data['lecture_education'] = $this->general->getLatestEducationLecture();

		$this->load->view('includes/main', $data);
	}
}
