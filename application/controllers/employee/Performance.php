<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Performance extends MY_Controller
{
	protected $view = 'contents/employee/performance/';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->employee();
		$this->load->model('employees');
		$this->load->model('performances');
	}

	public function performance_appraisal()
	{
		$employee_id = $this->session->userdata('employee');

		$data['content']	= $this->view.'performance_appraisal';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Kinerja';
		$data['sub_title']	= '';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data']		= $this->performances->searchEmployeeAssessmentByEmployee($employee_id);
		// echo '<pre>';var_dump($data['data']->result());echo '</pre>';die();
		$this->load->view('includes/main', $data);
	}

	public function show_performance_appraisal()
	{
		$performance_id = $this->uri->segment(4);
		$employee_id = $this->session->userdata('employee');

		// check employee_id
		$performance = $this->db->get_where('performances', array('id' => $performance_id))->row();
		if ($employee_id != $performance->employee_id) {
			$this->session->set_flashdata('error', 'Hasil kinerja pegawai tidak ditemukan');
			redirect('employee/performance/performance_appraisal');
		}

		$data['content']	= $this->view.'show_performance_appraisal';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Kinerja';
		$data['sub_title']	= 'Hasil Penilaian';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['data'] = $this->performances->getPerformanceResult($performance_id)->row();
		$data['specific'] = $this->performances->getPerformanceSpecific($performance_id);

		// check employee sudah punya performances atau belum
		$hasScore = $this->db->select('pr.id')->from('performance_assessment_standard as pas')->join('performances as pr', 'pr.id = pas.performance_id')->where(array('pr.id' => $performance_id, 'pr.employee_id' => $employee_id))->get()->row();

		if ($hasScore) {
			$data['standard'] = $this->performances->getPerformanceStandard($data['data']->pac_id, $employee_id);
		} else {			
			$data['standard'] = $this->performances->getEmptyPerformanceStandard($data['data']->pac_id);
		}

		$this->load->view('includes/main', $data);
	}

	public function peer_review()
	{
		$employee_id = $this->session->userdata('employee');
		$period_active = $this->db->get_where('period', array('flag' => TRUE))->row();
		$pac = $this->db->get_where('performance_appraisal_calendar', array('year' => $period_active->year))->row();

		$data['content']	= $this->view.'peer_review';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Sejawat';
		$data['sub_title']	= '';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['calendar']	= $period_active;
		$data['data']		= $this->performances->searchPeerReviewByEmployee($employee_id);
		$data['request']    = $this->db->select('apr.id')
								->from('assessor_peer_review as apr')
								->join('peer_review as pr', 'pr.id = apr.peer_review_id')
								->where(array('apr.assessor_id' => $employee_id, 'pr.pac_id' => $pac->id, 'apr.status' => self::DRAFT,'pr.status_reviewer' => self::PUBLISHED))->get()->num_rows();

		$this->load->view('includes/main', $data);
	}

	public function edit_reviewer()
	{
		$id = $this->uri->segment(4);
		$employee_id = $this->session->userdata('employee');
		$level = $this->session->userdata('level');

		$data['content']	= $this->view.'edit_reviewer';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Sejawat';
		$data['sub_title']	= 'Ubah Penilai';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['coworkers']	= $this->general->getCoworker(NULL, $level);
		$data['data']		= $this->employees->showEmployee($employee_id)->row();
		$data['reviewer']	= $this->performances->getReviewerPeerReview($id);

		$this->load->view('includes/main', $data);
	}

	public function detail_peer_review()
	{
		$id = $this->uri->segment(4);
		$employee_id = $this->session->userdata('employee');
		$level = $this->session->userdata('level');

		$pac = $this->db->select('pac.id, pac.year')->from('peer_review as pr')->join('performance_appraisal_calendar as pac', 'pac.id = pr.pac_id')->where('pr.id', $id)->get()->row();

		$data['content']	= $this->view.'show_peer_review';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Sejawat';
		$data['sub_title']	= 'Hasil Penilaian';
		$data['calendar']	= $pac;
		$data['final_score']= $this->db->get_where('peer_review', array('id' => $id))->row();
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['coworkers']	= $this->general->getCoworker(NULL, $level);
		$data['data']		= $this->employees->showEmployee($employee_id)->row();
		$data['reviewer']	= $this->performances->getReviewerPeerReview($id);
		$data['assessment'] = $this->performances->getAssessmentPeerReviewByEmployee($pac->id, $id);

		$this->load->view('includes/main', $data);
	}

	public function assign_reviewer()
	{
		$period_active = $this->db->get_where('period', array('flag' => TRUE))->row();
		$condition = $this->db->select('pr.id')->from('peer_review as pr')->join('performance_appraisal_calendar as pac', 'pac.id = pr.pac_id')->where(array('pac.year' => $period_active->year, 'pr.employee_id' => $this->session->userdata('employee')))->get()->row();

		if ($condition) {
			$this->session->set_flashdata('error', 'Tidak dapat membuat permintaan penilaian karena daftar penilai telah di daftarkan sebelumnya');
		    redirect('employee/performance/peer_review');
		}

		$employee_id = $this->session->userdata('employee');
		$org_unit = $this->session->userdata('org_unit');
		$level = $this->session->userdata('level');

		$data['content']	= $this->view.'assign_reviewer';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Sejawat';
		$data['sub_title']	= 'Pilih Rekan Sejawat';
		$data['calendar']	= $this->db->get_where('period', array('flag' => TRUE))->row();
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['coworkers']	= $this->general->getCoworker(NULL, $level);
		$data['data']		= $this->employees->showEmployee($employee_id)->row();

		$this->load->view('includes/main', $data);
	}

	public function store_reviewer()
	{		
		$period_active = $this->db->get_where('period', array('flag' => TRUE))->row();
		$year = $period_active->year;
		$peer_review_id = NULL;
		$employee = $this->session->userdata('employee');
		$submit = $this->input->post('save');

		$u_id = $this->input->post('u_id');
		$u_assessor = array_filter((array) $this->input->post('u_assessor'));
		$assessor = array_filter((array) $this->input->post('assessor'));

		if ($submit == 'save') {
			$status = self::DRAFT;
		} else {
			$status = self::PUBLISHED;
		}

		$merge = array_filter(array_merge((array) $assessor, (array) $u_assessor));

		// check duplicate employee
		if (count(array_unique($merge)) != count((array) $merge)) {
			$this->session->set_flashdata('error', 'Permintaan penilaian kinerja tidak diperbolehkan dengan penilai yang sama');
		    redirect($_SERVER['HTTP_REFERER']);
		}

		// check jumlah assessor
		if ($status == self::PUBLISHED) {
			if (count((array) $merge) != 3) {
				$this->session->set_flashdata('error', 'Permintaan penilaian kinerja harus berjumlah 3 penilai dengan level yang sama');
			    redirect($_SERVER['HTTP_REFERER']);
			}
		}

		$this->db->trans_begin();

		try {
			$pac_id =  $this->db->select('id')->from('performance_appraisal_calendar')->where(array('year' => $year))->group_by('year')->get()->row();

			if (!$pac_id) {
				$this->session->set_flashdata('error', 'Kalender kinerja pada periode '.$year.' belum dibuka');
			    redirect($_SERVER['HTTP_REFERER']);
			}

			$dataPeerReview = array(
				'status_reviewer' => $status,
				'status_assessment' => self::DRAFT,
				'pac_id' => $pac_id->id,
				'employee_id' => $employee,
			);

			$check = $this->db->select('pr.id')->from('peer_review as pr')->where(array('employee_id' => $employee, 'pac_id' => $pac_id->id))->get()->row();

			if (!$check->id) {
				$this->db->insert('peer_review', $dataPeerReview);
				$peer_review_id = $this->db->insert_id();
			} else {
				$this->db->where('id', $check->id)->update('peer_review', $dataPeerReview);
				$peer_review_id = $check->id;
			}

			// insert penilai
			for ($i=0; $i < count((array) $assessor); $i++) {
				$dataAssessor = array(
					'peer_review_id' => $peer_review_id,
					'assessor_id' => $assessor[$i],
					'status' => self::DRAFT
				);			

				$this->db->insert('assessor_peer_review', $dataAssessor);
			}

			// update penilai
			for ($j=0; $j < count((array) $u_assessor); $j++) {
				$dataAssessor = array(
					'assessor_id' => $u_assessor[$j]
				);	

				$this->db->where('id', $u_id[$j])->update('assessor_peer_review', $dataAssessor);
			}

			// send notifikasi
			if ($status == self::PUBLISHED) {
				
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Permintaan penilaian kinerja gagal di '.$submit);
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Permintaan penilaian kinerja berhasil di '.$submit);
	        $this->db->trans_commit();
	    }

	    if ($status == self::PUBLISHED) {
			redirect('employee/performance/peer_review');
	    } else {
	    	redirect($_SERVER['HTTP_REFERER']);
	    }
	}

	public function request_assessment()
	{
		$employee_id = $this->session->userdata('employee');
		$period_active = $this->db->get_where('period', array('flag' => TRUE))->row();
		$pac = $this->db->get_where('performance_appraisal_calendar', array('year' => $period_active->year))->row();
		$level = $this->session->userdata('level');

		$data['content']	= $this->view.'request_assessment';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Sejawat';
		$data['sub_title']	= 'Permintaan Penilaian';
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['coworkers']	= $this->general->getCoworker(NULL, $level);
		$data['data']		= $this->employees->showEmployee($employee_id)->row();
		$data['requestor']  = $this->db->select('pr.id, apr.id as assessor_peer_review_id, pr.status_assessment, ep.employee_id, ep.nip, e.name')
								->from('assessor_peer_review as apr')
								->join('peer_review as pr', 'pr.id = apr.peer_review_id')
								->join('employee_pt as ep', 'ep.employee_id = pr.employee_id')
								->join('employees as e', 'e.id = ep.employee_id')
								->where(array('apr.assessor_id' => $employee_id, 'apr.status' => self::DRAFT, 'pr.status_reviewer' => self::PUBLISHED, 'pr.pac_id' => $pac->id))->get();

		$this->load->view('includes/main', $data);
	}

	public function assessment_peer_review()
	{
		$id = $this->uri->segment(4);
		$assessor_peer_review_id = $this->uri->segment(5);
		$employee_id = $this->session->userdata('employee');
		$level = $this->session->userdata('level');

		$pac = $this->db->select('pac.id, pac.year')->from('peer_review as pr')->join('performance_appraisal_calendar as pac', 'pac.id = pr.pac_id')->where('pr.id', $id)->get()->row();

		$data['content']	= $this->view.'assessment_peer_review';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Penilaian Sejawat';
		$data['sub_title']	= 'Permintaan Penilaian';
		$data['calendar']	= $pac;
		$data['peer_review']= $this->db->get_where('peer_review', array('id' => $id))->row();
		$data['notif']		= $this->general->searchEmployeeAbsence();
		$data['promotion']	= $this->general->countEmployeePromotion();
		$data['coworkers']	= $this->general->getCoworker(NULL, $level);
		$data['data']		= $this->employees->showEmployee($employee_id)->row();
		$data['u_assessment'] = $this->performances->getAssessmentPeerReview($pac->id, $id, $employee_id);
		$data['assessment'] = $this->performances->createAssessmentPeerReview($pac->id, $id);

		$this->load->view('includes/main', $data);
	}

	public function store_assessment_peer_review()
	{
		$peer_review_id = $this->input->post('peer_review_id');
		$assessor_peer_review_id = $this->input->post('assessor_peer_review_id');
		$submit = $this->input->post('submit');

		$u_id = $this->input->post('u_id');
		$u_score = $this->input->post('u_score');

		$criteria_peer_review_id = $this->input->post('criteria_peer_review_id');
		$score = $this->input->post('score');

		if ($submit == 'save') {
			$status = self::DRAFT;
		} else {
			$status = self::PUBLISHED;
		}

		$this->db->trans_begin();
		try {
			// insert penilaian
			for ($i=0; $i < count((array) $score); $i++) { 
				$data = array(
					'assessor_peer_review_id' => $assessor_peer_review_id,
					'criteria_peer_review_id' => $criteria_peer_review_id[$i],
					'score' => $score[$i]
				);

				$this->db->insert('assessment_peer_review', $data);
			}

			// update penilaian
			for ($j=0; $j < count((array) $u_id) ; $j++) { 
				$data = array(
					'score' => $u_score[$j]
				);

				$this->db->where(array('id' => $u_id[$j]))->update('assessment_peer_review', $data);
			}

			// update status penilai
			$this->db->where(array('id' => $assessor_peer_review_id))->update('assessor_peer_review', array('status' => $status));

			$param = array();
			$count_assessor = $this->db->get_where('assessor_peer_review', array('peer_review_id' => $peer_review_id));
			foreach ($count_assessor->result() as $value) {
				array_push($param, $value->status);
			}

			if (count(array_keys($param, self::PUBLISHED)) == count($param)) {
				$this->db->where(array('id' => $peer_review_id))->update('peer_review', array('status_assessment' => self::PUBLISHED));
			}

			// hitung final score
			$final_score = 0;
			// $assessment = $this->db->select('COALESCE(SUM(atpr.score), 0) as score')->from('assessment_peer_review as atpr')->join('assessor_peer_review as apr', 'apr.id = atpr.assessor_peer_review_id')->where(array('apr.peer_review_id' => $peer_review_id))->group_by('assessor_peer_review_id')->get();

			// foreach ($assessment->result() as $ass) {
			// 	$final_score = $final_score + $ass->score;
			// }

			// $final_score = $final_score / $assessment->num_rows();
			$assessment = $this->db->select('COALESCE(ROUND(AVG(atpr.score), 2), 0) as score')
			->from('assessment_peer_review as atpr')
			->join('criteria_peer_review as cpr', 'atpr.criteria_peer_review_id = cpr.id')
			->join('assessor_peer_review as apr', 'apr.id = atpr.assessor_peer_review_id')
			->where(array('apr.peer_review_id' => $peer_review_id))
			->group_by('atpr.assessor_peer_review_id, cpr.id')
			->get();

			foreach ($assessment->result() as $ass) {
				$final_score = $final_score + $ass->score;
			}

			// catatan penting!
			// nantinya final_score di peer review di kalikan 0,20 kemudian ditambahkan final_score di performance appraisal
			$final_score = $final_score / $assessment->num_rows();

			$this->db->where(array('id' => $peer_review_id))->update('peer_review', array('final_score' => $final_score));

			// send email notification
			if ($status == self::PUBLISHED) {

			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect($_SERVER['HTTP_REFERER']);
		}

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Penilaian kinerja sejawat gagal di '.$submit);
	        $this->db->trans_rollback();
	    } else {
	    	$this->session->set_flashdata('success', 'Penilaian kinerja sejawat berhasil di '.$submit);
	        $this->db->trans_commit();
	    }

		if ($status == self::DRAFT) {
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			redirect('employee/performance/peer_review');
		}
	}
}
