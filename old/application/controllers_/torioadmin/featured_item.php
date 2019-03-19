<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Featured_item extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('featured_item_model');	
	}
	
	function index()
	{
		$this->data['featured_item']=$this->featured_item_model->get_featured_item_list();
		$this->data['content']='admin/featured_item/list';
		$this->load->view('common/admin/body',$this->data);
	}

	function add()
	{	
		$this->data['content']='admin/featured_item/add';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add()
	{	
		$title = $this->input->post('title');
		$link = $this->input->post('link');
		$description = $this->input->post('description');
		$precedence = last_precedence('featured_item_tb') + 1;
		
		$image='';	
			$config['upload_path'] = 'userdata/';
			$config['allowed_types'] = 'jpg|gif|png';
			$config['encrypt_name'] = TRUE;		
			$this->load->library('upload', $config);
			if($this->upload->do_upload('image'))
			{				
				$data = $this->upload->data(); 			
				$source             = "userdata/".$data['file_name'] ;
				$destination		= "userdata/featured";
				
				chmod($source, 0777) ;
				$this->load->library('image_lib') ;
				$sourceSize = getSizeImage($source);
				$sourceRatio = $sourceSize['height']/$sourceSize['width'];
				
				
				$img['image_library'] = 'GD2';
				$img['maintain_ratio']= true;
					
				//// Making THUMBNAIL ///////	
				$img['width']  = 300;
				$img['height'] = $img['width'] * $sourceRatio;
				$img['maintain_ratio'] = true;
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
		$database = array(	'title'=>$title,
							'link'=>$link,
							'image'=>$image,
							'description'=>$description,
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->featured_item_model->insert_data('featured_item_tb',$database);
		redirect('torioadmin/featured_item');
	}
	
	function edit($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->featured_item_model->get_selected_featured_item_data($id);
		$this->data['content']='admin/featured_item/edit';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit($id){
	
		$title = $this->input->post('title');
		$link = $this->input->post('link');
		$description = $this->input->post('description');
		$old_image = $this->featured_item_model->get_selected_featured_item_data($id);
		$image = $old_image['image'];
		$config['upload_path'] = 'userdata/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$source             = "userdata/".$data['file_name'] ;
			$destination		= "userdata/featured/" ;
			chmod($source, 0777) ;
			$this->load->library('image_lib') ;
			$sourceSize = getSizeImage($source);
			$sourceRatio = $sourceSize['height']/$sourceSize['width'];
			
			if ($image){
			//DELETE OLD FILES
			/*unlink($destination."".$picture);*/
			if(file_exists($destination))unlink($destination."".$image);
			}
			$img['image_library'] = 'GD2';
			$img['maintain_ratio']= true;
				
			//// Making THUMBNAIL ///////	
			$img['width']  = 300;
			$img['height'] = $img['width'] * $sourceRatio;
			$img['maintain_ratio'] = true;
			$img['quality']      = '100%';
			$img['source_image'] = $source ;
			$img['new_image']    = $destination;
			$this->image_lib->initialize($img);
			$this->image_lib->resize();
			$this->image_lib->clear() ;	
			
			unlink($source);
			$image=$data['file_name']; 
		}
		$database = array(	'title'=>$title,
							'link'=>$link,
							'description'=>$description,
							'image'=>$image );		
		$this->featured_item_model->update_data($id,$database);
		redirect('torioadmin/featured_item');
	}
	
	function delete_featured_item_picture($id){		
		$data=$this->featured_item_model->get_selected_featured_item_data($id);
		
		$old_picture=$data['image'];				
		
		if($old_picture!=""){
			$old_src="userdata/featured/".$old_picture ;
			if(file_exists($old_src))unlink($old_src);
		}
		
		$this->featured_item_model->delete_featured_item_picture($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_active_featured_item($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->featured_item_model->update_active_featured_item($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_featured_item($id){
	
		$this->featured_item_model->up_precedence_featured_item($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_featured_item($id){
	
		$this->featured_item_model->down_precedence_featured_item($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
}
?>