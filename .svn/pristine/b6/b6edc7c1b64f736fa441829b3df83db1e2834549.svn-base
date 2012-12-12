<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('parseLocation')) {
	function parseLocation($value, $code = TRUE) {
		
		$CI =& get_instance();
		
		if($code){
			$str = "SELECT * FROM cn_locations WHERE loc_id=$value";
			
			$records = $CI->db->query($str)->result();
			
			foreach($records as $rec) {
				if(strtolower($rec->type) == 'country')
					return ucwords($rec->name);
				elseif(strtolower($rec->type) == 'state')
					return strtoupper($rec->name);
			}
			
		} else { 
			$str = "SELECT * FROM cn_locations WHERE name='" . $value . "'";
			//on_watch($str, true);
			$records = $CI->db->query($str)->result();
			
			
			foreach($records as $rec) {
				return $rec->loc_id;
			}
		}
	}
}

if(!function_exists('strTruncate')) {
	function strTruncate($str, $count = 150) {
		$output = '';
		
		if(strlen($str) > $count) {		
			$output .= substr($str, 0, $count);
			$output .= '...';
		} else {
			$output .= $str;	
		}
		
		return $output;
	}
}

if(! function_exists('htmlDecode')) {
	function htmlDecode($dom) {
		$output = '';
		$pattern = '/(?<=^|>)[^><]+?(?=<|$)/';
		
		preg_match_all($pattern, $dom, $matches);
		
		if(!empty($matches[0])) {
			foreach($matches[0] as $line) {
				$output .= $line;
			}
		}
		
		//call_debug($matches);
		
		return trim($output);
	}
}

if(! function_exists('appendWebProtocol')) {
	function appendWebProtocol($link) {
		return trim("http://" . $link);
	}
}

if(! function_exists('getThumbImg')) {
	function getThumbImg($imgs) {
		$output = '';
		
		$arr = preg_split('/,/', $imgs, -1, PREG_SPLIT_NO_EMPTY);
		
	//	on_watch($arr);
			
		if(empty($arr))
			$output = '';
		else
			$output = $arr[0];
		
		return trim($output);
	}
}

if( ! function_exists('parseHTMLText')) {
	function parseHTMLText($text, $tosql = TRUE) {
		
		if($tosql) { // from textarea to MySQL
			$text = preg_replace('/[\r]/', "<br />", $text, ENT_QUOTES);
			$text = preg_replace('/\n/', '', $text);
			$text = htmlentities($text, ENT_QUOTES);
			return $text;
		} else { // from MySQL to textarea
			$text = html_entity_decode($text, ENT_QUOTES);
			$text = preg_replace('/<br \/>/', "\n", $text);
			
			return $text;
		}
	}
}
