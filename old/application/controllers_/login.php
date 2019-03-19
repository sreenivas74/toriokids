<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Login extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('shopping_cart_model');
		$this->data['page_title']="Register & Login";
	}
	
	function index()
	{
		$this->data['email']='';
		$this->data['content'] = 'content/login_register/login_register';
		$this->load->view('common/body', $this->data);	
	}
	
	function facebooklogin(){
		$newdate=date("Y-m-d H:i:s");
		$name=$this->input->post('name');
		$bobd=$this->input->post('birthday');
		$bod=date('Y-m-d', strtotime($bobd));
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
		$database=array('email'=>$email,'fb_id'=>$facebook_id,'fb_token'=>$token,'fb_data'=>$facebook_data,'full_name'=>$name,'date_of_birth'=>$bod,'created_date'=>$newdate,'activated_date'=>$newdate,'status'=>$status,'last_login'=>date("Y-m-d"));
		$this->user_model->insert_data('user_tb',$database);
		$user_id=mysql_insert_id();
		}		
		
		$sess_user = array ('user_logged_in' => true,
						   'user_id' => $user_id,
						   'email' => $email,
						   'name' => $name 
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
				$date=date('Y-m-d H:i:s');
				$actual_weight=$list['actual_weight'];
				$ceil_weight = $list['ceil_weight'];
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
										'type'=>1,
										'total'=>$total);	
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
							'type'=>1,
							'actual_weight'=>$actual_weight,
							'ceil_weight'=>$ceil_weight,
							'created_date'=>$date  );		
					$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);			
				}
			}	
		}
			
		$total_item = $this->shopping_cart_model->get_total_shopping_cart_list_user2($user_id);
		if($total_item>0){
			echo json_encode(array('links'=>site_url('shopping_cart')));
		}else{
			echo json_encode(array('links'=>site_url('my_account/dashboard')));
		}
				
	
	}
	
	function process()
	{
		$email = $this->input->post('loginEmail');
		$password = $this->input->post('loginPass');
		
		if(!$email || !$password)
		{	
			$this->data['errLogin'] = 'Please enter your email and password';
			$this->data['email']='';
			$this->data['content'] = 'content/login_register/login_register';
			$this->load->view('common/body', $this->data);	
		}
		else{
			$login = $this->user_model->login($email,$password);
			if ($login != NULL) {
				$sess_user = array (
									   'user_logged_in' => true,
									   'user_id' => $login['id'],
									   'email' => $login['email'],
									   'name' => $login['full_name']  
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
						$date=date('Y-m-d H:i:s');
						$actual_weight=$list['actual_weight'];
						$ceil_weight = $list['ceil_weight'];
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
												'type'=>1,
												'total'=>$total);	
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
									'type'=>1,
									'actual_weight'=>$actual_weight,
									'ceil_weight'=>$ceil_weight,
									'created_date'=>$date  );		
							$this->shopping_cart_model->insert_data('shopping_cart_tb',$database);			
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
				if($total_item>0){
					redirect('shopping_cart');
				}else{
					redirect('my_account/dashboard');
				}
			}
			else{
				$this->data['errLogin'] = 'Invalid username or password';
				$this->data['email']='';
				$this->data['content'] = 'content/login_register/login_register';
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