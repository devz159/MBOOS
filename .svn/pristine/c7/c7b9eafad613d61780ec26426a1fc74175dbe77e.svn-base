<?php

class Sender {
	
	// private member variables
	private $_mTo;
	private $_mFrom;
	private $_mSubject;
	private $_mMessage;
	private $_mArrMessages;
	private $_mFirstWeekNotice;
	private $_mBfSecondWeekNotice;
	private $_mSecondWeekNotice;
	private $_mArrPropertiesToRemove;
	
	// Super global CodeIgniter object
	public $CI;
	
	function __construct($param = array()) {
		
		// Initializes some member variables
		$this->CI =& get_instance();
		$this->_mTo = '';
		$this->_mFrom = '';
		$this->_mSubject = '';
		$this->_mMessage = '';
		$this->_mArrMessages = array();
		$this->_mFirstWeekNotice = array();
		$this->_mBfSecondWeekNotice = array();
		$this->_mSecondWeekNotice = array();
		$this->_mArrPropertiesToRemove = array();
		
		// Loads customized config file
		$this->CI->config->load('hrconfig', TRUE);
		
		
		if(count($param) > 0)
		{
			$this->initialize($param);
		}
		
		$this->log_message('Sender class has been successfully loaded');
	}
	
/*
 *
 * --------------------------------------------------------------------------------------------->
 *
 * ============================================================
 * Utility functions here
 * ============================================================
 */
	/*
 	 * Initializes the parameters
 	 * @input	array()
 	 * @output	none
 	 * 
 	 */
	public function initialize($config = array()) {
		$valid_params = FALSE;
		
		$valid_params = $this->_isArrayNotEmpty($config);
		
		switch ($valid_params) {
			case TRUE:
				$this->_mTo = $config['sendee'];
				$this->_mFirstWeekNotice = $config['firstweek'];
				$this->_mBfSecondWeekNotice = $config['bfsecondweek'];
				$this->_mSecondWeekNotice = $config['secondweek'];
				break;
				
			case FALSE:
				$this->log_message('Argument passed is not an array');
				break;
		}		
	}
	
