<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Login extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('shopping_cart_model');
		$this->data['page_title']="Login";
		if($this->session->userdata('user_logged_in')==true) redirect('home');
		$this->load->model('footer_menu_model');
		$this->data['footer'] = $this->footer_menu_model->get_active_footer_menu_list();
		$this->load->model('secondary_menu_model');
		$this->data['secondary'] = $this->secondary_menu_model->get_active_secondary_menu_list();
	}
	
	function index($login_type=0)
	{

		$login_type = $this->input->post('login_type');
		$this->data['login_type']=$login_type;
		$this->data['content'] = 'content/login_register/login';
		$this->load->view('common/body', $this->data);	
	}
	
	function facebooklogin(){
		$newdate=date("Y-m-d H:i:s");
		$name=$this->input->post('name');
		$email=$this->input->post('email');
		$facebook_id=$this->input->post('facebook_id');
		$data_facebook=$this->input->post('data_facebook');
		$facebook_data=json_encode($data_facebook,true);
		$token=$this->input->post('token');
		$status=1;
		//pre($facebook_data);
		$status=1;
		$check_email=$this->user_model->get_user_by_email($email);
		if($check_email){
		$database=array('fb_id'=>$facebook_id,'fb_token'=>$token,'fb_data'=>$facebook_data,'status'=>$status,'last_login'=>date("Y-m-d"));
		$where=array('email'=>$email);
		$this->user_model->update_data('user_tb', $database, $where);
		$user_id=$check_email['id'];
		}else{
		$database=array('email'=>$email,'fb_id'=>$facebook_id,'fb_token'=>$token,'fb_data'=>$facebook_data,'full_name'=>$name,'created_date'=>$newdate,'activated_date'=>$newdate,'status'=>$status,'last_login'=>date("Y-m-d"));
		$this->user_model->insert_data('user_tb',$database);
		$user_id=mysql_insert_id();
		}		
		
		$sess_user = array ('user_logged_in' => true,
						   'user_id' => $user_id,
						   'email' => $email,
						   'name' => $name,
						   'login_via'=>'facebook' 
							);
		$this->session->set_userdata($sess_user);
		$session_id=session_id();
		$data=$this->shopping_cart_model->get_shopping_cart_list2($session_id);
		if($data){
			foreach($data as $list){
				$user_id=$this->session->userdata('user_id');
				$product_id=$list['product_id'];
				$sku_id=$list['sku_id'];
				$qty=$list['quantity'];
				$price=$list['price'];
				$total=$list['quantity']*$list['sell_price'];
				$total_sale = $list['quantity']*$list['price'];
				$date=date('Y-m-d H:i:s');
				$actual_weight=$list['actual_weight'];
				$ceil_weight = $list['ceil_weight'];
				
				$sale_id = $list['sale_id'];
				
				$msrp=$list['msrp'];
				
				if(!$this->data['schedule_sale']) $price=$msrp;
			
				if($msrp>$price && $this->data['schedule_sale'])$discount=1;
				else $discount=0;
				
				if($sale_id==0)
				{
					$cek=$this->shopping_cart_model->check_shopping_cart_user($product_id,$sku_id,$user_id,$price);
					if($cek){
						//update shopping cart
						$actual_weight+=$cek['actual_weight'];
						$ceil_weight = ceil($actual_weight);
						$qty+=$cek['quantity'];
						$total+=$cek['total'];
						$this->shopping_cart_model->delete_session_shopping_cart($session_id);
						$database = array(	'actual_weight'=>$actual_weight,
											'ceil_weight'=>$ceil_weight,
											'quantity'=>$qty,
											'price'=>$price,
											'msrp_price'=>$msrp,
											'type'=>1,
											'discount'=>$discount,
											'total'=>$total,
											'sale_id'=>$sale_id);	
						$where = array( 'product_id'=>$product_id,
										'sku_id'=>$sku_id,
										'user_id'=>$user_id,
										'price'=>$price);	
						$this->shopping_cart_model->update_data('shopping_cart_tb',$database, $where);								
					}else{
						//create new shopping cart		
						$this->shopping_cart_model->delete_session_shopping_cart($session_id);		
						$database = array(	'product_id'=>$product_id, 
								'sku_id'=>$sku_id,
								'user_id'=>$user_id,
								'quantity'=>$qty,
								'price'=>$price,
								'total'=>$total,
								'discount'=>$discount,
								'msrp_price'=>$msrp,
								'type'=>1,
								'actual_weight'=>$actual_weight,
								'ceil_weight'=>$ceil_weight,
								'created_date'=>$date,
								'sale_id'=>$sale_id  );		
						$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);			
					}
				}
				else //if shopping cart item is flash sale item
				{
					$cek=$this->shopping_cart_model->check_shopping_cart_user($product_id,$sku_id,$user_id,$price);
					if($cek){
						//update shopping cart
						$actual_weight+=$cek['actual_weight'];
						$ceil_weight = ceil($actual_weight);
						$qty+=$cek['quantity'];
						$total_sale+=$cek['total'];
						$this->shopping_cart_model->delete_session_shopping_cart($session_id);
						$database = array(	'actual_weight'=>$actual_weight,
											'ceil_weight'=>$ceil_weight,
											'quantity'=>$qty,
											'msrp_price'=>$msrp,
											'type'=>1,
											'discount'=>$discount,
											'total'=>$total_sale,
											'sale_id'=>$sale_id);	
						$where = array( 'product_id'=>$product_id,
										'sku_id'=>$sku_id,
										'user_id'=>$user_id,
										'price'=>$price);	
						$this->shopping_cart_model->update_data('shopping_cart_tb',$database, $where);								
					}else{
						//create new shopping cart		
						#$this->shopping_cart_model->delete_session_shopping_cart($session_id);		
						$database = array(	'product_id'=>$product_id, 
								'sku_id'=>$sku_id,
								'user_id'=>$user_id,
								'quantity'=>$qty,
								'price'=>$price,
								'total'=>$total_sale,
								'discount'=>$discount,
								'msrp_price'=>$msrp,
								'type'=>1,
								'actual_weight'=>$actual_weight,
								'ceil_weight'=>$ceil_weight,
								'created_date'=>$date,
								'sale_id'=>$sale_id  );		
						pre($database);		
						#$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);			
					}
				}
			}	
		}
		$detail_user = $this->user_model->user_detail($user_id);	
		$total_item = $this->shopping_cart_model->get_total_shopping_cart_list_user2($user_id);
		// if($total_item>0){
		echo json_encode(array('status'=>"success",'name'=>$detail_user['full_name'],'phone'=>$detail_user['mobile'],'email'=>$detail_user['email']));
		// }else{
		// 	echo json_encode(array('links'=>site_url('my_account/dashboard')));
		// }
				
	
	}
	
	function process()
	{
		$login_type = $this->input->post('login_type');
		$email = $this->input->post('loginEmail');
		$password = $this->input->post('loginPass');
		$this->data['login_type']=$login_type;
		if(!$email)
		{	
			$this->data['email']=$email;
			$this->data['password']=$password;
			$this->data['error'] = 'Email harus di isi';
			$this->data['content'] = 'content/login_register/login';
			$this->load->view('common/body', $this->data);
		}
		else if(!$password)
		{
			$this->data['email']=$email;
			$this->data['password']=$password;
			$this->data['error_pass'] = 'Password harus di isi';
			$this->data['content'] = 'content/login_register/login';
			$this->load->view('common/body', $this->data);
		}
		else{
			$login = $this->user_model->login($email,$password);
			if ($login != NULL) {
				$sess_user = array (
									   'user_logged_in' => true,
									   'user_id' => $login['id'],
									   'email' => $login['email'],
									   'name' => $login['full_name'],
									   'login_via'=>'manual'   
									);
				$this->session->set_userdata($sess_user);
				
				//update last login
				$data=array('last_login'=>date("Y-m-d"));
				$where=array('id'=>$login['id']);
				$this->user_model->update_data('user_tb', $data, $where);
				$user_id=$login['id'];
				
				$session_id=session_id();
				$data=$this->shopping_cart_model->get_shopping_cart_list2($session_id);
				if($data){
					foreach($data as $list){
						$user_id=$this->session->userdata('user_id');
						$product_id=$list['product_id'];
						$sku_id=$list['sku_id'];
						$qty=$list['quantity'];
						$price=$list['price'];
						$total=$list['quantity']*$list['sell_price'];
						$total_sale=$list['quantity']*$list['price'];
						$date=date('Y-m-d H:i:s');
						$actual_weight=$list['actual_weight'];
						$ceil_weight = $list['ceil_weight'];
								
						$sale_id = $list['sale_id'];
						$msrp=$list['msrp'];
						
						if($msrp>$price)$discount=1;
						else $discount=0;
						
						if($sale_id==0)
						{
							$cek=$this->shopping_cart_model->check_shopping_cart_user($product_id,$sku_id,$user_id,$price);
							if($cek){
								//update shopping cart
								$actual_weight+=$cek['actual_weight'];
								$ceil_weight = ceil($actual_weight);
								$qty+=$cek['quantity'];
								$total+=$cek['total'];
								$this->shopping_cart_model->delete_session_shopping_cart($session_id);
								$database = array(	'actual_weight'=>$actual_weight,
													'ceil_weight'=>$ceil_weight,
													'quantity'=>$qty,
													'msrp_price'=>$msrp,
													'discount'=>$discount,
													'type'=>1,
													'total'=>$total,
													'sale_id'=>$sale_id);	
								$where = array( 'product_id'=>$product_id,
												'sku_id'=>$sku_id,
												'user_id'=>$user_id,
												'price'=>$price);	
								$this->shopping_cart_model->update_data('shopping_cart_tb',$database, $where);								
							}else{
								//create new shopping cart		
								$this->shopping_cart_model->delete_session_shopping_cart($session_id);		
								$database = array(	'product_id'=>$product_id, 
										'sku_id'=>$sku_id,
										'user_id'=>$user_id,
										'quantity'=>$qty,
										'price'=>$price,
										'total'=>$total_sale,
										'msrp_price'=>$msrp,
										'discount'=>$discount,
										'type'=>1,
										'actual_weight'=>$actual_weight,
										'ceil_weight'=>$ceil_weight,
										'created_date'=>$date,
										'sale_id'=>$sale_id  );		
								$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);			
							}
						}
						else //if shopping cart item is flash sale item
						{
							$cek=$this->shopping_cart_model->check_shopping_cart_user($product_id,$sku_id,$user_id,$price);
							if($cek){
								//update shopping cart
								$actual_weight+=$cek['actual_weight'];
								$ceil_weight = ceil($actual_weight);
								$qty+=$cek['quantity'];
								$total_sale+=$cek['total'];
								$this->shopping_cart_model->delete_session_shopping_cart($session_id);
								$database = array(	'actual_weight'=>$actual_weight,
													'ceil_weight'=>$ceil_weight,
													'quantity'=>$qty,
													'msrp_price'=>$msrp,
													'type'=>1,
													'discount'=>$discount,
													'total'=>$total_sale,
													'sale_id'=>$sale_id);	
								$where = array( 'product_id'=>$product_id,
												'sku_id'=>$sku_id,
												'user_id'=>$user_id,
												'price'=>$price);	
								$this->shopping_cart_model->update_data('shopping_cart_tb',$database, $where);								
							}else{
								//create new shopping cart		
								$this->shopping_cart_model->delete_session_shopping_cart($session_id);		
								$database = array(	'product_id'=>$product_id, 
										'sku_id'=>$sku_id,
										'user_id'=>$user_id,
										'quantity'=>$qty,
										'price'=>$price,
										'total'=>$total_sale,
										'discount'=>$discount,
										'msrp_price'=>$msrp,
										'type'=>1,
										'actual_weight'=>$actual_weight,
										'ceil_weight'=>$ceil_weight,
										'created_date'=>$date,
										'sale_id'=>$sale_id  );			
								$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);			
							}
						}
					}	
				}
				/*if(isset($_SESSION['mypage'])){
						$page=$_SESSION['mypage'];
						$_SESSION['mypage']=null;
						redirect($page);
					}else{
						redirect('my_account/shoppingcart');	
					}*/
				//$data_user_shopping=$this->shopping_cart_model->get_shopping_cart_list_user($id);
				
				$total_item = $this->shopping_cart_model->get_total_shopping_cart_list_user2($user_id);
				if($login_type=="customer_info"){
					redirect('shopping_cart/customer_information');
				}else{
					redirect('home');
				}
			}
			else{	
				$this->data['email']=$email;
				$this->data['password']=$password;
				$this->data['error_invalid'] = 'Password atau Email salah';
				$this->data['content'] = 'content/login_register/login';
				$this->load->view('common/body', $this->data);
				
			}
		}
	}
	
	function checkout(){
	
		$this->data['content'] = 'content/login_register/login_from_checkout';
		$this->load->view('common/body', $this->data);	
	}
}
?>