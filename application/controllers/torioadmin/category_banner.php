<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Category_banner extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('banner_model');	
		$this->load->model('general_model');
	}
	
	function index()
	{
		redirect('category_banner/view_banner_list');
	}
	
	function view_banner_list()
	{
		$this->data['detail']=$this->banner_model->get_category_banner_list();
		$this->data['content']='admin/category_banner/list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function add()
	{	
		$this->data['content']='admin/category_banner/add_banner';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add($type)
	{	
		$name = $this->input->post('name');
		$link = $this->input->post('link');	
		$precedence = last_precedence('category_banner_tb') + 1;
		
		$image='';	
		$image_mobile='';

		$config['upload_path'] = 'userdata/category_banner';
		$config['allowed_types'] = 'jpg|gif|png|jpeg';
		$config['encrypt_name'] = TRUE;		
		$this->load->library('upload', $config);
		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$source             = "userdata/category_banner/".$data['file_name'] ;
			$destination		= "userdata/category_banner/large";		
			$destination2		= "userdata/category_banner/small";
			chmod($source, 0777) ;
			$this->load->library('image_lib') ;
			$sourceSize = getSizeImage($source);
			$sourceRatio = $sourceSize['height']/$sourceSize['width'];			
			$img['image_library'] = 'GD2';
			$img['maintain_ratio']= true;				
			//// Making THUMBNAIL ///////
			if($type==1){				
				$img['height']  = 400;
				//$img['height'] = $img['width'] * $sourceRatio;
				$img['quality']      = '100%';
				$img['source_image'] = $source ;
				$img['new_image']    = $destination;
				$this->image_lib->initialize($img);
				$this->image_lib->resize();
				$this->image_lib->clear() ;	
				
				//unlink($source);
				$image=$data['file_name'];	
			}else {				
				$img['height']  = 120;
				//img['height'] = $img['width'] * $sourceRatio;
				$img['quality']      = '100%';
				$img['source_image'] = $source ;
				$img['new_image']    = $destination2;
				$this->image_lib->initialize($img);
				$this->image_lib->resize();
				$this->image_lib->clear() ;	
				
				//unlink($source);
				$image=$data['file_name'];	
			}
		}


		$config2['upload_path'] = 'userdata/category_banner';
		$config2['allowed_types'] = 'jpg|gif|png|jpeg';
		$config2['encrypt_name'] = TRUE;		
		$this->load->library('upload', $config2);
		if($this->upload->do_upload('image_mobile'))
		{				
			$data = $this->upload->data(); 			
			$image_mobile=$data['file_name'];	
			
		}

		$active=1;
		$database = array(	'type'=>$type,
						 	'name'=>$name, 
							'link'=>$link,
							'image'=>$image,
							'image_mobile'=>$image_mobile,
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->banner_model->insert_data('category_banner_tb',$database);
		redirect('torioadmin/category_banner/view_banner_list/'.$type);
	}
	
	function edit($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->banner_model->get_selected_category_banner_data($id);
		$this->data['content']='admin/category_banner/edit_banner';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit($id)
	{
		$name = $this->input->post('name');
		$link = $this->input->post('link');
		$old_image = $this->banner_model->get_selected_category_banner_data($id);
		$image = $old_image['image'];
		$old = "userdata/category_banner/".$image;

		$config['upload_path'] = 'userdata/category_banner';
		$config['allowed_types'] = 'jpg|gif|png|jpeg';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			if(file_exists($old))unlink($old);

			$image=$data['file_name'];	
		}
		else{
			$image = $image;
		}

		$database = array(	'name'=>$name, 
							'image'=>$image,
							'link'=>$link );		
		$this->banner_model->update_category_banner($id,$database);
		redirect('torioadmin/category_banner/view_banner_list');
	}
	
	function delete_category_banner_picture($id)
	{		
		$data=$this->banner_model->get_selected_category_banner_data($id);
		
		$old_picture=$data['image'];				
		
		if($old_picture!=""){
			$old_src2="userdata/category_banner/".$old_picture ;
			if(file_exists($old_src2))unlink($old_src2);
		}
		
		$this->banner_model->delete_category_banner_picture($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_active_category_banner($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->banner_model->update_active_category_banner($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_category_banner($id, $type){
	
		$this->banner_model->up_precedence_category_banner($id, $type);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_category_banner($id, $type){
	
		$this->banner_model->down_precedence_category_banner($id, $type);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}	
	
	function update_precedence(){
	
		$all_data=$this->input->post('table-1');
		
		$no=count($all_data);
			if($all_data)foreach($all_data as $list){
				$database=array('precedence'=>$no);
				$where =array('id'=>$list);
				$this->general_model->update_data('category_banner_tb',$database,$where);	
				$no--;		
			}
	}
}

?>