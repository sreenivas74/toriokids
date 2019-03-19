<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Change_password extends Ext_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('employee_model');
		$this->load->model('general_model');
		
	}
	
	function index(){
		$this->data['page'] = 'setting/change_password2';
		$this->load->view('common/body', $this->data);
	}
	function do_change_password(){
		$newdate=date("Y-m-d H:i:s");
		$old_password=$this->input->post('old_password');
		$new_password=$this->input->post('new_password');
		$confirm_new_password=$this->input->post('confirm_new_password');
		$employee_id=$this->session->userdata('employee_id');
		
			$cek_password_baru=md5($new_password);
		if($old_password !='' && $new_password !='' && $confirm_new_password!=''){
			
				if($new_password==$confirm_new_password){
			
					
					$data=$this->employee_model->show_administrator_employee_by_id($employee_id);
					$old_password=md5($old_password);
						if($data['password']==$cek_password_baru){
							$_SESSION['change_password_errror']='your password matching with last password';
						
						
							
						}elseif($data['password']!=$cek_password_baru && $data['password']==$old_password){
							
							
							$database=array('password'=>md5($confirm_new_password),'last_change_password'=>$newdate);
							$where=array('employee_id'=>$employee_id);
							$this->general_model->update_data('administrator_tb',$database,$where);
							$sess_admin = array (
										   'admin_logged_in' => TRUE,
										);
								$this->session->set_userdata($sess_admin);
							
							redirect ('home');	
						}
						
						else{
							$_SESSION['change_password_errror']='your old password not correct';
						}
					
					}else{
						//echo'2';
					$_SESSION['change_password_errror']='your new password and confirm new password not match';
				}
		
		}else{
			$_SESSION['change_password_errror']='please fill all data';
		
		
		}
		redirect($_SERVER['HTTP_REFERER']);
	}}