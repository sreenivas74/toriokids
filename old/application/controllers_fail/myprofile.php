<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Myprofile extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('myprofile_model');
		$this->load->model('flexigrid_model');
	}
	
	function index(){
		redirect('home');
	}
		
	function detail_profile(){
		$this->data['privilege'] = $this->myprofile_model->show_privilege();
		$this->data['company'] = $this->myprofile_model->show_company();
		$this->data['department'] = $this->myprofile_model->show_department();
		$this->data['user_login'] = $this->myprofile_model->show_admin_by_id($this->session->userdata('admin_id'));
		$this->data['employee'] = $this->myprofile_model->show_employee_by_id($this->session->userdata('employee_id'));
		$this->data['page'] = "myprofile/detail_profile";
		$this->load->view('common/body',$this->data);
	}
	
	function update_user_login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$this->myprofile_model->update_user_login($this->session->userdata('admin_id'),$username,$password);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function do_edit_employee($id){
		$privilege_id = $this->input->post('privilege_id');
		$category = $this->input->post('category');
		$firstname = $this->input->post('firstname');	
		$lastname = $this->input->post('lastname');
		$company_id = $this->input->post('company_id');
		$nik = $this->input->post('nik');
		$join_date = $this->input->post('join_date');
		$birth_date = $this->input->post('birth_date');
		$birth_place = $this->input->post('birth_place');
		$education = $this->input->post('education');
		$school = $this->input->post('school');
		$certificate = $this->input->post('certificate');
		$grade = $this->input->post('grade');
		$department_id = $this->input->post('department_id');
		$job_title = $this->input->post('job_title');
		$no_ktp = $this->input->post('no_ktp');
		$address_ktp = $this->input->post('address_ktp');
		$address_now = $this->input->post('address_now');
		$gsm_1 = $this->input->post('gsm_1');
		$gsm_2 = $this->input->post('gsm_2');
		$phone = $this->input->post('phone');
		$pin_bb = $this->input->post('pin_bb');
		$email = $this->input->post('email');
		$name_reference = $this->input->post('name_reference');
		$phone_reference = $this->input->post('phone_reference');
		$relation_reference = $this->input->post('relation_reference');
		$marriage_status = $this->input->post('marriage_status');
		$wife = $this->input->post('wife');
		$child = $this->input->post('child');
		$religion = $this->input->post('religion');
		$account_number = $this->input->post('account_number');
		$sim_a = $this->input->post('sim_a');
		$sim_c = $this->input->post('sim_c');
		$motor = $this->input->post('motor');
		$status = $this->input->post('status');
		
		$this->myprofile_model->do_edit_employee($id,$category,$firstname,$lastname,$company_id,$nik,$join_date,$birth_date,$birth_place,$education,$school,$certificate,$grade,$department_id,$job_title,$no_ktp,$address_ktp,$address_now,$gsm_1,$gsm_2,$phone,$pin_bb,$email,$name_reference,$phone_reference,$relation_reference,$marriage_status,$wife,$child,$religion,$account_number,$sim_a,$sim_c,$motor,$status,$privilege_id);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
}?>