<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Discount extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('discount_model');	
	}
	
	function index()
	{
		$this->data['detail']=$this->discount_model->get_list();
		$this->data['content']='admin/discount/list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function add()
	{	
		$this->data['content']='admin/discount/add';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add()
	{	
		$date_start = $this->input->post('date_start');	
		$date_end = $this->input->post('date_end');	
		$name = $this->input->post('name');
		$percentage = $this->input->post('percentage');
		
		$database = array(	'date_start'=>$date_start,
						 	'date_end'=>$date_end, 
							'name'=>$name,
							'percentage'=>$percentage );		
		$this->discount_model->insert_data('all_discount_tb',$database);
		redirect('torioadmin/discount');
	}
	
	function edit($id)
	{
		$this->data['detail']=$this->discount_model->get_selected_data($id);
		$this->data['content']='admin/discount/edit';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit()
	{
		$id = $this->input->post('disc_id');	
		$date_start = $this->input->post('date_start');	
		$date_end = $this->input->post('date_end');	
		$name = $this->input->post('name');
		$percentage = $this->input->post('percentage');
		
		$database = array(	'date_start'=>$date_start,
						 	'date_end'=>$date_end, 
							'name'=>$name,
							'percentage'=>$percentage );	
		$this->discount_model->update_data($id,$database);
		redirect('torioadmin/discount');
	}
	
	function change_status_discount($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$database = array(	'status'=>$active );		
		$this->discount_model->update_data($id,$database);
		$this->discount_model->update_status_discount($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>