<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Setting extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('employee_model');
		$this->load->model('general_model');
		
	}
	
	function index(){redirect('home');}
	
	function change_password(){
		$this->data['page'] = 'setting/change_password';
		$this->load->view('common/body', $this->data);
	}
	function do_change_password(){
		$old_password=$this->input->post('old_password');
			$newdate=date("Y-m-d H:i:s");
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
							$_SESSION['change_password_errror']='your password successfully changed';
						}else{
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
	}
	
	function auto_approver(){
		$this->load->model('setting_model');
		$this->load->model('employee_model');
		$this->data['detail']=$this->setting_model->get_auto_approve();
		$this->data['employee_list'] = $this->employee_model->show_employee_active();
		$this->data['page'] = 'setting/auto_approver';
		$this->load->view('common/body', $this->data);
	}
	
	function do_set_auto_approve(){
		$bs_approver=$this->input->post('bs_approver');
		$cash_payment_approver=$this->input->post('cash_payment_approver');
		$this->load->model('setting_model');
		$updated_date=date("Y-m-d H:i:s");
		$updated_by = $this->session->userdata('employee_id');
		$this->setting_model->set_auto_approve($bs_approver,$cash_payment_approver,$updated_date,$updated_by);
		$_SESSION['notif']='Update Success';
		redirect('setting/auto_approver');
	}
	
	function approval_list(){
		$this->load->model('setting_model');
		$this->load->model('employee_model');
		$this->data['approval']=$this->setting_model->get_approval_list();
		$this->data['employee_list'] = $this->employee_model->show_employee_active();
		$this->data['page'] = 'setting/rf_approver';
		$this->load->view('common/body', $this->data);
	}
	
	function do_set_approval(){
		$this->load->model('setting_model');
		$approval_1=$this->input->post('approval_1');
		$approval_2=$this->input->post('approval_2');
		$approval_3=$this->input->post('approval_3');
		$approval_4=$this->input->post('approval_4');
		
		$this->setting_model->clear_approval();
		
		$type=0;//approval 1
		if($approval_1)foreach($approval_1 as $list){
			
			$this->setting_model->insert_approval($type,$list);
		}
		$type=1;//approval 2
		if($approval_2)foreach($approval_2 as $list){
			
			$this->setting_model->insert_approval($type,$list);
		}
		$type=2;//approval 3
		if($approval_3)foreach($approval_3 as $list){
			
			$this->setting_model->insert_approval($type,$list);
		}
		$type=3;//approval 4
		if($approval_4)foreach($approval_4 as $list){
			
			$this->setting_model->insert_approval($type,$list);
		}
		$_SESSION['notif']='Update Success';
		redirect('setting/approval_list');
	}
}