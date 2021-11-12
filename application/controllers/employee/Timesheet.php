<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Timesheet extends MY_Controller
{
	protected $view = 'contents/employee/timesheet/';
	protected $table = 'timesheet';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->employee();
		$this->load->model('timesheets');
	}

	public function index()
	{
		$employee = $this->session->userdata('employee');
		$positions = $this->session->userdata('position');

		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Kegiatan Harian';
		$data['sub_title']	= '';
		$data['notif']		= array();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$start = NULL;
		$finish = NULL;

		if (isset($_GET['date'])) {
			$date = explode(' - ', $_GET['date']);
			$start = date('Y-m-d', strtotime($date[0]));
			if (isset($date[1])) {
				$finish = date('Y-m-d', strtotime($date[1]));
			}
		}

		$data['data'] = $this->timesheets->getDataTimesheet($employee, $start, $finish);

		$tupoksi = $this->timesheets->getDataTupoksi($positions)->result();

		$data['tupoksi'] = $tupoksi;

		$this->load->view('includes/main', $data);
	}

	public function store()
	{		
		$employee = $this->session->userdata('employee');
		$tupoksi = $this->input->post('tupoksi');
		// $u_activities = $this->input->post('u_activity');

		$this->db->trans_begin();

		try {			
			$i = 0;
			foreach ($tupoksi as $tup) {
				$check = $this->db->get_where('tupoksi', array('id' => $tup))->row();

				if ($check) {						
					$weight = $check->weight;
					$task = $check->tupoksi;
					$supervisor = null;

					$approver = $this->db->get_where('positions', array('id' => $check->position_id))->row();

					if ($approver) {
						$supervisor = $approver->parent_id;
					}

					$timesheet = array(
						'employee_id' => $employee,
						'approval' => self::WAITING_FOR_APPROVAL,
						'date_on' => date('Y-m-d' ,strtotime($this->input->post('date_on')[$i])),
						'duration' => $this->input->post('duration')[$i],
						'tupoksi' => $task,
						'activity' => $this->input->post('activity')[$i],
						'weight' => $weight,
						'approver_id' => $supervisor // parent position
					);

					$this->db->insert('timesheets', $timesheet);
				}

				$i++;		
			}

			// if ($u_activities) {
			// 	$j = 0;
			// 	foreach ($u_activities as $u_act) {
			// 		$timesheet = array(
			// 			'duration' => $this->input->post('u_duration')[$j],
			// 			'date_on' => date('Y-m-d'),
			// 			'activity' => $u_act
			// 		);

			// 		$this->db->update('timesheets', $timesheet, array('id'=>$this->input->post('u_id')[$j]));
			// 		$j++;		
			// 	}
			// }
		} catch (Exception $ex) {			
			$this->session->set_flashdata('error', $ex->getMessage());
		}

		if ($this->db->trans_status() === FALSE) {
		    $this->db->trans_rollback();
			$this->session->set_flashdata('success', 'Kegiatan harian gagal ditambah');
		} else {
		    $this->db->trans_commit();
			$this->session->set_flashdata('success', 'Kegiatan harian berhasil ditambah');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function edit()
	{
		$id = $this->uri->segment(4);
		$employee_id = $this->session->userdata('employee');

		$check = $this->db->get_where('timesheets', array('id' => $id, 'employee_id' => $employee_id))->row();

		if (!$check) {
			$this->session->set_flashdata('error', 'Data kegiatan tidak ditemukan');
			redirect('employee/timesheet');
		}

		$data['content']	= $this->view.'edit';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Kegiatan Harian';
		$data['sub_title']	= 'Edit Kegiatan Harian';
		$data['message']	= '';
		$data['data']		= $check;

		$this->load->view('includes/main', $data);
	}

	public function update()
	{
		$id = $this->uri->segment(4);
		$activity = $this->input->post('activity');
		$duration = $this->input->post('duration');

		$this->db->trans_begin();

		try {
			$data = array(
				'approval' => self::WAITING_FOR_APPROVAL,
				'duration' => $duration,
				'activity' => $activity,
				'feedback' => null
			);

			$this->db->where('id', $id)->update('timesheets', $data);
		} catch (Exception $ex) {			
			$this->session->set_flashdata('error', $ex->getMessage());
		}

		if ($this->db->trans_status() === FALSE) {
		    $this->db->trans_rollback();
			$this->session->set_flashdata('success', 'Kegiatan harian gagal diubah');
		} else {
		    $this->db->trans_commit();
			$this->session->set_flashdata('success', 'Kegiatan harian berhasil diubah');
		}

		redirect('employee/timesheet');
	}
}
