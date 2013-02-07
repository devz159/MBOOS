<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stocks extends CI_Controller {

	public function __construct() {
		parent::__construct();
	
		$this->load->helper(array('form'));
		$params = array('sadmin_uname', 'sadmin_islogin', 'sadmin_ulvl', 'sadmin_uid');
		$this->sessionbrowser->getInfo($params);
		$this->_arr = $this->sessionbrowser->mData;
	}
	
	public function index(){  
	
	}
	
	public function add_stock(){
		
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$product_id = $this->uri->segment(4);
		
		$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, sum(mboos_instocks.mboos_inStocks_quantity) as mboos_inStocks_quality FROM mboos_products
		INNER JOIN mboos_instocks ON mboos_instocks.mboos_product_id = mboos_products.mboos_product_id
		WHERE mboos_products.mboos_product_status = "1" AND mboos_products.mboos_product_id="'. $product_id .'"';
		
		$this->mdldata->select($params);
		$data['stock_number'] = $this->mdldata->_mRecords;
		
		$data['main_content'] = 'admin/stock_view/add_stock_view';
		$this->load->view('includes/template', $data);
	}
	
	public function add_stock_validate(){
		
		$item_id = $this->input->post('item_id');
		$this->load->library('form_validation'); 
		$validation = $this->form_validation;	
		
		$validation->set_rules('quantity_number', 'Stock quantity', 'required');
		
		if($this->form_validation->run() == FALSE) {
	
			redirect('admin/stocks/add_stock/'. $item_id .'');
					
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
				$this->mdldata->insert($params);
														
				redirect('admin/item');
		}
	}
}