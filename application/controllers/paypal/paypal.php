<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypal extends CI_Controller {
	
	public $_mItemList;
	public $_tmpArray;
	public $_cust_id;
	public $_subtotal;

	public function __construct() {
		parent::__construct();
		
		$this->_mItemList = array();
		$this->_tmpArray = array();
		
		$this->_cust_id = '';
		$this->_subtotal = '';
		
	}
	
	public function index() {
		
		$strOrder = $this->input->get("stringOrder");
		
		$this->_subtotal = $this->input->get("subtotal");
		$this->_cust_id = $this->input->get("cust_id");
		
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
		
		call_debug($data, false);
		
		call_debug($this->_subtotal, false);
		
		call_debug($this->_cust_id, false);
		
		
		$params['fields'] = array(
				'mboos_order_date' => '2013-01-31 00:00:00' ,
				'mboos_order_pick_schedule' => '2013-01-31 01:30:00',
				'mboos_orders_total_price' => $this->_subtotal,
				'mboos_customer_id' => $this->_cust_id
		);
		
		$params['table'] = array('name' => 'mboos_orders');
			
		$this->mdldata->SQLText(true);
		$this->mdldata->insert($params);
			
		$queryStringOrder = $this->mdldata->buildQueryString();
		
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
		call_debug($newArray, false);
		$params['transact'] = $newArray;
		
		$this->mdldata->reset();
        if($this->mdldata->executeTransact($params))
                   echo 'success';
        else
                   echo 'failed';
		
		$data['main_content'] = 'paypal_view/paypal_process_view';
		$this->load->view('includes/template', $data);
		
	}
	
	public function thankyou() {
		
		$data['main_content'] = 'admin/paypal_view/paypal_success_view';
		$this->load->view('includes/template', $data);
	
	}
}



