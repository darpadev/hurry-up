<?php

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Promotions extends CI_Model 
{
    public function showApprovalData($id)
    {
        $this->db->select('promotion_approval.*, employees.name AS assessor_name');
        $this->db->from('promotion_approval');
        $this->db->join('employees', 'employees.id = promotion_approval.assessor', 'left');
        $this->db->where('employee_id', $id);

        return $this->db->get();
    }

    public function getPromotionStatus($id)
    {
        $this->db->select('status');
        $this->db->from('promotion_approval');
        $this->db->where('promotion_approval.employee_id', $id);

        return $this->db->get()->row()->status;
    }

    public function getStatusUpdate($id)
    {
        $this->db->select(
            'status_updates.status, 
            status_updates.active_status,
            status_updates.effective_date, 
            employees.name AS assessor_name, 
            employment_statuses.status AS status_name, 
            employment_active_statuses.status AS active_name'
        );
        $this->db->from('status_updates');
        $this->db->join('employee_pt', 'employee_pt.user_id = status_updates.updated_by');
        $this->db->join('employees', 'employees.id = employee_pt.employee_id');
        $this->db->join('employment_statuses', 'employment_statuses.id = status_updates.status');
        $this->db->join('employment_active_statuses', 'employment_active_statuses.id = status_updates.active_status');
        $this->db->where('status_updates.employee_id', $id);
        $this->db->order_by('status_updates.updated_at', 'desc');
        $this->db->limit(1);

        return $this->db->get();
    }

    public function inspectDecision($id)
    {
        $this->db->select('manager, director');
        $this->db->from('promotion_approval');
        $this->db->where('id', $id);
        
        $decision  = $this->db->get()->row();

        $manager = explode(';', $decision->manager);
        $director = explode(';', $decision->director);

        if ($manager[0] == $director[0]) return true;
        else return false;
    }
}