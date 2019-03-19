<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Ticket extends Ext_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('schedule_model');
		$this->load->model('ticket_model');
		$this->load->model('flexigrid_model');
	}
	
	function index(){
		$login = $this->input->post('login');
		$password = $this->input->post('password');
		
		if($login && $password){
			
			$data = $this->ticket_model->login($login,$password);
			
			if($data){
				$this->data['login'] = $login;
				$this->data['password'] = $password;
				$this->data['ticket_detail'] = $this->ticket_model->show_ticket_history($login);
				$this->data['page'] = 'ticket_history';
			}else{
				$_SESSION['admin_notif'] = 'Login and Password are incorrect';	
				redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			$this->data['page'] = 'ticket';
		}
		
		$this->load->view('common/body', $this->data);
	}
	
	function add_ticket(){
		$name = $this->input->post('name');
		$phone = $this->input->post('phone');
		$email = $this->input->post('email');
		$complaint = $this->input->post('complaint');
		$pic = $this->input->post('pic');
		
		if(!$name && !$email && !$complaint && !$pic){
			$_SESSION['required_field'] = '*required field';	
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		
		$created_date = date('Y-m-d H:i:s');
		$created_by = $_SERVER['REMOTE_ADDR'];
		
		$this->ticket_model->do_add_ticket($name,$phone,$email,$complaint,$pic,$created_date,$created_by);
		$ticket_number = mysql_insert_id();
		
		//send email
		$subject = "Ticket #".date('y').date('m').$ticket_number;
		$to_email = "CS@CCTVCameraIndonesia.com";
		$from = $email;
		$email_content = "
			Problem : ".nl2br(esc($complaint))."<br />
			Nama PT : ".esc($name)."<br />
			Contact Person : ".esc($pic)."<br />
			Phone : ".esc($phone)."<br /><br />
			
		";
		$this->load->library('email'); 
		$this->email->from($from);
		$this->email->to($to_email);
			
		$this->email->subject($subject);
		$this->email->message($email_content);  
		$this->email->send();
		//
		$_SESSION['required_field'] = 'Ticket has been sent..please wait our response..<br />Thank you';
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function add_ticket_admin(){
		$name = $this->input->post('name');
		$phone = $this->input->post('phone');
		$email = $this->input->post('email');
		$complaint = $this->input->post('complaint');
		$pic = $this->input->post('pic');
		
		if(!$name && !$email && !$complaint && !$pic){
			$_SESSION['required_field'] = '*required field';	
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		$created_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userdata('admin_id');
		
		$this->ticket_model->do_add_ticket($name,$phone,$email,$complaint,$pic,$created_date,$created_by);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function do_add_problem(){
		$problem = $this->input->post('problem');
		$ticket_id = $this->input->post('ticket_id');
		$login = $this->input->post('login');
		$password = $this->input->post('password');
		if(!$problem){
			$_SESSION['ticket_notif'] = 'Problem cannot be empty..';
		}else{
			if(find_4_string('problem','ticket_id',$ticket_id,'problem',$problem,'ticket_response_tb')!=$problem){
				$send_date_2 = date('Y-m-d H:i:s');
				$this->ticket_model->do_add_problem($ticket_id,$problem,$send_date_2);
				//send email
				$subject = "Ticket #".$login;
				$to_email = "CS@CCTVCameraIndonesia.com";
				$from = $password;
				$email_content = "
					Problem : ".nl2br(esc($problem))."<br />
					Nama PT : ".esc(find('name',$ticket_id,'ticket_tb'))."<br />
					Contact Person : ".esc(find('pic',$ticket_id,'ticket_tb'))."<br />
					Phone : ".esc(find('phone',$ticket_id,'ticket_tb'))."
				";
				$this->load->library('email'); 
				$this->email->from($from);
				$this->email->to($to_email);
					
				$this->email->subject($subject);
				$this->email->message($email_content);  
				$this->email->send();
				//
				
				if(find('employee_id',$ticket_id,'ticket_tb')){
					//send email to assigne employee
					$to_email = '';
					$employee_id = explode('|'.find('employee_id',$ticket_id,'ticket_tb'));
					if($employee_id)foreach($employee_id as $list){
						if(find('email',$list,'employee_tb')){
							$to_email.= find('email',$list,'employee_tb').";"; 	
						}
					}
					
					$subject = "Ticket #".$login;
					
					$from = $password;
					$email_content = "
						Problem : ".nl2br(esc($problem))."<br />
						Nama PT : ".esc(find('name',$ticket_id,'ticket_tb'))."<br />
						Contact Person : ".esc(find('pic',$ticket_id,'ticket_tb'))."<br />
						Phone : ".esc(find('phone',$ticket_id,'ticket_tb'))."
					";
					$this->load->library('email'); 
					$this->email->from($from);
					$this->email->to($to_email);
						
					$this->email->subject($subject);
					$this->email->message($email_content);  
					$this->email->send();
					//
				}
			}
		}
		
		$this->data['login'] = $login;
		$this->data['password'] = $password;
		$this->data['ticket_detail'] = $this->ticket_model->show_ticket_history($login);
		$this->data['page'] = 'ticket_history';
		
		$this->load->view('common/body', $this->data);
	}
	
	function ticket_list(){
		if(!$this->session->userdata('admin_id'))redirect($_SERVER['HTTP_REFERER']);
		
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","ticket/ticket_list","privilege_tb"))redirect('home');
		$this->data['resource_list'] = $this->ticket_model->show_resource_active();
		$this->data['employee_active'] = $this->ticket_model->show_employee_active();
		$this->data['ticket_open_list'] = $this->ticket_model->show_ticket_open();
		$this->data['ticket_close_list'] = $this->ticket_model->show_ticket_close();
		$this->data['page'] = 'ticket/ticket_list';
		$this->load->view('common/body', $this->data);
	}
	
	function delete_ticket($id){
		$this->ticket_model->delete_ticket($id);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function do_edit_ticket($id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","ticket/ticket_list","privilege_tb"))redirect('home');
		if(!$this->session->userdata('admin_id'))redirect($_SERVER['HTTP_REFERER']);
		
		$respond = $this->input->post('respond');
		$project_id = $this->input->post('project_id');
		$status = $this->input->post('status');
		
		$last_update = date('Y-m-d H:i:s');
		$last_update_by = $this->session->userdata('admin_id');
		
		if($status == 1 && !$respond && !$project_id){
			$_SESSION['ticket_notif'] = "Project / Respond can't be empty";
			redirect('ticket/ticket_list#ticket_notif');
		}elseif($status == 1 && !$respond ){
			$_SESSION['ticket_notif'] = 'Respond is empty';
			redirect('ticket/ticket_list#ticket_notif');
		}elseif($status == 1){
			$close_date = date('Y-m-d H:i:s');
			
		}else{
			$close_date = '';
		}
		
		//send email
			$data = $this->ticket_model->show_ticket_by_id($id);
			
			$year = date('y',strtotime($data['created_date']));
			$month = date('m',strtotime($data['created_date']));
			
			$subject = "Ticket #".$year.$month.$id;
			$to_email = $data['email'];
			$from = "CS@CCTVCameraIndonesia.com";
			$email_content = "
				Problem : ".nl2br(esc($data['complaint']))."<br /><br />
				Respond : ".nl2br(esc($respond))."
				<br /><br /><br />
				This is your login and password to see your ticket history,<br />
				login : ".$year.$month.$id."<br />
				password : ".$data['email']."
			";
			//echo $email_content."<br />".$to_email."<br />".$subject;exit;
			$this->load->library('email'); 
			$this->email->from($from);
			$this->email->to($to_email);
				
			$this->email->subject($subject);
			$this->email->message($email_content);  
			$this->email->send();
			//
			
			if(find('employee_id',$id,'ticket_tb')){
				//send email to assigne employee
				$to_email = '';
				$employee_id = explode('|'.find('employee_id',$id,'ticket_tb'));
				if($employee_id)foreach($employee_id as $list){
					if(find('email',$list,'employee_tb')){
						$to_email.= find('email',$list,'employee_tb').";"; 	
					}
				}
				
				$subject = "Ticket #".$year.$month.$id;
				$to_email = $data['email'];
				$from = "CS@CCTVCameraIndonesia.com";
				$email_content = "
					Problem : ".nl2br(esc($data['complaint']))."<br /><br />
					Respond : ".nl2br(esc($respond))."
				";
				
				$this->load->library('email'); 
				$this->email->from($from);
				$this->email->to($to_email);
					
				$this->email->subject($subject);
				$this->email->message($email_content);  
				$this->email->send();
			}
			
		
		$this->ticket_model->do_edit_ticket($id,$project_id,$respond,$status,$last_update,$last_update_by,$close_date);
		$_SESSION['ticket_notif'] = 'Ticket Updated';
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function do_add_response($ticket_id){
		$status = $this->input->post('status');
		$response = $this->input->post('response');
		$send_date = date('Y-m-d H:i:s');
		$send_by = $this->session->userdata('admin_id');
		
		$this->ticket_model->do_add_response($ticket_id,$response,$send_date,$send_by);
		
		if($status == 1){
			$this->ticket_model->change_ticket_status($ticket_id,$status);	
		}
		
		//send email
		$data = $this->ticket_model->show_ticket_by_id($ticket_id);
		$year = date('y',strtotime($data['created_date']));
		$month = date('m',strtotime($data['created_date']));
		
		$subject = "Ticket #".$year.$month.$ticket_id;
		$to_email = $data['email'];
		$from = "CS@CCTVCameraIndonesia.com";
		$email_content = "
			Respond : ".nl2br(esc($response))."
			<br />
			This is your login and password to see your ticket history,<br />
			login : ".$year.$month.$ticket_id."<br />
			password : ".$data['email']."
		";
		$this->load->library('email');
		$this->email->from($from);
		$this->email->to($to_email);
			
		$this->email->subject($subject);
		$this->email->message($email_content);  
		$this->email->send();
		//
		
		if(find('employee_id',$ticket_id,'ticket_tb')){
			//send email to assigne employee
			$to_email = '';
			$employee_id = explode('|'.find('employee_id',$ticket_id,'ticket_tb'));
			if($employee_id)foreach($employee_id as $list){
				if(find('email',$list,'employee_tb')){
					$to_email.= find('email',$list,'employee_tb').";"; 	
				}
			}
			
			$subject = "Ticket #".$year.$month.$ticket_id;
			$to_email = $data['email'];
			$from = "CS@CCTVCameraIndonesia.com";
			$email_content = "
				Problem : ".find('complaint',$ticket_id,'ticket_tb')."<br>
				Respond : ".nl2br(esc($response))."
			";
			$this->load->library('email');
			$this->email->from($from);
			$this->email->to($to_email);
				
			$this->email->subject($subject);
			$this->email->message($email_content);  
			$this->email->send();
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function assigned_to($ticket_id){
		$assigned_to = $this->input->post('assigned_to');
		$employee_id = '';		
		if($assigned_to)foreach($assigned_to as $list){
			$employee_id.=$list.'|';
		}
		
		$this->ticket_model->add_assigned_to($ticket_id,$employee_id);
		
		//add to job tracking
		if($employee_id){
			$data = $this->ticket_model->show_ticket_by_id($ticket_id);
			$employee_activity_category_id = 4;
			$created_date = date('Y-m-d');
			$assign_date = date('Y-m-d');
			$assigned_to = $employee_id;
			$assign_time = $this->input->post('assign_time');
			$resource_id = $this->input->post('resource_id');
			$description = $this->input->post('description');
			//$this->ticket_model->close_job_tracking($data['project_id']);
			
			//$this->ticket_model->add_to_job_tracking($ticket_id,$data['project_id'],$data['complaint'],$employee_id,$employee_activity_category_id,$created_date);
			//created job tracking if not exist
			if(!find_2('id','project_id',$data['project_id'],'job_tracking_tb')){
				$this->ticket_model->add_to_job_tracking($ticket_id,$data['project_id'],$data['complaint'],$employee_id,$employee_activity_category_id,$created_date);
				
				$job_tracking_id = mysql_insert_id();
				if(!find_4_string('id','job_tracking_id',$job_tracking_id,'assign_date',$assign_date,'job_tracking_log_tb')){
					$this->schedule_model->add_assign_to($job_tracking_id,$assign_date,$assigned_to,$assign_time,$resource_id,$description);
				}else{
					$this->schedule_model->edit_assign_to($job_tracking_id,$assign_date,$assigned_to,$assign_time,$resource_id,$description);	
				}
			}else{
				$job_tracking_id = find_2('id','project_id',$data['project_id'],'job_tracking_tb');
				if(!find_4_string('id','job_tracking_id',$job_tracking_id,'assign_date',$assign_date,'job_tracking_log_tb')){
					$this->schedule_model->add_assign_to($job_tracking_id,$assign_date,$assigned_to,$assign_time,$resource_id,$description);
				}else{
					$this->schedule_model->edit_assign_to($job_tracking_id,$assign_date,$assigned_to,$assign_time,$resource_id,$description);	
				}
			}
			
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
}?>