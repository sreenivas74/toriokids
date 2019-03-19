<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Ads_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_ads_desktop(){
		$q = "select * from ads_tb where name='desktop' limit 1";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function get_ads_mobile(){
		$q = "select * from ads_tb where name='mobile' limit 1";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function insert_ads($name, $value){
		$q = "insert into ads_tb (name, value) values ('".esc($name)."', '".esc($value)."')";
		$this->db->query($q);
	}
}