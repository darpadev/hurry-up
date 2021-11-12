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

class Employees extends Auth
{
    private $secretkey = '5P2X6fkEIJ8cJRrjEYwuEbeaFiJ34B8i';

	function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->validate();
	}
	
	function index_get()
	{
        $token = $this->input->get_request_header('Authorization');

        $object = new stdClass();

        try {
	        $decode = JWT::decode($token, $this->secretkey, array('HS256'));

			$data = $this->Apimodel->getEmployee($decode->employee_id)->row();
			$positions = $this->Apimodel->getEmployeePosition($decode->employee_id)->result();

			$object->employee = $data;
			$object->positions = $positions;

		    $response['error'] = false;
		    $response['message'] = 'success';
		    $response['data'] = $object;
		    $response['url'] = current_url();

		    $code = REST_Controller::HTTP_OK;			
        } catch (Exception $e) {        	
            $this->response([
                'error' => TRUE, 
                'message' => $e->getMessage(), 
                'url' => current_url()
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
	    
	    $this->response($response, $code);
	}
}