	/*
	 * Main function
	 */
	public function doSendEmail() {
		
		// Main logic here
		/*
		 * First week notice part
		 */
		// Send mail for first week notice
		//$firstWeekNotice = $this->_mFirstWeekNotice;
		$firstWeekNotice = $this->_mFirstWeekNotice;
		
		$tmpHdrMsg = '';
		$tmpfooter = '<br />' . $this->CI->config->item('email_footer', 'hrconfig');
		$tmpMsg = '';
		$tmpDate = '';
		
		foreach ($firstWeekNotice as $key => $firstNotice){
			$tmpMsg .= '<a href="' . $this->CI->config->item('searchpagedetail', 'hrconfig') . $firstNotice['propno'] . '" >' . $firstNotice['address'] . '</a>' . '<br />';
			$tmpDate = longDate($firstNotice['availability']);
		}
		
		$tmpHdrMsg = 'The following property/ies is/are listed on or before ' . $tmpDate . '<br /><br >';
		 
		// Checks to see if array don't have data, if so then don't send email
		if(!empty($tmpMsg))
		{
			$tmpHdrMsg .= $tmpMsg . $tmpfooter;
			
			if($this->_sendMail($this->_mTo, 'Notice: Listed property/ies - 1 week elapsed', $tmpHdrMsg))
			{
				//echo 'Sending mail successful =='; //@todo - debuggin purposes
			}
		}
		
		/* ========================================================= */
		
		
		/*
		 * notice before removal - 13days.
		 */
		// Send mail for bfsecond week notice		
		$bfSecondWeekNotice = $this->_mBfSecondWeekNotice;
		
		$tmpHdrMsg = '';
		$tmpfooter = '<br />' . $this->CI->config->item('email_footer', 'hrconfig');
		$tmpMsg = '';
		$tmpDate = '';
		
		foreach ($bfSecondWeekNotice as $key => $bfSecondNotice){
			$tmpMsg .= '<a href="' . $this->CI->config->item('searchpagedetail', 'hrconfig') . $bfSecondNotice['propno'] . '" >' . $bfSecondNotice['address'] . '</a>' . '<br />';
			$tmpDate = longDate($bfSecondNotice['availability']);
		}
		
		$tmpHdrMsg = 'The following property/ies is/are listed on ' . $tmpDate . '<br /><br />';
		 
		$tmpHdrMsg .= $tmpMsg . $tmpfooter;
		
		if(!empty($tmpMsg))
		{
			if($this->_sendMail($this->_mTo, 'Notice: Listed properties are about to be removed', $tmpHdrMsg))
			{
				//echo 'Sending mail successful ***'; //@todo - debuggin purposes
			}
		}
		
		/* ========================================================= */
		
		
		/*
		 * notice for removal - 14days.
		 */
		// Send mail for bfsecond week notice		
		$SecondWeekNotice = $this->_mSecondWeekNotice;
		
		$tmpHdrMsg = '';
		$tmpfooter = '<br />' . $this->CI->config->item('email_footer', 'hrconfig');
		$tmpMsg = '';
		$tmpDate = '';
		
		foreach ($SecondWeekNotice as $key => $SecondNotice){
			$tmpMsg .= '<a href="' . $this->CI->config->item('searchpagedetail', 'hrconfig') . $SecondNotice['propno'] . '" >' . $SecondNotice['address'] . '</a>' . '<br />';
			
			$tmpDate = longDate($SecondNotice['availability']);
			
			array_push($this->_mArrPropertiesToRemove, $SecondNotice['propno']);
		}
		
		//echo $tmpMsg; shows all the link of properties
		
		$tmpHdrMsg = 'The following property/ies is/are listed on ' . $tmpDate . '<br /><br />';
		 
		$tmpHdrMsg .= $tmpMsg . $tmpfooter;
		
		if(!empty($tmpMsg))
		{
			if($this->_sendMail($this->_mTo, 'Notice: Listed properties have been removed', $tmpHdrMsg, $SecondNotice))
			{
				//echo 'Sending mail successful +++'; //@todo - debuggin purposes
				// call remover class here. remove per property basis.
				$config = array(
								'table' => 'properties',
								'remove' => 'remove',
								'filled' => 'filled',
								'propId' => $this->_mArrPropertiesToRemove
								);
				$this->CI->load->library('remover');
				$this->CI->remover->initialize($config);
				$this->CI->remover->doRemoveProperty();
			}
			else 
			{
				//echo 'Sending mail error ///'; //@todo - debuggin purposes
				
			}
		}
		 
		/* ========================================================= */
		
		// empties all arrays
		$this->_mArrPropertiesToRemove = array();
		
		return TRUE;
	}
	
	
	/*
	 * Creates mail
	 */
	private function _createMail($account) {
		
		foreach($account as $key => $val)
		{
			echo 'Key: ' . $key . ' => ' . $val . '<br />';
		}
		
		return TRUE;
	}
	
	/*
	 * Send mail 
	 */
	private function _sendMail($To, $subject, $msg) {
		
		
		/*echo 'To: ' . $To ,'<br />';
		echo 'From: ' . $this->CI->config->item('eml_admin') . '<br />';
		echo 'Subject: ' . $subject . '<br />';
		echo '<pre />';
		print_r($msg);
		
		die();*/
		
		// Loads the email library
		$config = array(
					'protocol' => 'sendmail',
					'mailpath' => '/usr/sbin/sendmail',
					'mailtype' => 'html'
				);
				
		$this->CI->load->library('email');
		$this->CI->email->initialize($config);
		
		$this->CI->email->from($this->CI->config->item('eml_admin'), 'Hello Renter Admin');
		$this->CI->email->to($To);
		$this->CI->email->cc($this->CI->config->item('eml_support'));
		
		$this->CI->email->subject($subject);
		$this->CI->email->message($msg);
		
		if($this->CI->email->send())
		{			
			return TRUE;
		}
		else
		{
			$this->log_message('Error sending mail to ' . $To);
			return FALSE;
		}
		
		
				
	}
	
	/*
	 * Checks the count of array
	 * @input		array()
	 * @output		boolean
	 */
	private function _isArrayNotEmpty ($arrVal) {
		if(empty($arrVal))
			return FALSE;
		
		return TRUE;
	}
	

	/*
	 * Logs messages
	 */
	private function log_message($message = 'Unknow error') {
		array_push($this->_mArrMessages, $message);
	}
	
	
	
/*
 * --------------------------------------------------------------------------------------------->
 *
 * ============================================================
 * Setter functions here
 * ============================================================
 */
 	
 	
 /*
 * --------------------------------------------------------------------------------------------->
 *
 * ============================================================
 * Getter functions here
 * ============================================================
 */
}