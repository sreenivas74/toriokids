<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Discount_cart extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('discount_model');	
	}
	
	function index()
	{
		$this->data['detail']=$this->discount_model->get_list_discount_cart();
		$this->data['content']='admin/discount_cart/list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function add()
	{	
		$this->data['content']='admin/discount_cart/add';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add()
	{	
		$date_start = $this->input->post('date_start');	
		$date_end = $this->input->post('date_end');	
		$name = $this->input->post('name');
		$minimum = $this->input->post('minimum');
		$discount = $this->input->post('discount');
		
		$database = array(	'date_start'=>$date_start,
						 	'date_end'=>$date_end, 
							'name'=>$name,
							'discount'=>$discount,
							'minimum_purchase'=>$minimum,
							'status'=>1 );		
		$this->discount_model->insert_data('discount_cart_tb',$database);
		redirect('torioadmin/discount_cart');
	}
	
	function edit($id)
	{
		$this->data['detail']=$this->discount_model->get_selected_data_discount_cart($id);
		$this->data['content']='admin/discount_cart/edit';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit()
	{
		$id = $this->input->post('disc_cart_id');	
		$date_start = $this->input->post('date_start');	
		$date_end = $this->input->post('date_end');	
		$name = $this->input->post('name');
		$minimum = $this->input->post('minimum');
		$discount = $this->input->post('discount');
		
		$database = array(	'date_start'=>$date_start,
						 	'date_end'=>$date_end, 
							'name'=>$name,
							'discount'=>$discount,
							'minimum_purchase'=>$minimum );	
		$this->discount_model->update_data_cart($id,$database);
		redirect('torioadmin/discount_cart');
	}
	
	function change_status_discount($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$database = array(	'status'=>$active );		
		$this->discount_model->update_data_cart($id,$database);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>