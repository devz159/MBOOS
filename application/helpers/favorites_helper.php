<?php  if(!defined("BASEPATH")) exit("No direct script access allowed");

if( !function_exists('getFavItemsResultSet')) {
	function getFavItemsResultSet() {
		
		$CI =& get_instance();
		
		$output = '';
		$CI->load->library('favlist');
				
		$lists = ($CI->favlist->readFav() == '') ? array() : explode(",", $CI->favlist->readFav());
		
		//call_debug($lists);
		if(count($lists) > 0) {
			foreach ($lists as $lst) {
				$output .= sprintf(" lst_id=%s", trim($lst));
				$output .= ' or ';
		
			}
		
			// preps some string
			preg_match('/[\w\s=]+(?=or)/', $output, $matches);
			$output = trim($matches[0]);
			$output =  sprintf("SELECT * FROM listing WHERE %s ORDER BY title ASC", $output);
		
			$CI->load->model('mdldata');
			$params['querystring'] = $output;
			$CI->mdldata->select($params);
		
			return $CI->mdldata->_mRecords;
		
		} else {
			return null;
		}
	}
}