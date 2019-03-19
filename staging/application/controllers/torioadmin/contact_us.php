<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Contact_us extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('contact_us_model');	
	}
	
	function index()
	{
		$this->data['detail']=$this->contact_us_model->get_contact_us_list();
		$this->data['content']='admin/contact_us/edit';
		$this->load->view('common/admin/body',$this->data);
	}

	function do_edit(){
	
		$title = $this->input->post('title');
		$address = $this->input->post('address');
		$fax = $this->input->post('fax');
		$email = $this->input->post('email');
		$operating = $this->input->post('operating');
		$phone = $this->input->post('phone');
		$us_representative = $this->input->post('us_representative');
		$email_representative = $this->input->post('email_representative');

		$old_image = $this->contact_us_model->get_contact_us_list();
		$image = $old_image['image'];
		$config['upload_path'] = 'userdata/contact_us';
		$config['allowed_types'] = 'jpg|gif|png|jpeg';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$destination		= "userdata/contact_us/" ;
			
			
			if ($image){
				if(file_exists($destination))unlink($destination."".$image);
			}
			
			$image=$data['file_name']; 
		}
		$database = array(	'title'=>$title,
							'address'=>$address,
							'fax'=>$fax,
							'email'=>$email,
							'operating_hours'=>$operating,
							'us_representative'=>$us_representative,
							'phone'=>$phone,
							'email_representative'=>$email_representative,
							'image'=>$image );		
		$this->contact_us_model->update_data(1,$database);
		redirect('torioadmin/contact_us');
	}


}
?>