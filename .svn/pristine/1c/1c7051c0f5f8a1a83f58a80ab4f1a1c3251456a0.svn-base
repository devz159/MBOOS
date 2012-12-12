<?php  if(!defined("BASEPATH")) exit("No direct script access allowed");
/**
 * Renders preconfigured email class. Extends the the Email class.
 * @package 	Codeigniter
 * @subpackage	application/libraries
 * @author 		Kenneth "digiArtist_ph" P. Vallejos
 * @since 		Thursday, April 19, 2012
 * @version		1.0.1
 * 
 * 
 * 	SAMPLE CODE: {CONTROLLER}
 * 		
 * 		$params = array(
 * 						'sender' => 'info@somedomainname.com',
 * 						'receiver' => 'customer@otherdomainname.com',
 * 						'from_name' => 'Web Master', // OPTIONAL
 * 						'cc' => 'supervisor@otherdomainname.com', // OPTIONAL
 * 						'subject' => 'My Subject', // OPTIONAL
 * 						'msg' => 'My message', // OPTIONAL
 * 						'email_temp_account' => TRUE, // OPTIONAL. Uses your specified google account only. Please see this method "_tmpEmailAccount" below (line 111).
 * 						'usersettings' => array( // 'usersettings' is OPTIONAL
 * 												'protocol' => 'sendmail',  // OPTIONAL
 *												'mailpath' => '/usr/sbin/sendmail', // OPTIONAL
 *												'charset' => 'iso-8859-1', // OPTIONAL
 *												'wordwrap' => TRUE	 // OPTIONAL
 * 											) 
 * 					);
 * 
 * 		$this->load->library('emailutil', $params);
 * 					OR
 * 		$this->load->library('emailutil'); $this->emailutil($params);
 * 
 *		$this->emailutil->send(); // returns TRUE if the email is send. FALSE otherwise
 * 
 */ 
class Emailutil {

	public $_mError;
	private $_mEmailTemporary;
	private $_mUserEmailSettings;
	private $CI;
	
	function __construct($params = array()) {
		
		// initializes some member variables
		$this->_mEmailTemporary = FALSE;
		$this->_mUserEmailSettings = FALSE;
		$this->_mError = '';
		$this->CI =& get_instance();
		
		//echo 'Initializing Emailutil library<br />';
		
		if(!empty($params)) // if $params is defined then pass it to intialize method
			$this->initialize($params);		
		
	}

	public function initialize($params) {
		
		if(empty($params))
			return FALSE;

		if(!array_key_exists('sender', $params))
			return FALSE;
		
		if(!array_key_exists('receiver', $params)) // no email for receiver, then exit from the method
			return FALSE;
		
		if(!array_key_exists('usersettings', $params))
			$this->_mUserEmailSettings = TRUE;
		
		if(array_key_exists('email_temp_account', $params))
			$this->_mEmailTemporary = TRUE;
		
		// preps some data/info and variables here
		$sender = $params['sender'];
		$fromName = (array_key_exists('from_name', $params) ? $params['from_name'] : "Your Name") ;
		$receiver = $params['receiver'];
		$cc = (array_key_exists('cc', $params) ? $params['cc'] : '');
		$subject = (array_key_exists('subject', $params) ? $params['subject'] : 'No Subject Provided');
		$msg = '';		
		$msg .= (array_key_exists('msg', $params) ? $params['msg'] : ' --- No msg provided ---');
		
		// end prep
		
		// loads the email class
		$this->CI->load->library('email', ($this->_mEmailTemporary) ? $this->_tmpEmailAccount() : $this->_loadDefaultEmailSettings(($this->_mUserEmailSettings) ? $params['usersettings'] : array() ));
		
		if($this->_mEmailTemporary)
			$this->CI->email->set_newline("\r\n");
		
		$this->CI->email->from($sender, $fromName);
		$this->CI->email->to($receiver);
		
		$this->CI->email->subject($subject);
		$this->CI->email->message($msg);		
		
		return TRUE;
		
	}
	
	public function send() {
		
		if($this->CI->email->send() === FALSE) {
			/*$this->_mError = $this->CI->email->print_debugger();*/ //on_watch('watching');
			return FALSE;
		}		
		
		return TRUE;
		
	}
	
	private function _tmpEmailAccount() {
		/**
		 * This email settings are for you to provide.
		 * You may need to refer to your email hosting account's documentation for their settings.
		 */
		$config = array(
					'protocol' => 'smtp',
					'smtp_host' => 'ssl://smtp.googlemail.com',
					'smtp_port' => 465,
					'smtp_user' => 'mboosCOM@gmail.com',
					'smtp_pass' => 'accountpassword', // real password hidden elsewhere
					'mailtype' => 'html'
				);
		
		return (array)$config;
	}
	
	private function _loadDefaultEmailSettings($userSettings = array()) {
		
		if(empty($userSettings)) {
			$config = array(
					'protocol' => 'sendmail',
					'mailpath' => '/usr/sbin/sendmail',
					'charset' => 'iso-8859-1',
					'mailtype' => 'html',
					'wordwrap' => TRUE );
		} else {
			$config = (array)$userSettings;
		}
		
		return (array)$config; // casts data type into an array
		
	}
	
}

