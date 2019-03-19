<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Client extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('client_model');
		$this->load->model('flexigrid_model');
	}
	
	function upload($config,$file){
		$this->load->library('upload');
		$this->upload->initialize($config);
		if($this->upload->do_upload($file))
		return true;
		return false;
	}
	
	function index(){
		redirect('home');
	}
	
	function list_client(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/list_client","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/list_client_2","privilege_tb") ){
			$this->data['page'] = 'client/list_client';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
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
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/list_client","privilege_tb")){
			$where = "";
			if ($query) $where .= " where $qtype LIKE '%$query%' ";
		}elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/list_client_2","privilege_tb")){
			$where = "where employee_id = '".$this->session->userdata('employee_id')."'";
			if ($query) $where .= " and $qtype LIKE '%$query%' ";
		}
		
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
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/delete_client","privilege_tb")){
				$delete = " | <a href=\"".site_url('client/delete_client/'.$row['id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/detail_client","privilege_tb")){
				$detail = " | <a href=\"".site_url('client/detail_client/'.$row['id'])."\">Detail</a>";
			 }else{
				$detail = "";
			 }
			 
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/edit_client","privilege_tb")){
				$visit = " | <a href=\"#\" onclick=\"message_no(".$row['id'].");\">Visit</a>";
			 }else{
				$visit = "";
			 }
			 
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/edit_client","privilege_tb")){
				$edit = "<a href=\"".site_url('client/edit_client/'.$row['id'])."\">Edit</a>";
			 }else{
				$edit = "";
			 }

			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			 
			$json .= "'".$edit.$delete.$detail.$visit."'";
			
			$json .= ",'".esc($row['name'])."'";
			$json .= ",'".find('name',esc($row['industry']),'industry_tb')."'";
			
			if($row['employee_id']!=0){
				$json .= ",'".find('firstname',esc($row['employee_id']),'employee_tb')." ".find('lastname',esc($row['employee_id']),'employee_tb')."'";
			}else{
				$json .= ",'Admin'";
			}
			
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/edit_client","privilege_tb")){
				if($row['active']==1){
					$json .= ",'<a href=\"".site_url('client/active_client/'.$row['id'].'/'.$row['active'])."\">active</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('client/active_client/'.$row['id'].'/'.$row['active'])."\">non-active</a>'";
				}
			}else{
				if($row['active']==1){
					$json .= ",'active'";
				}else{
					$json .= ",'non-active'";
				}
			}
			
			$json .= ",'".esc($row['product'])."'";
			$json .= ",'".esc($row['location'])."'";
			$json .= ",'".esc($row['cp_1'])."'";
			$json .= ",'".esc($row['cp_2'])."'";
			$json .= ",'".esc($row['phone'])."'";
			$json .= ",'".esc($row['handphone'])."'";
			$json .= ",'".esc($row['fax'])."'";
			$json .= ",'".esc($row['email'])."'";
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	function detail_client($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/detail_client","privilege_tb")){
			$this->data['client_information'] = $this->client_model->show_client_information_by_id($id);
			$this->data['client'] = $this->client_model->show_client_by_id($id);
			$this->data['page'] = 'client/detail_client';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function add_client(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/add_client","privilege_tb")){
			$this->data['industry'] = $this->client_model->show_industry();
			$this->data['employee'] = $this->client_model->show_employee();
			$this->data['page'] = 'client/add_client';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_add_client(){
		$employee_id = $this->input->post('employee_id');
		$name = $this->input->post('name');	
		$industry = $this->input->post('industry');
		$product = $this->input->post('product');
		$location = $this->input->post('location');
		$cp_1 = $this->input->post('cp_1');
		$cp_2 = $this->input->post('cp_2');
		$phone = $this->input->post('phone');
		$handphone = $this->input->post('handphone');
		$fax = $this->input->post('fax');
		$email = $this->input->post('email');
		$active = $this->input->post('active');
	
		//////////////////////////////////////
		chmod("userdata/attachment",0777);
		
		$config['upload_path'] = "userdata/attachment/";
		$config['allowed_types'] = 'doc|pdf|txt|xls|pt|ppt|docx|pptx|xlsx|jpg|png';
		$config['encrypt_name'] = true;
		
		if($this->upload($config,'attachment')){
			$data=$this->upload->data();
			$attachment = $data['file_name'];
		}
		
		$this->client_model->do_add_client($employee_id,$name,$industry,$product,$location,$cp_1,$cp_2,$phone,$handphone,$fax,$email,$active,$attachment);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_client($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/edit_client","privilege_tb")){
			$this->data['industry'] = $this->client_model->show_industry();
			$this->data['employee'] = $this->client_model->show_employee();
			$this->data['client'] = $this->client_model->show_client_by_id($id);
			$this->data['page'] = 'client/edit_client';
			$this->load->view('common/body', $this->data);	
		}else{
			redirect('home');	
		}
	}
	
	function do_edit_client($id){
		$employee_id = $this->input->post('employee_id');
		$name = $this->input->post('name');	
		$industry = $this->input->post('industry');
		$product = $this->input->post('product');
		$location = $this->input->post('location');
		$cp_1 = $this->input->post('cp_1');
		$cp_2 = $this->input->post('cp_2');
		$phone = $this->input->post('phone');
		$handphone = $this->input->post('handphone');
		$fax = $this->input->post('fax');
		$email = $this->input->post('email');
		$active = $this->input->post('active');
		
		$old_attachment = $this->client_model->show_client_by_id($id);
		$attachment = $old_attachment['attachment'];
	
			////////////////////////////////////////////////////
			
			chmod("userdata/attachment",0777);
			
			$config['upload_path'] = "userdata/attachment/";
			$config['allowed_types'] = 'doc|pdf|txt|xls|pt|ppt|docx|pptx|xlsx|jpg|png';
			$config['encrypt_name'] = true;
			
			if($this->upload($config,'attachment')){
				$src="userdata/attachment/".$attachment;
				if($attachment!=""){
					if(file_exists($src))unlink($src);
				}
				
				$file_data=$this->upload->data();
				$attachment = $file_data['file_name']; 
			}
		
		$this->client_model->do_edit_client($id,$employee_id,$name,$industry,$product,$location,$cp_1,$cp_2,$phone,$handphone,$fax,$email,$active,$attachment);
		redirect('client/detail_client/'.$id);
	}
	
	function active_client($id,$active){
		if($active == 1){
			$active = 0;
		}else{
			$active = 1;	
		}
		$this->client_model->active_client($id,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_client($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/delete_client","privilege_tb")){
			$this->client_model->delete_client($id);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	
	function update_last_check_date_2(){
		$description = $this->input->post('description');
		$id = $this->input->post('id');
		
		$input_by = $this->session->userdata('employee_id');
		$input_date = date('Y-m-d');
		
		$this->client_model->do_add_client_information($id,$description,$input_by,$input_date);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	//information
	function do_add_client_information($id){
		$description = $this->input->post('description');
		$input_by = $this->session->userdata('employee_id');
		$input_date = date('Y-m-d');
		$this->client_model->do_add_client_information($id,$description,$input_by,$input_date);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function delete_client_information($id){
		$this->client_model->delete_client_information($id);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function get_client_information($id){
		$this->data['client_information'] = $this->client_model->show_client_information_by_id_detail($id);
		$this->load->view('client/get_information',$this->data);
	}
	
	function edit_client_information($id){
		$description = $this->input->post('description');
		$this->client_model->edit_client_information($id,$description);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	//
	
}?>