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
		
		$this->_setSession(); // set session for pass_track
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
	
	private function _setSession() { //set session pass_track
	
		$params = array('pass_track' => 1); // set pass_track value to 1
	
		$this->sessionbrowser->setInfo($params); //send value of pass_track to 1 into sessionbrowser
		return TRUE;
	}
	
	public function set_new_password() { // function to reset password
	
		if($this->_checkSession()){ // check if session pass_track from dabase is = 1
				
			$this->_updateSession(); // update session pass_track from dabase to 0
			$this->_setSession_reset_pass_track(); // set session for reset_pass_track value to 1
	
			$data['main_content'] = 'mobile/forgot_new_password_view/forgot_new_password_view'; //load this page
			$this->load->view('includes/template', $data); // load template
	
		}else{
			
			
			$data['main_content'] = 'mobile/session_expired_view/session_expired_view'; // load this page
			$this->load->view('mobile_template/includes/template', $data); // load template
		}
	}
	
	private function _checkSession(){ //check session pass track
		$params = array('pass_track');
		$this->sessionbrowser->getInfo($params); // returns TRUE if successful, otherwise
	
		$arr = $this->sessionbrowser->mData; // returns array
	
		if($arr['pass_track'] == 1) //returns true if pass_track value is 1
			return TRUE;
	
		return FALSE;

	}
	
	private function _updateSession() {	//set session update pass_track
	
		$params = array('pass_track' => 0); // set pass_track value to 0
	
		$this->sessionbrowser->setInfo($params); //send value of pass_track to 0 into session browser
		return TRUE;
	}
	
	private function _setSession_reset_pass_track() { // set session reset_pass_track
	
		$params = array('reset_pass_track' => 1); //set reset_pass_track value to 1
	
		$this->sessionbrowser->setInfo($params);
		return TRUE;
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
			
			if($this->_checkSession_reset_pass_track()){  //check session reset_pass_track
					
				$this->_updateSession_reset_pass_track(); //update reset_pass_track value to 0
				$params = array(
						'table' => array('name' => 'mboos_customers','criteria_phrase' => 'mboos_customer_email="' .  strdecode($email) . '"'),
						'fields' => array('mboos_customer_pword' => md5($this->input->post('new_password'))));
	
				$this->mdldata->reset();
				$this->mdldata->update($params);
	
				$data['main_content'] = 'mobile/successfully_change_pword_view/successfully_change_pword_view';
				$this->load->view('mobile_template/includes/template', $data);
	
			} else {
	
				$data['main_content'] = 'admin/forgot_password_view/session_expired_view'; //load this page
				$this->load->view('mobile_template/includes/template', $data); //load template
	
			}
		}
	
	}
	
	private function _checkSession_reset_pass_track(){ //check session reset_pass_track
		$params = array('reset_pass_track');
		$this->sessionbrowser->getInfo($params); // returns TRUE if successful, otherwise
	
		$arr = $this->sessionbrowser->mData; // returns array
	
		if($arr['reset_pass_track'] == 1) //returns true if reset_pass_track = 1
			return TRUE;
	
		return FALSE;
		//call_debug($arr);
	}
	
	private function _updateSession_reset_pass_track() { //update session reset_pass_track
	
		$params = array('reset_pass_track' => 0); //set reset_pass_track value to 0
	
		$this->sessionbrowser->setInfo($params); //send value to sessionbrowser
		return TRUE;
	}
	
}

