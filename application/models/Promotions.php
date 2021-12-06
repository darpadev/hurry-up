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
        return $this->db->get_where('promotion_approval', array('employee_id' => $id));
    }

    public function getPromotionStatus($id)
    {
        $this->db->select('status');
        $this->db->from('employment_promotion');
        $this->db->join('promotion_approval', 'promotion_approval.employee_id = employment_promotion.employee_id');
        $this->db->where('promotion_approval.employee_id', $id);

        return $this->db->get()->row()->status;
    }
}