<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypal extends CI_Controller {
	
	public $_mItemList;
	public $_tmpArray;

	public function __construct() {
		parent::__construct();
		
		$this->_mItemList = array();
		$this->_tmpArray = array();
	}
	
	public function index() {
		
		$strOrder = $this->input->get("stringOrder");
		
		$this->paypal_validate($strOrder);
	}
	
	public function paypal_validate($order) {
		
		$pattern = '/,\|/';
		$replacement = '|';
		
		$strOrder = preg_replace($pattern, $replacement, $order);
	
		
		$orderItem = explode("||", $strOrder);
	
		
		foreach($orderItem as $v) {
			
			if($v != "" && preg_match('/=>/',$v)):
			
				$this->_tmpArray[] = $v;
			
			endif;
			
		}
		
		$array = $this->_tmpArray;

		foreach($array as $k => $v):
		
		$tmpArray = preg_split("/,/", $v);

		// remove single qoute
		$pattern1 = "/'/";
		$array = preg_replace($pattern1, "", $tmpArray);

		foreach($array as $val) {
			
			$keyVal = preg_split('/=>/',$val);
				
			$cleandArray[$k][trim($keyVal[0])] = trim($keyVal[1]);
			
		}
			
		endforeach;
		
		$this->_mItemList = $cleandArray;
		
		$data['order'] = $this->_mItemList;
		
		
		$data['main_content'] = 'paypal_view/paypal_process_view';
		$this->load->view('includes/template', $data);
		
	}
	
	public function thankyou() {
		
		$data['main_content'] = 'admin/paypal_view/paypal_success_view';
		$this->load->view('includes/template', $data);
	
	}
}

