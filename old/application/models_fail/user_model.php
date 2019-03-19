<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class User_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}	
	
	function login($email,$password)
	{
		$sql="select * from user_tb where `email`='".esc($email)."' and `password`='".esc(md5($password))."' and status=1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function user_registration($email)
	{
		$date=date("Y-m-d H:i:s");
		$sql="insert into user_tb(`email`,`created_date`) 
		values('".esc($email)."','".esc($date)."')";	
		$this->db->query($sql);			
	}
	
	function update_registration_password($password,$id)
	{
		$sql="update user_tb set password = '".esc($password)."' where id = '".esc($id)."'";
		$this->db->query($sql);
	}
	
	function create_activation_code($user_id,$activation_code)
	{
		$date=date('Y-m-d');
		$sql="insert into user_activation_tb(`user_id`,`activation_code`,`created_date`) values('".esc($user_id)."','".esc(	$activation_code)."','$date')";
		$this->db->query($sql);
	}
	
	function user_detail($id)
	{
		$sql="select * from user_tb where id='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function check_user_activation_code($id,$code)
	{
		$sql="select * from user_activation_tb where user_id='".esc($id)."' and activation_code='".esc($code)."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function update_user_status($id,$status)
	{
		$date=date("Y-m-d H:i:s");
		$sql="update user_tb set status='".esc($status)."',`activated_date`='".esc($date)."' where id='".esc($id)."'";
		$this->db->query($sql);	
	}	
	
	function delete_user_activation($id,$code)
	{
		$sql="delete from user_activation_tb where user_id='".esc($id)."' and activation_code='".esc($code)."'";
		$this->db->query($sql);	
	}
	
	function check_email_all($email)
	{
		$sql="select * from user_tb where email='".esc($email)."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function check_email($email)
	{
		$sql="select * from user_tb where email='".esc($email)."' and status = '1' ";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function check_email2($email)
	{
		$sql="select * from user_tb where email='".esc($email)."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function check_password($password)
	{
		$sql="select * from user_tb where password='".esc(md5($password))."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function delete_user($id)
	{
		$sql="delete from user_tb where id='".esc($id)."'";
		$this->db->query($sql);
	}
	
	function get_id($id)
	{
		$sql="select * from user_tb where id='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function delete_user_activation2($id)
	{
		$sql="delete from user_activation_tb where id='".esc($id)."'";
		$this->db->query($sql);	
	}
	
	function get_user_activation($user_id)
	{
		$sql="select * from user_activation_tb where `user_id`='".esc($user_id)."' ";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function create_forgot_pass_code($user_id,$code)
	{
		$date=date('Y-m-d');
		$sql="insert into forgot_password_tb (`user_id`,`verification_code`,`created_date`)values('".esc($user_id)."','".esc($code)."','".esc($date)."')";
		$this->db->query($sql);
	}
	
	function get_shipping_address_list($user_id)
	{
		$sql="select * from user_address_tb where `user_id`='".esc($user_id)."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function insert_shipping_address($user_id,$name,$addr,$phone,$recipient_name)
	{
		$sql="insert into user_address_tb(`user_id`,`name`,`recipient_name`,`phone`,`shipping_address`) values('".esc($user_id)."','".esc($name)."','".esc($recipient_name)."','".esc($phone)."','".esc($addr)."')";
		$this->db->query($sql);	
	}
	
	function delete_forgotpass_activation($user_id,$code)
	{
		$sql="delete from forgot_password_tb where user_id='".esc($user_id)."' and verification_code='".esc($code)."'";
		$this->db->query($sql);
	}
	
	function change_status_user($id,$status)
	{
		$sql = "update user_tb set status = '".esc($status)."' where `id` = '".esc($id)."'";
		$this->db->query($sql);
	}
	
	function user_list()
	{
		$sql="select * from user_tb";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function user_list_act()
	{
		$sql="select * from user_tb where status=1 order by full_name ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	
	function user_list2($user)
	{
		$sql="select * from user_tb where `status`='".esc($user)."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_user_by_email($email){
		$sql="select id from user_tb where email='".esc($email)."' and status=1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_user_by_email2($email){
		$sql="select id from user_tb where email='".esc($email)."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function is_not_guest($email){
		$sql="select id from user_tb where email='".esc($email)."' and `guest`=0";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	//account
	function update_account($user_id,$fullname,$dob,$address,$province,$postcode,$telephone,$mobile, $city)
	{
		$sql="update user_tb set `full_name`='".esc($fullname)."',`date_of_birth`='".esc($dob)."',`address`='".esc($address)."',`province`='".esc($province)."',`city`='".esc($city)."',`postcode`='".esc($postcode)."',`telephone`='".esc($telephone)."',`mobile`='".esc($mobile)."'
		where `id`='".esc($user_id)."'";
		$this->db->query($sql);
	}
	
	function update_password($id,$newpassword)
	{
		$newpassword = trim($newpassword);
		$sql="update user_tb set `password`='".esc(md5($newpassword))."' where `id`='".esc($id)."'";
		$this->db->query($sql);
	}
	
	function create_change_email_code($user_id,$code,$email)
	{
		$date=date('Y-m-d H:i:s');
		$email=trim($email);
		$sql="insert into `user_change_email_tb` (`user_id`,`new_email`,`verification_code`,`created_date`) values ('".esc($user_id)."','".esc($email)."','".esc($code)."','".esc($date)."')";
		$this->db->query($sql);	
	}
	
	function check_change_email_request($user_id)
	{
		$sql="select * from user_change_email_tb where `user_id`='".esc($user_id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}	
	
	function check_user_change_email_activation_code($id,$code)
	{
		$sql="select * from user_change_email_tb where `user_id`='".esc($id)."' and `verification_code`='".esc($code)."'";
		$query = $this->db->query($sql);
		return $query->row_array();	
	}
	
	function delete_user_change_email($id,$code)
	{
		$sql="delete from user_change_email_tb where `user_id`='".esc($id)."' and `verification_code`='".esc($code)."'";
		$this->db->query($sql);
	}
	
	function update_user_email($id,$email)
	{
		$email=trim($email);
		$sql="update user_tb set `email`='".esc($email)."' where id='".esc($id)."'";
		$this->db->query($sql);
	}
	
	function get_search_user($keyword)
	{
		$sql="select * from user_tb where full_name like '%".esc($keyword)."%' or email like '%".esc($keyword)."%' or date_of_birth like '%".esc($keyword)."%' ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function insert_create_account2($user_id,$fullname,$dob,$address,$province,$zipcode,$telephone,$mobile, $password, $city)
	{
		$password = trim($password);
		$date=date("Y-m-d H:i:s");
		$sql="update user_tb set `full_name`='".esc($fullname)."',`date_of_birth`='".esc($dob)."',`address`='".esc($address)."',`province`='".esc($province)."',`city`='".esc($city)."',`postcode`='".esc($zipcode)."',`telephone`='".esc($telephone)."',`mobile`='".esc($mobile)."',`activated_date`='".esc($date)."', `password`='".esc(md5($password))."' where `id`='".esc($user_id)."'";
		$this->db->query($sql);
	}
	
	//address
	
	function insert_address($recipient,$shipping,$phone,$province,$zipcode,$user_id,$mobile, $city)
	{
		$sql="insert into user_address_tb(`recipient_name`,`shipping_address`,`phone`,`province`,`zipcode`,`user_id`,`mobile`, `city`)values('".esc($recipient)."','".esc($shipping)."','".esc($phone)."','".esc($province)."','".esc($zipcode)."','".esc($user_id)."','".esc($mobile)."','".esc($city)."')";
		$this->db->query($sql);
	}
	
	function edit_address($id,$recipient,$shipping,$phone,$province,$zipcode,$user_id,$mobile, $city)
	{
		$sql="update user_address_tb set `recipient_name`='".esc($recipient)."',`shipping_address`='".esc($shipping)."',`phone`='".esc($phone)."',`province`='".esc($province)."',`city`='".esc($city)."',`zipcode`='".esc($zipcode)."',`user_id`='".esc($user_id)."', `mobile`='".esc($mobile)."'
		 where `id`='".esc($id)."'";
		$this->db->query($sql);
	}
	
	function get_address($id)
	{
		$sql="select * from user_address_tb where `id`='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_address_list()
	{
		$sql="select * from user_address_tb";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_address_by_user($id)
	{
		$sql="select * from user_address_tb where `user_id`='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_address_by_user2($id)
	{
		$sql="select * from user_tb where `id`='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_address_by_user3($id)
	{
		$sql="select * from user_address_tb where `user_id`='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function delete_address($id)
	{
		$sql="delete from user_address_tb where `id`='".esc($id)."'";
		$this->db->query($sql);
	}
	
	// order
	function get_order_by_user($id)
	{
		$sql="select * from order_tb where `user_id`='".esc($id)."' order by id desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_order_by_user2($id)
	{
		$date_start=date("Y-m-d 00:00:00");
		$date_end=date("Y-m-d 23:59:59");
		$sql="select * from order_tb where `user_id`='".esc($id)."' and `transaction_date` BETWEEN  '".esc($date_start)."' - interval 2 month and '".esc($date_end)."' order by `id` desc limit 5";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_order($id)
	{
		$sql="select * from order_item_tb where `order_id`='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_order2($id)
	{
		$sql="select a.*, b.name, b.alias, b.weight, b.msrp, b.price as sell_price from order_item_tb a, product_tb b where  a.product_id=b.id and a.order_id='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_shipping_info($id)
	{
		$sql="select * from order_tb where `id`='".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_order_list()
	{
		$sql="select * from order_tb ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	/// maintenance
	
	function get_maintenance()
	{
		$sql="select * from maintenance_tb";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function active_maintenance($active)
	{
		$sql = "update maintenance_tb set active = '".esc($active)."'";
		$this->db->query($sql);	
	}
	
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function update_data($table, $data, $where)
	{
		$this->db->update($table, $data, $where);
	}
	
	function set_as_default_address($addr_id,$user_id){
		$q="update user_address_tb set `default_address`=0 where user_id='".esc($user_id)."'";
		$this->db->query($q);	
		
		$q="update user_address_tb set `default_address`=1 where id='".esc($addr_id)."'";
		$this->db->query($q);	
		
	}
	
	function get_default_address($user_id){
		$q="select * from user_address_tb where `user_id`='".esc($user_id)."' and `default_address`=1";
		$query=$this->db->query($q);
		return $query->row_array();
	}
	
	function add_guest_email($email){
		$sql = "insert into user_tb (`email`, `guest`) values ('".esc($email)."', 1)";
		$query = $this->db->query($sql);
	}
}