<?php

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Timesheets extends CI_Model 
{
	public function getDataTupoksi($positions)
	{
		$this->db->select('*')->from('tupoksi')->where_in('position_id', $positions);

		$query = $this->db->get();
		return $query;
	}

	public function getDataTimesheet($employee, $start, $finish)
	{
		$this->db->select('t.*, a.status');
		$this->db->from('timesheets as t');
		$this->db->join('approval_status as a', 'a.id = t.approval');
		$this->db->where('employee_id', $employee);

		if ($start && $finish) {
			$this->db->where("date_on BETWEEN '$start' AND '$finish'", NULL, FALSE);
		}

		$query = $this->db->get();
		return $query;
	}

	public function searchTimesheetSubodinates($position = NULL, $approval = NULL, $start = NULL, $finish = NULL, $employee = NULL)
	{
		$subordinates = $this->general->getChildrenPositions($position);

		$this->db->select('t.id, e.name, ep.nip, t.activity, t.weight, t.duration, t.date_on, asu.status');
		$this->db->from('timesheets as t');
		$this->db->join('approval_status as asu', 'asu.id = t.approval');
		$this->db->join('employee_pt as ep', 'ep.employee_id = t.employee_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->where('ept.flag', TRUE);
		$this->db->order_by('t.employee_id', 'ASC');
		$this->db->order_by('t.date_on', 'DESC');

		$this->db->group_start();
		$this->db->or_where_in('ept.position_id', $subordinates);
		$this->db->where_in('t.approver_id', $position);
		$this->db->group_end();

		$this->db->group_by('t.id');

		if ($start && $finish) {
			$this->db->group_start();
			$this->db->where("t.date_on BETWEEN '$start' AND '$finish'", NULL, FALSE);
			$this->db->group_end();
		}

		if ($approval) {
			$this->db->where('t.approval', $approval);
		}

		if ($employee) {
			$this->db->where('ep.employee_id', $employee);
		}

		$query = $this->db->get();
		return $query;
	}
}