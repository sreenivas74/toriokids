<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Advertisement extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('advertisement_model');	
	}
	
	function index()
	{
		$this->data['detail']=$this->advertisement_model->get_advertisement_list();
		$this->data['content']='admin/advertisement/list';
		$this->load->view('common/admin/body',$this->data);
	}
		
	function add()
	{	
		$this->data['content']='admin/advertisement/add';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add($type)
	{	
		$name = $this->input->post('name');
		$link = $this->input->post('link');	
		$precedence = last_precedence('advertisement_tb') + 1;
		
		$image='';	
		$config['upload_path'] = 'userdata/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['encrypt_name'] = TRUE;		
		$this->load->library('upload', $config);
		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$source             = "userdata/".$data['file_name'] ;
			$destination		= "userdata/advertisement/";	
			chmod($source, 0777) ;
			$this->load->library('image_lib') ;
			$sourceSize = getSizeImage($source);
			$sourceRatio = $sourceSize['height']/$sourceSize['width'];			
			$img['image_library'] = 'GD2';
			$img['maintain_ratio']= true;				
			//// Making THUMBNAIL ///////
				$img['height']  = 140;
				//img['height'] = $img['width'] * $sourceRatio;
				$img['quality']      = '100%';
				$img['source_image'] = $source ;
				$img['new_image']    = $destination;
				$this->image_lib->initialize($img);
				$this->image_lib->resize();
				$this->image_lib->clear() ;	
				
				unlink($source);
				$image=$data['file_name'];
		}
		$active=1;
		$database = array(
						 	'name'=>$name, 
							'link'=>$link,
							'image'=>$image,
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->advertisement_model->insert_data('advertisement_tb',$database);
		redirect('torioadmin/advertisement/');
	}
	
	function edit($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->advertisement_model->get_selected_advertisement_data($id);
		$this->data['content']='admin/advertisement/edit';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit($id)
	{
		$name = $this->input->post('name');
		$link = $this->input->post('link');
		$old_image = $this->advertisement_model->get_selected_advertisement_data($id);
		$image = $old_image['image'];
		$config['upload_path'] = 'userdata/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$source             = "userdata/".$data['file_name'] ;
			$destination		= "userdata/advertisement/";	
			chmod($source, 0777) ;
			$this->load->library('image_lib') ;
			$sourceSize = getSizeImage($source);
			$sourceRatio = $sourceSize['height']/$sourceSize['width'];
			
			if ($image){
			//DELETE OLD FILES
			/*unlink($destination."".$picture);*/
				if($old_image['type']==1){		
					if(file_exists($destination))unlink($destination."".$image);
				}
			
			}
			$img['image_library'] = 'GD2';
			$img['maintain_ratio']= true;
				
			//// Making THUMBNAIL ///////
						
				$img['height']  = 140;
				//$img['height'] = $img['width'] * $sourceRatio;
				$img['quality']      = '100%';
				$img['source_image'] = $source ;
				$img['new_image']    = $destination;
				$this->image_lib->initialize($img);
				$this->image_lib->resize();
				$this->image_lib->clear() ;	
				
				unlink($source);
				$image=$data['file_name'];	
			
		}
		$database = array(	'name'=>$name, 
							'image'=>$image,
							'link'=>$link );		
		$this->advertisement_model->update_data($id,$database);
		redirect('torioadmin/advertisement');
	}
	
	function delete_advertisement_picture($id)
	{		
		$data=$this->advertisement_model->get_selected_advertisement_data($id);
		
		$old_picture=$data['image'];				
		
		if($old_picture!=""){
			$old_src="userdata/advertisement/".$old_picture ;
			if(file_exists($old_src))unlink($old_src);
		}
		
		$this->advertisement_model->delete_advertisement_picture($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_active_advertisement($id,$active)
	{
		
		if($active == 0) $active = 1; else $active = 0;
		$database = array('active'=>$active);		
		$this->advertisement_model->update_data($id,$database);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>