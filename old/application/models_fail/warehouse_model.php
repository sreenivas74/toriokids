<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Warehouse_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_all_stock(){
		$sql = "select * from stock_tb where  type_stock = 0 order by item asc";
		return $this->fetch_multi_row($sql);
	}
	
	function show_all_service(){
		$sql = "select * from stock_tb where  type_stock = 1 order by item asc";
		return $this->fetch_multi_row($sql);
	}
	
	function show_warehouse(){
		$sql = "select * from warehouse_tb";
		return $this->fetch_multi_row($sql);
	}
	
	function show_warehouse_by_id($id){
		$sql = "select * from warehouse_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function do_add_warehouse($name,$active){
		$sql = "insert into warehouse_tb (name,active) values ('".esc($name)."','".esc($active)."')";
		$this->execute_dml($sql);
	}
	
	function do_edit_warehouse($id,$name,$active){
		$sql = "update warehouse_tb set name = '".esc($name)."', active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_warehouse($id){
		$sql = "delete from warehouse_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function active($id,$active){
		$sql = "update warehouse_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
}?>