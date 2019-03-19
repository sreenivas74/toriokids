<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Channel extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('channel_model');	
	}
	
	function index()
	{
		$this->data['channel']=$this->channel_model->get_channel_list();
		$this->data['content']='admin/channel/list';
		$this->load->view('common/admin/body',$this->data);
	}

	function add()
	{	
		$this->data['content']='admin/channel/add';
		$this->load->view('common/admin/body',$this->data);
	}

	function banner()
	{	
		$this->data['detail']=$this->channel_model->get_channel_banner();
		$this->data['content']='admin/channel/edit_banner';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add()
	{	
		$name = $this->input->post('name');
		$link = $this->input->post('link');
		$precedence = last_precedence('channel_tb') + 1;
		
		$image='';	
			$config['upload_path'] = 'userdata/e-channel';
			$config['allowed_types'] = 'jpg|gif|png|jpeg';
			$config['encrypt_name'] = TRUE;		
			$this->load->library('upload', $config);
			if($this->upload->do_upload('image'))
			{				
				$data = $this->upload->data(); 	
				$image=$data['file_name'];
				
			}
			$active=1;
		$database = array(	'name'=>$name,
							'image'=>$image,
							'link'=>$link,
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->channel_model->insert_data('channel_tb',$database);
		redirect('torioadmin/channel');
	}
	
	function edit($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->channel_model->get_selected_channel_data($id);
		$this->data['content']='admin/channel/edit';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit($id){
	
		$name = $this->input->post('name');
		$link = $this->input->post('link');
		$old_image = $this->channel_model->get_selected_channel_data($id);
		$image = $old_image['image'];
		$config['upload_path'] = 'userdata/e-channel';
		$config['allowed_types'] = 'jpg|gif|png|jpeg';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$destination		= "userdata/e-channel/" ;
			
			
			if ($image){
				if(file_exists($destination))unlink($destination."".$image);
			}
			
			$image=$data['file_name']; 
		}
		$database = array(	'name'=>$name,
							'link'=>$link,
							'image'=>$image );		
		$this->channel_model->update_data($id,$database);
		redirect('torioadmin/channel');
	}

	function do_edit_banner(){
	
		$title = $this->input->post('title');
		$old_image = $this->channel_model->get_channel_banner();
		$image = $old_image['image'];
		$config['upload_path'] = 'userdata/e-channel';
		$config['allowed_types'] = 'jpg|gif|png|jpeg';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$destination		= "userdata/e-channel/" ;
			
			
			if ($image){
				if(file_exists($destination))unlink($destination."".$image);
			}
			
			$image=$data['file_name']; 
		}
		$database = array(	'title'=>$title,
							'image'=>$image );		
		$this->channel_model->update_data_banner(1,$database);
		redirect('torioadmin/channel/banner');
	}
	
	function delete_channel_picture($id){		
		$data=$this->channel_model->get_selected_channel_data($id);
		
		$old_picture=$data['image'];				
		
		if($old_picture!=""){
			$old_src="userdata/e-channel/".$old_picture ;
			if(file_exists($old_src))unlink($old_src);
		}
		
		$this->channel_model->delete_channel_picture($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_active_channel($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->channel_model->update_active_channel($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_channel($id){
	
		$this->channel_model->up_precedence_channel($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_channel($id){
	
		$this->channel_model->down_precedence_channel($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
}
?>