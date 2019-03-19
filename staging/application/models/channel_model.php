<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Channel_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_channel_list()
	{
		$q = "select * from channel_tb order by `precedence` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}

	function get_channel_banner()
	{
		$q = "select * from channel_banner_tb";
		$query = $this->db->query($q);
		return $query->row_array();	
	}

	function get_channel_list_active()
	{
		$q = "select * from channel_tb where active=1 order by `precedence` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_channel_data($id)
	{
		$q = "select * from channel_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_channel_data2($alias)
	{
		$q = "select * from channel_tb where `alias` = '".esc($alias)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_channel_list()
	{
		$q = "select * from channel_tb where `active`=1 order by `precedence` limit 3";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_menu_channel_by($channel_id)
	{
		$sql="select * from `sub_channel_tb` where `channel_id` = '".esc($channel_id)."' and `active`=1 order by precedence";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function update_data($id, $data)
	{
		$this->db->update('channel_tb', $data, array('id'=>$id));
	}

	function update_data_banner($id, $data)
	{
		$this->db->update('channel_banner_tb', $data, array('id'=>$id));
	}
	
	function update_active_channel($id, $active)
	{
		$q = "update channel_tb set `active` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function up_precedence_channel($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from channel_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from channel_tb where precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		channel_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		channel_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_channel($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from channel_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from channel_tb where precedence > '.$from['precedence'].' order by precedence asc'));
		
		$sql1 = "update		channel_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		channel_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function delete_channel_picture($id)
	{
		$sql = "update  channel_tb set `image` = '' where id = '".esc($id)."'";
		$this->db->query($sql);	
	}
}