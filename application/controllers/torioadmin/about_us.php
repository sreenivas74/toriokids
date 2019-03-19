<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class About_us extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('about_us_model');	
	}
	
	function index()
	{
		$this->data['about_us']=$this->about_us_model->get_about_us_list();
		$this->data['content']='admin/about_us/list';
		$this->load->view('common/admin/body',$this->data);
	}

	function add()
	{	
		$this->data['content']='admin/about_us/add';
		$this->load->view('common/admin/body',$this->data);
	}

	function banner()
	{	
		$this->data['detail']=$this->about_us_model->get_about_us_banner();
		$this->data['content']='admin/about_us/edit_banner';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add()
	{	
		$title = $this->input->post('title');
		$position = $this->input->post('position');
		$description = $this->input->post('description');
		$precedence = last_precedence('about_us_tb') + 1;
		
		$image='';	
			$config['upload_path'] = 'userdata/about_us';
			$config['allowed_types'] = 'jpg|gif|png|jpeg';
			$config['encrypt_name'] = TRUE;		
			$this->load->library('upload', $config);
			if($this->upload->do_upload('image'))
			{				
				$data = $this->upload->data(); 	
				$image=$data['file_name'];
				
			}
			$active=1;
		$database = array(	'title'=>$title,
							'image'=>$image,
							'position'=>$position,
							'description'=>$description,
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->about_us_model->insert_data('about_us_tb',$database);
		redirect('torioadmin/about_us');
	}
	
	function edit($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->about_us_model->get_selected_about_us_data($id);
		$this->data['content']='admin/about_us/edit';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit($id){
	
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$position = $this->input->post('position');
		$old_image = $this->about_us_model->get_selected_about_us_data($id);
		$image = $old_image['image'];
		$config['upload_path'] = 'userdata/about_us';
		$config['allowed_types'] = 'jpg|gif|png|jpeg';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$destination		= "userdata/about_us/" ;
			
			
			if ($image){
				if(file_exists($destination))unlink($destination."".$image);
			}
			
			$image=$data['file_name']; 
		}
		$database = array(	'title'=>$title,
							'position'=>$position,
							'description'=>$description,
							'image'=>$image );		
		$this->about_us_model->update_data($id,$database);
		redirect('torioadmin/about_us');
	}

	function do_edit_banner(){
	
		$title = $this->input->post('title');
		$old_image = $this->about_us_model->get_about_us_banner();
		$image = $old_image['image'];
		$config['upload_path'] = 'userdata/about_us';
		$config['allowed_types'] = 'jpg|gif|png|jpeg';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$destination		= "userdata/about_us/" ;
			
			
			if ($image){
				if(file_exists($destination))unlink($destination."".$image);
			}
			
			$image=$data['file_name']; 
		}
		$database = array(	'title'=>$title,
							'image'=>$image );		
		$this->about_us_model->update_data_banner(1,$database);
		redirect('torioadmin/about_us/banner');
	}
	
	function delete_about_us_picture($id){		
		$data=$this->about_us_model->get_selected_about_us_data($id);
		
		$old_picture=$data['image'];				
		
		if($old_picture!=""){
			$old_src="userdata/about_us/".$old_picture ;
			if(file_exists($old_src))unlink($old_src);
		}
		
		$this->about_us_model->delete_about_us_picture($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_active_about_us($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->about_us_model->update_active_about_us($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_about_us($id){
	
		$this->about_us_model->up_precedence_about_us($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_about_us($id){
	
		$this->about_us_model->down_precedence_about_us($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}

	function point()
	{
		$this->data['about_us']=$this->about_us_model->get_about_us_point();
		$this->data['content']='admin/about_us/list_point';
		$this->load->view('common/admin/body',$this->data);
	}

	function add_point()
	{	
		$this->data['content']='admin/about_us/add_point';
		$this->load->view('common/admin/body',$this->data);
	}

	function do_add_point()
	{	
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$precedence = last_precedence('about_us_point_tb') + 1;
		
		$image='';	
			$config['upload_path'] = 'userdata/about_us';
			$config['allowed_types'] = 'jpg|gif|png|jpeg';
			$config['encrypt_name'] = TRUE;		
			$this->load->library('upload', $config);
			if($this->upload->do_upload('image'))
			{				
				$data = $this->upload->data(); 	
				$image=$data['file_name'];
				
			}
			$active=1;
		$database = array(	'title'=>$title,
							'image'=>$image,
							'description'=>$description,
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->about_us_model->insert_data('about_us_point_tb',$database);
		redirect('torioadmin/about_us/point');
	}

	function edit_point($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->about_us_model->get_selected_about_us_point($id);
		$this->data['content']='admin/about_us/edit_point';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit_point($id){
	
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$old_image = $this->about_us_model->get_selected_about_us_point($id);
		$image = $old_image['image'];
		$config['upload_path'] = 'userdata/about_us';
		$config['allowed_types'] = 'jpg|gif|png|jpeg';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$destination		= "userdata/about_us/" ;
			
			
			if ($image){
				if(file_exists($destination))unlink($destination."".$image);
			}
			
			$image=$data['file_name']; 
		}
		$database = array(	'title'=>$title,
							'description'=>$description,
							'image'=>$image );		
		$this->about_us_model->update_data_point($id,$database);
		redirect('torioadmin/about_us/point');
	}

	function delete_about_us_point_picture($id){		
		$data=$this->about_us_model->get_selected_about_us_point($id);
		
		$old_picture=$data['image'];				
		
		if($old_picture!=""){
			$old_src="userdata/about_us/".$old_picture ;
			if(file_exists($old_src))unlink($old_src);
		}
		
		$this->about_us_model->delete_about_us_point_picture($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_active_about_us_point($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->about_us_model->update_active_about_us_point($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_about_us_point($id){
	
		$this->about_us_model->up_precedence_about_us_point($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_about_us_point($id){
	
		$this->about_us_model->down_precedence_about_us_point($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}


}
?>