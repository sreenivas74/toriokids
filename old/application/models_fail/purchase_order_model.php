<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Purchase_order_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function get_quotation_detail($id){
		$sql = "select pgq.*,p.name as pname,e.firstname as efirstname,e.lastname as elastname from project_goal_quotation_tb pgq
				left join project_goal_tb pg on pg.id = pgq.project_goal_id
				left join project_tb p on p.id = pg.project_id
				left join employee_tb e on pgq.created_by = e.id
				where pgq.id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function get_quotation_item_detail($id){
		$sql = "select * from project_goal_quotation_item_tb where project_goal_quotation_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql);
	}
	
	function update_product_status($item_id,$status){
		$sql = "update project_goal_quotation_item_tb set status = '".esc($status)."' where id = '".esc($item_id)."'";
		$this->execute_dml($sql);	
	}
	
	function add_stock($warehouse_id,$rak_id,$item,$description,$quantity,$notes,$updated_date,$updated_by,$price){
		$sql = "insert into stock_tb (warehouse_id,rak_id,item,description,quantity,notes,updated_date,updated_by,active,price)
				values	('".esc($warehouse_id)."',
						'".esc($rak_id)."',
						'".esc($item)."',
						'".esc($description)."',
						'".esc($quantity)."',
						'".esc($notes)."',
						'".esc($updated_date)."',
						'".esc($updated_by)."',
						'1',
						'".esc($price)."')";
		$this->execute_dml($sql);	
	}
		function add_stock2($warehouse_id,$rak_id,$item,$description,$quantity,$notes,$updated_date,$updated_by,$price,$type){
		$sql = "insert into stock_tb (warehouse_id,rak_id,item,description,quantity,notes,updated_date,updated_by,active,price,type_stock)
				values	('".esc($warehouse_id)."',
						'".esc($rak_id)."',
						'".esc($item)."',
						'".esc($description)."',
						'".esc($quantity)."',
						'".esc($notes)."',
						'".esc($updated_date)."',
						'".esc($updated_by)."',
						'1',
						'".esc($price)."',
						'".esc($type)."')";
		$this->execute_dml($sql);	
	}
	
	function get_detail_stock($id){
		$sql = "select * from stock_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function get_all_stock(){
		$sql = "select st.*,wh.name as warehouse_name,rk.name as rak_name 
		from stock_tb st 
		LEFT JOIN warehouse_tb wh on wh.id=st.warehouse_id
		LEFT JOIN rak_tb rk on rk.id=st.rak_id order by st.warehouse_id,rk.id";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_all_stock2(){
		$sql = "select st.*,wh.name as warehouse_name,rk.name as rak_name 
		from stock_tb st 
		LEFT JOIN warehouse_tb wh on wh.id=st.warehouse_id
		LEFT JOIN rak_tb rk on rk.id=st.rak_id  where st.type_stock=0 order by st.warehouse_id,rk.id";
		return $this->fetch_multi_row($sql);	
	}
	
	function active_stock($id,$active){
		$sql = "update stock_tb set active = '".esc($active)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function edit_stock($warehouse_id,$rak_id,$stock_id,$item,$description,$quantity,$notes,$updated_date,$updated_by,$price){
		$sql = "update stock_tb set warehouse_id='".esc($warehouse_id)."', rak_id='".esc($rak_id)."', item='".esc($item)."',quantity = '".esc($quantity)."', notes = '".esc($notes)."',description = '".esc($description)."', price = '".esc($price)."' where id = '".esc($stock_id)."'";
		$this->execute_dml($sql);	
	}
	
	function show_stock_active(){
		$sql = "select * from stock_tb where active = 1 order by item";
		return $this->fetch_multi_row($sql);	
	}
	
	function insert_po($quotation_id,$po_number,$po_date,$delivery_day,$att,$to,$contact,$telp,$fax,$email,$created_date,$created_by){
		$sql = "insert into project_goal_po_tb (project_goal_quotation_id,po_number,po_date,delivery_day,att,delivery_to,contact,telp,fax,email,created_date,created_by)
				values	('".esc($quotation_id)."',
						'".esc($po_number)."',
						'".esc($po_date)."',
						'".esc($delivery_day)."',
						'".esc($att)."',
						'".esc($to)."',
						'".esc($contact)."',
						'".esc($telp)."',
						'".esc($fax)."',
						'".esc($email)."',
						'".esc($created_date)."',
						'".esc($created_by)."')";
		$this->execute_dml($sql);	
	}
	
	function update_quotation_request_po($quotation_id,$created_date){
		$sql = "update project_goal_quotation_tb set is_request = 1, request_po_date = '".esc($created_date)."' where id = '".esc($quotation_id)."'";
		$this->execute_dml($sql);
	}
	
	function insert_po_item($po_id,$list,$qty,$stock_id,$po_price){
		$sql = "insert into project_goal_po_item_tb (project_goal_po_id,project_goal_quotation_item_id,qty,price,stock_id)
				values	('".esc($po_id)."','".esc($list)."','".esc($qty)."','".esc($po_price)."','".esc($stock_id)."')";
		$this->execute_dml($sql);	
	}
	
	function update_po_item_price($list,$is_stock,$stock_id,$po_price,$request_status){
		$sql = "update project_goal_quotation_item_tb set is_stock = '".esc($is_stock)."', is_request = '".esc($request_status)."', stock_id = '".esc($stock_id)."', po_price = '".esc($po_price)."' where id = '".esc($list)."'";
		$this->execute_dml($sql);	
	}
	
	function cut_stock($stock_id,$qty){
	echo	$sql = "update stock_tb set quantity=(quantity-".esc($qty).") where id = '".esc($stock_id)."'";
		$this->execute_dml($sql);	
	}
	
	function show_po_list($quotation_id){
		$sql = "select * from project_goal_po_tb where project_goal_quotation_id = '".esc($quotation_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_po_item($po_data){
		$sql = "select pgpi.*,item,description from project_goal_po_item_tb pgpi
				left join project_goal_quotation_item_tb pgqi on pgqi.id = pgpi.project_goal_quotation_item_id
				where project_goal_po_id in ( '".esc($po_data)."' )";
		return $this->fetch_multi_row($sql);	
	}
	
	function update_po_total($po_id,$subtotal,$discount,$ppn,$total){
		$sql = "update project_goal_po_tb set subtotal = '".esc($subtotal)."', discount = '".esc($discount)."', ppn = '".esc($ppn)."', total = '".esc($total)."' where id = '".esc($po_id)."'";
		$this->execute_dml($sql);	
	}
	
	function show_po_detail($id){
		$sql = "select pgp.*,currency_type from project_goal_po_tb pgp
				left join project_goal_quotation_tb pgq on pgq.id = pgp.project_goal_quotation_id
		 		where pgp.id  = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function show_po_item_detail($id){
		$sql = "select pgpi.*,item,description from project_goal_po_item_tb pgpi
				left join project_goal_quotation_item_tb pgqi on pgqi.id = pgpi.project_goal_quotation_item_id
				where project_goal_po_id = '".esc($id)."'";
		return $this->fetch_multi_row($sql); 	
	}
	
	function change_po_status($po_id,$status,$leader_id,$approval_date){
		$sql = "update project_goal_po_tb set approval = '".esc($status)."', approval_by = '".esc($leader_id)."', approval_date = '".esc($approval_date)."' where id = '".esc($po_id)."'";
		$this->execute_dml($sql);	
	}
	
	function get_user_detail($id){
		$sql = "select e.*,alias from employee_tb e
				left join company_tb c on c.id = e.company_id
				where e.id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function add_request_stock($vendor_id,$request_stock_number,$request_stock_date,$delivery_date,$payment_term,$is_ppn,$currency_type,$created_date,$month,$year,$number,$notes,$created_by){
		$sql = "insert into request_stock_tb (vendor_id,request_stock_number,request_stock_date,delivery_date,payment_term,is_ppn,currency_type,created_date,month,year,number,notes,created_by)
				values	('".esc($vendor_id)."',
						'".esc($request_stock_number)."',
						'".esc($request_stock_date)."',
						'".esc($delivery_date)."',
						'".esc($payment_term)."',
						'".esc($is_ppn)."',
						'".esc($currency_type)."',
						'".esc($created_date)."',
						'".esc($month)."',
						'".esc($year)."',
						'".esc($number)."',
						'".esc($notes)."',
						'".esc($created_by)."')";
		$this->execute_dml($sql);	
	}
	
	
	function update_request_stock($request_stock_id,$vendor_id,$request_stock_date,$delivery_date,$payment_term,$is_ppn,$currency_type,$updated_date,$notes,$updated_by){
		
		$sql = "update request_stock_tb set vendor_id = '".esc($vendor_id)."', request_stock_date = '".esc($request_stock_date)."', delivery_date = '".esc($delivery_date)."', payment_term = '".esc($payment_term)."', is_ppn = '".esc($is_ppn)."'
		, currency_type = '".esc($currency_type)."'
		, updated_date = '".esc($updated_date)."'
		, updated_by = '".esc($updated_by)."'
		, notes = '".esc($notes)."'
		
		
		 where id = '".esc($request_stock_id)."'";
		$this->execute_dml($sql);	
	}
	
	function add_request_stock_item($request_stock_id,$itemid,$desc,$qty,$unit_type,$price,$disc,$total){
		$sql = "insert into request_stock_item_tb (request_stock_id,item,description,qty,item_type,price,discount,total)
				values	('".esc($request_stock_id)."',
						'".esc($itemid)."',
						'".esc($desc)."',
						'".esc($qty)."',
						'".esc($unit_type)."',
						'".esc($price)."',
						'".esc($disc)."',
						'".esc($total)."')";
		$this->execute_dml($sql);		
	}
	
	function add_request_stock_item2($request_stock_id,$itemid,$desc,$qty,$unit_type,$price,$disc,$total,$bank_name,$acc_name,$acc_number,$vendor_id){
		$sql = "insert into request_stock_item_tb (request_stock_id,item,description,qty,item_type,price,discount,total,bank_name,acc_name,acc_number,vendor_id)
				values	('".esc($request_stock_id)."',
						'".esc($itemid)."',
						'".esc($desc)."',
						'".esc($qty)."',
						'".esc($unit_type)."',
						'".esc($price)."',
						'".esc($disc)."',
						'".esc($total)."',
						'".esc($bank_name)."',
						'".esc($acc_name)."',
						'".esc($acc_number)."',
						'".esc($vendor_id)."')";
		$this->execute_dml($sql);		
	}
	
	function update_request_stock_item($id,$itemid,$description,$qty,$unit_type,$price,$disc,$total){
		
		$sql = "update request_stock_item_tb set  item='".esc($itemid)."', description = '".esc($description)."', qty = '".esc($qty)."', item_type = '".esc($unit_type)."', price = '".esc($price)."'
		, discount = '".esc($disc)."'
		, total = '".esc($total)."'
		
		
		 where id = '".esc($id)."'";
		$this->execute_dml($sql);	
			
	}
	
		function update_request_stock_item2($id,$itemid,$description,$qty,$unit_type,$price,$disc,$total,$bank_name,$acc_name,$acc_number,$vendor_id){
		
		$sql = "update request_stock_item_tb set  item='".esc($itemid)."', description = '".esc($description)."', qty = '".esc($qty)."', item_type = '".esc($unit_type)."', price = '".esc($price)."', discount = '".esc($disc)."', bank_name = '".esc($bank_name)."', acc_name = '".esc($acc_name)."', acc_number = '".esc($acc_number)."', vendor_id = '".esc($vendor_id)."',
		
		
		
		
		
		 total = '".esc($total)."'
		
		
		 where id = '".esc($id)."'";
		$this->execute_dml($sql);	
			
	}
	
	function set_total_in_request_stock($request_stock_id,$subtotal,$discount,$discount_value,$ppn,$total){
		$sql = "update request_stock_tb set subtotal = '".esc($subtotal)."', discount = '".esc($discount)."', discount_value = '".esc($discount_value)."', ppn = '".esc($ppn)."', total = '".esc($total)."' where id = '".esc($request_stock_id)."'";
		$this->execute_dml($sql);	
	}
	
	function get_request_stock_detail($request_stock_id){
		$sql = "select * from request_stock_tb where id = '".esc($request_stock_id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function get_request_stock_item($request_stock_id){
		$sql = "select * from request_stock_item_tb where request_stock_id = '".esc($request_stock_id)."'";
		return $this->fetch_multi_row($sql);	
	}
	function get_request_stock_item_detail($id){
		$sql = "select * from request_stock_item_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function approve_request_stock($id,$approval_by,$approval_date){
		$sql = "update request_stock_tb set approval = 1, approval_by = '".esc($approval_by)."', approval_date = '".esc($approval_date)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_request_stock($id){
		$sql = "delete from request_stock_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);
		
		$sql = "delete from request_stock_item_tb where request_stock_id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function remove_request_stock_item($id){
		$sql = "delete from request_stock_item_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function get_payment_list_periode($from,$to){
		$sql = "select rbp.*,request_stock_number,b.name as bname,approval,approval_by from 
				request_stock_payment_tb rbp
				RIGHT join request_stock_tb rs on rs.id = rbp.request_stock_id
				left join request_stock_item_tb rsi on rsi.id = rbp.request_stock_id
				left join bank_tb b on b.id = rbp.bank_id
				where pay_date >= '".$from."' and pay_date <= '".$to."'
				order by pay_date desc";
		return $this->fetch_multi_row($sql);	
	}
	
	function get_quantity_received($request_stock_id,$request_stock_item_id){
		$sql = "select sum(quantity) from received_purchasing_item_tb where request_stock_id = '".esc($request_stock_id)."' AND request_stock_item_id = '".esc($request_stock_item_id)."'";
		return $this->fetch_multi_row($sql);	
	
	}
	
	function get_receive_purchasing_by_request($request_stock_id){
			$sql = "select * from receive_purchasing_tb where request_stock_id = '".esc($request_stock_id)."'";
		return $this->fetch_multi_row($sql);
		
	}
	
	function get_receive_item_purchasing_by_request($request_stock_id){
			$sql = "select * from received_purchasing_item_tb where request_stock_id = '".esc($request_stock_id)."'";
		return $this->fetch_multi_row($sql);
	}
	
	function get_receive_item_by_receive_purchasing_id($receive_purchasing_id){
		$sql = "select * from received_purchasing_item_tb where received_purchasing_id = '".esc($receive_purchasing_id)."'";
		return $this->fetch_multi_row($sql);
	}
	
	function new_approve_request_stock($id,$approve_by,$approve_date,$approval,$approval_by,$approval_date,$approval_comment,$comment){
		$sql = "update request_stock_tb set ".$approval." = 1, ".$approval_by." = '".esc($approve_by)."', ".$approval_date." = '".esc($approve_date)."', ".$approval_comment." = '".esc($comment)."'
				where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function set_approval_to_zero($request_stock_id){
		$sql = "update request_stock_tb set approval = 0, approval_by = 0, approval_date = '0000-00-00 00:00:00', approval_2 = 0, approval_2_by = 0, approval_2_date = '0000-00-00 00:00:00', approval_3 = 0, approval_3_by = 0, approval_3_date = '0000-00-00 00:00:00', approval_4 = 0, approval_4_by = 0, approval_4_date = '0000-00-00 00:00:00' where id = '".esc($request_stock_id)."'";
		$this->execute_dml($sql);		
	}
	
}