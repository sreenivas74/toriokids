<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Report_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_employee(){
		$sql = "select * from employee_tb order by join_date desc";
		return $this->fetch_multi_row($sql);
	}
	
	function show_employee_activity_list($date_1,$date_2){
		$sql = "select * from schedule_tb s where date_now >= '".esc($date_1)."' and date_now <= '".esc($date_2)."' order by date_now desc";
		return $this->fetch_multi_row($sql);
	}
	
	function show_project(){
		$sql = "select *,p.id as p_id, pg.id as pg_id from project_goal_tb pg left join project_tb p on p.id = pg.project_id order by name";
		return $this->fetch_multi_row($sql);
	}
	
	
	function show_employee_daily($date_1,$date_2){
		$sql = "select *,pea.category as pea_category from project_employee_activity_tb pea
				left join employee_tb e on e.id = pea.employee_id
				where activity_date >= '".esc($date_1)."' and activity_date <= '".esc($date_2)."'
				order by activity_date desc,firstname asc,lastname asc";
		return $this->fetch_multi_row($sql);
	}
	
	function show_department(){
		$sql = "select * from department_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);
	}
	
	function show_employee_active(){
		$sql = "select * from employee_tb where status = 1 order by firstname,lastname";
		return $this->fetch_multi_row($sql);
	}
	
	function check_leader($leader_id){
		$sql = "select * from employee_group_tb where  leader_id= '".esc($leader_id)."'";
		return $this->fetch_multi_row($sql);
	}
	
	function show_project_goal_all_range($start_date,$end_date){
			 $sql="select distinct pgi.id as pgi_id, pgi.ppn as pgi_ppn ,name,pgi.po_date as pgi_po_date,pgi.total as pgi_total,total_2,employee_id, pgi.bast_date as pgi_bast,pgi.invoice as pgi_invoice, pgi.under_table_fee as pgi_fee, pgi.tender as pgi_tender,pg.id as pg_id
					from project_goal_invoice_tb pgi
					left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date  >= '".esc($start_date)."' and pgi.bast_date <= '".esc($end_date)."'
					order by name,pgi.po_date,transfer_date";
			return $this->fetch_multi_row($sql);									
	}
	
	
	
	function show_project_goal_all_range2($start_date,$end_date){
				 $sql="select distinct pgi.*,pt.name,em.firstname,em.lastname,pt.employee_id
					from 
					project_goal_invoice_tb pgi
					LEFT JOIN project_goal_tb pgt on pgi.project_goal_id=pgt.id
					left join project_tb pt on pgt.project_id = pt.id
					left join employee_tb em on pt.employee_id = em.id
					left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
					where pgi.bast_date  >= '".esc($start_date)."' and pgi.bast_date <= '".esc($end_date)."'
					order by pt.employee_id,name,pgi.po_date,transfer_date
				";
			return $this->fetch_multi_row($sql);									
	}
	function show_project_goal_all_range3($start_date,$end_date,$employee_id){
				 $sql="select pgi.*,pt.name,em.firstname,em.lastname,pt.employee_id
					from 
					project_goal_invoice_tb pgi
					LEFT JOIN project_goal_tb pgt on pgi.project_goal_id=pgt.id
					left join project_tb pt on pgt.project_id = pt.id
					left join employee_tb em on pt.employee_id = em.id
						left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
					where  pt.employee_id  = '".esc($employee_id)."' AND pgi.bast_date  >= '".esc($start_date)."' and pgi.bast_date <= '".esc($end_date)."'
					order by pt.employee_id,name,pgi.po_date,transfer_date
				";
			return $this->fetch_multi_row($sql);									
	}
	
	function show_project_goal_all_range4($start_date,$end_date,$employee_id){
				 $sql="select distinct pgi.*,pt.name,em.firstname,em.lastname,pt.employee_id
					from 
					project_goal_invoice_tb pgi
					LEFT JOIN project_goal_tb pgt on pgi.project_goal_id=pgt.id
					left join project_tb pt on pgt.project_id = pt.id
					left join employee_tb em on pt.employee_id = em.id
					left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
					where  pt.employee_id IN ( '" . implode($employee_id, "', '") . "' ) AND pgi.bast_date  >= '".esc($start_date)."' and pgi.bast_date <= '".esc($end_date)."'
			order by pt.employee_id,name,pgi.po_date,transfer_date
				";
			return $this->fetch_multi_row($sql);									
	}
	
	function select_employee($employee_id){
			 $sql="select * from employee_tb where id IN ( '" . implode($employee_id, "', '") . "' ) ";
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
			echo $sql = "select distinct pgi.id as pgi_id, pgi.ppn as pgi_ppn ,name,pgi.po_date as pgi_po_date,pgi.total as pgi_total,total_2,employee_id, pgi.bast_date as pgi_bast,pgi.invoice as pgi_invoice, pgi.under_table_fee as pgi_fee, pgi.tender as pgi_tender,pg.id as pg_id
					from project_goal_invoice_tb pgi
					left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date > '".($year-1)."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16' 
					order by name,pgi.po_date,transfer_date";
		}else{
			echo $sql = "select distinct pgi.id as pgi_id,pgi.ppn as pgi_ppn,name,pgi.po_date as pgi_po_date,pgi.total as pgi_total,total_2,employee_id, pgi.bast_date as pgi_bast,pgi.invoice as pgi_invoice, pgi.under_table_fee as pgi_fee, pgi.tender as pgi_tender,pg.id as pg_id
					from project_goal_invoice_tb pgi
					left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date > '".$year."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16' 
					order by name,pgi.po_date,transfer_date";
		}
		return $this->fetch_multi_row($sql);
	}
	
	function show_outstanding_report($quarter,$year){
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
	
	function show_crm(){
		$sql = "select * from project_tb p order by name";
		return $this->fetch_multi_row($sql);
	}
	
	function show_project_goal_survey($quarter,$year){
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
			$sql = "select distinct pgi.id as pgi_id, pgi.ppn as pgi_ppn ,name,pgi.po_date as pgi_po_date,pgi.total as pgi_total,total_2,employee_id, pgi.bast_date as pgi_bast,pgi.invoice as pgi_invoice, pgi.under_table_fee as pgi_fee,marketing, engineering,support,pgis.description as pgis_description,pg.id as pg_id
					from project_goal_invoice_tb pgi
					left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					left join project_goal_invoice_survey_tb pgis on pgis.project_goal_invoice_id = pgi.id
					where pgi.bast_date > '".($year-1)."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16' 
					order by name,pgi.po_date,transfer_date";
		}else{
			$sql = "select distinct pgi.id as pgi_id,pgi.ppn as pgi_ppn,name,pgi.po_date as pgi_po_date,pgi.total as pgi_total,total_2,employee_id, pgi.bast_date as pgi_bast,pgi.invoice as pgi_invoice, pgi.under_table_fee as pgi_fee,marketing, engineering,support,pgis.description as pgis_description,pg.id as pg_id
					from project_goal_invoice_tb pgi
					left join project_goal_payment_tb pgp on pgp.project_goal_invoice_id = pgi.id
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					left join project_goal_invoice_survey_tb pgis on pgis.project_goal_invoice_id = pgi.id
					where pgi.bast_date > '".$year."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16' 
					order by name,pgi.po_date,transfer_date";
		}
		return $this->fetch_multi_row($sql);
	}
	
	function show_project_goal_bonus($quarter,$year){
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
			$sql = "select distinct pgi.id as pgi_id, bonus_marketing,bonus_admin,bonus_support, bonus_engineering, pgi.project_goal_id as pgi_project_goal_id, invoice, bast_date
from project_goal_invoice_tb pgi
left join project_goal_bonus_tb pgb on pgb.project_goal_invoice_id = pgi.id
					where pgi.bast_date > '".($year-1)."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16' 
					";
		}else{
			$sql = "select distinct pgi.id as pgi_id, bonus_marketing,bonus_admin,bonus_support, bonus_engineering, pgi.project_goal_id as pgi_project_goal_id, invoice, bast_date
from project_goal_invoice_tb pgi
left join project_goal_bonus_tb pgb on pgb.project_goal_invoice_id = pgi.id
					where pgi.bast_date > '".$year."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16'
					";
		}
		return $this->fetch_multi_row($sql);
	}
	
	function show_payment($quarter,$year){
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
			$sql = "select dp_idr,dp_usd, transfer_date, bank,  bast_date ,pgi.invoice as pgi_invoice, pgi.project_goal_id as pgi_project_goal_id
					from project_goal_payment_tb pgp
					left join project_goal_invoice_tb pgi on pgp.project_goal_invoice_id = pgi.id
					where transfer_date > '".($year-1)."-".$x."-15' and  transfer_date < '".$year."-".$y."-16' 
					order by transfer_date desc";
		}else{
			$sql = "select dp_idr,dp_usd, transfer_date, bank,  bast_date ,pgi.invoice as pgi_invoice, pgi.project_goal_id as pgi_project_goal_id
					from project_goal_payment_tb pgp
					left join project_goal_invoice_tb pgi on pgp.project_goal_invoice_id = pgi.id
					where transfer_date > '".$year."-".$x."-15' and  transfer_date < '".$year."-".$y."-16' 
					order by transfer_date desc";
		}
		return $this->fetch_multi_row($sql);
	}
	
	function show_total_invoice($quarter,$year){
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
			$sql = "select sum(pgi.total)as idr,sum(pgi.total_2)as usd
					from project_goal_invoice_tb pgi
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date > '".($year-1)."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16' 
					and p.employee_id != 0
					";
		}else{
			$sql = "select sum(pgi.total)as idr,sum(pgi.total_2)as usd
					from project_goal_invoice_tb pgi
					left join project_goal_tb pg on pg.id = pgi.project_goal_id
					left join project_tb p on p.id = pg.project_id
					where pgi.bast_date > '".$year."-".$x."-15' and  pgi.bast_date < '".$year."-".$y."-16'
					and p.employee_id != 0
					";
		}
		return $this->fetch_single_row($sql);
	}
	
	function show_outstanding($quarter,$year){
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
			$sql = "select sum(dp_idr)as dp_idr, sum(dp_usd)as dp_usd
					from project_goal_payment_tb pgp
					left join project_goal_invoice_tb pgi on pgp.project_goal_invoice_id = pgi.id
					where bast_date > '".($year-1)."-".$x."-15' and  bast_date < '".$year."-".$y."-16'
					";
		}else{
			$sql = "select sum(dp_idr)as dp_idr, sum(dp_usd)as dp_usd
					from project_goal_payment_tb pgp
					left join project_goal_invoice_tb pgi on pgp.project_goal_invoice_id = pgi.id
					where bast_date > '".$year."-".$x."-15' and  bast_date < '".$year."-".$y."-16' 
					";
		}
		return $this->fetch_single_row($sql);
	}
	
	
	
	
	function show_project_goal_report($type_filter,$start_date,$end_date){
		if($type_filter==1){
		 $sql = "select a.*,b.po_date,b.id as new_project_id from project_tb a join project_goal_po_client_tb b ON a.id=b.project_id where bast_date >= '".esc($start_date)."' and bast_date <= '".esc($end_date)."'";
		}else{
		 $sql = "select a.*,b.po_date,b.id as new_project_id from project_tb a join project_goal_po_client_tb b ON a.id=b.project_id where b.po_date >= '".esc($start_date)."' and b.po_date <= '".esc($end_date)."'";
		
		}
		return $this->fetch_multi_row($sql);
	}
	function get_project_po_client_item($po_client_id){
		$sql = "select * from project_goal_po_client_item_tb where project_goal_po_client_id = '".esc($po_client_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_invoice_po_client($po_client_id){
		$sql = "select sum(total) as total_invoice from project_goal_invoice_tb where project_goal_id = '".esc($po_client_id)."'";
		$result = mysql_fetch_assoc(mysql_query($sql));
		return $result;	
	}
	
	
	function show_crm_by_id($id){
		$sql = "select * from project_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function get_request_budget_project($project_id){
		$sql = "select * from request_budget_tb where project_id = '".esc($project_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	function get_request_budget_payment_tb($request_budget_id){
		$sql = "select * from request_budget_payment_tb where request_budget_id = '".esc($request_budget_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_request_budget_reimburse(){
		$sql = "select * from request_budget_tb where reimburse = '".esc(1)."' order by id DESC";
		return $this->fetch_multi_row($sql);
	}
	
	
	function get_all_oustanding(){
		$sql = "select pt.*,en.firstname,en.lastname from project_tb pt,pgt
		LEFT JOIN employee_tb en ON pt.employee_id=en.id
		where sales_stage = 4 order by id DESC";
		return $this->fetch_multi_row($sql);	
	}
	
	
	
	function get_all_project_goal_outstanding_tb(){
		$sql="select pgt.*,en.firstname,en.lastname ,pt.name as project_name,pt.bast_date as project_bast_date from project_goal_tb pgt JOIN
		project_tb pt ON pgt.project_id=pt.id
		LEFT JOIN employee_tb en ON pt.employee_id=en.id
		
		";
		return $this->fetch_multi_row($sql);
		
		;
	}
	
	function get_all_project_goal_outstanding_filter($type_filter,$start_date,$end_date){
		$search='';
		//1 bast date // 2 win date 
		if($type_filter==1){
			$search.= "and pt.bast_date >='".esc($start_date)."' and pt.bast_date <= '".esc($end_date)."' ";
		}elseif($type_filter==2){
			$search.= "and pt.close_date >='".esc($start_date)."' and pt.close_date <= '".esc($end_date)."' ";
		}
	
		 $sql="select pgt.*,en.firstname,en.lastname ,pt.id as project_id ,pt.close_date as win_date ,pt.name as project_name,pt.bast_date as project_bast_date from project_goal_tb pgt JOIN
		project_tb pt ON pgt.project_id=pt.id
		LEFT JOIN employee_tb en ON pt.employee_id=en.id
		where pgt.id!=0 " .$search. " order by id DESC
		";
		return $this->fetch_multi_row($sql);
		
		;
	}
	
	
	
	
	function get_all_project_detail_filter($type_filter,$start_date,$end_date){
		$search='';
		//1 bast date // 2 win date 
		if($type_filter==1){
			$search.= "and pt.bast_date >='".esc($start_date)."' and pt.bast_date <= '".esc($end_date)."' ";
		}elseif($type_filter==2){
			$search.= "and pt.close_date >='".esc($start_date)."' and pt.close_date <= '".esc($end_date)."' ";
		}
	
		 $sql="select pgt.*,en.firstname,en.lastname ,pt.id as project_id,pt.description as project_description ,pt.close_date as win_date ,pt.name as project_name,pt.bast_date as project_bast_date from project_goal_tb pgt JOIN
		project_tb pt ON pgt.project_id=pt.id
		LEFT JOIN employee_tb en ON pt.employee_id=en.id
		where pgt.id!=0 " .$search. " order by id DESC
		";
		return $this->fetch_multi_row($sql);
		
		;
	}
	
	
	
	
	function get_request_budget_by_employee($employee_id){
		$sql = "select * from request_budget_tb where bs_employee_id = '".esc($employee_id)."'";
		return $this->fetch_multi_row($sql);	
	}
		
	function get_request_budget_by_employee2 ($employee_id){
		$sql = "select * from request_budget_tb where bs_employee_id = '".esc($employee_id)."' AND PAID=1 ";
		return $this->fetch_multi_row($sql);	
	}
	function get_request_log_by_request_budget_id($budget_id){
		$sql = "select * from request_budget_log_tb where request_budget_id = '".esc($budget_id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function get_po_non_stock_history($search){
		 $sql = "select * from project_goal_po_item_tb where description like '%".esc($search)."%'";
		return $this->fetch_multi_row($sql);	
	}
	function get_po_stock_history($search){
		$sql = "select * from project_goal_request_stock_item_tb where description LIKE  '%".esc($search)."%'";
		return $this->fetch_multi_row($sql);	
	}
	function get_request_stock_history($search){
		$sql = "select * from request_stock_item_tb where item LIKE  '%".esc($search)."%' OR description LIKE  '%".esc($search)."%'";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_request_item_detail_by_desc($search){
		$sql = "select rb.*, b.name as bname, pgpci.item as pitem from request_budget_item_tb rb
				left join budget_tb b on b.id = rb.budget_id
				left join project_goal_po_client_item_tb pgpci on pgpci.id = rb.project_goal_po_client_item_id
				where rb.description  LIKE  '%".esc($search)."%' OR pgpci.item  	LIKE  '%".esc($search)."%'  ";
		return $this->fetch_multi_row($sql);	
	}

	
	function show_history_delivery_received($start_date,$end_date,$join_id_all){
		$search='';
		if($start_date!=NULL){
			$search.= "AND created_date >= '".esc($start_date)."'";
		}
		if($end_date!=NULL){
			$search.= "AND created_date <= '".esc($end_date)."'";
		}
		 $sql = "select * from history_delivery_received_tb
 where stock_id in (".$join_id_all.") ".$search." order by ID ASC";
		
		return $this->fetch_multi_row($sql);
	}
	
	
	function get_item_stock_by_name($name){
		$sql = "select * from stock_tb where item = '".esc($name)."'";
		return $this->fetch_multi_row($sql);
		
	}
	function show_stock_detail($id){
		 $sql = "select * from stock_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
}?>