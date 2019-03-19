<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Resource_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_resource(){
		$sql = "select * from resource_tb";
		return $this->fetch_multi_row($sql);
	}
	
	function show_resource_by_id($id){
		$sql = "select * from resource_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function do_add_resource($name,$active){
		$sql = "insert into resource_tb values ('','".esc($name)."','".esc($active)."')";
		$this->execute_dml($sql);
	}
	
	function do_edit_resource($id,$name,$active){
		$sql = "update resource_tb set name = '".esc($name)."', active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_resource($id){
		$sql = "delete from resource_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function active($id,$active){
		$sql = "update resource_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
}?>