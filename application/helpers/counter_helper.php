<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 if ( ! function_exists('counter_ordered')) {
 	
	function counter_ordered($id) {
		
		$CI =& get_instance();

		$CI->load->model('mdldata');
		
		$params['table'] = array(
				'name' => 'mboos_orders',
				'criteria_phrase' =>  'mboos_customer_id="'. $id . '"'
				);
		
		$CI->mdldata->select($params);

		$value = $CI->mdldata->_mRowCount;

		return $value;
	}
}