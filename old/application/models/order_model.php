<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Order_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}	
	
	function get_email_sent(){
		$q="select * from email_sent_pdf_tb order by ID DESC ";	
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function get_order_list(){
		$q="select * from order_tb order by ID DESC ";	
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_order_list_type_bank(){
		$q="select * from order_tb where payment_type=1 order by ID DESC ";	
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_order_list_type_cc(){
		$q="select * from order_tb where payment_type=2 order by ID DESC ";	
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_order_detail($order_id)
	{
		$q="select * from order_tb where id='".esc($order_id)."'";	
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function get_order_item($order_id)
	{
		$q="select * from order_item_tb where order_id='".esc($order_id)."'";	
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_order_item2($order_id)
	{
		$sql="select a.*, b.name, b.alias, b.weight, b.msrp, b.price as sell_price from order_item_tb a, product_tb b where  a.product_id=b.id and a.order_id='".esc($order_id)."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function update_order_item_status($order_item_id,$status_id)
	{
		$q="update order_item_tb set `status`='".esc($status_id)."' where id='".esc($order_item_id)."'";
		$this->db->query($q);		
	}
	
	function update_order_status($order_id,$status_id)
	{
		$q="update order_tb set `status`='".esc($status_id)."' where id='".esc($order_id)."'";
		$this->db->query($q);		
		
		//updated time
		$time = date('Y-m-d H:i:s');
		$sql = "update order_tb set updated_status='".esc($time)."' where id='".esc($order_id)."'";	
		$this->db->query($sql);
	}
	
	function update_stamp_id($emailstamps,$id_stamps)
	{
		$q="update user_tb set `stamps_id`='".esc($id_stamps)."' where email='".esc($emailstamps)."'";
		$this->db->query($q);			
	}
	
	function update_shipping_cost($order_id,$shipping_cost)
	{
		$q="update order_tb set `shipping_cost`='".esc($shipping_cost)."' where id='".esc($order_id)."'";
		$this->db->query($q);	
	}
	
	function get_search_order($keyword)
	{
		$search="";
		
		$sql="select * from order_tb where order_number like '%".esc($keyword)."%' or user_id like '%".esc($keyword)."%'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_totalprice($order_id)
	{
		$sql=" select sum(`total`) as 'sum'  from order_item_tb where `order_id`='".esc($order_id)."' and status!=-1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function update_total_order($id,$total)
	{
		$sql="update order_tb set `total`='".esc($total)."' where `id`='".esc($id)."'";
		$this->db->query($sql);
	}
	
	function update_order_item($order_id,$status_id,$quantity,$total_price,$delivery_time,$price)
	{
		$q="update order_item_tb set `status`='".esc($status_id)."',`price` = '".esc($price)."' ,`quantity`='".esc($quantity)."',`total`='".esc($total_price)."',`delivery_time`='".esc($delivery_time)."' where id='".esc($order_id)."'";
		$this->db->query($sql);	
	}
	
	function add_msg($order_id,$msg)
	{
		$date=date('Y-m-d H:i:s');
		$sql="insert into email_msg_tb(`order_id`,`msg`,`created_date`)values('".esc($order_id)."','".esc($msg)."','".esc($date)."')";	
		$this->db->query($sql);
	}
	
	function get_message($id)
	{
		$sql="select * from email_msg_tb where order_id ='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_message_for_email($id)
	{
		$sql="select * from email_msg_tb where order_id ='".esc($id)."' order by id DESC limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_recap()
	{
		$sql="select * from order_tb where status = 2";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_recap_list()
	{
		$sql="select * from order_tb";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_recap_list_filter($status, $from, $to)
	{
		$data="";
		if($status == 'ALL')
		{
			if($from && $to)$data=" where transaction_date between '".esc(date('Y-m-d',strtotime($from)))." 00:00:00"."' and '".esc(date('Y-m-d',strtotime($to)))." 23:59:59"."'";
			$sql="select * from order_tb ".$data."";
		}
		else
		{
			if($from && $to)$data=" and  transaction_date between '".esc(date('Y-m-d',strtotime($from)))." 00:00:00"."' and '".esc(date('Y-m-d',strtotime($to)))." 23:59:59"."'";
			$sql="select * from order_tb where status ='".esc($status)."' ".$data."";
		}
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_order_number()
	{
		$q="select * from order_number_counter_tb";	
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function update_order_number($num)
	{
		$sql="update order_number_counter_tb set `counter`='".esc($num)."'";
		$this->db->query($sql);
	}
	
	function update_order_number2($num)
	{
		$date=date('Y-m-d');
		$sql="update order_number_counter_tb set `counter`='".esc($num)."', updated_date='".esc($date)."'";
		$this->db->query($sql);
	}
	
	function check_order_by_email($order_number,$email_address){
		$q="select a.*, b.email from order_tb a left join 
		user_tb b on a.user_id=b.id
		where order_number='".esc($order_number)."' and b.email='".esc($email_address)."'";
		
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function get_order_item_all_for_download(){
		$q="select a.*,b.order_number,b.recipient_name as recipient_name,b.transaction_date,b.status,b.city as city_name,c.name as product_name,d.name as city_name,e.full_name as full_name
		FROM order_item_tb a JOIN order_tb b on a.order_id=b.id
		JOIN product_tb c ON a.product_id=c.id 
		JOIN jne_city_tb d on b.city = d.id 
		JOIN user_tb e ON b.user_id=e.id order by b.id DESC";
		
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_order_diffrent_one_hours(){
		$q="select * from order_tb where sent_reminder=0 and email_sent!= '0000-00-00 00:00:00' and status = 0 ";	
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_order_diffrent_two_days(){
		$q="select * from order_tb where sent_reminder=1 and status = 0 ";	
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function add_email_history($order_id, $email,$subject, $message, $now){
		$q = "insert into email_counter_tb (order_id, email_to, subject, content, send_time) values ('".esc($order_id)."', '".esc($email)."', '".esc($subject)."', '".esc($message)."', '".esc($now)."')";
		$this->db->query($q);
	}
	
	function get_email_history($id){
		$q = "select * from email_counter_tb where order_id='".esc($id)."'";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function remove_sale_id($id){
		$q = "update order_item_tb set sale_id=0 where id='".esc($id)."'";
		$this->db->query($q);
	}
}
?>