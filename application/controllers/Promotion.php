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
                $data['status'] = $this->db->select('*')->from('employment_statuses')->get()->result();
                $status_update = $this->promotions->getStatusUpdate($this->uri->segment(3));

                if ($status_update->num_rows() > 0) $data['status_update'] = $status_update->row();
                else $data['status_update'] = NULL;
            } else {
                $data['status'] = NULL;
                $data['status_update'] = NULL;
            }
        }else $data['approval'] = NULL;

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

    public function update_status()
    {
        $this->db->trans_begin();

        if ($this->input->post('status') == MY_Controller::RESIGN) $active_status = NULL;
        else $active_status = 1;

        $data = array(
            'employee_id'       => $this->input->post('employee_id'),
            'status'            => $this->input->post('status'),
            'active_status'     => $active_status,
            'effective_date'    => $this->input->post('effective_date'),
            'updated_at'        => date('Y-m-d'),
            'updated_by'        => $this->session->userdata('id'),
        );

        $this->db->insert('status_updates', $data);

        $this->db->set('status_request', TRUE);
        $this->db->where('employee_id', $this->input->post('employee_id'));
        $this->db->update('promotion_approval');

        // Work Agreement File Upload
        $file = $_FILES['work_agreement_file'];

        if (strlen($file['name'])) {
            $f_name = $file['name'];
            $f_type = $file['type'];
            $f_content = file_get_contents($file['tmp_name']);

            $agreement = array(
                'employee_id' 	=> $this->uri->segment(4),
                'name'			=> $f_name,
                'doc_type'		=> $f_type,
                'doc'			=> $f_content,
                'uploaded_by'	=> $this->session->userdata('id')
            );
            // Insert work_agreement_docs
            $this->db->insert($this->agreement, $agreement);
        }

        if (in_array(51, $this->session->userdata('position'))) {
            $this->db->set('status', $this->input->post('status'));
            $this->db->set('active_status', $active_status);
            $this->db->where('employee_id', $this->input->post('employee_id'));
            $this->db->update('employee_pt');

            $this->db->select('user_id')->from('login')->where('role_id', MY_Controller::HRD);

            $hrd = $this->db->get()->result();

            foreach ($hrd as $person) {
                $this->db->set('delete_at', date('Y-m-d', strtotime(date('Y-m-d') . '+ 1 week')));
                $this->db->set('checked', FALSE);
                $this->db->where('employee_id', $this->input->post('employee_id'));
                $this->db->where('receiver <>', $person->user_id);
                $this->db->update('employment_promotion');
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('promotion_error', 'Penilaian pegawai gagal diberikan');
            $this->db->trans_rollback();
        }else{
            $this->session->set_flashdata('promotion_success', 'Penilaian pegawai berhasil diberikan');
            $this->db->trans_commit();
        }

        redirect(base_url() . "notification");
    }
}

?>