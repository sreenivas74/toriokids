<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Advertisement_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_advertisement_list()
	{
		$q = "select * from advertisement_tb order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_advertisement_data($id)
	{
		$q = "select * from advertisement_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_second_data($type)
	{
		$q = "select * from advertisement_tb where `type` = '".esc($type)."' and `active`=1 limit 1";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_advertisement_list()
	{
		$q = "select * from advertisement_tb where `active`=1 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function update_data($id, $data)
	{
		$this->db->update('advertisement_tb', $data, array('id'=>$id));
	}
	
	function update_active_advertisement($id, $active)
	{
		$q = "update advertisement_tb set `active` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function up_precedence_advertisement($id, $type)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, type, precedence from advertisement_tb where id = '.$id.' and type = '.$type));
		$to=mysql_fetch_assoc(mysql_query('select id, type, precedence from advertisement_tb where type = '.$type.' and  precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		advertisement_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' and `type` = '".esc($from['type'])."'";
		$sql2 = "update		advertisement_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'  and `type` = '".esc($to['type'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_advertisement($id, $type)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, type, precedence from advertisement_tb where id = '.$id.' and type = '.$type));
		$to=mysql_fetch_assoc(mysql_query('select id, type, precedence from advertisement_tb where type = '.$type.' and  precedence > '.$from['precedence'].' order by precedence asc'));

		$sql1 = "update		advertisement_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' and `type` = '".esc($from['type'])."'";
		$sql2 = "update		advertisement_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."' and `type` = '".esc($to['type'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function delete_advertisement_picture($id)
	{
		$sql = "update advertisement_tb set image = '' where id = '".esc($id)."'";
		$this->db->query($sql);	
	}
	
	
	function update_active_small_footer_banner($id)
	{
		$q = "update advertisement_tb set `active` = 0 where `type`=3";
		$query = $this->db->query($q);
		
		$q = "update advertisement_tb set `active` = 1 where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
}