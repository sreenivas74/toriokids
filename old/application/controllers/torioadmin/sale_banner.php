<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Sale_banner extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('banner_model');	
		$this->load->model('general_model');
	}
	
	function index()
	{
		redirect('torioadmin/sale_banner/view_banner_list');
	}
	
	function view_banner_list()
	{
		$this->data['detail']=$this->banner_model->get_sale_banner_list();
		$this->data['content']='admin/sale_banner/sale_banner_list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function add()
	{	
		$this->data['content']='admin/sale_banner/add_banner';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add()
	{	
		$name = $this->input->post('name');
		$link = $this->input->post('link');	
		$precedence = last_precedence('sale_banner_tb') + 1;
		
		$image='';	
		$config['upload_path'] = 'userdata/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['encrypt_name'] = TRUE;		
		$this->load->library('upload', $config);
		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$source             = "userdata/".$data['file_name'] ;
			$destination		= "userdata/sale_banner";
			chmod($source, 0777) ;
			$this->load->library('image_lib') ;
			$sourceSize = getSizeImage($source);
			$sourceRatio = $sourceSize['height']/$sourceSize['width'];			
			$img['image_library'] = 'GD2';
			$img['maintain_ratio']= true;				
			//// Making THUMBNAIL ///////		
					
			$img['width']  = 700;
			$img['height'] = $img['width'] * $sourceRatio;
			$img['quality']      = '100%';
			$img['source_image'] = $source ;
			$img['new_image']    = $destination;
			$this->image_lib->initialize($img);
			$this->image_lib->resize();
			$this->image_lib->clear() ;	
			
			unlink($source);
			$image=$data['file_name'];	
		
		}
		$active=0;
		$database = array('name'=>$name, 
							'link'=>$link,
							'image'=>$image,
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->banner_model->insert_data('sale_banner_tb',$database);
		redirect('torioadmin/sale_banner/view_banner_list');
	}
	
	function edit($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->banner_model->get_selected_sale_banner_data($id);
		$this->data['content']='admin/sale_banner/edit_banner';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit($id)
	{
		$name = $this->input->post('name');
		$link = $this->input->post('link');
		$old_image = $this->banner_model->get_selected_sale_banner_data($id);
		$image = $old_image['image'];
		$config['upload_path'] = 'userdata/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{				
			$data = $this->upload->data(); 			
			$source             = "userdata/".$data['file_name'] ;
			$destination		= "userdata/sale_banner";		
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
			$img['width']  = 700;
			$img['height'] = $img['width'] * $sourceRatio;
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
		$this->banner_model->update_data_sale_banner($id,$database);
		redirect('torioadmin/sale_banner/view_banner_list');
	}
	
	function delete_sale_banner_picture($id)
	{		
		$data=$this->banner_model->get_selected_sale_banner_data($id);
		
		$old_picture=$data['image'];				
		
		if($old_picture!=""){
			$old_src="userdata/sale_banner/".$old_picture ;
			if(file_exists($old_src))unlink($old_src);
		}
		
		$this->banner_model->delete_sale_banner_picture($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_active_sale_banner($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->banner_model->update_active_sale_banner($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_sale_banner($id){
	
		$this->banner_model->up_precedence_sale_banner($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_sale_banner($id){
	
		$this->banner_model->down_precedence_sale_banner($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}	
	
	function update_precedence(){
	
		$all_data=$this->input->post('table-1');
		
		$no=count($all_data);
			if($all_data)foreach($all_data as $list){
				$database=array('precedence'=>$no);
				$where =array('id'=>$list);
				$this->general_model->update_data('sale_banner_tb',$database,$where);	
				$no--;		
			}
	}
}

?>