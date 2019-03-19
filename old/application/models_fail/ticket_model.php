<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Ticket_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function add_to_job_tracking($ticket_id,$project_id,$complaint,$employee_id,$employee_activity_category_id,$created_date){
		$sql = "insert into job_tracking_tb (project_id,ticket_id,description,assigned_to,employee_activity_category_id,created_date,active)
				values	('".esc($project_id)."',
						'".esc($ticket_id)."',
						'".esc($complaint)."',
						'".esc($employee_id)."',
						'".esc($employee_activity_category_id)."',
						'".esc($created_date)."',
						'0')";
		$this->execute_dml($sql);
	}
	
	function show_resource_active(){
		$sql = "select * from resource_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);
	}
	
	function close_job_tracking($project_id){
		$sql = "update job_tracking_tb set active = 1 where project_id = '".esc($project_id)."'";
		$this->execute_dml($sql);	
	}
	
	function show_employee_active(){
		$sql = "select * from employee_tb where status = 1 order by firstname,lastname";
		return $this->fetch_multi_row($sql);
	}
	
	function add_assigned_to($ticket_id,$employee_id){
		$sql = "update ticket_tb set employee_id = '".esc($employee_id)."' where id = '".esc($ticket_id)."'";
		$this->execute_dml($sql);	
	}
	
	function add_assign_to($job_tracking_id,$assign_date,$assigned_to){
		$sql = "insert into job_tracking_log_tb (job_tracking_id,assign_date,assign_to)
				values ('".esc($job_tracking_id)."',
						'".esc($assign_date)."',
						'".esc($assigned_to)."')";
		$this->execute_dml($sql);	
	}
	
	function edit_assign_to($job_tracking_id,$assign_date,$assigned_to){
		$sql = "update job_tracking_log_tb set 	assign_to = '".esc($assigned_to)."'
												where job_tracking_id = '".esc($job_tracking_id)."'
												and assign_date = '".esc($assign_date)."'";
		$this->execute_dml($sql);	
	}
	
	//login history ticket
	function login($login,$password){
		$year = substr($login,0,2);
		$month = substr($login,2,2);
		$id = substr($login,4,10);
		
		$date = "20".$year."-".$month."-";
		
		$sql = "select * from ticket_tb where email = '".esc($password)."' and id = '".esc($id)."' and created_date like '".$date."%'";
		return $this->fetch_single_row($sql);
	}
	
	function show_ticket_history($login){
		$id = substr($login,4,10);
		$sql = "select * from ticket_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function do_add_problem($ticket_id,$problem,$send_date_2){
		$sql = "insert into ticket_response_tb (ticket_id,problem,send_date_2)
				values ('".esc($ticket_id)."',
						'".esc($problem)."',
						'".esc($send_date_2)."')";
		$this->execute_dml($sql);	
	}
	//
	
	function show_ticket_open(){
		$sql = "select * from ticket_tb where status = 0 order by created_date desc";
		return $this->fetch_multi_row($sql);	
	}
	
	function delete_ticket($id){
		$sql = "delete from ticket_response_tb where ticket_id = '".esc($id)."'";	
		$this->execute_dml($sql);	
		
		$sql = "delete from ticket_tb where id = '".esc($id)."'";	
		$this->execute_dml($sql);
	}
	
	function show_ticket_close(){
		$sql = "select * from ticket_tb where status = 1 order by close_date desc limit	20";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_ticket_by_id($id){
		$sql = "select * from ticket_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
		
	function do_add_ticket($name,$phone,$email,$complaint,$pic,$created_date,$created_by){
		$sql = "insert into ticket_tb (name,phone,email,complaint,pic,created_date,created_by)
				value (	'".esc($name)."',
						'".esc($phone)."',
						'".esc($email)."',
						'".esc($complaint)."',
						'".esc($pic)."',
						'".esc($created_date)."',
						'".esc($created_by)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_ticket($id,$project_id,$respond,$status,$last_update,$last_update_by,$close_date){
		$sql = "update ticket_tb set	project_id = '".esc($project_id)."',
										respond = '".esc($respond)."',
										status = '".esc($status)."',
										last_update = '".esc($last_update)."',
										last_update_by = '".esc($last_update_by)."',
										close_date = '".esc($close_date)."'
										where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function do_add_response($ticket_id,$response,$send_date,$send_by){
		$sql = "insert into ticket_response_tb (ticket_id,response,send_date,send_by)
				value	('".esc($ticket_id)."',
						'".esc($response)."',
						'".esc($send_date)."',
						'".esc($send_by)."')";
		$this->execute_dml($sql);
		
		$sql = "update ticket_tb set last_update = '".esc($send_date)."', last_update_by = '".esc($send_by)."' where id = '".esc($ticket_id)."'";
		$this->execute_dml($sql);
	}
	
	function change_ticket_status($ticket_id,$status){
		$sql = "update ticket_tb set status = '".esc($status)."' where id = '".esc($ticket_id)."'";
		$this->execute_dml($sql);	
	}
}?>