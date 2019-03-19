<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Newsletter_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}	
	
	function check_email_newsletter($email)
	{
		$sql="select * from newsletter_tb where `email`='".esc($email)."'";
		$query = $this->db->query($sql);
		return $query->row_array();	;
	}
	
	function check_email_newsletter2($email)
	{
		$sql="select * from newsletter_tb where `email`='".esc($email)."' and `status`=1";
		$query = $this->db->query($sql);
		return $query->row_array();	;
	}
	
	function create_newsletter($email,$code)
	{
		$date=date("Y-m-d");
		$sql="insert into newsletter_tb (`email`,`code`,`created_date`) values('".esc($email)."','".esc($code)."','".esc($date)."')";
		$this->db->query($sql);		
	}
	
	function check_newsletter_code($id,$code)
	{
		$sql="select * from newsletter_tb where id='".esc($id)."' and `code`='".esc($code)."'";
		$query = $this->db->query($sql);
		return $query->row_array();	;
	}
	
	function update_newsletter_status($id,$status)
	{
		$date=date("Y-m-d");
		$sql="update newsletter_tb set `code`='',`activated_date`='".esc($date)."',`status`='".esc($status)."' where id='".esc($id)."'";
		$this->db->query($sql);
	}	
		
	function newsletter_detail($id)
	{
		$sql="select * from newsletter_tb where id='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();	;
	}
	
	function delete_newsletter($id)
	{
		$sql="delete from newsletter_tb where id='".esc($id)."'";
		$this->db->query($sql);
	}
	
	function newsletter_list()
	{
		$sql="select id,email,status from newsletter_tb";
		$query = $this->db->query($sql);
		return $query->result_array();	
	}
	
	function newsletter_active()
	{
		$sql="select id,email,status from newsletter_tb where status=1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function newsletter_inactive()
	{
		$sql="select id,email,status from newsletter_tb where status=0";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function active($id,$active){
		$sql = "update newsletter_tb set status = '".esc($active)."' where `id` = '".esc($id)."'";
		$this->db->query($sql);
	}
}