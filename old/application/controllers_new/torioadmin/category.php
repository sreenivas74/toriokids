<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Category extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('category_model');	
	}
	
	function index()
	{
		$this->data['category']=$this->category_model->get_category_list();
		$this->data['content']='admin/category/category_list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	//category
	function add()
	{	
		$this->data['content']='admin/category/add_category';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add()
	{	
		$name = $this->input->post('name');
		$precedence = last_precedence('category_tb') + 1;
		
		$image='';	
		$config['upload_path'] = 'userdata/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['encrypt_name'] = TRUE;		
		$this->load->library('upload', $config);
		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$source             = "userdata/".$data['file_name'] ;
			$destination		= "userdata/category_banner";
			
			chmod($source, 0777) ;
			$this->load->library('image_lib') ;
			$sourceSize = getSizeImage($source);
			$sourceRatio = $sourceSize['height']/$sourceSize['width'];
			
			
			$img['image_library'] = 'GD2';
			$img['maintain_ratio']= true;
				
			//// Making THUMBNAIL ///////
				
			//$img['width']  = 700;
			$img['height'] = 240;
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
		$database = array(	'name'=>$name, 
							'banner_image'=>$image,
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->category_model->insert_data('category_tb',$database);
		$id = mysql_insert_id();
		$alias = make_alias($name)."_".$id;
		$data = array('alias'=>$alias);
		$this->category_model->update_data($id, 'category_tb', $data);
		redirect('torioadmin/category');
	}
	
	function edit($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->category_model->get_selected_category_data($id);
		$this->data['content']='admin/category/edit_category';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit($id)
	{
		$name = $this->input->post('name');
		$alias = make_alias($name)."_".$id;
		$old_image = $this->category_model->get_selected_category_data($id);
		$image = $old_image['banner_image'];
		$config['upload_path'] = 'userdata/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{		
		
			$data = $this->upload->data(); 			
			$source             = "userdata/".$data['file_name'] ;
			$destination		= "userdata/category_banner/" ;
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
				
			//$img['width']  = 700;
			$img['height'] = 240;
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
		$database = array(	'name'=>$name,
							'alias'=>$alias, 
							'banner_image'=>$image);		
		$this->category_model->update_data($id, 'category_tb',$database);
		redirect('torioadmin/category');
	}
	
	function delete_category_picture($id){		
		$data=$this->category_model->get_selected_category_data($id);
		
		$old_picture=$data['banner_image'];				
		
		if($old_picture!=""){
			$old_src="userdata/category_banner/".$old_picture ;
			if(file_exists($old_src))unlink($old_src);
		}
		
		$this->category_model->delete_category_picture($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_active_category($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$database = array('active'=>$active);		
		$this->category_model->update_data($id, 'category_tb',$database);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_category($id){
	
		$this->category_model->up_precedence_category($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_category($id){
	
		$this->category_model->down_precedence_category($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	//sub category	
	function view_sub_category_list($category_id)
	{
		$this->data['category']=$this->category_model->get_sub_category_list($category_id);
		$this->data['content']='admin/category/sub_category_list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function add_sub($category_id)
	{	
		$this->data['category_id'] = $category_id;
		$this->data['content']='admin/category/add_sub_category';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add_sub($category_id)
	{	
		$name = $this->input->post('name');
		$cek = last_precedence_flexible('precedence', 'sub_category_tb', 'category_id', $category_id);
		if($cek==NULL)
		{
			$precedence = 1;
		} else 
		{
			$precedence = $cek + 1;	
		}
		$image='';	
			$config['upload_path'] = 'userdata/';
			$config['allowed_types'] = 'jpg|gif|png';
			$config['encrypt_name'] = TRUE;		
			$this->load->library('upload', $config);
			if($this->upload->do_upload('image'))
			{				
				$data = $this->upload->data(); 			
				$source             = "userdata/".$data['file_name'] ;
				$destination		= "userdata/sub_category_banner";
				
				chmod($source, 0777) ;
				$this->load->library('image_lib') ;
				$sourceSize = getSizeImage($source);
				$sourceRatio = $sourceSize['height']/$sourceSize['width'];
				
				
				$img['image_library'] = 'GD2';
				$img['maintain_ratio']= true;
					
				//// Making THUMBNAIL ///////
					
				//$img['width']  = 700;
				$img['height'] = 240;
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
		$database = array(	'category_id'=>$category_id,
							'name'=>$name, 
							'banner_image'=>$image,
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->category_model->insert_data('sub_category_tb',$database);
		$id = mysql_insert_id();
		$alias = make_alias($name)."_".$id;
		$data = array('alias'=>$alias);
		$this->category_model->update_data($id, 'sub_category_tb', $data);
		redirect('torioadmin/category/view_sub_category_list'.'/'.$category_id);
	}
	
	function edit_sub($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->category_model->get_selected_sub_category_data($id);
		$this->data['content']='admin/category/edit_sub_category';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit_sub($id)
	{
		$name = $this->input->post('name');
		$alias = make_alias($name)."_".$id;
		$old_image = $this->category_model->get_selected_sub_category_data($id);
		$image = $old_image['banner_image'];
		$config['upload_path'] = 'userdata/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{		
		
			$data = $this->upload->data(); 			
			$source             = "userdata/".$data['file_name'] ;
			$destination		= "userdata/sub_category_banner/" ;
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
				
			//$img['width']  = 700;
			$img['height'] = 240;
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
		$database = array(	'name'=>$name,
							'alias'=>$alias, 
							'banner_image'=>$image);		
		$this->category_model->update_data($id, 'sub_category_tb',$database);
		redirect('torioadmin/category/view_sub_category_list'.'/'.$old_image['category_id']);
	}
	
	function delete_sub_category_picture($id){		
		$data=$this->category_model->get_selected_sub_category_data($id);
		
		$old_image=$data['banner_image'];				
		
		if($old_image!=""){
			$old_src="userdata/sub_category_banner/".$old_image ;
			if(file_exists($old_src))unlink($old_src);
		}
		
		$this->category_model->delete_sub_category_picture($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_active_sub_category($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$database = array('active'=>$active);		
		$this->category_model->update_data($id, 'sub_category_tb',$database);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	function up_precedence_sub_category($id, $category_id)
	{
		$this->category_model->up_precedence_sub_category($id, $category_id);
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_sub_category($id, $category_id)
	{
		$this->category_model->down_precedence_sub_category($id, $category_id);
		redirect ($_SERVER['HTTP_REFERER']);
	}	
}
?>