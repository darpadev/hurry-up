<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Home extends MY_Controller
{
	protected $view = 'contents/employee/';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->guard();
		$this->load->model('employees');
		$this->load->model('presences');
	}

	public function index()
	{
		$data['content']	= $this->view.'dashboard';
		$data['css']		= '';
		$data['javascript']	= $this->view.'javascript-absen';
		$data['title']		= 'Dashboard';
		$data['sub_title']	= 'Home';
		$data['message']	= '';
		$data['promotion']	= $this->general->countEmployeePromotion();

		$org_unit = NULL;
		$employee = NULL;
		$start = NULL;
		$finish = NULL;

		if (isset($_GET['org_unit']) && $_GET['org_unit'] != 'Semua') {
			$org_unit = $_GET['org_unit'];
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

		$finish = new DateTime($finish);
		$start = new DateTime($start);
		$interval = $finish->diff($start);

		$days = array();
		$periods = new DatePeriod(
		     $start,
		     new DateInterval('P1D'),
		     $finish
		);

		foreach ($periods as $date) {
			$days[] = $date->format('Y-m-d');
		}
		$days[] = $finish->format('Y-m-d');

		$data['total_days']	= $interval->days+1;
		$data['days']		= $days;
		$data['available']	= $this->presences->searchEmployeeAvailability($employee, $org_unit, $start, $finish);

		$this->load->view('includes/main', $data);
	}

	public function getDetailEmployee()
	{
		$employee_id = $_GET['employee_id'];
		$response = array();
		$supervisor = array();
		$org_unit = array();

		$response['employee'] = $this->db->select('ep.employee_id, ep.nip, e.name, e.email, ep.extension')
		->from('employees as e')
		->join('employee_pt as ep', 'ep.employee_id = e.id')
		->where(array('employee_id' => $employee_id))
		->get()
		->row();

		$positions = array();
		$parents = $this->employees->getParentPosition($employee_id)->result();
		foreach ($parents as $par) {
			$positions[] = $par->parent_id;
		}

		$supervisor = $this->db->select('e.id, e.name')
			->from('employees as e')
			->join('employee_pt as ep', 'ep.employee_id = e.id')
			->join('employee_position as ept', 'ept.employee_id = ep.employee_id')
			->join('positions as p', 'p.id = ept.position_id')
			->where_in('p.id', $positions)
			->group_by('ep.employee_id')
			->get();

		if ($supervisor) {
			$supervisor = $supervisor->result();
		}

		$org_unit = $this->employees->showEmployeeOrgUnit($employee_id);

		if ($org_unit) {
			$org_unit = $org_unit->result();
		}
			
		$response['supervisor'] = $supervisor;
		$response['org_unit'] = $org_unit;

		echo json_encode($response);
	}

	public function getDataOrgChart()
	{		
		$employee = $_GET['employee'];
		$position = $_GET['position'];
		$response = array();
		$sub = array();
		$par = array();

		if ($position) {
			$sub[] = $position;
		}

		$checkParent = $this->db->get_where('positions', array('id' => $position))->row();

		if ($checkParent) {
			$par[] = $checkParent->parent_id;
		}

		$parent = $this->general->getParentBySubodinate($par)->row();
		$subordinates = $this->general->getSubordinatesByParent($sub)->result();
		$employee = $this->employees->getEmployeeByPosition($position, $employee)->row();

		$response['parent'] = $parent;
		$response['employee'] = $employee;
		$response['subordinate'] = $subordinates;

		echo json_encode($response);
	}

	public function checkin()
	{
		if (!empty($this->session->userdata('role'))) {
			$role = $this->session->userdata('role');
			$employee = $this->session->userdata('employee');

			$data = new \stdClass();

			$emp = $this->db->select('employee_id')->from('employee_pt')->where('user_id', $this->session->userdata('id'))->get()->row();
			$data->employee_id = $emp->employee_id;
			$data->date = date('Y-m-d');	
			$data->checkin = date('Y-m-d H:i:s');
			$data->type = self::WFH;

			if (substr($data->checkin, 11) > '09:00:00') {
				$data->status = self::LATE;
			} else {
				$data->status = self::OK;
			}
			
			$keterangan = '';

	        $check = $this->db->select('id, employee_id, checkin, checkout')->from('log_presences')->where(array('employee_id' => $emp->employee_id, 'date' => date('Y-m-d')))->get()->row();

			if ($check) {
				$checkLoc = $this->db->get_where('log_remote_presences', array('lat_checkin' => NULL, 'presences_id' => $check->id))->row();

				if ($checkLoc) {
					for ($i=0; $i <= count((array) $this->input->post('notes')) - 1; $i++) { 
						$keterangan .= $this->input->post('notes')[$i];

						if ($i < count((array) $this->input->post('notes')) - 1) {
							$keterangan .= ", ";
						}
					}

					$this->db->update('log_remote_presences', array('city' => $this->input->post('city'), 'temperature' => $this->input->post('temperature'), 'condition' => $this->input->post('condition'), 'notes' => $keterangan, 'lat_checkin' => $this->session->userdata('latitude'), 'long_checkin' => $this->session->userdata('longitude')), array('presences_id' => $check->id));

					if ($this->session->userdata('latitude') != NULL) {
						if ($this->input->post('condition') == "Sakit") {
							$this->session->set_flashdata('success','Selamat datang, Anda telah melakukan checkin hari ini. Istirahat yang cukup dan lakukan physical distancing. Jika keluhan berlanjut segera periksakan diri ke fasilitas kesehatan terdekat.');
						} else {
							$this->session->set_flashdata('success','Selamat datang, Anda telah melakukan checkin hari ini. Stay safe and keep healthy!');
						}
					} else {
						$this->session->set_flashdata('error','Absensi gagal, harap menyalakan Location atau GPS pada browser atau perangkat Anda terlebih dahulu.');
					}					
				} else {
					$datang = new DateTime($check->checkin);
					$pulang = new DateTime(date('Y-m-d H:i:s'));
					$diff = $datang->diff($pulang);
					$durasi = str_pad($diff->h, 2, "0", STR_PAD_LEFT).':'.str_pad($diff->i, 2, "0", STR_PAD_LEFT).':'.str_pad($diff->s, 2, "0", STR_PAD_LEFT);
					
					$checkout = $this->apimodel->putData('log_presences', array('checkout' => date('Y-m-d H:i:s'), 'duration' => $durasi), $check->id);

					$this->db->update('log_remote_presences', array('lat_checkout' => $this->session->userdata('latitude'), 'long_checkout' => $this->session->userdata('longitude')), array('presences_id' => $check->id));

					if ($checkout) {		
						if ($this->input->post('condition') == "Sakit") {
							$this->session->set_flashdata('success','Selamat istirahat, Anda telah melakukan checkout hari ini. Istirahat yang cukup dan lakukan physical distancing. Jika keluhan berlanjut segera periksakan diri ke fasilitas kesehatan terdekat.');
						} else {
							$this->session->set_flashdata('success','Selamat istirahat, Anda telah melakukan checkout hari ini. Stay safe and keep healthy!');
						}
					}
				}				
			} else {
				$this->db->trans_begin();

				$checkin = $this->db->insert('log_presences', $data);
				$last_id = $this->db->insert_id();

				for ($i=0; $i <= count((array) $this->input->post('notes')) - 1; $i++) { 
					$keterangan .= $this->input->post('notes')[$i];

					if ($i < count((array) $this->input->post('notes')) - 1) {
						$keterangan .= ", ";
					}
				}

				$attr = new \stdClass();
				
				$attr->presences_id = $last_id;
				$attr->city = $this->input->post('city');
				$attr->temperature = $this->input->post('temperature');
				$attr->condition = $this->input->post('condition');
				$attr->notes = $keterangan;
				$attr->lat_checkin = $this->session->userdata('latitude');
				$attr->long_checkin = $this->session->userdata('longitude');

				$checkin_remote = $this->db->insert('log_remote_presences', $attr);

				if ($this->db->trans_status() === FALSE) {
				    $this->db->trans_rollback();
				} else {
				    $this->db->trans_commit();
				}

				if ($checkin_remote) {
					$checkLoc = $this->db->get_where('log_remote_presences', array('presences_id' => $last_id))->row();

					if ($checkLoc->lat_checkin == NULL) {
						$this->session->set_flashdata('error','Absensi gagal, harap menyalakan Location atau GPS pada browser atau perangkat Anda terlebih dahulu.');
					} else {
						if ($this->input->post('condition') == "Sakit") {
							$this->session->set_flashdata('success','Selamat datang, Anda telah melakukan checkin hari ini. Istirahat yang cukup dan lakukan physical distancing. Jika keluhan berlanjut segera periksakan diri ke fasilitas kesehatan terdekat.');
						} else {
							$this->session->set_flashdata('success','Selamat datang, Anda telah melakukan checkin hari ini. Stay safe and keep healthy!');
						}
					}															
				}
			}

			redirect($_SERVER['HTTP_REFERER']);
		} else {
			redirect('login');
		}
	}

	public function delete_timesheet()
	{
		$id = $this->uri->segment(4);

		try {
			if ($this->db->where('id', $id)->delete('timesheets')) {
				$this->session->set_flashdata('success', 'Kegiatan harian berhasil dihapus');
			} else {
				$db_error = $this->db->error();
				if ($db_error) {
					throw new Exception('Database error! Error Number [' . $db_error['code'] . '] : ' . $db_error['message']);
					return false;
				}
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function sess()
	{
		$this->session->set_userdata('latitude', $_GET['lat']);
		$this->session->set_userdata('longitude', $_GET['long']);
	}
}
