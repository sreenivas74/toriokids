<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Store_logo_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_store_logo_list()
	{
		$q = "select * from store_logo_tb order by `precedence` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}

	function get_store_logo_banner()
	{
		$q = "select * from store_logo_banner_tb";
		$query = $this->db->query($q);
		return $query->row_array();	
	}

	function get_store_logo_list_active()
	{
		$q = "select * from store_logo_tb where active=1 order by `precedence` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_store_logo_data($id)
	{
		$q = "select * from store_logo_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_store_logo_data2($alias)
	{
		$q = "select * from store_logo_tb where `alias` = '".esc($alias)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_store_logo_list()
	{
		$q = "select * from store_logo_tb where `active`=1 order by `precedence` limit 3";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_menu_store_logo_by($store_logo_id)
	{
		$sql="select * from `sub_store_logo_tb` where `store_logo_id` = '".esc($store_logo_id)."' and `active`=1 order by precedence";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function update_data($id, $data)
	{
		$this->db->update('store_logo_tb', $data, array('id'=>$id));
	}

	function update_data_banner($id, $data)
	{
		$this->db->update('store_logo_banner_tb', $data, array('id'=>$id));
	}
	
	function update_active_store_logo($id, $active)
	{
		$q = "update store_logo_tb set `active` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function up_precedence_store_logo($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from store_logo_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from store_logo_tb where precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		store_logo_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		store_logo_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_store_logo($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from store_logo_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from store_logo_tb where precedence > '.$from['precedence'].' order by precedence asc'));
		
		$sql1 = "update		store_logo_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		store_logo_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function delete_store_logo_picture($id)
	{
		$sql = "update  store_logo_tb set `image` = '' where id = '".esc($id)."'";
		$this->db->query($sql);	
	}
}