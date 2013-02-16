<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author		Ian Paul Kionisala
 */
 
 if ( ! function_exists('count_qty')) {
	function count_qty($id) {
		$CI =& get_instance();
	
/* 		$params['querystring'] = "SELECT SUM(mboos_inStocks_quantity) as mboos_inStocks_quantity FROM mboos_instocks WHERE mboos_product_id='". $id . "'";
		$CI->mdldata->select($params);
		
		$serpsInstock = $CI->mdldata->_mRecords;
		//call_debug($serpsInstock, false);
		$CI->mdldata->reset();
		$params['querystring'] = 'SELECT sum(mboos_order_detail_quantity) as totalQtySolved FROM `mboos_order_details` where mboos_product_id="'. $id . '"';
		$CI->mdldata->select($params);
		$serpsOrderDetails = $CI->mdldata->_mRecords;
		//call_debug($serpsOrderDetails, false);

		$currQty = $serpsInstock[0]->mboos_inStocks_quantity - $serpsOrderDetails[0]->totalQtySolved;
		//call_debug($currQty); */
		
		$params['querystring'] = "SELECT (SUM(mboos_instocks.mboos_inStocks_quantity) - SUM(mboos_order_details.mboos_order_detail_quantity)) as currQty FROM `mboos_instocks` left join mboos_order_details on mboos_order_details.mboos_product_id=mboos_instocks.mboos_product_id where mboos_instocks.mboos_product_id ='".$id . "'";
		
		$CI->mdldata->select($params);
		$serpsInstock = $CI->mdldata->_mRecords;
		
		$currQty = $serpsInstock[0]->currQty;
		
		if($currQty <= 0)
			return "Out of Stock";
		
		return $currQty;
	}
}

if ( ! function_exists('order_counter')) {
	function order_counter($date) {
		$CI =& get_instance();

		$params['querystring'] = "SELECT * FROM mboos_orders where DATE_FORMAT(mboos_order_date, '%Y %m') = DATE_FORMAT('2013-02-08', '%Y %m')";

		$CI->mdldata->select($params);

		$serps = $CI->mdldata->_mRowCount;

		return $serps;
	}
}

if ( ! function_exists('qty_checker')) {
	function qty_checker($qty, $curr_qty) {
		$CI =& get_instance();

		if($qty <= $curr_qty )
			return 1;

		return 0;
	}
}




