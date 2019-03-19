<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class product_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	//setting maintenance//
	function get_setting()
	{
		$q = "select * from setting_tb";
		$query = $this->db->query($q);
		return $query->row_array();	
	}
	
		function update_maintenance($status)
	{
		$q = "update setting_tb set `maintenance` = '".esc($status)."'";
		$this->db->query($q);
	}
	
	//produk
	function get_product_list()
	{
		$q = "select * from product_tb order by `id` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_product_by_id($id)
	{
		$q = "select * from product_tb where id='".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function get_product_by_id_on_flash_sale($id){
		$q = "select p.*, tp.name as template_name from product_tb p
		left join template_name_tb tp on tp.id=p.template_id where p.id='".esc($id)."' and p.active=1";
		$query = $this->db->query($q);
		return $query->row_array();
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
		$q = "select p.*, tp.name as template_name from product_tb p
		left join template_name_tb tp on tp.id=p.template_id
		where p.`active`=1 and `category_name` like '%\"".esc($name)."\"%' 
		order by p.`id` DESC limit ".esc($offset).",".esc($num)."";
		
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_best_seller_paging($offset,$num,$sub_category,$new_arrival,$sale,$size)
	{
		$sub1="";
		if($sub_category){
			foreach ($sub_category as $sub) {
				$sub1.=" and sub_category_name like '%\"".esc($sub)."\"%' ";
			}
		}
		$search="";
		if($size){
			$x=join(',',$size);
			$search.=" and template_id in ( ".$x." )";
		}
		if($new_arrival){
			$new = "and flag = '".esc($new_arrival)."'";
		}else{
			$new="";
		}
		if($sale){
			$sale = "and sale_product = '".esc($sale)."'";
		}else{
			$sale="";
		}
	
		$q = "select p.*, tp.name as template_name from product_tb p
		left join template_name_tb tp on tp.id=p.template_id
		where p.`active`=1 and best_seller=1 ".$search." ".$sub1." ".$new." ".$sale." order by `id` DESC limit ".esc($offset).",".esc($num)."";
		//echo $q;exit;
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_best_seller_total($sub_category,$new_arrival,$sale,$size)
	{
		$sub1="";
		if($sub_category){
			foreach ($sub_category as $sub) {
				$sub1.=" and sub_category_name like '%\"".esc($sub)."\"%' ";
			}
		}
		$search="";
		if($size){
			$x=join(',',$size);
			$search.=" and template_id in ( ".$x." )";
		}
		if($new_arrival){
			$new = "and flag = '".esc($new_arrival)."'";
		}else{
			$new="";
		}
		if($sale){
			$sale = "and sale_product = '".esc($sale)."'";
		}else{
			$sale="";
		}

		$q = "select count(*) as total from product_tb where `active`=1 and best_seller=1 ".$search." ".$sub1." ".$new." ".$sale." order by `id`";
		$query = $this->db->query($q);
		$data=$query->row_array();	
		return $data['total'];
	}
	
	function get_sale_paging($offset,$num,$sub_category,$new_arrival,$best_seller,$size)
	{
		$sub1="";
		if($sub_category){
			foreach ($sub_category as $sub) {
				$sub1.=" and sub_category_name like '%\"".esc($sub)."\"%' ";
			}
		}
		$search="";
		if($size){
			$x=join(',',$size);
			$search.=" and template_id in ( ".$x." )";
		}
		if($new_arrival){
			$new = "and flag = '".esc($new_arrival)."'";
		}else{
			$new="";
		}
		if($best_seller){
			$best = "and best_seller = '".esc($best_seller)."'";
		}else{
			$best="";
		}

		$q = "select p.*, tp.name as template_name from product_tb p
		left join template_name_tb tp on tp.id=p.template_id
		where p.`active`=1 and sale_product=1 ".$search." ".$sub1." ".$new." ".$best." order by `id` DESC limit ".esc($offset).",".esc($num)."";
		//echo $q;exit;
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function get_sale_total($sub_category,$new_arrival,$best_seller,$size)
	{
		$sub1="";
		if($sub_category){
			foreach ($sub_category as $sub) {
				$sub1.=" and sub_category_name like '%\"".esc($sub)."\"%' ";
			}
		}
		$search="";
		if($size){
			$x=join(',',$size);
			$search.=" and template_id in ( ".$x." )";
		}
		if($new_arrival){
			$new = "and flag = '".esc($new_arrival)."'";
		}else{
			$new="";
		}
		if($best_seller){
			$best = "and best_seller = '".esc($best_seller)."'";
		}else{
			$best="";
		}

		$q = "select count(*) as total from product_tb where `active`=1 and sale_product=1 ".$search." ".$sub1." ".$new." ".$best." order by `id`";
		$query = $this->db->query($q);
		$data=$query->row_array();	
		return $data['total'];
	}
	
	function count_get_active_product_list($name)
	{
		$q = "select count(*) as total from product_tb where `active`=1 and `category_name` like '%\"".esc($name)."\"%' order by `id`";
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
		$q = "select p.*, t.name as template_name from product_tb p
		left join template_name_tb t on p.template_id=t.id
		where p.`active`=1 and p.`featured` =1 order by p.`id` DESC";
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
		$q = "select count(*) as total from product_tb where `active`=1 and `category_name` like '%\"".esc($cat_name)."\"%' and `sub_category_name` like '%\"".esc($sub_name)."\"%'  order by `id`";
		$query = $this->db->query($q);
		$data=$query->row_array();	
		return $data['total'];
	}
	
	function get_active_product_list2_paging($sub_name, $cat_name,$offset,$num)
	{
		$q = "select p.*, tp.name as template_name from product_tb p
		left join template_name_tb tp on tp.id=p.template_id
		where p.`active`=1 and `category_name` like '%\"".esc($cat_name)."\"%' 
		and `sub_category_name` like '%\"".esc($sub_name)."\"%' 
		order by p.`id` DESC limit ".esc($offset).",".esc($num)."";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function search_product($search)
	{
		$q=$search;
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	
	
	function insert_product($category_name, $sub_category_name, $name, $price, $description, $active, $flag, $weight,$sale_product,$msrp, $best_seller,$featured,$template_id,$discount,$sku)
	{
		$q = "insert into product_tb(`category_name`, `sku_code`, `sub_category_name`, `name`, `price`, `description`, `active`, `flag`, `weight`,`sale_product`,`msrp`,`best_seller`,`featured`,`template_id`,`discount`) 
			  values('".esc($category_name)."',
			  		 '".esc($sku)."',
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
	
	function update_product($id, $category_name, $sub_category_name, $name, $price, $description, $flag, $weight,$sale_product,$msrp, $best_seller,$featured,$template_id,$discount,$sku)
	{
		$q = "update product_tb set `category_name` = '".esc($category_name)."',
									`sku_code` = '".esc($sku)."',
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

	function get_sku_list_active($product_id)
	{
		$q = "select * from sku_tb where `product_id` = '".esc($product_id)."' and active=1 order by `precedence`";
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
	
	
	
	function get_selected_active_related_product($id)
	{
		$q = "select b.*, c.name as template_name, a.product_id_to
		from related_product_tb a
		left join product_tb b on b.id=a.product_id_to
		left join template_name_tb c on b.template_id=c.id
		where `product_id_from`='".esc($id)."' and b.active=1";
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
		$q = "select p.*, t.name as template_name from product_tb p
		left join template_name_tb t on p.template_id=t.id
		where p.`active`=1 and p.`flag`=1 order by p.`id` desc limit ".esc($offset).",".esc($num)."";
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
		
		$q = "select p.*, tp.name as template_name from product_tb p
		left join template_name_tb tp on tp.id=p.template_id where p.`active`=1 and `template_id`='".esc($template_id)."' order by `id` desc limit ".esc($offset).",".esc($num)."";
		
		
		
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	function update_best_seller($id, $active)
	{
		$q = "update product_tb set `best_seller` = '".esc($active)."' where `id` = '".esc($id)."'";
		$query = $this->db->query($q);
	}
	
	function cut_sku_stock($sku_id, $quantity){
		$q = "update sku_tb set stock=stock-'".esc($quantity)."' where id='".esc($sku_id)."'";
		$this->db->query($q);
	}
	
	function get_featured_product(){
		$q = "select p.*, t.name as template_name from product_tb p
		left join template_name_tb t on p.template_id=t.id
		where p.`active`=1 and p.`featured` =1 order by p.`featured_precedence` DESC";
		$query = $this->db->query($q);
		return $query->result_array();	
	}
	
	function null_featured_precedence(){
		$q = "update product_tb set featured_precedence=0";
		$this->db->query($q);
	}
	
	//collection
	function get_all_collection(){
		$q = "select * from product_collection_tb order by name asc";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function add_collection($name){
		$q = "insert into product_collection_tb (name) values ('".esc($name)."')";
		$this->db->query($q);
	}
	
	function edit_collection($id, $name){
		$q = "update product_collection_tb set name='".esc($name)."' where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function delete_collection($id){
		$q = "delete from product_collection_tb where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function get_product_with_no_collection(){
		$q = "select * from product_tb where collection_id=0 order by name asc";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_product_with_collection($id){
		$q = "select * from product_tb where collection_id='".esc($id)."' order by name asc";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function update_product_collection_id($id, $collection_id){
		$q = "update product_tb set collection_id='".esc($collection_id)."' where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function update_sku_code($product_id, $sku_code){
		$q = "update product_tb set sku_code='".esc($sku_code)."' where id='".esc($product_id)."'";
		$this->db->query($q);
	}
	
	function remove_product_collection($id){
		$q = "update product_tb set collection_id=0 where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function set_collection_id_to_0($id){
		$q = "update product_tb set collection_id=0 where collection_id='".esc($id)."'";
		$this->db->query($q);
	}
	
	//product sale schedule
	function get_sale_schedule(){
		$q = "select * from product_sale_schedule_tb limit 1";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function get_sale_schedule_by_time($now){
		$q = "select * from product_sale_schedule_tb where '".esc($now)."' >=`start_time` and  `end_time`>='".esc($now)."'";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function insert_sale_schedule($start_time, $end_time, $active){
		$q = "insert into product_sale_schedule_tb (start_time, end_time, active) values ('".esc($start_time)."', '".esc($end_time)."', '".esc($active)."')";
		$this->db->query($q);
	}

	function count_filter_product($sub_name, $cat_name, $best_seller, $new_arrival, $sale, $size)
	{
		$sub1="";
		if($sub_name){
			foreach ($sub_name as $sub) {
				$sub1.=" and sub_category_name like '%\"".esc($sub)."\"%' ";
			}
		}
		$search="";
		if($size){
			$x=join(',',$size);
			$search.=" and template_id in ( ".$x." )";
		}
		if($best_seller){
			$best = "and best_seller = '".esc($best_seller)."'";
		}else{ 
			$best=""; 
		}

		if($new_arrival){
			$new = "and flag = '".esc($new_arrival)."'";
		}else{
			$new="";
		}

		if($sale){
			$sale = "and sale_product = '".esc($sale)."'";
		}else{
			$sale="";
		}
		// and `sub_category_name` like '%".$sub_name."%'
		$q = "select count(*) as total from product_tb where `active`=1 and `category_name` like '%\"".esc($cat_name)."\"%' ".$sub1." ".$search." ".$best." ".$new." ".$sale." order by `id`";
		//echo $q;exit;
		$query = $this->db->query($q);
		$data=$query->row_array();	
		return $data['total'];
	}

	function filter_get_active_product_list2_paging($sub_name, $cat_name,$best_seller, $new_arrival, $sale, $size,$offset,$num)
	{
		$sub1="";
		if($sub_name){
			foreach ($sub_name as $sub) {
				$sub1.=" and sub_category_name like '%\"".esc($sub)."\"%' ";
			}
		}
		$search="";
		if($size){
			$x=join(',',$size);
			$search.=" and template_id in ( ".$x." )";
		}
		if($best_seller){
			$best = "and best_seller = '".esc($best_seller)."'";
		}else{ 
			$best=""; 
		}

		if($new_arrival){
			$new = "and flag = '".esc($new_arrival)."'";
		}else{
			$new="";
		}

		if($sale){
			$sale = "and sale_product = '".esc($sale)."'";
		}else{
			$sale="";
		}

		$q = "select p.*, tp.name as template_name from product_tb p
		left join template_name_tb tp on tp.id=p.template_id
		where p.`active`=1 and `category_name` like '%\"".esc($cat_name)."\"%' 
		".$sub1." ".$search." ".$best." ".$new." ".$sale."
		order by p.`id` DESC limit ".esc($offset).",".esc($num)."";
		//echo $q;exit;
		$query = $this->db->query($q);
		return $query->result_array();	
	}

	function check_product_sku($product_id,$sku_id){
		$q = "select * from sku_tb where id='".esc($sku_id)."' and product_id='".esc($product_id)."'";
		$query = $this->db->query($q);
		return $query->row_array();
	}
}