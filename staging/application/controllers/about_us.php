<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class About_us extends CI_Controller{
	function __construct(){
		parent::__construct();	
		$this->load->model('content_page_model');
		$this->load->model('footer_menu_model');
		$this->load->model('about_us_model');
		$this->data['footer'] = $this->footer_menu_model->get_active_footer_menu_list();
		$this->load->model('secondary_menu_model');
		$this->data['secondary'] = $this->secondary_menu_model->get_active_secondary_menu_list();
	}
	
	function index(){
		$this->data['about'] = $this->about_us_model->get_about_us_list_active();
		$this->data['banner'] = $this->about_us_model->get_about_us_banner();
		$this->data['point'] = $this->about_us_model->get_about_us_point_list_active();
		$this->data['page_title']='About Us';
		$this->data['content'] = 'content/about_us';
		$this->load->view('common/body', $this->data);
	}
	
}