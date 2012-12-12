<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(! function_exists('isSection')) {
		
		function isSection($section, $part = 1) {
			$CI =& get_instance();	
			
			if(strtolower($CI->uri->segment($part)) != strtolower($section))
				return FALSE;
						
			return TRUE;
		}		
	}
	
	if(! function_exists('getHeader')) {
		
		function getHeader() {
			
			$CI =& get_instance();
			$data['section'] = '';
			/*
			echo $CI->uri->uri_string();
			die();*/
			($CI->uri->segment(1) == "") ? 	$data['section'] = 'home' : '';
				
			if(isSection('home', 1))
				$data['section'] = 'home';
				
			if(isSection('directory', 1))
				$data['section'] = 'search';
				
			if(isSection('search', 2))
				$data['section'] = 'search';
			
			if(isSection('listing', 2))
				$data['section'] = 'listing';
			
			if(isSection('register', 2))
				$data['section'] = 'register';
				
			if(isSection('my', 2) || isSection('my', 1) || isSection('advertiser', 1))
				$data['section'] = 'my';
				
			if(isSection('edit_list', 4))
				$data['section'] = 'edit_list';
				
			if(isSection('validate_edit', 3))
				$data['section'] = 'validate_edit';
			
			if(isSection('login', 1))
				$data['section'] = 'login';
			
			if(isSection('admin', 1))
				$data['section'] = 'admin';
				
					
			$CI->load->view('includes/header', $data);
		}
		
	}
	
	if(! function_exists('getSideBar')) {
		
		function getSideBar($sidebar = '') {
			$CI =& get_instance();
			
			$data['sidebar'] = $sidebar;			
			$CI->load->view('includes/directory/sidebar', $data);
			
		}
	}
	
	if(! function_exists('getAdminSideBar')) {
		function getAdminSideBar() {
			$CI =& get_instance();
			$data['section'] = '';
			
			($CI->uri->segment(1) == "") ? 	$data['section'] = 'admin' : '';
				
			if(isSection('admin', 1))
				$data['section'] = 'advertisers';
				
			if(isSection('advertisers', 4))
				$data['section'] = 'advertisers';
			
			if(isSection('categories', 4)|| isSection('newcategory', 4) || isSection('editcategory', 4) || isSection('validatenewcategory', 3) || isSection('validateeditcategory', 3))
				$data['section'] = 'categories';
				
			if(isSection('subcategories', 4) || isSection('newsubcategory', 4) || isSection('editsubcategory', 4) || isSection('validatenewsubcategory', 3) || isSection('validateeditsubcategory', 3))
				$data['section'] = 'subcategories';
				
			if(isSection('products', 4) || isSection('newproduct', 4) || isSection('editproduct', 4) || isSection('validatenewproduct', 3) || isSection('validateeditproduct', 3))
				$data['section'] = 'products';
				
			if(isSection('listings', 4))
				$data['section'] = 'listings';
			
			if(isSection('states', 4) || isSection('newstate', 4) || isSection('editstate', 4) || isSection('validatenewstate', 3) || isSection('validateeditstate', 3))
				$data['section'] = 'states';
			
			if(isSection('countries', 4) || isSection('newcountry', 4) || isSection('editcountry', 4) || isSection('validatenewcountry', 3) || isSection('validateeditcountry', 3))
				$data['section'] = 'countries';
				
			if(isSection('allarticles', 4) || isSection('editarticle', 4) || isSection('validateeditarticle', 3))
				$data['section'] = 'allarticles';
				
			if(isSection('newarticle', 4))
				$data['section'] = 'newarticle';
				
			if(isSection('sections', 4)|| isSection('newsection', 4) || isSection('editsection', 4))
				$data['section'] = 'sections';
				
			if(isSection('users', 4) || isSection('edituser', 4) || isSection('validateeditsection', 3) || isSection('newuser',4) || isSection('validatenewuser',3))
				$data['section'] = 'users';
				
			if(isSection('generalsetttings', 4) || isSection('validateeditsettings', 3))
				$data['section'] = 'generalsetttings';
				
			if(isSection('emails', 4) || isSection('newemail',4) || isSection('editemail', 4) || isSection('validatenewemail',3))
				$data['section'] = 'emails';
				
			$CI->load->view('includes/adminsidebar', $data);
		}
	}
	
	if(! function_exists('viewSearchBar')) {
		function viewSearchBar() {
			$CI =& get_instance();
			$data['section'] = '';
			
			// listing details page
			if(isSection('details', 3))	
				return TRUE;
			
			return FALSE;
		}
	}
	
	if(! function_exists('getFooter')) {
		function getFooter() {
			$CI =& get_instance();
			$data['section'] = '';
			
			($CI->uri->segment(1) == "") ? 	$data['section'] = 'home' : '';
			
			if(isSection('admin', 1))
					$data['section'] = 'admin';
					
			$CI->load->view('includes/footer', $data);
		}
	}
	
	if(! function_exists('getProfileSideBar')) {
		function getProfileSideBar($sectiononly = FALSE) {
			$CI =& get_instance();
			$data['section'] = '';
			
			(isSection('my', 2)) ?	$data['section'] = 'profile' : '';
			
			(isSection('profile', 4)) ?	$data['section'] = 'profile' : '';
			
			(isSection('change_password', 4)) ? $data['section'] = 'change_password' : '';
			
			(isSection('validate_change_password', 3)) ? $data['section'] = 'change_password' : '';
				
			(isSection('active_list', 4)) ? $data['section'] = 'active_list': '';
			
			(isSection('edit_list', 4)) ? $data['section'] = 'edit_list': '';
			
			(isSection('validate_edit', 3)) ? $data['section'] = 'validate_edit': '';
			
			(isSection('expired_list', 4)) ? $data['section'] = 'expired_list' : '';
				
			(isSection('payment', 4)) ? $data['section'] = 'payment' : '';				
			
			if (!$sectiononly)
				$CI->load->view('includes/sidebar', $data);
			
			return $data['section'];
		}
	}
	
?>
