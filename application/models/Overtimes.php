<?php

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Overtimes extends CI_Model 
{
	public function getCounter($year, $code)
	{
		$this->db->select('COUNT(o.id) as counter');
		$this->db->from('overtimes as o');
		$this->db->join('employee_pt as ep', 'ep.employee_id = o.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ept.position_id');
		$this->db->join('organizations as or', 'or.id = p.org_unit');
		$this->db->where('YEAR(o.overtime_date)', $year);
		$this->db->where('or.code', $code);

		$query = $this->db->get();
		return $query;
	}

	public function searchOvertimeByFilter($start = NULL, $finish = NULL, $approval = NULL, $employee = NULL)
	{
		$this->db->select('t.id, t.no_assignment, e.name, t.start, t.finish, t.overtime_date, t.description, t.place, t.approval, as.status, t.insidentil');
		$this->db->from('overtimes as t');
		$this->db->join('employee_pt as ep', 'ep.employee_id = t.employee_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('approval_status as as', 'as.id = t.approval');
		$this->db->order_by('t.overtime_date', 'DESC');

		if ($employee) {
			$this->db->where('t.employee_id', $employee);
		}

		if ($approval) {
			$this->db->where('t.approval', $approval);
		}

		if ($start && $finish) {
			$this->db->group_start();
			$this->db->where("t.overtime_date BETWEEN '$start' AND '$finish'", NULL, FALSE);
			$this->db->group_end();
		}

		$query = $this->db->get();
		return $query;
	}

	public function searchIncentiveOvertimeByFilter($month = NULL, $year = NULL, $org_unit = NULL, $employee = NULL)
	{
		$this->db->select('
			ep.employee_id, 
			ep.nip, 
			e.name, 
			ep.bracket, 
			(select sec_to_time(sum(time_to_sec(ot.paid_hours))) from overtimes as ot where ot.employee_id = ep.employee_id and ot.approval = 6 and YEAR(ot.overtime_date) = '.$year.' and MONTH(ot.overtime_date) = '.$month.') as paid_hours,
			(select sum(ot.paid_overtime) from overtimes as ot where ot.employee_id = ep.employee_id and ot.approval = 6 and YEAR(ot.overtime_date) = '.$year.' and MONTH(ot.overtime_date) = '.$month.') as incentive
			');
		$this->db->from('employee_pt as ep');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'ept.position_id = p.id');
		$this->db->join('overtimes as o', 'ep.employee_id = o.employee_id');
		$this->db->where_in('p.level', array(6));
		$this->db->where('ept.flag', TRUE);
		$this->db->where('o.paid_hours !=', NULL);
		$this->db->group_by('employee_id');
		$this->db->order_by('ep.nip', 'ASC');

		if ($employee) {
			$this->db->where('ep.employee_id', $employee);
		}

		if ($org_unit) {
			$this->db->where('p.org_unit', $org_unit);
		}

		if ($year && $month) {
			$this->db->where('YEAR(o.overtime_date)', $year);
			$this->db->where('MONTH(o.overtime_date)', $month);
		}

		$query = $this->db->get();	
		return $query;
	}

	public function showApproverOvertimeByOvertimeId($id)
	{
		$this->db->select('t.id, p.position as approver, as.status, t.updated_at, ott.overtime_type');
		$this->db->from('approval_overtimes as t');
		$this->db->join('overtime_type as ott', 'ott.id = t.overtime_type');
		$this->db->join('overtimes as ot', 'ot.id = t.overtime_id');
		$this->db->join('approval_status as as', 'as.id = t.flag');
		$this->db->join('positions as p', 'p.id = t.approver_id');
		$this->db->where('t.overtime_id', $id);

		$this->db->order_by('t.id', 'ASC');

		$query = $this->db->get();
		return $query;
	}

	public function showEmployeeOvertime($id)
	{
		$this->db->select('t.id, t.no_assignment, t.employee_id, as.status, e2.name as requestor, t.overtime_date, e.name, t.start, t.finish, t.place, t.description');
		$this->db->from('overtimes as t');
		$this->db->join('employee_pt as ep', 'ep.employee_id = t.employee_id');
		$this->db->join('employees as e2', 'e2.id = t.requestor');
		$this->db->join('employees as e', 'ep.employee_id = e.id');
		$this->db->join('approval_status as as', 'as.id = t.approval');
		$this->db->where('t.id', $id);
		$this->db->order_by('t.overtime_date', 'DESC');

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function searchEmployeeByOvertimeApprover($approval = NULL, $start = NULL, $finish = NULL, $position = NULL, $type = NULL, $employee = NULL)
	{
		// $subordinates = $this->general->getChildrenPositions($position);

		$this->db->select('t.id, t.no_assignment, e.name, t.overtime_date, ep.nip, t.start, t.finish, t.description, t.place, asu.status, asu2.status as flag, ao.approver_id');
		$this->db->from('overtimes as t');
		$this->db->join('approval_status as asu', 'asu.id = t.approval');
		$this->db->join('employee_pt as ep', 'ep.employee_id = t.employee_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('approval_overtimes as ao', 'ao.overtime_id = t.id');
		$this->db->join('approval_status as asu2', 'asu2.id = ao.flag');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->where('ept.flag', TRUE);
		$this->db->order_by('t.id', 'ASC');

		$this->db->group_start();
		$this->db->where_in('ao.approver_id', $position);
		// $this->db->or_where_in('ept.position_id', $subordinates);
		$this->db->group_end();

		$this->db->group_by('t.id');

		if ($start && $finish) {
			$this->db->where("t.overtime_date BETWEEN '$start' AND '$finish'", NULL, FALSE);
		}

		if ($approval) {
			$this->db->where('ao.flag', $approval);
		}

		if ($employee) {
			$this->db->where('ep.employee_id', $employee);
		}

		if ($type) {
			$this->db->where('ao.overtime_type', $type);
		}

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function searchOvertimeSubodinates($approval = NULL, $start = NULL, $finish = NULL, $position = NULL, $type = NULL, $employee = NULL, $org_unit = NULL)
	{
		$subordinates = $this->general->getChildrenPositions($position);

		$this->db->select('t.id, t.no_assignment, e.name, t.overtime_date, ep.nip, t.start, t.finish, t.description, t.place, asu.status');
		$this->db->from('overtimes as t');
		$this->db->join('approval_status as asu', 'asu.id = t.approval');
		$this->db->join('employee_pt as ep', 'ep.employee_id = t.employee_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ept.position_id');
		$this->db->where('ept.flag', TRUE);
		$this->db->order_by('t.overtime_date', 'DESC');

		$this->db->group_start();
		$this->db->or_where_in('ept.position_id', $subordinates);
		$this->db->group_end();

		$this->db->group_by('t.id');

		if ($start && $finish) {
			$this->db->where("t.overtime_date BETWEEN '$start' AND '$finish'", NULL, FALSE);
		}

		if ($approval) {
			$this->db->where('t.approval', $approval);
		}

		if ($org_unit) {
			$this->db->where('p.org_unit', $org_unit);
		}

		if ($employee) {
			$this->db->where('ep.employee_id', $employee);
		}

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function searchEmployeeChart($employee = NULL, $start = NULL, $finish = NULL, $org_unit = NULL)
	{
		$org = $this->general->getChildrenOrganizations($org_unit);

		$this->db->select('o.actual_duration');
		$this->db->from('overtimes as o');
		$this->db->join('employee_position as ept', 'ept.employee_id = o.employee_id');
		$this->db->join('positions as p', 'ept.position_id = p.id');
		$this->db->where('ept.flag', TRUE);
		$this->db->where('o.approval', self::REPORTED);

		if ($start && $finish) {
			$this->db->where("o.overtime_date BETWEEN '$start' AND '$finish'", NULL, FALSE);
		}

		if ($org) {
			$this->db->where_in('p.org_unit', $org);
		}

		if ($employee) {
			$this->db->where('ept.employee_id', $employee);
		}

		$query = $this->db->get();
		return $query;
	}

	public function searchOrganizationChart($start = NULL, $finish = NULL, $org_unit = NULL)
	{
		$this->db->select('o.actual_duration');
		$this->db->from('overtimes as o');
		$this->db->join('employee_position as ept', 'ept.employee_id = o.employee_id');
		$this->db->join('positions as p', 'ept.position_id = p.id');
		$this->db->where('ept.flag', TRUE);
		$this->db->where('o.approval', self::REPORTED);

		if ($start && $finish) {
			$this->db->where("o.overtime_date BETWEEN '$start' AND '$finish'", NULL, FALSE);
		}

		if ($org_unit) {
			$this->db->where('p.org_unit', $org_unit);
		}

		$query = $this->db->get();
		return $query;
	}

	public function searchAnnualEmployeeChart($employee = NULL, $year = NULL, $month = NULL)
	{
		$this->db->select('o.actual_duration');
		$this->db->from('overtimes as o');
		$this->db->join('employee_position as ept', 'ept.employee_id = o.employee_id');
		$this->db->join('positions as p', 'ept.position_id = p.id');
		$this->db->where('ept.flag', TRUE);
		$this->db->where('o.approval', self::REPORTED);

		if ($year && $month) {
			$this->db->where('YEAR(o.overtime_date)', $year);
			$this->db->where('MONTH(o.overtime_date)', $month);
		}

		if ($employee) {
			$this->db->where('o.employee_id', $employee);
		}

		$query = $this->db->get();
		return $query;

	}

	public function searchAnnualOrganizationChart($org_unit = NULL, $year = NULL, $month = NULL)
	{
		$this->db->select('o.actual_duration');
		$this->db->from('overtimes as o');
		$this->db->join('employee_position as ept', 'ept.employee_id = o.employee_id');
		$this->db->join('positions as p', 'ept.position_id = p.id');
		$this->db->where('ept.flag', TRUE);
		$this->db->where('o.approval', self::REPORTED);

		if ($year && $month) {
			$this->db->where('YEAR(o.overtime_date)', $year);
			$this->db->where('MONTH(o.overtime_date)', $month);
		}

		if ($org_unit) {
			$this->db->where('p.org_unit', $org_unit);
		}

		$query = $this->db->get();
		return $query;

	}

	public function showReportOvertime($overtime_id)
	{
		$this->db->select('*');
		$this->db->from('overtime_reports as or');
		$this->db->where('overtime_id', $overtime_id);
		
		$query = $this->db->get();
		return $query;
	}

	public function showReportOvertimeByEmployee($employee_id, $year, $month)
	{
		$this->db->select('o.no_assignment, o.description, o.overtime_date, o.actual_duration, o.paid_hours, o.paid_overtime, o.day_type');
		$this->db->from('overtimes as o');
		// $this->db->join('overtime_day as od', 'od.id = o.day_type');
		$this->db->where('o.approval', self::REPORTED);
		$this->db->where('o.employee_id', $employee_id);
		$this->db->where('YEAR(o.overtime_date)', $year);
		$this->db->where('MONTH(o.overtime_date)', $month);		
		
		$query = $this->db->get();
		return $query;
	}
}