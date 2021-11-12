<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Overtime extends MY_Controller
{
	protected $view = 'contents/hrd/overtime/';
	protected $table = 'overtimes';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->hrd();
		$this->load->model('presences');
		$this->load->model('overtimes');
		$this->load->model('employees');
	}

	public function overtime()
	{
		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Lembur';
		$data['sub_title']	= 'Daftar Lembur';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$start = NULL;
		$finish = NULL;
		$approval = NULL;
		$employee = NULL;

		if (isset($_GET['approval']) && $_GET['approval'] != 'Semua') {
			$approval = $_GET['approval'];
		}

		if (isset($_GET['employee']) && $_GET['employee'] != 'Semua') {
			$employee = $_GET['employee'];
		}

		if (isset($_GET['date'])) {
			$date = explode(' - ', $_GET['date']);
			$start = date('Y-m-d', strtotime($date[0]));
			if (isset($date[1])) {
				$finish = date('Y-m-d', strtotime($date[1]));
			}
		}

		$result = $this->overtimes->searchOvertimeByFilter($start, $finish, $approval, $employee);
		
		$data['data']	= $result;

		$this->load->view('includes/main', $data);
	}

	public function show()
	{
		$id = $this->uri->segment(4);
		
		$data['content']	= $this->view.'show';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Lembur';
		$data['sub_title']	= 'Lihat Lembur';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data']		= $this->overtimes->showApproverOvertimeByOvertimeId($id);
		$data['overtime']	= $this->overtimes->showEmployeeOvertime($id)->row();
		$data['report']		= $this->overtimes->showReportOvertime($id);

		$this->load->view('includes/main', $data);
	}

	public function incentive()
	{
		$data['content']	= $this->view.'incentive';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Lembur';
		$data['sub_title']	= 'Insentif';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['organizations'] = $this->general->getActiveOrganizations();

		$month = NULL;
		$year = NULL;
		$org_unit = NULL;
		$employee = NULL;

		if (isset($_GET['org_unit']) && $_GET['org_unit'] != 'Semua') {
			$org_unit = $_GET['org_unit'];
		}

		if (isset($_GET['employee']) && $_GET['employee'] != 'Semua') {
			$employee = $_GET['employee'];
		}

		if (isset($_GET['period'])) {
			$period = explode(' ', $_GET['period']);
			$month = date('m', strtotime($period[0]));
			if (isset($period[1])) {
				$year = date('Y', strtotime($period[1]));
			}
		}

		$data['data'] = $this->overtimes->searchIncentiveOvertimeByFilter($month, $year, $org_unit, $employee);
		
		$this->load->view('includes/main', $data);
	}

	public function show_incentive()
	{
		$id = $this->uri->segment(4);
		
		$data['content']	= $this->view.'show_incentive';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Lembur';
		$data['sub_title']	= 'Lihat Insentif';
		$data['notif']		= $this->general->searchEmployeeAbsence();

		$month = NULL;
		$year = NULL;

		if (isset($_GET['period'])) {
			$period = explode(' ', $_GET['period']);
			$month = date('m', strtotime($period[0]));
			if (isset($period[1])) {
				$year = date('Y', strtotime($period[1]));
			}
		}

		$data['data']		= $this->employees->showEmployee($id)->row();
		
		$data['overtime']	= $this->overtimes->showReportOvertimeByEmployee($id, $year, $month);

		$this->load->view('includes/main', $data);
	}
}
