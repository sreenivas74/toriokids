<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class jne_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_filter_pronvice($search){
		$q = "select * from jne_province_tb where `name` LIKE '%".esc($search)."%'  order by `name`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_city_filter($search)
	{
		$q = "select a.*,b.name as province_name from jne_city_tb a 
		left JOIN jne_province_tb b 
		ON a.jne_province_id=b.id where  a.name LIKE '%".esc($search)."%' OR  b.name LIKE '%".esc($search)."%' order by a.name";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	function get_city_filter_new($search)
	{
		$q = "select a.*,b.name as province_name from jne_city_tb a 
		left JOIN jne_province_tb b 
		ON a.jne_province_id=b.id where  a.name LIKE '%".esc($search)."%' OR  b.name LIKE '%".esc($search)."%' and type=0 order by a.name";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	function get_city_all()
	{
		$q = "select * from jne_city_tb order by `name`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_city_all_new()
	{
		$q = "select * from jne_city_tb order by `name` and type=0";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_city_by_id($id)
	{
		$q = "select * from jne_city_tb where id='".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	
	function get_jne_province_data()
	{
		$q = "select * from jne_province_tb order by `name`";
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
		$q = "select b.*,a.name as province_name from jne_city_tb b
		left join  jne_province_tb a on a.id=b.jne_province_id 
		order by a.name,b.name";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_jne_data_new_all()
	{
		$q = "select b.*,a.name as province_name from jne_city_tb b
		left join  jne_province_tb a on a.id=b.jne_province_id where type=0
		order by a.name,b.name";
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
	
	function get_city_by_province($province_id)
	{
		$q = "select * from jne_city_tb where `jne_province_id`= '".esc($province_id)."' and type=0 order by `id`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_province_by_name($province_id){
		$q = "select * from jne_province_tb where `name`= '".esc($province_id)."'";
		$query = $this->db->query($q);
		return $query->row_array();
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
	function insert_csv_city($jne_province_id,$kecamatan_name,$reguler,$reguler_etd,$oke,$oke_etd){
		 $sql = "insert into jne_city_tb (jne_province_id,name,regular_fee,regular_etd,express_fee,express_etd)
				values	('".esc($jne_province_id)."',
							'".esc($kecamatan_name)."',
							'".esc($reguler)."',
							'".esc($reguler_etd)."',
							'".esc($oke)."',
							'".esc($oke_etd)."')"
						;
		$this->db->query($sql);	
	
	}
	
	function update_csv_city($id,$province_id,$kecamatan_name,$reguler,$reguler_etd,$oke,$oke_etd){
		$sql="update jne_city_tb set `jne_province_id`='".esc($province_id)."',`name`='".esc($kecamatan_name)."',`regular_fee`='".esc($reguler)."',`regular_etd`='".esc($reguler_etd)."',`express_fee`='".esc($oke)."' ,`express_etd`='".esc($oke_etd)."' where `id`='".esc($id)."'";
		
		$this->db->query($sql);
	}
	function insert_csv_province($name){
		 $sql = "insert into jne_province_tb (name)
				values	('".esc($name)."')";
		$this->db->query($sql);	
	
	}
	
	
	
	
	
}