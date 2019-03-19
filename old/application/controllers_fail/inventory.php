<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Inventory extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('inventory_model');
		$this->load->model('flexigrid_model');
	}
	
	function index(){
		redirect('home');
	}
	
	function list_inventory(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/list_inventory","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/list_inventory_2","privilege_tb")){
			$this->data['page'] = 'inventory/list_inventory';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function inventory_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'i.department_id,i.name';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*,i.id as i_id,d.name as d_name, i.name as i_name";
		
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/list_inventory","privilege_tb")){
			$where = "";
			if ($query) $where .= " where $qtype LIKE '%$query%' ";
			
		}elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/list_inventory_2","privilege_tb")){
			$where = "where i.employee_id = '".$this->session->userdata('employee_id')."'";
			if ($query) $where .= " and $qtype LIKE '%$query%' ";
		}
		
		$tname="inventory_tb i
				left join department_tb d on i.department_id = d.id
				left join employee_tb e on e.id = i.employee_id";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("i.id"," $tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if($result) foreach($result as $row){
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/delete_inventory","privilege_tb")){
				$delete = " | <a href=\"".site_url('inventory/delete_inventory/'.$row['i_id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/detail_inventory","privilege_tb")){
				$detail = " | <a href=\"".site_url('inventory/detail_inventory/'.$row['i_id'])."\">Detail</a>";
			 }else{
				$detail = ""; 
			 }

			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['i_id']."',";
			$json .= "cell:[";
			
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/edit_inventory","privilege_tb")){
				$json .= "'<a href=\"".site_url('inventory/edit_inventory/'.$row['i_id'])."\">Edit</a>".$delete.$detail."'";
			 }else{
				 $json .= "'".$delete.$detail."'";
			 }
			$update_no = "<a href=\"#\" onclick=\"message_no(".$row['i_id'].");\">No</a>";
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/edit_inventory","privilege_tb")){
				/*$json .= ",'<a href=\"".site_url('inventory/update_last_check_date/'.$row['i_id'])."\" onclick=\"return confirm(\'Inventory OK?\');\">Ok</a> ".$update_no."'";*/
				$json .= ",'<a href=\"#\" onclick=\"message_no(".$row['i_id'].");\">Ok</a> ".$update_no."'";
			}else{
				$json .= ",''";	
			}
			$json .= ",'".esc($row['d_name'])."'";
			$json .= ",'".esc($row['i_name'])."'";
			$json .= ",'".esc($row['code'])."'";
		
			if($row['buy_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['buy_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			if($row['check_date']!=00-00-0000){
				$json .= ",'".date('d/m/Y',strtotime(esc($row['check_date'])))."'";
			}else{
				$json .= ",'-'";	
			}
			$json .= ",'".find('firstname',esc($row['check_by']),'employee_tb')." ".find('lastname',esc($row['check_by']),'employee_tb')."'";
			$json .= ",'".esc($row['description'])."'";
			$json .= ",'".esc($row['floor'])."'";
			$json .= ",'".esc($row['room'])."'";
			
			/*$json .= ",'".find('firstname',esc($row['employee_id']),'employee_tb')." ".find('lastname',esc($row['employee_id']),'employee_tb')."'";*/
			$json .= ",'".esc($row['firstname'])." ".esc($row['lastname'])."'";
			
			$json .= ",'".find('name',esc($row['vendor_id']),'vendor_tb')."'";
			$json .= ",'".esc($row['qty'])."'";
			$json .= ",'".money(esc($row['price']))."'";
			$json .= ",'".money(esc($row['total']))."'";
			
			$json .= ",'".esc($row['notes'])."'";
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
	}
	
	function update_last_check_date($id){
		$check_date = date('Y-m-d');
		$check_by = $this->session->userdata('employee_id');
		$this->inventory_model->udpate_last_check_date($id,$check_date,$check_by);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function update_last_check_date_2(){
		$description = $this->input->post('description');
		$id = $this->input->post('id');
		//$check_date = date('Y-m-d');
		//$check_by = $this->session->userdata('employee_id');
		
		$input_by = $this->session->userdata('employee_id');
		$input_date = date('Y-m-d');
		//$this->inventory_model->udpate_last_check_date_2($id,$check_date,$check_by,$description);
		$this->inventory_model->do_add_inventory_information($id,$description,$input_by,$input_date);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function detail_inventory($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/detail_inventory","privilege_tb")){
			$this->data['inventory_information'] = $this->inventory_model->show_inventory_information_by_id($id);
			$this->data['inventory'] = $this->inventory_model->show_inventory_by_id($id);
			$this->data['page'] = 'inventory/detail_inventory';
			$this->load->view('common/body', $this->data);	
		}else{
			redirect('home');	
		}
	}
	
	function add_inventory(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/add_inventory","privilege_tb")){
			$this->data['department'] = $this->inventory_model->show_department();
			$this->data['employee'] = $this->inventory_model->show_employee();
			$this->data['vendor'] = $this->inventory_model->show_vendor();
			$this->data['page'] = 'inventory/add_inventory';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_add_inventory(){
		$employee_id=$this->input->post('employee_id');
		$vendor_id=$this->input->post('vendor_id');
		$name = $this->input->post('name');
		$code = $this->input->post('code');
		$floor = $this->input->post('floor');
		$room = $this->input->post('room');
		$department_id = $this->input->post('department_id');
		$description = $this->input->post('description');
		$qty = $this->input->post('qty');
		$price  =$this->input->post('price');
		$total = $qty * $price;
		$notes  =$this->input->post('notes');
		$buy_date = $this->input->post('buy_date');
		$check_date = date("Y-m-d");
		$check_by = $this->session->userdata('employee_id');
		
		$this->inventory_model->do_add_inventory($employee_id,$vendor_id,$name,$code,$floor,$room,$department_id,$description,$qty,$price,$total,$notes,$buy_date,$check_date,$check_by);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function edit_inventory($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/edit_inventory","privilege_tb")){
			$this->data['department'] = $this->inventory_model->show_department();
			$this->data['employee'] = $this->inventory_model->show_employee();
			$this->data['vendor'] = $this->inventory_model->show_vendor();
			$this->data['inventory'] = $this->inventory_model->show_inventory_by_id($id);
			$this->data['page'] = 'inventory/edit_inventory';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function do_edit_inventory($id){
		$employee_id=$this->input->post('employee_id');
		$vendor_id=$this->input->post('vendor_id');
		$name = $this->input->post('name');
		$code = $this->input->post('code');
		$floor = $this->input->post('floor');
		$room = $this->input->post('room');
		$department_id = $this->input->post('department_id');
		$description = $this->input->post('description');
		$qty = $this->input->post('qty');
		$price  =$this->input->post('price');
		$total = $qty * $price;
		$notes  =$this->input->post('notes');
		$buy_date = $this->input->post('buy_date');
		$check_date = date("Y-m-d");
		$check_by = $this->session->userdata('employee_id');
		
		$this->inventory_model->do_edit_inventory($id,$employee_id,$vendor_id,$name,$code,$floor,$room,$department_id,$description,$qty,$price,$total,$notes,$buy_date,$check_date,$check_by);
		
		redirect('inventory/detail_inventory/'.$id);
	}
	
	function delete_inventory($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/delete_inventory","privilege_tb")){
			$this->inventory_model->delete_inventory($id);
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	//information
	function do_add_inventory_information($id){
		$description = $this->input->post('description');
		$input_by = $this->session->userdata('employee_id');
		$input_date = date('Y-m-d');
		$this->inventory_model->do_add_inventory_information($id,$description,$input_by,$input_date);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function delete_inventory_information($id){
		$this->inventory_model->delete_inventory_information($id);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function get_inventory_information($id){
		$this->data['inventory_information'] = $this->inventory_model->show_inventory_information_by_id_detail($id);
		$this->load->view('inventory/get_information',$this->data);
	}
	
	function edit_inventory_information($id){
		$description = $this->input->post('description');
		$this->inventory_model->edit_inventory_information($id,$description);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
}?>