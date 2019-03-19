<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Cronjob extends CI_Controller {
	function __construct(){
		parent::__construct();
		
		$this->load->model('order_model');
		$this->load->model('user_model');
		$this->load->model('general_model');
	}
	
	function call_all(){
		$this->cancel_two_day();
		$this->send_reminder_one_day();	
	}
	
	function cancel_two_day()
	{
		$token=STAMPS_TOKEN;
		$store=STAMPS_STORE;
		$all_order=$this->order_model->get_order_diffrent_two_days();
		if($all_order)foreach($all_order as $list_order){
				$date1= new DateTime($list_order['email_sent']);
				$date2= new DateTime(date("Y-m-d H:i:s"));
				$diff = $date2->diff($date1);
				$hours = $diff->h;
				$hours = $hours + ($diff->days*24);
			if($hours >=144){
				$order_id=$list_order['id'];
				$time = date('Y-m-d H:i:s');
				$database=array('status'=>3, 'updated_status'=>$time);
				$where=array('id'=>$order_id);
				$this->general_model->update_data('order_tb',$database,$where);
				
					$stampsdata=$this->order_model->get_order_detail($order_id);	
					$trans_id=$stampsdata['id_stamps'];
					if($trans_id){
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
				
			}
		}
	}
	
	function send_reminder_one_day()
	{
		
	
		$all_order=$this->order_model->get_order_diffrent_one_hours();
		
		if($all_order){
			foreach($all_order as $list_order){
				$order_id=$list_order['id'];
				$date1= new DateTime($list_order['email_sent']);
				$date2= new DateTime(date("Y-m-d H:i:s"));
				$diff = $date2->diff($date1);
				$hours = $diff->h;
				$hours = $hours + ($diff->days*24);
				if($hours >=21){
					if($list_order['confirm_payment_flag']==0){
						$this->data['order']=$this->shopping_cart_model->get_order($order_id);
						$order=$this->data['order'];
						$this->data['user']=$this->user_model->user_detail($order['user_id']);
						$this->data['order_item']=$this->shopping_cart_model->get_order_item2($order['id']);
						$this->data['discount']=0;
						$isi=$this->load->view('content/email_template/email_reminder',$this->data,TRUE);		
						$email=$this->data['user']['email'];
						$this->load->library('email'); 	
						$this->email->from('noreply@toriokids.com');
						//$this->email->to('alvinw@isysedge.com,frans@isysedge.com,andry@isysedge.com'); 
						$this->email->to($email);
						$this->email->bcc('order@toriokids.com,alvinw@isysedge.com,andry@isysedge.com');  
						$this->email->subject('Reminder for your Torio Kids Order - '.$order['order_number']);
						$this->email->message($isi); 
						$this->email->send();
						$database=array('sent_reminder'=>1);
						$where=array('id'=>$order_id);
						$this->general_model->update_data('order_tb',$database,$where);
					}
				}
			}
		}
	}
	
	
	
}
?>