<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {
	

	public function __construct() {
		parent::__construct();

	}
	
	public function index() {
	
	}
	
	public function customer_info() {
		
		$email = $this->input->get("email");
		
		$params['table'] = array('name' => ' mboos_customers', 'criteria_phrase' => 'mboos_customer_email="'. $email .'"');
		
		if($this->mdldata->select($params)) {
		
			$data = $this->mdldata->_mRecords;
				
			echo '{"customer_info":'. json_encode($data) .'}';
				
		} else {
				
			echo '{"error":{"text":"Error"}}';
		}
		
	}
	
	public function customer_edit() {
		
		$id = $this->input->post("cust_id");
		$name = $this->input->post("name");
		$addr = $this->input->post("address");
		$email = $this->input->post("email");
		$number = $this->input->post("number");
		
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
}