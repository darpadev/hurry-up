<?php

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Employments extends CI_Model 
{
	public function getLeaveApprover($id)
	{
		$this->db->select('t.id, p1.position as child, p2.position as parent');
		$this->db->from('leave_approver as t');
		$this->db->join('positions as p1', 'p1.id = t.child_position');
		$this->db->join('positions as p2', 'p2.id = t.parent_position');
		$this->db->where('t.child_position', $id);

		$query = $this->db->get();
		return $query;
	}

	public function getOvertimeApprover($id)
	{
		$this->db->select('t.id, p1.position as child, p2.position as parent');
		$this->db->from('overtime_approver as t');
		$this->db->join('positions as p1', 'p1.id = t.child_position');
		$this->db->join('positions as p2', 'p2.id = t.parent_position');
		$this->db->where('t.child_position', $id);

		$query = $this->db->get();
		return $query;
	}

	public function searchEmployeeByFilter($group = NULL, $position = NULL, $org_unit = NULL, $status = NULL, $active_status = NULL)
	{
		$sql = "WITH RECURSIVE cte_org (id) AS (
				    SELECT id FROM organizations WHERE id = ? 
				    UNION ALL
				    SELECT o.id FROM organizations as o INNER JOIN cte_org ON o.parent_id = cte_org.id
				)
				SELECT * FROM cte_org";

		$tree = $this->db->query($sql, array($org_unit));

		foreach ($tree->result() as $value) {
			$child[] = $value->id;
		}

		$this->db->select('ep.employee_id, ep.user_id, ep.employee_id, e.name, o.org_unit, p.position, ug.name as group, ep.nip, ep.effective_date, es.status, eas.status as active_status');
		$this->db->from('employee_pt as ep');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ept.position_id');
		$this->db->join('organizations as o', 'o.id = p.org_unit');
		$this->db->join('user_group as ug', 'ug.id = ep.group_id');
		$this->db->join('employment_statuses as es', 'es.id = ep.status');
		$this->db->join('employment_active_statuses as eas', 'eas.id = ep.active_status', 'left');
		$this->db->where('ept.flag', 1);
		$this->db->group_by('ep.employee_id');
		$this->db->order_by('ep.nip', 'ASC');

		
		if ($org_unit) {
			$this->db->group_start();
			$this->db->where('p.org_unit', $org_unit);
			$this->db->or_where_in('o.parent_id', $child);
			$this->db->group_end();
		}

		if ($group) {
			$this->db->where('ep.group_id', $group);
		}

		if ($status) {
			$this->db->where('ep.status', $status);
		}

		if ($position) {
			$this->db->where('ept.position_id', $position);
		}

		if ($active_status) {
			$this->db->where('eas.id', $active_status);
		}

		$query = $this->db->get();
		return $query;
	}

	public function showEmployee($id)
	{
		$this->db->select('
			ep.employee_id, 
			e.province_id, 
			e.city_id, 
			e.district_id, 
			ep.join_date, 
			ep.nip, 
			ep.rfid, 
			e.name, 
			e.religion, 
			e.sex, 
			e.phone, 
			e.birthday, 
			pr.province, 
			c.city, 
			di.district, 
			e.postal_code, 
			e.address, 
			e.npwp, 
			e.sid, 
			e.email, 
			e.marital_status, 
			es.status,
			eas.status AS active_status, 
			e.photo, 
			e.image, 
			ep.group_id, 
			ep.work_agreement_status, 
			ep.bracket, 
			ep.effective_date,
			s.basic_salary,
			ep.nitk,
			ep.nidn,
			ep.nidk,
			ep.functional_position_id,
			fp.position AS functional_position
		');
		$this->db->from('employee_pt as ep');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('user_group as ug', 'ug.id = ep.group_id');
		$this->db->join('employment_statuses as es', 'es.id = ep.status');
		$this->db->join('employment_active_statuses as eas', 'eas.id = ep.active_status', 'left');
		$this->db->join('salary as s', 's.employee_id = ep.employee_id', 'left');
		$this->db->join('provinces as pr', 'pr.id = e.province_id', 'left');
		$this->db->join('cities as c', 'c.id = e.city_id', 'left');
		$this->db->join('districts as di', 'di.id = e.district_id', 'left');
		$this->db->join('functional_position as fp', 'fp.id = ep.functional_position_id', 'left');
		$this->db->where('ep.employee_id', $id);

		$query = $this->db->get();
		
		return $query;
	}

	public function showEmployeeOrgUnit($id)
	{
		$this->db->select('ept.id as ept_id, o.org_unit, p.position, o.id, ept.position_id');
		$this->db->from('organizations as o');
		$this->db->join('positions as p', 'p.org_unit = o.id');
		$this->db->join('employee_position as ept', 'ept.position_id = p.id');
		$this->db->join('employee_pt as ep', 'ep.employee_id = ept.employee_id');
		$this->db->where('ep.employee_id', $id);
		$this->db->where('ept.flag', TRUE);
		$this->db->group_by('o.org_unit');
		$this->db->order_by('o.id', 'ASC');

		$query = $this->db->get();
		return $query;
	}

	public function getPositionEmployee($employee_id)
	{
		$this->db->select('p.position, p.org_unit, o.org_unit as organization')->from('employee_position as ept');
        $this->db->join('employee_pt as ep', 'ep.employee_id = ept.employee_id');
        $this->db->join('positions as p', 'p.id = ept.position_id');
        $this->db->join('organizations as o', 'p.org_unit = o.id');
        $this->db->where('ept.flag', TRUE);
        $this->db->where_in('ept.employee_id', $employee_id);
        
		$query = $this->db->get();
		return $query;
	}

	public function getEmployeeByPosition($position, $employee)
	{
		$this->db->select('ep.employee_id, ep.nip, e.name, p.position');
		$this->db->from('employee_pt as ep');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'ept.position_id = p.id');
		$this->db->where('ept.flag', TRUE);
		$this->db->where('ept.position_id', $position);
		$this->db->where('ept.employee_id', $employee);

		$query = $this->db->get();
		return $query;
	}

	public function showEmployeeEducation($id)
	{
		$this->db->select('edu.level, edu.institution, edu.graduate');
		$this->db->from('educations as edu');
		$this->db->join('employees as e', 'e.id = edu.employee_id');
		$this->db->join('employee_pt as ep', 'ep.employee_id = e.id');
		$this->db->where('ep.employee_id', $id);
		$this->db->order_by('edu.id', 'ASC');

		$query = $this->db->get();
		return $query;
	}

	public function showEmployeeLeave($id, $start = NULL, $end = NULL, $approved = NULL)
	{
		$this->db->select('t.id, e.name, t.start, t.finish, lt.type, as.status, t.description, t.created_at');
		$this->db->from('leaves as t');
		// $this->db->join('list_leave_employees as lle', 'lle.leave_id = t.id'); // tidak berguna
		$this->db->join('employee_pt as ep', 'ep.employee_id = t.employee_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('leave_types as lt', 'lt.id = t.type');
		$this->db->join('approval_status as as', 'as.id = t.approval');
		$this->db->order_by('t.created_at', 'DESC');
		$this->db->where('ep.employee_id', $id);

		if ($approved) {
			$this->db->where('t.approval', $approved);
		}

		if ($start && $end) {
			$this->db->where("t.start BETWEEN '$start' AND '$end'", NULL, FALSE);
			$this->db->where("t.finish BETWEEN '$start' AND '$end'", NULL, FALSE);
		}

		$query = $this->db->get();
		// echo $this->db->last_query();die();	

		return $query;
	}

	public function getParentPosition($employee_id)
	{		
		$this->db->select('p.parent_id');
		$this->db->from('employee_position as ept');
		$this->db->join('positions as p', 'p.id = ept.position_id');
		$this->db->where('ept.flag', TRUE);
		$this->db->where('ept.employee_id', $employee_id);

		$query = $this->db->get();
		return $query;
	}

	public function getAllEmployeeActive()
	{
		$this->db->select('ep.employee_id, ep.nip, e.name');
		$this->db->from('employee_pt as ep');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->where('ep.status', self::ACTIVE);
		$this->db->or_where('ep.status', MY_Controller::CONTRACT);

		$query = $this->db->get();
		return $query;
	}

	public function getEmployeeNullPosition($status = NULL)
	{
		if ($status) {
			$status = " and ep.status = '".$status."'";
		}

		$query = $this->db->query('
			select 
				ep.employee_id, 
				ep.nip, 
				e.name, 
				ep.user_id
			from employee_pt as ep 
			join employees as e on e.id = ep.employee_id
			where ep.employee_id not in 
			(select employee_id from employee_position) '.$status.'
			group by ep.employee_id
		');
		
		return $query;
	}

	public function getEmployeePositionHistory($employee_id)
	{
		$query = $this->db->select('p.*, ept.start_date, ept.end_date')
		->from('positions as p')
		->join('employee_position as ept', 'ept.position_id = p.id')
		->where('ept.employee_id', $employee_id)
		->order_by('ept.start_date', 'ASC')
		->get();

		return $query;
	}

	// public function showEmployeeOvertime($id)
	// {		
	// 	$this->db->select('t.id, e.name, t.start, t.finish, t.place, as.status, t.description, t.created_at');
	// 	$this->db->from('overtimes as t');
	// 	$this->db->join('list_overtime_employees as loe', 'loe.overtime_id = t.id');
	// 	$this->db->join('employee_pt as ep', 'ep.employee_id = t.employee_id');
	// 	$this->db->join('employees as e', 'e.id = ep.employee_id');
	// 	$this->db->join('approval_status as as', 'as.id = t.approved');
	// 	$this->db->order_by('t.created_at', 'DESC');
	// 	$this->db->where('ep.employee_id', $id);

	// 	$query = $this->db->get();
	// 	return $query;
	// }

	public function showEmployeeAgreement($id){
		$this->db->select('id, name');
		$this->db->from('work_agreement_docs');		
		$this->db->where('employee_id', $id);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);

		$query = $this->db->get();

		return $query;
	}

	public function showAgreement($id){
		$this->db->select('name, doc_type, doc');
		$this->db->from('work_agreement_docs');		
		$this->db->where('id', $id);

		$query = $this->db->get();

		return $query;
	}

	public function getCurrentStatus($id){
		$this->db->select('status, active_status');
		$this->db->from('employee_pt');
		$this->db->where('employee_id', $id);

		$query = $this->db->get();
		
		return $query;
	}
}