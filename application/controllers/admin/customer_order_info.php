<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_order_info extends CI_Controller {

	
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
		
		$params['querystring'] = 'SELECT mboos_customers.mboos_customer_id, mboos_customers.mboos_customer_complete_name, mboos_customers.mboos_customer_addr, mboos_orders.mboos_order_id, mboos_orders.mboos_order_date
								FROM mboos_customers
								LEFT JOIN mboos_orders ON mboos_orders.mboos_customer_id = mboos_customers.mboos_customer_id
								WHERE mboos_customers.mboos_customer_status = "1"';
								
		$this->mdldata->reset();
		$this->mdldata->select($params);
		$data['customer_orders'] = $this->mdldata->_mRecords;
		
		$data['main_content'] = 'admin/report_view/customer_order_info_view';
		$this->load->view('includes/template', $data);
	}
}











