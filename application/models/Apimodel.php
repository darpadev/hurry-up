<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @author          Burhan Mafazi | burhan.mafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

class Apimodel extends CI_Model
{
	function is_valid($username, $password){
		$this->db->select('u.id, ep.employee_id, e.name, u.username, u.password');
		$this->db->from('users as u');
		$this->db->join('employee_pt as ep', 'ep.user_id = u.id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->where(array('u.username' => $username, 'u.password' => $password));

		return $this->db->get();
	}

	function getAllDataMultiparam($table, $paramList, $paramValList)
	{
		$sql = "SELECT * FROM $table WHERE ";

		for ($i=0; $i <= count($paramList) - 1; $i++) { 
			$sql .= "$paramList[$i] = '$paramValList[$i]'";

			if ($i < count($paramList) - 1) {
				$sql .= " AND ";
			}
		}

		return $this->db->query($sql);
	}

	function getData($table, $param, $limit = '', $offset = '')
	{
		return $this->db->get_where($table, $param, $limit, $offset);
	}

	function deleteData($table, $id)
	{
		return $this->db->delete($table, array('id' => $id));
	}

	function postData($table, $data)
	{
		return $this->db->insert($table, $data);
	}

	function putData($table, $data, $id)
	{
		return $this->db->update($table, $data, array('id' => $id));
	}

	function getEmployee($id = NULL, $status = NULL)
	{
		$this->db->select('ep.employee_id, ep.nip, e.name, e.email');
		$this->db->from('employees as e');
		$this->db->join('employee_pt as ep', 'e.id = ep.employee_id');
		$this->db->order_by('ep.nip', 'ASC');

		if ($status) {
			$this->db->where('ep.status', $status);
		} else {
			$this->db->where('ep.status', self::ACTIVE);
		}

		if ($id) {
			$this->db->where('e.id', $id);
		}

		return $this->db->get();
	}

	function getEmployeePosition($id = null, $status = null)
	{
		$this->db->select('p.id, p.position')
		->from('employee_position as ept')
		->join('employee_pt as ep', 'ep.employee_id = ept.employee_id')
		->join('positions as p', 'p.id = ept.position_id');

		if ($id) {
			$this->db->where('ept.employee_id', $id);
		}

		return $this->db->get();
	}

	function getEmployeeAttendance($employee_id)
	{
		$this->db->select('ep.nip, e.name, lp.date, lp.checkin, lp.checkout, lp.duration, ps.status');
		$this->db->from('log_presences as lp');
		$this->db->join('employee_pt as ep', 'ep.employee_id = lp.employee_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('presence_status as ps', 'ps.id = lp.status');
		$this->db->order_by('lp.date', 'ASC');
		$this->db->where('ep.employee_id', $employee_id);

		return $this->db->get();
	}

	function getDataActivities($employee_id)
	{
		$this->db->select('t.id, t.date_on, t.activity, t.duration, t.feedback, t.weight, t.approver_name, a.status');
		$this->db->from('timesheets as t');
		$this->db->join('approval_status as a', 'a.id = t.approval');
		$this->db->where('t.employee_id', $employee_id);

		$query = $this->db->get();
		return $query;
	}

	function searchTimesheetSubodinates($position)
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
		
		return $this->db->get();
	}
}