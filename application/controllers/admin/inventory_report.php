<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_report extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->helper(array('form'));
		
		$params = array('sadmin_uname', 'sadmin_islogin', 'sadmin_ulvl', 'sadmin_uid');
		$this->sessionbrowser->getInfo($params);
		$this->_arr = $this->sessionbrowser->mData;
	}
	
	public function index(){  
		$this->inventory_report();
	}
	
	public function inventory_report(){
		
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_product_category.mboos_product_category_name, mboos_instocks.mboos_inStocks_quantity, mboos_instocks.mboos_inStocks_date, mboos_users.mboos_user_username
								FROM mboos_products
								LEFT JOIN mboos_product_category ON mboos_product_category.mboos_product_category_id = mboos_products.mboos_product_category_id
								LEFT JOIN mboos_instocks ON mboos_instocks.mboos_product_id = mboos_products.mboos_product_id
								LEFT JOIN mboos_users ON mboos_users.mboos_user_id = mboos_instocks.mboos_user_id
								WHERE mboos_products.mboos_product_status =  "1"
								AND mboos_instocks.mboos_inStocks_quantity > "0"';
		
		$this->mdldata->select($params);
		$data['inventory_report'] = $this->mdldata->_mRecords;	
		
		$data['main_content'] = 'admin/report_view/inventory_report_view';  
		$this->load->view('includes/template', $data);	
	}
	
}