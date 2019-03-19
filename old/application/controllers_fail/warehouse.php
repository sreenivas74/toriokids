<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Warehouse extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('warehouse_model');
	}
	
	function index(){
		redirect('home');
	}
	
	function list_warehouse(){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","warehouse/list_warehouse","privilege_tb"))redirect('home');
		$this->data['warehouse_list'] = $this->warehouse_model->show_warehouse();
		$this->data['page'] = 'warehouse/warehouse_list';
		$this->load->view('common/body', $this->data);
	}
	
	function do_add_warehouse(){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","warehouse/add_warehouse","privilege_tb"))redirect('home');
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		$this->warehouse_model->do_add_warehouse($name,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function do_edit_warehouse($id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","warehouse/edit_warehouse","privilege_tb"))redirect('home');
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		$this->warehouse_model->do_edit_warehouse($id,$name,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_warehouse($id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","warehouse/edit_warehouse","privilege_tb"))redirect('home');
		$this->warehouse_model->delete_warehouse($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function active_warehouse($id,$active){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","warehouse/edit_warehouse","privilege_tb"))redirect('home');
		if($active==1){
			$active = 0;	
		}else{
			$active = 1;	
		}
		$this->warehouse_model->active($id,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
}?>