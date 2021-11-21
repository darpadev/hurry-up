<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Timesheet extends MY_Controller
{
	protected $view = 'contents/hrd/timesheet/';
	protected $table = 'timesheet';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->hrd();
	}

	public function index()
	{
		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Kegiatan Harian';
		$data['sub_title']	= '';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion'] 	= $this->general->countEmployeePromotion();

		$start = NULL;
		$finish = NULL;
		$employee = NULL;

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

		$this->db->select('t.*, e.name, ep.nip, as.status');
		$this->db->from('timesheets as t');
		$this->db->join('approval_status as as', 'as.id = t.approval');
		$this->db->join('employee_pt as ep', 'ep.employee_id = t.employee_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->order_by('t.date_on', 'ASC');

		if ($employee) {
			$this->db->where('t.employee_id', $employee);
		}

		if ($start && $finish) {
			$this->db->where("date_on BETWEEN '$start' AND '$finish'", NULL, FALSE);
		}

		$query = $this->db->get();
		
		$data['data'] = $query;

		$this->load->view('includes/main', $data);
	}
}
