<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Faq_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_faq(){
		$sql = "select * from faq_tb order by id desc";
		return $this->fetch_multi_row($sql);	
	}
	function show_faq_by_search($search){
		$sql = "select * from faq_tb where  name like '%".esc($search)."%'  OR  question  like '%".esc($search)."%'   order by id desc";
		return $this->fetch_multi_row($sql);	
	}
	function show_faq_by_departemen($departemen_id){
		$sql = "select * from faq_tb where  departemen_id = '".esc($departemen_id)."' OR departemen_id = 0 order by id desc";
		return $this->fetch_multi_row($sql);	
	}
	function show_faq_by_departemen2($departemen_id,$admin_id){
	 	$sql = "select * from faq_tb where created_by = '".esc($admin_id)."' or departemen_id like '%\"".esc($departemen_id)."\"%'  order by id desc";
		return $this->fetch_multi_row($sql);	
	}
	function show_faq_by_departemen_search($departemen_id,$search){
		$sql = "select * from faq_tb where  departemen_id = '".esc($departemen_id)."' OR departemen_id = 0  and  question like '%".esc($search)."%'  or name like '%".esc($search)."%'  order by id desc";
		return $this->fetch_multi_row($sql);	
	}
	function show_faq_by_departemen_search2($departemen_id,$search,$admin_id){
		$s='';
		if($search!='')$s=" and ( question like '%".esc($search)."%'  or name like '%".esc($search)."%' or answer like '%".esc($search)."%' )";
		if($departemen_id!=0)$s.=" and ( departemen_id like '%\"".esc($departemen_id)."\"%' OR created_by = '".esc($admin_id)."')";
	
		$sql = "select * from faq_tb where id!=0 ".$s."  order by id desc";
		return $this->fetch_multi_row($sql);	
	}
	function show_faq_category(){
		$sql = "select * from faq_category_tb order by title ASC";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_faq_by_id($id){
		$sql = "select * from faq_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	function show_faq_category_by_id($id){
		$sql = "select * from faq_category_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}

}