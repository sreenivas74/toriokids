<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Schedule extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('schedule_model');
		$this->load->model('flexigrid_model');
	}
	
	function index(){
		redirect('home');
	}
	
	//list job tracking per department
	function list_schedule_department(){
		$periode_from = $this->input->post('periode_from');
		
		if($periode_from){
			$this->data['periode_from'] = $periode_from;
			$this->data['periode_schedule'] = date('d M Y',strtotime($periode_from))." - ".date('d M Y',strtotime('+5 day',strtotime($periode_from)));
		}else{
			$this->data['periode_from'] = '';
			$this->data['periode_schedule'] = '';
		}
		
		$this->data['support_employee'] = $this->schedule_model->show_support_employee();
		$this->data['engineering_employee'] = $this->schedule_model->show_engineering_employee();
		$this->data['marketing_employee'] = $this->schedule_model->show_marketing_employee();
		$this->data['page'] = "schedule/list_job_tracking_department";
		$this->load->view('common/body',$this->data);
	}
	//
	
	function list_schedule(){
		//$this->data['employee'] = $this->schedule_model->show_employee_active();
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_schedule","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_schedule_2","privilege_tb")){
		$this->data['page'] = "schedule/list";
		$this->load->view('common/body',$this->data);
		}else{
			redirect('home');	
		}
	}
	
	function schedule_flexi(){
		if(date("N")==1)$z=7;
		elseif(date("N")==2)$z=6;
		elseif(date("N")==3)$z=5;
		elseif(date("N")==4)$z=4;
		elseif(date("N")==5)$z=3;
		elseif(date("N")==6)$z=2;
		elseif(date("N")==7)$z=1;
		
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 's.date_now';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*,e.id as e_id, s.id as s_id";
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_schedule","privilege_tb")){
			$where = " where description != ''";
			if ($query) $where .= " and $qtype LIKE '%$query%'";
		}elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_schedule_2","privilege_tb")){
			$where = "where employee_id = '".$this->session->userdata('employee_id')."' and description != ''";
			if ($query) $where .= " and $qtype LIKE '%$query%' ";
		}
		
		$tname="schedule_tb s
				left join employee_tb e on s.employee_id = e.id";
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
			if($row['description']!=""){
				 //if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/delete_schedule","privilege_tb")){
				//	$delete = " | <a href=\"".site_url('schedule/delete_schedule/'.$row['id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
				// }else{
					$delete = "";
				 //}
				 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/detail_schedule","privilege_tb")){
					//if($this->session->userdata('employee_id')==$row['id'] || $this->session->userdata('employee_id')==0){
						//if(find_4_string('id','employee_id',$row['employee_id'],'date_now',date("Y-m-d",strtotime('+'.($z+0).' day',strtotime(date('Y-m-d')))),'schedule_tb')){
							$detail = "<a href=\"".site_url('schedule/detail_schedule/'.$row['s_id'])."\">Detail</a>";
						//}else{
						//	$detail = "";	
						//}
					//}else{
					//	$detail = "";	
					//}
				 }else{
					$detail = "";
				 }
				 
				 //if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/edit_schedule","privilege_tb")){
				//	$edit = "<a href=\"".site_url('schedule/edit_schedule/'.$row['id'])."\">Edit</a>";
				// }else{
					$edit = "";
				 //}
	
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "id:'".$row['id']."',";
				$json .= "cell:[";
				 
				$json .= "'".$edit.$delete.$detail."'";
				
				//$json .= ",'".esc(find('firstname',$row['employee_id'],'employee_tb'))." ".esc(find('lastname',$row['employee_id'],'employee_tb'))."'";
				
				$json .= ",'".esc($row['firstname'])." ".esc($row['lastname'])."'";
				
				if($row['date_now']!=00-00-0000){
					$json .= ",'".date('d/m/Y',strtotime(esc($row['date_now'])))."'";
				}else{
					$json .= ",'-'";	
				}
				
				if($row['created_date']!=00-00-0000){
					$json .= ",'".date('d/m/Y',strtotime(esc($row['created_date'])))."'";
				}else{
					$json .= ",'-'";	
				}
				$json .= ",'".esc($row['description'])."'";
				$json .= "]}";
				$rc = true;		
			}
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	function detail_schedule($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/detail_schedule","privilege_tb")){
			//if($this->session->userdata('employee_id')==0 || $this->session->userdata('employee_id')==$id){
				$this->data['employee_id'] = find('employee_id',$id,'schedule_tb');
				$this->data['schedule_date'] = find('date_now',$id,'schedule_tb');
				$this->data['page'] = "schedule/detail";
				$this->load->view('common/body',$this->data);
			//}else{
			//	redirect('home');	
			//}
		}else{
			redirect('home');	
		}
	}
	
	function get_schedule($id){
		$this->data['schedule'] = $this->schedule_model->show_schedule_by_id($id);
		$this->load->view('schedule/get_schedule',$this->data);
	}
	
	function add_schedule(){
		if(date("N")==1)$z=7;
		elseif(date("N")==2)$z=6;
		elseif(date("N")==3)$z=5;
		elseif(date("N")==4)$z=4;
		elseif(date("N")==5)$z=3;
		elseif(date("N")==6)$z=2;
		elseif(date("N")==7)$z=1;
		
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/add_schedule","privilege_tb")){
			
			if(!find_4_string('id','employee_id',$this->session->userdata('employee_id'),'date_now',date("Y-m-d",strtotime('+'.($z+0).' day',strtotime(date('Y-m-d')))),'schedule_tb')){
				$this->data['page'] = "schedule/add";
				$this->load->view('common/body',$this->data);
			}else{
				redirect('schedule/detail_schedule/'.find_4_string('id','employee_id',$this->session->userdata('employee_id'),'date_now',date("Y-m-d",strtotime('+'.($z+0).' day',strtotime(date('Y-m-d')))),'schedule_tb'));	
			}
		}else{
			redirect('home');	
		}
	}
	
	function do_add_schedule(){
		$schedule_list = $this->input->post('schedule_list');
		
		foreach($schedule_list as $list){
			$date = $this->input->post('date_now_'.$list);
			$description = $this->input->post('description_'.$list);
			$employee = $this->session->userdata('employee_id');
			
			if(!find_4_string('id','employee_id',$employee,'date_now',$date,'schedule_tb')){
				$this->schedule_model->do_add_schedule($description,$date,$employee);
			}
			//echo $date."<br>";	
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_schedule($id){
		$description = $this->input->post('description');
		$updated_date = date('Y-m-d');
		$updated_by = $this->session->userdata('employee_id');
		
		$this->schedule_model->edit_schedule($id,$description,$updated_date,$updated_by);
		
 		redirect($_SERVER['HTTP_REFERER']);
	}
	
	/////
	//schedule to
	function add_schedule_to(){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/add_schedule","privilege_tb")) redirect($_SERVER['HTTP_REFERER']);
		$this->data['department'] = $this->schedule_model->show_department_active();
		$this->data['employee'] = $this->schedule_model->show_employee_active();
		$this->data['page'] = "schedule/add_schedule_to";
		$this->load->view('common/body',$this->data);
	}
	
	function do_add_schedule_to(){
		$employee_id = $this->input->post('employee_id');
		$activity_date = $this->input->post('activity_date');
		$description = $this->input->post('description');
		$input_date = date('Y-m-d');
		$input_by = $this->session->userdata('employee_id');
		$project_id = $this->input->post('project_id');
		
		$pic = $this->input->post('pic');
		$phone = $this->input->post('phone');
		$time = $this->input->post('time');
		
		$this->schedule_model->do_add_schedule_to($employee_id,$activity_date,$description,$input_by,$input_date,$pic,$phone,$time,$project_id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function get_employee_list($id){
		$this->data['employee_list'] = $this->schedule_model->show_employee_by_department($id);
		$this->load->view('schedule/get_employee_list',$this->data);
	}
	
	function get_schedule_list($id){
		$this->data['schedule_list'] = $this->schedule_model->show_schedule_list_by_id($id);
		$this->load->view('schedule/get_schedule_list',$this->data);
	}
	////
	////////////////
	//job tracking//
	////////////////
	
	function list_job_tracking(){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking","privilege_tb") && !find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/add_job_tracking","privilege_tb")) redirect('home');
		
		$sortby = $this->input->post('sortby');
		$this->data['sortby'] = $sortby;
		if($sortby==1)$sortby = 'due_date desc';
		elseif($sortby==2)$sortby = 'company_id asc';
		elseif($sortby==3)$sortby = 'employee_activity_category_id asc';
		else $sortby = 'jt.id desc';
		$periode_selected = $this->input->post('periode_selected');
		if($periode_selected){
			$this->data['periode_selected'] = $periode_selected;
			$this->data['today'] = date('d M Y',strtotime($periode_selected));
			$this->data['job_tracking_open'] = $this->schedule_model->show_job_tracking_open_selected($periode_selected,$sortby);
		}else{
			$this->data['periode_selected'] = '';
			$this->data['today'] = date('d M Y');
			$this->data['job_tracking_open'] = $this->schedule_model->show_job_tracking_open($sortby);
		}
		$this->data['employee_active'] = $this->schedule_model->show_employee_active();
		
		$this->data['job_tracking_close'] = $this->schedule_model->show_job_tracking_close();
		
		
		$this->data['employee'] = $this->schedule_model->show_employee_active();
		$this->data['resource_list'] = $this->schedule_model->show_resource_active();
		$this->data['company_list'] = $this->schedule_model->show_company_active();
		$this->data['employee_activity_category'] = $this->schedule_model->show_employee_activity_category();
		
		
		
		$this->data['page'] = 'schedule/list_job_tracking';
		$this->load->view('common/body',$this->data);
	}
	
	function job_tracking_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'jt.id desc, approval asc, active';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*,jt.id as jt_id";
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking","privilege_tb")){
			$where = " where description != ''";
			if ($query) $where .= " and $qtype LIKE '%$query%'";
		}elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking_2","privilege_tb")){
			$where = "where assigned_to = '".$this->session->userdata('employee_id')."' and description != ''";
			if ($query) $where .= " and $qtype LIKE '%$query%' ";
		}
		
		$tname="job_tracking_tb jt
				left join employee_tb e on e.id = jt.assigned_to";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("*"," $tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if($result) foreach($result as $row){
			if($row['description']!=""){
				 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/delete_job_tracking","privilege_tb")){
					$delete = " | <a href=\"".site_url('schedule/delete_job_tracking/'.$row['jt_id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
				 }else{
					$delete = "";
				 }
				 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/detail_job_tracking","privilege_tb"))
					$detail = " | <a href=\"".site_url('schedule/detail_job_tracking/'.$row['jt_id'])."\">Detail</a>";
				 }else{
					$detail = "";
				 }
				 
				 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/edit_job_tracking","privilege_tb")){
					$edit = "<a href=\"".site_url('schedule/edit_job_tracking/'.$row['jt_id'])."\">Edit</a>";
				 }else{
					$edit = "";
				 }
	
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "id:'".$row['id']."',";
				$json .= "cell:[";
				 
				$json .= "'".$edit.$delete.$detail."'";
				
				if($row['due_date']!=00-00-0000){
					$json .= ",'".date('d/m/Y',strtotime(esc($row['due_date'])))."'";
				}else{
					$json .= ",'-'";	
				}
				$json .= ",'".esc($row['description'])."'";
				
				$x = count(explode("|",$row['assigned_to']));
				$assigned = explode("|",$row['assigned_to']);
				
				$assigned_to = "";
				for($i=0;$i<$x-1;$i++){
					$assigned_to = $assigned_to.esc(find('firstname',$assigned[$i],'employee_tb')." ".find('lastname',$assigned[$i],'employee_tb'))."<br />";
				}
				
				$json .= ",'".esc($assigned_to)."'";
				
				if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/approval_job_tracking","privilege_tb")){	
					if($row['approval']==1){
						$json .= ",'<a href=\"".site_url('schedule/approval_job_tracking/'.$row['jt_id'].'/'.$row['approval'])."\">Approved</a>'";
					}else{
						$json .= ",'<a href=\"".site_url('schedule/approval_job_tracking/'.$row['jt_id'].'/'.$row['approval'])."\">Not Approved</a>'";
					}
				}else{
					 if($row['approval']==1){
						$json .= ",'Approved'";
					}else{
						$json .= ",'Not Approved'";
					}
				}
				
				if($row['active']==1){
					$json .= ",'<a href=\"".site_url('schedule/active_job_tracking/'.$row['jt_id'].'/'.$row['active'])."\">Closed</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('schedule/active_job_tracking/'.$row['jt_id'].'/'.$row['active'])."\">Open</a>'";
				}
				$json .= "]}";
				$rc = true;		
			}
		
		$json .= "]\n";
		$json .= "}";
		echo $json;		
	}
	
	function add_assigne($job_tracking_id){
		$assign_date = $this->input->post('assign_date');
		$assign_time = $this->input->post('assign_time');
		$assign_to = $this->input->post('assign_to');
		$resource_id = $this->input->post('resource_id');
		$description = $this->input->post('description');
		
		$due_date = $this->input->post('due_date');
		$employee_activity_category_id = $this->input->post('employee_activity_category_id');
		
		if($due_date && $employee_activity_category_id){
			$this->schedule_model->update_job_tracking_data($job_tracking_id,$due_date,$employee_activity_category_id);	
		}
		
		$assigned_to = '';
		
		if(!$assign_date || !$assign_to || !$assign_time || !$resource_id)redirect($_SERVER['HTTP_REFERER']);
		
		if($assign_to)foreach($assign_to as $list){
			$assigned_to = $assigned_to.$list."|";	
		}
		
		if(!find_4_string('id','job_tracking_id',$job_tracking_id,'assign_date',$assign_date,'job_tracking_log_tb')){
			$this->schedule_model->add_assign_to($job_tracking_id,$assign_date,$assigned_to,$assign_time,$resource_id,$description);
		}else{
			$this->schedule_model->edit_assign_to($job_tracking_id,$assign_date,$assigned_to,$assign_time,$resource_id,$description);	
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function add_job_tracking(){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/add_job_tracking","privilege_tb")) redirect('home');
		$this->data['employee'] = $this->schedule_model->show_employee_active();
		$this->data['resource_list'] = $this->schedule_model->show_resource_active();
		$this->data['company_list'] = $this->schedule_model->show_company_active();
		$this->data['employee_activity_category'] = $this->schedule_model->show_employee_activity_category();
		$this->data['page'] = 'schedule/add_job_tracking';
		$this->load->view('common/body',$this->data);
	}
	
	function do_add_job_tracking(){
		$project_id = $this->input->post('project_id');
		$description = $this->input->post('description');
		$employee_activity_category_id = $this->input->post('employee_activity_category_id');
		
		if($employee_activity_category_id==1){
			if(find('review_date',$project_id,'project_tb')){
				$due_date = find('review_date',$project_id,'project_tb');
			}else{
				$due_date = 0000-00-00;	
			}
		}else{
			$due_date = $this->input->post('due_date');
		}
		
		$priority = $this->input->post('priority');
		$active = $this->input->post('active');
		$notes = $this->input->post('notes');
		$bast_date = $this->input->post('bast_date');
		$respon_date = $this->input->post('respon_date');
		$respon_time = $this->input->post('respon_time');
		$finish_time = $this->input->post('finish_time');
		$additional_charge = $this->input->post('additional_charge');
		$resource = $this->input->post('resource');
		$pointer_at = $this->input->post('pointer_at');
		$approval = $this->input->post('approval');
		$company_id = $this->input->post('company_id');
		
		$pic_support = $this->input->post('pic_support');
		$pic_engineering = $this->input->post('pic_engineering');
		$assigned_to='';
		$employee_id = $this->input->post('employee_id');
		if($employee_id)foreach($employee_id as $list){
			$assigned_to = $assigned_to.$list."|";
		}
		
		$this->schedule_model->do_add_job_tracking($project_id,$assigned_to,$description,$due_date,$employee_activity_category_id,$priority,$active,$notes,$bast_date,$respon_date,$respon_time,$finish_time,$additional_charge,$resource,$pointer_at,$approval,$company_id,$pic_support,$pic_engineering);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_job_tracking($id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/edit_job_tracking","privilege_tb")) redirect('home');
		$this->data['job_tracking'] = $this->schedule_model->show_job_tracking_by_id($id);
		$this->data['employee'] = $this->schedule_model->show_employee_active();
		$this->data['resource_list'] = $this->schedule_model->show_resource_active();
		$this->data['company_list'] = $this->schedule_model->show_company_active();
		$this->data['employee_activity_category'] = $this->schedule_model->show_employee_activity_category();
		$this->data['page'] = 'schedule/edit_job_tracking';
		$this->load->view('common/body',$this->data);
	}
	
	function do_edit_job_tracking($id){
		$project_id = $this->input->post('project_id');
		$description = $this->input->post('description');
		$due_date = $this->input->post('due_date');
		$employee_activity_category_id = $this->input->post('employee_activity_category_id');
		$priority = $this->input->post('priority');
		$active = $this->input->post('active');
		$notes = $this->input->post('notes');
		$bast_date = $this->input->post('bast_date');
		$respon_date = $this->input->post('respon_date');
		$respon_time = $this->input->post('respon_time');
		$finish_time = $this->input->post('finish_time');
		$additional_charge = $this->input->post('additional_charge');
		$resource = $this->input->post('resource');
		$pointer_at = $this->input->post('pointer_at');
		$approval = $this->input->post('approval');
		$assigned_to='';
		$employee_id = $this->input->post('employee_id');
		$company_id = $this->input->post('company_id');
		$pic_support = $this->input->post('pic_support');
		$pic_engineering = $this->input->post('pic_engineering');
		$data = $this->schedule_model->show_job_tracking_by_id($id);
		
		if($employee_id)foreach($employee_id as $list){
			$assigned_to = $assigned_to.$list."|";
		}
		
		/*if($assigned_to == $data['assigned_to']){
			$this->schedule_model->do_edit_job_tracking($id,$project_id,$assigned_to,$description,$due_date,$employee_activity_category_id,$priority,$active,$notes,$bast_date,$respon_date,$respon_time,$finish_time,$additional_charge,$resource,$pointer_at,$approval);
		}else{
			$this->schedule_model->close_job_tracking($project_id);
			$this->schedule_model->do_add_job_tracking($project_id,$assigned_to,$description,$due_date,$employee_activity_category_id,$priority,$active,$notes,$bast_date,$respon_date,$respon_time,$finish_time,$additional_charge,$resource,$pointer_at,$approval);
			$id = mysql_insert_id();
		}*/
		
		$this->schedule_model->do_edit_job_tracking($id,$project_id,$assigned_to,$description,$due_date,$employee_activity_category_id,$priority,$active,$notes,$bast_date,$respon_date,$respon_time,$finish_time,$additional_charge,$resource,$pointer_at,$approval,$company_id,$pic_support,$pic_engineering);
		
		
		redirect('schedule/detail_job_tracking/'.$id);	
	}
	
	function detail_job_tracking($id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/detail_job_tracking","privilege_tb")) redirect('home');
		$this->data['job_tracking_log'] = $this->schedule_model->show_job_tracking_log_by_job_tracking_id($id);
		$this->data['resource_list'] = $this->schedule_model->show_resource_active();
		$this->data['company_list'] = $this->schedule_model->show_company_active();
		$this->data['job_tracking'] = $this->schedule_model->show_job_tracking_by_id($id);
		$this->data['job_tracking_information'] = $this->schedule_model->show_job_tracking_information_by_id($id);
		$this->data['employee'] = $this->schedule_model->show_employee_active();
		$this->data['employee_activity_category'] = $this->schedule_model->show_employee_activity_category();
		$this->data['page'] = 'schedule/detail_job_tracking';
		$this->load->view('common/body',$this->data);
	}
	
	function approval_job_tracking($id,$approval){
		if($approval==1){
			$approval = 0;	
		}else{
			$approval = 1;	
		}
		$this->schedule_model->approval_job_tracking($id,$approval);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function active_job_tracking($id,$active){
		if($active == 1){
			$active = 0;	
		}else{
			$active = 1;
		}
		$this->schedule_model->active_job_tracking($id,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_job_tracking($id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/delete_job_tracking","privilege_tb")) redirect('home');
		$this->schedule_model->delete_job_tracking($id);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	//job tracking information
	function do_add_job_tracking_information($id){
		$description = $this->input->post('description');
		$input_by = $this->session->userdata('employee_id');
		$input_date = date('Y-m-d');
		$this->schedule_model->do_add_job_tracking_information($id,$description,$input_by,$input_date);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function get_job_tracking_information($id){
		$this->data['job_tracking_information'] = $this->schedule_model->show_job_tracking_information_by_id_detail($id);
		$this->load->view('schedule/get_job_tracking_information',$this->data);
	}
	
	function edit_job_tracking_information($id){
		$description = $this->input->post('description');
		$this->schedule_model->edit_job_tracking_information($id,$description);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function delete_job_tracking_information($id){
		$this->schedule_model->delete_job_tracking_information($id);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function send_job_tracking($id){
			$to_email = "";
			$x=0;
			$job_tracking = $this->schedule_model->show_job_tracking_by_id($id);
			
			$assigne = explode("|",$job_tracking['assigned_to']);
			$yy= count(explode("|",$job_tracking['assigned_to']));
			
			for($z=0;$z<$yy-1;$z++){
				if(find('email',$assigne[$z],'employee_tb')){
					if($x!=0){
						$to_email = $to_email.";".find('email',$assigne[$z],'employee_tb');	
					}else{
						$to_email = find('email',$assigne[$z],'employee_tb');	
					}
					$x++;
				}
			}
			
			$email_office = $this->schedule_model->show_email_office();
			
			if($email_office)foreach($email_office as $list){
				if($to_email==""){
					$to_email = $list['email'];
				}else{
					$to_email = $to_email.";".$list['email'];
				}
				
			}
			
			$email_content=	$job_tracking['description']."<br /><br />
							<b>Deadline : ".date('d/m/Y',strtotime($job_tracking['due_date']))."</b>";
			
			$subject = "Job Tracking";
			$this->load->library('email'); 
			$this->email->from("cs@cctvcameraindonesia.com");
			$this->email->to($to_email);
				
			$this->email->subject($subject);
			$this->email->message($email_content);  
			$this->email->send();
			
			redirect($_SERVER['HTTP_REFERER']);
	}
	
	function send_job_tracking_today(){
		//$periode_selected = $this->input->post('periode_selected');
		//$job_tracking_open = $this->schedule_model->show_job_tracking_open_selected($periode_selected);
		
		$sortby = $this->input->post('sortby');
		if($sortby==1)$sortby = 'due_date desc';
		elseif($sortby==2)$sortby = 'company_id asc';
		elseif($sortby==3)$sortby = 'employee_activity_category_id asc';
		else $sortby = 'jt.id desc';
		$periode_selected = $this->input->post('periode_selected');
		if($periode_selected){
			$job_tracking_open = $this->schedule_model->show_job_tracking_open_selected($periode_selected,$sortby);
		}else{
			$periode_selected = date('Y-m-d');
			$job_tracking_open = $this->schedule_model->show_job_tracking_open($sortby);
		}
		
		$employee_active = $this->schedule_model->show_employee_active();
		//$company = $this->schedule_model->show_company_active();
		$email_content = '';
		//
		
		$email_content = "<b>Job Tracking Periode ".date('d M Y',strtotime($periode_selected))."</b>";
		$email_content.= "<table style='width:100%;' border='1'>
			<thead bgcolor='#CCCCCC'>
				<th width='1%'>No</th>
				<th width='25%'>Project Name</th>
				<th>Company</th>
				<th>Description</th>
				<th>Assign To</th>
				<th>Category</th>
				<th>Deadline</th>
				<th>Resource</th>
				<th>Support PIC</th>
				<th>Engineering PIC</th>
				<th>Assign Date</th>
				<th>Assign Time</th>
				<th>Assign Task</th>
			</thead>";
			$no = 1;
			if($job_tracking_open)foreach($job_tracking_open as $list){
				$email_content.= "
				<tr>
					<td valign='top'>".$no."</td>
					<td valign='top'>".find('name',$list['project_id'],'project_tb')."</td>
					<td align='center'  valign='top'>".find('alias',$list['company_id'],'company_tb')."&nbsp;</td>
					<td valign='top'>".nl2br($list['description'])."</td>";
					$email_content.="<td valign='top'>".find_last_assign_to($list['id'],$periode_selected)."&nbsp;</td>";
					$email_content.="<td valign='top'>".find('name',$list['employee_activity_category_id'],'employee_activity_category_tb')."</td>";
					if($list['due_date']!='0000-00-00')$email_content.= "<td valign='top'>".date('d M Y',strtotime($list['due_date']))."</td>";
					else $email_content.= "<td>&nbsp;</td>";
					$email_content.="<td valign='top'>".find('name',find_last_resource($list['id'],$periode_selected),'resource_tb')."&nbsp;</td>";
					$email_content.="<td valign='top'>".find('firstname',$list['pic_support'],'employee_tb')."&nbsp;</td>
					<td valign='top'>".find('firstname',$list['pic_engineering'],'employee_tb')."&nbsp;</td>";
						if(find_last_assign_date($list['id'],$periode_selected))
						$email_content.= "<td valign='top'>".date("d M Y",strtotime(find_last_assign_date($list['id'],$periode_selected)))."&nbsp;</td>";
					$email_content.="<td valign='top'>".find_last_assign_time($list['id'],$periode_selected)."&nbsp;</td>";
					$email_content.="<td valign='top'>".find_last_assign_task($list['id'],$periode_selected)."&nbsp;</td>";
					
				$email_content.="</tr>";
			$no++;
			}
		$email_content.= "</table>";
		
		$to_email = '';
		$email_office = $this->schedule_model->show_email_all_department_non_online();
		if($email_office)foreach($email_office as $list){
			if($to_email==""){
				$to_email = $list['email'];
			}else{
				$to_email = $to_email.";".$list['email'];
			}
			
		}
		
		$subject = "Schedule ".date('d M Y',strtotime($periode_selected));
		$this->load->library('email'); 
		$this->email->from("cs@cctvcameraindonesia.com");
		$this->email->to($to_email);
		$this->email->subject($subject);
		$this->email->message($email_content);  
		$this->email->send();
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	///////////////	
}?>