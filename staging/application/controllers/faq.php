<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Faq extends CI_Controller{
	function __construct(){
		parent::__construct();	
		$this->load->model('content_page_model');
		$this->load->model('footer_menu_model');
		$this->data['footer'] = $this->footer_menu_model->get_active_footer_menu_list();
		$this->load->model('secondary_menu_model');
		$this->data['secondary'] = $this->secondary_menu_model->get_active_secondary_menu_list();
	}
	
	function index(){
		$this->data['faq_cat']=$this->content_page_model->get_active_faq_category_list();
		$this->data['faq']=$this->content_page_model->get_active_faq_list();
		$this->data['page_title']='FAQ';
		$this->data['content'] = 'content/faq';
		$this->load->view('common/body', $this->data);
	}
	
}