<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sale_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_all_sale(){
		$sql="select * from flash_sale_tb";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function insert_flash_sale($name, $percentage, $start, $end){
		$q = "insert into flash_sale_tb (name, percentage, start_time, end_time) values ('".esc($name)."', '".esc($percentage)."', '".esc($start)."', '".esc($end)."')";
		$this->db->query($q);
	}
	
	function update_flash_sale($flash_sale_id, $name, $percentage, $start_time, $end_time){
		$q = "update flash_sale_tb set name='".esc($name)."', percentage='".esc($percentage)."', start_time='".esc($start_time)."', end_time='".esc($end_time)."' where id='".esc($flash_sale_id)."'";
		$this->db->query($q);
	}
	
	function delete_item_by_flash_id($id){
		$q = "delete from flash_sale_item_tb where flash_sale_id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function delete_flash_sale($id){
		$q = "delete from flash_sale_tb where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function get_all_product(){
		$q = "select * from product_tb where active=1 order by name asc";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_all_sku(){
		$q = "select * from sku_tb order by name asc";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_flash_sale($id){
		$q="select *from flash_sale_tb where id='".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function get_item_by_flash_sale_id($id){
		$q="select *from flash_sale_item_tb where flash_sale_id='".esc($id)."'";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function insert_item($flash_sale_id, $product_id){
		$q = "insert into flash_sale_item_tb (flash_sale_id, product_id) values ('".esc($flash_sale_id)."', '".esc($product_id)."')";
		$this->db->query($q);
	}
	
	function get_sale_by_time($time_now){
		$q = "select * from flash_sale_tb where '".esc($time_now)."' >=`start_time` and  `end_time`>='".esc($time_now)."'";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function check_promo($sale_id, $now){
		$q = "select * from flash_sale_tb where '".esc($now)."' >=`start_time` and  `end_time`>='".esc($now)."' and id='".esc($sale_id)."'";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function get_sale_type(){
		$q = "select * from flash_sale_type_tb";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function insert_sale_type($type){
		$q = "insert into flash_sale_type_tb (type) values ('".esc($type)."')";
		$this->db->query($q);
	}
	
	function update_sale_type($type){
		$q = "update flash_sale_type_tb set type='".esc($type)."'";
		$this->db->query($q);
	}
	
	function update_stock($id, $qty){
		$q = "update sku_tb set stock='".esc($qty)."' where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	
	function get_active_product_sku(){
		$q = "select s.* from sku_tb s join product_tb p on p.id = s.product_id where p.active=1 order by s.name, s.size asc";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
}