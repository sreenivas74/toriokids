<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Currency extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('currency_model');
		$this->load->model('flexigrid_model');
	}
	
	function index(){
		redirect('home');
	}
	
	function list_currency(){
		$this->data['idr_setting'] = $this->currency_model->show_currency();
		$this->data['page'] = 'setting/list_currency';
		$this->load->view('common/body', $this->data);
	}
	
	function do_edit_currency(){
		$idr = $this->input->post('idr');
		$this->currency_model->do_edit_currency($idr);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
}?>