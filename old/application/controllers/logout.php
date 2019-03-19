<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Logout extends CI_Controller {
	function __construct(){
		parent::__construct();	
	}	
	
	function index()
	{		
		$sess_user = array (
					   'user_logged_in' => false,
					   'user_id' => '',
					   'email' => '',
					   'name' => ''
					);
		$this->session->unset_userdata($sess_user);
		redirect('home');
	}
}
