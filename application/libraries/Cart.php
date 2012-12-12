<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed.');
/*
 * 
 * This is a Cart Class
 * that manages session variables that are 
 * associated in the checkout process.
 * 
 * @license GPL
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Saturday, January 14, 2012
 * @version 1.1
 * 
 * Instructions:
 * 		- It needs the sessionbrowser class. // resides at APPPATH . '/libraries/';
 * 		- It needs the config.txt  // resides at APPPATH . '/config/';
 * 
 * 		Methods
 * 			start() - resets all values of the session variables that are associated with the cart class
 * 			insert() - sets new values of the session variables
 * 				SAMPLE CODE: {Controller section}
 * 				
 *		 			$params = array(
 *							 'adTitle' => $this->input->post('title'),
 *							'adStreetAddress' => $this->input->post('streetaddress'),
 *							'adSuburb' => $this->input->post('suburb'),
 *							'adPostcode' => $this->input->post('postcode'),
 *							'adState' => $this->input->post('state'),
 *							'adCountry' => $this->input->post('country')
 *						);
 *		
 *					$this->load->library('cart');
 *					$this->cart->start(); // this method is required (at starting the cart class only)
 *					$this->cart->insert($params);
 *
 *			
 *			show() - retrieves all session variables that are associated with the cart class and stores an array of values into _mData member variable
 *				SAMPLE CODE: {Controller section}
 *					$params = array(
 *						'adPhone1' => $this->input->post('phone1'),
 *						'adPhone2' => $this->input->post('phone2'),
 *						'adEmail' => $this->input->post('email'),
 *						'adUrl' => $this->input->post('url')
 *					);
 *		
 *					$this->load->library('cart');
 *					$this->cart->insert($params);
 *		
 *					$this->cart->show();
 *					call_debug($this->cart->_mData, FALSE);
 *
 *			end() - clears all values of the session variables that are associated with the cart class
 *				SAMPLE CODE: {Controller section}
 *					$params = array(
 *						'adPhone1' => $this->input->post('phone1'),
 *						'adPhone2' => $this->input->post('phone2'),
 *						'adEmail' => $this->input->post('email'),
 *						'adUrl' => $this->input->post('url')
 *					);
 *		
 *					$this->load->library('cart');
 *					$this->cart->end();
 *		
 *
 */
class Cart {
	
	private $CI;
	
	public $_mData;
	
	public function __construct() {
		//echo 'Initialising Cart class.<br />';
		
		// initializes some member variables.
		$this->CI =& get_instance(); // refences to the core system of ci
		$this->_mData = array();
		
		// loads the sessionbrowser class
		$this->CI->load->library('sessionbrowser');
		
	}
	
	public function start() {

		$this->_purgeCart(); // resets all values from the cart
		
	}
	
	public function end() {
		
		$this->_purgeCart(); // deletes all values from the cart
		
	}
	
	public function insert($params) {
		
 		if( ! $this->CI->sessionbrowser->setInfo($params))
 			return FALSE;
 		
 		return TRUE;
	}
	
	public function show() {
		
		if( ! $this->_showAllValues())
			return FALSE;
					
		$this->_mData = $this->CI->sessionbrowser->mData;
		
		return TRUE;
	}
	
	private function _purgeCart() {
		
		// resets all current values from the cart class
		$params = array(
					'adTitle',			'adStreetAddress',
					'adSuburb',			'adPostcode',
					'adState', 			'adCountry', 
					'adPhone1',			'adPhone2', 
					'adEmail',			'adDescription',
					'adCategories',		'adImages',
					'acUser',			'acPword',
					'acFname',			'acLname',
					'acStreeAddress',	'acSuburb',
					'acPostcode', 		'acState', 
					'acCountry',		'acPhone1',
					'acPhone2', 		'acEmail',
					'acPaypal', 		'adUrl',
					'adPackageType',	'adRecurrentType',
					'adPaypal'
					);
					
		$this->CI->sessionbrowser->destroy($params);
		
		return TRUE;
	}
	
	private function _showAllValues() {
		
		$params = array(
					'adTitle',			'adStreetAddress',
					'adSuburb',			'adPostcode',
					'adState', 			'adCountry', 
					'adPhone1',			'adPhone2', 
					'adEmail',			'adDescription',
					'adCategories',		'adImages',
					'acUser',			'acPword',
					'acFname',			'acLname',
					'acStreeAddress',	'acSuburb',
					'acPostcode', 		'acState', 
					'acCountry',		'acPhone1',
					'acPhone2', 		'acEmail',
					'acPaypal',			'adUrl',
					'adPackageType',	'adRecurrentType',
					'adPaypal'
					);
					
		if( ! $this->CI->sessionbrowser->getInfo($params))
			return FALSE;
		
		return TRUE;
	}
}
