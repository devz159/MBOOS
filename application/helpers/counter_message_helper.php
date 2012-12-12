<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 if ( ! function_exists('counter')) {
	function counter($data) {
		
		$CI =& get_instance();

		$CI->load->model('mdldata');
		
		$params['table'] = array(
				'name' => $data['data']['table_name'],
				'criteria_phrase' =>  $data['data']['filter_string']
				);
		
		$CI->mdldata->select($params);

		$value = $CI->mdldata->_mRowCount;

		return $value;
	}
}