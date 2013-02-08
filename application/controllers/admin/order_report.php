<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_report extends CI_Controller {

	
	private $_arr;
	
	public function __construct() {
		parent::__construct();
		
		$this->load->helper(array('form'));
		
		$params = array('sadmin_uname', 'sadmin_islogin', 'sadmin_ulvl', 'sadmin_uid');
		$this->sessionbrowser->getInfo($params);
		$this->_arr = $this->sessionbrowser->mData;
		
	}
	
	public function index(){  
		$this->order_report();
	}
	
	public function order_report(){
	
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$data['main_content'] = 'admin/report_view/order_report_view';
		$this->load->view('includes/template', $data);
	}
}











