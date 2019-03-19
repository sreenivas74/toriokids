<?php if(!defined('BASEPATH')) exit('no direct script access allowed'); 
	class Sale extends CI_Controller {
		function __construct(){
			parent::__construct();
			$this->load->model('sale_model');
				if($this->session->userdata('admin_logged_in')==FALSE)
					redirect('torioadmin/login');		
		}
	
	function index(){
		redirect('torioadmin/sale/flash_sale');
	}
	
	function flash_sale(){
		$this->data['sale']=$this->sale_model->get_all_sale();
		$this->data['type']=$this->sale_model->get_sale_type();
		$this->data['content']='admin/flash_sale/list';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function add_flash_sale(){
		$this->data['content']='admin/flash_sale/add';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function do_add_flash_sale(){
		$name = $this->input->post('name');
		$percentage = $this->input->post('percentage');
		$start = $this->input->post('start');
		$start_time = str_replace('/','-',$start);
		$end = $this->input->post('end');
		$end_time = str_replace('/','-',$end);
		
		$start_time = date('Y-m-d H:i:s', strtotime($start));
		$end_time = date('Y-m-d H:i:s', strtotime($end));
		
		$this->sale_model->insert_flash_sale($name, $percentage, $start_time, $end_time);
		redirect('torioadmin/sale/flash_sale');
		
		/*$image_path = realpath(APPPATH . '../userdata/flash_sale_banner');
			
		$config['upload_path'] = $image_path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);
		$this->upload->overwrite = false;

		if(!$this->upload->do_upload('image'))
		{
			$err_upload = $this->upload->display_errors();
			$this->session->set_flashdata('notif2', $err_upload);
			redirect('torioadmin/sale/add_flash_sale');
		}
		else
		{
			#print_r($this->upload->data());
			$pic = $this->upload->data('file_name');
			
			$this->load->library('image_lib');
			$source = $image_path."/".$pic['file_name'];
			$sourceSize = getSizeImage($source);
			$sourceRatio = $sourceSize['height']/$sourceSize['width'];
			
			$img_cfg['image_library'] = 'gd2';
			$img_cfg['source_image'] = $image_path."/".$pic['file_name'];
			$img_cfg['maintain_ratio'] = false;
			$img_cfg['create_thumb'] = false;
			$img_cfg['new_image'] = $image_path."/resize";
			$img_cfg['width'] = 940;
			$img_cfg['height'] = 80;
			$img_cfg['quality'] = 100;
		
			$this->image_lib->initialize($img_cfg);
			$this->image_lib->resize();
			
			$this->sale_model->insert_flash_sale($name, $percentage, $start_time, $end_time, $pic);
			redirect('torioadmin/sale/flash_sale');

		}*/
	}
	
	function delete_flash_sale($id){
		if(!$_SERVER['HTTP_REFERER']) redirect('not_found');
		$this->sale_model->delete_item_by_flash_id($id);
		$this->sale_model->delete_flash_sale($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function flash_sale_item($id){
		$this->data['flash_sale_id'] = $id;
		$this->data['product'] = $this->sale_model->get_all_product();
		$this->data['item'] = $this->sale_model->get_item_by_flash_sale_id1($id);
		$this->data['content']='admin/flash_sale/item';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function add_item(){
		$flash_sale_id = $this->input->post('flash_sale_id');
		$id = $this->input->post('id');
		
		$this->sale_model->delete_item_by_flash_id($flash_sale_id);
		
		if($id) foreach($id as $list){
			$this->sale_model->insert_item($flash_sale_id, $list);
		}
		
		redirect('torioadmin/sale/flash_sale');
	}
	
	function edit_flash_sale($id){
		$this->data['detail']=$this->sale_model->get_flash_sale($id);
		$this->data['content']='admin/flash_sale/edit';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit_flash_sale(){
		$flash_sale_id = $this->input->post('flash_sale_id');
		$name = $this->input->post('name');
		$percentage = $this->input->post('percentage');
		$start = $this->input->post('start');
		$start_time = str_replace('/','-',$start);
		$end = $this->input->post('end');
		$end_time = str_replace('/','-',$end);
		
		$start_time = date('Y-m-d H:i:s', strtotime($start));
		$end_time = date('Y-m-d H:i:s', strtotime($end));
		
		//echo $start_time."<br>".$end_time;
		
		$this->sale_model->update_flash_sale($flash_sale_id, $name, $percentage, $start_time, $end_time);
		redirect('torioadmin/sale/flash_sale');
	}
	
	function change_sale_type($type){
		$check = $this->sale_model->get_sale_type();
		
		if($check){
			$this->sale_model->update_sale_type($type);
		}
		else
		{
			$this->sale_model->insert_sale_type($type);
		}
	}
	
	function edit_stock(){
		$this->data['sku'] = $this->sale_model->get_active_product_sku();
		$this->data['content']='admin/flash_sale/edit_stock';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function update_stock(){
		$id = $this->input->post('id');
		
		foreach($id as $list){
			$qty = $this->input->post('qty_'.$list);
			$this->sale_model->update_stock($list, $qty);
		}
		
		redirect('torioadmin/sale');
	}
}