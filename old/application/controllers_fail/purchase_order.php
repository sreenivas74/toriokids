<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Purchase_order extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE)redirect('login');
		$this->load->model('purchase_order_model');
		$this->load->model('flexigrid_model');
		$this->load->model('budget_model');
		$this->load->model('warehouse_model');
		$this->load->model('rak_model');
		$this->load->model('general_model');
		$this->load->model('project_model');
	}
	
	function index(){
		redirect('home');
	}
	
	function payment_list($from=0,$to=0){
		
		if(isset($_POST['from'])){
			$from = $_POST['from'];
		}elseif($from!=0){
			$from = date('Y-m-d',$from);
		}else $from = date('Y-m-d');
		
		if(isset($_POST['to'])){
			$to	= $_POST['to'];
		}elseif($to!=0){
			$to = date('Y-m-d',$to);
		}else $to = date('Y-m-d');
		
		$this->data['from'] = $from;
		$this->data['to'] = $to;
		
		$this->data['payment_list'] = $this->purchase_order_model->get_payment_list_periode($from,$to);
		$this->data['page'] = 'purchase_order/payment_list';
		$this->load->view('common/body', $this->data);
	}
	
	function confirm_payment(){
		$request_payment_id = $this->input->post('request_payment_id');
		$from = $this->input->post('from');
		$to = $this->input->post('to');		
		if($request_payment_id)foreach($request_payment_id as $list){
			$status = $this->input->post('cek_'.$list);
			if($status==1){
				$this->budget_model->confirm_payment_request_stock($list,$status);	
			}
		}
		
		redirect('purchase_order/payment_list/'.strtotime($from).'/'.strtotime($to));
	}
	
	function request_stock_flexi(){
		$fullpayment=$this->uri->segment(3);
		$final_approval=$this->uri->segment(4);
	
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'id';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*,
			 
		(
			SELECT SUM( amount ) AS total 
			FROM request_stock_payment_tb  
			WHERE request_stock_id = rs.id 
		) as total_paid , 
		rs.total - (
						SELECT SUM( amount ) AS total 
						FROM request_stock_payment_tb  
						WHERE request_stock_id = rs.id 
					)  as outstanding 
					";
		$where = "where id != 0";
		
		if($fullpayment=='1'){
			$where.=" AND (
			SELECT SUM( amount ) AS total 
			FROM request_stock_payment_tb  
			WHERE request_stock_id = rs.id 
		) > 0";
		}elseif($fullpayment=='2'){
			$where.=" AND (
			SELECT SUM( amount ) AS total 
			FROM request_stock_payment_tb  
			WHERE request_stock_id = rs.id 
		) is null";
		}
		
		if($final_approval=='1'){
			$where.=" AND approval_date !='0000-00-00 00:00:00'";
		}elseif($final_approval=='2'){
			$where.=" AND approval_date = '0000-00-00 00:00:00'";
		}
		
		
		if ($query) $where.= " AND $qtype LIKE '%$query%' ";
		$tname="request_stock_tb rs";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("id"," $tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if($result) foreach($result as $row){

			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			
			//if($goal==4){
			//	$goal_id = find_2('id','project_id',$row['pid'],'project_goal_tb');
			//	$json .= "'<a href=".site_url('project/detail_project_goal/'.$goal_id)."#budget_tab_site>detail</a>'";
			//}else{
				$json .= "'<a href=".site_url('purchase_order/request_stock_detail/'.$row['id'])." target=\"_blank\">detail</a>'";
			//}
			
			$json .= ",'".esc($row['request_stock_number'])."'";
			
			$json .= ",'".esc(number_format($row['total']))."'";
			
			if($row['total_paid']>0)
			$json .= ",'".esc(number_format($row['outstanding']))."'";
			else
			$json .= ",'".esc(number_format($row['total']))."'";
			
			$json .= ",'".esc(date('d F Y',strtotime($row['request_stock_date'])))."'";
			
			if($row['approval']==1){
				$approved_date = date('d F Y',strtotime($row['approval_date']));
				if($row['approval_by']==0)$approved_by = 'admin';
				else $approved_by = find('firstname',$row['approval_by'],'employee_tb')." ".find('lastname',$row['approval_by'],'employee_tb');
				$json .= ",'".$approved_date."<br />".$approved_by."'";
			}else{
				$json .= ",'-'";
			}
			
			$created_date = date('d F Y',strtotime($row['created_date']));
			if($row['created_by']==0)$created_by = 'admin';
			else $created_by = find('firstname',$row['created_by'],'employee_tb')." ".find('lastname',$row['created_by'],'employee_tb');
			$json .= ",'".$created_date."<br />".$created_by."'";
			
			if($row['updated_date']!='0000-00-00 00:00:00'){
				$updated_date = date('d F Y',strtotime($row['updated_date']));
				if($row['created_by']==0)$updated_by = 'admin';
				else $updated_by = find('firstname',$row['updated_by'],'employee_tb')." ".find('lastname',$row['updated_by'],'employee_tb');
				$json .= ",'".$updated_date."".$updated_date."<br />".$updated_by."'";
			}else{
				$json .= ",'-'";
			}
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	function do_add_request_stock(){
		
		$vendor_id = esc($this->input->post('vendor_id'));
		$request_stock_date = esc($this->input->post('request_stock_date'));
		$delivery_date = esc($this->input->post('delivery_date'));
		$payment_term = esc($this->input->post('payment_term'));
		$is_ppn = esc($this->input->post('is_ppn'));
		$currency_type = esc($this->input->post('currency_type'));
		$created_date = date('Y-m-d H:i:s');
		$notes = esc($this->input->post('notes'));
		
		$user_detail = $this->purchase_order_model->get_user_detail($this->session->userdata('employee_id'));
		$number = find_number_rs()+1;
		$month = date('m');
		$year = date('Y');
		if($this->session->userdata('admin_id')==1){
			$request_stock_number = "RS/".strtoupper("GSI/".date('m')."/ADM/".$number);
		}else{
			$request_stock_number = "RS/".strtoupper($user_detail['alias']."/".date('m')."/".substr($user_detail['firstname'],0,1).substr($user_detail['lastname'],0,1).$user_detail['id']."/".$number);
		}
		
		$created_by = $this->session->userdata('employee_id');
		
		$this->purchase_order_model->add_request_stock($vendor_id,$request_stock_number,$request_stock_date,$delivery_date,$payment_term,$is_ppn,$currency_type,$created_date,$month,$year,$number,$notes,$created_by);
		$request_stock_id = mysql_insert_id();
		//get item and service data
		//product
		$item_product_total = $this->input->post('item_product_total');
		
		for($i=1;$i<=$item_product_total;$i++){
			$itemid = $this->input->post('itemid1_'.$i);
			$desc = $this->input->post('desc1_'.$i);
			$qty = str_replace(",","",$this->input->post('qty1_'.$i));
			$unit_type = $this->input->post('unit_type1_'.$i);
			$price = str_replace(",","",$this->input->post('price1_'.$i));
			$disc = str_replace(",","",$this->input->post('disc1_'.$i));
			$total = str_replace(",","",$this->input->post('total1_'.$i));
			$bank_name=$this->input->post('bank_name1_'.$i);
			$acc_name=$this->input->post('acc_name1_'.$i);
			$acc_number=$this->input->post('acc_number1_'.$i);
			$vendor_id=$this->input->post('vendor1_'.$i);
			//insert to po item
			if($itemid){
				$this->purchase_order_model->add_request_stock_item2($request_stock_id,$itemid,$desc,$qty,$unit_type,$price,$disc,$total,$bank_name,$acc_name,$acc_number,$vendor_id);
			}
		}
		
		$subtotal = str_replace(",","",$this->input->post('subtotal3'));
		$discount = str_replace(",","",$this->input->post('discount'));
		$ppn = str_replace(",","",$this->input->post('ppn3'));
		$total = str_replace(",","",$this->input->post('total3'));
		$discount_value = str_replace(",","",$this->input->post('disc3'));
		$this->purchase_order_model->set_total_in_request_stock($request_stock_id,$subtotal,$discount,$discount_value,$ppn,$total);
		$_SESSION['notif'] = 'Purchase Order created. Click <a href="'.site_url('purchase_order/request_stock_detail/'.$request_stock_id).'">'.$request_stock_number.'</a> to see detail.';
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	
	function do_update_request_stock(){

		$request_stock_id = esc($this->input->post('request_stock_id'));
		$vendor_id = esc($this->input->post('vendor_id'));
		$request_stock_date = esc($this->input->post('request_stock_date'));
		$delivery_date = esc($this->input->post('delivery_date'));
		$payment_term = esc($this->input->post('payment_term'));
		$is_ppn = esc($this->input->post('is_ppn'));
		$currency_type = esc($this->input->post('currency_type'));
		$updated_date = date('Y-m-d H:i:s');
		$notes = esc($this->input->post('notes'));
		
		$user_detail = $this->purchase_order_model->get_user_detail($this->session->userdata('employee_id'));
	
		$updated_by = $this->session->userdata('employee_id');
		
		$this->purchase_order_model->update_request_stock($request_stock_id,$vendor_id,$request_stock_date,$delivery_date,$payment_term,$is_ppn,$currency_type,$updated_date,$notes,$updated_by);
		//exit();
		
		//$request_stock_id = mysql_insert_id();
		//get item and service data
		//product
		$item_product_total = $this->input->post('item_product_total');
		for($i=1;$i<=$item_product_total;$i++){
			$id = $this->input->post('item_id1_'.$i);
			$itemid = $this->input->post('itemid1_'.$i);
			$desc = $this->input->post('desc1_'.$i);
			$qty = str_replace(",","",$this->input->post('qty1_'.$i));
			$unit_type = $this->input->post('unit_type1_'.$i);
			$price = str_replace(",","",$this->input->post('price1_'.$i));
			$disc = str_replace(",","",$this->input->post('disc1_'.$i));
			$total = str_replace(",","",$this->input->post('total1_'.$i));
			$bank_name=$this->input->post('bank_name1_'.$i);
			$acc_name=$this->input->post('acc_name1_'.$i);
			$acc_number=$this->input->post('acc_number1_'.$i);
			$vendor_id=$this->input->post('vendor1_'.$i);
			
			//insert to po item
			if($itemid){
				if($id)
				$this->purchase_order_model->update_request_stock_item2($id,$itemid,$desc,$qty,$unit_type,$price,$disc,$total,$bank_name,$acc_name,$acc_number,$vendor_id);
				else
				$this->purchase_order_model->add_request_stock_item($request_stock_id,$itemid,$desc,$qty,$unit_type,$price,$disc,$total,$bank_name,$acc_name,$acc_number,$vendor_id);
			}
			else{
				
				if($id)
				$this->purchase_order_model->remove_request_stock_item($id);
			}
			
			
		}
		
		$subtotal = str_replace(",","",$this->input->post('subtotal3'));
		$discount = str_replace(",","",$this->input->post('discount'));
		$ppn = str_replace(",","",$this->input->post('ppn3'));
		$total = str_replace(",","",$this->input->post('total3'));
		$discount_value = str_replace(",","",$this->input->post('disc3'));
		$this->purchase_order_model->set_total_in_request_stock($request_stock_id,$subtotal,$discount,$discount_value,$ppn,$total);
		$_SESSION['notif'] = 'Request stock updated.';
		
		$this->purchase_order_model->set_approval_to_zero($request_stock_id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function add_request_stock(){
		$this->data['vendor_list'] = $this->budget_model->get_vendor_list();
		  $this->data['show_all_stock']=$this->warehouse_model->show_all_stock();
		$this->data['page'] = 'purchase_order/add_request_stock';
		$this->load->view('common/body', $this->data);
	}
	
	function request_stock_detail($request_stock_id){
		$this->load->model('warehouse_model');
		$this->load->model('rak_model');
		$this->data['warehouse_list'] = $this->warehouse_model->show_warehouse();
		$this->data['rak'] = $this->rak_model->show_rak();
		$this->data['detail'] = $this->purchase_order_model->get_request_stock_detail($request_stock_id);
		$this->data['item_detail'] = $this->purchase_order_model->get_request_stock_item($request_stock_id);
		$this->data['payment_list'] = $this->budget_model->get_request_stock_payment($request_stock_id);
		$this->data['received_list']=$this->purchase_order_model->get_receive_purchasing_by_request($request_stock_id);
		$this->data['received_item_list']=$this->purchase_order_model->get_receive_item_purchasing_by_request($request_stock_id);
		$this->data['bank_list'] = $this->budget_model->get_bank_list();
		$this->data['page'] = 'purchase_order/detail_request_stock';
		$this->load->view('common/body', $this->data);
	}
	
	function edit_request_stock($request_stock_id){
		$this->data['vendor_list'] = $this->budget_model->get_vendor_list();
		$this->data['show_all_stock']=$this->warehouse_model->show_all_stock();
		$this->data['detail'] = $this->purchase_order_model->get_request_stock_detail($request_stock_id);
		$this->data['item_detail'] = $this->purchase_order_model->get_request_stock_item($request_stock_id);
		
		$content = $this->load->view('purchase_order/edit_request_stock',$this->data);
		
		echo $content;	
	}
	
	function request_stock_list($fullpayment='a',$final_approval='a'){
		$this->data['fullpayment']=$fullpayment;
		$this->data['final_approval']=$final_approval;
		$this->data['page'] = 'purchase_order/request_stock_list';
		$this->load->view('common/body', $this->data);	
	}
	
	function delete_request_stock($id){
		$this->purchase_order_model->delete_request_stock($id);
		$_SESSION['notif'] = "Request Stock Deleted.";
		redirect('purchase_order/request_stock_list');
	}
	
	function ____old_approve_request_stock($id){
		$approval_by = $this->session->userdata('employee_id');
		$approval_date = date('Y-m-d H:i:s');
		
		$this->purchase_order_model->approve_request_stock($id,$approval_by,$approval_date);
		$_SESSION['notif'] = "Request Stock Approved.";
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function add_request_stock_payment($id){
		$paid_by = $this->session->userdata('employee_id');
		$paid_date = date('Y-m-d H:i:s');	
		$bank_to='';
		
		$bank_id = esc($this->input->post('bank_id'));
		$amount = str_replace(",","",esc($this->input->post('amount')));
		$pay_date = esc($this->input->post('pay_date'));
		$pay_type = esc($this->input->post('pay_type'));
		$method = esc($this->input->post('method'));
		
		$request_stock_item_id = $this->input->post('request_stock_item_id');
		
		if($amount){
			if($request_stock_item_id==''){
				$detail = $this->purchase_order_model->get_request_stock_item($id);
				if($detail)foreach($detail as $list_item_bank){
					$bank_to.= $list_item_bank['bank_name']. ' ' . $list_item_bank['acc_name']. ' ' . $list_item_bank['acc_number'] . ' | ';
				}
				}else{
				$detail=$this->purchase_order_model->get_request_stock_item_detail($request_stock_item_id);
				$bank_to=$detail['bank_name'].' '. $detail['acc_name'] . ' ' . $detail['acc_number'] ;
					
			}
			$this->budget_model->add_request_stock_payment2($id,$bank_id,$amount,$pay_date,$paid_by,$paid_date,$pay_type,$method,$request_stock_item_id,$bank_to);
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function update_request_stock_payment($payment_id){
		
		if($payment_id){
			$paid_by = $this->session->userdata('employee_id');
			$paid_date = date('Y-m-d H:i:s');
			
			
			$request_stock_id = esc($this->input->post('request_stock_id'));
			$request_stock_item_id = $this->input->post('request_stock_item_id');
			$bank_id = esc($this->input->post('bank_id'));
			$amount = str_replace(",","",esc($this->input->post('amount')));
			$pay_date = esc($this->input->post('pay_date'));
			$pay_type = esc($this->input->post('pay_type'));
			$method = esc($this->input->post('method'));
			
			if($amount){
				$this->budget_model->update_request_stock_payment($payment_id,$bank_id,$amount,$pay_date,$paid_by,$paid_date,$pay_type,$method,$request_stock_id,$request_stock_item_id);
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function remove_request_stock_payment($id){
		$this->budget_model->remove_request_stock_payment($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	//purchase order
	function all_list(){
		$this->data['page'] = 'purchase_order/all_list';
		$this->load->view('common/body', $this->data);
	}
	
	function purchase_order_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'pgq.quotation_number';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="pgq.*,p.name as pname,e.firstname as efirstname,e.lastname as elastname 
		";
		$where = "where pgq.status = 0 and pgq.approval_level = 3";
		if ($query) $where.= " and $qtype LIKE '%$query%' ";
		$tname="project_goal_quotation_tb pgq
				left join project_goal_tb pg on pg.id = pgq.project_goal_id
				left join project_tb p on p.id = pg.project_id
				left join employee_tb e on pgq.created_by = e.id";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("pgq.id"," $tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if($result) foreach($result as $row){

			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","purchase_order/edit_po","privilege_tb")){
				$json .= "'<a href=".site_url('purchase_order/detail/'.$row['id']).">detail</a>'";
			}else{
				$json .= "'-'";
			}
			$json .= ",'".esc($row['quotation_number'])."'";
			$json .= ",'".esc($row['pname'])."'";
			$json .= ",'".date("d/m/Y",strtotime(esc($row['quotation_date'])))."'";
			if($row['is_ppn']){
				$json .= ",'yes'";
			}else{
				$json .= ",'no'";
			}
			
			if($row['is_request']){
				$json .= ",'<b>yes</b>'";
			}else{
				$json .= ",'<b>no</b>'";
			}
			
			if(!$row['created_by']){
				$created_by = "superadmin";
			}else{
				$created_by = $row['efirstname']." ".$row['elastname'];	
			}
			
			$data = find_quotation_item($row['id'],$row['is_ppn']);
			$data = explode("|",$data);
			$total = $data[0];
			$item = str_replace(array("[","]",'"'),"",$data[1]); 
			
			
			$json .= ",'".date("d/m/Y",strtotime(esc($row['created_date'])))." - ".$created_by."'";
			$json .= ",'Total : ".number_format($total).", Item : ".$item."'";
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
	}
	
	function detail($quotation_id){
		$this->data['quotation_detail'] = $this->purchase_order_model->get_quotation_detail($quotation_id);
		$this->data['quotation_item'] = $this->purchase_order_model->get_quotation_item_detail($quotation_id);
		$this->data['stock_list'] = $this->purchase_order_model->show_stock_active();
		$this->data['po_list'] = $po_list = $this->purchase_order_model->show_po_list($quotation_id);
		$data = '';
		$no = 1;
		if($po_list){
			foreach($po_list as $list){
				if($no==1)$data.= $list['id'];
				else $data.=",".$list['id'];
				$no++;
			}
			$this->data['po_item'] = $this->purchase_order_model->show_po_item($data);
		}else{
			$this->data['po_item'] = '';
		}
		
		$this->data['page'] = 'purchase_order/detail';
		$this->load->view('common/body', $this->data);
	}
	
	function update_product_status($item_id,$status=0){
		//change status because item < 30%
		$this->purchase_order_model->update_product_status($item_id,$status);
		echo $status;
	}
	
	//stock list
	function all_stock(){
		$this->data['warehouse_list'] = $this->warehouse_model->show_warehouse();
		$this->data['page'] = 'purchase_order/all_stock';
		$this->load->view('common/body', $this->data);
	}
	
	function stock_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 's.item';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="s.*,e.firstname as efirstname,e.lastname as elastname";
		$where = "";
		if ($query) $where.= " where $qtype LIKE '%$query%' ";
		$tname="stock_tb s
				left join employee_tb e on s.updated_by = e.id";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("s.id"," $tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if($result) foreach($result as $row){

			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","purchase_order/edit_stock","privilege_tb")){
				$json .= "'<a href=# onclick=edit_stock(".$row['id'].")>edit</a> | <a href=".site_url('report/history_received_delivery').'/'.$row['id'].">History</a>'";
			}else{
				$json .= "'-'";
			}
			$json .= ",'".esc(find('name',$row['warehouse_id'],'warehouse_tb'))."'";
			$json .= ",'".esc(find('name',$row['rak_id'],'rak_tb'))."'";

			$json .= ",'".esc($row['item'])."'";
			$json .= ",'".esc($row['description'])."'";
			$json .= ",'".esc($row['quantity'])."'";
			$json .= ",'".esc(number_format($row['price']))."'";
			if($row['active']==1)$active = "active";
			else $active = "inactive";
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","purchase_order/edit_stock","privilege_tb")){
				$json .= ",'<a href=javascript:void(0) onclick=active_stock(".$row['id'].",".$row['active'].")>".$active."</a>'";
			}else{
				$json .= ",'".$active."'";
			}
			$json .= ",'".esc($row['notes'])."'";
			
			if(!$row['updated_by']){
				$updated_by = "superadmin";
			}else{
				$updated_by = $row['efirstname']." ".$row['elastname'];	
			}
			$json .= ",'".date("d/m/Y",strtotime(esc($row['updated_date'])))." - ".$updated_by."'";
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
	}
	
	function add_stock(){

		$warehouse_id=$this->input->post('warehouse');
		$rak_id=$this->input->post('rak');
		$item = $this->input->post('item');
		$quantity = $this->input->post('quantity');
		$description = $this->input->post('description');
		$notes = $this->input->post('notes');
		$type=$this->input->post('type');

		$price = str_replace(",","",$this->input->post('price'));
		if(!$item){
			$_SESSION['notif'] = 'Please insert item to add new stock.';
			redirect($_SERVER['HTTP_REFERER']);	
		}else{
			$updated_date = date("Y-m-d H:i:s");
			$updated_by = $this->session->userdata('employee_id');
			$this->purchase_order_model->add_stock2($warehouse_id,$rak_id,$item,$description,$quantity,$notes,$updated_date,$updated_by,$price,$type);
			
			$_SESSION['notif'] = 'Stock has been added';
			redirect($_SERVER['HTTP_REFERER']);	
		}
	}
	
	function edit_stock(){

		$warehouse_id=$this->input->post('warehouse');
		$rak_id=$this->input->post('rak');
		$stock_id = $this->input->post('stock_id');
		$item = $this->input->post('item');
		$quantity = $this->input->post('quantity');
		$description = $this->input->post('description');
		$notes = $this->input->post('notes');
		$price = str_replace(",","",esc($this->input->post('price')));
		//if(!$stock_id || !$quantity){
			//$_SESSION['notif'] = 'Please insert quantity to update stock.';
			//redirect($_SERVER['HTTP_REFERER']);	
	//	}else{
			$updated_date = date("Y-m-d H:i:s");
			$updated_by = $this->session->userdata('employee_id');
			$this->purchase_order_model->edit_stock($warehouse_id,$rak_id,$stock_id,$item,$description,$quantity,$notes,$updated_date,$updated_by,$price);
			$_SESSION['notif'] = 'Stock has been updated';
			redirect($_SERVER['HTTP_REFERER']);	
		//}
	}
	
	function get_detail_stock($id){
		$detail = $this->purchase_order_model->get_detail_stock($id);
		echo $detail['item']."|".$detail['quantity']."|".$detail['notes']."|".$detail['description']."|".number_format($detail['price']).'|'.$detail['warehouse_id'].'|'.$detail['rak_id'].'|'.$detail['type_stock'];	
	}
	
	function active_stock($id,$active){
		if($active)$active = 0;
		else $active = 1;
		$this->purchase_order_model->active_stock($id,$active);
	}
	
	function po_request($quotation_id){
		$created_by = $this->session->userdata('employee_id');
		$created_date = date("Y-m-d H:i:s");
		
		$po_number = $this->input->post('po_number');
		$po_date = $this->input->post('po_date');
		$delivery_day = $this->input->post('delivery_day');
		$discount = $this->input->post('discount');
		
		$att = $this->input->post('att');
		$to = $this->input->post('to');
		$contact = $this->input->post('contact');
		$telp = $this->input->post('telp');
		$fax = $this->input->post('fax');
		$email = $this->input->post('email');
		
		if(!$quotation_id || !$po_number){
			$_SESSION['notif'] = "Plese insert PO number.";
			redirect($_SERVER['HTTP_REFERER']);
		}
		//insert to po table
		$this->purchase_order_model->insert_po($quotation_id,$po_number,$po_date,$delivery_day,$att,$to,$contact,$telp,$fax,$email,$created_date,$created_by);
		$po_id = mysql_insert_id();
		
		$this->purchase_order_model->update_quotation_request_po($quotation_id,$created_date);
		$subtotal = 0;
		$item_id = $this->input->post('item_id');
		if($item_id)foreach($item_id as $list){
			$request_status = $this->input->post('request_'.$list);
			if($request_status){ //if check
				$is_stock = $this->input->post('is_stock_'.$list);
				$qty = $this->input->post('qty_'.$list);
				if($is_stock){
					$stock_id = $this->input->post('stock_id_'.$list);
					$po_price = 0;
					//insert item to po item
					if($qty && $stock_id){
						$this->purchase_order_model->insert_po_item($po_id,$list,$qty,$stock_id,$po_price);
					}
					
					//cut inventory
					$this->purchase_order_model->cut_stock($stock_id,$qty);

				}else{
					$stock_id = 0;
					$po_price = $this->input->post('po_price_'.$list);
					//insert item to po item
					if($qty && $po_price){
						$this->purchase_order_model->insert_po_item($po_id,$list,$qty,$stock_id,$po_price);
						$subtotal+=$po_price;
					}
				}
			}
		}
		//update po
		if($discount)$ppn = ($subtotal - $discount)*0.1;	
		else $ppn = $subtotal*0.1;
		
		$total = $subtotal - $discount + $ppn;
		$this->purchase_order_model->update_po_total($po_id,$subtotal,$discount,$ppn,$total);
		///
		
		$_SESSION['notif'] = "PO created.";
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function send_email_po($po_id){
		$this->data['po_detail'] = $po_detail = $this->purchase_order_model->show_po_detail($po_id);
		$this->data['po_item_detail'] = $this->purchase_order_model->show_po_item_detail($po_id);
		
		///////////////
		$leader_id = find_2('leader_id','employee_id',$this->session->userdata('employee_id'),'employee_group_tb');
		$this->data['leader_id'] = $leader_id;
		$this->data['leader_password'] = $leader_password = find_2('password','employee_id',$leader_id,'administrator_tb');
		
		$leader_email = find('email',$leader_id,'employee_tb');
		$from = find('email',$this->session->userdata('employee_id'),'employee_tb');
		$to_email = $leader_email;
		
		$email_content = $this->load->view('purchase_order/send_email_po',$this->data,TRUE);
		$subject = "Purchase Order - ".$po_detail['po_number'];
		
		//echo $email_content;exit;
		
		$this->load->library('email'); 
		$this->email->from($from);
		$this->email->to($to_email);
			
		$this->email->subject($subject);
		$this->email->message($email_content);  
		$this->email->send();
			
		$_SESSION['notif'] = "Email has been sent.";
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function print_email_po($po_id){
		$this->data['po_detail'] = $po_detail = $this->purchase_order_model->show_po_detail($po_id);
		$this->data['po_item_detail'] = $this->purchase_order_model->show_po_item_detail($po_id);
		
		$content=$this->load->view('purchase_order/print_po',$this->data,TRUE);
		echo $content;
		exit;
	}
	
	function print_stock(){
		$this->load->model('admin_model');
		$this->load->helper(array('dompdf', 'file'));
		$filename='all stock list';
    	$this->data['print_by'] =  $this->admin_model->show_administrator_employee_by_id($this->session->userdata('employee_id'));
		$this->data['stock_list']=$this->purchase_order_model->get_all_stock2();
	    $content = $this->load->view('purchase_order/print_stock',$this->data,TRUE);
		pdf_create($content, $filename);	
	}
	
	
	function print_request_stock_detail($request_stock_id){
		$this->load->model('admin_model');
		$this->load->helper(array('dompdf', 'file'));
		$filename='purchase order';
    	$this->data['print_by'] =  $this->admin_model->show_administrator_employee_by_id($this->session->userdata('employee_id'));
		$this->data['detail'] = $this->purchase_order_model->get_request_stock_detail($request_stock_id);
		$this->data['item_detail'] = $this->purchase_order_model->get_request_stock_item($request_stock_id);
		$this->data['payment_list'] = $this->budget_model->get_request_stock_payment($request_stock_id);
		$this->data['bank_list'] = $this->budget_model->get_bank_list();
		$this->data['page'] = 'purchase_order/print_detail_stock';
		  $content=$this->load->view('purchase_order/print_detail_stock', $this->data,TRUE);
		pdf_create($content, $filename);	
	}
	
	function do_receive(){
		$ada_item=0;
		$receive_date=$this->input->post('received_date');
		$no_invoice=$this->input->post('no_invoice');
		$request_stock_id=$this->input->post('purchase_order_id');
		$number = find_number_receive_purchasing()+1;
		$month = date('m');
		$year = date('Y');
		$created_date = date('Y-m-d');
		$vendor_id=$this->input->post('vendor_id');
		$created_by = $this->session->userdata('employee_id');
		if($this->session->userdata('admin_id')==1){
			$receive_number = strtoupper("PO/".date('m')."/ADM1/".$number);
		}else{
			$receive_number = strtoupper("PO/".date('m')."/".substr($user_detail['firstname'],0,1).substr($user_detail['lastname'],0,1).$user_detail['id']."/".$number);	
		}
		$database=array('request_stock_id'=>$request_stock_id,
						'receive_number'=>$receive_number,
						'month'=>$month,
						'year'=>$year,
						'invoice_number'=>$no_invoice,
						'receive_date'=>$receive_date,
						'number'=>$number,
						'created_by'=>$created_by,
						'created_date'=>$created_date);
		$this->general_model->insert_data('receive_purchasing_tb',$database);
		$receive_purchasing_id=mysql_insert_id();
		
		$item=$this->input->post('item');
			if($item)foreach($item as $list){
				$stock_id=$list;
				$price=$this->input->post('price_'.$list);
				$quantity=$this->input->post('qty_'.$list);
				$left=$this->input->post('left_'.$list);
				$warehouse_id=$this->input->post('warehouse_id_'.$list);
				$rak_id=$this->input->post('rak_id_'.$list);
				$desc=$this->input->post('desc_'.$list);
				$database2=array('request_stock_id'=>$request_stock_id,
								'request_stock_item_id'=>$stock_id,
								 'received_purchasing_id'=>$receive_purchasing_id,
								 'quantity'=>$quantity,
								 'left_qty'=>$left,
								 'warehouse_id'=>$warehouse_id,
								 'rak_id'=>$rak_id,
								 'created_date'=>$created_date,
								 'created_by'=>$created_by);
				if($quantity>0){
					if($left >= $quantity){
				
						if($warehouse_id!='0' && $rak_id!='0'){
					
						$stock_item=find('item',$stock_id,'stock_tb');
						$this->general_model->insert_data('received_purchasing_item_tb',$database2);	
					//insert stock//
						$cek_stock=find_10('quantity','rak_id',$rak_id,'warehouse_id',$warehouse_id,'item',$stock_item,'stock_tb');
						$cek_id=find_10('id','rak_id',$rak_id,'warehouse_id',$warehouse_id,'item',$stock_item,'stock_tb');
						
						$quantity_sekarang=$quantity;
							if($cek_stock){
								$database=array('quantity'=>$quantity_sekarang+$cek_stock);
								
								$this->general_model->update_data('stock_tb',$database,array('id'=>$cek_id));
								$database2=array('receive_purchasing_id'=>$receive_purchasing_id,'stock_id'=>$stock_id,'warehouse_id'=>$warehouse_id,'rak_id'=>$rak_id,'in_qty'=>$quantity,'out_qty'=>0,'total'=>$quantity_sekarang+$cek_stock,'qty_before'=>$cek_stock,'price'=>$price,'created_date'=>$created_date,'invoice_number'=>$no_invoice,'vendor_id'=>$vendor_id);
								$this->general_model->insert_data('history_delivery_received_tb',$database2);
							
							}else{
								$database=array('item'=>find('item',$stock_item,'stock_tb'),'description'=>$desc,'quantity'=>$quantity,'price'=>$price,'active'=>1,'rak_id'=>$rak_id,'warehouse_id'=>$warehouse_id);
								$this->general_model->insert_data('stock_tb',$database);
								$stock_id=mysql_insert_id();
								$database2=array('receive_purchasing_id'=>$receive_purchasing_id,'qty_before'=>0,'stock_id'=>$stock_id,'warehouse_id'=>$warehouse_id,'rak_id'=>$rak_id,'in_qty'=>$quantity,'out_qty'=>0,'total'=>$quantity_sekarang,'price'=>$price,'created_date'=>$created_date,'invoice_number'=>$no_invoice,'vendor_id'=>$vendor_id);
								$this->general_model->insert_data('history_delivery_received_tb',$database2);
							}
							$ada_item=1;
							
							
						
						}else{
						$this->general_model->delete_data('receive_purchasing_tb',array('id'=>$receive_purchasing_id));
						$this->general_model->delete_data('received_purchasing_item_tb',array('received_purchasing_id'=>$receive_purchasing_id));
							$_SESSION['error']='Please select Warehouse and Rak';
						}
						
					}else{
						$this->general_model->delete_data('receive_purchasing_tb',array('id'=>$receive_purchasing_id));
						$this->general_model->delete_data('received_purchasing_item_tb',array('received_purchasing_id'=>$receive_purchasing_id));
						$_SESSION['error']='Received Item Error (Quantity more than quantity available).';
						
						
						
					}
				
				}		
				
			}else{
				
				
				
			
			}
						
	redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	function delete_purchase_order_received($receive_purchasing_id){	
		$stock_list=$this->purchase_order_model->get_receive_item_by_receive_purchasing_id($receive_purchasing_id);
			if($stock_list)foreach($stock_list as $list){
				$stock_item=find('item',$list['request_stock_item_id'],'stock_tb');
				$rak_id=$list['rak_id'];
				$warehouse_id=$list['warehouse_id'];
				$cek_stock=find_10('quantity','rak_id',$rak_id,'warehouse_id',$warehouse_id,'item',$stock_item,'stock_tb');
				$cek_id=find_10('id','rak_id',$rak_id,'warehouse_id',$warehouse_id,'item',$stock_item,'stock_tb');
				$database=array('quantity'=>$cek_stock-$list['quantity']);				
				$this->general_model->update_data('stock_tb',$database,array('id'=>$cek_id));
			}
			
			
			$this->general_model->delete_data('receive_purchasing_tb',array('id'=>$receive_purchasing_id));
			$this->general_model->delete_data('received_purchasing_item_tb',array('received_purchasing_id'=>$receive_purchasing_id));
			$this->general_model->delete_data('history_delivery_received_tb',array('receive_purchasing_id'=>$receive_purchasing_id));
			
		redirect($_SERVER['HTTP_REFERER']);
		
	}
	
	
	
	function approve_request_stock(){
		
		$type=$this->input->post('type');
		$id=$this->input->post('request_id');
		$comment=$this->input->post('name_comment');
		
		$approve_by = $this->session->userdata('employee_id');
		$approve_date = date('Y-m-d H:i:s');
		if($type==1){
			$approval = "approval";
			$approval_by = "approval_by";
			$approval_date	= "approval_date";
			$approval_comment="approval_comment";
			$_SESSION['notif'] = "Approval 1 success";
		}elseif($type==2){
			$approval = "approval_2";
			$approval_by = "approval_2_by";
			$approval_date	= "approval_2_date";
			$approval_comment="approval_2_comment";
			$_SESSION['notif'] = "Approval 2 success";
		}elseif($type==3){
			$approval = "approval_3";
			$approval_by = "approval_3_by";
			$approval_date	= "approval_3_date";
			$approval_comment="approval_3_comment";
			$_SESSION['notif'] = "Approval 3 success";
		}elseif($type==4){
			$approval = "approval_4";
			$approval_by = "approval_4_by";
			$approval_date	= "approval_4_date";
			$approval_comment="approval_4_comment";	
			
			$status_item=1;
			$_SESSION['notif'] = "Approval 4 success";
			//$this->update_budget_log_status($id,$status_item);
			//$this->general_model->update_data('history_purchasing_tb',array('status'=>1),array('request_budget_id'=>$id));
		}elseif($type==5){
			$approval = "not_approval";
			$approval_by = "not_approval_by";
			$approval_date	= "not_approval_date";
			$approval_comment="not_approval_comment";	
		
		}
		
		$this->purchase_order_model->new_approve_request_stock($id,$approve_by,$approve_date,$approval,$approval_by,$approval_date,$approval_comment,$comment);
		
		

		echo json_encode(array('success'=>1),TRUE);
		
	//	redirect($_SERVER['HTTP_REFERER']);	
	}
	
	
	
}