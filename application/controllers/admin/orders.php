<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {

	
	private $_arr;
	
	public function __construct() {
		parent::__construct();
	
		$params = array('sadmin_uname', 'sadmin_islogin', 'sadmin_ulvl', 'sadmin_uid');
		$this->sessionbrowser->getInfo($params);
		$this->_arr = $this->sessionbrowser->mData;
		
	}
	
	public function index(){  
		
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$data['main_content'] = 'admin/order_view/order_view';
		$this->load->view('includes/template', $data);
		
	}
	
	private function _toQueryChecking(){
		
		$params['querystring'] = 'SELECT * FROM `mboos_orders` left join mboos_customers on mboos_orders.mboos_customer_id=mboos_customers.mboos_customer_id
								WHERE mboos_orders.mboos_order_status="1"'; 
										
		if(!$this->mdldata->select($params))
			return false;
		else
			return $this->mdldata->_mRecords;
	}
	
	private function _toQueryProcessing(){
	
		$params['querystring'] = 'SELECT * FROM `mboos_orders` left join mboos_customers on mboos_orders.mboos_customer_id=mboos_customers.mboos_customer_id
		WHERE mboos_orders.mboos_order_status="2"';
	
		if(!$this->mdldata->select($params))
			return false;
		else
			return $this->mdldata->_mRecords;
	}
	
	public function manage_order(){
		
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
	
		$data['orders'] = $this->_toQueryChecking();	
		
		$data['main_content'] = 'admin/order_view/manage_order_view';
		$this->load->view('includes/template', $data);
	}
	
	public function check_validate(){
		
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$order_id = $this->uri->segment(4);
		//call_debug($order_id);
		$params = array(
				'table' => array('name' => 'mboos_orders', 'criteria_phrase' => 'mboos_order_id= "' . $order_id . '"'),
				'fields' => array('mboos_order_status' => 2 ));
		
		$this->mdldata->reset();
		$this->mdldata->update($params);
		
		redirect('admin/orders/manage_order');
/* 		$data['orders'] = $this->_QueryOrderRecord();	
		
		$data['main_content'] = 'admin/order_view/manage_order_view';
		$this->load->view('includes/template', $data); */
	}
	
	public function process_order(){
	
		authUser();
	
		$data['sessVar'] = $this->_arr;
	
		$order_id = $this->uri->segment(4);
		//call_debug($order_id);
		$params = array(
				'table' => array('name' => 'mboos_orders', 'criteria_phrase' => 'mboos_order_id= "' . $order_id . '"'),
				'fields' => array('mboos_order_status' => 2 ));
	
		$this->mdldata->reset();
		$this->mdldata->update($params);
	
		
		$data['orders'] = $this->_toQueryProcessing();
	
		$data['main_content'] = 'admin/order_view/process_order_view';
		$this->load->view('includes/template', $data); 
	}
	
	public function process_validate(){
	
		authUser();
	
		$data['sessVar'] = $this->_arr;
	
		$order_id = $this->uri->segment(4);
		//call_debug($order_id);
		$params = array(
				'table' => array('name' => 'mboos_orders', 'criteria_phrase' => 'mboos_order_id= "' . $order_id . '"'),
				'fields' => array('mboos_order_status' => 2 ));
	
		$this->mdldata->reset();
		$this->mdldata->update($params);
	
		redirect('admin/orders/process_order');

	}
	
		
	
		public function processing(){
			
			authUser();
			
			$data['sessVar'] = $this->_arr;
		
		$order_id = $this->uri->segment(4);
		//call_debug($order_id);
		$params = array(
				'table' => array('name' => 'mboos_orders', 'criteria_phrase' => 'mboos_order_id= "' . $order_id . '"'),
				'fields' => array('mboos_order_status' => 3 ));
		
		$this->mdldata->reset();
		$this->mdldata->update($params);
		
		$data['orders'] = $this->_QueryOrderRecord();	
		
		$data['main_content'] = 'admin/order_view/manage_order_view';
		$this->load->view('includes/template', $data);
	}
	
	public function completed_order(){
		
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$params['querystring'] = 'SELECT * FROM mboos_orders 
								WHERE mboos_orders.mboos_order_status="3"'; 
			
		$this->mdldata->reset();
		$this->mdldata->select($params);
		$data['completed'] = $this->mdldata->_mRecords;
		
		$data['main_content'] = 'admin/order_view/completed_order_view';
		$this->load->view('includes/template', $data);
	}
	
}











