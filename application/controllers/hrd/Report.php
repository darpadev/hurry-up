<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Report extends MY_Controller
{
	protected $view = 'contents/hrd/report/';
	protected $table = 'holiday';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->hrd();
		$this->load->model('reports');
		$this->load->model('overtimes');
		$this->load->model('leaves');
		$this->load->model('presences');
	}

	public function overtime()
	{
		$data['content']	= $this->view.'overtime';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Laporan';
		$data['sub_title']	= 'Lembur';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$start = NULL;
		$finish = NULL;
		$approval = NULL;
		$type = NULL;
		$employee = NULL;
		$org_unit = NULL;

		if (isset($_GET['approval']) && $_GET['approval'] != 'Semua') {
			$approval = $_GET['approval'];
		}

		if (isset($_GET['org_unit']) && $_GET['org_unit'] != 'Semua') {
			$org_unit = $_GET['org_unit'];
		}

		if (isset($_GET['type']) && $_GET['type'] != 'Semua') {
			$type = $_GET['type'];
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

		$employees = $this->reports->getAllEmployeePt(1, $employee);
		$this->db->select('*');
		$this->db->from('organizations');

		if ($org_unit) {
			$this->db->where('id', $org_unit);
		}
		$organizations = $this->db->get();

		// chart laporan anggota
		$emp_report = array();
		$org_report = array();
		$sum_emp_report = array();
		$sum_org_report = array();

		foreach ($employees->result() as $emp) {
			$emp_duration = 0;

			$query = $this->overtimes->searchEmployeeChart($emp->employee_id, $start, $finish, array($org_unit));
			foreach ($query->result() as $dur) {
				$emp_duration = $emp_duration + (int) substr($dur->actual_duration, 0, 2);
			}

			if ($emp_duration > 0) {
				$emp_report[] = $emp->name;
				$sum_emp_report[] = $emp_duration;
			}

		}

		// chart laporan organisasi
		foreach ($organizations->result() as $org) {
			$org_duration = 0;

			$query = $this->overtimes->searchOrganizationChart($start, $finish, $org->id);

			foreach ($query->result() as $dur) {
				$org_duration = $org_duration + (int) substr($dur->actual_duration, 0, 2);
			}

			if ($org_duration > 0) {
				$org_report[] = $org->org_unit;
				$sum_org_report[] = $org_duration;
			}
		}

		$data['emp_report'] = $emp_report;
		$data['sum_emp_report'] = $sum_emp_report;
		$data['org_report'] = $org_report;
		$data['sum_org_report'] = $sum_org_report;

		$data['organizations'] = $this->db->select('id, org_unit')->from('organizations')->get();
		$data['employee'] 	= $this->reports->getAllEmployeePt(1);

		$this->load->view('includes/main', $data);
	}

	public function ajaxAnnualEmpOvertimeReport()
	{
		$returnValue = array();

		$employees = $this->reports->getAllEmployeePt(1);

		$year = $_GET['year'];
		$annual_emp_report = array();
		$annual_sum_emp_report = array();

		$init = 0;
		foreach ($employees->result() as $emp) {
			$annual_emp_report['label'][] = $emp->name;

			for ($i=1; $i <= 12; $i++) {
				$annual_emp_duration = 0;
				$query = $this->overtimes->searchAnnualEmployeeChart($emp->employee_id, $year, $i);

				foreach ($query->result() as $dur) {
					$annual_emp_duration = $annual_emp_duration + (int) substr($dur->actual_duration, 0, 2);
				}

				$annual_sum_emp_report[$init][$i] = $annual_emp_duration;
			}

			$init++;
		}

		$returnValue[] = $annual_emp_report;
		$returnValue[] = $annual_sum_emp_report;

		echo json_encode($returnValue);
	}

	public function ajaxAnnualOrgOvertimeReport()
	{
		$returnValue = array();

		$getOrganization = $this->db->select('org_unit')->from('positions')->get();
		$cug = array();
		foreach ($getOrganization->result() as $value) {
			$cug[] = $value->org_unit;
		}

		$organizations = $this->general->getSubordinateOrganizations($cug);

		$year = $_GET['year'];
		$annual_org_report = array();
		$annual_sum_org_report = array();

		$init = 0;
		foreach ($organizations->result() as $org) {
			$annual_org_report['label'][] = $org->org_unit;

			for ($i=1; $i <= 12; $i++) {
				$annual_org_duration = 0;
				$query = $this->overtimes->searchAnnualOrganizationChart($org->id, $year, $i);

				foreach ($query->result() as $dur) {
					$annual_org_duration = $annual_org_duration + (int) substr($dur->actual_duration, 0, 2);
				}

				$annual_sum_org_report[$init][$i] = $annual_org_duration;
			}

			$init++;
		}

		$returnValue[] = $annual_org_report;
		$returnValue[] = $annual_sum_org_report;

		echo json_encode($returnValue);
	}

	public function leave()
	{
		$data['content']	= $this->view.'leave';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Laporan';
		$data['sub_title']	= 'Izin Kerja';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$this->load->view('includes/main', $data);
	}

	public function employee()
	{
		$data['content']	= $this->view.'employee';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Laporan';
		$data['sub_title']	= 'Pegawai';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$this->load->view('includes/main', $data);
	}

	public function presence()
	{
		$data['content']	= $this->view.'presence';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Laporan';
		$data['sub_title']	= 'Kehadiran';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$this->load->view('includes/main', $data);
	}
}
