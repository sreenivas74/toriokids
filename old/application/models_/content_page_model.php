<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Content_page_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_content_page_data()
	{
		$q = "select * from content_page_tb order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_content_page_data($id)
	{
		$q = "select * from content_page_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_content_page_data2($alias)
	{
		$q = "select * from content_page_tb where `active`=1 and `alias` = '".esc($alias)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_content_page_list()
	{
		$q = "select * from content_page_tb where `active`=1 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_active_content_page_list2()
	{
		$q = "select * from content_page_tb where `active`=1 and `name` in('Term of Use', 'Privacy Policy') order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function update_data($id, $data, $table)
	{
		$this->db->update($table, $data, array('id'=>$id));
	}
	
	function up_precedence_content_page($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from content_page_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from content_page_tb where precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		content_page_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		content_page_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_content_page($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from content_page_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from content_page_tb where precedence > '.$from['precedence'].' order by precedence asc'));
		
		$sql1 = "update		content_page_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		content_page_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	//FAQ Category
	function get_faq_category_data()
	{
		$q = "select * from faq_category_tb order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_faq_category_data($id)
	{
		$q = "select * from faq_category_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_faq_category_list()
	{
		$q = "select * from faq_category_tb where `active`=1 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function up_precedence_faq_category($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from faq_category_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from faq_category_tb where precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		faq_category_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		faq_category_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_faq_category($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from faq_category_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from faq_category_tb where precedence > '.$from['precedence'].' order by precedence asc'));
		
		$sql1 = "update		faq_category_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		faq_category_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	//FAQ
	function get_faq_data()
	{
		$q = "select * from faq_tb order by `faq_category_id`,`precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_faq_data2($category)
	{
		$q = "select * from faq_tb where `faq_category_id` = '".esc($category)."' order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_faq_data($id)
	{
		$q = "select * from faq_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_faq_list()
	{
		$q = "select * from faq_tb where `active`=1 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_active_faq_list2($category)
	{
		$q = "select * from faq_tb where `active`=1 and `faq_category_id` = '".esc($category)."' order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function up_precedence_faq($id, $faq_category_id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, type, precedence from faq_tb where id = '.$id.' and faq_category_id = '.$faq_category_id));
		$to=mysql_fetch_assoc(mysql_query('select id, faq_category_id, precedence from faq_tb where faq_category_id = '.$faq_category_id.' and  precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		faq_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' and `faq_category_id` = '".esc($from['faq_category_id'])."'";
		$sql2 = "update		faq_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'  and `faq_category_id` = '".esc($to['faq_category_id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_faq($id, $faq_category_id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, faq_category_id, precedence from faq_tb where id = '.$id.' and faq_category_id = '.$faq_category_id));
		$to=mysql_fetch_assoc(mysql_query('select id, faq_category_id, precedence from faq_tb where faq_category_id = '.$faq_category_id.' and  precedence > '.$from['precedence'].' order by precedence asc'));

		$sql1 = "update		faq_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' and `faq_category_id` = '".esc($from['faq_category_id'])."'";
		$sql2 = "update		faq_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."' and `faq_category_id` = '".esc($to['faq_category_id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
}