<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class E_channel extends CI_Controller{
	function __construct(){
		parent::__construct();	
		$this->load->model('content_page_model');
		$this->load->model('channel_model');
		$this->load->model('footer_menu_model');
		$this->data['footer'] = $this->footer_menu_model->get_active_footer_menu_list();
		$this->load->model('secondary_menu_model');
		$this->data['secondary'] = $this->secondary_menu_model->get_active_secondary_menu_list();
	}
	
	function index(){
		$this->data['channel']= $this->channel_model->get_channel_list_active();
		$this->data['banner']= $this->channel_model->get_channel_banner();
		$this->data['page_title']='E-Channel';
		$this->data['content'] = 'content/e-channel';
		$this->load->view('common/body', $this->data);
	}
	
}