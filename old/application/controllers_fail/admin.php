<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Admin extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('admin_model');
		$this->load->model('flexigrid_model');
		$this->load->model('general_model');
	}
	
	function index(){
		$this->data['page'] = 'admin/list';
		$this->load->view('common/body', $this->data);
	}
	//privilege user
	function privilege_user(){
		if($this->session->userdata('admin_privilege')==1){
			$this->data['privilege_user'] = $this->admin_model->show_privilege_user();
			$this->data['page'] = 'admin/privilege_user_list';
			$this->load->view('common/body', $this->data);
		}
	}
	
	function privilege_user_do_add(){
		$name = $this->input->post('name');
		$this->admin_model->privilege_user_do_add($name);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function edit_privilege_user($id){
		$name = $this->input->post('name');
		$this->admin_model->edit_privilege_user($id,$name);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	//setting
	function privilege_user_setting($id){
		$this->data['privilege_user'] = $this->admin_model->show_privilege_user_by_id($id);
		$this->data['page'] = 'admin/privilege_user_setting';
		$this->load->view('common/body', $this->data);	
	}
	
	function add_privilege($privilege_user_id,$module,$module_2){
		$this->admin_model->add_privilege($privilege_user_id,$module,$module_2);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function add_privilege_user_setting($privilege_user_id){
		$this->admin_model->clear_privilege($privilege_user_id);
		//project CRM
		$y=39;
		for($x=1;$x<$y;$x++){
			if($this->input->post('project_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('project_'.$x));
			}
		}
		//request funds
		$y=30;
		for($x=1;$x<$y;$x++){
			
			if($this->input->post('rf_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('rf_'.$x));
			}
		}
		//request stock
		$y=9;
		for($x=1;$x<$y;$x++){
			if($this->input->post('rs_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('rs_'.$x));
			}
		}
		//
		//purchasing
		$y=9;
		for($x=1;$x<$y;$x++){
			if($this->input->post('po_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('po_'.$x));
			}
		}
		//
		//absence
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('absence_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('absence_'.$x));
			}
		}
		
		//warehouse
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('warehouse_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('warehouse_'.$x));
			}
		}
		//employee
		$y=9;
		for($x=1;$x<$y;$x++){
			if($this->input->post('employee_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('employee_'.$x));
			}
		}
		//
		//vendor
		$y=6;
		for($x=1;$x<$y;$x++){
			if($this->input->post('vendor_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('vendor_'.$x));
			}
		}
		//
		//client
		$y=7;
		for($x=1;$x<$y;$x++){
			if($this->input->post('client_'.$x)){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('client_'.$x));
			}
		}
		//
		//inventory
		$y=7;
		for($x=1;$x<$y;$x++){
			if($this->input->post('inventory_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('inventory_'.$x));
			}
		}
		//
		//brand category product
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('brand_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('brand_'.$x));
			}
		}
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('category_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('category_'.$x));
			}
		}
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('product_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('product_'.$x));
			}
		}
		//
		
		//lesson
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('lesson_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('lesson_'.$x));
			}
		}
		//
		//industry leadsource company department
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('industry_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('industry_'.$x));
			}
		}
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('lead_source_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('lead_source_'.$x));
			}
		}
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('company_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('company_'.$x));
			}
		}
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('department_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('department_'.$x));
			}
		}
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('bank_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('bank_'.$x));
			}
		}
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('ticket_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('ticket_'.$x));
			}
		}
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('survey_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('survey_'.$x));
			}
		}
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('activity_category_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('activity_category_'.$x));
			}
		}
		$y=4;
		for($x=1;$x<$y;$x++){
			if($this->input->post('resource_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('resource_'.$x));
			}
		}
		//
		//schedule
		$y=13;
		for($x=1;$x<$y;$x++){
			if($this->input->post('schedule_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('schedule_'.$x));
			}
		}
		//
		//reminder
		$y=8;
		for($x=1;$x<$y;$x++){
			if($this->input->post('reminder_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('reminder_'.$x));
			}
		}
		//
		//report
		$y=21;
		for($x=1;$x<$y;$x++){
			if($this->input->post('report_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('report_'.$x));
			}
		}
		//
		//dash
		$y=3;
		for($x=1;$x<$y;$x++){
			if($this->input->post('dashboard_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('dashboard_'.$x));
			}
		}
		//
		//rak
		$y=5;
		for($x=1;$x<$y;$x++){
			if($this->input->post('rak_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('rak_'.$x));
			}
		}
		$y=9;
		for($x=1;$x<$y;$x++){
			if($this->input->post('faq_'.$x)==true){
				$this->admin_model->add_privilege_user_setting($privilege_user_id,$this->input->post('faq_'.$x));
			}
		}
		//
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_privilege($privilege_user_id,$module,$module_2){
		$this->admin_model->delete_privilege($privilege_user_id,$module,$module_2);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	//
	//admin
	function list_admin(){
		if($this->session->userdata('admin_privilege')==1){
			$this->data['list_admin'] = $this->admin_model->list_admin();
			$this->data['list_privilege'] = $this->admin_model->list_privilege();
			$this->data['list_employee'] = $this->admin_model->show_employee();
			$this->data['page'] = 'admin/list_admin';
			$this->load->view('common/body', $this->data);
		}
	}
	
	function do_add_admin(){
		$name = $this->input->post('name');
		$username = $this->input->post('username');
		$password = $this->input->post('password');	
		$privilege_id = $this->input->post('privilege_id');
		$employee_id = $this->input->post('employee_id');
		
		$this->admin_model->do_add_admin($name,$username,$password,$privilege_id,$employee_id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_admin($id){
		if($this->session->userdata('admin_privilege')==1){
			$this->data['list_employee'] = $this->admin_model->show_employee();
			$this->data['list_admin'] = $this->admin_model->list_admin_by_id($id);
			$this->data['list_privilege'] = $this->admin_model->list_privilege();
			$this->data['page'] = 'admin/edit_admin';
			$this->load->view('common/body', $this->data);
		}
	}
	
	function do_edit_admin($id){
		$name = $this->input->post('name');
		$username = $this->input->post('username');
		$password = $this->input->post('password');	
		$employee_id = $this->input->post('employee_id');
		if($password==""){
			$password = find("password",$id,"administrator_tb");
		}else{
			$password = md5($password);	
		}
		$privilege_id = $this->input->post('privilege_id');
		
		$this->admin_model->do_edit_admin($id,$name,$username,$password,$privilege_id,$employee_id);
		redirect("admin/list_admin");
	}
	
	function delete_admin($id){
		$this->admin_model->delete_model($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	function update_precedence(){
	
		$all_data=$this->input->post('table-1');
		
		$no=1;
			if($all_data)foreach($all_data as $list){
				$database=array('precedence'=>$no);
				$where =array('id'=>$list);
				$this->general_model->update_data('privilege_user_tb',$database,$where);	
				$no++;		
			}
	}
	
	//
}?>