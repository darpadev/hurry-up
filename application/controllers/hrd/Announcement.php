<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Announcement extends MY_Controller
{
	protected $view = 'contents/hrd/announcement/';
	protected $table = 'announcements';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->hrd();
		$this->load->model('presences');
	}

	public function index()
	{
		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Pengumuman';
		$data['sub_title']	= '';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion'] 	= $this->general->countEmployeePromotion();

		$this->load->view('includes/main', $data);
	}
}
