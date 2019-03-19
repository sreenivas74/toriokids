<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Not_found extends CI_Controller{
	function __construct(){
		parent::__construct();	
		$this->data['page_title']="Page Not Found";
	}
	
	function index(){
		$this->data['content'] = 'content/not_found';
		$this->load->view('common/body', $this->data);
	}
	
}