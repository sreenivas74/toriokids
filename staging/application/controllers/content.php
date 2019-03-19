<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Content extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('content_page_model');
		$this->load->model('footer_menu_model');
		$this->data['footer'] = $this->footer_menu_model->get_active_footer_menu_list();
		$this->load->model('secondary_menu_model');
		$this->data['secondary'] = $this->secondary_menu_model->get_active_secondary_menu_list();
	}
	
	function index($alias)
	{
		//$alias="the_torio_story_1";
		$this->data['detail']=$this->content_page_model->get_selected_content_page_data2($alias);
		if(!$this->data['detail'])redirect('not_found');
		$this->data['page_title']=$this->data['detail']['name'];
		$this->data['content'] = 'content/footer/content_page';
		$this->load->view('common/body', $this->data);
	}
}