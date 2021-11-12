<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization');

use Restserver\libraries\REST_Controller;
use \Firebase\JWT\JWT;

require APPPATH . '../vendor/autoload.php';
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         api-hris
 * @category        RESTful API
 * @author          Burhan Mafazi | burhan.mafazi@universitaspertamina.ac.id
 * @link            https://phabricator.universitaspertamina.ac.id/source/HurryUP/
 */

class Auth extends REST_Controller
{
    private $secretkey = '5P2X6fkEIJ8cJRrjEYwuEbeaFiJ34B8i';

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Apimodel');
    }

    public function index_post()
    {
        if ($this->uri->segment(2) != 'auth') {
            $this->response([
              'error' => TRUE,
              'message' => 'Method not allowed',
              'url' => current_url()
              ], REST_Controller::HTTP_METHOD_NOT_ALLOWED);
        }

        $date = new DateTime();

        $username = $this->post('username', TRUE);
        $password = $this->post('password', TRUE);

        $valid = $this->Apimodel->is_valid($username, md5($password))->row();

        if ($valid) {
            $emp_pos = $this->db->select('position_id')->from('employee_position')->where(array('employee_id' => $valid->employee_id))->get()->result();

            $positions = array();

            foreach ($emp_pos as $value) {
                $positions[] = $value->position_id;
            }

            $payload['id'] = $valid->id;
            $payload['employee_id'] = $valid->employee_id;
            $payload['name'] = $valid->name;
            $payload['username'] = $valid->username;
            $payload['positions'] = $positions;
            // $payload['iat'] = $date->getTimestamp();
            // $payload['exp'] = $date->getTimestamp() + 3600;

            $token = JWT::encode($payload, $this->secretkey);

            return $this->response([
                'error' => FALSE,
                'message' => 'success',
                'token' => $token,
                'url' => current_url()
            ], REST_Controller::HTTP_OK);
        } else {
            $this->unauthorized();
        }
    }

    private function unauthorized() {
        $this->response([
          'error' => TRUE,
          'message' => 'Unauthorized access',
          'url' => current_url()
          ], REST_Controller::HTTP_UNAUTHORIZED);
    }

    function validate(){
        $jwt = $this->input->get_request_header('Authorization');

        try {
            $decode = JWT::decode($jwt, $this->secretkey, array('HS256'));

            if ($decode) {
                return true;
            } else {
                throw new Exception("Error Processing Request", 1);                
            }
        } catch (Exception $e) {
            $this->clear();
            $this->response([
                'error' => TRUE, 
                'message' => 'Token invalid', 
                'url' => current_url()
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function clear()
    {
        if (isset($_SERVER['HTTP_COOKIE']))
        {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie)
            {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time() - 1000);
                setcookie($name, '', time() - 1000, '/');
            }
        }
    }
}