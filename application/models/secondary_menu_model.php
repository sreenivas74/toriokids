<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Secondary_menu_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_secondary_menu_list()
	{
		$q = "select * from secondary_menu_tb order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_secondary_menu_list2($category)
	{
		$q = "select * from secondary_menu_tb where `category` = '".esc($category)."' order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_secondary_menu_data($id)
	{
		$q = "select * from secondary_menu_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_secondary_menu_list()
	{
		$q = "select * from secondary_menu_tb where `active`=1 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_active_help_list()
	{
		$q = "select * from secondary_menu_tb where `active`=1 and `category`=1 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_active_about_us_list()
	{
		$q = "select * from secondary_menu_tb where `active`=1 and `category`=2 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_active_connect_us_list()
	{
		$q = "select * from secondary_menu_tb where `active`=1 and `category`=3 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function insert_secondary_menu($name, $link, $active, $precedence)
	{
		$q = "insert into secondary_menu_tb(`name`, `link`, `active`, `precedence`) 
			  values('".esc($name)."',
			  		 '".esc($link)."',
			  		 '".esc($active)."',
					 '".esc($precedence)."')";
		$this->db->query($q);	
	}
	
	function update_secondary_menu($id, $name, $link)
	{
		$q = "update secondary_menu_tb set `name` = '".esc($name)."',
								   		`link` = '".esc($link)."'
			  where `id` = '".esc($id)."'";
		$this->db->query($q);
	}
	
	function update_active_secondary_menu($id, $active)
	{
		$q = "update secondary_menu_tb set `active` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function up_precedence_secondary_menu($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id,precedence from secondary_menu_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from secondary_menu_tb where  precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		secondary_menu_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' ";
		$sql2 = "update		secondary_menu_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."' ";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_secondary_menu($id, $category)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from secondary_menu_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from secondary_menu_tb where precedence > '.$from['precedence'].' order by precedence asc'));

		$sql1 = "update		secondary_menu_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' ";
		$sql2 = "update		secondary_menu_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."' ";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function delete_secondary_menu($id){
		$q = "delete from secondary_menu_tb where id='".esc($id)."'";
		$this->db->query($q);
	}
}