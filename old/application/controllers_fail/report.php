<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Report extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('flexigrid_model');
		$this->load->model('report_model');
		$this->load->model('project_model');
		$this->load->model('general_model');
	}
	
	function index(){
		redirect('home');
	}
	
	/////////////////////
	//project goal//////
	////////////////////
	function list_project_goal_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_project_goal_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_project_goal_report_2","privilege_tb")){
			$this->data['page'] = 'report/list_project_goal_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function list_project_goal_report_selected(){
			$this->load->model('employee_model');
		$this->data['check_employee_id']=0;
		
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_project_goal_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_project_goal_report_2","privilege_tb")){
			
		
			$this->data['start_date']=$start_date=$this->input->post('date_1');
			
			$this->data['end_date']=$end_date=$this->input->post('date_2');
	$this->data['employee']=NULL;
			$this->data['grand_total_idr']=0;
			$this->data['grand_total_usd']=0;
			$this->data['grand_total_fee']=0;
			
			$employee_id=$this->session->userdata('employee_id');
			if($employee_id=='0' or $employee_id==6 or $employee_id==3 or $employee_id==4){
				$this->data['employee']=$employee=$this->report_model->show_employee_active();
			;			
						if($employee)foreach($employee as $employee_list){
						$this->data['grand_total_employee_idr_'.$employee_list['id']]= ${'grand_total_employee_idr_'.$employee_list['id']}=0;
						$this->data['grand_total_employee_usd_'.$employee_list['id']]= ${'grand_total_employee_usd_'.$employee_list['id']}=0;
						$this->data['grand_total_employee_fee_'.$employee_list['id']]= ${'grand_total_employee_usd_'.$employee_list['id']}=0;
						}
						
				
				$this->data['project'] = $this->report_model->show_project_goal_all_range2($start_date,$end_date);
			;
				$this->data['page'] = 'report/list_project_goal_select';

			}else{
			
				$check_leader=$this->report_model->check_leader($employee_id);
				
					if(!$check_leader){//jika bukan leader
						
					$this->data['employee']=$employee=$this->employee_model->show_employee_by_id_multi_row($employee_id);
			;			
						if($employee)foreach($employee as $employee_list){
						$this->data['grand_total_employee_idr_'.$employee_list['id']]= ${'grand_total_employee_idr_'.$employee_list['id']}=0;
						$this->data['grand_total_employee_usd_'.$employee_list['id']]= ${'grand_total_employee_usd_'.$employee_list['id']}=0;
						$this->data['grand_total_employee_fee_'.$employee_list['id']]= ${'grand_total_employee_usd_'.$employee_list['id']}=0;
						}
						
				
				$this->data['project'] = $this->report_model->show_project_goal_all_range2($start_date,$end_date);
			;
			
						
						$this->data['project'] = $this->report_model->show_project_goal_all_range2($start_date,$end_date,$employee_id);
					}else{//jika leader
						$employee_bawahan[]=$employee_id;
		
						
						if($check_leader)foreach($check_leader as $leader){
							$employee_bawahan[]=$leader['employee_id'];
						}
						$this->data['employee']=$employee=$this->report_model->select_employee($employee_bawahan);
			;			
						if($employee)foreach($employee as $employee_list){
						$this->data['grand_total_employee_idr_'.$employee_list['id']]= ${'grand_total_employee_idr_'.$employee_list['id']}=0;
						$this->data['grand_total_employee_usd_'.$employee_list['id']]= ${'grand_total_employee_usd_'.$employee_list['id']}=0;
						$this->data['grand_total_employee_fee_'.$employee_list['id']]= ${'grand_total_employee_usd_'.$employee_list['id']}=0;
						}



						$this->data['project'] =$data=$this->report_model->show_project_goal_all_range4($start_date,$end_date,$employee_bawahan);
						
						
					}
					
			$this->load->model('employee_model');
			$this->data['page'] = 'report/list_project_goal_select';
			
			}

			
		
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
	}
	///////////////
	//outstanding//
	//
	function list_outstanding_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_outstanding_report","privilege_tb")){
			$this->data['page'] = 'report/list_outstanding_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function list_outstanding_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_outstanding_report","privilege_tb")){
			$quarter = $this->input->post('quarter');
			$year = $this->input->post('year');
			
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['project'] = $this->report_model->show_outstanding_report($quarter,$year);
			
			$this->data['quarter'] = $quarter;
			$this->data['year_selected'] = $year;
			
			$this->data['page'] = 'report/list_outstanding_report_selected';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
	}
	//////////////////////
	//CRM//////
	////////////////////
	function list_crm_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_crm_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_crm_report_2","privilege_tb")){
			$this->data['page'] = 'report/list_crm_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function list_crm_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_crm_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_crm_report_2","privilege_tb")){
			$quarter = $this->input->post('quarter');
			$year = $this->input->post('year');
			$based = $this->input->post('based');
			
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['project'] = $this->report_model->show_crm();
			
			$this->data['quarter'] = $quarter;
			$this->data['year_selected'] = $year;
			$this->data['based'] = $based;
			
			$this->load->model('employee_model');
			$this->data['emp_group']=$this->employee_model->get_employee_group_by_leader($this->session->userdata('employee_id'));
			
			$this->data['page'] = 'report/list_crm_report_selected';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
	}
	
	function send_crm(){
		$quarter = $this->input->post('quarter');
		$year = $this->input->post('year');
		$based = $this->input->post('based');
		
		$this->data['employee'] = $this->report_model->show_employee_active();
		$this->data['project'] = $this->report_model->show_crm();
		$employee = $this->report_model->show_employee_active();
		$project = $this->report_model->show_crm();
		
		$this->data['quarter'] = $quarter;
		$this->data['year_selected'] = $year;
		$this->data['based'] = $based;
		
			$this->load->model('employee_model');
			$this->data['emp_group']=$this->employee_model->get_employee_group_by_leader($this->session->userdata('employee_id'));
			
		if($quarter==1){
			$xxx = ($year-1)."-12-15";
			$yyy = $year."-03-16";
		}elseif($quarter==2){
			$xxx = $year."-03-15";
			$yyy = $year."-06-16";
		}elseif($quarter==3){
			$xxx = $year."-06-15";
			$yyy = $year."-09-16";
		}elseif($quarter==4){
			$xxx = $year."-09-15";
			$yyy = $year."-12-16";
		}
		
		//send email
		$to_email = 'david@isysedge.com';
		
		$email_content = 
		"
		<table class='form' style='width:100%;'>
        <thead>
            <tr>
                <th width='5%'>Marketing</th>
                <th width='10%'>Sales Stage</th>
                <th width='50%'>Project</th>
                <th width='10%'>Amount (IDR)</th>
                <th width=''>Notes</th>
            </tr>
        </thead>";
        $x=0;$y=0;$z=0;$a=0;$b=0; $total_stage = 0;
        if($employee)foreach($employee as $list){
        	
            	if(find_4_string('id','privilege_user_id',$this->session->userdata('admin_privilege'),'module','report/list_crm_report','privilege_tb')){
					$karyawan = $list['id'];
				}elseif(find_4_string('id','privilege_user_id',$this->session->userdata('admin_privilege'),'module','report/list_crm_report_2','privilege_tb')){
					$karyawan = $this->session->userdata('employee_id');
				}
                
                $z=0;if($project)foreach($project as $row){
                    if($row['employee_id']==$karyawan){
                        $z++;
                    }
                }
                
                
        
		if(find_4_string('id','privilege_user_id',$this->session->userdata('admin_privilege'),'module','report/list_crm_report_2','privilege_tb')){
		if($z!=0 && $list['id']==$karyawan){
            $email_content.="<tr>
                <td colspan='5' valign='top'><b>".$list['firstname'].' '.$list['lastname']."</b></td>
            </tr>
            <tr>
                <td></td>
                <td colspan='4'><b>Potential</b></td>
            </tr>";
            $x=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==1){
                        $email_content.="
						<tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":"; 
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
                            $email_content.="
                            </td>
                        </tr>";
            $x++;$total_stage =$total_stage + $row['amount'];} }
            if($x!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$x."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td></td>
                <td colspan='4'><b>Quotation</b></td>
            </tr>";
            $y=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==2){
						$email_content.="
                        <tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":"; 
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
							$email_content.="
                            </td>
                        </tr>";
            $y++;$total_stage = $total_stage + $row['amount'];} }
            if($y!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$y."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td></td>
                <td colspan='4'><b>Review / Tender</b></td>
            </tr>";
            $z=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==3){
						$email_content.="
                        <tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":"; 
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
                            $email_content.="
                            </td>
                        </tr>";
            $z++;$total_stage = $total_stage + $row['amount'];} }
            if($z!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$z."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td></td>
                <td colspan='4'><b>Win</b></td>
            </tr>";
            $a=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==4 && strtotime($row['close_date'])>strtotime($xxx) && strtotime($row['close_date'])<strtotime($yyy)){
						$email_content.="
                        <tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":"; 
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
                            $email_content.="
                            </td>
                        </tr>";
            $a++;$total_stage = $total_stage + $row['amount'];} }
            if($a!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$a."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td></td>
                <td colspan='4'><b>Lost</b></td>
            </tr>";
            $b=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==5 && strtotime($row['close_date'])>strtotime($xxx) && strtotime($row['close_date'])<strtotime($yyy)){
						$email_content.="
                        <tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":";
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
                            $email_content.="
                            </td>
                        </tr>";
            $b++;$total_stage = $total_stage + $row['amount'];} }
            if($b!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$b."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td colspan='5' bgcolor='#333333'></td>
            </tr>";
        	}
		}elseif(find_4_string('id','privilege_user_id',$this->session->userdata('admin_privilege'),'module','report/list_crm_report','privilege_tb')){
			if($z!=0){
            $email_content.="
        		<tr>
                <td colspan='5' valign='top'><b>".$list['firstname']." ".$list['lastname']."</b></td>
            </tr>
            <tr>
                <td></td>
                <td colspan='4'><b>Potential</b></td>
            </tr>";
            $x=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==1){
						$email_content.="
                        <tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":"; 
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
                            $email_content.="
                            </td>
                        </tr>";
            $x++;$total_stage =$total_stage + $row['amount'];} }
            if($x!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$x."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td></td>
                <td colspan='4'><b>Quotation</b></td>
            </tr>";
            $y=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==2){
						$email_content.="
                        <tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":";
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
                            $email_content.="
                            </td>
                        </tr>";
            $y++;$total_stage = $total_stage + $row['amount'];} }
            if($y!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$y."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td></td>
                <td colspan='4'><b>Review / Tender</b></td>
            </tr>";
            $z=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==3){
						$email_content.="
                        <tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":"; 
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
                            $email_content.="
                            </td>
                        </tr>";
            $z++;$total_stage = $total_stage + $row['amount'];} }
            if($z!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$z."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td></td>
                <td colspan='4'><b>Win</b></td>
            </tr>";
            $a=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==4 && strtotime($row['close_date'])>strtotime($xxx) && strtotime($row['close_date'])<strtotime($yyy)){
						$email_content.="
                        <tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":"; 
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
                            $email_content.="
                            </td>
                        </tr>";
            $a++;$total_stage = $total_stage + $row['amount'];} }
            if($a!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$a."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td></td>
                <td colspan='4'><b>Lost</b></td>
            </tr>";
            $b=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==5 && strtotime($row['close_date'])>strtotime($xxx) && strtotime($row['close_date'])<strtotime($yyy)){
						$email_content.="
                        <tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":"; 
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
                            $email_content.="
                            </td>
                        </tr>";
            $b++;$total_stage = $total_stage + $row['amount'];} }
            if($b!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$b."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td colspan='5' bgcolor='#333333'></td>
            </tr>";
        	 } 
			}
		}
		$email_content.="
    </table>";
		
		//echo $email_content;exit;
		
		$subject = "CRM REPORT";
		$this->load->library('email'); 
		$this->email->from("crm@gsindonesia.com");
		$this->email->to('robert@gsindonesia.com;agus@gsindonesia.com;indra@gsindonesia.com');
			
		$this->email->subject($subject);
		$this->email->message($email_content);
		$this->email->send();
		//send email
		
		$this->data['page'] = 'report/list_crm_report_selected';
		$this->load->view('common/body', $this->data);
	}
	
	function send_crm_2($employee_id){
		$quarter = $this->input->post('quarter');
		$year = $this->input->post('year');
		$based = $this->input->post('based');
		
		$this->data['employee'] = $this->report_model->show_employee_active();
		$this->data['project'] = $this->report_model->show_crm();
		$employee = $this->report_model->show_employee_active();
		$project = $this->report_model->show_crm();
		
		$this->data['quarter'] = $quarter;
		$this->data['year_selected'] = $year;
		$this->data['based'] = $based;
		
		if($quarter==1){
			$xxx = ($year-1)."-12-15";
			$yyy = $year."-03-16";
		}elseif($quarter==2){
			$xxx = $year."-03-15";
			$yyy = $year."-06-16";
		}elseif($quarter==3){
			$xxx = $year."-06-15";
			$yyy = $year."-09-16";
		}elseif($quarter==4){
			$xxx = $year."-09-15";
			$yyy = $year."-12-16";
		}
		
		//send email
		//$to_email = 'david@isysedge.com';
		
		$email_content = 
		"
		<table class='form' style='width:100%;'>
        <thead>
            <tr>
                <th width='5%'>Marketing</th>
                <th width='10%'>Sales Stage</th>
                <th width='50%'>Project</th>
                <th width='10%'>Amount (IDR)</th>
                <th width=''>Notes</th>
            </tr>
        </thead>";
        $x=0;$y=0;$z=0;$a=0;$b=0; $total_stage = 0;
        if($employee)foreach($employee as $list){
        	
            	/*if(find_4_string('id','privilege_user_id',$this->session->userdata('admin_privilege'),'module','report/list_crm_report','privilege_tb')){
					$karyawan = $list['id'];
				}elseif(find_4_string('id','privilege_user_id',$this->session->userdata('admin_privilege'),'module','report/list_crm_report_2','privilege_tb')){
					$karyawan = $this->session->userdata('employee_id');
				}*/
				
				$karyawan = $employee_id;
                
                $z=0;if($project)foreach($project as $row){
                    if($row['employee_id']==$karyawan){
                        $z++;
                    }
                }
                
                
        
		//if(find_4_string('id','privilege_user_id',$this->session->userdata('admin_privilege'),'module','report/list_crm_report_2','privilege_tb')){
		if($z!=0 && $list['id']==$karyawan){
            $email_content.="<tr>
                <td colspan='5' valign='top'><b>".$list['firstname'].' '.$list['lastname']."</b></td>
            </tr>
            <tr>
                <td></td>
                <td colspan='4'><b>Potential</b></td>
            </tr>";
            $x=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==1){
                        $email_content.="
						<tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":"; 
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
                            $email_content.="
                            </td>
                        </tr>";
            $x++;$total_stage =$total_stage + $row['amount'];} }
            if($x!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$x."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td></td>
                <td colspan='4'><b>Quotation</b></td>
            </tr>";
            $y=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==2){
						$email_content.="
                        <tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":"; 
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
							$email_content.="
                            </td>
                        </tr>";
            $y++;$total_stage = $total_stage + $row['amount'];} }
            if($y!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$y."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td></td>
                <td colspan='4'><b>Review / Tender</b></td>
            </tr>";
            $z=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==3){
						$email_content.="
                        <tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":"; 
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
                            $email_content.="
                            </td>
                        </tr>";
            $z++;$total_stage = $total_stage + $row['amount'];} }
            if($z!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$z."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td></td>
                <td colspan='4'><b>Win</b></td>
            </tr>";
            $a=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==4 && strtotime($row['close_date'])>strtotime($xxx) && strtotime($row['close_date'])<strtotime($yyy)){
						$email_content.="
                        <tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":"; 
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
                            $email_content.="
                            </td>
                        </tr>";
            $a++;$total_stage = $total_stage + $row['amount'];} }
            if($a!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$a."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td></td>
                <td colspan='4'><b>Lost</b></td>
            </tr>";
            $b=0;$total_stage = 0;
				if($project)foreach($project as $row){
                    if($row['employee_id']==$list['id'] && $row['sales_stage']==5 && strtotime($row['close_date'])>strtotime($xxx) && strtotime($row['close_date'])<strtotime($yyy)){
						$email_content.="
                        <tr>
                            <td></td>
                            <td></td>
                            <td valign='top'>".$row['name']."</td>
                            <td valign='top' align='right'>".currency($row['amount'])."</td>
                            <td valign='top'>";
                            if(find_2('id','project_id',$row['id'],'project_info_tb')){
                            	$email_content.= date('d/m/Y',strtotime(find_2_order('input_date','project_id',$row['id'],'project_info_tb','desc'))).":";
								$email_content.= find_2_order('description','project_id',$row['id'],'project_info_tb','desc');
                            }
                            $email_content.="
                            </td>
                        </tr>";
            $b++;$total_stage = $total_stage + $row['amount'];} }
            if($b!=0){
				$email_content.="
                <tr>
                    <td colspan='2'></td>
                    <td align='right'><b>Total : ".$b."</b></td>
                    <td align='right'><b>".currency($total_stage)."</b></td>
                </tr>";
            }
			$email_content.="
            <tr>
                <td colspan='5' bgcolor='#333333'></td>
            </tr>";
        	}
		//}
		}
		$email_content.="
    </table>";
		
		//echo $email_content;exit;
		
		$subject = "CRM REPORT";
		$this->load->library('email'); 
		$this->email->from("crm@gsindonesia.com");
		$this->email->to('robert@gsindonesia.com;agus@gsindonesia.com;indra@gsindonesia.com');
			
		$this->email->subject($subject);
		$this->email->message($email_content);
		$this->email->send();
		//send email
		
		$this->data['page'] = 'report/list_crm_report_selected';
		$this->load->view('common/body', $this->data);
	}
	
	///payment report
	function list_payment_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_payment_report","privilege_tb")){
			$this->data['page'] = 'report/list_payment_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function list_payment_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_payment_report","privilege_tb")){
			$quarter = $this->input->post('quarter');
			$year = $this->input->post('year');
			
			$this->data['payment'] = $this->report_model->show_payment($quarter,$year);
			$this->data['invoice'] = $this->report_model->show_total_invoice($quarter,$year);
			$this->data['outstanding'] = $this->report_model->show_outstanding($quarter,$year);
			
			$this->data['quarter'] = $quarter;
			$this->data['year_selected'] = $year;
			
			$this->data['page'] = 'report/list_payment_report_selected';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
	}
	////////
	
	///survey report
	function list_survey_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_survey_report","privilege_tb")){
			$this->data['page'] = 'report/list_survey_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function list_survey_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_survey_report","privilege_tb")){
			$quarter = $this->input->post('quarter');
			$year = $this->input->post('year');
			
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['project'] = $this->report_model->show_project_goal_survey($quarter,$year);
			
			$this->data['quarter'] = $quarter;
			$this->data['year_selected'] = $year;
			
			$this->data['page'] = 'report/list_survey_report_selected';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
	}
	////////
	///bonus report
	function list_bonus_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_bonus_report","privilege_tb")){
			$this->data['page'] = 'report/list_bonus_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	
	function list_bonus_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_bonus_report","privilege_tb")){
			$quarter = $this->input->post('quarter');
			$year = $this->input->post('year');
			
			$this->data['project_goal'] = $this->report_model->show_project();
			$this->data['project'] = $this->report_model->show_project_goal_bonus($quarter,$year);
			
			$this->data['quarter'] = $quarter;
			$this->data['year_selected'] = $year;
			
			$this->data['page'] = 'report/list_bonus_report_selected';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
	}
	////////
	//employee
	function list_employee_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_report","privilege_tb")){
			$this->data['department'] = $this->report_model->show_department();
			$this->data['employee'] = $this->report_model->show_employee();
			$this->data['page'] = 'report/list_employee_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}
	}
	//
	//////report 35//
	function report_project(){
		 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/project_report","privilege_tb")){
			$this->data['employee'] = $this->report_model->show_employee_active();
		
			$start_date=NULL;
			$end_date=NULL;
			$type_filter=1;
			$status=$this->input->post('status');
			if($status==1){
				$type_filter=$this->input->post('filter_radio');
				$start_date=$this->input->post('date_1');
				$end_date=$this->input->post('date_2');
				$this->data['project_goal_list']=$this->report_model->show_project_goal_report($type_filter,$start_date,$end_date);
				
					
			}else{
				$this->data['project_goal_list']=NULL;
			}
		
			$this->data['type_filter']=$type_filter;
			
			$this->data['start_date']=$start_date;
			$this->data['end_date']=$end_date;
			$this->data['page'] = 'report/list_project';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}	
	}
	
	
	
	
	
	//employee daily report
	function list_employee_daily_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_daily_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_daily_report_2","privilege_tb")){
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['page'] = 'report/list_employee_daily_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}	
	}
	
	
	
	function list_employee_daily_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_daily_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_daily_report_2","privilege_tb")){
			
			$date_1 = $this->input->post('date_1');
			$date_2 = $this->input->post('date_2');
			$employee_selected = $this->input->post('employee_id');
			$z=1;
			$employee_list='';
			if($employee_selected)foreach($employee_selected as $list){
				if($z!=1){	
					$employee_list = $employee_list."|".$list;
				}elseif($z==1){
					$employee_list = $list;
				}
				$z++;
			}
			$this->data['employee_list'] = $employee_list;
			
			$this->data['department'] = $this->report_model->show_department();
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['employee_daily'] = $this->report_model->show_employee_daily($date_1,$date_2);
			$this->data['page'] = 'report/list_employee_daily_report_selected';
			
			$this->data['date_1'] = $date_1;
			$this->data['date_2'] = $date_2;
			
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}	
	}
	
	//employee schedule vs daily
	function list_employee_schedule_daily_report(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_schedule_daily_report","privilege_tb")){
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['page'] = 'report/list_schedule_and_activity_report';
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}	
	}
	
	function list_employee_schedule_daily_report_selected(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_schedule_daily_report","privilege_tb")){
			
			$date_1 = $this->input->post('date_1');
			$date_2 = $this->input->post('date_2');
			$employee_selected = $this->input->post('employee_id');
			$z=1;
			if($employee_selected)foreach($employee_selected as $list){
				if($z!=1){	
					$employee_list = $employee_list."|".$list;
				}elseif($z==1){
					$employee_list = $list;
				}
				$z++;
			}
			$this->data['employee_list'] = $employee_list;
			$this->data['employee'] = $this->report_model->show_employee_active();
			$this->data['employee_activity_list'] = $this->report_model->show_employee_activity_list($date_1,$date_2);
			$this->data['page'] = 'report/list_schedule_and_activity_report_selected';
			
			$this->data['date_1'] = $date_1;
			$this->data['date_2'] = $date_2;
			
			$this->load->view('common/body', $this->data);
		}else{
			redirect('home');	
		}	
	}
	
	function report_bs_list(){
		
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_report_bs","privilege_tb")){
		$this->load->model('budget_model');
		$this->data['department'] = $this->report_model->show_department();
		$this->data['employee'] = $this->report_model->show_employee_active();
		$this->data['page'] = 'report/list_report_bs';
		$this->load->view('common/body', $this->data);
			}else{
			redirect('home');
			}
	}
	
	
	function report_reimburse_to_client(){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_report_reimburse","privilege_tb")){
		$this->data['request_reimburse']=$this->report_model->get_request_budget_reimburse();
		$this->data['page'] = 'report/list_report_reimburse';
		$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		
		}
	}
	
	function report_all_outstanding(){
	 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_report_outstanding_project","privilege_tb")){
		$this->data['outstand_list']=$data=$this->report_model->get_all_project_goal_outstanding_tb();
		$this->data['newdate']=$newdate=date("Y-m-d");
		$this->data['page'] = 'report/outstanding_report';
		$this->load->view('common/body', $this->data);
	 }else{
		 redirect('home');
	 }
		
	}
	
	function report_project_list(){
		
		 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/report_project_list","privilege_tb")){
					$start_date=NULL;
					$end_date=NULL;
					$type_filter=1;
					
					if($_POST){
						$type_filter=$this->input->post('filter_radio');
						$start_date=$this->input->post('date_1');
						$end_date=$this->input->post('date_2');
						$this->data['project_list']=$this->report_model->get_all_project_goal_outstanding_filter($type_filter,$start_date,$end_date);
					}else{
						$this->data['project_list']=NULL;
					}
					$this->data['start_date']=$start_date;
					$this->data['end_date']=$end_date;
					$this->data['type_filter']=$type_filter;
					$this->data['page'] = 'report/report_project_list';
					$this->load->view('common/body', $this->data);
		}else{
			redirect('home');
		}
	
	}
	
	function detail_project_report(){
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/detail_project_report","privilege_tb")){
				 $start_date=NULL;
					$end_date=NULL;
					$type_filter=1;
				 if($_POST){
						$type_filter=$this->input->post('filter_radio');
						$start_date=$this->input->post('date_1');
						$end_date=$this->input->post('date_2');
						$this->data['project_list']=$this->report_model->get_all_project_detail_filter($type_filter,$start_date,$end_date);
					}else{
						$this->data['project_list']=NULL;
					}
					$this->data['start_date']=$start_date;
					$this->data['end_date']=$end_date;
					$this->data['type_filter']=$type_filter;
					$this->data['page'] = 'report/detail_project_report';
					$this->load->view('common/body', $this->data);
			 }else{
				 	redirect('home');
			 }
	}
	
	
	
	function approve_reimburse_to_client($id){
		$reimburse=0;
		$database=array('reimburse'=>$reimburse);
		$where=array('id'=>$id);
		
		$this->general_model->update_data('request_budget_tb',$database,$where);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	function bs_list_history($employee_id){
		$this->load->model('budget_model');
		$this->data['request_fund']=$request_fund=$this->report_model->get_request_budget_by_employee($employee_id);
		$this->data['page'] = 'report/history_bs_list';
		$this->load->view('common/body', $this->data);
	}
	
	
	
	function report_history_search($keyword=NULL){
	  if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/report_history_search","privilege_tb")){
		$keyword=$this->input->post('keyword');
		if($keyword!=NULL){
			$this->data['search_list_po_stock']=$this->report_model->get_po_stock_history($keyword);
			$this->data['search_list_po_non_stock']=$this->report_model->get_po_non_stock_history($keyword);
			$this->data['search_list_request_stock']=$this->report_model->get_request_stock_history($keyword);
			$this->data['search_request_fund_item']=$this->report_model->get_request_item_detail_by_desc($keyword);;
		
		}else{
			$this->data['search_list_po_stock']=NULL;
			$this->data['search_list_po_non_stock']=NULL;
			$this->data['search_list_request_stock']=NULL;
			$this->data['search_request_fund_item']=NULL;
		}
		
		
		$this->data['keyword']=$keyword;
		$this->data['page'] = 'report/history_report_search';
		$this->load->view('common/body', $this->data);
		
	  }else{
	  redirect('home');
	  }
	}
	
	
	function history_received_delivery($stock_id=NULL){	
	
		if($stock_id==NULL){
			redirect('home');
		}
		
		$this->data['stock_detail']=$stock_detail=$this->report_model->show_stock_detail($stock_id);
		$this->data['stock_id']=$stock_id;
		$id_all=array();
		$get_item_list=$this->report_model->get_item_stock_by_name($stock_detail['item']);
		if($get_item_list)foreach($get_item_list as $list){
			$id_all[]=$list['id'];  
		}
		$join_id_all=join(',',$id_all);
	
		
		
		$this->data['start_date']=$start_date=$this->input->post('date_1');
		$this->data['end_date']=$end_date=$this->input->post('date_2');
		$this->data['history_list']=$this->report_model->show_history_delivery_received($start_date,$end_date,$join_id_all);

		$this->data['page'] = 'report/history_received_delivery';
		$this->load->view('common/body', $this->data);
	}
	
	//
}?>