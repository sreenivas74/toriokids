<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Department_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function get_timeline_log_tb($timeline_id){
		$sql = "select * from timeline_log_tb where timeline_id = '".esc($timeline_id)."' order by id desc";
		return $this->fetch_multi_row($sql);
	}
	function show_project_deadline_tb($project_id){
		$sql = "select * from project_deadline_tb where project_id = '".esc($project_id)."' order by deadline_date";
		return $this->fetch_multi_row($sql);
	}
	
	function show_project_deadline_by_id($id){
		$sql = "select * from project_deadline_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	function show_department_by_id($id){
		$sql = "select * from department_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	function get_departemen_active(){
		$sql = "select * from department_tb where active=1";
		return $this->fetch_multi_row($sql);
	}
	
	function do_add_department($name,$active){
		$sql = "insert into department_tb values ('','".esc($name)."','".esc($active)."')";
		$this->execute_dml($sql);
	}
	
	function do_edit_department($id,$name,$active){
		$sql = "update department_tb set name = '".esc($name)."', active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_department($id){
		$sql = "delete from department_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function active($id,$active){
		$sql = "update department_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
}?>