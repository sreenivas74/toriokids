<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in') == TRUE)redirect('torioadmin/home');
		$this->load->model('admin_model');
	}
	
	function index()
	{
		$this->data['content'] = 'admin/login';
		$this->load->view('common/admin/body', $this->data);
	}
	
	function do_login()
	{
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		
		if(!$username || !$password){
			$this->data['error'] = 'Invalid username or password';
			$this->data['content'] = 'admin/login';
			$this->load->view('common/admin/body',$this->data);
		}
		else{
			$login = $this->admin_model->login($username, $password);
			if ($login != NULL) {
				$sess_admin = array (
									   'admin_logged_in' => true,
									   'admin_id' => $login['id'],
									   'admin_fullname' => $login['name'],
									   'admin_username' => $login['username'],
									   'admin_last_login' => $login['last_login'],
									);
				$this->session->set_userdata($sess_admin);				
				redirect ('torioadmin/home');
			}
			else {
				$this->data['content'] = 'admin/login';
				$this->data['error'] = 'Invalid username or password';
				$this->load->view('common/admin/body', $this->data);
			}
		}
	}
	
	
}?>