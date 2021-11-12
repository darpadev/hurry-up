<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Setting extends MY_Controller
{
	const UPLOAD_PATH = './assets/images/contents';
	protected $view = 'contents/admin/settings/';

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
		$data['title']		= 'Pengaturan';
		$data['sub_title']	= '';
		$data['profile']	= $this->db->select('*')->from('company')->get()->row();
		$data['mail']		= $this->db->select('*')->from('email')->get()->row();

		$this->load->view('includes/main', $data);
	}

	public function update_profile()
	{
		$data = array(
			'name' => $this->input->post('company'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'address' => $this->input->post('address'),
			'website' => $this->input->post('website')
		);

		if(!empty($_FILES['logo']['name'])){
			$config['upload_path']		= self::UPLOAD_PATH;
			$config['allowed_types']	= 'jpg|jpeg|png';
			$config['max_size']			= '1024';
			$config['overwrite']		= false;
			$config['file_name']		= $this->input->post('logo');

			$this->upload->initialize($config);

			if($this->upload->do_upload('logo')){
				$upload = $this->upload->data();

				$data['logo'] = $upload['file_name'];
			}
		}

		if ($this->db->where('id', $this->uri->segment(4))->update('company', $data)) {
			$this->session->set_flashdata('success','Profil perusahaan berhasil diubah');
		} else {
			$this->session->set_flashdata('error','Profil perusahaan gagal diubah');
		}

		redirect('admin/setting');
	}

	public function update_mail()
	{
		$data = array(
			'name' => $this->input->post('name'),
			'host' => $this->input->post('host'),
			'port' => $this->input->post('port'),
			'driver' => $this->input->post('driver'),
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),
			'encryption' => $this->input->post('encryption'),
			'updated_by' => $this->session->userdata('id')
		);

		if ($this->db->where('id', $this->uri->segment(4))->update('email', $data)) {
			$this->session->set_flashdata('success','Pengaturan email berhasil diubah');
		} else {
			$this->session->set_flashdata('error','Pengaturan email gagal diubah');
		}

		redirect('admin/setting');
	}
}
