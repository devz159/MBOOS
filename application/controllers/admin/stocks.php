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
	
			$this->manage_stock_view();
	}
	
	public function manage_stock_view(){
		
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$product_id = $this->uri->segment(4);
		
		$data['stock_number'] = $this->_getStocks();
		
		$config["total_rows"] = $this->_getcountproducts();
		
		$data['products'] = $this->_getlistproducts();
		
		$data['main_content'] = 'admin/stock_view/stocks_view';
		$this->load->view('includes/template', $data);
	}
	
	public function add_stock(){
		
		authUser();
		
		$data['sessVar'] = $this->_arr;		
		
		$data['stock_number'] = $this->_getStocks();
		
		$data['main_content'] = 'admin/stock_view/add_stock_view';
		$this->load->view('includes/template', $data);
	}
	
	private function _getStocks(){
	
		$product_id = $this->uri->segment(4);
		
		$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, sum(mboos_instocks.mboos_inStocks_quantity) as mboos_inStocks_quality FROM mboos_products
		INNER JOIN mboos_instocks ON mboos_instocks.mboos_product_id = mboos_products.mboos_product_id
		WHERE mboos_products.mboos_product_status = "1" AND mboos_products.mboos_product_id="'. $product_id .'"';
		
		if(!$this->mdldata->select($params))
			return false;
		else
			return $this->mdldata->_mRecords;
	}
	
	private function _getcountproducts(){
	
		$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_products.mboos_product_desc, mboos_products.mboos_product_supplier, mboos_products.mboos_product_image, mboos_products.mboos_product_status, mboos_products.mboos_product_category_id, mboos_product_category.mboos_product_category_name
		FROM mboos_products INNER JOIN mboos_product_category ON mboos_products.mboos_product_category_id = mboos_product_category.mboos_product_category_id WHERE mboos_products.mboos_product_status="1"';
	
		if(!$this->mdldata->select($params))
			return false;
		else
			return $this->mdldata->_mRowCount;
	}
	
	private function _getlistproducts(){
	
		$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_image, mboos_products.mboos_product_name, mboos_products.mboos_product_desc, mboos_products.mboos_product_supplier, mboos_product_category.mboos_product_category_name, mboos_product_price.mboos_product_price
		FROM mboos_products
		LEFT JOIN mboos_product_category ON mboos_products.mboos_product_category_id = mboos_product_category.mboos_product_category_id
		LEFT JOIN mboos_product_price ON mboos_product_price.mboos_product_id = mboos_products.mboos_product_id
		WHERE mboos_products.mboos_product_status =  "1" AND mboos_product_price.mboos_product_price_status ="1"
		ORDER BY mboos_products.mboos_product_id asc';
	
		if(!$this->mdldata->select($params))
			return false;
		else
			return $this->mdldata->_mRecords;
	}
	
	public function add_stock_validate(){
		
		$datestring = "Y-m-d g:i:s";
		$time = time();
		
		$item_date = mdate($datestring, $time);
		
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
												'mboos_inStocks_date' => $item_date,
												'mboos_product_id' => $this->input->post('item_id'),
												));		
							//call_debug($params);
				$this->mdldata->reset();
				$this->mdldata->insert($params);
														
				redirect('admin/item');
		}
	}
}