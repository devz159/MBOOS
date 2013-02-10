<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller {

	
	private $_arr;
	
	public function __construct() {
		parent::__construct();
	
		$params = array('sadmin_uname', 'sadmin_islogin', 'sadmin_ulvl', 'sadmin_uid');
		$this->sessionbrowser->getInfo($params);
		$this->_arr = $this->sessionbrowser->mData;
		
	}
	
	public function index(){  
		
		$this->view_invioce();
	}
	
	public function view_invoice(){
		
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$order_id = $this->uri->segment(4);
				
		$params['querystring'] = 'SELECT mboos_orders.mboos_order_id, mboos_customers.mboos_customer_complete_name, mboos_orders.mboos_order_date, mboos_orders.mboos_order_pick_schedule
								FROM mboos_orders
								LEFT JOIN mboos_customers ON mboos_customers.mboos_customer_id = mboos_orders.mboos_customer_id
								WHERE mboos_order_status ="2" AND mboos_order_id = "' . $order_id . '"';

		$this->mdldata->reset();
		$this->mdldata->select($params);
		$data['order_detail'] = $this->mdldata->_mRecords;
		
		$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_product_category.mboos_product_category_name, mboos_order_details.mboos_order_detail_quantity, mboos_order_details.mboos_order_detail_price, mboos_orders.mboos_orders_total_price
								FROM mboos_orders left join mboos_order_details on mboos_order_details.mboos_order_id=mboos_orders.mboos_order_id
								LEFT JOIN mboos_products on mboos_products.mboos_product_id=mboos_order_details.mboos_product_id 
								LEFT JOIN mboos_product_category on mboos_product_category.mboos_product_category_id=mboos_products.mboos_product_category_id 
								WHERE mboos_orders.mboos_order_id="' . $order_id . '" 
								ORDER BY mboos_products.mboos_product_id asc';

		$this->mdldata->reset();
		$this->mdldata->select($params);
		$data['order_product_detail'] = $this->mdldata->_mRecords;
		
		$data['main_content'] = 'admin/invoice_view/invoice_view';
		$this->load->view('includes/template', $data);
		
	}
	
}