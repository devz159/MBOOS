<?php 
class Profile_mboos extends CI_Controller{
	public function __construct() {
		parent::__construct();
		
		$params = array('sadmin_uname', 'sadmin_islogin', 'sadmin_ulvl', 'sadmin_uid');
		$this->sessionbrowser->getInfo($params);
		$this->_arr = $this->sessionbrowser->mData;
	
	}
	
	public function edit_profile() {
		
		//get session variables
		$params = array(
						'sadmin_uname', 
						'sadmin_email', 
						'sadmin_islogin',
						'sadmin_uid');
						
		$this->sessionbrowser->getInfo($params);
		$data['currUser'] = $this->sessionbrowser->mData;
		
		$data['sessVar'] = $this->_arr;
		
		authUser(); //check if user is logged in
		
		$currUser = $this->uri->segment(4); //selects the 4th segment of the URL
		
		$params['table'] = array('name' => 'mboos_users', 'criteria_phrase' => 'mboos_user_id="'. $currUser .'"');
		$this->mdldata->select($params);
		
		
		$data['user_info'] = $this->mdldata->_mRecords;
		
		$data['main_content'] = 'admin/edit_profile_view/edit_profile_view';
		$this->load->view('includes/template', $data);
		}
		
	public function edit_validate() {
		
		authUser();
		
		$this->form_validation->set_rules('user_email', 'User E-Mail', 'required');
		$this->form_validation->set_rules('user_username', 'Username', 'required');
		
		if($this->form_validation->run() == FALSE) {
			redirect('admin/profile_mboos/edit_profile'. $currUser);
			
			} else {
				
				$params['fields'] = array(
						'mboos_user_email' => $this->input->post('user_email'),
						'mboos_user_username' => $this->input->post('user_username')
					);
				$currUser = $this->input->post('user_id');	
				$params['table'] = array('name'=>'mboos_users', 'criteria' => 'mboos_user_id', 'criteria_value' => $currUser);
				
				//$this->mdldata->SQLText(TRUE);
				//$this->mdldata->update($params);
				//$string = $this->mdldata->buildQueryString();
				//call_debug($string);
				if($this->mdldata->update($params)) {
					
					//echo 'The database has been updated';
					redirect('admin/profile_mboos/edit_profile/'. $currUser);
					} else {
					redirect('admin/profile_mboos/edit_profile/'. $currUser);
						} 
				
				
				}
		}
		public function back_profile() {
			redirect('admin/dashboard');
			
			}
	
}
?>