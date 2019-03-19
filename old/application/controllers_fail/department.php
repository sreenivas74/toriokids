<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Department extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('flexigrid_model');
		$this->load->model('department_model');
	}
	
	function index(){
		redirect('home');
	}
	
	function list_department(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","department/list_department","privilege_tb")){
			$this->data['page'] = 'department/list_department';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function department_flexi(){
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
		$tname="department_tb";
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
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","department/delete_department","privilege_tb")){
				$delete = " | <a href=\"".site_url('inventory/delete_department/'.$row['id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","department/edit_department","privilege_tb")){
				$json .= "'<a href=\"".site_url('department/edit_department/'.$row['id'])."\">Edit</a>'";
			 }else{
				 $json .= "'".$delete."'";
			 }
			
			$json .= ",'".esc($row['name'])."'";
			
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","department/edit_department","privilege_tb")){
				if($row['active']==1){
					$json .= ",'<a href=\"".site_url('department/active/'.$row['id'].'/'.$row['active'])."\">yes</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('department/active/'.$row['id'].'/'.$row['active'])."\">no</a>'";
				}
			}else{
				if($row['active']==1){
					$json .= ",'yes'";
				}else{
					$json .= ",'no'";
				}

			}
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
	}
	
	function add_department(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","department/add_department","privilege_tb")){
			$this->data['page'] = 'department/add_department';
			$this->load->view('common/body', $this->data);
		}else{
			redirect($_SERVER['HTTP_REFERENCE']);	
		}
	}
	
	function do_add_department(){
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		$this->department_model->do_add_department($name,$active);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_department($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","department/edit_department","privilege_tb")){
			$this->data['department'] = $this->department_model->show_department_by_id($id);
			$this->data['page'] = 'department/edit_department';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_edit_department($id){
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		$this->department_model->do_edit_department($id,$name,$active);
		redirect('department/list_department');
	}
	
	function active($id,$active){
		if($active==1){
			$active = 0;	
		}else{
			$active = 1;	
		}
		$this->department_model->active($id,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_department($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","department/delete_department","privilege_tb")){	
			$this->department_model->delete_department($id);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');
		}
	}
	
	
}?>