<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_category extends CI_Controller {

	public function __construct() {
		parent::__construct();
	
	}
	
	public function index(){  
	
		$params['querystring'] = 'SELECT mboos_product_category.mboos_product_category_id, mboos_product_category.mboos_product_category_name, mboos_product_category.mboos_product_category_image FROM mboos_product_category WHERE mboos_product_category.mboos_product_category_status="1" ORDER BY mboos_product_category_name';
		
		$this->mdldata->select($params);
			
		$data['product_category_list'] = $this->mdldata->_mRecords;
		
		$data['main_content'] = 'admin/product_category_view/product_category_view';  
		$this->load->view('includes/template', $data);	
		
	}
	
	public function add_product_category(){
		
		
		$data['main_content'] = 'admin/product_category_view/add_product_category_view';
		$this->load->view('includes/template', $data);
		
	}
	
	public function add_product_category_validate(){
		
		$this->load->library('form_validation'); // loads form_validation from library
		$validation = $this->form_validation;	// initializes form_validation
		
		$validation->set_rules('product_category_name', 'Category name', 'required'); // setting validation rules
		$validation->set_rules('product_category_image', 'Category image', 'required');
		if($this->form_validation->run() == FALSE) {
					
				$data['main_content'] = 'admin/product_category_view/add_product_category_view';
				$this->load->view('includes/template', $data);
					
			} else {
				
					$params = array(
							  		'table' => array('name' => 'mboos_product_category'),
							        'fields' => array(						                                     
											'mboos_product_category_name' => $this->input->post('product_category_name'),
											'mboos_product_category_image' => $this->input->post('product_category_image')));
					
					$this->mdldata->reset();
					$this->mdldata->insert($params);
					                
					$data['main_content'] = 'admin/product_category_view/add_product_category_success_view';
					$this->load->view('includes/template', $data);
			}
	}
	
	public function edit_product_category(){
		
		$edit_category_id = $this->uri->segment(4);
		
		$params['querystring'] = 'SELECT mboos_product_category.mboos_product_category_id, mboos_product_category.mboos_product_category_name, mboos_product_category.mboos_product_category_image FROM mboos_product_category WHERE mboos_product_category.mboos_product_category_status="1" AND mboos_product_category.mboos_product_category_id="' . $edit_category_id  . '" ORDER BY mboos_product_category_name';
		
		$this->mdldata->select($params);
			
		$data['edit_category'] = $this->mdldata->_mRecords;
		
		$data['main_content'] = 'admin/product_category_view/edit_product_category_view';
		$this->load->view('includes/template', $data);
		
	}
	
	public function edit_product_category_validate(){
		
		$this->load->library('form_validation'); // loads form_validation from library
		$validation = $this->form_validation;	// initializes form_validation
		
		$validation->set_rules('product_category_name', 'Category name', 'required'); // setting validation rules
		$validation->set_rules('product_category_image', 'Category image', 'required');
		
			if($this->form_validation->run() == FALSE) {
				
				$edit_category_id = $this->uri->segment(4);
				
				$params['querystring'] = 'SELECT mboos_product_category.mboos_product_category_id, mboos_product_category.mboos_product_category_name, mboos_product_category.mboos_product_category_image FROM mboos_product_category WHERE mboos_product_category.mboos_product_category_status="1" AND mboos_product_category.mboos_product_category_id="' . $edit_category_id  . '" ORDER BY mboos_product_category_name';
				
				$this->mdldata->select($params);
					
				$data['edit_category'] = $this->mdldata->_mRecords;
				
				$data['main_content'] = 'admin/product_category_view/edit_product_category_view';
				$this->load->view('includes/template', $data);
				
			} else {
		
				$params = array(
						'table' => array('name' => 'mboos_product_category', 'criteria_phrase' => 'mboos_product_category_id= "' . $this->input->post('product_category_id') . '"'),
						'fields' => array('mboos_product_category_name' => $this->input->post('product_category_name'),
										  'mboos_product_category_image' => $this->input->post('product_category_image')));
				
				$this->mdldata->reset();
				$this->mdldata->update($params);
		
				$data['main_content'] = 'admin/product_category_view/edit_product_category_success';
				$this->load->view('includes/template', $data);
			}
	}
	public function delete_product_category_validate(){
		
		$delete_category_id = $this->uri->segment(4);
		
		$params = array(
				'table' => array('name' => 'mboos_product_category', 'criteria_phrase' => 'mboos_product_category_id= "' . $delete_category_id . '"'),
				'fields' => array('mboos_product_category_status' => 0 ));
		
		$this->mdldata->reset();
		$this->mdldata->update($params);
		
		redirect('admin/product_category');
		
	}
	
}

