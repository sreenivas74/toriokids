<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Currency_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_currency(){
		$q="select * from currency_tb";
		$query=$this->db->query($q);
		return $query->row_array();	
	}
	
	function update_currency($rate){
		$q="update currency_tb set `rate`='".esc($rate)."'";
		$this->db->query($q);
	}
}