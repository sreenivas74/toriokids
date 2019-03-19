<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Small_footer_banner extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('banner_model');	
	}
	
	function index()
	{
		redirect('small_footer_banner/view_banner_list');
	}
	
	function view_banner_list()
	{
		$type = 3;
		$this->data['type']=$type;
		$this->data['detail']=$this->banner_model->get_banner_list($type);
		$this->data['content']='admin/small_footer_banner/list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function add()
	{	
		$type = 3;
		$this->data['type']=$type;
		$this->data['content']='admin/small_footer_banner/add';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add($type)
	{	
		$name = $this->input->post('name');
		$link = $this->input->post('link');	
		$precedence = last_precedence('home_banner_tb') + 1;
		
		$image='';	
		$config['upload_path'] = 'userdata/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['encrypt_name'] = TRUE;		
		$this->load->library('upload', $config);
		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$source             = "userdata/".$data['file_name'] ;
			$destination		= "userdata/small_footer_banner/";	
			chmod($source, 0777) ;
			$this->load->library('image_lib') ;
			$sourceSize = getSizeImage($source);
			$sourceRatio = $sourceSize['height']/$sourceSize['width'];			
			$img['image_library'] = 'GD2';
			$img['maintain_ratio']= true;				
			//// Making THUMBNAIL ///////
				$img['height']  = 120;
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
		$database = array(	'type'=>$type,
						 	'name'=>$name, 
							'link'=>$link,
							'image'=>$image,
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->banner_model->insert_data('home_banner_tb',$database);
		redirect('torioadmin/small_footer_banner/view_banner_list/'.$type);
	}
	
	function edit($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->banner_model->get_selected_home_banner_data($id);
		$this->data['type']=$this->data['detail']['type'];
		$this->data['content']='admin/small_footer_banner/edit';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit($id)
	{
		$name = $this->input->post('name');
		$link = $this->input->post('link');
		$old_image = $this->banner_model->get_selected_home_banner_data($id);
		$image = $old_image['image'];
		$config['upload_path'] = 'userdata/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$source             = "userdata/".$data['file_name'] ;
			$destination		= "userdata/small_footer_banner/";	
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
						
				$img['height']  = 120;
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
		$this->banner_model->update_data($id,$database);
		redirect('torioadmin/small_footer_banner/view_banner_list/'.$old_image['type']);
	}
	
	function delete_small_footer_banner_picture($id)
	{		
		$data=$this->banner_model->get_selected_home_banner_data($id);
		
		$old_picture=$data['image'];				
		
		if($old_picture!=""){
			$old_src="userdata/small_footer_banner/".$old_picture ;
			if(file_exists($old_src))unlink($old_src);
		}
		
		$this->banner_model->delete_home_banner_picture($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_active_small_footer_banner($id,$active)
	{
		
		if($active == 0) $active = 1; else $active = 0;
		$this->banner_model->update_active_home_banner($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>