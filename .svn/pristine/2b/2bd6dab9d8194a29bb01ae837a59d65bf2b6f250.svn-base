<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	private $_arr;
	
	public function __construct() {
		parent::__construct();
		
		$params = array('sadmin_uname', 'sadmin_islogin', 'sadmin_ulvl', 'sadmin_uid');
		$this->sessionbrowser->getInfo($params);
		$this->_arr = $this->sessionbrowser->mData;
	}
	
	public function index()
	{
		authUser();
		//call_debug($this->_arr);
		$data['sessVar'] = $this->_arr;
		
		$data['main_content'] = 'admin/home_page_view/home_page_view';
		$this->load->view('includes/template', $data);
	}
}

