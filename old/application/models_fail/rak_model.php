<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Rak_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_rak(){
		$sql = "select * from rak_tb order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_rak_by_id($id){
		$sql = "select * from rak_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function show_rak_by_warehouse($warehouse_id){
		$sql = "select * from rak_tb where warehouse_id = '".esc($warehouse_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_stock_by_rak($rak_id){
		 $sql = "select * from stock_tb where rak_id = '".esc($rak_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function do_add_rak($name,$warehouse_id){
		$sql = "insert into rak_tb (name,warehouse_id)
				values ('".esc($name)."','".esc($warehouse_id)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_rak($id,$name,$warehouse_id){
		$sql = "update rak_tb set 	name = '".esc($name)."',
									warehouse_id = '".esc($warehouse_id)."'
									where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_rak($id){
		$sql = "delete from rak_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function show_stock_detail($id){
		 $sql = "select * from stock_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function get_item_stock_by_name($name){
		$sql = "select * from stock_tb where item = '".esc($name)."'";
		return $this->fetch_multi_row($sql);
		
	}
}