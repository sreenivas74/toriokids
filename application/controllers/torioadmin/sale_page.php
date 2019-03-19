<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Sale_page extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('content_page_model');
		$this->load->model('general_model');
	}
	
	function index(){
		$this->data['detail']=$this->content_page_model->get_content_sale_page();
		$this->data['content']='admin/sale_page_content';
		$this->load->view('common/admin/body',$this->data);	
	}
	function do_edit(){
		$content = $this->input->post('content');
		$active = $this->input->post('active');
		$data = array(	'active'=>$active,
							'content'=>$content );		
		$table='sale_page_content_tb';
		$where='';
		$this->general_model->update_data($table, $data, $where);
		redirect($_SERVER['HTTP_REFERER']);
	}
}