<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Countdown_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_all_countdown(){
		$sql="select * from countdown_tb order by start_time asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_countdown($id){
		$sql = "select * from countdown_tb where id='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function insert_countdown($name, $start, $end, $pic, $mobile){
		$q = "insert into countdown_tb (name, image, image_mobile, start_time, end_time) values ('".esc($name)."', '".esc($pic)."', '".esc($mobile)."', '".esc($start)."', '".esc($end)."')";
		$this->db->query($q);
	}
	
	function update_countdown($id, $name, $start_time, $end_time, $pic, $mobile){
		$q = "update countdown_tb set name='".esc($name)."', image='".esc($pic)."', image_mobile='".esc($mobile)."', start_time='".esc($start_time)."', end_time='".esc($end_time)."' where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function delete_countdown($id){
		$q = "delete from countdown_tb where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function get_upcoming_countdown($time){
		$q = "select * from countdown_tb where start_time>'".esc($time)."' and end_time>'".esc($time)."' limit 1";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
}