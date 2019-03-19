<?php if(!defined('BASEPATH')) exit('no direct script access allowed'); 
	class Ads extends CI_Controller {
		function __construct(){
			parent::__construct();
				if($this->session->userdata('admin_logged_in')==FALSE)
					redirect('torioadmin/login');		
		}
	
	function index(){
		$this->load->model('ads_model');
		$this->data['ads_desktop'] = $this->ads_model->get_ads_desktop();
		$this->data['ads_mobile'] = $this->ads_model->get_ads_mobile();
		$this->data['content']='admin/ads/edit';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function do_edit(){
		$this->load->model('ads_model');
		$this->load->model('general_model');
		$this->general_model->truncate_data('ads_tb');
		$ads_desktop = $this->input->post('ads_desktop');
		$ads_mobile = $this->input->post('ads_mobile');
		
		if($ads_desktop!='') $this->ads_model->insert_ads('desktop', $ads_desktop);
		if($ads_mobile!='') $this->ads_model->insert_ads('mobile', $ads_mobile);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
}