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
	
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$data['main_content'] = 'admin/report_view/report_view';  
		$this->load->view('includes/template', $data);	
	}
	
	public function monthly_report(){

		authUser();
		
		$data['sessVar'] = $this->_arr;
			
		$data['main_content'] = 'admin/report_view/monthly_set_report';  
		$this->load->view('includes/template', $data);	
	}
	
	public function monthly_report_query(){
				
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$order_year = $this->input->post('year_ordered');
		$month_order_start = $this->input->post('month_ordered_start');
		$month_order_end = $this->input->post('month_ordered_end');
		//call_debug($month_order_end);
		if ($order_year == $this->input->post('year_ordered') && $month_order_start == $this->input->post('month_ordered_start') && $month_order_end == "00"){
			
		$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_product_category.mboos_product_category_name, mboos_orders.mboos_order_date, mboos_orders.mboos_orders_total_price
								FROM mboos_products
								LEFT JOIN mboos_product_category ON mboos_product_category.mboos_product_category_id = mboos_products.mboos_product_category_id
								LEFT JOIN mboos_order_details ON mboos_order_details.mboos_product_id = mboos_products.mboos_product_id
								LEFT JOIN mboos_orders ON mboos_orders.mboos_order_id = mboos_order_details.mboos_order_id
								WHERE mboos_products.mboos_product_status =  "1"
								AND mboos_orders.mboos_orders_total_price > "0"
								AND mboos_orders.mboos_order_date BETWEEN "' . $order_year . '-' . $month_order_start . '-01" AND "' . $order_year . '-' . $month_order_start . '-31" ORDER BY mboos_orders.mboos_order_date';
		
		$this->mdldata->reset();
		$this->mdldata->select($params);
		$data['sales'] = $this->mdldata->_mRecords;
		
			$data['main_content'] = 'admin/report_view/sales_report_view';  
			$this->load->view('includes/template', $data);	
			
		}elseif($order_year == $this->input->post('year_ordered') && $month_order_start == $this->input->post('month_ordered_start') && $month_order_end == $this->input->post('month_ordered_end')){
			
			$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_product_category.mboos_product_category_name, mboos_orders.mboos_order_date, mboos_orders.mboos_orders_total_price
								FROM mboos_products
								LEFT JOIN mboos_product_category ON mboos_product_category.mboos_product_category_id = mboos_products.mboos_product_category_id
								LEFT JOIN mboos_order_details ON mboos_order_details.mboos_product_id = mboos_products.mboos_product_id
								LEFT JOIN mboos_orders ON mboos_orders.mboos_order_id = mboos_order_details.mboos_order_id
								WHERE mboos_products.mboos_product_status =  "1"
								AND mboos_orders.mboos_orders_total_price > "0"
								AND mboos_orders.mboos_order_date BETWEEN "' . $order_year . '-' . $month_order_start . '-01" AND "' . $order_year . '-' . $month_order_end . '-31" ORDER BY mboos_orders.mboos_order_date';
		
			$this->mdldata->reset();
			$this->mdldata->select($params);
			
			$data['sales'] = $this->mdldata->_mRecords;
			
			$data['main_content'] = 'admin/report_view/sales_report_view';  
			$this->load->view('includes/template', $data);	
			
		}
	}
	
	public function yearly_report(){
	
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$data['main_content'] = 'admin/report_view/yearly_set_report';  
		$this->load->view('includes/template', $data);	
	}
	
	public function yearly_report_query(){
		
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$order_year_start = $this->input->post('year_ordered_start');
		$order_year_end = $this->input->post('year_ordered_end');
		
		//call_debug($order_year_start);
		
		if ($order_year_start == $this->input->post('year_ordered_start') && $order_year_end == "0000"){
			
			//call_debug($order_year_start);
			$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_product_category.mboos_product_category_name, mboos_orders.mboos_order_date, mboos_orders.mboos_orders_total_price
								FROM mboos_products
								LEFT JOIN mboos_product_category ON mboos_product_category.mboos_product_category_id = mboos_products.mboos_product_category_id
								LEFT JOIN mboos_order_details ON mboos_order_details.mboos_product_id = mboos_products.mboos_product_id
								LEFT JOIN mboos_orders ON mboos_orders.mboos_order_id = mboos_order_details.mboos_order_id
								WHERE mboos_products.mboos_product_status =  "1"
								AND mboos_orders.mboos_orders_total_price > "0"
								AND mboos_orders.mboos_order_date BETWEEN "' . $order_year_start . '-01-01" AND "' . $order_year_start . '-12-31" ORDER BY mboos_orders.mboos_order_date';
		
			
			$this->mdldata->select($params);
			
			$data['sales'] = $this->mdldata->_mRecords;
			
			$data['main_content'] = 'admin/report_view/sales_report_view';  
			$this->load->view('includes/template', $data);	
			
		}elseif($order_year_start == $this->input->post('year_ordered_start') && $order_year_end == $this->input->post('year_ordered_end')){
			
			$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_product_category.mboos_product_category_name, mboos_orders.mboos_order_date, mboos_orders.mboos_orders_total_price
								FROM mboos_products
								LEFT JOIN mboos_product_category ON mboos_product_category.mboos_product_category_id = mboos_products.mboos_product_category_id
								LEFT JOIN mboos_order_details ON mboos_order_details.mboos_product_id = mboos_products.mboos_product_id
								LEFT JOIN mboos_orders ON mboos_orders.mboos_order_id = mboos_order_details.mboos_order_id
								WHERE mboos_products.mboos_product_status =  "1"
								AND mboos_orders.mboos_orders_total_price > "0"
								AND mboos_orders.mboos_order_date BETWEEN "' . $order_year_start . '-01-01" AND "' . $order_year_end . '-12-31" ORDER BY mboos_orders.mboos_order_date';
			//call_debug($params);
			$this->mdldata->select($params);
			
			$data['sales'] = $this->mdldata->_mRecords;
			
			$data['main_content'] = 'admin/report_view/sales_report_view';  
			$this->load->view('includes/template', $data);	
		}
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