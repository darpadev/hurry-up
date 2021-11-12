<?php

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Presences extends CI_Model 
{
	public function searchEmployeePresence($group = NULL, $nip = NULL, $type = NULL, $start = NULL, $finish = NULL)
	{
		$this->db->select('t.id, t.date, t.checkin, t.notes, t.checkout, t.duration, ps.status, e.name, lrp.condition, ep.nip, lrp.temperature');
		$this->db->from('log_presences as t');
		$this->db->join('log_remote_presences as lrp', 'lrp.presences_id = t.id', 'left');
		$this->db->join('employee_pt as ep', 'ep.employee_id = t.employee_id');
		$this->db->join('employees as e', 'ep.employee_id = e.id');
		$this->db->join('users as u', 'u.id = t.updated_by', 'left');
		$this->db->join('presence_status as ps', 'ps.id = t.status');
		$this->db->join('presence_types as pt', 'pt.id = t.type', 'left');
		$this->db->order_by('date', 'ASC');
		$this->db->order_by('checkin', 'ASC');

		if ($group) {
			$this->db->where('ep.group_id', $group);
		}

		if ($nip) {
			$this->db->where('ep.nip', $nip);
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

	public function showEmployeePresence($id)
	{
		$this->db->select('t.id, t.date, t.checkin, t.checkout, t.duration, t.status as status_id, ps.status, e.name, t.notes, lrp.condition, lrp.notes as health_records, gc.id as city_id, gc.city, lrp.lat_checkin, lrp.long_checkin, lrp.lat_checkout, lrp.long_checkout, ep.nip, ep.employee_id as emp_id, e.name, t.type, gc.latitude as lat_city, gc.longitude as long_city, pt.type as type_presence, lrp.temperature');
		$this->db->from('log_presences as t');
		$this->db->join('log_remote_presences as lrp', 'lrp.presences_id = t.id', 'left');
		$this->db->join('employee_pt as ep', 'ep.employee_id = t.employee_id');
		$this->db->join('employees as e', 'ep.employee_id = e.id');
		$this->db->join('presence_status as ps', 'ps.id = t.status');
		$this->db->join('presence_types as pt', 'pt.id = t.type','left');
		$this->db->join('geo_cities as gc', 'gc.id = lrp.city', 'left');
		$this->db->where('t.id', $id);

		$query = $this->db->get();
		return $query;
	}

	public function searchEmployeeAvailability($employee = NULL, $org_unit = NULL, $start = NULL, $finish = NULL)
	{
		$this->db->select('ep.employee_id, e.name, ep.nip, e.email');
		$this->db->from('employees as e');
		$this->db->join('employee_pt as ep', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ept.position_id');
		$this->db->where('ep.status', self::ACTIVE);
		$this->db->where('ept.flag', TRUE);

		if ($employee) {
			$this->db->where('ep.employee_id', $employee_id);
		}

		if ($org_unit) {
			$this->db->where('p.org_unit', $org_unit);
		}

		$this->db->order_by('ep.nip', 'ASC');
		$this->db->group_by('ep.employee_id');

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}
}