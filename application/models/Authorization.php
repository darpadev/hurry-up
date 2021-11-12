<?php

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Authorization extends CI_Model 
{
	public function guard()
	{
		if (empty($this->session->userdata('role'))) {
			$this->session->sess_destroy();
			redirect('auth');
		}
    }

    public function admin()
    {
    	if ($this->session->userdata('role') != self::ADMINISTRATOR) {
			$this->session->set_flashdata('error', 'Halaman tidak ditemukan');
			redirect($_SERVER['HTTP_REFERER']);
		}
    }

    public function hrd()
    {
    	if ($this->session->userdata('role') != self::HRD) {
			$this->session->set_flashdata('error', 'Halaman tidak ditemukan');
			redirect($_SERVER['HTTP_REFERER']);
		}
    }

    public function employee()
    {
    	if ($this->session->userdata('role') != self::EMPLOYEE) {
			$this->session->set_flashdata('error', 'Halaman tidak ditemukan');
			redirect($_SERVER['HTTP_REFERER']);
		}
    }
    
    public function check($data)
	{
		$this->db->select('t.user_id, ep.employee_id, t.role_id, u.username, ep.group_id, ep.status, ept.position_id, p.level, p.org_unit');
		$this->db->from('login as t');
		$this->db->join('users as u', 'u.id = t.user_id');
		$this->db->join('employee_pt as ep', 'u.id = ep.user_id');
		$this->db->join('employees as e', 'e.id = ep.employee_id');
		$this->db->join('roles as r', 'r.id = t.role_id');
		$this->db->join('employee_status as es', 'es.id = ep.status');
		$this->db->join('employee_position as ept', 'ept.employee_id = ep.employee_id', 'left');
		$this->db->join('positions as p', 'p.id = ept.position_id', 'left');
		$this->db->where('ept.flag', TRUE);
		$this->db->where('u.username', $data['username']);
		$this->db->where('u.password', $data['password']);
		$this->db->group_by('ept.position_id, p.level');

		$query = $this->db->get();	
		return $query;
	}

	public function getUser($id){
		$this->db->select('name, email');
		$this->db->from('employees');
		$this->db->where('id', $id);

		$query = $this->db->get();
		return $query->row();
	}

	public function countRole($id){
		$this->db->select('*');
		$this->db->from('login');
		$this->db->where('user_id', $id);

		$query = $this->db->get();
		return $query;
	}
}