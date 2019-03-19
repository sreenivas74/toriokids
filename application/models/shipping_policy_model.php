<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Shipping_policy_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_detail(){
		$q = "select * from shipping_policy_tb";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
}