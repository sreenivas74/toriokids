<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class My_order extends CI_Controller{
	function My_order()
	{
		parent::__construct();	
		if($this->session->userdata('user_logged_in')==false)redirect("login");		
		$this->load->model('user_model');		
		$this->load->model('order_model');	
		$this->data['page_title']="My Orders";			
	}
			
	function index()
	{
		$user_id=$this->session->userdata('user_id');
		$this->data['account']=$this->user_model->user_detail($user_id);
		$this->data['order_user']=$this->user_model->get_order_by_user($user_id);
		$this->data['content'] = 'content/my_account/edit_profile_order';
		$this->load->view('common/body', $this->data);	
	}
	
	function detail($id)
	{
		$this->data['shipping']=$this->user_model->get_shipping_info($id);
		$user_id=$this->session->userdata('user_id');
		if(order_check($user_id,$id)){
			$this->data['account']=$this->user_model->user_detail($user_id);
			$this->data['order']=$this->user_model->get_order2($id);
		}else {
		redirect('home');
		}
		$this->data['discount']=0;
		$this->data['content'] = 'content/my_account/edit_profile_order_detail';
		$this->load->view('common/body', $this->data);	
	}
	function confirm_payment($id){
		$this->data['shipping']=$this->user_model->get_shipping_info($id);
		$user_id=$this->session->userdata('user_id');
		if(order_check($user_id,$id)){
			$this->data['account']=$this->user_model->user_detail($user_id);
			$this->data['order_detail']=$order_detail=$this->order_model->get_order_detail($id);
		}else {
		redirect('home');
		}
		
	
		$this->data['content'] = 'content/my_account/confirm_payment';
		$this->load->view('common/body', $this->data);	
	}
	
	function do_confirm_payment(){
		$order_number = $this->input->post('order_number');
		$account_name = $this->input->post('account_name');
		$bank=$this->input->post('bank');
		$date_transfer=$this->input->post('date_transfer');
		$note=$this->input->post('note');
		if($account_name!='' && $bank!='' && $date_transfer ){
			$data=array('account_name'=>$account_name,
						'bank'=>$bank,
						'date_transfer'=>$date_transfer,
						'note'=>$note);
			$where=array('order_number'=>$order_number);
			$this->user_model->update_data('order_tb',$data,$where);
			
			
			
			
			$this->load->library('email'); 	
			$this->email->to('order@toriokids.com ');
			$this->email->from('noreply@toriokids.com');	
			
			$this->email->subject('Payment Confirmation - '.$order_detail['order_number']);
			
			$order_detail=$this->order_model->get_order_detail($order_id);
			$this->data['user_detail']=$this->user_model->user_detail($order_detail['user_id']);
			
			$isi="Payment Confirmation<br>
			Order Number: ".$order_detail['order_number']."<br>
			Transfer Date: ".$date_transfer."<br>
			Bank: ".$bank."<br>
			Account Name: ".$account_name."<br>
			Note: ".$note."
			";
			$this->email->message($isi); 
			//$this->email->send();
		}
		$_SESSION['confirm']=1;
		redirect('my_order');


		
	}
	
	function download_order($order_id){
		 $this->load->helper(array('dompdf', 'file'));
		 // page info here, db calls, etc.     
		
		 $this->data['shipping']=$this->user_model->get_shipping_info($order_id);
		 $this->data['order']=$this->user_model->get_order2($order_id);
		 $this->data['detail']=$datadetail=$this->order_model->get_order_detail($order_id);
		 $user_id=$datadetail['user_id'];
		 $this->data['sender_detail']=$data100=$this->user_model->user_detail($user_id);
		// pre($datadetail);exit();
		 $this->data['discount']=0;
		 $this->data['item']=$this->order_model->get_order_item($order_id);
		 $html = $this->load->view('admin/order/testexcel', $this->data, true);
		 $filename = "Order-".$datadetail['order_number'];
		 pdf_create($html, $filename);	
	}
}
?>