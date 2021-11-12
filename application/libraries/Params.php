<?php 

/**
 * 
 */
class Params
{
	const DEFAULT_LIMIT_SIZE = 10;
	const DEFAULT_OFFSET = 0;
	const DEFAULT_COLUMN_ORDER = 'id';
	const DEFAULT_ORDER = 'ASC';
	
	function urltojson($params){		
		$arr = array();
		
		if (!$params) {
			$obj = (object) $arr;
		} else {			
			$keywords = preg_split("/[\s,=,&]+/", $params);

			for($i = 0; $i < sizeof($keywords); $i++)
			{				
				$arr[$keywords[$i]] = str_replace(['%2F', '%3A', '+', '%3D', '%2B', '%2C', '%24', '%40', '%23', '%25', '%26', '%3B', '%2F', '%5D', '%5B', '%22', '%3C', '%3E', '%7B', '%7D', '%20'], ['/', ':', ' ', '=', '+', ',', '$', '@', '#', '%', '&', ';', '/', ']', '[', '"', '<', '>', '{', '}', ' '], $keywords[++$i]);
			}

			$obj =(object) $arr;
		}

		return $obj;
	}

	function getLimit($limit = ''){
		return $limit == NULL ? self::DEFAULT_LIMIT_SIZE : $limit;
	}

	function getOffset($offset = ''){
		return $offset == NULL ? self::DEFAULT_OFFSET : $offset;
	}

	function getColumn($column = ''){
		return $column == NULL ? self::DEFAULT_COLUMN_ORDER : $column;
	}

	function getOrder($order = ''){
		return $order == NULL ? self::DEFAULT_ORDER : $order;
	}

	function methodFail(){
		return array('error' => true, 'message' => 'Unknown method', 'url' => current_url());
	}

	function existData(){
		return array('error' => true, 'message' => 'Data already exist', 'url' => current_url());
	}

	function errData($message = NULL){
		if (!$message) {
			$message = 'Something wen wrong';
		}
		
		return array('error' => true, 'message' => $message, 'url' => current_url());
	}

	function nullData(){
		return array('error' => true, 'message' => 'Data cannot be null', 'url' => current_url());
	}

	function nullTable(){
		return array('error' => true, 'message' => 'Table cannot be null', 'url' => current_url());
	}
	
	function created($_id = ''){
		return array('error' => false, 'message' => 'Data has been created', 'url' => current_url());
	}
	
	function updated(){
		return array('error' => false, 'message' => 'Data has been updated', 'url' => current_url());
	}
	
	function deleted(){
		return array('error' => false, 'message' => 'Data has been deleted', 'url' => current_url());
	}
}

?>