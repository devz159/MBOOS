<?php
class Item extends CI_Controller{
	public function __construct() {
		parent::__construct();
	}
	
	public function view_item() {
		
		//authenticate if logged in
		authUser();
		
		$params['table'] = array('name' => 'mboos_products', 'criteria_phrase' => 'mboos_product_status = "1"');
		$this->mdldata->select($params);
		
		$data['records'] = $this->mdldata->_mRecords;
		
		$data['main_content'] = 'admin/item_view/item_view';
		$this->load->view('includes/template', $data);
		}
		
	public function add_item() {
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('item_name', 'Item Name', 'required');
		$this->form_validation->set_rules('item_supplier', 'Item Supplier', 'required');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('admin/item_view/add_item_view');
			} else {
				$params = array(
							'table' => array('name' => 'mboos_products'),
							'fields' => array(
											'mboos_product_name' => $this->input->post('item_name'),
											'mboos_product_supplier' => $this->input->post('item_supplier') 
										)
							);
				$this->mdldata->reset();
				$this->mdldata->insert($params);
				
				$data['main_content'] = 'admin/item_view/item_success_view';
				$this->load->view('includes/template', $data);
				
				
				
				}
		}	
		
	public function edit_item() {
		
		authUser();
		
		$mboos_product_id = $this->uri->segment(4);
		//call_debug($mboos_product_id);
		$params['table'] = array('name' => 'mboos_products', 'criteria_phrase' => 'mboos_product_id="'. $mboos_product_id .'"');
		$this->mdldata->select($params);
		
		$data['user_info'] = $this->mdldata->_mRecords;
		
		$data['main_content'] = 'admin/item_view/edit_item_view';
		$this->load->view('includes/template', $data);
		
		}
		
	public function edit_item_validate() {
		
		authUser();
		
		$this->form_validation->set_rules('product_name', 'Product Name', 'required');
		$this->form_validation->set_rules('supplier_name', 'Product Supplier', 'required');
		
		if($this->form_validation->run() == FALSE) {
				$this->edit_item();
			} else {
					$params['fields'] = array(
										'mboos_product_name' => $this->input->post('product_name'),
										'mboos_product_supplier' => $this->input->post('supplier_name')
										);
					$params['table'] = array('name' => 'mboos_products', 'criteria_phrase' => 'mboos_product_id ="'. $this->input->post('product_id') .'"');
					
					if($this->mdldata->update($params)) {
						
						redirect('item/item/view_item');
						} else {
							redirect('item/item/edit_item');
							}
				}
		
		}
		
	public function delete_item() {
		
		authUser();
		
		$mboos_product_id = $this->uri->segment(4);
		//call_debug($mboos_product_id, FALSE);
		$params['fields'] = array(
							'mboos_product_product_status' => 0
							);
							
		$params['table'] = array('name' => 'mboos_products', 'criteria_phrase' => 'mboos_product_id="'. $mboos_product_id .'"');
		//$this->mdldata->SQLText(TRUE);
		//call_debug($params);
		$this->mdldata->update($params);
		//$string = $this->mdldata->buildQueryString();
		//call_debug($string);
		redirect('item/item/view_item');
		
		
		}
	public function back_item() {
			redirect('item/item/view_item');
			
			}
	
	//Category section
	public function view_category() {
		$data['main_content'] = 'admin/item_category_view/view_category_view';
		$this->load->view('includes/template', $data);
		}
	
	public function add_category() {
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('category_name', 'Category Name', 'required');
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('admin/item_category_view/add_category_view');
			
			} else {
				$params = array(
							'table' => array('name' => 'mboos_product_category'), 
							'fields' => array(
											'mboos_product_category_name' => $this->input->post('category_name')
										)
				
					);
					
				$this->mdldata->reset();
				$this->mdldata->insert($params);
				
				$data['main_content'] = 'admin/item_category_view/category_success_view';
				$this->load->view('includes/template', $data);
				
				}
		
		}
	
} 

?>