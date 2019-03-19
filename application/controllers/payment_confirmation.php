<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Payment_confirmation extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('user_logged_in')==false)redirect("login");	
		$this->load->model('user_model');	
		$this->load->model('jne_model');
		$this->load->model('general_model');
		$this->load->model('order_model');	
		$this->data['page_title']="My Profile";
		$this->load->model('footer_menu_model');
		$this->data['footer'] = $this->footer_menu_model->get_active_footer_menu_list();
		$this->load->model('secondary_menu_model');
		$this->data['secondary'] = $this->secondary_menu_model->get_active_secondary_menu_list();
	}
	function index(){
		$user_id=$this->session->userdata('user_id');
		$profile= $this->user_model->user_detail($user_id);	
		$this->data['content'] = 'content/profile/payment_confirmation';
		$this->load->view('common/body', $this->data);	

	}

	function do_confirm_payment(){
		$order_number = $this->input->post('order_number');
		$account_name = $this->input->post('account_name');
		$bank=$this->input->post('bank');
		$date_transfer=$this->input->post('date_transfer');
		$nominal=$this->input->post('nominal');
		$bank_tujuan=$this->input->post('bank_tujuan');
		//$metode=$this->input->post('metode');
		$note="";
		$user_id = $this->session->userdata('user_id');
		$check = $this->order_model->check_order_number($order_number,$user_id);

		$this->data['order_number']=$order_number;
		$this->data['account_name']=$account_name;
		$this->data['bank']=$bank;
		$this->data['date_transfer']=$date_transfer;
		$this->data['nominal']=$nominal;
		$this->data['bank_tujuan']=$bank_tujuan;
		//$this->data['metode']=$metode;

		if($order_number==""){
			$this->data['error'] = 'Please enter your order number';
			$this->data['content'] = 'content/profile/payment_confirmation';
			$this->load->view('common/body', $this->data);
		}
		else if(!$check){
			$this->data['error'] = 'Your order number is incorrect';
			$this->data['content'] = 'content/profile/payment_confirmation';
			$this->load->view('common/body', $this->data);
		}
		else if($bank_tujuan==""){
			$this->data['error_tujuan'] = 'Please select the destination bank';
			$this->data['content'] = 'content/profile/payment_confirmation';
			$this->load->view('common/body', $this->data);
		}
		else if($bank==""){
			$this->data['error_bank'] = 'Please enter your bank';
			$this->data['content'] = 'content/profile/payment_confirmation';
			$this->load->view('common/body', $this->data);
		}
		else if($account_name==""){
			$this->data['error_rek'] = 'Please enter your account name';
			$this->data['content'] = 'content/profile/payment_confirmation';
			$this->load->view('common/body', $this->data);
		}
		// else if($metode==""){
		// 	$this->data['error_metode'] = 'Please select your transfer method';
		// 	$this->data['content'] = 'content/profile/payment_confirmation';
		// 	$this->load->view('common/body', $this->data);
		// }
		else if($nominal==""){
			$this->data['error_nom'] = 'Please enter your nominal transfer';
			$this->data['content'] = 'content/profile/payment_confirmation';
			$this->load->view('common/body', $this->data);
		}
		else if(!is_numeric($nominal)){
			$this->data['error_nom'] = 'Nominal transfer must be number';
			$this->data['content'] = 'content/profile/payment_confirmation';
			$this->load->view('common/body', $this->data);
		}
		else if($date_transfer==""){
			$this->data['error_date'] = 'Please enter transfer date';
			$this->data['content'] = 'content/profile/payment_confirmation';
			$this->load->view('common/body', $this->data);
		}
		else{
				if($account_name!='' && $bank!='' && $date_transfer ){
					$data=array('account_name'=>$account_name,
								'bank'=>$bank,
								'date_transfer'=>$date_transfer,
								'note'=>$note,
								'nominal_transfer'=>$nominal,
								'confirm_payment_flag'=>1);
					$where=array('order_number'=>$order_number);
					$this->user_model->update_data('order_tb',$data,$where);
					
					$order_id = find_2('id','order_number',$order_number,'order_tb');
					$order_detail=$this->order_model->get_order_detail($order_id);
					
					$this->load->library('email'); 	
					$this->email->to('order@toriokids.com');
					$this->email->from('noreply@toriokids.com');	
					
					$this->email->subject('Order Payment Confirmation - '.$order_detail['order_number']);
					
					
					$this->data['user_detail']=$this->user_model->user_detail($order_detail['user_id']);
					
					$isi="Payment Confirmation<br>
					Order Number: ".$order_detail['order_number']."<br>
					Transfer Date: ".$date_transfer."<br>
					Bank: ".$bank."<br>
					Account Name: ".$account_name."
					";
					$this->email->message($isi); 
					$this->email->send();
				}
			$_SESSION['confirm']=1;
			redirect('my_order');
		}


		
	}
	

}
?>