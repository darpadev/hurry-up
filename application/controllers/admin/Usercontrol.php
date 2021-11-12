<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Usercontrol extends MY_Controller
{
	protected $view = 'contents/admin/users/';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->admin();		
	}

	public function index()
	{
		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Hak Akses';
		$data['sub_title']	= 'Pengguna';
		$data['role']		= $this->db->select('*')->from('roles')->get();
		$data['users']		= $this->db->select('t.id, e.name, es.status, t.last_login')->from('users as t')->join('employee_pt as ep', 'ep.user_id = t.id')->join('employees as e', 'e.id = ep.user_id')->join('employee_status as es', 'es.id = ep.status')->get();

		$this->load->view('includes/main', $data);
	}

	public function edit_role()
	{
		$data['content']	= $this->view.'edit_role';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Hak Akses';
		$data['sub_title']	= 'Pengguna';
		$data['data']		= $this->db->select('*')->from('roles')->where('id', $this->uri->segment(4))->get()->row();
		$data['users']		= $this->db->select('t.id, e.name, es.status, t.last_login')->from('users as t')->join('employee_pt as ep', 'ep.user_id = t.id')->join('employees as e', 'e.id = ep.user_id')->join('employee_status as es', 'es.id = ep.status')->get();

		$this->load->view('includes/main', $data);
	}

	public function update_role()
	{
		$data = array(
			'role' => $this->input->post('role')
		);

		if ($this->db->where('id', $this->uri->segment(4))->update('roles', $data)) {
			$this->session->set_flashdata('success','Peran berhasil diubah');
		} else {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		}

		redirect('/admin/usercontrol');
	}

	public function add_user_role()
	{
		$data['content']	= $this->view.'add_access';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Hak Akses';
		$data['sub_title']	= 'Tambah Peran';
		$data['role']		= $this->db->select('*')->from('roles')->get();
		$data['users']		= $this->db->select('t.id, l.id as login_id, r.role, e.name')->from('users as t')->join('login as l', 'l.user_id = t.id')->join('roles as r', 'r.id = l.role_id')->join('employee_pt as ep', 'ep.user_id = t.id')->join('employees as e', 'e.id = ep.user_id')->where('t.id', $this->uri->segment(4))->get();

		$this->load->view('includes/main', $data);
	}

	public function store_user_role()
	{
		$data = array(
			'user_id' => $this->uri->segment(4),
			'role_id' => $this->input->post('role_id'),
			'created_by' => $this->session->userdata('id')
		);

		$check = $this->db->select('id')->from('login')->where(array('user_id' => $data['user_id'], 'role_id' => $data['role_id']))->get()->row()->id;

		if (!$check) {
			$this->db->insert('login', $data);
			$this->session->set_flashdata('success','Peran pengguna berhasil ditambah');
		} else {
			$this->session->set_flashdata('error', 'Pengguna telah memiliki peran ini');
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_user_role()
	{
		if ($this->db->where('id', $this->uri->segment(4))->delete('login')) {
			$this->session->set_flashdata('success','Berhasil menghapus peran pengguna');
		} else {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete()
	{
		if ($this->db->where('user_id', $this->uri->segment(4))->delete('login') && $this->db->where('id', $this->uri->segment(4))->delete('users')) {
			$this->session->set_flashdata('success','Berhasil menghapus pengguna');
		} else {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function reset_password()
	{
		$id = $this->uri->segment(4);		

		if ($this->db->where('id', $id)->update('users', array('password' => md5($this->db->select('username')->from('users')->where('id', $id)->get()->row()->username)))) {

			$this->session->set_flashdata('success','Kata sandi berhasil disetel ulang');
		} else {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
}
