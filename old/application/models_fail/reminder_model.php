<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Reminder_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_reminder_today(){
		$today = date("Y-m-d");
		$today_2 =date("Y-m-d",strtotime('+14 day',strtotime(date('Y-m-d'))));
		$sql = "select * from reminder_tb where (date_send >= '".esc($today)."' and date_send <= '".esc($today_2)."' ) or date_deadline <= '".esc($today_2)."' and status = 0 order by date_deadline asc";
		return $this->fetch_multi_row($sql);	
	}
	
	
	function get_deadline_reminder_admin(){
		$today = date("Y-m-d");
		$today_2 =date("Y-m-d",strtotime('+7 day',strtotime(date('Y-m-d'))));
	 	$sql = "select * from project_deadline_tb where  deadline_date <= '".esc($today_2)."'  and progress<100 order by deadline_date asc";
		return $this->fetch_multi_row($sql);	
	}
	function get_deadline_reminder($employee_id,$departemen_id){
		$today = date("Y-m-d");
		$today_2 =date("Y-m-d",strtotime('+7 day',strtotime(date('Y-m-d'))));
		$sql = "select * from project_deadline_tb where (employee_id_assignment= '".esc($employee_id)."' OR division_assignment = '".esc($departemen_id)."')  and deadline_date <= '".esc($today_2)."' and progress<100  order by deadline_date asc";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_deadline_reminder_now($employee_id,$departemen_id){
		$today = date("Y-m-d");
		$today_2 =date("Y-m-d",strtotime('+7 day',strtotime(date('Y-m-d'))));
		 $sql = "select * from project_deadline_tb where (deadline_date <= '".esc($today)."') and (progress<100) and (employee_id_assignment= '".esc($employee_id)."' OR division_assignment = '".esc($departemen_id)."')    order by deadline_date asc";
		return $this->fetch_multi_row($sql);	
	}
	
	
	
	
	
	
	
	
	
	
	
	function show_reminder_today_2(){
		$today = date("Y-m-d");
		$today_2 =date("Y-m-d",strtotime('+14 day',strtotime(date('Y-m-d'))));
		$sql = "select * from reminder_tb where (date_send >= '".esc($today)."' and date_send <= '".esc($today_2)."' ) or (date_deadline >= '".esc($today)."' and date_deadline <= '".esc($today_2)."') and status = 0 order by department_id,date_deadline asc";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_reminder_by_id($id){
		$sql = "select * from reminder_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function show_department_active(){
		$sql = "select * from department_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_employee_by_department($id){
		$sql = "select * from employee_tb where department_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);
	}
	function show_employee_active_by_department($id){
		$sql = "select * from employee_tb where status = 1 and department_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);
	}
	
	function do_add_reminder($department_id,$description,$date_send,$date_deadline,$created_by,$date_created){
		$sql = "insert into reminder_tb (department_id,description,date_send,date_deadline,created_by,date_created)
				values ('".esc($department_id)."',
						'".esc($description)."',
						'".esc($date_send)."',
						'".esc($date_deadline)."',
						'".esc($created_by)."',
						'".esc($date_created)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_reminder($id,$department_id,$description,$date_send,$date_deadline){
		$sql = "update reminder_tb set 	department_id = '".esc($department_id)."',
										description = '".esc($description)."',
										date_send = '".esc($date_send)."',
										date_deadline = '".esc($date_deadline)."'
										where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function active_reminder($id,$status,$done_by,$date_done){
		$sql = "update reminder_tb set 	status = '".esc($status)."',
										done_by = '".esc($done_by)."',
										date_done = '".esc($date_done)."'
										where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_reminder($id){
		$sql = "delete from reminder_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
}?>