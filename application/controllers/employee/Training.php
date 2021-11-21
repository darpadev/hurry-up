<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Training extends MY_Controller
{
	protected $view = 'contents/employee/training/';
	protected $table = 'training';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->employee();
	}

	public function index()
	{
		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Pelatihan';
		$data['sub_title']	= '';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$this->load->view('includes/main', $data);
	}
}
