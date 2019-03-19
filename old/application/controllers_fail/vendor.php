<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Vendor extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('vendor_model');
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
	
	function list_vendor(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/list_vendor","privilege_tb")){
			$this->data['page'] = 'vendor/list_vendor';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
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
		$where = "";
		if ($query) $where = " where $qtype LIKE '%$query%' ";
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
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/delete_vendor","privilege_tb")){
				$delete = " | <a href=\"".site_url('vendor/delete_vendor/'.$row['id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/detail_vendor","privilege_tb")){
				$detail = " | <a href=\"".site_url('vendor/detail_vendor/'.$row['id'])."\" >Detail</a>";
			 }else{
				 $detail = "";
			 }
			 
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/edit_vendor","privilege_tb")){
				$visit = " | <a href=\"#\" onclick=\"message_no(".$row['id'].");\">Visit</a>";
			 }else{
				$visit = "";
			 }

			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/edit_vendor","privilege_tb")){
				$json .= "'<a href=\"".site_url('vendor/edit_vendor/'.$row['id'])."\">Edit</a>".$delete.$detail.$visit."'";
			 }else{
				 $json .= "'".$delete.$detail.$visit."'";
			 }
			
			$json .= ",'".esc($row['name'])."'";
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/edit_vendor","privilege_tb")){
				if($row['active']==1){
					$json .= ",'<a href=\"".site_url('vendor/active_vendor/'.$row['id'].'/'.$row['active'])."\">active</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('vendor/active_vendor/'.$row['id'].'/'.$row['active'])."\">non-active</a>'";
				}
			}else{
				if($row['active']==1){
					$json .= ",'active'";
				}else{
					$json .= ",'non-active'";
				}
			}
			$json .= ",'".esc($row['type'])."'";
			$json .= ",'".esc($row['description'])."'";
			$json .= ",'".esc($row['address'])."'";
			$json .= ",'".esc($row['location'])."'";
			$json .= ",'".esc($row['cp_1'])."'";
			$json .= ",'".esc($row['cp_2'])."'";
			$json .= ",'".esc($row['phone'])."'";
			$json .= ",'".esc($row['handphone'])."'";
			$json .= ",'".esc($row['fax'])."'";
			$json .= ",'".esc($row['email'])."'";
			$json .= ",'".esc($row['website'])."'";
			$json .= ",'".esc($row['account_number'])."'";
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;	
	}
	
	function detail_vendor($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/detail_vendor","privilege_tb")){
			$this->data['vendor_information'] = $this->vendor_model->show_vendor_information_by_id($id);
			$this->data['vendor'] = $this->vendor_model->show_vendor_by_id($id);
			$this->data['page'] = 'vendor/detail_vendor';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function add_vendor(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/add_vendor","privilege_tb")){
			$this->data['page'] = 'vendor/add_vendor';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_add_vendor(){
		$bank_name=$this->input->post('bank_name');
		$account_name=$this->input->post('account_name');
		$name = $this->input->post('name');	
		$type = $this->input->post('type');
		$description = $this->input->post('description');
		$location = $this->input->post('location');
		$address = $this->input->post('address');
		$cp_1 = $this->input->post('cp_1');
		$cp_2 = $this->input->post('cp_2');
		$phone = $this->input->post('phone');
		$handphone = $this->input->post('handphone');
		$fax = $this->input->post('fax');
		$email = $this->input->post('email');
		$website = $this->input->post('website');
		$account_number = $this->input->post('account_number');
		$active = $this->input->post('active');
		//////////////////////////////////////
		chmod("userdata/attachment",0777);
		
		$config['upload_path'] = "userdata/attachment/";
		$config['allowed_types'] = 'doc|pdf|txt|xls|pt|ppt|docx|pptx|xlsx|jpg|png';
		$config['encrypt_name'] = true;
		$attachment='';
		if($this->upload($config,'attachment')){
			$data=$this->upload->data();
			$attachment = $data['file_name'];
		}
	
		
		$this->vendor_model->do_add_vendor($name,$type,$description,$location,$address,$cp_1,$cp_2,$phone,$handphone,$fax,$email,$website,$account_number,$attachment,$active,$bank_name,$account_name);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_vendor($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/edit_vendor","privilege_tb")){
			$this->data['vendor'] = $this->vendor_model->show_vendor_by_id($id);
			$this->data['page'] = 'vendor/edit_vendor';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_edit_vendor($id){
		$bank_name=$this->input->post('bank_name');
		$account_name=$this->input->post('account_name');
		$name = $this->input->post('name');	
		$type = $this->input->post('type');
		$description = $this->input->post('description');
		$location = $this->input->post('location');
		$address = $this->input->post('address');
		$cp_1 = $this->input->post('cp_1');
		$cp_2 = $this->input->post('cp_2');
		$phone = $this->input->post('phone');
		$handphone = $this->input->post('handphone');
		$fax = $this->input->post('fax');
		$email = $this->input->post('email');
		$website = $this->input->post('website');
		$account_number = $this->input->post('account_number');
		$active = $this->input->post('active');
		
		$old_attachment = $this->vendor_model->show_vendor_by_id($id);
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
		
		$this->vendor_model->do_edit_vendor($id,$name,$type,$description,$location,$address,$cp_1,$cp_2,$phone,$handphone,$fax,$email,$website,$account_number,$attachment,$active,$bank_name,$account_name);
		redirect('vendor/detail_vendor/'.$id);
	}
	
	function active_vendor($id,$active){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/edit_vendor","privilege_tb")){
			if($active == 1){
				$active = 0;
			}else{
				$active = 1;	
			}
			$this->vendor_model->active_vendor($id,$active);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	
	function delete_vendor($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/delete_vendor","privilege_tb")){
			$this->vendor_model->delete_vendor($id);
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
		
		$this->vendor_model->do_add_vendor_information($id,$description,$input_by,$input_date);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	/////vendor information
	function do_add_vendor_information($id){
		$description = $this->input->post('description');
		$input_by = $this->session->userdata('employee_id');
		$input_date = date('Y-m-d');
		$this->vendor_model->do_add_vendor_information($id,$description,$input_by,$input_date);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function delete_vendor_information($id){
		$this->vendor_model->delete_vendor_information($id);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function get_vendor_information($id){
		$this->data['vendor_information'] = $this->vendor_model->show_vendor_information_by_id_detail($id);
		$this->load->view('vendor/get_information',$this->data);
	}
	
	function edit_vendor_information($id){
		$description = $this->input->post('description');
		$this->vendor_model->edit_vendor_information($id,$description);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	/////////
	
}?>