<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Sentinel Class 
 * 
 * @license GPL
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Tuesday, November 22, 2011
 * @version 2.1
 * 
 * 		Instructions:
 * 			Use this class on your controller to check for the validity the session on your browser.
 * 			Checks if the geniune user has logged in or not. 
 * 
 * 		Return Value: returns TRUE if user credentials validated. Otherwiser FALSE.
 * 
 * 		METHOD AVAILABLE:	goflag($params, [$email = TRUE]); //set $email to TRUE if EMAIL is being used when checking some check points, instead of USERNAME. Otherwise set FALSE.
 * 
 * 		SAMPLE CODE:
 * 			{Controller}
 * 			
 *				$params = array('advr_uname', 'advr_islog', 'advr_fullname');		
 *				if($this->sentinel->goFlag($params))
 *					echo 'Green Flag';
 *				else
 *					echo 'Red Flag';
 *
 *		
 */
class Sentinel {

	private static $__em_rec_IsLoggedIn = 'EMRECISLOGGEDIN'; // @todo: delete this (temporary class variable)
	private $_mCI;
	
	public function __construct() {
		
		// intialising some varibles
		$this->_mCI =& get_instance();
		
		//echo 'Initialising Sentinel Class.<br />';
		$this->_mCI->load->library('sessionbrowser');
	}
	
	public function __call($name, $params) {
		// goFlag($params)
		
		if(empty($params))
			return FALSE;
		
		if(count($params)< 1)
			return FALSE;	

		$params = $params[0];
		
			$method = '_' . $name;
			
			if(method_exists($this, $method)) {
				return $this->$method($params);
			} else {
				return FALSE;
			}
		
		return TRUE;
	}

	protected function _goFlag($params, $email = TRUE) {
		$arrData = null;
		$flag =  FALSE;
		$email = FALSE;
		$pattern = '/([\w]+)@[\w]+\.+[\w]{2,4}/'; // email			
		
		
		if($this->_mCI->sessionbrowser->getInfo($params))
			$arrData = $this->_mCI->sessionbrowser->mData;
		else
			return FALSE;

		//call_debug($arrData, FALSE);
		
		foreach ($arrData as $val) {
			if(preg_match($pattern, $val)) {
				$email = TRUE;
				break;
			}
		}
		
		foreach ($arrData as $val) {
			if($val === TRUE) {
				$flag = TRUE;
				break;
			}
		}
		
		if($email) {
			if(!$flag || !$email)
				return FALSE;
		} else {
			if(!$flag)
				return FALSE;
		}
		
		return TRUE;
	}
}