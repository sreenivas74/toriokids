<?php if(!defined("BASEPATH")) exit("Hack Attempt");

class Logout extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('admin_model');
	}
	
	function index()
	{
		$this->admin_model->admin_last_login();
		$sess_admin = array (
						   'admin_logged_in' => '',
						   'admin_id' => '',
						   'admin_fullname' => '',
						   'admin_username' => '',
						   'admin_last_login' => ''
						);
		$this->session->unset_userdata($sess_admin);
		redirect('torioadmin/login'); 
	}
}?>