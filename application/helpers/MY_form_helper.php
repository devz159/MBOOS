<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('cbo_selected')) {
		function cbo_selected($strOne, $strTwo) {
			$output = '';
			
			if(strtolower($strOne) == strtolower($strTwo)) {
				$output .= ' ';
				$output .= 'selected="selected"';
				$output .= ' ';
			} else {
				$output .= '';	
			}
			
			return $output;
		}
	}

?>