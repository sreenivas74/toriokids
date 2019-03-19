<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Change_password extends CI_Controller{
	function Change_password()
	{
		parent::__construct();
		if($this->session->userdata('user_logged_in')==false)redirect("login");
		$this->load->model('user_model');	
		$this->data['page_title']="Change Password";
	}
	
	function index()
	{
		$this->data['password']='';
		$user_id=$this->session->userdata('user_id');
		$this->data['account']=$this->user_model->user_detail($user_id);
		$this->data['changepass']=$this->user_model->user_detail($user_id);
		$this->data['content'] = 'content/my_account/change_password';
		$this->load->view('common/body', $this->data);	
	}
	
	function check_password()
	{		
		$password=$this->input->post('fieldValue');	
		$fieldId=$this->input->post('fieldId');			
		$temp=$this->user_model->check_password($password);	
		if($temp)echo '["'.$fieldId.'",1]';
		else echo '["'.$fieldId.'",0]';
	}
	
	function check_password_registered()
	{		
		$password=$this->input->post('password');	
		$temp=$this->user_model->check_password($password);	
		if($temp and $temp['status']==0)
			echo $temp['status']."|Your email is registered but it's not verified yet, <a href=\"".site_url('registration/resend_code')."/".$temp['id']."\">try resending your activation code</a>";
		else echo "1|";
	}
	
	function do_edit()
	{
		
		$id=$this->session->userdata('user_id');
		$password=$this->input->post('password');	
		$a=md5($password);
		$data=$this->user_model->get_id($id);
		if ($a==$data['password']){
		$newpassword=$this->input->post('newpassword');
		$this->user_model->update_password($id,$newpassword);
		//$_SESSION['flag3']=1;
		$_SESSION['update_profile_msg']="Your password has been successfully changed.";
		
		}
		else
		{
			//$_SESSION['flag2']=1;
			
		$_SESSION['update_profile_msg']="Your password unsuccessfully changed,please input correct password";
		}
		redirect ('change_password');
		}
		

}
?>