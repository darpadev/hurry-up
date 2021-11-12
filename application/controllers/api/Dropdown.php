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

class Dropdown extends Auth 
{
    private $secretkey = '5P2X6fkEIJ8cJRrjEYwuEbeaFiJ34B8i';

    function __construct($config = 'rest') {
        parent::__construct($config);
    }

    function cities_get() {
        try {
            $data = $this->db->select('*')->from('geo_cities')->get()->result();

            $object = new stdClass();
            $object->countCities = count((array) $data);
            $object->city = $data;

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

    function tupoksi_get() {        
        $this->validate();
        $this->load->model('timesheets');

        $token = $this->input->get_request_header('Authorization');

        try {
            $decode = JWT::decode($token, $this->secretkey, array('HS256'));
            $data = $this->timesheets->getDataTupoksi($decode->positions)->result();

            $object = new stdClass();
            $object->countTupoksi = count((array) $data);
            $object->tupoksi = $data;

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
}