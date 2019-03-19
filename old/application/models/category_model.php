<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Category_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	//category
	function get_category_list()
	{
		$q = "select * from category_tb order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_category_data($id)
	{
		$q = "select * from category_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_category_data2($alias)
	{
		$q = "select * from category_tb where `alias` = '".esc($alias)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_category_data3($name)
	{
		$q = "select * from category_tb where `name` = '".esc($name)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_category_list()
	{
		$q = "select * from category_tb where `active`=1 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_menu_category_by($category_id)
	{
		$sql="select * from `sub_category_tb` where `category_id` = '".esc($category_id)."' and `active`=1 order by precedence";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function update_data($id, $table, $data)
	{
		$this->db->update($table, $data, array('id'=>$id));
	}
	
	function up_precedence_category($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from category_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from category_tb where precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		category_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		category_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_category($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from category_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from category_tb where precedence > '.$from['precedence'].' order by precedence asc'));
		
		$sql1 = "update		category_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		category_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function delete_category_picture($id)
	{
		$sql = "update category_tb set `banner_image` = '' where id = '".esc($id)."'";
		$this->db->query($sql);	
	}
	
	//sub category
	function get_sub_category_list($category_id)
	{
		$q = "select * from sub_category_tb where `category_id`='".esc($category_id)."' order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_sub_category_data($id)
	{
		$q = "select * from sub_category_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_sub_category_data2($alias)
	{
		$q = "select * from sub_category_tb where `alias` = '".esc($alias)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_sub_category_data3($id)
	{
		$q = "select * from sub_category_tb where `category_id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_sub_category_list()
	{
		$q = "select * from sub_category_tb where `active`=1 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_active_sub_category_list_v2($category_id)
	{
		$q = "select * from sub_category_tb where `active`=1 and `category_id`='".esc($category_id)."' order by `id`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function insert_sub_category($category_id, $name, $image, $active, $precedence)
	{
		$q = "insert into sub_category_tb(`category_id`, `name`, `banner_image`, `active`, `precedence`) 
			  values('".esc($category_id)."',
			  		 '".esc($name)."',
					 '".esc($image)."',
			  		 '".esc($active)."',
					 '".esc($precedence)."')";
		$this->db->query($q);	
	}
	
	function update_alias2($id, $alias)
	{
		$q = "update sub_category_tb set `alias` = '".esc($alias)."'
			  where `id` = '".esc($id)."'";
		$this->db->query($q);
	}
	
	function update_sub_category($id, $name, $image)
	{
		$q = "update sub_category_tb set `name` = '".esc($name)."',
									 	 `banner_image` = '".esc($image)."'
			  where `id` = '".esc($id)."'";
		$this->db->query($q);
	}
	
	function update_active_sub_category($id, $active)
	{
		$q = "update sub_category_tb set `active` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function up_precedence_sub_category($id, $category_id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, category_id, precedence from sub_category_tb where id = '.$id.' and category_id = '.$category_id));
		$to=mysql_fetch_assoc(mysql_query('select id, category_id, precedence from sub_category_tb where category_id = '.$category_id.' and  precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		sub_category_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' and `category_id` = '".esc($from['category_id'])."'";
		$sql2 = "update		sub_category_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'  and `category_id` = '".esc($to['category_id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_sub_category($id, $category_id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, category_id, precedence from sub_category_tb where id = '.$id.' and category_id = '.$category_id));
		$to=mysql_fetch_assoc(mysql_query('select id, category_id, precedence from sub_category_tb where category_id = '.$category_id.' and  precedence > '.$from['precedence'].' order by precedence asc'));

		$sql1 = "update		sub_category_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' and `category_id` = '".esc($from['category_id'])."'";
		$sql2 = "update		sub_category_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."' and `category_id` = '".esc($to['category_id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function delete_sub_category_picture($id)
	{
		$sql = "update sub_category_tb set `banner_image` = '' where id = '".esc($id)."'";
		$this->db->query($sql);	
	}
}