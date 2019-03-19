<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Client_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_client_information_by_id($id){
		$sql = "select * from client_information_tb where client_id = '".esc($id)."' order by input_date desc";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_client_information_by_id_detail($id){
		$sql = "select * from client_information_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_client_information($id,$description,$input_by,$input_date){
		$sql = "insert into client_information_tb (client_id,description,input_by,input_date)
						values ('".esc($id)."',
								'".esc($description)."',
								'".esc($input_by)."',
								'".esc($input_date)."')";
		$this->execute_dml($sql);	
	}
	
	function delete_client_information($id){
		$sql = "delete from client_information_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function edit_client_information($id,$description){
		$sql = "update client_information_tb set description = '".esc($description)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function show_industry(){
		$sql = "select * from industry_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_employee(){
		$sql = "select * from employee_tb order by firstname,lastname";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_client_by_id($id){
		$sql = "select * from client_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_client($employee_id,$name,$industry,$product,$location,$cp_1,$cp_2,$phone,$handphone,$fax,$email,$active,$attachment){
		$today = date('Y-m-d');
		$sql = "insert into client_tb
				values(	'',
						'".esc($employee_id)."',
						'".esc($industry)."',
						'".esc($name)."',
						'".esc($product)."',
						'".esc($location)."',
						'".esc($cp_1)."',
						'".esc($cp_2)."',
						'".esc($phone)."',
						'".esc($handphone)."',
						'".esc($fax)."',
						'".esc($email)."',
						'".esc($attachment)."',
						'".esc($active)."',
						'".esc($today)."'
				)";
		$this->execute_dml($sql);	
	}
	
	function do_edit_client($id,$employee_id,$name,$industry,$product,$location,$cp_1,$cp_2,$phone,$handphone,$fax,$email,$active,$attachment){
		$sql = "update client_tb set 	name = '".esc($name)."',
										industry = '".esc($industry)."',
										product = '".esc($product)."',
										location = '".esc($location)."',
										employee_id = '".esc($employee_id)."',
										cp_1 = '".esc($cp_1)."',
										cp_2 = '".esc($cp_2)."',
										phone = '".esc($phone)."',
										handphone = '".esc($handphone)."',
										fax = '".esc($fax)."',
										email = '".esc($email)."',
										active = '".esc($active)."',
										attachment = '".esc($attachment)."'
										where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function active_client($id,$active){
		$sql = "update client_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_client($id){
		$sql = "delete from client_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
}?>