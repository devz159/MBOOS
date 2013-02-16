<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {
	

	public function __construct() {
		parent::__construct();

	}
	
	public function index() {
	
	}
	
	public function customer_info() {
		
		$email = mysql_real_escape_string($this->input->get("email"));
		
		$params['table'] = array('name' => ' mboos_customers', 'criteria_phrase' => 'mboos_customer_email="'. $email .'"');
		
		if($this->mdldata->select($params)) {
		
			$data = $this->mdldata->_mRecords;
				
			echo '{"customer_info":'. json_encode($data) .'}';
				
		} else {
				
			echo '{"error":{"text":"Error"}}';
		}
		
	}
	
	public function customer_edit() {
		
		$id = mysql_real_escape_string($this->input->post("cust_id"));
		$name = mysql_real_escape_string($this->input->post("name"));
		$addr = mysql_real_escape_string($this->input->post("address"));
		$email = mysql_real_escape_string($this->input->post("email"));
		$number = mysql_real_escape_string($this->input->post("number"));
		
		$params['fields'] = array(
					
				'mboos_customer_complete_name' => $name,
				'mboos_customer_addr' => $addr,
				'mboos_customer_email' => $email,
				'mboos_customer_phone' => $number
				
				);
		$params['table'] = array('name' => 'mboos_customers', 'criteria_phrase' => 'mboos_customer_id="'. $id . '"');
		
		if($this->mdldata->update($params))
			return true;
		
		return false;	
	}
	
	public function customer_order_summary() {
		
		$email = mysql_real_escape_string($this->input->get('currEmail'));
		
		if(isset($email)) {
		
			$params['table'] = array('name' => ' mboos_customers', 'criteria_phrase' => 'mboos_customer_email="'. $email . '"');
			$this->mdldata->select($params);
			
			$cust_info = $this->mdldata->_mRecords;
			
			$cust_id = $cust_info[0]->mboos_customer_id;
			$this->mdldata->reset();
			$params['table'] = array('name' => ' mboos_orders', 'criteria_phrase' => 'mboos_customer_id="'. $cust_id . '"');
			
			$this->mdldata->select($params);
			
			$cust_order_summary = $this->mdldata->_mRecords;
			
			echo '{"orders_summary":'. json_encode($cust_order_summary) .'}';
			
		}

	}
	
	public function order_summary_details() {
		
		$order_id = $this->input->get('order_id');
		
		$params['querystring'] = "SELECT mboos_orders.mboos_order_id,mboos_orders.mboos_order_date, mboos_orders.mboos_orders_total_price, mboos_orders.mboos_order_pick_schedule, mboos_order_details.mboos_order_detail_quantity, mboos_order_details.mboos_order_detail_price, mboos_products.mboos_product_id, mboos_products.mboos_product_name FROM `mboos_orders` left join mboos_order_details on mboos_orders.mboos_order_id=mboos_order_details.mboos_order_id left join mboos_products on mboos_products.mboos_product_id=mboos_order_details.mboos_product_id where mboos_orders.mboos_order_id='". $order_id . "'";
		
		$this->mdldata->select($params);
		
		$summary_details = $this->mdldata->_mRecords;
		//call_debug($summary_details);
		$dateToBePickUp = $summary_details[0]->mboos_order_pick_schedule;
		$dateOrdered = $summary_details[0]->mboos_order_date;
		
		echo '{"summary_details":'. json_encode($summary_details) .', "dateToBePickUp":[{"datePickUpFormmated":"'. getDateArr($dateToBePickUp) . '", "dateOrderd":"'.  getDateArr($dateOrdered) . '"}]}';
	}
	
	public function editPassword() {
		
		$cust_id = $this->input->post("cust_id");
		$pword = md5($this->input->post('pw'));
		
		$params['table'] = array('name' => 'mboos_customers', 'criteria_phrase' => 'mboos_customer_id="'. $cust_id . '" and mboos_customer_pword="'. $pword . '"');
		
		$this->mdldata->select($params);
		
		if($this->mdldata->_mRowCount < 1) {
			
			echo "0";
			
		} else {
			
		  	echo "1";
		}
		
		
	}
	
	public function savePassword() {
		
		$cust_id = $this->input->post("cust_id");
		$pword = md5($this->input->post('pw'));
		
		$params['fields'] = array(
				'mboos_customer_pword' => $pword
				);
		$params['table'] = array('name' => 'mboos_customers', 'criteria_phrase' => 'mboos_customer_id="'. $cust_id . '"');
		
		if($this->mdldata->update($params)) {
			echo "1";
		} else {
			echo "0";
		}
	}
}