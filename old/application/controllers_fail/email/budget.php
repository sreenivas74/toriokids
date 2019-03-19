<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Budget extends Ext_Controller{
	function __construct(){
		parent::__construct();
	
		$this->load->model('budget_model');
		$this->load->model('admin_model');
		$this->load->model('flexigrid_model');
	
	}
	
	function index(){
		redirect('home');
	}
	function send_email($budget_id){
		
	
			$this->data['budget_id']=$budget_id;
			$this->data['email']='frans@isysedge.com';
			$isi=$this->load->view('budget/email/sent_to',$this->data,TRUE);
		
			$this->load->library('email'); 	
			$this->email->from('GSI Indonesia');
			$this->email->to($email); 
			$this->email->subject('budget-email');
			$this->email->message($isi); 
			$this->email->send();
			
			$this->email->clear();	
	}
	
	
	function detail($id,$base_64_decode){
		$email=base64_decode($base_64_decode);
		//automatic login//
		$login = $this->admin_model->login_by_email($email);
				if ($login != NULL) {
					$sess_admin = array (
										   'admin_logged_in' => true,
										   'admin_id' => $login['id'],
										   'employee_id' => $login['employee_id'],
										   'admin_fullname' => $login['name'],
										   'admin_username' => $login['username'],
										   'admin_last_login' => $login['last_login'],
										   'admin_created_date' => $login['created_date'],
										   'admin_privilege' => $login['privilege_id']
										);
					$this->session->set_userdata($sess_admin);
				
				}else{
				redirect($_SERVER['HTTP_REFERER']);
				
				}
	/////
		
		
		
		$this->data['request_detail'] = $request_detail = $this->budget_model->get_request_detail($id);
		$this->data['request_item'] = $this->budget_model->get_request_item_detail($id);
		$this->data['vendor_list'] = $this->budget_model->get_vendor_list();
		$this->data['request_log'] = $this->budget_model->get_request_log($id);
		
		$this->data['bank_list'] = $this->budget_model->get_bank_list();
		$this->data['payment_list'] = $this->budget_model->get_payment_list($id);
		
		//project goal
		$goal = 0;$request_budget='';$this->data['po_client_item']='';
		if($request_detail['project_id']!=0){
			$goal = find('sales_stage',$request_detail['project_id'],'project_tb');
			$this->data['budget_log_2'] = $budget_log_2 = $this->budget_model->get_request_budget_distinct_2($id);
			$data='';
			if($budget_log_2)foreach($budget_log_2 as $list){
				if($data)$data.=",".$list['project_goal_po_client_item_id'];
				else $data.=$list['project_goal_po_client_item_id'];
			}
			if($data){
				$this->data['budget_log_list_2'] = $this->budget_model->get_budget_log_list_2($data);
			}else{
				$this->data['budget_log_list_2'] = '';	
			}
			
			//po stock n nonstock
			$this->load->model('project_model');
			$project_id = $request_detail['project_id'];
			$this->data['po_client'] = $po_client = $this->project_model->get_project_po_client($request_detail['project_id']);
			$this->data['po_client_item'] = $this->project_model->get_project_po_client_item($po_client['id']);
			
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
			$this->data['request_budget'] = $request_budget = $this->project_model->get_project_request_budget_outstanding($project_id);
			
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
			
		}else{
			$this->data['budget_log_2'] = '';	
			$this->data['budget_log_list_2'] = '';	
		}
		
		//budget
		$this->data['budget_log'] = $budget_log = $this->budget_model->get_request_budget_distinct($id);
		$data='';
		if($budget_log)foreach($budget_log as $list){
			if($data)$data.=",".$list['budget_id'];
			else $data.=$list['budget_id'];
		}
		if($data){
			$this->data['budget_log_list'] = $this->budget_model->get_budget_log_list($data);
		}else{
			$this->data['budget_log_list'] = '';	
		}
		
		
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
		
		
		
		
		
		
		
		$this->data['page'] = 'budget/email/detail';
		$this->load->view('common/body', $this->data);
	}
	
	function approve_request_budget(){
		
		$type=$this->input->post('type');
		$id=$this->input->post('request_id');
		$comment=$this->input->post('name_comment');
		
		$approve_by = $this->session->userdata('employee_id');
		$approve_date = date('Y-m-d H:i:s');
		if($type==1){
			$approval = "approval";
			$approval_by = "approval_by";
			$approval_date	= "approval_date";
			$approval_comment="approval_comment";
		}elseif($type==2){
			$approval = "approval_2";
			$approval_by = "approval_2_by";
			$approval_date	= "approval_2_date";
			$approval_comment="approval_2_comment";
		}elseif($type==3){
			$approval = "approval_3";
			$approval_by = "approval_3_by";
			$approval_date	= "approval_3_date";
			$approval_comment="approval_3_comment";
		}elseif($type==4){
			$approval = "approval_4";
			$approval_by = "approval_4_by";
			$approval_date	= "approval_4_date";
			$approval_comment="approval_4_comment";	
	
			
			//$request_item = $this->budget_model->get_request_item_detail($id);
//			$status_item=1;//approved
//			if($request_item)foreach($request_item as $list){
//				$this->budget_model->update_budget_log_status($list['id'],$status_item);
//			}
			
			$status_item=1;
			$this->update_budget_log_status($id,$status_item);
		}elseif($type==5){
			$approval = "not_approval";
			$approval_by = "not_approval_by";
			$approval_date	= "not_approval_date";
			$approval_comment="not_approval_comment";	
		
		}
		
		$this->budget_model->new_approve_request_budget($id,$approve_by,$approve_date,$approval,$approval_by,$approval_date,$approval_comment,$comment);
		
		////cek reimbuse
//		$reimburse = find('reimburse',$id,'request_budget_tb');
//		if($reimburse!=1 && $type==4){
//			//insert to log
//			$request_item = $this->budget_model->get_request_item_detail($id);
//			if($request_item)foreach($request_item as $list){
//				$this->budget_model->insert_budget_log($list['id'],$list['budget_id'],$list['total'],$approve_by,$approve_date);
//			}
//		}
// pindah ke doadd request budget

		

		echo json_encode(array('success'=>1),TRUE);
		
	//	redirect($_SERVER['HTTP_REFERER']);	
	}
	


}