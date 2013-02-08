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
		
		$config["total_rows"] = $this->_getcountproducts();
		
		$data['products'] = $this->_getlistproducts();
		//call_debug($data);
		$data['main_content'] = 'admin/item_view/item_view';
		$this->load->view('includes/template', $data);
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
		
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		
		$datestring = "Y-m-d g:i:s";
		$time = time();
	
		$item_date = mdate($datestring, $time);
		
		//call_debug($this->input->post('userfile'));
		$this->load->library('form_validation'); // loads form_validation from library
		$validation = $this->form_validation;	// initializes form_validation
		
		$validation->set_rules('item_name', 'Item name', 'required'); // setting validation rules
		$validation->set_rules('item_price', 'Item price', 'required');
		//$validation->set_rules('item_image', 'Item image', 'required');
		
		if($this->form_validation->run() == FALSE) {
				
				$this->add_item();
					
			} else {
					
					$target = "images/item_images/";
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
											'mboos_product_price_date'	=> $item_date,
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
											'mboos_user_id'             => $data['sessVar']['sadmin_uid'],
											'mboos_inStocks_quantity'   => 0,
											'mboos_inStocks_date'       => $item_date,
											'mboos_inStocks_quantity'	=> $this->input->post('item_quantity'),
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
								//call_debug($params);
								$this->mdldata->reset();
								$this->mdldata->executeTransact($params);
								//call_debug($QueryStringInsertprice);
																
								redirect('admin/item');
							}
					}else{
						
						redirect('admin/item/add_item');
					}
			}
	}
	
	public function upload_image(){
			
		authUser();
		
		$data['sessVar'] = $this->_arr;
		
		$id = $this->uri->segment(4);
		
		$params['table'] = array('name' => ' mboos_products' , 'criteria_phrase' => ' mboos_product_id="'. $id . '"');
		$this->mdldata->select($params);
		
		$data['item_info'] = $this->mdldata->_mRecords;
		
		
		$data['main_content'] = 'admin/item_view/upload_image_view';
		$this->load->view('includes/template', $data);
			
	}
	
	public function upload_image_validate(){
					
					$edit_image_id = $this->input->post('item_id');
				
					$target = "images/item_images/";
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
							  		'table' => array('name' => 'mboos_products', 'criteria_phrase' => 'mboos_product_id= "' . $edit_image_id . '"'),
							        'fields' => array(					
											'mboos_product_image' => $image));	
											
								$this->mdldata->reset();
								$this->mdldata->update($params);
									
								redirect('admin/item/edit_item/'. $edit_image_id .'');
							}	
						}else{
							
							authUser();
							
							$data['sessVar'] = $this->_arr;
							
							redirect('admin/item/upload_image/'. $edit_image_id .'');
							
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
		$params['querystring'] = 'SELECT mboos_product_price.mboos_product_price, mboos_product_price.mboos_product_price_date, mboos_product_price.mboos_product_price_status FROM mboos_product_price WHERE mboos_product_price.mboos_product_id="'. $edit_item_id .'" and mboos_product_price.mboos_product_price_status="1"';
		$this->mdldata->select($params);
		$data['item_price'] = $this->mdldata->_mRecords;
		
		
		$this->mdldata->reset();
		$params['querystring'] = "SELECT * FROM	mboos_product_price where mboos_product_id='". $edit_item_id . "' ORDER BY `mboos_product_price`.`mboos_product_price_status` ASC";
		$this->mdldata->select($params);
		$data['all_price'] = $this->mdldata->_mRecords;
	
							
		$params['querystring'] = 'SELECT * FROM mboos_products
		LEFT JOIN mboos_product_category ON mboos_products.mboos_product_category_id = mboos_product_category.mboos_product_category_id WHERE mboos_products.mboos_product_id="'. $edit_item_id .'"';

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
		//$validation->set_rules('item_price', 'Item price', 'required'); 
		//$validation->set_rules('product_category_image', 'Category image', 'required');
		
			if($this->form_validation->run() == FALSE) {
							
				redirect('admin/item/edit_item/'. $edit_item_id .'');
				
			} else {
				
								$params = array(
							  		'table' => array('name' => 'mboos_products', 'criteria_phrase' => 'mboos_product_id= "' . $this->input->post('item_id') . '"'),
							        'fields' => array(						                                     
											'mboos_product_name' 		=> $this->input->post('item_name'),
											'mboos_product_desc' 		=> $this->input->post('item_desc'),
											'mboos_product_supplier' 	=> $this->input->post('item_supplier'),		
											'mboos_product_category_id' => $this->input->post('product_category')));		
								//call_debug($params);
								$this->mdldata->reset();
								//$this->mdldata->SQLText(true);
								$this->mdldata->update($params);
								
								redirect('admin/item');
							
			}
	}
	
	public function add_price(){
	
		$product_id = $this->uri->segment(4);
		
		$data['main_content'] = 'admin/item_view/add_item_price_view';
		$this->load->view('includes/template', $data);
	}
	
	public function add_price_validate(){
		
		$edit_item_id = $this->input->post('item_id');
		
		$this->load->library('form_validation'); // loads form_validation from library
		$validation = $this->form_validation;	// initializes form_validation
		
		$validation->set_rules('item_price_new', 'Item name', 'required'); // setting validation rules
		
		if($this->form_validation->run() == FALSE) {
							
				redirect('admin/item/add_price/'. $edit_item_id .'');
				
		} else {
			
			// get the date
			$datestring = "Y-m-d g:i:s";
			$time = time();
			
			$item_price = $this->input->post('item_price_new');
			$item_date = mdate($datestring, $time);
			$item_id = $this->input->post('item_id');
			
			$params['querystring'] = 'INSERT INTO mboos_product_price (mboos_product_price, mboos_product_price_date, mboos_product_id) VALUES ("'. $item_price .'", "'. $item_date .'", "'. $item_id .'")';
						
			$this->mdldata->reset();
			$this->mdldata->insert($params);
			
			$params['querystring'] ='UPDATE mboos_product_price SET mboos_product_price_status="0" WHERE mboos_product_price_date!="'. $item_date .'" AND mboos_product_id="'. $item_id .'"';
			
			$this->mdldata->reset();
			$this->mdldata->update($params);

			redirect('admin/item/edit_item/'. $this->input->post('item_id') .'');
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

