<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('sCurrency')) {
	function sCurrency($sValue) {
		$pattern = '/(\d)+(\.\d{2})?/';
		$curAmnt;
		
		preg_match($pattern, $sValue,$matches);
		
		if(!$matches)
			$curAmnt = '0';
		else
			$curAmnt = $matches[0];
		
		return number_format($curAmnt, 2, '.', ',');
	}
}