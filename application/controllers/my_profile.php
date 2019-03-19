<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class My_profile extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('user_logged_in')==false)redirect("login");	
		$this->load->model('user_model');	
		$this->load->model('jne_model');
		$this->load->model('general_model');	
		$this->data['page_title']="My Profile";
		$this->load->model('footer_menu_model');
		$this->data['footer'] = $this->footer_menu_model->get_active_footer_menu_list();
		$this->load->model('secondary_menu_model');
		$this->data['secondary'] = $this->secondary_menu_model->get_active_secondary_menu_list();
	}
	function index(){
		$user_id=$this->session->userdata('user_id');
		$profile= $this->user_model->user_detail($user_id);
		$this->data['change_profile']=0;
		$this->data['account']=$this->user_model->user_detail($user_id);
		$this->data['shipping']=$this->user_model->get_default_address($user_id);	
		$this->data['order_user']=$this->user_model->get_order_by_user2($user_id);		
		$this->data['content'] = 'content/profile/my_profile';
		$this->load->view('common/body', $this->data);	

	}


	function edit_profile()
	{	
		$id=$this->session->userdata('user_id');
		$this->data['account']=$this->user_model->user_detail($id);
		$this->data['page_title']="Edit Profile";
		$this->data['content'] = 'content/profile/edit_profile';
		$this->load->view('common/body', $this->data);			
	}

	function do_edit_profile(){
		$name = $this->security->xss_clean($this->input->post('name'));
		$email = $this->security->xss_clean($this->input->post('email'));
		$phone = $this->security->xss_clean($this->input->post('phone'));
		$birthday = $this->security->xss_clean($this->input->post('birthday'));
		$user_id = $this->session->userdata('user_id');

		$current_email = find('email',$user_id,'user_tb');
		//echo $current_email;exit;
		$this->data['account']=$this->user_model->user_detail($user_id);

		$check = $this->user_model->check_email_all($email);
		if(!$name){
			$this->data['error'] = 'Please enter your name';
			$this->data['content'] = 'content/profile/edit_profile';
			$this->load->view('common/body', $this->data);
		}
		else if(!$email){
			$this->data['error_email'] = 'Please enter your email';
			$this->data['content'] = 'content/profile/edit_profile';
			$this->load->view('common/body', $this->data);
		}
		else if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
			$this->data['error_email'] = 'Invalid email format';
			$this->data['content'] = 'content/profile/edit_profile';
			$this->load->view('common/body', $this->data);
		}
		else if(!$phone){
			$this->data['error_phone'] = 'Please enter your phone number';
			$this->data['content'] = 'content/profile/edit_profile';
			$this->load->view('common/body', $this->data);
		}
		else if(!is_numeric($phone)){
			$this->data['error_phone'] = 'Phone number must be number';
			$this->data['content'] = 'content/profile/edit_profile';
			$this->load->view('common/body', $this->data);
		}
		else if(!$birthday){
			$this->data['error_birthday'] = 'Please enter your birthday';
			$this->data['content'] = 'content/profile/edit_profile';
			$this->load->view('common/body', $this->data);
		}
		else{

			if($email == $current_email){
				$prev = find('profile_picture',$user_id,'user_tb');
				$image_path = realpath(APPPATH . '../userdata/profile_picture');
				$pospic = $image_path."/".$prev;

					$config['upload_path'] = 'userdata/profile_picture';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['encrypt_name'] = TRUE;

					$this->load->library('upload');
					$this->upload->initialize($config);

					if ($this->upload->do_upload('image'))
					{	
						if(file_exists($pospic)){
								unlink($pospic);
							}

						$data = $this->upload->data('image');
						$image =  $data['file_name'];
					}
					else{
						$image=$prev;
					}		

				$data=array('full_name'=>$name,
							'email'=>$email,
							'telephone'=>$phone,
							'date_of_birth'=>$birthday,
							'profile_picture'=>$image);
				$this->general_model->update_data('user_tb',$data,array('id'=>$user_id));

				redirect('my_profile/edit_profile');
			}
			else{
				if($check){
					$this->session->set_flashdata('notif','Email sudah di pakai');
					redirect('my_profile/edit_profile');
				}
				else{
					$prev = find('profile_picture',$user_id,'user_tb');
					$image_path = realpath(APPPATH . '../userdata/profile_picture');
					$pospic = $image_path."/".$prev;

						$config['upload_path'] = 'userdata/profile_picture';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['encrypt_name'] = TRUE;

						$this->load->library('upload');
						$this->upload->initialize($config);

						if ($this->upload->do_upload('image'))
						{	
							if(file_exists($pospic)){
									unlink($pospic);
								}

							$data = $this->upload->data('image');
							$image =  $data['file_name'];
						}
						else{
							$image=$prev;
						}		

					$data=array('full_name'=>$name,
								'email'=>$email,
								'telephone'=>$phone,
								'date_of_birth'=>$birthday,
								'profile_picture'=>$image);
					$this->general_model->update_data('user_tb',$data,array('id'=>$user_id));

					redirect('my_profile/edit_profile');
				}
			}
		}
		
	}

	function edit_password(){
		$this->data['page_title']="Edit Password";
		$this->data['content'] = 'content/profile/edit_password';
		$this->load->view('common/body', $this->data);	
	}

	function do_edit_password()
	{
		
		$id=$this->session->userdata('user_id');
		$current_pass=$this->input->post('current_pass');	
		$newpassword=$this->input->post('new_pass');
		$confirm_password=$this->input->post('confirm_pass');
		$a=md5($current_pass);
		$data=$this->user_model->get_id($id);
		if(!$current_pass){
			$this->data['new']=$newpassword;
			$this->data['cur']=$current_pass;
			$this->data['con']=$confirm_password;
			$this->data['error_cur'] = 'Please enter your current password';
			$this->data['content'] = 'content/profile/edit_password';
			$this->load->view('common/body', $this->data);
		}
		else if(!$newpassword){
			$this->data['new']=$newpassword;
			$this->data['cur']=$current_pass;
			$this->data['con']=$confirm_password;
			$this->data['error_new'] = 'Please enter your new password';
			$this->data['content'] = 'content/profile/edit_password';
			$this->load->view('common/body', $this->data);
		}
		else if(!$confirm_password){
			$this->data['new']=$newpassword;
			$this->data['cur']=$current_pass;
			$this->data['con']=$confirm_password;
			$this->data['error_con'] = 'Please enter your confirm password';
			$this->data['content'] = 'content/profile/edit_password';
			$this->load->view('common/body', $this->data);
		}
		else if($newpassword != $confirm_password){
			$this->data['new']=$newpassword;
			$this->data['cur']=$current_pass;
			$this->data['con']=$confirm_password;
			$this->data['error_con'] = 'Confirm password must same with new password';
			$this->data['content'] = 'content/profile/edit_password';
			$this->load->view('common/body', $this->data);
		}
		else{
			if ($a==$data['password']){
				
				$this->user_model->update_password($id,$newpassword);
				//$_SESSION['flag3']=1;
				$this->session->set_flashdata('notif','Password successfully changed');
				redirect('my_profile/edit_password');
			}
			else
			{
				$this->data['new']=$newpassword;
				$this->data['cur']=$current_pass;
				$this->data['con']=$confirm_password;
				$this->data['error_cur'] = 'Your Current password is incorrect';
				$this->data['content'] = 'content/profile/edit_password';
				$this->load->view('common/body', $this->data);
			}
		}
	}

	function my_address(){
		$user_id=$this->session->userdata('user_id');
		$address=$this->user_model->get_address_by_user($user_id);
		$this->data['account']=$this->user_model->user_detail($user_id);
		$this->data['address']=$this->user_model->get_address_by_user($user_id);
		$this->data['content'] = 'content/profile/my_address';
		$this->load->view('common/body', $this->data);
	}

	function add_address($address_type=""){
		$address_type = $this->input->post('address_type');
		$this->data['address_type']=$address_type;
		$this->data['province']=$this->jne_model->get_jne_province_data();
		$this->data['content'] = 'content/profile/add_address';
		$this->load->view('common/body', $this->data);
	}

	function do_add_address(){
		$user_id = $this->input->post('user_id');
		$label = $this->security->xss_clean($this->input->post('label'));
		$name = $this->security->xss_clean($this->input->post('name'));
		$phone = $this->security->xss_clean($this->input->post('phone'));
		$shipping_address = $this->security->xss_clean($this->input->post('shipping_address'));
		$personal_city = $this->security->xss_clean($this->input->post('personal_city'));
		$zipcode = $this->security->xss_clean($this->input->post('zipcode'));
		$city_name = $this->security->xss_clean($this->input->post('city'));
		if($personal_city!=0){
			$api = api_get_city($personal_city);
			$province = $api['jne_province_id'];
		}
		$address_type = $this->input->post('address_type');

		$this->data['address_type']=$address_type;
		$this->data['label']=$label;
		$this->data['phone']=$phone;
		$this->data['address']=$shipping_address;
		$this->data['city']=$personal_city;
		$this->data['zipcode']=$zipcode;
		$this->data['city_name']=$city_name;
		$this->data['name']=$name;

			$find_default = $this->user_model->get_default_address($user_id);
			if($find_default){
				$default = 0;
			}
			else{
				$default = 1;
			}
		if(!$label){
			$this->data['error_label'] = 'Please specify a label name for this address';
			$this->data['content'] = 'content/profile/add_address';
			$this->load->view('common/body', $this->data);
		}
		else if(!$name){
			$this->data['error_name'] = 'Please enter your name';
			$this->data['content'] = 'content/profile/add_address';
			$this->load->view('common/body', $this->data);
		}
		else if(!$phone){
			$this->data['error_phone'] = 'Please enter your phone number';
			$this->data['content'] = 'content/profile/add_address';
			$this->load->view('common/body', $this->data);
		}
		else if(!is_numeric($phone)){
			$this->data['error_phone'] = 'Phone number must be number';
			$this->data['content'] = 'content/profile/add_address';
			$this->load->view('common/body', $this->data);
		}
		else if(!$shipping_address){
			$this->data['error_address'] = 'Please enter your address';
			$this->data['content'] = 'content/profile/add_address';
			$this->load->view('common/body', $this->data);
		}
		else if(!$personal_city){
			$this->data['error_city'] = 'Please select a city / area from the selection provided';
			$this->data['content'] = 'content/profile/add_address';
			$this->load->view('common/body', $this->data);
		}
		else if(!$zipcode){
			$this->data['error_zipcode'] = 'Please enter your zip code';
			$this->data['content'] = 'content/profile/add_address';
			$this->load->view('common/body', $this->data);
		}
		else{
			$data = array('shipping_address'=>$shipping_address,
						'recipient_name'=>$name,
						'phone'=>$phone,
						'label'=>$label,
						'city'=>$personal_city,
						'province'=>$province,
						'zipcode'=>$zipcode,
						'user_id'=>$user_id,
						'default_address'=>$default);
			$this->general_model->insert_data('user_address_tb',$data);

			if($address_type==1){
				redirect('shopping_cart/customer_information');
			}
			else{
				redirect('my_profile/my_address');
			}
		}
	}

	function edit_address($id){
		$user_id=$this->session->userdata('user_id');
		$temp = $this->user_model->get_address($id);
		if($temp['user_id']==$user_id){
			$this->data['province']=$this->jne_model->get_jne_province_data();
			$this->data['city']=$this->jne_model->get_jne_city_data();
			$this->data['account']=$this->user_model->user_detail($user_id);
			$this->data['address']=$temp;
			$this->data['content'] = 'content/profile/my_address_edit';
			$this->load->view('common/body',$this->data);
		}else redirect('not_found');
	}

	function do_edit_address(){
		$label = $this->security->xss_clean($this->input->post('label'));
		$name = $this->security->xss_clean($this->input->post('name'));
		$user_id=$this->session->userdata('user_id');
		$phone = $this->security->xss_clean($this->input->post('phone'));
		$shipping_address = $this->security->xss_clean($this->input->post('shipping_address'));
		$personal_city = $this->security->xss_clean($this->input->post('personal_city'));
		$province = $this->security->xss_clean($this->input->post('province'));
		$zipcode = $this->security->xss_clean($this->input->post('zipcode'));
		if($personal_city!=0){
			$api = api_get_city($personal_city);
			$province = $api['jne_province_id'];
		}
		$id = $this->input->post('id');
		
		$temp = $this->user_model->get_address($id);
		$this->data['address']=$temp;
		$user_id = $this->session->userdata('user_id');

		if(!$label){
			$this->data['error_label'] = 'Please specify a label name for this address';
			$this->data['content'] = 'content/profile/my_address_edit';
			$this->load->view('common/body', $this->data);
		}
		else if(!$name){
			$this->data['error_name'] = 'Please enter your name';
			$this->data['content'] = 'content/profile/my_address_edit';
			$this->load->view('common/body', $this->data);
		}
		else if(!$phone){
			$this->data['error_phone'] = 'Please enter your phone number';
			$this->data['content'] = 'content/profile/my_address_edit';
			$this->load->view('common/body', $this->data);
		}
		else if(!is_numeric($phone)){
			$this->data['error_phone'] = 'Phone number must be number';
			$this->data['content'] = 'content/profile/my_address_edit';
			$this->load->view('common/body', $this->data);
		}
		else if(!$shipping_address){
			$this->data['error_address'] = 'Please enter your address';
			$this->data['content'] = 'content/profile/my_address_edit';
			$this->load->view('common/body', $this->data);
		}
		else if(!$personal_city){
			$this->data['error_city'] = 'Please select a city / area from the selection provided';
			$this->data['content'] = 'content/profile/my_address_edit';
			$this->load->view('common/body', $this->data);
		}
		else if(!$zipcode){
			$this->data['error_zipcode'] = 'Please enter your zip code';
			$this->data['content'] = 'content/profile/my_address_edit';
			$this->load->view('common/body', $this->data);
		}
		else{

			$check = $this->user_model->check_email_all($email);
			// if($check){
			// 	$this->session->set_flashdata('notif','Email sudah di pakai');
			// 	redirect('my_profile/edit_address/'.$id);
			// }
			// else{
				$data = array('shipping_address'=>$shipping_address,
							'label'=>$label,
							'phone'=>$phone,
							'province'=>$province,
							'city'=>$personal_city,
							'zipcode'=>$zipcode);
				$this->general_model->update_data('user_address_tb',$data,array('id'=>$id));
				redirect('my_profile/my_address');
			//}
		}
	}

	function do_set_default($addr_id)
	{	
		$user_id=$this->session->userdata('user_id');
		$user_id2=find('user_id', $addr_id, 'user_address_tb');
		if($user_id!=$user_id2)redirect('not_found');
		$this->user_model->set_as_default_address($addr_id,$user_id);
		redirect($_SERVER['HTTP_REFERER']);
	}



}
?>