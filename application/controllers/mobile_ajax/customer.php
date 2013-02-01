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
		$params['table'] = array('name' => 'mboos_customers', 'criteria' => 'mboos_customer_id', 'criteria_value' => id);
		
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
}