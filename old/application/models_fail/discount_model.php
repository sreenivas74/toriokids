<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Discount_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_list()
	{
		$q = "select * from all_discount_tb";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_discount_list()
	{
		$q = "select * from all_discount_tb where status=1 and CURDATE() between `date_start` and `date_end`";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_data($id)
	{
		$q = "select * from all_discount_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function update_data($id, $data)
	{
		$this->db->update('all_discount_tb', $data, array('id'=>$id));
	}
	
	function update_status_discount($id)
	{
		$q = "update all_discount_tb set `status` = '0' where `id` != '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	//discount cart
	function get_list_discount_cart()
	{
		$q = "select * from discount_cart_tb";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_data_discount_cart($id)
	{
		$q = "select * from discount_cart_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function update_data_cart($id, $data)
	{
		$this->db->update('discount_cart_tb', $data, array('id'=>$id));
	}
	
	function get_current_discount_cart($now){
		$q = "select * from discount_cart_tb where date_start<='".esc($now)."' and date_end>='".esc($now)."' and status=1 order by id desc limit 1";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
}