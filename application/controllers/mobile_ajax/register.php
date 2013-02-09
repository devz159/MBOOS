<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
	
	}
	
	/* get all product categories */
	public function index() {
		
 		$uName =  mysql_real_escape_string($this->input->post("cname"));
		$uAddr =  mysql_real_escape_string($this->input->post("address"));
		$uEmail =  mysql_real_escape_string($this->input->post("email"));
		$ucpNumber =  mysql_real_escape_string($this->input->post("cpnumber"));
		$uPassword =  md5($this->input->post("pword")); 
		
		
		//$query=$this->db->query("call sp_select_customer(1,@insertorderstatus)");
		//$data  = $query->result();
		//$query=$this->db->query("call sp_insert_customer('name of tongbens', 'address', 'email', 'pword', 'phone', 'ian', @insertorderstatus)");
		//$data = $query->result();
		//call_debug($data);
		$this->register($uName, $uAddr, $uEmail, $ucpNumber, $uPassword);	
			
	}
	
	private function register($name, $addr, $email, $number, $pword) {
		
/* 		$params['fields'] = array(
					
				'mboos_customer_complete_name' => $name,
				'mboos_customer_addr' => $addr,
				'mboos_customer_email' => $email,
				'mboos_customer_phone' => $number,
				'mboos_customer_pword' => $pword
				
				); */
		$params = array(
					
				'mboos_customer_complete_name' => $name,
				'mboos_customer_addr' => $addr,
				'mboos_customer_email' => $email,
				'mboos_customer_pword' => $pword,
				'mboos_customer_phone' => $number
				
		
		);
		$this->db->query("CALL sp_insert_customer(?,?,?,?,?,1,@insertorderstatus)", $params);
		//$params['table'] = array('name' => 'mboos_customers');
		
		//if($this->mdldata->insert($params)) 
		//	return true;

		return true;
	}
	
	public function email_checker() {
		
		$email = mysql_real_escape_string($this->input->post("email"));
		
		$params['table'] = array('name' => 'mboos_customers', 'criteria_phrase' => 'mboos_customer_email="'. $email . '"');
		
		$this->mdldata->select($params);
		
		if($this->mdldata->_mRowCount < 1 ) {
			
			echo "0";
			
		} else {
			
			echo "1";
			
		}
	}
	
}