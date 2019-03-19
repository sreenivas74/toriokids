<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
	function __construct(){
		parent::__construct();
		if($this->session->userdata('admin_logged_in')==FALSE)redirect('torioadmin/login');	
		$this->load->model('admin_model');
	}
	
	function index()
	{
		$this->data['content']='admin/home';
		$this->load->view('common/admin/body', $this->data);
	}    
}