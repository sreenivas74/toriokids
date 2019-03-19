<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Home extends Ext_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('reminder_model');
		$this->load->model('project_model');
		$this->load->model('admin_model');
		$this->load->model('general_model');
		$this->load->model('department_model');

	}
	function index(){
		if($this->sentry->admin_is_logged_in() == TRUE){
			$_SESSION['employee_id']=$employee_id=$this->session->userdata('employee_id');
			$_SESSION['departemen_id']=$departemen_id=$this->session->userdata('admin_departemen_id');
			$this->data['page'] = 'home';	
			$this->data['employee_active'] = $this->project_model->show_employee_active();
			$this->data['reminder_today'] = $this->reminder_model->show_reminder_today();
			
			if($employee_id>0){
				$this->data['get_deadline_reminder']=$this->reminder_model->get_deadline_reminder($employee_id,$departemen_id);
				
			}else{
				$this->data['get_deadline_reminder']=$this->reminder_model->get_deadline_reminder_admin();
			}
			$this->data['crm_dashboard'] = $this->project_model->show_crm_dashboard();
			$this->data['activity_dashboard'] = $this->project_model->show_activity_dashboard();
			$this->data['quarter_goal_dashboard'] = $this->project_model->show_quarter_goal_dashboard();
			$this->data['quarter_win_dashboard'] = $this->project_model->show_quarter_win_dashboard();
			$this->data['pending_payment_dashboard'] = $this->project_model->show_pending_payment_dashboard();
			$this->data['job_tracking'] = $this->project_model->show_job_tracking_open_not_approved();
			$this->data['employee_goal_list'] = $this->project_model->show_employee_goal_list();
			$this->data['schedule_to_list'] = $this->project_model->show_schedule_to_list();
			$this->data['project_not_survey_list'] = $this->project_model->show_project_not_survey_list();
			$this->data['employee_information_deadline'] = $this->project_model->show_employee_information_deadline();
			$this->data['inventory_list'] = $this->project_model->show_inventory_list_over_six_months();
			$this->data['vendor_list'] = $this->project_model->show_vendor_last_visit();
			$this->data['lesson_learn_list'] = $this->project_model->show_lesson_learn();
			$this->data['amount_goal_quarter'] = $this->project_model->show_project_goal_amount_per_quarter();
			$this->data['employee_year'] = $this->project_model->show_employee_year();
			$this->data['admin_login_log'] = $this->project_model->show_admin_login_log();
			//$this->data['statistic_days'] = $this->project_model->show
			$this->data['project_team_list'] = $this->project_model->show_team_list();
		}else{
			$this->data['page'] = 'login';
		}
		$this->load->view('common/body', $this->data);
	}
	
	function schedule_1_minggu(){
		$this->data['department_list'] = $this->project_model->show_department_list();
		$this->data['employee_active'] = $this->project_model->show_employee_active();
		$this->data['schedule_to_list'] = $this->project_model->show_schedule_to_list();
		$this->data['page'] = 'schedule_1_minggu';
		$this->load->view('common/body', $this->data);	
	}
	
	function crm_deadline(){
		$this->data['crm_deadline_list'] = $this->project_model->show_crm_deadline();
		$this->data['crm_updated_list'] = $this->project_model->show_crm_updated();
		$this->data['pending_payment_dashboard'] = $this->project_model->show_pending_payment_dashboard();
		
		$this->data['department_list'] = $this->project_model->show_department_list();
		$this->data['employee_active'] = $this->project_model->show_employee_active();
		$this->data['schedule_to_list'] = $this->project_model->show_schedule_to_list();
		
		$this->data['page'] = 'crm_deadline';
		$this->load->view('common/body', $this->data);
	}
	
	function crm_deadline_send_email(){
		//$to_email = "david@isysedge.com";
		$to_email = "indra@gsindonesia.com;robert@gsindonesia.com";
		$crm_deadline_list = $this->project_model->show_crm_deadline();
		$crm_updated_list = $this->project_model->show_crm_updated();
		$pending_payment_dashboard = $this->project_model->show_pending_payment_dashboard();
		
		$department_list = $this->project_model->show_department_list();
		$employee_active = $this->project_model->show_employee_active();
		$schedule_to_list = $this->project_model->show_schedule_to_list();
		
		//CRM
		$email_content=
		"
		<h2>CRM deadline 1 month from now ".date('d/m/Y')."</h2>
		<table style='width:100%' border='1'>
			<thead>
				<td><b>Project Name</b></td>
				<td><b>Marketing</td>
				<td><b>Client</b></td>
				<td><b>Amount</b></td>
				<td><b>Expected Close Date</b></td>
			</thead>
			<tbody>";
				if($crm_deadline_list)foreach($crm_deadline_list as $list){
					$email_content.= "<tr>
						<td valign='top'>".$list['name']."</td>
						<td valign='top'>".find('firstname',$list['employee_id'],'employee_tb')." ".find('lastname',$list['employee_id'],'employee_tb')."</td>
						<td valign='top'>".find('name',$list['client_id'],'client_tb')."</td>
						<td valign='top' align='right'>".currency($list['amount'])."</td>
						<td valign='top' align='center'>".date('d/m/Y',strtotime($list['expected_close_date']))."</td>
					</tr>";
				}
			$email_content.= "</tbody>
		</table>";
		
		//no update
		$email_content.=
		"
		<h2>CRM 1 month No-update ".date('d/m/Y')."</h2>
		<table style='width:100%' border='1'>
			<thead>
				<td><b>Project Name</b></td>
				<td><b>Marketing</td>
				<td><b>Client</b></td>
				<td><b>Amount</b></td>
				<td><b>Expected Close Date</b></td>
				<td><b>Update Date</b></td>
			</thead>
			<tbody>";
				if($crm_updated_list)foreach($crm_updated_list as $list){
					if($list['sales_stage']!=4){
					$email_content.= "<tr>
						<td valign='top'>".$list['name']."</td>
						<td valign='top'>".find('firstname',$list['employee_id'],'employee_tb')." ".find('lastname',$list['employee_id'],'employee_tb')."</td>
						<td valign='top'>".find('name',$list['client_id'],'client_tb')."</td>
						<td valign='top' align='right'>".currency($list['amount'])."</td>
						<td valign='top'>".date('d/m/Y',strtotime($list['expected_close_date']))."</td>
						<td valign='top'>".date('d/m/Y',strtotime($list['update_date']))."</td>
					</tr>";
					}
				}
			$email_content.= "</tbody>
		</table>";
		
		//PENDING PAYMENT
		$email_content.=
		"
		<h2>Pending Payment</h2>
		<table style='width:100%' border='1'>
			<thead>
				<th>Project</th>
				<th>Invoice</th>
				<th>BAST</th>
				<th>Outstanding IDR</th>
				<th>Outstanding USD</th>
			</thead>";
			if($pending_payment_dashboard)foreach($pending_payment_dashboard as $list){
						if($list['pgi_bast']!=0000-00-00 && $list['name']!='' && (($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1) || ($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1))){
							$email_content.="
							<tr>
								<td valign='top'>".$list['name']."</td>
								<td valign='top'>".$list['pgi_invoice']."</td>
								<td valign='top'>".date('d/m/Y',strtotime($list['pgi_bast']))."</td>
								<td valign='top' align='right'>";
										if($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')!=0){
										$email_content.= currency($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
									}
                                $email_content.="
								</td>
								<td valign='top' align='right'>";
									if($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')){
										$email_content.= currency($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
									}
								$email_content.="</td>
							</tr>";
							
					}
                }
                
        $email_content.="</table>";
		
		//ACTIVITY
		
		
		for($x=0;$x<8;$x++){
			if($x==0){
    			$email_content.= "<h2>".date('D d/m/Y')."</h2>
			<table border='1' style='width:100%'>
				<thead>
					<th width='15%'>Name</th>
					<th>Description</th>
					<th width='15%'>PIC</th>
					<th width='10%'>Telp</th>
					<th width='10%'>Jam</th>
				</thead>
				<tbody>";
					if($department_list)foreach($department_list as $list){
						if($list['id'] == 4){
						$email_content.="
						<tr>
							<td colspan='5'><b>".$list['name']."</b></td>
						</tr>";
						if($employee_active)foreach($employee_active as $list2){
								if($list2['department_id'] == $list['id']){
									$email_content.="
									<tr>
										<td valign='top' colspan='5'>&bull; ".$list2['firstname']." ".$list2['lastname']."</td>
									</tr>";
									if(find_4_string('description','date_now',date('Y-m-d'),'employee_id',$list2['id'],'schedule_tb') || find_4_string('description','activity_date',date('Y-m-d'),'employee_id',$list2['id'],'project_employee_activity_tb')){
										$email_content.="
										<tr>
											<td></td>
											<td valign='top'>
											<a style='text-decoration:none; color:#000' href='".site_url('schedule/detail_schedule/'.find_4_string('id','date_now',date('Y-m-d'),'employee_id',$list2['id'],'schedule_tb'))."'>".find_4_string('description','date_now',date('Y-m-d'),'employee_id',$list2['id'],'schedule_tb')."</a><br />
											<a style='text-decoration:none; color:#000' href='".site_url('project/detail_employee_activity/'.find_4_string('id','activity_date',date('Y-m-d'),'employee_id',$list2['id'],'project_employee_activity_tb'))."'>".find_4_string('description','activity_date',date('Y-m-d'),'employee_id',$list2['id'],'project_employee_activity_tb')."</a>
											</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>";
									}
										if($schedule_to_list)foreach($schedule_to_list as $list3){
											if($list3['activity_date']==date('Y-m-d') && $list3['employee_id']==$list2['id']){
											$email_content.="
											<tr>
												<td></td>
												<td valign='top'>".nl2br($list3['description'])."</td>
												<td valign='top'>".nl2br($list3['pic'])."</td>
												<td valign='top'>".nl2br($list3['phone'])."</td>
												<td valign='top'>".nl2br($list3['time'])."</td>
											</tr>";
											}
										}
								}
							}
						}
					}
					$email_content.="
				</tbody>
			</table>";
		}else{
			$email_content.="
			<h2>".date('D d/m/Y',strtotime('+'.$x.' day',strtotime(date('Y-m-d'))))."</h2>
			<table border='1' style='width:100%'>
				<thead>
					<th width='15%'>Name</th>
					<th>Description</th>
					<th width='15%'>PIC</th>
					<th width='10%'>Telp</th>
					<th width='10%'>Jam</th>
				</thead>
				<tbody>";
					if($department_list)foreach($department_list as $list){
						if($list['id'] == 4){
						$email_content.="
						<tr>
							<td colspan='5'><b>".$list['name']."</b></td>
						</tr>";
						if($employee_active)foreach($employee_active as $list2){
								if($list2['department_id'] == $list['id']){
									$email_content.="
									<tr>
										<td valign='top' colspan='5'>&bull; ".$list2['firstname']." ".$list2['lastname']."</td>
									</tr>";
									if(find_4_string('description','date_now',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb') || find_4_string('description','activity_date',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'project_employee_activity_tb')){
										$email_content.="
										<tr>
											<td></td>
											<td valign='top'><a style='text-decoration:none; color:#000' href='".site_url('schedule/detail_schedule/'.find_4_string('id','date_now',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb'))."'>".find_4_string('description','date_now',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')."</a><br />
											<a style='text-decoration:none; color:#000' href='".site_url('project/detail_employee_activity/'.find_4_string('id','activity_date',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'project_employee_activity_tb'))."'>".find_4_string('description','activity_date',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'project_employee_activity_tb')."</a>
											</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>";
									}
									
										if($schedule_to_list)foreach($schedule_to_list as $list3){
											if($list3['activity_date']==date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))) && $list3['employee_id']==$list2['id']){
											$email_content.="
											<tr>
												<td></td>
												<td valign='top'>".nl2br($list3['description'])."</td>
												<td valign='top'>".nl2br($list3['pic'])."</td>
												<td valign='top'>".nl2br($list3['phone'])."</td>
												<td valign='top'>".nl2br($list3['time'])."</td>
											</tr>";
											}
										}
								}
							}
						}
					}
				$email_content.="</tbody>
			</table>";
			}
		}
		
		$subject = "Laporan Harian";
		$this->load->library('email'); 
		$this->email->from("crm@gsindonesia.com");
		$this->email->to($to_email);
			
		$this->email->subject($subject);
		$this->email->message($email_content);  
		$this->email->send();
		
		//to sales
		$to_email = '';
		$x=0;
		if($employee_active)foreach($employee_active as $list4){
			if($list4['email']!="" && $list4['department_id']==4){
				
				$to_email = $list4['email'];
				//$to_email = 'david@isysedge.com';
				
				//CRM
				$email_content=
				"
				<h2>CRM deadline 1 month from now ".date('d/m/Y')."</h2>
				<table style='width:100%' border='1'>
					<thead>
						<td><b>Project Name</b></td>
						<td><b>Marketing</td>
						<td><b>Client</b></td>
						<td><b>Amount</b></td>
						<td><b>Expected Close Date</b></td>
					</thead>
					<tbody>";
						if($crm_deadline_list)foreach($crm_deadline_list as $list){
							if($list['employee_id'] == $list4['id']){
							$email_content.= "<tr>
								<td valign='top'>".$list['name']."</td>
								<td valign='top'>".find('firstname',$list['employee_id'],'employee_tb')." ".find('lastname',$list['employee_id'],'employee_tb')."</td>
								<td valign='top'>".find('name',$list['client_id'],'client_tb')."</td>
								<td valign='top' align='right'>".currency($list['amount'])."</td>
								<td valign='top' align='center'>".date('d/m/Y',strtotime($list['expected_close_date']))."</td>
							</tr>";
							}
						}
					$email_content.= "</tbody>
				</table>";
				
				//PENDING PAYMENT
				$email_content.=
				"
				<h2>Pending Payment</h2>
				<table style='width:100%' border='1'>
					<thead>
						<th>Project</th>
						<th>Invoice</th>
						<th>BAST</th>
						<th>Outstanding IDR</th>
						<th>Outstanding USD</th>
					</thead>";
					if($pending_payment_dashboard)foreach($pending_payment_dashboard as $list){
								if($list['pgi_bast']!=0000-00-00 && $list['name']!='' && (($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1) || ($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1)) && $list['employee_id']==$list4['id'] ){
									$email_content.="
									<tr>
										<td valign='top'>".$list['name']."</td>
										<td valign='top'>".$list['pgi_invoice']."</td>
										<td valign='top'>".date('d/m/Y',strtotime($list['pgi_bast']))."</td>
										<td valign='top' align='right'>";
												if($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')!=0){
												$email_content.= currency($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
											}
										$email_content.="
										</td>
										<td valign='top' align='right'>";
											if($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')){
												$email_content.= currency($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
											}
										$email_content.="</td>
									</tr>";
									
							}
						}
						
				$email_content.="</table>";
				
				//ACTIVITY
				
				for($x=0;$x<8;$x++){
					if($x==0){
						$email_content.= "<h2>".date('D d/m/Y')."</h2>
					<table border='1' style='width:100%'>
						<thead>
							<th width='15%'>Name</th>
							<th>Description</th>
							<th width='15%'>PIC</th>
							<th width='10%'>Telp</th>
							<th width='10%'>Jam</th>
						</thead>
						<tbody>";
							if($department_list)foreach($department_list as $list){
								if($list['id'] == 4){
								$email_content.="
								<tr>
									<td colspan='5'><b>".$list['name']."</b></td>
								</tr>";
								if($employee_active)foreach($employee_active as $list2){
										if($list2['department_id'] == $list['id'] && $list2['id'] == $list4['id']){
											$email_content.="
											<tr>
												<td valign='top' colspan='5'>&bull; ".$list2['firstname']." ".$list2['lastname']."</td>
											</tr>";
											if(find_4_string('description','date_now',date('Y-m-d'),'employee_id',$list2['id'],'schedule_tb') || find_4_string('description','activity_date',date('Y-m-d'),'employee_id',$list2['id'],'project_employee_activity_tb')){
												$email_content.="
												<tr>
													<td></td>
													<td valign='top'>
													<a style='text-decoration:none; color:#000' href='".site_url('schedule/detail_schedule/'.find_4_string('id','date_now',date('Y-m-d'),'employee_id',$list2['id'],'schedule_tb'))."'>".find_4_string('description','date_now',date('Y-m-d'),'employee_id',$list2['id'],'schedule_tb')."</a><br />
													<a style='text-decoration:none; color:#000' href='".site_url('project/detail_employee_activity/'.find_4_string('id','activity_date',date('Y-m-d'),'employee_id',$list2['id'],'project_employee_activity_tb'))."'>".find_4_string('description','activity_date',date('Y-m-d'),'employee_id',$list2['id'],'project_employee_activity_tb')."</a>
													</td>
													<td></td>
													<td></td>
													<td></td>
												</tr>";
											}
												if($schedule_to_list)foreach($schedule_to_list as $list3){
													if($list3['activity_date']==date('Y-m-d') && $list3['employee_id']==$list2['id']){
													$email_content.="
													<tr>
														<td></td>
														<td valign='top'>".nl2br($list3['description'])."</td>
														<td valign='top'>".nl2br($list3['pic'])."</td>
														<td valign='top'>".nl2br($list3['phone'])."</td>
														<td valign='top'>".nl2br($list3['time'])."</td>
													</tr>";
													}
												}
										}
									}
								}
							}
							$email_content.="
						</tbody>
					</table>";
				}else{
					$email_content.="
					<h2>".date('D d/m/Y',strtotime('+'.$x.' day',strtotime(date('Y-m-d'))))."</h2>
					<table border='1' style='width:100%'>
						<thead>
							<th width='15%'>Name</th>
							<th>Description</th>
							<th width='15%'>PIC</th>
							<th width='10%'>Telp</th>
							<th width='10%'>Jam</th>
						</thead>
						<tbody>";
							if($department_list)foreach($department_list as $list){
								if($list['id'] == 4){
								$email_content.="
								<tr>
									<td colspan='5'><b>".$list['name']."</b></td>
								</tr>";
								if($employee_active)foreach($employee_active as $list2){
										if($list2['department_id'] == $list['id'] && $list2['id'] == $list4['id']){
											$email_content.="
											<tr>
												<td valign='top' colspan='5'>&bull; ".$list2['firstname']." ".$list2['lastname']."</td>
											</tr>";
											if(find_4_string('description','date_now',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb') || find_4_string('description','activity_date',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'project_employee_activity_tb')){
												$email_content.="
												<tr>
													<td></td>
													<td valign='top'><a style='text-decoration:none; color:#000' href='".site_url('schedule/detail_schedule/'.find_4_string('id','date_now',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb'))."'>".find_4_string('description','date_now',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')."</a><br />
													<a style='text-decoration:none; color:#000' href='".site_url('project/detail_employee_activity/'.find_4_string('id','activity_date',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'project_employee_activity_tb'))."'>".find_4_string('description','activity_date',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'project_employee_activity_tb')."</a>
													</td>
													<td></td>
													<td></td>
													<td></td>
												</tr>";
											}
											
												if($schedule_to_list)foreach($schedule_to_list as $list3){
													if($list3['activity_date']==date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))) && $list3['employee_id']==$list2['id']){
													$email_content.="
													<tr>
														<td></td>
														<td valign='top'>".nl2br($list3['description'])."</td>
														<td valign='top'>".nl2br($list3['pic'])."</td>
														<td valign='top'>".nl2br($list3['phone'])."</td>
														<td valign='top'>".nl2br($list3['time'])."</td>
													</tr>";
													}
												}
										}
									}
								}
							}
						$email_content.="</tbody>
					</table>";
					}
				}
				
				
				
				$subject = "Laporan Harian";
				$this->load->library('email'); 
				$this->email->from("crm@gsindonesia.com");
				$this->email->to($to_email);
					
				$this->email->subject($subject);
				$this->email->message($email_content);  
				$this->email->send();
			
			}$x++;
		}
		
		//redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function crm_list($employee_id,$sales_stage){
		$this->data['employee_id'] = $employee_id;
		$this->data['sales_stage'] = $sales_stage;
		$this->data['crm_project_list'] = $this->project_model->show_crm_project_list($employee_id,$sales_stage);
		$this->data['page'] = 'crm_list';
		$this->load->view('common/body', $this->data);
	}
	
	function goal_quarter_list($employee_id){
		$this->data['employee_id'] = $employee_id;
		$this->data['goal_quarter_list'] = $this->project_model->show_project_goal_amount_per_quarter_2($employee_id);
		$this->data['page'] = 'goal_quarter_list';
		$this->load->view('common/body', $this->data);
	}
	
	//reminder send
	function reminder_send_email(){
		$to_email = "";
		$x=0;
		$reminder = $this->reminder_model->show_reminder_today_2();
		//$department = $this->reminder_model->show_department_active();
		$department_id = 0;
		$email_content = '';
		$total = count($reminder);
		$no = 1;
		//echo $total."<br>";
		if($reminder)foreach($reminder as $list2){
			
			if($department_id==0){
				$department_id = $list2['department_id'];	
				$email_content.= $list2['department_id'].$list2['description']." [ <b>Reminder : ".date('d/m/Y',strtotime($list2['date_send']))."</b> - <b>Deadline : ".date('d/m/Y',strtotime($list2['date_deadline']))."</b> ]<br>";
			}elseif($department_id==$list2['department_id']){
				$email_content.= $list2['department_id'].$list2['description']." [ <b>Reminder : ".date('d/m/Y',strtotime($list2['date_send']))."</b> - <b>Deadline : ".date('d/m/Y',strtotime($list2['date_deadline']))."</b> ]<br>";
			}elseif($department_id!=$list2['department_id']){
				//get department email
				$department_list = $this->reminder_model->show_employee_active_by_department($department_id);
				if($department_list)foreach($department_list as $list){
					if($list['email']!=""){
						if($x!=0){
							$to_email = $to_email.";".$list['email'];
						}else{
							$to_email = $list['email'];	
						}
					}
					$x++;
				}
				//
				//echo $email_content."send to:".$to_email."<br>";
				$subject = "Reminder";
				$this->load->library('email'); 
				$this->email->from("crm@gsindonesia.com");
				$this->email->to($to_email);
					
				$this->email->subject($subject);
				$this->email->message($email_content);  
				$this->email->send();
				
				$email_content = '';
				$to_email='';
				$x=0;
				$email_content.= $list2['department_id'].$list2['description']." [ <b>Reminder : ".date('d/m/Y',strtotime($list2['date_send']))."</b> - <b>Deadline : ".date('d/m/Y',strtotime($list2['date_deadline']))."</b> ]<br>";
				$department_id = $list2['department_id'];
			}
			
			if($no == $total){
				//get department email
				$department_list = $this->reminder_model->show_employee_active_by_department($department_id);
				if($department_list)foreach($department_list as $list){
					if($list['email']!=""){
						if($x!=0){
							$to_email = $to_email.";".$list['email'];
						}else{
							$to_email = $list['email'];	
						}
					}
					$x++;
				}
				//
				//echo $email_content."send to:".$to_email."<br>";
				
				$subject = "Reminder";
				$this->load->library('email'); 
				$this->email->from("crm@gsindonesia.com");
				$this->email->to($to_email);
					
				$this->email->subject($subject);
				$this->email->message($email_content);  
				$this->email->send();
				
				$email_content = '';
				$to_email='';
				$x=0;
			}
			$no++;
		}
	}
	
	function forget_password(){
		$this->data['page'] = 'forget_password';
		$this->load->view('common/body', $this->data);
	}
	
	function do_forget_password(){
	
		$username=$this->input->post('username');
		$detail=$this->admin_model->login_by_email($username);
	
		$admin_id=$detail['id'];
		$newdate=date("Y-m-d H:i:s");
		$verification_code=md5($newdate.$admin_id.$username);
		
		$database=array('user_id'=>$admin_id,'verification_code'=>$verification_code,'created_date'=>$newdate);
		$this->general_model->delete_data('forgot_password_tb',array('user_id'=>$admin_id));
		$this->general_model->insert_data('forgot_password_tb',$database);
		$this->data['url']=$url=site_url('home/do_email_forget'.'/'.$admin_id.'/'.$verification_code);
	
			$this->data['email']=$username;
		    $isi=$this->load->view('email/forget_password',$this->data,TRUE);
		
			$this->load->library('email'); 	
			$this->email->from('GSI Indonesia');
			$this->email->to($username); 
			$this->email->subject('Forget Password - Confirmation');
			$this->email->message($isi); 
			$this->email->send();		
			$this->email->clear();	
		
		$this->data['quote']= 'Silahkan periksa email anda, kami telah mengirimkan link untuk mendapatkan password baru';
		$this->data['keterangan']=NULL;
		$this->data['page'] = 'forget_password_confirm';
		$this->load->view('common/body', $this->data);
	
	}
	
	
	function do_email_forget($user_id=NULL,$verification_code=NULL){
		$data=$this->admin_model->get_detail_forget_pass($user_id,$verification_code);	
		
		$quote='';
		$email=find('username',$user_id,'administrator_tb');
		if($data){
		
			$newpass=rand(10000, 99999);
			$database=array('password'=>md5($newpass),'last_change_password'=>'0000-00-00');
			$this->general_model->update_data('administrator_tb',$database,array('id'=>$user_id));
			$this->data['newpass']=$newpass;
			    $isi=$this->load->view('email/new_password',$this->data,TRUE);
				$this->load->library('email'); 	
				$this->email->from('GSI Indonesia');
				$this->email->to($email); 
				$this->email->subject('Forget Password - New Password');
				$this->email->message($isi); 
				$this->email->send();		
				$this->email->clear();	
			//$_SESSION['sukses_forget_pass']=1;
			$quote='silahkan cek email anda, password baru telah dikirimkan ke email anda ';
			$keterangan=1;
			$this->general_model->delete_data('forgot_password_tb',array('user_id'=>$user_id));
			
		}else{
			$quote='Token anda expired, silahkan lakukan forget password kembali';
			$keterangan=2;
		}
		$this->data['keterangan']=$keterangan;
		
		
		$this->data['quote']=$quote;
		$this->data['page'] = 'forget_password_confirm';
		$this->load->view('common/body', $this->data);
	
	}
	
	function add_image(){
			$image='';
			$newdate=date("Y-m-d H:i:s");
			
		$config['upload_path'] = 'userdata/content/';
		$config['allowed_types'] = 'jpg|gif|png|jpeg';
		$config['encrypt_name'] = TRUE;		
			$this->load->library('upload', $config);
			
			
		
				if (!$this->upload->do_upload('file'))
				{
						$array = array('filelink' => '');
				}
				else
				{
					$data = $this->upload->data();
					$image = $data['file_name'] ; 
					$array = array(
					'filelink' => base_url()."userdata/content/".$image
				);
				}
			
				
			
			echo stripslashes(json_encode($array));
		}
		
		
	function do_update_timeline(){
	
		$progress=$this->input->post('progress');
		$notes=$this->input->post('notes');
		$timeline_id=$this->input->post('timeline_id');
		$newdate=date("Y-m-d H:i:s");
		$input_by = $this->session->userdata('employee_id');
		$database=array('timeline_id'=>$timeline_id,
						'progress'=>$progress,
						'notes'=>$notes,
						'created_by'=>$input_by,
						'created_date'=>$newdate,
						'last_updated_by'=>$input_by,
						'last_updated_date'=>$newdate);
		$this->general_model->insert_data('timeline_log_tb',$database);
		$this->general_model->update_data('project_deadline_tb',array('progress'=>$progress),array('id'=>$timeline_id));
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	//
}?>