<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Lead_source_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_lead_source_by_id($id){
		$sql = "select * from lead_source_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function do_add_lead_source($name,$active){
		$sql = "insert into lead_source_tb values ('','".esc($name)."','".esc($active)."')";
		$this->execute_dml($sql);
	}
	
	function do_edit_lead_source($id,$name,$active){
		$sql = "update lead_source_tb set name = '".esc($name)."', active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_lead_source($id){
		$sql = "delete from lead_source_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function active($id,$active){
		$sql = "update lead_source_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
}?>