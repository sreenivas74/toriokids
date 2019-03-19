<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Company extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('flexigrid_model');
		$this->load->model('company_model');
	}
	
	function index(){
		redirect('home');
	}
	
	function list_company(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","company/list_company","privilege_tb")){
			$this->data['page'] = 'company/list_company';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function company_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'id';
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
		$tname="company_tb";
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
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","company/delete_company","privilege_tb")){
				$delete = " | <a href=\"".site_url('inventory/delete_company/'.$row['id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","company/edit_company","privilege_tb")){
				$json .= "'<a href=\"".site_url('company/edit_company/'.$row['id'])."\">Edit</a>'";
			 }else{
				 $json .= "'".$delete."'";
			 }
			
			$json .= ",'".esc($row['name'])."'";
			$json .= ",'".esc($row['alias'])."'";
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","company/edit_company","privilege_tb")){
				if($row['active']==1){
					$json .= ",'<a href=\"".site_url('company/active/'.$row['id'].'/'.$row['active'])."\">yes</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('company/active/'.$row['id'].'/'.$row['active'])."\">no</a>'";
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
	
	function add_company(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","company/add_company","privilege_tb")){
			$this->data['page'] = 'company/add_company';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_add_company(){
		$name = $this->input->post('name');
		$alias = $this->input->post('alias');
		$active = $this->input->post('active');
		$this->company_model->do_add_company($name,$alias,$active);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_company($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","company/edit_company","privilege_tb")){
			$this->data['company'] = $this->company_model->show_company_by_id($id);
			$this->data['page'] = 'company/edit_company';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_edit_company($id){
		$name = $this->input->post('name');
		$alias = $this->input->post('alias');
		$active = $this->input->post('active');
		$this->company_model->do_edit_company($id,$name,$alias,$active);
		redirect('company/list_company');
	}
	
	function active($id,$active){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","company/edit_company","privilege_tb")){
			if($active==1){
				$active = 0;	
			}else{
				$active = 1;	
			}
			$this->company_model->active($id,$active);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	
	function delete_company($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","company/delete_company","privilege_tb")){
			$this->company_model->delete_company($id);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	
}?>