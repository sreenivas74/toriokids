<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Contact_us extends CI_Controller{
	function __construct(){
		parent::__construct();	
		$this->load->model('content_page_model');
	}
	
	function index(){
		$alias="contact-us-2";
		$this->data['alias']=$alias;
		$this->data['detail']=$this->content_page_model->get_selected_content_page_data2($alias);
		if(!$this->data['detail'])redirect('not_found');
		$this->data['page_title']=$this->data['detail']['name'];
		$this->data['content'] = 'content/footer/contact_us';
		$this->load->view('common/body', $this->data);
	}
	
	function process_email(){		
		if(!$_POST)redirect('not_found');
		$name=$this->input->post('name');
		$email=$this->input->post('email');
		$phone_number=$this->input->post('phone_number');
		$message=$this->input->post('message');
		$to = "cs@toriokids.com";
		$email_content = "
		Name : ".esc($name)."<br />
		Email Address : ".esc($email)."<br />
		Phone Number : ".esc($phone_number)."<br />
		Message : ".esc($message)."<br /><br />	
		";
		$this->load->library('email'); 	
		$this->email->from($email);
		$this->email->to($to);	
		$this->email->subject('Contact Us Inquiry');
		$this->email->message($email_content); 
		$this->email->send();			
		redirect('contact_us');		
	}
}
?>