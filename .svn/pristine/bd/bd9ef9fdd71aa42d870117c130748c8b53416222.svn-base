<?php
class Login_validation extends CI_Controller{
	function index(){
		/** $this->load->helper(array('form','url')); **/
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('validation_username', 'Username', 'required');
		$this->form_validation->set_rules('validation_password', 'Password', 'required');
		$this->form_validation->set_rules('validation_confirm', 'Confrim Password', 'required|matches[validation_password]');
		$this->form_validation->set_rules('validation_email', 'E-mail Address', 'required');
		
		if($this->form_validation->run() == FALSE) {
			
			$this->load->view('admin/login_validation/login_validation');
			} else {
				$params = array(
							'table' => array('name' => 'mboos_users'),
							'fields' => array(
											'mboos_user_email' => $this->input->post('validation_email'),
											'mboos_user_username' => $this->input->post('validation_username'),
											'mboos_user_password' => md5($this->input->post('validation_password')),
											'mboos_user_secret_question' => $this->input->post('validation_question'),
											'mboos_user_secret_answer' => $this->input->post('validation_answer')
											) 
								);
				$this->mdldata->reset();
				$this->mdldata->insert($params);	
				
				//$this->load->view('admin/login_validation/validation_success');
				$data['main_content'] = 'admin/login_validation/validation_success';
				$this->load->view('includes/template', $data);
				}
		
		}	
	
	
}

?>