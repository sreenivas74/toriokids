<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Budget extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE)redirect('login');
		$this->load->model('budget_model');
		$this->load->model('flexigrid_model');
		$this->load->model('admin_model');
		$this->load->model('general_model');
	
	}
	
	function index(){
		redirect('home');
	}
	
	function reimburse_list(){
		$this->data['page'] = 'budget/reimburse_list';
		$this->load->view('common/body', $this->data);
	}
	
	function flexi_reimburse_list(){

		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'name';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 15;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable		
		$selection="*";
		$where = " ";
		if ($query) $where .= " where $qtype LIKE '%$query%' ";
		$tname="request_budget_tb rb 
				left join project_tb p on p.id = rb.project_id ";
		
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("rb.id","$tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		
		$no=1;
		$no=$no+($rp*($page-1));
		if($result) foreach($result as $row){
			if ($rc) $json .= ",";
			
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			
			$json .= "'$no'";
			
			$json .= ",'<a href=\"".site_url('purchasing_payment/detail')."/".$row['id']."\" title=\"Purchasing Payment Detail\" >View</a>'";			
			
			$json .= ",'".esc($row['name'])."'";
			
			
			$json .= "]}";
			$rc = true;	
			$no++;	
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
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
		
		$this->data['payment_list'] = $this->budget_model->get_payment_list_periode($from,$to);
		$this->data['page'] = 'budget/payment_list';
		$this->load->view('common/body', $this->data);
	}
	
	function confirm_payment(){
		$request_payment_id = $this->input->post('request_payment_id');
		$from = $this->input->post('from');
		$to = $this->input->post('to');		
		if($request_payment_id)foreach($request_payment_id as $list){
			$status = $this->input->post('cek_'.$list);
			if($status==1){
				$this->budget_model->confirm_payment($list,$status);
				
				$updated_by = $this->session->userdata('employee_id');
				$this->budget_model->confirm_payment_by($list,$updated_by);	
				
				$payment_detail=$this->budget_model->get_budget_payment_detail($list);
				//pre($payment_detail);
				$request_budget_id=$payment_detail['request_budget_id'];
				$statuss=2;
				$this->update_budget_log_status($request_budget_id,$statuss);
			}
		}
		
		redirect('budget/payment_list/'.strtotime($from).'/'.strtotime($to));
	}
	
	function unconfirm_payment($request_payment_id){
		$status=0;
		$this->budget_model->confirm_payment($request_payment_id,$status);
		$updated_by = $this->session->userdata('employee_id');
		$this->budget_model->confirm_payment_by($request_payment_id,$updated_by);
		
			
	}
	
	function update_budget_log_status($request_budget_id,$status){
		$reimburse = find('reimburse',$request_budget_id,'request_budget_tb');
		if($reimburse!=1 ){
			$request_item = $this->budget_model->get_request_item_detail($request_budget_id);
			if($request_item)foreach($request_item as $list){
				$this->budget_model->update_budget_log_status($list['id'],$status);
			}
			
			
			//
			//$budget_log = $this->budget_model->get_request_budget_distinct($request_budget_id);
//			$data='';
//			if($budget_log)foreach($budget_log as $list){
//				if($data)$data.=",".$list['budget_id'];
//				else $data.=$list['budget_id'];
//			}
//			if($data){
//				$budget_log_list = $this->budget_model->get_budget_log_list($data);
//			} 
//			else{
//				$budget_log_list="";
//			}
//			
//			if($budget_log_list)foreach($budget_log_list as $list){
//				
//				$this->budget_model->update_budget_log_status($list['id'],$status);
//			}
		}
		
	}
	
	//stock list
	function all_list(){
		$this->data['page'] = 'budget/all_list';
		$this->load->view('common/body', $this->data);
	}
	
	function budget_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'name';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="b.*,e.firstname as efirstname,e.lastname as elastname";
		$where = "";
		if ($query) $where.= " where $qtype LIKE '%$query%' ";
		$tname="budget_tb b
				left join employee_tb e on b.updated_by = e.id";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("b.id"," $tname $where");
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
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/edit_budget","privilege_tb")){
				$json .= "'<a href=# style=text-decoration:none onclick=edit_budget(".$row['id'].")>edit</a> | <a href=".site_url('budget/budget_log/'.$row['id'])." style=text-decoration:none>log</a>'";
			}else{
				$json .= "'-'";
			}
			$json .= ",'".esc($row['name'])."'";
			
			//get payment
			$total_budget_payment = find_sum_budget2($row['id']);
			$json .= ",'".esc(number_format($total_budget_payment))." / <b>".esc(number_format($row['amount']))."</b>'";
			
			$json .= ",'".esc($row['month_start'])."/".esc($row['year_start'])."'";
			$json .= ",'".esc($row['month_end'])."/".esc($row['year_end'])."'";
			if($row['active']==1)$active = "active";
			else $active = "inactive";
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/edit_budget","privilege_tb")){
				$json .= ",'<a href=javascript:void(0) onclick=active_budget(".$row['id'].",".$row['active'].")>".$active."</a>'";
			}else{
				$json .= ",'".$active."'";
			}
			
			if(!$row['created_by']){
				$created_by = "superadmin";
			}else{
				$created_by = find('firstname',$row['created_by'],'employee_tb')." ".find('lastname',$row['created_by'],'employee_tb');	
			}
			if($row['created_date']!='0000-00-00 00:00:00'){
				$json .= ",'".date("d/m/Y",strtotime(esc($row['created_date'])))." - ".$created_by."'";
			}else $json .= ",''";
			
			if(!$row['updated_by']){
				$updated_by = "superadmin";
			}else{
				$updated_by = $row['efirstname']." ".$row['elastname'];	
			}
			if($row['updated_date']!='0000-00-00 00:00:00'){
				$json .= ",'".date("d/m/Y",strtotime(esc($row['updated_date'])))." - ".$updated_by."'";
			}else $json .= ",''";
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
	}
	
	function budget_log($budget_id){
		if($budget_id){
			$this->data['budget_name'] = find('name',$budget_id,'budget_tb');
 			$this->data['budget_log_list'] = $this->budget_model->budget_log_list($budget_id);
			$this->data['page'] = 'budget/budget_log';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function add_budget(){
		$name = $this->input->post('name');
		$month_start = $this->input->post('month_start');
		$year_start = $this->input->post('year_start');
		$month_end = $this->input->post('month_end');
		$year_end = $this->input->post('year_end');
		$amount = str_replace(",","",$this->input->post('amount'));
		$created_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userdata('employee_id');
		
		if(!$name || !$month_start || !$year_start || !$month_end || !$year_end || !$amount){
			$_SESSION['notif'] = 'Please insert all required data.';
			redirect($_SERVER['HTTP_REFERER']);	
		}else{
			$this->budget_model->add_budget($name,$month_start,$year_start,$month_end,$year_end,$amount,$created_date,$created_by);
			
			$_SESSION['notif'] = 'Budget has been added';
			redirect($_SERVER['HTTP_REFERER']);	
		}
	}
	
	function edit_budget(){
		$budget_id = $this->input->post('budget_id');
		$name = $this->input->post('name');
		$month_start = $this->input->post('month_start');
		$year_start = $this->input->post('year_start');
		$month_end = $this->input->post('month_end');
		$year_end = $this->input->post('year_end');
		$amount = str_replace(",","",$this->input->post('amount'));
		$updated_date = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('employee_id');
		
		
		if(!$name || !$month_start || !$year_start || !$month_end || !$year_end || !$amount){
			$_SESSION['notif'] = 'Please insert all required data.';
			redirect($_SERVER['HTTP_REFERER']);	
		}else{
			$this->budget_model->edit_budget($budget_id,$name,$month_start,$year_start,$month_end,$year_end,$amount,$updated_date,$updated_by);
			$_SESSION['notif'] = 'Budget has been updated';
			redirect($_SERVER['HTTP_REFERER']);	
		}
	}
	
	function get_detail_budget($id){
		$detail = $this->budget_model->get_budget_detail($id);
		echo $detail['name']."|".$detail['month_start']."|".$detail['year_start']."|".$detail['month_end']."|".$detail['year_end']."|".number_format($detail['amount']);	
	}
	
	function active_budget($id,$active){
		if($active)$active = 0;
		else $active = 1;
		$this->budget_model->active_budget($id,$active);
	}
	
	function add_request_budget($project_id=0){
		$this->data['project_id'] = $project_id;
		if($project_id!=0){
			$this->data['project_name'] = find('name',$project_id,'project_tb');
			$po_client_id = find_2('id','project_id',$project_id,'project_goal_po_client_tb');
			$this->data['po_client_item'] = $this->budget_model->get_po_client_item($po_client_id);
		}else $this->data['project_name'] = '';
		$this->data['vendor_list'] = $this->budget_model->get_vendor_list();
		$this->data['budget_list'] = $this->budget_model->get_in_range_budget();
		$this->data['page'] = 'budget/add_request_budget';
		$this->load->view('common/body', $this->data);
	}
	
	function do_request_budget(){

		$employee_id = esc($this->input->post('employee_id'));
		$project_id = esc($this->input->post('project_id'));
		$request_date = esc($this->input->post('request_date'));
		$bs = esc($this->input->post('bs'));
		$notes = esc($this->input->post('notes'));
	
		$subtotal = esc(str_replace(',','',$this->input->post('subtotal1')));
		$grand_total_after_ppn = esc(str_replace(',','',$this->input->post('grand_total_after_ppn')));
		$is_ppn=$this->input->post('ppn');
		$ppn=(($subtotal*10)/100);
	
		/*if($is_ppn==1){
		$total=$grand_total_after_ppn+$ppn;
		}else{
		$total=$grand_total_after_ppn;
		}*/
		
		$total=$grand_total_after_ppn;
		
		$reimburse = esc($this->input->post('reimburse'));
		
		$created_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userdata('employee_id');
		
		//request number
		$user_detail = $this->budget_model->get_user_detail($this->session->userdata('employee_id'));
		$number = find_number_request()+1;
		$month = date('m');
		$year = date('Y');
		
		//$prefix=SITENAME;
		/*if($this->session->userdata('admin_id')==1){
			$request_number = "RF/GSI/".date('m')."/ADM".$user_detail['id']."/".$number;
		}else{
			$request_number = "RF/".strtoupper($user_detail['alias']."/".date('m')."/".substr($user_detail['firstname'],0,1).substr($user_detail['lastname'],0,1).$user_detail['id']."/".$number);
		}*/
		
		$prefix=SITENAME;
		if($this->session->userdata('admin_id')==1){
			$request_number = "RF/".$prefix."/".date('m')."/ADM".$user_detail['id']."/".$number;
		}else{
			$request_number = "RF/".strtoupper($prefix."/".date('m')."/".substr($user_detail['firstname'],0,1).substr($user_detail['lastname'],0,1).$user_detail['id']."/".$number);
		}
		
		
		//insert request budget
		
		$this->budget_model->insert_request_budget2($project_id,$request_date,$bs,$notes,$total,$created_date,$created_by,$request_number,$month,$year,$number,$reimburse,$employee_id,$is_ppn,$subtotal);
		
		$request_budget_id = mysql_insert_id();
		
		$approve_by = $this->session->userdata('employee_id');
		$approve_date = date('Y-m-d H:i:s');
		
		//product
		$item_product_total = $this->input->post('item_product_total');
		for($i=1;$i<=$item_product_total;$i++){
			$budget_id = esc($this->input->post('item1_'.$i));
			$po_item_id = esc($this->input->post('poitem1_'.$i));
			$desc = esc($this->input->post('desc1_'.$i));
			$price = str_replace(",","",$this->input->post('price1_'.$i));
			$qty = str_replace(",","",$this->input->post('qty1_'.$i));
			$subtotal=str_replace(",","",$this->input->post('total1_'.$i));
			$totals = str_replace(",","",$this->input->post('total_after_ppn_'.$i));
			$vendor_name = esc($this->input->post('vendor1_'.$i));
			$bank_name = esc($this->input->post('bank_name1_'.$i));
			$acc_name = esc($this->input->post('acc_name1_'.$i));
			$acc_number = esc($this->input->post('acc_number1_'.$i));
			$discount=esc($this->input->post('disc1_'.$i));
			if($this->input->post('ppn_check_'.$i)){
				$ppn_check=1;
			}else{
				$ppn_check=0;
			}
			$grand_total_after_ppn=str_replace(",","",$this->input->post('total_after_ppn_'.$i));
			if($budget_id || $po_item_id){
				$this->budget_model->insert_request_budget_item2($request_budget_id,$budget_id,$po_item_id,$desc,$price,$vendor_name,$bank_name,$acc_name,$acc_number,$qty,$totals,$discount,$subtotal,$ppn_check);
				$request_budget_item_id = mysql_insert_id();
					
				if($reimburse!=1){
					//insert to log
					$this->budget_model->insert_budget_log($request_budget_item_id,$budget_id,$totals,$approve_by,$approve_date);
				}
				
				if($po_item_id!='0' && $po_item_id!=NULL){
				$database=array('request_budget_id'=>$request_budget_id,'stock_id'=>$po_item_id,'quantity'=>$qty,'unit_rate'=>$price,'discount'=>$discount,'description'=>$desc,'total'=>$totals,'project_id'=>$project_id,'status'=>0);
				$this->general_model->insert_data('history_purchasing_tb',$database);
				}
			}
			
		}
		
		$total3=esc(str_replace(',','',$this->input->post('total3')));
		
		if($bs){
			$bs_approver=$this->budget_model->get_bs_approver();
			if($bs_approver['bs_approver']>0){
				if($total<=300000){
					//if total less than 300k, go for final approval 
					$approval = "approval_4";
					$approval_by = "approval_4_by";
					$approval_date	= "approval_4_date";
					$approve_by = $bs_approver['bs_approver'];
					$approve_date = date('Y-m-d H:i:s');	
					$this->budget_model->approve_request_budget($request_budget_id,$approve_by,$approve_date,$approval,$approval_by,$approval_date);
					$this->general_model->update_data('history_purchasing_tb',array('status'=>1),array('request_budget_id'=>$request_budget_id));
					
				}
			}
		}
		
		if($project_id){
			$project_goal = find_2('id','project_id',$project_id,'project_goal_tb');
			if($project_goal){
				$_SESSION['notif'] = 'Request number #'.$request_number.' Added. Click <a href="'.site_url('project/detail_project_goal/'.$project_goal."#budget_tab_site").'">here</a> to back to project.';
			}else{
				$_SESSION['notif'] = 'Request number #'.$request_number.' Added.';
			}
		}else{
			$_SESSION['notif'] = 'Request number #'.$request_number.' Added.';
		}
		
		$this->send_email($request_budget_id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function do_edit_request_budget($request_budget_id){
		
		$employee_id = esc($this->input->post('employee_id'));
		$project_id = esc($this->input->post('project_id'));
		$request_date = esc($this->input->post('request_date'));
		$bs = esc($this->input->post('bs'));
		$reimburse = esc($this->input->post('reimburse'));
		$notes = esc($this->input->post('notes'));
		
		$is_ppn=$this->input->post('is_ppn');
		$subtotal = esc(str_replace(',','',$this->input->post('subtotal1')));
		$grand_total_after_ppn = esc(str_replace(',','',$this->input->post('grand_total_after_ppn')));
		$ppn=(($subtotal*10)/100);
	
		/*if($is_ppn==1){
			$grand_total=$grand_total_after_ppn+$ppn;
		}else{
			$grand_total=$grand_total_after_ppn;
		}*/
		$grand_total=$grand_total_after_ppn;
		
		
		$updated_date = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('employee_id');
		//save log if BS
		$budget_log_check = $this->input->post('budget_log_check');
		$request_detail = $this->budget_model->get_request_detail($request_budget_id);
		if($budget_log_check==1){
			//save log
			$request_detail = $this->budget_model->get_request_detail($request_budget_id);
			$request_item = $this->budget_model->get_request_item_detail($request_budget_id);
			
			$data_1 = json_encode($request_detail,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
			$data_2 = json_encode($request_item,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
			$created_date = date('Y-m-d H:i:s');
			$created_by = $this->session->userdata('employee_id');
			$this->budget_model->save_rf_log($request_budget_id,$data_1,$data_2,$request_detail['total'],$created_by,$created_date);
		}
		
		//insert request budget
		$this->budget_model->update_request_budget($request_budget_id,$project_id,$request_date,$bs,$notes,$grand_total,$updated_date,$updated_by,$employee_id,$reimburse,$is_ppn);
		
		
		//die(pre($_POST));
		
		$current_total=$this->input->post('current_total');
		if($employee_id!=0){
			if($bs==0){
			//kalau bukan bs dan totalny berubah set approval lagi dari awal
			if($current_total!=$grand_total){
				$this->budget_model->set_approval_to_zero($request_budget_id);
			}
		}
		else{	
			//kalau bs dan totalny diatas 300000 set approval lagi dari awal
			//set approval to 0
			
				if($grand_total>300000){
					if($current_total!=$grand_total){		
						$this->budget_model->set_approval_to_zero($request_budget_id);
					}
				}
			
		}
		}
		
		//product
		$item_product_total = $this->input->post('item_product_total');
		for($i=1;$i<=$item_product_total;$i++){
			$request_budget_item_id = esc($this->input->post('request_budget_item_id1_'.$i));
			$budget_id = esc($this->input->post('item1_'.$i));
			$po_item_id = esc($this->input->post('poitem1_'.$i));
			$desc = esc($this->input->post('desc1_'.$i));
			$qty = str_replace(",","",$this->input->post('qty1_'.$i));
			$price = str_replace(",","",$this->input->post('price1_'.$i));
			$subtotal=str_replace(",","",$this->input->post('total1_'.$i));
			$total = str_replace(",","",$this->input->post('total_after_ppn_'.$i));
			$vendor_name = esc($this->input->post('vendor1_'.$i));
			$bank_name = esc($this->input->post('bank_name1_'.$i));
			$acc_name = esc($this->input->post('acc_name1_'.$i));
			$acc_number = esc($this->input->post('acc_number1_'.$i));
			$discount=esc($this->input->post('disc1_'.$i));
			if($this->input->post('ppn_check_'.$i)){
				$ppn_check=1;
			}else{
				$ppn_check=0;
			}
			
			if($budget_id || $po_item_id){
				if($request_budget_item_id){
					$this->budget_model->update_request_budget_item2($request_budget_item_id,$budget_id,$po_item_id,$desc,$price,$vendor_name,$bank_name,$acc_name,$acc_number,$qty,$total,$discount,$subtotal,$ppn_check);
					
					//remove budget log if exists
					$this->budget_model->remove_budget_log_by_item_id($request_budget_item_id);
					if($request_detail['reimburse']!=1){
						//insert to log
				$this->budget_model->insert_budget_log($request_budget_item_id,$budget_id,$grand_total,$updated_by,$updated_date);
			}
					
				}else{// add new
					$this->budget_model->insert_request_budget_item2($request_budget_id,$budget_id,$po_item_id,$desc,$price,$vendor_name,$bank_name,$acc_name,$acc_number,$qty,$total,$discount,$subtotal,$ppn_check)
					
					
					;if($request_detail['reimburse']!=1){
						//insert to log
				$this->budget_model->insert_budget_log($request_budget_item_id,$budget_id,$grand_total,$updated_by,$updated_date);
			}
				}
			}elseif($request_budget_item_id){ // remove item
				$this->budget_model->remove_request_budget_item($request_budget_item_id);
				if($request_detail['reimburse']!=1){
						//insert to log
				$this->budget_model->insert_budget_log($request_budget_item_id,$budget_id,$grand_total,$updated_by,$updated_date);
			}
				//remove budget log if exists
				$this->budget_model->remove_budget_log_by_item_id($request_budget_item_id);
			}
		}
		
		
		
		$_SESSION['notif'] = 'Request budget updated.';
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function request_budget_list($status=0,$fullpayment='a',$final_approval='a',$not_approve='a'){
	
		$this->data['status']=$status;
		$this->data['fullpayment']=$fullpayment;
		$this->data['final_approval']=$final_approval;
		$this->data['not_approve']=$not_approve;
		$this->data['page'] = 'budget/request_list';
		$this->load->view('common/body', $this->data);
	}
	
	function request_flexi(){
		$fullpayment=$this->uri->segment(3);
		$final_approval=$this->uri->segment(4);
		$not_approval=$this->uri->segment(5);
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
		$selection="rb.*, p.name as pname,p.id as pid, 
		(
			SELECT SUM( amount ) AS total 
			FROM request_budget_payment_tb 
			WHERE request_budget_id = rb.id 
		) as total_paid ,
		rb.total - (
						(	
							SELECT SUM( amount ) AS total 
							FROM request_budget_payment_tb 
							WHERE request_budget_id = rb.id and pay_type=0
						) 
						-
						(	
							SELECT SUM( amount ) AS total 
							FROM request_budget_payment_tb 
							WHERE request_budget_id = rb.id and pay_type=1
						)  
					)  as outstanding ";
					
		
		$where = "  ";
		
		if($fullpayment==1){
			if($final_approval==1){
				$where.=" where rb.paid=1 AND rb.approval_4_date !='0000-00-00 00:00:00'";
			}elseif($final_approval==2){
				$where.=" where rb.paid=1 AND rb.approval_4_date ='0000-00-00 00:00:00'";
			}else{
				$where.=" where rb.paid=1 ";
			}
			
		}elseif($fullpayment==2) {
			if($final_approval==1){
				$where.=" where rb.paid=0 AND rb.approval_4_date !='0000-00-00 00:00:00'";
			}elseif($final_approval==2){
				$where.=" where rb.paid=0 AND rb.approval_4_date ='0000-00-00 00:00:00'";
			}else{
			$where.=" where rb.paid=0 ";
			}
		}else{
			
			if($final_approval==1){
				$where.=" where rb.approval_4_date !='0000-00-00 00:00:00'";
			}elseif($final_approval==2){
				$where.=" where rb.approval_4_date ='0000-00-00 00:00:00'";
			}else{
			$where.=" where rb.id!='' ";
			}
		}
		
		if($not_approval==2) $where.= ' AND rb.not_approval=1 ';
		else if($not_approval==1) $where.= ' AND rb.not_approval=0 ';
		
		
		
		if ($query) $where.= " and $qtype LIKE '%$query%' ";
		
		
		
		$tname="request_budget_tb rb
				left join project_tb p on rb.project_id = p.id";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("rb.id"," $tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;//pre($result);
		if($result) foreach($result as $row){

			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			
			if($row['pid']!=0){
			$goal = find('sales_stage',$row['pid'],'project_tb');
			}else $goal = 0;
			//if($goal==4){
			//	$goal_id = find_2('id','project_id',$row['pid'],'project_goal_tb');
			//	$json .= "'<a href=".site_url('project/detail_project_goal/'.$goal_id)."#budget_tab_site>detail</a>'";
			//}else{
				$json .= "'<a href=".site_url('budget/detail/'.$row['id'])." target=\"_blank\">detail</a>'";
			//}
			
			$json .= ",'".esc($row['request_number'])."'";
			$json .= ",'".esc($row['pname'])."'";
			
			if($row['bs']==1)
			$json .= ",'&#x2713;'";
			else
			$json .= ",''";
			
			
			if($row['reimburse']==1)
			$json .= ",'&#x2713;'";
			else
			$json .= ",''";
			
			$json .= ",'".esc(number_format($row['total']))."'";
			
			//outstanding
			//if($row['total_paid']>0)
//			$json .= ",'".esc(number_format($row['outstanding']))."'";
//			else
//			$json .= ",'".esc(number_format($row['total']))."'";
			
			
			
			//outstanding
			$outstanding=get_rf_outstanding($row['id']);
			$json .= ",'".esc(number_format($row['total']-$outstanding))."'";
			//$json .= ",'".esc(number_format($row['outstanding']))."'";
			
			$json .= ",'".esc(date('d F Y',strtotime($row['request_date'])))."'";
			
			if($row['approval_4']==1){
				$approved_date = date('d F Y',strtotime($row['approval_4_date']));
				if($row['approval_4_by']==0)$approved_by = 'admin';
				else $approved_by = find('firstname',$row['approval_4_by'],'employee_tb')." ".find('lastname',$row['approval_4_by'],'employee_tb');
				$json .= ",'".$approved_date."<br />".$approved_by."'";
			}else{
				$json .= ",'-'";
			}
			
			if($row['paid']==1){
				/*$paid_date = date('d F Y',strtotime($row['paid_date']));
				if($row['paid_by']==0)$paid_by = 'admin';
				else $paid_by = find('firstname',$row['paid_by'],'employee_tb')." ".find('lastname',$row['paid_by'],'employee_tb');*/
				//$json .= ",'".$paid_date."<br />".$paid_by."'";
				
				$json .= ",'";
				
				$payment_list=$this->budget_model->get_payment_list($row['id']);
				if($payment_list)foreach($payment_list as $rows){
					$json .= date('d F Y',strtotime($rows['pay_date']))."<br>";
				}
				
				
				$json .= "'";
			}else{
				$json .= ",'-'";
			}
			
			$created_date = date('d F Y',strtotime($row['created_date']));
			if($row['created_by']==0)$created_by = 'admin';
			else $created_by = find('firstname',$row['created_by'],'employee_tb')." ".find('lastname',$row['created_by'],'employee_tb');
			$json .= ",'".$created_date."<br />".$created_by."'";
			/*
			if($row['updated_date']!='0000-00-00'){
				$updated_date = date('d F Y',strtotime($row['updated_date']));
				if($row['created_by']==0)$updated_by = 'admin';
				else $updated_by = find('firstname',$row['updated_by'],'employee_tb')." ".find('lastname',$row['updated_by'],'employee_tb');
				$json .= ",'".$updated_date."<br />".$updated_by."'";
			}else{
				$json .= ",'-'";
			}*/
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	function detail($id){
		
		$this->data['request_detail'] = $request_detail = $this->budget_model->get_request_detail($id);
		$this->data['request_item'] = $this->budget_model->get_request_item_detail($id);
		$this->data['vendor_list'] = $this->budget_model->get_vendor_list();
		$this->data['request_log'] = $this->budget_model->get_request_log($id);
		
		$this->data['bank_list'] = $this->budget_model->get_bank_list();
		$this->data['payment_list'] = $this->budget_model->get_payment_list($id);
		
		//project goal
		$goal = 0;$request_budget='';$this->data['po_client_item']='';
		if($request_detail['project_id']!=0){
			$goal = find('sales_stage',$request_detail['project_id'],'project_tb');
			$this->data['budget_log_2'] = $budget_log_2 = $this->budget_model->get_request_budget_distinct_2($id);
			$data='';
			if($budget_log_2)foreach($budget_log_2 as $list){
				if($data)$data.=",".$list['project_goal_po_client_item_id'];
				else $data.=$list['project_goal_po_client_item_id'];
			}
			if($data){
				$this->data['budget_log_list_2'] = $this->budget_model->get_budget_log_list_2($data);
			}else{
				$this->data['budget_log_list_2'] = '';	
			}
			
			//po stock n nonstock
			$this->load->model('project_model');
			$project_id = $request_detail['project_id'];
			$this->data['po_client'] = $po_client = $this->project_model->get_project_po_client($request_detail['project_id']);
			$this->data['po_client_item'] = $this->project_model->get_project_po_client_item($po_client['id']);
			
			//project po non stock (multiple data)
			$this->data['po_request_non_stock'] = $po_request_non_stock = $this->project_model->get_project_po_request_non_stock($project_id);
			if($po_request_non_stock){
				$data = "(";
				$no = 1;
				foreach($po_request_non_stock as $list){
					if($no==1)$data.=$list['id'];
					else $data.=",".$list['id'];
					$no++;
				}
				$data.=')';
				$this->data['po_request_non_stock_item'] = $this->project_model->get_project_po_request_non_stock_item($data);
			}else $this->data['po_request_non_stock_item']='';
			
			
			
			
			//project po stock
			$this->data['request_budget'] = $request_budget = $this->project_model->get_project_request_budget_outstanding($project_id);
			
			//project po stock
			$this->data['po_request_stock'] = $po_request_stock = $this->project_model->get_project_po_request_stock($project_id);
			if($po_request_stock){
				$data = "(";
				$no = 1;
				foreach($po_request_stock as $list){
					if($no==1)$data.=$list['id'];
					else $data.=",".$list['id'];
					$no++;
				}
				$data.=')';
				$this->data['po_request_stock_item'] = $this->project_model->get_project_po_request_stock_item($data);
			}else $this->data['po_request_stock_item']='';
			
		}else{
			$this->data['budget_log_2'] = '';	
			$this->data['budget_log_list_2'] = '';	
		}
		
		//budget
		$this->data['budget_log'] = $budget_log = $this->budget_model->get_request_budget_distinct($id);
		$data='';
		if($budget_log)foreach($budget_log as $list){
			if($data)$data.=",".$list['budget_id'];
			else $data.=$list['budget_id'];
		}
		if($data){
			$this->data['budget_log_list'] = $this->budget_model->get_budget_log_list($data);
		}else{
			$this->data['budget_log_list'] = '';	
		}
		
		
		if($request_budget){
			$data = "(";
			$no = 1;
			foreach($request_budget as $list){
				if($no==1)$data.=$list['id'];
				else $data.=",".$list['id'];
				$no++;
			}
			$data.=')';
			$this->data['request_budget_item'] = $this->project_model->get_project_request_budget_item($data);
		}else $this->data['request_budget_item']='';
		
		
		$this->data['page'] = 'budget/detail';
		$this->load->view('common/body', $this->data);
	}
	
	function approve_request_budget(){
		
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
		}elseif($type==2){
			$approval = "approval_2";
			$approval_by = "approval_2_by";
			$approval_date	= "approval_2_date";
			$approval_comment="approval_2_comment";
		}elseif($type==3){
			$approval = "approval_3";
			$approval_by = "approval_3_by";
			$approval_date	= "approval_3_date";
			$approval_comment="approval_3_comment";
		}elseif($type==4){
			$approval = "approval_4";
			$approval_by = "approval_4_by";
			$approval_date	= "approval_4_date";
			$approval_comment="approval_4_comment";	
	
			
			//$request_item = $this->budget_model->get_request_item_detail($id);
//			$status_item=1;//approved
//			if($request_item)foreach($request_item as $list){
//				$this->budget_model->update_budget_log_status($list['id'],$status_item);
//			}
			
			$status_item=1;
			$this->update_budget_log_status($id,$status_item);
			$this->general_model->update_data('history_purchasing_tb',array('status'=>1),array('request_budget_id'=>$id));
		}elseif($type==5){
			$approval = "not_approval";
			$approval_by = "not_approval_by";
			$approval_date	= "not_approval_date";
			$approval_comment="not_approval_comment";	
		
		}
		
		$this->budget_model->new_approve_request_budget($id,$approve_by,$approve_date,$approval,$approval_by,$approval_date,$approval_comment,$comment);
		
		
		////cek reimbuse
//		$reimburse = find('reimburse',$id,'request_budget_tb');
//		if($reimburse!=1 && $type==4){
//			//insert to log
//			$request_item = $this->budget_model->get_request_item_detail($id);
//			if($request_item)foreach($request_item as $list){
//				$this->budget_model->insert_budget_log($list['id'],$list['budget_id'],$list['total'],$approve_by,$approve_date);
//			}
//		}
// pindah ke doadd request budget

		

		echo json_encode(array('success'=>1),TRUE);
		
	//	redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function add_request_payment($id){
		$paid_by = $this->session->userdata('employee_id');
		$paid_date = date('Y-m-d H:i:s');	

		$transfer_to='';
		$bank_id = esc($this->input->post('bank_id'));
		$amount = str_replace(",","",esc($this->input->post('amount')));
		$pay_date = esc($this->input->post('pay_date'));
		$pay_type = esc($this->input->post('pay_type'));
		$method = esc($this->input->post('method'));
		
		$approved_by=esc($this->input->post('approved_by'));;
		$request_budget_item_id = $this->input->post('request_budget_item_id');
		if($request_budget_item_id!=''){
			$bank_name=find('bank_name',$request_budget_item_id,'request_budget_item_tb');
			$acc_name=find('acc_name',$request_budget_item_id,'request_budget_item_tb');
			$acc_number=find('acc_number',$request_budget_item_id,'request_budget_item_tb');
			$transfer_to=$bank_name . ' ' . $acc_name . ' ' . $acc_number;
		}else{
			$no=1;
			$listitem=$this->input->post('listitem');
			if($listitem)foreach($listitem as $list){
				$bank_name=find('bank_name',$list,'request_budget_item_tb');
				$acc_name=find('acc_name',$list,'request_budget_item_tb');
				$acc_number=find('acc_number',$list,'request_budget_item_tb');
				
				if($no==1){
					$transfer_to.= $bank_name . ' ' . $acc_name . ' ' . $acc_number;
				}else{
					$transfer_to.= ' | ' . $bank_name . ' ' . $acc_name . ' ' . $acc_number;
				}
				$no++;
			}
		}
		if($amount){
			$this->budget_model->add_request_payment2($id,$bank_id,$amount,$pay_date,$paid_by,$paid_date,$pay_type,$method,$request_budget_item_id,$transfer_to,$approved_by);
			$payment_id=mysql_insert_id();
			
			if($method==1){
				$status=1;
				$this->budget_model->confirm_payment($payment_id,$status);	
				
				$rf_payment_cash_confirm=$this->budget_model->get_cash_payment_approver();
				if($rf_payment_cash_confirm['cash_payment_approver']>0){
					$this->budget_model->confirm_payment_by($payment_id,$rf_payment_cash_confirm['cash_payment_approver']);
				}
			}
		}
		$this->budget_model->update_request_budget_paid($id,$paid_by,$paid_date);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function get_edit_request($request_id){
		$this->data['vendor_list'] = $this->budget_model->get_vendor_list();
		$this->data['request_detail'] = $request_detail = $this->budget_model->get_request_detail($request_id);
		
		$win = find('sales_stage',$request_detail['project_id'],'project_tb');
		if($win==4){
			$po_client_id = find_2('id','project_id',$request_detail['project_id'],'project_goal_po_client_tb');
			$this->data['po_client_item'] = $this->budget_model->get_po_client_item($po_client_id);
			$this->data['budget_list'] = '';
		}else{
			$this->data['budget_list'] = $this->budget_model->get_in_range_budget();	
			$this->data['po_client_item'] = '';
		}
		
		$this->data['request_item'] = $this->budget_model->get_request_item_detail($request_id);

		
		$content = $this->load->view('budget/edit_request_budget',$this->data);
		echo $content;	
	}
	
	function cek_project_win($project_id){
		$win = find('sales_stage',$project_id,'project_tb');
		$this->data['vendor_list'] = $this->budget_model->get_vendor_list();
		if($win==4){
			//find po client item
			$po_client_id = find_2('id','project_id',$project_id,'project_goal_po_client_tb');
			$this->data['po_client_item'] = $this->budget_model->get_po_client_item($po_client_id);
			$content = $this->load->view('budget/get_po_client_item',$this->data,TRUE);
			//echo "1??".$content;
			
			echo json_encode(array('status'=>1,'content'=>$content));
			
		}else{
			$this->data['budget_list'] = $this->budget_model->get_in_range_budget();
			$content = $this->load->view('budget/get_budget_item',$this->data,TRUE);
			//echo "2??".$content;	
			echo json_encode(array('status'=>2,'content'=>$content));
		}
	}
	
	function cek_edit_project_win($project_id,$request_id){
		$this->data['request_detail'] = $request_detail = $this->budget_model->get_request_detail($request_id);
		$this->data['request_item'] = $this->budget_model->get_request_item_detail($request_id);
		$this->data['budget_list'] = $this->budget_model->get_in_range_budget();
		
		$win = find('sales_stage',$project_id,'project_tb');
		if($win==4){
			//find po client item
			$po_client_id = find_2('id','project_id',$project_id,'project_goal_po_client_tb');
			$this->data['po_client_item'] = $this->budget_model->get_po_client_item($po_client_id);
			$content = $this->load->view('budget/get_edit_po_client_item',$this->data);
			echo "1|".$content;
		}else{
			$content = $this->load->view('budget/get_edit_budget_item',$this->data);
			echo "2|".$content;	
		}
	}
	
	function remove_payment($payment_id){
		if($payment_id){
			$this->budget_model->remove_payment($payment_id);	
		}
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function update_payment($payment_id){
		if($payment_id){
			$paid_by = $this->session->userdata('employee_id');
			$paid_date = date('Y-m-d H:i:s');
			
			
			$request_budget_id = esc($this->input->post('request_budget_id'));
			$request_budget_item_id = esc($this->input->post('request_budget_item_id'));
			$bank_id = esc($this->input->post('bank_id'));
			$amount = str_replace(",","",esc($this->input->post('amount')));
			$pay_date = esc($this->input->post('pay_date'));
			$pay_type = esc($this->input->post('pay_type'));
			$method = esc($this->input->post('method'));
			
			if($amount){
				$this->budget_model->edit_request_payment($payment_id,$bank_id,$amount,$pay_date,$paid_by,$paid_date,$pay_type,$method,$request_budget_item_id);
				$this->budget_model->update_request_budget_paid($request_budget_id,$paid_by,$paid_date);
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_rf($id){
		$this->budget_model->delete_rf($id);
		$this->budget_model->delete_request_log($id);
		$this->budget_model->remove_all_payment($id);
		$request_item = $this->budget_model->get_request_item_detail($id);
		if($request_item)foreach($request_item as $list){
			$this->budget_model->remove_request_budget_item($list['id']);
			//remove budget log if exists
			$this->budget_model->remove_budget_log_by_item_id($list['id']);	
			
		}
		
		$_SESSION['notif'] = "Request fund deleted.";
		
		redirect('budget/request_budget_list');	
	}
	
	function print_rf($id){
		$this->load->model("admin_model");
		$this->data['print_by'] =  $this->admin_model->show_administrator_employee_by_id($this->session->userdata('employee_id'));
		$this->data['request_detail'] = $this->budget_model->get_request_detail($id);
		//pre($this->data['request_detail']);
		$this->data['request_item'] = $this->budget_model->get_request_item_detail($id);
		
		$content = $this->load->view('budget/rf_pdf',$this->data,TRUE);

		require_once(APPPATH.'libraries/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','fr');
		$html2pdf->WriteHTML($content);
		$html2pdf->Output('RF.pdf');	
	}
	
	function payment_table(){
		$from=$this->input->post('from');
		$to=$this->input->post('to');
		$status=$this->input->post('status');
		$project_name=$this->input->post('project_name');
		$project_id=$this->input->post('project_id');
		
		
		
		$this->data['status']=$status;
		$this->data['from']=$from;
		$this->data['to']=$to;
		$this->data['project_id']=$project_id;
		$this->data['project_name']=$project_name;
		$this->data['page'] = 'budget/payment_table';
		$this->load->view('common/body', $this->data);
	}
	
	function payment_table_flexi($project_id='',$status='0',$from='',$to=''){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'pay_date';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection=" rbp.*, rb.request_number, b.name as bname,b.id as bid, p.name as pname";
		$where = " where pay_date >= '".esc($from)."' and pay_date <= '".esc($to)."' and p.id='".esc($project_id)."' and rbp.status='".esc($status)."'";
		
		
		
		if ($query) $where.= " and $qtype LIKE '%$query%' ";
				
		$tname="request_budget_payment_tb rbp 
				join request_budget_tb rb on rb.id=rbp.request_budget_id
				left join project_tb p on p.id=rb.project_id
				left join bank_tb b on b.id = rbp.bank_id";
				
				
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("rbp.id"," $tname $where");
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
			
			
			$json .= "'<a href=".site_url('budget/detail/'.$row['id'])." target=\"_blank\">detail</a>'";
		
			
			$json .= ",'".esc($row['request_number'])."'";
			
			$json .= ",'".esc($row['pname'])."'";
			$json .= ",'".esc($row['bname'])."'";
			
			if($row['method']==1)
			$json .= ",'Cash'";
			else
			$json .= ",'Transfer'";
			
			if($row['pay_type']==1)
			$json .= ",'Received'";
			else
			$json .= ",'Payment'";
			
			
			if($row['request_budget_item_id']==0)
				$json .= ",'All'";

			else{
				$budget_id = find('budget_id',$row['request_budget_item_id'],'request_budget_item_tb');
				$project_goal_po_client_item_id = find('project_goal_po_client_item_id',$row['request_budget_item_id'],'request_budget_item_tb');	
				if($budget_id!=0)
					$json .= ",'".esc(find('name',$budget_id,'budget_tb'))."'";
				else if($project_goal_po_client_item_id!=0)
					$json .= ",'".esc(find('item',$project_goal_po_client_item_id,'project_goal_po_client_item_tb'))."'";
			}
			
			$json .= ",'".number_format($row['amount'])."'";
			
			
			
			
			if($row['status']==1)
			$json .= ",'Done - ". date('d F Y',strtotime($row['done_date']))."'";
			else
			$json .= ",'Not Done'";
			
			$json .= ",'".date('d F Y',strtotime($row['pay_date']))."'";
			$json .= ",'".date('d F Y',strtotime($row['created_date']))."'";
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	function po_non_stock_flexi(){
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
		$selection="pgp.*, p.name as pname,p.id as pid, pg.id as pg_id";
		/*
		$selection="pgp.*, p.name as pname,p.id as pid, pg.id as pg_id, 
		 
		(
			SELECT SUM( amount ) AS total 
			FROM project_goal_po_payment_tb  
			WHERE project_goal_po_id = pgp.id 
		) as total_paid , 
		pgp.total - (
						SELECT SUM( amount ) AS total 
						FROM project_goal_po_payment_tb  
						WHERE project_goal_po_id = pgp.id 
					)  as outstanding 
		";*/
		$where = "";
		if ($query) $where.= " where $qtype LIKE '%$query%' ";
		$tname="project_goal_po_tb pgp
				left join project_goal_tb pg on pg.project_id=pgp.project_id
				left join project_tb p on pgp.project_id = p.id";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("pgp.id"," $tname $where");
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
			
			if($row['pid']!=0){
			$goal = find('sales_stage',$row['pid'],'project_tb');
			}else $goal = 0;
			//if($goal==4){
			//	$goal_id = find_2('id','project_id',$row['pid'],'project_goal_tb');
			//	$json .= "'<a href=".site_url('project/detail_project_goal/'.$goal_id)."#budget_tab_site>detail</a>'";
			//}else{
				
				
				$json .= "'<a href=".site_url('budget/po_non_stock_detail/'.$row['id']).">detail</a>'";
			//}
			
			$json .= ",'".esc($row['po_number'])."'";
			$json .= ",'".esc($row['pname'])."'";
			
			$json .= ",'".esc(number_format($row['total']))."'";
			//outstanding
			/*if($row['total_paid']>0)
			$json .= ",'".esc(number_format($row['outstanding']))."'";
			else
			$json .= ",'".esc(number_format($row['total']))."'";*/
			
			$json .= ",'".esc(date('d F Y',strtotime($row['po_date'])))."'";
			
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
			
			if($row['updated_date']!='0000-00-00'){
				$updated_date = date('d F Y',strtotime($row['updated_date']));
				if($row['created_by']==0)$updated_by = 'admin';
				else $updated_by = find('firstname',$row['updated_by'],'employee_tb')." ".find('lastname',$row['updated_by'],'employee_tb');
				$json .= ",'".$updated_date."<br />".$updated_by."'";
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
	
	function po_non_stock_detail($project_id){
		$this->load->model('project_model');
		$this->data['crm'] = $crm=$this->project_model->show_crm_by_id($project_id);
		//echo $project_ids = find('project_id',$project_id,'project_goal_tb');
		$this->data['detail']=$detail=$this->project_model->get_po_non_stock_detail2($project_id);
		
		
		$this->data['bank_list'] = $this->budget_model->get_bank_list();
		$this->data['payment_list'] = $this->budget_model->get_po_non_stock_payment($project_id);
		if(!$detail)redirect('budget/request_budget_list/1');
		
		$this->data['po_request_non_stock_item'] = $this->project_model->get_project_po_request_non_stock_item2($detail['id']);
		$this->data['page'] = 'budget/po_non_stock_detail';
		$this->load->view('common/body', $this->data);
	}
	
	
	
	function add_po_non_stock_payment($id){
		$paid_by = $this->session->userdata('employee_id');
		$paid_date = date('Y-m-d H:i:s');	
		
		$bank_id = esc($this->input->post('bank_id'));
		$amount = str_replace(",","",esc($this->input->post('amount')));
		$pay_date = esc($this->input->post('pay_date'));
		$pay_type = esc($this->input->post('pay_type'));
		$method = esc($this->input->post('method'));
		
		//$request_budget_item_id = $this->input->post('request_budget_item_id');
		
		if($amount){
			$this->budget_model->add_po_non_stock_payment($id,$bank_id,$amount,$pay_date,$paid_by,$paid_date,$pay_type,$method);
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function update_po_non_stock_payment($payment_id){
		
		if($payment_id){
			$paid_by = $this->session->userdata('employee_id');
			$paid_date = date('Y-m-d H:i:s');
			
			
			$project_goal_po_id = esc($this->input->post('project_goal_po_id'));
			$bank_id = esc($this->input->post('bank_id'));
			$amount = str_replace(",","",esc($this->input->post('amount')));
			$pay_date = esc($this->input->post('pay_date'));
			$pay_type = esc($this->input->post('pay_type'));
			$method = esc($this->input->post('method'));
			
			if($amount){
				$this->budget_model->update_po_non_stock_payment($payment_id,$bank_id,$amount,$pay_date,$paid_by,$paid_date,$pay_type,$method,$project_goal_po_id);
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function remove_po_non_stock_payment($id){
		$this->budget_model->remove_po_non_stock_payment($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	function send_email($budget_id){
		$this->load->model('project_model');
		
	

			$this->data['budget_id']=$budget_id;
			$this->data['request_detail'] = $request_detail = $this->budget_model->get_request_detail($budget_id);
			$this->data['request_item'] = $this->budget_model->get_request_item_detail($budget_id);
					$project_id = $request_detail['project_id'];
			$email_username=$this->budget_model->get_request_budget_approver();
			$this->data['email']=$email=NULL;
			//budget
			$this->data['budget_log'] = $budget_log = $this->budget_model->get_request_budget_distinct($budget_id);
			$data='';
			if($budget_log)foreach($budget_log as $list){
				if($data)$data.=",".$list['budget_id'];
				else $data.=$list['budget_id'];
			}
			if($data){
				$this->data['budget_log_list'] = $this->budget_model->get_budget_log_list($data);
			}else{
				$this->data['budget_log_list'] = '';	
			}
			
			$this->load->model('project_model');
			$project_id = $request_detail['project_id'];
		$this->data['request_budget'] = $request_budget = $this->project_model->get_project_request_budget_outstanding($project_id);
			if($request_budget){
				$data = "(";
				$no = 1;
				foreach($request_budget as $list){
					if($no==1)$data.=$list['id'];
					else $data.=",".$list['id'];
					$no++;
				}
				$data.=')';
				$this->data['request_budget_item'] = $this->project_model->get_project_request_budget_item($data);
			}else $this->data['request_budget_item']='';
			
			//po stock n nonstock
			
			
			$this->data['po_client'] = $po_client = $this->project_model->get_project_po_client($request_detail['project_id']);
			$this->data['po_client_item'] = $this->project_model->get_project_po_client_item($po_client['id']);
			
			
			if($email_username)foreach($email_username as $list3){
				$this->data['email']=$email=base64_encode(find_2('username','employee_id',$list3['admin_id'],'administrator_tb'));
				$email_normal=find_2('username','employee_id',$list3['admin_id'],'administrator_tb');
				$isi=$this->load->view('budget/email/sent_to',$this->data,TRUE);

				$this->load->library('email'); 	
				$this->email->from('GSI Indonesia');
				$this->email->to($email_normal); 
				$this->email->subject('Request Budget Notification');
				$this->email->message($isi); 
				$this->email->send();
				$this->email->clear();	
			}
	}
	
	function lock_budget(){
		$this->load->model('general_model');
		$lock=$this->input->post('lock');
		$id=$this->input->post('id');
		$database=array('is_lock'=>$lock);
		$where=array('id'=>$id);
		$this->general_model->update_data('request_budget_tb',$database,$where);
	
	}
	
	
	function unconfirm_paymet($id){
		
				$this->budget_model->confirm_payment($id,0);
				
				$updated_by = $this->session->userdata('employee_id');
				$database=array('undone_by'=>$updated_by);
				$where=array('id'=>$id);
				$this->general_model->update_data('request_budget_payment_tb',$database,$where);
				$payment_detail=$this->budget_model->get_budget_payment_detail($id);
				//pre($payment_detail);
				$request_budget_id=$payment_detail['request_budget_id'];
				$statuss=0;
				$this->update_budget_log_status($request_budget_id,$statuss);
		redirect($_SERVER['HTTP_REFERER']);
	
	}
		
	
	
	
}