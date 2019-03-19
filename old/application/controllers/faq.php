<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Faq extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('content_page_model');
		$this->data['page_title']="FAQ";
	}
	
	function index()
	{
		$this->data['faq_cat']=$this->content_page_model->get_active_faq_category_list();
		$this->data['faq']=$this->content_page_model->get_active_faq_list();
		$this->data['content'] = 'content/footer/faq';
		$this->load->view('common/body', $this->data);
	}    
}