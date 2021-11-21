<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Payroll extends MY_Controller
{
	protected $view = 'contents/hrd/payroll/';
	protected $table = 'payroll';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->hrd();
		$this->load->model('employees');
		$this->load->model('payrolls');
	}

	public function index()
	{
		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penggajian';
		$data['sub_title']	= '';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$employee = NULL;
		$position = NULL;
		$status = NULL;
		$org_unit = NULL;
		$group = NULL;
		$work_agreement_status = NULL;

		if (isset($_GET['group']) && $_GET['group'] != 'Semua') {
			$group = $_GET['group'];
		}

		if (isset($_GET['employee']) && $_GET['employee'] != 'Semua') {
			$employee = $_GET['employee'];
		}

		if (isset($_GET['position']) && $_GET['position'] != 'Semua') {
			$position = $_GET['position'];
		}

		if (isset($_GET['status']) && $_GET['status'] != 'Semua') {
			$status = $_GET['status'];
		}

		if (isset($_GET['org_unit']) && $_GET['org_unit'] != 'Semua') {
			$org_unit = $_GET['org_unit'];
		}

		if (isset($_GET['work_agreement_status']) && $_GET['work_agreement_status'] != 'Semua') {
			$work_agreement_status = $_GET['work_agreement_status'];
		}

		$data['employee'] = $this->employees->getAllEmployeeActive();
		$data['data']		= $this->payrolls->searchEmployeeSalary($employee, $position, $status, $group, $work_agreement_status, $org_unit);

		$this->load->view('includes/main', $data);
	}

	public function show()
	{
		$id = $this->uri->segment(4);

		$data['content']	= $this->view.'show';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penggajian';
		$data['sub_title']	= 'Detail';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['employees']	= $this->employees->showEmployee($id)->row();
		$data['data']		= '';

		$this->load->view('includes/main', $data);
	}
}
