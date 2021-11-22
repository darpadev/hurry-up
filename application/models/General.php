<?php

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Model 
{
	public function searchEmployeeAbsence()
	{
		$i = 0;
		$arr = array();

		$employee = $this->db->select('*')->from('employee_pt')->where('status', 1)->get()->result();

		foreach ($employee as $emp) {
			$value = $this->db->select('ep.nip, e.name, e.id, t.date, ep.status')->from('log_presences as t')->join('employee_pt as ep', 'ep.employee_id = t.employee_id')->join('employees as e', 'e.id = ep.employee_id')->where('ep.nip', $emp->nip)->order_by('t.date ASC', 'ep.nip ASC')->get()->result();

			if ($value) {
				$dancug = end($value);

				$arr[$i]['id'] = $dancug->id;
				$arr[$i]['nip'] = $dancug->nip;
				$arr[$i]['date'] = $dancug->date;
				$arr[$i]['name'] = $dancug->name;
				$arr[$i]['status'] = $dancug->status;
			}
			$i++;
		}

		$mm = array();
		$j = 0;
		foreach ($arr as $key) {
			$date_1 = new DateTime($key['date']);
			$date_2 = new DateTime(date('Y-m-d'));

			$period = new DatePeriod($date_1, new DateInterval('P1D'), $date_2);

			$diff = date_diff($date_1, $date_2);

			$day = $diff->days;

			$holiday = $this->db->select('day_off')->from('holiday')->get()->result();

			$now = date('Y-m-d');
			for ($i=0; $i < $day; $i++) {
				$now = date('Y-m-d', strtotime(date('Y-m-d', strtotime($now)). " - 1 day"));

				foreach ($holiday as $hol) {
					if ($hol->day_off == $now) {
						$day--;
					}
				}
			}

			foreach ($period as $dt) {
				$curr = $dt->format('D');

				if ($curr == 'Sat' || $curr == 'Sun') {
			        $day--;
			    }
			}

			if (date('Y-m-d') > $key['date']) {
				if ($day >= 2) { // parameter tidak absen
					$mm[$j]['id'] = $key['id'];
					$mm[$j]['nip'] = $key['nip'];
					$mm[$j]['name'] = $key['name'];
					$mm[$j]['date'] = $key['date'];
					$mm[$j]['day'] = $day;
					$mm[$j]['status'] = $key['status'];
				}
			}
			$j++;
		}

		return $mm;
	}

	public function getFunctionalPosition()
	{
		$this->db->select('
			fp.id,
			fp.position,
			(select count(ep.employee_id) from employee_pt as ep where ep.functional_position_id = fp.id and ep.group_id = 2) as total
			')
		->from('functional_position as fp');

		return $this->db->get();
	}

	public function getLatestEducationLecture()
	{
		$this->db->select('
			ep.latest_education,
			(select count(ep2.employee_id) from employee_pt as ep2 where ep2.group_id = 2 and ep2.latest_education = ep.latest_education) as total
			')
		->from('employee_pt as ep')
		->group_by('ep.latest_education');

		return $this->db->get();
	}

	public function getParentPositions($parent_id = null, array &$parents = [])
	{
		if ($parent_id) {
			$this->db->select('parent_id');
		    $this->db->from('positions');
		    $this->db->where('id', $parent_id);
		    $child = $this->db->get()->row_array();

		    $parents[] = $parent_id;

		    if ($child['parent_id']) {
		    	$this->getParentPositions($child['parent_id'], $parents);
		    }
		}

		return $parents;
	}

	public function getChildrenPositions(array &$positions)
	{
		$childs = array();

		$sql = "WITH RECURSIVE cte_positions (id) AS (
				    SELECT id FROM positions WHERE id IN ? 
				    UNION ALL
				    SELECT p.id FROM positions as p INNER JOIN cte_positions ON p.parent_id = cte_positions.id
				)
				SELECT * FROM cte_positions";

		$tree = $this->db->query($sql, array($positions));

		foreach ($tree->result() as $value) {
			$childs[] = $value->id;
		}
		
		return $childs;
	}

	public function getChildrenOrganizations(array &$org_unit)
	{
		$childs = array();

		$sql = "WITH RECURSIVE cte_organizations (id) AS (
				    SELECT id FROM organizations WHERE id IN ? 
				    UNION ALL
				    SELECT o.id FROM organizations as o INNER JOIN cte_organizations ON o.parent_id = cte_organizations.id
				)
				SELECT * FROM cte_organizations";

		$tree = $this->db->query($sql, array($org_unit));

		foreach ($tree->result() as $value) {
			$childs[] = $value->id;
		}

		return $childs;
	}

	public function getSubordinatesByParent(array &$positions)
	{
		$this->db->select('ep.employee_id, ep.nip, e.name, p.position');
		$this->db->from('employee_pt as ep');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ept.position_id');
		$this->db->where('ept.flag', TRUE);
		$this->db->where_in('p.parent_id', $positions);
		$this->db->group_by('ep.employee_id');

		$query = $this->db->get();
		return $query;
	}

	public function getParentBySubodinate(array &$positions)
	{
		$this->db->select('ep.employee_id, ep.nip, e.name, p.position');
		$this->db->from('employee_pt as ep');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'ept.position_id = p.id');
		$this->db->where('ept.flag', TRUE);
		$this->db->where_in('p.id', $positions);

		$query = $this->db->get();
		return $query;
	}

	public function getSubordinates(array &$positions, $level = null, $employee_id = null, $org_unit = null)
	{
		$this->db->select('ep.employee_id, ep.nip, e.name, p.position');
		$this->db->from('employee_pt as ep');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'ept.position_id = p.id');
		// $this->db->join('organizations as o', 'o.id = p.org_unit');
		$this->db->where('ept.flag', TRUE);
		$this->db->where_in('p.id', $positions);

		if ($level) {			
			$this->db->where_in('p.level', $level);
		}

		if ($employee_id) {
			$this->db->where('ep.employee_id', $employee_id);
		}

		if ($org_unit) {
			$this->db->where('p.org_unit', $org_unit);
		}

		$this->db->group_by('ep.employee_id');

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function getSubordinateOrganizations(array &$org_unit)
	{
		$org = $this->getChildrenOrganizations($org_unit);

		$this->db->select('o.id, o.org_unit');
		$this->db->from('organizations as o');
		$this->db->join('users as u', 'u.id = o.updated_by');
		$this->db->join('org_types as ot', 'ot.id = o.type_id');
		$this->db->join('employee_pt as ep', 'ep.user_id = u.id');
		$this->db->join('employees as e', 'ep.employee_id = e.id');
		$this->db->where('o.is_active', TRUE);

		if ($org) {			
			$this->db->where_in('o.id', $org);
		}

		$this->db->order_by('o.org_unit', 'ASC');

		$query = $this->db->get();
		return $query;
	}

	public function getAllOrganizations($is_active = NULL, $org_unit = NULL, $type = NULL, $level = NULL)
	{
		// $org = $this->getChildrenOrganizations($org_unit);

		$this->db->select('o.id, o.org_unit, ot.type, o.level, e.name as created, o.is_active');
		$this->db->from('organizations as o');
		$this->db->join('users as u', 'u.id = o.updated_by');
		$this->db->join('org_types as ot', 'ot.id = o.type_id');
		$this->db->join('employee_pt as ep', 'ep.user_id = u.id');
		$this->db->join('employees as e', 'ep.employee_id = e.id');

		if ($is_active) {			
			$this->db->where('o.is_active', TRUE);
		} else {
			$this->db->where('o.is_active', FALSE);			
		}

		if ($org_unit) {			
			$this->db->where('o.id', $org_unit);
		}

		if ($type) {			
			$this->db->where('o.type_id', $type);
		}

		if ($level) {			
			$this->db->where('o.level', $level);
		}

		$this->db->order_by('o.level', 'ASC');
		$this->db->order_by('o.org_unit', 'ASC');
		$this->db->order_by('o.is_active', 'DESC');

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	public function getActiveOrganizations()
	{
		$this->db->select('o.id, o.org_unit, ot.type, e.name as created, o.is_active');
		$this->db->from('organizations as o');
		$this->db->join('users as u', 'u.id = o.updated_by');
		$this->db->join('org_types as ot', 'ot.id = o.type_id');
		$this->db->join('employee_pt as ep', 'ep.user_id = u.id');
		$this->db->join('employees as e', 'ep.employee_id = e.id');
		$this->db->where('o.is_active', TRUE);
		$this->db->order_by('o.org_unit', 'ASC');

		$query = $this->db->get();
		return $query;
	}

	public function getAllPositions($org_unit = NULL, $position = NULL, $is_active = NULL)
	{
		$this->db->select('t.id, t.position, t.is_active, d.org_unit, e.name as created, t.level');
		$this->db->from('positions as t');
		$this->db->join('users as u', 'u.id = t.updated_by');
		$this->db->join('employee_pt as ep', 'ep.user_id = u.id');
		$this->db->join('employees as e', 'ep.employee_id = e.id');
		$this->db->join('organizations as d', 'd.id = t.org_unit');

		if ($is_active) {
			$this->db->where('t.is_active', TRUE);
		} else {
			$this->db->where('t.is_active', FALSE);			
		}

		if ($org_unit) {			
			$this->db->where('d.id', $org_unit);
		}

		if ($position) {			
			$this->db->where('t.id', $position);
		}

		$this->db->order_by('t.level', 'ASC');

		$query = $this->db->get();
		return $query;
	} 

	public function getActivePositions()
	{
		$this->db->select('t.id, t.position, t.is_active, d.org_unit, e.name as created, t.level');
		$this->db->from('positions as t');
		$this->db->join('users as u', 'u.id = t.updated_by');
		$this->db->join('employee_pt as ep', 'ep.user_id = u.id');
		$this->db->join('employees as e', 'ep.employee_id = e.id');
		$this->db->join('organizations as d', 'd.id = t.org_unit');
		$this->db->where('t.is_active', TRUE);

		$this->db->order_by('t.level', 'ASC');

		$query = $this->db->get();
		return $query;
	} 

	public function getCoworker($org_unit = NULL, $level = NULL)
	{
		$this->db->select('ep.employee_id, ep.nip, e.name');
		$this->db->from('employee_pt as ep');
		$this->db->join('employees as e', 'ep.employee_id = e.id');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions as p', 'p.id = ept.position_id');
		$this->db->where('ep.employee_id !=', $this->session->userdata('employee'));

		if ($org_unit) {			
			$this->db->where_in('p.org_unit', $org_unit);
		}

		if ($level) {			
			$this->db->where_in('p.level', $level);
		}

		$this->db->order_by('ep.nip', 'ASC');
		$this->db->group_by('ep.employee_id');

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return $query;
	}

	/**
	 * 
	 * @author 			Hutomo, Mohammad Milzam Kasyfillah | milzam.khutomo@gmail.com
	 * @link			https://linktr.ee/m.hutomo
	 * 
	 */

	public function searchEmployeePromotion()
	{
		$this->load->model('notifications');

		// Search the employee(s) who still in contract and have working for at least 2 years
		$this->db->select('ep.employee_id, ep.join_date, ep.nip, e.name, p.parent_id');
		$this->db->from('employee_pt AS ep');
		$this->db->join('employees AS e', 'e.id = ep.employee_id');
		$this->db->join('employee_position AS ept', 'ept.employee_id = ep.employee_id');
		$this->db->join('positions AS p', 'p.id = ept.position_id');
		$this->db->where('ep.status', MY_Controller::CONTRACT);
		$this->db->where('p.level >', 4);

		
		$employee = $this->db->get()->result();
		
		$promotion = array();
		
		foreach ($employee as $value){
			if (date('Y-m-d', strtotime($value->join_date . '+2 years')) <= date('Y-m-d', strtotime('+3 months'))){
				array_push(
					$promotion, 
					array(
						'id' => $value->employee_id, 
						'position' => $value->parent_id, 
						'nip' => $value->nip, 
						'name' => $value->name
					)
				);
			}
		}

		// Search for HRD
		$this->db->select('e.name, l.user_id AS id');
		$this->db->from('login AS l');
		$this->db->join('employee_pt AS ep', 'ep.user_id = l.user_id');
		$this->db->join('employees AS e', 'e.id = ep.employee_id');
		$this->db->where('role_id', MY_Controller::HRD);

		$hrd = $this->db->get()->result();
		
		// Send information to HRD
		foreach ($hrd as $person){
			for ($i = 0; $i < count($promotion); $i++) {
				$data = array(
					'employee_id' 	=> $promotion[$i]['id'],
					'receiver'		=> $person->id
				);
				
				if ($this->db->get_where('employment_promotion', $data)->num_rows() > 0) continue;
				$this->db->insert('employment_promotion', $data);
				$this->notifications->sendMailEmployeePromotion($person->name, array('name' => $promotion[$i]['name'], 'nip' => $promotion[$i]['nip']));
			}
		}
		
		for ($i = 0; $i < count($promotion); $i++){
			// Search for direct-parent
			$this->db->select('e.name, users.id');
			$this->db->from('users');
			$this->db->join('employee_pt AS ep', 'ep.user_id = users.id');
			$this->db->join('employee_position AS ept', 'ept.employee_id = ep.employee_id');
			$this->db->join('employees AS e', 'e.id = ep.employee_id');
			$this->db->where('ept.position_id', $promotion[$i]['position']);
			
			$parent = $this->db->get()->result();

			foreach ($parent as $person) {
				$data = array(
					'employee_id'	=> $promotion[$i]['id'],
					'receiver'		=> $person->id
				);
				if ($this->db->get_where('employment_promotion', $data)->num_rows() > 0) continue;
				$this->db->insert('employment_promotion', $data);
				$this->notifications->sendMailEmployeePromotion($person->name, array('name' => $promotion[$i]['name'], 'nip' => $promotion[$i]['nip']));
			}

			// Search for top-level-parent
			$query = "	SELECT e.name, u.id
						FROM users AS u
						JOIN employee_pt AS ep
							ON ep.user_id = u.id
						JOIN employee_position AS ept
							ON ept.employee_id = ep.employee_id
						JOIN employees AS e
							ON e.id = ep.employee_id
						WHERE ept.position_id = (
							SELECT parent_id
							FROM positions
							WHERE org_unit = ? AND level < 5)";
			
			$parent = $this->db->query($query, array($promotion[$i]['position']))->result();			

			foreach ($parent as $person) {
				$data = array(
					'employee_id'	=> $promotion[$i]['id'],
					'receiver'		=> $person->id
				);
				if ($this->db->get_where('employment_promotion', $data)->num_rows() > 0) continue;
				$this->db->insert('employment_promotion', $data);
				$this->notifications->sendMailEmployeePromotion($person->name, array('name' => $promotion[$i]['name'], 'nip' => $promotion[$i]['nip']));
			}
		}
	}

	public function countEmployeePromotion()
	{
		$promotion = array();

		$this->db->select('e.name, ep.join_date');
		$this->db->from('employee_pt AS ep');
		$this->db->join('employees AS e', 'e.id = ep.employee_id');
		$this->db->join('employment_promotion AS prom', 'ep.employee_id = prom.employee_id');
		$this->db->where('prom.receiver', $this->session->userdata('id'));
		$this->db->where('prom.checked', FALSE);

		$employee = $this->db->get()->result();
		
		foreach ($employee as $value) {
			if(date('Y-m-d', strtotime($value->join_date . '+2 years')) <= date('Y-m-d', strtotime('+3 months'))){
				array_push($promotion, array('name' => $value->name));
			}		
		}
		
		return $promotion;
	}
			
	public function showEmployeePromotion()
	{
		$promotion = array();

		$this->db->select('ep.employee_id, e.name, ep.nip, ep.join_date');
		$this->db->from('employee_pt AS ep');
		$this->db->join('employees AS e', 'e.id = ep.employee_id');
		$this->db->join('employment_promotion AS prom', 'ep.employee_id = prom.employee_id');
		$this->db->where('prom.receiver', $this->session->userdata('id'));

		$employee = $this->db->get()->result();

		foreach ($employee as $value) {
			if(date('Y-m-d', strtotime($value->join_date . '+2 years')) <= date('Y-m-d', strtotime('+3 months'))){
				array_push($promotion, array('id' => $value->employee_id, 'name' => $value->name, 'join_date' => $value->join_date, 'nip' => $value->nip));
			}		
		}

		return $promotion;
	}

	public function storeEmployeeAbsence()
	{
		$employees = $this->searchEmployeeAbsence();

		// Search for HRD
		$this->db->select('e.name, l.user_id AS id');
		$this->db->from('login AS l');
		$this->db->join('employee_pt AS ep', 'ep.user_id = l.user_id');
		$this->db->join('employees AS e', 'e.id = ep.employee_id');
		$this->db->where('role_id', MY_Controller::HRD);

		$hrd = $this->db->get()->result();
		
		// Send information to HRD
		foreach ($hrd as $person){
			foreach ($employees as $employee){
				$data = array(
					'employee_id' 	=> $employee['id'],
					'receiver'		=> $person->id,
				);

				$stored = $this->db->get_where('employment_absences', $data);
				
				if ($stored->num_rows() > 0){
					if ($stored->row()->created_at == date('Y-m-d')) continue;
					else if ($stored->row()->created_at != date('Y-m-d')) {
						$value = array(
							'created_at'	=> date('Y-m-d'),
							'checked'		=> FALSE,
						);
						$this->db->set($value);
						$this->db->where('receiver', $this->session->userdata('id'));
						$this->db->update('employment_absences');
					}
				} else {
					array_push($data, array('created_at' => date('Y-m-d')));
					$this->db->insert('employment_absences', $data);
				}
			}
		}
	}

	public function countEmployeeAbsence()
	{
		$employees = $this->searchEmployeeAbsence();

		$absences = $this->db->get_where('employment_absences', array('checked' => FALSE, 'receiver' => $this->session->userdata('id')))->result();

		$value = array();

		foreach ($absences as $absence) {
			foreach ($employees as $employee) {
				if ($absence->employee_id == $employee['id']) {
					array_push($value, array('name' => $employee['name'], 'day' => $employee['day']));
					break;
				}
			}
		}

		return $value;
	}

	public function clearEmployeeAbsence()
	{
		$this->db->select('employee_id');
		$this->db->from('employee_pt');
		$this->db->join('users', 'users.id = employee_pt.user_id');
		$this->db->where('users.id', $this->session->userdata('id'));
		
		$id = $this->db->get()->row()->employee_id;

		$this->db->where('employee_id', $id);
		$this->db->delete('employment_absences');
	}
}