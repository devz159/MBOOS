<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * This is a generic Session Browser
 * that reads several session variables.
 * 
 * @license GPL
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Saturday, November 12, 2011
 * @version 2.0.1
 * 
 * Instructions:
 * 
 * 		EXTERNAL TEXTFILE 
 * 			config.txt  // resides at APPPATH . '/config/';
 * 
 * 			Data Format: //  <section_uniquevarname>:<UNIQUENAMESESSIONVARIABLE>
 * 			------ INSIDE config.txt FILE -------- 
 * 				advr_uname:ADVR_USERNAME
 *				advr_islog:ADVR_ISLOGGEDIN
 *				advr_fullname:ADVR_FULLNAME
 *				site_uname:SITE_USERNAME
 *				site_islog:SITE_ISLOGGEDIN
 *				site_fullname:SITE_FULLNAME
 *			------ INSIDE config.txt FILE --------
 *
 *
 * 		SAMPLE CODE:
 * 			// setInfo(); 
 * 			$params = array(
 *							'advr_uname' => 'kennvall@gmail.com',
 *							'advr_islog' => TRUE,
 *							'advr_fullname' => 'Kenneth Vallejos'
 *						);
 *			
 *			$this->sessionbrowser->setInfo($params); // returns TRUE if successful, otherwise FALSE
 *
 *			
 *			// getInfo();
 *			$params = array('advr_uname', 'advr_islog', 'advr_fullname');
 *			$this->sessionbrowser->getInfo($params); // returns TRUE if successful, otherwise FALSE
 *			
 *
 *			// destroy();
 *			$params = array('advr_uname', 'advr_islog', 'advr_fullname');
 *			$this->sessionbrowser->destroy($params); // returns TRUE if successful, otherwise FALSE
 *			
 *			// DATA:
 *			$arr = $this->sessionbrowser->mData; // returns array
 *
 */
class Sessionbrowser {

	private $_mSession;
	private $_mCI;	
	public $mData;
		
	public function __construct() {
		
		//echo 'Initializing SessionBrowser Class...';
		
		// initializes super CI global object
		$this->_mCI =& get_instance();
		$this->mData = array();
			
		// loads a library
		$this->_mCI->load->library('file_maker');		
		$config = array('filename' => 'config.txt', 'path' => APPPATH . 'config/', 'char_struct' => 'kenn:genius');	
		$this->_mCI->file_maker->initialize($config);
		$this->_mCI->file_maker->parseData();
				
		// initializes some variables
		foreach ($this->_mCI->file_maker->mData as $key => $val) {
			$this->$key = trim($val);
		}
	}
	
	public function __call($name,  $params) {
		$tempArr;
		$method = '_' . $name;
		
		if(method_exists($this, $method)) {
			return $this->$method($name, $params);
		} else {
			return $this->_noMethod($name);
		}
			
	}
	
	private function _setInfo($name = '', $params = array()) {
				
		if(count($params)< 1)
			return FALSE;			
		
		// simplifies array
		$params = $params[0];
		
		foreach ($params as $key => $val) {
			$this->_mCI->session->set_userdata($this->$key, $val);
		}
				
		return TRUE;
	}
	
	private function _getInfo($name = '', $params = array()) {
		$sessionName;		                                                   
		
		if(count($params) < 1)
			return FALSE;
		
		// simplifies array
		$params = $params[0];		
		
		foreach ($params as $val) {
			$this->mData[$val] = $this->_mCI->session->userdata($this->$val);	
		}
		
		return TRUE;
	}
	
	private function _destroy($name = '', $params = array()) {
		
		if(count($params) < 1)
			return FALSE;
		
		// simplifies array
		$params = $params[0];
		
		foreach ($params as	$value) {
			$this->_mCI->session->unset_userdata($this->$value, '');
		}

		return TRUE;
	}
	
	private function _noMethod($name) {
		echo '<br />No such method: ' . $name . ' exist.';
		return TRUE;
	}
	
}

