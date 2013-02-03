<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function __construct() {
		parent::__construct();
	
	}
	
	public function index(){  
	
		$data['main_content'] = 'admin/report_view/report_view';  
		$this->load->view('includes/template', $data);	
	}
	
	public function monthly_report(){
	
		$data['main_content'] = 'admin/report_view/monthly_set_report';  
		$this->load->view('includes/template', $data);	
	}
	
	public function monthly_report_query(){
	
		$order_year = $this->input->post('year_ordered');
		$month_order_start = $this->input->post('month_ordered_start');
		$month_order_end = $this->input->post('month_ordered_end');
		//call_debug($month_order_end);
		if ($order_year == $this->input->post('year_ordered') && $month_order_start == $this->input->post('month_ordered_start') && $month_order_end == "00"){
			
			$params['querystring'] = 'SELECT mboos_orders.mboos_order_id, mboos_orders.mboos_order_date, mboos_orders.mboos_order_pick_schedule, mboos_orders.mboos_orders_total_price, mboos_orders.mboos_order_status, mboos_orders.mboos_customer_id FROM mboos_orders WHERE mboos_orders.mboos_order_status="1" AND mboos_orders.mboos_order_date BETWEEN "' . $order_year . '-' . $month_order_start . '-01" AND "' . $order_year . '-' . $month_order_start . '-31" ORDER BY mboos_orders.mboos_order_date';
			//call_debug($params);
			$this->mdldata->select($params);
			
			$data['monthly_order_list'] = $this->mdldata->_mRecords;
			
			$data['main_content'] = 'admin/report_view/monthly_report_view';  
			$this->load->view('includes/template', $data);	
			
		}elseif($order_year == $this->input->post('year_ordered') && $month_order_start == $this->input->post('month_ordered_start') && $month_order_end == $this->input->post('month_ordered_end')){
		
			$params['querystring'] = 'SELECT mboos_orders.mboos_order_id, mboos_orders.mboos_order_date, mboos_orders.mboos_order_pick_schedule, mboos_orders.mboos_orders_total_price, mboos_orders.mboos_order_status, mboos_orders.mboos_customer_id FROM mboos_orders WHERE mboos_orders.mboos_order_status="1" AND mboos_orders.mboos_order_date BETWEEN "' . $order_year . '-' . $month_order_start . '-01" AND "' . $order_year . '-' . $month_order_end . '-31" ORDER BY mboos_orders.mboos_order_date';
			//call_debug($params);
			$this->mdldata->select($params);
			
			$data['monthly_order_list'] = $this->mdldata->_mRecords;
			
			$data['main_content'] = 'admin/report_view/monthly_report_view';  
			$this->load->view('includes/template', $data);	
			
		}
	}
	
	public function yearly_report(){
	
		$data['main_content'] = 'admin/report_view/yearly_set_report';  
		$this->load->view('includes/template', $data);	
	}
	
	public function yearly_report_query(){
		
		$order_year_start = $this->input->post('year_ordered_start');
		$order_year_end = $this->input->post('year_ordered_end');
		
		//call_debug($order_year_start);
		
		if ($order_year_start == $this->input->post('year_ordered_start') && $order_year_end == "0000"){
			
			//call_debug($order_year_start);
			$params['querystring'] = 'SELECT mboos_orders.mboos_order_id, mboos_orders.mboos_order_date, mboos_orders.mboos_order_pick_schedule, mboos_orders.mboos_orders_total_price, mboos_orders.mboos_order_status, mboos_orders.mboos_customer_id FROM mboos_orders WHERE mboos_orders.mboos_order_status="1" AND mboos_orders.mboos_order_date BETWEEN "' . $order_year_start . '-01-01" AND "' . $order_year_start . '-12-31" ORDER BY mboos_orders.mboos_order_date';
			//call_debug($params);
			$this->mdldata->select($params);
			
			$data['yearly_order_list'] = $this->mdldata->_mRecords;
			
			$data['main_content'] = 'admin/report_view/yearly_report_view';  
			$this->load->view('includes/template', $data);	
			
		}elseif($order_year_start == $this->input->post('year_ordered_start') && $order_year_end == $this->input->post('year_ordered_end')){
			
			$params['querystring'] = 'SELECT mboos_orders.mboos_order_id, mboos_orders.mboos_order_date, mboos_orders.mboos_order_pick_schedule, mboos_orders.mboos_orders_total_price, mboos_orders.mboos_order_status, mboos_orders.mboos_customer_id FROM mboos_orders WHERE mboos_orders.mboos_order_status="1" AND mboos_orders.mboos_order_date BETWEEN "' . $order_year_start . '-01-01" AND "' . $order_year_end . '-12-31" ORDER BY mboos_orders.mboos_order_date';
			//call_debug($params);
			$this->mdldata->select($params);
			
			$data['yearly_order_list'] = $this->mdldata->_mRecords;
			
			$data['main_content'] = 'admin/report_view/yearly_report_view';  
			$this->load->view('includes/template', $data);	
		}
	}
}