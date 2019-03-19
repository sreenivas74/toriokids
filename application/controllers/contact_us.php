<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Contact_us extends CI_Controller{
	function __construct(){
		parent::__construct();	
		$this->load->model('content_page_model');
		$this->load->model('footer_menu_model');
		$this->load->model('contact_us_model');
		$this->data['footer'] = $this->footer_menu_model->get_active_footer_menu_list();
		$this->load->model('secondary_menu_model');
		$this->data['secondary'] = $this->secondary_menu_model->get_active_secondary_menu_list();
	}
	
	function index(){
		$this->data['detail'] = $this->contact_us_model->get_contact_us_list();
		$this->data['page_title']='Contact Us';
		$this->data['content'] = 'content/contact_us';
		$this->load->view('common/body', $this->data);
	}

	function send_email(){
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$name = $this->input->post('name');
		$message = $this->input->post('message');

		$message_send = $message;
        $this->load->library('email');
        $this->email->set_newline("\r\n");
        
        $this->email->from($email);
        $this->email->to('cs@toriokids.com'); 

        $this->email->subject('Torio - Contact Us');
        $this->email->message($message_send);    //>> masukin email_content nya

        $this->email->send();
        //$this->email->print_debugger();

        $this->session->set_flashdata('notif1', 'Email telah terkirim');
		redirect('contact_us');

	}
	
}