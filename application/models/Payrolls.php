<?php

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Payrolls extends CI_Model 
{
	public function searchEmployeeSalary($employee = NULL, $position = NULL, $status = NULL, $group = NULL, $work_agreement_status = NULL, $org_unit = NULL)
	{	
		$this->db->select('ep.employee_id, e.name, ep.nip, ep.work_agreement_status, ep.status, s.basic_salary');
		$this->db->from('employee_pt as ep');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ept.employee_id');
		$this->db->join('salary as s', 's.employee_id = ep.employee_id', 'left');
		$this->db->where('ept.flag', TRUE);
		$this->db->group_by('ep.employee_id');
		$this->db->order_by('ep.nip', 'ASC');

		if ($employee) {
			$this->db->where('ep.employee_id', $employee);
		}

		if ($status) {
			$this->db->where('ep.status', $status);
		}

		if ($position) {
			$this->db->where('ept.position_id', $position);
		}

		if ($group) {
			$this->db->where('ep.group_id', $group);			
		}

		if ($org_unit) {
			$this->db->where('p.org_unit', $org_unit);			
		}

		if ($work_agreement_status) {
			$this->db->where('ep.work_agreement_status', $work_agreement_status);
		}

		$query = $this->db->get();
		return $query;
	}
}