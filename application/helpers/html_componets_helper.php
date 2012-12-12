<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('htmlSelect')) {
		function htmlSelect($val1, $val2) {

			if($val1 == $val2)
				return 'selected="selected"';
			else
				return '';
		}		
	}
	
	/**
	 * Truncates the sring of chararcters
	 * @params $param = array('chars' => 'text here', 'num_chars' => 30);
	 * @return string
	 */
	if(!function_exists('truncator')) {
		function truncator($params = array()) {
			$output = '';
			$elips = "...";
			
			if(strlen($params['chars'] > $params['num_chars']))
				$output .= substr($params['chars'], 0, 29) . $elips;
			else 
				$output = $params['chars'];
				
			return $output;
		}
	}