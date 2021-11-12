<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization');

use Restserver\Libraries\REST_Controller;

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

class Positions extends REST_Controller {
    function __construct($config = 'rest') {
        parent::__construct($config);
    }

    function index_get() {
        $id = $this->uri->segment(3);
        $order_by = $this->get('order_by');
        $sort = $this->get('sort');
        $limit = $this->get('limit');

        try {
            if ($id) {        
                $data = $this->db->select('id, parent_id, position, org_unit, level')->from('positions')->where('id', $id)->get()->result();
            } else {
                // $positions = $this->db->select('p.id, p.parent_id, p.position, p.level, p.org_unit as organization_id, o.org_unit as organization')->from('positions as p')->join('organizations as o', 'o.id = p.org_unit')->get()->result();                
                $data = $this->db->select('id, parent_id, position, org_unit, level')->from('positions')->get()->result();
            }

            $response = array(
                'error' => false,
                'message' => 'success',
                'data' => $data,
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