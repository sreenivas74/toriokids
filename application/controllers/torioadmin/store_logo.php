<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Store_logo extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('store_logo_model');	
	}
	
	function index()
	{
		$this->data['store_logo']=$this->store_logo_model->get_store_logo_list();
		$this->data['content']='admin/store_logo/list';
		$this->load->view('common/admin/body',$this->data);
	}

	function add()
	{	
		$this->data['content']='admin/store_logo/add';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add()
	{	
		$name = $this->input->post('name');
		$link = $this->input->post('link');
		$precedence = last_precedence('store_logo_tb') + 1;
		
		$image='';	
			$config['upload_path'] = 'userdata/e-store_logo';
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
							'link'=>$link,
							'image'=>$image,
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->store_logo_model->insert_data('store_logo_tb',$database);
		redirect('torioadmin/store_logo');
	}
	
	function edit($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->store_logo_model->get_selected_store_logo_data($id);
		$this->data['content']='admin/store_logo/edit';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit($id){
	
		$name = $this->input->post('name');
		$link = $this->input->post('link');
		$old_image = $this->store_logo_model->get_selected_store_logo_data($id);
		$image = $old_image['image'];
		$config['upload_path'] = 'userdata/e-store_logo';
		$config['allowed_types'] = 'jpg|gif|png|jpeg';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$destination		= "userdata/e-store_logo/" ;
			
			
			if ($image){
				if(file_exists($destination))unlink($destination."".$image);
			}
			
			$image=$data['file_name']; 
		}
		$database = array(	'name'=>$name,
							'link'=>$link,
							'image'=>$image );		
		$this->store_logo_model->update_data($id,$database);
		redirect('torioadmin/store_logo');
	}
	
	function delete_store_logo_picture($id){		
		$data=$this->store_logo_model->get_selected_store_logo_data($id);
		
		$old_picture=$data['image'];				
		
		if($old_picture!=""){
			$old_src="userdata/e-store_logo/".$old_picture ;
			if(file_exists($old_src))unlink($old_src);
		}
		
		$this->store_logo_model->delete_store_logo_picture($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_active_store_logo($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->store_logo_model->update_active_store_logo($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_store_logo($id){
	
		$this->store_logo_model->up_precedence_store_logo($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_store_logo($id){
	
		$this->store_logo_model->down_precedence_store_logo($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
}
?>