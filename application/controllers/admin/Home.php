<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Home extends MY_Controller
{
	protected $view = 'contents/admin/';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->admin();
	}

	public function index()
	{
		$data['content']	= $this->view.'dashboard';
		$data['css']		= '';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Beranda';
		$data['sub_title']	= '';

		$this->load->view('includes/main', $data);
	}
}
