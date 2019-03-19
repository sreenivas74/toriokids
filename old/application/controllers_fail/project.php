<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Project extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->library('excel_reader');
		$this->load->library('PHPExcel');
		$this->load->model('project_model');
		$this->load->model('budget_model');
		$this->load->model('report_model');
		$this->load->model('flexigrid_model');
		$this->load->model('rak_model');
		$this->load->model('warehouse_model');
		$this->load->model('general_model');
		$this->load->model('department_model');
	}
	
	function index(){
		redirect('home');
	}
	
	function upload($config,$file){
		$this->load->library('upload');
		$this->upload->initialize($config);
		if($this->upload->do_upload($file))
		return true;
		return false;
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//CRM//
	////////////
	function list_crm($year=NULL,$sales_stage=NULL){
		$this->data['year']=$year;
		$this->data['sales_stage']=$sales_stage;
		
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_crm","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_crm_2","privilege_tb")){
			$this->data['project_team_list'] = $this->project_model->show_team_list();
			$this->data['page'] = 'project/list_crm';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
	}
	
	function crm_flexi(){
		$year=$this->uri->segment(3);
		$sales_stage=$this->uri->segment(4);
		
		
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'p.status,p.name';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*,p.id as p_id, p.name as p_name, c.name as c_name, i.name as i_name,p.status as p_status";
		
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_crm","privilege_tb")){
			if($sales_stage=='a'){
				$where = "where sales_stage != 4 ";
			}else{
				$where = "where sales_stage = '".esc($sales_stage)."' ";
			}
			
			if($year!='a'){
				$where .= "and year(p.quotation_date)='".esc($year)."' ";
			}
			if ($query) $where .= "and $qtype LIKE '%$query%' ";
			
		}else if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_crm_2","privilege_tb")){
			
			if($sales_stage=='a'){
					
					$where = "where 
					( 
						p.employee_id = '".$this->session->userdata('employee_id')."' or
						p.employee_id in 
						( 
							select b.id from employee_group_tb a 
							left join employee_tb b on a.employee_id=b.id 
							where a.leader_id='".esc($this->session->userdata('employee_id'))."' 
						) 
					) 
					and sales_stage != 4";
					
					if($year!='a'){
						$where .= "and year(p.quotation_date)='".esc($year)."' ";
					}
			}else{
			
			
					$where = "where 
					( 
						p.employee_id = '".$this->session->userdata('employee_id')."' or
						p.employee_id in 
						( 
							select b.id from employee_group_tb a 
							left join employee_tb b on a.employee_id=b.id 
							where a.leader_id='".esc($this->session->userdata('employee_id'))."' 
						) 
					) 
					AND sales_stage = '".esc($sales_stage)."' ";
					
					
					if($year!='a'){
						$where .= "and year(p.quotation_date)='".esc($year)."' ";
					}
			
			}
					
					
			
			
			
			if ($query) $where .= " and $qtype LIKE '%$query%' ";
		}
		
		
		
		$tname="project_tb p
				left join employee_tb e on e.id = p.employee_id 
				left join client_tb c on c.id = p.client_id 
				left join industry_tb i on i.id = c.industry ";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("p.id"," $tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if($result) foreach($result as $row){
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/delete_crm","privilege_tb")){
				$delete = " | <a href=\"".site_url('project/delete_crm/'.$row['p_id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/detail_crm","privilege_tb")){
				$detail = " | <a href=\"".site_url('project/detail_crm/'.$row['p_id'])."\">Detail</a>";
			 }else{
				$detail = "";
			 }

			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['p_id']."',";
			$json .= "cell:[";
			
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/edit_crm","privilege_tb")){
				$json .= "'<a href=\"".site_url('project/edit_crm/'.$row['p_id'])."\">Edit</a>".$delete.$detail."'";
			 }else{
				 $json .= "'".$delete.$detail."'";
			 }
			
			$json .= ",'".esc($row['p_name'])."'";
			
			/*if($row['client_id']!=0){
				$json .= ",'".find('name',esc($row['client_id']),'client_tb')."'";
			}else{
				$json .= ",''";
			}*/
			$json .= ",'".esc($row['c_name'])."'";
			/*if($row['employee_id']!=0){
				$json .= ",'".find('firstname',esc($row['employee_id']),'employee_tb')." ".find('lastname',esc($row['employee_id']),'employee_tb')."'";
			}else{
				$json .= ",'admin'";
			}*/
			
			if($row['employee_id']!=0)
			$json .= ",'".esc($row['firstname'])." ".esc($row['lastname'])."'";
			else
			$json .= ",'Admin'";
			
			
			if($row['update_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['update_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			/*if($row['client_id']!=0){
				$json .= ",'".find('name',find('industry',esc($row['client_id']),'client_tb'),'industry_tb')."'";
			}else{
				$json .= ",''";
			}*/
			$json .= ",'".esc($row['location'])."'";
			$json .= ",'".esc($row['i_name'])."'";
			$json .= ",'".esc(money($row['amount']))."'";
			if($row['sales_stage']==1){
				$json .= ",'potential'";
			}elseif($row['sales_stage']==2){
				$json .= ",'quotation'";
			}elseif($row['sales_stage']==3){
				$json .= ",'tender/review'";
			}elseif($row['sales_stage']==4){
				$json .= ",'win'";
			}else{
				$json .= ",'lost'";
			}
			if($row['lead_source']!=0){
				$json .= ",'".find('name',esc($row['lead_source']),'lead_source_tb')."'";
			}else{
				$json .= ",'-'";
			}
			
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/edit_crm","privilege_tb")){
				if($row['p_status']==0){
					$json .= ",'<a href=\"".site_url('project/status/'.$row['p_id'].'/'.$row['p_status'])."\">open</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('project/status/'.$row['p_id'].'/'.$row['p_status'])."\">Close</a>'";
				}
			}else{
				if($row['status']==0){
				$json .= ",'open'";
				}else{
					$json .= ",'Close'";
				}
			}
			
			if($row['first_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['first_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			if($row['demo_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['demo_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			if($row['quotation_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['quotation_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			if($row['review_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['review_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			if($row['close_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['close_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			if($row['expected_close_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['expected_close_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			$json .= ",'".esc($row['description'])."'";
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	function status($id,$status){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/edit_crm","privilege_tb")){
			if($status==0){
				$status = 1;	
			}else{
				$status = 0;
			}
			$this->project_model->status($id,$status);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	
	function detail_crm($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/detail_crm","privilege_tb")){
			$this->data['project_item'] = $this->project_model->show_product_by_project($id);
			$this->data['crm'] = $this->project_model->show_crm_by_id($id);
			$this->data['activity'] = $this->project_model->show_employee_activity_by_project_goal_id($id);
			$this->data['crm_info'] = $this->project_model->show_crm_info($id);
			$this->data['show_all_stock']=$this->warehouse_model->show_all_stock();
			$this->data['schedule_to'] = $this->project_model->show_schedule_to_by_project_id($id);
			$this->data['ticket_new'] = $this->project_model->show_ticket_new_by_project_id($id);
			$this->data['ticket_close'] = $this->project_model->show_ticket_close_by_project_id($id);
			
			//project quotation
			$this->data['quotation'] = $quotation = $this->project_model->show_quotation_project($id);
			$data = '';
			$no = 1;
			if($quotation){
				foreach($quotation as $list){
					if($no==1)$data.= $list['id'];
					else $data.=",".$list['id'];
					$no++;
				}
				$this->data['quotation_item'] = $this->project_model->show_quotation_item($data);
				$this->data['quotation_log'] = $this->project_model->show_quotation_log($data);
				$this->data['quotation_payment'] = $this->project_model->show_quotation_payment($data);
			}
			
			//project quotation
			$this->data['po_client'] = $po_client = $this->project_model->show_po_client_project($id);
			$data = '';
			$no = 1;
			if($po_client){
				foreach($po_client as $list){
					if($no==1)$data.= $list['id'];
					else $data.=",".$list['id'];
					$no++;
				}
				$this->data['po_client_item'] = $this->project_model->show_po_client_item($data);
			}
			
			$this->data['page'] = 'project/detail_crm';
			$this->load->view('common/body', $this->data);
		}else{
			echo "x";exit;
			redirect('home');	
		}
	}
	
	function do_add_project_item($id){
		$product_id = $this->input->post('product_id');
		$price = $this->input->post('price');	
		$qty = $this->input->post('qty');
		$description = $this->input->post('description');
		$type = $this->input->post('type');
		$this->project_model->do_add_project_item($id,$product_id,$price,$qty,$description);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function add_project_total($id){
		$subtotal = $this->input->post('subtotal');
		$discount = $this->input->post('discount');
		$ppn = $this->input->post('ppn');
		
		if($ppn==1){
			$total = $subtotal - ($subtotal*$discount/100) + (($subtotal-($subtotal*$discount/100))*0.1);	
		}else{
			$total = $subtotal - ($subtotal*$discount/100);	
		}
		
		$this->project_model->do_add_project_total($id,$subtotal,$discount,$ppn,$total);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_project_total($id){
		$this->project_model->delete_project_total($id);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function delete_project_item($id){
		$this->project_model->delete_project_item($id);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function product_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'c.id,p.name';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*,p.id as p_id, c.id as c_id, p.name as p_name, c.name as c_name";
		$where = "where type = 0 and p.active = 1 and c.active = 1";
		if ($query) $where .= " and $qtype LIKE '%$query%' ";
		$tname="product_tb p
				left join category_tb c on c.id = p.category_id";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("p.id"," $tname $where");
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
			$json .= "id:'".$row['p_id']."',";
			$json .= "cell:[";

			$json .= "'".esc($row['c_name'])."'";
			$json .= ",'<a href=\"#\" onClick=\"get_main_product(".$row['p_id'].",\'".make_alias_2(esc($row['p_name']))."\',\'".make_alias_2(esc($row['number']))."\',".esc($row['price']).",\'".esc($row['description'])."\'); return false;\">".esc($row['p_name'])."</a>'";
			$json .= ",'<a href=\"#\" onClick=\"get_main_product(".$row['p_id'].",\'".make_alias_2(esc($row['p_name']))."\',\'".make_alias_2(esc($row['number']))."\',".esc($row['price']).",\'".esc($row['description'])."\'); return false;\">".esc($row['number'])."</a>'";

			$json .= ",'".money(esc($row['price']))."'";
			$json .= ",'$ ".currency(esc($row['price_2']))."'";
			
			$json .= ",'".esc($row['description'])."'";
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
	}
	
	function accessories_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'c.id,p.name';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*,p.id as p_id, c.id as c_id, p.name as p_name, c.name as c_name";
		$where = "where type = 1 and p.active = 1";
		if ($query) $where .= " and $qtype LIKE '%$query%' ";
		$tname="product_tb p
				left join category_tb c on c.id = p.category_id";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("p.id"," $tname $where");
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
			$json .= "id:'".$row['p_id']."',";
			$json .= "cell:[";

			$json .= "'<a href=\"#\" onClick=\"get_acc_product(".$row['p_id'].",\'".make_alias_2(esc($row['p_name']))."\',\'".make_alias_2(esc($row['number']))."\',".esc($row['price']).",\'".esc($row['description'])."\'); return false;\">".esc($row['p_name'])."</a>'";
			$json .= ",'<a href=\"#\" onClick=\"get_acc_product(".$row['p_id'].",\'".make_alias_2(esc($row['p_name']))."\',\'".make_alias_2(esc($row['number']))."\',".esc($row['price']).",\'".esc($row['description'])."\'); return false;\">".esc($row['number'])."</a>'";

			$json .= ",'".money(esc($row['price']))."'";
			$json .= ",'$ ".currency(esc($row['price_2']))."'";
			
			$json .= ",'".esc($row['description'])."'";
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
	}
	
	function employee_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'category,firstname,lastname';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*";
		$where = "where status = 1";
		if ($query) $where .= " and $qtype LIKE '%$query%' ";
		$tname="employee_tb";
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
			

			if($row['category']==1){
				$json .= "'Technician'";
			}elseif($row['category']==2){
				$json .= "'Web'";
			}elseif($row['category']==3){
				$json .= "'Marketing'";
			}else{
				$json .= "'-'";
			}
			$json .= ",'<a href=\"#\" onClick=\"get_employee(".$row['id'].",\'".make_alias_2(esc($row['firstname']).esc($row['lastname']))."\'); return false;\">".esc($row['firstname'])."</a>'";
			$json .= ",'<a href=\"#\" onClick=\"get_employee(".$row['id'].",\'".make_alias_2(esc($row['firstname']).esc($row['lastname']))."\'); return false;\">".esc($row['lastname'])."</a>'";
			
			$json .= ",'".find('name',esc($row['company_id']),'company_tb')."'";
		
			$json .= ",'".find('name',esc($row['department_id']),'department_tb')."'";
			$json .= ",'".esc($row['job_title'])."'";
			$json .= ",'".esc($row['gsm_1'])."'";
			$json .= ",'".esc($row['gsm_2'])."'";
			$json .= ",'".esc($row['phone'])."'";
			$json .= ",'".esc($row['pin_bb'])."'";
			$json .= ",'".esc($row['email'])."'";
			
			if($row['sim_a']==1){
				$json .= ",'yes'";
			}else{
				$json .= ",'no'";
			}
			
			if($row['sim_c']==1){
				$json .= ",'yes'";
			}else{
				$json .= ",'no'";
			}
			
			if($row['motor']==1){
				$json .= ",'yes'";
			}else{
				$json .= ",'no'";
			}
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	function employee_flexi2(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'category,firstname,lastname';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*";
		$where = "where status = 1";
		if ($query) $where .= " and $qtype LIKE '%$query%' ";
		$tname="employee_tb";
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
			

			if($row['category']==1){
				$json .= "'Technician'";
			}elseif($row['category']==2){
				$json .= "'Web'";
			}elseif($row['category']==3){
				$json .= "'Marketing'";
			}else{
				$json .= "'-'";
			}
			$json .= ",'<a href=\"#\" onClick=\"get_employee2(".$row['id'].",\'".make_alias_2(esc($row['firstname']).esc($row['lastname']))."\'); return false;\">".esc($row['firstname'])."</a>'";
			$json .= ",'<a href=\"#\" onClick=\"get_employee2(".$row['id'].",\'".make_alias_2(esc($row['firstname']).esc($row['lastname']))."\'); return false;\">".esc($row['lastname'])."</a>'";
			
			$json .= ",'".find('name',esc($row['company_id']),'company_tb')."'";
		
			$json .= ",'".find('name',esc($row['department_id']),'department_tb')."'";
			$json .= ",'".esc($row['job_title'])."'";
			$json .= ",'".esc($row['gsm_1'])."'";
			$json .= ",'".esc($row['gsm_2'])."'";
			$json .= ",'".esc($row['phone'])."'";
			$json .= ",'".esc($row['pin_bb'])."'";
			$json .= ",'".esc($row['email'])."'";
			
			if($row['sim_a']==1){
				$json .= ",'yes'";
			}else{
				$json .= ",'no'";
			}
			
			if($row['sim_c']==1){
				$json .= ",'yes'";
			}else{
				$json .= ",'no'";
			}
			
			if($row['motor']==1){
				$json .= ",'yes'";
			}else{
				$json .= ",'no'";
			}
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	function employee_flexi3(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'category,firstname,lastname';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*";
		$where = "where status = 1";
		if ($query) $where .= " and $qtype LIKE '%$query%' ";
		$tname="employee_tb";
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
			

			if($row['category']==1){
				$json .= "'Technician'";
			}elseif($row['category']==2){
				$json .= "'Web'";
			}elseif($row['category']==3){
				$json .= "'Marketing'";
			}else{
				$json .= "'-'";
			}
			$json .= ",'<a href=\"#\" onClick=\"get_employee3(".$row['id'].",\'".make_alias_2(esc($row['firstname']).esc($row['lastname']))."\'); return false;\">".esc($row['firstname'])."</a>'";
			$json .= ",'<a href=\"#\" onClick=\"get_employee3(".$row['id'].",\'".make_alias_2(esc($row['firstname']).esc($row['lastname']))."\'); return false;\">".esc($row['lastname'])."</a>'";
			
			$json .= ",'".find('name',esc($row['company_id']),'company_tb')."'";
		
			$json .= ",'".find('name',esc($row['department_id']),'department_tb')."'";
			$json .= ",'".esc($row['job_title'])."'";
			$json .= ",'".esc($row['gsm_1'])."'";
			$json .= ",'".esc($row['gsm_2'])."'";
			$json .= ",'".esc($row['phone'])."'";
			$json .= ",'".esc($row['pin_bb'])."'";
			$json .= ",'".esc($row['email'])."'";
			
			if($row['sim_a']==1){
				$json .= ",'yes'";
			}else{
				$json .= ",'no'";
			}
			
			if($row['sim_c']==1){
				$json .= ",'yes'";
			}else{
				$json .= ",'no'";
			}
			
			if($row['motor']==1){
				$json .= ",'yes'";
			}else{
				$json .= ",'no'";
			}
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	
	function client_flexi(){
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
		$selection="*";
		$where = "where name != ''";
		if ($query) $where = " and $qtype LIKE '%$query%' ";
		$tname="client_tb";
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
			
			$json .= "'<a href=\"#\" onClick=\"get_client(".$row['id'].",\'".make_alias_2(esc($row['name']))."\'); return false;\">".esc($row['name'])."</a>'";
			$json .= ",'".find('name',esc($row['industry']),'industry_tb')."'";
			
			$json .= ",'".esc($row['location'])."'";
			
			$json .= ",'".esc($row['phone'])."'";
			
			$json .= ",'".esc($row['email'])."'";
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	function vendor_flexi(){
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
		$selection="*";
		$where = "where name != ''";
		if ($query) $where = " and $qtype LIKE '%$query%' ";
		$tname="vendor_tb";
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
			
			$json .= "'<a href=\"#\" onClick=\"get_vendor(".$row['id'].",\'".make_alias_2(esc($row['name']))."\'); return false;\">".esc($row['name'])."</a>'";
			$json .= ",'".esc($row['type'])."'";
			
			$json .= ",'".esc($row['cp_1'])."'";
			
			$json .= ",'".esc($row['phone'])."'";
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	
	function add_crm(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/add_crm","privilege_tb")){
			$this->data['lead_source'] = $this->project_model->show_lead_source();
			$this->data['page'] = 'project/add_crm';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_add_crm(){
		$name = $this->input->post('name');
		$employee_id = $this->input->post('employee_id');
		$client_id = $this->input->post('client_id');
		$sales_stage = $this->input->post('sales_stage');
		$lead_source = $this->input->post('lead_source');
		$first_date = $this->input->post('first_date');
		$demo_date = $this->input->post('demo_date');
		$quotation_date = $this->input->post('quotation_date');
		$review_date = $this->input->post('review_date');
		$bast_date = $this->input->post('bast_date');
		
		$close_date = $this->input->post('close_date');
		$expected_close_date = $this->input->post('expected_close_date');
		$description = $this->input->post('description');
		$amount = $this->input->post('amount');
		$status = $this->input->post('status');
		
		$this->project_model->do_add_crm($name,$client_id,$employee_id,$sales_stage,$lead_source,$first_date,$demo_date,$quotation_date,$review_date,$close_date,$expected_close_date,$amount,$description,$status,$bast_date);
		
		//project goal
		$project_id = mysql_insert_id();
		if($sales_stage == 4){
			$this->project_model->insert_to_project_goal($project_id);	
		}
		//
		
		redirect('project/detail_crm/'.$project_id);
	}
	
	function edit_crm($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/edit_crm","privilege_tb")){
			$this->data['lead_source'] = $this->project_model->show_lead_source();
			$this->data['crm'] = $this->project_model->show_crm_by_id($id);
			$this->data['page'] = 'project/edit_crm';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_edit_crm($id){
		$name = $this->input->post('name');
		$client_id = $this->input->post('client_id');
		$employee_id = $this->input->post('employee_id');
		$sales_stage = $this->input->post('sales_stage');
		$lead_source = $this->input->post('lead_source');
		$first_date = $this->input->post('first_date');
		$demo_date = $this->input->post('demo_date');
		$quotation_date = $this->input->post('quotation_date');
		$review_date = $this->input->post('review_date');
		$bast_date = $this->input->post('bast_date');
		
		$close_date = $this->input->post('close_date');
		$expected_close_date = $this->input->post('expected_close_date');
		$description = $this->input->post('description');
		$amount = $this->input->post('amount');
		$status = $this->input->post('status');
		
		$this->project_model->do_edit_crm($id,$name,$client_id,$employee_id,$sales_stage,$lead_source,$first_date,$demo_date,$quotation_date,$review_date,$close_date,$expected_close_date,$amount,$description,$status,$bast_date);	
		
		//project goal
		$project_id = $id;
		
		if($sales_stage == 4){
			if(!find_2('project_id','project_id',$project_id,'project_goal_tb')){
				$this->project_model->insert_to_project_goal($project_id);	
				//$project_goal_id = mysql_insert_id();
				//$this->project_model->insert_project_goal_bonus($project_goal_id);
			}
		}else{
			if(find_2('project_id','project_id',$project_id,'project_goal_tb')){
				$this->project_model->delete_from_project_goal($project_id);
			}
		}
		//
		
		redirect('project/detail_crm/'.$id);
	}
	
	function do_edit_crm_2($id){
		$name = $this->input->post('name');
		$client_id = $this->input->post('client_id');
		$employee_id = $this->input->post('employee_id');
		$sales_stage = $this->input->post('sales_stage');
		$lead_source = $this->input->post('lead_source');
		$first_date = $this->input->post('first_date');
		$demo_date = $this->input->post('demo_date');
		$quotation_date = $this->input->post('quotation_date');
		$review_date = $this->input->post('review_date');
		$bast_date = $this->input->post('bast_date');
		
		$close_date = $this->input->post('close_date');
		$expected_close_date = $this->input->post('expected_close_date');
		$description = $this->input->post('description');
		$amount = $this->input->post('amount');
		$status = $this->input->post('status');
		
		$this->project_model->do_edit_crm($id,$name,$client_id,$employee_id,$sales_stage,$lead_source,$first_date,$demo_date,$quotation_date,$review_date,$close_date,$expected_close_date,$amount,$description,$status,$bast_date);	
		
		//project goal
		/*$project_id = $id;
		
		if($sales_stage == 4){
			if(!find_2('project_id','project_id',$project_id,'project_goal_tb')){
				$this->project_model->insert_to_project_goal($project_id);	
				$project_goal_id = mysql_insert_id();
				$this->project_model->insert_project_goal_bonus($project_goal_id);
			}
		}else{
			if(find_2('project_id','project_id',$project_id,'project_goal_tb')){
				$this->project_model->delete_from_project_goal($project_id);
			}
		}*/
		//
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_crm($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/delete_crm","privilege_tb")){
			$project_goal_id = find_2('id','project_id',$id,'project_goal_tb');
			$this->project_model->delete_crm($id,$project_goal_id);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	/////////////////
	//project goal///
	////////////////
	function list_project_goal(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){
			$this->data['filter_goal'] = $this->input->post('filter_goal');
			$this->data['project_team_list'] = $this->project_model->show_team_goal_list();
			$this->data['page'] = 'project/list_project_goal';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function project_goal_flexi($filter_goal){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'open desc,p.name';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 20;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*,p.id as p_id, pg.id as pg_id,p.name as p_name, c.name as c_name, count(pgi.id)as total_invoice";
		
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal","privilege_tb")){
			if($filter_goal==-1){
					$where = "";
					if ($query) $where .= " where $qtype LIKE '%$query%' ";
				}else{
					$where = "where p.close_date >= '".$filter_goal."-01-01' and p.close_date <= '".$filter_goal."-12-31'";
					if ($query) $where .= " and $qtype LIKE '%$query%' ";
				}
			$where .= "group by pg.id";
			
		}elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){
			if($filter_goal==-1){
				//$where = "where p.employee_id = '".$this->session->userdata('employee_id')."'";
				
				$where = " where  
			( 
				ps.employee_id = '".$this->session->userdata('employee_id')."' or 
				p.employee_id in 
				( 
					select b.id from employee_group_tb a 
					left join employee_tb b on a.employee_id=b.id 
					where a.leader_id='".esc($this->session->userdata('employee_id'))."' 
				) 
			) ";
				
			}else{
				//$where = "where p.employee_id = '".$this->session->userdata('employee_id')."' and p.close_date >= '".$filter_goal."-01-01' and p.close_date <= '".$filter_goal."-12-31'";
				
				$where = " where  
			( 
				p.employee_id = '".$this->session->userdata('employee_id')."' or 
				p.employee_id in 
				( 
					select b.id from employee_group_tb a 
					left join employee_tb b on a.employee_id=b.id 
					where a.leader_id='".esc($this->session->userdata('employee_id'))."' 
				) 
			) and p.close_date >= '".$filter_goal."-01-01' and p.close_date <= '".$filter_goal."-12-31' ";
			}
			
			
			
			if ($query) $where .= " and $qtype LIKE '%$query%' ";
			$where .= "group by pg.id";
			
			
			
			
		}
		
		$tname="project_goal_tb pg
				left join project_tb p on p.id = pg.project_id
				left join client_tb c on c.id = p.client_id
				left join employee_tb e on e.id = p.employee_id
				left join project_goal_invoice_tb pgi on pgi.project_goal_id = pg.id";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec2("*"," $tname $where");
		//customable
		//$total=$total1['total'];
		$total = 0;
		//echo $total;exit;
		if($total1)foreach($total1 as $xxx){
			$xxx['total'];	
		$total++;
		}
		
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if($result) foreach($result as $row){
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/detail_project_goal","privilege_tb")){
				$detail = " | <a href=\"".site_url('project/detail_project_goal/'.$row['pg_id'])."\">Detail</a>";
			 }else{
				$detail = "";
			 }
			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['pg_id']."',";
			$json .= "cell:[";
			
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/edit_project_goal","privilege_tb")){
				$json .= "'<a href=\"".site_url('project/edit_crm/'.$row['p_id'])."\">Edit</a>".$detail."'";
			 }else{
				 $json .= "'".$detail."'";
			 }
			$approval_budget='-';
			// find_2($coloumn,$data,$data_2,$table)
			$cek_approval=find_2('approval_level','	project_id',$row['p_id'],'project_goal_po_client_tb');
			//echo $cek_approval.'DDDDD';
			
			if($cek_approval=='0'){
				$approval_budget = 'No';
			}else if($cek_approval=='3'){
				$approval_budget = 'Yes';
			}
			
			
			$json .= ",'".esc($row['p_name'])."'";
			$json .= ",'".esc($row['c_name'])."'";
			$json .= ",'".esc($row['firstname'])." ".esc($row['lastname'])."'";
			$json .= ",'".esc($row['total_invoice'])."'";
			$json .= ",'".esc($approval_budget)."'";
			
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/view_number","privilege_tb")){
				if(find_2_total('sum(total)as total','project_goal_id',$row['pg_id'],'project_goal_invoice_tb')-find_2_total('sum(dp_idr)as total','project_goal_id',$row['pg_id'],'project_goal_payment_tb')!=0){
				$json .= ",'".money(esc(find_2_total('sum(total)as total','project_goal_id',$row['pg_id'],'project_goal_invoice_tb')-find_2_total('sum(dp_idr)as total','project_goal_id',$row['pg_id'],'project_goal_payment_tb')))."'";
				}else $json .= ",'-'";
			}else $json .= ",'-'";
			
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/view_number","privilege_tb")){
				if(find_2_total('sum(total_2)as total','project_goal_id',$row['pg_id'],'project_goal_invoice_tb')-find_2_total('sum(dp_usd)as total','project_goal_id',$row['pg_id'],'project_goal_payment_tb')!=0){
				$json .= ",'$ ".currency(esc(find_2_total('sum(total_2)as total','project_goal_id',$row['pg_id'],'project_goal_invoice_tb')-find_2_total('sum(dp_usd)as total','project_goal_id',$row['pg_id'],'project_goal_payment_tb')))."'";
				}else $json .= ",'-'";
			}else $json .= ",'-'";
			
			if($row['close_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['close_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			
			if($row['review_date']!=00-00-0000){
				if($row['sales_stage']==4){
					$json .= ",'".date('d/m/Y',strtotime(esc($row['review_date'])))."'";
				}else{
					$json .= ",'-'";
				}
			}else{
				$json .= ",'-'";	
			}
			
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/edit_project_goal","privilege_tb")){
				if($row['open']==1){
					$json .= ",'<a href=\"".site_url('project/goal_open/'.$row['pg_id'].'/'.$row['open'])."\">Open</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('project/goal_open/'.$row['pg_id'].'/'.$row['open'])."\">Closed</a>'";
				}
			}else{
				if($row['open']==1){
					$json .= ",'Open'";
				}else{
					$json .= ",'Closed'";
				}
			}
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	function goal_open($id,$open){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/edit_project_goal","privilege_tb")){
		if($open==0){
			$open = 1;	
		}else{
			$open = 0;	
		}
		$this->project_model->goal_open($id,$open);
		redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	
	function edit_project_goal($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/edit_project_goal","privilege_tb")){
			$this->data['goal'] = $this->project_model->show_project_goal_by_id($id);
			$this->data['page'] = 'project/edit_project_goal';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_edit_project_goal($id){
		$invoice_number = $this->input->post('invoice_number');
		$po_date = $this->input->post('po_date');
		/*$bast_date = $this->input->post('bast_date');	
		$settled_date = $this->input->post('settled_date');
		$tender = $this->input->post('tender');*/
		$open = $this->input->post('open');
		
		/*$this->project_model->do_edit_project($id,$invoice_number,$po_date,$bast_date,$settled_date,$tender,$open);*/
		$this->project_model->do_edit_project($id,$invoice_number,$tender,$open);
		redirect('project/detail_project_goal/'.$id);
	}
	
	function detail_project_goal($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/detail_project_goal","privilege_tb")){
			$this->data['project_goal_id']=$id;
			
			$this->data['rak'] = $this->rak_model->show_rak();
			$this->data['bank'] = $this->project_model->show_bank_active();
			$this->data['goal'] = $this->project_model->show_project_goal_by_id($id);
			$this->data['employee'] = $this->project_model->show_employee();
			$this->data['stock_list'] = $this->project_model->get_stock_list();
			$this->data['get_departemen_active']=$this->department_model->get_departemen_active();
		
			$this->data['payment'] = $this->project_model->show_payment_by_project_goal_id($id);
			$this->data['bonus'] = $this->project_model->show_bonus_by_project_goal_id($id);
			$this->data['info_invoice'] = $this->project_model->show_project_goal_info_invoice($id);
			$this->data['bonus_invoice'] = $this->project_model->show_project_goal_bonus_invoice($id);
			$this->data['survey'] = $this->project_model->show_invoice_survey($id);
			$this->data['project_id']=	$project_id = find('project_id',$id,'project_goal_tb');
			$this->data['project_deadline']=$this->department_model->show_project_deadline_tb($project_id);
			$this->data['lead_source'] = $this->project_model->show_lead_source();
			$this->data['project_item'] = $this->project_model->show_product_by_project($project_id);
			$this->data['crm'] = $this->project_model->show_crm_by_id($project_id);
			$this->data['member'] = $this->project_model->show_employee_by_project_goal_id($project_id);
			$this->data['activity'] = $this->project_model->show_employee_activity_by_project_goal_id($project_id);
			$this->data['invoice'] = $this->project_model->show_invoice_by_project_goal_id($id);
			
			$this->data['project_goal_info'] = $this->project_model->show_project_goal_info($id);
			$this->data['retur_list']=$this->project_model->get_retur_by_project($project_id);
			$this->data['schedule_to'] = $this->project_model->show_schedule_to_by_project_id($project_id);
			$this->data['ticket_new'] = $this->project_model->show_ticket_new_by_project_id($project_id);
			$this->data['ticket_close'] = $this->project_model->show_ticket_close_by_project_id($project_id);
			
			$this->data['survey_result_replied_list'] = $this->project_model->show_survey_result_replied_by_project_id($project_id);
			
			//project quotation
			$this->data['quotation'] = $quotation = $this->project_model->get_project_quotation($project_id);
			$data = '';
			if($quotation){
				foreach($quotation as $listquo){
					if($data)$data.=",".$listquo['id'];
					else $data = $listquo['id'];	
				}
				$this->data['quotation_item'] = $this->project_model->get_project_quotation_item($data);
			}else $this->data['quotation_item'] = '';
			
			$this->data['quotation_file'] = $this->project_model->get_project_quotation_file($project_id);
			
			//project client po
			$this->data['po_client'] = $po_client = $this->project_model->get_project_po_client($project_id);

			$this->data['po_client_item'] =$this->project_model->get_project_po_client_item($po_client['id']);
			
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
			
			//project po stock
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
			
			//history retur//
			
		
			
			
			//receive item
			$this->data['receive_list'] = $receive_list = $this->project_model->get_receive_list($project_id);
			if($receive_list){
				$data = "";
				$no = 1;
				foreach($receive_list as $list){
					if($no==1)$data.=$list['id'];
					else $data.=",".$list['id'];
					$no++;
				}
				$this->data['receive_item_list'] = $this->project_model->get_receive_item_list2($data);
			}else $this->data['receive_item_list']='';
			
			$this->data['warehouse_list'] = $this->project_model->get_warehouse_aktif();
			
			//delivery item
			$this->data['delivery_list'] = $delivery_list = $this->project_model->get_delivery_list($project_id);
			if($delivery_list){
				$data = "";
				$no = 1;
				foreach($delivery_list as $list){
					if($no==1)$data.=$list['id'];
					else $data.=",".$list['id'];
					$no++;
				}
				$this->data['delivery_item_list'] = $this->project_model->get_delivery_item_list($data);
			}else $this->data['delivery_item_list']='';
			
			///purchase request
			$this->data['purchase_request']=$this->project_model->get_purchase_request($project_id);
			$this->data['purchase_request_item']=$this->project_model->get_purchase_request_item($project_id);
			
			$this->data['page'] = 'project/detail_project_goal';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_add_project_member($id){
		$employee_id = $this->input->post('employee_id');
		
		$this->project_model->do_add_project_member($id,$employee_id);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_project_member($id){
		$this->project_model->delete_project_member($id);
		
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function do_add_project_info_invoice($id){
		$project_goal_invoice_id = $this->input->post('project_goal_invoice_id');
		$description = $this->input->post('description');
		$input_date = date("Y-m-d");
		$input_by = $this->session->userdata('employee_id');
		
		$this->project_model->do_add_project_info_invoice($id,$project_goal_invoice_id,$description,$input_by,$input_date);
		
		redirect('project/detail_project_goal'.'/'.$id.'#project_invoice_tab_site');
	}
	
	function delete_project_goal_info_invoice($id){
		$this->project_model->delete_project_goal_info_invoice($id);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function do_add_project_payment($id){
		$project_goal_invoice_id = $this->input->post('project_goal_invoice_id');
		$dp_idr = $this->input->post('dp_idr');
		$dp_usd = $this->input->post('dp_usd');
		$transfer_date = $this->input->post('transfer_date');
		$bank = $this->input->post('bank_1');
		$notes = $this->input->post('notes');
		
		$this->project_model->do_add_project_payment($id,$project_goal_invoice_id,$dp_idr,$dp_usd,$transfer_date,$bank,$notes);
		redirect('project/detail_project_goal'.'/'.$id.'#project_invoice_tab_site');
	}
	
	function do_edit_project_payment($id){
		//$project_goal_invoice_id = $this->input->post('project_goal_invoice_id');
		$dp_idr = $this->input->post('dp_idr');
		$dp_usd = $this->input->post('dp_usd');
		$transfer_date = $this->input->post('transfer_date');
		$bank = $this->input->post('bank_1');
		$notes = $this->input->post('notes');
		
		/*$currency = $this->project_model->show_currency();
		$kurs = $currency['idr'];
		
		if( ($dp_idr==0 || $dp_idr=='') && ($dp_usd!=0 || $dp_usd!='') ){
			$dp_idr = $dp_usd * $kurs;
		}*/
		
		$this->project_model->do_edit_project_payment($id,$dp_idr,$dp_usd,$transfer_date,$bank,$notes);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_project_payment($id){
		$this->project_model->delete_project_payment($id);
		redirect($_SERVER['HTTP_REFERER'].'#project_invoice_tab_site');
	}
	
	
	function do_add_project_invoice($project_goal_id){
		$invoice = $this->input->post('invoice');
		$po_date = $this->input->post('po_date');
		$bast_date = $this->input->post('bast_date');
		$settled_date = $this->input->post('settled_date');
		$under_table_fee = $this->input->post('under_table_fee');
		$total = $this->input->post('total');
		$total_2 = $this->input->post('total_2');
		$description = $this->input->post('description');
		$created_date = date('Y-m-d');
		
		$ppn = $this->input->post('ppn');
		$tender = $this->input->post('tender');
		
		/*$currency = $this->project_model->show_currency();
		$kurs = $currency['idr'];
		
		if(($total == 0 || $total == '') && ($total_2 != 0 || $total_2 != '')){
			$total = $total_2 * $kurs;
		}*/
		
		if($ppn == 1){
			$total = $total + ($total * 0.1);
			$total_2 = $total_2 + ($total_2 * 0.1);
		}
		
		$this->project_model->do_add_project_invoice($project_goal_id,$invoice,$po_date,$bast_date,$settled_date,$under_table_fee,$tender,$ppn,$total,$total_2,$description,$created_date);
		
		redirect('project/detail_project_goal'.'/'.$project_goal_id.'#project_invoice_tab_site');
	}
	
	function do_edit_project_invoice($id){
		$invoice = $this->input->post('invoice');
		$po_date = $this->input->post('po_date');
		$bast_date = $this->input->post('bast_date');
		$settled_date = $this->input->post('settled_date');
		$under_table_fee = $this->input->post('under_table_fee');
		$total = $this->input->post('total');
		$total_2 = $this->input->post('total_2');
		$created_date = date('Y-m-d');
		
		$ppn = $this->input->post('ppn');
		$tender = $this->input->post('tender');
		$description = $this->input->post('description');
		/*$currency = $this->project_model->show_currency();
		$kurs = $currency['idr'];
		
		if(($total == 0 || $total == '') && ($total_2 != 0 || $total_2 != '')){
			$total = $total_2 * $kurs;
		}*/
		
		if($ppn == 1){
			$total = $total + ($total * 0.1);
			$total_2 = $total_2 + ($total_2 * 0.1);
		}
		
		$this->project_model->do_edit_project_invoice($id,$invoice,$po_date,$bast_date,$settled_date,$under_table_fee,$tender,$ppn,$total,$total_2,$description,$created_date);
		 redirect($_SERVER['HTTP_REFERER'].'#project_invoice_tab_site');
//		redirect('project/detail_project_goal'.'/'.$invoice.'#project_invoice_tab_site');
	}
	
	function get_invoice($id){
		$this->data['invoice_detail'] = $this->project_model->show_invoice_by_id($id);
		$this->load->view('project/get_invoice',$this->data);
	}
	
	function get_payment($id){
		$this->data['bank'] = $this->project_model->show_bank_active();
		$this->data['payment_detail'] = $this->project_model->show_payment_by_id($id);
		$this->load->view('project/get_payment',$this->data);
	}
	
	function get_invoice_info($id){
		$this->data['invoice_info'] = $this->project_model->show_invoice_info_by_id($id);
		$this->load->view('project/get_invoice_information',$this->data);
	}
	
	function get_bonus($id){
		$this->data['bonus_detail'] = $this->project_model->show_bonus_invoice_by_id($id);
		$this->load->view('project/get_bonus',$this->data);
	}
	
	function delete_project_invoice($id){
		$this->project_model->delete_project_invoice($id);
		 redirect($_SERVER['HTTP_REFERER'].'#project_invoice_tab_site');
	}
	
	function do_edit_project_bonus($id){
		$bonus_marketing = $this->input->post('bonus_marketing');
		$bonus_support = $this->input->post('bonus_support');
		$bonus_admin = $this->input->post('bonus_admin');
		$bonus_engineering = $this->input->post('bonus_engineering');
		
		$this->project_model->do_edit_project_bonus($id,$bonus_marketing,$bonus_support,$bonus_admin,$bonus_engineering);
		
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function do_add_project_bonus_invoice($id){
		$project_goal_invoice_id = $this->input->post('project_goal_invoice_id');
		$bonus_marketing = $this->input->post('bonus_marketing');
		$bonus_support = $this->input->post('bonus_support');
		$bonus_admin = $this->input->post('bonus_admin');
		$bonus_engineering = $this->input->post('bonus_engineering');
		
		$this->project_model->do_add_project_bonus_invoice($id,$project_goal_invoice_id,$bonus_marketing,$bonus_support,$bonus_admin,$bonus_engineering);
		
		redirect('project/detail_project_goal'.'/'.$id.'#project_invoice_tab_site');
	}
	
	function do_edit_project_bonus_invoice($id){
		$bonus_marketing = $this->input->post('bonus_marketing');
		$bonus_support = $this->input->post('bonus_support');
		$bonus_admin = $this->input->post('bonus_admin');
		$bonus_engineering = $this->input->post('bonus_engineering');
		
		$this->project_model->do_edit_project_bonus_invoice($id,$bonus_marketing,$bonus_support,$bonus_admin,$bonus_engineering);
		
		 redirect($_SERVER['HTTP_REFERER'].'#project_invoice_tab_site');
	}
	
	function edit_project_invoice_info($id){
		$description = $this->input->post('description');
		$today = date("Y-m-d");
		$input_by = $this->session->userdata('employee_id');
		$this->project_model->edit_project_invoice_info($id,$description,$today,$input_by);
		
	 redirect($_SERVER['HTTP_REFERER'].'#project_invoice_tab_site');
	}
	
	function delete_project_goal_bonus_invoice($id){
		$this->project_model->delete_project_goal_bonus_invoice($id);
		 redirect($_SERVER['HTTP_REFERER'].'#project_invoice_tab_site');
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////
	//employee activity//
	/////////////////////
	
	function list_employee_activity(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_employee_activity","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_employee_activity_2","privilege_tb")){
			$this->data['page'] = 'project/list_employee_activity';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function employee_activity_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'activity_date desc,firstname asc, lastname';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*,pea.id as pea_id, e.id as e_id, pea.description as pea_description, pea.category as pea_category,p.name as p_name";
		
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_employee_activity","privilege_tb")){
			$where = "";
			
			if($qtype == 'employee_name'){
				if ($query) $where .= " where firstname LIKE '%$query%' or lastname LIKE '%$query%'";
			}else{
				if ($query) $where .= " where $qtype LIKE '%$query%' ";
			}
		}elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_employee_activity_2","privilege_tb")){
			$where = "where e.id = '".$this->session->userdata('employee_id')."'";
			if($qtype == 'employee_name'){
				if ($query) $where .= " and (firstname LIKE '%$query%' or lastname LIKE '%$query%')";
			}else{
				if ($query) $where .= " and $qtype LIKE '%$query%' ";
			}
		}
		
		$tname="project_employee_activity_tb pea
				left join employee_tb e on e.id = pea.employee_id
				left join project_tb p on p.id = pea.project_id";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("pea.id"," $tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if($result) foreach($result as $row){
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/delete_employee_activity","privilege_tb")){
				$delete = " | <a href=\"".site_url('project/delete_employee_activity/'.$row['pea_id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			 
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/detail_employee_activity","privilege_tb")){
				$detail = " | <a href=\"".site_url('project/detail_employee_activity/'.$row['pea_id'])."\">Detail</a>";
			 }else{
					$detail = ""; 
			 }
			 
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['pea_id']."',";
			$json .= "cell:[";
			
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/edit_employee_activity","privilege_tb")){
				$json .= "'<a href=\"".site_url('project/edit_employee_activity/'.$row['pea_id'])."\">Edit</a>".$delete.$detail."'";
			 }else{
				 $json .= "'".$delete.$detail."'";
			 }
			if($row['activity_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['activity_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			if($row['firstname']!="" || $row['lastname']!=""){
				$json .= ",'".esc($row['firstname'])." ".esc($row['lastname'])."'";
			}else{
				$json .= ",'Admin'";	
			}
			$json .= ",'".find('name',$row['project_id'],'project_tb')."'";
			
			
			/*if($row['pea_category']==1){
				$json .= ",'New Instalation'";
			}elseif($row['pea_category']==2){
				$json .= ",'maintenance'";
			}elseif($row['pea_category']==3){
				$json .= ",'at office'";	
			}elseif($row['pea_category']==4){
				$json .= ",'trouble'";	
			}else{
				$json .= ",'no category'";	
			}*/
			$json .= ",'".esc($row['pea_category'])."'";
			$json .= ",'".esc($row['pea_description'])."'";
			
			$json .= ",'".esc($row['activity_do'])."'";
			$json .= ",'".esc($row['plan_tomorrow'])."'";
			$json .= ",'".esc($row['activity_pending'])."'";
			$json .= ",'".esc($row['activity_status'])."'";
			$json .= ",'".esc($row['worktime_1'])."'";
			$json .= ",'".esc($row['worktime_2'])."'";
			$json .= ",'".esc($row['worktime_3'])."'";
			$json .= ",'".esc($row['worktime_4'])."'";
			
			$json .= ",'".esc($row['product'])."'";
			$json .= ",'".esc($row['competitor'])."'";
			$json .= ",'".esc($row['closed'])."'";
			if($row['implement_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['implement_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			
			
			
			
			$json .= ",'".money(esc($row['additional_charge']))."'";
			$json .= ",'".esc($row['client_complaint'])."'";
			if($row['input_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['input_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			$json .= ",'".find('firstname',esc($row['input_by']),'employee_tb')." ".find('lastname',esc($row['input_by']),'employee_tb')."'";
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	function crm_flexi_2(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'status,name';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*";
		$where = "";
		if ($query) $where = " where $qtype LIKE '%$query%' ";
		$tname="project_tb";
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
			$project_goal_id=find_2('id','project_id',$row['id'],'project_goal_tb');
			$find_invoice=find_2('id','project_goal_id',$project_goal_id,'project_goal_invoice_tb');
			$find_timeline=find_2('id','project_id',$row['id'],'project_deadline_tb');
			$find_budget=find_2('approval_2_data','project_id',$row['id'],'project_goal_po_client_tb');
		   	
		   	if(($find_invoice && $find_timeline && $find_budget!='') or $row['id']<2100){
			//if(1==1){
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";

			
			//$json .= "'".esc($row['name'])."'";

			$json .= "'<a href=\"#\" onClick=\"get_project(".$row['id'].",\'".make_alias_2(esc($row['name']))."\'); return false;\">".esc($row['name'])."</a>'";
			$json .= ",'".find('name',esc($row['client_id']),'client_tb')."'";
			
			if($row['employee_id']!=0){
				$json .= ",'".find('firstname',esc($row['employee_id']),'employee_tb')." ".find('lastname',esc($row['employee_id']),'employee_tb')."'";
			}else{
				$json .= ",'admin'";
			}
			
			/*if($row['client_id']!=0){
				$json .= ",'".find('name',find('industry',esc($row['client_id']),'client_tb'),'industry_tb')."'";
			}else{
				$json .= ",''";
			}
			$json .= ",'".esc($row['amount'])."'";
			if($row['sales_stage']==1){
				$json .= ",'potential'";
			}elseif($row['sales_stage']==2){
				$json .= ",'quotation'";
			}elseif($row['sales_stage']==3){
				$json .= ",'tender/review'";
			}elseif($row['sales_stage']==4){
				$json .= ",'win'";
			}else{
				$json .= ",'lost'";
			}
			$json .= ",'".find('name',esc($row['lead_source']),'lead_source_tb')."'";*/
			
			$json .= "]}";
			$rc = true;		
		   }
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	function crm_flexi_3($ticket_id){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'status,name';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*";
		$where = "";
		if ($query) $where = " where $qtype LIKE '%$query%' ";
		$tname="project_tb";
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

			
			//$json .= "'".esc($row['name'])."'";
			$json .= "'<a href=\"#\" onClick=\"get_project(".$ticket_id.",".$row['id'].",\'".make_alias_2(esc($row['name']))."\'); return false;\">".esc($row['name'])."</a>'";
			$json .= ",'".find('name',esc($row['client_id']),'client_tb')."'";
			
			if($row['employee_id']!=0){
				$json .= ",'".find('firstname',esc($row['employee_id']),'employee_tb')." ".find('lastname',esc($row['employee_id']),'employee_tb')."'";
			}else{
				$json .= ",'admin'";
			}
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	
	function add_employee_activity(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/add_employee_activity","privilege_tb")){
			$this->data['employee_activity_category'] = $this->project_model->show_activity_category_active(); 
			$this->data['client'] = $this->project_model->show_client();
			$this->data['employee'] = $this->project_model->show_employee();
			$this->data['project'] = $this->project_model->show_project_open();
			$this->data['page'] = 'project/add_employee_activity';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_add_employee_activity(){
		$project_id = $this->input->post('project_id');
		
		$employee_id = $this->input->post('employee_id');
		$category = $this->input->post('category');
		$description = $this->input->post('description');
		$activity_date = $this->input->post('activity_date');
		$activity_do = $this->input->post('activity_do');
		
		$worktime_1 = $this->input->post('worktime_1');
		$worktime_2 = $this->input->post('worktime_2');
		$worktime_3 = $this->input->post('worktime_3');
		$worktime_4 = $this->input->post('worktime_4');
		
		$product = $this->input->post('product');
		$competitor = $this->input->post('competitor');
		$closed = $this->input->post('closed');
		$implement_date = $this->input->post('date_implement');
		
		$activity_status = $this->input->post('activity_status');
		$activity_pending = $this->input->post('activity_pending');
		$plan_tomorrow = $this->input->post('plan_tomorrow');
		$additional_charge = $this->input->post('additional_charge');
		$client_complaint = $this->input->post('client_complaint');
		$input_date = date("Y-m-d");
		$input_by = $this->session->userdata('employee_id');
		
		if($project_id != 0){
			$this->project_model->do_add_employee_activity($project_id,$employee_id,$category,$description,$activity_date,$activity_do,$worktime_1,$worktime_2,$worktime_3,$worktime_4,$product,$competitor,$closed,$implement_date,$activity_status,$activity_pending,$plan_tomorrow,$additional_charge,$client_complaint,$input_date,$input_by);
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function detail_employee_activity($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/detail_employee_activity","privilege_tb")){
			$this->data['activity'] = $this->project_model->show_employee_activity_by_id($id);
			$this->data['page'] = 'project/detail_employee_activity';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function edit_employee_activity($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/edit_employee_activity","privilege_tb")){
			$this->data['employee_activity_category'] = $this->project_model->show_activity_category_active(); 
			$this->data['activity'] = $this->project_model->show_employee_activity_by_id($id);
			$this->data['employee'] = $this->project_model->show_employee();
			$this->data['project'] = $this->project_model->show_project_open();
			$this->data['page'] = 'project/edit_employee_activity';
			$this->load->view('common/body', $this->data);	
		}else{
			redirect('home');	
		}
	}
	
	function do_edit_employee_activity($id){
		$project_id = $this->input->post('project_id');
		$employee_id = $this->input->post('employee_id');
		$category = $this->input->post('category');
		$description = $this->input->post('description');
		$activity_date = $this->input->post('activity_date');
		$activity_do = $this->input->post('activity_do');
		
		$worktime_1 = $this->input->post('worktime_1');
		$worktime_2 = $this->input->post('worktime_2');
		$worktime_3 = $this->input->post('worktime_3');
		$worktime_4 = $this->input->post('worktime_4');
		
		$product = $this->input->post('product');
		$competitor = $this->input->post('competitor');
		$closed = $this->input->post('closed');
		$implement_date = $this->input->post('date_implement');
		
		
		$activity_status = $this->input->post('activity_status');
		$activity_pending = $this->input->post('activity_pending');
		$plan_tomorrow = $this->input->post('plan_tomorrow');
		$additional_charge = $this->input->post('additional_charge');
		$client_complaint = $this->input->post('client_complaint');
		$input_date = date("Y-m-d");
		$input_by = $this->session->userdata('employee_id');
		
		$this->project_model->do_edit_employee_activity($id,$project_id,$employee_id,$category,$description,$activity_date,$activity_do,$worktime_1,$worktime_2,$worktime_3,$worktime_4,$product,$competitor,$closed,$implement_date,$activity_status,$activity_pending,$plan_tomorrow,$additional_charge,$client_complaint);
		redirect('project/list_employee_activity');
	}
	
	function delete_employee_activity($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/delete_employee_activity","privilege_tb")){
			$this->project_model->delete_employee_activity($id);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	
	//////////////////
	//activity category//
	function list_activity_category(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_activity_category","privilege_tb")){
			$this->data['activity_category'] = $this->project_model->show_activity_category();
			$this->data['page'] = 'project/list_activity_category';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function add_activity_category(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/add_activity_category","privilege_tb")){
			$this->data['page'] = 'project/add_activity_category';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_add_activity_category(){
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		
		$this->project_model->do_add_activity_category($name,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_activity_category($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/edit_activity_category","privilege_tb")){
			$this->data['activity_category'] = $this->project_model->show_activity_category_by_id($id);
			$this->data['page'] = 'project/edit_activity_category';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_edit_activity_category($id){
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		
		$this->project_model->do_edit_activity_category($id,$name,$active);
		redirect('project/list_activity_category');
	}
	
	function active_activity_category($id,$active){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_activity_category","privilege_tb")){
			if($active==1){
				$active = 0;	
			}else{
				$active = 1;	
			}
			$this->project_model->active_activity_category($id,$active);
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	function delete_activity_category($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/delete_activity_category","privilege_tb")){
			$this->project_model->delete_activity_category($id);
			redirect($_SERVER['HTTP_REFERER']);	
		}else{
			redirect('home');	
		}
	}
	/////////////////
	//bank//
	function list_bank(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_bank","privilege_tb")){
			$this->data['bank'] = $this->project_model->show_bank();
			$this->data['page'] = 'project/list_bank';
			$this->load->view('common/body', $this->data);	
		}else{
			redirect('home');	
		}
	}
	
	function add_bank(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/add_bank","privilege_tb")){
			$this->data['page'] = 'project/add_bank';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_add_bank(){
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		
		$this->project_model->do_add_bank($name,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_bank($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/edit_bank","privilege_tb")){
			$this->data['bank'] = $this->project_model->show_bank_by_id($id);
			$this->data['page'] = 'project/edit_bank';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_edit_bank($id){
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		
		$this->project_model->do_edit_bank($id,$name,$active);
		redirect('project/list_bank');
	}
	
	function active_bank($id,$active){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/edit_bank","privilege_tb")){
			if($active==1){
				$active = 0;	
			}else{
				$active = 1;	
			}
			$this->project_model->active_bank($id,$active);
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	function delete_bank($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/delete_bank","privilege_tb")){
			$this->project_model->delete_bank($id);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	//survey
	function get_survey($id){
		$this->data['survey_detail'] = $this->project_model->show_invoice_survey_by_id($id);
		$this->load->view('project/get_survey',$this->data);
	}
	
	function add_invoice_survey($goal_id){
		$project_goal_invoice_id = $this->input->post('project_goal_invoice_id');
		$marketing = $this->input->post('marketing');
		$engineering = $this->input->post('engineering');
		$support = $this->input->post('support');
		$description = $this->input->post('description'); 
		$surveyor = $this->input->post('surveyor');
		$input_by = $this->session->userdata('employee_id');
		$input_date = $this->input->post('input_date');
		
		$this->project_model->add_invoice_survey($goal_id,$project_goal_invoice_id,$marketing,$engineering,$support,$description,$surveyor,$input_by,$input_date);
		redirect('project/detail_project_goal'.'/'.$goal_id.'#project_invoice_tab_site');
	}
	
	function edit_invoice_survey($id){
		$marketing = $this->input->post('marketing');
		$engineering = $this->input->post('engineering');
		$support = $this->input->post('support');
		$description = $this->input->post('description'); 
		$surveyor = $this->input->post('surveyor');
		$input_date = $this->input->post('input_date');
		
		$this->project_model->edit_invoice_survey($id,$marketing,$engineering,$support,$description,$surveyor,$input_date);
		 redirect($_SERVER['HTTP_REFERER'].'#project_invoice_tab_site');
	}
	
	function delete_invoice_survey($id){
		$this->project_model->delete_invoice_survey($id);
		 redirect($_SERVER['HTTP_REFERER'].'#project_invoice_tab_site');
	}
	//
	//crm info
	function do_add_crm_information($project_id){
		$description = $this->input->post('description');
		$input_date = date('Y-m-d');
		$input_by = $this->session->userdata('employee_id');
		$this->project_model->do_add_crm_information($project_id,$description,$input_date,$input_by);
		
		$report = $this->input->post('report');
		if($report){
			$quarter = $this->input->post('quarter');
			$year = $this->input->post('year');
			$based = $this->input->post('based');
			
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['project'] = $this->report_model->show_crm();
			
			$this->data['quarter'] = $quarter;
			$this->data['year_selected'] = $year;
			$this->data['based'] = $based;
			
			$this->data['page'] = 'report/list_crm_report_selected';
			$this->load->view('common/body', $this->data);
		}else{
			redirect($_SERVER['HTTP_REFERER']);	
		}
	}
	
	function get_crm_information($id){
		$this->data['crm_information'] = $this->project_model->show_crm_information_by_id($id);
		$this->load->view('project/get_crm_info',$this->data);
	}
	
	function edit_crm_information($id){
		$description = $this->input->post('description');
		$this->project_model->edit_crm_information($id,$description);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function delete_crm_information($project_id){
		$this->project_model->delete_crm_information($project_id);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	//project goal info
	function do_add_project_goal_information($project_goal_id){
		$description = $this->input->post('description');
		$input_date = date('Y-m-d');
		$input_by = $this->session->userdata('employee_id');
		$this->project_model->do_add_project_goal_information($project_goal_id,$description,$input_date,$input_by);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function get_project_goal_information($id){
		$this->data['project_goal_information'] = $this->project_model->show_project_goal_information_by_id($id);
		$this->load->view('project/get_project_goal_info',$this->data);
	}
	
	function edit_project_goal_information($id){
		$description = $this->input->post('description');
		$this->project_model->edit_project_goal_information($id,$description);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function delete_project_goal_information($project_id){
		$this->project_model->delete_project_goal_information($project_id);
	 redirect($_SERVER['HTTP_REFERER'].'#project_invoice_tab_site');
	}
	
	//quotation
	function add_quotation(){
		$project_id = $this->input->post('project_id');
		$quotation_date = $this->input->post('quotation_date');
		$delivery_date = $this->input->post('delivery_date');
		$payment_term = $this->input->post('payment_term');
		$is_ppn = $this->input->post('is_ppn');
		$currency_type = $this->input->post('currency_type');
		$notes = $this->input->post('notes');
		$unique_number = substr(md5(time().uniqid()),0,7);
		$created_date = date("Y-m-d H:i:s");
		$created_by = $this->session->userdata('employee_id');
		
		//GSI(namaPT)/03(bulan)/IW(Inisial Sales)/1(Urutan quotation)
		//quotation number
		$user_detail = $this->project_model->get_user_detail($this->session->userdata('employee_id'));
		$number = find_number_quotation()+1;
		$month = date('m');
		$year = date('Y');
		
		if($this->session->userdata('admin_id')==1){
			$quotation_number = strtoupper("GSI/".date('m')."/ADM1/".$number);
		}else{
			$quotation_number = strtoupper($user_detail['alias']."/".date('m')."/".substr($user_detail['firstname'],0,1).substr($user_detail['lastname'],0,1).$user_detail['id']."/".$number);	
		}
		
		if(!$quotation_number || !$quotation_date)redirect('home');
		
		//insert into quotation tb
		$this->project_model->add_quotation($project_id,$quotation_number,$quotation_date,$is_ppn,$currency_type,$notes,$unique_number,$created_date,$created_by,$number,$month,$year,$delivery_date,$payment_term);
		$quotation_id = mysql_insert_id();
		
		
		$subtotal=0;
		$total=0;
		//get item and service data
		//product
		$item_product_total = $this->input->post('item_product_total');
		$type=1;
		for($i=1;$i<=$item_product_total;$i++){
			$item = $this->input->post('item1_'.$i);
			$desc = $this->input->post('desc1_'.$i);
			$qty = str_replace(",","",$this->input->post('qty1_'.$i));
			$unit_type = $this->input->post('unit_type1_'.$i);
			$price1 = str_replace(",","",$this->input->post('price1_'.$i));
			$disc1 = str_replace(",","",$this->input->post('disc1_'.$i));
			$total1 = str_replace(",","",$this->input->post('total1_'.$i));
			//insert to quotation item
			if($item && $price1 && $qty){
				$this->project_model->add_quotation_item($quotation_id,$item,$desc,$qty,$unit_type,$price1,$disc1,$total1,$type,$created_date);
				$subtotal+=($price1*$qty)-$disc1;
			}
		}
		//service
		$item_service_total = $this->input->post('service_product_total');
		$type=2;
		for($i=1;$i<=$item_service_total;$i++){
			$item = $this->input->post('item2_'.$i);
			$desc = $this->input->post('desc2_'.$i);
			$qty = str_replace(",","",$this->input->post('qty2_'.$i));
			$price2 = str_replace(",","",$this->input->post('price2_'.$i));
			$disc2 = str_replace(",","",$this->input->post('disc2_'.$i));
			$unit_type = $this->input->post('unit_type2_'.$i);
			$total2 = str_replace(",","",$this->input->post('total2_'.$i));
			//insert to quotation item
			if($item && $price2 && $qty){
				$this->project_model->add_quotation_item($quotation_id,$item,$desc,$qty,$unit_type,$price2,$disc2,$total2,$type,$created_date);
				$subtotal+=($price2*$qty)-$disc2;
			}
		}
		
		//update subtotal and total
		
		$subtotal = str_replace(",","",$this->input->post('subtotal3'));
		$discount = str_replace(",","",$this->input->post('discount'));
		$ppn = str_replace(",","",$this->input->post('ppn3'));
		$total = str_replace(",","",$this->input->post('total3'));
		$discount_value = str_replace(",","",$this->input->post('disc3'));
		$this->project_model->set_total_in_quotation($quotation_id,$subtotal,$discount,$discount_value,$ppn,$total);
		
		//insert to log
		$data_json = json_encode($_POST);
		$this->project_model->add_quotation_log($quotation_id,$data_json,$created_by,$created_date);
		
		redirect($_SERVER['HTTP_REFERER']."#project_quotation_tab_site");
	}
	
	function add_po_client(){
		$project_id = $this->input->post('project_id');
		$po_number = $this->input->post('po_number');
		$po_date = $this->input->post('po_date');
		$delivery_date = $this->input->post('delivery_date');
		$payment_term = $this->input->post('payment_term');
		$is_ppn = $this->input->post('is_ppn');
		$currency_type = $this->input->post('currency_type');
		$notes = $this->input->post('notes');
		$unique_number = substr(md5(time().uniqid()),0,7);
		$created_date = date("Y-m-d H:i:s");
		$created_by = $this->session->userdata('employee_id');
		
		$config['upload_path'] = "userdata/client_po/";
		$config['allowed_types'] = 'doc|docx|xls|xlsx';
		$config['encrypt_name'] = TRUE;
		
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		$po_file='';
		if($this->upload->do_upload('po_file')){
			
			$file_data=$this->upload->data();
			$po_file = $file_data['file_name'];
		}
		//echo $this->upload->display_errors('<p>', '</p>');
		if(!$po_number || !$po_date)redirect($_SERVER['HTTP_REFERER']);
		
		//insert into quotation tb
		$this->project_model->add_po_client($project_id,$po_number,$po_date,$is_ppn,$currency_type,$notes,$unique_number,$created_date,$created_by,$delivery_date,$payment_term,$po_file);
		$po_client_id = mysql_insert_id();
		
		
		$subtotal=0;
		$total=0;
		//get item and service data
		//product
		$item_product_total = $this->input->post('item_product_total');
		$type=1;
		for($i=1;$i<=$item_product_total;$i++){
			$item = $this->input->post('item1_'.$i);
			$desc = $this->input->post('desc1_'.$i);
			$qty = str_replace(",","",$this->input->post('qty1_'.$i));
			$unit_type = $this->input->post('unit_type1_'.$i);
			$price1 = str_replace(",","",$this->input->post('price1_'.$i));
			$disc1 = str_replace(",","",$this->input->post('disc1_'.$i));
			$total1 = str_replace(",","",$this->input->post('total1_'.$i));
			$total_po1 = str_replace(",","",$this->input->post('total_po1_'.$i));
			//insert to quotation item
			if($item && $price1 && $qty){
				$this->project_model->add_po_client_item($po_client_id,$item,$desc,$qty,$unit_type,$price1,$disc1,$total1,$type,$created_date,$total_po1);
				$subtotal+=($price1*$qty)-$disc1;
			}
		}
		//service
		$item_service_total = $this->input->post('service_product_total');
		$type=2;
		for($i=1;$i<=$item_service_total;$i++){
			$item = $this->input->post('item2_'.$i);
			$desc = $this->input->post('desc2_'.$i);
			$qty = str_replace(",","",$this->input->post('qty2_'.$i));
			$price2 = str_replace(",","",$this->input->post('price2_'.$i));
			$disc2 = str_replace(",","",$this->input->post('disc2_'.$i));
			$unit_type = $this->input->post('unit_type2_'.$i);
			$total2 = str_replace(",","",$this->input->post('total2_'.$i));
			$total_po2 = str_replace(",","",$this->input->post('total_po2_'.$i));
			//insert to quotation item
			if($item && $price2 && $qty){
				$this->project_model->add_po_client_item($po_client_id,$item,$desc,$qty,$unit_type,$price2,$disc2,$total2,$type,$created_date,$total_po2);
				$subtotal+=($price2*$qty)-$disc2;
			}
		}
		
		//update subtotal and total
		
		$subtotal = str_replace(",","",$this->input->post('subtotal3'));
		$discount = str_replace(",","",$this->input->post('discount'));
		$ppn = str_replace(",","",$this->input->post('ppn3'));
		$total = str_replace(",","",$this->input->post('total3'));
		$discount_value = str_replace(",","",$this->input->post('disc3'));
		$this->project_model->set_total_in_po_client($po_client_id,$subtotal,$discount,$discount_value,$ppn,$total);
		
		redirect($_SERVER['HTTP_REFERER']."#project_quotation_tab_site");
	}
	
	function edit_po_client(){
		$project_goal_po_client_id = $this->input->post('project_goal_po_client_id');
		$po_number = $this->input->post('po_number');
		$po_date = $this->input->post('po_date');
		$delivery_date = $this->input->post('delivery_date');
		$payment_term = $this->input->post('payment_term');
		$is_ppn = $this->input->post('is_ppn');
		$currency_type = $this->input->post('currency_type');
		$notes = $this->input->post('notes');
		$updated_date = date("Y-m-d H:i:s");
		$updated_by = $this->session->userdata('employee_id');
		
		
		if(!$po_number || !$po_date)redirect($_SERVER['HTTP_REFERER']);
		
		
		$po_client = $this->project_model->show_po_client_project_detail($project_goal_po_client_id);
		
		$config['upload_path'] = "userdata/client_po/";
		$config['allowed_types'] = 'doc|docx|xls|xlsx';
		$config['encrypt_name'] = TRUE;
		
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		$po_file=$po_client['po_file'];
		if($this->upload->do_upload('po_file')){
			$addr='userdata/client_po/'.$po_file;
			if(file_exists($addr))unlink($addr);
			
			$file_data=$this->upload->data();
			$po_file = $file_data['file_name'];
		}
		//update po client tb
		$this->project_model->edit_po_client($project_goal_po_client_id,$po_number,$po_date,$is_ppn,$currency_type,$notes,$updated_date,$updated_by,$delivery_date,$payment_term,$po_file);
		
		//get item and service data
		//product
		$item_product_total = $this->input->post('item_product_total');
		$type=1;
		for($i=1;$i<=$item_product_total;$i++){
			$project_goal_po_client_item_id = $this->input->post('po_client_item_id1_'.$i);
			$item = $this->input->post('item1_'.$i);
			$desc = $this->input->post('desc1_'.$i);
			$qty = str_replace(",","",$this->input->post('qty1_'.$i));
			$unit_type = $this->input->post('unit_type1_'.$i);
			$price1 = str_replace(",","",$this->input->post('price1_'.$i));
			$disc1 = str_replace(",","",$this->input->post('disc1_'.$i));
			$total1 = str_replace(",","",$this->input->post('total1_'.$i));
			$total_po1 = str_replace(",","",$this->input->post('total_po1_'.$i));
			//insert to quotation item
			if($item && $price1 && $qty){
				if($project_goal_po_client_item_id){
					$this->project_model->edit_po_client_item($project_goal_po_client_item_id,$item,$desc,$qty,$unit_type,$price1,$disc1,$total1,$type,$updated_date,$total_po1);
				}else{
					$this->project_model->add_po_client_item($project_goal_po_client_id,$item,$desc,$qty,$unit_type,$price1,$disc1,$total1,$type,$updated_date,$total_po1);
				}
			}
			else
					$this->project_model->remove_po_client_item($project_goal_po_client_item_id);
		}
		//service
		$item_service_total = $this->input->post('service_product_total');
		$type=2;
		for($i=1;$i<=$item_service_total;$i++){
			$project_goal_po_client_item_id = $this->input->post('po_client_item_id2_'.$i);
			$item = $this->input->post('item2_'.$i);
			$desc = $this->input->post('desc2_'.$i);
			$qty = str_replace(",","",$this->input->post('qty2_'.$i));
			$price2 = str_replace(",","",$this->input->post('price2_'.$i));
			$disc2 = str_replace(",","",$this->input->post('disc2_'.$i));
			$unit_type = $this->input->post('unit_type2_'.$i);
			$total2 = str_replace(",","",$this->input->post('total2_'.$i));
			$total_po2 = str_replace(",","",$this->input->post('total_po2_'.$i));
			//insert to quotation item
			if($item && $price2 && $qty){
				if($project_goal_po_client_item_id){
					$this->project_model->edit_po_client_item($project_goal_po_client_item_id,$item,$desc,$qty,$unit_type,$price2,$disc2,$total2,$type,$updated_date,$total_po2);
				}else{
					$this->project_model->add_po_client_item($project_goal_po_client_id,$item,$desc,$qty,$unit_type,$price2,$disc2,$total2,$type,$updated_date,$total_po2);
				}
			}else
					$this->project_model->remove_po_client_item($project_goal_po_client_item_id);
		}
		
		//update subtotal and total
		
		$subtotal = str_replace(",","",$this->input->post('subtotal3'));
		$discount = str_replace(",","",$this->input->post('discount'));
		$ppn = str_replace(",","",$this->input->post('ppn3'));
		$total = str_replace(",","",$this->input->post('total3'));
		$discount_value = str_replace(",","",$this->input->post('disc3'));
		$this->project_model->set_total_in_po_client($project_goal_po_client_id,$subtotal,$discount,$discount_value,$ppn,$total);
		
		$_SESSION['notif'] = "PO Client updated.";
		
		redirect($_SERVER['HTTP_REFERER']."#project_quotation_tab_site");
	}
	
	function edit_quotation(){
		$project_goal_quotation_id = $this->input->post('project_goal_quotation_id');
		$quotation_date = $this->input->post('quotation_date');
		$delivery_date = $this->input->post('delivery_date');
		$payment_term = $this->input->post('payment_term');
		$is_ppn = $this->input->post('is_ppn');
		$currency_type = $this->input->post('currency_type');
		$notes = $this->input->post('notes');
		$created_date = date("Y-m-d H:i:s");
		$created_by = $this->session->userdata('employee_id');
		
		//updatequotation tb
		$this->project_model->update_quotation($project_goal_quotation_id,$quotation_date,$is_ppn,$currency_type,$notes,$created_date,$created_by,$delivery_date,$payment_term);
		
		//get item and service data
		//product
		$item_product_total = $this->input->post('item_product_total');
		$type=1;
		for($i=1;$i<=$item_product_total;$i++){
			$itemid = $this->input->post('itemid1_'.$i);
			$item = $this->input->post('item1_'.$i);
			$desc = $this->input->post('desc1_'.$i);
			$qty = str_replace(",","",$this->input->post('qty1_'.$i));
			$unit_type = $this->input->post('unit_type1_'.$i);
			$price = str_replace(",","",$this->input->post('price1_'.$i));
			$disc = str_replace(",","",$this->input->post('disc1_'.$i));
			$total = str_replace(",","",$this->input->post('total1_'.$i));
			//insert to quotation item
			if(!$itemid && $item){
				$this->project_model->add_quotation_item($project_goal_quotation_id,$item,$desc,$qty,$unit_type,$price,$disc,$total,$type,$created_date);
			}else{
				$this->project_model->edit_quotation_item($itemid,$item,$desc,$qty,$unit_type,$price,$disc,$total,$type,$created_date);
			}
		}
		//service
		$item_service_total = $this->input->post('service_product_total');
		$type=2;
		for($i=1;$i<=$item_service_total;$i++){
			$itemid = $this->input->post('itemid2_'.$i);
			$item = $this->input->post('item2_'.$i);
			$desc = $this->input->post('desc2_'.$i);
			$qty = str_replace(",","",$this->input->post('qty2_'.$i));
			$price = str_replace(",","",$this->input->post('price2_'.$i));
			$disc = str_replace(",","",$this->input->post('disc2_'.$i));
			$unit_type = $this->input->post('unit_type2_'.$i);
			$total = str_replace(",","",$this->input->post('total2_'.$i));
			//insert to quotation item
			if(!$itemid && $item){
				$this->project_model->add_quotation_item($project_goal_quotation_id,$item,$desc,$qty,$unit_type,$price,$disc,$total,$type,$created_date);
			}else{
				$this->project_model->edit_quotation_item($itemid,$item,$desc,$qty,$unit_type,$price,$disc,$total,$type,$created_date);
			}
		}
		
		//update subtotal and total
		
		$subtotal = str_replace(",","",$this->input->post('subtotal3'));
		$discount = str_replace(",","",$this->input->post('discount'));
		$ppn = str_replace(",","",$this->input->post('ppn3'));
		$total = str_replace(",","",$this->input->post('total3'));
		$discount_value = str_replace(",","",$this->input->post('disc3'));
		$this->project_model->set_total_in_quotation($project_goal_quotation_id,$subtotal,$discount,$discount_value,$ppn,$total);
		
		//insert to log
		$data_json = json_encode($_POST);
		$this->project_model->add_quotation_log($project_goal_quotation_id,$data_json,$created_by,$created_date);
		
		redirect($_SERVER['HTTP_REFERER']."#project_quotation_tab_site");
	}
	
	function item_history_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'item';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*";
		$where = "where item != ''";
		if ($query) $where.= " and $qtype LIKE '%$query%' ";
		$tname="project_goal_quotation_item_tb";
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
			$json .= "'".esc($row['item'])."'";
			$json .= ",'".number_format(esc($row['price']))."'";
			$json .= ",'".esc($row['discount'])."'";
			$json .= ",'".esc($row['quantity'])."'";
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
	}
	
	function print_quotation($quotation_id){
		
		//$content=$this->load->view('content/replenishment/final_po_excel',$this->data,TRUE);
		
		$email_content = '';
		$this->data['quotation_detail'] = $quotation_detail = $this->project_model->get_quotation_detail($quotation_id);
		$this->data['quotation_item'] = $this->project_model->show_quotation_item($quotation_detail['id']);
	
		$email_content = $this->load->view('project/send_email_quotation_pdf',$this->data,TRUE);

		require_once(APPPATH.'libraries/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','fr');
		$html2pdf->WriteHTML($email_content);
		$html2pdf->Output('quotation.pdf');
	}
	
	function send_email_quotation($quotation_id,$approval_level){
		if($approval_level==1){
			$approval_level = 0;
			//change approval if quotation get revision
			$this->project_model->update_quotation_revision_to_waiting($quotation_id,$approval_level);
		}
		$email_content = '';
		$this->data['quotation_detail'] = $quotation_detail = $this->project_model->get_quotation_detail($quotation_id);
		$this->data['quotation_item'] = $this->project_model->show_quotation_item($quotation_detail['id']);
		
		$this->data['po_client_detail'] = '';
		$this->data['po_client_item'] = '';
		
		///////////////
		$leader_id = find_2('leader_id','employee_id',$quotation_detail['created_by'],'employee_group_tb');
		$this->data['leader_id'] = $leader_id;
		$this->data['leader_password'] = $leader_password = find_2('password','employee_id',$leader_id,'administrator_tb');
		
		$leader_email = find('email',$leader_id,'employee_tb');
		$from = find('email',$quotation_detail['created_by'],'employee_tb');
		$to_email = $leader_email;
		$this->data['approval_level'] = 2;
		
		$email_content = $this->load->view('project/send_email_quotation',$this->data,TRUE);
		$subject = "Quotation - ".$quotation_detail['quotation_number'];
		
		//echo $email_content;exit;
		
		$this->load->library('email'); 
		$this->email->from($from);
		$this->email->to($to_email);
			
		$this->email->subject($subject);
		$this->email->message($email_content);  
		$this->email->send();
		//echo $this->email->print_debugger();exit;
		
		$_SESSION['notif'] = 'Quotation approval email has been sent.';
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function send_email_quotation_2($quotation_id,$approval_level,$po_client_id){
		$email_content = '';
		$this->data['quotation_detail'] = $quotation_detail = $this->project_model->get_quotation_detail($quotation_id);
		$this->data['quotation_item'] = $quotation_item_detail = $this->project_model->get_quotation_item_detail($quotation_id);
		
		$this->data['po_client_detail'] = $po_client_detail = $this->project_model->get_po_client_detail($po_client_id);
		$this->data['po_client_item'] = $po_client_item_detail = $this->project_model->get_po_client_item_detail($po_client_id);
		
		///////////////
		$leader_id = find_2('leader_id','employee_id',$quotation_detail['created_by'],'employee_group_tb');
		$ledaer_id = find_2('leader_id','employee_id',$leader_id,'employee_group_tb');
		$this->data['leader_id'] = $leader_id;
		$this->data['leader_password'] = $leader_password = find_2('password','employee_id',$leader_id,'administrator_tb');
		
		$leader_email = find('email',$leader_id,'employee_tb');
		$from = find('email',$quotation_detail['created_by'],'employee_tb');
		$to_email = $leader_email;
		$this->data['approval_level'] = 3;
		
		$email_content = $this->load->view('project/send_email_quotation',$this->data,TRUE);
		$subject = "Quotation - ".$quotation_detail['quotation_number'];
		
		//echo $email_content;exit;
		
		$this->load->library('email'); 
		$this->email->from($from);
		$this->email->to($to_email);
			
		$this->email->subject($subject);
		$this->email->message($email_content);  
		$this->email->send();
		
		$_SESSION['notif'] = 'Quotation approval email has been sent.';
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function do_add_project_quotation_payment($goal_id){
		$quotation_id = $this->input->post('quotation_id');
		$dp = $this->input->post('dp');
		$transfer_date = $this->input->post('transfer_date');
		$bank = $this->input->post('bank');
		$notes = $this->input->post('notes');
		
		if($goal_id && $quotation_id && $dp && $transfer_date && $bank){
			$this->project_model->do_add_project_quotation_payment($goal_id,$quotation_id,$dp,$transfer_date,$bank,$notes);
			$_SESSION['notif'] = "Payment has been added and sent.";
			
			$payment_id = mysql_insert_id();
			///////////////
			$this->data['payment_detail'] = $this->project_model->get_payment_detail($payment_id);
			$leader_id = find_2('leader_id','employee_id',$this->session->userdata('employee_id'),'employee_group_tb');
			$this->data['leader_id'] = $leader_id;
			$this->data['leader_password'] = $leader_password = find_2('password','employee_id',$leader_id,'administrator_tb');
			
			$leader_email = find('email',$leader_id,'employee_tb');
			$from = find('email',$this->session->userdata('employee_id'),'employee_tb');
			$to_email = $leader_email;
			
			$email_content = $this->load->view('project/send_email_quotation_payment',$this->data,TRUE);
			$subject = "Quotation Payment - ".find('quotation_number',$quotation_id,'project_goal_quotation_tb');
			
			$this->load->library('email'); 
			$this->email->from($from);
			$this->email->to($to_email);
				
			$this->email->subject($subject);
			$this->email->message($email_content);  
			$this->email->send();
			
		}else{
			$_SESSION['notif'] = "Please insert quotation, dp, transfer date and bank to complete the payment.";	
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function do_edit_project_quotation_payment($id){
		$dp = $this->input->post('dp');
		$transfer_date = $this->input->post('transfer_date');
		$bank = $this->input->post('bank');
		$notes = $this->input->post('notes');
		
		if($id && $dp && $transfer_date && $bank){
			$this->project_model->do_edit_project_quotation_payment($id,$dp,$transfer_date,$bank,$notes);
			$_SESSION['notif'] = "Payment has been update.";
			
			///////////////
			$this->data['payment_detail'] = $payment_detail = $this->project_model->get_payment_detail($id);
			$leader_id = find_2('leader_id','employee_id',$this->session->userdata('employee_id'),'employee_group_tb');
			$this->data['leader_id'] = $leader_id;
			$this->data['leader_password'] = $leader_password = find_2('password','employee_id',$leader_id,'administrator_tb');
			
			$leader_email = find('email',$leader_id,'employee_tb');
			$from = find('email',$this->session->userdata('employee_id'),'employee_tb');
			$to_email = $leader_email;
			
			$email_content = $this->load->view('project/send_email_quotation_payment',$this->data,TRUE);
			$subject = "Quotation Payment (update) - ".$payment_detail['quotation_number'];
			
			$this->load->library('email'); 
			$this->email->from($from);
			$this->email->to($to_email);
				
			$this->email->subject($subject);
			$this->email->message($email_content);  
			$this->email->send();
		}else{
			$_SESSION['notif'] = "Please insert quotation, dp, transfer date and bank to complete update the payment.";	
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function get_add_po_non_stock($project_id){
		$this->data['project_id'] = $project_id;
		
		//project client po
		$this->data['po_client'] = $po_client = $this->project_model->get_project_po_client($project_id);
		$this->data['po_client_item'] = $this->project_model->get_project_po_client_item($po_client['id']);
		
		$content = $this->load->view('project/add_po_non_stock',$this->data);
		echo $content;	
	}
	
	function get_update_po_non_stock($po_id,$project_id){
		//project client po
		$this->data['po_client'] = $po_client = $this->project_model->get_project_po_client($project_id);
		$this->data['po_client_item'] = $this->project_model->get_project_po_client_item($po_client['id']);
		
		$this->data['po_detail'] = $this->project_model->get_po_non_stock_detail($po_id);
		$this->data['po_item'] = $this->project_model->get_po_non_stock_item($po_id);
		
		$content = $this->load->view('project/update_po_non_stock',$this->data);
		
		echo $content;
		
	}
	
	function get_add_po_stock($project_id){
		
		$this->data['project_id'] = $project_id;
		
		//project client po
		$this->data['warehouse_list'] = $this->warehouse_model->show_warehouse();
		$this->data['po_client'] = $po_client = $this->project_model->get_project_po_client($project_id);
		$this->data['po_client_item'] = $this->project_model->get_project_po_client_item($po_client['id']);
		
		//inventory stock list
		$this->data['stock_list'] = $this->project_model->get_stock_list();
		
		
		$content = $this->load->view('project/add_po_stock',$this->data);
		echo $content;	
	}
	
	function get_update_po_stock($po_id,$project_id){
		//project client po
		
		
		$this->data['po_client'] = $po_client = $this->project_model->get_project_po_client($project_id);
		
		$this->data['po_client_item'] = $this->project_model->get_project_po_client_item($po_client['id']);
		
		//inventory stock list
	
		
		$this->data['po_detail'] = $this->project_model->get_po_stock_detail($po_id);
		$this->data['po_item'] = $data= $this->project_model->get_po_stock_item($po_id);
		$this->data['warehouse_list'] = $this->warehouse_model->show_warehouse();
		
		
		
		
		
		$content = $this->load->view('project/update_po_stock',$this->data);
		
		echo $content;
		
	}
	
	function add_po_stock(){
		$this->load->model('rak_model');
	
		$project_id = esc($this->input->post('project_id'));
		$request_date = esc($this->input->post('request_date'));
		$notes = esc($this->input->post('notes'));
		$total = esc(str_replace(",","",$this->input->post('total3')));
		$created_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userdata('employee_id');
		
		//insert stock
		if(!$project_id || !$request_date){
			$_SESSION['notif'] = 'Request Stock Failed.';	
		}else{
		$this->load->model('budget_model');
		$user_detail = $this->budget_model->get_user_detail($this->session->userdata('employee_id'));
		$number = find_number_receive()+1;
		$month = date('m');
		$year = date('Y');
		if($this->session->userdata('admin_id')==1){
			$receive_number = strtoupper("RI/".date('m')."/ADM1/".$number);
		}else{
			$receive_number = strtoupper("RI/".date('m')."/".substr($user_detail['firstname'],0,1).substr($user_detail['lastname'],0,1).$user_detail['id']."/".$number);	
		}
		
		//add receive
		$this->project_model->add_receive2($project_id,$receive_number,$request_date,$created_date,$created_by,$month,$year,$number,'-');
		$receive_id=mysql_insert_id();
		
		
		
			$this->project_model->add_po_stock($project_id,$request_date,$total,$notes,$created_date,$created_by);
			$projet_goal_request_stock_id = mysql_insert_id();
			
	
			
			$item_product_total = $this->input->post('item_product_total');
			for($i=1;$i<=$item_product_total;$i++){
				$item_new = esc($this->input->post('item1_'.$i));
				$data_item=explode("|", $item_new);
			
				if($item_new!=''){
				$item=trim($data_item[1]);
				$stock_id=$this->input->post('stock1_'.$i);
				$stock_detail=$this->rak_model->show_stock_detail($stock_id);
				$warehouse_id=$stock_detail['warehouse_id'];
				$rak_id=$stock_detail['rak_id'];
				}else{
				$item='';
				}
			
				$stock = esc($this->input->post('stock1_'.$i));
				$desc = esc($this->input->post('desc1_'.$i));
				$qty = str_replace(",","",$this->input->post('qty1_'.$i));
				$unit_type = esc($this->input->post('unit_type1_'.$i));
				
				
				$price=0;
				if($stock!=0)
				//$price = str_replace(",","",$this->input->post('price1_'.$i));
				$price=find('price',esc($stock),'stock_tb');
	
				//
				$total = str_replace(",","",$this->input->post('total1_'.$i));
				//insert to quotation item
				
				if($item && $stock && $qty>0){
					$this->project_model->add_request_stock_item2($warehouse_id,$rak_id,$projet_goal_request_stock_id,$item,$stock,$desc,$qty,$unit_type,$price,$total);
					$request_id_project=mysql_insert_id();
						$this->project_model->add_receive_item2($receive_id,0,$request_id_project,0,$qty,$created_date,$created_by,$warehouse_id,$rak_id);
					//cut stock
					$qty_sebelumnya=find('quantity',$stock,'stock_tb');
					$this->project_model->cut_stock($stock,$qty);
					$quantity_sekarang=find('quantity',$stock,'stock_tb');
					
					$database2=array('project_id'=>$project_id,'qty_before'=>$qty_sebelumnya,'stock_id'=>$item,'warehouse_id'=>$warehouse_id,'rak_id'=>$rak_id,'in_qty'=>0,'out_qty'=>$qty,'total'=>$quantity_sekarang,'price'=>$price,'created_date'=>$created_date,'invoice_number'=>'-');
					$this->general_model->insert_data('history_delivery_received_tb',$database2);			
				}
			}
			
			$_SESSION['notif'] = 'Request Stock Success.';
		}
		
		redirect($_SERVER['HTTP_REFERER']."#purchase_order_tab_site");
	}
	
	function edit_po_stock(){

		$po_id = esc($this->input->post('id'));	
		$request_date = esc($this->input->post('request_date'));
		$notes = esc($this->input->post('notes'));
		$total = esc(str_replace(",","",$this->input->post('total3')));
		$updated_date = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('employee_id');
		
		//insert stock
		if(!$request_date){
			$_SESSION['notif'] = 'Update Request Stock Failed.';	
		}else{
			$this->project_model->update_po_stock($po_id,$request_date,$total,$notes,$updated_date,$updated_by);
			
			$item_product_total = $this->input->post('item_product_total');
			for($i=1;$i<=$item_product_total;$i++){
				$warehouse_id=esc($this->input->post('warehouse1_'.$i));
				$rak_id=esc($this->input->post('rak1_'.$i));
				$po_item_id = esc($this->input->post('po_id_'.$i));
				$item = esc($this->input->post('item1_'.$i));
				$stock = esc($this->input->post('stock1_'.$i));
				$desc = esc($this->input->post('desc1_'.$i));
				$qty = str_replace(",","",$this->input->post('qty1_'.$i));
				$qty_old = str_replace(",","",$this->input->post('qty1_old_'.$i));
				$unit_type = esc($this->input->post('unit_type1_'.$i));
				$price = str_replace(",","",$this->input->post('price1_'.$i));
				$total = str_replace(",","",$this->input->post('total1_'.$i));
				//insert to quotation item
				
				if($item && $stock && $qty>0){
					if($po_item_id){
						$this->project_model->update_request_stock_item2($warehouse_id,$rak_id,$po_item_id,$item,$stock,$desc,$qty,$unit_type,$price,$total);
						
						$qty_now = -($qty_old-$qty);
						//cut stock
						$this->project_model->cut_stock($stock,$qty_now);
					}else{
						$this->project_model->add_request_stock_item2($warehouse_id,$rak_id,$po_id,$item,$stock,$desc,$qty,$unit_type,$price,$total);
						//cut stock
						$this->project_model->cut_stock($stock,$qty);
					}
				}else{ //remove item
					if($po_item_id){
						$this->project_model->remove_request_stock_item($po_item_id);
						
						//add stock
						$this->project_model->cut_stock($stock,-$qty);
					}
				}
			}
			
			$_SESSION['notif'] = 'Request Stock Updated.';
		}
		
		redirect($_SERVER['HTTP_REFERER']."#purchase_order_tab_site");
	}
	
	function add_po_non_stock(){
		$project_id = esc($this->input->post('project_id'));
		$vendor_id = esc($this->input->post('vendor_id'));
		$po_date = esc($this->input->post('po_date'));
		$delivery_date = esc($this->input->post('delivery_date'));
		$payment_term = esc($this->input->post('payment_term'));
		$is_ppn = esc($this->input->post('is_ppn'));
		$currency_type = esc($this->input->post('currency_type'));
		$created_date = date('Y-m-d H:i:s');
		$notes = esc($this->input->post('notes'));
		
		$user_detail = $this->project_model->get_user_detail($this->session->userdata('employee_id'));
		$number = find_number_po()+1;
		$month = date('m');
		$year = date('Y');
		if($this->session->userdata('admin_id')==1){
			$po_number = "PO/".strtoupper("GSI/".date('m')."/ADM/".$number);
		}else{
			$po_number = "PO/".strtoupper($user_detail['alias']."/".date('m')."/".substr($user_detail['firstname'],0,1).substr($user_detail['lastname'],0,1).$user_detail['id']."/".$number);
		}
		
		$this->project_model->add_po_non_stock($project_id,$vendor_id,$po_number,$po_date,$delivery_date,$payment_term,$is_ppn,$currency_type,$created_date,$month,$year,$number,$notes);
		$po_id = mysql_insert_id();
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
			
			//insert to po item
			if($itemid){
				$this->project_model->add_po_item($po_id,$itemid,$desc,$qty,$unit_type,$price,$disc,$total);
			}
		}
		
		$subtotal = str_replace(",","",$this->input->post('subtotal3'));
		$discount = str_replace(",","",$this->input->post('discount'));
		$ppn = str_replace(",","",$this->input->post('ppn3'));
		$total = str_replace(",","",$this->input->post('total3'));
		$discount_value = str_replace(",","",$this->input->post('disc3'));
		$this->project_model->set_total_in_po($po_id,$subtotal,$discount,$discount_value,$ppn,$total);
		$_SESSION['notif'] = 'PO created.';
		redirect($_SERVER['HTTP_REFERER']."#purchase_order_tab_site");
	}
	
	function edit_po_non_stock(){
		$po_id = esc($this->input->post('id'));
		$vendor_id = esc($this->input->post('vendor_id'));
		$po_date = esc($this->input->post('po_date'));
		$delivery_date = esc($this->input->post('delivery_date'));
		$payment_term = esc($this->input->post('payment_term'));
		$is_ppn = esc($this->input->post('is_ppn'));
		$currency_type = esc($this->input->post('currency_type'));
		$updated_date = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('employee_id');
		$notes = esc($this->input->post('notes'));
		
		//total
		$subtotal = str_replace(",","",$this->input->post('subtotal3'));
		$discount = str_replace(",","",$this->input->post('discount'));
		$ppn = str_replace(",","",$this->input->post('ppn3'));
		$total = str_replace(",","",$this->input->post('total3'));
		$discount_value = str_replace(",","",$this->input->post('disc3'));
		
		$this->project_model->edit_po_non_stock($po_id,$vendor_id,$po_date,$delivery_date,$payment_term,$is_ppn,$currency_type,$updated_date,$updated_by,$notes,$subtotal,$discount,$discount_value,$ppn,$total);
		//get item and service data
		//product
		$item_product_total = $this->input->post('item_product_total');
		for($i=1;$i<=$item_product_total;$i++){
			$po_item_id = esc($this->input->post('po_id_'.$i));
			$itemid = $this->input->post('itemid1_'.$i);
			$desc = $this->input->post('desc1_'.$i);
			$qty = str_replace(",","",$this->input->post('qty1_'.$i));
			$unit_type = $this->input->post('unit_type1_'.$i);
			$price = str_replace(",","",$this->input->post('price1_'.$i));
			$disc = str_replace(",","",$this->input->post('disc1_'.$i));
			$total = str_replace(",","",$this->input->post('total1_'.$i));
			
			//insert to po item
			if($itemid){
				if($po_item_id){ //edit
					$this->project_model->update_po_item($po_item_id,$itemid,$desc,$qty,$unit_type,$price,$disc,$total);
				}else{ //add
					$this->project_model->add_po_item($po_id,$itemid,$desc,$qty,$unit_type,$price,$disc,$total);
				}
			}else{
				if($po_item_id){ //remove item
					$this->project_model->remove_po_item($po_item_id);
				}
			}
		}
		
		$_SESSION['notif'] = 'PO Updated.';
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function get_budget_bs($project_id){
		$this->data['project_id'] = $project_id;
		
		//project client po
		$this->data['po_client'] = $po_client = $this->project_model->get_project_po_client($project_id);
		$this->data['po_client_item'] = $this->project_model->get_project_po_client_item_acc($po_client['id']);
		
		$content = $this->load->view('project/get_budget_bs',$this->data);
		echo $content;	
	}
	
	function get_update_budget($budget_id,$project_id){
		$this->data['budget_id'] = $budget_id;
		
		//project client po
		$this->data['po_client'] = $po_client = $this->project_model->get_project_po_client($project_id);
		$this->data['po_client_item'] = $this->project_model->get_project_po_client_item_acc($po_client['id']);
		
		$this->data['budget_detail'] = $this->project_model->get_budget_detail($budget_id);
		$this->data['budget_item'] = $this->project_model->get_budget_item($budget_id);
		
		$content = $this->load->view('project/get_update_budget',$this->data);
		echo $content;	
	}
	
	function request_budget(){
		$project_id = esc($this->input->post('project_id'));
		$request_date = esc($this->input->post('request_date'));
		$bs = esc($this->input->post('bs'));
		$notes = esc($this->input->post('notes'));
		//$total = esc(str_replace(',','',$this->input->post('subtotal1')));
		$total = esc(str_replace(",","",$this->input->post('total3')));
		$created_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userdata('employee_id');
		
		//request number
		$this->load->model('budget_model');
		$user_detail = $this->budget_model->get_user_detail($this->session->userdata('employee_id'));
		$number = find_number_request()+1;
		$month = date('m');
		$year = date('Y');
		
		if($this->session->userdata('admin_id')==1){
			$request_number = "RF/GSI/".date('m')."/ADM".$user_detail['id']."/".$number;
		}else{
			$request_number = "RF/".strtoupper($user_detail['alias']."/".date('m')."/".substr($user_detail['firstname'],0,1).substr($user_detail['lastname'],0,1).$user_detail['id']."/".$number);
		}
		
		//$project_id = esc($this->input->post('project_id'));
		//$request_date = esc($this->input->post('request_date'));
		//$notes = esc($this->input->post('notes'));
		//$total = esc(str_replace(",","",$this->input->post('total3')));
		//$created_date = date('Y-m-d H:i:s');
		//$created_by = $this->session->userdata('employee_id');
		//$bs = $this->input->post('bs');
		
		//insert budget
		if(!$project_id || !$request_date){
			$_SESSION['notif'] = 'Request Stock Failed.';	
		}else{
			$this->budget_model->insert_request_budget($project_id,$request_date,$bs,$notes,$total,$created_date,$created_by,$request_number,$month,$year,$number);
		
			$request_budget_id = mysql_insert_id();
			//$this->project_model->add_request_budget($project_id,$request_date,$total,$notes,$created_date,$created_by,$bs);
			//$projet_goal_request_budget_id = mysql_insert_id();
			
			
			$item_product_total = $this->input->post('item_product_total');
			for($i=1;$i<=$item_product_total;$i++){
				$item = esc($this->input->post('item1_'.$i));
				$desc = esc($this->input->post('desc1_'.$i));
				$vendor = esc($this->input->post('vendor1_'.$i));
				$qty = 1;
				$price = str_replace(",","",$this->input->post('price1_'.$i));
				$bank_name = esc($this->input->post('bank_name1_'.$i));
				$acc_name = esc($this->input->post('acc_name1_'.$i));
				$acc_number = esc($this->input->post('acc_number1_'.$i));
				//insert to quotation item
				
				if($item){
					$this->project_model->add_request_budget_item($request_budget_id,$item,$desc,$vendor,$qty,$price,$bank_name,$acc_name,$acc_number);
				}
			}
			
			$_SESSION['notif'] = 'Request Budget Success.';
		}
		
		redirect($_SERVER['HTTP_REFERER']."#budget_tab_site");
	}
	
	function approval_1_quotation($quotation_id){
		$this->data['quotation_detail'] = $quotation_detail = $this->project_model->get_quotation_detail($quotation_id);
		$this->project_model->change_quotation_status_to_approval($quotation_id,2);
		
		//insert approval log
		$data = array(
			'leader_id'=>$this->session->userdata('employee_id'),
			'status'=>2,
			'approval_date'=>date('Y-m-d H:i')
		);
		$approval_1_data = json_encode($data);
		$this->project_model->insert_approval_1_data($quotation_id,$approval_1_data);
			
		$_SESSION['notif']="Quotation Approved.";
			
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function approval_2_quotation($quotation_id){
		$this->data['quotation_detail'] = $quotation_detail = $this->project_model->get_quotation_detail($quotation_id);
		$this->project_model->change_quotation_status_to_approval($quotation_id,3);
		
		//set win
		$this->project_model->set_project_win_date($quotation_detail['project_id'],date('Y-m-d'));
		$this->project_model->insert_to_project_goal($quotation_detail['project_id']);
		
		//insert approval log
		$data = array(
			'leader_id'=>$this->session->userdata('employee_id'),
			'status'=>3,
			'approval_date'=>date('Y-m-d H:i')
		);
		$approval_1_data = json_encode($data);
		$this->project_model->insert_approval_2_data($quotation_id,$approval_1_data);
		
		$_SESSION['notif']=" Client PO Approved.";
		
		redirect($_SERVER['HTTP_REFERER']."#project_quotation_tab_site");
	}
	
	function approval_2_po($po_client_id){
		$this->data['po_detail'] = $po_detail = $this->project_model->get_po_client_detail($po_client_id);
		
		$this->project_model->change_po_client_status_to_approval($po_client_id,3);
		
		//set win
		//$this->project_model->set_project_win_date($quotation_detail['project_id'],date('Y-m-d'));
		//$this->project_model->insert_to_project_goal($quotation_detail['project_id']);
		
		//insert approval log
		$data = array(
			'approval_by'=>$this->session->userdata('employee_id'),
			'approval_date'=>date('Y-m-d H:i')
		);
		$approval_1_data = json_encode($data);
		$this->project_model->insert_approval_po_2_data($po_client_id,$approval_1_data);
		
		$_SESSION['notif']=" Client PO Approved.";
		
		redirect($_SERVER['HTTP_REFERER']."#project_quotation_tab_site");
	}
	
	function unapproval_2_po($po_client_id){
		$this->data['po_detail'] = $po_detail = $this->project_model->get_po_client_detail($po_client_id);
		$this->project_model->change_po_client_status_to_approval($po_client_id,0);
		
		//set win
		//$this->project_model->set_project_win_date($quotation_detail['project_id'],date('Y-m-d'));
		//$this->project_model->insert_to_project_goal($quotation_detail['project_id']);
		
		//insert approval log
		$data = array(
			'un_approval_by'=>$this->session->userdata('employee_id'),
			'un_approval_date'=>date('Y-m-d H:i')
		);
		$approval_1_data = json_encode($data);
		$this->project_model->insert_approval_po_2_data($po_client_id,$approval_1_data);
		
		$_SESSION['notif']=" Client PO Un-Approved.";
		
		redirect($_SERVER['HTTP_REFERER']."#project_quotation_tab_site");
	}
	
	function get_update_po($po_id){
		$this->data['show_all_stock']=$this->warehouse_model->show_all_stock();
		$this->data['po_client'] = $po_client = $this->project_model->show_po_client_project_detail($po_id);
		$this->data['po_client_item'] = $this->project_model->show_po_client_item_detail($po_client['id']);
		
		$content = $this->load->view('project/get_update_po',$this->data);
		echo $content;	
	}
	
	function update_request_budget(){
		$budget_id = esc($this->input->post('budget_id'));
		$settle_date = esc($this->input->post('settle_date'));
		$notes = esc($this->input->post('notes'));
		$total = esc(str_replace(",","",$this->input->post('total3')));
		$updated_date = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('employee_id');

		//insert budget
		if(!$budget_id || !$settle_date){
			$_SESSION['notif'] = 'Update Request Stock Failed.';	
		}else{
			$this->project_model->update_request_budget($budget_id,$settle_date,$notes,$total,$updated_date,$updated_by);
		
			$item_product_total = $this->input->post('item_product_total');
			for($i=1;$i<=$item_product_total;$i++){
				$budget_item_id = esc($this->input->post('budget_item_id1_'.$i));
				$item = esc($this->input->post('item1_'.$i));
				$desc = esc($this->input->post('desc1_'.$i));
				$vendor = esc($this->input->post('vendor1_'.$i));
				$qty = 1;
				$price = str_replace(",","",$this->input->post('price1_'.$i));
				$bank_name = esc($this->input->post('bank_name1_'.$i));
				$acc_name = esc($this->input->post('acc_name1_'.$i));
				$acc_number = esc($this->input->post('acc_number1_'.$i));
				//insert to quotation item
				
				if($budget_item_id){//update
					$this->project_model->update_request_budget_item($budget_item_id,$item,$desc,$vendor,$qty,$price,$bank_name,$acc_name,$acc_number);
				}else{
					if($item){
						$this->project_model->add_request_budget_item($budget_id,$item,$desc,$vendor,$qty,$price,$bank_name,$acc_name,$acc_number);
					}
				}
				
				
			}
			
			$_SESSION['notif'] = 'Request Budget Success.';
		}
		
		redirect($_SERVER['HTTP_REFERER']."#budget_tab_site");
	}
	
	function add_purchase_request_view($crm_id){
		$this->data['crm_id'] = $crm_id;
		
		$this->data['show_all_stock']=$this->warehouse_model->show_all_stock();
		$content = $this->load->view('project/add_purchase_request',$this->data);
		echo $content;
	}
	
	function add_quotation_view($crm_id){
		$this->data['crm_id'] = $crm_id;
		
		$this->data['show_all_stock']=$this->warehouse_model->show_all_stock();
		$content = $this->load->view('project/add_quotation_view',$this->data);
		echo $content;
	}
	
	function add_po_client_view($crm_id){
		$this->data['crm_id'] = $crm_id;
		
		//$project_id=find_2('id','project_id',$crm_id,'project_goal_tb');
		
		//$project_id = find('project_id',$crm_id,'project_goal_tb');
		$this->data['crm'] = $this->project_model->show_crm_by_id($crm_id);
		$this->data['show_all_stock']=$this->warehouse_model->show_all_stock();
		$content = $this->load->view('project/add_po_client_view',$this->data);
		echo $content;
	}
	
	function approve_po_non_stock($id){
		$approval_date = date('Y-m-d H:i:s');
		$approval_by = $this->session->userdata('employee_id');
		$this->project_model->approve_po_non_stock($id,$approval_date,$approval_by);
		
		$_SESSION['notif'] = "PO non-Stock Approved";
		redirect($_SERVER['HTTP_REFERER']."#purchase_order_tab_site");	
	}
	
	function print_po($project_id){
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
		
		
		$content = $this->load->view('project/po_pdf',$this->data,TRUE);

		require_once(APPPATH.'libraries/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','fr');
		$html2pdf->WriteHTML($content);
		$html2pdf->Output('po.pdf');
	}
	
	function get_edit_quotation($quotation_id){
		 
		$this->data['show_all_stock']=$this->warehouse_model->show_all_stock();
		$this->data['quotation_detail'] = $this->project_model->get_quotation_detail($quotation_id);
		$this->data['quotation_item'] = $this->project_model->get_quotation_item_detail($quotation_id);
		
		$content = $this->load->view('project/get_edit_quotation',$this->data);
		echo $content;	
	}
	
	function add_quotation_excel(){
		$project_id = $this->input->post('project_id');
		$created_date = $this->session->userdata('employee_id');
		$created_by = date('Y-m-d H:i:s');
		
		$config['upload_path'] = 'userdata/quotation/';
        $config['allowed_types'] = 'xls|xlsx';
		
		if($this->upload($config,'excel_file')){
			$upload_data = $this->upload->data();
			$file_location =  $upload_data['file_name'];
			
			$this->project_model->add_quotation_excel($project_id,$created_by,$created_date,$file_location);
			$_SESSION['notif'] = 'Quotation excel uploaded.';
		}
		
		redirect($_SERVER['HTTP_REFERER']."#project_quotation_tab_site");
	}
	
	
	function do_receive_item(){
		
		$project_id = esc($this->input->post('project_id'));
		$receive_date = esc($this->input->post('receive_date'));
		$invoice_nomor=$this->input->post('invoice_nomor');
		$created_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userdata('employee_id');
		
		$budget_id = $this->input->post('budget_id');
		$request_non_stock_item_id = $this->input->post('request_non_stock_item_id');
		$request_stock_item_id = $this->input->post('request_stock_item_id');
		
		
		//validate data
		$error = 0;
		$qty = 0; //initial
		if($request_non_stock_item_id)foreach($request_non_stock_item_id as $list){
			$qty = $this->input->post('qty_non_stock_'.$list);
			$qty_left = $this->input->post('qty_non_stock_left_'.$list);
			if($qty>$qty_left){
				$error=1;
			}
		}
		
		$qty = 0; //initial
		if($request_stock_item_id)foreach($request_stock_item_id as $list){
			$qty = $this->input->post('qty_stock_'.$list);
			$qty_left = $this->input->post('qty_stock_left_'.$list);
			if($qty>$qty_left){
				$error=1;
			}
		}
		
		$qty = 0; //initial
		if($budget_id)foreach($budget_id as $list){
			$qty = $this->input->post('qty_budget_'.$list);
			$qty_left = $this->input->post('qty_budget_left_'.$list); 
			if($qty>$qty_left){
				$error=1;
			}
		}
		$_SESSION['notif'] = "Received Item Error (Quantity more than quantity available).";
		if($error==1)redirect($_SERVER['HTTP_REFERER']."#receive_item_tab_site");	
		
		$this->load->model('budget_model');
		$user_detail = $this->budget_model->get_user_detail($this->session->userdata('employee_id'));
		$number = find_number_receive()+1;
		$month = date('m');
		$year = date('Y');
		if($this->session->userdata('admin_id')==1){
			$receive_number = strtoupper("RI/".date('m')."/ADM1/".$number);
		}else{
			$receive_number = strtoupper("RI/".date('m')."/".substr($user_detail['firstname'],0,1).substr($user_detail['lastname'],0,1).$user_detail['id']."/".$number);	
		}
		
		//add receive
		$this->project_model->add_receive2($project_id,$receive_number,$receive_date,$created_date,$created_by,$month,$year,$number,$invoice_nomor);
		$receive_id = mysql_insert_id();
		
		$qty = 0; //initial
		if($request_non_stock_item_id)foreach($request_non_stock_item_id as $list){
			$qty = $this->input->post('qty_non_stock_'.$list);
			$price=$this->input->post('price_non_stock_'.$list);
			$qty_left = $this->input->post('qty_non_stock_left_'.$list);
			$warehouse_id = $this->input->post('warehouse1_id_'.$list);
			$rak_id=$this->input->post('rak1_id_'.$list);
			$desc=$this->input->post('desc_non_stock_'.$list);
			$stock_id=$this->input->post('stock_non_stock_'.$list);
			$stock_item=find('item',$stock_id,'stock_tb');
			if($qty>0 && $qty<=$qty_left){
			
				
				$cek_stock=find_10('quantity','rak_id',$rak_id,'warehouse_id',$warehouse_id,'item',$stock_item,'stock_tb');
				$cek_id=find_10('id','rak_id',$rak_id,'warehouse_id',$warehouse_id,'item',$stock_item,'stock_tb');
				
		
				$quantity_sekarang=$qty;
				if($cek_stock){
					$database=array('quantity'=>$quantity_sekarang+$cek_stock);
					$this->general_model->update_data('stock_tb',$database,array('id'=>$cek_id));
					$database2=array('project_id'=>$project_id,'stock_id'=>$stock_id,'warehouse_id'=>$warehouse_id,'rak_id'=>$rak_id,'in_qty'=>$qty,'out_qty'=>0,'total'=>$quantity_sekarang+$cek_stock,'qty_before'=>$cek_stock,'price'=>$price,'created_date'=>$created_date,'invoice_number'=>$invoice_nomor);
					
					$this->general_model->insert_data('history_delivery_received_tb',$database2);
					$history_id=mysql_insert_id();
				}else{
					$database=array('item'=>find('item',$stock_id,'stock_tb'),'description'=>$desc,'quantity'=>$qty,'price'=>$price,'active'=>1,'rak_id'=>$rak_id,'warehouse_id'=>$warehouse_id);
					$this->general_model->insert_data('stock_tb',$database);
					$cek_id=mysql_insert_id();
					$database2=array('project_id'=>$project_id,'qty_before'=>0,'stock_id'=>$stock_id,'warehouse_id'=>$warehouse_id,'rak_id'=>$rak_id,'in_qty'=>$qty,'out_qty'=>0,'total'=>$quantity_sekarang,'price'=>$price,'created_date'=>$created_date,'invoice_number'=>$invoice_nomor);
					$this->general_model->insert_data('history_delivery_received_tb',$database2);
					$history_id=mysql_insert_id();
				}
					
					$this->project_model->add_receive_item3($receive_id,$list,0,0,$qty,$created_date,$created_by,$warehouse_id,$rak_id,$cek_id,$history_id);
				
			}
		}
		
		$qty = 0; //initial
		if($request_stock_item_id)foreach($request_stock_item_id as $list){
			$qty = $this->input->post('qty_stock_'.$list);
			$price=$this->input->post('price_stock_'.$list);
			$qty_left = $this->input->post('qty_stock_left_'.$list);
			
			$desc=$this->input->post('desc_stock_'.$list);
			$stock_id=$this->input->post('stock_stock_'.$list);
			$stock_item=find('item',$stock_id,'stock_tb');
			$warehouse_id = find('warehouse_id',$stock_id,'stock_tb');
			$rak_id=find('rak_id',$stock_id,'stock_tb');
			if($qty>0 && $qty<=$qty_left){
				$quantity_sekarang=$qty;
				
				
				$cek_stock=find_10('quantity','rak_id',$rak_id,'warehouse_id',$warehouse_id,'item',$stock_item,'stock_tb');
				if($cek_stock){
					$qty_before=$cek_stock;
				}else{
					$qty_before=0;
				}
				
				$database2=array('project_id'=>$project_id,'stock_id'=>$stock_id,'warehouse_id'=>$warehouse_id,'rak_id'=>$rak_id,'in_qty'=>$qty,'out_qty'=>0,'total'=>$quantity_sekarang+$cek_stock,'qty_before'=>$qty_before,'created_date'=>$created_date,'invoice_number'=>$invoice_nomor);
					$this->general_model->insert_data('history_delivery_received_tb',$database2);
					$history_id=mysql_insert_id();
					$this->project_model->add_receive_item3($receive_id,0,$list,0,$qty,$created_date,$created_by,$warehouse_id,$rak_id,$stock_id,$history_id);
			
			}
		}
		
		$qty = 0; //initial
		if($budget_id)foreach($budget_id as $list){
			$price=$this->input->post('price_po_item_'.$list);
			$qty = $this->input->post('qty_budget_'.$list);
			$desc=$this->input->post('desc_po_item'.$list);
			$qty_left = $this->input->post('qty_budget_left_'.$list);
			$warehouse_id = $this->input->post('warehouse3_id_'.$list);
			$rak_id=$this->input->post('rak3_id_'.$list);
			$stock_id=$this->input->post('stock_budget_item'.$list);
			$stock_item=find('item',$stock_id,'stock_tb');
			if($qty>0 && $qty<=$qty_left){
				
				
				$cek_stock=find_10('quantity','rak_id',$rak_id,'warehouse_id',$warehouse_id,'item',$stock_item,'stock_tb');
				$cek_id=find_10('id','rak_id',$rak_id,'warehouse_id',$warehouse_id,'item',$stock_item,'stock_tb');
					
			
				$quantity_sekarang=$qty;
				if($cek_stock){
					$database=array('quantity'=>$quantity_sekarang+$cek_stock);
					$this->general_model->update_data('stock_tb',$database,array('id'=>$cek_id));
					$database2=array('project_id'=>$project_id,'stock_id'=>$stock_id,'warehouse_id'=>$warehouse_id,'rak_id'=>$rak_id,'in_qty'=>$qty,'out_qty'=>0,'total'=>$quantity_sekarang+$cek_stock,'qty_before'=>$cek_stock,'price'=>$price,'created_date'=>$created_date,'invoice_number'=>$invoice_nomor);
					$this->general_model->insert_data('history_delivery_received_tb',$database2);
					$history_id=mysql_insert_id();
				}else{
					$database=array('item'=>find('item',$stock_id,'stock_tb'),'description'=>$desc,'quantity'=>$qty,'price'=>$price,'active'=>1,'rak_id'=>$rak_id,'warehouse_id'=>$warehouse_id);
					$this->general_model->insert_data('stock_tb',$database);
					$cek_id=mysql_insert_id();
					$database2=array('project_id'=>$project_id,'qty_before'=>0,'stock_id'=>$stock_id,'warehouse_id'=>$warehouse_id,'rak_id'=>$rak_id,'in_qty'=>$qty,'out_qty'=>0,'total'=>$quantity_sekarang,'price'=>$price,'created_date'=>$created_date,'invoice_number'=>$invoice_nomor);
					$this->general_model->insert_data('history_delivery_received_tb',$database2);
					$history_id=mysql_insert_id();
				}
				
				$this->project_model->add_receive_item3($receive_id,0,0,$list,$qty,$created_date,$created_by,$warehouse_id,$rak_id,$cek_id,$history_id);
				
				
				
				
				
				
			}
		}
		
		$_SESSION['notif'] = "Received Item Created.";
		redirect($_SERVER['HTTP_REFERER']."#receive_item_tab_site");	
	}
	
	function delete_received_item($id){
		
		$data=$this->project_model->get_receive_item_by_id($id);
		if($data)foreach($data as $list){
			//balikin stock / kurangin stock
			$this->project_model->cut_stock($list['cek_stock_Id'],$list['qty']);
			//hapus historynya ///
			$this->general_model->delete_data('history_delivery_received_tb',array('id'=>$list['history_id']));		
		}	
		$this->project_model->delete_receive_item($id);
		redirect($_SERVER['HTTP_REFERER']."#receive_item_tab_site");
	}
	
	function confirm_received_item($id){
		$confirm_by = $this->session->userdata('employee_id');
		$confirm_date = date('Y-m-d H:i:s');
		$this->project_model->confirm_receive_item($id,$confirm_by,$confirm_date);
		
		redirect($_SERVER['HTTP_REFERER']."#receive_item_tab_site");
	}
	
	function do_delivery_item(){
	
		$logo=$this->input->post('logo');
		$receive_name=$this->input->post('receive_name');
		$project_id = esc($this->input->post('project_id'));
		$delivery_date = esc($this->input->post('delivery_date'));
		$pic = esc($this->input->post('pic'));
		$receive_date = esc($this->input->post('receive_date'));
		
		$created_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userdata('employee_id');
		
		$budget_id = $this->input->post('budget_id');
		$request_non_stock_item_id = $this->input->post('request_non_stock_item_id');
		$request_stock_item_id = $this->input->post('request_stock_item_id');
		$po_number=$this->input->post('po_number');
		
		
		//validate data
		$error = 0;
		$qty = 0; //initial
		if($request_non_stock_item_id)foreach($request_non_stock_item_id as $list){
			$qty = $this->input->post('qty_non_stock_'.$list);
			$qty_left = $this->input->post('qty_non_stock_left_'.$list);
			if($qty>$qty_left){
				$error=1;
			}
		}
		
		$qty = 0; //initial
		if($request_stock_item_id)foreach($request_stock_item_id as $list){
			$qty = $this->input->post('qty_stock_'.$list);
			$qty_left = $this->input->post('qty_stock_left_'.$list);
			if($qty>$qty_left){
				$error=1;
			}
		}
		
		$qty = 0; //initial
		if($budget_id)foreach($budget_id as $list){
			$qty = $this->input->post('qty_budget_'.$list);
			$qty_left = $this->input->post('qty_budget_left_'.$list);
			if($qty>$qty_left){
				$error=1;
			}
		}
		$_SESSION['notif'] = "Delivery Item Error (Quantity more than quantity available).";
		if($error==1)redirect($_SERVER['HTTP_REFERER']."#delivery_item_tab_site");	
		
		$this->load->model('budget_model');
		$user_detail = $this->budget_model->get_user_detail($this->session->userdata('employee_id'));
		$number = find_number_delivery()+1;
		$month = date('m');
		$year = date('Y');
		if($this->session->userdata('admin_id')==1){
			$delivery_number = strtoupper("DI/".date('m')."/ADM1/".$number);
		}else{
			$delivery_number = strtoupper("DI/".date('m')."/".substr($user_detail['firstname'],0,1).substr($user_detail['lastname'],0,1).$user_detail['id']."/".$number);	
		}
		
		//add receive
		$this->project_model->add_delivery3($project_id,$delivery_number,$receive_date,$pic,$delivery_date,$created_date,$created_by,$month,$year,$number,$po_number,$logo,$receive_name);
		$delivery_id = mysql_insert_id();
			
		$qty = 0; //initial
		if($request_non_stock_item_id)foreach($request_non_stock_item_id as $list){
			$stock_id=$this->input->post('warehouse_non_stock_'.$list);
			$qty = $this->input->post('qty_non_stock_'.$list);
			$qty_left = $this->input->post('qty_non_stock_left_'.$list);
			$serial_number=$this->input->post('serial_number_non_stock_'.$list);
		
			if($qty>0 && $qty<=$qty_left){		
					$this->project_model->add_delivery_item2($delivery_id,$list,0,0,$qty,$created_date,$created_by,$stock_id,$serial_number);
					$stock_detail=$this->project_model->show_stock_detail($stock_id);
					$quantity_sekarang=$stock_detail['quantity']-$qty;
			
					$database2=array('project_id'=>$project_id,'qty_before'=>$stock_detail['quantity'],'stock_id'=>$stock_id,'warehouse_id'=>$stock_detail['warehouse_id'],'rak_id'=>$stock_detail['rak_id'],'in_qty'=>0,'out_qty'=>$qty,'total'=>$quantity_sekarang,'created_date'=>$created_date,'invoice_number'=>'-','type'=>1);
						$this->general_model->insert_data('history_delivery_received_tb',$database2);	
						
							$this->project_model->cut_stock($stock_id,$qty);
				
			}
			
		}
		
		$qty = 0; //initial
		if($request_stock_item_id)foreach($request_stock_item_id as $list){
			$stock_id=$this->input->post('warehouse_stock_'.$list);
			$serial_number=$this->input->post('serial_number_stock_'.$list);
			$qty = $this->input->post('qty_stock_'.$list);
			$qty_left = $this->input->post('qty_stock_left_'.$list);
			if($qty>0 && $qty<=$qty_left){
				$this->project_model->add_delivery_item2($delivery_id,0,$list,0,$qty,$created_date,$created_by,$stock_id,$serial_number);
				
				$stock_detail=$this->project_model->show_stock_detail($stock_id);
					$quantity_sekarang=$stock_detail['quantity']-$qty;
				
					$database2=array('project_id'=>$project_id,'qty_before'=>$stock_detail['quantity'],'stock_id'=>$stock_id,'warehouse_id'=>$stock_detail['warehouse_id'],'rak_id'=>$stock_detail['rak_id'],'in_qty'=>0,'out_qty'=>$qty,'total'=>$quantity_sekarang,'created_date'=>$created_date,'invoice_number'=>'-','type'=>1);
						$this->general_model->insert_data('history_delivery_received_tb',$database2);	
				
				//$this->project_model->cut_stock($stock_id,$qty);
			}
		}
		
		$qty = 0; //initial
		if($budget_id)foreach($budget_id as $list){
			$stock_id=$this->input->post('warehouse_budget_item_'.$list);
			$qty = $this->input->post('qty_budget_'.$list);
			$qty_left = $this->input->post('qty_budget_left_'.$list);
			$serial_number=$this->input->post('serial_number_budget_item_'.$list);
			if($qty>0 && $qty<=$qty_left){
				$this->project_model->add_delivery_item2($delivery_id,0,0,$list,$qty,$created_date,$created_by,$stock_id,$serial_number);
			
				$stock_detail=$this->project_model->show_stock_detail($stock_id);
					$quantity_sekarang=$stock_detail['quantity']-$qty;
				
					$database2=array('project_id'=>$project_id,'qty_before'=>$stock_detail['quantity'],'stock_id'=>$stock_id,'warehouse_id'=>$stock_detail['warehouse_id'],'rak_id'=>$stock_detail['rak_id'],'in_qty'=>0,'out_qty'=>$qty,'total'=>$quantity_sekarang,'created_date'=>$created_date,'invoice_number'=>'-','type'=>1);
						$this->general_model->insert_data('history_delivery_received_tb',$database2);	
							$this->project_model->cut_stock($stock_id,$qty);
						
						
			}
		}
		
		$_SESSION['notif'] = "Delivery Item Created.";
		redirect($_SERVER['HTTP_REFERER']."#delivery_item_tab_site");	
	}
	
	function delete_delivery_item($id){
		//retur stock item//
		$delivery_item=$this->project_model->get_delivery_detail_item_list($id);
		if($delivery_item)foreach($delivery_item as $list_item){
			$this->project_model->tambah_stock($list_item['stock_id'],$list_item['qty']);
			
		}

		$this->project_model->delete_delivery_item($id);

		redirect($_SERVER['HTTP_REFERER']."#delivery_item_tab_site");
	}
	
	function confirm_delivered_item($id){
		$detail=$this->project_model->get_delivery_detail($id);
		$detail_item_list=$this->project_model->get_delivery_detail_item_list($id);
		$confirm_by = $this->session->userdata('employee_id');
		$confirm_date = date('Y-m-d H:i:s');
		$this->project_model->confirm_delivered_item($id,$confirm_by,$confirm_date);
		redirect($_SERVER['HTTP_REFERER']."#delivery_item_tab_site");
	}
	
	function delete_po_stock($id,$project_goal_id){
		$data = "(".$id.")";
		$po_request_stock_item = $this->project_model->get_project_po_request_stock_item($data);
		if($po_request_stock_item)foreach($po_request_stock_item as $list){
			$stock = $list['stock_id'];
			$qty_now = $list['qty'];
			//add stock ( - qty )
			$this->project_model->cut_stock($stock,-$qty_now);	
		}
		
		$this->project_model->delete_po_stock($id);
		redirect('project/detail_project_goal/'.$project_goal_id."#purchase_order_tab_site");	
	}
	
	function delete_po_non_stock($id,$project_goal_id){
		$this->project_model->delete_po_non_stock($id);		
		$_SESSION['notif'] = "PO Non Stock Deleted.";

		redirect('project/detail_project_goal/'.$project_goal_id."#purchase_order_tab_site");	
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function delete_rf($id){
		$this->budget_model->delete_rf($id);
		$request_item = $this->budget_model->get_request_item_detail($id);
		if($request_item)foreach($request_item as $list){
			$this->budget_model->remove_request_budget_item($list['id']);
			//remove budget log if exists
			$this->budget_model->remove_budget_log_by_item_id($list['id']);	
		}
		
		$_SESSION['notif'] = "Request fund deleted.";
		
		redirect($_SERVER['HTTP_REFERER']."#budget_tab_site");	
	}
	
	function print_pdf_approval($project_id){

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
			
			
		 $content = $this->load->view('project/print_po_non_stock_pdf',$this->data,TRUE);

		$this->load->helper(array('dompdf', 'file'));
		 $filename='po_non_stock';
    	 pdf_create($content, $filename);
	}
	
	function update_pic($id){
		
		$this->load->model('general_model');
		$pic_edit=$this->input->post('pic_edit');
		$receive_name=$this->input->post('receive_name');
		$logo=$this->input->post('logo');
		$po_number_edit=$this->input->post('po_number_edit');
		$received_date_edit=$this->input->post('received_date_edit');
		$database=array('logo'=>$logo,'receive_name'=>$receive_name,'pic'=>$pic_edit,'receive_date'=>$received_date_edit,'po_number'=>$po_number_edit);
		$this->general_model->update_data('delivery_tb',$database,array('id'=>$id));	
		redirect ($_SERVER['HTTP_REFERER'].'#delivery_item_tab_site');
	
	}
	
	function confirm_payment($payment_id,$invoice_id){
		$this->data['invoice_detail'] = $this->project_model->show_invoice_by_id($invoice_id);
		$this->data['payment_detail'] = $this->project_model->show_payment_by_id($payment_id);
		$this->load->view('project/detail_project_goal/confirm_payment',$this->data);
	}
	
	function do_confirm_payment(){
		if(!empty($_POST)){//pre($_POST);exit();
			$invoice_id=$this->input->post('invoice_id');
			$payment_id=$this->input->post('payment_id');
			$received_date=$this->input->post('received_date');
			$amount=$this->input->post('amount');
			$bank=$this->input->post('bank');	
			
			$this->load->model('general_model');
			
			$table='project_goal_payment_tb';
			$data=array('payment_amount'=>$amount,'payment_bank'=>$bank,'payment_received_date'=>$received_date,'payment_status'=>1);
			$where=array('id'=>$payment_id);
			$this->general_model->update_data($table, $data, $where);
			echo '1';
			exit;
		}
		else{
			redirect('home');
		}
		
	}
	
	
	function get_retur_po_stock($po_id,$project_id){
		//project client po
		
		$this->data['project_id']=$project_id;
		$this->data['po_client'] = $po_client = $this->project_model->get_project_po_client($project_id);
		
		$this->data['po_client_item'] = $this->project_model->get_project_po_client_item($po_client['id']);
		
		//inventory stock list
	
		
		$this->data['po_detail'] = $this->project_model->get_po_stock_detail($po_id);
		$this->data['po_item'] = $data= $this->project_model->get_po_stock_item($po_id);
		$this->data['warehouse_list'] = $this->warehouse_model->show_warehouse();
		$content = $this->load->view('project/get_retur_po_stock',$this->data);
		echo $content;
		
	}
	
	function do_retur(){
			
		$request_date = esc($this->input->post('request_date'));
		$notes = esc($this->input->post('notes'));
		$updated_date = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('employee_id');
		$project_id=$this->input->post('project_id');
		
	
		//insert stock
		if(!$request_date){
			$_SESSION['notif'] = 'Retur Stock Failed.';	
		}else{
			
			$item_product_total = $this->input->post('item_product_total');
			$database=array(	'project_id'=>$project_id,
								'request_date'=>$request_date,
								'created_date'=>$updated_date,
								'created_by'=>$updated_by,
								'notes'=>$notes);
				$this->general_model->insert_data('project_goal_retur_stock_tb',$database);
				$project_goal_retur_stock_id=mysql_insert_id();
				
			for($i=1;$i<=$item_product_total;$i++){

				//insert  to project_goal_retur_stock_item_tb
				$po_item_id = esc($this->input->post('po_id_'.$i));
				$retur_quantity=esc($this->input->post('retur_quantity1_'.$i));
				$qty_old=esc($this->input->post('qty1_old_'.$i));
				$stock_id=esc($this->input->post('stock1_'.$i));
				if($retur_quantity<=$qty_old){
				$database2=array('project_goal_retur_stock_id'=>$project_goal_retur_stock_id,
								'old_quantity'=>$qty_old,
								'project_goal_request_stock_item_id'=>$po_item_id,
								'total_quantity'=>$qty_old-$retur_quantity,
								'retur_quantity'=>$retur_quantity);
				$this->general_model->insert_data('project_goal_retur_stock_item_tb',$database2);	
				
				
				//kirim stock ke gudang 
				$this->project_model-> tambah_stock($stock_id,$retur_quantity);
				//hapus item_list //
				$this->project_model->cut_stock_retur($po_item_id,$retur_quantity);
					$_SESSION['notif'] = 'Retur Stock Updated.';
				}else{
						
					$_SESSION['notif'] = 'Retur yang anda masuk untuk beberapa item gagal karena stok retur yang dimasukan lebih besar dari jumlah quantity sebelumnya';
				
				}
				
				
				
			}
			redirect($_SERVER['HTTP_REFERER']."#purchase_order_tab_site");
			
		}
		
	redirect($_SERVER['HTTP_REFERER']."#purchase_order_tab_site");
		
		
	}
	
	
	function print_po_stock_approval($project_id){
			$this->load->helper(array('dompdf', 'file'));
			//project po non stock (multiple data)
			
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
			
		 $content = $this->load->view('project/print_po_stock_pdf',$this->data,TRUE);
 	
		
		$filename='po_stock';
    	 pdf_create($content, $filename);	
	}
	
	function po_stock_detail($id){
	//project po stock
		$this->data['detail'] =$detail = $this->project_model->get_po_stock_detail($id);
		$this->data['po_request_stock_item']=$this->project_model->get_project_po_request_stock_item2($id);
		$this->data['page'] = 'project/detail_project_goal/po_stock_detail';
			$this->data['crm'] = $this->project_model->show_crm_by_id($detail['project_id']);
			$this->data['retur_list']=$this->project_model->get_retur_by_project($detail['project_id']);
		$this->load->view('common/body', $this->data);	
	}
	function po_non_stock_detail($id){
		$this->data['detail']=$detail=$this->project_model->get_po_non_stock_detail2($id);
		$this->data['po_request_non_stock_item']=$this->project_model->get_project_po_request_non_stock_item2($id);
			$this->data['crm'] = $this->project_model->show_crm_by_id($detail['project_id']);
		$this->data['page'] = 'project/detail_project_goal/po_non_stock_detail';
		$this->load->view('common/body', $this->data);
	}
	
	function download_delivery_order($delivery_id){
		$this->load->model('admin_model');
		$this->data['print_by'] =  $this->admin_model->show_administrator_employee_by_id($this->session->userdata('employee_id'));
		$this->data['delivery_detail']=$this->project_model->get_delivery_detail($delivery_id);
		$this->data['delivery_item_list']=$this->project_model->get_delivery_item_list_by_id($delivery_id);
		$this->load->helper(array('dompdf', 'file'));
	    $content = $this->load->view('project/print_delivery_order',$this->data,TRUE);
		$filename='delivery_order';
     pdf_create($content, $filename);	
	}
	function do_timeline(){

		$newdate=date("Y-m-d H:i:s");
		$input_by = $this->session->userdata('employee_id');
		$deadline_date=$this->input->post('deadline_date');
		$description=$this->input->post('description');
		$type=$this->input->post('type');
		$project_id=$this->input->post('assignment_project_id');
		$division_assignment=$this->input->post('division_assignment');
		$employee_id_assignment=$this->input->post('employee_id_assignment');
		$database=array('project_id'=>$project_id,
						'deadline_date'=>$deadline_date,
						'description'=>$description,
						'type'=>$type,
						'division_assignment'=>$division_assignment,
						'employee_id_assignment'=>$employee_id_assignment,
						'created_by'=>$input_by,
						'created_date'=>$newdate,
						'last_updated_by'=>$input_by,
						'last_created_date'=>$newdate);
		$this->general_model->insert_data('project_deadline_tb',$database);
		redirect($_SERVER['HTTP_REFERER'].'/#timelineandreminder');					
		
	}
	function edit_timeline($id){
		$this->data['get_departemen_active']=$this->department_model->get_departemen_active();
		$this->data['detail']=$this->department_model->show_project_deadline_by_id($id);		
		$content = $this->load->view('project/timeline_edit',$this->data);
		echo $content;	
	}
	
	function doedit_timeline($id){
	
		
		$newdate=date("Y-m-d H:i:s");
		$input_by = $this->session->userdata('employee_id');
		$deadline_date=$this->input->post('deadline_date');
		$description=$this->input->post('description');
		$type=$this->input->post('type');
		$division_assignment=$this->input->post('division_assignment_edit');
		$employee_id_assignment=$this->input->post('employee_id_assignment_edit');
		$database=array(
						'deadline_date'=>$deadline_date,
						'description'=>$description,
						'type'=>$type,
						'division_assignment'=>$division_assignment,
						'employee_id_assignment'=>$employee_id_assignment,
						'last_updated_by'=>$input_by,
						'last_created_date'=>$newdate);
		$this->general_model->update_data('project_deadline_tb',$database,array('id'=>$id));
		redirect($_SERVER['HTTP_REFERER'].'/#timelineandreminder');					
	}
	
	function delete_timeline($id){
		$this->general_model->delete_data('project_deadline_tb',array('id'=>$id));
		redirect($_SERVER['HTTP_REFERER'].'/#timelineandreminder');	
	}
	function do_update_timeline(){
	
		$progress=$this->input->post('progress');
		$notes=$this->input->post('notes');
		$timeline_id=$this->input->post('timeline_id');
		$newdate=date("Y-m-d H:i:s");
		$input_by = $this->session->userdata('employee_id');
		$database=array('timeline_id'=>$timeline_id,
						'progress'=>$progress,
						'notes'=>$notes,
						'created_by'=>$input_by,
						'created_date'=>$newdate,
						'last_updated_by'=>$input_by,
						'last_updated_date'=>$newdate);
		$this->general_model->insert_data('timeline_log_tb',$database);
		$this->general_model->update_data('project_deadline_tb',array('progress'=>$progress),array('id'=>$timeline_id));
		redirect($_SERVER['HTTP_REFERER'].'/#timelineandreminder');	
	}
	function upload_timeline(){
		$newdate=date("Y-m-d H:i:s");
		$input_by = $this->session->userdata('employee_id');
		$config['upload_path'] = 'userdata/timeline/';
		$config['allowed_types'] = '*';
		$project_id=$this->input->post('project_id');
		
		$config['encrypt_name'] = TRUE;		
		$this->load->library('upload', $config);
	
		if($this->upload->do_upload('attachment'))
		{				
			$upload_data = $this->upload->data();
			$file_location =  $upload_data['full_path'];
			
			$inputFileName = $file_location;  
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);  
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);  
			$objReader->setReadDataOnly(true);  
			/**  Load $inputFileName to a PHPExcel Object  **/  
			$objPHPExcel = $objReader->load($inputFileName);  
			$total_sheets=$objPHPExcel->getSheetCount(); // here 4  
			$allSheetName=$objPHPExcel->getSheetNames(); // array ([0]=>'student',[1]=>'teacher',[2]=>'school',[3]=>'college')  
			$objWorksheet = $objPHPExcel->setActiveSheetIndex(0); // first sheet  
			$highestRow = $objWorksheet->getHighestRow(); // here 5  
			$highestColumn = $objWorksheet->getHighestColumn(); // here 'E'  
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);  // here 5  
			for ($row = 1; $row <= $highestRow; ++$row) {  
				$value = '';
				for ($col = 0; $col <= $highestColumnIndex; ++$col) {  
					$value.=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue().'|';
				}
				
				$data[] = explode('|',$value);
		
			}
			
			if($data)foreach($data as $list_data){
				$description=$list_data['0'];
				$deadline_date=date('Y-m-d',strtotime($list_data[1]));
				$database=array('project_id'=>$project_id,
								'deadline_date'=>$deadline_date,
								'description'=>$description,
								'created_by'=>$input_by,
								'created_date'=>$newdate,
								'last_updated_by'=>$input_by,
								'last_created_date'=>$newdate
				);
				$this->general_model->insert_data('project_deadline_tb',$database);
		
			}
		}
		redirect($_SERVER['HTTP_REFERER'].'/#timelineandreminder');	
		
	}
	
	function do_add_purchase_request(){//pre($_POST);
		$project_id=$this->input->post('project_id');	
		$po_client_item_id=$this->input->post('po_client_item_id');
		$qty_to_request=$this->input->post('qty_to_request');
		$deadline_date=$this->input->post('deadline_date');
		$this->load->model('general_model');
		
		$ok_to_create=0;
		if($qty_to_request)foreach($qty_to_request as $key=>$row){
		
			if($row>0){$ok_to_create=1;}
		}
		//echo $ok_to_create;
		if($ok_to_create==1){
			$number=find_number_purchase_request()+1;
			$pr_number='GSI/f/'.$number;
			$data=array('project_id'=>$project_id,'unique_number'=>uniqid(),'created_date'=>date("Y-m-d H:i:s"),'created_by'=>$this->session->userdata('admin_id'),'year'=>date("Y"),'month'=>date("m"),'number'=>$number,'po_number'=>$pr_number);
			$this->general_model->insert_data('project_goal_purchase_request_tb', $data);
			$purchase_request_id=mysql_insert_id();
		
		
			if($qty_to_request)foreach($qty_to_request as $key=>$row){
				if($row>0){
					$qty=$row;
					$po_client_item_id_now=$po_client_item_id[$key];
					$deadline_date_now=$deadline_date[$key];
					
					$data=array('purchase_request_id'=>$purchase_request_id,'po_client_item_id'=>$po_client_item_id_now,'deadline'=>$deadline_date_now,'quantity'=>$qty,'project_id'=>$project_id);
					$this->general_model->insert_data('project_goal_purchase_request_item_tb', $data);
					
					$data2=array('requested_quantity'=>$qty);
					$where=array('id'=>$po_client_item_id_now);
					$this->general_model->update_data('project_goal_po_client_item_tb',$data2,$where);
				}
			}
		}
		
		redirect($_SERVER['HTTP_REFERER'].'/#purchase_request_tab_site');	
	}
	
	function delete_purchase_request($id){
		//id= purchase request_id
		$items=$this->project_model->get_purchase_request_item_by_pr_id($id);
		
		//balikin quantity reserved
		if($items)foreach($items as $row){
			$update_to=find('requested_quantity',$row['po_client_item_id'],'project_goal_po_client_item_tb');
			$data2=array('requested_quantity'=>$update_to-$row['quantity']);
			$where=array('id'=>$row['po_client_item_id']);
			$this->general_model->update_data('project_goal_po_client_item_tb',$data2,$where);
		}
		
		$where=array('id'=>$id);
		$this->general_model->delete_data('project_goal_purchase_request_tb', $where);
		redirect($_SERVER['HTTP_REFERER'].'#purchase_request_tab_site');	
	}
	
	function confirm_purchase_request($id){
		$data=array('is_confirm'=>1,'updated_date'=>date("Y-m-d H:i:s"),'updated_by'=>$this->session->userdata('employee_id'));
		$where=array('id'=>$id);
		$this->general_model->update_data('project_goal_purchase_request_tb', $data,$where);
		redirect($_SERVER['HTTP_REFERER'].'/#purchase_request_tab_site');	
	}
}?>