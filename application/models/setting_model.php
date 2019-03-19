<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setting_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function edit_setting($name,$value){
		$q="update mailchimp_tb set `value`='".esc($value)."' where name='".esc($name)."'";
		$this->db->query($q);
	}
	
	function get_setting(){
		$q="select *from mailchimp_tb";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_setting_by_name($name){
		$q="select *from mailchimp_tb where name='".esc($name)."'";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function get_mailing_list(){
		$q="select *from mailing_list_tb";
		$query = $this->db->query($q);
		return $query->result_array();
	}
}