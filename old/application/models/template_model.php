<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Template_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_template_name_list()
	{
		$q = "select * from template_name_tb order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_template_name_list_active()
	{
		$q = "select * from template_name_tb where active=1 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_template_size_list($name_id)
	{
		$q = "select * from template_size_tb where `template_name_id` = '".esc($name_id)."' order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_template_name_data($id)
	{
		$q = "select * from template_name_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_template_size_data($id)
	{
		$q = "select * from template_size_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function insert_template_name($name, $precedence)
	{
		$q = "insert into template_name_tb(`name`, `precedence`) 
			  values('".esc($name)."',
					 '".esc($precedence)."')";
		$this->db->query($q);	
	}
	
	function insert_template_size($name_id, $size, $precedence)
	{
		$q = "insert into template_size_tb(`template_name_id`, `size`, `precedence`) 
			  values('".esc($name_id)."',
			  		 '".esc($size)."',
					 '".esc($precedence)."')";
		$this->db->query($q);	
	}
	
	function update_template_name($id, $name)
	{
		$q = "update template_name_tb set `name` = '".esc($name)."'
			  where `id` = '".esc($id)."'";
		$this->db->query($q);
	}
	
	function update_template_size($id, $size)
	{
		$q = "update template_size_tb set `size` = '".esc($size)."'
			  where `id` = '".esc($id)."'";
		$this->db->query($q);
	}
	
	function up_precedence_template_name($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from template_name_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from template_name_tb where precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		template_name_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		template_name_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function up_precedence_template_size($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from template_size_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from template_size_tb where precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		template_size_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		template_size_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_template_name($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from template_name_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from template_name_tb where precedence > '.$from['precedence'].' order by precedence asc'));
		
		$sql1 = "update		template_name_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		template_name_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_template_size($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from template_size_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from template_size_tb where precedence > '.$from['precedence'].' order by precedence asc'));
		
		$sql1 = "update		template_size_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		template_size_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	
	function update_alias($id, $alias)
	{
		$q = "update template_name_tb set `alias` = '".esc($alias)."'
			  where `id` = '".esc($id)."'";
		$this->db->query($q);
	}
	
	function update_active($id, $active)
	{
		$q = "update template_name_tb set `active` = '".esc($active)."'
			  where `id` = '".esc($id)."'";
		$this->db->query($q);
	}
}