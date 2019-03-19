<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Newsletter extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('newsletter_model');
		$this->load->model('footer_menu_model');
		$this->data['footer'] = $this->footer_menu_model->get_active_footer_menu_list();
		$this->load->model('secondary_menu_model');
		$this->data['secondary'] = $this->secondary_menu_model->get_active_secondary_menu_list();
	}
	
	function index()
	{
		redirect('home');	
	}
	
	function process()
	{
		if(!$_POST)redirect('not_found');
		$email=$this->input->post('email');

		$temp=$this->newsletter_model->check_email_newsletter2($email);	

		if($email==""){
			$this->session->set_flashdata('notif', 'Email harus di isi');
			redirect('shopping_cart/checkout_finish');
		}
		else if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
			$this->session->set_flashdata('notif', 'Format email anda salah');
			redirect('shopping_cart/checkout_finish');
		}
		else{
			if($temp){
				$this->session->set_flashdata('notif', 'Email sudah terdaftar di Newsletter');
				redirect('shopping_cart/checkout_finish');
			}
			else{

				$code=md5(rand(0,100).$email.date('Y-m-d H:i:s'));
				$this->newsletter_model->create_newsletter($email,$code);
				$id=mysql_insert_id();
				
				$this->data['detail']=$email;
				$this->data['code']=$code;
				$this->data['user_id']=$id;
					
				$this->data['verify_link']=site_url('newsletter/activation').'/'.$code.'/'.$id;
				$this->data['cancel_link']=site_url('newsletter/cancel').'/'.$code.'/'.$id;
				$isi=$this->load->view('content/email_template/subscribe_newsletter',$this->data,TRUE);
				
				$this->load->library('email'); 	
				$this->email->from('noreply@toriokids.com');
				$this->email->to($email); 
				
				$this->email->subject('Newsletter Activation');

				$this->email->message($isi); 

				$this->email->send();		

				redirect('newsletter/success');
			}
		}
	}
	
	function process2()
	{
		if(!$_POST)redirect('not_found');
		$email=$this->security->xss_clean($this->input->post('email'));
		$temp=$this->newsletter_model->check_email_newsletter2($email);	

		if($email==""){
			$this->session->set_flashdata('notif', 'Email harus di isi');
			redirect('shopping_cart/checkout_finish');
		}
		else if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
			$this->session->set_flashdata('notif', 'Format email anda salah');
			redirect('shopping_cart/checkout_finish');
		}
		else if($temp){
			$this->session->set_flashdata('notif', 'Email sudah terdaftar di Newsletter');
			redirect('shopping_cart/checkout_finish');
		}
		else{
			$code=md5(rand(0,100).$email.date('Y-m-d H:i:s'));
			$this->newsletter_model->create_newsletter($email,$code);
			$id=mysql_insert_id();
			
			$this->data['detail']=$email;
			$this->data['code']=$code;
			$this->data['user_id']=$id;
				
			$this->data['verify_link']=site_url('newsletter/activation').'/'.$code.'/'.$id;
			$this->data['cancel_link']=site_url('newsletter/cancel').'/'.$code.'/'.$id;
			$isi=$this->load->view('content/email_template/subscribe_newsletter',$this->data,TRUE);
			
			$this->load->library('email'); 	
			$this->email->from('noreply@toriokids.com');
			$this->email->to($email); 
			
			$this->email->subject('Newsletter Activation');

			$this->email->message($isi); 

			$this->email->send();		
			
			redirect('newsletter/success');
		}
	}
	
	function check_email()
	{		
		$email=$this->input->post('fieldValue');	
		$fieldId=$this->input->post('fieldId');
			
		$temp=$this->newsletter_model->check_email_newsletter2($email);	
		
		if($temp)echo '["'.$fieldId.'",0]';
		else echo '["'.$fieldId.'",1]';
	}
		
	function check_email_newsletter_registered()
	{		
		$email=$this->input->post('news_letter_email');	
		
		$temp=$this->newsletter_model->check_email_newsletter2($email);	
		
		if($temp)
			echo "2";
		else echo "1";
	}	
	
	function activation()
	{
		$code=$this->uri->segment(3,0);
		$id=$this->uri->segment(4,0);
		
		$data=$this->newsletter_model->newsletter_detail($id);

		if($data['status']==1)$status=0;
		else{			 
			if(strcmp($data['code'],$code)==0 and $data['status']==0){
				$status=1;
				$this->newsletter_model->update_newsletter_status($id,$status);	
			}
			else
				$status=0;
		}
				
		if($status==1){
			redirect('newsletter/thanks');
		}
		else{
			redirect('newsletter/failed');
		}
	}
	
	function cancel($code,$id)
	{
		$user_data=$this->newsletter_model->newsletter_detail($id);
		
		if($user_data['status']==0){
			$this->newsletter_model->delete_newsletter($id);
			
			redirect('newsletter/failed');
		}
		else redirect('home');
	
	}
		
	
	function success()
	{
		$this->data['content']='content/newsletter/newsletter_request';
		$this->load->view('common/body',$this->data);
	}
	
	function failed()
	{	
		$this->data['content']='content/newsletter/newsletter_expired_link';
		$this->load->view('common/body',$this->data);
	}
	
	function thanks()
	{
		$this->data['content']='content/newsletter/newsletter_success';
		$this->load->view('common/body',$this->data);
	}
}