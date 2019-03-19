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
}