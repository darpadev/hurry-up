<?php

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Leaves extends CI_Model 
{
	public function searchLeaveByFilter($group = NULL, $start = NULL, $finish = NULL, $approval = NULL, $id = NULL)
	{
		$this->db->select('t.id, e.name, t.start, t.finish, lt.type, as.status, t.created_at, t.approval, t.description');
		$this->db->from('leaves as t');
		$this->db->join('employee_pt as ep', 'ep.employee_id = t.employee_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('leave_types as lt', 'lt.id = t.type');
		$this->db->join('approval_status as as', 'as.id = t.approval');
		$this->db->order_by('created_at', 'DESC');
		
		if ($id) {
			$this->db->where('t.employee_id', $id);
		}

		if ($group) {
			$this->db->where('ep.group_id', $group);
		}

		if ($start && $finish) {
			$this->db->group_start();
			$this->db->where("t.start BETWEEN '$start' AND '$finish'", NULL, FALSE);
			$this->db->where("t.finish BETWEEN '$start' AND '$finish'", NULL, FALSE);
			$this->db->group_end();
		}

		if ($approval) {
			$this->db->where('t.approval', $approval);
		}

		$query = $this->db->get();
		return $query;
	}

	public function showEmployeeLeaveByLeaveId($id)
	{
		$this->db->select('t.id, p.position as approver, as.status, t.updated_at');
		$this->db->from('approval_leaves as t');
		$this->db->join('leaves as l', 'l.id = t.leave_id');
		$this->db->join('approval_status as as', 'as.id = t.flag');
		$this->db->join('positions as p', 'p.id = t.approver_id');
		$this->db->where('t.leave_id', $id);
		$this->db->order_by('t.id', 'ASC');

		$query = $this->db->get();
		return $query;
	}

	public function showEmployeeLeave($id, $start = NULL, $end = NULL, $approved = NULL)
	{
		$this->db->select('l.id, ep.employee_id, e.name, l.start, l.finish, lt.type, l.description, as.status');
		$this->db->from('leaves as l');
		$this->db->join('approval_leaves as al', 'al.leave_id = l.id');
		$this->db->join('employee_pt as ep', 'ep.employee_id = l.employee_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('leave_types as lt', 'lt.id = l.type');
		$this->db->join('approval_status as as', 'as.id = l.approval');
		$this->db->where('al.leave_id', $id);

		$query = $this->db->get();
		return $query;
	}

	public function searchEmployeeByLeaveApprover($employee = NULL, $approval = NULL, $start = NULL, $finish = NULL, $position = NULL)
	{
		$this->db->select('l.id, e.name, ep.nip, l.start, l.finish, lt.type, l.description, asu.status, asu2.status as flag, al.approver_id');
		$this->db->from('leaves as l');
		$this->db->join('approval_status as asu', 'asu.id = l.approval');
		$this->db->join('employee_pt as ep', 'ep.employee_id = l.employee_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('leave_types as lt', 'lt.id = l.type');
		$this->db->join('approval_leaves as al', 'l.id = al.leave_id');
		$this->db->join('approval_status as asu2', 'asu2.id = al.flag');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->where('ept.flag', TRUE);
		$this->db->order_by('al.id', 'DESC');
		$this->db->where_in('al.approver_id', $position);
		$this->db->group_by('l.id');

		if ($start && $finish) {
			$this->db->group_start();
			$this->db->where("l.start BETWEEN '$start' AND '$finish'", NULL, FALSE);
			$this->db->where("l.finish BETWEEN '$start' AND '$finish'", NULL, FALSE);
			$this->db->group_end();
		}

		if ($approval) {
			$this->db->where('al.flag', $approval);
		}

		if ($employee) {
			$this->db->where('ep.employee_id', $employee);
		}

		$query = $this->db->get();

		// echo $this->db->last_query();die();
		return $query;
	}

	public function searchLeaveSubodinates($approval = NULL, $start = NULL, $finish = NULL, $position = NULL, $type = NULL, $employee = NULL)
	{
		$subordinates = $this->general->getChildrenPositions($position);

		$this->db->select('t.id, e.name, ep.nip, t.start, t.finish, t.description, asu.status, lt.type');
		$this->db->from('leaves as t');
		$this->db->join('approval_status as asu', 'asu.id = t.approval');
		$this->db->join('leave_types as lt', 'lt.id = t.type');
		$this->db->join('employee_pt as ep', 'ep.employee_id = t.employee_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->where('ept.flag', TRUE);
		$this->db->order_by('t.start', 'DESC');

		$this->db->group_start();
		$this->db->or_where_in('ept.position_id', $subordinates);
		$this->db->group_end();

		$this->db->group_by('t.id');

		if ($start && $finish) {
			$this->db->group_start();
			$this->db->where("t.start BETWEEN '$start' AND '$finish'", NULL, FALSE);
			$this->db->where("t.finish BETWEEN '$start' AND '$finish'", NULL, FALSE);
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