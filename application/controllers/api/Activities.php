<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization');

use Restserver\Libraries\REST_Controller;
use \Firebase\JWT\JWT;

require APPPATH . 'controllers/api/Auth.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         api-hris
 * @category        RESTful API
 * @author          Burhan Mafazi | burhan.mafazi@universitaspertamina.ac.id
 * @link            https://phabricator.universitaspertamina.ac.id/source/HurryUP/
 */

class Activities extends Auth 
{
    // approval status
    const SUBMITTED = 1;
    const APPROVED = 2;
    const REJECTED = 3;
    const WAITING_FOR_APPROVAL = 4;
    const CANCELLED = 5;
    const REPORTED = 6;
    const VERIFICATION = 7;
    const DRAFT = 8;
    const PUBLISHED = 9;

    private $secretkey = '5P2X6fkEIJ8cJRrjEYwuEbeaFiJ34B8i';
    private $table      = 'timesheets';

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->validate();
    }

    function index_get() 
    {       
        $token = $this->input->get_request_header('Authorization');

        try {
            $decode = JWT::decode($token, $this->secretkey, array('HS256'));
            $data = $this->Apimodel->getDataActivities($decode->employee_id)->result();

            $object = new stdClass();
            $object->countTimesheets = count((array) $data);
            $object->timesheets = $data;

            $response = array(
                'error' => false,
                'message' => 'success',
                'data' => $object,
                'url' => current_url()
            );

            $code = REST_Controller::HTTP_OK;
        } catch (Exception $e) {
            $response = array(
                'error' => true,
                'message' => $e->getMessage(),
                'data' => null,                
                'url' => current_url()
            );

            $code = REST_Controller::HTTP_INTERNAL_SERVER_ERROR;
        } catch (Error $err) {
            $response = array(
                'error' => true,
                'message' => 'Something went wrong because '.$err->getMessage().' on file '.$err->getFile().' in line number '.$err->getLine(),
                'data' => null,                
                'url' => current_url()
            );

            $code = REST_Controller::HTTP_INTERNAL_SERVER_ERROR;
        }        

        $this->response($response, $code);
    }

    function index_post()
    {
        $token = $this->input->get_request_header('Authorization');
        $content_type = $this->input->get_request_header('Content-Type');

        if ($content_type != 'application/json') {
            throw new Exception("Content-Type must be application/json", 1);                    
        }

        $errMessage = null;

        $this->db->trans_begin();

        try {
            $decode = JWT::decode($token, $this->secretkey, array('HS256'));
            
            $i = 0;
            foreach ($this->post('tupoksi') as $tup) {
                $check = $this->db->get_where('tupoksi', array('id' => $tup))->row();

                if ($check) {                     
                    $weight = $check->weight;
                    $tupoksi = $check->tupoksi;
                    $supervisor = null;

                    $approver = $this->db->get_where('positions', array('id' => $check->position_id))->row();

                    if ($approver) {
                        $supervisor = $approver->parent_id;
                    }

                    $timesheet = array(
                        'employee_id' => $decode->employee_id,
                        'approval' => self::WAITING_FOR_APPROVAL,
                        'date_on' => date('Y-m-d', strtotime($this->post('date_on')[$i])),
                        'duration' => $this->post('duration')[$i],
                        'tupoksi' => $tupoksi,
                        'activity' => $this->post('activity')[$i],
                        'weight' => $weight,
                        'approver_id' => $supervisor // parent position
                    );

                    $this->db->insert('timesheets', $timesheet);
                } else {
                    throw new Exception("Data tupoksi tidak ditemukan", 1);                    
                }

                $i++;   
            }
        } catch (Exception $e) {
            $errMessage = $e->getMessage();
            $response = $this->params->errData($errMessage);
            $code = REST_Controller::HTTP_INTERNAL_SERVER_ERROR;

            $this->response($response, $code);
        } catch (Error $err) {
            $errMessage = 'Something went wrong because '.$err->getMessage().' on file '.$err->getFile().' in line number '.$err->getLine();
        }   

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $response = $this->params->errData($errMessage);
            $code = REST_Controller::HTTP_INTERNAL_SERVER_ERROR;
        } else {
            $this->db->trans_commit();
            $response = $this->params->created();
            $code = REST_Controller::HTTP_OK;
        }

        $this->response($response, $code);
    }

    function index_put()
    {
        $token = $this->input->get_request_header('Authorization');
        $content_type = $this->input->get_request_header('Content-Type');

        if ($content_type != 'application/json') {
            throw new Exception("Content-Type must be application/json", 1);                    
        }

        $id = $this->uri->segment(3);

        $errMessage = null;

        $this->db->trans_begin();

        try {
            $decode = JWT::decode($token, $this->secretkey, array('HS256'));

            $data = array(
                'feedback' => $this->put('feedback')
            );

            $this->db->where('id', $id)->update('timesheets', $data);
        } catch (Exception $e) {
            $errMessage = $e->getMessage();
            $response = $this->params->errData($errMessage);
            $code = REST_Controller::HTTP_INTERNAL_SERVER_ERROR;

            $this->response($response, $code);
        } catch (Error $err) {
            $errMessage = 'Something went wrong because '.$err->getMessage().' on file '.$err->getFile().' in line number '.$err->getLine();
        }   

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $response = $this->params->errData($errMessage);
            $code = REST_Controller::HTTP_INTERNAL_SERVER_ERROR;
        } else {
            $this->db->trans_commit();
            $response = $this->params->updated();
            $code = REST_Controller::HTTP_OK;
        }

        $this->response($response, $code);
    }
}