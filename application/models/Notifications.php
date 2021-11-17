<?php

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('mailer');
	}

	public function getReceiverData($position_id)
	{
		$this->db->select('e.name, e.email');
		$this->db->from('employee_position as ept');
		$this->db->join('employees as e', 'ept.employee_id = e.id');
		$this->db->where('ept.flag', TRUE);
		$this->db->where('ept.position_id', $position_id);

		$query = $this->db->get();
		return $query;
	}

	// overtime
	public function sendMailOvertimeToSupervisor($email, $receiver, $sender, $date, $no_assignment)
	{
		$mail = $this->db->get('email')->row();
		$url =  base_url().'employee/approve/overtime';
		$subject = '[HURRY-UP] '.$no_assignment.' - Permohonan persetujuan Penjadwalan Lembur';
		$content = '
					Dengan hormat Bpk/Ibu '.$receiver.', <br><br>
					'.$sender.' telah mengajukan staf untuk lembur pada tanggal '.$date.' dan menunggu persetujuan anda. <br>
					Mohon membuka pengajuan dengan mengetuk tautan berikut ini:  <a href="'.$url.'">HURRY-UP</a>
					<br>
					<br>
					Terima kasih.
					<br>
					<br>
					**** THIS MAIL IS AUTOMATICALLY GENERATED BY HURRY-UP SYSTEM ****
					<br>
					**** PLEASE DO NOT REPLY ****
				';

		$payload = array(
			'sender_name' => $mail->name,
			'sender_email' => $mail->email,
			'password' => $mail->password,
			'host' => $mail->host,
			'port' => $mail->port,
			'encryption' => $mail->encryption,
			'subject' => $subject,
			'receiver' => $email,
			'content' => $content
		);
		
		// $send = $this->mailer->sendEmail($payload);

		// if (!$send) {
		// 	$this->session->set_flashdata('error', 'Email pemberitahuan gagal dikirim');
		// }
	}

	public function sendMailOvertimeToStaff($email, $receiver, $sender, $date, $no_assignment)
	{
		$mail = $this->db->get('email')->row();
		$url =  base_url().'employee/overtime';
		$subject = '[HURRY-UP] '.$no_assignment.' - Penugasan Lembur';
		$content = '
					Halo '.$receiver.', <br><br>
					Anda dijadwalkan oleh '.$sender.' untuk Lembur pada tanggal '.$date.'. <br>
					Silakan melihat informasi detail dengan mengetuk tautan berikut ini: <a href="'.$url.'">HURRY-UP</a>
					<br>
					<br>
					Terima kasih.
					<br>
					<br>
					**** THIS MAIL IS AUTOMATICALLY GENERATED BY HURRY-UP SYSTEM ****
					<br>
					**** PLEASE DO NOT REPLY ****
				';

		$payload = array(
			'sender_name' => $mail->name,
			'sender_email' => $mail->email,
			'password' => $mail->password,
			'host' => $mail->host,
			'port' => $mail->port,
			'encryption' => $mail->encryption,
			'subject' => $subject,
			'receiver' => $email,
			'content' => $content
		);
		
		// $send = $this->mailer->sendEmail($payload);

		// if (!$send) {
		// 	$this->session->set_flashdata('error', 'Email pemberitahuan gagal dikirim');
		// }
	}

	public function sendMailOvertimeApproval($email, $receiver, $sender, $approval, $no_assignment)
	{
		$mail = $this->db->get('email')->row();
		$url =  base_url().'employee/overtime';
		$subject = '[HURRY-UP] '.$no_assignment.' - Persetujuan Laporan Lembur';
		$content = '
					Halo '.$receiver.', <br><br>
					Pengajuan lembur anda di'.$approval.' oleh '.$sender.'. <br>
					Silakan melihat informasi detail dengan mengetuk tautan berikut ini:  <a href="'.$url.'">HURRY-UP</a>
					<br>
					<br>
					Terima kasih.
					<br>
					<br>
					**** THIS MAIL IS AUTOMATICALLY GENERATED BY HURRY-UP SYSTEM ****
					<br>
					**** PLEASE DO NOT REPLY ****
				';

		$payload = array(
			'sender_name' => $mail->name,
			'sender_email' => $mail->email,
			'password' => $mail->password,
			'host' => $mail->host,
			'port' => $mail->port,
			'encryption' => $mail->encryption,
			'subject' => $subject,
			'receiver' => $email,
			'content' => $content
		);
		
		// $send = $this->mailer->sendEmail($payload);

		// if (!$send) {
		// 	$this->session->set_flashdata('error', 'Email pemberitahuan gagal dikirim');
		// }
	}

	public function sendMailOvertimeReported($email, $receiver, $sender, $date, $no_assignment)
	{
		$mail = $this->db->get('email')->row();
		$url =  base_url().'employee/team/overtime';
		$subject = '[HURRY-UP] '.$no_assignment.' - Permohonan Persetujuan Laporan Lembur';
		$content = '
					Halo '.$receiver.', <br><br>
					'.$sender.'  sudah membuat laporan lembur saya pada tanggal '.$date.', dan menunggu persetujuan. <br>
					Mohon membuka pengajuan dengan mengetuk tautan berikut ini: <a href="'.$url.'">HURRY-UP</a>
					<br>
					<br>
					Terima kasih.
					<br>
					<br>
					**** THIS MAIL IS AUTOMATICALLY GENERATED BY HURRY-UP SYSTEM ****
					<br>
					**** PLEASE DO NOT REPLY ****
				';

		$payload = array(
			'sender_name' => $mail->name,
			'sender_email' => $mail->email,
			'password' => $mail->password,
			'host' => $mail->host,
			'port' => $mail->port,
			'encryption' => $mail->encryption,
			'subject' => $subject,
			'receiver' => $email,
			'content' => $content
		);
		
		// $send = $this->mailer->sendEmail($payload);

		// if (!$send) {
		// 	$this->session->set_flashdata('error', 'Email pemberitahuan gagal dikirim');
		// }
	}

	public function sendMailOvertimeToHrd($email, $receiver, $sender, $date, $no_assignment)
	{
		$mail = $this->db->get('email')->row();
		$url =  base_url().'hrd/overtime/incentive';
		$subject = '[HURRY-UP] '.$no_assignment.' - Laporan Lembur';
		$content = '
					Halo '.$receiver.', <br><br>
					Laporan lembur untuk '.$sender.' pada tanggal '.$date.' telah disetujui. <br>
					Silakan melihat informasi detail dengan mengetuk tautan berikut ini: <a href="'.$url.'">HURRY-UP</a>
					<br>
					<br>
					Terima kasih.
					<br>
					<br>
					**** THIS MAIL IS AUTOMATICALLY GENERATED BY HURRY-UP SYSTEM ****
					<br>
					**** PLEASE DO NOT REPLY ****
				';

		$payload = array(
			'sender_name' => $mail->name,
			'sender_email' => $mail->email,
			'password' => $mail->password,
			'host' => $mail->host,
			'port' => $mail->port,
			'encryption' => $mail->encryption,
			'subject' => $subject,
			'receiver' => $email,
			'content' => $content
		);
		
		// $send = $this->mailer->sendEmail($payload);

		// if (!$send) {
		// 	$this->session->set_flashdata('error', 'Email pemberitahuan gagal dikirim');
		// }
	}


	// peformance appraisal
	public function sendMailPublishedPerformanceResultToEmployee($email, $receiver, $sender)
	{

	}

	public function sendMailPublishedPerformanceToEmployee()
	{

	}

	public function sendMailUpdatedPerformanceToEmployee()
	{

	}

	public function sendMailRejectedPerformanceToSupervisor()
	{

	}

	public function sendMailApprovedPerformanceToSupervisor()
	{
		
	}

	public function sendMailEmployeePromotion(){
		// $config = array(
		// 	'protocol'    => 'smtp',
		// 	'smtp_host'   => 'mail.universitaspertamina.ac.id',
		// 	'smtp_port'   => 587,
		// 	'smtp_user'   => 'hurryup@universitaspertamina.ac.id',
		// 	'smtp_pass'   => 'P4ssw0rd',
		// 	'emailtype'   => 'html',
		// 	'charset'     => 'iso-8859-1'
		// );

		// $this->load->library('email', $config);

		// $this->email->set_newline("\r\n");

		// $this->email->from('hurryup@universitaspertamina.ac.id', 'Hurry UP');
		// $this->email->to('milzam.khutomo@gmail.com');
		// $this->email->cc('milzamhutomo.social@gmail.com');
		// $this->email->bcc('105217013@student.universitaspertamina.ac.id');

		// $this->email->subject('Test Email');
		// $this->email->message('Lorem ipsum');

		// var_dump($this->email->send());

		$mail = $this->db->get('email')->row();
		$subject = '[HURRY-UP] - Pengangkatan Karyawan PKWT';
		$content = '
			Halo,
			<br>
			<br>
			Saat ini terdapat karyawan yang terikat dengan skema Perjanjian Kerja Waktu Tertentu (PKWT)
			yang telah bekerja selama 2 tahun pada 3 bulan sejak pemberitahuan ini dikirimkan.
			<br>
			Berikut adalah daftar karyawan tersebut:
			<br>
			<br>
			Terima kasih.
			<br>
			<br>
			***** THIS EMAIL IS GENERATED AUTOMATICALLY BY HURRY-UP SYSTEM *****
			<br>
			<br>
			***** PLEASE DO NOT REPLY *****
		';

		$payload = array(
			'sender_name'	=> $mail->name,
			'sender_email'	=> $mail->email,
			'password'		=> $mail->password,
			'host'			=> $mail->host,
			'port'			=> $mail->port,
			'encryption'	=> 'tls',
			'subject'		=> $subject,
			'receiver'		=> 'smtptester.up@gmail.com',
			'content'		=> $content
		);	

		$send = $this->mailer->sendEmail($payload);

		if (!$send) {
			$this->session->set_flashdata('error', 'Email pemberitahuan gagal dikirim');
		}

		log_message('debug', print_r($send, TRUE));
	}
}