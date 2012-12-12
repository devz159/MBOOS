<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/* Ian Paul Kionisala as Rookie  */
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
		
		$params['table'] = array('name' => 'mboos_products', 'criteria_phrase' => 'mboos_product_product_status="1"');
		
		if($this->mdldata->select($params)) {
		
			$data = $this->mdldata->_mRecords;
				
			echo '{"products":'. json_encode($data) .'}';
				
		} else {
				
			echo '{"error":{"text":"Error"}}';
		}
	}
	
	public function get_info() {
		
		$id = $this->input->get('id');

		$params['table'] = array('name' => 'mboos_products', 'criteria_phrase' => 'mboos_product_id="'. $id . '"');
		
		if($this->mdldata->select($params)) {
		
			$data = $this->mdldata->_mRecords;
		
			echo json_encode($data);
		
		} else {
		
			echo '[{"text":"Error"}]';
		}
	}
}

