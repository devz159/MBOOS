<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stocks extends CI_Controller {

	public function __construct() {
		parent::__construct();
	
	}
	
	public function index(){  
	
	}
	
	public function add_stock(){
		
		$product_id = $this->uri->segment(4);
		
		$params['querystring'] = 'SELECT mboos_instocks.mboos_inStocks_quantity FROM mboos_instocks WHERE mboos_instocks.mboos_product_id="' . $product_id . '" ';
		
		$this->mdldata->select($params);
		$data['stock_number'] = $this->mdldata->_mRecords;
		
		$data['main_content'] = 'admin/stock_view/add_stock_view';
		$this->load->view('includes/template', $data);
	}
	
	public function add_stock_validate(){
		
		$this->load->library('form_validation'); 
		$validation = $this->form_validation;	
		
		$validation->set_rules('quantity_number', 'Stock quantity', 'required');
		
		if($this->form_validation->run() == FALSE) {
				
				$this->add_stock();
					
			} else {
				$params = array(
								'table' => array('name' => 'mboos_instocks', 'criteria_phrase' => 'mboos_product_id= "' . $this->input->post('item_id') . '"'),
								'fields' => array(						                                     
												'mboos_inStocks_quantity' => $this->input->post('quantity_number'),
												'mboos_inStocks_date' => $this->input->post('stock_date'),
												'mboos_product_id' => $this->input->post('item_id'),
												));		
							//call_debug($params);
				$this->mdldata->reset();
				$this->mdldata->update($params);
														
				$data['main_content'] = 'admin/stock_view/add_stock_view_success';
				$this->load->view('includes/template', $data);
		}
	}
}