<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobile extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
	
	}
	
	/* get all product categories */
	public function get_categories() {
	
		$params['table'] = array('name' => 'mboos_product_category', 'criteria_phrase' => 'mboos_product_category_status="1"');
		
		if($this->mdldata->select($params)) {
				
			$data = $this->mdldata->_mRecords;
			
			echo '{"categories":'. json_encode($data) .'}';
			
		} else {
			
			echo '{"error":{"text":"Error"}}';
		}
				
	}
	
	public function search() {
		
		$params['table'] = array('name' => 'mboos_products', 'criteria_phrase' => 'mboos_product_status="1"');
		
		if($this->mdldata->select($params)) {
		
			$data = $this->mdldata->_mRecords;
				
			echo '{"products":'. json_encode($data) .'}';
				
		} else {
				
			echo '{"error":{"text":"Error"}}';
		}
	}
	
	public function get_info() {
		
		$id = mysql_real_escape_string($this->input->get('id'));

		$params['querystring'] = "SELECT * FROM `mboos_products` left join mboos_product_price on mboos_products.mboos_product_id=mboos_product_price.mboos_product_id where mboos_products.mboos_product_status='1' AND mboos_products.mboos_product_id='". $id . "'";
		
		if($this->mdldata->select($params)) {
		
			$product_info = $this->mdldata->_mRecords;
						
			echo '{"item_info":'. json_encode($product_info) .'}';

		
		} else {
		
			echo '{"error":{"text":"Error"}}';
		}
	}
	
	public function getByCategory() {
		
		$id = mysql_real_escape_string($this->input->get('id'));
		
		//$params['querystring'] = "SELECT * FROM `mboos_products` where mboos_product_category_id='". $id . "'";
		$params['querystring'] = "SELECT * FROM `mboos_products` left join mboos_product_price on mboos_products.mboos_product_id=mboos_product_price.mboos_product_id where mboos_products.mboos_product_status='1' AND mboos_products.mboos_product_category_id='". $id . "'";
		
		if($this->mdldata->select($params)) {
		
			$product_info = $this->mdldata->_mRecords;
		
			echo '{"cat_item_list":'. json_encode($product_info) .'}';
		
		
		} else {
		
			echo '{"error":{"text":"Error"}}';
		}
		
	}
}

