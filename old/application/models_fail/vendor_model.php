<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Vendor_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	///information
	function show_vendor_information_by_id($id){
		$sql = "select * from vendor_information_tb where vendor_id = '".esc($id)."' order by input_date desc";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_vendor_information_by_id_detail($id){
		$sql = "select * from vendor_information_tb where id = '".esc($id)."' order by input_date desc";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_vendor_information($id,$description,$input_by,$input_date){
		$sql = "insert into vendor_information_tb (vendor_id,description,input_by,input_date)
						values ('".esc($id)."',
								'".esc($description)."',
								'".esc($input_by)."',
								'".esc($input_date)."')";
		$this->execute_dml($sql);	
	}
	
	function delete_vendor_information($id){
		$sql = "delete from vendor_information_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function edit_vendor_information($id,$description){
		$sql = "update vendor_information_tb set description = '".esc($description)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	///
	
	function show_vendor_by_id($id){
		$sql = "select * from vendor_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_vendor($name,$type,$description,$location,$address,$cp_1,$cp_2,$phone,$handphone,$fax,$email,$website,$account_number,$attachment,$active,$bank_name,$account_name){
		$sql = "insert into vendor_tb (name,type,description,address,location,cp_1,cp_2,phone,handphone,fax,email,website,account_number,attachment,active,bank,account_name)
				values(	'".esc($name)."',
						'".esc($type)."',
						'".esc($description)."',
						'".esc($address)."',
						'".esc($location)."',
						'".esc($cp_1)."',
						'".esc($cp_2)."',
						'".esc($phone)."',
						'".esc($handphone)."',
						'".esc($fax)."',
						'".esc($email)."',
						'".esc($website)."',
						'".esc($account_number)."',
						'".esc($attachment)."',
						'".esc($active)."',
						'".esc($bank_name)."',
						'".esc($account_name)."'
				)";
		$this->execute_dml($sql);	
	}
	
	function do_edit_vendor($id,$name,$type,$description,$location,$address,$cp_1,$cp_2,$phone,$handphone,$fax,$email,$website,$account_number,$attachment,$active,$bank_name,$account_name){
		$sql = "update vendor_tb set 	name = '".esc($name)."',
										type = '".esc($type)."',
										description = '".esc($description)."',
										location = '".esc($location)."',
										address = '".esc($address)."',
										cp_1 = '".esc($cp_1)."',
										cp_2 = '".esc($cp_2)."',
										phone = '".esc($phone)."',
										handphone = '".esc($handphone)."',
										fax = '".esc($fax)."',
										email = '".esc($email)."',
										website = '".esc($website)."',
										account_number = '".esc($account_number)."',
										attachment = '".esc($attachment)."',
										active = '".esc($active)."',
										bank = '".esc($bank_name)."',
										account_name = '".esc($account_name)."'
										where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function active_vendor($id,$active){
		$sql = "update vendor_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_vendor($id){
		$sql = "delete from vendor_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
}?>