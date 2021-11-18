<?php 
    /**
     * @author      Hutomo, Mohammad Milzam Kasyfillah | milzam.khutomo@gmail.com
     * @link        https://linktr.ee/m.hutomo
     */

    defined('BASEPATH') OR exit('No direct script access allowed.');

    class Notification extends MY_Controller
    {
        protected $view = 'contents/notification/';

        public function __construct()
        {
            parent::__construct();
            $this->load->model('notifications');
        }

        public function index()
        {
            $data['content']            = $this->view.'content';
            $data['css']                = $this->view.'css';
            $data['javascript']         = $this->view.'javascript';
            $data['title']              = 'Notifikasi';
            $data['sub_title']          = '';
            $data['notif']              = $this->general->searchEmployeeAbsence();
            $data['promotion']          = $this->general->countEmployeePromotion(); 
            $data['employee_promotion'] = $this->general->showEmployeePromotion();

            $this->db->set('checked', TRUE);
            $this->db->where('receiver', $this->session->userdata('id'));
            $this->db->update('employment_promotion');

            $this->load->view('includes/main', $data);
        }

        public function mail(){
            // $config = array(
            //     'protocol'    => 'smtp',
            //     'smtp_host'   => 'ssl://smtp.googlemail.com',
            //     'smtp_port'   => 456,
            //     'smtp_user'   => 'milzam075@gmail.com',
            //     'smtp_pass'   => '#Milzam70465',
            //     'emailtype'   => 'html',
            //     'charset'     => 'iso-8859-1'
            // );

            // $this->load->library('email', $config);

            // $this->email->set_newline("\r\n");

            // $this->email->from('milzam075@gmail.com', 'Milzam Hutomo');
            // $this->email->to('milzam.khutomo@gmail.com');
            // $this->email->cc('milzamhutomo.social@gmail.com');
            // $this->email->bcc('105217013@student.universitaspertamina.ac.id');

            // $this->email->subject('Test Email');
            // $this->email->message('Lorem ipsum');

            // $this->email->send();
            $this->notifications->sendMailEmployeePromotion();
            // $this->notifications->sendMailOvertimeToHrd('milzam.khutomo@gmail.com', 'milzam.khutomo@gmail.com', 'milzam.khutomo@gmail.com', '2020-06-14', '123');
        }
    }

?>