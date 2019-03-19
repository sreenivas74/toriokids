<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Forgot_password extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->data['page_title']='Forget Password';
	}	
	
	function index()
	{		
		$this->data['content']='content/login_register/forget_password';
		$this->load->view('common/body',$this->data);
	}
	
	function check_email()
	{			
		$email=$this->input->post('email');
		$temp=$this->user_model->check_email($email);	
		if($temp)
			echo 1;
		else 
			echo 0;	
	}
	
	function process()
	{
		$email=$this->input->post('email');
		
		if($email=="")
			redirect('forgot_password');
		
		$data = $this->user_model->check_email($email);	
		
		if(!$data)redirect('forgot_password/process_error');
		if($data['status']!='0'){
		$user_id=$data['id'];				
		$name=$data['email'];
				
		$code=md5($email.$user_id.date('y-m-d H:i:s'));
		$this->user_model->create_forgot_pass_code($user_id,$code);
		
		$this->data['detail']=$data;
		$this->data['reset_password']=site_url('forgot_password/process_reset').'/'.$code.'/'.$user_id;
		
		$isi=$this->load->view('content/email_template/forgot_password',$this->data,TRUE);
		
		$this->load->library('email'); 	
		$this->email->from('noreply@toriokids.com');
		$this->email->to($email); 
		
		$this->email->subject('Forgot Password');
		
		$this->email->message($isi); 
		
		$this->email->send();		
		
		redirect('forgot_password/process_success');
		
		}else {
			$id=$data['id'];
			$code=find_2('activation_code','user_id',$id,'user_activation_tb');
			$cek2=$this->user_model->check_user_activation_code($id,$code);
				if($cek2){
					$status=1;
					$this->user_model->update_user_status($id,1);	
					$this->user_model->delete_user_activation($id,$code);
					
					//get random password after send email in registration page
						$i = str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890');
						$pass=substr($i,0,5);
						$new_pass=md5($pass);
						$this->user_model->update_registration_password($new_pass,$id);
				}
				
					$this->data['detail']=$data;
					$this->data['pass']=$pass;
					$isi=$this->load->view('content/email_template/activation_success',$this->data,TRUE);
					
					$this->load->library('email'); 	
					$this->email->from('noreply@toriokids.com');
					$this->email->to($data['email']); 
					
					$this->email->subject('User Activation');
					
					$this->email->message($isi); 
					
					$this->email->send();		
					
					redirect('registration/activation_success');
				
		}
	}
	
	function process_success(){
		$this->data['content']='content/login_register/forgetpass_success';
		$this->load->view('common/body',$this->data);
	}
	
	function process_error(){		
		$this->data['content']='content/login_register/forgetpass_error';
		$this->load->view('common/body',$this->data);
	}
	
	function process_reset(){
		
		$user_id = $this->uri->segment(4);
		$code = $this->uri->segment(3);
		
		$this->user_model->delete_forgotpass_activation($user_id,$code);
		$data=$this->user_model->user_detail($user_id);
		//get random password after send email in registration page
			$i = str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890');
			$pass=substr($i,0,5);
			$new_pass=md5($pass);
			$this->user_model->update_registration_password($new_pass,$user_id);
		
			$email=$data['email'];
			
			$this->data['detail']=$data;
			$this->data['pass']=$pass;
		
			$isi=$this->load->view('content/email_template/forgot_password_success',$this->data,TRUE);

			$this->load->library('email'); 	
			$this->email->from('noreply@toriokids.com');
			$this->email->to($email); 
			
			$this->email->subject('New Password');
			
			$this->email->message($isi); 
			
			$this->email->send();		
			
			redirect('forgot_password/forgot_success');
			
	}
	
	function forgot_success(){
		$this->data['content']='content/login_register/getnewpass_success';
		$this->load->view('common/body',$this->data);
	}
}
?>