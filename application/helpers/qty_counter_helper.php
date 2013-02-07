<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author		Ian Paul Kionisala
 */
 
 if ( ! function_exists('count_qty')) {
	function count_qty($id) {
		$CI =& get_instance();
	
		$params['querystring'] = "SELECT SUM(mboos_inStocks_quantity) as mboos_inStocks_quantity FROM mboos_instocks WHERE mboos_product_id='". $id . "'";
		$CI->mdldata->select($params);
		
		$serps = $CI->mdldata->_mRecords;
		
		return $serps[0]->mboos_inStocks_quantity;
	}
}




