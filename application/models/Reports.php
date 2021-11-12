<?php

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Model 
{
	public function getAllEmployees($group = NULL, $status = NULL)
	{
		$this->db->select('t.name, t.religion, t.sex, t.phone, t.birthday, p.province, c.city, d.district, t.postal_code, t.address, t.latest_education, t.npwp, t.sid, t.email, t.marital_status');
		$this->db->from('employees as t');
		$this->db->join('employee_pt as ep', 't.id = ep.employee_id');
		$this->db->join('provinces as p', 'p.id = t.province_id');
		$this->db->join('cities as c', 'c.id = t.city_id');
		$this->db->join('districts as d', 'd.id = t.district_id');
		$this->db->order_by('t.id', 'ASC');

		if ($group) {
			$this->db->where('ep.group_id', $group);
		}

		if ($status) {
			$this->db->where('ep.flag', $status);
		}

		$query = $this->db->get();
		return $query;
	}

	public function getAllEmployeePt($group = NULL, $employee = NULL, $status = NULL)
	{
		$this->db->select('t.employee_id, t.nip, t.rfid, t.join_date, e.name, ug.name as group, p.position, o.org_unit, e.email');
		$this->db->from('employee_pt as t');
		$this->db->join('employees as e', 'e.id = t.employee_id');
		$this->db->join('user_group as ug', 'ug.id = t.group_id');
		$this->db->join('positions as p', 'p.id = t.position_id');
		$this->db->join('organizations as o', 'o.id = p.org_unit');
		$this->db->order_by('t.nip', 'ASC');

		if ($employee) {
			$this->db->where('t.employee_id', $employee);
		}

		if ($group) {
			$this->db->where('t.group_id', $group);
		}

		if ($status) {
			$this->db->where('t.flag', $status);
		}

		$query = $this->db->get();
		return $query;
	}

	public function getPresences($group = NULL, $start = NULL, $finish = NULL, $type = NULL, $id = NULL)
	{
		$this->db->select('ep.nip, e.name, t.date, t.checkin, t.checkout, t.duration, ps.status, lrp.temperature, lrp.condition, t.notes, lrp.notes as notes_condition, ug.name as group, pt.type');
		$this->db->from('log_presences as t');
		$this->db->join('employee_pt as ep', 'ep.employee_id = t.employee_id');
		$this->db->join('employees as e', 'ep.user_id = e.id');
		$this->db->join('user_group as ug', 'ug.id = ep.group_id');
		$this->db->join('presence_types as pt', 'pt.id = t.type');
		$this->db->join('presence_status as ps', 'ps.id = t.status');
		$this->db->join('log_remote_presences as lrp', 'lrp.presences_id = t.id', 'left');
		$this->db->order_by('ep.nip', 'ASC');

		if ($group) {
			$this->db->where('ep.group_id', $group);
		}

		if ($id) {
			$this->db->where('t.employee_id', $id);
		}

		if ($type) {
			$this->db->where('t.type', $type);
		}

		if ($start && $finish) {
			$this->db->where("t.date BETWEEN '$start' AND '$finish'", NULL, FALSE);
		}

		$query = $this->db->get();
		return $query;
	}
}