<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Presence extends MY_Controller
{
	protected $view = 'contents/hrd/presence/';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->hrd();
		$this->load->model('presences');
	}

	public function index()
	{
		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Presensi';
		$data['sub_title']	= '';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$nip = NULL;
		$type = NULL;
		$group = NULL;
		$start = date('Y-m-d');
		$finish = date('Y-m-d');

		if (isset($_GET['nip']) && $_GET['nip'] != 'Semua') {
			$nip = $_GET['nip'];
		}

		if (isset($_GET['group']) && $_GET['group'] != 'Semua') {
			$group = $_GET['group'];
		}

		if (isset($_GET['type']) && $_GET['type'] != 'Semua') {
			$type = $_GET['type'];
		}

		if (isset($_GET['date'])) {
			$date = explode(' - ', $_GET['date']);
			$start = date('Y-m-d', strtotime($date[0]));
			if (isset($date[1])) {
				$finish = date('Y-m-d', strtotime($date[1]));
			}
		}

		$data['data'] = $this->presences->searchEmployeePresence($group, $nip, $type, $start, $finish);
		
		$this->load->view('includes/main', $data);
	}

	public function show()
	{
		$data['content']	= $this->view.'show';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Presensi';
		$data['sub_title']	= 'Detail';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data'] 		= $this->presences->showEmployeePresence($this->uri->segment(4))->row();
		
		$this->load->view('includes/main', $data);
	}

	public function store()
	{
		if ($this->db->select('id')->from('log_presences')->where('date', date('Y-m-d', strtotime($this->input->post('date'))))->get()->num_rows() > 0) {			
			$this->session->set_flashdata('error', 'Pegawai telah melakukan absen pada tanggal '.date('Y-m-d', strtotime($this->input->post('date'))));
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->trans_begin();

		$data = array(
			'employee_id' => $this->input->post('employee_id'),
			'date' => date('Y-m-d', strtotime($this->input->post('date'))),
			'checkin' => date('Y-m-d', strtotime($this->input->post('date')))." ".$this->input->post('checkin'),
			'checkout' => date('Y-m-d', strtotime($this->input->post('date')))." ".$this->input->post('checkout'),
			'status' => $this->input->post('status'),
			'type' => $this->input->post('type'),
			'notes' => $this->input->post('notes'),
			'updated_by' => $this->session->userdata('id')
		);

		$end = new DateTime($data['checkout']);
		$start = new DateTime($data['checkin']);

		$interval = $end->diff($start);
		$elapsed = $interval->format('%H:%i:%s');

		$data['duration'] = $elapsed;

		$this->db->insert('log_presences', $data);
		$presence_id = $this->db->insert_id();

		$remote = array(
			'presences_id' => $presence_id,
			'condition' => $this->input->post('condition'),
			'temperature' => $this->input->post('temperature'),
			'city' => $this->input->post('city'),
			'notes' => $this->input->post('health_records')
		);

		if ($presence_id) {
			$this->db->insert('log_remote_presences', $remote);
		} else {
			$error = $this->db->error();
			$this->session->set_flashdata('error', $error);
		}

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	    } else {
			$this->session->set_flashdata('success', 'Presensi pegawai berhasil ditambahkan');
	        $this->db->trans_commit();
	    }

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function edit()
	{
		$data['content']	= $this->view.'edit';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Presensi';
		$data['sub_title']	= 'Ubah';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$data['data'] 		= $this->presences->showEmployeePresence($this->uri->segment(4))->row();
		
		$this->load->view('includes/main', $data);
	}

	public function update()
	{
		$this->db->trans_begin();

		$data = array(
			'date' => date('Y-m-d', strtotime($this->input->post('date'))),
			'checkin' => date('Y-m-d', strtotime($this->input->post('date')))." ".$this->input->post('checkin'),
			'checkout' => date('Y-m-d', strtotime($this->input->post('date')))." ".$this->input->post('checkout'),
			'duration' => $this->input->post('duration'),
			'status' => $this->input->post('status'),
			'type' => $this->input->post('type'),
			'notes' => $this->input->post('notes'),
			'updated_by' => $this->session->userdata('id')
		);

		$end = new DateTime($data['checkout']);
		$start = new DateTime($data['checkin']);

		$interval = $end->diff($start);
		$elapsed = $interval->format('%H:%i:%s');

		$data['duration'] = $elapsed;

		$remote = array(
			'condition' => $this->input->post('condition'),
			'temperature' => $this->input->post('temperature'),
			'city' => $this->input->post('city'),
			'notes' => $this->input->post('health_records')
		);

		$this->db->where('id', $this->uri->segment(4))->update('log_presences', $data);
		$this->db->where('presences_id', $this->uri->segment(4))->update('log_remote_presences', $remote);

		if ($presence_id) {
			$this->db->insert('log_presences', $remote);
		} else {
			$error = $this->db->error();
			$this->session->set_flashdata('error', $error);
		}

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	    } else {
			$this->session->set_flashdata('success', 'Presensi pegawai berhasil diubah');
	        $this->db->trans_commit();
	    }

		redirect('/hrd/presence/show/'.$this->uri->segment(4));
	}

	public function delete()
	{
		try {	
			$this->db->trans_begin();

			if (
			$this->db->where('presences_id', $this->uri->segment(4))->delete('log_remote_presences') && 
			$this->db->where('id', $this->uri->segment(4))->delete('log_presences')
			) {
				$this->session->set_flashdata('success', 'Presensi pegawai berhasil dihapus');
			} else {
				$db_error = $this->db->error();
				if ($db_error) {
					throw new Exception('Database error! Error Number [' . $db_error['code'] . '] : ' . $db_error['message']);
					return false;
				}
			}

			if ($this->db->trans_status() === FALSE) {
		        $this->db->trans_rollback();
		    } else {		    	
		        $this->db->trans_commit();
		    }
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function absence()
	{
		$data['content']	= $this->view.'absence';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Presensi';
		$data['sub_title']	= 'Absensi';
		$data['notif'] 		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		
		$this->load->view('includes/main', $data);
	}
}
