<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Myprofile_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_employee_by_id($id){
		$sql = "select * from employee_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function show_privilege(){
		$sql = "select * from privilege_user_tb where id != 1";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_company(){
		$sql = "select * from company_tb where active = '1' order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_department(){
		$sql = "select * from department_tb where active = '1' order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_admin_by_id($id){
		$sql = "select * from administrator_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function update_user_login($admin_id,$username,$password){
		$sql = "update administrator_tb set username = '".esc($username)."', password = '".md5(esc($password))."' where id = '".esc($admin_id)."'";
		$this->execute_dml($sql);
	}
	
	function do_edit_employee($id,$category,$firstname,$lastname,$company_id,$nik,$join_date,$birth_date,$birth_place,$education,$school,$certificate,$grade,$department_id,$job_title,$no_ktp,$address_ktp,$address_now,$gsm_1,$gsm_2,$phone,$pin_bb,$email,$name_reference,$phone_reference,$relation_reference,$marriage_status,$wife,$child,$religion,$account_number,$sim_a,$sim_c,$motor,$status,$privilege_id){
		$sql = "update employee_tb set 	category = '".esc($category)."',
										firstname = '".esc($firstname)."',
										lastname = '".esc($lastname)."',
										company_id = '".esc($company_id)."',
										nik = '".esc($nik)."',
										join_date = '".esc($join_date)."',
										birth_date = '".esc($birth_date)."',
										birth_place = '".esc($birth_place)."',
										education = '".esc($education)."',
										school = '".esc($school)."',
										certificate = '".esc($certificate)."',
										grade = '".esc($grade)."',
										department_id = '".esc($department_id)."',
										job_title = '".esc($job_title)."',
										no_ktp = '".esc($no_ktp)."',
										address_ktp = '".esc($address_ktp)."',
										address_now = '".esc($address_now)."',
										gsm_1 = '".esc($gsm_1)."',
										gsm_2 = '".esc($gsm_2)."',
										phone = '".esc($phone)."',
										pin_bb = '".esc($pin_bb)."',
										email = '".esc($email)."',
										name_reference = '".esc($name_reference)."',
										phone_reference = '".esc($phone_reference)."',
										relation_reference = '".esc($relation_reference)."',
										marriage_status = '".esc($marriage_status)."',
										wife = '".esc($wife)."',
										child = '".esc($child)."',
										religion = '".esc($religion)."',
										account_number = '".esc($account_number)."',
										sim_a = '".esc($sim_a)."',
										sim_c = '".esc($sim_c)."',
										motor = '".esc($motor)."',
										status = '".esc($status)."'
										where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
}?>