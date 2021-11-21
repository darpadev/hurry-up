<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Team extends MY_Controller
{
	protected $view = 'contents/employee/team/';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->employee();
		$this->load->model('employees');
		$this->load->model('overtimes');
		$this->load->model('leaves');
		$this->load->model('performances');
		$this->load->model('timesheets');
	}

	public function index()
	{
		$id = $this->session->userdata('employee');
		$positions = $this->session->userdata('position');

		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Anggota Tim';
		$data['sub_title']	= '';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$child = $this->general->getChildrenPositions($positions);

		$data['employee'] 	= $this->general->getSubordinates($child);
		$data['positions'] 	= $this->db->select('*')->from('positions')->where_in('id', $child)->get();

		$employee = NULL;

		if (isset($_GET['employee']) && $_GET['employee'] != 'Semua') {
			$employee = $_GET['employee'];
		}

		if (isset($_GET['position']) && $_GET['position'] != 'Semua') {
			$child = array($_GET['position']);
		}

		$data['data']		= $this->general->getSubordinates($child, NULL, $employee);
		$this->load->view('includes/main', $data);
	}

	public function show()
	{	
		$id = $this->uri->segment(4);
		$positions = $this->session->userdata('position');
		$check_emp = array();

		$data['content']	= $this->view.'show';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Anggota Tim';
		$data['sub_title']	= 'Detail Anggota';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		// validation team member
		$child = $this->general->getChildrenPositions($positions);
		$employee_position = $this->db->select('employee_id')->from('employee_position')->where('flag', TRUE)->where_in('position_id', $child)->get()->result();
		foreach ($employee_position as $check) {
			$check_emp[] = $check->employee_id;
		}

		if (!in_array($id, $check_emp)) {			
			$this->session->set_flashdata('error', 'Data anggota tim tidak ditemukan');
			redirect('employee/team');
		}

		$data['data']		= $this->employees->showEmployee($id)->row();
		$data['organizations']	= $this->employees->showEmployeeOrgUnit($id);
		// echo '<pre>';var_dump($data['data']->result());echo '</pre>';die();
		$this->load->view('includes/main', $data);
	}

	public function overtime()
	{
		$id = $this->session->userdata('employee');
		$position = $this->session->userdata('position');
		$level = $this->session->userdata('level');

		$data['content']	= $this->view.'overtime';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Anggota Tim';
		$data['sub_title']	= 'Lembur';
		$data['message']	= '';
		$data['level']		= $level;

		$child = $this->general->getChildrenPositions($position);

		$level_subordinate = array();
		$level_subordinate[] = 6;

		$data['employee'] 	= $this->general->getSubordinates($child, $level_subordinate);

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

		$getOrganization = $this->db->select('org_unit')->from('positions')->where_in('id', $position)->get();

		$cug = array();
		foreach ($getOrganization->result() as $value) {
			$cug[] = $value->org_unit;
		}

		$organizations = $this->general->getSubordinateOrganizations($cug);

		// chart laporan anggota
		$report = $this->general->getSubordinates($child, $level_subordinate, $employee, $org_unit);
		$emp_report = array();
		$org_report = array();
		$sum_emp_report = array();
		$sum_org_report = array();

		foreach ($report->result() as $rep) {
			$emp_duration = 0;

			$query = $this->overtimes->searchEmployeeChart($rep->employee_id, $start, $finish, array($org_unit));
			foreach ($query->result() as $dur) {
				$emp_duration = $emp_duration + (int) substr($dur->actual_duration, 0, 2);
			}

			if ($emp_duration > 0) {
				$emp_report[] = $rep->name;
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

		// char laporan tahunan anggota
		// $year = date('Y');
		// $annual_emp_report = array();
		// $annual_sum_emp_report = array();

		// $init = 0;
		// foreach ($report->result() as $rep) {
		// 	$annual_emp_report['label'][] = $rep->name;

		// 	for ($i=1; $i <= 12; $i++) {
		// 		$annual_emp_duration = 0;
		// 		$query = $this->overtimes->searchAnnualEmployeeChart($rep->employee_id, $year, $i);

		// 		foreach ($query->result() as $dur) {
		// 			$annual_emp_duration = $annual_emp_duration + (int) substr($dur->actual_duration, 0, 2);
		// 		}

		// 		$annual_sum_emp_report[$init][$i] = $annual_emp_duration;
		// 	}

		// 	$init++;
		// }

		// echo '<pre>';var_dump($annual_emp_report);echo '</pre>';
		// echo '<pre>';var_dump($annual_sum_emp_report);echo '</pre>';
		// die();

		$data['emp_report'] = $emp_report;
		$data['sum_emp_report'] = $sum_emp_report;
		$data['org_report'] = $org_report;
		$data['sum_org_report'] = $sum_org_report;

		$data['organizations'] = $organizations;

		$data['data'] = $this->overtimes->searchOvertimeSubodinates($approval, $start, $finish, $position, $type, $employee, $org_unit);

		$this->load->view('includes/main', $data);
	}

	public function ajaxAnnualEmpOvertimeReport()
	{
		$returnValue = array();

		$position = $this->session->userdata('position');
		$child = $this->general->getChildrenPositions($position);

		$level_subordinate = array();
		$level_subordinate[] = 6;

		$report = $this->general->getSubordinates($child, $level_subordinate);

		$year = $_GET['year'];
		$annual_emp_report = array();
		$annual_sum_emp_report = array();

		$init = 0;
		foreach ($report->result() as $rep) {
			$annual_emp_report['label'][] = $rep->name;

			for ($i=1; $i <= 12; $i++) {
				$annual_emp_duration = 0;
				$query = $this->overtimes->searchAnnualEmployeeChart($rep->employee_id, $year, $i);

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
		$position = $this->session->userdata('position');

		$getOrganization = $this->db->select('org_unit')->from('positions')->where_in('id', $position)->get();
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

	public function show_overtime()
	{
		$id = $this->uri->segment(4);
		$my_positions = $this->session->userdata('position');

		$child = $this->general->getChildrenPositions($my_positions);

		$data['employee'] 	= $this->general->getSubordinates($child);

		$data['content']	= $this->view.'show_overtime';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Anggota Tim';
		$data['sub_title']	= 'Detail Lembur';
		$data['message']	= '';
		$data['data']		= $this->overtimes->showApproverOvertimeByOvertimeId($id);
		$data['overtime']	= $this->overtimes->showEmployeeOvertime($id)->row();
		$data['report']		= $this->overtimes->showReportOvertime($id);

		// check subordinates positions
		$employee_positions = $this->db->select('position_id')->from('employee_position')->where(array('employee_id' => $data['overtime']->employee_id, 'flag' => TRUE))->get()->result();
		$emp_pos = array();
		foreach ($employee_positions as $emppos) {
			$emp_pos[] = $emppos->position_id;
		}
		
		if (
			!isset($data['overtime']) || 
			!array_intersect($emp_pos, $child)
		) {
			$this->session->set_flashdata('error', 'Data anggota tim tidak ditemukan');
			redirect('employee/team/overtime');
		}

		$this->load->view('includes/main', $data);
	}

	public function edit_overtime()
	{
		$id = $this->uri->segment(4);

		$my_positions = $this->session->userdata('position');
		$child = $this->general->getChildrenPositions($my_positions);

		$data['employee'] 	= $this->general->getSubordinates($child);

		$data['content']	= $this->view.'edit_overtime';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Anggota Tim';
		$data['sub_title']	= 'Edit Lembur';
		$data['message']	= '';
		$data['data']		= $this->overtimes->showApproverOvertimeByOvertimeId($id);
		$data['overtime']	= $this->overtimes->showEmployeeOvertime($id)->row();
		$data['report']		= $this->overtimes->showReportOvertime($id);

		// validation status
		$report = $this->overtimes->showReportOvertime($id);
		if ($report->row() || date('Y-m-d') == $data['overtime']->overtime_date || date('Y-m-d') > $data['overtime']->overtime_date) {
			$this->session->set_flashdata('error', 'Data anggota tim tidak dapat diubah');
			redirect('employee/team/show_overtime/'.$id);
		}

		// check subordinates positions
		$employee_positions = $this->db->select('position_id')->from('employee_position')->where(array('employee_id' => $data['overtime']->employee_id, 'flag' => TRUE))->get()->result();
		$emp_pos = array();
		foreach ($employee_positions as $emppos) {
			$emp_pos[] = $emppos->position_id;
		}
		
		if (
			!isset($data['overtime']) || 
			!array_intersect($emp_pos, $child)
		) {
			$this->session->set_flashdata('error', 'Data anggota tim tidak ditemukan');
			redirect('employee/team/overtime');
		}

		$this->load->view('includes/main', $data);
	}

	public function update_overtime()
	{		
		$id = $this->uri->segment(4);
		$overtime_date = date('Y-m-d', strtotime($this->input->post('overtime_date')));

		$day = strtolower(date('l', strtotime($this->input->post('overtime_date'))));
		if ($day == 'saturday' || $day == 'sunday') 
		{
			$day_type = self::WEEKEND;
		} else {
			$holiday = $this->db->get_where('holiday', array('day_off' => $overtime_date))->row();

			if ($holiday) {				
				$day_type = self::WEEKEND;
			} else {
				$day_type = self::WEEKDAY;
			}
		}

		$this->db->trans_begin();

		// validation status
		$report = $this->overtimes->showReportOvertime($id);
		if ($report->row() || date('Y-m-d') == $overtime_date || date('Y-m-d') > $overtime_date) {
			$this->session->set_flashdata('error', 'Data anggota tim tidak dapat diubah');
			redirect('employee/team/show_overtime/'.$id);
		}

		$data = array(
			'overtime_date' => $overtime_date,
			'start' => $this->input->post('start'),
			'finish' => $this->input->post('finish'),
			'description' => $this->input->post('description'),
			'day_type' => $day_type,
			'approval' => self::SUBMITTED,
			'updated_by' => $this->session->userdata('id')
		);

		$this->db->where('id', $id)->update('overtimes', $data);

		$this->db->where('overtime_id', $id)->update('approval_overtimes', array('flag' => self::WAITING_FOR_APPROVAL));

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Jadwal lembur anggota tim gagal diubah');
	        $this->db->trans_rollback();
	    } else {
			$this->session->set_flashdata('success', 'Jadwal lembur anggota tim berhasil diubah');
	        $this->db->trans_commit();
	    }

		redirect('/employee/team/show_overtime/'.$id);
	}

	public function leave()
	{
		$id = $this->session->userdata('employee');
		$position = $this->session->userdata('position');
		$level = $this->session->userdata('level');

		$data['content']	= $this->view.'leave';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Anggota Tim';
		$data['sub_title']	= 'Izin Kerja';
		$data['message']	= '';
		$data['level']		= $level;

		$child = $this->general->getChildrenPositions($position);

		$data['employee'] 	= $this->general->getSubordinates($child);

		$start = NULL;
		$finish = NULL;
		$approval = NULL;
		$type = NULL;
		$employee = NULL;

		if (isset($_GET['approval']) && $_GET['approval'] != 'Semua') {
			$approval = $_GET['approval'];
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

		$data['data']		= $this->leaves->searchLeaveSubodinates($approval, $start, $finish, $position, $type, $employee);

		$this->load->view('includes/main', $data);
	}

	public function show_leave()
	{
		$id = $this->uri->segment(4);
		$my_positions = $this->session->userdata('position');

		$child = $this->general->getChildrenPositions($my_positions);

		$data['employee'] 	= $this->general->getSubordinates($child);

		$data['content']	= $this->view.'show_leave';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Anggota Tim';
		$data['sub_title']	= 'Detail Izin Kerja';
		$data['message']	= '';
		$data['data']		= $this->leaves->showEmployeeLeaveByLeaveId($id);
		$data['leave']		= $this->leaves->showEmployeeLeave($id)->row();

		// check subordinates positions
		$employee_positions = $this->db->select('position_id')->from('employee_position')->where(array('employee_id' => $data['leave']->employee_id, 'flag' => TRUE))->get()->result();
		$emp_pos = array();
		foreach ($employee_positions as $emppos) {
			$emp_pos[] = $emppos->position_id;
		}
		
		if (
			!isset($data['leave']) || 
			!array_intersect($emp_pos, $child)
		) {
			$this->session->set_flashdata('error', 'Data anggota tim tidak ditemukan');
			redirect('employee/team/leave');
		}

		$this->load->view('includes/main', $data);
	}

	public function performance()
	{
		$id = $this->session->userdata('employee');
		$position = $this->session->userdata('position');
		$level = $this->session->userdata('level');

		$data['content']	= $this->view.'performance';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Anggota Tim';
		$data['sub_title']	= 'Penilaian Kinerja';
		$data['message']	= '';
		$data['level']		= $level;

		$child = $this->general->getChildrenPositions($position);

		$employee = NULL;
		$org_unit = NULL;
		$year = NULL;
		$period = NULL;

		if (isset($_GET['period']) && $_GET['period'] != 'Semua') {
			$period = $_GET['period'];
		}

		if (isset($_GET['year']) && $_GET['year'] != 'Semua') {
			$year = $_GET['year'];
		}

		if (isset($_GET['employee']) && $_GET['employee'] != 'Semua') {
			$employee = $_GET['employee'];
		}

		if (isset($_GET['org_unit']) && $_GET['org_unit'] != 'Semua') {
			$org_unit = $_GET['org_unit'];
		}

		$getOrganization = $this->db->select('org_unit')->from('positions')->where_in('id', $position)->get();

		$cug = array();
		foreach ($getOrganization->result() as $value) {
			$cug[] = $value->org_unit;
		}

		$data['employee'] 	= $this->general->getSubordinates($child);
		$data['organizations'] = $this->general->getSubordinateOrganizations($cug);
		$data['data'] = $this->performances->searchEmployeeAssessmentBySupervisor($employee, $org_unit, $year, $period);
		$data['data2'] = $this->general->getSubordinatesByParent($position);

		$employeeByOrgUnit = $this->db->select('ep.employee_id')
		->from('employee_pt as ep')
		->join('employee_position as ept', 'ept.employee_id = ep.employee_id')
		->join('positions as p', 'p.id = ept.position_id')
		->where('p.org_unit', $org_unit)
		->where('ept.flag', TRUE)->get()->result();

		$filter = array();
		foreach ($employeeByOrgUnit as $empOrg) {
			$filter[] = $empOrg->employee_id;
		}

		$data['filter'] = $filter;

		$this->load->view('includes/main', $data);
	}

	public function create_criteria()
	{
		$employee_id = $this->session->userdata('employee');
		$position = $this->session->userdata('position');
		$level = $this->session->userdata('level');

		$year = $this->uri->segment(4);
		$org_unit = $this->uri->segment(5);
		$period = $this->uri->segment(6);

		$data['content']	= $this->view.'create_criteria_specific';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Anggota Tim';
		$data['sub_title']	= 'Buat Kriteria Penilaian';
		$data['year'] = $year;
		$data['period_type'] = $this->db->get_where('period_types', array('id' => $period))->row();
		$data['organizations'] = $this->db->get_where('organizations', array('id' => $org_unit))->row();		
		$data['subordinates'] 	= $this->general->getSubordinatesByParent($position)->result();
		$data['data'] = $this->performances->searchEmployeeAssessmentBySupervisor(NULL, $org_unit, $year);

		$this->load->view('includes/main', $data);
	}

	public function adjustment_criteria()
	{
		$performance_id = $this->uri->segment(4);

		$employee_id = $this->session->userdata('employee');
		$position = $this->session->userdata('position');
		$level = $this->session->userdata('level');

		$employee = isset($_GET['employee']) ? $_GET['employee'] : NULL;
		$year = isset($_GET['year']) ? $_GET['year'] : NULL;
		$org_unit = isset($_GET['org_unit']) ? $_GET['org_unit'] : NULL;
		$period = isset($_GET['period']) ? $_GET['period'] : NULL;

		$employeeByOrgUnit = $this->db->select('ep.employee_id')
		->from('employee_pt as ep')
		->join('employee_position as ept', 'ept.employee_id = ep.employee_id')
		->join('positions as p', 'p.id = ept.position_id')
		->where('p.org_unit', $org_unit)
		->where('ept.flag', TRUE)->get()->result();

		$filter = array();
		foreach ($employeeByOrgUnit as $empOrg) {
			$filter[] = $empOrg->employee_id;
		}

		if (!in_array($employee, $filter)) {
			$this->session->set_flashdata('error', 'Pegawai tidak termasuk dalam organisasi ini');

			redirect($_SERVER['HTTP_REFERER']);
		}

		$data['content']	= $this->view.'adjustment_criteria';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Anggota Tim';
		$data['sub_title']	= 'Buat Kriteria Penilaian';
		$data['year'] = $year;
		$data['period_type'] = $this->db->get_where('period_types', array('id' => $period))->row();
		$data['employee'] = $this->db->get_where('employees', array('id' => $employee))->row();
		$data['performance'] = $this->db->get_where('performances', array('id' => $performance_id))->row();

		if ($data['performance']->status_criteria == self::APPROVED) {
			$this->session->set_flashdata('error', 'Kriteria penilaian telah disetujui pegawai, tidak dapat mengubah kriteria');

			redirect($_SERVER['HTTP_REFERER']);
		}

		$data['data'] = $this->performances->searchAssessmentSpecifif($performance_id, $employee, $year);

		$this->load->view('includes/main', $data);
	}

	public function assessment()
	{
		$employee = NULL;
		$performance_id = $this->uri->segment(4);

		$position = $this->session->userdata('position');
		$performance = $this->db->get_where('performances', array('id' => $performance_id))->row();

		if (!$performance_id) {
			$this->session->set_flashdata('error', 'Tidak dapat melakukan penilaian karena pegawai belum memiliki kriteria penilaian');

			redirect($_SERVER['HTTP_REFERER']);
		}

		// check employee_id
		if (!in_array($performance->assessor_id, $position) || $performance->status_criteria != self::APPROVED) {
			$this->session->set_flashdata('error', 'Hasil kinerja pegawai tidak ditemukan');
			redirect('employee/team/performance');
		}

		$data['content']	= $this->view.'assessment';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Kinerja';
		$data['sub_title']	= 'Hasil Penilaian';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data'] = $this->performances->getPerformanceResult($performance_id)->row();
		$data['specific'] = $this->performances->getPerformanceSpecific($performance_id);

		if (isset($_GET['employee'])) {
			$employee = $_GET['employee'];
		}

		// check employee sudah punya performances atau belum
		$hasScore = $this->db->select('pr.id')->from('performance_assessment_standard as pas')->join('performances as pr', 'pr.id = pas.performance_id')->where(array('pr.id' => $performance_id, 'pr.employee_id' => $employee))->get()->row();

		if ($hasScore) {
			$data['standard'] = $this->performances->getPerformanceStandard($data['data']->pac_id, $employee);
		} else {			
			$data['standard'] = $this->performances->getEmptyPerformanceStandard($data['data']->pac_id);
		}

		$this->load->view('includes/main', $data);
	}

	public function copy_assessment_period()
	{
		$url = NULL;
		$user_id = $this->session->userdata('id');
		$performance_id = $this->uri->segment(4);

		$employee = $this->input->post('employee');
		$org_unit = $this->input->post('org_unit');		
		$period_type_from = $this->input->post('period_type_from');
		$period_type = $this->input->post('period_type');

		$year_to = $this->input->post('period_to');
		$year_from = $this->input->post('period_from');

		if ($year_to == $year_from && $period_type_from == $period_type) {			
			$this->session->set_flashdata('error', 'Tidak bisa menyalin KRA pada periode yang sama');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->trans_begin();
		try {
			if (!$performance_id) {
				$assessor_id = $this->employees->getParentPosition($employee)->row()->parent_id;
				$assessor_name = $this->authorization->getUser($this->session->userdata('employee'))->name;

				$pac_id =  $this->db->select('id')->from('performance_appraisal_calendar')->where(array('year' => $year_to))->group_by('year')->get()->row()->id;

				$dataPerformance = array(
					'status_criteria' => self::DRAFT,
					'pac_id' => $pac_id,
					'employee_id' => $employee,
					'period_type' => $period_type,
					'assessor_id' => $assessor_id,
					'assessor_name' => $assessor_name
				);

				$this->db->insert('performances', $dataPerformance);

				$performance_id = $this->db->insert_id();
			}

			$assessment = $this->performances->searchAssessmentSpecifif(NULL, $employee, $year_from)->result();

			foreach ($assessment as $ass) {
				$data = array(
					'performance_id' => $performance_id,
					'kra' => $ass->kra,
					'kpi' => $ass->kpi,
					'criteria' => $ass->criteria,
					'created_by' => $user_id,
					'updated_by' => $user_id
				);			

				$this->db->insert('assessment_specific', $data);
			}

		    $url = 'employee/team/adjustment_criteria/'.$performance_id.'?employee='.$employee.'&org_unit='.$org_unit.'&year='.$year_to.'&period='.$period_type;
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Penilaian kinerja spesifik gagal disalin');
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Penilaian kinerja spesifik berhasil disalin');
	        $this->db->trans_commit();
	    }

		redirect($url);
	}

	public function store_criteria_specific()
	{
		$user_id = $this->session->userdata('id');

		$year = $this->uri->segment(4);

		$period_type = $this->input->post('period_type');
		$employee_id = $this->input->post('employee');
		$save = $this->input->post('save');

		$kra = $this->input->post('kra');
		$kpi = $this->input->post('kpi');
		$criteria = $this->input->post('criteria');

		$check_id = $this->input->post('check_id');
		$u_id = $this->input->post('u_id');
		$u_kra = $this->input->post('u_kra');
		$u_kpi = $this->input->post('u_kpi');
		$u_criteria = $this->input->post('u_criteria');
		
		$diff = array_diff((array) $check_id, (array) $u_id);

		if ($save == 'publish') {
			$status = self::PUBLISHED;
		} else {
			$status = self::DRAFT;
		}

		$this->db->trans_begin();
		try {
			$assessor_id = $this->employees->getParentPosition($employee_id)->row()->parent_id;
			$assessor_name = $this->authorization->getUser($this->session->userdata('employee'))->name;

			$pac_id =  $this->db->select('id')->from('performance_appraisal_calendar')->where(array('year' => $year))->group_by('year')->get()->row()->id;

			$dataPerformance = array(
				'status_criteria' => $status,
				'pac_id' => $pac_id,
				'employee_id' => $employee_id,
				'period_type' => $period_type,
				'assessor_id' => $assessor_id,
				'assessor_name' => $assessor_name
			);
		
			// insert performances	
			$this->db->insert('performances', $dataPerformance);
			$performance_id = $this->db->insert_id();

			// insert kriteria
			for ($i=0; $i < count((array) $kra); $i++) {
				$data = array(
					'performance_id' => $performance_id,
					'kra' => $kra[$i],
					'kpi' => $kpi[$i],
					'criteria' => $criteria[$i],
					'created_by' => $user_id,
					'updated_by' => $user_id
				);

				$this->db->insert('assessment_specific', $data);
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Penilaian kinerja spesifik gagal di '.$save);
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Penilaian kinerja spesifik berhasil di '.$save);
	        $this->db->trans_commit();
	    }

		redirect('employee/team/adjustment_criteria/'.$performance_id.'?org_unit='.$_GET['org_unit'].'&employee='.$employee_id.'&year='.$year.'&period='.$period_type);
	}

	public function update_criteria_specific()
	{
		$user_id = $this->session->userdata('id');

		$year = $this->uri->segment(4);
		$employee_id = $this->uri->segment(5);
		$performance_id = $this->uri->segment(6);

		$period_type = $this->input->post('period_type');
		$save = $this->input->post('save');

		$kra = $this->input->post('kra');
		$kpi = $this->input->post('kpi');
		$criteria = $this->input->post('criteria');

		$check_id = $this->input->post('check_id');
		$u_id = $this->input->post('u_id');
		$u_kra = $this->input->post('u_kra');
		$u_kpi = $this->input->post('u_kpi');
		$u_criteria = $this->input->post('u_criteria');
		
		$diff = array_diff((array) $check_id, (array) $u_id);

		if ($save == 'publish') {
			$status = self::PUBLISHED;
		} else {
			$status = self::DRAFT;
		}

		$this->db->trans_begin();
		try {
			$assessor_id = $this->employees->getParentPosition($employee_id)->row()->parent_id;
			$assessor_name = $this->authorization->getUser($this->session->userdata('employee'))->name;

			$pac_id =  $this->db->select('id')->from('performance_appraisal_calendar')->where(array('year' => $year))->group_by('year')->get()->row()->id;

			$dataPerformance = array(
				'status_criteria' => $status,
				'pac_id' => $pac_id,
				'employee_id' => $employee_id,
				'period_type' => $period_type,
				'assessor_id' => $assessor_id,
				'assessor_name' => $assessor_name
			);
		
			if ($performance_id) {	
				// update performances				
				$this->db->where('id', $performance_id)->update('performances', $dataPerformance);
			} else {
				// insert performances	
				$this->db->insert('performances', $dataPerformance);
				$performance_id = $this->db->insert_id();
			}

			// insert kriteria
			for ($i=0; $i < count((array) $kra); $i++) {
				$data = array(
					'performance_id' => $performance_id,
					'kra' => $kra[$i],
					'kpi' => $kpi[$i],
					'criteria' => $criteria[$i],
					'created_by' => $user_id,
					'updated_by' => $user_id
				);

				$this->db->insert('assessment_specific', $data);
			}

			// update kriteria
			for ($j=0; $j < count((array) $u_id); $j++) { 
				$data = array(
					'kra' => $u_kra[$j],
					'kpi' => $u_kpi[$j],
					'criteria' => $u_criteria[$j],
					'updated_by' => $user_id
				);

				$this->db->where('id', $u_id[$j])->update('assessment_specific', $data);		
			}

			// delete kriteria
			foreach($diff as $d) {
				$this->db->delete('assessment_specific', array('id' => $d));	
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Penilaian kinerja spesifik gagal di '.$save);
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Penilaian kinerja spesifik berhasil di '.$save);
	        $this->db->trans_commit();
	    }

		redirect('employee/team/adjustment_criteria/'.$performance_id.'?org_unit='.$_GET['org_unit'].'&employee='.$employee_id.'&year='.$year.'&period='.$period_type);
	}

	public function store_assessment()
	{
		$user_id = $this->session->userdata('id');

		$submit = $this->input->post('submit');
		$performance_id = $this->input->post('performance_id');
		$recommendation = $this->input->post('recommendation');

		$specific_id = $this->input->post('specific_id');
		$specific_score = $this->input->post('specific_score');
		$specific_comment = $this->input->post('specific_comment');

		$standard_id = $this->input->post('standard_id');
		$standard_score = $this->input->post('standard_score');
		$standard_comment = $this->input->post('standard_comment');

		if ($submit == 'save') {
			$status_assessment = self::DRAFT;
		} else {
			$status_assessment = self::PUBLISHED;
		}

		$total_specific_score = 0;
		$total_standard_score = 0;

		$this->db->trans_begin();

		try {			
			$dataPerformance = array(
				'status_assessment' => $status_assessment,
				'result' => '',
				'recommendation' => $recommendation
			);

			$this->db->where('id', $performance_id)->update('performances', $dataPerformance);

			// insert penilaian standar
			for ($i=0; $i < count((array) $standard_id); $i++) {
				$dataStandard = array(
					'performance_id' => $performance_id,
					'assessment_standard_id' => $standard_id[$i],
					'score' => $standard_score[$i],
					'comment' => $standard_comment[$i]
				);

				$check_standard = $this->db->get_where('performance_assessment_standard', array('performance_id' => $performance_id, 'assessment_standard_id' => $standard_id[$i]))->row();

				if ($check_standard) {					
					$this->db->where('id', $check_standard->id)->update('performance_assessment_standard', $dataStandard);
				} else {					
					$this->db->insert('performance_assessment_standard', $dataStandard);	
				}

				$total_standard_score = $total_standard_score + $standard_score[$i];
			}

			// update penilaian spesifik
			for ($j=0; $j < count((array) $specific_id); $j++) {

				$dataSpecific = array(
					'score' => $specific_score[$j],
					'comment' => $specific_comment[$j],
					'updated_by' => $user_id
				);

				$this->db->where('id', $specific_id[$j])->update('assessment_specific', $dataSpecific);

				$total_specific_score = $total_specific_score + $specific_score[$j];
			}

			// final score
			$avg_standard_score = $total_standard_score / count((array) $standard_id) * 0.45;
			$avg_specific_score = $total_specific_score / count((array) $specific_id) * 0.35;
			$final_score = $avg_specific_score + $avg_standard_score;
			$result = null;

			if ($final_score > 1 && $final_score < 2) {
				$result = 'Perlu banyak pengembangan';
			} elseif ($final_score > 3 && $final_score < 4) {
				$result = 'Masih perlu dikembangkan';
			} elseif ($final_score > 5 && $final_score < 6) {
				$result = 'Sesuai tingkatan yang diperlukan/efektif';
			} elseif ($final_score > 7 && $final_score < 8) {
				$result = 'Diatas tingkatan yang diperlukan/sangat efektif';
			}

			$this->db->where('id', $performance_id)->update('performances', array('final_score' => $final_score, 'result' => $result));
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Penilaian kinerja spesifik gagal di '.$save);
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Penilaian kinerja spesifik berhasil di '.$save);
	        $this->db->trans_commit();
	    }

	    redirect($_SERVER['HTTP_REFERER']);
	}

	public function timesheet()
	{
		$id = $this->session->userdata('employee');
		$position = $this->session->userdata('position');
		$level = $this->session->userdata('level');

		$data['content']	= $this->view.'timesheet';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Anggota Tim';
		$data['sub_title']	= 'Kegiatan Harian';
		$data['message']	= '';
		$data['level']		= $level;

		$child = $this->general->getChildrenPositions($position);

		$data['employee'] 	= $this->general->getSubordinates($child);

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

		$data['data']		= $this->timesheets->searchTimesheetSubodinates($position, $approval, $start, $finish, $employee);

		$this->load->view('includes/main', $data);
	}

	public function edit_timesheet()
	{
		$id = $this->uri->segment(4);
		$positions = $this->session->userdata('position');

		$check = $this->db->select('t.*, e.name, p.position')
		->from('timesheets as t')
		->join('employees as e', 'e.id = t.employee_id')
		->join('employee_position as ept', 'ept.employee_id = t.employee_id')
		->join('positions as p', 'p.id = ept.position_id')
		->where(array('t.id' => $id))
		->where_in('t.approver_id', $positions)
		->get()
		->row();

		if (!$check) {
			$this->session->set_flashdata('error', 'Data kegiatan anggota tim tidak ditemukan');
			redirect('employee/team/timesheet');
		}

		$data['content']	= $this->view.'edit_timesheet';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Anggota Tim';
		$data['sub_title']	= 'Edit Kegiatan Harian';
		$data['message']	= '';
		$data['data']		= $check;

		$this->load->view('includes/main', $data);
	}

	public function update_timesheet()
	{
		$id = $this->uri->segment(4);

		$this->db->trans_begin();

		$data = array(
			'feedback' => $this->input->post('feedback')
		);

		$this->db->where('id', $id)->update('timesheets', $data);

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
			$this->session->set_flashdata('error', 'Saran gagal ditambahkan');
	    } else {
	        $this->db->trans_commit();
			$this->session->set_flashdata('success', 'Saran berhasil ditambahkan');
	    }

		redirect('/employee/team/edit_timesheet/'.$id);
	}
}
