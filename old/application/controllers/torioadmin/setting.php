<?php if(!defined('BASEPATH')) exit('no direct script access allowed'); 
	class Setting extends CI_Controller {
		function __construct(){
			parent::__construct();
				if($this->session->userdata('admin_logged_in')==FALSE)
					redirect('torioadmin/login');		
		}
	
	function index(){
		$this->load->model('setting_model');
		$this->data['setting']=$this->setting_model->get_setting();
		$this->data['content']='admin/setting/list';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function edit($name){
		$this->load->model('setting_model');
		$this->data['name']=$name;
		$this->data['detail']=$this->setting_model->get_setting_by_name($name);
		$this->data['content']='admin/setting/edit';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function do_edit(){
		$this->load->model('setting_model');
		$name=$this->input->post('name');
		$value=$this->input->post('value');
		$this->setting_model->edit_setting($name,$value);
		redirect('torioadmin/setting');
	}
}