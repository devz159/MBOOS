<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {

	public function __construct() {
		parent::__construct();
	
	}
	
	public function index(){  
	
		//$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_products.mboos_product_desc, mboos_products.mboos_product_supplier, mboos_products.mboos_product_image, mboos_products.mboos_product_availability, mboos_products.mboos_product_status, mboos_products.mboos_product_category_id FROM mboos_products WHERE mboos_products.mboos_product_status="1" ORDER BY mboos_products.mboos_product_name';
		$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_products.mboos_product_desc, mboos_products.mboos_product_supplier, mboos_products.mboos_product_image, mboos_products.mboos_product_availability, mboos_products.mboos_product_status, mboos_product_category.mboos_product_category_name
FROM mboos_product_category INNER JOIN mboos_products ON mboos_product_category.mboos_product_category_id = mboos_products.mboos_product_category_id';

		$this->mdldata->select($params);
		$data['products'] = $this->mdldata->_mRecords;	
		
		$data['main_content'] = 'admin/item_view/item_view';  
		$this->load->view('includes/template', $data);	
		
	}
	
	public function add_item(){
		
		$params['querystring'] = 'SELECT mboos_product_category.mboos_product_category_id, mboos_product_category.mboos_product_category_name, mboos_product_category.mboos_product_category_status FROM mboos_product_category WHERE mboos_product_category.mboos_product_category_status="1"';	
		$this->mdldata->select($params);
		$data['category'] = $this->mdldata->_mRecords;	
		
		$data['main_content'] = 'admin/item_view/add_item_view';
		$this->load->view('includes/template', $data);
		
	}
	
	public function add_item_validate(){
		
		$this->load->library('form_validation'); // loads form_validation from library
		$validation = $this->form_validation;	// initializes form_validation
		
		$validation->set_rules('item_name', 'Item name', 'required'); // setting validation rules
		$validation->set_rules('item_availability', 'Item availability', 'required');
		if($this->form_validation->run() == FALSE) {
					
				$data['main_content'] = 'admin/item_view/add_item_view';
				$this->load->view('includes/template', $data);
					
			} else {
					
		 			$target = "uploads/item_images/";
					$target = $target . basename( $_FILES['item_image']['name']);
					$image = basename( $_FILES['item_image']['name']);
					//call_debug($image);
					$pic=($_FILES['item_image']['name']);
					
					$allowedExts = array("jpg", "jpeg", "gif", "png");
					$extension = end(explode(".", $_FILES["item_image"]["name"]));
					if ((($_FILES["item_image"]["type"] == "image/gif")|| ($_FILES["item_image"]["type"] == "image/jpeg")|| ($_FILES["item_image"]["type"] == "image/png")|| ($_FILES["item_image"]["type"] == "image/pjpeg"))&& ($_FILES["item_image"]["size"] < 200000)&& in_array($extension, $allowedExts)){
						if ($_FILES["item_image"]["error"] > 0){
							echo "Error: " . $_FILES["item_image"]["error"] . "<br>";
							}else{
								move_uploaded_file($_FILES['item_image']['tmp_name'], $target);
								$params = array(
							  		'table' => array('name' => 'mboos_products'),
							        'fields' => array(						                                     
											'mboos_product_name' 		=> $this->input->post('item_name'),
											'mboos_product_desc' 		=> $this->input->post('item_desc'),
											'mboos_product_supplier' 	=> $this->input->post('item_supplier'),
											'mboos_product_availability'=> $this->input->post('item_availability'),
											'mboos_product_category_id' => $this->input->post('product_category'),
											'mboos_product_image' 		=> $image));								
														
								$this->mdldata->reset();
								$this->mdldata->insert($params);
								/*
								$params = array(
									'table'  => array('name' => 'mboos_product_price'),
									'fields' => array(
											'mboos_product_price'		=> $this->input->post('item_price'),
											'mboos_product_price_date'	=> $this->input->post('price_date'),
											'mboos_product_id'			=> $this->input->post('product_id');
												));
								
								$this->mdldata->reset();
								$this->mdldata->insert($params);
								*/
								$data['main_content'] = 'admin/item_view/item_success_view';
								$this->load->view('includes/template', $data);
							}
					}else{
						
						$data['main_content'] = 'admin/item_view/add_item_view';
						$this->load->view('includes/template', $data);
						
					}
			}
	}
	
	public function edit_item(){
		
		$edit_item_id = $this->uri->segment(4);
		
		//$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_products.mboos_product_desc, mboos_products.mboos_product_supplier, mboos_products.mboos_product_image, mboos_products.mboos_product_availability, mboos_products.mboos_product_status, mboos_products.mboos_product_category_id, mboos_product_category.mboos_product_category_name
//FROM mboos_product_category INNER JOIN mboos_products ON mboos_product_category.mboos_product_category_id = mboos_products.mboos_product_category_id WHERE mboos_products.mboos_product_id="'. $edit_item_id .'"';
		$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_products.mboos_product_desc, mboos_products.mboos_product_supplier, mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_products.mboos_product_desc, mboos_products.mboos_product_supplier, mboos_products.mboos_product_image, mboos_products.mboos_product_availability, mboos_products.mboos_product_status, mboos_products.mboos_product_category_id, mboos_product_category.mboos_product_category_name, mboos_product_price.mboos_product_price, mboos_product_price.mboos_product_price_date, mboos_product_price.mboos_product_price_status, mboos_product_price.mboos_product_id
FROM mboos_product_price INNER JOIN (mboos_product_category INNER JOIN mboos_products ON mboos_product_category.mboos_product_category_id = mboos_products.mboos_product_category_id) ON mboos_product_price.mboos_product_id = mboos_products.mboos_product_id WHERE mboos_products.mboos_product_id="'. $edit_item_id .'"';

		//$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_products.mboos_product_desc, mboos_products.mboos_product_supplier, mboos_products.mboos_product_image, mboos_products.mboos_product_availability, mboos_products.mboos_product_status, mboos_product_category.mboos_product_category_name
//FROM mboos_product_category INNER JOIN mboos_products ON mboos_product_category.mboos_product_category_id = mboos_products.mboos_product_category_id WHERE mboos_products.mboos_product_id="'. $edit_item_id .'"';

		$this->mdldata->select($params);
		$data['edit_items'] = $this->mdldata->_mRecords;
		
		$data['main_content'] = 'admin/item_view/edit_item_view';  
		$this->load->view('includes/template', $data);	
		
	}
	
	public function edit_item_validate(){
		
		$this->load->library('form_validation'); // loads form_validation from library
		$validation = $this->form_validation;	// initializes form_validation
		
		$validation->set_rules('item_name', 'Item name', 'required'); // setting validation rules
		//$validation->set_rules('product_category_image', 'Category image', 'required');
		
			if($this->form_validation->run() == FALSE) {
				
				$edit_item_id = $this->uri->segment(4);
				
				$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_products.mboos_product_desc, mboos_products.mboos_product_supplier, mboos_products.mboos_product_image, mboos_products.mboos_product_availability, mboos_products.mboos_product_status, mboos_products.mboos_product_category_id FROM mboos_products WHERE mboos_products.mboos_product_status="1" AND mboos_products.mboos_product_id="' . $edit_item_id . '"';
				$this->mdldata->select($params);
					
				$data['edit_items'] = $this->mdldata->_mRecords;
				
				$data['main_content'] = 'admin/item_view/edit_item_view';  
				$this->load->view('includes/template', $data);	
				
			} else {
				
					$target = "uploads/item_images/";
					$target = $target . basename( $_FILES['item_image']['name']);
					$image = basename( $_FILES['item_image']['name']);
					//call_debug($image);
					$pic=($_FILES['item_image']['name']);
					
					$allowedExts = array("jpg", "jpeg", "gif", "png");
					$extension = end(explode(".", $_FILES["item_image"]["name"]));
					if ((($_FILES["item_image"]["type"] == "image/gif")|| ($_FILES["item_image"]["type"] == "image/jpeg")|| ($_FILES["item_image"]["type"] == "image/png")|| ($_FILES["item_image"]["type"] == "image/pjpeg"))&& ($_FILES["item_image"]["size"] < 200000)&& in_array($extension, $allowedExts)){
						if ($_FILES["item_image"]["error"] > 0){
							echo "Error: " . $_FILES["item_image"]["error"] . "<br>";
							}else{
								move_uploaded_file($_FILES['item_image']['tmp_name'], $target);
								$params = array(
							  		'table' => array('name' => 'mboos_products', 'criteria_phrase' => 'mboos_product_id= "' . $this->input->post('item_id') . '"'),
							        'fields' => array(						                                     
											'mboos_product_name' 		=> $this->input->post('item_name'),
											'mboos_product_desc' 		=> $this->input->post('item_desc'),
											'mboos_product_supplier' 	=> $this->input->post('item_supplier'),
											'mboos_product_availability'=> $this->input->post('item_availability'),
											'mboos_product_category_id' => $this->input->post('product_category'),
											'mboos_product_image' 		=> $image));		
					
								$this->mdldata->reset();
								$this->mdldata->update($params);
												
								$data['main_content'] = 'admin/item_view/item_success_view';
								$this->load->view('includes/template', $data);
							}
					}else{
						
						//$data['main_content'] = 'admin/item_view/edit_item_view';
						//$this->load->view('includes/template', $data);
						echo "upload failed";
					}
			}
	}
	public function delete_item(){
		
		$delete_item_id = $this->uri->segment(4);
		
		$params = array(
				'table' => array('name' => 'mboos_products', 'criteria_phrase' => 'mboos_product_id= "' . $delete_item_id . '"'),
				'fields' => array('mboos_product_status' => 0 ));
		
		$this->mdldata->reset();
		$this->mdldata->update($params);
		
		redirect('admin/item');
		
	}
	
}

