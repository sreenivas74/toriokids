<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Budget_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	
	function get_request_budget_approver(){
		$sql = "select * from  request_budget_approver_tb";
		return $this->fetch_multi_row($sql);	
	}
	
	
	function get_vendor_list(){
		$sql = "select * from vendor_tb order  by name ASC";
		return $this->fetch_multi_row($sql);	
	}
	function get_bank_list(){
		$sql = "select * from bank_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_user_detail($id){
		$sql = "select e.*,alias from employee_tb e
				left join company_tb c on c.id = e.company_id
				where e.id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function add_budget($name,$month_start,$year_start,$month_end,$year_end,$amount,$created_date,$created_by){
		$sql = "insert into budget_tb (name,month_start,year_start,month_end,year_end,amount,created_date,created_by,active)
				values	('".esc($name)."',
						'".esc($month_start)."',
						'".esc($year_start)."',
						'".esc($month_end)."',
						'".esc($year_end)."',
						'".esc($amount)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'1')";
		$this->execute_dml($sql);
	}
	
	function edit_budget($id,$name,$month_start,$year_start,$month_end,$year_end,$amount,$updated_date,$updated_by){
		$sql = "update budget_tb set 	name = '".esc($name)."',
										month_start = '".esc($month_start)."',
										year_start = '".esc($year_start)."',
										month_end = '".esc($month_end)."',
										year_end = '".esc($year_end)."',
										amount = '".esc($amount)."',
										updated_date = '".esc($updated_date)."',
										updated_by = '".esc($updated_by)."'
										where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function get_budget_detail($id){
		$sql = "select * from budget_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function active_budget($id,$active){
		$sql = "update budget_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function get_budget_active(){
		$sql = "select * from budget_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_in_range_budget(){
	/*$sql = "select * from budget_tb where active = 1 and 
	( '01-'month
	( year_start >= ".esc(date("Y"))." and month_start >= ".esc(date("m"))." ) and ( year_end <=".esc(date("Y"))."  and month_end <= ".esc(date("m"))." ) order by name";*/
		$sql="SELECT * , CONCAT( year_start,  '-', month_start,  '-01' ) AS start_date, CONCAT( year_end,  '-', month_end,  '-31' ) AS start_date
FROM budget_tb 
WHERE active=1 and CONCAT( year_start,  '-', month_start,  '-01' ) <= NOW( ) 
AND CONCAT( year_end,  '-', month_end,  '-31' ) >= NOW( ) ";
	
		return $this->fetch_multi_row($sql);	
	}
	
	function insert_request_budget($project_id,$request_date,$bs,$notes,$total,$created_date,$created_by,$request_number,$month,$year,$number,$reimburse,$employee_id,$is_ppn){
		$sql = "insert request_budget_tb (request_number,month,year,number,project_id,request_date,bs,notes,total,created_date,created_by,reimburse,bs_employee_id,is_ppn)
				values	('".esc($request_number)."',
						'".esc($month)."',
						'".esc($year)."',
						'".esc($number)."',
						'".esc($project_id)."',
						'".esc($request_date)."',
						'".esc($bs)."',
						'".esc($notes)."',
						'".esc($total)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'".esc($reimburse)."',
						'".esc($employee_id)."',
						'".esc($is_ppn)."')";
		$this->execute_dml($sql);	
	}
	
	function insert_request_budget2($project_id,$request_date,$bs,$notes,$total,$created_date,$created_by,$request_number,$month,$year,$number,$reimburse,$employee_id,$is_ppn,$subtotal){
		$sql = "insert request_budget_tb (request_number,month,year,number,project_id,request_date,bs,notes,total,created_date,created_by,reimburse,bs_employee_id,is_ppn,total_before_ppn)
				values	('".esc($request_number)."',
						'".esc($month)."',
						'".esc($year)."',
						'".esc($number)."',
						'".esc($project_id)."',
						'".esc($request_date)."',
						'".esc($bs)."',
						'".esc($notes)."',
						'".esc($total)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'".esc($reimburse)."',
						'".esc($employee_id)."',
						'".esc($is_ppn)."',
						'".esc($subtotal)."')";
		$this->execute_dml($sql);	
	}
	
	function insert_request_budget_item($request_budget_id,$budget_id,$po_item_id,$desc,$price,$vendor_name,$bank_name,$acc_name,$acc_number,$quantity,$total,$discount){
		$sql = "insert into request_budget_item_tb (request_budget_id,budget_id,project_goal_po_client_item_id,description,price,vendor_name,bank_name,acc_name,acc_number,quantity,total,discount)
				values	('".esc($request_budget_id)."',
						'".esc($budget_id)."',
						'".esc($po_item_id)."',
						'".esc($desc)."',
						'".esc($price)."',
						'".esc($vendor_name)."',
						'".esc($bank_name)."',
						'".esc($acc_name)."',
						'".esc($acc_number)."',
						'".esc($quantity)."',
						'".esc($total)."',
						'".esc($discount)."')";
		$this->execute_dml($sql);	
	}
	
	function insert_request_budget_item2($request_budget_id,$budget_id,$po_item_id,$desc,$price,$vendor_name,$bank_name,$acc_name,$acc_number,$quantity,$total,$discount,$subtotal,$ppn_check){
		$sql = "insert into request_budget_item_tb (request_budget_id,budget_id,project_goal_po_client_item_id,description,price,vendor_name,bank_name,acc_name,acc_number,quantity,total,discount,subtotal,ppn)
				values	('".esc($request_budget_id)."',
						'".esc($budget_id)."',
						'".esc($po_item_id)."',
						'".esc($desc)."',
						'".esc($price)."',
						'".esc($vendor_name)."',
						'".esc($bank_name)."',
						'".esc($acc_name)."',
						'".esc($acc_number)."',
						'".esc($quantity)."',
						'".esc($total)."',
						'".esc($discount)."',
						'".esc($subtotal)."',
						'".esc($ppn_check)."')";
		$this->execute_dml($sql);	
	}
	
	function get_request_detail($id){
		$sql = "select rb.*,p.name as pname,p.id as pid from request_budget_tb rb 
				left join project_tb p on p.id = rb.project_id
				where rb.id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function get_request_item_detail($id){
		$sql = "select rb.*, b.name as bname, pgpci.item as pitem from request_budget_item_tb rb
				left join budget_tb b on b.id = rb.budget_id
				left join project_goal_po_client_item_tb pgpci on pgpci.id = rb.project_goal_po_client_item_id
				where request_budget_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function remove_request_budget_item($id){
		$sql = "delete from request_budget_item_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function insert_budget_log($request_budget_item_id,$budget_id,$price,$created_by,$created_date){
		$sql = "insert into budget_log_tb (request_budget_item_id,budget_id,amount,created_by,created_date)
				values	('".esc($request_budget_item_id)."',
						'".esc($budget_id)."',
						'".esc($price)."',
						'".esc($created_by)."',
						'".esc($created_date)."')";
		$this->execute_dml($sql);	
	}
	
	function insert_budget_log2($request_budget_item_id,$budget_id,$price){
		$sql = "insert into budget_log_tb (request_budget_item_id,budget_id,amount)
				values	('".esc($request_budget_item_id)."',
						'".esc($budget_id)."',
						'".esc($price)."')";
		$this->execute_dml($sql);	
	}
	
	function set_approval_to_zero($request_budget_id){
		$sql = "update request_budget_tb set approval = 0, approval_by = 0, approval_date = '0000-00-00 00:00:00', approval_2 = 0, approval_2_by = 0, approval_2_date = '0000-00-00 00:00:00', approval_3 = 0, approval_3_by = 0, approval_3_date = '0000-00-00 00:00:00', approval_4 = 0, approval_4_by = 0, approval_4_date = '0000-00-00 00:00:00' where id = '".esc($request_budget_id)."'";
		$this->execute_dml($sql);		
	}
	
	function remove_budget_log_by_item_id($request_budget_item_id){
		$sql = "delete from budget_log_tb where request_budget_item_id = '".esc($request_budget_item_id)."'";
		$this->execute_dml($sql);	
	}
	
	function get_request_budget_distinct($id){
		$sql = "select distinct rbi.budget_id,amount, b.name as bname, month_start, year_start, month_end, year_end from request_budget_item_tb rbi
				left join budget_tb b on b.id = rbi.budget_id
				where rbi.request_budget_id = '".esc($id)."'
				and rbi.budget_id != 0 ";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_request_budget_distinct_2($id){
		$sql = "select distinct rbi.project_goal_po_client_item_id,pgpci.total as amount, pgpci.item as bname 
				from project_goal_po_client_item_tb pgpci 
				left join request_budget_item_tb rbi on rbi.project_goal_po_client_item_id = pgpci.id
				where rbi.request_budget_id = '".esc($id)."' ";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_budget_log_list($data){
		$sql = "select bl.*,request_number,price,rbi.total as item_total, bl.status as log_status 
			,approval_by, approval_2_by, approval_3_by, approval_4_by,description
			from budget_log_tb bl 
				right join request_budget_item_tb rbi on rbi.id = bl.request_budget_item_id
				right join request_budget_tb rb on rb.id = rbi.request_budget_id
				where bl.budget_id in (".$data.")  and rb.not_approval=0
				and bl.budget_id != 0";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_all_budget_log($data){
		$sql = "select * from budget_log_tb ";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_budget_log_list_2($data){
		$sql = "select rbi.*,request_number,created_date,created_by, approval_4,
				approval_by, approval_2_by, approval_3_by, approval_4_by,
				rbi.total as total_item from request_budget_item_tb rbi
				left join request_budget_tb rb on rb.id = rbi.request_budget_id
				where project_goal_po_client_item_id in (".$data.") and approval_4 = 1";
		return $this->fetch_multi_row($sql);	
	}
	
	function approve_request_budget($id,$approve_by,$approve_date,$approval,$approval_by,$approval_date){
		$sql = "update request_budget_tb set ".$approval." = 1, ".$approval_by." = '".esc($approve_by)."', ".$approval_date." = '".esc($approve_date)."'
				where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function new_approve_request_budget($id,$approve_by,$approve_date,$approval,$approval_by,$approval_date,$approval_comment,$comment){
		$sql = "update request_budget_tb set ".$approval." = 1, ".$approval_by." = '".esc($approve_by)."', ".$approval_date." = '".esc($approve_date)."', ".$approval_comment." = '".esc($comment)."'
				where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	
	
	function add_request_payment($id,$bank_id,$amount,$pay_date,$paid_by,$paid_date,$pay_type,$method,$request_budget_item_id){
		$sql = "insert request_budget_payment_tb (request_budget_id,bank_id,amount,pay_date,created_by,created_date,pay_type,method,request_budget_item_id)
				values	('".esc($id)."',
						'".esc($bank_id)."',
						'".esc($amount)."',
						'".esc($pay_date)."',
						'".esc($paid_by)."',
						'".esc($paid_date)."',
						'".esc($pay_type)."',
						'".esc($method)."',
						'".esc($request_budget_item_id)."')";
		$this->execute_dml($sql);	
	}
	
	function add_request_payment2($id,$bank_id,$amount,$pay_date,$paid_by,$paid_date,$pay_type,$method,$request_budget_item_id,$transfer_to,$approved_by){
		$sql = "insert request_budget_payment_tb (request_budget_id,bank_id,amount,pay_date,created_by,created_date,pay_type,method,request_budget_item_id,transfer_account_bank,approved_by)
				values	('".esc($id)."',
						'".esc($bank_id)."',
						'".esc($amount)."',
						'".esc($pay_date)."',
						'".esc($paid_by)."',
						'".esc($paid_date)."',
						'".esc($pay_type)."',
						'".esc($method)."',
						'".esc($request_budget_item_id)."',
						'".esc($transfer_to)."',
						'".esc($approved_by)."')";
		$this->execute_dml($sql);	
	}
	function get_payment_list_periode($from,$to){
		$sql = "select rbp.*,request_number,b.name as bname,rbi.bank_name,rbi.acc_name,rbi.acc_number,approval_4,approval_4_by,rb.project_id,rbi.budget_id,rbi.project_goal_po_client_item_id,rbi.description 
				from request_budget_payment_tb rbp
				RIGHT join request_budget_tb rb on rb.id = rbp.request_budget_id
				left join request_budget_item_tb rbi on rbi.id = rbp.request_budget_item_id
				left join bank_tb b on b.id = rbp.bank_id
				where pay_date >= '".$from."' and pay_date <= '".$to."'
				order by pay_date desc";
		return $this->fetch_multi_row($sql);	
	}
	
	function edit_request_payment($payment_id,$bank_id,$amount,$pay_date,$paid_by,$paid_date,$pay_type,$method,$request_budget_item_id){
		$sql = "update request_budget_payment_tb set bank_id = '".esc($bank_id)."', amount = '".esc($amount)."', pay_date = '".esc($pay_date)."', updated_date = '".esc($paid_date)."', updated_by = '".esc($paid_by)."', pay_type = '".esc($pay_type)."', method = '".esc($method)."', request_budget_item_id = '".esc($request_budget_item_id)."' where id = '".esc($payment_id)."'";
		$this->execute_dml($sql);	
	}
	
	function confirm_payment($id,$status){
		$sql = "update request_budget_payment_tb set status = '".esc($status)."', done_date='".esc(date("Y-m-d H:i:s"))."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function get_budget_payment_detail($id){
		$q="select * from request_budget_payment_tb where id='".esc($id)."'";
		return $this->fetch_single_row($q);
		
	}
	
	function confirm_payment_by($id,$user_id){
		$sql = "update request_budget_payment_tb set done_by = '".esc($user_id)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function update_request_budget_paid($id,$paid_by,$paid_date){
		$sql = "update request_budget_tb set paid = 1, paid_by  = '".esc($paid_by)."', paid_date = '".esc($paid_date)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function get_payment_list($id){
		$sql = "select rbp.*, b.name as bname,b.id as bid from request_budget_payment_tb rbp
				left join bank_tb b on b.id = rbp.bank_id
				where request_budget_id = '".esc($id)."' order by pay_date";
		return $this->fetch_multi_row($sql);		
	}
	
	function update_request_budget($request_budget_id,$project_id,$request_date,$bs,$notes,$total,$updated_date,$updated_by,$employee_id,$reimburse,$is_ppn){
		$sql = "update request_budget_tb set project_id = '".esc($project_id)."', request_date = '".esc($request_date)."', bs = '".esc($bs)."',notes = '".esc($notes)."',total = '".esc($total)."',updated_date = '".esc($updated_date)."', updated_by = '".esc($updated_by)."', bs_employee_id = '".esc($employee_id)."', reimburse = '".esc($reimburse)."' , is_ppn = '".esc($is_ppn)."' where id = '".esc($request_budget_id)."'";
		$this->execute_dml($sql);	
	}
	
	function update_request_budget_item($request_budget_item_id,$budget_id,$po_item_id,$desc,$price,$vendor_name,$bank_name,$acc_name,$acc_number,$quantity,$total,$discount){
		$sql = "update request_budget_item_tb set budget_id = '".esc($budget_id)."',project_goal_po_client_item_id = '".esc($po_item_id)."' , description = '".esc($desc)."', price = '".esc($price)."',vendor_name = '".esc($vendor_name)."',bank_name = '".esc($bank_name)."',acc_name = '".esc($acc_name)."',acc_number = '".esc($acc_number)."',quantity = '".esc($quantity)."',total = '".esc($total)."',discount = '".esc($discount)."'
				where id = '".esc($request_budget_item_id)."'";
		$this->execute_dml($sql);
	}
	function update_request_budget_item2($request_budget_item_id,$budget_id,$po_item_id,$desc,$price,$vendor_name,$bank_name,$acc_name,$acc_number,$quantity,$total,$discount,$subtotal,$ppn_check){
		$sql = "update request_budget_item_tb set budget_id = '".esc($budget_id)."',project_goal_po_client_item_id = '".esc($po_item_id)."' , description = '".esc($desc)."', price = '".esc($price)."',vendor_name = '".esc($vendor_name)."',bank_name = '".esc($bank_name)."',acc_name = '".esc($acc_name)."',acc_number = '".esc($acc_number)."',quantity = '".esc($quantity)."',total = '".esc($total)."',discount = '".esc($discount)."',subtotal = '".esc($subtotal)."',ppn  = '".esc($ppn_check)."'
				where id = '".esc($request_budget_item_id)."'";
		$this->execute_dml($sql);
	}
	
	function get_po_client_item($po_client_id){
		$sql = "select * from project_goal_po_client_item_tb where project_goal_po_client_id = '".esc($po_client_id)."'";
		return $this->fetch_multi_row($sql);		
	}
	
	function remove_payment($payment_id){
		$sql = "delete from request_budget_payment_tb where id = '".esc($payment_id)."'";
		$this->execute_dml($sql);	
	}
	
	function remove_all_payment($request_budget_id){
		$sql = "delete from request_budget_payment_tb where request_budget_id = '".esc($request_budget_id)."'";
		$this->execute_dml($sql);	
	}
	
	function budget_log_list($budget_id){
		$sql = "select bl.*, request_number,request_date,bank_name,acc_name,acc_number,description,rb.id as rbid, rbi.total from budget_log_tb bl
				left join request_budget_item_tb rbi on rbi.id = bl.request_budget_item_id
				left join request_budget_tb rb on rb.id = rbi.request_budget_id
				where bl.budget_id = '".esc($budget_id)."' and rb.not_approval=0
				order by bl.created_date desc";
		return $this->fetch_multi_row($sql);		
	}
	
	function delete_rf($id){
		$sql = "delete from request_budget_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function save_rf_log($request_budget_id,$data_1,$data_2,$total_difference,$created_by,$created_date){
		$sql = "insert into request_budget_log_tb (request_budget_id,data_1,data_2,total,created_by,created_date)
				values	('".esc($request_budget_id)."',
						'".esc($data_1)."',
						'".esc($data_2)."',
						'".esc($total_difference)."',
						'".esc($created_by)."',
						'".esc($created_date)."')";
		$this->execute_dml($sql);	
	}
	
	function get_request_log($request_budget_id){
		$sql = "select * from request_budget_log_tb where request_budget_id = '".esc($request_budget_id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function delete_request_log($request_budget_id){
		$sql = "delete from request_budget_log_tb where request_budget_id = '".esc($request_budget_id)."'";
		$this->execute_dml($sql);	
	}
	
	function get_po_non_stock_payment($id){
		$sql = "select pgp.*, b.name as bname,b.id as bid from project_goal_po_payment_tb pgp
				left join bank_tb b on b.id = pgp.bank_id
				where pgp.project_goal_po_id = '".esc($id)."' order by pgp.id";
		return $this->fetch_multi_row($sql);	
	}
	
	function add_po_non_stock_payment($id,$bank_id,$amount,$pay_date,$paid_by,$paid_date,$pay_type,$method){
		$sql = "insert project_goal_po_payment_tb (project_goal_po_id,bank_id,amount,pay_date,created_by,created_date,pay_type,method)
				values	('".esc($id)."',
						'".esc($bank_id)."',
						'".esc($amount)."',
						'".esc($pay_date)."',
						'".esc($paid_by)."',
						'".esc($paid_date)."',
						'".esc($pay_type)."',
						'".esc($method)."')";
		$this->execute_dml($sql);	
	}
	
	function remove_po_non_stock_payment($id){
		$q="delete from project_goal_po_payment_tb where id='".esc($id)."'";
		$this->execute_dml($q);
	}
	
	function update_po_non_stock_payment($payment_id,$bank_id,$amount,$pay_date,$paid_by,$paid_date,$pay_type,$method,$project_goal_po_id){
		$sql = "update project_goal_po_payment_tb set bank_id = '".esc($bank_id)."', amount = '".esc($amount)."', pay_date = '".esc($pay_date)."', updated_date = '".esc($paid_date)."', updated_by = '".esc($paid_by)."', pay_type = '".esc($pay_type)."', method = '".esc($method)."', project_goal_po_id = '".esc($project_goal_po_id)."' where id = '".esc($payment_id)."'";
		$this->execute_dml($sql);	
	}
	
	function get_request_stock_payment($id){
		$sql = "select pgr.*, b.name as bname,b.id as bid 
				from request_stock_payment_tb pgr
				left join bank_tb b on b.id = pgr.bank_id
				where pgr.request_stock_id = '".esc($id)."' order by pgr.id";
		return $this->fetch_multi_row($sql);
	}
	
	function add_request_stock_payment($id,$bank_id,$amount,$pay_date,$paid_by,$paid_date,$pay_type,$method,$request_stock_item_id){
		$sql = "insert request_stock_payment_tb (request_stock_id,bank_id,amount,pay_date,created_by,created_date,pay_type,method,request_stock_item_id)
				values	('".esc($id)."',
						'".esc($bank_id)."',
						'".esc($amount)."',
						'".esc($pay_date)."',
						'".esc($paid_by)."',
						'".esc($paid_date)."',
						'".esc($pay_type)."',
						'".esc($method)."',
						'".esc($request_stock_item_id)."')";
		$this->execute_dml($sql);	
	}
		function add_request_stock_payment2($id,$bank_id,$amount,$pay_date,$paid_by,$paid_date,$pay_type,$method,$request_stock_item_id,$bank_to){
		$sql = "insert request_stock_payment_tb (request_stock_id,bank_id,amount,pay_date,created_by,created_date,pay_type,method,request_stock_item_id,bank_to)
				values	('".esc($id)."',
						'".esc($bank_id)."',
						'".esc($amount)."',
						'".esc($pay_date)."',
						'".esc($paid_by)."',
						'".esc($paid_date)."',
						'".esc($pay_type)."',
						'".esc($method)."',
						'".esc($request_stock_item_id)."',
						'".esc($bank_to)."')";
		$this->execute_dml($sql);	
	}
	
	function remove_request_stock_payment($id){
		$q="delete from request_stock_payment_tb where id='".esc($id)."'";
		$this->execute_dml($q);
	}
	
	function update_request_stock_payment($payment_id,$bank_id,$amount,$pay_date,$paid_by,$paid_date,$pay_type,$method,$request_stock_id,$request_stock_item_id){
		$sql = "update request_stock_payment_tb set bank_id = '".esc($bank_id)."', amount = '".esc($amount)."', pay_date = '".esc($pay_date)."', updated_date = '".esc($paid_date)."', updated_by = '".esc($paid_by)."', pay_type = '".esc($pay_type)."', method = '".esc($method)."', request_stock_id = '".esc($request_stock_id)."', request_stock_item_id = '".esc($request_stock_item_id)."' where id = '".esc($payment_id)."'";
		$this->execute_dml($sql);	
	}
	
	
	function confirm_payment_request_stock($id,$status){
		$sql = "update request_stock_payment_tb set status = '".esc($status)."', done_date='".esc(date("Y-m-d H:i:s"))."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function get_bs_approver(){
		$q="select bs_approver from auto_approver_setting_tb limit 1";
		return $this->fetch_single_row($q);
	}
	
	function get_cash_payment_approver(){
		$q="select cash_payment_approver from auto_approver_setting_tb limit 1";
		return $this->fetch_single_row($q);
	}
	
	function update_budget_log_status($item_id,$item_status){
	 	$sql = "update budget_log_tb set status = '".esc($item_status)."' where request_budget_item_id = '".esc($item_id)."'";
		$this->execute_dml($sql);	
	}
}