<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Order extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if ($this->session->userdata('admin_logged_in')==false) {
			redirect('torioadmin/login');
		}
		$this->load->model('order_model');	
		$this->load->model('user_model');	
		$this->load->model('shopping_cart_model');	
	}
	
	function index()
	{	
		$this->data['order']=$this->order_model->get_order_list();
		$this->data['content']='admin/order/list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function shipped_order()
	{
		$this->data['recap']=$this->order_model->get_recap();
		$this->data['content']='admin/order/shipped_order';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function search()
	{
		$keyword=$this->data['keyword']=$this->input->post('keyword');
		if($keyword){
			if(username_check($keyword)){
			$this->data['order']=$this->order_model->get_search_order(username_check($keyword));
			}else {
			$this->data['order']=$this->order_model->get_search_order($keyword);
			}
		$this->data['content']='admin/order/list';
		$this->load->view('common/admin/body',$this->data);
		}else {
			redirect('torioadmin/order');
		}
	}
	
	function detail($order_id)
	{	
		$this->data['detail']=$this->order_model->get_order_detail($order_id);
		$this->data['item']=$this->order_model->get_order_item2($order_id);	 
		$this->data['content']='admin/order/detail';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function recalculate($order_id)
	{
		$result=$this->order_model->get_totalprice($order_id);
		$this->order_model->update_total_order($order_id,$result['sum']);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function update_send_email($order_id)
	{
		$msg=$this->input->post('msg');	
		$this->order_model->add_msg($order_id,$msg);
		
		$this->data['user']=$this->session->userdata('user_id');
		$order=$this->data['order']=$this->shopping_cart_model->get_order($order_id);
		$order_item=$this->data['order_item']=$this->shopping_cart_model->get_order_item2($order['id']);
		$message=$this->data['message']=$this->order_model->get_message_for_email($order_id);
		$this->data['name']=find('full_name',$order['user_id'],'user_tb');
		$this->data['sender_address']=find_sender($order['sender_name']);
		$this->data['recipient_address']=find_recipient($order['recipient_name']);
		$isi=$this->load->view('content/email_template/email_update_temp_order_details',$this->data,TRUE);
		$email=find('email',$order['user_id'],'user_tb');

		$this->load->library('email'); 	
		$this->email->from('noreply@toriokids.com');
		$this->email->to($email); 
		
		$this->email->subject('Order Details');
		
		$this->email->message($isi);
		
		$this->email->send();	
		
		$isi2=$this->load->view('content/email_template/email_update_temp_order_details',$this->data,TRUE);
		$this->email->from('noreply@toriokids.com');
		$this->email->to('noreply@toriokids.com'); 
		
		$this->email->subject('Order Details Admin');
		
		$this->email->message($isi2);
		$this->email->send();	
	
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function email_message($id)
	{
		$this->data['message']=$this->order_model->get_message($id);
		$this->data['detail']=$this->order_model->get_order_detail($id);
		$this->data['content']='admin/order/email_msg';
		$this->load->view('common/admin/body',$this->data);
		
	}
	
	function update_order_item_status()
	{
		$order_item_id=$this->input->post('order_item_id');
		$status_id=$this->input->post('status_id');	
		
		$this->order_model->update_order_item_status($order_item_id,$status_id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function update_order_status()
	{

		$order_id=$this->input->post('id');
		$status_id=$this->input->post('status_id');	
		$token=STAMPS_TOKEN;
		$aa=$this->input->post('order_id');;
		$store=STAMPS_STORE;
		$emailstamps=$this->input->post('email_stamps');
		$grand_total=$this->input->post('grand_total');
		
		if ($status_id==1){
			
			$stamps = array(
								'token'=>$token,
								'store'=>$store,
								'user_email'=>$emailstamps,
								'invoice_number'=>$aa,
								'total_value'=>$grand_total	
									 );
			$data = json_encode($stamps); 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://stamps.co.id/api/transactions/add');                     
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch,  CURLOPT_HTTPHEADER,  array(
				'Content-Type: application/json'));
			$result  =  curl_exec($ch);  
			$zz=json_decode($result,true);
		
			if(!isset($zz['errors'])){
				$id_stamps= $zz['customer']['id'];
				$this->order_model->update_stamp_id($emailstamps,$id_stamps);
			}
		// jika cancel
		}else if($status_id==3){
			$stampsdata=$this->order_model->get_order_detail($order_id);	
			$trans_id=$stampsdata['id_stamps'];
			//echo $trans_id;
			$stamps = array(
								'token'=>$token,
								'id'=>$trans_id	
									 );
			$data = json_encode($stamps); 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://stamps.co.id/api/transactions/cancel');                     
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch,  CURLOPT_HTTPHEADER,  array(
				'Content-Type: application/json'));
			$result  =  curl_exec($ch);  
		}
		$this->order_model->update_order_status($order_id,$status_id);
		if($status_id==1 or $status_id==4){
			$this->email_order($order_id,$status_id);
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function update_shipping_cost()
	{
		$order_id=$this->input->post('order_id');
		$shipping_cost=$this->input->post('shipping_cost');	
		
		$this->order_model->update_shipping_cost($order_id,$shipping_cost);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function update_order_item()
	{
		$order_id=$this->input->post('order_id');
		$order_item_id=$this->input->post('order_item_id');	
		$admin_id=$this->session->userdata('admin_id');
		
		if($order_item_id){
			$total=0;$total_price=0;
			foreach($order_item_id as $item_id){				
				$price=$this->input->post('price_'.$item_id);
				$quantity=$this->input->post('quantity_'.$item_id);
				$status_id=$this->input->post('status_id_'.$item_id);
				$delivery_time=$this->input->post('delivery_time_'.$item_id);
				
				if($status_id!=-1)
				$total_price=$price*$quantity;
				else				
				$total_price=0;
				$total+=$total_price;
					
				$this->order_model->update_order_item($item_id,$status_id,$quantity,$total_price,$delivery_time,$price);
			}
			$this->order_model->update_total_order($order_id,$total);			
		}		
		
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function recap()
	{
		$this->data['status']="";
		$this->data['to']=NULL;
		$this->data['from']=NULL;
		$a = $this->data['recap']=$this->order_model->get_recap_list();
		$this->data['content']='admin/order/recap';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function filter()
	{
		$status = $this->input->post('txtStatus');
		$from =  $this->input->post('date');
		$to =  $this->input->post('date_to');
		$this->data['recap']=$this->order_model->get_recap_list_filter($status, $from, $to);
		$this->data['status']=$status;
		$this->data['to']=$to;
		$this->data['from']=$from;
		$this->data['content']='admin/order/recap';
		$this->load->view('common/admin/body',$this->data);
		
	}
	
	function send_reminder($order_id){		
		$this->data['order']=$this->shopping_cart_model->get_order($order_id);
		$order=$this->data['order'];
		$this->data['user']=$this->user_model->user_detail($order['user_id']);
		$this->data['order_item']=$this->shopping_cart_model->get_order_item2($order['id']);
		$this->data['discount']=0;
		
		$isi=$this->load->view('content/email_template/email_reminder',$this->data,TRUE);		
		
		$email=$this->data['user']['email'];
		$this->load->library('email'); 	
		$this->email->from('noreply@toriokids.com ');
		$this->email->to($email); 
		$this->email->bcc('order@toriokids.com');  
		
		$this->email->subject('Reminder for your Torio Kids Order - '.$order['order_number']);
		
		$this->email->message($isi); 
		$this->email->send();
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function email_order($order_id,$status){
		
		$this->data['order']=$this->shopping_cart_model->get_order($order_id);
		$order=$this->data['order'];
		$this->data['user']=$this->user_model->user_detail($order['user_id']);
		$this->data['order_item']=$this->shopping_cart_model->get_order_item2($order['id']);
		$this->data['discount']=0;
		
		$isi=$this->load->view('content/email_template/email_update_temp_order_details',$this->data,TRUE);
		//$this->load->view('content/email_template/email_update_temp_order_details',$this->data);
		
		$email=$this->data['user']['email'];
		$this->load->library('email'); 	
		$this->email->from('noreply@toriokids.com ');
		$this->email->to($email); 
		$this->email->bcc('order@toriokids.com');  
		
		$this->email->subject('Order Details - '.$order['order_number']);
		
		$this->email->message($isi); 
		$this->email->send();
		//echo $this->email->print_debugger();
		
	}
	
	function confirm_payment_bank_transfer($order_id)
	{
		$this->order_model->update_order_status($order_id,1);
		$this->data['order']=$this->shopping_cart_model->get_order($order_id);
		$order=$this->data['order'];
		$this->data['user']=$this->user_model->user_detail($order['user_id']);
		$this->data['order_item']=$this->shopping_cart_model->get_order_item2($order['id']);
		$this->data['discount']=0;
		$isi=$this->load->view('content/email_template/email_update_temp_order_details',$this->data,TRUE);
		$email=find('email',$order['user_id'],'user_tb');
		$this->load->library('email'); 	
		$this->email->from('noreply@toriokids.com ');
		$this->email->to($email); 
		$this->email->bcc('order@toriokids.com'); 
		
		$this->email->subject('Order Details - '.$order['order_number']);
		
		$this->email->message($isi); 
		$this->email->send();
		
		redirect($_SERVER['HTTP_REFERER']);
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
	 $this->data['item']=$this->order_model->get_order_item2($order_id);


     $html = $this->load->view('admin/order/testexcel', $this->data, true);
	 $filename = "Order-".$datadetail['order_number'];
     pdf_create($html, $filename);	
	}
}