<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Approve extends MY_Controller
{
	protected $view = 'contents/employee/approve/';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->employee();
		$this->load->model('employees');
		$this->load->model('presences');
		$this->load->model('overtimes');
		$this->load->model('leaves');
	}

	public function leave()
	{
		$id = $this->session->userdata('employee');
		$position = $this->session->userdata('position');
		$level = $this->session->userdata('level');

		$data['content']	= $this->view.'leave';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Persetujuan';
		$data['sub_title']	= 'Cuti';
		$data['message']	= '';

		$child = $this->general->getChildrenPositions($position);

		$data['employee'] 	= $this->general->getSubordinates($child);
		
		$employee = NULL;
		$start = NULL;
		$finish = NULL;
		$approval = self::WAITING_FOR_APPROVAL;

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

		$data['data']		= $this->leaves->searchEmployeeByLeaveApprover($employee, $approval, $start, $finish, $position);

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
		$data['title']		= 'Cuti';
		$data['sub_title']	= 'Lihat Cuti';
		$data['message']	= '';
		$data['data']		= $this->leaves->showEmployeeLeaveByLeaveId($id);
		$data['leave']		= $this->leaves->showEmployeeLeave($id)->row();

		// check subordinates positions
		$employee_positions = $this->db->select('position_id')->from('employee_position')->where(array('employee_id' => $data['leave']->employee_id, 'flag' => 1))->get()->result();

		$emp_pos = array();
		foreach ($employee_positions as $emppos) {
			$emp_pos[] = $emppos->position_id;
		}
		
		if (
			!isset($data['leave']) || 
			!array_intersect($emp_pos, $child)
		) {
			$this->session->set_flashdata('error', 'Data izin kerja pegawai tidak ditemukan');
			redirect('employee/approve/leave');
		}
		
		$this->load->view('includes/main', $data);
	}

	public function approve_leave()
	{
		$id = $this->session->userdata('id');
		$position = $this->session->userdata('position');
		$leave_id = $this->uri->segment(4);
		$approver_id = $this->uri->segment(5);
		$approver_name = $this->authorization->getUser($this->session->userdata('employee'))->name;

		if (!$id || !$leave_id || !$approver_id) {
			$this->session->set_flashdata('error', 'Pengajuan izin kerja gagal diproses');
			redirect($_SERVER['HTTP_REFERER']);
		}

		// position validation
		if (!in_array($approver_id, $position)) {
			$this->session->set_flashdata('error', 'Anda tidak berhak melakukan persetujuan pada data ini');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->logic_approve_leave($id, $leave_id, $approver_id, $approver_name);

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reject_leave()
	{
		$id = $this->session->userdata('id');
		$position = $this->session->userdata('position');
		$leave_id = $this->uri->segment(4);
		$approver_id = $this->uri->segment(5);
		$approver_name = $this->authorization->getUser($this->session->userdata('employee'))->name;

		if (!$id || !$leave_id || !$approver_id) {
			$this->session->set_flashdata('error', 'Pengajuan izin kerja gagal diproses');
			redirect($_SERVER['HTTP_REFERER']);
		}

		// position validation
		if (!in_array($approver_id, $position)) {
			$this->session->set_flashdata('error', 'Anda tidak berhak melakukan persetujuan pada data ini');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->logic_reject_leave($id, $leave_id, $approver_id, $approver_name);

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function bulk_approval_leave()
	{
		$id = $this->session->userdata('id');
		$position = $this->session->userdata('position');
		$approver_name = $this->authorization->getUser($this->session->userdata('employee'))->name;

		$bulks = $this->input->post('approval');
		$type = $this->input->post('bulk');

		try {
			if ($bulks) {
				foreach ($bulks as $bulk) {
					$value = explode(",", $bulk);
					$leave_id = $value[0];
					$approver_id = $value[1];

					if (!$id || !$leave_id || !$approver_id) {
						$this->session->set_flashdata('error', 'Pengajuan izin kerja gagal diproses');
						redirect($_SERVER['HTTP_REFERER']);
					}

					// position validation
					if (!in_array($approver_id, $position)) {
						$this->session->set_flashdata('error', 'Anda tidak berhak melakukan persetujuan pada data ini');
						redirect($_SERVER['HTTP_REFERER']);
					}

					if ($type == 'Terima Permohonan') {						
						$this->logic_approve_leave($id, $leave_id, $approver_id, $approver_name);
					} else {						
						$this->logic_reject_leave($id, $leave_id, $approver_id, $approver_name);						
					}
				}			
			} else {				
				$this->session->set_flashdata('error', 'Harap memilih permohonan terlebih dahulu');
			}
		} catch (Exception $e) {			
			$this->session->set_flashdata('error', $e->getMessage());
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	private function logic_approve_leave($id, $leave_id, $approver_id, $approver_name)
	{
		$al = array('flag' => self::APPROVED, 'approver_name' => $approver_name, 'updated_at' => date('Y-m-d H:i:s'));
		$approval = array('approval' => self::APPROVED, 'updated_by' => $id);

		$this->db->trans_begin();

		$this->db->where(array('leave_id' => $leave_id, 'approver_id' => $approver_id))->update('approval_leaves', $al);

		$count_approver = $this->db->select('flag')->from('approval_leaves')->where(array('leave_id' => $leave_id))->get()->result();
		$param = array();
		foreach ($count_approver as $value) {
			if ($value->flag == self::REJECTED) {
				$this->db->where(array('id' => $leave_id))->update('leaves', array('approval' => self::REJECTED));
				array_push($param, $value->flag);
				break;
			} else {
				$this->db->where(array('id' => $leave_id))->update('leaves', array('approval' => self::WAITING_FOR_APPROVAL));
				array_push($param, $value->flag);
			}
		}

		if (count(array_keys($param, 2)) == count($param)) {
			$this->db->where(array('id' => $leave_id))->update('leaves', $approval);
			$leaves = $this->db->select('t.employee_id, t.start, t.finish, t.description, lt.type')->from('leaves as t')->join('leave_types as lt', 'lt.id = t.type')->where('t.id', $leave_id)->get()->row();

			$period = new DatePeriod(
			     new DateTime($leaves->start),
			     new DateInterval('P1D'),
			     new DateTime($leaves->finish)
			);

			foreach ($period as $value) {
				$this->db->insert('log_presences', array('employee_id' => $leaves->employee_id, 'date' => $value->format('Y-m-d'), 'status' => self::WAITING_FOR_APPROVAL, 'type' => self::WFO, 'notes' => $leaves->type.' - '.$leaves->description));
			}

			$this->db->insert('log_presences', array('employee_id' => $leaves->employee_id, 'date' => $leaves->finish, 'status' => self::WAITING_FOR_APPROVAL, 'type' => self::WFO, 'notes' => $leaves->type.' - '.$leaves->description));
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Pengajuan izin kerja gagal diproses');
	        $this->db->trans_rollback();
	    } else {
			$this->session->set_flashdata('success', 'Pengajuan izin kerja berhasil diterima');
	        $this->db->trans_commit();
	    }
	}

	private function logic_reject_leave($id, $leave_id, $approver_id, $approver_name)
	{
		$lle = array('flag' => self::REJECTED, 'approver_name' => $approver_name);
		$approval = array('approval' => self::REJECTED, 'updated_by' => $id);

		$this->db->trans_begin();

		// cancel all approval leaves
		$this->db->where(array('leave_id' => $leave_id))->update('approval_leaves', array('flag' => self::CANCELLED, 'approver_name' => $approver_name));

		// reject approval leaves as approver
		$this->db->where(array('leave_id' => $leave_id, 'approver_id' => $approver_id))->update('approval_leaves', $lle);

		$count_approver = $this->db->select('flag')->from('approval_leaves')->where(array('leave_id' => $leave_id))->get()->result();
		
		foreach ($count_approver as $value) {
			if ($value->flag == self::REJECTED) {
				$this->db->where(array('id' => $leave_id))->update('leaves', array('approval' => self::REJECTED));
				break;
			}
		}
		
		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	    } else {
			$this->session->set_flashdata('success', 'Pengajuan cuti berhasil diterima');
	        $this->db->trans_commit();
	    }
	}

	public function overtime()
	{
		$id = $this->session->userdata('employee');
		$position = $this->session->userdata('position');
		$level = $this->session->userdata('level');

		$data['content']	= $this->view.'overtime';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Persetujuan';
		$data['sub_title']	= 'Lembur';
		$data['message']	= '';
		$data['level']		= $level;

		$child = $this->general->getChildrenPositions($position);

		$level_subordinate = array();
		// $level_subordinate[] = 5;
		$level_subordinate[] = 6; // test

		$data['employee'] 	= $this->general->getSubordinates($child, $level_subordinate);

		$start = NULL;
		$finish = NULL;
		$approval = self::WAITING_FOR_APPROVAL;
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

		$data['data']		= $this->overtimes->searchEmployeeByOvertimeApprover($approval, $start, $finish, $position, $type, $employee);

		$this->load->view('includes/main', $data);
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
		$data['title']		= 'Lembur';
		$data['sub_title']	= 'Lihat Lembur';
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
			$this->session->set_flashdata('error', 'Data lembur pegawai tidak ditemukan');
			redirect('employee/approve/overtime');
		}

		$this->load->view('includes/main', $data);
	}

	public function bulk_approval_overtime()
	{
		$id = $this->session->userdata('id');
		$position = $this->session->userdata('position');
		$approver_name = $this->authorization->getUser($this->session->userdata('employee'))->name;

		$bulks = $this->input->post('approval');
		$type = $this->input->post('bulk');

		try {
			if ($bulks) {
				foreach ($bulks as $bulk) {
					$value = explode(",", $bulk);
					$overtime_id = $value[0];
					$approver_id = $value[1];

					if (!$id || !$overtime_id || !$approver_id) {
						$this->session->set_flashdata('error', 'Pengajuan lembur gagal diproses');
						redirect($_SERVER['HTTP_REFERER']);
					}

					// position validation
					if (!in_array($approver_id, $position)) {
						$this->session->set_flashdata('error', 'Anda tidak berhak melakukan persetujuan pada data ini');
						redirect($_SERVER['HTTP_REFERER']);
					}

					if ($type == 'Terima Permohonan') {						
						$this->logic_approve_overtime($id, $overtime_id, $approver_id, $approver_name);
					} else {						
						$this->logic_reject_overtime($id, $overtime_id, $approver_id, $approver_name);						
					}
				}			
			} else {				
				$this->session->set_flashdata('error', 'Harap memilih permohonan terlebih dahulu');
			}
		} catch (Exception $e) {			
			$this->session->set_flashdata('error', $e->getMessage());
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function approve_overtime()
	{
		$id = $this->session->userdata('id');
		$position = $this->session->userdata('position');
		$overtime_id = $this->uri->segment(4);
		$approver_id = $this->uri->segment(5);
		$approver_name = $this->authorization->getUser($this->session->userdata('employee'))->name;

		if (!$id || !$overtime_id || !$approver_id) {
			$this->session->set_flashdata('error', 'Pengajuan lembur gagal diproses');
			redirect($_SERVER['HTTP_REFERER']);
		}

		// position validation
		if (!in_array($approver_id, $position)) {
			$this->session->set_flashdata('error', 'Anda tidak berhak melakukan persetujuan pada data ini');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->logic_approve_overtime($id, $overtime_id, $approver_id, $approver_name);

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reject_overtime()
	{
		$id = $this->session->userdata('id');
		$position = $this->session->userdata('position');
		$overtime_id = $this->uri->segment(4);
		$approver_id = $this->uri->segment(5);
		$approver_name = $this->authorization->getUser($this->session->userdata('employee'))->name;

		if (!$id || !$overtime_id || !$approver_id) {
			$this->session->set_flashdata('error', 'Pengajuan lembur gagal diproses');
			redirect($_SERVER['HTTP_REFERER']);
		}

		// position validation
		if (!in_array($approver_id, $position)) {
			$this->session->set_flashdata('error', 'Anda tidak berhak melakukan persetujuan pada data ini');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->logic_reject_overtime($id, $overtime_id, $approver_id, $approver_name);

		redirect($_SERVER['HTTP_REFERER']);
	}

	private function logic_approve_overtime($id, $overtime_id, $approver_id, $approver_name)
	{
		$ao = array('flag' => self::APPROVED, 'approver_name' => $approver_name, 'updated_at' => date('Y-m-d H:i:s'));

		$this->db->trans_begin();
		$no_assignment = $this->db->select('no_assignment')->from('overtimes')->where('id', $overtime_id)->get()->row()->no_assignment;
		$overtime_type = $this->db->get_where('approval_overtimes', array('overtime_id' => $overtime_id, 'approver_id' => $approver_id, 'flag' => self::WAITING_FOR_APPROVAL))->row()->overtime_type;

		if ($overtime_type == self::REPORT) {
			$reported = self::REPORTED;
		} else {
			$reported = self::APPROVED;
		}

		$approved = array('approval' => $reported, 'updated_by' => $id);

		$this->db->where(array('overtime_id' => $overtime_id, 'approver_id' => $approver_id, 'overtime_type' => $overtime_type))->update('approval_overtimes', $ao);

		$count_approver = $this->db->select('flag')->from('approval_overtimes')->where(array('overtime_id' => $overtime_id, 'overtime_type' => $overtime_type))->get()->result();

		$param = array();
		
		foreach ($count_approver as $value) {
			if ($value->flag == self::REJECTED) {
				$this->db->where(array('id' => $overtime_id))->update('overtimes', array('approval' => self::REJECTED));
				array_push($param, $value->flag);
				break;
			} else {					
				$this->db->where(array('id' => $overtime_id))->update('overtimes', array('approval' => self::WAITING_FOR_APPROVAL));
				array_push($param, $value->flag);
			}
		}

		if (count(array_keys($param, 2)) == count($param)) {
			$this->db->where(array('id' => $overtime_id))->update('overtimes', $approved);
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Pengajuan lembur gagal diproses');
	        $this->db->trans_rollback();
	    } else {
			$this->session->set_flashdata('success', 'Pengajuan lembur berhasil diterima');
	        $this->db->trans_commit();
			
	    	// email notification
			$sender = $this->db->select('e.name')->from('employees as e')->where(array('id' => $this->session->userdata('employee')))->get()->row();
			$receiver = $this->notifications->getReceiverData($approver_id)->row();
	    	$this->notifications->sendMailOvertimeApproval($receiver->email, $receiver->name, $sender->name, 'approve', $no_assignment);
	    }
	}

	private function logic_reject_overtime($id, $overtime_id, $approver_id, $approver_name)
	{
		$loe = array('flag' => 3, 'approver_name' => $approver_name);
		$rejected = array('approval' => self::REJECTED, 'updated_by' => $id);

		$this->db->trans_begin();
		$no_assignment = $this->db->select('no_assignment')->from('overtimes')->where('id', $overtime_id)->get()->row()->no_assignment;
		$overtime_type = $this->db->get_where('approval_overtimes', array('overtime_id' => $overtime_id, 'approver_id' => $approver_id, 'flag' => self::WAITING_FOR_APPROVAL))->row()->overtime_type;

		// cancel all approval overtimes
		$this->db->where(array('overtime_id' => $overtime_id, 'overtime_type' => $overtime_type))->update('approval_overtimes', array('flag' => self::CANCELLED, 'approver_name' => $approver_name));

		// reject approval overtimes as approver
		$this->db->where(array('overtime_id' => $overtime_id, 'approver_id' => $approver_id, 'overtime_type' => $overtime_type))->update('approval_overtimes', $loe);

		$count_approver = $this->db->select('flag')->from('approval_overtimes')->where(array('overtime_id' => $overtime_id, 'overtime_type' => $overtime_type))->get()->result();
		
		foreach ($count_approver as $value) {
			if ($value->flag == self::REJECTED) {
				$this->db->where(array('id' => $overtime_id))->update('overtimes', $rejected);
				break;
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Pengajuan lembur gagal ditolak');
	        $this->db->trans_rollback();
	    } else {
			$this->session->set_flashdata('success', 'Pengajuan lembur berhasil ditolak');
	        $this->db->trans_commit();

	    	// email notification
			$sender = $this->db->select('e.name')->from('employees as e')->where(array('id' => $this->session->userdata('employee')))->get()->row();
			$receiver = $this->notifications->getReceiverData($approver_id)->row();
	    	$this->notifications->sendMailOvertimeApproval($receiver->email, $receiver->name, $sender->name, 'reject', $no_assignment);
	    }
	}

	public function create_overtime()
	{
		$requestor = $this->session->userdata('employee');
		$org_unit = $this->db->select('id, code')->from('organizations')->where_in('id', $this->session->userdata('org_unit'))->group_by('code')->get()->row();
		$year = date('Y');
		$number = $this->overtimes->getCounter($year, $org_unit->code)->row();
		$no_assignment = 'OVI-'.$org_unit->code.'-'.substr($year, 2).'-'.str_pad((int) $number->counter + 1, 4, '0', STR_PAD_LEFT);

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
		$employee_id = $this->input->post('employee_id');

		foreach ($employee_id as $emp) {
			$employee = $this->db->select('position_id')->from('employee_position')->where(array('employee_id' => $emp, 'flag' => TRUE))->group_by('position_id')->get()->row();

			$data = array(
				'requestor' => $requestor,
				'employee_id' => $emp,
				'no_assignment' => $no_assignment,
				'start' => $this->input->post('start'),
				'finish' => $this->input->post('finish'),
				'overtime_date' => date('Y-m-d', strtotime($this->input->post('overtime_date'))),
				'description' => $this->input->post('description'),
				'place' => $this->input->post('place'),
				'insidentil' => 0,
				'day_type' => $day_type,
				'created_by' => $requestor,
				'updated_by' => $requestor
			);
			
			$level_approver = 1;
			$level_type = array(1,2,3);			

			$this->db->insert('overtimes', $data);
			$overtime_id = $this->db->insert_id();
			
		    $child = $this->db->select('parent_id')->from('positions')->where('id', $employee->position_id)->get()->row();

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
						
						if (!in_array($value, $this->session->userdata('position'))) {
							$this->notifications->sendMailOvertimeToSupervisor($receiver->email, $receiver->name, $sender->name, tanggal(date('Y-m-d', strtotime($this->input->post('overtime_date')))), $no_assignment);
						}

						// notification to staf
						$receiver_staff = $this->notifications->getReceiverData($employee->position_id)->row();
						$this->notifications->sendMailOvertimeToStaff($receiver_staff->email, $receiver_staff->name, $sender->name, tanggal(date('Y-m-d', strtotime($this->input->post('overtime_date')))), $no_assignment);
					}

					$constraint++;				
				}
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Lembur gagal ditambah');
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Lembur berhasil ditambah');
	        $this->db->trans_commit();
	    }
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function approval_criteria_performance()
	{
		$performance_id = $this->input->post('performance');
		$approval = $this->input->post('approval');

		$this->db->trans_begin();

		if ($approval == 'approve') {
			$this->db->where('id', $performance_id)->update('performances', array('status_criteria' => self::APPROVED));
			$message = 'Kriteria penilaian telah disetujui';
		} else {
			$this->db->where('id', $performance_id)->update('performances', array('status_criteria' => self::REJECTED));
			$message = 'Kriteria penilaian telah ditolak';
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Kriteria penilaian gagal diproses');
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', $message);
	        $this->db->trans_commit();
	    }
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function approval_assessment()
	{
		$performance_id = $this->input->post('performance');
		$approval = $this->input->post('approval');

		if ($approval == 'approve') {
			$this->db->where('id', $performance_id)->update('performances', array('status_assessment' => self::APPROVED));
			$message = 'Penilaian pegawai telah disetujui';
		} else {			
			$this->db->where('id', $performance_id)->update('performances', array('status_assessment' => self::REJECTED));
			$message = 'Penilaian pegawai telah ditolak';
		}

		$this->db->trans_begin();

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Penilaian pegawai gagal diproses');
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', $message);
	        $this->db->trans_commit();
	    }
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function approval_timesheet()
	{
		$timesheet_id = $this->uri->segment(4);
		$approval = $this->input->get('approval');
		$employee = $this->db->select('name')->from('employees')->where('id', $this->session->userdata('employee'))->get()->row();

		if ($approval == 'approve') {
			$this->db->where('id', $timesheet_id)->update('timesheets', array('approval' => self::APPROVED, 'approver_name' => $employee->name));
			$message = 'Kegiatan harian telah disetujui';
		} else {			
			$this->db->where('id', $timesheet_id)->update('timesheets', array('approval' => self::REJECTED, 'approver_name' => $employee->name));
			$message = 'Kegiatan harian telah ditolak';
		}

		$this->db->trans_begin();

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Kegiatan harian gagal diproses');
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', $message);
	        $this->db->trans_commit();
	    }
		
		redirect($_SERVER['HTTP_REFERER']);
	}
}
