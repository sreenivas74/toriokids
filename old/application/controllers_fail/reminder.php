<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Reminder extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('flexigrid_model');
		$this->load->model('reminder_model');
	}
	
	function index(){
		redirect('home');
	}
	
	function list_reminder(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder_2","privilege_tb")){
			$this->data['filter_reminder'] = $this->input->post('filter_reminder');
			$this->data['page'] = 'reminder/list';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function reminder_flexi($filter_reminder){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'r.status asc, date_deadline';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*,r.id as r_id, r.status as r_status";
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder","privilege_tb")){
			
			if($filter_reminder==-1){
				$where = "";
				if ($query) $where .= " where $qtype LIKE '%$query%' ";
			}else{
				$where = "where r.date_send >= '".$filter_reminder."-01-01' and r.date_send <= '".$filter_reminder."-12-31'";
				if ($query) $where .= " and $qtype LIKE '%$query%' ";
			}
			
			
		}elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder_2","privilege_tb")){
			
			if($this->session->userdata('employee_id')!=0){
				if($filter_reminder==-1){
					$where = "where r.department_id = ".find('department_id',$this->session->userdata('employee_id'),'employee_tb')."";
					if ($query) $where .= " and $qtype LIKE '%$query%' ";
				}else{
					$where = "where r.department_id = ".find('department_id',$this->session->userdata('employee_id'),'employee_tb')." and r.date_send >= '".$filter_reminder."-01-01' and r.date_send <= '".$filter_reminder."-12-31'";
					if ($query) $where .= " and $qtype LIKE '%$query%' ";
				}
				
			}else{
				if($filter_reminder==-1){
					$where = "";
					if ($query) $where .= " where $qtype LIKE '%$query%' ";
				}else{
					$where = "where r.date_send >= '".$filter_reminder."-01-01' and r.date_send <= '".$filter_reminder."-12-31'";
					if ($query) $where .= " and $qtype LIKE '%$query%' ";
				}
			}
			
		}
		
		$tname="reminder_tb r
				left join department_tb d on r.department_id = d.id
				left join employee_tb e on r.created_by = e.id";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("r.id"," $tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if($result) foreach($result as $row){
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/delete_reminder","privilege_tb")){
				$delete = " | <a href=\"".site_url('reminder/delete_reminder/'.$row['r_id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/detail_reminder","privilege_tb")){
				$detail = " | <a href=\"".site_url('reminder/detail_reminder/'.$row['r_id'])."\">Detail</a>";
			 }else{
				$detail = "";
			 }
			 
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/edit_reminder","privilege_tb")){
				$edit = "<a href=\"".site_url('reminder/edit_reminder/'.$row['r_id'])."\">Edit</a>";
			 }else{
				$edit = "";
			 }
			
			//if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/edit_reminder","privilege_tb")){
				$send = " | <a href=\"".site_url('reminder/send_reminder/'.$row['r_id'])."\" onclick=\"return confirm(\'Send This Email?\');\">Send</a>";
			// }else{
			//	$edit = "";
			// }
			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			 
			$json .= "'".$edit.$delete.$detail.$send."'";
			$json .= ",'".esc(nl2br($row['description']))."'";
			
			if($row['date_send']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['date_send'])))."'";
			}else{
				$json .= ",'-'";	
			}
			
			if($row['date_deadline']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['date_deadline'])))."'";
			}else{
				$json .= ",'-'";	
			}
			
			$json .= ",'".esc($row['name'])."'";
			
			
			
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/edit_reminder","privilege_tb")){
				if($row['r_status']==1){
					$json .= ",'<a href=\"".site_url('reminder/active_reminder/'.$row['r_id'].'/'.$row['r_status'])."\" onclick=\"return confirm(\'Are you sure?\');\">Done</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('reminder/active_reminder/'.$row['r_id'].'/'.$row['r_status'])."\" onclick=\"return confirm(\'Are you sure?\');\">Not Done</a>'";
				}
			}else{
				if($row['status']==1){
					$json .= ",'Done'";
				}else{
					$json .= ",'Not Done'";
				}
			}
			
			if($row['date_done']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['date_done'])))."'";
			}else{
				$json .= ",'-'";	
			}
			
			if($row['done_by']!=0){
				$json .= ",'".find('firstname',esc($row['done_by']),'employee_tb')." ".find('lastname',esc($row['done_by']),'employee_tb')."'";
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
	
	function detail_reminder($id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/detail_reminder","privilege_tb"))redirect('home');
		$this->data['department'] = $this->reminder_model->show_department_active();
		$this->data['reminder'] = $this->reminder_model->show_reminder_by_id($id);
		$this->data['page'] = 'reminder/detail';
		$this->load->view('common/body', $this->data);
		
	}
	
	function add_reminder(){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/add_reminder","privilege_tb"))redirect('home');
			$this->data['department'] = $this->reminder_model->show_department_active();
			$this->data['page'] = 'reminder/add';
			$this->load->view('common/body', $this->data);
		
	}
	
	function do_add_reminder(){
		$department_id = $this->input->post('department_id');
		$description = $this->input->post('description');
		$date_send = $this->input->post('date_send');
		$date_deadline = $this->input->post('date_deadline');
		$created_by = $this->session->userdata('created_by');
		$repeat = $this->input->post('repeat');
		$date_created = date("Y-m-d");
		
		if($repeat==1){
			$this->reminder_model->do_add_reminder($department_id,$description,$date_send,$date_deadline,$created_by,$date_created);
		}elseif($repeat==2){
			for($x=1;$x<4;$x++){
				//echo $date_deadline."<br />";
				$this->reminder_model->do_add_reminder($department_id,$description,$date_send,$date_deadline,$created_by,$date_created);
				$date_send = date("Y-m-d",strtotime("+1 month",strtotime($date_send)));
				$date_deadline = date("Y-m-d",strtotime("+1 month",strtotime($date_deadline)));
			}
		}elseif($repeat==3){
			for($x=1;$x<13;$x++){
				$this->reminder_model->do_add_reminder($department_id,$description,$date_send,$date_deadline,$created_by,$date_created);
				$date_send = date("Y-m-d",strtotime("+1 month",strtotime($date_send)));
				$date_deadline = date("Y-m-d",strtotime("+1 month",strtotime($date_deadline)));
			}
		}elseif($repeat==4){
			for($x=1;$x<25;$x++){
				$this->reminder_model->do_add_reminder($department_id,$description,$date_send,$date_deadline,$created_by,$date_created);
				$date_send = date("Y-m-d",strtotime("+1 month",strtotime($date_send)));
				$date_deadline = date("Y-m-d",strtotime("+1 month",strtotime($date_deadline)));
			}
		}elseif($repeat==5){
			for($x=1;$x<4;$x++){
				$this->reminder_model->do_add_reminder($department_id,$description,$date_send,$date_deadline,$created_by,$date_created);
				$date_send = date("Y-m-d",strtotime("+1 year",strtotime($date_send)));
				$date_deadline = date("Y-m-d",strtotime("+1 year",strtotime($date_deadline)));
			}
		}elseif($repeat==6){
			for($x=1;$x<6;$x++){
				$this->reminder_model->do_add_reminder($department_id,$description,$date_send,$date_deadline,$created_by,$date_created);
				$date_send = date("Y-m-d",strtotime("+1 year",strtotime($date_send)));
				$date_deadline = date("Y-m-d",strtotime("+1 year",strtotime($date_deadline)));
			}
		}elseif($repeat==7){
			for($x=1;$x<11;$x++){
				$this->reminder_model->do_add_reminder($department_id,$description,$date_send,$date_deadline,$created_by,$date_created);
				$date_send = date("Y-m-d",strtotime("+1 year",strtotime($date_send)));
				$date_deadline = date("Y-m-d",strtotime("+1 year",strtotime($date_deadline)));
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_reminder($id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/edit_reminder","privilege_tb"))redirect('home');
			$this->data['department'] = $this->reminder_model->show_department_active();
			$this->data['reminder'] = $this->reminder_model->show_reminder_by_id($id);
			$this->data['page'] = 'reminder/edit';
			$this->load->view('common/body', $this->data);
	}
	
	function do_edit_reminder($id){
		$department_id = $this->input->post('department_id');
		$description = $this->input->post('description');
		$date_send = $this->input->post('date_send');
		$date_deadline = $this->input->post('date_deadline');
		
		$this->reminder_model->do_edit_reminder($id,$department_id,$description,$date_send,$date_deadline);
		redirect('reminder/list_reminder');
	}
	
	function active_reminder($id,$status){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/edit_reminder","privilege_tb")) redirect('home');
			if($status==0){
				$status = 1;
				$date_done = date("Y-m-d");
				$done_by = $this->session->userdata('employee_id');
			}else{
				$status = 0;
				$date_done = 0000-00-00;
				$done_by = 0;	
			}
			
			$this->reminder_model->active_reminder($id,$status,$done_by,$date_done);
			redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_reminder($id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/delete_reminder","privilege_tb")) redirect('home');
			$this->reminder_model->delete_reminder($id);
			redirect($_SERVER['HTTP_REFERER']);
	}
	
	function send_reminder($id){
			$to_email = "";
			$x=0;
			$reminder= $this->reminder_model->show_reminder_by_id($id);
			
			$department_list = $this->reminder_model->show_employee_by_department($reminder['department_id']);
			
			if($department_list)foreach($department_list as $list){
				//echo $list['email']."<br />";
				if($list['email']!=""){
					if($x!=0){
						$to_email = $to_email.";".$list['email'];
					}else{
						$to_email = $list['email'];	
					}
				}
				$x++;
			}
			
			
			$email_content=	$reminder['description']."<br /><br />
							<b>Reminder : ".date('d/m/Y',strtotime($reminder['date_send']))."</b><br />
							<b>Deadline : ".date('d/m/Y',strtotime($reminder['date_deadline']))."</b>";
			
			$subject = "Reminder";
			$this->load->library('email'); 
			$this->email->from("crm@gsindonesia.com");
			$this->email->to($to_email);
				
			$this->email->subject($subject);
			$this->email->message($email_content);  
			$this->email->send();
			
			redirect($_SERVER['HTTP_REFERER']);
	}
}?>