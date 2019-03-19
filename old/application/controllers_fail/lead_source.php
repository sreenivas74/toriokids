<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Lead_source extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('flexigrid_model');
		$this->load->model('lead_source_model');
	}
	
	function index(){
		redirect('home');
	}
	
	function list_lead_source(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lead_source/list_lead_source","privilege_tb")){
			$this->data['page'] = 'lead_source/list_lead_source';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function lead_source_flexi(){
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
		$tname="lead_source_tb";
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
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lead_source/delete_lead_source","privilege_tb")){
				$delete = " | <a href=\"".site_url('inventory/delete_lead_source/'.$row['id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lead_source/edit_lead_source","privilege_tb")){
				$json .= "'<a href=\"".site_url('lead_source/edit_lead_source/'.$row['id'])."\">Edit</a>'";
			 }else{
				 $json .= "'".$delete."'";
			 }
			
			$json .= ",'".esc($row['name'])."'";
			
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lead_source/edit_lead_source","privilege_tb")){
				if($row['active']==1){
					$json .= ",'<a href=\"".site_url('lead_source/active/'.$row['id'].'/'.$row['active'])."\">yes</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('lead_source/active/'.$row['id'].'/'.$row['active'])."\">no</a>'";
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
	
	function add_lead_source(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lead_source/add_lead_source","privilege_tb")){
			$this->data['page'] = 'lead_source/add_lead_source';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_add_lead_source(){
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		$this->lead_source_model->do_add_lead_source($name,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_lead_source($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lead_source/edit_lead_source","privilege_tb")){
			$this->data['lead_source'] = $this->lead_source_model->show_lead_source_by_id($id);
			$this->data['page'] = 'lead_source/edit_lead_source';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_edit_lead_source($id){
		$name = $this->input->post('name');
		$active = $this->input->post('active');
		$this->lead_source_model->do_edit_lead_source($id,$name,$active);
		redirect('lead_source/list_lead_source');
	}
	
	function delete_lead_source($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lead_source/edit_lead_source","privilege_tb")){
			$this->lead_source_model->delete_lead_source($id);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
	
	function active($id,$active){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lead_source/edit_lead_source","privilege_tb")){
			if($active==1){
				$active = 0;	
			}else{
				$active = 1;	
			}
			$this->lead_source_model->active($id,$active);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('home');	
		}
	}
}?>