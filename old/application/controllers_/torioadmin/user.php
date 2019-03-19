<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class User extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if ($this->session->userdata('admin_logged_in')==false) {
			redirect('torioadmin/login');
		}
		$this->load->model('user_model');
	}
	
	function index($user1=null)
	{
		$user2 = $this->input->post('user');
		if($user1)$user=$user1;
		else $user=$user2;
		if($user==2){
			$this->data['user']=$this->user_model->user_list();
		}else{
			$this->data['user']=$this->user_model->user_list2($user);
		}
		$this->data['us']=$user;
		$this->data['keyword']='';
		$this->data['content']='admin/user/list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function search()
	{
		$keyword=$this->data['keyword']=$this->input->post('keyword');
		$this->data['user']=$this->user_model->get_search_user($keyword);
		$this->data['us']="search";
		$this->data['content']='admin/user/list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function detail($id)
	{
		$this->data['user']=$this->user_model->user_detail($id);
		$this->data['order']=$this->user_model->get_order_by_user($id);
		$this->data['content']='admin/user/detail';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function change_status_user($id,$status)
	{
		if($status==1){
			$status=0;	
		}else{
			$status=1;	
		}
		$this->user_model->change_status_user($id,$status);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
