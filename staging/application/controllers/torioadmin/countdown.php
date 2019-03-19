<?php if(!defined('BASEPATH')) exit('no direct script access allowed'); 
	class Countdown extends CI_Controller {
		function __construct(){
			parent::__construct();
			$this->load->model('countdown_model');
				if($this->session->userdata('admin_logged_in')==FALSE)
					redirect('torioadmin/login');		
		}
	
	function index(){
		$this->data['countdown']=$this->countdown_model->get_all_countdown();
		$this->data['content']='admin/countdown/list';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function add(){
		$this->data['content']='admin/countdown/add';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function do_add_countdown(){
		$name = $this->input->post('name');
		$start = $this->input->post('start');
		$start_time = str_replace('/','-',$start);
		$end = $this->input->post('end');
		$end_time = str_replace('/','-',$end);
		
		$start_time = date('Y-m-d H:i:s', strtotime($start));
		$end_time = date('Y-m-d H:i:s', strtotime($end));
		
		$image_path = realpath(APPPATH . '../userdata/countdown');
		
		$config['upload_path'] = $image_path;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);
		$this->upload->overwrite = false;

		if(!$this->upload->do_upload('image'))
		{
			$err_upload = $this->upload->display_errors();
			$this->session->set_flashdata('notif2', $err_upload);
			redirect('torioadmin/countdown/add');
		}
		else
		{
			$pic = $this->upload->data('file_name');
		}
		
		$config_mobile['upload_path'] = $image_path."/mobile";
		$config_mobile['allowed_types'] = 'gif|jpg|png|jpeg';
		$config_mobile['encrypt_name'] = TRUE;

		$this->upload->initialize($config_mobile);
		$this->upload->overwrite = false;
		
		if(!$this->upload->do_upload('image_mobile'))
		{
			$err_upload = $this->upload->display_errors();
			$this->session->set_flashdata('notif2', $err_upload);
			redirect('torioadmin/countdown/add');
		}
		else
		{
			$pic_mobile = $this->upload->data('file_name');
		}
		
		$this->countdown_model->insert_countdown($name, $start_time, $end_time, $pic['file_name'], $pic_mobile['file_name']);
		redirect('torioadmin/countdown');
	}
	
	function delete_countdown($id){
		if(!$_SERVER['HTTP_REFERER']) redirect('not_found');
		$cd = $this->countdown_model->get_countdown($id);
		$image = $cd['image'];
		if($image) if(file_exists('userdata/countdown/'.$image)) unlink('userdata/countdown/'.$image);
		
		$this->countdown_model->delete_countdown($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_countdown($id){
		$this->data['detail']=$this->countdown_model->get_countdown($id);
		$this->data['content']='admin/countdown/edit';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit_countdown(){
		$id = $this->input->post('countdown_id');
		$name = $this->input->post('name');
		$start = $this->input->post('start');
		$start_time = str_replace('/','-',$start);
		$end = $this->input->post('end');
		$end_time = str_replace('/','-',$end);
		
		$start_time = date('Y-m-d H:i:s', strtotime($start));
		$end_time = date('Y-m-d H:i:s', strtotime($end));
		
		$detail = $this->countdown_model->get_countdown($id);
		$image = $detail['image'];
		$image_mobile = $detail['image_mobile'];
		
		if($_FILES['image']['error']!=4){
			$image_path = realpath(APPPATH . '../userdata/countdown');
		
			$config['upload_path'] = $image_path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['encrypt_name'] = TRUE;
	
			$this->load->library('upload', $config);
			$this->upload->overwrite = false;
	
			if(!$this->upload->do_upload('image'))
			{
				$err_upload = $this->upload->display_errors();
				$this->session->set_flashdata('notif2', $err_upload);
				redirect($_SERVER['HTTP_REFERER']);
			}
			else
			{
				$pic = $this->upload->data('file_name');
				
				//unlink previous image
				if($detail['image']){
					if(file_exists('userdata/countdown/'.$detail['image'])) unlink('userdata/countdown/'.$detail['image']);
				}
				
				$image = $pic['file_name'];
			}
		}
		
		if($_FILES['image_mobile']['error']!=4){
			$image_path = realpath(APPPATH . '../userdata/countdown/mobile');
		
			$config_mobile['upload_path'] = $image_path;
			$config_mobile['allowed_types'] = 'gif|jpg|png|jpeg';
			$config_mobile['encrypt_name'] = TRUE;
	
			$this->load->library('upload', $config_mobile);
			$this->upload->overwrite = false;
	
			if(!$this->upload->do_upload('image_mobile'))
			{
				$err_upload = $this->upload->display_errors();
				$this->session->set_flashdata('notif2', $err_upload);
				redirect($_SERVER['HTTP_REFERER']);
			}
			else
			{
				$pic_mobile = $this->upload->data('file_name');
				
				//unlink previous image
				if($detail['image_mobile']){
					if(file_exists('userdata/countdown/mobile/'.$detail['image'])) unlink('userdata/countdown/mobile/'.$detail['image']);
				}
				
				$image_mobile = $pic_mobile['file_name'];
			}
		}
		
		$this->countdown_model->update_countdown($id, $name, $start_time, $end_time, $image, $image_mobile);
		redirect('torioadmin/countdown');
	}
}