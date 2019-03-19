<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class General_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}		
	
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function insert_data_batch($table,$data){		
		$this->db->insert_batch($table, $data);
	}
	
	function update_data($table, $data, $where)
	{
		$this->db->update($table, $data, $where);
	}
	
	function delete_data($table,$where)
	{
		$this->db->delete($table, $where);
	}
	
	function truncate_data($table)
	{
		$this->db->truncate($table);
	}
}