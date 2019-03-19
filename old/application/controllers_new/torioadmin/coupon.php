<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Coupon extends CI_Controller {
	function __construct(){
		parent::__construct();
		if($this->session->userdata('admin_logged_in')==FALSE)redirect('torioadmin/login');	
		$this->load->model('coupoun_model');
		$this->load->model('user_model');
	}
	
	function index()
	{
		$this->data['coupoun_list']=$this->coupoun_model->get_voucher();	
		$this->data['content']='admin/coupon/list';
		$this->load->view('common/admin/body', $this->data);
	} 
	function Individual()
	{
		$this->data['content']='admin/coupon/addindividu';
		$this->load->view('common/admin/body', $this->data);
	}    
	
	function addindividu()
	{
		$name=$this->input->post('name');
		$prefix=$this->input->post('code');
		$qty=$this->input->post('qty');
		$datestart = $this->input->post('date_start');
		$dateend=$this->input->post('date_end');
		$type_used=$this->input->post('type_used');
		$type=$this->input->post('type');
		$value=$this->input->post('value');
		$minsub=$this->input->post('min');
		$maxsub=$this->input->post('max');
		
		$image='';	
		$config['upload_path'] = 'userdata/';
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['encrypt_name'] = TRUE;		
		$this->load->library('upload', $config);
		if($this->upload->do_upload('image')){				
			$data = $this->upload->data(); 			
			$source             = "userdata/".$data['file_name'] ;
			$destination		= "userdata/voucher/";
			chmod($source, 0777) ;
			$this->load->library('image_lib') ;
			$sourceSize = getSizeImage($source);
			
			$img['image_library'] = 'GD2';
			$img['maintain_ratio']= false;
				
			//// Making THUMBNAIL ///////
				
			$img['width']   = $sourceSize['width'] ;
			$img['height'] = $sourceSize['height'];
			$img['quality']      = '100%';
			$img['source_image'] = $source ;
			$img['new_image']    = $destination;
			$this->image_lib->initialize($img);
			$this->image_lib->resize();
			$this->image_lib->clear();	
			
			unlink($source);
			$image=$data['file_name'];
		}
			
		$this->coupoun_model->add($name,$image,$prefix, $qty, $datestart, $dateend,$type_used, $type, $value, $minsub, $maxsub);
		redirect('torioadmin/coupon');
	}
	
	function doeditindividu($id)
	{
	
		$data=$this->coupoun_model->coupoun_detail($id);
		$name=$this->input->post('name');
		$prefix=$this->input->post('code');
		$qty=$this->input->post('qty');
		$datestart = $this->input->post('date_start');
		$dateend=$this->input->post('date_end');
		$type_used=$this->input->post('type_used');
		$type=$this->input->post('type');
		$value=$this->input->post('value');
		$minsub=$this->input->post('min');
		$maxsub=$this->input->post('max');
		$image=$data['image'];	
		$config['upload_path'] = 'userdata/';
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['encrypt_name'] = TRUE;		
		$this->load->library('upload', $config);
			if($this->upload->do_upload('image')){				
				$data = $this->upload->data(); 	
				$unlink		= "userdata/voucher/".$image;
				unlink($unlink);	
				$source             = "userdata/".$data['file_name'] ;
				$destination		= "userdata/voucher/";
				chmod($source, 0777) ;
				$this->load->library('image_lib') ;
				$sourceSize = getSizeImage($source);
				
				$img['image_library'] = 'GD2';
				$img['maintain_ratio']= false;
					
				//// Making THUMBNAIL ///////
					
				$img['width']   = $sourceSize['width'] ;
				$img['height'] = $sourceSize['height'];
				$img['quality']      = '100%';
				$img['source_image'] = $source ;
				$img['new_image']    = $destination;
				$this->image_lib->initialize($img);
				$this->image_lib->resize();
				$this->image_lib->clear();	
				
				unlink($source);
				$image=$data['file_name'];
			}
		$this->coupoun_model->edit($id,$name,$image,$prefix, $qty, $datestart, $dateend,$type_used, $type, $value, $minsub, $maxsub);
		redirect('torioadmin/coupon');
	}
	function edit($id)
	{
		$this->data['edit_list']=$this->coupoun_model->coupoun_detail($id);	
		$this->data['content']='admin/coupon/editindividu';
		$this->load->view('common/admin/body', $this->data);
	} 
	
	
	function dodelete($id){
		$this->coupoun_model->delete($id);
			redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function dodeleteuser($id){
		$this->coupoun_model->deleteuser($id);
			redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function detailhistory($id){
		$this->data['history_list']=$this->coupoun_model->coupoun_history($id);	
		$this->data['content']='admin/coupon/detail';
		$this->load->view('common/admin/body', $this->data);
	} 
	
	function adduser($id)
	{	
		$this->data['user_list_voc']=$this->coupoun_model->get_user_voc($id);
		$this->data['da']=$id;
		$this->data['content']='admin/coupon/adduser';
		$this->data['user']=$this->user_model->user_list_act();
		$this->load->view('common/admin/body', $this->data);
	}
	
	function doadduser()
	{
		$coupon_id=$this->input->post('voc_id');
		$user_id=$this->input->post('userid');
		$status=0;
		$this->coupoun_model->adduser($coupon_id,$user_id,$status);
		redirect('torioadmin/coupon/adduser/'.$coupon_id);
	}
	  
}