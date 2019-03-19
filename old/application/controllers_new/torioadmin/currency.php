<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Currency extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('currency_model');	
	}
	
	function index()
	{
		$this->data['detail']=$this->currency_model->get_currency();
		$this->data['content']='admin/currency/edit';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit(){
		$rate=$this->input->post('rate');
		$this->currency_model->update_currency($rate);
		redirect($_SERVER['HTTP_REFERER']);
	}
}