<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Employee_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function status_employee_information($id,$status){
		$sql = "update employee_information_tb set status = '".esc($status)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	function do_add_employee_group($leader_id,$employee_id){
		$sql = "insert into employee_group_tb (leader_id,employee_id)
				values ('".esc($leader_id)."','".esc($employee_id)."')";
		$this->execute_dml($sql);	
	}
	
	function get_absence_list($userid,$month,$year){
		$data_1 = $year."-".$month."-16";
		$data_2 = date("Y-m-15",strtotime('+1 month',strtotime($data_1)));
		$sql = "select * from employee_salary_by_periode where user_id = '".esc($userid)."' and periode_from >= '".esc($data_1)."' and periode_to <= '".esc($data_2)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function delete_employee_member($id){
		$sql = "delete from employee_group_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function show_privilege(){
		$sql = "select * from privilege_user_tb where id != 1 order by precedence ASC";
		return $this->fetch_multi_row($sql);	
	}
	function show_privilege2($precendece){
		$sql = "select * from privilege_user_tb where id != 1 and precedence > '".esc($precendece)."'order by precedence ASC";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_employee_active(){
		$sql = "select * from employee_tb where status = 1 order by firstname,lastname";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_emp_group(){
		$sql = "select * from employee_group_tb";
		return $this->fetch_multi_row($sql);
	}
	
	function show_emp_leader(){
		$sql = "select distinct(leader_id) from employee_group_tb";
		return $this->fetch_multi_row($sql);
	}
	
	function show_employee_by_id($id){
		$sql = "select * from employee_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function show_employee_by_id_multi_row($id){
		$sql = "select * from employee_tb where id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_administrator_employee_by_id($id){
		$sql = "select * from administrator_tb where employee_id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	function show_administrator_employee_by_id_active($id){
		$sql = "select * from administrator_tb where employee_id = '".esc($id)."' AND status=1" ;
		return $this->fetch_single_row($sql);	
	}
	
	function show_employee_information_by_id($id){
		$sql = "select * from employee_information_tb where employee_id = '".esc($id)."' order by input_date desc";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_employee_information_by_id_detail($id){
		$sql = "select * from employee_information_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function show_company(){
		$sql = "select * from company_tb where active = '1' order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_department(){
		$sql = "select * from department_tb where active = '1' order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function do_add_employee($category,$firstname,$lastname,$company_id,$nik,$join_date,$birth_date,$birth_place,$education,$school,$certificate,$grade,$department_id,$job_title,$no_ktp,$address_ktp,$address_now,$gsm_1,$gsm_2,$phone,$pin_bb,$email,$name_reference,$phone_reference,$relation_reference,$marriage_status,$wife,$child,$religion,$account_number,$sim_a,$sim_c,$motor,$status,$type,$type_date){
		$sql = "insert into employee_tb
						(category,firstname,lastname,company_id,nik,join_date,out_date,birth_place,birth_date,education,school,certificate,grade,department_id,job_title,no_ktp,address_ktp,address_now,gsm_1,gsm_2,phone,pin_bb,email,name_reference,phone_reference,relation_reference,marriage_status,wife,child,religion,account_number,sim_a,sim_c,motor,status,type,type_date)
				values(	'".esc($category)."',
						'".esc($firstname)."',
						'".esc($lastname)."',
						'".esc($company_id)."',
						'".esc($nik)."',
						'".esc($join_date)."',
						'0000-00-00',
						'".esc($birth_place)."',
						'".esc($birth_date)."',
						'".esc($education)."',
						'".esc($school)."',
						'".esc($certificate)."',
						'".esc($grade)."',
						'".esc($department_id)."',
						'".esc($job_title)."',
						'".esc($no_ktp)."',
						'".esc($address_ktp)."',
						'".esc($address_now)."',
						'".esc($gsm_1)."',
						'".esc($gsm_2)."',
						'".esc($phone)."',
						'".esc($pin_bb)."',
						'".esc($email)."',
						'".esc($name_reference)."',
						'".esc($phone_reference)."',
						'".esc($relation_reference)."',
						'".esc($marriage_status)."',
						'".esc($wife)."',
						'".esc($child)."',
						'".esc($religion)."',
						'".esc($account_number)."',
						'".esc($sim_a)."',
						'".esc($sim_c)."',
						'".esc($motor)."',
						'".esc($status)."',
						'".esc($type)."',
						'".esc($type_date)."'
				)";
		$this->execute_dml($sql);	
	}
	
	function insert_into_admin($employee_id,$firstname,$lastname,$email,$privilege_id,$password){
		//$password = "gsi";
		$created_date = date("Y-m-d h:i:s");
		$sql = "insert into administrator_tb (employee_id,name,username,password,privilege_id,created_date)
				values ('".esc($employee_id)."',
						'".esc($firstname." ".$lastname)."',
						'".esc($email)."',
						'".esc(md5($password))."',
						'".esc($privilege_id)."',
						'".esc($created_date)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_employee($id,$category,$firstname,$lastname,$company_id,$nik,$join_date,$birth_date,$birth_place,$education,$school,$certificate,$grade,$department_id,$job_title,$no_ktp,$address_ktp,$address_now,$gsm_1,$gsm_2,$phone,$pin_bb,$email,$name_reference,$phone_reference,$relation_reference,$marriage_status,$wife,$child,$religion,$account_number,$sim_a,$sim_c,$motor,$status,$privilege_id,$type,$type_date,$out_date){
		$sql = "update employee_tb set 	category = '".esc($category)."',
										firstname = '".esc($firstname)."',
										lastname = '".esc($lastname)."',
										company_id = '".esc($company_id)."',
										nik = '".esc($nik)."',
										join_date = '".esc($join_date)."',
										out_date = '".esc($out_date)."',
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
										status = '".esc($status)."',
										type = '".esc($type)."',
										type_date = '".esc($type_date)."'
										where id = '".esc($id)."'";
		$this->execute_dml($sql);
		
		$sql2="update administrator_tb set privilege_id = '".esc($privilege_id)."' where employee_id = '".esc($id)."'";
		$this->execute_dml($sql2);
		
	}
	
	function active_employee($id,$active){
		$sql = "update employee_tb set status = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_employee($id){
		$sql2 = "delete from administrator_tb where employee_id = '".esc($id)."'";
		$this->execute_dml($sql2);
		
		$sql = "delete from employee_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function get_employee_group_by_leader($leader_id){
		$q="select * from employee_group_tb a 
		left join employee_tb b on a.employee_id=b.id
		where a.leader_id='".esc($leader_id)."'";
		return $this->fetch_multi_row($q);	
	}
	
	//information
	function do_add_employee_information($id,$description,$deadline_date,$input_by,$input_date){
		$sql = "insert into employee_information_tb (employee_id,description,deadline_date,input_by,input_date)
						values ('".esc($id)."',
								'".esc($description)."',
								'".esc($deadline_date)."',
								'".esc($input_by)."',
								'".esc($input_date)."')";
		$this->execute_dml($sql);	
	}
	
	function delete_employee_information($id){
		$sql = "delete from employee_information_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function edit_employee_information($id,$description,$deadline_date){
		$sql = "update employee_information_tb set description = '".esc($description)."', deadline_date = '".esc($deadline_date)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	//
}?>