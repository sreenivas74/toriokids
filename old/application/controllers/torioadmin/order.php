<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Order extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if ($this->session->userdata('admin_logged_in')==false) {
			redirect('torioadmin/login');
		}
		$this->load->model('product_model');
		$this->load->model('jne_model');
		$this->load->model('order_model');	
		$this->load->model('user_model');	
		$this->load->model('shopping_cart_model');	
		$this->load->model('general_model');	
	}
	
	function index()
	{	
		if($this->session->userdata('admin_id')==2) redirect('torioadmin/order/recap');
		$this->data['sent_email']=$this->order_model->get_email_sent();
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
			curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
				'Content-Type: application/json'));
			$result  =  curl_exec($ch);  
		}
		if($status_id==4){
			$no_resi=$this->input->post('no_resi');
			$database=array('no_resi'=>$no_resi);
			$where=array('id'=>$order_id);
			$this->general_model->update_data('order_tb',$database,$where);
		}
		
		$order_item = $this->order_model->get_order_item($order_id);
		
		if($status_id!=5 && $status_id!=0){
			foreach($order_item as $list){
				if($list['sale_id']!=0){
					$sku_id = $list['sku_id'];
					$stock = find('stock', $sku_id, 'sku_tb');
					$qty = $list['quantity'];
					
					if($qty<=$stock){ 
						$sisa = $stock-$qty;
					}
					else if($qty>$stock){ 
						$sisa = 0;
					}
					else{
						//do nothing
					}
					
					$this->load->model('sale_model');
					$this->sale_model->update_stock($sku_id, $sisa);
				}
				
				$this->order_model->remove_sale_id($list['id']);
			}
		}
		
		$this->order_model->update_order_status($order_id,$status_id);
		if($status_id==1 or $status_id==4){//1 itu processed 4 itu shipped
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
	
	function email_order($order_id,$status)	{
		
		$this->data['order']=$this->shopping_cart_model->get_order($order_id);
		$order=$this->data['order'];
		$this->data['user']=$this->user_model->user_detail($order['user_id']);
		$this->data['order_item']=$this->shopping_cart_model->get_order_item2($order['id']);
		$this->data['discount']=0;
		
		if($status==1)
		$isi=$this->load->view('content/email_template/email_update_temp_order_details',$this->data,TRUE);
		else
		$isi=$this->load->view('content/email_template/email_order_shipped',$this->data,TRUE);
		
		$email=$this->data['user']['email'];
		$this->load->library('email'); 	
		$this->email->from('noreply@toriokids.com ');
		$this->email->to($email); 
		$this->email->bcc('order@toriokids.com');  
		
		if($status==4){
			$this->email->subject('Order Shipped - '.$order['order_number']);
		}else{
			$this->email->subject('Order Processed - '.$order['order_number']);
		}
		
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
	
	function export_excel(){
		$this->data['order_item_list']=$data=$this->order_model->get_order_item_all_for_download();
		$content = $this->load->view('admin/order/order_download', $this->data, true);
	
		$filename = "report_order.xls";
		//prepare to give the user a Save/Open dialog...
		//header ("Content-type: application/vnd.ms-excel");
		header("Content-type: application/vnd.ms-excel; name='excel'; charset=utf-8");
		header ("Content-Disposition: attachment; filename=".$filename);
		
		//setting the cache expiration to 30 seconds ahead of current time. an IE 8 issue when opening the data directly in the browser without first saving it to a file
		$expiredate = time() + 30;
		$expireheader = "Expires: ".gmdate("D, d M Y G:i:s",$expiredate)." GMT";
		header ($expireheader);
		echo $content;
		exit;	
	}
	
	function bank(){
		$this->data['order']=$this->order_model->get_order_list_type_bank();
		$this->data['content']='admin/order/list_bank';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function cc(){
		$this->data['order']=$this->order_model->get_order_list_type_cc();
		$this->data['content']='admin/order/list_cc';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function clear_shopping_cart(){
		$this->db->truncate('shopping_cart_tb');
		$_SESSION['success_clear']=1;
		redirect('torioadmin');
	}
	
	function email($id){
		$this->data['sent_email']=$this->order_model->get_email_sent();
		$this->data['detail']=$this->order_model->get_order_detail($id);
		$this->data['email_counter']=$this->order_model->get_email_history($id);
		$this->data['content']='admin/order/email';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function change_email(){
		$this->general_model->update_data('email_sent_pdf_tb',$_POST,array('id'=>1));
	}
	
	function send_email_form($id){
		$this->data['detail']=$this->order_model->get_order_detail($id);
		$this->data['sent_email']=$sent_email=$this->order_model->get_email_sent();
		$subject = $this->input->post('subject');
	
		$message = $this->input->post('message');
		$this->data['message']=$message;
		$content=$this->load->view('admin/order/email_template',$this->data,TRUE);
			
		$this->load->library('email'); 	
		$this->email->from('noreply@toriokids.com');
		$this->email->reply_to('aditya@isysedge.com','Aditya Mahendra');
		$this->email->to($sent_email['email']); 
		$this->email->subject($subject);
		$this->email->message($content); 
		$this->email->send();
		
		$now = date('Y-m-d H:i:s');
		
		$this->order_model->add_email_history($id, $sent_email['email'],$subject, $message, $now);
		
		$_SESSION['contact_error'] = 'Your email has been send to '.$sent_email['email'].'. Thank You.';
		$this->general_model->update_data('order_tb',array('email_sent'=>date('Y-m-d H:i:s')),array('id'=>$id));
		redirect('torioadmin/order');
	}
	
	function cheat_order(){
		$order=$this->order_model->get_order_list();
		$table='order_tb';
		if($order)foreach($order as $list){
			$where=array('id'=>$list['id']);
			$city_name=find('name',$list['city'],'jne_city_tb');
			$province_name=find('name',$list['province'],'jne_province_tb');
			$data=array('province_name'=>$province_name,'city_name'=>$city_name);
			$this->general_model->update_data($table, $data, $where);
		}
	}
	
	function send_email($order_id=0){
		if($order_id!=0){
			$this->data['order']=$this->shopping_cart_model->get_order($order_id);
			$order=$this->data['order'];
			$user_id=$order['user_id'];
			$this->data['user']=$this->user_model->user_detail($user_id);
			$this->data['order_item']=$data55=$this->shopping_cart_model->get_order_item2($order['id']);
		
			
			$this->data['discount']=0;
			$isi=$this->load->view('content/email_template/email_temp_order_details',$this->data,TRUE);
			$isi_admin=$this->load->view('content/email_template/email_temp_order_details_admin',$this->data,TRUE);
			
			//return 1;exit();
			$email=find('email',$user_id,'user_tb');
			
			$this->load->library('email'); 	
			$this->email->from('noreply@toriokids.com');
			$this->email->to($email); 
			$this->email->subject('Order Details - '.$order['order_number']);
			$this->email->message($isi); 
			$this->email->send();
			
			$this->email->clear();
			
			//untuk admin ada link donlod pdf
			$this->email->from('noreply@toriokids.com');
			$this->email->to('order@toriokids.com'); 	
			$isi_admin=$this->load->view('content/email_template/email_temp_order_details_admin',$this->data,TRUE);
			$this->email->subject('Order Details - '.$order['order_number']);
			$this->email->message($isi_admin); 
			$this->email->send();
			
			return TRUE;
		}
		else return FALSE;
	}
	
	function add(){
		#$this->data['city'] = $this->jne_model->get_city_all();
		$this->data['product'] = $this->product_model->get_active_sku_list();
		$this->data['province'] = $this->jne_model->get_jne_province_data();
		
		$this->data['content']='admin/order/add';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function get_kecamatan(){
		$jne_city=array();
		if(isset($_GET['term'])){
			$search=htmlspecialchars($_GET['term']);
			$parameters = array('search'=>$search);
			$parameters_json = json_encode($parameters);
			
			$ch = curl_init();  
			$url = "http://jne.isysedge.com/api/jne/get_city_filter";
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array("data" => $parameters_json));    
			$output=curl_exec($ch);
			curl_close($ch);
			
			$data=json_decode($output,true);
		}else{
			$ch = curl_init();  
			$url = "http://jne.isysedge.com/api/jne/get_city_all";
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			//curl_setopt($ch, CURLOPT_POSTFIELDS, array("data" => $parameters_json));    
			$output=curl_exec($ch);
			curl_close($ch);
			$data=json_decode($output,true);
		}
	
		//pre($data);
		foreach ($data as $list){
				$jne_city[]=array('id'=>$list['id'],'province_id'=>$list['jne_province_id'],'value'=>$list['province_name'] .' | '. $list['name']);		
		}
		echo json_encode($jne_city);
	}
	
	function get_city(){
		$province_name = $this->input->post('province_name');
		$province = $this->jne_model->get_province_by_name($province_name);
		if($province) $province_id = $province['id'];
		else $province_id = 0;
		
		$this->data['city'] = $this->jne_model->get_city_by_province($province_id);
		$content = $this->load->view('admin/order/ajax_city', $this->data, TRUE);
		
		$fee = '';
		$this->data['method'] = '';
		$fee = $this->load->view('admin/order/ajax_shipping', $this->data, TRUE);
	
		echo json_encode(array('content'=>$content, 'fee'=>$fee));
	}
	
	function get_method(){
		$id = $_POST['id'];
		$parameters = array('city_id'=>$id);
		$parameters_json = json_encode($parameters);
		
		$ch = curl_init();  
		$url = "http://jne.isysedge.com/api/jne/get_shipping_method";
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array("data" => $parameters_json));    
		$output=curl_exec($ch);
		curl_close($ch);
		$this->data['method'] = $data=json_decode($output,true);
		
		$content = $this->load->view('admin/order/ajax_shipping', $this->data, TRUE);
		echo json_encode(array('content'=>$content));
	}
	
	function add_order_manual(){	
		//check if user_id exists by email
		$email = $this->input->post('email');
		$user_id = 0;
		
		//check email first for user_id
		$check_email = $this->user_model->check_email_all($email);
		
		//if email as guest already exists
		if($check_email)
		{
			if($check_email['password']=="" && $check_email['guest']==1)
			{
				$user_id = $check_email['id'];
			}
			
			if($check_email['password']!="" && $check_email['guest']==0)
			{
				$user_id = $check_email['id'];
			}
		}
		
		//if no email, input new email as guest
		if(!$check_email)
		{
			$this->user_model->add_guest_email($email);
			$user_id = mysql_insert_id();
		}
		
		$recipient_name = $this->input->post('recipient_name');
		$address = $this->input->post('address');
		$phone = $this->input->post('phone');
		$zipcode = $this->input->post('zipcode');
		$city = $this->input->post('city');
		$payment = $this->input->post('payment');
		$shipping_cost = $this->input->post('shipping_cost');
		$date = date('Y-m-d H:i:s');
		
		$province_id = $this->input->post('province');
		$province_name = api_province_name($province_id);
		$city_name = api_city_name($city);
		
		$sku_arr = $this->input->post('id');
		$qty_arr = $this->input->post('qty');
		$price_arr = $this->input->post('price');
		
		//make order number
		$temp = $this->order_model->get_order_number();
		if(date('Y', strtotime($temp['updated_date']))==date('Y')){
			$num=$temp['counter']+1;	
			$this->order_model->update_order_number($num);
		}else {
			$num=101;
			$this->order_model->update_order_number2($num);
		}
		
		$order_number='T'.date('y').date('m').date('d').$num;
		
		//calculate grand total and total shipping
		$total=0; $total_discount=0; $total_weight=0; $grand_total=0;
		$no=0; $count = count($sku_arr);
		for($no=0; $no < $count; $no++)
		{
			$sku = $this->product_model->get_selected_sku_data($sku_arr[$no]);
			$product_id = $sku['product_id'];
			$weight = find('weight', $product_id, 'product_tb');
			$qty = $qty_arr[$no];
			$price = $price_arr[$no];
			//$total_discount += $product['discount']*$qty;
			$total += $price*$qty;
			$total_weight += $weight*$qty;
		}
		
		$ceil_weight = ceil($total_weight);
		
		$total_shipping = $shipping_cost*$ceil_weight;
		$grand_total = $total+$total_shipping;
		
		$data = array(
			'recipient_name'=>$recipient_name,
			'shipping_address'=>$address,
			'phone'=>$phone,
			'city'=>$city,
			'city_name'=>$city_name,
			'province'=>$province_id,
			'province_name'=>$province_name,
			'zipcode'=>$zipcode,
			'user_id'=>$user_id,
			'total'=>$grand_total,
			'status'=>0,
			'order_number'=>$order_number,
			'transaction_date'=>$date,
			'shipping_cost'=>$total_shipping,
			'shipping_method_fee'=>$shipping_cost,
			'payment_type'=>$payment,
			'actual_weight'=>$total_weight,
			'ceil_weight'=>$ceil_weight
		);
		
		$this->shopping_cart_model->insert_data('order_tb',$data);	
		$order_id = mysql_insert_id();
		
		$no2=0; $count2 = count($sku_arr);
		for($no2=0; $no2 < $count2; $no2++)
		{
			$sku = $this->product_model->get_selected_sku_data($sku_arr[$no2]);
			$product2 = $this->product_model->get_product_by_id($sku['product_id']);
			$qty2 = $qty_arr[$no2];
			$total_real = $qty2*$price_arr[$no2];
			$price2 = $product2['msrp'];
			
			//if there's a quantity of the product
			if($qty2 > 0) //change to -1 if NaN
			{
				$total2=$qty2*$price2;
				#$discount = $product2['msrp']-$product2['price'];
				$totaldiscount=($qty2*$price2)-$total_real;
				$database = array(	'order_id'=>$order_id,
									'product_id'=>$product2['id'], 
									'sku_id'=>$sku['id'],
									'user_id'=>$user_id,
									'quantity'=>$qty2,
									'price'=>$price2,
									'discount_price'=>$totaldiscount,
									'total'=>$total_real);		
				$this->shopping_cart_model->insert_data('order_item_tb',$database);	
			}
		}
		
		$this->send_email($order_id);
		
		$this->session->set_flashdata('add_notif','Success add order.');
		
		echo 1;
	}
	
	function make_order_number($order_id=0){
		if($order_id!=0){
			$temp = $this->order_model->get_order_number();
			if(date('Y', strtotime($temp['updated_date']))==date('Y')){
				$num=$temp['counter']+1;	
				$this->order_model->update_order_number($num);
			}else {
				$num=101;
				$this->order_model->update_order_number2($num);
			}
			$_SESSION['order_id']=$order_id;
			$number='T'.date('y').date('m').date('d').$num;
			$_SESSION['order_number']=$number;
			$this->shopping_cart_model->update_order($order_id,$number);
			return $number;
		}
		return 0;
	}
	
	
	function test_reminder($order_id){
		$this->data['order']=$this->shopping_cart_model->get_order($order_id);
		$order=$this->data['order'];
		$this->data['user']=$this->user_model->user_detail($order['user_id']);
		$this->data['order_item']=$this->shopping_cart_model->get_order_item2($order['id']);
		$this->data['discount']=0;
		$isi=$this->load->view('content/email_template/email_reminder',$this->data,TRUE);		
		echo $isi;
	}
	
	function test_send_email($order_id){
		$this->data['order']=$this->shopping_cart_model->get_order($order_id);
		$order=$this->data['order'];
		$user_id=$order['user_id'];
		$this->data['user']=$this->user_model->user_detail($user_id);
		$this->data['order_item']=$data55=$this->shopping_cart_model->get_order_item2($order['id']);
	
		
		$this->data['discount']=0;
		$isi=$this->load->view('content/email_template/email_temp_order_details',$this->data,TRUE);
		echo $isi;
	}
}