<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Admin_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function login($username, $password){
		$sql = "select * from administrator_tb where username = '".esc($username)."' and password = '".esc($password)."'";
		return $this->fetch_single_row($sql);
	}
	
	function login_by_email($username){
		 $sql = "select * from administrator_tb where username = '".esc($username)."'";
         return $this->fetch_single_row($sql);
	}
	function get_detail_forget_pass($user_id,$verification_code){
			 $sql = "select * from forgot_password_tb where user_id = '".esc($user_id)."' AND verification_code = '".esc($verification_code)."'";
         return $this->fetch_single_row($sql);
	
	}
	
	function updateLastLogin($id){
		$sql = "update administrator_tb set `last_login` = now() where `id` = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	//privilege user
	function show_privilege_user(){
		$sql = "select * from privilege_user_tb order by precedence ASC";
		return $this->fetch_multi_row($sql);
	}
	
	function show_privilege_user_by_id($id){
		$sql = "select * from privilege_user_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function privilege_user_do_add($name){
		$precedence=last_precedence('privilege_user_tb')+1;
		$sql = "insert into privilege_user_tb (name,precedence) values ('".esc($name)."','".esc($precedence)."')";
		$this->execute_dml($sql);	
	}
	
	function add_privilege($privilege_user_id,$module,$module_2){
		$sql = "insert into privilege_tb (privilege_user_id,module) values ('".esc($privilege_user_id)."','".esc($module."/".$module_2)."')";
		$this->execute_dml($sql);	
	}
	
	function add_privilege_user_setting($privilege_user_id,$module){
		$sql = "insert into privilege_tb (privilege_user_id,module) values ('".esc($privilege_user_id)."','".esc($module)."')";
		$this->execute_dml($sql);	
	}
	
	function clear_privilege($privilege_user_id){
		$sql = "delete from privilege_tb where privilege_user_id = '".esc($privilege_user_id)."'";
		$this->execute_dml($sql);	
	}
	
	function edit_privilege_user($id,$name){
		$sql = "update privilege_user_tb set name = '".esc($name)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_privilege($privilege_user_id,$module,$module_2){
		$sql = "delete from privilege_tb where 	privilege_user_id = '".esc($privilege_user_id)."' 
												and module = '".esc($module."/".$module_2)."'";
		$this->execute_dml($sql);	
	}
	//
	//admin
	function show_employee(){
		$sql = "select * from employee_tb where status = 1 order by firstname, lastname";
		return $this->fetch_multi_row($sql);	
	}
	
	function list_admin(){
		$sql = "select * from administrator_tb order by privilege_id";
		return $this->fetch_multi_row($sql);	
	}
	function list_admin_by_id($id){
		$sql = "select * from administrator_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	function list_privilege(){
		$sql = "select * from privilege_user_tb order by id";
		return $this->fetch_multi_row($sql);	
	}
	function do_add_admin($name,$username,$password,$privilege_id,$employee_id){
		$created_date = date("Y-m-d h:i:s");
		$sql = "insert into administrator_tb (name,username,password,privilege_id,created_date,employee_id)
				values ('".esc($name)."',
						'".esc($username)."',
						'".esc(md5($password))."',
						'".esc($privilege_id)."',
						'".esc($created_date)."',
						'".esc($employee_id)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_admin($id,$name,$username,$password,$privilege_id,$employee_id){
		$sql = "update administrator_tb set name = '".esc($name)."',
											username = '".esc($username)."',
											password = '".esc($password)."',
											privilege_id = '".esc($privilege_id)."',
											employee_id = '".esc($employee_id)."'
											where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_model($id){
		$sql  = "delete from administrator_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function show_administrator_employee_by_id($id){
		$sql = "select * from employee_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	//
	
}?>