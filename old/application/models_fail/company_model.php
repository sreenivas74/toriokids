<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Company_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_company_by_id($id){
		$sql = "select * from company_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function do_add_company($name,$alias,$active){
		$sql = "insert into company_tb values ('','".esc($name)."','".esc($alias)."','".esc($active)."')";
		$this->execute_dml($sql);
	}
	
	function do_edit_company($id,$name,$alias,$active){
		$sql = "update company_tb set name = '".esc($name)."', alias = '".esc($alias)."', active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_company($id){
		$sql = "delete from company_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function active($id,$active){
		$sql = "update company_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
}?>