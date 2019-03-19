<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class product_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	//produk
	function get_product_list()
	{
		$q = "select * from product_tb order by `id` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_product_list_price()
	{
		$q = "select * from product_tb order by `name` ASC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_new_product_list()
	{
		$q = "select * from product_tb where flag=1 order by `id`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_product_data($id)
	{
		$q = "select * from product_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_product_data3($id)
	{
		$q = "select * from product_tb where `id` = '".esc($id)."' and active=1 ";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_selected_product_data2($cat_al, $sub_cat_al)
	{
		$data = " ";
		if($cat_al)$data= " `category_name` like '%".esc($cat_al)."%' ";
		if($sub_cat_al)$data= " and `sub_category_name` like '%".esc($sub_cat_al)."%' ";
		$q = "select * from product_tb where ".$data." order by `id`";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_product_list($name)
	{
		$q = "select * from product_tb where `active`=1 and `category_name` like '%".esc($name)."%' order by `id`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_active_product_list_paging($name,$offset,$num)
	{
		$q = "select * from product_tb where `active`=1 and `category_name` like '%".esc($name)."%' order by `id` DESC limit ".esc($offset).",".esc($num)."";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_best_seller_paging($offset,$num)
	{
		$q = "select * from product_tb where `active`=1 and best_seller=1 order by `id` DESC limit ".esc($offset).",".esc($num)."";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_best_seller_total()
	{
		$q = "select count(*) as total from product_tb where `active`=1 and best_seller=1 order by `id`";
		$query = $this->db->query($q);
		$data=$query->row_array();	
		return $data['total'];
	}
	
	function get_sale_paging($offset,$num)
	{
		$q = "select * from product_tb where `active`=1 and sale_product=1 order by `id` DESC limit ".esc($offset).",".esc($num)."";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_sale_total()
	{
		$q = "select count(*) as total from product_tb where `active`=1 and sale_product=1 order by `id`";
		$query = $this->db->query($q);
		$data=$query->row_array();	
		return $data['total'];
	}
	
	function count_get_active_product_list($name)
	{
		$q = "select count(*) as total from product_tb where `active`=1 and `category_name` like '%".esc($name)."%' order by `id`";
		$query = $this->db->query($q);
		$data=$query->row_array();	
		return $data['total'];
	}
	
	function get_active_new_product_list($name)
	{
		$q = "select * from product_tb where `active`=1 and `flag`=1 and `category_name` like '%".esc($name)."%' order by `id`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_active_featured_list()
	{
		$q = "select * from product_tb where `active`=1 and `featured` =1 order by `id`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function count_active_new_product_list($name)
	{
		$q = "select count(*) as total from product_tb where `active`=1 and `flag`=1 and `category_name` like '%".esc($name)."%' order by `id`";
		
		$query = $this->db->query($q);
		$data=$query->row_array();	
		return $data['total'];
	}
	
	function get_active_new_product_list_paging($name,$offset,$num)
	{
		$q = "select * from product_tb where `active`=1 and `flag`=1 and `category_name` like '%".esc($name)."%' order by `id` DESC limit ".esc($offset).",".esc($num)."";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_active_product_list2($sub_name, $cat_name)
	{
		$q = "select * from product_tb where `active`=1 and `category_name` like '%".esc($cat_name)."%' and `sub_category_name` like '%".esc($sub_name)."%'  order by `id`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function count_active_product_list2($sub_name, $cat_name)
	{
		$q = "select count(*) as total from product_tb where `active`=1 and `category_name` like '%".esc($cat_name)."%' and `sub_category_name` like '%".esc($sub_name)."%'  order by `id`";
		$query = $this->db->query($q);
		$data=$query->row_array();	
		return $data['total'];
	}
	
	function get_active_product_list2_paging($sub_name, $cat_name,$offset,$num)
	{
		$q = "select * from product_tb where `active`=1 and `category_name` like '%".esc($cat_name)."%' and `sub_category_name` like '%".esc($sub_name)."%'  order by `id` DESC limit ".esc($offset).",".esc($num)."";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function search_product($search)
	{
		$q=$search;
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	
	
	function insert_product($category_name, $sub_category_name, $name, $price, $description, $active, $flag, $weight,$sale_product,$msrp, $best_seller,$featured,$template_id,$discount)
	{
		$q = "insert into product_tb(`category_name`, `sub_category_name`, `name`, `price`, `description`, `active`, `flag`, `weight`,`sale_product`,`msrp`,`best_seller`,`featured`,`template_id`,`discount`) 
			  values('".esc($category_name)."',
					 '".esc($sub_category_name)."',
					 '".esc($name)."',
					 '".esc($price)."',
					 '".esc($description)."',
					 '".esc($active)."',
					 '".esc($flag)."',
					 '".esc($weight)."',
					 '".esc($sale_product)."',
					 '".esc($msrp)."',
					 '".esc($best_seller)."',
					'".esc($featured)."',
					'".esc($template_id)."',
					'".esc($discount)."' )";
		$this->db->query($q);	
	}
	
	function get_featured_item_list()
	{
		$q = "select * from product_tb order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	function update_alias($id, $alias)
	{
		$q = "update product_tb set `alias` = '".esc($alias)."'
			  where `id` = '".esc($id)."'";
		$this->db->query($q);
	}
	
	function update_product($id, $category_name, $sub_category_name, $name, $price, $description, $flag, $weight,$sale_product,$msrp, $best_seller,$featured,$template_id,$discount)
	{
		$q = "update product_tb set `category_name` = '".esc($category_name)."',
									`sub_category_name` = '".esc($sub_category_name)."',
									`name` = '".esc($name)."',
									`price` = '".esc($price)."',
									`description` = '".esc($description)."',
									`flag` = '".esc($flag)."',
									`weight` = '".esc($weight)."',
									`sale_product` = '".esc($sale_product)."',
									`msrp` = '".esc($msrp)."',
									`best_seller` = '".esc($best_seller)."',
									`featured` = '".esc($featured)."',
									`template_id` = '".esc($template_id)."',
									`discount` = '".esc($discount)."'
			  where `id` = '".esc($id)."'";
		$this->db->query($q);
	}
	
	function update_active_product($id, $active)
	{
		$q = "update product_tb set `active` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function update_data($table, $data, $where)
	{
		$this->db->update($table, $data, $where);
	}
	
	function update_new_product($id, $active)
	{
		$q = "update product_tb set `flag` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function update_sale_product($id, $active)
	{
		$q = "update product_tb set `sale_product` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
		function update_featured_product($id, $active)
	{
		$q = "update product_tb set `featured` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	
	
	//produk image
	function get_product_image_list($product_id)
	{
		$q = "select * from product_image_tb where `product_id` = '".esc($product_id)."' order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_product_image_data($id)
	{
		$q = "select * from product_image_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_product_image_list()
	{
		$q = "select * from product_image_tb where `active`=1 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_active_product_image_list2($product_id)
	{
		$q = "select * from product_image_tb where `active`=1 and `product_id` = '".esc($product_id)."' order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function insert_product_image($product_id, $image, $precedence, $active)
	{
		$q = "insert into product_image_tb(`product_id`, `image`, `precedence`, `active`) 
			  values('".esc($product_id)."',
			  		 '".esc($image)."',
					 '".esc($precedence)."',
					 '".esc($active)."')";
		$this->db->query($q);	
	}
	
	function delete_product_image($id)
	{
		$sql = "update product_image_tb set `image` = '' where id = '".esc($id)."'";
		$this->db->query($sql);	
	}
	
	function update_product_image($id, $image)
	{
		$q = "update product_image_tb set `image` = '".esc($image)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function update_active_product_image($id, $active)
	{
		$q = "update product_image_tb set `active` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function up_precedence_product_image($id, $product_id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, product_id, precedence from product_image_tb where id = '.$id.' and product_id = '.$product_id));
		$to=mysql_fetch_assoc(mysql_query('select id, product_id, precedence from product_image_tb where product_id = '.$product_id.' and  precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		product_image_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' and `product_id` = '".esc($from['product_id'])."'";
		$sql2 = "update		product_image_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'  and `product_id` = '".esc($to['product_id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_product_image($id, $product_id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, product_id, precedence from product_image_tb where id = '.$id.' and product_id = '.$product_id));
		$to=mysql_fetch_assoc(mysql_query('select id, product_id, precedence from product_image_tb where product_id = '.$product_id.' and  precedence > '.$from['precedence'].' order by precedence asc'));

		$sql1 = "update		product_image_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' and `product_id` = '".esc($from['product_id'])."'";
		$sql2 = "update		product_image_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."' and `product_id` = '".esc($to['product_id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	//sku
	function get_sku_list($product_id)
	{
		$q = "select * from sku_tb where `product_id` = '".esc($product_id)."' order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_sku_data($id)
	{
		$q = "select * from sku_tb where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
	function get_active_sku_list()
	{
		$q = "select * from sku_tb where `active`=1 order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_active_sku_list2($id)
	{
		$q = "select * from sku_tb where `active`=1 and `product_id` = '".esc($id)."' order by `precedence`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function insert_sku($product_id, $name, $size, $precedence, $active)
	{
		$q = "insert into sku_tb(`product_id`, `name`, `size`, `precedence`, `active`) 
			  values('".esc($product_id)."',
			  		 '".esc($name)."',
					 '".esc($size)."',
					 '".esc($precedence)."',
					 '".esc($active)."')";
		$this->db->query($q);	
	}
	
	function update_sku($id, $size, $name)
	{
		$q = "update sku_tb set `size` = '".esc($size)."', `name` = '".esc($name)."'
				where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function update_active_sku($id, $active)
	{
		$q = "update sku_tb set `active` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function up_precedence_sku($id, $product_id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, product_id, precedence from sku_tb where id = '.$id.' and product_id = '.$product_id));
		$to=mysql_fetch_assoc(mysql_query('select id, product_id, precedence from sku_tb where product_id = '.$product_id.' and  precedence < '.$from['precedence'].' order by precedence desc'));
		
		$sql1 = "update		sku_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' and `product_id` = '".esc($from['product_id'])."'";
		$sql2 = "update		sku_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'  and `product_id` = '".esc($to['product_id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	function down_precedence_sku($id, $product_id)
	{
		$from=mysql_fetch_assoc(mysql_query('select id, product_id, precedence from sku_tb where id = '.$id.' and product_id = '.$product_id));
		$to=mysql_fetch_assoc(mysql_query('select id, product_id, precedence from sku_tb where product_id = '.$product_id.' and  precedence > '.$from['precedence'].' order by precedence asc'));

		$sql1 = "update		sku_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."' and `product_id` = '".esc($from['product_id'])."'";
		$sql2 = "update		sku_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."' and `product_id` = '".esc($to['product_id'])."'";
		
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	
	//Related Product
	function get_active_related_product($id)
	{
		$q = "select * from product_tb where `active`=1 and `id`!='".esc($id)."' order by `id`";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_selected_related_product($id)
	{
		$q = "select *
		from related_product_tb a, product_tb b
		where `product_id_from`='".esc($id)."' and b.id=a.product_id_to";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function delete_related($product_id_from)
	{
		$sql="delete from related_product_tb where `product_id_from`='".esc($product_id_from)."'";
		$this->db->query($sql);
	}
	
	function delete_related2($product_id_from)
	{
		$sql="delete from related_product_tb where `product_id_to`='".esc($product_id_from)."'";
		$this->db->query($sql);
	}
	
	function insert_related_product($product_id_from,$product_id_to)
	{
		$q = "insert into related_product_tb(`product_id_from`, `product_id_to`) 
			  values('".esc($product_id_from)."',
			  		 '".esc($product_id_to)."')";
		$this->db->query($q);	
	}
	
	function insert_related_product2($product_id_from,$product_id_to)
	{
		$q = "insert into related_product_tb(`product_id_from`, `product_id_to`) 
			  values('".esc($product_id_to)."',
			  		 '".esc($product_id_from)."')";
		$this->db->query($q);	
	}
	
	function count_new_arrival(){
		
		$q = "select count(*) as total from product_tb where `active`=1 and `flag`=1 order by `id`";
		
		$query = $this->db->query($q);
		$data=$query->row_array();	
		return $data['total'];
	}
	
	
	
	function get_all_new_arrival($offset,$num)
	{
		$q = "select * from product_tb where `active`=1 and `flag`=1 order by `id` desc limit ".esc($offset).",".esc($num)."";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function product_total_by_template($template_id){
		$q = "select count(*) as total from product_tb where `active`=1 and `template_id`='".esc($template_id)."' order by `id`";
		
		$query = $this->db->query($q);
		$data=$query->row_array();	
		return $data['total'];
	}
	
	
	function get_product_by_template($template_id,$offset, $num)	{
		$q = "select * from product_tb where `active`=1 and `template_id`='".esc($template_id)."' order by `id` desc limit ".esc($offset).",".esc($num)."";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
}