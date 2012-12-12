<?php if( !defined('BASEPATH')) exit('No direct script access allowed');
/** 
 *
 * This is a menu builder library returns a DOM of nodes in a string form.
 * 
 * Sample output:
 * 				<li class="selected"><a class="sprite" href="#"><span class="sprite">Profile</span></a></li>
 *              <li><a class="sprite" href="#"><span class="sprite">Package</span></a></li>
 *              <li><a class="sprite" href="#"><span class="sprite">Payment Method</span></a></li>';
 *              
 *
 * @package			CodeIgniter
 * @subpackage    	Application/Libraries
 * @category        Libraries
 * @author			Kenneth P. Vallejos
 * @link			http://n2esolutions.org
 * @version			1.0.1
 *
 *
 *		Instructions:
 *			
 *			{Controller} or {View}
 *				$config['wrapper'] = array('div|class:classname1 classname2', 'ul|id:idname'); OPTIONAL | It just wraps the generated html DOM into.
 *					sample: <div class="classname1 classname2"><ul id="idname"><GENERATED HTML DOM></ul></div>
 *
 *				$config['classes'] = array('li' => '', 'a' => 'sprite', 'span' => 'sprite');
 *				$config['menu_items'] = array('Profile' =>  base_url() .'advertiser/profile', 'Package' => base_url() .'advertiser/package', 'Payment Method' => '#');
 *			
 *				$CI =& get_instance(); // this is only necessary if the library is called from views
 *			
 *				$CI->load->library('menu', $config) or 	$CI->menu->initialize($config);
 *							
 *				$strSubMenu .= $CI->menu->buildMenu('Payment Method', 'li', 'selected');
 *					First parameter: Menu_item, Second Parameter: Node Element of the html, Third Parameter: the actual class name.
 *
 *				note: replace "$CI" with "$this" if you're in a Controller or Model, otherwise use "$CI"  
 */
class Menu {
	
	private $_mConfig;
	private $_mArrWrapper;
	
	public function __construct($params = array()) {
		// initializes some variables		
		$this->_mArrWrapper = array();
		
		if(!empty($params)){
			$this->initialize($params);		
		}
		
		// echo 'Done initialising Menu Class...';
	}
	
	public function initialize($config) {
		// passes the parameter into the member variable.
		$this->_mConfig = $config;
		
		// checks for required array keys
		if(! array_key_exists('classes', $config))
			return FALSE;
			
		if(! array_key_exists('menu_items', $config))
			return FALSE;
		
		return TRUE;
	}

	private function _prepWrapper($wrapper) {		
		$pattern = '/([\w]+)((\|)(\w)+(:)((\w)+[\s]?)+)?/';
		$arrCount = 0;
		$element;
		$attrib;
		$output = '';
		preg_match($pattern, $wrapper, $matches);
		
		
		if(preg_match($pattern, $wrapper)){
			
			// counts the array.
			$arrCount = count($matches);
			
			
			if($arrCount > 2) { // we have long string full matched >>> 'div|class:classone classtwo'
				$attrib = preg_split('/:/', $matches[2]);
				
				$attrib = trim($attrib[0], '|') . '="' . $attrib[1] . '"';
				$element = $matches[1]; // gets the html element.
				array_push($this->_mArrWrapper, $element);
				$output .= '<' . $element . ' ' . $attrib . '>';
			} else {
				$element = $matches[1]; // gets the html element.
				array_push($this->_mArrWrapper, $element);
				$output .= '<' . $element . '>';
			}
								
		} 
		
		return  $output;
		
	}
	
	public function buildMenu($menuItem, $elem, $class) {
		$output = '';
		$outputWrapper = '';
		$strClasses = '';
		
		$config = $this->_mConfig;
		
		foreach ($config['menu_items'] as $mItem => $mLnk) {
			
			foreach ($config['classes'] as $cNode => $cNodeValue) {
				
				$strClasses .= $cNodeValue . ' ';
				if(strtolower($mItem) == strtolower($menuItem) && strtolower($cNode) == strtolower($elem)) {
					$strClasses .= $class;					
				}
								
				// trims the classes string
				$strClasses = trim($strClasses);
				
				if(strtolower($cNode) == 'a') {
					$output .= '<' .  $cNode . ' ' . 'href="' . $mLnk . '" ';
				} else {				
					$output .= '<' . $cNode;
				}
				
				$output .= $strClasses!=''? ' class="' . $strClasses . '"' . '> ' : '>';
				
				// clears the $strClasses variable
				$strClasses = '';
			}
			
			$output .= $mItem;
			
			foreach (array_reverse($config['classes']) as $cNode => $value) {
				$output .= '</' . $cNode . '>';
			}
		}
		
		if(array_key_exists('wrapper', $config)) {
			foreach ($config['wrapper'] as $wrapper) {
				$outputWrapper .= $this->_prepWrapper($wrapper);
			}
			
			$outputWrapper .= $output;
			
			foreach (array_reverse($this->_mArrWrapper) as $rWrapper) {
				$outputWrapper .= '</' . $rWrapper . '>';
			}
			
			$output = $outputWrapper;
		}
		
		return  trim($output);
		
	}

}