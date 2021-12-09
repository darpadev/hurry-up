<?php 

/**
 * 
 * @author      Hutomo, Mohammad Milzam Kasyfillah | milzam.khutomo@gmail.com
 * @link        https://linktr.ee/m.hutomo
 * 
 */

class Promotion extends MY_Controller
{
    protected $view = 'contents/promotion/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('promotions');
    }

    public function form()
    {
        $this->load->model('employments');

        $data['title']			= 'Penilaian Karyawan';
        $data['sub_title']		= '';
        $data['content']		= $this->view.'promotion';
        $data['css']			= NULL;
        $data['javascript']		= $this->view.'js_promotion';
        $data['notif']			= $this->general->countEmployeeAbsence();
        $data['promotion']		= $this->general->countEmployeePromotion();
        $data['employee']		= $this->employments->showEmployeeBrief($this->uri->segment(3));

        $approval = $this->promotions->showApprovalData($this->uri->segment(3));

        if ($approval->num_rows() > 0) {
            $data['approval'] = $approval->row();

            if ($data['approval']->status == 4) {
                $status_update = $this->promotions->getStatusUpdate($this->uri->segment(3));

                if ($status_update->num_rows() > 0) $data['status_update'] = $status_update->row();
                else $data['status_update'] = NULL;
            } else $data['status_update'] = NULL;
        }else $data['approval'] = NULL;

        var_dump($data['status_update']);
        die;

        $this->load->view('/includes/main', $data);
    }

    public function store()
    {
        $this->db->trans_begin();

        $message = NULL;

        for ($i=0; $i < count($this->input->post('reason')); $i++) { 
            $message .= "<li>" . $this->input->post('reason')[$i] . "</li>";
        }

        $message .= "|" . $this->input->post('rating')[0] . "|" . $this->input->post('rating')[1];

        $employee = $this->db->select('name')->from('employees')->where('id', $this->input->post('employee_id'))->get()->row();

        $promotion = array(
            'message'		=> $message,
            // Status = Menunggu Keputusan Manajer
            'status'        => 2,
            'assessor'      => $this->session->userdata('employee'),
        );

        // Insert promotion data
        $this->db->where('employee_id', $this->input->post('employee_id'));
        $this->db->update('promotion_approval', $promotion);

        $assessor_name = $this->db->select('name')->from('employees')->where('id', $this->session->userdata('employee'))->get()->row();
        $assessor_name = $assessor_name->name;

        // Update employment_promotion
        $this->db->set('checked', FALSE);
        $this->db->set('notification', $assessor_name . ' telah memberikan penilaian untuk pengangkatan ' . $employee->name);
        $this->db->where('employee_id', $this->input->post('employee_id'));
        $this->db->where('receiver <>', $this->session->userdata('id'));
        $this->db->update('employment_promotion');

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('promotion_error', 'Penilaian pegawai gagal diberikan');
            $this->db->trans_rollback();
        }else{
            $this->session->set_flashdata('promotion_success', 'Penilaian pegawai berhasil diberikan');
            $this->db->trans_commit();
        }

        redirect("/notification");
    }

    public function update()
    {
        $this->db->trans_begin();

        $current_status = $this->promotions->getPromotionStatus($this->input->post('employee_id'));

        $message = $this->input->post('promotion');

        if ($this->input->post('duration') !== NULL) {
            $message .= ' ' . $this->input->post('duration');
        }

        $message .= "; ";

        if ($this->input->post('description') !== NULL And strlen($this->input->post('description')) > 0) {
            $message .= "<strong>Keterangan: </strong>" . $this->input->post('description');
        }

        $employee = $this->db->select('name')->from('employees')->where('id', $this->input->post('employee_id'))->get()->row();

        if ($current_status == 2){ 
            $this->db->set('manager', $message);
            $this->db->where('employee_id', $this->input->post('employee_id'));
            $this->db->update('promotion_approval');
            
            // Update employment_promotion
            $this->db->set('checked', FALSE);
            $this->db->set('notification', 'Manajer telah memberikan keputusan untuk pengangkatan ' . $employee->name);
            $this->db->where('employee_id', $this->input->post('employee_id'));
            $this->db->update('employment_promotion');

            // Update promotion status to "Menunggu Penilaian Direktur"
            $this->db->where('employee_id', $this->input->post('employee_id'));
            $this->db->update('promotion_approval', array('status' => 3));

        }elseif ($current_status == 3){
            $this->db->set('director', $message);
            $this->db->where('employee_id', $this->input->post('employee_id'));
            $this->db->update('promotion_approval');
            
            // Update employment_promotion
            $this->db->set('checked', FALSE);
            $this->db->set('notification', 'Direktur telah memberikan keputusan untuk pengangkatan ' . $employee->name);
            $this->db->where('employee_id', $this->input->post('employee_id'));
            $this->db->update('employment_promotion');

            // Update promotion status to "Keputusan Akhir"
            $this->db->where('employee_id', $this->input->post('employee_id'));
            $this->db->update('promotion_approval', array('status' => 4));
        }

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('promotion_error', 'Penilaian pegawai gagal diberikan');
            $this->db->trans_rollback();
        }else{
            $this->session->set_flashdata('promotion_success', 'Penilaian pegawai berhasil diberikan');
            $this->db->trans_commit();
        }

        redirect("/notification");
    }
}

?>