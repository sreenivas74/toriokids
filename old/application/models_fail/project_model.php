<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Project_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
/*
	function get_po_stock_detail($po_id){
		$sql = "select * from project_goal_request_stock_tb where id = '".esc($po_id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function get_po_stock_item($po_id){
		$sql = "select * from project_goal_request_stock_item_tb where project_goal_request_stock_id = '".esc($po_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_project_po_request_stock_item($data){
		$sql = "select pgrsi.*,pgpci.item as po_item, s.item as stock_name,pgrs.created_date,pgrs.created_by from project_goal_request_stock_item_tb pgrsi
				left join project_goal_po_client_item_tb pgpci on pgrsi.project_goal_po_client_item_id = pgpci.id
				left join stock_tb s on s.id = pgrsi.stock_id
				left join project_goal_request_stock_tb pgrs on pgrs.id = pgrsi.project_goal_request_stock_id
				where pgrsi.project_goal_request_stock_id in ".esc($data);
		return $this->fetch_multi_row($sql);	
	}
	//*/

	
	function get_project_po_request_stock_item2($id){
				
		$sql = "select pgrsi.*,pgpci.item as po_item, s.item as stock_name,pgrs.created_date,pgrs.created_by from project_goal_request_stock_item_tb pgrsi
				left join project_goal_po_client_item_tb pgpci on pgrsi.project_goal_po_client_item_id = pgpci.id
				left join stock_tb s on s.id = pgrsi.stock_id
				left join project_goal_request_stock_tb pgrs on pgrs.id = pgrsi.project_goal_request_stock_id
				where pgrsi.project_goal_request_stock_id =".esc($id);
		return $this->fetch_multi_row($sql);	
	}
	
	function get_po_non_stock_detail2($id){
		$sql="select pgp.*, v.name as vendor_name from project_goal_po_tb pgp
				left join vendor_tb v on v.id = pgp.vendor_id
				where pgp.id = '".esc($id)."'";
		
		return $this->fetch_single_row($sql);	
	}
	
	function get_project_po_request_non_stock_item2($id){
		$sql = "select pgpi.*,pgpci.id as pgpci_id, pgpci.item as po_item, pgp.approval_by, pgp.approval_date,pgp.created_by, pgp.created_date, po_number from project_goal_po_item_tb pgpi
				left join project_goal_po_client_item_tb pgpci on pgpi.project_goal_po_client_item_id = pgpci.id
				left join project_goal_po_tb pgp on pgp.id = pgpi.project_goal_po_id
				where pgpi.project_goal_po_id = ".esc($id);
		return $this->fetch_multi_row($sql);	
	}
	
	
	
	function add_quotation_excel($project_id,$created_by,$created_date,$file_location){
		$sql = "insert into quotation_file_tb (project_id,created_by,created_date,file_url)
				values	('".esc($project_id)."',
						'".esc($created_by)."',
						'".esc($created_date)."',
						'".esc($file_location)."')
				";
		$this->execute_dml($sql);	
	}
	
	function get_project_quotation_file($project_id){
		$sql = "select * from quotation_file_tb where project_id = '".esc($project_id)."' order by id";
		return $this->fetch_multi_row($sql);
	}
	
	function get_user_detail($id){
		$sql = "select e.*,alias from employee_tb e
				left join company_tb c on c.id = e.company_id
				where e.id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function insert_reason($quotation_id,$reason){
		$sql = "update project_goal_quotation_tb set reason = '".esc($reason)."' where id = '".esc($quotation_id)."'";
		$this->db->query($sql);	
	}
	
	function get_warehouse_aktif(){
		$sql = "select * from warehouse_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);
	}
	
	//project quotation
	function get_payment_detail($id){
		$sql = "select pgqp.*,p.name as pname,quotation_number,currency_type from project_goal_quotation_payment_tb pgqp
				left join project_goal_quotation_tb pgq on pgq.id = pgqp.project_goal_quotation_id
				left join project_goal_tb pg on pgq.project_goal_id = pg.id
				left join project_tb p on p.id = pg.project_id
				where pgqp.id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_edit_project_quotation_payment($id,$dp,$transfer_date,$bank,$notes){
		$updated_by = $this->session->userdata('employee_id');
		$updated_date = date('Y-m-d H:i:s');
		$sql = "update project_goal_quotation_payment_tb set dp = '".esc($dp)."', transfer_date = '".esc($transfer_date)."', bank = '".esc($bank)."', notes = '".esc($notes)."', updated_by = '".esc($updated_by)."', updated_date = '".esc($updated_date)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function do_add_project_quotation_payment($goal_id,$quotation_id,$dp,$transfer_date,$bank,$notes){
		$created_by = $this->session->userdata('employee_id');
		$created_date = date("Y-m-d H:i:s");
		$sql = "insert into project_goal_quotation_payment_tb (project_goal_id,project_goal_quotation_id,dp,transfer_date,bank,notes,created_date,created_by)
				values	('".esc($goal_id)."',
						'".esc($quotation_id)."',
						'".esc($dp)."',
						'".esc($transfer_date)."',
						'".esc($bank)."',
						'".esc($notes)."',
						'".esc($created_date)."',
						'".esc($created_by)."')";
		$this->execute_dml($sql);	
	}
	
	function get_sales_manager(){
		$sql = "select employee_id,password,email from administrator_tb a
				left join employee_tb e on a.employee_id = e.id
				where a.privilege_id = 20";
		return $this->fetch_multi_row($sql);	
	}
	function insert_approval_1_data($quotation_id,$approval_1_data){
		$sql = "update project_goal_quotation_tb set approval_1_data = '".esc($approval_1_data)."' where id = '".esc($quotation_id)."'";
		$this->execute_dml($sql);	
	}
	function insert_approval_2_data($quotation_id,$approval_2_data){
		$sql = "update project_goal_quotation_tb set approval_2_data = '".esc($approval_2_data)."' where id = '".esc($quotation_id)."'";
		$this->execute_dml($sql);	
	}
	
	function insert_approval_po_2_data($po_client_id,$approval_2_data){
		$sql = "update project_goal_po_client_tb set approval_2_data = '".esc($approval_2_data)."' where id = '".esc($po_client_id)."'";
		$this->execute_dml($sql);	
	}
	
	function update_quotation_revision_to_waiting($quotation_id,$approval_level){
		$sql = "update project_goal_quotation_tb set approval_level = '".esc($approval_level)."' where id = '".esc($quotation_id)."'";
		$this->execute_dml($sql);	
	}
	
	function show_quotation_project($project_id){
		$sql = "select * from project_goal_quotation_tb where project_id = '".esc($project_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_po_client_project($project_id){
		$sql = "select * from project_goal_po_client_tb where project_id = '".esc($project_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_po_client_project_detail($po_id){
		$sql = "select * from project_goal_po_client_tb where id = '".esc($po_id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function show_quotation_item($data){
		$sql = "select * from project_goal_quotation_item_tb where project_goal_quotation_id in (".$data.")";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_po_client_item($data){
		$sql = "select * from project_goal_po_client_item_tb where project_goal_po_client_id in (".$data.")";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_po_client_item_detail($po_id){
		$sql = "select * from project_goal_po_client_item_tb where project_goal_po_client_id = '".esc($po_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_quotation_log($data){
		$sql = "select * from project_goal_quotation_log_tb where project_goal_quotation_id in (".$data.")";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_quotation_payment($data){
		$sql = "select * from project_goal_quotation_payment_tb where project_goal_quotation_id in (".$data.")";
		return $this->fetch_multi_row($sql);	
	}
	
	function add_quotation($project_id,$quotation_number,$quotation_date,$is_ppn,$currency_type,$notes,$unique_number,$created_date,$created_by,$number,$month,$year,$delivery_date,$payment_term){
		$sql = "insert into project_goal_quotation_tb (project_id,quotation_number,quotation_date,is_ppn,currency_type,notes,unique_number,created_date,created_by,number,month,year,delivery_date,payment_term)
				values	('".esc($project_id)."',
						'".esc($quotation_number)."',
						'".esc($quotation_date)."',
						'".esc($is_ppn)."',
						'".esc($currency_type)."',
						'".esc($notes)."',
						'".esc($unique_number)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'".esc($number)."',
						'".esc($month)."',
						'".esc($year)."',
						'".esc($delivery_date)."',
						'".esc($payment_term)."')";
		$this->execute_dml($sql);	
	}
	
	function add_po_client($project_id,$po_number,$po_date,$is_ppn,$currency_type,$notes,$unique_number,$created_date,$created_by,$delivery_date,$payment_term,$po_file){
		$sql = "insert into project_goal_po_client_tb (project_id,po_number,po_date,is_ppn,currency_type,notes,unique_number,created_date,created_by,delivery_date,payment_term,po_file)
				values	('".esc($project_id)."',
						'".esc($po_number)."',
						'".esc($po_date)."',
						'".esc($is_ppn)."',
						'".esc($currency_type)."',
						'".esc($notes)."',
						'".esc($unique_number)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'".esc($delivery_date)."',
						'".esc($payment_term)."',
						'".esc($po_file)."')";
		$this->execute_dml($sql);	
	}
	
	function edit_po_client($project_goal_po_client_id,$po_number,$po_date,$is_ppn,$currency_type,$note,$udpated_date,$updated_by,$delivery_date,$payment_term,$po_file){
		$sql = "update project_goal_po_client_tb set 	po_number = '".esc($po_number)."',
														po_date = '".esc($po_date)."',
														is_ppn = '".esc($is_ppn)."',
														currency_type = '".esc($currency_type)."',
														notes = '".esc($note)."',
														updated_date = '".esc($udpated_date)."',
														updated_by = '".esc($updated_by)."',
														delivery_date = '".esc($delivery_date)."',
														payment_term = '".esc($payment_term)."',
														approval_level = 0,
														approval_2_data = '',
														po_file = '".esc($po_file)."'
														where id = '".esc($project_goal_po_client_id)."'";
		$this->execute_dml($sql);
	}
	
	function set_total_in_quotation($quotation_id,$subtotal,$discount,$discount_value,$ppn,$total){
		$sql = "update project_goal_quotation_tb set subtotal = '".esc($subtotal)."', discount = '".esc($discount)."', discount_value = '".esc($discount_value)."', ppn = '".esc($ppn)."', total = '".esc($total)."' where id = '".esc($quotation_id)."'";
		$this->execute_dml($sql);	
	}
	
	function set_total_in_po_client($po_client_id,$subtotal,$discount,$discount_value,$ppn,$total){
		$sql = "update project_goal_po_client_tb set subtotal = '".esc($subtotal)."', discount = '".esc($discount)."', discount_value = '".esc($discount_value)."', ppn = '".esc($ppn)."', total = '".esc($total)."' where id = '".esc($po_client_id)."'";
		$this->execute_dml($sql);	
	}
	
	function add_quotation_item($quotation_id,$item,$desc,$qty,$unit_type,$price1,$disc1,$total,$type,$created_date){
		$sql = "insert into project_goal_quotation_item_tb (project_goal_quotation_id,item,description,quantity,item_type,price,discount,total,type,created_date)
				values	('".esc($quotation_id)."',
						'".esc($item)."',
						'".esc($desc)."',
						'".esc($qty)."',
						'".esc($unit_type)."',
						'".esc($price1)."',
						'".esc($disc1)."',
						'".esc($total)."',
						'".esc($type)."',
						'".esc($created_date)."')";
		$this->execute_dml($sql);	
	}
	
	function add_po_client_item($po_client_id,$item,$desc,$qty,$unit_type,$price1,$disc1,$total,$type,$created_date,$total_po){
		$sql = "insert into project_goal_po_client_item_tb (project_goal_po_client_id,item,description,quantity,item_type,price,discount,total,type,created_date,total_po)
				values	('".esc($po_client_id)."',
						'".esc($item)."',
						'".esc($desc)."',
						'".esc($qty)."',
						'".esc($unit_type)."',
						'".esc($price1)."',
						'".esc($disc1)."',
						'".esc($total)."',
						'".esc($type)."',
						'".esc($created_date)."',
						'".esc($total_po)."')";
		$this->execute_dml($sql);	
	}
	
	function edit_po_client_item($project_goal_po_client_item_id,$item,$desc,$qty,$unit_type,$price1,$disc1,$total1,$type,$updated_date,$total_po){
		$sql = "update project_goal_po_client_item_tb set 	item = '".esc($item)."',
															description = '".esc($desc)."',
															quantity = '".esc($qty)."',
															item_type = '".esc($unit_type)."',
															price = '".esc($price1)."',
															discount = '".esc($disc1)."',
															total = '".esc($total1)."',
															type = '".esc($type)."',
															updated_date = '".esc($updated_date)."',
															total_po = '".esc($total_po)."'
															where id = '".esc($project_goal_po_client_item_id)."'";
		$this->execute_dml($sql);		
	}
	
	function remove_po_client_item($project_goal_po_client_item_id){
		$q="delete from project_goal_po_client_item_tb	where id = '".esc($project_goal_po_client_item_id)."'";
		$this->execute_dml($q);
	}
	
	
	function add_quotation_log($quotation_id,$data_json,$created_by,$created_date){
		$sql = "insert into project_goal_quotation_log_tb (project_goal_quotation_id,data_json,created_by,created_date)
				values	('".esc($quotation_id)."',
						'".esc($data_json)."',
						'".esc($created_by)."',
						'".esc($created_date)."')";
		$this->execute_dml($sql);	
	}
	
	function update_quotation($project_goal_quotation_id,$quotation_date,$is_ppn,$currency_type,$notes,$created_date,$created_by,$delivery_date,$payment_term){
		$sql = "update project_goal_quotation_tb set 	quotation_date = '".esc($quotation_date)."',
														is_ppn = '".esc($is_ppn)."',
														currency_type = '".esc($currency_type)."',
														updated_date = '".esc($created_date)."',
														updated_by = '".esc($created_by)."',
														payment_term = '".esc($payment_term)."',
														notes = '".esc($notes)."',
														delivery_date = '".esc($delivery_date)."'
														where id = '".esc($project_goal_quotation_id)."'";
		$this->execute_dml($sql);	
	}
	
	function edit_quotation_item($itemid,$item,$desc,$qty,$unit_type,$price,$disc,$total,$type,$created_date){
		$sql = "update project_goal_quotation_item_tb set	item = '".esc($item)."',
															description = '".esc($desc)."',
															quantity = '".esc($qty)."',
															discount = '".esc($disc)."',
															total = '".esc($total)."',
															type = '".esc($type)."',
															item_type = '".esc($unit_type)."',
															quantity = '".esc($qty)."',
															price = '".esc($price)."',
															updated_date = '".esc($created_date)."'
															where id = '".esc($itemid)."'";
		$this->execute_dml($sql);	
	}
	
	function get_quotation_detail($id){
		$sql = "select pgq.*,p.name as pname,e.firstname as efirstname,e.lastname as elastname from project_goal_quotation_tb pgq
				left join project_tb p on p.id = pgq.project_id
				left join employee_tb e on pgq.created_by = e.id
				where pgq.id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function get_po_client_detail($id){
		$sql = "select pgq.* from project_goal_po_client_tb pgq
				where pgq.id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function get_quotation_item_detail($id){
		$sql = "select * from project_goal_quotation_item_tb where project_goal_quotation_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);
	}
	
	function get_po_client_item_detail($id){
		$sql = "select * from project_goal_po_client_item_tb where project_goal_po_client_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);
	}
	
	function change_quotation_status_to_approval($id,$status){
		$sql = "update project_goal_quotation_tb set approval_level = '".esc($status)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function change_po_client_status_to_approval($id,$status){
		$sql = "update project_goal_po_client_tb set approval_level = '".esc($status)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	//crm deadline
	function show_crm_deadline(){
		$sql = "select * from project_tb where expected_close_date <= '".date('Y-m-d',strtotime('+30 day',strtotime(date('Y-m-d'))))."' and expected_close_date >= '".date('Y-m-d')."' and sales_stage != 5 order by name, expected_close_date";
		return $this->fetch_multi_row($sql);
	}
	
	//crm updated
	function show_crm_updated(){
		$sql = "select * from project_tb where update_date <= '".date('Y-m-d',strtotime('-30 day',strtotime(date('Y-m-d'))))."' and sales_stage != 5 order by name,update_date,expected_close_date";
		return $this->fetch_multi_row($sql);
	}
	//
	
	function show_team_list(){
		$sql = "select * from project_tb where (sales_stage != '4' and sales_stage != '5') order by employee_id,name";
		return $this->fetch_multi_row($sql);
	}
	
	function show_team_goal_list(){
		$sql = "select * from project_tb where sales_stage = 4 order by employee_id,name";
		return $this->fetch_multi_row($sql);
	}
	
	function show_currency(){
		$sql = "select idr from currency_tb";
		return $this->fetch_single_row($sql);	
	}
	
	function show_department_list(){
		$sql = "select * from department_tb where active = 1 order by id";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_crm_project_list($employee_id,$sales_stage){
		$sql = "select * from project_tb where employee_id = '".esc($employee_id)."' and sales_stage = '".esc($sales_stage)."' order by name";
		return $this->fetch_multi_row($sql);		
	}
	////////////////////////
	//dashboard//
	function show_admin_login_log(){
		$sql = "select *,max(last_login) as last_login from administrator_tb where id != 0 group by name";
		return $this->fetch_multi_row($sql);
	}
	
	function show_project_goal($quarter,$year){
		if($quarter==1){
			$x = 12;
			$y = '03';
		}elseif($quarter==2){
			$x = '03';
			$y = '06';	
		}elseif($quarter==3){
			$x = '06';
			$y = '09';	
		}elseif($quarter==4){
			$x = '09';
			$y = 12;
		}
		
		if($quarter==1){
			$sql = "select distinct pgi.id as pgi_id, pgi.ppn as pgi_ppn ,name,pgi.po_date as pgi_po_date,pgi.total as pgi_total,total_2,employee_id, pgi.bast_date as pgi_bast,pgi.invoice as pgi_invoice, pgi.under_table_fee as pgi_fee, pgi.tender as pgi_tender,pg.id as pg_id
					from project_goal_invoice_tb pgi
					left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date > '".($year-1)."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16' 
					order by name,pgi.po_date,transfer_date";
		}else{
			$sql = "select distinct pgi.id as pgi_id,pgi.ppn as pgi_ppn,name,pgi.po_date as pgi_po_date,pgi.total as pgi_total,total_2,employee_id, pgi.bast_date as pgi_bast,pgi.invoice as pgi_invoice, pgi.under_table_fee as pgi_fee, pgi.tender as pgi_tender,pg.id as pg_id
					from project_goal_invoice_tb pgi
					left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date > '".$year."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16' 
					order by name,pgi.po_date,transfer_date";
		}
		return $this->fetch_multi_row($sql);
	}
	
	
	function show_employee_year(){
		$sql = "SELECT distinct substring(join_date,1,4) as join_year FROM `employee_tb` order by join_date desc";
		return $this->fetch_multi_row($sql);
	}
	
	function show_lesson_learn(){
		$sql = "select * from lesson_learn_tb order by input_date desc limit 20";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_inventory_list_over_six_months(){
		$sql = "select * from inventory_tb where check_date <= '".esc(date('Y-m-d',strtotime('-6 month',strtotime(date('Y-m-d')))))."' order by check_date";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_vendor_last_visit(){
		$sql = "select distinct vendor_id, max(input_date) as last_visit from vendor_information_tb where input_date <= '".esc(date('Y-m-d',strtotime('-6 month',strtotime(date('Y-m-d')))))."' group by vendor_id order by last_visit";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_employee_active(){
		$sql = "select * from employee_tb where status = 1 order by firstname,lastname";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_employee_information_deadline(){
		$sql = "select * from employee_information_tb where deadline_date != '0000-00-00' and status != 1 order by deadline_date asc";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_schedule_to_list(){
		$sql = "select * from schedule_to_tb order by activity_date asc";
		return $this->fetch_multi_row($sql);
	}
	
	function show_project_not_survey_list(){
		$sql = "select pgi.project_goal_id as pg_id, pgi.id as pgi_id, invoice, marketing, engineering, support from 		
				project_goal_invoice_tb pgi
				left join project_goal_invoice_survey_tb pgis on pgis.project_goal_invoice_id = pgi.id
				order by pgi.project_goal_id";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_employee_goal_list(){
		$sql = "select * from employee_tb where status = 1 and type = 1 and type_date >= '".date('Y-m-d',strtotime("-2 month",strtotime(date('Y-m-d'))))."' order by type_date desc";
		return $this->fetch_multi_row($sql);	
	}
	function show_job_tracking_open_not_approved(){
		$sql = "select * from job_tracking_tb where approval != 1 or active != 1 order by due_date desc";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_crm_dashboard(){
		$sql = "select * from project_tb order by expected_close_date desc";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_activity_dashboard(){
		$today = date("Y-m-d");
		$today_2 =date("Y-m-d",strtotime('-7 day',strtotime(date('Y-m-d'))));
		$sql = "select * from project_employee_activity_tb where (activity_date <= '".esc($today)."' and activity_date >= '".esc($today_2)."' ) order by activity_date desc";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_pending_payment_dashboard(){
		$sql = "select distinct pgi.id as pgi_id, pgi.ppn as pgi_ppn ,name,pgi.po_date as pgi_po_date,pgi.total as pgi_total,total_2,employee_id, pgi.bast_date as pgi_bast,pgi.invoice as pgi_invoice, pgi.under_table_fee as pgi_fee,pg.id as pg_id
				from project_goal_invoice_tb pgi
				left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
				left join project_goal_tb pg on pg.id = pgi.project_goal_id
				left join project_tb p on p.id = pg.project_id
				order by pgi.bast_date desc";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_project_goal_amount_per_quarter(){
		$year = date('Y');
		$x='';$y='';$quarter='';
		
		$date_1 = date("Y")."-03-15";
		$date_2 = date("Y")."-06-15";
		$date_3 = date("Y")."-09-15";
		$date_4 = date("Y")."-12-15";
		
		if(date("Y-m-d")>=date("Y-m-d",strtotime("".($year-1)."-12-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_1)) ){
			$x = '12';
			$y = '03';
			$quarter = 1;
		}elseif(date("Y-m-d")>=date("Y-m-d",strtotime("".$year."-03-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_2)) ){
			$x = '03';
			$y = '06';
			$quarter = 2;
		}elseif(date("Y-m-d")>=date("Y-m-d",strtotime("".$year."-06-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_3)) ){
			$x = '06';
			$y = '09';	
			$quarter = 3;
		}elseif(date("Y-m-d")>=date("Y-m-d",strtotime("".$year."-09-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_4)) ){
			$x = '09';
			$y = '12';
			$quarter = 4;
		}else{
			$x = '12';
			$y = '03';
			$quarter = 1;
		}
		
		if($quarter==1){
			$sql = "select p.employee_id,sum(pgi.total)as total_1, sum(pgi.total_2)as total_2
					from project_goal_invoice_tb pgi
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date > '".($year-1)."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16'
					group by p.employee_id";
		}else{
			$sql = "select p.employee_id,sum(pgi.total)as total_1, sum(pgi.total_2)as total_2
					from project_goal_invoice_tb pgi
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date > '".$year."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16'
					group by p.employee_id";
		}
		return $this->fetch_multi_row($sql);
	}
	
	function show_project_goal_amount_per_quarter_2($employee_id){
		$year = date('Y');
		$x='';$y='';$quarter='';
		$date_1 = date("Y")."-03-15";
		$date_2 = date("Y")."-06-15";
		$date_3 = date("Y")."-09-15";
		$date_4 = date("Y")."-12-15";
		
		if(date("Y-m-d")>=date("Y-m-d",strtotime("".($year-1)."-12-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_1)) ){
			$x = '12';
			$y = '03';
			$quarter = 1;
		}elseif(date("Y-m-d")>=date("Y-m-d",strtotime("".$year."-03-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_2)) ){
			$x = '03';
			$y = '06';
			$quarter = 2;
		}elseif(date("Y-m-d")>=date("Y-m-d",strtotime("".$year."-06-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_3)) ){
			$x = '06';
			$y = '09';	
			$quarter = 3;
		}elseif(date("Y-m-d")>=date("Y-m-d",strtotime("".$year."-09-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_4)) ){
			$x = '09';
			$y = '12';
			$quarter = 4;
		}else{
			$x = '12';
			$y = '03';
			$quarter = 1;	
		}
		
		if($quarter==1){
			$sql = "select p.employee_id,p.name as p_name,pg.id as pg_id
					from project_goal_invoice_tb pgi
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date > '".($year-1)."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16'
					and p.employee_id = '".esc($employee_id)."'
					";
		}else{
			$sql = "select p.employee_id,p.name as p_name,pg.id as pg_id
					from project_goal_invoice_tb pgi
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date > '".$year."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16'
					and p.employee_id = '".esc($employee_id)."'
					";
		}
		return $this->fetch_multi_row($sql);
	}
	
	function show_quarter_goal_dashboard(){
		$x='';$y='';$quarter='';
		$date_1 = date("Y")."-03-15";
		$date_2 = date("Y")."-06-15";
		$date_3 = date("Y")."-09-15";
		$date_4 = date("Y")."-12-15";
		$year = date('Y');
		if(date("Y-m-d")>=date("Y-m-d",strtotime("".($year-1)."-12-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_1)) ){
			$x = '12';
			$y = '03';
			$quarter = 1;
		}elseif(date("Y-m-d")>=date("Y-m-d",strtotime("".$year."-03-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_2)) ){
			$x = '03';
			$y = '06';
			$quarter = 2;
		}elseif(date("Y-m-d")>=date("Y-m-d",strtotime("".$year."-06-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_3)) ){
			$x = '06';
			$y = '09';	
			$quarter = 3;
		}elseif(date("Y-m-d")>=date("Y-m-d",strtotime("".$year."-09-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_4)) ){
			$x = '09';
			$y = '12';
			$quarter = 4;
		}else{
			$x = '12';
			$y = '03';
			$year=$year+1;
			$quarter = 2;
				
		}
		
		if($quarter==1){
			$sql = "select distinct pgi.id as pgi_id, pgi.ppn as pgi_ppn ,name,pgi.po_date as pgi_po_date,pgi.total as pgi_total,total_2,employee_id, pgi.bast_date as pgi_bast,pgi.invoice as pgi_invoice, pgi.under_table_fee as pgi_fee,pg.id as pg_id
					from project_goal_invoice_tb pgi
					left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date > '".($year-1)."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16' 
					order by pgi.bast_date";
		}else{
			$sql = "select distinct pgi.id as pgi_id,pgi.ppn as pgi_ppn,name,pgi.po_date as pgi_po_date,pgi.total as pgi_total,total_2,employee_id, pgi.bast_date as pgi_bast,pgi.invoice as pgi_invoice, pgi.under_table_fee as pgi_fee,pg.id as pg_id
					from project_goal_invoice_tb pgi
					left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date > '".$year."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16' 
					order by pgi.bast_date";
		}
		
		
		return $this->fetch_multi_row($sql);
	}
	
	function show_quarter_win_dashboard(){
		$x='';$y='';$quarter='';
		$date_1 = date("Y")."-03-15";
		$date_2 = date("Y")."-06-15";
		$date_3 = date("Y")."-09-15";
		$date_4 = date("Y")."-12-15";
		$year = date('Y');
		if(date("Y-m-d")>=date("Y-m-d",strtotime("".($year-1)."-12-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_1)) ){
			$x = '12';
			$y = '03';
			$quarter = 1;
		}elseif(date("Y-m-d")>=date("Y-m-d",strtotime("".$year."-03-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_2)) ){
			$x = '03';
			$y = '06';
			$quarter = 2;
		}elseif(date("Y-m-d")>=date("Y-m-d",strtotime("".$year."-06-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_3)) ){
			$x = '06';
			$y = '09';	
			$quarter = 3;
		}elseif(date("Y-m-d")>=date("Y-m-d",strtotime("".$year."-09-16")) && date("Y-m-d")<=date("".$year."-m-d",strtotime($date_4)) ){
			$x = '09';
			$y = '12';
			$quarter = 4;
		}else{
			$x = '12';
			$y = '03';
			$year=$year+1;
			$quarter = 2;
				
		}
		
		if($quarter==1){
			$sql = "select distinct pgi.id as pgi_id, pgi.ppn as pgi_ppn ,name,pgi.po_date as pgi_po_date,pgi.total as pgi_total,total_2,employee_id, pgi.bast_date as pgi_bast,pgi.invoice as pgi_invoice, pgi.under_table_fee as pgi_fee,pg.id as pg_id, p.review_date
					from project_goal_invoice_tb pgi
					left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date > '".($year-1)."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16' 
					order by pgi.bast_date";
		}else{
			$sql = "select distinct pgi.id as pgi_id,pgi.ppn as pgi_ppn,name,pgi.po_date as pgi_po_date,pgi.total as pgi_total,total_2,employee_id, pgi.bast_date as pgi_bast,pgi.invoice as pgi_invoice, pgi.under_table_fee as pgi_fee,pg.id as pg_id, p.review_date
					from project_goal_invoice_tb pgi
					left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date > '".$year."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16' 
					order by pgi.bast_date";
		}
		
		return $this->fetch_multi_row($sql);
	}
	/////////////////////
	/////////////////////
	//project CRM//
	/////////////////////
	function show_lead_source(){
		$sql = "select * from lead_source_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);
	}
	
	function show_quotation(){
		$sql ="select * from project_quotation_tb where status = 0 order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_product_by_project($project_id){
		$sql = "select * from project_item_tb where project_id = '".esc($project_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_employee(){
		$sql = "select * from employee_tb order by firstname,lastname";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_industry(){
		$sql = "select * from industry_tb order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_client(){
		$sql = "select * from client_tb order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_crm_by_id($id){
		$sql = "select * from project_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_crm($name,$client_id,$employee_id,$sales_stage,$lead_source,$first_date,$demo_date,$quotation_date,$review_date,$close_date,$expected_close_date,$amount,$description,$status,$bast_date){
		$today = date('Y-m-d');
		$sql = "insert into project_tb (name,
										client_id,
										employee_id,
										sales_stage,
										lead_source,
										first_date,
										demo_date,
										quotation_date,
										review_date,
										close_date,
										expected_close_date,
										amount,
										description,
										created_date,
										status,
										bast_date)
				values ('".esc($name)."',
						'".esc($client_id)."',
						'".esc($employee_id)."',
						'".esc($sales_stage)."',
						'".esc($lead_source)."',
						'".esc($first_date)."',
						'".esc($demo_date)."',
						'".esc($quotation_date)."',
						'".esc($review_date)."',
						'".esc($close_date)."',
						'".esc($expected_close_date)."',
						'".esc($amount)."',
						'".esc($description)."',
						'".esc($today)."',
						'".esc($status)."',
						'".esc($bast_date)."'
						)";
		$this->execute_dml($sql);	
	}
	
	function do_edit_crm($id,$name,$client_id,$employee_id,$sales_stage,$lead_source,$first_date,$demo_date,$quotation_date,$review_date,$close_date,$expected_close_date,$amount,$description,$status,$bast_date){
		$today = date('Y-m-d');
		$update_by = $this->session->userdata('admin_id');
		$sql = "update project_tb set 	name = '".esc($name)."',
										client_id = '".esc($client_id)."',
										employee_id = '".esc($employee_id)."',
										sales_stage = '".esc($sales_stage)."',
										lead_source = '".esc($lead_source)."',
										first_date = '".esc($first_date)."',
										demo_date = '".esc($demo_date)."',
										quotation_date = '".esc($quotation_date)."',
										review_date = '".esc($review_date)."',
										close_date = '".esc($close_date)."',
										expected_close_date = '".esc($expected_close_date)."',
										description = '".esc($description)."',
										amount = '".esc($amount)."',
										status = '".esc($status)."',
										update_date = '".esc($today)."',
										update_by = '".esc($update_by)."',
										bast_date = '".esc($bast_date)."'
										where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function delete_crm($id,$project_goal_id){
		$sql2 = "delete from project_goal_bonus_tb where project_goal_id = '".esc($project_goal_id)."'";
		$this->execute_dml($sql2);
		
		$sql3 = "delete from project_goal_invoice_tb where project_goal_id = '".esc($project_goal_id)."'";
		$this->execute_dml($sql3);
		
		$sql4 = "delete from project_goal_invoice_info_tb where project_goal_id = '".esc($project_goal_id)."'";
		$this->execute_dml($sql4);
		
		$sql44 = "delete from project_goal_invoice_survey_tb where project_goal_id = '".esc($project_goal_id)."'";
		$this->execute_dml($sql44);
		
		$sql5 = "delete from project_goal_payment_tb where project_goal_id = '".esc($project_goal_id)."'";
		$this->execute_dml($sql5);
		
		$sql6 = "delete from project_goal_tb where id = '".esc($project_goal_id)."'";
		$this->execute_dml($sql6);
		
		$sql = "delete from project_employee_activity_tb where project_id = '".esc($id)."'";
		$this->execute_dml($sql);
		
		$sql7 = "delete from project_tb where id = '".esc($id)."'";
		$this->execute_dml($sql7);
	}
	
	function set_project_win_date($project_id,$win_date){
		$sql = "update project_tb set close_date = '".esc($win_date)."', sales_stage = 4 where id = '".esc($project_id)."'";
		$this->execute_dml($sql);	
	}
	
	function insert_to_project_goal($project_id){
		$sql = "insert into project_goal_tb (project_id,open) values ('".esc($project_id)."','1')";
		$this->execute_dml($sql);	
	}
	
	function insert_project_goal_bonus($project_goal_id){
		$sql = "insert into project_goal_bonus_tb (project_goal_id) values ('".esc($project_goal_id)."')";
		$this->execute_dml($sql);	
	}
	
	function delete_from_project_goal($project_id){
		$project_goal_id = find_2('id','project_id',$project_id,'project_goal_tb');
		
		$sql_2 = "delete from project_goal_bonus_tb where project_goal_id = '".esc($project_goal_id)."'";
		$this->execute_dml($sql_2);
		
		$sql5 = "delete from project_goal_invoice_info_tb where project_goal_id = '".esc($project_goal_id)."'";
		$this->execute_dml($sql5);
		
		$sql6 = "delete from project_goal_invoice_survey_tb where project_goal_id = '".esc($project_goal_id)."'";
		$this->execute_dml($sql6);
		
		$sql7 = "delete from project_goal_invoice_tb where project_goal_id = '".esc($project_goal_id)."'";
		$this->execute_dml($sql7);
		
		$sql_3 = "delete from project_goal_payment_tb where project_goal_id = '".esc($project_goal_id)."'";
		$this->execute_dml($sql_3);
		
		$sql = "delete from project_goal_tb where project_id = '".esc($project_id)."'";
		$this->execute_dml($sql);
	}
	
	function delete_project_item($id){
		$sql = "delete from project_item_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function status($id,$status){
		$sql = "update project_tb set status = '".esc($status)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function do_add_project_item($id,$product_id,$price,$qty,$description){
		$sql = "insert into project_item_tb (project_id,product_id,price,qty,description)
				values ('".esc($id)."',
						'".esc($product_id)."',
						'".esc($price)."',
						'".esc($qty)."',
						'".esc($description)."')";
		$this->execute_dml($sql);	
	}
	
	function do_add_project_total($id,$subtotal,$discount,$ppn,$total){
		$sql = "update project_tb set 	subtotal = '".esc($subtotal)."',
										discount = '".esc($discount)."',
										ppn = '".esc($ppn)."',
										total = '".esc($total)."'
										where id = '".esc($id)."'";
				
		$this->execute_dml($sql);	
	}
	
	function delete_project_total($id){
		$sql = "update project_tb set 	subtotal = '0',
										discount = '0',
										ppn = '0',
										total = '0'
										where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function show_schedule_to_by_project_id($id){
		$sql = "select * from schedule_to_tb where project_id = '".esc($id)."' order by activity_date desc limit 20";
		return $this->fetch_multi_row($sql);	
	}
		
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////
	//project goal//
	////////////////
	function show_survey_result_replied_by_project_id($project_id){
		$sql = "select * from survey_result_tb where project_id = '".esc($project_id)."' and status = 1 order by send_date desc limit 30";
		return $this->fetch_multi_row($sql);
	}
	
	function show_project_goal_by_id($id){
		$sql = "select * from project_goal_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function show_invoice_by_project_goal_id($id){
		$sql = "select * from project_goal_invoice_tb where project_goal_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);
	}
	
	function show_payment_by_project_goal_id($id){
		$sql = "select * from project_goal_payment_tb where project_goal_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);
	}
	
	function show_payment_by_invoice($id){
		$sql = "select * from project_goal_payment_tb where project_goal_invoice_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);
	}
	
	function show_bonus_by_project_goal_id($id){
		$sql = "select * from project_goal_bonus_tb where project_goal_id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function show_employee_by_project_goal_id($id){
		$sql = "select distinct employee_id from project_employee_activity_tb where project_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);
	}
	
	function do_edit_project($id,$invoice_number,$tender,$open){
		$sql = "update project_goal_tb set 	invoice_number = '".esc($invoice_number)."',
											tender = '".esc($tender)."',
											open = '".esc($open)."'
											where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function do_add_project_member($id,$employee_id){
		$sql = "insert into project_goal_member_tb values ('','".esc($id)."','".esc($employee_id)."')";
		$this->execute_dml($sql);	
	}
	
	function delete_project_member($id){
		$sql = "delete from project_goal_member_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function do_add_project_payment($id,$project_goal_invoice_id,$dp_idr,$dp_usd,$transfer_date,$bank,$notes){
		$sql = "insert into project_goal_payment_tb (project_goal_id,project_goal_invoice_id,dp_idr,dp_usd,transfer_date,bank,notes)
				values ('".esc($id)."',
						'".esc($project_goal_invoice_id)."',
						'".esc($dp_idr)."',
						'".esc($dp_usd)."',
						'".esc($transfer_date)."',
						'".esc($bank)."',
						'".esc($notes)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_project_payment($id,$dp_idr,$dp_usd,$transfer_date,$bank,$notes){
		$sql = "update project_goal_payment_tb set 	dp_idr='".esc($dp_idr)."',dp_usd = '".esc($dp_usd)."',transfer_date = '".esc($transfer_date)."',
													bank = '".esc($bank)."',
													notes = '".esc($notes)."'
													where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_project_payment($id){
		$sql = "delete from project_goal_payment_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function do_edit_project_bonus($id,$bonus_marketing,$bonus_support,$bonus_admin,$bonus_engineering){
		$sql = "update project_goal_bonus_tb set 	bonus_marketing = '".esc($bonus_marketing)."',
													bonus_support = '".esc($bonus_support)."',
													bonus_admin = '".esc($bonus_admin)."',
													bonus_engineering = '".esc($bonus_engineering)."'
													where project_goal_id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function do_add_project_invoice($project_goal_id,$invoice,$po_date,$bast_date,$settled_date,$under_table_fee,$tender,$ppn,$total,$total_2,$description,$created_date){
		$sql = "insert into project_goal_invoice_tb (	project_goal_id,
														invoice,
														po_date,
														bast_date,
														settled_date,
														under_table_fee,
														tender,
														ppn,
														total,
														total_2,
														description,
														created_date)
				values ('".esc($project_goal_id)."',
						'".esc($invoice)."',
						'".esc($po_date)."',
						'".esc($bast_date)."',
						'".esc($settled_date)."',
						'".esc($under_table_fee)."',
						'".esc($tender)."',
						'".esc($ppn)."',
						'".esc($total)."',
						'".esc($total_2)."',
						'".esc($description)."',
						'".esc($created_date)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_project_invoice($id,$invoice,$po_date,$bast_date,$settled_date,$under_table_fee,$tender,$ppn,$total,$total_2,$description,$created_date){
		$sql = "update project_goal_invoice_tb set 	invoice = '".esc($invoice)."',
													po_date = '".esc($po_date)."',
													bast_date = '".esc($bast_date)."',
													settled_date = '".esc($settled_date)."',
													under_table_fee = '".esc($under_table_fee)."',
													tender = '".esc($tender)."',
													ppn = '".esc($ppn)."',
													total = '".esc($total)."',
													total_2 = '".esc($total_2)."',
													description = '".esc($description)."'
													where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function show_invoice_by_id($id){
		$sql = "select * from project_goal_invoice_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function show_payment_by_id($id){
		$sql = "select * from project_goal_payment_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function show_invoice_info_by_id($id){
		$sql = "select * from project_goal_invoice_info_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function delete_project_invoice($id){
		$sql2 = "delete from project_goal_payment_tb where project_goal_invoice_id = '".esc($id)."'";
		$this->execute_dml($sql2);
		
		$sql = "delete from project_goal_invoice_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function goal_open($id,$open){
		$sql = "update project_goal_tb set open = '".esc($open)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function edit_project_invoice_info($id,$description,$today,$input_by){
		$sql = "update project_goal_invoice_info_tb set description = '".esc($description)."',
														input_date = '".esc($today)."',
														input_by = '".esc($input_by)."'
														where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function show_employee_activity_by_project_goal_id($id){
		$sql = "select * from project_employee_activity_tb where project_id = '".esc($id)."' order by activity_date desc";
		return $this->fetch_multi_row($sql);
	}
	
	function show_project_goal_info_invoice($id){
		$sql = "select * from project_goal_invoice_info_tb where project_goal_id = '".esc($id)."' order by input_date desc";
		return $this->fetch_multi_row($sql);	
	}
	
	function delete_project_goal_info_invoice($id){
		$sql = "delete from project_goal_invoice_info_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function do_add_project_info_invoice($id,$project_goal_invoice_id,$description,$input_by,$input_date){
		$sql= "insert into project_goal_invoice_info_tb (	project_goal_id,
															project_goal_invoice_id,
															description,
															input_by,
															input_date)
				values ('".esc($id)."',
						'".esc($project_goal_invoice_id)."',
						'".esc($description)."',
						'".esc($input_by)."',
						'".esc($input_date)."')";
		$this->execute_dml($sql);	
	}
	
	function do_add_project_bonus_invoice($id,$project_goal_invoice_id,$bonus_marketing,$bonus_support,$bonus_admin,$bonus_engineering){
		$sql = "insert project_goal_bonus_tb (	project_goal_id,
												project_goal_invoice_id,
												bonus_marketing,
												bonus_support,
												bonus_admin,
												bonus_engineering)
				values ('".esc($id)."',
						'".esc($project_goal_invoice_id)."',
						'".esc($bonus_marketing)."',
						'".esc($bonus_support)."',
						'".esc($bonus_admin)."',
						'".esc($bonus_engineering)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_project_bonus_invoice($id,$bonus_marketing,$bonus_support,$bonus_admin,$bonus_engineering){
		$sql = "update project_goal_bonus_tb set 	bonus_marketing = '".esc($bonus_marketing)."',
													bonus_support = '".esc($bonus_support)."',
													bonus_admin	= '".esc($bonus_admin)."',
													bonus_engineering = '".esc($bonus_engineering)."'
													where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function show_project_goal_bonus_invoice($id){
		$sql = "select * from project_goal_bonus_tb where project_goal_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);
	}
	
	function show_bonus_invoice_by_id($id){
		$sql = "select * from project_goal_bonus_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function delete_project_goal_bonus_invoice($id){
		$sql = "delete from project_goal_bonus_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function show_ticket_new_by_project_id($project_id){
		$sql = "select * from ticket_tb where project_id = '".esc($project_id)."' and status = 0 order by created_date desc limit 10";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_ticket_close_by_project_id($project_id){
		$sql = "select * from ticket_tb where project_id = '".esc($project_id)."' and status = 1 order by close_date desc limit 10";
		return $this->fetch_multi_row($sql);	
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////
	//employee activity//
	/////////////////////
	function show_project_open(){
		$sql = "select * from project_quotation_tb where  status = 0";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_employee_activity_by_id($id){
		$sql = "select * from project_employee_activity_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_employee_activity($project_id,$employee_id,$category,$description,$activity_date,$activity_do,$worktime_1,$worktime_2,$worktime_3,$worktime_4,$product,$competitor,$closed,$implement_date,$activity_status,$activity_pending,$plan_tomorrow,$additional_charge,$client_complaint,$input_date,$input_by){
		$sql ="insert into project_employee_activity_tb
				values ('',
						'".esc($project_id)."',
						'".esc($employee_id)."',
						'".esc($category)."',
						'".esc($description)."',
						'".esc($activity_date)."',
						'".esc($activity_do)."',
						'".esc($worktime_1)."',
						'".esc($worktime_2)."',
						'".esc($worktime_3)."',
						'".esc($worktime_4)."',
						'".esc($product)."',
						'".esc($competitor)."',
						'".esc($closed)."',
						'".esc($implement_date)."',
						'".esc($activity_status)."',
						'".esc($activity_pending)."',
						'".esc($plan_tomorrow)."',
						'".esc($additional_charge)."',
						'".esc($client_complaint)."',
						'".esc($input_date)."',
						'".esc($input_by)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_employee_activity($id,$project_id,$employee_id,$category,$description,$activity_date,$activity_do,$worktime_1,$worktime_2,$worktime_3,$worktime_4,$product,$competitor,$closed,$implement_date,$activity_status,$activity_pending,$plan_tomorrow,$additional_charge,$client_complaint){
		$sql = "update project_employee_activity_tb set project_id = '".esc($project_id)."',
														employee_id = '".esc($employee_id)."',
														category = '".esc($category)."',
														description = '".esc($description)."',
														activity_date = '".esc($activity_date)."',
														activity_do = '".esc($activity_do)."',
														worktime_1 = '".esc($worktime_1)."',
														worktime_2 = '".esc($worktime_2)."',
														worktime_3 = '".esc($worktime_3)."',
														worktime_4 = '".esc($worktime_4)."',
														product = '".esc($product)."',
														implement_date = '".esc($implement_date)."',
														closed = '".esc($closed)."',
														competitor = '".esc($competitor)."',
														activity_status = '".esc($activity_status)."',
														activity_pending = '".esc($activity_pending)."',
														plan_tomorrow = '".esc($plan_tomorrow)."',
														additional_charge = '".esc($additional_charge)."',
														client_complaint = '".esc($client_complaint)."'
														where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function delete_employee_activity($id){
		$sql = "delete from project_employee_activity_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	////
	//activity category
	
	function show_activity_category(){
		$sql = "select * from employee_activity_category_tb order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_activity_category_active(){
		$sql = "select * from employee_activity_category_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_activity_category_by_id($id){
		$sql = "select * from employee_activity_category_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_activity_category($name,$active){
		$sql = "insert into employee_activity_category_tb (name,active)
				values ('".esc($name)."',
						'".esc($active)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_activity_category($id,$name,$active){
		$sql = "update employee_activity_category_tb set 	name = '".esc($name)."',
															active = '".esc($active)."'
															where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function active_activity_category($id,$active){
		$sql = "update employee_activity_category_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_activity_category($id){
		$sql = "delete from employee_activity_category_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	//bank
	function show_bank(){
		$sql = "select * from bank_tb order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_bank_active(){
		$sql = "select * from bank_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_bank_by_id($id){
		$sql = "select * from bank_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_bank($name,$active){
		$sql = "insert into bank_tb (name,active)
				values ('".esc($name)."',
						'".esc($active)."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_bank($id,$name,$active){
		$sql = "update bank_tb set 	name = '".esc($name)."',
									active = '".esc($active)."'
									where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function active_bank($id,$active){
		$sql = "update bank_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_bank($id){
		$sql = "delete from bank_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	//survey
	function show_invoice_survey($id){
		$sql = "select * from project_goal_invoice_survey_tb where project_goal_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);
	}
	
	function show_invoice_survey_by_id($id){
		$sql = "select * from project_goal_invoice_survey_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function add_invoice_survey($goal_id,$project_goal_invoice_id,$marketing,$engineering,$support,$description,$surveyor,$input_by,$input_date){
		$sql = "insert into project_goal_invoice_survey_tb (project_goal_id,
															project_goal_invoice_id,
															marketing,
															engineering,
															support,
															description,
															surveyor,
															input_by,
															input_date)
				values ('".esc($goal_id)."',
						'".esc($project_goal_invoice_id)."',
						'".esc($marketing)."',
						'".esc($engineering)."',
						'".esc($support)."',
						'".esc($description)."',
						'".esc($surveyor)."',
						'".esc($input_by)."',
						'".esc($input_date)."')";
		$this->execute_dml($sql);	
	}
	
	function edit_invoice_survey($id,$marketing,$engineering,$support,$description,$surveyor,$input_date){
		$sql = "update project_goal_invoice_survey_tb set 	marketing = '".esc($marketing)."',
															engineering = '".esc($engineering)."',
															support = '".esc($support)."',
															description = '".esc($description)."',
															surveyor = '".esc($surveyor)."',
															input_date = '".esc($input_date)."'
															where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function delete_invoice_survey($id){
		$sql = "delete from project_goal_invoice_survey_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	//crm information 
	function show_crm_info($project_id){
		$sql = "select * from project_info_tb where project_id = '".esc($project_id)."' order by input_date desc";
		return $this->fetch_multi_row($sql);
	}
	
	function do_add_crm_information($project_id,$description,$input_date,$input_by){
		$sql = "insert into project_info_tb (project_id,description,input_by,input_date)
				values ('".esc($project_id)."',
						'".esc($description)."',
						'".esc($input_by)."',
						'".esc($input_date)."')";
		$this->execute_dml($sql);	
	}
	
	function delete_crm_information($id){
		$sql = "delete from project_info_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function show_crm_information_by_id($id){
		$sql = "select * from project_info_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function edit_crm_information($id,$description){
		$sql = "update project_info_tb set description = '".esc($description)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	//project goal
	function show_project_goal_info($project_goal_id){
		$sql = "select * from project_goal_info_tb where project_goal_id = '".esc($project_goal_id)."' order by input_date desc";
		return $this->fetch_multi_row($sql);
	}
	
	function do_add_project_goal_information($project_goal_id,$description,$input_date,$input_by){
		$sql = "insert into project_goal_info_tb (project_goal_id,description,input_by,input_date)
				values ('".esc($project_goal_id)."',
						'".esc($description)."',
						'".esc($input_by)."',
						'".esc($input_date)."')";
		$this->execute_dml($sql);	
	}
	
	function delete_project_goal_information($id){
		$sql = "delete from project_goal_info_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function show_project_goal_information_by_id($id){
		$sql = "select * from project_goal_info_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function edit_project_goal_information($id,$description){
		$sql = "update project_goal_info_tb set description = '".esc($description)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function get_project_quotation($project_id){
		$sql = "select * from project_goal_quotation_tb where project_id = '".esc($project_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_project_quotation_item($data){
		$sql = "select * from project_goal_quotation_item_tb where project_goal_quotation_id in (".esc($data).")";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_project_po_client($project_id){
		$sql = "select * from project_goal_po_client_tb where project_id = '".esc($project_id)."'";
		return $this->fetch_single_row($sql);		
	}
	
	function get_project_po_client_item($po_client_id){
		$sql = "select * from project_goal_po_client_item_tb where project_goal_po_client_id = '".esc($po_client_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_project_po_client_item_acc($po_client_id){
		$sql = "select * from project_goal_po_client_item_tb where project_goal_po_client_id = '".esc($po_client_id)."' and type = 2";
		return $this->fetch_multi_row($sql);	
	}
	
	function add_po_non_stock($project_id,$vendor_id,$po_number,$po_date,$delivery_date,$payment_term,$is_ppn,$currency_type,$created_date,$month,$year,$number,$notes){
		$sql = "insert into project_goal_po_tb (project_id,vendor_id,po_number,po_date,delivery_date,payment_term,is_ppn,currency_type,created_date,month,year,number,notes)
				values	('".esc($project_id)."',
						'".esc($vendor_id)."',
						'".esc($po_number)."',
						'".esc($po_date)."',
						'".esc($delivery_date)."',
						'".esc($payment_term)."',
						'".esc($is_ppn)."',
						'".esc($currency_type)."',
						'".esc($created_date)."',
						'".esc($month)."',
						'".esc($year)."',
						'".esc($number)."',
						'".esc($notes)."')";
		$this->execute_dml($sql);	
	}
	
	function add_po_item($po_id,$itemid,$desc,$qty,$unit_type,$price,$disc,$total){
		$sql = "insert into project_goal_po_item_tb (project_goal_po_id,project_goal_po_client_item_id,description,qty,unit_type,price,discount,total)
				values	('".esc($po_id)."',
						'".esc($itemid)."',
						'".esc($desc)."',
						'".esc($qty)."',
						'".esc($unit_type)."',
						'".esc($price)."',
						'".esc($disc)."',
						'".esc($total)."')";
		$this->execute_dml($sql);		
	}
	
	function set_total_in_po($po_id,$subtotal,$discount,$discount_value,$ppn,$total){
		$sql = "update project_goal_po_tb set subtotal = '".esc($subtotal)."', discount = '".esc($discount)."', discount_value = '".esc($discount_value)."', ppn = '".esc($ppn)."', total = '".esc($total)."' where id = '".esc($po_id)."'";
		$this->execute_dml($sql);	
	}
	
	function get_stock_list(){
		$sql = "select * from stock_tb where active = 1 order by item";
		return $this->fetch_multi_row($sql);
	}
	
	function add_po_stock($project_id,$request_date,$total,$notes,$created_date,$created_by){
		$sql = "insert into project_goal_request_stock_tb (project_id,request_date,total,notes,created_date,created_by)
				values	('".esc($project_id)."','".esc($request_date)."','".esc($total)."','".esc($notes)."','".esc($created_date)."','".esc($created_by)."')";
		$this->execute_dml($sql);	
	}
	
	function update_po_stock($po_id,$request_date,$total,$notes,$updated_date,$updated_by){
		$sql = "update project_goal_request_stock_tb set request_date = '".esc($request_date)."',
															total = '".esc($total)."',
															notes = '".esc($notes)."',
															updated_date = '".esc($updated_date)."',
															updated_by = '".esc($updated_by)."'
															where id = '".esc($po_id)."'";
		$this->execute_dml($sql);
	}
	
	function add_request_stock_item($projet_goal_request_stock_id,$item,$stock,$desc,$qty,$unit_type,$price,$total){
		$sql = "insert into project_goal_request_stock_item_tb (project_goal_request_stock_id,project_goal_po_client_item_id,stock_id,description,qty,unit_type,price,total)
				values	('".esc($projet_goal_request_stock_id)."',
						'".esc($item)."',
						'".esc($stock)."',
						'".esc($desc)."',
						'".esc($qty)."',
						'".esc($unit_type)."',
						'".esc($price)."',
						'".esc($total)."')";
		$this->execute_dml($sql);	
	}
	function add_request_stock_item2($warehouse_id,$rak_id,$projet_goal_request_stock_id,$item,$stock,$desc,$qty,$unit_type,$price,$total){
		$sql = "insert into project_goal_request_stock_item_tb (warehouse_id,rak_id,project_goal_request_stock_id,project_goal_po_client_item_id,stock_id,description,qty,unit_type,price,total)
				values	(
						'".esc($warehouse_id)."',
						'".esc($rak_id)."',
						'".esc($projet_goal_request_stock_id)."',
						'".esc($item)."',
						'".esc($stock)."',
						'".esc($desc)."',
						'".esc($qty)."',
						'".esc($unit_type)."',
						'".esc($price)."',
						'".esc($total)."')";
		$this->execute_dml($sql);	
	}
	
	function update_request_stock_item($po_item_id,$item,$stock,$desc,$qty,$unit_type,$price,$total){
		$sql = "update project_goal_request_stock_item_tb set 	project_goal_po_client_item_id = '".esc($item)."',
																stock_id = '".esc($stock)."',
																description = '".esc($desc)."',
																qty = '".esc($qty)."',
																unit_type = '".esc($unit_type)."',
																price = '".esc($price)."',
																total = '".esc($total)."'
																where id = '".esc($po_item_id)."'";
		$this->execute_dml($sql);	
	}
	
	function update_request_stock_item2($warehouse_id,$rak_id,$po_item_id,$item,$stock,$desc,$qty,$unit_type,$price,$total){
		$sql = "update project_goal_request_stock_item_tb set 	warehouse_id = '".esc($warehouse_id)."',
																rak_id = '".esc($rak_id)."',
																project_goal_po_client_item_id = '".esc($item)."',
																stock_id = '".esc($stock)."',
																description = '".esc($desc)."',
																qty = '".esc($qty)."',
																unit_type = '".esc($unit_type)."',
																price = '".esc($price)."',
																total = '".esc($total)."'
																where id = '".esc($po_item_id)."'";
		$this->execute_dml($sql);	
	}
	
	
	
	function remove_request_stock_item($po_item_id){
		$sql = "delete from project_goal_request_stock_item_tb where id = '".esc($po_item_id)."'";
		$this->execute_dml($sql);	
	}
	
	function get_project_po_request_non_stock($project_id){
		$sql = "select pgp.*, v.name as vendor_name from project_goal_po_tb pgp
				left join vendor_tb v on v.id = pgp.vendor_id
				where pgp.project_id = '".esc($project_id)."'
				order by pgp.id asc";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_project_po_request_non_stock_item($data){
		$sql = "select pgpi.*,pgpci.item as po_item, pgp.approval_by, pgp.approval_date,pgp.created_by, pgp.created_date, po_number from project_goal_po_item_tb pgpi
				left join project_goal_po_client_item_tb pgpci on pgpi.project_goal_po_client_item_id = pgpci.id
				left join project_goal_po_tb pgp on pgp.id = pgpi.project_goal_po_id
				where pgpi.project_goal_po_id in ".esc($data);
		return $this->fetch_multi_row($sql);	
	}
	
	function get_project_po_request_stock($project_id){
		$sql = "select * from project_goal_request_stock_tb where project_id = '".esc($project_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_project_po_request_stock_item($data){
		$sql = "select pgrsi.*,pgpci.item as po_item, s.item as stock_name,pgrs.created_date,pgrs.created_by from project_goal_request_stock_item_tb pgrsi
				left join project_goal_po_client_item_tb pgpci on pgrsi.project_goal_po_client_item_id = pgpci.id
				left join stock_tb s on s.id = pgrsi.stock_id
				left join project_goal_request_stock_tb pgrs on pgrs.id = pgrsi.project_goal_request_stock_id
				where pgrsi.project_goal_request_stock_id in ".esc($data);
		return $this->fetch_multi_row($sql);	
	}
	
	function add_request_budget($project_id,$request_date,$total,$notes,$created_date,$created_by,$bs){
		$sql = "insert into request_budget_tb (project_id,request_date,total,notes,created_date,created_by,bs)
				values	('".esc($project_id)."','".esc($request_date)."','".esc($total)."','".esc($notes)."','".esc($created_date)."','".esc($created_by)."','".esc($bs)."')";
		$this->execute_dml($sql);
	}
	
	function add_request_budget_item($request_budget_id,$item,$desc,$vendor,$qty,$price,$bank_name,$acc_name,$acc_number){
		$sql = "insert into request_budget_item_tb (request_budget_id,project_goal_po_client_item_id,description,vendor_name,price,bank_name,acc_name,acc_number)
				values	('".esc($request_budget_id)."',
						'".esc($item)."',
						'".esc($desc)."',
						'".esc($vendor)."',
						'".esc($price)."',
						'".esc($bank_name)."',
						'".esc($acc_name)."',
						'".esc($acc_number)."')";
		$this->execute_dml($sql);	
	}
	
	function update_request_budget_item($budget_item_id,$item,$desc,$vendor,$qty,$price,$bank_name,$acc_name,$acc_number){
		$sql = "update request_budget_item_tb set 	project_goal_po_client_item_id = '".esc($item)."',
													description = '".esc($desc)."',
													vendor_name = '".esc($vendor)."',
													price = '".esc($price)."',
													bank_name = '".esc($bank_name)."',
													acc_name = '".esc($acc_name)."',
													acc_number = '".esc($acc_number)."'
													where id = '".esc($budget_item_id)."'";
		$this->execute_dml($sql);	
	}
	
	function get_project_request_budget($project_id){
		$sql = "select * from request_budget_tb where project_id = '".esc($project_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	
	
	function get_project_request_budget_outstanding($project_id){
		$sql = "select *,
		(
			SELECT SUM( amount ) AS total 
			FROM request_budget_payment_tb 
			WHERE request_budget_id = rb.id 
		) as total_paid ,
		rb.total - (
						SELECT SUM( amount ) AS total 
						FROM request_budget_payment_tb 
						WHERE request_budget_id = rb.id 
					)  as outstanding 
					 from request_budget_tb rb
		
		
		 where project_id = '".esc($project_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_project_request_budget_item($data){
		$sql = "select pgrbi.*,pgpci.id as pgpci_id, pgpci.item as po_item,rb.created_by,rb.created_date,rb.approval_by,rb.approval_date, request_number as request_budget_number, pgrbi.total as total_item , bl.status as log_status, rb.approval_by, rb.approval_2_by, rb.approval_3_by, rb.approval_4_by
				from request_budget_item_tb pgrbi
				left join budget_log_tb bl on bl.request_budget_item_id=pgrbi.id
				left join project_goal_po_client_item_tb pgpci on pgrbi.project_goal_po_client_item_id = pgpci.id
				left join request_budget_tb rb on rb.id = pgrbi.request_budget_id
				where pgrbi.request_budget_id in ".esc($data)."  and rb.not_approval=0";
		return $this->fetch_multi_row($sql);		
	}
	
	function get_total_expense($data){
		$sql = "select sum(pgrbi.total) as total
				from request_budget_item_tb pgrbi
				left join budget_log_tb bl on bl.request_budget_item_id=pgrbi.id
				left join project_goal_po_client_item_tb pgpci on pgrbi.project_goal_po_client_item_id = pgpci.id
				left join request_budget_tb rb on rb.id = pgrbi.request_budget_id
				where pgrbi.request_budget_id in ".esc($data);
		return $this->fetch_single_row($sql);
	}
	
	
	function get_budget_detail($budget_id){
		$sql = "select * from request_budget_tb where id = '".esc($budget_id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function get_budget_item($budget_id){
		$sql = "select pgrbi.*,pgpci.item as po_item from request_budget_item_tb pgrbi
				left join project_goal_po_client_item_tb pgpci on pgrbi.project_goal_po_client_item_id = pgpci.id 
				where pgrbi.request_budget_id = ".esc($budget_id);
		return $this->fetch_multi_row($sql);	
	}
	
	function update_request_budget($budget_id,$settle_date,$notes,$total,$update_date,$updated_by){
		$sql = "update request_budget_tb set notes = '".esc($notes)."', settle_date = '".esc($settle_date)."', total = '".esc($total)."', updated_date = '".esc($update_date)."', updated_by = '".esc($updated_by)."' where id = '".esc($budget_id)."'";
		$this->execute_dml($sql);	
	}
	
	function approve_po_non_stock($id,$approval_date,$approval_by){
		$sql = "update project_goal_po_tb set approval = 1, approval_by = '".esc($approval_by)."', approval_date = '".esc($approval_date)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function get_po_stock_detail($po_id){
		$sql = "select * from project_goal_request_stock_tb where id = '".esc($po_id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function get_po_stock_item($po_id){
		$sql = "select * from project_goal_request_stock_item_tb where project_goal_request_stock_id = '".esc($po_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function cut_stock_retur($id,$qty){
		$sql = "update project_goal_request_stock_item_tb set qty = (qty-".$qty.") where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function cut_stock($stock,$qty){
		$sql = "update stock_tb set quantity = (quantity-".$qty.") where id = '".esc($stock)."'";
		$this->execute_dml($sql);	
	}
	
	function tambah_stock($stock,$qty){
		$sql = "update stock_tb set quantity = (quantity+".$qty.") where id = '".esc($stock)."'";
		$this->execute_dml($sql);	
	}
	
	function get_po_non_stock_detail($po_id){
		$sql = "select * from project_goal_po_tb where id = '".esc($po_id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function get_po_non_stock_item($po_id){
		$sql = "select * from project_goal_po_item_tb where project_goal_po_id = '".esc($po_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function update_po_item($po_item_id,$itemid,$desc,$qty,$unit_type,$price,$disc,$total){
		$sql = "update project_goal_po_item_tb set	project_goal_po_client_item_id = '".esc($itemid)."',
													description = '".esc($desc)."',
													qty = '".esc($qty)."',
													unit_type = '".esc($unit_type)."',
													price = '".esc($price)."',
													discount = '".esc($disc)."',
													total = '".esc($total)."'
													where id = '".esc($po_item_id)."'";
		$this->execute_dml($sql);	
	}
	
	function edit_po_non_stock($po_id,$vendor_id,$po_date,$delivery_date,$payment_term,$is_ppn,$currency_type,$updated_date,$updated_by,$notes,$subtotal,$discount,$discount_value,$ppn,$total){
		$sql = "update project_goal_po_tb set	vendor_id = '".esc($vendor_id)."',
												delivery_date = '".esc($delivery_date)."',
												payment_term = '".esc($payment_term)."',
												is_ppn = '".esc($is_ppn)."',
												currency_type = '".esc($currency_type)."',
												po_date = '".esc($po_date)."',
												updated_date = '".esc($updated_date)."',
												updated_by = '".esc($updated_by)."',
												notes = '".esc($notes)."',
												subtotal = '".esc($subtotal)."',
												discount = '".esc($discount)."',
												discount_value = '".esc($discount_value)."',
												ppn = '".esc($ppn)."',
												total = '".esc($total)."'
												where id = '".esc($po_id)."'";
		$this->execute_dml($sql);	
	}
	
	function remove_po_item($id){
		$sql = "delete from project_goal_po_item_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function add_receive($project_id,$receive_number,$receive_date,$created_date,$created_by,$month,$year,$number){
		$sql = "insert into receive_tb (project_id,receive_number,receive_date,created_date,created_by,month,year,number)
				values	('".esc($project_id)."',
						'".esc($receive_number)."',
						'".esc($receive_date)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'".esc($month)."',
						'".esc($year)."',
						'".esc($number)."')";
		$this->execute_dml($sql);	
	}
	
	function add_receive2($project_id,$receive_number,$receive_date,$created_date,$created_by,$month,$year,$number,$invoice_number){
		$sql = "insert into receive_tb (project_id,receive_number,receive_date,created_date,created_by,month,year,number,invoice_number)
				values	('".esc($project_id)."',
						'".esc($receive_number)."',
						'".esc($receive_date)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'".esc($month)."',
						'".esc($year)."',
						'".esc($number)."',
						'".esc($invoice_number)."')";
		$this->execute_dml($sql);	
	}
	
	function add_receive_item($receive_id,$list,$list2,$list3,$qty,$created_date,$created_by,$warehouse_id){
		$sql = "insert into receive_item_tb (receive_id,request_non_stock_item_id,request_stock_item_id,budget_id,qty,created_date,created_by,warehouse_id)
				values	('".esc($receive_id)."',
						'".esc($list)."',
						'".esc($list2)."',
						'".esc($list3)."',
						'".esc($qty)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'".esc($warehouse_id)."')";
		$this->execute_dml($sql);	
	}
	
	
	
	function add_receive_item2($receive_id,$list,$list2,$list3,$qty,$created_date,$created_by,$warehouse_id,$rak_id){
		$sql = "insert into receive_item_tb (receive_id,request_non_stock_item_id,request_stock_item_id,budget_id,qty,created_date,created_by,warehouse_id,rak_id)
				values	('".esc($receive_id)."',
						'".esc($list)."',
						'".esc($list2)."',
						'".esc($list3)."',
						'".esc($qty)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'".esc($warehouse_id)."',
						'".esc($rak_id)."')";
		$this->execute_dml($sql);	
	}
	
	function add_receive_item3($receive_id,$list,$list2,$list3,$qty,$created_date,$created_by,$warehouse_id,$rak_id,$cek_id,$history_id){
		$sql = "insert into receive_item_tb (receive_id,request_non_stock_item_id,request_stock_item_id,budget_id,qty,created_date,created_by,warehouse_id,rak_id,cek_stock_id,history_id)
				values	('".esc($receive_id)."',
						'".esc($list)."',
						'".esc($list2)."',
						'".esc($list3)."',
						'".esc($qty)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'".esc($warehouse_id)."',
						'".esc($rak_id)."',
						'".esc($cek_id)."',
						'".esc($history_id)."')";
		$this->execute_dml($sql);	
	}
	
	
	
	
	
	
	function get_receive_list($project_id){
		$sql = "select * from receive_tb where project_id = '".esc($project_id)."' order by receive_date asc";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_receive_item_list($data){
		$sql = "select 	ri.*,
						w.name as wname,
						rbi.budget_id as rbi_budget_id,
						rbi.project_goal_po_client_item_id as rbi_project_goal_po_client_item_id,
						rbi.description as rbi_description,
						pgrsi.project_goal_po_client_item_id as pgrsi_project_goal_po_client_item_id,
						pgrsi.description as pgrsi_description,
						pgrsi.stock_id as pgrsi_stock_id,
						pgpi.project_goal_po_client_item_id as pgpi_project_goal_po_client_item_id,
						pgpi.description as pgpi_description
						
				from receive_item_tb ri
				left join request_budget_item_tb rbi on ri.budget_id = rbi.id
				left join project_goal_request_stock_item_tb pgrsi on pgrsi.id = ri.request_stock_item_id
				left join project_goal_po_item_tb pgpi on pgpi.id = ri.request_non_stock_item_id
				left join warehouse_tb w on w.id = ri.warehouse_id
				where ri.receive_id in (".esc($data).")";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_receive_item_list2($data){
		$sql = "select 	ri.*,
						w.name as wname,
						rbi.budget_id as rbi_budget_id,
						rbi.project_goal_po_client_item_id as rbi_project_goal_po_client_item_id,
						rbi.description as rbi_description,
						pgrsi.project_goal_po_client_item_id as pgrsi_project_goal_po_client_item_id,
						pgrsi.description as pgrsi_description,
						pgrsi.stock_id as pgrsi_stock_id,
						pgpi.project_goal_po_client_item_id as pgpi_project_goal_po_client_item_id,
						pgpi.description as pgpi_description,
						rt.name as rak_name 
						
				from receive_item_tb ri
				left join request_budget_item_tb rbi on ri.budget_id = rbi.id
				left join project_goal_request_stock_item_tb pgrsi on pgrsi.id = ri.request_stock_item_id
				left join project_goal_po_item_tb pgpi on pgpi.id = ri.request_non_stock_item_id
				left join warehouse_tb w on w.id = ri.warehouse_id
				left join rak_tb rt ON ri.rak_id=rt.id
				where ri.receive_id in (".esc($data).")";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_delivery_list($project_id){
		$sql = "select * from delivery_tb where project_id = '".esc($project_id)."' order by delivery_date asc";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_delivery_detail($id){
		$sql = "select * from delivery_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function get_delivery_detail_item_list($id){
		$sql = "select * from delivery_item_tb where delivery_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_delivery_item_list($data){
		$sql = "select 	di.*,
						rbi.budget_id as rbi_budget_id,
						rbi.project_goal_po_client_item_id as rbi_project_goal_po_client_item_id,
						rbi.description as rbi_description,
						pgrsi.project_goal_po_client_item_id as pgrsi_project_goal_po_client_item_id,
						pgrsi.description as pgrsi_description,
						pgrsi.stock_id as pgrsi_stock_id,
						pgpi.project_goal_po_client_item_id as pgpi_project_goal_po_client_item_id,
						pgpi.description as pgpi_description
				from delivery_item_tb di
				left join request_budget_item_tb rbi on di.budget_id = rbi.id
				left join project_goal_request_stock_item_tb pgrsi on pgrsi.id = di.request_stock_item_id
				left join project_goal_po_item_tb pgpi on pgpi.id = di.request_non_stock_item_id
				where di.delivery_id in (".esc($data).")";
		return $this->fetch_multi_row($sql);	
	}
	
		function get_delivery_item_list_by_id($data){
		$sql = "select 	di.*,
						rbi.budget_id as rbi_budget_id,
						rbi.project_goal_po_client_item_id as rbi_project_goal_po_client_item_id,
						rbi.description as rbi_description,
						pgrsi.project_goal_po_client_item_id as pgrsi_project_goal_po_client_item_id,
						pgrsi.description as pgrsi_description,
						pgrsi.stock_id as pgrsi_stock_id,
						pgpi.project_goal_po_client_item_id as pgpi_project_goal_po_client_item_id,
						pgpi.description as pgpi_description
				from delivery_item_tb di
				left join request_budget_item_tb rbi on di.budget_id = rbi.id
				left join project_goal_request_stock_item_tb pgrsi on pgrsi.id = di.request_stock_item_id
				left join project_goal_po_item_tb pgpi on pgpi.id = di.request_non_stock_item_id
				where di.delivery_id = ".esc($data)."";
		return $this->fetch_multi_row($sql);	
	}
	
	function add_delivery($project_id,$delivery_number,$receive_date,$pic,$delivery_date,$created_date,$created_by,$month,$year,$number){
		$sql = "insert into delivery_tb (project_id,delivery_number,receive_date,pic,delivery_date,created_date,created_by,month,year,number)
				values	('".esc($project_id)."',
						'".esc($delivery_number)."',
						'".esc($receive_date)."',
						'".esc($pic)."',
						'".esc($delivery_date)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'".esc($month)."',
						'".esc($year)."',
						'".esc($number)."')";
		$this->execute_dml($sql);	
	}
	
	function add_delivery2($project_id,$delivery_number,$receive_date,$pic,$delivery_date,$created_date,$created_by,$month,$year,$number,$po_number){
		$sql = "insert into delivery_tb (project_id,delivery_number,receive_date,pic,delivery_date,created_date,created_by,month,year,number,po_number)
				values	('".esc($project_id)."',
						'".esc($delivery_number)."',
						'".esc($receive_date)."',
						'".esc($pic)."',
						'".esc($delivery_date)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'".esc($month)."',
						'".esc($year)."',
						'".esc($number)."',
						'".esc($po_number)."')";
		$this->execute_dml($sql);	
	}

function add_delivery3($project_id,$delivery_number,$receive_date,$pic,$delivery_date,$created_date,$created_by,$month,$year,$number,$po_number,$logo,$receive_name){
		$sql = "insert into delivery_tb (project_id,delivery_number,receive_date,pic,delivery_date,created_date,created_by,month,year,number,po_number,logo,receive_name)
				values	('".esc($project_id)."',
						'".esc($delivery_number)."',
						'".esc($receive_date)."',
						'".esc($pic)."',
						'".esc($delivery_date)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'".esc($month)."',
						'".esc($year)."',
						'".esc($number)."',
						'".esc($po_number)."',
						'".esc($logo)."',
						'".esc($receive_name)."')";
		$this->execute_dml($sql);	
	}	
	function add_delivery_item($delivery_id,$list,$list2,$list3,$qty,$created_date,$created_by){
		$sql = "insert into delivery_item_tb (delivery_id,request_non_stock_item_id,request_stock_item_id,budget_id,qty,created_date,created_by)
				values	('".esc($delivery_id)."',
						'".esc($list)."',
						'".esc($list2)."',
						'".esc($list3)."',
						'".esc($qty)."',
						'".esc($created_date)."',
						'".esc($created_by)."')";
		$this->execute_dml($sql);	
	}
	
		function add_delivery_item2($delivery_id,$list,$list2,$list3,$qty,$created_date,$created_by,$stock_id,$serial_number){
		$sql = "insert into delivery_item_tb (delivery_id,request_non_stock_item_id,request_stock_item_id,budget_id,qty,created_date,created_by,stock_id,serial_number)
				values	('".esc($delivery_id)."',
						'".esc($list)."',
						'".esc($list2)."',
						'".esc($list3)."',
						'".esc($qty)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'".esc($stock_id)."',
						'".esc($serial_number)."')";
		$this->execute_dml($sql);	
	}
	
	function get_receive_item_by_id($id){
		$sql = "select * from receive_item_tb where receive_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);
	}
	function delete_receive_item($id){
		$sql = "delete from receive_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);
		
		$sql = "delete from receive_item_tb where receive_id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function confirm_receive_item($id,$confirm_by,$confirm_date){
		$sql = "update receive_tb set is_confirm = 1, confirm_by = '".esc($confirm_by)."', confirm_date = '".esc($confirm_date)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function confirm_delivered_item($id,$confirm_by,$confirm_date){
		$sql = "update delivery_tb set is_confirm = 1, confirm_by = '".esc($confirm_by)."', confirm_date = '".esc($confirm_date)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function delete_delivery_item($id){
		$sql = "delete from delivery_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);
		
		$sql = "delete from delivery_item_tb where delivery_id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function delete_po_stock($id){
		$sql = "delete from project_goal_request_stock_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);
		
		$sql = "delete from project_goal_request_stock_item_tb where project_goal_request_stock_id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function delete_po_non_stock($id){
		$sql = "delete from project_goal_po_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);
		
		$sql = "delete from project_goal_po_item_tb where project_goal_po_id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function get_retur_by_project($project_id){
		$sql = "select * from project_goal_retur_stock_tb where project_id = '".esc($project_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_retur_item_by_project($project_goal_retur_stock_id){
		$sql = "select a.*,b.* from project_goal_retur_stock_item_tb a 
		RIGHT JOIN project_goal_request_stock_item_tb b
		ON b.id=a.project_goal_request_stock_item_id where project_goal_retur_stock_id = '".esc($project_goal_retur_stock_id)."' order by a.ID DESC";
		return $this->fetch_multi_row($sql);	
	}

	function get_item_stock_by_name($name){
		$sql = "select * from stock_tb where item = '".esc($name)."' and quantity > 0";
		return $this->fetch_multi_row($sql);
		
	}
	function show_stock_detail($id){
		 $sql = "select * from stock_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}

	
	////purchase request
	function get_purchase_request_item($project_id){
		$sql = "select * from project_goal_purchase_request_item_tb where project_id = '".esc($project_id)."' ";
		return $this->fetch_multi_row($sql);
	}
	function get_purchase_request_item_by_pr_id($purchase_request_id){
		$sql = "select * from project_goal_purchase_request_item_tb where purchase_request_id = '".esc($purchase_request_id)."' ";
		return $this->fetch_multi_row($sql);
	}
	function get_purchase_request($project_id){
		$sql = "select * from project_goal_purchase_request_tb where project_id = '".esc($project_id)."' ";
		return $this->fetch_multi_row($sql);
	}

	
}?>