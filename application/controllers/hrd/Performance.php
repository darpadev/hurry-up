<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Performance extends MY_Controller
{
	protected $view = 'contents/hrd/performance/';
	protected $table_calendar = 'performance_appraisal_calendar';
	protected $table_activity = 'performance_appraisal_activity';
	protected $table_performance = 'performances';
	protected $table_assessment_standard = 'assessment_standard';
	protected $table_assessment_specific = 'assessment_specific';
	protected $table_peer_review = 'peer_review';
	protected $table_criteria_peer_review = 'criteria_peer_review';
	protected $table_assessment_peer_review = 'assessment_peer_review';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->hrd();
		$this->load->model('performances');
		$this->load->model('employees');
	}

	public function calendar()
	{
		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Kalender Penilaian Kinerja';
		$data['sub_title']	= '';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$data['data'] = $this->performances->searchCalendarPerformance();

		$this->load->view('includes/main', $data);
	}

	public function detail_calendar()
	{
		$calendar_id = $this->uri->segment(4);

		$data['content']	= $this->view.'detail_calendar';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Kinerja';
		$data['sub_title']	= 'Detail Kalender';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data']		= $this->performances->getDetailCalendar($calendar_id);

		$this->load->view('includes/main', $data);
	}

	public function store_calendar()
	{
		$id = $this->session->userdata('id');
		$data = array(
			'period' => $this->input->post('period'),
			'year' => $this->input->post('year'),
			'description' => $this->input->post('description'),
			'created_by' => $id,
			'updated_by' => $id
		);

		$insert = $this->db->insert('performance_appraisal_calendar', $data);

		if ($insert) {
			$this->session->set_flashdata('success', 'Kalender penilaian kinerja berhasil ditambah');
		} else {
			$this->session->set_flashdata('error', 'Kalender penilaian kinerja gagal ditambah');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function edit_calendar()
	{
		$data['content']   = $this->view.'edit';
	    $data['css']    = $this->view.'css';
	    $data['javascript']  = $this->view.'javascript';
	    $data['title']    = 'Penilaian Kinerja';
	    $data['sub_title']  = 'Ubah';
	    $data['notif']    = $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

	    $data['data']    = $this->db->select('pac.id, pac.description, pac.period, pac.year')->from('performance_appraisal_calendar as pac')
	                ->where('id', $this->uri->segment(4))->get()->row();
	    
	    $this->load->view('includes/main', $data);
	}

	public function update_calendar()
	{
		$data = array(
	      'description' => $this->input->post('description'),
	      'period' => $this->input->post('period'),
	      'year' => $this->input->post('year'),
	      'updated_by' => $this->session->userdata('id')
	    );

	    if($this->db->where('id', $this->uri->segment(4))->update($this->table, $data)){
	      $this->session->set_flashdata('success', 'Penilaian kinerja berhasil diubah');
	    } else{
	      $this->session->set_flashdata('error', 'Penilaian kinerja gagal diubah');
	    }

	    redirect('hrd/performance');
	}

	public function delete_calendar()
	{
		$id = $this->uri->segment(4);

		$this->db->trans_begin();
		try {
			if (
			$this->db->where('id', $id)->delete($this->table_calendar)
			) {
				$this->session->set_flashdata('success', 'Kalender penilaian kerja berhasil dihapus');
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

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	    } else {		    	
	        $this->db->trans_commit();
	    }

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function store_activity()
	{
		$this->db->trans_begin();

		try {			
			$data = array(
				'pac_id' => $this->input->post('pac_id'),
				'start' => date('Y-m-d', strtotime($this->input->post('start'))),
				'finish' => date('Y-m-d', strtotime($this->input->post('finish'))),
				'activity_type' => $this->input->post('activity')
			);

			$this->db->insert($this->table_activity, $data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Kegiatan kalender gagal ditambah');
	        $this->db->trans_rollback();
	    } else {
			$this->session->set_flashdata('success', 'Kegiatan kalender berhasil ditambah');
	        $this->db->trans_commit();
	    }

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function edit_activity($id)
	{
		$data['content']   = $this->view.'edit_activity';
	    $data['css']    = $this->view.'css';
	    $data['javascript']  = $this->view.'javascript';
	    $data['title']    = 'Detail Kalendar';
	    $data['sub_title']  = 'Ubah Detail Kalendar';
	    $data['notif']    = $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

	    $data['data']    = $this->db->select('paa.*, pat.type')->from('performance_appraisal_activity as paa')
	    ->join('performance_activity_types as pat', 'paa.activity_type = pat.id')
	                ->where('paa.id', $id)->get()->row();
	    
	    $this->load->view('includes/main', $data);
	}

	public function update_activity()
	{
		$id = $this->uri->segment(4);

		$this->db->trans_begin();
		try {
			$data = array(
		      'pac_id' => $this->input->post('pac_id'),
		      'activity_type' => $this->input->post('activity'),
		      'start' => date('Y-m-d', strtotime($this->input->post('start'))),
		      'finish' => date('Y-m-d', strtotime($this->input->post('finish')))
		    );

			$this->db->where('id', $id)->update($this->table_activity, $data);
		} catch (Exception $e) {			
			$this->session->set_flashdata('error', $e->getMessage());
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Detail kalendar gagal diubah');
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Detail kalendar berhasil diubah');
	        $this->db->trans_commit();
	    }

	    redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_activity()
	{
		$id = $this->uri->segment(4);

		$this->db->trans_begin();
		try {

			if (
			$this->db->where('id', $id)->delete($this->table_activity)
			) {
				$this->session->set_flashdata('success', 'Kegiatan berhasil dihapus');
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

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	    } else {		    	
	        $this->db->trans_commit();
	    }

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function assessment()
	{
		$data['content']	= $this->view.'assessment';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Kinerja Pegawai';
		$data['sub_title']	= '';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$employee = NULL;
		$org_unit = NULL;
		// $status = NULL;
		$year = NULL;
		$period = NULL;

		if (isset($_GET['employee']) && $_GET['employee'] != 'Semua') {
			$employee = $_GET['employee'];
		}

		// if (isset($_GET['status']) && $_GET['status'] != 'Semua') {
		// 	$status = $_GET['status'];
		// }

		if (isset($_GET['year']) && $_GET['year'] != 'Semua') {
			$year = $_GET['year'];
		} else {
			$year = date('Y');
			$_GET['year'] = $year;
		}

		if (isset($_GET['period']) && $_GET['period'] != 'Semua') {
			$period = $_GET['period'];
		}

		if (isset($_GET['org_unit']) && $_GET['org_unit'] != 'Semua') {
			$org_unit = $_GET['org_unit'];
		}

		$data['employee'] = $this->employees->getAllEmployeeActive();
		$data['organization'] = $this->general->getActiveOrganizations();

		$data['data'] = $this->performances->searchEmployeePerformances($employee, $org_unit, $year, $period);

		$this->load->view('includes/main', $data);
	}

	public function detail_assessment()
	{
		$id = $this->uri->segment(4);
		$year = $this->uri->segment(5);
		$employee_id = null;

		$data['content']	= $this->view.'performance_result';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Kinerja Pegawai';
		$data['sub_title']	= 'Hasil Penilaian Kinerja '.$year;
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$data['data'] = $this->performances->getPerformanceResult($id)->row();
		$data['specific'] = $this->performances->getPerformanceSpecific($id);

		// check employee sudah punya performances atau belum
		$hasScore = $this->db->select('pr.id')->from('performance_assessment_standard as pas')->join('performances as pr', 'pr.id = pas.performance_id')->where(array('pr.id' => $id, 'pr.employee_id' => $data['data']->employee_id))->get()->row();

		if ($hasScore) {
			$data['standard'] = $this->performances->getPerformanceStandard($data['data']->pac_id, $data['data']->employee_id);
		} else {			
			$data['standard'] = $this->performances->getEmptyPerformanceStandard($data['data']->pac_id);
		}

		$this->load->view('includes/main', $data);
	}

	public function assessment_standard()
	{
		$data['content']	= $this->view.'assessment_standard';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Kinerja Pegawai';
		$data['sub_title']	= 'Kriteria Kinerja Standar';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$year = NULL;

		if (isset($_GET['year']) && $_GET['year'] != 'Semua') {
			$year = $_GET['year'];
		}

		$data['data'] = $this->performances->searchAssessmentStandard($year);

		$this->load->view('includes/main', $data);
	}

	public function store_assessment_standard()
	{
		$user_id = $this->session->userdata('id');

		$year = $this->input->post('year');
		
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
			$pac_id =  $this->db->select('id')->from($this->table_calendar)->where(array('year' => $year))->group_by('year')->get()->row()->id;

			// insert kriteria
			for ($i=0; $i < count((array) $kra); $i++) {
				$data = array(
					'pac_id' => $pac_id,
					'kra' => $kra[$i],
					'kpi' => $kpi[$i],
					'criteria' => $criteria[$i],
					'status' => $status,
					'created_by' => $user_id,
					'updated_by' => $user_id
				);

				$this->db->insert($this->table_assessment_standard, $data);
			}

			// update kriteria
			for ($j=0; $j < count((array) $u_id); $j++) { 
				$data = array(
					'kra' => $u_kra[$j],
					'kpi' => $u_kpi[$j],
					'criteria' => $u_criteria[$j],
					'status' => $status,
					'updated_by' => $user_id
				);

				$this->db->where('id', $u_id[$j])->update($this->table_assessment_standard, $data);		
			}

			// delete kriteria
			foreach($diff as $d) {
				$this->db->delete($this->table_assessment_standard, array('id' => $d));	
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Penilaian kinerja standar gagal di '.$save);
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Penilaian kinerja standar berhasil di '.$save);
	        $this->db->trans_commit();
	    }

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function copy_assessment_period()
	{
		$user_id = $this->session->userdata('id');

		$period_to = $this->input->post('period_to');
		$period_from = $this->input->post('period_from');

		if ($period_to == $period_from) {			
			$this->session->set_flashdata('error', 'Tidak bisa menyalin KRA pada periode yang sama');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->trans_begin();
		try {
			$assessment = $this->performances->searchAssessmentStandard($period_from)->result();
			$pac = $this->db->select('id')->from($this->table_calendar)->where(array('year' => $period_to))->group_by('year')->get()->row();

			foreach ($assessment as $ass) {
				$data = array(
					'pac_id' => $pac->id,
					'kra' => $ass->kra,
					'kpi' => $ass->kpi,
					'criteria' => $ass->criteria,
					'status' => self::DRAFT,
					'created_by' => $user_id,
					'updated_by' => $user_id
				);

				$this->db->insert($this->table_assessment_standard, $data);				
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Penilaian kinerja standar gagal disalin');
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Penilaian kinerja standar berhasil disalin');
	        $this->db->trans_commit();
	    }

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function peer_review()
	{
		$data['content']	= $this->view.'peer_review';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Kinerja Sejawat';
		$data['sub_title']	= 'Kinerja Sejawat';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$employee = NULL;
		$org_unit = NULL;
		$year = NULL;

		if (isset($_GET['employee']) && $_GET['employee'] != 'Semua') {
			$employee = $_GET['employee'];
		}

		if (isset($_GET['year']) && $_GET['year'] != 'Semua') {
			$year = $_GET['year'];
		} else {
			$period_active = $this->db->get_where('period', array('flag' => TRUE))->row();
			$year = $period_active->year;
		}

		if (isset($_GET['org_unit']) && $_GET['org_unit'] != 'Semua') {
			$org_unit = $_GET['org_unit'];
		}

		$data['employee'] = $this->employees->getAllEmployeeActive();
		$data['organization'] = $this->general->getActiveOrganizations();

		$data['data'] = $this->performances->searchEmployeePeerReview($employee, $org_unit, $year);

		$this->load->view('includes/main', $data);
	}

	public function detail_peer_review()
	{
		$id = $this->uri->segment(4);
		$pac = $this->db->select('pac.id, pac.year, pr.employee_id')->from('peer_review as pr')->join('performance_appraisal_calendar as pac', 'pac.id = pr.pac_id')->where('pr.id', $id)->get()->row();

		$data['content']	= $this->view.'peer_review_result';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Kinerja Sejawat';
		$data['sub_title']	= 'Hasil Penilaian';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['calendar']	= $pac;
		$data['final_score']= $this->db->get_where('peer_review', array('id' => $id))->row();
		$data['data']		= $this->employees->showEmployee($pac->employee_id)->row();
		$data['reviewer']	= $this->performances->getReviewerPeerReview($id);
		$data['assessment'] = $this->performances->getAssessmentPeerReview($pac->id, $id);
		$data['average'] 	= $this->performances->getAssessmentPeerReviewByEmployee($pac->id, $id);

		$this->load->view('includes/main', $data);
	}

	public function assessment_peer_review()
	{
		$data['content']	= $this->view.'assessment_peer_review';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Kinerja Sejawat';
		$data['sub_title']	= 'Kriteria Kinerja Sejawat';
		$data['notif']		= $this->general->countEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();

		$year = NULL;

		if (isset($_GET['year']) && $_GET['year'] != 'Semua') {
			$year = $_GET['year'];
		}

		$data['data'] = $this->performances->searchAssessmentPeerReview($year);

		$this->load->view('includes/main', $data);
	}

	public function store_criteria_peer_review()
	{
		$user_id = $this->session->userdata('id');

		$year = $this->input->post('year');
		
		$save = $this->input->post('save');
		$kra = $this->input->post('kra');
		$sequence = $this->input->post('sequence');
		$criteria = $this->input->post('criteria');

		$check_id = $this->input->post('check_id');
		$u_id = $this->input->post('u_id');
		$u_kra = $this->input->post('u_kra');
		$u_sequence = $this->input->post('u_sequence');
		$u_criteria = $this->input->post('u_criteria');
		
		$diff = array_diff((array) $check_id, (array) $u_id);

		if ($save == 'publish') {
			$status = self::PUBLISHED;
		} else {
			$status = self::DRAFT;
		}

		$this->db->trans_begin();
		try {
			$pac_id =  $this->db->select('id')->from($this->table_calendar)->where(array('year' => $year))->group_by('year')->get()->row()->id;

			// insert kriteria
			for ($i=0; $i < count((array) $kra); $i++) {
				$data = array(
					'pac_id' => $pac_id,
					'kra' => $kra[$i],
					'sequence' => $sequence[$i],
					'criteria' => $criteria[$i],
					'status' => $status,
					'created_by' => $user_id,
					'updated_by' => $user_id
				);

				$this->db->insert($this->table_criteria_peer_review, $data);
			}

			// update kriteria
			for ($j=0; $j < count((array) $u_id); $j++) { 
				$data = array(
					'kra' => $u_kra[$j],
					'sequence' => $u_sequence[$j],
					'criteria' => $u_criteria[$j],
					'status' => $status,
					'updated_by' => $user_id
				);

				$this->db->where('id', $u_id[$j])->update($this->table_criteria_peer_review, $data);		
			}

			// delete kriteria
			foreach($diff as $d) {
				$this->db->delete($this->table_criteria_peer_review, array('id' => $d));	
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Kriteria kinerja sejawat gagal di '.$save);
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Kriteria kinerja sejawat berhasil di '.$save);
	        $this->db->trans_commit();
	    }

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function copy_criteria_peer_review_period()
	{
		$user_id = $this->session->userdata('id');

		$period_to = $this->input->post('period_to');
		$period_from = $this->input->post('period_from');

		if ($period_to == $period_from) {			
			$this->session->set_flashdata('error', 'Tidak bisa menyalin KRA pada periode yang sama');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->trans_begin();
		try {
			$assessment = $this->performances->searchAssessmentPeerReview($period_from)->result();
			$pac = $this->db->select('id')->from($this->table_calendar)->where(array('year' => $period_to))->group_by('year')->get()->row();

			foreach ($assessment as $ass) {
				$data = array(
					'pac_id' => $pac->id,
					'kra' => $ass->kra,
					'sequence' => $ass->sequence,
					'criteria' => $ass->criteria,
					'status' => self::DRAFT,
					'created_by' => $user_id,
					'updated_by' => $user_id
				);

				$this->db->insert($this->table_criteria_peer_review, $data);				
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Kriteria kinerja sejawat gagal disalin');
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Kriteria kinerja sejawat berhasil disalin');
	        $this->db->trans_commit();
	    }

		redirect($_SERVER['HTTP_REFERER']);
	}
}
