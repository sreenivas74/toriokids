<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Change_email extends CI_Controller{
	function Change_email()
	{
		parent::__construct();
		if($this->session->userdata('user_logged_in')==false)redirect("login");
		$this->load->model('user_model');	
		$this->data['page_title']="Change Email";
	}
	
	function index()
	{
		$user_id=$this->session->userdata('user_id');
		$this->data['account']=$this->user_model->user_detail($user_id);
		$this->data['content'] = 'content/my_account/change_email';
		$this->load->view('common/body', $this->data);	
	}
	
	function check_user_password()
	{
		$user_id=$this->session->userdata('user_id');
		$user_detail=$this->user_model->user_detail($user_id);		
		$password=$this->input->post('fieldValue');	
		$fieldId=$this->input->post('fieldId');		
		$cek=strcmp($user_detail['password'],md5($password));	
		if($cek)echo '["'.$fieldId.'",0]';
		else echo '["'.$fieldId.'",1]';
	}
	
	function change_email_check()
	{
		$email=strtolower($this->input->post('email'));
		$user_id=$this->session->userdata('user_id');
		$check=$this->user_model->check_change_email_request($user_id);
		if($check)echo "0|You already request to change your email, <a href=\"#\">try resending your activation code</a>";
		else {
			$check2=$this->user_model->check_email($email);
			if($check2)
				echo "0|This email is already registered";
			else
				echo "1|";
		}
	}
	
	function check_email()
	{		
		$email=$this->input->post('fieldValue');	
		$fieldId=$this->input->post('fieldId');	
		$temp=$this->user_model->check_email($email);	
		if($temp)echo '["'.$fieldId.'",0]';
		else echo '["'.$fieldId.'",1]';
	}
	
	function do_edit()
	{
		if(!$_POST)redirect('not_found');
		$user_id=$this->session->userdata('user_id');
		$email=strtolower($this->input->post('email'));
		$new_email=strtolower($this->input->post('new_email'));
		$password=strtolower($this->input->post('password'));
		$user_detail=$this->user_model->user_detail($user_id);
		$cek=strcmp($user_detail['password'],md5($password));
		if($email!=$new_email){
			$_SESSION['notif']=1;
			$this->data['content']='content/my_account/change_email';
			$this->load->view('common/body',$this->data);
		}
		else if($cek!=0){
			$_SESSION['notif']=2;
			$this->data['content']='content/my_account/change_email';
			$this->load->view('common/body',$this->data);
		}
		else{			
			$code=md5($email.$user_id.date('y-m-d H:i:s'));
			$this->user_model->create_change_email_code($user_id,$code,$email);
			$this->data['code']=$code;
			$this->data['new_email']=$new_email;
			$this->data['email']=$user_detail['email'];
			$this->data['detail']=$user_detail;
			$this->data['new_email']=$email;
			$isi=$this->load->view('content/email_template/email_change_request',$this->data,TRUE);
			$this->load->library('email'); 	
			$this->email->from('noreply@toriokids.com');
			$this->email->to($email); 
			$this->email->subject('Reset Your Email');
			$this->email->message($isi); 
			$this->email->send();		
			$this->email->print_debugger();
			redirect('change_email/change_email_success');	
		}
	}

	function change_email_success()
	{
		$this->data['content']='content/my_account/change_email_request';
		$this->load->view('common/body',$this->data);
	}
	
	function activate_email()
	{
		$code=$this->uri->segment(3,0);
		$id=$this->uri->segment(4,0);
		
		$data=$this->user_model->user_detail($id);
		
		$cek2=$this->user_model->check_user_change_email_activation_code($id,$code);
		
		if($cek2){
			//delete code
			$this->user_model->delete_user_change_email($id,$code);
			
			//update new email
			$this->user_model->update_user_email($id,$cek2['new_email']);
			$status=1;
		}
		else
			$status=0;
		
		if($status==1){
			redirect('change_email/verification_done');
		}
		else{
			redirect('change_email/verification_failed');
		}	
	}
	
	function verification_done()
	{
		$user = array (
						   'user_logged_in' => false,
						   'user_id' => '',
						   'email' => ''
						);
		$this->session->unset_userdata($user);
		$this->data['content']='content/my_account/change_email_success';
		$this->load->view('common/body',$this->data);
	}
		
	function verification_failed()
	{
		$this->data['content']='content/my_account/change_email_failed';
		$this->load->view('common/body',$this->data);
	}	
}
?>