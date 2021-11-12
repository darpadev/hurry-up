<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    protected $_ci;

    public function __construct(){
        $this->_ci = &get_instance();
        require_once(APPPATH.'third_party/phpmailer/Exception.php');
        require_once(APPPATH.'third_party/phpmailer/PHPMailer.php');
        require_once(APPPATH.'third_party/phpmailer/SMTP.php');
    }

    public function sendEmail($data){
        $returnValue = null;
        
        $mail = new PHPMailer;
        // echo '<pre>';var_dump($data);echo '</pre>';die();
        $mail->isSMTP();
        $mail->Host = $data['host'];
        $mail->Username = $data['sender_email'];
        $mail->Password = $data['password'];
        $mail->Port = $data['port'];

        // $mail->Host = 'smtp.gmail.com';
        // $mail->Username = 'burhanburdev@gmail.com';
        // $mail->Password = 'burhan216105';
        // $mail->Port = 587;

        $mail->SMTPAuth = true;
        $mail->SMTPSecure = $data['encryption'];
        // $mail->SMTPSecure = 'tls';
        // $mail->SMTPDebug = 2;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        // $mail->setFrom('burhanburdev@gmail.com', $data['sender_name']);
        $mail->setFrom($data['sender_email'], $data['sender_name']);
        $mail->addAddress($data['receiver'], '');
        $mail->isHTML(true);
        $mail->Subject = $data['subject'];
        $mail->Body = $data['content'];
        // $mail->AddEmbeddedImage('image/logo.png', 'logo_mynotescode', 'logo.png');

        if($mail->send()){          
            $returnValue = 1;
        }

        return $returnValue;
    }
    public function send_with_attachment($data){
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = $this->email_pengirim; // Email Pengirim
        $mail->Password = $this->password; // Isikan dengan Password email pengirim
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        // $mail->SMTPDebug = 2; // Aktifkan untuk melakukan debugging
        $mail->setFrom($this->email_pengirim, $this->nama_pengirim);
        $mail->addAddress($data['email_penerima'], '');
        $mail->isHTML(true); // Aktifkan jika isi emailnya berupa html
        $mail->Subject = $data['subjek'];
        $mail->Body = $data['content'];
        $mail->AddEmbeddedImage('image/logo.png', 'logo_mynotescode', 'logo.png'); // Aktifkan jika ingin menampilkan gambar dalam email
        if($data['attachment']['size'] <= 25000000){ // Jika ukuran file <= 25 MB (25.000.000 bytes)
            $mail->addAttachment($data['attachment']['tmp_name'], $data['attachment']['name']);
            $send = $mail->send();
            if($send){ // Jika Email berhasil dikirim
                $response = array('status'=>'Sukses', 'message'=>'Email berhasil dikirim');
            }else{ // Jika Email Gagal dikirim
                $response = array('status'=>'Gagal', 'message'=>'Email gagal dikirim');
            }
        }else{ // Jika Ukuran file lebih dari 25 MB
            $response = array('status'=>'Gagal', 'message'=>'Ukuran file attachment maksimal 25 MB');
        }
        return $response;
    }
}