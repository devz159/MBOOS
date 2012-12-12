<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

/**
	@doccomment
	@Description: Check to see if checked attribute of checkbox should be having a true or checked value.
*/
if(!function_exists('selected_attrib')) {
	function selected_attrib($value, $attrib) {
		if(strtolower($value) == strtolower($attrib))
			return 'selected="selected"';
		else
			return '';
	}
}
/**
	@doccomment
	@Description: Check to see if checked attribute of radio button should be having a true or checked value.
	@sample code: <p>Standard FREE <input  type="radio" name="package" value="FREE" <?php echo checked_attribX($package[0], 'standard'); ?> /></p>
*/
if(!function_exists('checked_attribX')) {
	function checked_attribX($value, $attrib) {
		if(strtolower($value) == strtolower($attrib))
			return 'checked="checked"';
		else
			return '';
	}
}

if(!function_exists('checked_attrib')) {
	function checked_attrib($value) {
		if($value == 1)
			return 'checked="checked"';
		else
			return '';
	}
}

if(!function_exists('check_features')) {
	function check_features($features, $value) {
		//$featuresarr = explode(',', $features);
		
		/*echo '<pre>';
		print_r($features);
		die();
		*/
		foreach($features as $feature)
		{
			if($feature == $value)
				return 'checked="checked"';
			//echo 'feature: ' . $feature . '<br />';
		}
		//die();
		return '';
	}
}