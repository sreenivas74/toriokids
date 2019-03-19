<?php if(!defined('BASEPATH')) exit('no direct script access allowed'); 
	class Campaign extends CI_Controller {
		function __construct(){
			parent::__construct();
				if($this->session->userdata('admin_logged_in')==FALSE)
					redirect('torioadmin/login');		
		}
	
	function index(){
		$this->load->model('cronjob_model');
		$this->data['campaign']=$this->cronjob_model->get_all_campaign_order_desc();
		$this->data['content']='admin/campaign/list';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function add(){
		$this->load->model('product_model');
		$this->data['product']=$this->product_model->get_product_list_price();
		$this->data['content']='admin/campaign/add';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add(){
		$this->load->model('cronjob_model');
		$title=$this->input->post('title');
		$subject=$this->input->post('subject');
		$link=$this->input->post('link');
		$desc=$this->input->post('desc');
		$show=$this->input->post('show');
		$button_link=$this->input->post('button_link');
		$greeting_name=$this->input->post('greeting_name');
		
		$product_id = array();
		$product_1 = $this->input->post('product_1');
		$product_2 = $this->input->post('product_2');
		$product_3 = $this->input->post('product_3');
		$product_4 = $this->input->post('product_4');
		
		$price_before_1 = $this->input->post('price_before_1');
		$price_before_2 = $this->input->post('price_before_2');
		$price_before_3 = $this->input->post('price_before_3');
		$price_before_4 = $this->input->post('price_before_4');
		
		$price_after_1 = $this->input->post('price_after_1');
		$price_after_2 = $this->input->post('price_after_2');
		$price_after_3 = $this->input->post('price_after_3');
		$price_after_4 = $this->input->post('price_after_4');
		
		if($product_1) array_push($product_id, array('product_id'=>$product_1, 'price_before'=>$price_before_1, 'price_after'=>$price_after_1));
		if($product_2) array_push($product_id, array('product_id'=>$product_2, 'price_before'=>$price_before_2, 'price_after'=>$price_after_2));
		if($product_3) array_push($product_id, array('product_id'=>$product_3, 'price_before'=>$price_before_3, 'price_after'=>$price_after_3));
		if($product_4) array_push($product_id, array('product_id'=>$product_4, 'price_before'=>$price_before_4, 'price_after'=>$price_after_4));
		
		$json_product_id = json_encode($product_id);
		
		$config['upload_path'] = 'userdata/campaign';
		$config['allowed_types'] = 'jpg|gif|png|jpeg';
		$config['encrypt_name'] = TRUE; 
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload('image'))
		{
			$error = $this->upload->display_errors();
			$this->session->set_flashdata('notif_error', $error);
			redirect($_SERVER['HTTP_REFERER']);
		}
		else
		{
			$data = $this->upload->data();
			$image = $data['file_name']; 
			$this->cronjob_model->set_all_campaign_inactive();
			$this->cronjob_model->add_campaign($title,$subject,$desc,$image,$link,1,$show,$button_link,$json_product_id,$greeting_name);
			redirect('torioadmin/campaign');
		}
	}
	
	function edit($id){
		$this->load->model('cronjob_model');
		$this->data['detail']=$this->cronjob_model->get_campaign($id);
		$this->load->model('product_model');
		$this->data['product']=$this->product_model->get_product_list_price();
		$this->data['content']='admin/campaign/edit';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit(){
		$this->load->model('cronjob_model');
		$id=$this->input->post('id');
		$title=$this->input->post('title');
		$subject=$this->input->post('subject');
		$link=$this->input->post('link');
		$desc=$this->input->post('desc');
		$show=$this->input->post('show');
		$button_link=$this->input->post('button_link');
		$greeting_name = $this->input->post('greeting_name');
		
		$product_id = array();
		$product_1 = $this->input->post('product_1');
		$product_2 = $this->input->post('product_2');
		$product_3 = $this->input->post('product_3');
		$product_4 = $this->input->post('product_4');
		
		$price_before_1 = $this->input->post('price_before_1');
		$price_before_2 = $this->input->post('price_before_2');
		$price_before_3 = $this->input->post('price_before_3');
		$price_before_4 = $this->input->post('price_before_4');
		
		$price_after_1 = $this->input->post('price_after_1');
		$price_after_2 = $this->input->post('price_after_2');
		$price_after_3 = $this->input->post('price_after_3');
		$price_after_4 = $this->input->post('price_after_4');
		
		if($product_1) array_push($product_id, array('product_id'=>$product_1, 'price_before'=>$price_before_1, 'price_after'=>$price_after_1));
		if($product_2) array_push($product_id, array('product_id'=>$product_2, 'price_before'=>$price_before_2, 'price_after'=>$price_after_2));
		if($product_3) array_push($product_id, array('product_id'=>$product_3, 'price_before'=>$price_before_3, 'price_after'=>$price_after_3));
		if($product_4) array_push($product_id, array('product_id'=>$product_4, 'price_before'=>$price_before_4, 'price_after'=>$price_after_4));
		
		$json_product_id = json_encode($product_id);
		
		$image_previous = find('image',$id,'campaign_tb');
		
		$this->cronjob_model->edit_campaign($id,$title,$subject,$desc,$link,$show,$button_link,$json_product_id,$greeting_name);
		
		if($_FILES['image']['error']!=4){
			$config['upload_path'] = 'userdata/campaign';
			$config['allowed_types'] = 'jpg|gif|png|jpeg';
			$config['encrypt_name'] = TRUE; 
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('image'))
			{
				redirect($_SERVER['HTTP_REFERER']);
			}
			else
			{
				$data = $this->upload->data();
				$image = $data['file_name'] ; 
				$this->cronjob_model->update_image_campaign($id, $image);
				if(file_exists('userdata/campaign/'.$image_previous)) unlink('userdata/campaign/'.$image_previous);
			}
		}
		
		$this->load->model('cronjob_model');
		$this->data['detail']=$detail=$this->cronjob_model->get_campaign($id);
		if($detail['campaign_id']!='' && $detail['sent']==0){
			$mailchimpapi=$this->cronjob_model->get_mailchip_api();
			$mailchimpid=$this->cronjob_model->get_mailchip_id();
			
			$options = array (
			"subject" =>  $detail['subject'],
			"from_email" => 'noreply@toriokids.com', //noreply@mudpie.co.id
			"from_name" => 'Torio Kids',
			"to_name" => '*|FNAME|*',
			"title" => $detail['title']
			);
			
			$content=array(
				//'html' => $this->load->view('content/email_template/campaign_template', $this->data, TRUE) //old version
				'html' => $this->load->view('content/email_template/campaign_template_2', $this->data, TRUE)
			);
			require_once 'application/controllers/cronjob_mailchimp/MailChimp.class.php';
			$MailChimp = new MailChimp($mailchimpapi['value']);
			$_params_content = array("apikey"=>$mailchimpapi['value'], "cid" => $detail['campaign_id'],"name"=>'content', 'value'=>$content);
			$_params_options = array("apikey"=>$mailchimpapi['value'], "cid" => $detail['campaign_id'],"name"=>'options', 'value'=>$options);
			
			$MailChimp->call('campaigns/update',$_params_content);
			$MailChimp->call('campaigns/update',$_params_options);
		}
		
		redirect('torioadmin/campaign');
	}
	
	function delete($id){
		$this->load->model('cronjob_model');
		$this->cronjob_model->delete_campaign($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function active($id,$active){
		$this->load->model('cronjob_model');
		if($active){
			$active=0;
			$active2=1;	
		}else{
			$active=1;
			$active2=0;	
		}
		$this->cronjob_model->active($id,$active);
		$this->cronjob_model->active2($id,$active2);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function preview($id){
		$this->load->model('cronjob_model');
		$this->data['detail'] = $this->cronjob_model->get_campaign($id);
		echo $this->load->view('content/email_template/campaign_template_2', $this->data, TRUE);
	}
}