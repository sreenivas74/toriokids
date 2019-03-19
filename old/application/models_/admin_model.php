<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Admin_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}	
	
	function login($username,$password)
	{
		$q="select * from admin_tb where `username`='".esc($username)."' and `password`='".esc($password)."' and active=1";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function admin_last_login()
	{
		$date=date("Y-m-d H:i:s");
		$id=$this->session->userdata('admin_id');
		$q = "update admin_tb set last_login = '".esc($date)."' where id = '".esc($id)."'";
		$query = $this->db->query($q);	
	}
}