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

class Teams extends Auth 
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

    function activity_get() 
    {       
        $token = $this->input->get_request_header('Authorization');

        try {
            $decode = JWT::decode($token, $this->secretkey, array('HS256'));

            $data = $this->Apimodel->searchTimesheetSubodinates($decode->positions)->result();

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

    function approval_put()
    {
        $timesheet_id = $this->uri->segment(4);
        $token = $this->input->get_request_header('Authorization');
        $content_type = $this->input->get_request_header('Content-Type');
        $approval = $this->put('approval');
        $errMessage = null;

        $this->db->trans_begin();

        try {        
            if ($content_type != 'application/json') {
                throw new Exception("Content-Type must be application/json", 1);                    
            }

            $decode = JWT::decode($token, $this->secretkey, array('HS256'));

            if ($approval == 'approve') {
                $this->db->where('id', $timesheet_id)->update('timesheets', array('approval' => self::APPROVED, 'approver_name' => $decode->name));
            } else if ($approval = 'reject') {            
                $this->db->where('id', $timesheet_id)->update('timesheets', array('approval' => self::REJECTED, 'approver_name' => $decode->name));
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
            $response = $this->params->updated();
            $code = REST_Controller::HTTP_OK;
        }

        $this->response($response, $code);
    }
}