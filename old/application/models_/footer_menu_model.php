<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Footer_menu_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_footer_menu_list()
	{
		$q = "select * from footer_menu_tb order by `category`,`precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_footer_menu_list2($category)
	{
		$q = "select * from footer_menu_tb where `category` = '".esc($category)."' order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_footer_menu_data($id)
	{
		$q = "select * from footer_menu_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_footer_menu_list()
	{
		$q = "select * from footer_menu_tb where `active`=1 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_active_help_list()
	{
		$q = "select * from footer_menu_tb where `active`=1 and `category`=1 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_active_about_us_list()
	{
		$q = "select * from footer_menu_tb where `active`=1 and `category`=2 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_active_connect_us_list()
	{
		$q = "select * from footer_menu_tb where `active`=1 and `category`=3 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function insert_footer_menu($category, $name, $type, $content_alias, $link, $active, $precedence)
	{
		$q = "insert into footer_menu_tb(`category`, `name`, `type`, `content_alias`, `link`, `active`, `precedence`) 
			  values('".esc($category)."',
			  		 '".esc($name)."',
					 '".esc($type)."',
			  		 '".esc($content_alias)."',
			  		 '".esc($link)."',
			  		 '".esc($active)."',
					 '".esc($precedence)."')";
		$this->db->query($q);	
	}
	
	function update_footer_menu($id, $name, $type, $content_alias, $link)
	{
		$q = "update footer_menu_tb set `name` = '".esc($name)."',
										`type` = '".esc($type)."', 
								   		`content_alias` = '".esc($content_alias)."', 
								   		`link` = '".esc($link)."'
			  where `id` = '".esc($id)."'";
		$this->db->query($q);
	}
	
	function update_active_footer_menu($id, $active)
	{
		$q = "update footer_menu_tb set `active` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function up_precedence_footer_menu($id, $category)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, category, precedence from footer_menu_tb where id = '.$id.' and category = '.$category));
		$to=mysql_fetch_assoc(mysql_query('select id, category, precedence from footer_menu_tb where category = '.$category.' and  precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		footer_menu_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' and `category` = '".esc($from['category'])."'";
		$sql2 = "update		footer_menu_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'  and `category` = '".esc($to['category'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_footer_menu($id, $category)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, category, precedence from footer_menu_tb where id = '.$id.' and category = '.$category));
		$to=mysql_fetch_assoc(mysql_query('select id, category, precedence from footer_menu_tb where category = '.$category.' and  precedence > '.$from['precedence'].' order by precedence asc'));

		$sql1 = "update		footer_menu_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' and `category` = '".esc($from['category'])."'";
		$sql2 = "update		footer_menu_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."' and `category` = '".esc($to['category'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
}