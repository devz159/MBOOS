<?php if (! defined('BASEPATH')) exit ('No direct script access allowed.');


if (! function_exists('getHeader')) {
	
	function getHeader() {
		$CI =& get_instance();
		$data['section'] = getSection();
			
		$CI->load->view('includes/header', $data);
		
	}
}

if(! function_exists('getSideBar')) {
	function getSideBar() {
		$CI =& get_instance();
		
		$data['section'] = getSection();
		
		$CI->load->view('includes/sidebar', $data);
		
	}
}

if (! function_exists('getFooter')) {
	function getFooter() {
		
		$CI =& get_instance();
		
		$data['section'] = getSection();
		$CI->load->view('includes/footer', $data);
		
	}
}

if (! function_exists('getSection')) {
	function getSection() {
		
		$CI =& get_instance();
		$section = '';
		$sought = '';
		$uri = uri_string();
		
		// generic
		$sought =  $CI->uri->segment(1);
		
		switch($sought) {
			case 'admin':
				$section = 'admin';
				break;
				
				
			default:
				$section = 'admin';
		}
		
		// specific
		
		// special
		
		return $section;
	}
}

if(! function_exists('getBreadcrumbs')) {
	function getBreadcrumbs() {
		$CI =& get_instance();
		
		$data['section'] = getSection();
		
		$CI->load->view('includes/breadcrumbs', $data);
	}
}

if(! function_exists('isSection')) {
		
		function isSection($section, $part = 1) {
			$CI =& get_instance();	
			
			if(strtolower($CI->uri->segment($part)) != strtolower($section))
				return FALSE;
						
			return TRUE;
		}		
}

if(! function_exists('toggleButton')) {
	function toggleButton($section, $tab = FALSE) {
		$CI =& get_instance();
		$val = '';
		$url = sprintf("%s/%s", $CI->uri->segment(1), $CI->uri->segment(2));
		
		if($tab) {
			if(strtolower($section) == strtolower($CI->uri->segment(1)))
				$val = " in ";
		} else {
			if(strtolower($section) == strtolower($url))
				$val = ' class="active" ';
		}
		
		return $val;	
	}
}

if(! function_exists('toggleBcrumbs')) {
	function toggleBcrumbs($section, $path) {
		$CI =& get_instance();
		$val = '';
		$url = sprintf("%s/%s", $CI->uri->segment(1), $CI->uri->segment(2));

		if(strtolower($path) == strtolower($url))
			$val = $section; 
		else
			$val = sprintf('<a class="ext_disabled" href="%s">%s</a>', base_url(strtolower($path)), $section); 

		return $val;	
	}
}
