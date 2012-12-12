<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @package application/helper
 * @version 1.0.1
 * 
 */
	if(! function_exists('codeToImage')) {
		function codeToImage($int) {
			$output = '';
			
			switch(intval($int)) {
				case 0:
					$output .= 'pending';
					break;
				case 1:
					$output .= 'active';
					break;
				case 2:
				default:
					$output .= 'inactive';					
			}
			
			return $output;
		}
	}
	
	if(! function_exists('categoryLookUp')) {
		function categoryLookUp($str) {
			$CI =& get_instance();
			
			$output = '';
			$arrCateg = array();
			$arrCateg = explode(",", $str);
			
			if(empty($arrCateg))
				return $output;
						
			$CI->load->model('mdldata');
			
			foreach ($arrCateg as $sc) {
				$params['querystring'] = 'SELECT * FROM subcategories WHERE scat_id=' . intval($sc);
				
				$CI->mdldata->reset();
				$CI->mdldata->select($params);
				$val = $CI->mdldata->_mRecords;
				
				if(isset($val[0]))
					$output .= $val[0]->sub_category . ', ';
			}
			
			$pattern = '/^[\w\s,]+(?=,)/';
			
			if(preg_match($pattern, $output, $matches))
				$output =$matches[0];
			
			return $output;
			
		}
	}
	
	if(! function_exists('imagePosition')) {
		function imagePosition($file) {
			$output = '';
			
			$output .= 'style="';
			
			define("PIXMAXWIDTH", 244);
			define("PIXMAXHEIGHT", 222);
			
			$data = getimagesize($file);
			$width = $data[0];
			$height = $data[1];
			
		
			if($width < PIXMAXWIDTH ) {
				$width = (PIXMAXWIDTH - $width) / 2;
				$output .= 'left:' . $width . 'px; ';
			}
			
			if($height < PIXMAXHEIGHT) {
				$height = (PIXMAXHEIGHT - $height)	 / 2;
				
				if($height > 0)
					$height -= 2;
					
				$output .= 'top:' . $height . 'px; ';
			}
			
			$output .= ' position:absolute;"';	
			
			return $output;
		}
	}
	
	if(! function_exists('display_error')) {
		function display_error($fld) {
			echo form_error($fld, '<span class="error">', '</span>');
		}
	}
	
?>