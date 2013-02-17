<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypal extends CI_Controller {
	
	public $_mItemList;
	public $_tmpArray;
	public $_cust_id;
	public $_subtotal;
	public $_paypal_email;
	public $_readyToInsertQueryString;

	public function __construct() {
		parent::__construct();
		
		$this->_mItemList = array();
		$this->_tmpArray = array();
		
		$this->_cust_id = '';
		$this->_subtotal = '';
		$this->_paypal_email = '';
		$this->_readyToInsertQueryString = array();
		
	}
	
	public function index() {
			
		
		$strOrder = $this->input->get("stringOrder");
		//call_debug($strOrder, false);
		//if(isset($strOrder))
			//show_404();
		
		$this->_subtotal = mysql_real_escape_string($this->input->get("subtotal"));
		$this->_cust_id = mysql_real_escape_string($this->input->get("cust_id"));
		$this->_paypal_email = mysql_real_escape_string($this->input->get("paypal_email"));
		
		$this->sp_process_order($strOrder);
		
		/* $pattern = '/0/';
		if(preg_match($pattern, $this->_validate_item($strOrder))) {
			echo "<h3>Transaction Failed, Please Order Again</h3>";
		} else {
			
			$this->paypal_validate($strOrder);
		} */
	} 
	
	private function sp_process_order($itemList) {
		
		$timezone = "Asia/Manila";
		
		date_default_timezone_set($timezone);
		
		$pattern = '/,\|/';
		$replacement = '|';
		
		$strOrder = preg_replace($pattern, $replacement, $itemList);
		
		$orderArr = explode('||', $strOrder);
		
		$tmpArray = array();
		
		foreach($orderArr as $v) {
			if($v != "" && preg_match('/=>/',$v)):
			$tmpArray[] = $v;
			endif;
		}
		
		$array = $tmpArray;
		
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
		
		$data = $this->_mItemList;
		
		$string = "";
		
		for($i=0; $i < count($data); $i++) {
			
			$string .=$data[$i]['item_id']. "=>" .$data[$i]['qty']. ",";
			
		}
		
		$cleanString = substr($string, 0, -1);
		
		$currDate = date('Y-m-d H:i:s A');
		$generated_date = $this->process_date();
		
		$this->db->query("CALL sp_testing('". $cleanString ."', '". $currDate . "', '". $generated_date ."', '". $this->_subtotal ."', '". $this->_cust_id ."', @success)");
		$db = $this->db->query("SELECT @success as success");
		$records = $db->result();
		
		$response =$records[0]->success;
		if($response == 0) 	{	
			
			$data['main_content'] = 'paypal_view/paypal_failed';
			$this->load->view('mobile_template/includes/template', $data);
		} else {
			
			$data['order'] = $this->_mItemList;
			
			$data['paypal_email'] = $this->_paypal_email;
			
			$data['main_content'] = 'paypal_view/paypal_process_view';
			$this->load->view('mobile_template/includes/template', $data);
		}
		
		
	}
	
	private function _validate_item($order) {
		
		$pattern = '/,\|/';
		$replacement = '|';
		
		$strOrder = preg_replace($pattern, $replacement, $order);
		
		$orderArr = explode('||', $strOrder);
		
		$tmpArray = array();
		
		foreach($orderArr as $v) {
			if($v != "" && preg_match('/=>/',$v)):
			$tmpArray[] = $v;
			endif;
		}
		
		$array = $tmpArray;
		
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
		
		call_debug($data, false);
		$status = "";
		
		for($j=0; $j<count($data['order']); $j++) {
				
			$currQty = count_qty($data['order'][$j]['item_id']);
			
			if($currQty == "Out of Stock") 
				$currQty = 0;
			
			$checker = qty_checker($data['order'][$j]['qty'], $currQty);
			
			//call_debug($checker, false);
			if($checker == 1) {
				
				$status .= "1";
			
			} else {
				
				$status .= "0";
			
			} 
			//call_debug($this->_qty_checker($checker));
						
		}
		
		return $status;
		
	}
	
	public function paypal_validate($order) {
		
		
		$data['paypal_email'] = $this->_paypal_email;
		
		$timezone = "Asia/Manila";
		
		date_default_timezone_set($timezone);
		
		$pattern = '/,\|/';
		$replacement = '|';
		
		$strOrder = preg_replace($pattern, $replacement, $order);
		
		$orderArr = explode('||', $strOrder);
		
		$tmpArray = array();
		
		foreach($orderArr as $v) {
			if($v != "" && preg_match('/=>/',$v)):
			$tmpArray[] = $v;
			endif;
		}
		
		$array = $tmpArray;
		
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
		
		$currDate = date('Y-m-d H:i:s A');
		
		$generated_date = $this->process_date();
		
		
		$params['fields'] = array(
				'mboos_order_date' => $currDate ,
				'mboos_order_pick_schedule' => $generated_date,
				'mboos_orders_total_price' => $this->_subtotal,
				'mboos_customer_id' => $this->_cust_id
		);
		
		
		$params['table'] = array('name' => 'mboos_orders');
		
		$this->mdldata->SQLText(true);
		$this->mdldata->insert($params);
			
		$queryStringOrder = $this->mdldata->buildQueryString();
		call_debug($queryStringOrder);
		$get_the_last_id = "SET @last_id_in_table1 = LAST_INSERT_ID()";
		
		$newArray = array($queryStringOrder, $get_the_last_id );
		$strInsert = '';
		
		
		for($k=0; $k<count($data['order']); $k++) {
		
			$params['fields'] = array(
					'mboos_order_detail_quantity' => $data['order'][$k]['qty'] ,
					'mboos_order_detail_price' => $data['order'][$k]['price'],
					'mboos_order_id' => '+@last_id_in_table1+',
					'mboos_product_id' => $data['order'][$k]['item_id']
			);
		
			$params['table'] = array('name' => 'mboos_order_details');
		
			$this->mdldata->SQLText(true);
			$this->mdldata->insert($params);
		
			$string = $this->mdldata->buildQueryString();
			$pattern =  "/('\+)/";
			$replacement = '';
			$tempInsertQueryString =  preg_replace($pattern, $replacement, $string);
		
			$string = $tempInsertQueryString;
			$pattern =  "/(\+')/";
			$replacement = '';
			$cleanInsertQueryString =  preg_replace($pattern, $replacement, $string);
		
			$strInsert = $cleanInsertQueryString;
			array_push($newArray, $strInsert);
		
		}
		
		$this->_readyToInsertQueryString = $newArray;
		
		call_debug($this->_readyToInsertQueryString);
		$params['transact'] = $this->_readyToInsertQueryString;
		
		$this->mdldata->reset();
		$this->mdldata->executeTransact($params);
			
		
		$data['main_content'] = 'paypal_view/paypal_process_view';
		$this->load->view('mobile_template/includes/template', $data);
		
	}
	
	public function thankyou() {
		
		$data['main_content'] = 'paypal_view/paypal_success_view';
		$this->load->view('mobile_template/includes/template', $data);
	
	}
	

	
	private function process_date() {
	
		$timezone = "Asia/Manila";
		
		date_default_timezone_set($timezone);
		
		$params['querystring'] = "SELECT mboos_order_pick_schedule FROM mboos_orders ORDER BY mboos_order_date DESC LIMIT 1";
		
		$this->mdldata->select($params);
		
		$last_pick_scheduled = $this->mdldata->_mRecords;
		
		if($this->mdldata->_mRowCount == 0) {
			
			
		
			 $currDate = date('Y-m-d');
			$starting_date =  date('Y-m-d H:i:s A' , strtotime('+ 1 day 8:00 AM', strtotime($currDate)));
		
			
			return $starting_date;
			
		
		} else {
			
			$start_time = $last_pick_scheduled[0]->mboos_order_pick_schedule;
			
			
			$splitComplateDate = preg_split('/ /', $start_time);
			
			$splitDate = preg_split('/-/', $splitComplateDate[0]);
			
			list($year, $month, $day)= $splitDate;
			
			$plitTime = preg_split('/:/', $splitComplateDate[1]);
			
			
			list($hr, $min, $sec)= $plitTime;
			
			
			$clearDateTime = date("Y-m-d h:i:s A", mktime($hr, $min, $sec, $month, $day, $year)); 
			
			$currDate = date("Y-m-d h:i:s A");
			//call_debug($currDate, false);
			//call_debug($clearDateTime);
			if($clearDateTime <= $currDate) {
				
				$date = date("Y-m-d");
				
				$start_currDate = $date . " 08:00:00 AM";
				$end_currDate = $date . " 05:00:00 PM";
				
				if($this->check_date_is_within_range($start_currDate, $end_currDate, $clearDateTime)){
				
					$timestamp = date('Y-m-d H:i:s A', strtotime($currDate.' + 15 minutes') );
					$new_generate_datetime = $timestamp;
					return $new_generate_datetime;
				
				
				} else {
				
					$new_generate_datetime = date('Y-m-d H:i:s A' , strtotime('+ 1 day 8:00 AM', strtotime($splitComplateDate[0])));
				
					return $new_generate_datetime;
				
				
				}
							
			} else {
				
				$start_currDate = $splitComplateDate[0] . " 08:00:00 AM";
				$end_currDate = $splitComplateDate[0] . " 05:00:00 PM";
				
				if($this->check_date_is_within_range($start_currDate, $end_currDate, $clearDateTime)){
						
					$timestamp = date('Y-m-d H:i:s A', strtotime($start_time.' + 15 minutes') );
					$new_generate_datetime = $timestamp;
					return $new_generate_datetime;
				
						
				} else {
						
					$new_generate_datetime = date('Y-m-d H:i:s A' , strtotime('+ 1 day 8:00 AM', strtotime($splitComplateDate[0])));
						
					return $new_generate_datetime;
						
						
				}
				
			}
			
			

			
		}
		
		
	}
	
	function check_date_is_within_range($start_date, $end_date, $todays_date) {
	
		$start_timestamp = strtotime($start_date);
		$end_timestamp = strtotime($end_date);
		$today_timestamp = strtotime($todays_date);
	
		return (($today_timestamp >= $start_timestamp) && ($today_timestamp < $end_timestamp));
	
	}
	
	private function _qty_checker($param) {
		
		if($param == 1)
			return true;
		
		return false;
		
	}
	
	
}



