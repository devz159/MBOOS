<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_report extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->helper(array('form'));
		
		$params = array('sadmin_uname', 'sadmin_islogin', 'sadmin_ulvl', 'sadmin_uid');
		$this->sessionbrowser->getInfo($params);
		$this->_arr = $this->sessionbrowser->mData;
	}
	
	public function index(){  
		$this->sales_report();
	}
	
	public function sales_report(){
		
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_product_category.mboos_product_category_name, mboos_orders.mboos_order_date, mboos_orders.mboos_orders_total_price
								FROM mboos_products
								LEFT JOIN mboos_product_category ON mboos_product_category.mboos_product_category_id = mboos_products.mboos_product_category_id
								LEFT JOIN mboos_order_details ON mboos_order_details.mboos_product_id = mboos_products.mboos_product_id
								LEFT JOIN mboos_orders ON mboos_orders.mboos_order_id = mboos_order_details.mboos_order_id
								WHERE mboos_products.mboos_product_status =  "1"
								AND mboos_orders.mboos_orders_total_price > "0"';
		
		$this->mdldata->reset();
		$this->mdldata->select($params);
		$data['sales'] = $this->mdldata->_mRecords;
		
		$data['main_content'] = 'admin/report_view/sales_report_view';  
		$this->load->view('includes/template', $data);	
	}
	
}