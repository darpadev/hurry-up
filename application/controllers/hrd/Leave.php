<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Leave extends MY_Controller
{
	protected $view = 'contents/hrd/leave/';
	protected $table = 'leaves';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->hrd();
		$this->load->model('leaves');
		$this->load->model('presences');
	}

	public function index()
	{
		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Izin Kerja';
		$data['sub_title']	= '';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

			$group = NULL;
			$start = NULL;
			$finish = NULL;
			$approval = NULL;
			$employee = NULL;

			if (isset($_GET['group']) && $_GET['group'] != 'Semua') {
				$group = $_GET['group'];
			}

			if (isset($_GET['employee']) && $_GET['employee'] != 'Semua') {
				$employee = $_GET['employee'];
			}

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

			$result = $this->leaves->searchLeaveByFilter($group, $start, $finish, $approval, $employee);

			$data['data']	= $result;

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
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data']		= $this->leaves->showEmployeeLeaveByLeaveId($id);
		$data['leave']		= $this->leaves->showEmployeeLeave($id)->row();

		$this->load->view('includes/main', $data);
	}
}
