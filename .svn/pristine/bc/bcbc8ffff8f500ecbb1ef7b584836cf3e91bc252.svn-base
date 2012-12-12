<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Age Calculator
 * @author Ian Paul F. Kionisala
 * @param array $params
 * @package application/helper
 * @version 1.0.0
 * @Company	Mugs & Coffee
 *
 *
 */

if ( ! function_exists('getAge')) {
	function getAge($params) {
			
         //explode the date to get month, day and year
        $params = explode("/", $params);
      	
         //get age from date or birthdate
         $age = (date("md", date("U", mktime(0, 0, 0, $params[0], $params[1], $params[2]))) > date("md") ? ((date("Y")-$params[2])-1):(date("Y")-$params[2]));
         
         return $age;
	}
}