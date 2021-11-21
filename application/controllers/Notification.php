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
            $this->db->set('checked', TRUE);
            $this->db->where('receiver', $this->session->userdata('id'));
            $this->db->update('employment_promotion');

            $this->db->set('checked', TRUE);
            $this->db->where('receiver', $this->session->userdata('id'));
            $this->db->update('employment_absences');
            
            $data['content']            = $this->view.'content';
            $data['css']                = $this->view.'css';
            $data['javascript']         = $this->view.'javascript';
            $data['title']              = 'Notifikasi';
            $data['sub_title']          = '';
            $data['notif']              = $this->general->countEmployeeAbsence();
            $data['absence']            = $this->general->searchEmployeeAbsence();
            $data['promotion']          = $this->general->countEmployeePromotion(); 
            $data['employee_promotion'] = $this->general->showEmployeePromotion();

            $this->load->view('includes/main', $data);
        }

        public function mail(){
            $this->notifications->sendMailEmployeePromotion("Test From Controller", array('name' => 'Karyawan Kontrak', 'nip' => '218999'));
        }
    }

?>