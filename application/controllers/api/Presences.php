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

class Presences extends Auth
{
	// presence type
	const WFO = 1;
	const WFH = 2;

	// presence status
	const OK = 1;
	const LATE = 2;
	const ATTENDANCE_LESS = 3;
	const LEAVE = 4;
	const BUSINESS_TRIP = 5;
	const OTHER = 6;

    private $secretkey = '5P2X6fkEIJ8cJRrjEYwuEbeaFiJ34B8i';
	private $table 		= 'log_presences';
	private $table_condition = 'log_remote_presences';

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

			$data = $this->Apimodel->getData($this->table, array('employee_id' => $decode->id))->result();
			$object->countPresences = count((array) $data);
			$object->presences = $data;

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

	function index_post()
	{
        $token = $this->input->get_request_header('Authorization');
        $content_type = $this->input->get_request_header('Content-Type');

        $object = new stdClass();
        $errMessage = null;

		$this->db->trans_begin();

        try {
	        $decode = JWT::decode($token, $this->secretkey, array('HS256'));
        	
			if ($content_type != 'application/json') {
				throw new Exception("Content-Type must be application/json", 1);					
			}

			$data = new \stdClass();

			$emp = $this->db->select('employee_id')->from('employee_pt')->where('user_id', $decode->id)->get()->row();
			$data->employee_id = $emp->employee_id;
			$data->date = date('Y-m-d');	
			$data->checkin = date('Y-m-d H:i:s');
			$data->type = self::WFH; // WFH

			if (substr($data->checkin, 11) > '09:00:00') {
				$data->status = self::LATE;
			} else {
				$data->status = self::OK;
			}

			$keterangan = '';

	        $check = $this->db->select('id, employee_id, checkin, checkout')->from('log_presences')->where(array('employee_id' => $emp->employee_id, 'date' => date('Y-m-d')))->get()->row();

	        if ($check) {		        	
		        // checkout
				$checkLoc = $this->db->get_where('log_remote_presences', array('lat_checkin' => NULL, 'presences_id' => $check->id))->row();

				if ($checkLoc) {
					for ($i = 0; $i <= count((array) $this->post('notes')) - 1; $i++) { 
						$keterangan .= $this->post('notes')[$i];

						if ($i < count((array) $this->post('notes')) - 1) {
							$keterangan .= ", ";
						}
					}

					$this->db->update('log_remote_presences', 
						array(
							'city' => $this->post('city'), 
							'temperature' => $this->post('temperature'), 
							'condition' => $this->post('condition'), 
							'notes' => $keterangan, 
							'lat_checkin' => $this->post('latitude'), 
							'long_checkin' => $this->post('longitude')
						), array('presences_id' => $check->id)
					);
				} else {						
					$datang = new DateTime($check->checkin);
					$pulang = new DateTime(date('Y-m-d H:i:s'));
					$diff = $datang->diff($pulang);
					$durasi = str_pad($diff->h, 2, "0", STR_PAD_LEFT).':'.str_pad($diff->i, 2, "0", STR_PAD_LEFT).':'.str_pad($diff->s, 2, "0", STR_PAD_LEFT);

					$checkout = $this->Apimodel->putData('log_presences', array('checkout' => date('Y-m-d H:i:s'), 'duration' => $durasi), $check->id);

					$this->db->update('log_remote_presences', array('lat_checkout' => $this->post('latitude'), 'long_checkout' => $this->post('longitude')), array('presences_id' => $check->id));
				}
	        } else {
	        	// checkin
				$checkin = $this->db->insert('log_presences', $data);
				$last_id = $this->db->insert_id();

				for ($i = 0; $i <= count((array) $this->post('notes')) - 1; $i++) { 
					$keterangan .= $this->post('notes')[$i];

					if ($i < count((array) $this->post('notes')) - 1) {
						$keterangan .= ", ";
					}
				}

				$attr = new \stdClass();

				$attr->presences_id = $last_id;
				$attr->city = $this->post('city');
				$attr->temperature = $this->post('temperature');
				$attr->condition = $this->post('condition');
				$attr->notes = $keterangan;
				$attr->lat_checkin = $this->post('latitude');
				$attr->long_checkin = $this->post('longitude');

				$checkin_remote = $this->db->insert('log_remote_presences', $attr);
	        }			
        } catch (Exception $e) {
        	$errMessage = $e->getMessage();
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
}