<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Product_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_currency(){
		$sql = "select idr from currency_tb";
		return $this->fetch_single_row($sql);	
	}
	
	/////////
	//brand//
	/////////
	function show_brand_by_id($id){
		$sql = "select * from brand_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_brand($name,$active){
		$sql = "insert into brand_tb (name,active) values ('".esc($name)."','".esc($active)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_brand($id,$name,$active){
		$sql = "update brand_tb set name = '".esc($name)."', active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_brand($id){
		$sql = "delete from brand_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function active_brand($id,$active){
		$sql = "update brand_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	
	////////////
	//category//
	///////////
	function show_brand(){
		$sql = "select * from brand_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_category_by_id($id){
		$sql = "select * from category_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_category($brand_id,$name,$active){
		$sql = "insert into category_tb (brand_id,name,active) values ('".esc($brand_id)."','".esc($name)."','".esc($active)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_category($id,$brand_id,$name,$active){
		$sql = "update category_tb set brand_id = '".esc($brand_id)."', name = '".esc($name)."', active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_category($id){
		$sql = "delete from category_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function active_category($id,$active){
		$sql = "update category_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	///////////
	//product//
	///////////
	
	function show_category(){
		$sql = "select * from category_tb where active = 1  order by name";
		return $this->fetch_multi_row($sql);		
	}
	
	function show_product_by_id($id){
		$sql = "select * from product_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_product($category_id,$name,$number,$description,$price,$price_2,$active,$type){
		$sql = "insert into product_tb (category_id,name,number,description,price,price_2,type,active)
				values ('".esc($category_id)."',
						'".esc($name)."',
						'".esc($number)."',
						'".esc($description)."',
						'".esc($price)."',
						'".esc($price_2)."',
						'".esc($type)."',
						'".esc($active)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_product($id,$category_id,$name,$number,$description,$price,$price_2,$active,$type){
		$sql = "update product_tb set 	category_id = '".esc($category_id)."',
										name = '".esc($name)."',
										number = '".esc($number)."',
										description = '".esc($description)."',
										price = '".esc($price)."',
										price_2 = '".esc($price_2)."',
										type = '".esc($type)."',
										active = '".esc($active)."'
										where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function active($id,$active){
		$sql = "update product_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_product($id){
		$sql = "delete from product_tb where id ='".esc($id)."'";
		$this->execute_dml($sql);	
	}
}?>