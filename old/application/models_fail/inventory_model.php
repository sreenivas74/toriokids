<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Inventory_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_employee(){
		$sql = "select * from employee_tb order by firstname,lastname";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_vendor(){
		$sql = "select * from vendor_tb order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_inventory_by_id($id){
		$sql = "select * from inventory_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function show_department(){
		$sql= "select * from department_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function udpate_last_check_date($id,$check_date,$check_by){
		$sql = "update inventory_tb set check_date = '".esc($check_date)."', check_by = '".esc($check_by)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function udpate_last_check_date_2($id,$check_date,$check_by,$description){
		$sql = "update inventory_tb set check_date = '".esc($check_date)."', check_by = '".esc($check_by)."', description = '".esc($description)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function do_add_inventory($employee_id,$vendor_id,$name,$code,$floor,$room,$department_id,$description,$qty,$price,$total,$notes,$buy_date,$check_date,$check_by){
		$sql = "insert into inventory_tb 
				values ('',
						'".esc($employee_id)."',
						'".esc($vendor_id)."',
						'".esc($name)."',
						'".esc($code)."',
						'".esc($floor)."',
						'".esc($room)."',
						'".esc($department_id)."',
						'".esc($description)."',
						'".esc($qty)."',
						'".esc($price)."',
						'".esc($total)."',
						'".esc($notes)."',
						'".esc($buy_date)."',
						'".esc($check_date)."',
						'".esc($check_by)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_inventory($id,$employee_id,$vendor_id,$name,$code,$floor,$room,$department_id,$description,$qty,$price,$total,$notes,$buy_date,$check_date,$check_by){
		$sql = "update inventory_tb set employee_id = '".esc($employee_id)."',
										vendor_id = '".esc($vendor_id)."',
										name = '".esc($name)."',
										code = '".esc($code)."',
										floor = '".esc($floor)."',
										room = '".esc($room)."',
										department_id = '".esc($department_id)."',
										description = '".esc($description)."',
										qty = '".esc($qty)."',
										price = '".esc($price)."',
										total = '".esc($total)."',
										notes = '".esc($notes)."',
										buy_date = '".esc($buy_date)."',
										check_date = '".esc($check_date)."',
										check_by = '".esc($check_by)."'
										where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_inventory($id){
		$sql = "delete from inventory_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	//infomation
	function show_inventory_information_by_id($id){
		$sql = "select * from inventory_information_tb where inventory_id = '".esc($id)."' order by input_date desc";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_inventory_information_by_id_detail($id){
		$sql = "select * from inventory_information_tb where id = '".esc($id)."' order by input_date desc";
		return $this->fetch_single_row($sql);
	}
	
	function do_add_inventory_information($id,$description,$input_by,$input_date){
		$sql = "insert into inventory_information_tb (inventory_id,description,input_by,input_date)
						values ('".esc($id)."',
								'".esc($description)."',
								'".esc($input_by)."',
								'".esc($input_date)."')";
		$this->execute_dml($sql);
		
		$sql2 = "update inventory_tb set check_date = '".esc($input_date)."', check_by = '".esc($input_by)."' where id = '".esc($id)."'";
		$this->execute_dml($sql2);
	}
	
	function delete_inventory_information($id){
		$sql = "delete from inventory_information_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function edit_inventory_information($id,$description){
		$sql = "update inventory_information_tb set description = '".esc($description)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	//
	
}?>