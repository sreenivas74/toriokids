<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Store extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('store_model');	
	}
	
	function index()
	{
		$this->data['store']=$this->store_model->get_store_list();
		$this->data['content']='admin/store/list';
		$this->load->view('common/admin/body',$this->data);
	}

	function add()
	{	
		$this->data['content']='admin/store/add';
		$this->load->view('common/admin/body',$this->data);
	}

	function banner()
	{	
		$this->data['detail']=$this->store_model->get_store_banner();
		$this->data['content']='admin/store/edit_banner';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add()
	{	
		$name = $this->input->post('name');
		$link = $this->input->post('link');
		$address = $this->input->post('address');
		$precedence = last_precedence('store_tb') + 1;
		
		$image='';	
			$config['upload_path'] = 'userdata/e-store';
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
							'address'=>$address,
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->store_model->insert_data('store_tb',$database);
		redirect('torioadmin/store');
	}
	
	function edit($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->store_model->get_selected_store_data($id);
		$this->data['content']='admin/store/edit';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit($id){
	
		$name = $this->input->post('name');
		$link = $this->input->post('link');
		$address = $this->input->post('address');
		$old_image = $this->store_model->get_selected_store_data($id);
		$image = $old_image['image'];
		$config['upload_path'] = 'userdata/e-store';
		$config['allowed_types'] = 'jpg|gif|png|jpeg';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$destination		= "userdata/e-store/" ;
			
			
			if ($image){
				if(file_exists($destination))unlink($destination."".$image);
			}
			
			$image=$data['file_name']; 
		}
		$database = array(	'name'=>$name,
							'link'=>$link,
							'address'=>$address,
							'image'=>$image );		
		$this->store_model->update_data($id,$database);
		redirect('torioadmin/store');
	}

	function do_edit_banner(){
	
		$title = $this->input->post('title');
		$old_image = $this->store_model->get_store_banner();
		$image = $old_image['image'];
		$config['upload_path'] = 'userdata/e-store';
		$config['allowed_types'] = 'jpg|gif|png|jpeg';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$destination		= "userdata/e-store/" ;
			
			
			if ($image){
				if(file_exists($destination))unlink($destination."".$image);
			}
			
			$image=$data['file_name']; 
		}
		$database = array(	'title'=>$title,
							'image'=>$image );		
		$this->store_model->update_data_banner(1,$database);
		redirect('torioadmin/store/banner');
	}
	
	function delete_store_picture($id){		
		$data=$this->store_model->get_selected_store_data($id);
		
		$old_picture=$data['image'];				
		
		if($old_picture!=""){
			$old_src="userdata/e-store/".$old_picture ;
			if(file_exists($old_src))unlink($old_src);
		}
		
		$this->store_model->delete_store_picture($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_active_store($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->store_model->update_active_store($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_store($id){
	
		$this->store_model->up_precedence_store($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_store($id){
	
		$this->store_model->down_precedence_store($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
}
?>