<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->library('cart');
		$this->load->library('cart_utility');
	}
	
	public function index()
	{
		
		$string = "+'id'=>'1','name'=>'ian',+'id'=>'2','name'=>'paul',+'item_id'=>'3'";
		call_debug($string, false);
		$this->cart_utility->stringToArray($string);
		
		$data = $this->cart_utility->_mItemList;
		
		call_debug($data);
		
	$this->load->view('test');			
	}
}

