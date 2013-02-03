<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	

	public function __construct() {
		parent::__construct();

	
	}
	
	public function index() {
		
		if($this->_isExists()) {
			echo "1";
		} else {
			echo "0";
		}
	
	}
	
	public function _isExists() {
	
		$email = mysql_real_escape_string($this->input->post('email'));
		$pword = md5($this->input->post('pword'));
	
		$string = "mboos_customer_email='" . $email . "' and mboos_customer_pword='". $pword . "' and mboos_customer_status='1'";
		
		$params['table'] = array('name' => 'mboos_customers', 'criteria_phrase' => $string );
	
		$this->mdldata->select($params);
		
	
		if($this->mdldata->_mRowCount < 1)
			return FALSE;
	
		return TRUE;
	}
	

	
	public function forgot_password() {
		
		$email = mysql_real_escape_string($this->input->post('email'));
		
		$params['table'] = array('name' => 'mboos_customers', 'criteria_phrase' => 'mboos_customer_email="'. $email . '"');
		
		$this->mdldata->select($params);
		
		if($this->mdldata->_mRowCount == 1) {
			
				echo "1";
			
			
		} else {
			
			    echo "0";
		}
		

	}
	
	
	public function reset_password() {
		
		$receiver = $this->input->get('email');
		
		$data['email'] = $receiver;
		
		
		$session_id = $this->session->userdata('session_id'); //initialize session userdata
		$params = array( // process to send email
				'sender' => 'mboosCOM@gmail.com',
				'receiver' => $receiver,
				'from_name' => 'Web Master', // OPTIONAL
				'cc' => '', // OPTIONAL
				'subject' => 'Reset Password', // OPTIONAL
				'msg' => '<p>Hello,</p><br/><br/><p>Click <a href = "http://localhost/MBOOS/mobile_ajax/login/set_new_password/' . strencode($receiver) . '/' . $session_id . '">here</a> to reset your password.</p><br /><br /><p>Regards<p><p>MBOOS Company</p>', // OPTIONAL
				'email_temp_account' => TRUE, // OPTIONAL. Uses your specified google account only. Please see this method "_tmpEmailAccount" below (line 111).
		);
		
		$this->load->library('emailutil', $params); // loads emailutil from library
		
		if($this->emailutil->send()){ // send if library is loaded
			
			$data['main_content'] = 'mobile/forgot_password_email_send_view/forgot_password_email_send_view';
			$this->load->view('mobile_template/includes/template', $data);
			
		}else{
			echo "message not sent"; // does not send if not loaded
		}
		
	}

	
	public function set_new_password() { // function to reset password
					
			$data['main_content'] = 'mobile/forgot_new_password_view/forgot_new_password_view'; //load this page
			$this->load->view('mobile_template/includes/template', $data); // load template
	
	}
	
	
	
	public function reset_password_validate() { // validate reset password
	
		$newpass = $this->input->post('new_password'); // initialize post 'new_password' from reset_password_view
		
		$this->load->library('form_validation'); // load form_validation from library
	
	
		$this->form_validation->set_rules('confirm_password', 'Confrim Password', 'required|matches[new_password]'); // set validation rules
	
	
		if($this->form_validation->run() == FALSE) { //returns false if validation rules are violated
	
			$data['main_content'] = 'mobile/forgot_new_password_view/forgot_new_password_view'; //load this page
			$this->load->view('includes/template', $data); // load template
			
		} else {
	
			$email = $this->input->post('email'); //initialize post 'email' from reset_password_view

				$params = array(
						'table' => array('name' => 'mboos_customers','criteria_phrase' => 'mboos_customer_email="' .  strdecode($email) . '"'),
						'fields' => array('mboos_customer_pword' => md5($this->input->post('new_password'))));
	
				$this->mdldata->reset();
				$this->mdldata->update($params);
	
				$data['main_content'] = 'mobile/successfully_change_pword_view/successfully_change_pword_view';
				$this->load->view('mobile_template/includes/template', $data);
				
		}
	
	}

	
}

