<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('code_generator')){
	/**
	 * Generates has like string out from another string
	 * @author unknown (from the internet)
	 * @since unknow
	 * @param string $length
	 * @return hash like string
	 * @version unknown
	 */
	function code_generator($length = 10){
	
		if ($length <= 0)
		{
			return false;
		}
		
		$code = "";
		$chars = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
		srand((double)microtime() * 1000000);
		for ($i = 0; $i < $length; $i++)
		{
			$code = $code . substr($chars, rand() % strlen($chars), 1);
		}
			return $code;
			
		}	 
}

if(! function_exists('strencode')){
	/**
	 * 
	 * Encodes string into hexadecimal or binary strings
	 * @param string $str
	 * @param boolean $hex
	 * @author Kenneth "digiArtist_ph" P. Vallejos
	 * @return string 01100001011001000111011001100101011100100111010001101001011100110110010101110010
	 * @version 1.0
	 * @since Sunday, October 28, 2012
	 * @example strencode('advertiser', FALSE)
	 * 
	 */
	function strencode($str, $hex = TRUE) {
		$output = '';
						
		for($i = 0; $i < strlen($str); $i++) {
			if($hex)
				$output .= sprintf("%02s", dechex(ord($str[$i])));
			else
				$output .= sprintf("%08s", decbin(ord($str[$i])));
		}
			
		$output = sprintf("%s", $output);	
		
		return $output;
	}	
}

if(! function_exists('strdecode')) {
	/**
	 * 
	 * Decodes hash like hexadecimal/binary string into alphanumeric characters
	 * @param string $str
	 * @param boolean $hex
	 * @author Kenneth "digiArtist_ph" P. Vallejos
	 * @return string e.i "advertiser"
	 * @version 1.0
	 * @since Monday, October 29, 2012
	 * @example strdecode('01100001011001000111011001100101011100100111010001101001011100110110010101110010', FALSE)
	 */
	function strdecode($str, $hex = TRUE) {
		$output = '';
		$data;
		
		do {
			
			if($hex){
				$data = codexTruncateHash($str, 2);
				$output .= chr(hexdec($data['strBuff']));
			} else {
				$data = codexTruncateHash($str, 8);
				$output .= chr(bindec($data['strBuff']));
			}
			$str = $data['strTrunc'];
		} while(strlen($str) > 0);
		
		return $output;
	}
}

/*** utility ***/
function codexTruncateHash($hash, $loop = 2) {
	$sought = '';
	$strBuff = '';
	$cntr = 0;
	
	do {
		$sought = $hash[0]; // retrieves sought character
		$hash = substr($hash, strlen($sought), (strlen($hash) - strlen($sought))); // truncates the first character from array of string
		$strBuff .= $sought; // appends char into an array

		$cntr++;
	} while($cntr < $loop);
	
	$output = array('strBuff' => $strBuff, 'strTrunc' => $hash);
	
	return $output;
}