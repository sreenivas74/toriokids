<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Schedule_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	//schedule department
	function show_support_employee(){
		$sql = "select * from employee_tb where department_id = 2 and status = 1 order by firstname, lastname";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_engineering_employee(){
		$sql = "select * from employee_tb where department_id = 1 and status = 1 order by firstname, lastname";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_marketing_employee(){
		$sql = "select * from employee_tb where department_id = 8 and status = 1 order by firstname, lastname";
		return $this->fetch_multi_row($sql);	
	}
	//
	
	function close_job_tracking($project_id){
		$sql = "update job_tracking_tb set active = 1 where project_id = '".esc($project_id)."'";
		$this->execute_dml($sql);
	}	
	
	function show_resource_active(){
		$sql = "select * from resource_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);
	}
	
	function show_company_active(){
		$sql = "select * from company_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);
	}
	
	function show_job_tracking_open($sortby){
		$sql = "select * from job_tracking_tb jt where active = 0 order by ".esc($sortby)."";
		return $this->fetch_multi_row($sql);
	}
	
	function show_job_tracking_open_selected($periode_selected,$sortby){
		$sql = "select *,jt.id as id from job_tracking_tb jt, job_tracking_log_tb jtl
				where jt.id = jtl.job_tracking_id
				and jtl.assign_date = '".esc($periode_selected)."'
				and active = 0
				order by ".esc($sortby)."";
		return $this->fetch_multi_row($sql);
	}
	function show_job_tracking_close(){
		$sql = "select * from job_tracking_tb where active = 1 order by id desc";
		return $this->fetch_multi_row($sql);
	}
	
	function show_email_office(){
		$sql = "select email from employee_tb where status = 1 department_id = 5";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_email_all_department(){
		$sql = "select email from employee_tb where status = 1";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_email_all_department_non_online(){
		$sql = "select email from employee_tb where status = 1 and department_id != 6";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_employee_activity_category(){
		$sql = "select * from employee_activity_category_tb where active = 1";
		return $this->fetch_multi_row($sql);	
	}
	
	function update_job_tracking_data($job_tracking_id,$due_date,$employee_activity_category_id){
		$sql = "update job_tracking_tb set due_date = '".esc($due_date)."', employee_activity_category_id = '".esc($employee_activity_category_id)."' where id = '".esc($job_tracking_id)."'";
		$this->execute_dml($sql);	
	}
	
	function add_assign_to($job_tracking_id,$assign_date,$assigned_to,$assign_time,$resource_id,$description){
		$sql = "insert into job_tracking_log_tb (job_tracking_id,assign_date,assign_to,assign_time,resource_id,description)
				values ('".esc($job_tracking_id)."',
						'".esc($assign_date)."',
						'".esc($assigned_to)."',
						'".esc($assign_time)."',
						'".esc($resource_id)."',
						'".esc($description)."')";
		$this->execute_dml($sql);	
	}
	
	function edit_assign_to($job_tracking_id,$assign_date,$assigned_to,$assign_time,$resource_id,$description){
		$sql = "update job_tracking_log_tb set 	assign_to = '".esc($assigned_to)."',
												assign_time = '".esc($assign_time)."',
												resource_id = '".esc($resource_id)."',
												description = '".esc($description)."'
												where job_tracking_id = '".esc($job_tracking_id)."'
												and assign_date = '".esc($assign_date)."'";
		$this->execute_dml($sql);	
	}
	
	function show_job_tracking_log_by_job_tracking_id($job_tracking_id){
		$sql = "select * from job_tracking_log_tb where job_tracking_id = '".esc($job_tracking_id)."' order by assign_date desc";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_employee_active(){
		$sql = "select * from employee_tb where status = 1 order by firstname,lastname";
		return $this->fetch_multi_row($sql);
	}
	
	function show_department_active(){
		$sql = "select * from department_tb where active = 1";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_employee_by_department($id){
		$sql = "select * from employee_tb where department_id = '".esc($id)."' and status = 1 order by firstname, lastname";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_schedule_list_by_id($id){
		$sql = "select * from schedule_tb where employee_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	/*function show_employee_active_1(){
		$sql = "select * from employee_tb where status = 1 order by firstname,lastname limit 40";
		return $this->fetch_multi_row($sql);
	}
	
	function show_employee_active_2(){
		$sql = "select * from employee_tb where status = 1 order by firstname,lastname limit 40,40";
		return $this->fetch_multi_row($sql);
	}
	*/
	function show_schedule_by_id($id){
		$sql = "select * from schedule_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_schedule($description,$date,$employee){
		$today = date("Y-m-d");
		$sql = "insert into schedule_tb (employee_id,description,date_now,created_date)
				values ('".esc($employee)."',
						'".esc($description)."',
						'".esc($date)."',
						'".esc($today)."')";
		$this->execute_dml($sql);	
	}
	
	/*function do_edit_schedule($description,$date,$employee){
		$sql = "update schedule_tb set 	description = '".esc($description)."'
										where 
										date_now = '".esc($date)."'
										and employee_id = '".esc($employee)."'";
		$this->execute_dml($sql);	
	}*/
	
	function edit_schedule($id,$description,$updated_date,$updated_by){
		$sql = "update schedule_tb set 	description = '".esc($description)."',
										edited_date = '".esc($updated_date)."',
										edited_by = '".esc($updated_by)."'
										where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	//job tracking//
	function show_job_tracking_by_id($id){
		$sql = "select * from job_tracking_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_job_tracking($project_id,$assigned_to,$description,$due_date,$employee_activity_category_id,$priority,$active,$notes,$bast_date,$respon_date,$respon_time,$finish_time,$additional_charge,$resource,$pointer_at,$approval,$company_id,$pic_support,$pic_engineering){
		$created_date = date("Y-m-d");
		$sql = "insert into job_tracking_tb (project_id,assigned_to,description,due_date,employee_activity_category_id,priority,active,notes,bast_date,respon_date,respon_time,finish_time,additional_charge,resource,pointer_at,approval,created_date,company_id,pic_support,pic_engineering)
				values ('".esc($project_id)."',
						'".esc($assigned_to)."',
						'".esc($description)."',
						'".esc($due_date)."',
						'".esc($employee_activity_category_id)."',
						'".esc($priority)."',
						'".esc($active)."',
						'".esc($notes)."',
						'".esc($bast_date)."',
						'".esc($respon_date)."',
						'".esc($respon_time)."',
						'".esc($finish_time)."',
						'".esc($additional_charge)."',
						'".esc($resource)."',
						'".esc($pointer_at)."',
						'".esc($approval)."',
						'".esc($created_date)."',
						'".esc($company_id)."',
						'".esc($pic_support)."',
						'".esc($pic_engineering)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_job_tracking($id,$project_id,$assigned_to,$description,$due_date,$employee_activity_category_id,$priority,$active,$notes,$bast_date,$respon_date,$respon_time,$finish_time,$additional_charge,$resource,$pointer_at,$approval,$company_id,$pic_support,$pic_engineering){
		$sql = "update job_tracking_tb set 	project_id = '".esc($project_id)."',
											description = '".esc($description)."',
											assigned_to = '".esc($assigned_to)."',
											due_date = '".esc($due_date)."',
											employee_activity_category_id = '".esc($employee_activity_category_id)."',
											priority = '".esc($priority)."',
											active = '".esc($active)."',
											notes = '".esc($notes)."',
											bast_date = '".esc($bast_date)."',
											respon_date = '".esc($respon_date)."',
											respon_time = '".esc($respon_time)."',
											finish_time = '".esc($finish_time)."',
											additional_charge = '".esc($additional_charge)."',
											resource = '".esc($resource)."',
											pointer_at = '".esc($pointer_at)."',
											approval = '".esc($approval)."',
											company_id = '".esc($company_id)."',
											pic_support = '".esc($pic_support)."',
											pic_engineering = '".esc($pic_engineering)."'
											where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function approval_job_tracking($id,$approval){
		$sql = "update job_tracking_tb set approval = '".esc($approval)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function active_job_tracking($id,$active){
		$close_date = date("Y-m-d");
		
		if($active==0){
			$sql = "update job_tracking_tb set active = '".esc($active)."', close_date = '000-00-00' where id = '".esc($id)."'";
		}else{
			$sql = "update job_tracking_tb set active = '".esc($active)."', close_date = '".esc($close_date)."' where id = '".esc($id)."'";
		}
		$this->execute_dml($sql);
	}
	
	function delete_job_tracking($id){
		$sql = "delete from job_tracking_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	//
	//information
	function show_job_tracking_information_by_id($id){
		$sql = "select * from job_tracking_information_tb where job_tracking_id = '".esc($id)."' order by input_date desc";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_job_tracking_information_by_id_detail($id){
		$sql = "select * from job_tracking_information_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_job_tracking_information($id,$description,$input_by,$input_date){
		$sql = "insert into job_tracking_information_tb (job_tracking_id,description,input_by,input_date)
						values ('".esc($id)."',
								'".esc($description)."',
								'".esc($input_by)."',
								'".esc($input_date)."')";
		$this->execute_dml($sql);	
	}
	
	function delete_job_tracking_information($id){
		$sql = "delete from job_tracking_information_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function edit_job_tracking_information($id,$description){
		$sql = "update job_tracking_information_tb set description = '".esc($description)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	//
	//add schedule to
	function do_add_schedule_to($employee_id,$activity_date,$description,$input_by,$input_date,$pic,$phone,$time,$project_id){
		$sql = "insert into schedule_to_tb (employee_id,activity_date,description,input_by,input_date,pic,phone,time,project_id)
				values ('".esc($employee_id)."',
						'".esc($activity_date)."',
						'".esc($description)."',
						'".esc($input_by)."',
						'".esc($input_date)."',
						'".esc($pic)."',
						'".esc($phone)."',
						'".esc($time)."',
						'".esc($project_id)."')";
		$this->execute_dml($sql);	
	}
	//
}?>