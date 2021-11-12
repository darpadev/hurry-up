<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Overtime extends MY_Controller
{
	protected $view = 'contents/employee/overtime/';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->employee();
		$this->load->model('employees');
		$this->load->model('overtimes');
	}

	public function index()
	{
		$id = $this->session->userdata('employee');

		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Lembur';
		$data['sub_title']	= '';
		$data['message']	= '';

		$start = NULL;
		$finish = NULL;
		$approval = NULL;
		$calendar = array();

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

		$result = $this->overtimes->searchOvertimeByFilter($start, $finish, $approval, $id);

		if (isset($_GET['date'])) {
			foreach ($result->result() as $cal) {
				if ($cal->status != 'Rejected' && $cal->status != 'Cancelled') {
					array_push($calendar, array(
						'title' => $cal->description,
						'start' => $cal->overtime_date.'T'.$cal->start,
						'end' => $cal->overtime_date.'T'.$cal->finish,
						'url' => base_url().'employee/overtime/show/'.$cal->id
					));
				}
			}
		}

		$data['data']	= $result;
		$data['calendar'] = $calendar;

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
		$data['message']	= '';
		$data['data']		= $this->overtimes->showApproverOvertimeByOvertimeId($id);
		$data['overtime']	= $this->overtimes->showEmployeeOvertime($id)->row();
		$data['report']		= $this->overtimes->showReportOvertime($id);
		
		if (
			!isset($data['overtime']) ||
			$data['overtime']->employee_id != $this->session->userdata('employee') 
		) {
			$this->session->set_flashdata('error', 'Data lembur tidak ditemukan');
			redirect('employee/overtime');
		}

		$this->load->view('includes/main', $data);
	}

	public function report()
	{
		$id = $this->uri->segment(4);

		$data['content']	= $this->view.'report';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Lembur';
		$data['sub_title']	= 'Laporan Lembur';
		$data['message']	= '';
		$data['data']		= $this->overtimes->showApproverOvertimeByOvertimeId($id);
		$data['overtime']	= $this->overtimes->showEmployeeOvertime($id)->row();
		
		if (
			!isset($data['overtime']) ||
			$data['overtime']->employee_id != $this->session->userdata('employee') 
		) {
			$this->session->set_flashdata('error', 'Data lembur tidak ditemukan');
			redirect('employee/overtime');
		}

		$this->load->view('includes/main', $data);
	}


	private function decimalHour($time)
	{
		$hms = explode(":", $time);
		return ($hms[0] + ($hms[1]/60) + ($hms[2]/3600));
	}

	public function report_update()
	{
		$id = $this->uri->segment(4);

		$this->db->trans_begin();

		$duration = array();
		for ($i = 0; $i < count($this->input->post('description')); $i++) {
			$report = array(
				'overtime_id' => $id,
				'start' => $this->input->post('start')[$i],
				'finish' => $this->input->post('finish')[$i],
				'description' => $this->input->post('description')[$i],
			);

			$this->db->insert('overtime_reports', $report);

			$finish = new DateTime($this->input->post('finish')[$i]);
			$start = new DateTime($this->input->post('start')[$i]);

			$interval = $finish->diff($start);
			$elapsed = $interval->format('%H:%I:%S');
			array_push($duration, $elapsed);
		}

		$actual_duration = sumDuration($duration);

		$check = $this->db->select('od.maximal, o.overtime_date, o.day_type, o.employee_id, COALESCE(s.basic_salary, 0) as basic_salary')
			->from('overtimes as o')
			->join('overtime_day as od', 'od.id = o.day_type')
			->join('salary as s', 's.employee_id = o.employee_id', 'left')
			->where('o.id', $id)->get()->row();		

		// batas lembur maximal perhari
		// if (strtotime($check->maximal) < strtotime($actual_duration)) {
		// 	$paid_hours = $check->maximal;
		// 	$paid_overtime = '';
		// } else {
		// 	$paid_hours = $actual_duration;
		// 	$paid_overtime = '';			
		// }

		// batas lembur maximal perbulan
		$formula = $check->basic_salary / 173;
		$paid_hours = $actual_duration;
		$first_hour = 0;
		$second_hour = 0;
		$hour_remaining = 0;
		$paid_overtime = 0;
			
		if (strtotime($paid_hours) >= strtotime('01:00:00')) {
			// hari libur
			if ($check->day_type == self::WEEKEND) {
				if (strtotime($paid_hours) >= strtotime('07:00:00')) {
					$first_hour = round($this->decimalHour('07:00:00') * $formula * 2);

					// jika lebih dari 8 jam
					if (strtotime($paid_hours) >= strtotime('07:00:00') && strtotime($paid_hours) <= strtotime('08:00:00')) {
						$second_hour = round($this->decimalHour(date('H:i:s', strtotime('-7 hours', strtotime($paid_hours)))) * $formula * 3);
					}

					if (strtotime($paid_hours) >= strtotime('08:00:00')) {
						$second_hour = round($this->decimalHour(date('H:i:s', strtotime('-7 hours', strtotime($paid_hours)))) * $formula * 3);
					}

					// jika lebih dari 9 jam
					if (strtotime($paid_hours) >= strtotime('08:00:00') && strtotime($paid_hours) <= strtotime('09:00:00')) {
						$second_hour = round($this->decimalHour('01:00:00') * $formula * 3);
						$hour_remaining = round($this->decimalHour(date('H:i:s', strtotime('-8 hours', strtotime($paid_hours)))) * $formula * 4);
					}

					if (strtotime($paid_hours) >= strtotime('09:00:00')) {
						$second_hour = round($this->decimalHour('01:00:00') * $formula * 3);
						$hour_remaining = round($this->decimalHour(date('H:i:s', strtotime('-8 hours', strtotime($paid_hours)))) * $formula * 4);
					}
				} else {					
					$first_hour = round($this->decimalHour($paid_hours) * $formula * 2);
				}

				$paid_overtime = $first_hour + $second_hour + $hour_remaining;
			} else {
				$first_hour = round($this->decimalHour('01:00:00') * $formula * 1.5);

				$hour_remaining = round($this->decimalHour(date('H:i:s', strtotime('-1 hours', strtotime($paid_hours)))) * $formula * 2);
				$paid_overtime = $first_hour + $hour_remaining;
			}
		}

		$overtime = array(
			'approval' => self::VERIFICATION,
			'actual_duration' => $actual_duration,
			'paid_hours' => $paid_hours,
			'paid_overtime' => $paid_overtime,
			'updated_by' => $this->session->userdata('id')
		);

		$this->db->where('id', $id)->update('overtimes', $overtime);

		if ($this->db->get_where('overtimes', array('id' => $id))->row()->insidentil == TRUE) {
			$level_approver = 2;
			$level_type = array(1,2,3,4);
		} else {
			$level_approver = 1;
			$level_type = array(1,2,3);
		}

		$child = $this->db->select('parent_id')->from('positions')->where('id', $this->session->userdata('position')[0])->get()->row();

		$approver = $this->general->getParentPositions($child->parent_id);

		$constraint = 0;
		foreach ($approver as $value) {
			$check_level = $this->db->select('level')->from('positions')->where('id', $value)->where_in('level', $level_type)->get()->row();

			if ($check_level) {
				if ($constraint < $level_approver) {
					$data_approver = array(
						'overtime_id' => $id,
						'approver_id' => $value,
						'overtime_type' => self::REPORT,
					);

					$this->db->insert('approval_overtimes', $data_approver);

					// email notification
					$sender = $this->db->select('e.name')->from('employees as e')->where(array('id' => $this->session->userdata('employee')))->get()->row();
					$receiver = $this->notifications->getReceiverData($value)->row();
			    	$this->notifications->sendMailOvertimeReported($receiver->email, $receiver->name, $sender->name, $check->overtime_date, $no_assignment);

			    	// notification to hrd
			    	$this->notifications->sendMailOvertimeToHrd($this->db->get('email')->row()->email, 'Staf SDM', $sender->name, $check->overtime_date, $no_assignment);
				}		
				$constraint++;	
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Lembur gagal dilaporkan');
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Lembur berhasil dilaporkan');
	        $this->db->trans_commit();
	    }

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function store()
	{
		$employee_id = $this->session->userdata('employee');
		$org_unit = $this->db->select('id, code')->from('organizations')->where_in('id', $this->session->userdata('org_unit'))->group_by('code')->get()->row();
		$year = date('Y');
		$number = $this->overtimes->getCounter($year, $org_unit->code)->row();
		$no_assignment = 'OVI-'.$org_unit->code.'-'.substr($year, 2).'-'.str_pad((int) $number->counter + 1, 4, '0', STR_PAD_LEFT);
		
		$overtime_date = strtotime($this->input->post('overtime_date'));
		$day = strtolower(date('l', $overtime_date));
		if ($day == 'saturday' || $day == 'sunday') 
		{
			$day_type = self::WEEKEND;
		} else {
			$holiday = $this->db->get_where('holiday', array('day_off' => date('Y-m-d', $overtime_date)))->row();

			if ($holiday) {				
				$day_type = self::WEEKEND;
			} else {
				$day_type = self::WEEKDAY;
			}
		}
		
		$this->db->trans_begin();

		$data = array(
			'requestor' => $employee_id,
			'employee_id' => $employee_id,
			'no_assignment' => $no_assignment,
			'start' => $this->input->post('start'),
			'finish' => $this->input->post('finish'),
			'overtime_date' => date('Y-m-d', $overtime_date),
			'description' => $this->input->post('description'),
			'place' => $this->input->post('place'),
			'day_type' => $day_type,
			'created_by' => $employee_id,
			'updated_by' => $employee_id
		);

		if ($this->session->userdata('group') == self::TENDIK) {
			$data['insidentil'] = TRUE;
			$level_approver = 2;
			$level_type = array(1,2,3,4);
		} else {
			$level_approver = 1;
			$level_type = array(1,2,3);
		}

		try {
			$this->db->insert('overtimes', $data);
			$overtime_id = $this->db->insert_id();
			
		    $child = $this->db->select('parent_id')->from('positions')->where('id', $this->session->userdata('position')[0])->get()->row();

			$approver = $this->general->getParentPositions($child->parent_id);

			$constraint = 0;
			foreach ($approver as $value) {
				$check_level = $this->db->select('level')->from('positions')->where('id', $value)->where_in('level', $level_type)->get()->row();

				if ($check_level) {
					if ($constraint < $level_approver) {
						$data_approver = array(
							'overtime_id' => $overtime_id,
							'approver_id' => $value,
							'overtime_type' => self::REQUEST,
						);

						$this->db->insert('approval_overtimes', $data_approver);

						// email notification
						$sender = $this->db->select('e.name')->from('employees as e')->where(array('id' => $this->session->userdata('employee')))->get()->row();
						$receiver = $this->notifications->getReceiverData($value)->row();
						$this->notifications->sendMailOvertimeToSupervisor($receiver->email, $receiver->name, $sender->name, tanggal(date('Y-m-d', $overtime_date)), $no_assignment);
					}

					$constraint++;				
				}

			}

			if ($this->db->trans_status() === FALSE) {
				$this->session->set_flashdata('error', 'Lembur gagal ditambah');
		        $this->db->trans_rollback();
		    } else {
		    	$this->session->set_flashdata('success', 'Lembur berhasil ditambah');
		        $this->db->trans_commit();
		    }
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
	        $this->db->trans_rollback();			
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function cancel()
	{
		$employee_id = $this->session->userdata('employee');

		$this->db->trans_begin();

		$this->db->where('id', $this->uri->segment(4))->update('overtimes', array('approval' => self::CANCELLED, 'updated_by' => $employee_id));
		$this->db->where(array('overtime_id' => $this->uri->segment(4), 'flag !=' => self::APPROVED))->update('approval_overtimes', array('flag' => self::CANCELLED));

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Lembur gagal dibatalkan');
	        $this->db->trans_rollback();
		} else {
			$this->session->set_flashdata('success', 'Lembur berhasil dibatalkan');
	        $this->db->trans_commit();
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
}
