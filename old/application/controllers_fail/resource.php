<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Resource extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('resource_model');
	}
	
	function index(){
		redirect('home');
	}
	
	function list_resource(){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","resource/list_resource","privilege_tb"))redirect('home');
		$this->data['resource_list'] = $this->resource_model->show_resource();
		$this->data['page'] = 'resource/resource_list';
		$this->load->view('common/body', $this->data);
	}
	
	function do_add_resource(){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","resource/add_resource","privilege_tb"))redirect('home');
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		$this->resource_model->do_add_resource($name,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function do_edit_resource($id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","resource/edit_resource","privilege_tb"))redirect('home');
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		$this->resource_model->do_edit_resource($id,$name,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_resource($id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","resource/edit_resource","privilege_tb"))redirect('home');
		$this->resource_model->delete_resource($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function active_resource($id,$active){
			if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","resource/edit_resource","privilege_tb"))redirect('home');
			if($active==1){
				$active = 0;	
			}else{
				$active = 1;	
			}
			$this->resource_model->active($id,$active);
			redirect($_SERVER['HTTP_REFERER']);
	}
}?>