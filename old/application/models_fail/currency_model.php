<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Currency_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_currency(){
		$sql = "select * from currency_tb";
		return $this->fetch_single_row($sql);	
	}
	
	function do_edit_currency($idr){
		$sql = "update currency_tb set idr = '".esc($idr)."'";
		$this->execute_dml($sql);	
	}

}?>