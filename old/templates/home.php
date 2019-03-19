<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('banner_model');
		$this->load->model('featured_item_model');
		$this->load->model('product_model');
		$this->data['page_title']="Home";
	}
	
	function index()
	{
		$this->data['home_banner']=$this->banner_model->get_active_home_banner_list(1);
		$this->data['second']=$this->banner_model->get_selected_second_data(2);
		$this->data['footer_banner']=$this->banner_model->get_selected_second_data(3);
		$this->data['featured']=$this->featured_item_model->get_active_featured_item_list();
		$this->data['product_featured']=$this->product_model->get_active_featured_list();
		$this->data['content'] = 'content/home';
		$this->load->view('common/body', $this->data);	
	}    
	
	function download_order($order_id=''){
		if($order_id){
			$this->load->model('user_model');
			$this->load->model('order_model');
			
			$this->load->helper(array('dompdf', 'file'));
			// page info here, db calls, etc.     
			
			$this->data['shipping']=$this->user_model->get_shipping_info($order_id);
			$this->data['order']=$this->user_model->get_order2($order_id);
			$this->data['detail']=$datadetail=$this->order_model->get_order_detail($order_id);
			$user_id=$datadetail['user_id'];
			$this->data['sender_detail']=$data100=$this->user_model->user_detail($user_id);
			// pre($datadetail);exit();
			$this->data['discount']=0;
			$this->data['item']=$this->order_model->get_order_item($order_id);
			$html = $this->load->view('admin/order/testexcel', $this->data, true);
			$filename = "Order-".$datadetail['order_number'];
			pdf_create($html, $filename);	
		}
	}
	
	function facebook(){
	//pre($_POST);
		$like=$this->input->post('like');
			if($like==1){
			$facebook_user = array ('likes' => 1);
			};
			$this->session->set_userdata($facebook_user);
			$_SESSION['like_pages']=1;
	}
	
	function facebookusertoken(){
	//	pre($_POST);
		if(!$this->session->userdata('fb_id'))
		$_SESSION['apply_coupon']=1;
	
		$this->load->model('user_model');
		$user_id=$this->session->userdata('user_id');
		$fb_id=$this->input->post('fb_id');
		$fb_token=$this->input->post('fb_token');
		$database = array ('fb_id'=>$fb_id,'fb_token'=>$fb_token);
		$this->session->set_userdata($database);
		$where=array('id'=>$user_id);
		$this->user_model->update_data('user_tb', $database, $where);
	}
}