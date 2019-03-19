<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Employee extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('employee_model');
		$this->load->model('flexigrid_model');
	}
	
	function index(){
		redirect('home');
	}
	
	function get_absensi($userid,$month,$year){
		$this->data['absensi_detail'] = $this->employee_model->get_absence_list($userid,$month,$year);
 		$this->load->view('employee/get_absensi',$this->data);
	}
	
	function list_employee(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/list_employee","privilege_tb")){
			$this->data['page'] = 'employee/list_employee';
			$this->load->view('common/body', $this->data);
		}
	}
	
	//employee group
	function list_employee_group(){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/list_employee_group","privilege_tb"))redirect('home');
		$this->data['employee_list'] = $this->employee_model->show_employee_active();
		$this->data['emp_leader_list'] = $this->employee_model->show_emp_leader();
		$this->data['emp_group_list'] = $this->employee_model->show_emp_group();
		$this->data['page'] = 'employee/list_employee_group';
		$this->load->view('common/body',$this->data);	
	}
	
	function do_add_employee_group(){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/add_employee_group","privilege_tb"))redirect('home');
		$leader_id = $this->input->post('leader_id');
		$employee_id = $this->input->post('employee_id');
		
		if($employee_id)foreach($employee_id as $list){
			if(!find_4('id','leader_id',$leader_id,'employee_id',$list,'employee_group_tb') && $list != $leader_id){
				$this->employee_model->do_add_employee_group($leader_id,$list);
			}
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_employee_member($id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/delete_employee_group","privilege_tb"))redirect('home');
		$this->employee_model->delete_employee_member($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	//
	
	function employee_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'status desc,company_id,firstname,lastname';
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
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/delete_employee","privilege_tb")){
				$delete = " | <a href=\"".site_url('employee/delete_employee/'.$row['id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/detail_employee","privilege_tb")){
				$detail = " | <a href=\"".site_url('employee/detail_employee/'.$row['id'])."\">Detail</a>";
			 }else{
				$detail = ""; 
			 }
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/edit_employee","privilege_tb")){
				$json .= "'<a href=\"".site_url('employee/edit_employee/'.$row['id'])."\">Edit</a>".$delete.$detail."'";
			 }else{
				$json .= "'".$delete.$detail."'";
			 }
			 
			 
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/edit_employee","privilege_tb")){
				if($row['status']==1){
					$json .= ",'<a href=\"".site_url('employee/active_employee/'.$row['id'].'/'.$row['status'])."\">active</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('employee/active_employee/'.$row['id'].'/'.$row['status'])."\">non-active</a>'";
				}
			}else{
				if($row['status']==1){
					$json .= ",'active'";
				}else{
					$json .= ",'non-active'";
				}
			} 
			$json .= ",'".find('name',esc($row['company_id']),'company_tb')."'";
			/*if($row['category']==1){
				$json .= ",'Technician'";
			}elseif($row['category']==2){
				$json .= ",'Web'";
			}elseif($row['category']==3){
				$json .= ",'Marketing'";
			}else{
				$json .= ",'-'";
			}*/
			$json .= ",'".esc($row['firstname'])."'";
			$json .= ",'".esc($row['lastname'])."'";
			
			/*if(find_2('privilege_id','employee_id',$row['id'],'administrator_tb')){
				$json .= ",'".find('name',find_2('privilege_id','employee_id',$row['id'],'administrator_tb'),'privilege_user_tb')."'";
			}else{
				$json .= ",'-'";	
			}
			*/
			
			
			/*$json .= ",'".esc($row['nik'])."'";
			
			if($row['join_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['join_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			
			$json .= ",'".esc($row['birth_place'])."'";
			
			if($row['birth_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['birth_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			
			$json .= ",'".esc($row['education'])."'";
			$json .= ",'".esc($row['school'])."'";
			$json .= ",'".esc($row['certificate'])."'";
			$json .= ",'".esc($row['grade'])."'";*/
			$json .= ",'".find('name',esc($row['department_id']),'department_tb')."'";
			/*$json .= ",'".esc($row['job_title'])."'";
			$json .= ",'".esc($row['no_ktp'])."'";
			$json .= ",'".esc($row['address_ktp'])."'";
			$json .= ",'".esc($row['address_now'])."'";*/
			$json .= ",'".esc($row['gsm_1'])."'";
			$json .= ",'".esc($row['gsm_2'])."'";
			$json .= ",'".esc($row['phone'])."'";
		/*	$json .= ",'".esc($row['pin_bb'])."'";
			$json .= ",'".esc($row['email'])."'";
			$json .= ",'".esc($row['name_reference'])."'";
			$json .= ",'".esc($row['phone_reference'])."'";
			$json .= ",'".esc($row['relation_reference'])."'";
			$json .= ",'".esc($row['marriage_status'])."'";
			$json .= ",'".esc($row['wife'])."'";
			$json .= ",'".esc($row['child'])."'";
			$json .= ",'".esc($row['religion'])."'";
			$json .= ",'".esc($row['account_number'])."'";*/
			
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
	
	function detail_employee($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/detail_employee","privilege_tb")){
			$this->data['employee_information'] = $this->employee_model->show_employee_information_by_id($id);
			$this->data['employee'] = $this->employee_model->show_employee_by_id($id);
			$this->data['page'] = "employee/detail_employee";
			$this->load->view('common/body',$this->data);
		}
	}
	
	function do_add_employee_information($id){
		$description = $this->input->post('description');
		$deadline_date = $this->input->post('deadline_date');
		$input_by = $this->session->userdata('employee_id');
		$input_date = date('Y-m-d');
		$this->employee_model->do_add_employee_information($id,$description,$deadline_date,$input_by,$input_date);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function add_employee(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/add_employee","privilege_tb")){
			$precedence= find('precedence',$this->session->userdata('admin_privilege'),'privilege_user_tb');
			
			$this->data['privilege'] = $this->employee_model->show_privilege2($precedence);
			
			$this->data['company'] = $this->employee_model->show_company();
			$this->data['department'] = $this->employee_model->show_department();
			$this->data['page'] = 'employee/add_employee';
			$this->load->view('common/body', $this->data);
		}
	}
	
	function delete_employee_information($id){
		$this->employee_model->delete_employee_information($id);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function do_add_employee(){
		$privilege_id = $this->input->post('privilege_id');
		$category = $this->input->post('category');
		$firstname = $this->input->post('firstname');	
		$lastname = $this->input->post('lastname');
		$company_id = $this->input->post('company_id');
		$nik = $this->input->post('nik');
		$join_date = $this->input->post('join_date');
		$birth_date = $this->input->post('birth_date');
		$birth_place = $this->input->post('birth_place');
		$education = $this->input->post('education');
		$school = $this->input->post('school');
		$certificate = $this->input->post('certificate');
		$grade = $this->input->post('grade');
		$department_id = $this->input->post('department_id');
		$job_title = $this->input->post('job_title');
		$no_ktp = $this->input->post('no_ktp');
		$address_ktp = $this->input->post('address_ktp');
		$address_now = $this->input->post('address_now');
		$gsm_1 = $this->input->post('gsm_1');
		$gsm_2 = $this->input->post('gsm_2');
		$phone = $this->input->post('phone');
		$pin_bb = $this->input->post('pin_bb');
		$email = $this->input->post('email');
		$name_reference = $this->input->post('name_reference');
		$phone_reference = $this->input->post('phone_reference');
		$relation_reference = $this->input->post('relation_reference');
		$marriage_status = $this->input->post('marriage_status');
		$wife = $this->input->post('wife');
		$child = $this->input->post('child');
		$religion = $this->input->post('religion');
		$account_number = $this->input->post('account_number');
		$sim_a = $this->input->post('sim_a');
		$sim_c = $this->input->post('sim_c');
		$motor = $this->input->post('motor');
		$status = $this->input->post('status');
		$type = $this->input->post('type');
		
		if($type==1){
			$type_date = date("Y-m-d");	
		}else{
			$type_date = 0000-00-00;	
		}
		
		$this->employee_model->do_add_employee($category,$firstname,$lastname,$company_id,$nik,$join_date,$birth_date,$birth_place,$education,$school,$certificate,$grade,$department_id,$job_title,$no_ktp,$address_ktp,$address_now,$gsm_1,$gsm_2,$phone,$pin_bb,$email,$name_reference,$phone_reference,$relation_reference,$marriage_status,$wife,$child,$religion,$account_number,$sim_a,$sim_c,$motor,$status,$type,$type_date);
		
		$employee_id = mysql_insert_id();
		$password=rand(10000,99999);
		$this->employee_model->insert_into_admin($employee_id,$firstname,$lastname,$email,$privilege_id,$password);
		
		$email_content="Username : ".$email."<br />
						Password : ".$password."<br />
						Please change your password at myprofile page";
		$subject = "User Login to Golden Solution System";
		$this->load->library('email'); 
		$this->email->from("crm@gsindonesia.com");
		$this->email->to($email);
			
		$this->email->subject($subject);
		$this->email->message($email_content);  
		$this->email->send();
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_employee($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/edit_employee","privilege_tb")){
				$precedence= find('precedence',$this->session->userdata('admin_privilege'),'privilege_user_tb');
			
			$this->data['privilege'] = $this->employee_model->show_privilege2($precedence);
			$this->data['company'] = $this->employee_model->show_company();
			$this->data['department'] = $this->employee_model->show_department();
			$this->data['employee'] = $this->employee_model->show_employee_by_id($id);
			$this->data['page'] = 'employee/edit_employee';
			$this->load->view('common/body', $this->data);
		}
	}
	
	function do_edit_employee($id){
		$privilege_id = $this->input->post('privilege_id');
		$category = $this->input->post('category');
		$firstname = $this->input->post('firstname');	
		$lastname = $this->input->post('lastname');
		$company_id = $this->input->post('company_id');
		$nik = $this->input->post('nik');
		$join_date = $this->input->post('join_date');
		$birth_date = $this->input->post('birth_date');
		$birth_place = $this->input->post('birth_place');
		$education = $this->input->post('education');
		$school = $this->input->post('school');
		$certificate = $this->input->post('certificate');
		$grade = $this->input->post('grade');
		$department_id = $this->input->post('department_id');
		$job_title = $this->input->post('job_title');
		$no_ktp = $this->input->post('no_ktp');
		$address_ktp = $this->input->post('address_ktp');
		$address_now = $this->input->post('address_now');
		$gsm_1 = $this->input->post('gsm_1');
		$gsm_2 = $this->input->post('gsm_2');
		$phone = $this->input->post('phone');
		$pin_bb = $this->input->post('pin_bb');
		$email = $this->input->post('email');
		$name_reference = $this->input->post('name_reference');
		$phone_reference = $this->input->post('phone_reference');
		$relation_reference = $this->input->post('relation_reference');
		$marriage_status = $this->input->post('marriage_status');
		$wife = $this->input->post('wife');
		$child = $this->input->post('child');
		$religion = $this->input->post('religion');
		$account_number = $this->input->post('account_number');
		$sim_a = $this->input->post('sim_a');
		$sim_c = $this->input->post('sim_c');
		$motor = $this->input->post('motor');
		$status = $this->input->post('status');
		$out_date = $this->input->post('out_date');
		
		$type = $this->input->post('type');
		
		if($type==1){
			$type_date = date("Y-m-d");	
		}else{
			$type_date = 0000-00-00;	
		}
		
		$this->employee_model->do_edit_employee($id,$category,$firstname,$lastname,$company_id,$nik,$join_date,$birth_date,$birth_place,$education,$school,$certificate,$grade,$department_id,$job_title,$no_ktp,$address_ktp,$address_now,$gsm_1,$gsm_2,$phone,$pin_bb,$email,$name_reference,$phone_reference,$relation_reference,$marriage_status,$wife,$child,$religion,$account_number,$sim_a,$sim_c,$motor,$status,$privilege_id,$type,$type_date,$out_date);
		
		redirect('employee/detail_employee/'.$id);
	}
	
	function active_employee($id,$active){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/edit_employee","privilege_tb")){
			if($active == 1){
				$active = 0;
			}else{
				$active = 1;	
			}
			$this->employee_model->active_employee($id,$active);
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	function delete_employee($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/delete_employee","privilege_tb")){
			$this->employee_model->delete_employee($id);
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	//information
	function get_employee_information($id){
		$this->data['employee_information'] = $this->employee_model->show_employee_information_by_id_detail($id);
		$this->load->view('employee/get_information',$this->data);
	}
	
	function edit_employee_information($id){
		$description = $this->input->post('description');
		$deadline_date = $this->input->post('deadline_date');
		$this->employee_model->edit_employee_information($id,$description,$deadline_date);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function status_employee_information($id,$status){
		if($status==1){
			$status = 0;	
		}else{
			$status = 1;	
		}
		
		$this->employee_model->status_employee_information($id,$status);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	//
	
	function employee_flexi_request_fund(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'status desc,company_id,firstname,lastname';
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
			
			$json .= "'<a href=\"#\" onclick=\"add_employee_bs(\'".esc($row['firstname']).' '.esc($row['lastname'])."\',\'".$row['id']."\');\">Add</a>'";
			 
			
			$json .= ",'".find('name',esc($row['company_id']),'company_tb')."'";
			/*if($row['category']==1){
				$json .= ",'Technician'";
			}elseif($row['category']==2){
				$json .= ",'Web'";
			}elseif($row['category']==3){
				$json .= ",'Marketing'";
			}else{
				$json .= ",'-'";
			}*/
			$json .= ",'".esc($row['firstname'])."'";
			$json .= ",'".esc($row['lastname'])."'";
			
			/*if(find_2('privilege_id','employee_id',$row['id'],'administrator_tb')){
				$json .= ",'".find('name',find_2('privilege_id','employee_id',$row['id'],'administrator_tb'),'privilege_user_tb')."'";
			}else{
				$json .= ",'-'";	
			}
			*/
			
			
			/*$json .= ",'".esc($row['nik'])."'";
			
			if($row['join_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['join_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			
			$json .= ",'".esc($row['birth_place'])."'";
			
			if($row['birth_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['birth_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			
			$json .= ",'".esc($row['education'])."'";
			$json .= ",'".esc($row['school'])."'";
			$json .= ",'".esc($row['certificate'])."'";
			$json .= ",'".esc($row['grade'])."'";*/
			$json .= ",'".find('name',esc($row['department_id']),'department_tb')."'";
			/*$json .= ",'".esc($row['job_title'])."'";
			$json .= ",'".esc($row['no_ktp'])."'";
			$json .= ",'".esc($row['address_ktp'])."'";
			$json .= ",'".esc($row['address_now'])."'";*/
			$json .= ",'".esc($row['gsm_1'])."'";
			$json .= ",'".esc($row['gsm_2'])."'";
			$json .= ",'".esc($row['phone'])."'";
		/*	$json .= ",'".esc($row['pin_bb'])."'";
			$json .= ",'".esc($row['email'])."'";
			$json .= ",'".esc($row['name_reference'])."'";
			$json .= ",'".esc($row['phone_reference'])."'";
			$json .= ",'".esc($row['relation_reference'])."'";
			$json .= ",'".esc($row['marriage_status'])."'";
			$json .= ",'".esc($row['wife'])."'";
			$json .= ",'".esc($row['child'])."'";
			$json .= ",'".esc($row['religion'])."'";
			$json .= ",'".esc($row['account_number'])."'";*/
			
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
}?>