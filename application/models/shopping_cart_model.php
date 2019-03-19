<?php if(!defined('BASEPATH')) exit("Hacking Attempt?");
class Shopping_cart_model extends CI_Model{
	function Shopping_cart_model(){
		parent::__construct();	
	}
	
	function get_shopping_cart_list_user($id)
	{
		$sql="select * from shopping_cart_tb where `user_id`='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function get_discount_type($id)
	{
		$sql="select * from shopping_cart_tb where `user_id`='".esc($id)."' and type=2";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_shopping_cart_list($session_id)
	{
		$sql="select * from shopping_cart_tb where `session_id`='".esc($session_id)."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_shopping_cart_list_user2($id)
	{
		$sql="select a.*, b.name, b.alias, b.weight, b.msrp, b.price as sell_price, c.size 
		from shopping_cart_tb a, product_tb b, sku_tb c
		where a.product_id=b.id and c.id = a.sku_id
		and a.user_id='".esc($id)."' order by id desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_total_shopping_cart_list_user2($id)
	{
		$sql="select count(*) as total
		from shopping_cart_tb a, product_tb b, sku_tb c
		where a.product_id=b.id and c.id = a.sku_id
		and a.user_id='".esc($id)."'";
		$query = $this->db->query($sql);
		$data=$query->row_array();
		return $data['total'];
	}
	
	function get_shopping_cart_list_guest2($id)
	{
		$sql="select a.*, b.name, b.alias, b.weight, b.msrp, b.price as sell_price, c.size 
		from shopping_cart_tb a, product_tb b, sku_tb c
		where a.product_id=b.id and c.id = a.sku_id
		and a.session_id='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_discount_on_cart($id)
	{
	 	$sql="select a.*,b.code_voucher as code_voucher,b.image as image_voucher,b.name as voucher_name,b.minimum_sub,b.maximum_sub,b.value,b.type as type_voc from shopping_cart_tb a JOIN coupon_tb b
		where a.user_id='".esc($id)."' AND a.type='2'  AND a.voucher_id=b.id limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_discount_on_cart_guest($session_id)
	{
	 	$sql="select a.*,b.code_voucher as code_voucher,b.image as image_voucher,b.name as voucher_name,b.minimum_sub,b.maximum_sub,b.value,b.type as type_voc from shopping_cart_tb a JOIN coupon_tb b
		where a.session_id='".esc($session_id)."' AND a.type='2'  AND a.voucher_id=b.id limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_discount_user($id)
	{
	 	$sql="select a.*,b.code_voucher as code_voucher,b.image as image_voucher,b.name as voucher_name,b.minimum_sub,b.maximum_sub,b.value,b.type as type_voc from shopping_cart_tb a JOIN coupon_tb b where a.user_id='".esc($id)."' AND a.type='2'  AND a.voucher_id=b.id ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_discount_guest($session_id)
	{
	 	$sql="select a.*,b.code_voucher as code_voucher,b.image as image_voucher,b.name as voucher_name,b.minimum_sub,b.maximum_sub,b.value,b.type as type_voc from shopping_cart_tb a JOIN coupon_tb b
		where a.session_id='".esc($session_id)."' AND a.type='2'  AND a.voucher_id=b.id ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
		function get_discount_facebook($id)
	{
		$sql="select * from shopping_cart_tb
		where user_id='".esc($id)."' AND type='2'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_discount_user2($id)
	{
		$sql="select a.*,b.image as image_voucher,b.name as voucher_name,b.minimum_sub,b.maximum_sub,b.value,b.type as type_voc from shopping_cart_tb a JOIN coupon_tb b
		where a.user_id='".esc($id)."' AND a.type='2'  AND a.voucher_id=b.id limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_discount_guest2($id)
	{
		$sql="select a.*,b.image as image_voucher,b.name as voucher_name,b.minimum_sub,b.maximum_sub,b.value,b.type as type_voc from shopping_cart_tb a JOIN coupon_tb b
		where a.session_id='".esc($id)."' AND a.type='2'  AND a.voucher_id=b.id limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_dis_disc($user_id)
	{
		$sql="select a.*,b.image as image_voucher,b.name as voucher_name,b.minimum_sub,b.maximum_sub,b.value,b.type as type_voc 
from shopping_cart_tb a JOIN coupon_tb b
ON a.voucher_id=b.id where user_id='".esc($user_id)."' ";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	
	//for new coupon module (without non-discount items only)
	function get_total_cart_value($user_id){
		$sql="select sum(total) as total from shopping_cart_tb where user_id='".esc($user_id)."' and type =1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_total_cart_value_guest($session_id){
		$sql="select sum(total) as total from shopping_cart_tb where session_id='".esc($session_id)."' and type =1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	//end of new coupon module
	
	
	function get_total_value($user_id)
	{
		$sql="select sum(total) as totalsemua from shopping_cart_tb where user_id='".esc($user_id)."' and type =1 and discount=0";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_total_value_guest($session_id)
	{
		$sql="select sum(total) as totalsemua from shopping_cart_tb where session_id='".esc($session_id)."' and type =1 and discount=0";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	
	
	function get_shopping_cart_list2($session_id)
	{
		$sql="select a.*, b.name, b.alias, b.weight, b.msrp, b.price as sell_price, c.size 
		from shopping_cart_tb a, product_tb b, sku_tb c
		where a.product_id=b.id and c.id = a.sku_id
		and a.session_id='".esc($session_id)."' order by id desc ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	//guest
	function check_shopping_cart_guest($product_id,$sku_id,$session_id,$price)
	{
		$sql="select * from shopping_cart_tb where `session_id`='".esc($session_id)."' and `product_id`='".esc($product_id)."' and `sku_id`='".esc($sku_id)."' and `price`='".esc($price)."'";
		$query = $this->db->query($sql);
		return $query->row_array();	
	}
	
	//user
	function check_shopping_cart_user($product_id,$sku_id,$user_id,$price)
	{
		$sql="select * from shopping_cart_tb where `user_id`='".esc($user_id)."' and `product_id`='".esc($product_id)."' and `price`='".esc($price)."' and `sku_id`='".esc($sku_id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();		
	}
	
	function remove_shopping_cart($id)
	{
		$sql="delete from shopping_cart_tb where id='".esc($id)."'";
		$this->db->query($sql);
	}
	
	function delete_session_shopping_cart($id)
	{
		$sql="delete from shopping_cart_tb where session_id='".esc($id)."'";
		$this->db->query($sql);
	}
	
	function delete_shopping_cart_by_user($id)
	{
		$sql="delete from shopping_cart_tb where user_id='".esc($id)."'";
		$this->db->query($sql);
	}
	
	//order	
	function update_order($order_id,$number)
	{
		$sql="update order_tb set `order_number`='".esc($number)."' where `id`='".esc($order_id)."'";
		$this->db->query($sql);
	}
	
	function get_order($id)
	{
		$sql="select * from order_tb where `id`='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();	
	}
	
	function get_order_item($id)
	{
		$sql="select * from order_item_tb where `order_id`='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_order_item2($id)
	{
		$sql="SELECT a . * , b.name, b.sku_code, b.alias, b.weight, b.msrp, b.price AS sell_price, c.size
		FROM order_item_tb a, product_tb b, sku_tb c
		WHERE a.product_id = b.id
		AND c.id = a.sku_id
		and a.order_id='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function insert_order_item($product,$sku_id,$price,$quantity,$total,$user_id,$order_id)
	{
		$sql="insert into order_item_tb(`product_id`,`sku_id`,`price`,`quantity`,`total`,`user_id`,`order_id`)values('".esc($product)."','".esc($sku_id)."','".esc($price)."','".esc($quantity)."','".esc($total)."','".esc($user_id)."','".esc($order_id)."')";
		$this->db->query($sql);
	}	
	
	//
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function insert_data_batch($table, $data)
	{
		$this->db->insert_batch($table, $data);
	}
	
	function update_data($table, $data, $where)
	{
		$this->db->update($table, $data, $where);
	}
	
	function get_doku_payment_data($doku_id)
	{
		$sql="select * from doku_tb where `id`='".esc($doku_id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();	
	}
	
	function get_doku_data($order_number)
	{
		$sql="select transidmerchant,totalamount from doku_tb where transidmerchant='".($order_number)."' and trxstatus='Requested'";
		$query = $this->db->query($sql);
		return $query->row_array();	
	}
	
	function get_doku_data2($order_number)
	{
		$sql="select * from doku_tb where transidmerchant='".($order_number)."'";
		$query = $this->db->query($sql);
		return $query->row_array();	
	}
	
	function delete_doku_session($session_id)
	{
		$sql="delete from doku_tb where `session_id`='".esc($session_id)."'";
		$this->db->query($sql);
	}
	
	function check_quantity_cart($user_id, $sku_id){
		$sql="select quantity from shopping_cart_tb where user_id='".($user_id)."' and sku_id='".esc($sku_id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();	
	}
	
	function check_quantity_cart2($session_id, $sku_id){
		$sql="select quantity from shopping_cart_tb where session_id='".($session_id)."' and sku_id='".esc($sku_id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();	
	}
	function delete_shopping_cart($id){
		$sql="delete from shopping_cart_tb where id = '".esc($id)."'";
		$query = $this->db->query($sql);
	}
}