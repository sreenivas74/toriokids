<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Shopping_cart extends CI_Controller {
	function Shopping_cart(){
		parent::__construct();
		$this->load->model('shopping_cart_model');
		$this->load->model('product_model');
		$this->load->model('user_model');
		$this->load->model('jne_model');
		$this->load->model('order_model');
		$this->load->model('discount_model');
		$this->load->model('coupoun_model');
		$this->data['page_title']="My Shopping Cart";
		
		if($this->session->userdata('user_logged_in')==true){
			$user_id=$this->session->userdata('user_id');
			$cart_list=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);	
		}
		else{
			$session_id=session_id();
			$cart_list=$this->shopping_cart_model->get_shopping_cart_list2($session_id);	
		}
		$check_sale = 0;
		
		if($cart_list)foreach($cart_list as $cartsss){
			$id=$cartsss['id'];
			$qty=$cartsss['quantity'];			
			$price=$cartsss['sell_price'];
			$actual_weight=$cartsss['weight'];
			$msrp=$cartsss['msrp'];
			$sale_id = $cartsss['sale_id'];
			
			if(!$this->data['schedule_sale']) $price=$msrp;
			
			if($msrp>$price && $this->data['schedule_sale'])$discount=1;
			else $discount=0;
			
			if($sale_id==0)
			{
				if($qty>0){			
					$database = array(	'actual_weight'=>$actual_weight*$qty,
										'ceil_weight'=>ceil($actual_weight*$qty),	
										'quantity'=>$qty,
										'price'=>$price,
										'msrp_price'=>$msrp,
										'discount'=>$discount,
										'total'=>$qty*$price);	
					$where = array( 'id'=>$id );	
					$this->shopping_cart_model->update_data('shopping_cart_tb',$database, $where);
				}
				else{
						$this->shopping_cart_model->remove_shopping_cart($id);				
				}
			}
			else
			{
				$time = date('Y-m-d H:i:s');
				$check = $this->sale_model->check_promo($sale_id, $time);
				if(!$check){
					if($qty>0){			
						$database = array(	'actual_weight'=>$actual_weight*$qty,
											'ceil_weight'=>ceil($actual_weight*$qty),	
											'quantity'=>$qty,
											'msrp_price'=>$msrp,
											'price'=>$price,
											'discount'=>$discount,
											'total'=>$qty*$price,
											'sale_id'=>0);	
						$where = array( 'id'=>$id );	
						$this->shopping_cart_model->update_data('shopping_cart_tb',$database, $where);
					}
					else{
						$this->shopping_cart_model->remove_shopping_cart($id);				
					}
					
					$check_sale++;
				}
			}
		}
		
		$this->data['check_sale']=$check_sale;
	}
	
	function index(){
		$_SESSION['order_id']=$_SESSION['order_number']=NULL;
		if($this->session->userdata('user_logged_in')==true){
			$user_id=$this->session->userdata('user_id');
			$cart_list=$this->data['shopping_cart']=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);	
		}
		else{
			$session_id=session_id();
			$cart_list=$this->data['shopping_cart']=$this->shopping_cart_model->get_shopping_cart_list2($session_id);
		}
		
		$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');

		$this->data['user']=$this->user_model->user_detail($user_id);
		
		//delete existing coupon
		$this->coupoun_model->delete_cou_sho($user_id);	
		
		$data2 = $this->shopping_cart_model->get_discount_user($user_id);	

		$this->data['voucher_list']=$data10000=$this->shopping_cart_model->get_discount_user($user_id);	

		//pre($data10000);

		//torio stamps//
		
		$token=STAMPS_TOKEN;
		$merchant=STAMPS_MERCHANT;
		$user_email=$this->session->userdata('email');
	//	pre($user_email);
		$stamps = array(
							'token'=>$token,
							'merchant'=>$merchant,
							'user_email'=>$user_email
								 );
		$data = $stamps; 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://stamps.co.id/api/rewards/?merchant='.$data['merchant'].'&token='.$data['token'].'&user_email='.$data['user_email'].'');                   
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,  CURLOPT_HTTPHEADER,  array(
			'Content-Type: application/json')
			);
		$result  =  curl_exec($ch);  
		
		$zz=json_decode($result,true);
		$this->data['list_reward']=$zz;
		
		////////////////
		///////////DATA TORIO STAMPS//
		$stamps_rewards=$this->input->post('stamps_rewards');
		$detailenc=$this->input->post('detail_'.$stamps_rewards);
		$detaildec=base64_decode($detailenc);
		$detail=json_decode($detaildec,true);		
		//pre($detail);
		$this->data['get_discount_stamps']=$data20=$this->coupoun_model->stamps_list($user_id);
		
		if($stamps_rewards && !$data20){
			
			if($detail['extra_data']!=NULL){
			$harga=$detail['extra_data']['value'];
				if($detail['extra_data']['type']=='discount'){
					$totaldiskon=($data3['totalsemua']*$detail['extra_data']['value'])/100;
				}
			}else{
			$harga=$detail['price'];
			$totaldiskon=$harga;
			}
				//if($detail['extra_data']!="")
				
				//}else{
		//			$totaldiskon=$detail['price'];
			//	}
				$database = array(	
									'user_id'=>$user_id,
									'stamps_id'=>$detail['id'],
									'type'=>2,
									'quantity'=>1,
									'price'=>$harga,			
									'total'=>$totaldiskon,
									'created_date'=>$date  );	
				$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);	
				
		redirect('shopping_cart/shipping');
		}
		
		$data200=$this->coupoun_model->stamps_list($user_id);

		$this->data['stamps_list_real']=$detail;	
	
		$this->data['get_discount_stamps']=$this->coupoun_model->stamps_list($user_id);
		/////////////////////////////	
		
		///////MEMBERSHIP STAMPS////

	//	pre($user_email);
		$stamps_member = array(
							'token'=>$token,
							'merchant'=>$merchant,
							'user_email'=>$user_email
								 );
		$data500 = $stamps_member; 
		$che= curl_init();
		curl_setopt($che, CURLOPT_URL, 'https://stamps.co.id/api/memberships/status?&token='.$data500['token'].'&user_email='.$data500['user_email'].'&merchant='.$data500['merchant']);                
		curl_setopt($che, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($che, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($che,  CURLOPT_HTTPHEADER,  array(
			'Content-Type: application/json')
			);
		$resulte  =  curl_exec($che);  
		
		$zze=json_decode($resulte,true);
		
		$this->data['membership_stamps']=$d0000ata=$zze;
		
		
		///////////////////////////
		$this->data['coupon_active'] = $this->coupoun_model->check_active_coupon();
		
		$this->data['city']=$this->jne_model->get_jne_city_data();	
		if($this->session->userdata('user_logged_in'))	
		$this->data['content'] = 'content/shopping_cart';
		else
		$this->data['content'] = 'content/shopping_cart_guest';
		
		$this->load->view('common/body', $this->data);	
	}
	
	function check_stock_cart(){
		if($this->session->userdata('user_logged_in')==true){
			$user_id=$this->session->userdata('user_id');
			$shopping_cart=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);	
		}
		else{
			$session_id=session_id();
			$shopping_cart=$this->shopping_cart_model->get_shopping_cart_list2($session_id);
		}

		$check = 0; $arr_product=array();
		foreach($shopping_cart as $list){
			$sku_id = $list['sku_id'];
			if($list['sale_id']!=0){
				$stock = find('stock', $sku_id, 'sku_tb');
				if($stock==$list['quantity'] || $stock>$list['quantity'])
				{
					//do nothing
				}
				else
				{
					//one or more stock unavailable
					array_push($arr_product, $list['id']);
					$check++;
				}
			}
		}
	
		echo json_encode(array('check'=>$check, 'product_id'=>$arr_product));
	}
	
	function check_current_stock(){
		$cart_id = $this->input->post('id');
		$qty = $this->input->post('qty');
		$sku_id = find('sku_id',$cart_id, 'shopping_cart_tb');
		$sale_id = find('sale_id', $cart_id, 'shopping_cart_tb');
		$check = 0;
		
		if($sale_id!=0){
			$stock = find('stock', $sku_id, 'sku_tb');
			
			if($qty<=$stock){
			
			}else{
				$check = 1; //quantity overload than stock
			}
		}
		
		echo json_encode(array('check'=>$check));
	}
	
	function add_stamps(){
		$user_id=$this->session->userdata('user_id');
		$data3 =$this->shopping_cart_model->get_total_value($user_id);$date=date('Y-m-d H:i:s');
		//torio stamps//
		
		$token=STAMPS_TOKEN;
		$merchant=STAMPS_MERCHANT;
		$user_email=$this->session->userdata('email');
	//	pre($user_email);
		$stamps = array(
							'token'=>$token,
							'merchant'=>$merchant,
							'user_email'=>$user_email
								 );
		$data = $stamps; 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://stamps.co.id/api/rewards/?merchant='.$data['merchant'].'&token='.$data['token'].'&user_email='.$data['user_email'].'');                   
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,  CURLOPT_HTTPHEADER,  array(
			'Content-Type: application/json')
			);
		$result  =  curl_exec($ch);  
		
		$zz=json_decode($result,true);
		$this->data['list_reward']=$zz;
		
		////////////////
		///////////DATA TORIO STAMPS//
		$stamps_rewards=$this->input->post('stamps_rewards');
		$detailenc=$this->input->post('detail_'.$stamps_rewards);
		$detaildec=base64_decode($detailenc);
		$detail=json_decode($detaildec,true);		
		//pre($detail);		
		//pre($detail);
		$this->data['get_discount_stamps']=$data20=$this->coupoun_model->stamps_list($user_id);
		
		if($stamps_rewards && !$data20){
			
			if($detail['extra_data']!=NULL){
			$harga=$detail['extra_data']['value'];
				if($detail['extra_data']['type']=='discount'){
					$totaldiskon=$detail['extra_data']['value'];
				}
			}else{
			$harga=$detail['price'];
			$totaldiskon=$harga;
			}
				//if($detail['extra_data']!="")
				
				//}else{
		//			$totaldiskon=$detail['price'];
			//	}
				$database = array(	
									'user_id'=>$user_id,
									'stamps_id'=>$detail['id'],
									'type'=>2,
									'quantity'=>1,
									'price'=>$harga,			
									'total'=>$totaldiskon,
									'created_date'=>$date  );	
				$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);	
				
				
				
				
				if($this->session->userdata('user_logged_in')==true){
					$user_id=$this->session->userdata('user_id');
					$cart_list=$this->data['shopping_cart']=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);	
				}
				else{
					$session_id=session_id();
					$cart_list=$this->data['shopping_cart']=$this->shopping_cart_model->get_shopping_cart_list2($session_id);	
				}
				
				$date=date('Y-m-d H:i:s');
				$user_id=$this->session->userdata('user_id');
		
				$this->data['user']=$this->user_model->user_detail($user_id);
				$this->data['voucher_list']= $this->shopping_cart_model->get_discount_user($user_id);		
				$this->data['get_discount_stamps']=$this->coupoun_model->stamps_list($user_id);					
				$discount_content=$this->load->view('content/ajax/grand_total_table',$this->data,true);
				
				echo json_encode(array('status'=>1,'msg'=>'Stamps applied','content'=>$discount_content));exit();
		}
		else{
			
			echo json_encode(array('status'=>0,'msg'=>'a'));exit();
		}
	}
	
	/* old coupon module from frans
	function add_coupon(){
		$coupoun=$this->input->post('coupoun');
		$user_id=$this->session->userdata('user_id');

		$this->data['user']=$this->user_model->user_detail($user_id);
		if(empty($_POST)){
			$this->coupoun_model->delete_cou_sho($user_id);		
		}
		
		$this->data['voucher_list']= $data2 = $this->shopping_cart_model->get_discount_user($user_id);	
		
		$data5=$this->coupoun_model->get_voucher_type($coupoun);
		
		$data="";$_SESSION['coupon_id']=0;
		if($data5){
			$_SESSION['coupon_id']=$data5['id'];
		
			if($data5['type_used']==1){
				$this->data['coupoun_diskon']=$data =$this->coupoun_model->get_voucher_all($coupoun);
			}else{
				$this->data['coupoun_diskon']=$data =$this->coupoun_model->get_voucher_list($coupoun,$user_id);
			}
		}
		
		$data3 =$this->shopping_cart_model->get_total_value($user_id);
		
		#if(!$data){
			
		#	echo json_encode(array('status'=>0,'msg'=>'Invalids coupon code'));
		#}
		
		if($_POST && !$data){
			//$_SESSION['coupon_error'] = 'Invalid Coupon Code';
			//$this->session->set_flashdata('error_coupon','Invalid Coupon Code');
			//echo json_encode(array('status'=>0,'msg'=>'Voucher tidak dapat digabungkan dengan promo lain. Hubungi order@toriokids.comuntuk informasi penggunaan voucher'));exit();
			echo json_encode(array('status'=>0,'msg'=>'Invalid coupon code'));exit();
		}
		
		if($data){
			if(!$data2){
				if($data3['totalsemua']>$data['minimum_sub']){	
					if(!empty($coupoun) && $data['code_voucher']==$coupoun  ){
						$date=date('Y-m-d H:i:s');$user_id=$this->session->userdata('user_id');
						
						if($data['type']==1 && $data3['totalsemua']<$data['maximum_sub']){
							$aaa=$data3['totalsemua'];$bbb=$data['value'];$totaldiskon=($aaa*$bbb)/100;
						}
						else if($data['type']==2 && $data3['totalsemua']<$data['maximum_sub']){
							$totaldiskon=$data['value'];
						}
						else if($data['type']==1 && $data3['totalsemua']>$data['maximum_sub']){
							$aaa=$data['maximum_sub'];$bbb=$data['value'];$totaldiskon=($aaa*$bbb)/100;
						}
						else if($data['type']==2 && $data3['totalsemua']>$data['maximum_sub']){
							$totaldiskon=$data['value'];
						}
						
						$database = array('user_id'=>$user_id,'voucher_id'=>$data['id'],'type'=>2,
						'quantity'=>1,'price'=>$data['value'],'total'=>$totaldiskon,'created_date'=>$date);	
						$coupoun_id=$data['id'];
						
						//if success
						//redirect('shopping_cart/shipping');
						//echo "E";
						
						
						if($this->session->userdata('user_logged_in')==true){
							$user_id=$this->session->userdata('user_id');
							$cart_list=$this->data['shopping_cart']=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);	
						}
						else{
							$session_id=session_id();
							$cart_list=$this->data['shopping_cart']=$this->shopping_cart_model->get_shopping_cart_list2($session_id);	
						}
						
						$date=date('Y-m-d H:i:s');
						$user_id=$this->session->userdata('user_id');
				
						//sebelum dipindahin ke bawah
						#$this->data['user']=$this->user_model->user_detail($user_id);
						#$this->data['voucher_list']= $this->shopping_cart_model->get_discount_user($user_id);
							
						#$this->data['get_discount_stamps']=$this->coupoun_model->stamps_list($user_id);					
						#$discount_content=$this->load->view('content/ajax/grand_total_table',$this->data,true);
						
						
						if($user_id){
							$check_coupon_udahdipakai=check_coupon_email($user_id,$data5['id']);
							if($check_coupon_udahdipakai==NULL){
								$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);	
								
								//delete this if necessary	
								$this->data['user']=$this->user_model->user_detail($user_id);
								$this->data['voucher_list']= $this->shopping_cart_model->get_discount_user($user_id);
								$this->data['get_discount_stamps']=$this->coupoun_model->stamps_list($user_id);					
								$discount_content=$this->load->view('content/ajax/grand_total_table',$this->data,true);
								//////////////////////////
								
								echo json_encode(array('status'=>1,'msg'=>'Coupon applied','content'=>$discount_content,'discount'=>$totaldiskon));exit();
							}else{
								
							echo json_encode(array('status'=>0,'msg'=>"you already used a coupon"));
							exit();
							
							}
						}else{
								$discount_content='';
								echo json_encode(array('status'=>1,'msg'=>'Coupon applied','content'=>$discount_content));exit();
						
						
						}
					}
					else{ 
						//failed
						//redirect('shopping_cart/shipping');	
						echo json_encode(array('status'=>0,'msg'=>'Coupon unavailable'));exit();
					}
				}
				else echo json_encode(array('status'=>0,'msg'=>'This coupon is only valid when the total non-discounted items is more than IDR '.money2($data['minimum_sub'])));exit();
			}else echo json_encode(array('status'=>0,'msg'=>"Coupon already applied"));
		}else echo json_encode(array('status'=>0,'msg'=>"Invalid coupon code"));
	}
	*/
	function add_coupon(){
		$coupoun=$this->input->post('coupoun');
		$user_id=$this->session->userdata('user_id');

		$this->data['user']=$this->user_model->user_detail($user_id);
		if(empty($_POST)){
			$this->coupoun_model->delete_cou_sho($user_id);		
		}
		
		$this->data['voucher_list']= $data2 = $this->shopping_cart_model->get_discount_user($user_id);	
		
		$data5=$this->coupoun_model->get_voucher_type($coupoun);
		
		$data="";$_SESSION['coupon_id']=0;
		if($data5){
			$_SESSION['coupon_id']=$data5['id'];
		
			if($data5['type_used']==1){
				$this->data['coupoun_diskon']=$data =$this->coupoun_model->get_voucher_all($coupoun);
			}else{
				$this->data['coupoun_diskon']=$data =$this->coupoun_model->get_voucher_list($coupoun,$user_id);
			}
		}
		
		$data3 =$this->shopping_cart_model->get_total_value($user_id);
		
		//for new coupon module
		$total_cart_value = $this->shopping_cart_model->get_total_cart_value($user_id);
		
		if($_POST && !$data){
			//$_SESSION['coupon_error'] = 'Invalid Coupon Code';
		//	$this->session->set_flashdata('error_coupon','Invalid Coupon Code');
			echo json_encode(array('status'=>0,'msg'=>'Invalid coupon code'));exit();
		}
		
		if($data){
			if(!$data2){
				if($total_cart_value['total']>$data['minimum_sub']){	
					if(!empty($coupoun) && $data['code_voucher']==$coupoun  ){
						$date=date('Y-m-d H:i:s');$user_id=$this->session->userdata('user_id');
						
						//new coupon module (no non-discounted items, ALL)
						if($data['type']==1){
							if($total_cart_value['total']>$data['maximum_sub']) $totaldiskon=$data['maximum_sub']*$data['value']/100;
							else
							$totaldiskon=$total_cart_value['total']*$data['value']/100;
						}else if($data['type']==2){
							if($total_cart_value['total']>$data['maximum_sub']) $totaldiskon=$data['maximum_sub'];
							else
							$totaldiskon=$data['value'];
						}else{
							//do nothing
						}
						
						$database = array('user_id'=>$user_id,'voucher_id'=>$data['id'],'type'=>2,
						'quantity'=>1,'price'=>$data['value'],'total'=>$totaldiskon,'created_date'=>$date);	
						$coupoun_id=$data['id'];
						
						//if success
						//redirect('shopping_cart/shipping');
						//echo "E";
						
						
						if($this->session->userdata('user_logged_in')==true){
							$user_id=$this->session->userdata('user_id');
							$cart_list=$this->data['shopping_cart']=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);	
						}
						else{
							$session_id=session_id();
							$cart_list=$this->data['shopping_cart']=$this->shopping_cart_model->get_shopping_cart_list2($session_id);	
						}
						
						$date=date('Y-m-d H:i:s');
						$user_id=$this->session->userdata('user_id');
				
						/* //sebelum dipindahin ke bawah
						$this->data['user']=$this->user_model->user_detail($user_id);
						$this->data['voucher_list']= $this->shopping_cart_model->get_discount_user($user_id);
							
						$this->data['get_discount_stamps']=$this->coupoun_model->stamps_list($user_id);					
						$discount_content=$this->load->view('content/ajax/grand_total_table',$this->data,true);*/
						
						
						if($user_id){
							$check_coupon_udahdipakai=check_coupon_email($user_id,$data5['id']);
							if($check_coupon_udahdipakai==NULL){
								$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);	
								
								//delete this if necessary	
								$this->data['user']=$this->user_model->user_detail($user_id);
								$this->data['voucher_list']= $this->shopping_cart_model->get_discount_user($user_id);
								$this->data['get_discount_stamps']=$this->coupoun_model->stamps_list($user_id);					
								$discount_content=$this->load->view('content/ajax/grand_total_table',$this->data,true);
								//////////////////////////
								
								echo json_encode(array('status'=>1,'msg'=>'Coupon applied','content'=>$discount_content,'discount'=>$totaldiskon));exit();
							}else{
								
							echo json_encode(array('status'=>0,'msg'=>"you already used a coupon"));
							exit();
							
							}
						}else{
								$discount_content='';
								echo json_encode(array('status'=>1,'msg'=>'Coupon applied','content'=>$discount_content));exit();
						
						}
					}
					else{ 
						//failed
						//redirect('shopping_cart/shipping');	
						echo json_encode(array('status'=>0,'msg'=>'Coupon unavailable'));exit();
					}
				}
				else echo json_encode(array('status'=>0,'msg'=>'This coupon is only valid when the total is more than IDR '.money2($data['minimum_sub']).'. Hubungi order@toriokids.com untuk informasi penggunaan voucher'));exit();
			}else echo json_encode(array('status'=>0,'msg'=>"Coupon already applied"));
		}else echo json_encode(array('status'=>0,'msg'=>"Invalid coupon code"));
	}
	
	/* OLD guest coupon from frans
	function add_coupon_guest(){
//		if(!$_POST)
		$coupoun=$this->input->post('coupoun');
		$session_id=session_id();

		$this->data['voucher_list']= $data2 = $this->shopping_cart_model->get_discount_guest($session_id);	
		
		$data5=$this->coupoun_model->get_voucher_type($coupoun);
		
		$data="";$_SESSION['coupon_id']=0;
		if($data5){
			$_SESSION['coupon_id']=$data5['id'];
		
			if($data5['type_used']==1){
				$this->data['coupoun_diskon']=$data =$this->coupoun_model->get_voucher_all($coupoun);
			}else{
				//$this->data['coupoun_diskon']=$data =$this->coupoun_model->get_voucher_list($coupoun,$user_id);
				$this->data['coupoun_diskon']=$data='';
			}
		}
		
		$data3 =$this->shopping_cart_model->get_total_value_guest($session_id);
		
		if($_POST && !$data){
			//$_SESSION['coupon_error'] = 'Invalid Coupon Code';
			//$this->session->set_flashdata('error_coupon','Invalid Coupon Code');
			//echo json_encode(array('status'=>0,'msg'=>'Voucher tidak dapat digabungkan dengan promo lain. Hubungi order@toriokids.comuntuk informasi penggunaan vouchers'));exit();
			echo json_encode(array('status'=>0,'msg'=>'Invalid coupon code'));exit();
		}	
						$this->data['get_discount_stamps']='';			
		
		if($data){
			if(!$data2){
				if($data3['totalsemua']>$data['minimum_sub']){	
					if(!empty($coupoun) && $data['code_voucher']==$coupoun  ){
						$date=date('Y-m-d H:i:s');$user_id=$this->session->userdata('user_id');
						if($data['type']==1 && $data3['totalsemua']<$data['maximum_sub']){
							$aaa=$data3['totalsemua'];$bbb=$data['value'];$totaldiskon=($aaa*$bbb)/100;
						}
						else if($data['type']==2 && $data3['totalsemua']<$data['maximum_sub']){
							$totaldiskon=$data['value'];
						}
						else if($data['type']==1 && $data3['totalsemua']>$data['maximum_sub']){
							$aaa=$data['maximum_sub'];$bbb=$data['value'];$totaldiskon=($aaa*$bbb)/100;
						}
						else if($data['type']==2 && $data3['totalsemua']>$data['maximum_sub']){
							$totaldiskon=$data['value'];
						}
						$database = array('session_id'=>$session_id,'voucher_id'=>$data['id'],'type'=>2,
						'quantity'=>1,'price'=>$data['value'],'total'=>$totaldiskon,'created_date'=>$date);	
						$coupoun_id=$data['id'];
						$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);		
						//if success
						//redirect('shopping_cart/shipping');
						//echo "E";
						
						
						$cart_list=$this->data['shopping_cart']=$this->shopping_cart_model->get_shopping_cart_list2($session_id);	
						
						$this->data['voucher_list']= $data2 = $this->shopping_cart_model->get_discount_guest($session_id);	
						$date=date('Y-m-d H:i:s');
								
						$discount_content=$this->load->view('content/ajax/grand_total_table',$this->data,true);
						
						echo json_encode(array('status'=>1,'msg'=>'Coupon applied','content'=>$discount_content));exit();
					}
					else{ 
						//failed
						//redirect('shopping_cart/shipping');	
						echo json_encode(array('status'=>0,'msg'=>'Coupon unavailable'));exit();
					}
				}
				else echo json_encode(array('status'=>0,'msg'=>'This coupon is only valid when the total non-discounted items is more than IDR '.money2($data['minimum_sub']).'. Hubungi order@toriokids.com untuk informasi penggunaan voucher'));exit();
			}else echo json_encode(array('status'=>0,'msg'=>"Coupon already applied"));
		}else echo json_encode(array('status'=>0,'msg'=>"Invalid coupon code"));
		
	}*/
	
	function add_coupon_guest(){
//		if(!$_POST)
		$coupoun=$this->input->post('coupoun');
		$session_id=session_id();

		$this->data['voucher_list']= $data2 = $this->shopping_cart_model->get_discount_guest($session_id);	
		
		$data5=$this->coupoun_model->get_voucher_type($coupoun);
		
		$data="";$_SESSION['coupon_id']=0;
		if($data5){
			$_SESSION['coupon_id']=$data5['id'];
		
			if($data5['type_used']==1){
				$this->data['coupoun_diskon']=$data =$this->coupoun_model->get_voucher_all($coupoun);
			}else{
				//$this->data['coupoun_diskon']=$data =$this->coupoun_model->get_voucher_list($coupoun,$user_id);
				$this->data['coupoun_diskon']=$data='';
			}
		}
		
		#$data3 =$this->shopping_cart_model->get_total_value_guest($session_id);
		
		//for new coupon module
		$total_cart_value = $this->shopping_cart_model->get_total_cart_value_guest($session_id);
		
		if($_POST && !$data){
			//$_SESSION['coupon_error'] = 'Invalid Coupon Code';
			//$this->session->set_flashdata('error_coupon','Invalid Coupon Code');
			//echo json_encode(array('status'=>0,'msg'=>'Voucher tidak dapat digabungkan dengan promo lain. Hubungi order@toriokids.comuntuk informasi penggunaan vouchers'));exit();
			echo json_encode(array('status'=>0,'msg'=>'Invalid coupon code'));exit();
		}	
						$this->data['get_discount_stamps']='';			
		
		if($data){
			if(!$data2){
				if($total_cart_value['total']>$data['minimum_sub']){	
					if(!empty($coupoun) && $data['code_voucher']==$coupoun  ){
						$date=date('Y-m-d H:i:s');$user_id=$this->session->userdata('user_id');
						
						//new coupon module (no non-discounted items, ALL)
						if($data['type']==1){
							if($total_cart_value['total']>$data['maximum_sub']) $totaldiskon=$data['maximum_sub']*$data['value']/100;
							else
							$totaldiskon=$total_cart_value['total']*$data['value']/100;
						}else if($data['type']==2){
							if($total_cart_value['total']>$data['maximum_sub']) $totaldiskon=$data['maximum_sub'];
							else
							$totaldiskon=$data['value'];
						}else{
							//do nothing
						}
						
						$database = array('session_id'=>$session_id,'voucher_id'=>$data['id'],'type'=>2,
						'quantity'=>1,'price'=>$data['value'],'total'=>$totaldiskon,'created_date'=>$date);	
						$coupoun_id=$data['id'];
						$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);		
						//if success
						//redirect('shopping_cart/shipping');
						//echo "E";
						
						
						$cart_list=$this->data['shopping_cart']=$this->shopping_cart_model->get_shopping_cart_list2($session_id);	
						
						$this->data['voucher_list']= $data2 = $this->shopping_cart_model->get_discount_guest($session_id);	
						$date=date('Y-m-d H:i:s');
								
						$discount_content=$this->load->view('content/ajax/grand_total_table',$this->data,true);
						
						echo json_encode(array('status'=>1,'msg'=>'Coupon applied','content'=>$discount_content));exit();
					}
					else{ 
						//failed
						//redirect('shopping_cart/shipping');	
						echo json_encode(array('status'=>0,'msg'=>'Coupon unavailable'));exit();
					}
				}
				else echo json_encode(array('status'=>0,'msg'=>'This coupon is only valid when the total non-discounted items is more than IDR '.money2($data['minimum_sub']).'. Hubungi order@toriokids.com untuk informasi penggunaan voucher'));exit();
			}else echo json_encode(array('status'=>0,'msg'=>"Coupon already applied"));
		}else echo json_encode(array('status'=>0,'msg'=>"Invalid coupon code"));
		
	}
	
	function add_facebook_voucher(){
		
		$like=$this->input->post('like');
		if($like==1){
		$session_fbpost=array('fb_post'=>1);
		$this->session->set_userdata($session_fbpost);
		$coupoun='facebooklikes';
		$user_id=$this->session->userdata('user_id');

		$this->data['user']=$this->user_model->user_detail($user_id);
		if(empty($_POST)){
			$this->coupoun_model->delete_cou_sho($user_id);		
		}
		
		$this->data['voucher_list']= $data2 = $this->shopping_cart_model->get_discount_user($user_id);	
		
		$data5=$this->coupoun_model->get_voucher_type($coupoun);
		
		$data="";$_SESSION['coupon_id']=0;
		if($data5){
			$_SESSION['coupon_id']=$data5['id'];
		
			if($data5['type_used']==1){
				$this->data['coupoun_diskon']=$data =$this->coupoun_model->get_voucher_all($coupoun);
			}else{
				$this->data['coupoun_diskon']=$data =$this->coupoun_model->get_voucher_list($coupoun,$user_id);
			}
		}
		
		$data3 =$this->shopping_cart_model->get_total_value($user_id);
		
		if($_POST && !$data){
			//$_SESSION['coupon_error'] = 'Invalid Coupon Code';
		//	$this->session->set_flashdata('error_coupon','Invalid Coupon Code');
			echo json_encode(array('status'=>0,'msg'=>'Invalid coupon code'));exit();
		}
		
		if($data){
			if(!$data2){
				if($data3['totalsemua']>$data['minimum_sub']){	
					if(!empty($coupoun) && $data['code_voucher']==$coupoun  ){
						$date=date('Y-m-d H:i:s');$user_id=$this->session->userdata('user_id');
						if($data['type']==1 && $data3['totalsemua']<$data['maximum_sub']){
							$aaa=$data3['totalsemua'];$bbb=$data['value'];$totaldiskon=($aaa*$bbb)/100;
						}
						else if($data['type']==2 && $data3['totalsemua']<$data['maximum_sub']){
							$totaldiskon=$data['value'];
						}
						else if($data['type']==1 && $data3['totalsemua']>$data['maximum_sub']){
							$aaa=$data['maximum_sub'];$bbb=$data['value'];$totaldiskon=($aaa*$bbb)/100;
						}
						else if($data['type']==2 && $data3['totalsemua']>$data['maximum_sub']){
							$totaldiskon=$data['value'];
						}
						$database = array('user_id'=>$user_id,'voucher_id'=>$data['id'],'type'=>2,
						'quantity'=>1,'price'=>$data['value'],'total'=>$totaldiskon,'created_date'=>$date);	
						$coupoun_id=$data['id'];
						$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);		
						//if success
						//redirect('shopping_cart/shipping');
						//echo "E";
						
						
						if($this->session->userdata('user_logged_in')==true){
							$user_id=$this->session->userdata('user_id');
							$cart_list=$this->data['shopping_cart']=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);	
						}
						else{
							$session_id=session_id();
							$cart_list=$this->data['shopping_cart']=$this->shopping_cart_model->get_shopping_cart_list2($session_id);	
						}
						
						$date=date('Y-m-d H:i:s');
						$user_id=$this->session->userdata('user_id');
				
						$this->data['user']=$this->user_model->user_detail($user_id);
						$this->data['voucher_list']= $this->shopping_cart_model->get_discount_user($user_id);		
						$this->data['get_discount_stamps']=$this->coupoun_model->stamps_list($user_id);					
						$discount_content=$this->load->view('content/ajax/grand_total_table',$this->data,true);
						
						echo json_encode(array('status'=>1,'msg'=>'Coupon applied','content'=>$discount_content));exit();
						
					}
					else{ 
						//failed
						//redirect('shopping_cart/shipping');	
						echo json_encode(array('status'=>0,'msg'=>'Coupon unavailable'));exit();
					}
				}
				else echo json_encode(array('status'=>0,'msg'=>'Total must be greater than IDR '.money2($data['minimum_sub'])));exit();
			}else echo json_encode(array('status'=>0,'msg'=>"Coupon already applied"));
		}else echo json_encode(array('status'=>0,'msg'=>"Invalid coupon code"));
		
		}else{
		echo ' ga bisa akses langsung';
		}
	}
	
	
	
	
	function add_facebook_voucher_guest(){
		
		$like=$this->input->post('like');
		if($like==1){
		$session_fbpost=array('fb_post'=>1);
		$this->session->set_userdata($session_fbpost);
		$coupoun='facebooklikes';
		
		$session_id=session_id();

		
		$this->data['voucher_list']= $data2 = $this->shopping_cart_model->get_discount_guest($session_id);	
		
		$data5=$this->coupoun_model->get_voucher_type($coupoun);
		
		$data="";$_SESSION['coupon_id']=0;
		if($data5){
			$_SESSION['coupon_id']=$data5['id'];
		
			if($data5['type_used']==1){
				$this->data['coupoun_diskon']=$data =$this->coupoun_model->get_voucher_all($coupoun);
			}else{
				//$this->data['coupoun_diskon']=$data =$this->coupoun_model->get_voucher_list($coupoun,$user_id);
				$this->data['coupoun_diskon']=$data='';
			}
		}
		
		$data3 =$this->shopping_cart_model->get_total_value_guest($session_id);
		
		if($_POST && !$data){
			//$_SESSION['coupon_error'] = 'Invalid Coupon Code';
		//	$this->session->set_flashdata('error_coupon','Invalid Coupon Code');
			echo json_encode(array('status'=>0,'msg'=>'Invalid coupon code'));exit();
		}	
						$this->data['get_discount_stamps']='';			
		
		if($data){
			if(!$data2){
				if($data3['totalsemua']>$data['minimum_sub']){	
					if(!empty($coupoun) && $data['code_voucher']==$coupoun  ){
						$date=date('Y-m-d H:i:s');$user_id=$this->session->userdata('user_id');
						if($data['type']==1 && $data3['totalsemua']<$data['maximum_sub']){
							$aaa=$data3['totalsemua'];$bbb=$data['value'];$totaldiskon=($aaa*$bbb)/100;
						}
						else if($data['type']==2 && $data3['totalsemua']<$data['maximum_sub']){
							$totaldiskon=$data['value'];
						}
						else if($data['type']==1 && $data3['totalsemua']>$data['maximum_sub']){
							$aaa=$data['maximum_sub'];$bbb=$data['value'];$totaldiskon=($aaa*$bbb)/100;
						}
						else if($data['type']==2 && $data3['totalsemua']>$data['maximum_sub']){
							$totaldiskon=$data['value'];
						}
						$database = array('session_id'=>$session_id,'voucher_id'=>$data['id'],'type'=>2,
						'quantity'=>1,'price'=>$data['value'],'total'=>$totaldiskon,'created_date'=>$date);	
						$coupoun_id=$data['id'];
						$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);		
						//if success
						//redirect('shopping_cart/shipping');
						//echo "E";
						
						
						$cart_list=$this->data['shopping_cart']=$this->shopping_cart_model->get_shopping_cart_list2($session_id);	
						
						
						$this->data['voucher_list']= $data2 = $this->shopping_cart_model->get_discount_guest($session_id);	
						$date=date('Y-m-d H:i:s');
								
						$discount_content=$this->load->view('content/ajax/grand_total_table',$this->data,true);
						
						echo json_encode(array('status'=>1,'msg'=>'Coupon applied','content'=>$discount_content));exit();
					}
					else{ 
						//failed
						//redirect('shopping_cart/shipping');	
						echo json_encode(array('status'=>0,'msg'=>'Coupon unavailable'));exit();
					}
				}
				else echo json_encode(array('status'=>0,'msg'=>'Total must be greater than IDR '.money2($data['minimum_sub'])));exit();
			}else echo json_encode(array('status'=>0,'msg'=>"Coupon already applied"));
		}else echo json_encode(array('status'=>0,'msg'=>"Invalid coupon code"));
		
		}else{
		echo ' Direct access forbidden';
		}
	}
	
	function delete_coupon(){
		$user_id=$this->session->userdata('user_id');
		$this->coupoun_model->delete_cou_sho($user_id);	

		$this->data['user']=$this->user_model->user_detail($user_id);
		$this->data['voucher_list']= $this->shopping_cart_model->get_discount_user($user_id);		
		$this->data['get_discount_stamps']=$this->coupoun_model->stamps_list($user_id);
		
		$this->data['total_harga_diskon'] = $this->shopping_cart_model->get_total_value($user_id);
	
		#$this->data['total_harga_diskon'] = $total_diskon;
						
		$discount_content=$this->load->view('content/ajax/grand_total_table',$this->data,true);
		
		echo json_encode(array('status'=>1,'msg'=>'Coupon deleted','content'=>$discount_content));
	}
	
	
	function deletevoucher()
	{
		
		$user_id=$this->session->userdata('user_id');
		$this->coupoun_model->delete_cou_sho($user_id);		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function deletevoucher_shop()
	{
		
		$user_id=$this->session->userdata('user_id');
		$this->coupoun_model->delete_cou_sho($user_id);		
		redirect('shopping_cart/checkout_summary');
	}
	
	function default_address()
	{
		$user_id=$this->session->userdata('user_id');
		$recipient_name = $this->session->userdata('name');
		$dob=$this->input->post('dob');
		$address=$this->input->post('address'); 
		$city=$this->input->post('select_city'); 
		$postcode=$this->input->post('postcode');
		$telephone=$this->input->post('telephone');
		//$mobile=$this->input->post('mobile');
		$mobile='';
		$database = array(	'id'=>$user_id, 
							'date_of_birth'=>date('Y-m-d',strtotime($dob)),
							'mobile'=>$mobile,
							'address'=>$address,
							'telephone'=>$telephone,
							'city'=>$city,
							'postcode'=>$postcode  );		
		$where = array( 'id'=>$user_id);	
		$this->shopping_cart_model->update_data('user_tb',$database, $where);
		$default_address=is_exist_default_address($user_id);
		if($default_address)
		{
			$default_address=1;
			$database2 = array(	'user_id'=>$user_id, 
								'recipient_name'=>$recipient_name, 
								'shipping_address'=>$address,
								'phone'=>$telephone,
								'mobile'=>$mobile,
								'city'=>$city,
								'zipcode'=>$postcode,
								'default_address'=>$default_address   );		
			$where = array( 'user_id'=>$user_id);	
			$this->shopping_cart_model->update_data('user_address_tb',$database2, $where);
		}else{
			$default_address=1;
			$database3 = array(	'user_id'=>$user_id, 
								'recipient_name'=>$recipient_name, 
								'shipping_address'=>$address,
								'phone'=>$telephone,
								'mobile'=>$mobile,
								'city'=>$city,
								'zipcode'=>$postcode,
								'default_address'=>$default_address  );		
			$this->shopping_cart_model->insert_data('user_address_tb',$database3);	
		}
		redirect($_SERVER['HTTP_REFERER']);
	}	
		
	function add_to_cart()
	{
		$product_id=$this->input->post('product_id');
		$qty=$this->input->post('quantity');
		$aw=$this->input->post('actual_weight');
		$actual_weight=$aw*$qty;
		$ceil_weight = ceil($actual_weight);
		$price=$this->input->post('price');
		$sku_id=$this->input->post('sku_id');
		$discount = $this->input->post('discount');
		$msrp = $this->input->post('msrp');
		$sale_id = $this->input->post('sale_id');
		$date=date('Y-m-d H:i:s');
		
		$total=$qty*$price;
		
		//if guest
		if($this->session->userdata('user_logged_in')==false){
			$session_id=session_id();
			$cek=$this->shopping_cart_model->check_shopping_cart_guest($product_id,$sku_id,$session_id,$price);
			if($cek){
				//update shopping cart
				$actual_weight+=$cek['actual_weight'];
				$ceil_weight = ceil($actual_weight);
				$qty+=$cek['quantity'];
				$total+=$cek['total'];
				$database = array(	'actual_weight'=>$actual_weight,
									'ceil_weight'=>$ceil_weight,
									'quantity'=>$qty,
									'msrp_price' => $msrp,
									'discount' => $discount,
									'type'=>1,
									'total'=>$total,
									'sale_id'=>$sale_id);	
				$where = array( 'product_id'=>$product_id,
								'sku_id'=>$sku_id,
								'session_id'=>$session_id,
								'price'=>$price);	
				$this->shopping_cart_model->update_data('shopping_cart_tb',$database, $where);
			//	redirect($_SERVER['HTTP_REFERER']);
			}
			else{
				//create new shopping cart
				$database = array('product_id'=>$product_id, 
									'sku_id'=>$sku_id,
									'session_id'=>$session_id,
									'type'=>1,
									'quantity'=>$qty,
									'price'=>$price,
									'actual_weight'=>$actual_weight,
									'ceil_weight'=>$ceil_weight,
									'total'=>$total,
									'msrp_price' => $msrp,
									'discount' => $discount,
									'created_date'=>$date,
									'sale_id'=>$sale_id);	
									
				$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);	
				//redirect($_SERVER['HTTP_REFERER']);
			}
			
			$sku_stock = find('stock', $sku_id, 'sku_tb');
			$cart_list=$this->shopping_cart_model->check_quantity_cart2($session_id, $sku_id);
			
			$cart_qty = $cart_list['quantity'];
			
			$cart = $this->shopping_cart_model->get_shopping_cart_list2($session_id);
			
			$price=0;
			$qty=0;
			$price_total_diskon=0;
			for($i=0; $i<count($cart);$i++){
				if($cart[$i]['sale_id']==0){
					if($this->data['schedule_sale']){
						$price=$price+$cart[$i]['sell_price']*$cart[$i]['quantity'];
					}
					else
					{
						$price=$price+$cart[$i]['msrp']*$cart[$i]['quantity'];
					}
				}else{
					$price=$price+$cart[$i]['price']*$cart[$i]['quantity'];
				}
				$qty=$qty+$cart[$i]['quantity'];
				
				if($cart[$i]['discount'] == 0)
				{
					$price_total_diskon += $cart[$i]['sell_price']*$cart[$i]['quantity'];
				}
			}
			
			echo json_encode(array('qty'=>$qty,'price'=>money($price), 'stock'=>$sku_stock, 'cart_qty'=>$cart_qty));
		}else{
			//user
			$user_id=$this->session->userdata('user_id');
			$cek=$this->shopping_cart_model->check_shopping_cart_user($product_id,$sku_id,$user_id,$price);
			if($cek){
				//update shopping cart
				$actual_weight+=$cek['actual_weight'];
				$ceil_weight = ceil($actual_weight);
				$qty+=$cek['quantity'];
				$total+=$cek['total'];
				$database = array(	'actual_weight'=>$actual_weight,
									'ceil_weight'=>$ceil_weight,
									'quantity'=>$qty,
									'msrp_price' => $msrp,
									'discount' => $discount,
									'type'=>1,
									'total'=>$qty*$price,
									'sale_id'=>$sale_id);	
				$where = array( 'product_id'=>$product_id,
								'sku_id'=>$sku_id,
								'user_id'=>$user_id,
								'price'=>$price);	
				$this->shopping_cart_model->update_data('shopping_cart_tb',$database, $where);
				//redirect($_SERVER['HTTP_REFERER']);
			}
			else{
				//create new shopping cart	
				$database = array(	'product_id'=>$product_id, 
									'sku_id'=>$sku_id,
									'user_id'=>$user_id,
									'type'=>1,
									'quantity'=>$qty,
									'actual_weight'=>$actual_weight,
									'ceil_weight'=>$ceil_weight,
									'price'=>$price,
									'total'=>$total,
									'discount'=>$discount,
									'msrp_price'=>$msrp,
									'created_date'=>$date,
									'sale_id'=>$sale_id);		
									
				
				$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);	
			//	redirect($_SERVER['HTTP_REFERER']);
			}
			
			$sku_stock = find('stock', $sku_id, 'sku_tb');
			$cart_list=$this->shopping_cart_model->check_quantity_cart($user_id, $sku_id);
			
			$cart_qty = $cart_list['quantity'];
			
			$cart = $this->shopping_cart_model->get_shopping_cart_list_user2($user_id);
			$price=0;
			$qty=0;
			for($i=0; $i<count($cart);$i++){
				if($cart[$i]['sale_id']==0){
					if($this->data['schedule_sale']){
						$price=$price+$cart[$i]['sell_price']*$cart[$i]['quantity'];
					}
					else
					{
						$price=$price+$cart[$i]['msrp']*$cart[$i]['quantity'];
					}
				}else{
					$price=$price+$cart[$i]['price']*$cart[$i]['quantity'];
				}
				$qty=$qty+$cart[$i]['quantity'];
			}
			
			echo json_encode(array('qty'=>$qty,'price'=>money($price), 'stock'=>$sku_stock, 'cart_qty'=>$cart_qty));
		}
	}

	function do_update()
	{
		$id=$this->input->post('id');
		$notavailable_cart=array();
		
		if($id)
		foreach($id as $id){
			$qty=$this->input->post('quantity_'.$id);
			
			$sale_id = find('sale_id', $id, 'shopping_cart_tb');
			
			if($sale_id!=0){
				$sku_id = find('sku_id', $id, 'shopping_cart_tb');
				$stock = find('stock', $sku_id, 'sku_tb');
				if($qty>$stock){
					$qty=$stock;
					array_push($notavailable_cart, $id);
				}
			}
			
			$price=$this->input->post('price_'.$id);
			$actual_weight=$this->input->post('actual_weight_'.$id);
			if($qty>0)
			{			
				$database = array(	'actual_weight'=>$actual_weight*$qty,
									'ceil_weight'=>ceil($actual_weight*$qty),	
									'quantity'=>$qty,
									'total'=>$qty*$price);	
				$where = array( 'id'=>$id );	
				$this->shopping_cart_model->update_data('shopping_cart_tb',$database, $where);
			}
			else{
					$this->shopping_cart_model->remove_shopping_cart($id);				
			}
		}
		$this->session->set_flashdata('notavailable_cart', json_encode($notavailable_cart));
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function remove_item($id)
	{			
		$session_id2=find('session_id', $id, 'shopping_cart_tb');
		$user_id2=find('user_id', $id, 'shopping_cart_tb');
		if($this->session->userdata('user_logged_in')==true){
			$user_id=$this->session->userdata('user_id');
			if($user_id!=$user_id2)redirect('not_found');
			$this->shopping_cart_model->remove_shopping_cart($id);
			redirect($_SERVER['HTTP_REFERER']);	
		}else

		{
			$session_id=session_id();
			if($session_id!=$session_id2)redirect('not_found');
			$this->shopping_cart_model->remove_shopping_cart($id);
			redirect($_SERVER['HTTP_REFERER']);	
		}
	}
	
	function clear_shopping_cart()
	{	
		if($this->session->userdata('user_logged_in')==true){
			$user_id=$this->session->userdata('user_id');
			$this->shopping_cart_model->delete_shopping_cart_by_user($user_id);	
		}else
		{
			$session_id=session_id();
			$this->shopping_cart_model->delete_session_shopping_cart($session_id);	
		}			
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function shipping()
	{
		/*if($this->session->userdata('user_logged_in')==false){
			$_SESSION['mypage'] = $_SERVER['HTTP_REFERER'];
			redirect('login');
		}else
		
			if($this->data['total_item']==0)redirect('shopping_cart');
			$this->data['content']='content/shipping_address';
			$user_id=$this->session->userdata('user_id');
			$this->data['address']=$this->user_model->get_address_by_user($user_id);
			$this->data['detail']=$this->user_model->get_address_by_user3($user_id);
			$this->data['province']=$this->jne_model->get_jne_province_data();
			$this->data['city']=$this->jne_model->get_jne_city_data();
			if($this->data['detail'] && $this->data['detail']['city']){
				$this->data['sm']=$this->jne_model->get_shipping_method($this->data['detail']['city']);
			}else $this->data['sm']="";
			$this->load->view('common/body',$this->data);
			*/
			
			
			if($this->data['total_item']==0)redirect('shopping_cart');
			if($this->session->userdata('user_logged_in')){
				$this->data['content']='content/shipping_address';
				
				$user_id=$this->session->userdata('user_id');
				$this->data['address']=$this->user_model->get_address_by_user($user_id);
				$this->data['detail']=$this->user_model->get_address_by_user3($user_id);
			
			}
			else{
				$this->data['content']='content/shipping_address_guest';
				$this->data['address']=$this->data['detail']='';
			}
			
		
			$this->data['province']=$this->jne_model->get_jne_province_data();
			$this->data['city']=$this->jne_model->get_jne_city_data();
			if($this->data['detail'] && $this->data['detail']['city']){
				//$this->data['sm']=$this->jne_model->get_shipping_method($this->data['detail']['city']);
				$this->data['sm']=api_get_city($this->data['detail']['city']);
			}else $this->data['sm']="";
			$this->load->view('common/body',$this->data);
			
	}
	
	function checkout_summary()
	{
		/*if($this->session->userdata('user_logged_in')==false)
			redirect('login');
		else
		if(!isset($_SESSION['address_id']) && !isset($_SESSION['shipping_method']))redirect('not_found');
		if($this->data['total_item']==0)redirect('shopping_cart');
		$user_id=$this->session->userdata('user_id');
		$user_address_id=$_SESSION['address_id'];
		$this->data['shipping_fee']=$_SESSION['shipping_method'];
		$this->data['shipping_cost']="";
		$this->data['discount']=0;
		$this->data['total_actual_weight']="";
		$this->data['disc']=$this->discount_model->get_discount_list();
		$this->data['user']=$this->user_model->user_detail($user_id);
		$this->data['address']=$this->user_model->get_address($user_address_id);
		$this->data['cart_list']=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);
		
		$datae =$this->shopping_cart_model->get_dis_disc($user_id);
		$coupoun="";
		if($datae){
		$coupoun=$datae['voucher_id'];
		}
		
	//echo $datae['voucher_id'];
		$this->data['voucher_list']=$data1000=$this->coupoun_model->get_voucher_id_bos($coupoun,$user_id);
		//pre($data1000);
		$this->data['stamps_list']=$this->coupoun_model->stamps_list($user_id);
	
		$this->data['content']='con976tent/confirm_order';
		$this->load->view('common/body',$this->data);*/
		
			$user_id=$this->session->userdata('user_id');
			$session_id=session_id();
		if($this->session->userdata('user_logged_in')){
			$user_address_id=$_SESSION['address_id'];
			$this->data['shipping_fee']=$_SESSION['shipping_method'];
			$this->data['shipping_cost']="";
			$this->data['discount']=0;
			$this->data['total_actual_weight']="";
			$this->data['disc']=$this->discount_model->get_discount_list();
			$this->data['user']=$this->user_model->user_detail($user_id);
			$this->data['address']=$this->user_model->get_address($user_address_id);
			$this->data['cart_list']=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);
			
			$datae =$this->shopping_cart_model->get_dis_disc($user_id);
			$coupoun="";
			if($datae){
			$coupoun=$datae['voucher_id'];
			}
			
			$this->data['voucher_list']=$data1000=$this->coupoun_model->get_voucher_id_bos($coupoun,$user_id);
			//pre($data1000);
			$this->data['stamps_list']=$this->coupoun_model->stamps_list($user_id);
		
			
			$this->data['content']='content/confirm_order';
			$this->data['cart_list']=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);
		}
		else{
			//pre($this->session->userdata);
			
			
			
        	$this->data['shipping_info']=$address_guest=$this->session->userdata('address_guest');
			$this->data['discount']=0;
			$this->data['total_actual_weight']="";
			$this->data['disc']=$this->discount_model->get_discount_list();
			
			$check_email=$this->user_model->is_not_guest($address_guest['personal_email']);
			//pre($check_email);
			
			if($check_email){
				$this->session->set_flashdata('notif','This email already registered as member, please login');
				redirect('shopping_cart/shipping');
			}
			
			$this->data['address']='';			
			
			$this->data['voucher_list']=$this->shopping_cart_model->get_discount_guest($session_id);	
			//pre($data1000);
			$this->data['stamps_list']='';
		
			
			
			$this->data['cart_list']=$this->shopping_cart_model->get_shopping_cart_list2($session_id);
			$this->data['content']='content/confirm_order_guest';
		}
		
		$cart = $this->data['cart_list']; 
		$check_sale_id = 0;
		foreach($cart as $list){
			if($list['sale_id']!=0) $check_sale_id++;
		}
		
		$this->data['check_sale_id'] = $check_sale_id;
		$this->load->view('common/body',$this->data);
	}
	
	/*function checkout_with_coupoun()
	{
		if($this->session->userdata('user_logged_in')==false)
			redirect('login');
		else
		if(!isset($_SESSION['address_id']) && !isset($_SESSION['shipping_method']))redirect('not_found');
		
		
		if($this->data['total_item']==0)redirect('shopping_cart');
		$this->load->model('coupoun_model');	
		$coupoun=$this->input->post('coupoun');
		$this->data['coupoun_diskon']=$this->coupoun_model->get_voucher_list($coupoun);	
		$user_id=$this->session->userdata('user_id');
		$user_address_id=$_SESSION['address_id'];
		$this->data['shipping_fee']=$_SESSION['shipping_method'];
		$this->data['shipping_cost']="";
		$this->data['discount']=0;
		$this->data['total_actual_weight']="";
		$this->data['disc']=$this->discount_model->get_discount_list();
		$this->data['user']=$this->user_model->user_detail($user_id);
		$this->data['address']=$this->user_model->get_address($user_address_id);
		$this->data['cart_list']=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);	
		$this->data['content']='content/confirm_order_coupoun';
		$this->load->view('common/body',$this->data);
	}*/
	
	function bank_payment_page()
	{
		if($this->session->userdata('user_logged_in')==false)
			redirect('login');
		else
		if(!isset($_SESSION['address_id']) && !isset($_SESSION['shipping_method']))redirect('not_found');
		
		if($this->data['total_item']==0)redirect('shopping_cart');
		$user_id=$this->session->userdata('user_id');
		$user_address_id=$_SESSION['address_id'];
		$_SESSION['payment_type']=1;
		$this->data['voucher_list']= $data2 = $this->shopping_cart_model->get_discount_user($user_id);
		$data3=array_shift($data2);
		$coupoun_id=$data3['id'];
		$this->data['shipping_fee']=$_SESSION['shipping_method'];
		$this->data['shipping_cost']="";
		$this->data['stamps_list']=$this->coupoun_model->stamps_list($user_id);
		$this->data['discount']=0;
		$this->data['total_actual_weight']="";
		$this->data['disc']=$this->discount_model->get_discount_list();
		
		$this->data['address']=$this->user_model->get_address($user_address_id);
		$this->data['cart_list']=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);	
		$this->data['content']='content/bank_payment';
		$this->load->view('common/body',$this->data);
	}

	function checkout_login()
	{	
		if($this->session->userdata('user_logged_in') == TRUE) redirect('home');
		$this->data['email']='';
		$this->data['content']='content/login_register';
		$this->load->view('common/body',$this->data);
	}
	
	function do_add_address()
	{
		if(!$_POST)redirect('not_found');
		$user_id=$this->session->userdata('user_id');
		$name=$this->input->post('name');
		$addr=$this->input->post('addr');
		$phone=$this->input->post('phone');
		$recipient_name=$this->input->post('recipient_name');
	
		$this->user_model->insert_shipping_address($user_id,$name,$addr,$phone,$recipient_name);
		redirect($_SERVER['HTTP_REFERER']);	
	}
		
	function load_address($id)
	{	
		if($id){
			$list_address=$this->user_model->get_address($id);
			
			//echo $list_address['id']."|".$list_address['recipient_name']."|".$list_address['shipping_address']."|".$list_address['phone']."|".$list_address['mobile']."|".$list_address['province']."|".$list_address['city']."|".$list_address['zipcode'];
			
			echo json_encode(array('id'=>$list_address['id'],'recipient_name'=>$list_address['recipient_name'],'shipping_address'=>$list_address['shipping_address'],'phone'=>$list_address['phone'],'province'=>$list_address['province'],'city'=>$list_address['city'],'zipcode'=>$list_address['zipcode'],'jne_kecamatan_name'=>api_city_name($list_address['city'])));
		}
	}
	
	function load_city($id)
	{	
		$this->data['city']=$this->jne_model->get_city($id);
		$this->load->view('content/city_list',$this->data);
	}
	
	function load_city2($id)
	{	
		$this->data['city_id']=$id;
		$this->data['city']=$this->jne_model->get_jne_city_data();
		//$this->data['city']=$this->jne_model->get_city2($id);
		$this->load->view('content/city_list',$this->data);
	}
	
	function load_shipping_method($id)
	{	
		//$this->data['sm']=$this->jne_model->get_shipping_method($id);
		//new api
		$this->data['sm'] = api_get_city($id);
		$this->load->view('content/shipping_method_list',$this->data);
	}
	
	
	function address($id=NULL)
	{
		if(!$_POST)redirect('not_found');
		$address_id=$this->input->post('select_recipient');
		$shipping_method=$this->input->post('shipping_method');
		$_SESSION['shipping_method']=$shipping_method;
		if($address_id){
			$_SESSION['address_id']=$address_id;		
			$user_id=$this->session->userdata('user_id');
			$shipping=$this->input->post('shipping');
			$phone=$this->input->post('phone');
			$recipient=$this->input->post('recipient');
			//$province=$this->input->post('select_province');
			$city=$this->input->post('select_city');
			$api = api_get_city($city);
			$province = $api['jne_province_id'];
			$zipcode=$this->input->post('zipcode');
			$mobile=$this->input->post('mobile');
			$this->user_model->edit_address($address_id,$recipient,$shipping,$phone,$province,$zipcode,$user_id,$mobile, $city);
			redirect('shopping_cart/checkout_summary');
		}else{		
			$user_id=$this->session->userdata('user_id');
			$shipping=$this->input->post('shipping');
			$phone=$this->input->post('phone');
			$recipient=$this->input->post('recipient');
			//$province=$this->input->post('select_province');
			$city=$this->input->post('select_city');
			$api = api_get_city($city);
			$province = $api['jne_province_id'];
			$zipcode=$this->input->post('zipcode');
			$mobile=$this->input->post('mobile');
			$this->user_model->insert_address($recipient,$shipping,$phone,$province,$zipcode,$user_id,$mobile, $city);
			$user_address_id=mysql_insert_id();
			$_SESSION['address_id']=$user_address_id;
			redirect('shopping_cart/checkout_summary');
		}	
	}
	
	
	
	function address_guest()
	{
		if(!$_POST)redirect('not_found');
		$shipping_cost=$this->input->post('shipping_method');
	
		$shipping_address=$this->input->post('shipping');
		$phone=$this->input->post('phone');
		$recipient=$this->input->post('recipient');
		$city=$this->input->post('select_city');
		$zipcode=$this->input->post('zipcode');
		
		
		$personal_name=$this->input->post('personal_name');
		$personal_email=$this->input->post('personal_email');
		$personal_phone=$this->input->post('personal_phone');
		$personal_billing_address=$this->input->post('personal_billing_address');
		$personal_city = $this->input->post('personal_city');
		
	
		
					
		
		
		$ship_info=array('address_guest'=>array('personal_phone'=>$personal_phone,'personal_name'=>$personal_name,'personal_email'=>$personal_email,'personal_billing_address'=>$personal_billing_address,'personal_city'=>$personal_city,'recipient'=>$recipient,'phone'=>$phone,'shipping_cost'=>$shipping_cost,'city'=>$city,'zipcode'=>$zipcode,'shipping_address'=>$shipping_address));
		$this->session->set_userdata($ship_info);
		//pre($_POST);
		
		$check_email=$this->user_model->is_not_guest($personal_email);
	
		if($check_email){
			$this->session->set_flashdata('notif','This email already registered as member, please login');
			redirect('shopping_cart/shipping');
		}
		
		redirect('shopping_cart/checkout_summary');
	}
	
	function summary()
	{
		$user_id=$this->session->userdata('user_id');
		$order_id=$this->uri->segment(3);
		$cart_list=$this->data['cart_list']=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);
			if($cart_list)foreach($cart_list as $list){
				$this->shopping_cart_model->insert_order_item($list['product_id'],$list['sku_id'],$list['price'],$list['quantity'],$list['quantity']*$list['price'],$user_id,$order_id);
			}
		$this->shopping_cart_model->delete_shopping_cart_by_user($user_id);
		redirect('shopping_cart/checkout_finish');
	}
	
	function checkout_finish()
	{
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
		
		$this->data['content'] = 'content/checkout_finish';
		$this->load->view('common/body', $this->data);	
	}
	
	function do_checkout_2(){
		//die(pre($_POST));
		//if(!$_POST)redirect('not_found');
		//pre($this->session->userdata);
		//(pre($_POST));
		$status=$this->input->post('status');
		
		if($status==1){
			if(!$this->session->userdata('user_logged_in')){
				///////// check if guest ////////
			
				///save data user
				$shipping_info=$this->session->userdata('address_guest');
				////
				$email=$shipping_info['personal_email'];
				
				$full_name=$shipping_info['personal_name'];
				$address=$shipping_info['personal_billing_address'];
				$billing_phone=$shipping_info['personal_phone'];
				$personal_city = $shipping_info['personal_city'];
				$api = api_get_city($personal_city);
				$personal_province = $api['jne_province_id'];
					
				$check_email=$this->user_model->get_user_by_email2($email);
				
				$shipping_method_fee=$shipping_info['shipping_cost'];
				$session_id=session_id();
				$payment_type=1;
					
					
					
				if(!$check_email){
					//guest user bener2 baru
					$_SESSION['guest_checkout']=1;
					$this->user_model->user_registration($email);
					$user_id=mysql_insert_id();
				
					$this->session->set_userdata(array('email_address'=>$email));
					//$this->user_model->update_registration_password($password,$user_id);
					
					$date=date("Y-m-d H:i:s");
					
					$data=array('full_name'=>$full_name,'telephone'=>$billing_phone,'address'=>$address,'activated_date'=>$date,'created_date'=>$date, 'city'=>$personal_city, 'province'=>$personal_province);
					$where=array('id'=>$user_id);
					$this->user_model->update_data('user_tb', $data, $where);
					
					
					$status=1;
					$this->user_model->update_user_status($user_id,$status);
					
					
					$discount_user = $this->shopping_cart_model->get_discount_on_cart_guest($session_id);
					$cart_list=$this->shopping_cart_model->get_shopping_cart_list2($session_id);	
					
					
					$shipping_fee=$shipping_info['shipping_cost'];
					
					$recipient_name=$shipping_info['recipient'];
					$shipping_address=$shipping_info['shipping_address'];
					$phone=$shipping_info['phone'];
					$mobile='';
					
					$city=$shipping_info['city'];
					
					//old version
					//$city_detail=$this->jne_model->get_shipping_method($city);
					$city_detail=api_get_city($city);
					$province=$city_detail['jne_province_id'];
					
					$city_name=api_city_name($city);
					if(!$city_detail['jne_province_id'])
						$province_name='';
					else
						$province_name=api_province_name($province);
					
						
					$zipcode=$shipping_info['zipcode'];
					
										
					$total_actual_weight=0;
					$total_belanja=0;
					$total_diskon=0;
					if($cart_list)foreach($cart_list as $list){
						if($list['sale_id']==0)
						{
							if($this->data['schedule_sale']){
								$total_belanja+=$list['sell_price']*$list['quantity'];
							}else{
								$total_belanja+=$list['msrp']*$list['quantity'];
							}
						}else
						{
							$total_belanja+=$list['price']*$list['quantity'];
						}
						$total_actual_weight+=$list['actual_weight'];
						if($list['discount'] == 0)
							$total_diskon+=$list['total'];	
					}
					$actual_weight=$total_actual_weight;
					$ceil_weight=ceil($actual_weight);
					$shipping_cost=$ceil_weight*$shipping_fee;
					
					
					$status='0';
					$date=date('Y-m-d H:i:s');
					/*if($discount_user){
						if($discount_user['type_voc']==1){
							$discount_price=($total_diskon*$discount_user['value'])/100;
						}
						else{
							$discount_price=$discount_user['value'];
						}
						$voucher_id=$discount_user['voucher_id'];
					}
					else{
						$discount_price=0;
						$voucher_id=0;
					}*/
					
					//new calculation for coupon
					if($discount_user){
						if($discount_user['type_voc']==1){
							$discount_price=($total_belanja*$discount_user['value'])/100;
						}
						else{
							$discount_price=$discount_user['value'];
						}
						$voucher_id=$discount_user['voucher_id'];
					}
					else{
						$discount_price=0;
						$voucher_id=0;
					}
					
					$time_now = date('Y-m-d');
					$discount_cart = $this->discount_model->get_current_discount_cart($time_now);
					
					if($discount_cart){
						if($total_belanja>=$discount_cart['minimum_purchase']){
							$discount_price = $discount_cart['discount'];
						}
						else
						{
							$discount_price=0;
						}
					}
					
					$total_price=$total_belanja-$discount_price+$shipping_cost;
					
									
					// CREATE ORDER RECORD //
					$order_detail = array('recipient_name'=>$recipient_name,
										'shipping_address'=>$shipping_address,
										'phone'=>$phone,
										'city'=>$city,
										'province'=>$province,
										'city_name'=>$city_name,
										'province_name'=>$province_name,
										'zipcode'=>$zipcode,
										'user_id'=>$user_id,
										'total'=>$total_price,
										'status'=>$status,
										'transaction_date'=>$date,
										'shipping_cost'=>$shipping_cost, 
										'shipping_method_fee'=>$shipping_fee,
										'payment_type'=>$payment_type,
										'actual_weight'=>$actual_weight,
										'ceil_weight'=>$ceil_weight,
										'total_diskon'=>$total_diskon,
										'discount_price'=>$discount_price
										);		
					$this->shopping_cart_model->insert_data('order_tb',$order_detail);	
					$order_id=mysql_insert_id();
					// CREATE ORDER RECORD //
					
					
					//MASUKIN COUPON HISTORY//
					if($voucher_id!=0){
						//$id_order=last_order_id('order_tb')+1;
						$grand_total=$total_price+$shipping_cost-$discount_price;
						$database = array(	'coupon_id'=>$voucher_id,
											'user_id'=>$user_id, 
											'order_id'=>$order_id,
											'date_transaction'=>$date,
											'sub_total'=>$total_price,
											'discount'=>$discount_price,
											'grand_total'=>$grand_total);	
						$this->shopping_cart_model->insert_data('coupon_history_tb',$database);	
						$this->coupoun_model->updateqty($voucher_id);
						$this->coupoun_model->update_use_spec($voucher_id);	
					}
					//SELESAI COUPON HISTORY//
					
					$order_number=$this->make_order_number($order_id);
					
					$order_item=array();
					if($cart_list)foreach($cart_list as $list){
						
						$totaldiscount=($list['quantity']*$list['msrp'])-$list['total'];
						$order_item[] = array(	'order_id'=>$order_id,
											'product_id'=>$list['product_id'], 
											'sku_id'=>$list['sku_id'],
											'user_id'=>$user_id,
											'quantity'=>$list['quantity'],
											'price'=>$list['msrp'],
											'discount_price'=>$totaldiscount,
											'total'=>$list['price']*$list['quantity'],
											'sale_id'=>$list['sale_id']
										);	
					}
					
					
					// INSERT ORDER ITEM //
					if($order_item)
						$this->shopping_cart_model->insert_data_batch('order_item_tb',$order_item);		
					// INSERT ORDER ITEM
					
					
					
					
					// DELETE SHOPPING CART //
					$this->shopping_cart_model->delete_session_shopping_cart($session_id);
					// DELETE SHOPPING CART //
					
					
					$this->send_email($order_id);
				
					
					
					
					
					$_SESSION['address_id']=NULL;
					
				}else{
					// guest checkout dan ternyata emailny udah terdaftar sebagai user
					
								
					$is_not_guest=$this->user_model->is_not_guest($email);
					
					if($is_not_guest){
						$this->session->set_flashdata('notif','This email already registered as member, please login');
						redirect('shopping_cart/shipping');
					}
					
					$user_id=$check_email['id'];
					
					$discount_user = $this->shopping_cart_model->get_discount_on_cart($session_id);
					$cart_list=$this->shopping_cart_model->get_shopping_cart_list_user2($session_id);	
					
					$shipping_fee=$shipping_info['shipping_cost'];
					
					$payment_type=1;

					$recipient_name=$shipping_info['recipient'];
					$shipping_address=$shipping_info['shipping_address'];
					$phone=$shipping_info['phone'];
					$mobile='';
					$city=$shipping_info['city'];
					
					//old version
					//$city_detail=$this->jne_model->get_shipping_method($city);
					$city_detail=api_get_city($city);
					$province=$city_detail['jne_province_id'];
					
					$city_name=api_city_name($city);
					if(!$city_detail['jne_province_id'])
						$province_name='';
					else
						$province_name=api_province_name($province);
					
					$zipcode=$shipping_info['zipcode'];
					
					$total_actual_weight=0;
					$total_belanja=0;
					$total_diskon=0;
					if($cart_list)foreach($cart_list as $list){
						if($list['sale_id']==0){
							if($this->data['schedule_sale']){
								$total_belanja+=$list['sell_price']*$list['quantity'];
							}else{
								$total_belanja+=$list['msrp']*$list['quantity'];
							}
						}else{
							$total_belanja+=$list['price']*$list['quantity'];
						}
						$total_actual_weight+=$list['actual_weight'];	
						if($list['discount'] == 0)
						{
							$total_diskon += $list['total'];
						}
					}
					$actual_weight=$total_actual_weight;
					$ceil_weight=ceil($actual_weight);
					$shipping_cost=$ceil_weight*$shipping_fee;
					
					$status='0';
					$date=date('Y-m-d H:i:s');
					/*if($discount_user){
						if($discount_user['type_voc']==1){
							$discount_price=($total_diskon*$discount_user['value'])/100;
						}
						else{
							$discount_price=$discount_user['value'];
						}
						$voucher_id=$discount_user['voucher_id'];
					}
					else{
						$discount_price=0;
						$voucher_id=0;
					}*/
					
					//new calculation for coupon
					if($discount_user){
						if($discount_user['type_voc']==1){
							$discount_price=($total_belanja*$discount_user['value'])/100;
						}
						else{
							$discount_price=$discount_user['value'];
						}
						$voucher_id=$discount_user['voucher_id'];
					}
					else{
						$discount_price=0;
						$voucher_id=0;
					}
					
					$time_now = date('Y-m-d');
					$discount_cart = $this->discount_model->get_current_discount_cart($time_now);
					
					if($discount_cart){
						if($total_belanja>=$discount_cart['minimum_purchase']){
							$discount_price = $discount_cart['discount'];
						}
						else
						{
							$discount_price=0;
						}
					}
					
					$total_price=$total_belanja-$discount_price+$shipping_cost;	

					//$shipping_method_fee=$_SESSION['shipping_method'];
					//$payment_type=1;
					
					/* guest checkout gak pake stamps
					// QUERYING REWARDS STAMPS //
					$data_stamps=$this->coupoun_model->stamps_list($user_id);
					$store=STAMPS_STORE;
					$token=STAMPS_TOKEN;
					$email_stamp=$this->session->userdata('email');
					$rewards=$data_stamps['stamps_id'];
					$stamps = array(
									'token'=>$token,
									'store'=>$store,
									'user_email'=>$email_stamp,
									'reward'=>$rewards
									);
					$data_stamps =json_encode($stamps); 
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, 'https://stamps.co.id/api/redemptions/add');                     
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_stamps);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch,  CURLOPT_HTTPHEADER,  array(
					'Content-Type: application/json')
					);
					$result_stamps  =  curl_exec($ch);  
					// QUERYING REWARDS STAMPS //*/
					
					
					
					// CREATE ORDER RECORD //
					$order_detail = array('recipient_name'=>$recipient_name,
										'shipping_address'=>$shipping_address,
										'phone'=>$phone,
										'city'=>$city,
										'province'=>$province,
										'city_name'=>$city_name,
										'province_name'=>$province_name,
										'zipcode'=>$zipcode,
										'user_id'=>$user_id,
										'total'=>$total_price,
										'status'=>$status,
										'transaction_date'=>$date,
										'shipping_cost'=>$shipping_cost, 
										'shipping_method_fee'=>$shipping_fee,
										'payment_type'=>$payment_type,
										'actual_weight'=>$actual_weight,
										'ceil_weight'=>$ceil_weight,
										'total_diskon'=>$total_diskon,
										'discount_price'=>$discount_price
										);	
					
					$this->shopping_cart_model->insert_data('order_tb',$order_detail);	
					$order_id=mysql_insert_id();
					// CREATE ORDER RECORD //
					
					
					//MASUKIN COUPON HISTORY//
					if($voucher_id!=0){
						//$id_order=last_order_id('order_tb')+1;
						$grand_total=$total_price+$shipping_cost-$discount_price;
						$database = array(	'coupon_id'=>$voucher_id,
											'user_id'=>$user_id, 
											'order_id'=>$order_id,
											'date_transaction'=>$date,
											'sub_total'=>$total_price,
											'discount'=>$discount_price,
											'grand_total'=>$grand_total);	
						$this->shopping_cart_model->insert_data('coupon_history_tb',$database);	
						$this->coupoun_model->updateqty($voucher_id);
						$this->coupoun_model->update_use_spec($voucher_id);	
					}
					//SELESAI COUPON HISTORY//
					
					$order_number=$this->make_order_number($order_id);
					
					$order_item=array();
					if($cart_list)foreach($cart_list as $list){
						
						$totaldiscount=($list['quantity']*$list['msrp'])-$list['total'];
						$order_item[] = array('order_id'=>$order_id,
											'product_id'=>$list['product_id'], 
											'sku_id'=>$list['sku_id'],
											'user_id'=>$user_id,
											'quantity'=>$list['quantity'],
											'price'=>$list['msrp'],
											'discount_price'=>$totaldiscount,
											'total'=>$list['price']*$list['quantity'],
											'sale_id'=>$list['sale_id']
										);	
					}
					
					
					// INSERT ORDER ITEM //
					if($order_item)
						$this->shopping_cart_model->insert_data_batch('order_item_tb',$order_item);		
					//INSERT ORDER ITEM
					
					
					
					
					// DELETE SHOPPING CART //
					$this->shopping_cart_model->delete_session_shopping_cart($session_id);
					// DELETE SHOPPING CART //
					
					
					$this->send_email($order_id);
				
					
					
					
					
					$_SESSION['address_id']=NULL;
					
				}
				
			
				////////////////////////
			}
			else{
				//if user
					
				$user_id=$this->session->userdata('user_id');
				$user_address_id=$_SESSION['address_id'];
				
				$address=$this->user_model->get_address($user_address_id);
				$discount_user = $this->shopping_cart_model->get_discount_on_cart($user_id);
				$stamps_list=$this->coupoun_model->stamps_list($user_id);			
				$cart_list=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);	
				
				
				$shipping_fee=$_SESSION['shipping_method'];
				$payment_type=$_SESSION['payment_type']=1;
				
				
				$recipient_name=$address['recipient_name'];
				$shipping_address=$address['shipping_address'];
				$phone=$address['phone'];
				//$mobile=$address['mobile'];
				$mobile='';
				$city=$address['city'];
				
				//old version
				//$city_detail=$this->jne_model->get_shipping_method($city);
				$city_detail=api_get_city($city);
				$province=$city_detail['jne_province_id'];
				
				$city_name=api_city_name($city);
				if(!$city_detail['jne_province_id'])
					$province_name='';
				else
					$province_name=api_province_name($province);
				
				$zipcode=$address['zipcode'];
				
				
				$total_actual_weight=0;
				$total_belanja=0;
				$total_diskon=0;
				
				if($cart_list)foreach($cart_list as $list){
					if($list['sale_id']==0){
						if($this->data['schedule_sale']){
							$total_belanja+=$list['sell_price']*$list['quantity'];
						}else{
							$total_belanja+=$list['msrp']*$list['quantity'];
						}
					}else{
						$total_belanja+=$list['price']*$list['quantity'];
					}
					$total_actual_weight+=$list['actual_weight'];	
					if($list['discount'] == 0)
					{
						$total_diskon += $list['total'];
					}
				}
				$actual_weight=$total_actual_weight;
				$ceil_weight=ceil($actual_weight);
				$shipping_cost=$ceil_weight*$shipping_fee;
				
				$status='0';
				$date=date('Y-m-d H:i:s');
				/*if($discount_user){
					if($discount_user['type_voc']==1){
						$discount_price=($total_diskon*$discount_user['value'])/100;
					}
					else{
						$discount_price=$discount_user['value'];
					}
					$voucher_id=$discount_user['voucher_id'];
				}
				else{
					$discount_price=0;
					$voucher_id=0;
				}*/
				
				//new calculation for coupon
				if($discount_user){
					if($discount_user['type_voc']==1){
						$discount_price=($total_belanja*$discount_user['value'])/100;
					}
					else{
						$discount_price=$discount_user['value'];
					}
					$voucher_id=$discount_user['voucher_id'];
				}
				else{
					$discount_price=0;
					$voucher_id=0;
				}
				
				//check discount cart promo
				$time_now = date('Y-m-d');
				$discount_cart = $this->discount_model->get_current_discount_cart($time_now);
				
				if($discount_cart){
					if($total_belanja>=$discount_cart['minimum_purchase']){
						$discount_price = $discount_cart['discount'];
					}
					else
					{
						$discount_price=0;
					}
				}
				
				
				$total_price=$total_belanja-$discount_price+$shipping_cost;		
				
				$shipping_method_fee=$_SESSION['shipping_method'];
				$payment_type=$_SESSION['payment_type'];
				
				
				
				// QUERYING REWARDS STAMPS //
				$data_stamps=$this->coupoun_model->stamps_list($user_id);$data_stamps=NULL;
				if($data_stamps)
				{
					$store=STAMPS_STORE;
					$token=STAMPS_TOKEN;
					$email_stamp=$this->session->userdata('email');
					$rewards=$data_stamps['stamps_id'];
					$stamps = array(
									'token'=>$token,
									'store'=>$store,
									'user_email'=>$email_stamp,
									'reward'=>$rewards
									);
					$data_stamps =json_encode($stamps); 
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, 'https://stamps.co.id/api/redemptions/add');                     
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_stamps);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch,  CURLOPT_HTTPHEADER,  array(
						'Content-Type: application/json')
						);
					$result_stamps  =  curl_exec($ch);
				}
				// QUERYING REWARDS STAMPS //
				
	
				// CREATE ORDER RECORD //
				$order_detail = array(	'recipient_name'=>$recipient_name,
									'shipping_address'=>$shipping_address,
									'phone'=>$phone,
									'city'=>$city,
									'province'=>$province,
									'city_name'=>$city_name,
									'province_name'=>$province_name,
									'zipcode'=>$zipcode,
									'user_id'=>$user_id,
									'total'=>$total_price,
									'status'=>$status,
									'transaction_date'=>$date,
									'shipping_cost'=>$shipping_cost, 
									'shipping_method_fee'=>$shipping_method_fee,
									'payment_type'=>$payment_type,
									'actual_weight'=>$actual_weight,
									'ceil_weight'=>$ceil_weight,
									'total_diskon'=>$total_diskon,
									'discount_price'=>$discount_price
									);	
				
				$this->shopping_cart_model->insert_data('order_tb',$order_detail);	
				$order_id=mysql_insert_id();
				// CREATE ORDER RECORD //
				
				//MASUKIN COUPON HISTORY//
				if($voucher_id!=0){
					//$id_order=last_order_id('order_tb')+1;
					$grand_total=$total_price+$shipping_cost-$discount_price;
					$database = array(	'coupon_id'=>$voucher_id,
										'user_id'=>$user_id, 
										'order_id'=>$order_id,
										'date_transaction'=>$date,
										'sub_total'=>$total_price,
										'discount'=>$discount_price,
										'grand_total'=>$grand_total);	
					$this->shopping_cart_model->insert_data('coupon_history_tb',$database);	
					$this->coupoun_model->updateqty($voucher_id);
					$this->coupoun_model->update_use_spec($voucher_id);	
				}
				//SELESAI COUPON HISTORY//    
				
				
				$order_number=$this->make_order_number($order_id);
				
				$order_item=array();
				if($cart_list)foreach($cart_list as $list){
					
					$totaldiscount=($list['quantity']*$list['msrp'])-$list['total'];
					$order_item[] = array(	'order_id'=>$order_id,
										'product_id'=>$list['product_id'], 
										'sku_id'=>$list['sku_id'],
										'user_id'=>$user_id,
										'quantity'=>$list['quantity'],
										'price'=>$list['msrp'],
										'discount_price'=>$totaldiscount,
										'total'=>$list['price']*$list['quantity'],
										'sale_id'=>$list['sale_id']
									);	
				}
				
				
				// INSERT ORDER ITEM //
				if($order_item)
					$this->shopping_cart_model->insert_data_batch('order_item_tb',$order_item);		
				// INSERT ORDER ITEM
				
				
				
				
				// DELETE SHOPPING CART //
				$this->shopping_cart_model->delete_shopping_cart_by_user($user_id);
				// DELETE SHOPPING CART //
				
				
				$this->send_email($order_id);
				
				
				$_SESSION['address_id']=NULL;
			}
			
			$this->session->unset_userdata(array('address_guest'=>''));
			redirect('shopping_cart/checkout_finish');
		}
		else{
			#redirect('shopping_cart');
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
			$this->email->subject('Order Received - '.$order['order_number']);
			$this->email->message($isi_admin); 
			$this->email->send();
			
			return TRUE;
		}
		else return FALSE;
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
	
	function do_checkout()
	{
		
		if(!$_POST)redirect('not_found');
	//	pre($_POST);exit();
		$total=$this->input->post('total');
		$user_id=$this->session->userdata('user_id');
		$recipient_name=$this->input->post('recipient_name');
		$shipping_address=$this->input->post('shipping_address');
		$phone=$this->input->post('phone');
		$city=$this->input->post('city');
		$province=$this->input->post('province');
		$zipcode=$this->input->post('zipcode');
		$mobile=$this->input->post('mobile');
		$actual_weight=$this->input->post('actual_weight');
		$ceil_weight=$this->input->post('ceil_weight');
		$status='0';
		$date=date('Y-m-d H:i:s');
		$discount_price=$this->input->post('discount');
		$shipping_cost=$this->input->post('shipping_cost');
		$shipping_method_fee=$_SESSION['shipping_method'];
		$payment_type=$_SESSION['payment_type'];
		
		//MASUKIN COUPON HISTORY//
		$voucher_id=$this->input->post('voucher_id');
		if($voucher_id!=0){
		$id_order=last_order_id('order_tb')+1;
		$total_price=$this->input->post('total_price');
		$grand_total=$this->input->post('grand_total');
		$database = array(	'coupon_id'=>$voucher_id,
							'user_id'=>$user_id, 
							'order_id'=>$id_order,
							'date_transaction'=>$date,
							'sub_total'=>$total_price,
							'discount'=>$discount_price,
							'grand_total'=>$grand_total);	
		$this->shopping_cart_model->insert_data('coupon_history_tb',$database);	
		$this->coupoun_model->updateqty($voucher_id);
		$this->coupoun_model->update_use_spec($voucher_id);	
		}
		//SELESAI COUPON HISTORY//
		
		// QUERYING REWARDS STAMPS //
		$data_stamps=$this->coupoun_model->stamps_list($user_id);
		$store=STAMPS_STORE;
		$token=STAMPS_TOKEN;
		$email_stamp=$this->session->userdata('email');
		$rewards=$data_stamps['stamps_id'];
		$stamps = array(
							'token'=>$token,
							'store'=>$store,
							'user_email'=>$email_stamp,
							'reward'=>$rewards
								 );
		$data21 =json_encode($stamps); 
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://stamps.co.id/api/redemptions/add');                     
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data21);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,  CURLOPT_HTTPHEADER,  array('Content-Type: application/json') );
		$result  =  curl_exec($ch);
		// QUERYING REWARDS STAMPS //
		
		
		// TUTUPNYA NIH BOS //	
		$database = array(	'recipient_name'=>$recipient_name,
							'shipping_address'=>$shipping_address,
							'phone'=>$phone,
							'city'=>$city,
							'province'=>$province,
							'zipcode'=>$zipcode,
							'user_id'=>$user_id,
							'total'=>$total,
							'status'=>$status,
							'transaction_date'=>$date,
							'mobile'=>$mobile, 
							'shipping_cost'=>$shipping_cost, 
							'shipping_method_fee'=>$shipping_method_fee,
							'payment_type'=>$payment_type,
							'actual_weight'=>$actual_weight,
							'ceil_weight'=>$ceil_weight,
							'discount_price'=>$discount_price
						);		
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
			$price=$list['msrp'];
			$totaldiscount=($list['quantity']*$list['msrp'])-$list['total'];
			$database = array(	'order_id'=>$order_id,
								'product_id'=>$list['product_id'], 
								'sku_id'=>$list['sku_id'],
								'user_id'=>$user_id,
								'quantity'=>$list['quantity'],
								'price'=>$price,
								'discount_price'=>$totaldiscount,
								'total'=>$price*$list['quantity']);		
			$this->shopping_cart_model->insert_data('order_item_tb',$database);	
		}
	
		
		$this->shopping_cart_model->delete_shopping_cart_by_user($user_id);
		
		$this->send_email($order_id);
		$_SESSION['address_id']=NULL;
		redirect('shopping_cart/checkout_finish');
	}
	
	function print_order_detail($order_id)
	{
		$this->data['shipping']=$this->user_model->get_shipping_info($order_id);
		$user_id=$this->session->userdata('user_id');
		if(order_check($user_id,$order_id)){
			$this->data['account']=$this->user_model->user_detail($user_id);
			$this->data['order']=$this->user_model->get_order2($order_id);
		}else {
			redirect('home');
		}
		$this->data['discount']=0;
		$this->load->view('content/print_order_detail', $this->data);
	}
	
	function order_template($order_id){
		
		$user_id=$this->session->userdata('user_id');
		$this->data['account']=$this->user_model->user_detail($user_id);
		$this->data['user']=$this->user_model->user_detail($user_id);
		$this->data['order']=$this->shopping_cart_model->get_order($order_id);
		$this->data['order_item']=$this->shopping_cart_model->get_order_item2($order_id);
		$this->data['discount']=0;
		$this->load->view('content/email_template/email_temp_order_details',$this->data);
	}
	
	function get_kabupaten(){	
			$jne_province=array();
			if(isset($_GET['term'])){
			$search=htmlspecialchars($_GET['term']);
				$data = $this->jne_model->get_filter_pronvice($search);
			}else{
				$data=$this->sparepart_model->get_jne_province_data();
			}
			//pre($data);
			foreach ($data as $list){
					$jne_province[]=array('id'=>$list['id'],'value'=>$list['name']);		
			}
			echo json_encode($jne_province);	
	}
	
	function get_kecamatan(){
		
			/*
			//old version
			$jne_city=array();
			if(isset($_GET['term'])){
			$search=htmlspecialchars($_GET['term']);
				$data = $this->jne_model->get_city_filter($search);
			}else{
				$data=$this->jne_model->get_city_all_new();
			}
			//pre($data);
			foreach ($data as $list){
					$jne_city[]=array('id'=>$list['id'],'value'=>$list['province_name'] .' | '. $list['name']);		
			}
			echo json_encode($jne_city);*/
			
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
					$jne_city[]=array('id'=>$list['id'],'value'=>$list['province_name'] .' | '. $list['name'], 'province_id'=>$list['jne_province_id']);		
			}
			echo json_encode($jne_city);
	}
	function get_kecamatan_2($province_id){
		$user_id=$this->session->userdata('user_id');
		$this->data['detail']=$this->user_model->get_address_by_user3($user_id);
		$this->data['kecamatan_list'] = $this->jne_model->get_city($province_id);
		$this->load->view('content/kecamatan_list',$this->data);
	}
	
	function get_shipping_method(){
		$city_id = $_POST['city_id'];
		$parameters = array('city_id'=>$city_id);
		$parameters_json = json_encode($parameters);
		
		$ch = curl_init();  
		$url = "http://jne.isysedge.com/api/jne/get_shipping_method";
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array("data" => $parameters_json));    
		$output=curl_exec($ch);
		curl_close($ch);
		$this->data['city'] = $data=json_decode($output,true);
		
		$content = $this->load->view('content/shipping_method', $this->data, TRUE);
		echo json_encode(array('content'=>$content));
	}
}
?>