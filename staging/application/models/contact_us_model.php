<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Contact_us_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_contact_us_list()
	{
		$q = "select * from contact_us_tb";
		$query = $this->db->query($q);
		return $query->row_array();	
	}

	
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function update_data($id, $data)
	{
		$this->db->update('contact_us_tb', $data, array('id'=>$id));
	}

}