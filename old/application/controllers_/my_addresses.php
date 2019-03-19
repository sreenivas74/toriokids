<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class My_addresses extends CI_Controller{
	function My_addresses()
	{
		parent::__construct();	
		if($this->session->userdata('user_logged_in')==false)redirect("login");	
		$this->load->model('user_model');
		$this->load->model('jne_model');	
		$this->data['page_title']="My Addresses";				
	}
	
	function index()
	{	
		$user_id=$this->session->userdata('user_id');
		$address=$this->user_model->get_address_by_user($user_id);
		$this->data['account']=$this->user_model->user_detail($user_id);
		$this->data['address']=$this->user_model->get_address_by_user($user_id);
		$this->data['content'] = 'content/my_account/my_addresses';
		$this->load->view('common/body', $this->data);	
	}
	
	function do_set_default($addr_id)
	{	
		$user_id=$this->session->userdata('user_id');
		$user_id2=find('user_id', $addr_id, 'user_address_tb');
		if($user_id!=$user_id2)redirect('not_found');
		$this->user_model->set_as_default_address($addr_id,$user_id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function load_city($id)
	{	
		$this->data['city']=$this->jne_model->get_city($id);
		$this->load->view('content/my_account/my_addresses_city_list',$this->data);
	}
	
	function add()
	{
		$user_id=$this->session->userdata('user_id');
		$this->data['province']=$this->jne_model->get_jne_province_data();
		$this->data['city']=$this->jne_model->get_jne_city_data();
		$this->data['account']=$this->user_model->user_detail($user_id);
		$this->data['content'] = 'content/my_account/my_addresses_add';
		$this->load->view('common/body',$this->data);
	}
	
	function do_add()
	{
		if(!$_POST)redirect('not_found');
		$user_id = $this->session->userdata('user_id');
		$recipient = $this->input->post('recipient');
		$shipping = $this->input->post('shipping');
		$zipcode = $this->input->post('zipcode');
		$city = $this->input->post('select_city');
		$province = $this->input->post('select_province');
		$phone = $this->input->post('phone');
		//$mobile = $this->input->post('mobile');
		$mobile='';
		$this->user_model->insert_address($recipient,$shipping,$phone,$province,$zipcode,$user_id,$mobile, $city);
		$_SESSION['flag']=1;
		redirect('my_addresses');
	}
	
	function edit($id)
	{
		$user_id=$this->session->userdata('user_id');
		$temp = $this->user_model->get_address($id);
		if($temp['user_id']==$user_id){
			$this->data['province']=$this->jne_model->get_jne_province_data();
			$this->data['city']=$this->jne_model->get_jne_city_data();
			$this->data['account']=$this->user_model->user_detail($user_id);
			$this->data['address']=$temp;
			$this->data['content'] = 'content/my_account/my_addresses_edit';
			$this->load->view('common/body',$this->data);
		}else redirect('not_found');
	}
	
	function do_edit($id)
	{
		$user_id = $this->session->userdata('user_id');
		$user_id2=find('user_id', $id, 'user_address_tb');
		if($user_id==$user_id2){
			$recipient = $this->input->post('recipient');
			$shipping = $this->input->post('shipping');
			$zipcode = $this->input->post('zipcode');
			$city = $this->input->post('select_city');
			$province = $this->input->post('select_province');
			$phone = $this->input->post('phone');
			//$mobile = $this->input->post('mobile');
			$mobile='';
			$this->user_model->edit_address($id,$recipient,$shipping,$phone,$province,$zipcode,$user_id,$mobile, $city);
			$_SESSION['flag']=1;
			redirect('my_addresses');
		}else redirect('not_found');
	}
	
	function delete_address($id)
	{	
		$user_id = $this->session->userdata('user_id');
		$user_id2=find('user_id', $id, 'user_address_tb');
		if($user_id==$user_id2){
			$this->user_model->delete_address($id);
			redirect('my_addresses');
		}else redirect('not_found');
	}
}
?>