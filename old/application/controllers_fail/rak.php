<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Rak extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('rak_model');
		$this->load->model('warehouse_model');
	}
	
	function index(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","rak/list_rak","privilege_tb")){
			$this->data['rak'] = $this->rak_model->show_rak();
			$this->data['page'] = 'rak/list';
			$this->load->view('common/body', $this->data);	
		}else{
			redirect('home');	
		}
	}
	
	function add(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","rak/add_rak","privilege_tb")){
			$this->data['warehouse_list'] = $this->warehouse_model->show_warehouse();
			$this->data['page'] = 'rak/add';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_add(){
		
		$warehouse_id=$this->input->post('warehouse');
		if($warehouse_id!='0'){
		$name = $this->input->post('name');
		$this->rak_model->do_add_rak($name,$warehouse_id);
			$_SESSION['status_add']='rak has been added';
		}else{
			$_SESSION['status_add']='please select rak';
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","rak/edit_rak","privilege_tb")){
			$this->data['warehouse_list'] = $this->warehouse_model->show_warehouse();
			$this->data['rak'] = $this->rak_model->show_rak_by_id($id);
			$this->data['page'] = 'rak/edit';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_edit($id){
		$warehouse_id=$this->input->post('warehouse');
		if($warehouse_id!='0'){
			$name = $this->input->post('name');
			$this->rak_model->do_edit_rak($id,$name,$warehouse_id);
			
		}

		redirect('rak');
	}
	
	
	function do_delete($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","rak/delete_rak","privilege_tb")){
			$this->rak_model->delete_rak($id);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	
	function get_rak_by_warehouse($warehouse_id){
		$this->data['rak_list']=$this->rak_model->show_rak_by_warehouse($warehouse_id);
		$this->data['page'] = 'rak/get_rak_by_warehouse';
		$this->load->view('rak/get_rak_by_warehouse', $this->data);	
	}
	function get_rak_by_warehouse2($warehouse_id,$rak_id){
		$this->data['rak_id']=$rak_id;
		$this->data['rak_list']=$this->rak_model->show_rak_by_warehouse($warehouse_id);
		$this->data['page'] = 'rak/get_rak_by_warehouse_edit';
		$this->load->view('rak/get_rak_by_warehouse_edit', $this->data);	
	}
	
	function get_rak_for_add_po_stock($warehouse_id,$no){
		$this->data['no']=$no;
		$this->data['rak_list']=$this->rak_model->show_rak_by_warehouse($warehouse_id);
		$this->data['page'] = 'rak/get_rak_for_po';
		$this->load->view('rak/get_rak_for_po', $this->data);	
	}
	
	function get_stock_by_rak($stock_id,$no){
		
		$this->data['no']=$no;
		$stock_detail=$this->rak_model->show_stock_detail($stock_id);
		$this->data['stock_list']=$this->rak_model->get_item_stock_by_name($stock_detail['item']);
		$this->data['page'] = 'rak/get_stock';
		$this->load->view('rak/get_stock', $this->data);	
	}
	
	function get_rak_by_warehouse_purchasing($warehouse_id,$no){
		$this->data['no']=$no;
		$this->data['rak_list']=$this->rak_model->show_rak_by_warehouse($warehouse_id);
		$this->data['page'] = 'rak/get_rak_by_warehouse_purchasing';
		$this->load->view('rak/get_rak_by_warehouse_purchasing', $this->data);	
	}
}