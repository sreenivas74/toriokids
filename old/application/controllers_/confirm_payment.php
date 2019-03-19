<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Confirm_payment extends CI_Controller{
	function Confirm_payment()
	{
		parent::__construct();
		$this->data['page_title']="Confirm Payment";
		$this->load->model('order_model');
		$this->load->model('user_model');
	}
	
	function index(){
	//	pre($this->session->userdata);
		$this->data['content'] = 'content/confirm_payment_guest';
		$this->load->view('common/body', $this->data);	
	}
	
	function next_step(){
		//pre($this->session->userdata);	
		$order_id=$this->session->userdata('order_id');
		$this->data['order_detail']=$order_detail=$this->order_model->get_order_detail($order_id);
		if(!$order_detail)redirect('confirm_payment');
		if($order_detail['bank']!=''){
			$this->session->set_flashdata('notif','This order has been confirmed already');
			redirect('confirm_payment');
		}
		
		$this->data['user_detail']=$this->user_model->user_detail($order_detail['user_id']);
		$this->data['content'] = 'content/confirm_payment_guest_2';
		$this->load->view('common/body', $this->data);	
	}
	
	function thankyou(){
		//pre($this->session->userdata);	
		$email=$this->session->userdata('email_address');
		
		if(!$email)redirect('confirm_payment');
		
		
		$check_email=$this->user_model->check_email($email);
	//	pre($check_email);
		if($check_email['password']!='')$this->data['ok_register']=0;
		else $this->data['ok_register']=1;
		$this->data['content'] = 'content/confirm_payment_guest_ty';
		$this->load->view('common/body', $this->data);	
	}
	
	function do_complete(){
		$order_id=$this->session->userdata('order_id');
		
		//die(pre($_POST));
		if($_POST){
			$order_detail=$this->order_model->get_order_detail($order_id);//pre($order_detail);
			$account_name = $this->input->post('account_name');
			$bank=$this->input->post('bank');
			$date_transfer=$this->input->post('date_transfer');
			$notes=$this->input->post('notes');
			if($account_name!='' && $bank!='' && $date_transfer ){
				$data=array('account_name'=>$account_name,
							'bank'=>$bank,
							'date_transfer'=>$date_transfer,
							'note'=>$notes);
				$where=array('id'=>$order_id);
				$this->user_model->update_data('order_tb',$data,$where);
				$this->session->unset_userdata(array('order_id'=>''));
				
				
				
				$this->load->library('email'); 	
				$this->email->from('noreply@toriokids.com');
				$this->email->to('order@toriokids.com');	
				
				$this->email->subject('Payment Confirmation - '.$order_detail['order_number']);
				
				$order_detail=$this->order_model->get_order_detail($order_id);
				$this->data['user_detail']=$this->user_model->user_detail($order_detail['user_id']);
				
				$isi="Payment Confirmation<br>
				Order Number: ".$order_detail['order_number']."<br>
				Transfer Date: ".$date_transfer."<br>
				Bank: ".$bank."<br>
				Account Name: ".$account_name."<br>
				Note: ".$notes."
				";
				$this->email->message($isi); 
				$this->email->send();				
				
				
				redirect('confirm_payment/thankyou');
			}
			else{
				$this->session->set_flashdata('notif','Required fields must be filled');
				redirect('confirm_payment/next_step');
			}
		}else{
			$this->session->set_flashdata('notif','Required fields must be filled');
			redirect('confirm_payment');
		}
	}
	
	function check(){
		$order_number=$this->input->post('order_number');
		$email_address=$this->input->post('email_address');
		if($_POST){
			if($order_number!='' && $email_address!=''){
				$check=$this->order_model->check_order_by_email($order_number,$email_address);
				//die(pre($check));
				if($check){
					if($check['bank']==""){
						$this->session->set_userdata(array('order_id'=>$check['id'],'email_address'=>$email_address));
						redirect('confirm_payment/next_step');
					}
					else
					$this->session->set_flashdata('notif','This order has been confirmed already');
				}
				else{
					$this->session->set_flashdata('notif','Invalid order number or email address');
				}
			}
			else{
				$this->session->set_flashdata('notif','All field must be filled');
			}
			
			redirect('confirm_payment');
		}
		else{
			redirect('confirm_payment');
		}
	}
}