<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Industry_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_industry_by_id($id){
		$sql = "select * from industry_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function do_add_industry($name,$active){
		$sql = "insert into industry_tb values ('','".esc($name)."','".esc($active)."')";
		$this->execute_dml($sql);
	}
	
	function do_edit_industry($id,$name,$active){
		$sql = "update industry_tb set name = '".esc($name)."', active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_industry($id){
		$sql = "delete from industry_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function active($id,$active){
		$sql = "update industry_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
}?>