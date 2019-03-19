<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Setting_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function get_auto_approve(){
		$q="select * from auto_approver_setting_tb limit 1";
		return $this->fetch_single_row($q);
	}
	
	function set_auto_approve($bs_approver,$cash_payment_approver,$updated_date,$updated_by){
		$sql = "update auto_approver_setting_tb set bs_approver = '".esc($bs_approver)."', cash_payment_approver = '".esc($cash_payment_approver)."', updated_date = '".esc($updated_date)."', updated_by = '".esc($updated_by)."' where id = 1";
		$this->execute_dml($sql);	
	}
	
	function get_approval_list(){
		$q="select * from request_budget_approver_tb ";
		return $this->fetch_multi_row($q);	
	}
	
	function clear_approval(){
		$q="TRUNCATE TABLE  `request_budget_approver_tb`";
		$this->execute_dml($q);	
	}
	
	function insert_approval($type,$admin_id){
		$sql = "insert request_budget_approver_tb (type,admin_id)
				values	('".esc($type)."',
						'".esc($admin_id)."')";
		$this->execute_dml($sql);	
	}
}