<?php

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Performances extends CI_Model 
{
	public function searchCalendarPerformance()
	{
		$this->db->select('pac.*');
		$this->db->from('performance_appraisal_calendar as pac');

		$query = $this->db->get();
		return $query;
	}

	public function getDetailCalendar($calendar_id)
	{
		$this->db->select('paa.id, paa.pac_id, pat.type as activity, paa.start, paa.finish');
		$this->db->from('performance_appraisal_activity as paa');
		$this->db->join('performance_activity_types as pat', 'paa.activity_type = pat.id');
		$this->db->where('paa.pac_id', $calendar_id);
		$this->db->order_by('paa.start', 'ASC');

		$query = $this->db->get();
		return $query;
	}

	public function valueDescription()
    {
        $this->db->select('paa.*');
        $this->db->from('performance_appraisal_activity as paa');
        $this->db->where('paa.pac_id', $this->uri->segment(4));

        $query = $this->db->get();
        return $query;
    }

	public function showActivity($type_id)
	{
		$this->db->select('paa.id, paa.pac_id, pat.type as activity, paa.start, paa.finish, paa.activity_type');
		$this->db->from('performance_appraisal_activity as paa');
		$this->db->join('performance_activity_types as pat', 'paa.activity_type = pat.id');
		$this->db->where('paa.activity_type', $type_id);

		$query = $this->db->get();
		return $query;
	}

	public function searchEmployeePerformances($employee = NULL, $org_unit = NULL, $year = NULL, $period = NULL)
	{
		$this->db->select('pr.id, pr.pac_id, ep.employee_id, ep.nip, e.name, pac.year, as.status as status_criteria, as2.status as status_assessment');
		$this->db->from('employee_pt as ep');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ept.position_id');
		$this->db->join('performances as pr', 'pr.employee_id = ep.employee_id');
		$this->db->join('period_types as pt', 'pt.id = pr.period_type');
		$this->db->join('performance_appraisal_calendar as pac', 'pac.id = pr.pac_id');
		$this->db->join('approval_status as as', 'as.id = pr.status_criteria');
		$this->db->join('approval_status as as2', 'as2.id = pr.status_assessment', 'left');
		$this->db->where('ep.status', self::ACTIVE);
		$this->db->group_by('ep.employee_id');
		$this->db->order_by('ep.nip', 'ASC');

		if ($employee) {
			$this->db->where('ep.employee_id', $employee);
		}

		if ($org_unit) {
			$this->db->where('p.org_unit', $org_unit);
		}

		if ($year) {
			$this->db->where('pac.year', $year);
		}

		if ($period) {
			$this->db->where('pr.period_type', $period);
		}

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function getPerformanceResult($id)
	{
		$this->db->select('ep.employee_id, pac.id as pac_id, pac.year, ep.nip, e.name, pr.assessor_name, as.status as status_criteria, as2.status as status_assessment, pr.final_score, pr.result, pr.recommendation');
		$this->db->from('performances as pr');
		$this->db->join('approval_status as as', 'as.id = pr.status_criteria');
		$this->db->join('approval_status as as2', 'as2.id = pr.status_assessment', 'left');
		$this->db->join('performance_appraisal_calendar as pac', 'pac.id = pr.pac_id');
		$this->db->join('employee_pt as ep', 'ep.employee_id = pr.employee_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ept.position_id');
		$this->db->where('pr.id', $id);

		$query = $this->db->get();
		return $query;
	}

	public function getPerformanceSpecific($id)
	{
		$this->db->select('asp.id, asp.kra, asp.kpi, asp.criteria, asp.score, asp.comment');
		$this->db->from('assessment_specific as asp');
		$this->db->join('performances as pr', 'pr.id = asp.performance_id');
		$this->db->where('pr.id', $id);

		$query = $this->db->get();
		return $query;
	}

	public function getPerformanceStandard($pac_id, $employee_id = NULL)
	{
		$this->db->select('pas.id, pr.id as performance_id, asd.id as standard_id, asd.kra, asd.kpi, asd.criteria, pas.score, pas.comment');
		$this->db->from('assessment_standard as asd');
		$this->db->join('performance_appraisal_calendar as pac', 'pac.id = asd.pac_id');
		$this->db->join('performance_assessment_standard as pas', 'pas.assessment_standard_id = asd.id', 'left');
		$this->db->join('performances as pr', 'pr.id = pas.performance_id', 'left');
		$this->db->join('approval_status as as', 'as.id = asd.status', 'left');
		$this->db->where('pac.id', $pac_id);
		$this->db->where('asd.status', self::PUBLISHED);

		if ($employee_id) {
			$this->db->where('pr.employee_id', $employee_id);
		}

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function getEmptyPerformanceStandard($pac_id)
	{
		$this->db->select('asd.id as standard_id, asd.kra, asd.kpi, asd.criteria');
		$this->db->from('assessment_standard as asd');
		$this->db->join('performance_appraisal_calendar as pac', 'pac.id = asd.pac_id');
		$this->db->where('pac.id', $pac_id);
		$this->db->where('asd.status', self::PUBLISHED);

		$query = $this->db->get();
		return $query;
	}

	public function searchAssessmentSpecifif($performance_id = NULL, $employee = NULL, $year = NULL)
	{
		$this->db->select('asp.id, pr.pac_id, asp.kra, asp.kpi, asp.criteria, pac.year');
		$this->db->from('assessment_specific as asp');
		$this->db->join('performances as pr', 'pr.id = asp.performance_id');
		$this->db->join('performance_appraisal_calendar as pac', 'pac.id = pr.pac_id');
		$this->db->join('approval_status as as', 'as.id = pr.status_criteria');
		$this->db->join('approval_status as as2', 'as2.id = pr.status_assessment', 'left');
		$this->db->join('period_types as pt', 'pt.id = pr.period_type');
		$this->db->join('employee_pt as ep', 'ep.employee_id = pr.employee_id');

		if ($performance_id) {			
			$this->db->where('pr.id', $performance_id);
		}

		if ($employee) {
			$this->db->where('ep.employee_id', $employee);
		}

		if ($year) {
			$this->db->where('pac.year', $year);			
		}

		$query = $this->db->get();
		return $query;
	}

	public function searchAssessmentStandard($year = NULL)
	{
		$this->db->select('asd.id, asd.pac_id, asd.kra, asd.kpi, asd.criteria, pac.year, asd.status, as.status as criteria_status');
		$this->db->from('assessment_standard as asd');
		$this->db->join('performance_appraisal_calendar as pac', 'pac.id = asd.pac_id');
		$this->db->join('approval_status as as', 'as.id = asd.status');

		if ($year) {
			$this->db->where('pac.year', $year);
		} else {
			$this->db->where('pac.year', date('Y'));
		}

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function searchEmployeeAssessmentBySupervisor($employee = NULL, $org_unit = NULL, $year = NULL, $period = NULL)
	{
		$this->db->select('pr.id, pr.pac_id, ep.employee_id, ep.nip, e.name, pac.year, as.status as status_criteria, as2.status as status_assessment, pt.type');
		$this->db->from('employee_pt as ep');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ept.position_id');
		$this->db->join('performances as pr', 'pr.employee_id = ep.employee_id');
		$this->db->join('period_types as pt', 'pt.id = pr.period_type');
		$this->db->join('performance_appraisal_calendar as pac', 'pac.id = pr.pac_id');
		$this->db->join('approval_status as as', 'as.id = pr.status_criteria');
		$this->db->join('approval_status as as2', 'as2.id = pr.status_assessment', 'left');
		$this->db->where('ep.status', self::ACTIVE);
		$this->db->group_by('ep.employee_id');
		$this->db->order_by('ep.nip', 'ASC');

		if ($employee) {
			$this->db->where('ep.employee_id', $employee);
		}

		if ($org_unit) {
			$this->db->where('p.org_unit', $org_unit);
		}

		if ($year) {
			$this->db->where('pac.year', $year);
		}

		if ($period) {
			$this->db->where('pr.period_type', $period);
		}

		$query = $this->db->get();
		return $query;
	}

	public function searchEmployeeAssessmentByEmployee($employee = NULL)
	{
		$this->db->select('pac.id, pac.description, pac.year, pac.period, pr.id as performance_id, as.status as status_criteria, as2.status as status_assessment');
		$this->db->from('performance_appraisal_calendar as pac');
		$this->db->join('performances as pr', 'pr.pac_id = pac.id');
		$this->db->join('employee_pt as ep', 'ep.employee_id = pr.employee_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ept.position_id');
		$this->db->join('period_types as pt', 'pt.id = pr.period_type');
		$this->db->join('approval_status as as', 'as.id = pr.status_criteria');
		$this->db->join('approval_status as as2', 'as2.id = pr.status_assessment', 'left');
		$this->db->where('ep.status', self::ACTIVE);
		$this->db->where('ept.flag', TRUE);
		// $this->db->where_in('as.status', array(self::PUBLISHED));
		// $this->db->group_by('ep.employee_id');
		$this->db->order_by('ep.nip', 'ASC');

		if ($employee) {
			$this->db->where('ep.employee_id', $employee);
		}

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function searchAssessmentPeerReview($year = NULL)
	{
		$this->db->select('cpr.id, cpr.pac_id, cpr.kra, cpr.criteria, pac.year, cpr.status, cpr.sequence, as.status as criteria_status');
		$this->db->from('criteria_peer_review as cpr');
		$this->db->join('performance_appraisal_calendar as pac', 'pac.id = cpr.pac_id');
		$this->db->join('approval_status as as', 'as.id = cpr.status');

		if ($year) {
			$this->db->where('pac.year', $year);
		} else {
			$this->db->where('pac.year', date('Y'));
		}

		$this->db->order_by('cpr.sequence', 'ASC');

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function searchPeerReviewByEmployee($employee = NULL)
	{
		$this->db->select('pac.id, pac.description, pac.year, pac.period, pr.id as peer_review_id, as.status as status_assessment, as2.status as status_reviewer');
		$this->db->from('performance_appraisal_calendar as pac');
		$this->db->join('peer_review as pr', 'pr.pac_id = pac.id');
		$this->db->join('employee_pt as ep', 'ep.employee_id = pr.employee_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ept.position_id');
		$this->db->join('approval_status as as', 'as.id = pr.status_assessment');
		$this->db->join('approval_status as as2', 'as2.id = pr.status_reviewer');
		$this->db->where('ep.status', self::ACTIVE);
		// $this->db->where_in('as.status', array(self::PUBLISHED));
		// $this->db->group_by('ep.employee_id');
		$this->db->order_by('ep.nip', 'ASC');

		if ($employee) {
			$this->db->where('ep.employee_id', $employee);
		}

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function getReviewerPeerReview($id)
	{
		$this->db->select('apr.id, pr.id as peer_review_id, ep.employee_id, e.name, ep.nip');
		$this->db->from('assessor_peer_review as apr');
		$this->db->join('peer_review as pr', 'pr.id = apr.peer_review_id');
		$this->db->join('employee_pt as ep', 'ep.employee_id = apr.assessor_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ept.position_id');
		$this->db->where('ept.flag', TRUE);
		$this->db->where('apr.peer_review_id', $id);

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function getAssessmentPeerReview($pac, $peer_review_id = NULL, $assessor_id = NULL)
	{
		$this->db->select('cpr.id as criteria_peer_review_id, apr.id as assessor_peer_review_id, atpr.id, cpr.kra, cpr.criteria, cpr.sequence, atpr.score, apr.status');
		$this->db->from('criteria_peer_review as cpr');
		$this->db->join('assessment_peer_review as atpr', 'atpr.criteria_peer_review_id = cpr.id', 'left');
		$this->db->join('assessor_peer_review as apr', 'apr.id = atpr.assessor_peer_review_id', 'left');
		$this->db->join('peer_review as pr', 'pr.id = apr.peer_review_id', 'left');
		$this->db->where('cpr.pac_id', $pac);

		if ($peer_review_id) {
			$this->db->where('pr.id', $peer_review_id);
		}

		if ($assessor_id) {
			$this->db->where('apr.assessor_id', $assessor_id);			
		}

		$this->db->order_by('cpr.sequence', 'ASC');

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function getAssessmentPeerReviewByEmployee($pac, $peer_review_id = NULL)
	{
		$this->db->select('cpr.id as criteria_peer_review_id, apr.id as assessor_peer_review_id, atpr.id, cpr.kra, cpr.criteria, cpr.sequence, COALESCE(ROUND(AVG(atpr.score), 2), 0) as score, apr.status');
		$this->db->from('criteria_peer_review as cpr');
		$this->db->join('assessment_peer_review as atpr', 'atpr.criteria_peer_review_id = cpr.id', 'left');
		$this->db->join('assessor_peer_review as apr', 'apr.id = atpr.assessor_peer_review_id', 'left');
		$this->db->join('peer_review as pr', 'pr.id = apr.peer_review_id', 'left');
		$this->db->where('cpr.pac_id', $pac);

		if ($peer_review_id) {
			$this->db->where('pr.id', $peer_review_id);
		}

		$this->db->order_by('cpr.sequence', 'ASC');
		$this->db->group_by('cpr.id');

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function createAssessmentPeerReview($pac)
	{
		$this->db->select('cpr.id as criteria_peer_review_id, cpr.kra, cpr.criteria, cpr.sequence');
		$this->db->from('criteria_peer_review as cpr');
		$this->db->where('cpr.pac_id', $pac);

		$this->db->order_by('cpr.sequence', 'ASC');

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function searchEmployeePeerReview($employee = NULL, $org_unit = NULL, $year = NULL)
	{
		$this->db->select('pr.id, pr.pac_id, ep.employee_id, ep.nip, e.name, pac.year, as.status as status_reviewer, as2.status as status_assessment');
		$this->db->from('employee_pt as ep');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ept.position_id');
		$this->db->join('peer_review as pr', 'pr.employee_id = ep.employee_id');
		$this->db->join('performance_appraisal_calendar as pac', 'pac.id = pr.pac_id');
		$this->db->join('approval_status as as', 'as.id = pr.status_reviewer');
		$this->db->join('approval_status as as2', 'as2.id = pr.status_assessment', 'left');
		$this->db->where('ep.status', self::ACTIVE);
		$this->db->group_by('ep.employee_id');
		$this->db->order_by('ep.nip', 'ASC');

		if ($employee) {
			$this->db->where('ep.employee_id', $employee);
		}

		if ($org_unit) {
			$this->db->where('p.org_unit', $org_unit);
		}

		if ($year) {
			$this->db->where('pac.year', $year);
		}

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}
}