<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Report extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('flexigrid_model');
		$this->load->model('report_model');
	}
	
	function index(){
		redirect('home');
	}
	
	/////////////////////
	//project goal//////
	////////////////////
	function list_project_goal_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_project_goal_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_project_goal_report_2","privilege_tb")){
			$this->data['page'] = 'report/list_project_goal_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function list_project_goal_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_project_goal_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_project_goal_report_2","privilege_tb")){
			$quarter = $this->input->post('quarter');
			$year = $this->input->post('year');
			
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['project'] = $this->report_model->show_project_goal($quarter,$year);
			
			$this->data['quarter'] = $quarter;
			$this->data['year_selected'] = $year;
			
			$this->data['page'] = 'report/list_project_goal_report_selected';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
	}
	///////////////
	//outstanding//
	//
	function list_outstanding_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_outstanding_report","privilege_tb")){
			$this->data['page'] = 'report/list_outstanding_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function list_outstanding_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_outstanding_report","privilege_tb")){
			$quarter = $this->input->post('quarter');
			$year = $this->input->post('year');
			
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['project'] = $this->report_model->show_outstanding_report($quarter,$year);
			
			$this->data['quarter'] = $quarter;
			$this->data['year_selected'] = $year;
			
			$this->data['page'] = 'report/list_outstanding_report_selected';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
	}
	//////////////////////
	//CRM//////
	////////////////////
	function list_crm_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_crm_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_crm_report_2","privilege_tb")){
			$this->data['page'] = 'report/list_crm_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function list_crm_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_crm_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_crm_report_2","privilege_tb")){
			$quarter = $this->input->post('quarter');
			$year = $this->input->post('year');
			$based = $this->input->post('based');
			
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['project'] = $this->report_model->show_crm();
			
			$this->data['quarter'] = $quarter;
			$this->data['year_selected'] = $year;
			$this->data['based'] = $based;
			
			$this->data['page'] = 'report/list_crm_report_selected';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
	}
	
	///payment report
	function list_payment_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_payment_report","privilege_tb")){
			$this->data['page'] = 'report/list_payment_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function list_payment_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_payment_report","privilege_tb")){
			$quarter = $this->input->post('quarter');
			$year = $this->input->post('year');
			
			$this->data['payment'] = $this->report_model->show_payment($quarter,$year);
			$this->data['invoice'] = $this->report_model->show_total_invoice($quarter,$year);
			$this->data['outstanding'] = $this->report_model->show_outstanding($quarter,$year);
			
			$this->data['quarter'] = $quarter;
			$this->data['year_selected'] = $year;
			
			$this->data['page'] = 'report/list_payment_report_selected';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
	}
	////////
	
	///survey report
	function list_survey_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_survey_report","privilege_tb")){
			$this->data['page'] = 'report/list_survey_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function list_survey_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_survey_report","privilege_tb")){
			$quarter = $this->input->post('quarter');
			$year = $this->input->post('year');
			
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['project'] = $this->report_model->show_project_goal_survey($quarter,$year);
			
			$this->data['quarter'] = $quarter;
			$this->data['year_selected'] = $year;
			
			$this->data['page'] = 'report/list_survey_report_selected';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
	}
	////////
	///bonus report
	function list_bonus_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_bonus_report","privilege_tb")){
			$this->data['page'] = 'report/list_bonus_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function list_bonus_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_bonus_report","privilege_tb")){
			$quarter = $this->input->post('quarter');
			$year = $this->input->post('year');
			
			$this->data['project_goal'] = $this->report_model->show_project();
			$this->data['project'] = $this->report_model->show_project_goal_bonus($quarter,$year);
			
			$this->data['quarter'] = $quarter;
			$this->data['year_selected'] = $year;
			
			$this->data['page'] = 'report/list_bonus_report_selected';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
	}
	////////
	//employee
	function list_employee_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_report","privilege_tb")){
			$this->data['department'] = $this->report_model->show_department();
			$this->data['employee'] = $this->report_model->show_employee();
			$this->data['page'] = 'report/list_employee_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	//
	
	//employee daily report
	function list_employee_daily_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_daily_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_daily_report_2","privilege_tb")){
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['page'] = 'report/list_employee_daily_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}	
	}
	
	
	
	function list_employee_daily_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_daily_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_daily_report_2","privilege_tb")){
			
			$date_1 = $this->input->post('date_1');
			$date_2 = $this->input->post('date_2');
			$employee_selected = $this->input->post('employee_id');
			$z=1;
			$employee_list='';
			if($employee_selected)foreach($employee_selected as $list){
				if($z!=1){	
					$employee_list = $employee_list."|".$list;
				}elseif($z==1){
					$employee_list = $list;
				}
				$z++;
			}
			$this->data['employee_list'] = $employee_list;
			
			$this->data['department'] = $this->report_model->show_department();
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['employee_daily'] = $this->report_model->show_employee_daily($date_1,$date_2);
			$this->data['page'] = 'report/list_employee_daily_report_selected';
			
			$this->data['date_1'] = $date_1;
			$this->data['date_2'] = $date_2;
			
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}	
	}
	
	//employee schedule vs daily
	function list_employee_schedule_daily_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_schedule_daily_report","privilege_tb")){
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['page'] = 'report/list_schedule_and_activity_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}	
	}
	
	function list_employee_schedule_daily_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_schedule_daily_report","privilege_tb")){
			
			$date_1 = $this->input->post('date_1');
			$date_2 = $this->input->post('date_2');
			$employee_selected = $this->input->post('employee_id');
			$z=1;
			if($employee_selected)foreach($employee_selected as $list){
				if($z!=1){	
					$employee_list = $employee_list."|".$list;
				}elseif($z==1){
					$employee_list = $list;
				}
				$z++;
			}
			$this->data['employee_list'] = $employee_list;
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['employee_activity_list'] = $this->report_model->show_employee_activity_list($date_1,$date_2);
			$this->data['page'] = 'report/list_schedule_and_activity_report_selected';
			
			$this->data['date_1'] = $date_1;
			$this->data['date_2'] = $date_2;
			
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}	
	}
	//
}?>