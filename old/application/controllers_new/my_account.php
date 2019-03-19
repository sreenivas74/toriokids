<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class My_account extends CI_Controller{
	function My_account()
	{
		parent::__construct();
		if($this->session->userdata('user_logged_in')==false)redirect("login");	
		$this->load->model('user_model');	
		$this->load->model('jne_model');	
		$this->data['page_title']="My Account";
	}
	
	function index()
	{		
		redirect('my_account/dashboard');
	}
	
	function dashboard()
	{
		$user_id=$this->session->userdata('user_id');
		$profile= $this->user_model->user_detail($user_id);
		$this->data['change_profile']=0;
		$this->data['account']=$this->user_model->user_detail($user_id);
		$this->data['shipping']=$this->user_model->get_default_address($user_id);	
		$this->data['order_user']=$this->user_model->get_order_by_user2($user_id);		
		$this->data['content'] = 'content/my_account/dashboard';
		$this->load->view('common/body', $this->data);	
	}
	
	function view_profile()
	{	
		$user_id=$this->session->userdata('user_id');
		$profile= $this->user_model->user_detail($user_id);
		$this->data['account']=$this->user_model->user_detail($user_id);			
		$this->data['content'] = 'content/my_account/my_profile';
		$this->load->view('common/body', $this->data);	
	}
	
	function edit_profile()
	{	
		$id=$this->session->userdata('user_id');
		$this->data['province']=$this->jne_model->get_jne_province_data();
		$this->data['city']=$this->jne_model->get_jne_city_data();
		$this->data['account']=$this->user_model->user_detail($id);
		$this->data['page_title']="Edit Profile";
		$this->data['content'] = 'content/my_account/edit_profile';
		$this->load->view('common/body', $this->data);			
	}
	
	function do_edit()
	{
		if(!$_POST)redirect('not_found');
		$user_id=$this->session->userdata('user_id');
		$fullname=$this->input->post('fullname');
		$dob=$this->input->post('dob');
		$address=$this->input->post('address');
		$province=$this->input->post('select_province'); 
		$city=$this->input->post('select_city'); 
		$postcode=$this->input->post('postcode');
		$telephone=$this->input->post('telephone');
		$mobile=$this->input->post('mobile');
		$this->user_model->update_account($user_id,$fullname,date('Y-m-d',strtotime($dob)),$address,$province,$postcode,$telephone,$mobile, $city);
		
		
		$_SESSION['update_profile_msg']="Your profile has been successfully changed";
		
		//check if no default address create new default address, if exists update it
		$default_addr=is_exist_default_address($user_id);
	
		if($default_addr==0){
			$recipient = $this->session->userdata('name');
			$this->user_model->insert_address($recipient,$address,$telephone,$province,$postcode,$user_id,$mobile,$city);
			$addr_id=mysql_insert_id();			
			$this->user_model->update_data('user_address_tb', array('default_address'=>1), array('id'=>$addr_id));
		}
		else{
			$addr_detail=$this->user_model->get_address($default_addr);
			$this->user_model->edit_address($default_addr,$addr_detail['recipient_name'],$address,$telephone,$province,$postcode,$user_id,$mobile,$city);
		}
		
		
		redirect ('my_account/view_profile');
	}	
}
?>