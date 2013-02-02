<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author		Ian Paul Kionisala
 */
 
 if ( ! function_exists('formatedpadding')) {
	
 	function formatedpadding($params){
 		
 		$result = str_pad($params, 8, "0", STR_PAD_LEFT);
 		
 		return $result;
	}

}

if ( ! function_exists('deletePaddingZeros')) {

	function deletePaddingZeros($params){
		
		$pattern = "/0/";
		$replacement = "";
		$result = preg_replace($pattern, $replacement, $params);
		
		return $result;
	}

}






