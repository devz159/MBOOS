<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * @package			CodeIgniter
 * @subpackage    	Application/Libraries
 * @category        Libraries
 * @author			Kenneth P. Vallejos
 * @link			http://n2esolutions.org
 * @version			2.1.1
 *
 *	Instructions:
 *		- The parameters ($config) array should be declared on the CONSTRUCTOR section of the CONTROLLER.
 *
 *		SAMPLE CODE:	
 *			
 *			{Controller}
 *			
 *			private $_mConfig;
 *
 *			public function __construct() {
 *		 		parent::__construct();
 *				
 *				$config['wrapper'] = array('div|class:classname1 classname2', 'ul|id:idname');
 *				$config['classes'] = array('li' => '', 'a' => 'sprite', 'span' => 'sprite');
 *		 		$config['menu_items'] = array('Profile' =>  base_url() .'advertiser/profile', 'Package' => base_url() .'advertiser/package', 'Payment Method' => '#', 'Sign-Out' => base_url() . 'advertiser/sign_out');
 *		 		$config['session'] = array('advr_uname', 'advr_islog', 'advr_fullname');
 *		 		
 *				$this->_mConfig = $config;
 *			}
 *
 *			public function someMethod() {
 *
 *				...
 *
 *				$this->load->library('warden', $this->_mConfig);
 *				$this->warden->build();
 *				$data['warden'] = $this->warden->_mData;
 *
 *				$data['$main_content'] = ''my/profile/search agent/profile_view';
 *				$this->load->view('includes/template,', $data);
 *			}
 *
 */
class Warden {

	private $_mCI;
	private $_mConfig;
	private $_mFlag;
	public $_mData;
	
	public function __construct($params = array()) {

		// initializes some values
		$this->_mCI =& get_instance();
		$this->_mConfig = null;
		$this->_mFlag = FALSE;
		$this->_mData = null;

		//echo 'Initializing Warden Class...<br />';
		
		if(! empty($params))
			$this->initialize($params);			
	}	
 		
	public function initialize($config) {
		
 		if( ! array_key_exists('classes', $config))
 			return FALSE;
 		
 		if(! array_key_exists('menu_items', $config))
 			return FALSE;
 		
 		if( ! array_key_exists('session', $config))
 			return FALSE;
		
		$this->_mCI->load->library('menu');
 		$this->_mCI->menu->initialize($config);
 		 		
 		$this->_mConfig = $config;
		
 		$this->_mFlag = TRUE;
 		
		return $this->_mFlag;		
	}
	
	public function build() {		
		
		if($this->_mFlag === FALSE)	
			return FALSE;
			
		if($this->_goFlag($this->_mConfig['session'])) {			
			$this->_mData = $this->_mCI->menu->buildMenu('', '', '');
			
		} else {			
			$this->_mData = '';
		}
			
		return TRUE;
	}
	
	protected function _goFlag($params, $email = TRUE) {
		$arrData = null;
		$flag =  FALSE;
		$email = FALSE;
		$pattern = '/([\w]+)@[\w]+\.+[\w]{2,4}/'; // email			
		
		// loads a library.
		$this->_mCI->load->library('sessionbrowser');
		
		if($this->_mCI->sessionbrowser->getInfo($params))
			$arrData = $this->_mCI->sessionbrowser->mData;
		else
			return FALSE;
		
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