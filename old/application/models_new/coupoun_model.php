<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Coupoun_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function add($name,$image, $prefix, $qty, $datestart, $dateend,$type_used, $type, $value, $minsub, $maxsub)
	{	$newdate=date("Y-m-d H:i:s");
		$idlogin=$this->session->userdata('admin_id');
		$q = "insert into coupon_tb (name,image,code_voucher,quantity,start_date,end_date,type_used,type,value,minimum_sub,maximum_sub,created_by, created_date,last_updated_date,last_updated_by) 
			  values('".esc($name)."',
					  '".esc($image)."',
			  		 '".esc($prefix)."',
					 '".esc($qty)."',
			  		 '".esc($datestart)."',
			  		 '".esc($dateend)."',
					 '".esc($type_used)."',
			  		 '".esc($type)."',
					 '".esc($value)."',
					 '".esc($minsub)."',
					 '".esc($maxsub)."',
					 '".esc($idlogin)."', 
					 '".esc($newdate)."',
					 '".esc($newdate)."', 
					 '".esc($idlogin)."')";
		$this->db->query($q);	
	}
	
	function adduser($coupon_id,$user_id,$status)
	{	$newdate=date("Y-m-d H:i:s");
		
		$q = "insert into coupon_user_tb (coupon_id	,user_id,status) 
			  values('".esc($coupon_id)."',
					  '".esc($user_id)."',
			  		 '".esc($status)."')";
		$this->db->query($q);	
	}
	
	function get_user_voc($id)
	{
		$q = "select a.*,b.email,b.full_name from coupon_user_tb a join user_tb b on a.user_id=b.id where coupon_id='".esc($id)."'";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	
	function get_voucher_list($coupoun,$user_id)
	{
		$q = "select a.*,b.status as status_cou from coupon_tb a join coupon_user_tb b ON a.id=b.coupon_id where quantity>0 and CURDATE() between `start_date` AND `end_date` AND `code_voucher` = '".esc($coupoun)."' AND `user_id` = '".esc($user_id)."' AND status=0";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_voucher_all($coupoun)
	{
		$q = "select * from coupon_tb where quantity>0 and CURDATE() between `start_date` AND `end_date` AND `code_voucher` = '".esc($coupoun)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	
	function get_voucher_type($coupoun)
	{
		$q = "select * from coupon_tb where `code_voucher` = '".esc($coupoun)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_voucher_id_bos($coupoun,$user_id)
	{
		$q = "select a.*,b.image as image_voucher,b.name as voucher_name,b.minimum_sub,b.maximum_sub,b.value,b.type as type_voc from shopping_cart_tb a JOIN coupon_tb b
		where b.id='".esc($coupoun)."' AND a.type='2'  AND a.voucher_id=b.id AND a.user_id='".esc($user_id)."'";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	
	function get_voucher()
	{
		$q = "select * from coupon_tb order by id DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function countcoupoun($coupoun)
	{
		$q = "select count(*) from coupon_tb where quantity>0 and CURDATE() between `start_date` AND `end_date` AND `code_voucher` = '".esc($coupoun)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function updateqty($voucher_id)
	{
		$q = "update coupon_tb set `quantity` = quantity-1,
									quantity_used =quantity_used+1
			  where `id` = '".esc($voucher_id)."'";
		$this->db->query($q);
	}
	
	function update_use_spec($voucher_id)
	{
		$newdate=date("Y-m-d H:i:s");
		$user_id=$this->session->userdata('user_id');
		$q = "update coupon_user_tb set `status` =  1,
										date_used='".esc($newdate)."'
			  where `coupon_id` = '".esc($voucher_id)."' AND user_id = '".esc($user_id)."'";
		$this->db->query($q);
	}
	
	
	function delete($id){
		$sql = "delete from coupon_tb
											where id = '".esc($id)."'";
											
		$this->db->query($sql);
	}
	
	function deleteuser($id){
		$sql = "delete from coupon_user_tb
											where id = '".esc($id)."'";
											
		$this->db->query($sql);
	}
	
	function delete_cou_sho($user_id){
		$sql = "delete from shopping_cart_tb
											where type=2 AND user_id = '".esc($user_id)."'";											
		$this->db->query($sql);
	}
	
	function coupoun_detail($id){
		$sql = "select * from coupon_tb where id = '".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function coupoun_history($id){
		$sql = "select a.*,b.full_name,b.email from coupon_history_tb a JOIN user_tb b ON a.user_id=b.id where coupon_id = '".esc($id)."'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function edit($id,$name,$image, $prefix, $qty, $datestart, $dateend, $type_used,$type, $value, $minsub, $maxsub){
		$newdate=date("Y-m-d H:i:s");
		$idlogin=$this->session->userdata('admin_id');
		$sql = "update coupon_tb set 		name = '".esc($name)."',
											image= '".esc($image)."',
											code_voucher = '".esc($prefix)."',
											quantity = '".esc($qty)."',
											start_date= '".esc($datestart)."',
											end_date= '".esc($dateend)."',
											type_used= '".esc($type_used)."',
											type= '".esc($type)."',
											value= '".esc($value)."',
											minimum_sub= '".esc($minsub)."',
											maximum_sub= '".esc($maxsub)."',
											last_updated_date = '".esc($newdate)."',
											last_updated_by  ='".esc($idlogin)."'
											
											where id = '".esc($id)."'";
		$this->db->query($sql);	
	}
	
		function get_voc_id($user_id)
	{
		$q = "select * from shopping_cart_tb where type=2  AND `user_id` = '".esc($user_id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function stamps_list($user_id)
	{
		$q = "select * from shopping_cart_tb where type=2  AND `user_id` = '".esc($user_id)."' and stamps_id!=0";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	
}