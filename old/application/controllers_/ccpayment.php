<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Ccpayment extends CI_Controller {
	function Ccpayment(){
		parent::__construct();
		$this->load->model('shopping_cart_model');
		$this->load->model('product_model');
		$this->load->model('user_model');
		$this->load->model('jne_model');
		$this->load->model('coupoun_model');
		$this->load->model('order_model');
	}
	
	//Saat dilakukan payment request, dilakukan insert data ke doku_tb
	function doku_payment()
	{
		//pre($_POST);
		//sebelum pindah ke halaman doku, kita create dulu item2 untuk dilempar ke halaman doku
		//$address_guest=$this->session->userdata('address_guest');
		$user_id=$this->input->post('user_id');
		$id=$user_id;
		$total=$this->input->post('total');
		$ceil_weight=$this->input->post('ceil_weight');
		$shipping_fee=$this->input->post('shipping_fee');
		$voucher_id=$this->input->post('voucher');
		$user_address_id=$_SESSION['address_id'];
		$shipping_method_fee=$_SESSION['shipping_method'];
		$transaction_id=uniqid(); 
		$cart_list=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);
		
		$discount_list=$this->shopping_cart_model->get_discount_user2($id);

		$session_id=session_id();
		$amount=$total.".00";
		$words=sha1($amount.MALLID.SHARED_KEY.$transaction_id);
		$basket="";
		
		$before_discount=$total;
		
		$user_detail=$this->user_model->user_detail($user_id);
		$address_guest=$this->user_model->get_address($user_address_id);
		//pre($address_guest);
		$shipping_method_fee=$shipping_fee;
		
		if($cart_list){
			foreach($cart_list as $list2){
				$name = $list2['name'].' ('.$list2['size'].')';
				$price = $list2['price'];
				$quantity = $list2['quantity'];
				$total2 = $list2['total'];	
				$basket.= rtrim($name).','.$price.','.$quantity.','.$total2.';';
			}
			
			$discount_price=0;
			if($discount_list){
				$name = $discount_list['voucher_name'];
				$price = $discount_list['total'];
				$discount_price=$discount_list['total'];
				$quantity = 1;
				$total2 = $discount_list['total'];	
				$basket.= rtrim($name).','.-$price.','.$quantity.','.-$total2.';';

				$total=$total-$total2;
				
				
				
				$amount=$total.'.00';
				$words=sha1($amount.MALLID.SHARED_KEY.$transaction_id);
			}
		}
		
		$after_discount=$before_discount-$discount_price;
		
		$shipping_cost=$ceil_weight*$shipping_fee;
		$basket.='Shipping Cost,'.$shipping_fee.','.$ceil_weight.','.$shipping_cost.';';
		//pre($user_detail);
		if(check_session_id($session_id)==0)
		{
			$database = array(	'transidmerchant'=>$transaction_id, 
								'totalamount'=>$total,
								'words'=>$words,
								'payment_channel'=>'01',
								'session_id'=>$session_id,
								'trxstatus'=>'Requested',
								'user_address_id'=>$user_address_id,
								'user_id'=>$user_id,
								'shipping_method_fee'=>$shipping_method_fee,
								'voucher_id'=>$voucher_id,
								'subtotal'=>$before_discount,
								'discount_price'=>$discount_price,
								'recipient_name'=>$address_guest['recipient_name'],
								'shipping_address'=>$address_guest['shipping_address'],
								'phone'=>$address_guest['phone'],
								'city'=>$address_guest['city'],
								'zipcode'=>$address_guest['zipcode'],
								'email_address'=>$user_detail['email'],
								'full_name'=>$user_detail['full_name'],
								'billing_address'=>$user_detail['address'],
								'billing_phone'=>$user_detail['telephone']);		
			$this->shopping_cart_model->insert_data('doku_tb',$database);	
			$doku_id=mysql_insert_id();
			$doku=$this->shopping_cart_model->get_doku_payment_data($doku_id);
			echo $doku['transidmerchant']."|".$doku['totalamount']."|".$doku['words']."|".$doku['payment_channel']."|".$doku['session_id']."|".$basket;
		}else{
			$this->shopping_cart_model->delete_doku_session($session_id);
			$database = array(	'transidmerchant'=>$transaction_id, 
								'totalamount'=>$total,
								'words'=>$words,
								'payment_channel'=>'01',
								'session_id'=>$session_id,
								'trxstatus'=>'Requested',
								'user_address_id'=>$user_address_id,
								'user_id'=>$user_id,
								'shipping_method_fee'=>$shipping_method_fee,
								'voucher_id'=>$voucher_id,
								'subtotal'=>$before_discount,
								'discount_price'=>$discount_price,
								'recipient_name'=>$address_guest['recipient'],
								'shipping_address'=>$address_guest['shipping_address'],
								'phone'=>$address_guest['phone'],
								'city'=>$address_guest['city'],
								'zipcode'=>$address_guest['zipcode'],
								'email_address'=>$address_guest['personal_email'],
								'full_name'=>$address_guest['personal_name'],
								'billing_address'=>$address_guest['personal_billing_address'],
								'billing_phone'=>$address_guest['personal_phone']);		
			$this->shopping_cart_model->insert_data('doku_tb',$database);	
			$doku_id=mysql_insert_id();
			$doku=$this->shopping_cart_model->get_doku_payment_data($doku_id);
			echo $doku['transidmerchant']."|".$doku['totalamount']."|".$doku['words']."|".$doku['payment_channel']."|".$doku['session_id']."|".$basket;
		}
	}
	
	
	function doku_payment_guest()
	{
		
		//sebelum pindah ke halaman doku, kita create dulu item2 untuk dilempar ke halaman doku
		$session_id=session_id();
		$id=$session_id;
		$total=$this->input->post('total');
		$ceil_weight=$this->input->post('ceil_weight');
		$shipping_fee=$this->input->post('shipping_fee');
		$voucher_id=$this->input->post('voucher');
		$user_address_id='';
		
		$address_guest=$this->session->userdata('address_guest');
		
		
		$shipping_method_fee=$address_guest['shipping_cost'];
		
		$transaction_id=uniqid(); 
		$cart_list=$this->shopping_cart_model->get_shopping_cart_list2($session_id);
		
		$discount_list=$this->shopping_cart_model->get_discount_guest2($id);

		$amount=$total.".00";
		$words=sha1($amount.MALLID.SHARED_KEY.$transaction_id);
		$basket="";
		
		$before_discount=$total;
		
		if($cart_list){
			foreach($cart_list as $list2){
				$name = $list2['name'].' ('.$list2['size'].')';
				$price = $list2['price'];
				$quantity = $list2['quantity'];
				$total2 = $list2['total'];	
				$basket.= rtrim($name).','.$price.','.$quantity.','.$total2.';';
			}
			
			$discount_price=0;
			if($discount_list){
				$name = $discount_list['voucher_name'];
				$price = $discount_list['total'];
				$discount_price=$discount_list['total'];
				$quantity = 1;
				$total2 = $discount_list['total'];	
				$basket.= rtrim($name).','.-$price.','.$quantity.','.-$total2.';';

				$total=$total-$total2;
				
				
				
				$amount=$total.'.00';
				$words=sha1($amount.MALLID.SHARED_KEY.$transaction_id);
			}
		}
		
		$after_discount=$before_discount-$discount_price;
		
		$shipping_cost=$ceil_weight*$shipping_fee;
		$basket.='Shipping Cost,'.$shipping_fee.','.$ceil_weight.','.$shipping_cost.';';
		
		if(check_session_id($session_id)==0)
		{
			$database = array(	'transidmerchant'=>$transaction_id, 
								'totalamount'=>$total,
								'words'=>$words,
								'payment_channel'=>'01',
								'session_id'=>$session_id,
								'trxstatus'=>'Requested',
								'user_address_id'=>'',
								'user_id'=>'',
								'shipping_method_fee'=>$shipping_method_fee,
								'voucher_id'=>$voucher_id,
								'subtotal'=>$before_discount,
								'discount_price'=>$discount_price,
								'recipient_name'=>$address_guest['recipient'],
								'shipping_address'=>$address_guest['shipping_address'],
								'phone'=>$address_guest['phone'],
								'city'=>$address_guest['city'],
								'zipcode'=>$address_guest['zipcode'],
								'email_address'=>$address_guest['personal_email'],
								'full_name'=>$address_guest['personal_name'],
								'billing_address'=>$address_guest['personal_billing_address'],
								'billing_phone'=>$address_guest['personal_phone']								
								);	
									
			$this->shopping_cart_model->insert_data('doku_tb',$database);	
			$doku_id=mysql_insert_id();
			$doku=$this->shopping_cart_model->get_doku_payment_data($doku_id);
			echo $doku['transidmerchant']."|".$doku['totalamount']."|".$doku['words']."|".$doku['payment_channel']."|".$doku['session_id']."|".$basket;
		}else{
			$this->shopping_cart_model->delete_doku_session($session_id);
			$database = array(	'transidmerchant'=>$transaction_id, 
								'totalamount'=>$total,
								'words'=>$words,
								'payment_channel'=>'01',
								'session_id'=>$session_id,
								'trxstatus'=>'Requested',
								'user_address_id'=>'',
								'user_id'=>'',
								'shipping_method_fee'=>$shipping_method_fee,
								'voucher_id'=>$voucher_id,
								'subtotal'=>$before_discount,
								'discount_price'=>$discount_price,
								'recipient_name'=>$address_guest['recipient'],
								'shipping_address'=>$address_guest['shipping_address'],
								'phone'=>$address_guest['phone'],
								'city'=>$address_guest['city'],
								'zipcode'=>$address_guest['zipcode'],
								'email_address'=>$address_guest['personal_email'],
								'full_name'=>$address_guest['personal_name'],
								'billing_address'=>$address_guest['personal_billing_address'],
								'billing_phone'=>$address_guest['personal_phone']);		
			$this->shopping_cart_model->insert_data('doku_tb',$database);	
			$doku_id=mysql_insert_id();
			$doku=$this->shopping_cart_model->get_doku_payment_data($doku_id);
			echo $doku['transidmerchant']."|".$doku['totalamount']."|".$doku['words']."|".$doku['payment_channel']."|".$doku['session_id']."|".$basket;
		}
	}
	
	
	function notify()
	{		
		//url yang dipanggil oleh doku pada saat payment secara background
		$order_number = $this->input->post('TRANSIDMERCHANT');	
		if(!$order_number){
			$order_number=0;
		}
		
		$totalamount = $this->input->post('AMOUNT');	
		$words    = $this->input->post('WORDS');
		$statustype = $this->input->post('STATUSTYPE');
		$response_code = $this->input->post('RESPONSECODE');
		$approvalcode   = $this->input->post('APPROVALCODE');
		$status         = $this->input->post('RESULTMSG');
		$paymentchannel = $this->input->post('PAYMENTCHANNEL');
		$paymentcode = $this->input->post('PAYMENTCODE'); 
		$session_id = $this->input->post('SESSIONID');
		$bank_issuer = $this->input->post('BANK');
		$cardnumber = $this->input->post('MCN'); 
		$payment_date_time = $this->input->post('PAYMENTDATETIME'); 
		$verifyid = $this->input->post('VERIFYID'); 
		$verifyscore = $this->input->post('VERIFYSCORE'); 
		$verifystatus = $this->input->post('VERIFYSTATUS'); 

		$checkout=$this->shopping_cart_model->get_doku_data($order_number);
		if($checkout){
			$hasil=$checkout['transidmerchant'];
			$amount=$checkout['totalamount'];
		}else{
			$hasil="";
			$amount='';
		}
		
		if(!$hasil){
		  echo 'Stop1';
		}else{
			if($status=="SUCCESS"){
				$database = array(	'words'=>$words,
									'statustype'=>$statustype,
									'response_code'=>$response_code,
									'approvalcode'=>$approvalcode,
									'trxstatus'=>$status,
									'payment_channel'=>$paymentchannel,
									'paymentcode'=>$paymentcode,
									'session_id'=>$session_id,
									'bank_issuer'=>$bank_issuer,
									'creditcard'=>$cardnumber,
									'payment_date_time'=>$payment_date_time,
									'verifyid'=>$verifyid,
									'verifyscore'=>$verifyscore,
									'verifystatus'=>$verifystatus );	
				$where = array( 'transidmerchant'=>$order_number );	
				$result=$this->shopping_cart_model->update_data('doku_tb',$database, $where);
			} else {
				$database = array(	'trxstatus'=>'Failed'  );	
				$where = array( 'transidmerchant'=>$order_number );	
				$this->shopping_cart_model->update_data('doku_tb',$database, $where);
				$result=$this->shopping_cart_model->update_data('doku_tb',$database, $where);
			}
			echo 'Continue';
		}
	}
	
	function redirect()
	{
		//url yang dipanggil doku setelah pembayaran sukses
		$order_number = $this->input->post('TRANSIDMERCHANT');	
		$this->data['order_number'] = $order_number;	
		$this->data['purchase_amt'] = $this->input->post('AMOUNT');	
		$status_code = $this->input->post('STATUSCODE');
		$this->data['status_code'] = $status_code;
		$this->data['words'] = $this->input->post('WORDS');
		$this->data['paymentchannel'] = $this->input->post('PAYMENTCHANNEL');	
		$this->data['session_id'] = $this->input->post('SESSIONID');	
		$this->data['paymentcode'] = $this->input->post('PAYMENTCODE');	
		$redirect_url = '';
		$this->data['redirect_url'] = str_replace('&amp;', '&', $redirect_url);
		$doku=$this->shopping_cart_model->get_doku_data2($order_number);
		if($doku['response_code']=="0000" && $status_code=="0000"){
			$this->data['content'] = 'content/doku_form';
			$this->load->view('common/body', $this->data);	
		}else{
			$this->data['content'] = 'content/doku_failed';
			$this->load->view('common/body', $this->data);	
		}
	}
	
	function test_checkout(){
		$transidmerchant = '52f8d57c8f5c9';
		
		$doku=$this->shopping_cart_model->get_doku_data2($transidmerchant);
		$user_id = $doku['user_id'];
		$user_address_id = $doku['user_address_id'];
		$voucher_id = $doku['voucher_id'];
		
		$address=$this->user_model->get_address($user_address_id);
		$cart_list=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);
		$total_actual_weight=0;
		$retotal=0;
		if($cart_list)foreach($cart_list as $list){
			$total_actual_weight+=$list['actual_weight'];	
			
			$retotal+=$list['price']*$list['quantity'];
		}
		//
		$total=260000;
		$recipient_name=$address['recipient_name'];
		$shipping_address=$address['shipping_address'];
		$phone=$address['phone'];
		$city=$address['city'];
		$province=$address['province'];
		$zipcode=$address['zipcode'];
		$mobile=$address['mobile'];
		$actual_weight=$total_actual_weight;
		$ceil_weight=ceil($total_actual_weight);
		if($doku['trxstatus']=="SUCCESS")$status='1';else $status='0';
		$date=date('Y-m-d H:i:s');
		$shipping_method_fee=$doku['shipping_method_fee'];
		$shipping_cost=$ceil_weight*$shipping_method_fee;
		$total2=$total-$shipping_cost;
		$payment_type=2;
		
		
		
		
		
		
		//////get trx detail
		$before_discount=$doku['subtotal'];
		$the_discount=$doku['discount_price'];
		$after_discount=$before_discount-$the_discount;
		////
		
		
		
		
		
		
		
		
		$database = array(	'recipient_name'=>$recipient_name,
							'transidmerchant'=>$transidmerchant,
							'shipping_address'=>$shipping_address,
							'phone'=>$phone,
							'city'=>$city,
							'province'=>$province,
							'zipcode'=>$zipcode,
							'user_id'=>$user_id,
							'total'=>$before_discount,
							'discount_price'=>$the_discount,
							'status'=>$status,
							'transaction_date'=>$date,
							'mobile'=>$mobile, 
							'shipping_cost'=>$shipping_cost, 
							'shipping_method_fee'=>$shipping_method_fee,
							'payment_type'=>$payment_type,
							'actual_weight'=>$actual_weight,
							'ceil_weight'=>$ceil_weight);		
		$this->shopping_cart_model->insert_data('order_tb',$database);	
		$order_id=mysql_insert_id();
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
		$cart_list=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);
		if($cart_list)foreach($cart_list as $list){
			$price=$list['price'];
			$database = array(	'order_id'=>$order_id,
								'product_id'=>$list['product_id'], 
								'sku_id'=>$list['sku_id'],
								'user_id'=>$user_id,
								'quantity'=>$list['quantity'],
								'price'=>$price,
								'total'=>$price*$list['quantity']);		
			$this->shopping_cart_model->insert_data('order_item_tb',$database);	
		}
		
		//MASUKIN COUPON HISTORY//
		$datavoucher=$this->coupoun_model->coupoun_detail($voucher_id);
		if($datavoucher){
			//$voucher_id=$datavoucher['voucher_id'];
			//$id_order=last_order_id('order_tb')+1;
			//$total_price=$this->input->post('total_price');
			//$grand_total=$this->input->post('grand_total');
							
			//1 by percent, else by value
			//if($datavoucher['type']==1)
			//$discount_price=($datavoucher['value']*$total_price)/100;
			//else
			//$discount_price=$datavoucher['value'];
			
				
			
			//insert coupon history
			$database = array(	'coupon_id'=>$voucher_id,
								'user_id'=>$user_id, 
								'order_id'=>$order_id,
								'date_transaction'=>$date,
								'sub_total'=>$before_discount,
								'discount'=>$the_discount,
								'grand_total'=>$after_discount);	
			$this->shopping_cart_model->insert_data('coupon_history_tb',$database);	
			$this->coupoun_model->updateqty($voucher_id);
			$this->coupoun_model->update_use_spec($voucher_id);	
				
		}	
	}
	
	function do_checkout()
	{
		//dipanggil dari view content/doku_form
		$transidmerchant = $this->input->post('order_number');
		$status_code = $this->input->post('status_code');
		$session_id = $this->input->post('session_id');
		$doku=$this->shopping_cart_model->get_doku_data2($transidmerchant);
		$user_id = $doku['user_id'];
		
		
		if($user_id=="0"){
			//check out guest
			$cart_list=$this->shopping_cart_model->get_shopping_cart_list_guest2($session_id);
			
			$email=$doku['email_address'];
			$full_name=$doku['full_name'];
			$billing_phone=$doku['billing_phone'];
			$billing_address=$doku['billing_address'];
			
			$check_email=$this->user_model->get_user_by_email2($email);
			
			if(!$check_email){
				//kalau emailny belom ada
				$this->user_model->user_registration($email);
				$user_id=mysql_insert_id();
			
				$this->session->set_userdata(array('email_address'=>$email));
				//$this->user_model->update_registration_password($password,$user_id);
				
				$date=date("Y-m-d H:i:s");
				
				$data=array('full_name'=>$full_name,'telephone'=>$billing_phone,'address'=>$billing_address,'activated_date'=>$date,'created_date'=>$date);
				$where=array('id'=>$user_id);
				$this->user_model->update_data('user_tb', $data, $where);
				
				
				$status=1;
				$this->user_model->update_user_status($user_id,$status);
			}
			else{
				$user_id=$check_email['id'];
					
				$cart_list=$this->shopping_cart_model->get_shopping_cart_list_guest2($session_id);
			}
			$_SESSION['guest_checkout']=1;
		}
		else{
			$address=$this->user_model->get_address($user_address_id);
			$cart_list=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);
		}
		

		$recipient_name=$doku['recipient_name'];
		$shipping_address=$doku['shipping_address'];
		$phone=$doku['phone'];
		$city=$doku['city'];
		$province='';
		$zipcode=$doku['zipcode'];
		$mobile='';
		$user_address_id = $doku['user_address_id'];
		$voucher_id = $doku['voucher_id'];
		$total_actual_weight=0;
		$retotal=0;
		if($cart_list)foreach($cart_list as $list){
			$total_actual_weight+=$list['actual_weight'];	
			
			$retotal+=$list['price']*$list['quantity'];
		}
		//
		$total=$this->input->post('purchase_amt');
		
		$actual_weight=$total_actual_weight;
		$ceil_weight=ceil($total_actual_weight);
		if($doku['trxstatus']=="SUCCESS")$status='1';else $status='0';
		$date=date('Y-m-d H:i:s');
		$shipping_method_fee=$doku['shipping_method_fee'];
		$shipping_cost=$ceil_weight*$shipping_method_fee;
		$total2=$total-$shipping_cost;
		$payment_type=2;
		
		
		
		
		
		
		//////get trx detail
		$before_discount=$doku['subtotal'];//this is after shipping cost
		$the_discount=$doku['discount_price'];
		$after_discount=$before_discount-$the_discount;
		////
		
		
		
		
		
		
		
		
		$database = array(	'recipient_name'=>$recipient_name,
							'transidmerchant'=>$transidmerchant,
							'shipping_address'=>$shipping_address,
							'phone'=>$phone,
							'city'=>$city,
							'province'=>$province,
							'zipcode'=>$zipcode,
							'user_id'=>$user_id,
							'total'=>$before_discount,
							'discount_price'=>$the_discount,
							'status'=>$status,
							'transaction_date'=>$date,
							'mobile'=>$mobile, 
							'shipping_cost'=>$shipping_cost, 
							'shipping_method_fee'=>$shipping_method_fee,
							'payment_type'=>$payment_type,
							'actual_weight'=>$actual_weight,
							'ceil_weight'=>$ceil_weight);		
		$this->shopping_cart_model->insert_data('order_tb',$database);	
		$order_id=mysql_insert_id();
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
		//$cart_list=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);
		if($cart_list)foreach($cart_list as $list){
			$price=$list['price'];
			$database = array(	'order_id'=>$order_id,
								'product_id'=>$list['product_id'], 
								'sku_id'=>$list['sku_id'],
								'user_id'=>$user_id,
								'quantity'=>$list['quantity'],
								'price'=>$price,
								'total'=>$price*$list['quantity']);		
			$this->shopping_cart_model->insert_data('order_item_tb',$database);	
		}
		
		
		$datavoucher=$this->coupoun_model->coupoun_detail($voucher_id);
		if($datavoucher){
			//$voucher_id=$datavoucher['voucher_id'];
			//$id_order=last_order_id('order_tb')+1;
			//$total_price=$this->input->post('total_price');
			//$grand_total=$this->input->post('grand_total');
							
			//1 by percent, else by value
			//if($datavoucher['type']==1)
			//$discount_price=($datavoucher['value']*$total_price)/100;
			//else
			//$discount_price=$datavoucher['value'];
			
			//update total by discount
			//$new_total=$retotal-$discount_price+$shipping_cost;
			//$datass=array('total'=>$new_total,'discount_price'=>$discount_price);
			//$wheress=array('id'=>$order_id);
			//$this->shopping_cart_model->update_data('order_tb', $datass, $wheress);
			
			
			//insert coupon history
			$database = array(	'coupon_id'=>$voucher_id,
								'user_id'=>$user_id, 
								'order_id'=>$order_id,
								'date_transaction'=>$date,
								'sub_total'=>$before_discount,
								'discount'=>$the_discount,
								'grand_total'=>$after_discount);
			$this->shopping_cart_model->insert_data('coupon_history_tb',$database);	
			$this->coupoun_model->updateqty($voucher_id);
			$this->coupoun_model->update_use_spec($voucher_id);	
				
		}	
		//SELESAI COUPON HISTORY//
		
		$this->shopping_cart_model->delete_shopping_cart_by_user($user_id);
		$this->shopping_cart_model->delete_session_shopping_cart($session_id);
		$this->data['order']=$this->shopping_cart_model->get_order($order_id);
		$order=$this->data['order'];
		$this->data['user']=$this->user_model->user_detail($order['user_id']);
		$this->data['order_item']=$this->shopping_cart_model->get_order_item2($order['id']);
		$isi=$this->load->view('content/email_template/email_update_temp_order_details',$this->data,TRUE);
		$email=find('email',$user_id,'user_tb');
		$this->load->library('email'); 	
		$this->email->from('noreply@toriokids.com ');
		$this->email->to($email); 
		//$this->email->bcc('order@toriokids.com'); 
		
		$this->email->subject('Order Details - '.$number);
		
		$this->email->message($isi); 
		$this->email->send();
			
		/*$isi2=$this->load->view('content/email_template/email_update_temp_order_details',$this->data,TRUE);				
		$this->load->library('email'); 	
		$this->email->from('noreply@toriokids.com ');
		//$this->email->to('order@toriokids.com'); 
		$this->email->subject('Order Details - '.$number);
		
		$this->email->message($isi2); 
		$this->email->send();*/
		
		
		//untuk admin ada link donlod pdf
		$this->email->from('noreply@toriokids.com ');
		$this->email->to('order@toriokids.com');
		
		$isi_admin=$this->load->view('content/email_template/email_temp_order_details_admin',$this->data,TRUE);
		$this->email->subject('Order Details - '.$number);
		
		$this->email->message($isi_admin); 
		$this->email->send();
		
		$_SESSION['address_id']=NULL;
		$this->session->unset_userdata(array('address_guest'=>''));
		redirect('ccpayment/result');
	}
	
	function result()
	{
		/*$_SESSION['shipping_method']=NULL;
		$_SESSION['payment_type']=NULL;
		$this->data['order_id'] = $_SESSION['order_id'];
		$this->data['order_number'] = $_SESSION['order_number'];
		$_SESSION['order_id']=NULL;
		$_SESSION['order_number']=NULL;
		$this->data['content'] = 'content/cc_success';
		$this->load->view('common/body', $this->data);*/
		
		
		//pre($this->session->userdata);
		if(!isset($_SESSION['order_id']) && !isset($_SESSION['order_number']))redirect('not_found');
		$_SESSION['shipping_method']=NULL;
		$_SESSION['payment_type']=NULL;
		//$_SESSION['order_id']='38';
		//$_SESSION['order_number']='T140321125';
		$this->data['order_id'] = $_SESSION['order_id'];
		$this->data['order_number'] = $_SESSION['order_number'];
		//$_SESSION['order_id']=NULL;
		//$_SESSION['order_number']=NULL;
		
		$this->data['order_detail']=$this->user_model->get_shipping_info($this->data['order_id'] );
		
		$this->data['content'] = 'content/cc_success';
		$this->load->view('common/body', $this->data);		
	}
}