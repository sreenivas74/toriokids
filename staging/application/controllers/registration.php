<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Registration extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('jne_model');
		$this->load->model('shopping_cart_model');
		$this->load->model('newsletter_model');
		$this->load->model('general_model');
		$this->data['page_title']="Register";
		$this->load->model('footer_menu_model');
		$this->data['footer'] = $this->footer_menu_model->get_active_footer_menu_list();
		$this->load->model('secondary_menu_model');
		$this->data['secondary'] = $this->secondary_menu_model->get_active_secondary_menu_list();
	}
	
	function index($register_type=0)
	{
		if($this->session->userdata('user_logged_in')==true) redirect('home');
		$register_type = $this->input->post('register_type');
		$this->data['register_type']=$register_type;
		$this->data['content'] = 'content/login_register/register';
		$this->load->view('common/body', $this->data);	
	}

	function complete_profile($login_type=""){
		$this->data['login_type']=$login_type;
		$this->data['content'] = 'content/login_register/complete_register';
		$this->load->view('common/body', $this->data);
	}
	
	function process()
	{
		if(!$_POST)redirect('not_found');
		$email=$this->input->post('email');
		$check_email=$this->user_model->get_user_by_email($email);
		if(!$check_email){
			$check_email2=$this->user_model->get_user_by_email2($email);
			if(!$check_email2){
				$this->user_model->user_registration($email);
				$user_id=mysql_insert_id();
			}else {
				$user_id=$check_email2['id'];
			}
			
			//create activation code
			$code=md5(rand(0,100).$user_id.date('Y-m-d H:i:s'));
			$this->user_model->create_activation_code($user_id,$code);
			$_SESSION['email_regis'] = $email;
			redirect('registration/create_account'.'/'.$code.'/'.$user_id);
		}else {
			$this->data['err']='This email address is already registered';
			$this->data['email']=$email;
			$this->data['content'] = 'content/login_register/login_register';
			$this->load->view('common/body', $this->data);	
		}		
	}

	function do_register(){
		if(!$_POST)redirect('not_found');
		$email=$this->security->xss_clean($this->input->post('email'));
		$phone=$this->security->xss_clean($this->input->post('phone'));
		$name=$this->security->xss_clean($this->input->post('name'));
		$password=$this->input->post('password');
		$register_type=$this->input->post('register_type');

		$this->data['name']=$name;
		$this->data['phone']=$phone;
		$this->data['email']=$email;
		$this->data['password']=$password;
		$this->data['register_type']=$register_type;

		if(!$name && !$email && !$phone && !$password){
			$this->data['error'] = 'Nama harus di isi';
			$this->data['error_phone'] = 'Phone number harus di isi';
			$this->data['error_email'] = 'Email harus di isi';
			$this->data['error_password'] = 'Password harus di isi';
			$this->data['content'] = 'content/login_register/register';
			$this->load->view('common/body', $this->data);
		}
		else if($name==""){
			$this->data['error'] = 'Nama harus di isi';
			$this->data['content'] = 'content/login_register/register';
			$this->load->view('common/body', $this->data);
		}
		else if($phone==""){
			$this->data['error_phone'] = 'Phone number harus di isi';
			$this->data['content'] = 'content/login_register/register';
			$this->load->view('common/body', $this->data);
		}
		else if(!is_numeric($phone)){
			$this->data['error_phone'] = 'Phone number harus angka';
			$this->data['content'] = 'content/login_register/register';
			$this->load->view('common/body', $this->data);
		}
		else if($email==""){
			$this->data['error_email'] = 'Email harus di isi';
			$this->data['content'] = 'content/login_register/register';
			$this->load->view('common/body', $this->data);
		}
		else if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
			$this->data['error_email'] = 'Format email anda salah';
			$this->data['content'] = 'content/login_register/register';
			$this->load->view('common/body', $this->data);
		}
		else if($password==""){
			$this->data['error_password'] = 'Password harus di isi';
			$this->data['content'] = 'content/login_register/register';
			$this->load->view('common/body', $this->data);
		}
		else{

			$check_email=$this->user_model->get_user_by_email($email);
			if(!$check_email){
				$data=array('email'=>$email,
							'full_name'=>$name,
							'mobile'=>$phone,
							'password'=>md5($password),
							'created_date'=>date('Y-m-d H:i:s')
							);
				$check_email2=$this->user_model->get_user_by_email2($email);
				if(!$check_email2){
					$this->general_model->insert_data('user_tb',$data);
					$user_id=mysql_insert_id();
				}else {
					$user_id=$check_email2['id'];
				}
				$code=md5(rand(0,100).$user_id.date('Y-m-d H:i:s'));
				$this->user_model->create_activation_code($user_id,$code);

					$this->data['email']=$email;
					if($register_type==1){
						$this->data['verify_link']=site_url('registration/activation_success').'/'.$code.'/'.$user_id.'/'.'1';
					}else{
						$this->data['verify_link']=site_url('registration/activation_success').'/'.$code.'/'.$user_id;
					}
					//$this->data['cancel_link']=site_url('registration/cancel').'/'.$code.'/'.$user_id;
					
					$isi=$this->load->view('content/login_register/register_success',$this->data,TRUE);
					$this->load->library('email'); 	
					$this->email->from('noreply@toriokids.com');
					$this->email->to($email); 
					
					$this->email->subject('Registration Success');
		
					$this->email->message($isi); 
					
					$this->email->send();
					//echo $this->email->print_debugger();exit;

				//$this->session->set_flashdata('notif','Please check your email');
				redirect('registration/thanks');
			}
			else{
				$this->data['name']=$name;
				$this->data['phone']=$phone;
				$this->data['email']=$email;
				$this->data['password']=$password;
				$this->data['error_email'] = 'Email ini sudah terdaftar';
				$this->data['content'] = 'content/login_register/register';
				$this->load->view('common/body', $this->data);	
			}
		}
	}

	function do_complete_profile(){
		if(!$_POST)redirect('not_found');
		$email=$this->security->xss_clean($this->input->post('email'));
		$phone=$this->security->xss_clean($this->input->post('phone'));
		$name=$this->security->xss_clean($this->input->post('name'));
		$user_id=$this->input->post('user_id');
		$login_type=$this->input->post('login_type');

		$this->data['login_type'] = $login_type;
		$check_email = $this->user_model->check_email_all($email);
		$detail = $this->user_model->user_detail($user_id);
		if($name==""){
			$this->data['error'] = 'Name harus di isi';
			$this->data['content'] = 'content/login_register/complete_register';
			$this->load->view('common/body', $this->data);
		}
		else if($phone==""){
			$this->data['error_phone'] = 'Phone Number harus di isi';
			$this->data['content'] = 'content/login_register/complete_register';
			$this->load->view('common/body', $this->data);
		}
		else if($email==""){
			$this->data['error_email'] = 'Email harus di isi';
			$this->data['content'] = 'content/login_register/complete_register';
			$this->load->view('common/body', $this->data);
		}

		else if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
			$this->data['error_email'] = 'Format email salah';
			$this->data['content'] = 'content/login_register/complete_register';
			$this->load->view('common/body', $this->data);
		}
		else{
			if($detail['email']==$email){
				$data=array('full_name'=>$name,
						'mobile'=>$phone,
						'email'=>$email);
				$this->general_model->update_data('user_tb',$data,array('id'=>$user_id));

				if($login_type == 1){
					redirect('shopping_cart/customer_information');
				}
				else{
					redirect('home');
				}
			}
			else{
				if($check_email){
					$this->data['error_email'] = 'Email ini sudah di gunakan';
					$this->data['content'] = 'content/login_register/complete_register';
					$this->load->view('common/body', $this->data);
				}
				else{
					$data=array('full_name'=>$name,
						'mobile'=>$phone,
						'email'=>$email);
					$this->general_model->update_data('user_tb',$data,array('id'=>$user_id));

					if($login_type == 1){
					redirect('shopping_cart/customer_information');
					}
					else{
						redirect('home');
					}
				}
			}
			
		}
	}
	
	function activation_success($code,$user_id,$register_type="")
	{	
		$status=1;
		$this->user_model->update_user_status($user_id,$status);	
		$this->user_model->delete_user_activation($user_id,$code);
		$date=date("Y-m-d H:i:s");
		$database1 = array(  'activated_date'=>$date );
		$where = array('id'=>$user_id);		
		$this->user_model->update_data('user_tb',$database1, $where);
		$user = $this->user_model->user_detail($user_id);
		$sess_user = array (
							   'user_logged_in' => true,
							   'user_id' => $user['id'],
							   'email' => $user['email'],
							   'name' => $user['full_name']  
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
				
					//create new shopping cart		
					$this->shopping_cart_model->delete_session_shopping_cart($session_id);		
					$database2 = array(	'product_id'=>$product_id, 
							'sku_id'=>$sku_id,
							'user_id'=>$user_id,
							'quantity'=>$qty,
							'price'=>$price,
							'total'=>$total,
							'actual_weight'=>$actual_weight,
							'ceil_weight'=>$ceil_weight,
							'created_date'=>$date  );		
					$this->shopping_cart_model->insert_data('shopping_cart_tb',$database2);			
				
			}	
		}
		if($register_type==1){
			redirect('shopping_cart/customer_information');
		}
		else{
			redirect('home');
		}
	}
	
	function activation_error()
	{	
		$this->data['content']='content/login_register//login_register_error';
		$this->load->view('common/body',$this->data);
	} 	
	
	function thanks()
	{
		// if(isset($_SESSION['email_regis'])){
		// 	$this->data['email'] = $_SESSION['email_regis'];
		// 	$_SESSION['email_regis']=NULL;
		// }else $this->data['email'] = "";
		$this->data['content']='content/login_register/register_thank_you';
		$this->load->view('common/body',$this->data);
	}
	
	function cancel($code,$user_id,$code_id)
	{
		$user_data=$this->user_model->user_detail($user_id);
		$code_data=$this->user_model->check_user_activation_code($user_id,$code);
		
		if($user_data['status']==0){
			$this->user_model->delete_user($user_id);
			$this->user_model->delete_user_activation2($code_id);
			redirect('registration/cancelled');
		}
		else redirect('home');
	
	}
	
	function cancelled()
	{
		$this->data['content']='content/login_register/login_register_cancelled';
		$this->load->view('common/body',$this->data);
	}	
	
	function check_email()
	{		
		$email=$this->input->post('fieldValue');	
		$fieldId=$this->input->post('fieldId');
			
		$temp=$this->user_model->check_email($email);	
		
		if($temp)echo '["'.$fieldId.'",0]';
		else echo '["'.$fieldId.'",1]';
	}
	
	function check_email_registered()
	{		
		$email=$this->input->post('email');	
		$temp=$this->user_model->check_email($email);	
		if($temp)
			echo "2";
		else echo "1";
	}
	
	function load_city($id)
	{	
		$this->data['city']=$this->jne_model->get_city($id);
		$this->load->view('content/my_account/my_addresses_city_list',$this->data);
	}

	function create_account($code,$user_id)
	{
		$cek=$this->user_model->check_user_activation_code($user_id,$code);
		if($cek){
			$this->data['code']=$code;
			$this->data['user_id']=$user_id;
			$this->data['email'] = $_SESSION['email_regis'];
			$this->data['content']='content/login_register/create_account';
		}else {
			$this->data['content']='content/login_register/login_register_error2';
		}
			$this->load->view('common/body',$this->data);
	}

	function do_create_account($code,$user_id)
	{
		if(!$_POST)redirect('not_found');
		$data=$this->user_model->user_detail($user_id);
	
		if($data['status']==1)$status=0;
		else{
			$cek2=$this->user_model->check_user_activation_code($user_id,$code);
			if($cek2){
				$email=$this->input->post('email');
				$fullname=$this->input->post('fullname');
				$password=$this->input->post('password');
				$pass = trim($password);
				$database = array(  'full_name'=>$fullname, 
									'password'=>md5($pass));
				$where = array('id'=>$user_id);		
				$this->user_model->update_data('user_tb',$database, $where);
				
				$this->data['detail']=$email;
				$this->data['verify_link']=site_url('registration/activation_success').'/'.$code.'/'.$user_id;
				$this->data['cancel_link']=site_url('registration/cancel').'/'.$code.'/'.$user_id.'/'.$cek2['id'];
				
				$isi=$this->load->view('content/email_template/register_success',$this->data,TRUE);
				$this->load->library('email'); 	
				$this->email->from('noreply@toriokids.com');
				$this->email->to($email); 
				
				$this->email->subject('Registration Success');
	
				$this->email->message($isi); 
		
				$this->email->send();
				
				//newsletter
				$newsleter=$this->input->post('newsleter');
				if($newsleter){
					$date=date("Y-m-d");
					$status=1;
					$database = array(	'email'=>$email, 
										'created_date'=>$date,
										'activated_date'=>$date,
										'status'=>$status  );		
					$this->shopping_cart_model->insert_data('newsletter_tb',$database);	
				}
				redirect('registration/thanks');
			}
			else
				$status=0;
		}
	}
	
	
	function guest_mode(){
		$email=$this->session->userdata('email_address');//pre($_POST);
		
		//pre($this->session->userdata);
		//$this->session->userdata(array('email_address'=>''));
		if($_POST){
			$password=$this->input->post('password');
			
			
			$check_email=$this->user_model->check_email2($email);
			//pre($check_email);
			if($check_email['password']==''){
				//$this->user_model->user_registration($email);
				//$id=mysql_insert_id();
				$user_id=$check_email['id'];
				$this->user_model->update_registration_password(md5($password),$user_id);
				echo 'as';
					
				$status=1;
				$this->user_model->update_user_status($user_id,$status);
			
			}
			//else{
			//	echo "ASDSA";}
			
			redirect('registration/guest_mode_complete');
		}
		else show_404();
	}
	
	
	function guest_mode_complete()
	{
		
		
		$this->data['content']='content/login_register/login_register_success';
		$this->load->view('common/body',$this->data);
	}
	
}
?>