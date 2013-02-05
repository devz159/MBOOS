<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form'));
		
		$params = array('sadmin_uname', 'sadmin_islogin', 'sadmin_ulvl', 'sadmin_uid');
		$this->sessionbrowser->getInfo($params);
		$this->_arr = $this->sessionbrowser->mData;
	}
	
	public function index(){  
		$this->view_item();
	}
	
	public function view_item(){
	
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$config = array();
		$config["base_url"] = base_url() . "admin/item/view_item/";
		$config["total_rows"] = $this->_getcountproducts();
		$config["per_page"] = 10;
		$config['num_links'] = 6;
		$config["uri_segment"] = 4;
		
		$this->load->library("pagination");
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["links"] = $this->pagination->create_links();
		
		$data['products'] = $this->_getlistproducts($config["per_page"], $page);
		//call_debug($data);
		$data['main_content'] = 'admin/item_view/item_view';
		$this->load->view('includes/template', $data);
	}
	
	private function _getlistproducts($limit, $start){
	
		$params['querystring'] = 'SELECT mboos_products.mboos_product_id, mboos_products.mboos_product_name, mboos_products.mboos_product_desc, mboos_products.mboos_product_supplier, mboos_products.mboos_product_image, mboos_products.mboos_product_status, mboos_products.mboos_product_category_id, mboos_product_category.mboos_product_category_name, mboos_product_price.mboos_product_price, mboos_instocks.mboos_inStocks_quantity
									FROM mboos_products
									INNER JOIN mboos_product_category ON mboos_products.mboos_product_category_id = mboos_product_category.mboos_product_category_id
									INNER JOIN mboos_product_price ON mboos_products.mboos_product_id = mboos_product_price.mboos_product_id
									INNER JOIN mboos_instocks ON mboos_instocks.mboos_product_id = mboos_products.mboos_product_id
									WHERE mboos_products.mboos_product_status = "1"
									ORDER BY mboos_product_category.mboos_product_category_name LIMIT '.$start .',' . $limit;
		
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
	
	public function add_item(){
		authUser();
		
		$data['sessVar'] = $this->_arr;
	
		$params['querystring'] = 'SELECT mboos_product_category.mboos_product_category_id, mboos_product_category.mboos_product_category_name, mboos_product_category.mboos_product_category_status FROM mboos_product_category WHERE mboos_product_category.mboos_product_category_status="1"';	
		
		$this->mdldata->select($params);
		$data['category'] = $this->mdldata->_mRecords;	
		
		$data['main_content'] = 'admin/item_view/add_item_view';
		$this->load->view('includes/template', $data);
		
	}
	
	public function add_item_validate(){
	
		call_debug($this->input->post('userfile'));
		$this->load->library('form_validation'); // loads form_validation from library
		$validation = $this->form_validation;	// initializes form_validation
		
		$validation->set_rules('item_name', 'Item name', 'required'); // setting validation rules
		$validation->set_rules('item_price', 'Item price', 'required');
		//$validation->set_rules('item_image', 'Item image', 'required');
		
		if($this->form_validation->run() == FALSE) {
				
						authUser();
			
						$data['sessVar'] = $this->_arr;
						$data['main_content'] = 'admin/item_view/add_item_view';
						$this->load->view('includes/template', $data);
					
			} else {
					
					$target = "uploads/product_images/";
					$target = $target . basename( $_FILES['item_image']['name']);
					$image = basename( $_FILES['item_image']['name']);
					//call_debug($image);
					$pic=($_FILES['item_image']['name']);
					
					$allowedExts = array("jpg", "jpeg", "gif", "png");
					$extension = end(explode(".", $_FILES["item_image"]["name"]));
					if ((($_FILES["item_image"]["type"] == "image/gif")|| ($_FILES["item_image"]["type"] == "image/jpeg")|| ($_FILES["item_image"]["type"] == "image/png")|| ($_FILES["item_image"]["type"] == "image/pjpeg"))&& ($_FILES["item_image"]["size"] < 2000000)&& in_array($extension, $allowedExts)){
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
											'mboos_product_category_id' => $this->input->post('product_category'),
											'mboos_product_image' => $image));
						
								$this->mdldata->reset();
								$this->mdldata->SQLText(true);
								$this->mdldata->insert($params);
								
								$QueryStringInsertproduct = $this->mdldata->buildQueryString();
								//call_debug($QueryStringInsertproduct,false);
								//===================================================
								$params = array(
									'table'  => array('name' => 'mboos_product_price'),
									'fields' => array(
											'mboos_product_price'		=> $this->input->post('item_price'),
											'mboos_product_price_date'	=> $this->input->post('price_date'),
											'mboos_product_id'			=> '+@last_id_in_table1+'
												));
								$get_the_last_id = "SET @last_id_in_table1 = LAST_INSERT_ID()";
								
								$this->mdldata->reset();
								$this->mdldata->SQLText(true);
								$this->mdldata->insert($params);
								
								$QueryStringInsertprice = $this->mdldata->buildQueryString();
								//===================================================
								$params = array(
									'table'  => array('name' => 'mboos_instocks'),
									'fields' => array(
											'mboos_inStocks_quantity'	=> 0,
											'mboos_product_id'			=> '+@last_id_in_table1+'
												));
								$get_the_last_id2 = "SET @last_id_in_table1 = LAST_INSERT_ID()";
								
								$this->mdldata->reset();
								$this->mdldata->SQLText(true);
								$this->mdldata->insert($params);
								
								$QueryStringInsertStock = $this->mdldata->buildQueryString();
								//===================================================
								
								$string = $QueryStringInsertprice;
								$string2 = $QueryStringInsertStock;
								
								$pattern =  "/(\'\+|\+\')+/";
								$replacement = '';
								
								$cleanInsertQueryString =  preg_replace($pattern, $replacement, $string);
								$cleanInsertQueryString2 =  preg_replace($pattern, $replacement, $string2);
								
								$params['transact'] = array(
														$QueryStringInsertproduct,
														$get_the_last_id,
														$get_the_last_id2,
														$cleanInsertQueryString,
														$cleanInsertQueryString2
													);
								call_debug($params);
								$this->mdldata->reset();
								$this->mdldata->executeTransact($params);
								//call_debug($QueryStringInsertprice);
																
								$data['main_content'] = 'admin/item_view/item_success_view';
								$this->load->view('includes/template', $data);	
							}
					}else{
						$data['main_content'] = 'admin/item_view/add_item_view';
						$this->load->view('includes/template', $data);
					}
			}
	}
	
	public function upload_image(){
			
			$image_name = $this->uri->segment(4);
			//call_debug($image_name);
			$data['main_content'] = 'admin/item_view/upload_image_view';
			$this->load->view('includes/template', $data);
			
	}
	
	public function upload_image_validate(){
					
					$image_name = $this->input->post('item_name');
					$config['upload_path'] = './uploads/product_images/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']	= '1000';
					$config['max_width']  = '3024';
					$config['max_height']  = '1768';
					$config['file_name']  = $image_name; 
					//call_debug($image_name);
					
					$this->load->library('upload', $config);
					
					if ( ! $this->upload->do_upload())
					{
						//$error = array('error' => $this->upload->display_errors());
						//$this->add_item();
						echo "upload failed";
					}
					else
					{			
						$data = array('upload_data' => $this->upload->data());
								
						$this->index();
								
					}
	}
	public function edit_item(){
		
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$edit_item_id = $this->uri->segment(4);
		
			$params['table'] = array(
							'name' => 'mboos_product_category'
							);
							
							$this->mdldata->select($params);
							$data['all_category'] = $this->mdldata->_mRecords;
							
		//call_debug($edit_item_id);
		$params['querystring'] = 'SELECT mboos_product_price.mboos_product_price, mboos_product_price.mboos_product_price_date, mboos_product_price.mboos_product_price_status FROM mboos_product_price WHERE mboos_product_price.mboos_product_id="'. $edit_item_id .'"';
		$this->mdldata->select($params);
		$data['item_price'] = $this->mdldata->_mRecords;
		
	
							
							$params['querystring'] = 'SELECT * FROM mboos_products
		LEFT JOIN mboos_product_category ON mboos_products.mboos_product_category_id = mboos_product_category.mboos_product_category_id
		LEFT JOIN mboos_instocks ON mboos_instocks.mboos_product_id = mboos_products.mboos_product_id WHERE mboos_products.mboos_product_id="'. $edit_item_id .'"';

//call_debug($params);
		$this->mdldata->reset();
		$this->mdldata->select($params);
		$data['edit_items'] = $this->mdldata->_mRecords;
		//call_debug($data);
		$data['main_content'] = 'admin/item_view/edit_item_view';  
		$this->load->view('includes/template', $data);	
		
	}
	
	public function edit_item_validate(){
		
		$edit_item_id = $this->input->post('item_id');

		//call_debug($edit_item_id);
		$this->load->library('form_validation'); // loads form_validation from library
		$validation = $this->form_validation;	// initializes form_validation
		
		$validation->set_rules('item_name', 'Item name', 'required'); // setting validation rules
		$validation->set_rules('item_price', 'Item price', 'required'); 
		//$validation->set_rules('product_category_image', 'Category image', 'required');
		
			if($this->form_validation->run() == FALSE) {
							
				$this->edit_item();
				
			} else {
				
					$target = "uploads/item_images/";
					$target = $target . basename( $_FILES['item_image']['name']);
					$image = basename( $_FILES['item_image']['name']);
					//call_debug($image);
					$pic=($_FILES['item_image']['name']);
					
					$allowedExts = array("jpg", "jpeg", "gif", "png");
					$extension = end(explode(".", $_FILES["item_image"]["name"]));
					if ((($_FILES["item_image"]["type"] == "image/gif")|| ($_FILES["item_image"]["type"] == "image/jpeg")|| ($_FILES["item_image"]["type"] == "image/png")|| ($_FILES["item_image"]["type"] == "image/pjpeg"))&& ($_FILES["item_image"]["size"] < 20000000)&& in_array($extension, $allowedExts)){
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
											'mboos_product_image' 		=> $image,		
											'mboos_product_category_id' => $this->input->post('product_category')));		
					//call_debug($params);
								$this->mdldata->reset();
								$this->mdldata->SQLText(true);
								$this->mdldata->update($params);
								
								$QueryStringInsertproduct = $this->mdldata->buildQueryString();
								
								$params = array(
									'table'  => array('name' => 'mboos_product_price'),
									'fields' => array(
											'mboos_product_price'		=> $this->input->post('item_price'),
											'mboos_product_price_date'	=> $this->input->post('price_date'),
											'mboos_product_id'			=> '+@last_id_in_table1+'
												));
								$get_the_last_id = "SET @last_id_in_table1 = LAST_INSERT_ID()";
								
								$this->mdldata->reset();
								$this->mdldata->SQLText(true);
								$this->mdldata->insert($params);
								
								$QueryStringInsertprice = $this->mdldata->buildQueryString();

								$string = $QueryStringInsertprice;
								
								$pattern =  "/(\'\+|\+\')+/";
								$replacement = '';
								
								$cleanInsertQueryString =  preg_replace($pattern, $replacement, $string);
							
								$params['transact'] = array(
														$QueryStringInsertproduct,
														$get_the_last_id,
														$cleanInsertQueryString
													);				
								$this->mdldata->reset();
								$this->mdldata->executeTransact($params);

								
								$data['main_content'] = 'admin/item_view/item_success_view';
								$this->load->view('includes/template', $data);
							}
					}else{
						
						$this->edit_item();
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

