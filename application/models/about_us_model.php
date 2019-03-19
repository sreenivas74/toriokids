<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class About_us_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_about_us_list()
	{
		$q = "select * from about_us_tb order by `precedence` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}

	function get_about_us_point()
	{
		$q = "select * from about_us_point_tb order by `precedence` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}

	function get_about_us_banner()
	{
		$q = "select * from about_us_banner_tb";
		$query = $this->db->query($q);
		return $query->row_array();	
	}

	function get_about_us_list_active()
	{
		$q = "select * from about_us_tb where active=1 order by `precedence` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}

	function get_about_us_point_list_active()
	{
		$q = "select * from about_us_point_tb where active=1 order by `precedence` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_about_us_data($id)
	{
		$q = "select * from about_us_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}

	function get_selected_about_us_point($id)
	{
		$q = "select * from about_us_point_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_about_us_data2($alias)
	{
		$q = "select * from about_us_tb where `alias` = '".esc($alias)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_about_us_list()
	{
		$q = "select * from about_us_tb where `active`=1 order by `precedence` limit 3";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_menu_about_us_by($about_us_id)
	{
		$sql="select * from `sub_about_us_tb` where `about_us_id` = '".esc($about_us_id)."' and `active`=1 order by precedence";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function update_data($id, $data)
	{
		$this->db->update('about_us_tb', $data, array('id'=>$id));
	}

	function update_data_banner($id, $data)
	{
		$this->db->update('about_us_banner_tb', $data, array('id'=>$id));
	}

	function update_data_point($id, $data)
	{
		$this->db->update('about_us_point_tb', $data, array('id'=>$id));
	}
	
	function update_active_about_us($id, $active)
	{
		$q = "update about_us_tb set `active` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}

	function update_active_about_us_point($id, $active)
	{
		$q = "update about_us_point_tb set `active` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function up_precedence_about_us($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from about_us_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from about_us_tb where precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		about_us_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		about_us_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_about_us($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from about_us_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from about_us_tb where precedence > '.$from['precedence'].' order by precedence asc'));
		
		$sql1 = "update		about_us_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		about_us_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}

	function up_precedence_about_us_point($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from about_us_point_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from about_us_point_tb where precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		about_us_point_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		about_us_point_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_about_us_point($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from about_us_point_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from about_us_point_tb where precedence > '.$from['precedence'].' order by precedence asc'));
		
		$sql1 = "update		about_us_point_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		about_us_point_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function delete_about_us_picture($id)
	{
		$sql = "update  about_us_tb set `image` = '' where id = '".esc($id)."'";
		$this->db->query($sql);	
	}

	function delete_about_us_point_picture($id)
	{
		$sql = "update  about_us_point_tb set `image` = '' where id = '".esc($id)."'";
		$this->db->query($sql);	
	}
}