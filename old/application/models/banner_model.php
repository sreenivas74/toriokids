<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Banner_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_banner_list($type)
	{
		$q = "select * from home_banner_tb where `type` = '".esc($type)."' order by `precedence` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_home_banner_data($id)
	{
		$q = "select * from home_banner_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_second_data($type)
	{
		$q = "select * from home_banner_tb where `type` = '".esc($type)."' and `active`=1 limit 1";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_second_data2($type)
	{
		$q = "select * from home_banner_tb where `type` = '".esc($type)."' and `active`=1 limit 1";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_home_banner_list($type)
	{
		$q = "select * from home_banner_tb where `type` = '".esc($type)."' and `active`=1 order by `precedence` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function update_data($id, $data)
	{
		$this->db->update('home_banner_tb', $data, array('id'=>$id));
	}
	
	function update_active_home_banner($id, $active)
	{
		$q = "update home_banner_tb set `active` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function up_precedence_home_banner($id, $type)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, type, precedence from home_banner_tb where id = '.$id.' and type = '.$type));
		$to=mysql_fetch_assoc(mysql_query('select id, type, precedence from home_banner_tb where type = '.$type.' and  precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		home_banner_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' and `type` = '".esc($from['type'])."'";
		$sql2 = "update		home_banner_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'  and `type` = '".esc($to['type'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_home_banner($id, $type)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, type, precedence from home_banner_tb where id = '.$id.' and type = '.$type));
		$to=mysql_fetch_assoc(mysql_query('select id, type, precedence from home_banner_tb where type = '.$type.' and  precedence > '.$from['precedence'].' order by precedence asc'));

		$sql1 = "update		home_banner_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' and `type` = '".esc($from['type'])."'";
		$sql2 = "update		home_banner_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."' and `type` = '".esc($to['type'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function delete_home_banner_picture($id)
	{
		$sql = "update home_banner_tb set image = '' where id = '".esc($id)."'";
		$this->db->query($sql);	
	}
	
	
	function update_active_small_footer_banner($id)
	{
		$q = "update home_banner_tb set `active` = 0 where `type`=3";
		$query = $this->db->query($q);
		
		$q = "update home_banner_tb set `active` = 1 where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	/////SALE BANNER
	
	function get_sale_banner_list()
	{
		$q = "select * from sale_banner_tb order by `precedence` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_sale_banner_data($id)
	{
		$q = "select * from sale_banner_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function delete_sale_banner_picture($id)
	{
		$sql = "update sale_banner_tb set image = '' where id = '".esc($id)."'";
		$this->db->query($sql);	
	}
	
	function update_data_sale_banner($id, $data)
	{
		$this->db->update('sale_banner_tb', $data, array('id'=>$id));
	}
	
	function update_active_sale_banner($id, $active)
	{
		$q = "update sale_banner_tb set `active` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function up_precedence_sale_banner($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from sale_banner_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from sale_banner_tb where precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		sale_banner_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		sale_banner_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_sale_banner($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from sale_banner_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from sale_banner_tb where  precedence > '.$from['precedence'].' order by precedence asc'));

		$sql1 = "update		sale_banner_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		sale_banner_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function get_active_sale_banner(){
		$q = "select * from sale_banner_tb where active=1 limit 1";
		$query = $this->db->query($q);
		return $query->row_array();
	}
}