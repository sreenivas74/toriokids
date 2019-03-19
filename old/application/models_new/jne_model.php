<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class jne_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_jne_province_data()
	{
		$q = "select * from jne_province_tb order by `id`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_jne_city_data()
	{
		$q = "select * from jne_city_tb order by `precedence` asc";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_jne_data()
	{
		$q = "select b.* from jne_province_tb a, jne_city_tb b where a.id=b.jne_province_id order by b.jne_province_id";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_city($id)
	{
		$q = "select * from jne_city_tb where `jne_province_id`= '".esc($id)."' order by `id`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_city2($id)
	{
		$q = "select * from jne_city_tb where `id`= '".esc($id)."' order by `id`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_shipping_method($city)
	{
		$q = "select * from jne_city_tb where `id` = '".esc($city)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_jne_province_data($province)
	{
		$q = "select * from jne_province_tb where `id` = '".esc($province)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function update_data($table, $data, $where)
	{
		$this->db->update($table, $data, $where);
	}
	
	function up_precedence_jne_city($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from jne_city_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from jne_city_tb where precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		jne_city_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		jne_city_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_jne_city($id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from jne_city_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from jne_city_tb where precedence > '.$from['precedence'].' order by precedence asc'));
		
		$sql1 = "update		jne_city_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		jne_city_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	
	function update_precedence($id,$precedence){
		$q="update jne_city_tb set `precedence`='".esc($precedence)."' where id='".esc($id)."'";
		$query = $this->db->query($q);
	}
	
		
	function get_precedence_in_between($start,$end){
		$q="SELECT * 
		FROM jne_city_tb
		WHERE precedence >= '".esc($start)."' and precedence < '".esc($end)."'
		ORDER BY `precedence` ASC
		";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
}