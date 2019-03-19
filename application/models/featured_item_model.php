<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Featured_item_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_featured_item_list()
	{
		$q = "select * from featured_item_tb order by `precedence` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_featured_item_data($id)
	{
		$q = "select * from featured_item_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_featured_item_data2($alias)
	{
		$q = "select * from featured_item_tb where `alias` = '".esc($alias)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_featured_item_list()
	{
		$q = "select * from featured_item_tb where `active`=1 order by `precedence` limit 3";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_menu_featured_item_by($featured_item_id)
	{
		$sql="select * from `sub_featured_item_tb` where `featured_item_id` = '".esc($featured_item_id)."' and `active`=1 order by precedence";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function update_data($id, $data)
	{
		$this->db->update('featured_item_tb', $data, array('id'=>$id));
	}
	
	function update_active_featured_item($id, $active)
	{
		$q = "update featured_item_tb set `active` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function up_precedence_featured_item($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from featured_item_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from featured_item_tb where precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		featured_item_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		featured_item_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_featured_item($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from featured_item_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from featured_item_tb where precedence > '.$from['precedence'].' order by precedence asc'));
		
		$sql1 = "update		featured_item_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		featured_item_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function delete_featured_item_picture($id)
	{
		$sql = "update  featured_item_tb set `image` = '' where id = '".esc($id)."'";
		$this->db->query($sql);	
	}
}