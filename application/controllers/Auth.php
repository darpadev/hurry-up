<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

	}

	public function index()
	{
		$role = $this->session->userdata('role');

		if ($role == 1) {
			redirect('admin/home');
		} elseif ($role == 2){
			redirect('hrd/home');
		} elseif ($role == 3){
			redirect('employee/home');
		} else {			
			$this->load->view('login');
		}
	}

	public function auth()
	{
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[6]');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run()) {
        	$data = array(	
							'username' => $this->input->post('username', TRUE),
							'password' => md5($this->input->post('password', TRUE)
						)
			);

			$check = $this->authorization->check($data);
			
			if ($check->num_rows() && $check->row()->status != MY_Controller::RESIGN) {
				
				$data['id'] = $check->result()[0]->user_id;
				$data['employee'] = $check->result()[0]->employee_id;
				$data['username'] = $check->result()[0]->username;
				$data['role'] = $check->result()[0]->role_id;
				$data['group'] = $check->result()[0]->group_id;

				foreach ($check->result() as $res) {
					$data['position'][] = $res->position_id;
					$data['level'][] = $res->level;
					$data['org_unit'][] = $res->org_unit;
				}
				
				$this->session->set_userdata($data);	

				$this->db->update('users', array('last_login' => date('Y-m-d H:i:s')), array('id' => $check->result()[0]->user_id));

				$this->general->searchEmployeePromotion();
				$this->general->storeEmployeeAbsence();

				$role = $this->session->userdata('role');

				if ($role == 1) {
					redirect('admin/home');
				} elseif ($role == 2){
					redirect('hrd/home');
				} elseif ($role == 3){
					redirect('employee/home');
				} else {
					$this->authorization->guard();
				}
			} else {
				$this->session->set_flashdata('error', 'Username atau password Anda salah');				
	        	redirect($_SERVER['HTTP_REFERER']);
			}
        } else {
			$this->session->set_flashdata('error', 'Username atau password Anda salah');
        	redirect($_SERVER['HTTP_REFERER']);
        }
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth');
	}
}
