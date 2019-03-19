<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Page_notif extends Ext_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('project_model');
		$this->load->model('purchase_order_model');
	}
	
	function index(){
		redirect('home');	
	}
	
	function approve_quotation($quotation_id,$status,$leader_id,$leader_password,$quotation_date_updated){
		if(!$quotation_id || !$status || !$leader_id || !$leader_password || !$quotation_date_updated)redirect('home');
		//cek leader
		$leader_cek = find_4_string('id','employee_id',$leader_id,'password',$leader_password,'administrator_tb');
		if(!$leader_cek)redirect('home');
		$this->data['quotation_detail'] = $quotation_detail = $this->project_model->get_quotation_detail($quotation_id);
		$this->data['quotation_number'] = $quotation_detail['quotation_number'];
		
		if($quotation_detail['updated_date'])$last_update_date = md5($quotation_detail['updated_date']);
		else $last_update_date = md5($quotation_detail['created_date']);
		
		if($quotation_date_updated!=$last_update_date){
			$this->data['status'] = "Quotation link has been expired or invalid.";
		}elseif($status == 2 && $quotation_detail['approval_level'] >= 2){
			$this->data['status'] = "Quotation link has been expired or invalid.";
		}elseif($status == 3 && $quotation_detail['approval_level'] >= 3){
			$this->data['status'] = "Quotation link has been expired or invalid.";
		}else{
			$this->project_model->change_quotation_status_to_approval($quotation_id,$status);
			
			if($status==3){
				//set win lose date
				$this->project_model->set_project_win_date($quotation_detail['project_id'],date('Y-m-d'));
				//project win
				$this->project_model->insert_to_project_goal($quotation_detail['project_id']);	
			}
			
			if($status==1)$this->data['status'] = "REJECTED (need revision).";
			else $this->data['status'] = "APPROVED.";
			
			//insert approval log
			$data = array(
				'leader_id'=>$leader_id,
				'status'=>$status,
				'approval_date'=>date('Y-m-d H:i')
			);
			$approval_1_data = json_encode($data);
			if($status==2){
				$this->project_model->insert_approval_1_data($quotation_id,$approval_1_data);
			}else{
				$this->project_model->insert_approval_2_data($quotation_id,$approval_1_data);
			}
			
			/*if($status==2){
				//send email to sales manager
				$email_content = '';			
				$this->data['quotation_item'] = $quotation_item_detail = $this->project_model->get_quotation_item_detail($quotation_id);
				
				$from = find('email',$quotation_detail['created_by'],'employee_tb');
				$subject = "Quotation - ".$quotation_detail['quotation_number'];
				$this->data['approval_level'] = 3;
				//find sales manager employee id (privilege = 20)
				$sales_manager = $this->project_model->get_sales_manager();
				if($sales_manager)foreach($sales_manager as $list){
					$this->data['leader_id'] = $list['employee_id'];
					$this->data['leader_password'] = $list['password'];
					$to_email = $list['email'];
					$email_content = $this->load->view('project/send_email_quotation',$this->data,TRUE);
					$this->load->library('email'); 
					$this->email->from($from);
					$this->email->to($to_email);
						
					$this->email->subject($subject);
					$this->email->message($email_content);  
					$this->email->send();	
				}
			}*/
		}
		
		$this->data['quotation_id'] = $quotation_id;
		$this->data['page'] = 'project/approval_page';
		$this->load->view('common/body', $this->data);
	}
	
	function reject_reason($quotation_id){
		if(!$quotation_id)redirect('home');
		
		$reason = $this->input->post('reason');
		$this->project_model->insert_reason($quotation_id,$reason);
		
		$_SESSION['notif'] = "Reject Sent.";
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function approve_po($po_id,$status,$leader_id,$leader_password,$po_date){
		if(!$po_id || !$status || !$leader_id || !$leader_password || !$po_date)redirect($_SERVER['HTTP_REFERER']);
		
		$leader_cek = find_4_string('id','employee_id',$leader_id,'password',$leader_password,'administrator_tb');
		if(!$leader_cek)redirect('home');
		
		$this->data['po_detail'] = $po_detail = $this->purchase_order_model->show_po_detail($po_id);
		$this->data['po_number'] = $po_detail['po_number'];
		
		if($po_detail['updated_date'])$last_update_date = md5($po_detail['updated_date']);
		else $last_update_date = md5($po_detail['created_date']);
		
		if($po_date!=$last_update_date){
			$this->data['status'] = "Purchase Order approval link has been expired or invalid.";
		}elseif($po_detail['approval'] > 0){
			$this->data['status'] = "Purchase Order approval link has been expired or invalid.";
		}else{
			if($status==2)$this->data['status'] = "REJECTED (need revision).";
			else $this->data['status'] = "APPROVED.";
			
			$this->purchase_order_model->change_po_status($po_id,$status,$leader_id,date('Y-m-d H:i:s'));
			
			$this->data['page'] = 'purchase_order/approval_page';
			$this->load->view('common/body', $this->data);
		}
	}
}