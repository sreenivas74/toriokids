<script>
function update_progress(id){
	$(".aaa").hide();
	$(".sssss").hide();
	$("#detail_edit_timeline_"+id).show();
	$("#update_progress_"+id).show();
	
}
</script>

                
<?php if($this->session->userdata("employee_id")!=0){
	if(find('department_id',$this->session->userdata('employee_id'),'employee_tb') == 4 || find('department_id',$this->session->userdata('employee_id'),'employee_tb') == 8){
		$x=1;
	}elseif(find('department_id',$this->session->userdata('employee_id'),'employee_tb') == 7){
		$x=2;
	}elseif(find('department_id',$this->session->userdata('employee_id'),'employee_tb') == 5){
		$x=3;
	}elseif(find('department_id',$this->session->userdata('employee_id'),'employee_tb') == 1 || find('department_id',$this->session->userdata('employee_id'),'employee_tb') == 2){
		$x=4;
	}elseif(find('department_id',$this->session->userdata('employee_id'),'employee_tb') == 3){
		$x=5;
	}else{
		$x=999;	
	}
}else{
	$x=999;	
}?>

<p style="color:red"><?php echo $this->session->userdata('error_page');

$this->session->unset_userdata(array('error_page'=>''));
?></p>

<table style="width:100%" class="form">
 <b>&raquo; Reminder Deadline</b>
 <thead>
 <th>Description</th><th> Deadline</th><th>Employee/Departement</th><th>Project</th><th>Progress</th><th>Notes</th><th>Updated By</th><th>Update</th>
 </thead>    
   <?php if($get_deadline_reminder)foreach($get_deadline_reminder as $list_reminder){?>
    <tr>
    <td><?php echo $list_reminder['description'];?></td>
    <td style="color:red"><?php echo display_date($list_reminder['deadline_date']);?></td>
    <td>
    
    <?php if($list_reminder['division_assignment']>0){?>
    
    <?php echo find('name',$list_reminder['division_assignment'],'department_tb');} ?>
    
     <?php if($list_reminder['employee_id_assignment']>0){?>
     
    
    <?php echo find('firstname',$list_reminder['employee_id_assignment'],'employee_tb') . ' ' . find('lastname',$list_reminder['employee_id_assignment'],'employee_tb'); } ?>
    
    
    
    
    </td>
    <td><?php echo find('name',$list_reminder['project_id'],'project_tb'); ?></td>
       <?php $data_log=$this->department_model->get_timeline_log_tb($list_reminder['id']);?>
    <td><?php if($data_log)foreach($data_log as $log_data){?>
    <?php echo $log_data['progress'];?><br />
    <?php } ?></td>
    <td><?php if($data_log)foreach($data_log as $log_data){?>
    <?php echo $log_data['notes'];?><br />
    <?php } ?></td>
    <td>
	   	<?php if($data_log)foreach($data_log as $log_data){?>
	<?php if($log_data['created_by']==0)echo 'admin';else  echo find('firstname',$log_data['created_by'],'employee_tb') . ' ' . find('lastname',$log_data['created_by'],'employee_tb')?><br />
    
    <?php }?>
    </td>
    <td><a href="#" onclick="update_progress('<?php echo $list_reminder['id']; ?>')">Update</a></td>
    </tr>
    <tr>
    <td style="display:none" id="update_progress_<?php echo $list_reminder['id']?>" class="aaa"> 
               <form method="POST" action="<?php echo site_url('home/do_update_timeline');?>" enctype="multipart/form-data">
              	<table class="form">
                
                     <tr>
                            <td>Progress</td>
                            <td><select  name="progress" >
                            <?php for($i=$list_reminder['progress'];$i<=100;$i++){?>
                            <option value="<?php echo $i;?>"><?php echo $i?></option>
                            <?php } ?>
                            
                            </select></td>
                        </tr>
                         <tr>
                            <td>Notes</td>
                            <td><textarea name="notes"></textarea></td>
                        </tr>
                        <input type="hidden" value="<?php echo $list_reminder['id']?>" name="timeline_id" />
                        <tr>
                            <td></td>
                            <td><input type="submit"  value="Submit" /></td>
                        </tr>
                    
                </table>
               
               </form>
               
               </td>
    </tr>
    <?php } ?>

</table>



<?php if($x==999){?>
		<table width="100%">
        	<tr>
            	<td width="50%" valign="top">
                	<b>&raquo; Reminder</b>
					<?php if($reminder_today){?>
                    <table class="form" style="width:100%; color:#000">
                        <thead>
                            <th width="4%">Action</th>
                            <th>Description</th>
                            <th width="7%">Reminder</th>
                            <th width="7%">Deadline</th>
                            <th width="10%">Department</th>
                        </thead>
                        <?php foreach($reminder_today as $list){?>
                            <tr>
                                <td valign="top" align="center"><a href="<?php echo site_url('reminder/send_reminder/'.$list['id'])?>" onclick="return confirm('Send this reminder?')">Send</a></td>
                                <td valign="top"><?php echo nl2br($list['description'])?></td>
                                <td valign="top" align="center">
                                    <?php if($list['date_send']==date("Y-m-d")){?><font color="#FF0000"><?php }?>
                                        <?php echo date("d/m/Y",strtotime($list['date_send']))?>
                                    </font>
                                </td>
                                <td valign="top" align="center">
                                    <?php if($list['date_deadline']<=date("Y-m-d")){?><font color="#FF0000"><?php }?>
                                        <?php echo date("d/m/Y",strtotime($list['date_deadline']))?>
                                    </font>
                                </td>
                                <td valign="top" align="center"><?php echo find('name',$list['department_id'],'department_tb');?></td>
                            </tr>
                            <?php }?>
                    </table>
                </td>
                <td>&nbsp;</td>
                <td width="50%" valign="top">
                	<b>&raquo; Job Tracking</b>
                    <table class="form" style="width:100%">
                        <thead>
                            <th>Deadline</th>
                            <th>Description</th>
                            <th>App</th>
                            <th>Status</th>
                        </thead>
                        
                        <?php if($job_tracking)foreach($job_tracking as $list){?>
                                <tr <?php if($list['due_date'] >= date('Y-m-d',strtotime('+0 day',strtotime(date('Y-m-d')))) && $list['due_date'] <= date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d'))))){?> style="color:#F00;" <?php }?>>
                                    <td align="center" width="10%" valign="top"><?php if($list['due_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['due_date'])); else echo "-";?>
                                    <br />
                                    <a onclick="return confirm('Send this job tracking?');" style="text-decoration:none" href="<?php echo site_url('schedule/send_job_tracking/'.$list['id']);?>">[Send]</a>
                                    </td>
                                <td valign="top"><a target="_blank" style="text-decoration:none; color:#000;" href="<?php echo site_url('schedule/detail_job_tracking/'.$list['id']);?>"><?php echo nl2br($list['description'])?></a></td>
                                <td valign="top" align="center">
                                    <?php if($list['approval']==1){?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">Yes</a>
                                    <?php }else{?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">No</a>
                                    <?php }?>
                                </td>
                                <td valign="top" align="center">
                                <?php if($list['active']==1){?>
                                    <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Closed</a>
                                <?php }else{?>
                                    <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Open</a>
                                <?php }?>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                <?php }?>
                </td>
            </tr>
        </table>
        <hr size="1" />
        <b>&raquo; USER LOGIN LOG</b>
        <?php $login_count = ceil(count($admin_login_log)/2);?>
        <table style="width:100%">
        	<tr>
            	<td valign="top" style="width:50%">
                	<table class="form" style="width:100%">
                        <thead>
                            <th width="40%">Name</th>
                            <th width="40%">Username</th>
                            <th>Last Login Date</th>
                        </thead>
                        <?php $c=0;
						if($admin_login_log)foreach($admin_login_log as $list){
							if($c<=$login_count){?>
                                <tr>
                                    <td><?php echo $list['name']?></td>
                                    <td><?php echo $list['username']?></td>
                                    <td><?php if($list['last_login']!="0000-00-00 00:00:00"){
                                                echo date('D, d/m/Y',strtotime($list['last_login']));
                                    }?></td>
                                </tr>
                        <?php }$c++;
						}?>
                    </table>
                </td>
                <td></td>
                <td valign="top">
                	<table class="form" style="width:100%">
                        <thead>
                            <th width="40%">Name</th>
                            <th width="40%">Username</th>
                            <th>Last Login Date</th>
                        </thead>
                        <?php $c=0;
						if($admin_login_log)foreach($admin_login_log as $list){
							if($c > $login_count){?>
                                <tr>
                                    <td><?php echo $list['name']?></td>
                                    <td><?php echo $list['username']?></td>
                                    <td><?php if($list['last_login']!="0000-00-00 00:00:00"){
                                                echo date('D, d/m/Y',strtotime($list['last_login']));
                                    }?></td>
                                </tr>
                        <?php }$c++;
						}?>
                    </table>
                </td>
            </tr>
        </table>
        
<?php }elseif($x==1){?>
<table width="100%">
	<tr>
    	<td valign="top" width="25%">
        	<?php 	if(date("N")==1)$z=1;
					elseif(date("N")==2)$z=1;
					elseif(date("N")==3)$z=1;
					elseif(date("N")==4)$z=1;
					elseif(date("N")==5)$z=1;
					elseif(date("N")==6)$z=1;
					elseif(date("N")==7)$z=1;?>
                   
            <?php if($this->session->userdata('employee_id')!=0){?>
        	<b>&raquo; Schedule</b>
        	<table class="form" style="width:100%;">
            	<tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z-1).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z-1).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d') && $list['employee_id']==$this->session->userdata['employee_id']){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+1).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+1).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+2 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+2).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+2).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+3 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+3).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+3).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+4 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td width="20%" valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+4).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+4).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+5 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
            </table>
            <hr size="1" />
            <?php }?>
            <?php if($this->session->userdata('employee_id')!=0){?>
            	<b>&raquo; Activity</b>
                <table class="form" style="width:100%">
                	<thead>
                    	<th>Date</th>
                        <th>Now</th>
                        <th>Next</th>
                    </thead>
                    <?php if($activity_dashboard)foreach($activity_dashboard as $list){
							if($list['employee_id']==$this->session->userdata['employee_id']){?>
                                <tr>
                                    <td width="10%" valign="top"><?php echo date("d/m/Y",strtotime($list['activity_date']))?></td>
                                    <td><?php echo nl2br($list['description'])?></td>
                                    <td><?php echo nl2br($list['plan_tomorrow'])?></td>
                                </tr>
                    <?php }
					}?>
                </table>
                <hr size="1" />
            <?php }?>
            <?php if($this->session->userdata('employee_id')!=0){?>
            	<b>&raquo; Job Tracking</b>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking_2","privilege_tb")){?>
                    <table class="form" style="width:100%">
                        <thead>
                            <th>Deadline</th>
                            <th>Description</th>
                            <th>Approve</th>
                            <th>Status</th>
                        </thead>
                        
                        <?php if($job_tracking)foreach($job_tracking as $list){
                                if($list['assigned_to']==$this->session->userdata['employee_id']){?>
                                    <tr <?php if($list['due_date'] >= date('Y-m-d',strtotime('+0 day',strtotime(date('Y-m-d')))) && $list['due_date'] <= date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d'))))){?> style="color:#F00;" <?php }?>>
                                <td align="center" width="10%" valign="top"><?php if($list['due_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['due_date'])); else echo "-";?>
                                
                                </td>
                                <td valign="top"><a target="_blank" style="text-decoration:none; color:#000;" href="<?php echo site_url('schedule/detail_job_tracking/'.$list['id']);?>"><?php echo nl2br($list['description'])?></a></td>
                                <td valign="top" align="center">
                                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/approval_job_tracking","privilege_tb")){	?>
									<?php if($list['approval']==1){?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">Yes</a>
                                    <?php }else{?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">No</a>
                                    <?php }?>
                                <?php }else{?>
                                	<?php if($list['approval']==1){?>
                                        Yes
                                    <?php }else{?>
                                        No
                                    <?php }?>
                                <?php }?>
                                </td>
                                <td valign="top" align="center">
								<?php if($list['active']==1){?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Closed</a>
                                <?php }else{?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Open</a>
                                <?php }?>
                                </td>
                            </tr>
                            <?php }
                            }?>
                    </table>
                <?php }elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking","privilege_tb")){?>
                    <table class="form" style="width:100%">
                        <thead>
                            <th>Deadline</th>
                            <th>Description</th>
                            <th>App</th>
                            <th>Status</th>
                        </thead>
                        
                        <?php if($job_tracking)foreach($job_tracking as $list){?>
                            <tr <?php if($list['due_date'] >= date('Y-m-d',strtotime('+0 day',strtotime(date('Y-m-d')))) && $list['due_date'] <= date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d'))))){?> style="color:#F00;" <?php }?>>
                                <td align="center" width="10%" valign="top"><?php if($list['due_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['due_date'])); else echo "-";?>
                                <br />
                                <a onclick="return confirm('Send this job tracking?');" style="text-decoration:none" href="<?php echo site_url('schedule/send_job_tracking/'.$list['id']);?>">[Send]</a>
                                </td>
                                <td valign="top"><a target="_blank" style="text-decoration:none; color:#000;" href="<?php echo site_url('schedule/detail_job_tracking/'.$list['id']);?>"><?php echo nl2br($list['description'])?></a></td>
                                <td valign="top" align="center">
                                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/approval_job_tracking","privilege_tb")){	?>
									<?php if($list['approval']==1){?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">Yes</a>
                                    <?php }else{?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">No</a>
                                    <?php }?>
                                <?php }else{?>
									<?php if($list['approval']==1){?>
                                        Yes
                                    <?php }else{?>
                                        No
                                    <?php }?>
                                <?php }?>
                                </td>
                                <td valign="top" align="center">
								<?php if($list['active']==1){?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Closed</a>
                                <?php }else{?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Open</a>
                                <?php }?>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                <?php }?>
                <hr size="1" />
            <?php }?>
        </td>
        <td>&nbsp;</td>
    	<td valign="top" width="50%">
        	<b>&raquo; CRM</b>
            <table class="form" style="width:100%">
                <thead>
                    <th width="30%">Project</th>
                    <th width="8%">Demo</th>
                    <th width="8%">Quotation</th>
                    <th width="8%">Expected Close</th>
                    <th width="10%">Amount(IDR)</th>
                </thead>
                <tr>
                    <td colspan="5"><b>Potential</b></td>
                </tr>
                <?php 
				//collect data if leader
				$data = find_group_member_id($this->session->userdata('employee_id'));
				//
				
				$x=0; $total_potential = 0; 
				if($crm_dashboard)foreach($crm_dashboard as $list){
						if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_crm_2","privilege_tb")){
                        	if($list['sales_stage']==1 && ($list['employee_id'] == $this->session->userdata('employee_id') || in_array($list['employee_id'],$data))){?>
                                <tr style="color:
								<?php 
								if($list['expected_close_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['expected_close_date']))){?>
                                    	#F00 
								<?php } 
								}elseif($list['quotation_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('+1 month',strtotime($list['quotation_date']))){?>
                                     	#009900
                                <?php } 
								}elseif($list['demo_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('+1 month',strtotime($list['demo_date']))){?>
                                     	#009900
                                <?php }
								}?>
                                ">
                                    <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_crm/'.$list['id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                    <td valign="top" align="center"><?php if($list['demo_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['demo_date']));
                                                            else echo "-";?></td>
                                    <td valign="top" align="center"><?php if($list['quotation_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['quotation_date']));
                                                            else echo "-";?></td>
                                    <td valign="top" align="center"><?php if($list['expected_close_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['expected_close_date']));
                                                            else echo "-";?></td>
                                    <td valign="top" align="right"><?php echo currency($list['amount'])?></td>
                                </tr>
                <?php $x++;
						$total_potential = $total_potential+$list['amount'];
						}?>
					<?php }else{
							if($list['sales_stage']==1){?>
                                <tr style="color:
								<?php 
								if($list['expected_close_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['expected_close_date']))){?>
                                    	#F00 
								<?php } 
								}elseif($list['quotation_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('+1 month',strtotime($list['quotation_date']))){?>
                                     	#009900
                                <?php } 
								}elseif($list['demo_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('+1 month',strtotime($list['demo_date']))){?>
                                     	#009900
                                <?php }
								}?>
                                ">
                                    <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_crm/'.$list['id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                    <td valign="top" align="center"><?php if($list['demo_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['demo_date']));
                                                            else echo "-";?></td>
                                    <td valign="top" align="center"><?php if($list['quotation_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['quotation_date']));
                                                            else echo "-";?></td>
                                    <td valign="top" align="center"><?php if($list['expected_close_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['expected_close_date']));
                                                            else echo "-";?></td>
                                    <td valign="top" align="right"><?php echo currency($list['amount'])?></td>
                                </tr>
                <?php $x++;$total_potential = $total_potential+$list['amount'];}
						}
                }?>
                <?php if($x!=0){?>
                    <tr>
                        <td align="right"><b>Total : <?php echo $x;?></b></td>
                        <td colspan="3"></td>
                        <td align="right"><b><?php echo currency($total_potential);?></b></td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan="5" bgcolor="#333333"></td>
                </tr>
                <tr>
                    <td colspan="5"><b>Quotation</b></td>
                </tr>
                <?php $x=0; $total_quotation = 0; if($crm_dashboard)foreach($crm_dashboard as $list){
					if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_crm_2","privilege_tb")){
                        if($list['sales_stage']==2 && ($list['employee_id'] == $this->session->userdata('employee_id') || in_array($list['employee_id'],$data))){?>
                            <tr style="color:
								<?php 
								if($list['expected_close_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['expected_close_date']))){?>
                                    	#F00 
								<?php } 
								}elseif($list['quotation_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('+1 month',strtotime($list['quotation_date']))){?>
                                     	#009900
                                <?php } 
								}elseif($list['demo_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('+1 month',strtotime($list['demo_date']))){?>
                                     	#009900
                                <?php }
								}?>
                                ">
                                <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_crm/'.$list['id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                <td valign="top" align="center"><?php if($list['demo_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['demo_date']));
                                                        else echo "-";?></td>
                                <td valign="top" align="center"><?php if($list['quotation_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['quotation_date']));
                                                        else echo "-";?></td>
                                <td valign="top" align="center"><?php if($list['expected_close_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['expected_close_date']));
                                                        else echo "-";?></td>
                                <td valign="top" align="right"><?php echo currency($list['amount'])?></td>
                            </tr>
                <?php $x++;$total_quotation = $total_quotation + $list['amount'];}
					}else{
						if($list['sales_stage']==2){?>
                            <tr style="color:
								<?php 
								if($list['expected_close_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['expected_close_date']))){?>
                                    	#F00 
								<?php } 
								}elseif($list['quotation_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('+1 month',strtotime($list['quotation_date']))){?>
                                     	#009900
                                <?php } 
								}elseif($list['demo_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('+1 month',strtotime($list['demo_date']))){?>
                                     	#009900
                                <?php }
								}?>
                                ">
                                <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_crm/'.$list['id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                <td valign="top" align="center"><?php if($list['demo_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['demo_date']));
                                                        else echo "-";?></td>
                                <td valign="top" align="center"><?php if($list['quotation_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['quotation_date']));
                                                        else echo "-";?></td>
                                <td valign="top" align="center"><?php if($list['expected_close_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['expected_close_date']));
                                                        else echo "-";?></td>
                                <td valign="top" align="right"><?php echo currency($list['amount'])?></td>
                            </tr>
                <?php $x++;$total_quotation = $total_quotation + $list['amount'];}
					}
                }?>
                <?php if($x!=0){?>
                    <tr>
                        <td align="right"><b>Total : <?php echo $x;?></b></td>
                        <td colspan="3"></td>
                        <td align="right"><b><?php echo currency($total_quotation);?></b></td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan="5" bgcolor="#333333"></td>
                </tr>
                <tr>
                    <td colspan="5"><b>Tender/Review</b></td>
                </tr>
                <?php $x=0; $total_review= 0; if($crm_dashboard)foreach($crm_dashboard as $list){
					if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_crm_2","privilege_tb")){
                        if($list['sales_stage']==3 && ($list['employee_id'] == $this->session->userdata('employee_id') || in_array($list['employee_id'],$data))){?>
                            <tr style="color:
								<?php 
								if($list['expected_close_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['expected_close_date']))){?>
                                    	#F00 
								<?php } 
								}elseif($list['quotation_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('+1 month',strtotime($list['quotation_date']))){?>
                                     	#009900
                                <?php } 
								}elseif($list['demo_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('+1 month',strtotime($list['demo_date']))){?>
                                     	#009900
                                <?php }
								}?>
                                ">
                                <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_crm/'.$list['id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                <td valign="top" align="center"><?php if($list['demo_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['demo_date']));
                                                        else echo "-";?></td>
                                <td valign="top" align="center"><?php if($list['quotation_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['quotation_date']));
                                                        else echo "-";?></td>
                                <td valign="top" align="center"><?php if($list['expected_close_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['expected_close_date']));
                                                        else echo "-";?></td>
                                <td valign="top" align="right"><?php echo currency($list['amount'])?></td>
                            </tr>
                <?php $x++;$total_review = $total_review +$list['amount'];}
					}else{
						if($list['sales_stage']==3){?>
                            <tr style="color:
								<?php 
								if($list['expected_close_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['expected_close_date']))){?>
                                    	#F00 
								<?php } 
								}elseif($list['quotation_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('+1 month',strtotime($list['quotation_date']))){?>
                                     	#009900
                                <?php } 
								}elseif($list['demo_date']!=0000-00-00){
									if(strtotime(date("Y-m-d")) >= strtotime('+1 month',strtotime($list['demo_date']))){?>
                                     	#009900
                                <?php }
								}?>
                                ">
                                <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_crm/'.$list['id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                <td valign="top" align="center"><?php if($list['demo_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['demo_date']));
                                                        else echo "-";?></td>
                                <td valign="top" align="center"><?php if($list['quotation_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['quotation_date']));
                                                        else echo "-";?></td>
                                <td valign="top" align="center"><?php if($list['expected_close_date']!=0000-00-00)	echo date('d/m/Y',strtotime($list['expected_close_date']));
                                                        else echo "-";?></td>
                                <td valign="top" align="right"><?php echo currency($list['amount'])?></td>
                            </tr>
                <?php $x++;$total_review = $total_review +$list['amount'];}
					}
                }?>
                <?php if($x!=0){?>
                    <tr>
                        <td align="right"><b>Total : <?php echo $x;?></b></td>
                        <td colspan="3"></td>
                        <td align="right"><b><?php echo currency($total_review)?></b></td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan="5" bgcolor="#333333"></td>
                </tr>
            </table>
            
            <?php /*if(find_2('id','leader_id',$this->session->userdata('employee_id'),'employee_group_tb')){?>
            <hr size="1" />
            <h2>Team Member Project</h2>
            <table class="form" style="width:100%">
                <thead>
                    <th width="2%">No</th>
                    <th>Project Name</th>
                    <th>Member</th>
                    <th>Client</th>
                    <th>Sales Stage</th>
                    <th>Description</th>
                </thead>
                <?php $no = 1;if($project_team_list)foreach($project_team_list as $list){
                        if(find_4('id','leader_id',$this->session->userdata('employee_id'),'employee_id',$list['employee_id'],'employee_group_tb')){?>
                        <tr>
                            <td valign="top"><?php echo $no?></td>
                            <td valign="top"><?php echo $list['name']?></td>
                            <td valign="top"><?php echo find('firstname',$list['employee_id'],'employee_tb')." ".find('lastname',$list['employee_id'],'employee_tb')?></td>
                            <td valign="top"><?php echo find('name',$list['client_id'],'client_tb')?></td>
                            <td valign="top">
                            <?php 
                            if($list['sales_stage']==1){
                                echo "potential";
                            }elseif($list['sales_stage']==2){
                                echo "quotation";
                            }elseif($list['sales_stage']==3){
                                echo "tender/review";
                            }elseif($list['sales_stage']==4){
                                echo "win";
                            }else{
                                echo "lost";
                            }
                            ?>
                            </td>
                            <td valign="top"><?php echo find_last_info_project('description','project_id',$list['id'],'project_info_tb')?></td>
                        </tr>
                <?php $no++;}
                }?>
                
            </table>
            <?php }*/?>
    	</td>
        <td>&nbsp;</td>
        <td valign="top" style="width:50%">
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder_2","privilege_tb")){?>
    			<b>&bull; Today's reminder <?php echo date("d/m/Y");?></b>
				<?php if($reminder_today){?>
                <table class="form" style="width:100%; color:#000">
                    <thead>
                        
                        <th>Description</th>
                        
                        <th width="7%">Deadline</th>
                        <th width="10%">Department</th>
                    </thead>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder_2","privilege_tb")){?>
                                <?php foreach($reminder_today as $list){
                                        if($list['department_id']==find('department_id',$this->session->userdata('employee_id'),'employee_tb')){?>
                                            <tr>
                                                
                                                <td valign="top"><?php echo nl2br($list['description'])?></td>
                                                
                                                <td valign="top" align="center">
                                                    <?php if($list['date_deadline']<=date("Y-m-d")){?><font color="#FF0000"><?php }?>
                                                        <?php echo date("d/m/Y",strtotime($list['date_deadline']))?>
                                                    </font>
                                                </td>
                                                <td valign="top" align="center"><?php echo find('name',$list['department_id'],'department_tb');?></td>
                                            </tr>
                                <?php }
                                }
                    }elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder","privilege_tb")){
                             foreach($reminder_today as $list){?>
                                <tr>
                                    
                                    <td valign="top"><?php echo nl2br($list['description'])?></td>
                                    
                                    <td valign="top" align="center">
                                        <?php if($list['date_deadline']<=date("Y-m-d")){?><font color="#FF0000"><?php }?>
                                            <?php echo date("d/m/Y",strtotime($list['date_deadline']))?>
                                        </font>
                                    </td>
                                    <td valign="top" align="center"><?php echo find('name',$list['department_id'],'department_tb');?></td>
                                </tr>
                                <?php
                              }
                    }?>
                </table>
                <?php }else echo "&raquo; There is no reminders today";?>
                <hr size="1" />
            <?php }?>
            
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
            	<b>&raquo; Quarter Goal</b>
                <table class="form" style="width:100%">
                	<thead>
                    	<th>Project</th>
                        <th>Invoice</th>
                        <th>BAST</th>
                        <th>Settled</th>
                        <th>IDR</th>
                        <th>USD</th>
                    </thead>
                    <?php  $total_idr = 0; $total_usd=0; $idr = 0;$usd=0;?>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
                
						<?php if($quarter_goal_dashboard)foreach($quarter_goal_dashboard as $list){
								$idr = 0; $usd = 0;
                                if($list['employee_id']==$this->session->userdata['employee_id'] && $list['pgi_bast']!=0000-00-00  && $list['name']!=''){?>
                                    <tr>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php echo date("d/m/Y",strtotime($list['pgi_bast']))?></td>
                                        <td valign="top"></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['pgi_total']); 
														$idr = $list['pgi_total'];
													}else{
														echo currency($list['pgi_total']*10/11);
														$idr = $list['pgi_total']*10/11;
													}
											}else echo "-";?></td>
                                        <td valign="top" align="right">
											<?php if($list['total_2']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['total_2']);
														$usd = $list['total_2'];
													}else{
														echo currency($list['total_2']*10/11);
														$usd = $list['total_2']*10/11;
													}
											}else echo "-";?></td>
                                    </tr>
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        <tr>
                                <td colspan="4"></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_idr);?></font></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_usd);?></font></td>
                        	</tr>
					<?php }else{?>
     
                    	<?php  $total_idr = 0; $total_usd=0; $idr = 0;$usd=0;?>
                   	 	<?php if($quarter_goal_dashboard)foreach($quarter_goal_dashboard as $list){
								$idr = 0; $usd = 0;
                                if($list['pgi_bast']!=0000-00-00 && $list['name']!=''){?>
                                    <tr>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php echo date("d/m/Y",strtotime($list['pgi_bast']))?></td>
                                        <td valign="top"></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['pgi_total']); 
														$idr = $list['pgi_total'];
													}else{
														echo currency($list['pgi_total']*10/11); 
														$idr = $list['pgi_total']*10/11;
													}
											}else echo "-";?>
                                        </td>
                                        <td valign="top" align="right">
                                        	<?php if($list['total_2']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['total_2']);
														$usd = $list['total_2'];
													}else{
														echo currency($list['total_2']*10/11);
														$usd = $list['total_2']*10/11;
													}
											}else echo "-";?>
                                        </td>
                                    </tr>
							<?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
							}?>
                            <tr>
                                <td colspan="4"></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_idr);?></font></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_usd);?></font></td>
                        	</tr>
						<?php }?>
                </table>
                <hr size="1" />
            <?php }?>
            
            
            
            
            
            
            
            
            <?php  $total_idr = 0; $total_usd=0; $idr = 0;$usd=0;?>
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
            	<b>&raquo; Project Win</b>
                <table class="form" style="width:100%">
                	<thead>
                    	<th>Project</th>
                        <th>Invoice</th>
                        <th>Deadline</th>
                        <th>IDR</th>
                        <th>USD</th>
                    </thead>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
						<?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
                                $idr = 0; $usd = 0;
								if($list['employee_id']==$this->session->userdata['employee_id'] && $list['review_date']!=0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr<?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['pgi_total']); 
														$idr = $list['pgi_total'];
													}else{
														echo currency($list['pgi_total']*10/11); 
														$idr = $list['pgi_total']*10/11;
													}
											}else echo "-";?></td>
                                        <td valign="top" align="right">
											<?php if($list['total_2']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['total_2']);
														$usd = $list['total_2'];
													}else{
														echo currency($list['total_2']*10/11);
														$usd = $list['total_2']*10/11;
													}
											}else echo "-";?></td>
                                    </tr>
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        
                        <?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
							$usd = 0; $idr = 0;
								if($list['employee_id']==$this->session->userdata['employee_id'] && $list['review_date']==0000-00-00&& $list['pgi_bast']==0000-00-00){?>
                                    <tr<?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['pgi_total']); 
														$idr = $list['pgi_total'];
													}else{
														echo currency($list['pgi_total']*10/11); 
														$idr = $list['pgi_total']*10/11;
													}
											}else echo "-";?></td>
                                        <td valign="top" align="right">
											<?php if($list['total_2']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['total_2']);
														$usd = $list['total_2'];
													}else{
														echo currency($list['total_2']*10/11);
														$usd = $list['total_2']*10/11;
													}
											}else echo "-";?></td>
                                    </tr>
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        	<tr>
                                <td colspan="3"></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_idr);?></font></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_usd);?></font></td>
                        	</tr>
					<?php }else{?>
                    	<?php  $total_idr = 0; $total_usd=0; $idr = 0;$usd=0;?>
                   	 	<?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
								$idr = 0; $usd = 0;
                                if($list['review_date']!=0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr <?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['pgi_total']); 
														$idr = $list['pgi_total'];
													}else{
														echo currency($list['pgi_total']*10/11); 
														$idr = $list['pgi_total']*10/11;
													}
											}else echo "-";?></td>
                                        <td valign="top" align="right">
											<?php if($list['total_2']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['total_2']);
														$usd = $list['total_2'];
													}else{
														echo currency($list['total_2']*10/11);
														$usd = $list['total_2']*10/11;
													}
											}else echo "-";?></td>
                                    </tr>
							<?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;
								}
                            }?>
                            <?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
                               $usd = 0; $idr = 0;  if($list['review_date']==0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr <?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['pgi_total']); 
														$idr = $list['pgi_total'];
													}else{
														echo currency($list['pgi_total']*10/11); 
														$idr = $list['pgi_total']*10/11;
													}
											}else echo "-";?></td>
                                        <td valign="top" align="right">
											<?php if($list['total_2']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['total_2']);
														$usd = $list['total_2'];
													}else{
														echo currency($list['total_2']*10/11);
														$usd = $list['total_2']*10/11;
													}
											}else echo "-";?></td>
                                    </tr>
							<?php $total_idr = $total_idr + $idr; 
									$total_usd = $total_usd + $usd;
								}
                            }?>
                            <tr>
                                <td colspan="3"></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_idr);?></font></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_usd);?></font></td>
                        	</tr>
						<?php }?>
                </table>
                <hr size="1" />
            <?php }?>
            <?php  $total_idr = 0; $total_usd=0; $idr = 0;$usd=0;?>
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
            	<b>&raquo; Project Pending Payment</b>
                <table class="form" style="width:100%">
                	<thead>
                    	<th>Project</th>
                        <th>Invoice</th>
                        <th>BAST</th>
                        <th>Outstanding IDR</th>
                        <th>Outstanding USD</th>
                    </thead>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
						<?php if($pending_payment_dashboard)foreach($pending_payment_dashboard as $list){
							$idr = 0;$usd = 0;
                                if($list['pgi_bast']!=0000-00-00 && $list['name']!='' && (($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1) || ($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1)) && $list['employee_id']==$this->session->userdata['employee_id']){?>
                                	
                                    <tr <?php if(strtotime(date("Y-m-d")) > strtotime('+1 month',strtotime($list['pgi_bast']))){ ?> style="color:#F00" <?php }?>>
                                    	<td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php echo date("d/m/Y",strtotime($list['pgi_bast']))?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')!=0){
												echo currency($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
												$idr = $list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb');
											}else echo "-";?>
                                        </td>
                                        <td valign="top" align="right">
											<?php if($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')){
												echo currency($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
												$usd = $list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb');
											}else echo "-";?>
                                        </td>
                                    </tr>
                                    
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        	<tr>
                                <td colspan="3"></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_idr);?></font></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_usd);?></font></td>
                        	</tr>
					<?php }else{?>
                   	 	<?php if($pending_payment_dashboard)foreach($pending_payment_dashboard as $list){
								$idr = 0;$usd=0;
                                if($list['pgi_bast']!=0000-00-00 && $list['name']!='' && (($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1) || ($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1))){?>
                                	
                                    <tr <?php if(strtotime(date("Y-m-d")) > strtotime('+1 month',strtotime($list['pgi_bast']))){ ?> style="color:#F00" <?php }?>>
                                    	<td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php echo date("d/m/Y",strtotime($list['pgi_bast']))?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')!=0){
												echo currency($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
												$idr = $list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb');
											}else echo "-";?>
                                        </td>
                                        <td valign="top" align="right">
											<?php if($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')){
												echo currency($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
												$usd = $list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb');
											}else echo "-";?>
                                        </td>
                                    </tr>
                                    
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        	<tr>
                                <td colspan="3"></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_idr);?></font></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_usd);?></font></td>
                        	</tr>
                    <?php }?>
                </table>
                <hr size="1" />
            <?php }?>
        </td>
	</tr>    
</table>
<?php }elseif($x==2){?>
<table width="100%">
	<tr>
    	<td valign="top" width="25%">
        	<?php 	if(date("N")==1)$z=1;
					elseif(date("N")==2)$z=1;
					elseif(date("N")==3)$z=1;
					elseif(date("N")==4)$z=1;
					elseif(date("N")==5)$z=1;
					elseif(date("N")==6)$z=1;
					elseif(date("N")==7)$z=1;?>
                   
            <?php if($this->session->userdata('employee_id')!=0){?>
        	<b>&raquo; Schedule</b>
        	<table class="form" style="width:100%;">
            	<tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z-1).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z-1).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d') && $list['employee_id']==$this->session->userdata['employee_id']){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+1).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+1).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+2 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+2).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+2).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+3 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+3).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+3).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+4 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td width="20%" valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+4).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+4).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+5 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
            </table>
            <hr size="1" />
            <?php }?>
            <?php if($this->session->userdata('employee_id')!=0){?>
            	<b>&raquo; Job Tracking</b>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking_2","privilege_tb")){?>
                    <table class="form" style="width:100%">
                        <thead>
                            <th>Deadline</th>
                            <th>Description</th>
                            <th>App</th>
                            <th>Status</th>
                        </thead>
                        
                        <?php if($job_tracking)foreach($job_tracking as $list){
                                if($list['assigned_to']==$this->session->userdata['employee_id']){?>
                                    <tr <?php if($list['due_date'] >= date('Y-m-d',strtotime('+0 day',strtotime(date('Y-m-d')))) && $list['due_date'] <= date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d'))))){?> style="color:#F00;" <?php }?>>
                                <td align="center" width="10%" valign="top"><?php if($list['due_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['due_date'])); else echo "-";?></td>
                                <td valign="top"><a target="_blank" style="text-decoration:none; color:#000;" href="<?php echo site_url('schedule/detail_job_tracking/'.$list['id']);?>"><?php echo nl2br($list['description'])?></a></td>
                                <td valign="top" align="center">
                                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/approval_job_tracking","privilege_tb")){?>
									<?php if($list['approval']==1){?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">Yes</a>
                                    <?php }else{?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">No</a>
                                    <?php }?>
                                <?php }else{?>
                                	<?php if($list['approval']==1){?>
                                        Yes
                                    <?php }else{?>
                                        No
                                    <?php }?>
                                <?php }?>
                                </td>
                                <td valign="top" align="center">
								<?php if($list['active']==1){?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Closed</a>
                                <?php }else{?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Open</a>
                                <?php }?>
                                </td>
                            </tr>
                            <?php }
                            }?>
                    </table>
                <?php }elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking","privilege_tb")){?>
                    <table class="form" style="width:100%">
                        <thead>
                            <th>Deadline</th>
                            <th>Description</th>
                            <th>App</th>
                            <th>Status</th>
                        </thead>
                        
                        <?php if($job_tracking)foreach($job_tracking as $list){?>
                            <tr <?php if($list['due_date'] >= date('Y-m-d',strtotime('+0 day',strtotime(date('Y-m-d')))) && $list['due_date'] <= date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d'))))){?> style="color:#F00;" <?php }?>>
                                <td align="center" width="10%" valign="top"><?php if($list['due_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['due_date'])); else echo "-";?></td>
                                <td valign="top"><a target="_blank" style="text-decoration:none; color:#000;" href="<?php echo site_url('schedule/detail_job_tracking/'.$list['id']);?>"><?php echo nl2br($list['description'])?></a></td>
                                <td valign="top" align="center">
                                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/approval_job_tracking","privilege_tb")){?>
									<?php if($list['approval']==1){?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">Yes</a>
                                    <?php }else{?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">No</a>
                                    <?php }?>
                                <?php }else{?>
                                	<?php if($list['approval']==1){?>
                                        Yes
                                    <?php }else{?>
                                        No
                                    <?php }?>
                                <?php }?>
                                </td>
                                <td valign="top" align="center">
								<?php if($list['active']==1){?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Closed</a>
                                <?php }else{?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Open</a>
                                <?php }?>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                <?php }?>
                <hr size="1" />
            <?php }?>
        </td>
        <td>&nbsp;</td>
    	<td valign="top" width="50%">
        <?php  $total_idr = 0; $total_usd=0; $idr = 0;$usd=0;?>
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
            	<b>&raquo; Project Pending Payment</b>
                <table class="form" style="width:100%">
                	<thead>
                    	<th>Project</th>
                        <th>Invoice</th>
                        <th>BAST</th>
                        <th>Outstanding IDR</th>
                        <th>Outstanding USD</th>
                    </thead>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
						<?php if($pending_payment_dashboard)foreach($pending_payment_dashboard as $list){
							$idr = 0;$usd = 0;
                                if($list['pgi_bast']!=0000-00-00 && $list['name']!='' && (($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1) || ($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1)) && $list['employee_id']==$this->session->userdata['employee_id']){?>
                                	
                                    <tr <?php if(strtotime(date("Y-m-d")) > strtotime('+1 month',strtotime($list['pgi_bast']))){ ?> style="color:#F00" <?php }?>>
                                    	<td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php echo date("d/m/Y",strtotime($list['pgi_bast']))?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')!=0){
												echo currency($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
												$idr = $list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb');
											}else echo "-";?>
                                        </td>
                                        <td valign="top" align="right">
											<?php if($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')){
												echo currency($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
												$usd = $list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb');
											}else echo "-";?>
                                        </td>
                                    </tr>
                                    
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        	<tr>
                                <td colspan="3"></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_idr);?></font></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_usd);?></font></td>
                        	</tr>
					<?php }else{?>
                   	 	<?php if($pending_payment_dashboard)foreach($pending_payment_dashboard as $list){
								$idr = 0;$usd=0;
                                if($list['pgi_bast']!=0000-00-00 && $list['name']!='' && (($list['pgi_total'] - find_2_total('sum(dp_idr) as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1) || ($list['total_2'] - find_2_total('sum(dp_usd) as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1))){?>
                                	
                                    <tr <?php if(strtotime(date("Y-m-d")) > strtotime('+1 month',strtotime($list['pgi_bast']))){ ?> style="color:#F00" <?php }?>>
                                    	<td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php echo date("d/m/Y",strtotime($list['pgi_bast']))?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total'] - find_2_total('sum(dp_idr) as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')!=0){
												echo currency($list['pgi_total'] - find_2_total('sum(dp_idr) as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
												$idr = $list['pgi_total'] - find_2_total('sum(dp_idr) as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb');
											}else echo "-";?>
                                        </td>
                                        <td valign="top" align="right">
											<?php if($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')){
												echo currency($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
												$usd = $list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb');
											}else echo "-";?>
                                        </td>
                                    </tr>
                                    
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        	<tr>
                                <td colspan="3"></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_idr);?></font></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_usd);?></font></td>
                        	</tr>
                    <?php }?>
                </table>
                <hr size="1" />
            <?php }?>   
    	</td>
        <td>&nbsp;</td>
        <td valign="top" style="width:50%">
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder_2","privilege_tb")){?>
    			<b>&bull; Today's reminder <?php echo date("d/m/Y");?></b>
				<?php if($reminder_today){?>
                <table class="form" style="width:100%; color:#000">
                    <thead>
                        
                        <th>Description</th>
                        
                        <th width="7%">Deadline</th>
                        <th width="10%">Department</th>
                    </thead>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder_2","privilege_tb")){?>
                                <?php foreach($reminder_today as $list){
                                        if($list['department_id']==find('department_id',$this->session->userdata('employee_id'),'employee_tb')){?>
                                            <tr>
                                                
                                                <td valign="top"><?php echo nl2br($list['description'])?></td>
                                                
                                                <td valign="top" align="center">
                                                    <?php if($list['date_deadline']<=date("Y-m-d")){?><font color="#FF0000"><?php }?>
                                                        <?php echo date("d/m/Y",strtotime($list['date_deadline']))?>
                                                    </font>
                                                </td>
                                                <td valign="top" align="center"><?php echo find('name',$list['department_id'],'department_tb');?></td>
                                            </tr>
                                <?php }
                                }
                    }elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder","privilege_tb")){
                             foreach($reminder_today as $list){?>
                                <tr>
                                    
                                    <td valign="top"><?php echo nl2br($list['description'])?></td>
                                    
                                    <td valign="top" align="center">
                                        <?php if($list['date_deadline']<=date("Y-m-d")){?><font color="#FF0000"><?php }?>
                                            <?php echo date("d/m/Y",strtotime($list['date_deadline']))?>
                                        </font>
                                    </td>
                                    <td valign="top" align="center"><?php echo find('name',$list['department_id'],'department_tb');?></td>
                                </tr>
                                <?php
                              }
                    }?>
                </table>
                <?php }else echo "&raquo; There is no reminders today";?>
                <hr size="1" />
            <?php }?>
            
            <?php  $total_idr = 0; $total_usd=0; $idr = 0;$usd=0;?>
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
            	<b>&raquo; Project Win</b>
                <table class="form" style="width:100%">
                	<thead>
                    	<th>Project</th>
                        <th>Invoice</th>
                        <th>Deadline</th>
                        <th>IDR</th>
                        <th>USD</th>
                    </thead>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
						<?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
                                $idr = 0; $usd = 0;
								if($list['employee_id']==$this->session->userdata['employee_id'] && $list['review_date']!=0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr<?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['pgi_total']); 
														$idr = $list['pgi_total'];
													}else{
														echo currency($list['pgi_total']*10/11); 
														$idr = $list['pgi_total']*10/11;
													}
											}else echo "-";?></td>
                                        <td valign="top" align="right">
											<?php if($list['total_2']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['total_2']);
														$usd = $list['total_2'];
													}else{
														echo currency($list['total_2']*10/11);
														$usd = $list['total_2']*10/11;
													}
											}else echo "-";?></td>
                                    </tr>
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        <?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
								$usd = 0; $idr = 0;
								if($list['employee_id']==$this->session->userdata['employee_id'] && $list['review_date']==0000-00-00&& $list['pgi_bast']==0000-00-00){?>
                                    <tr<?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['pgi_total']); 
														$idr = $list['pgi_total'];
													}else{
														echo currency($list['pgi_total']*10/11); 
														$idr = $list['pgi_total']*10/11;
													}
											}else echo "-";?></td>
                                        <td valign="top" align="right">
											<?php if($list['total_2']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['total_2']);
														$usd = $list['total_2'];
													}else{
														echo currency($list['total_2']*10/11);
														$usd = $list['total_2']*10/11;
													}
											}else echo "-";?></td>
                                    </tr>
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        	<tr>
                                <td colspan="3"></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_idr);?></font></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_usd);?></font></td>
                        	</tr>
					<?php }else{?>
                   	 	<?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
								$idr = 0; $usd = 0;
                                if($list['review_date']!=0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr <?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['pgi_total']); 
														$idr = $list['pgi_total'];
													}else{
														echo currency($list['pgi_total']*10/11); 
														$idr = $list['pgi_total']*10/11;
													}
											}else echo "-";?></td>
                                        <td valign="top" align="right">
											<?php if($list['total_2']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['total_2']);
														$usd = $list['total_2'];
													}else{
														echo currency($list['total_2']*10/11);
														$usd = $list['total_2']*10/11;
													}
											}else echo "-";?></td>
                                    </tr>
							<?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
                            }?>
                            <?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
								$usd = 0; $idr = 0;
                                if($list['review_date']==0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr <?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['pgi_total']); 
														$idr = $list['pgi_total'];
													}else{
														echo currency($list['pgi_total']*10/11); 
														$idr = $list['pgi_total']*10/11;
													}
											}else echo "-";?></td>
                                        <td valign="top" align="right">
											<?php if($list['total_2']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['total_2']);
														$usd = $list['total_2'];
													}else{
														echo currency($list['total_2']*10/11);
														$usd = $list['total_2']*10/11;
													}
											}else echo "-";?></td>
                                    </tr>
							<?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
                            }?>
                            <tr>
                                <td colspan="3"></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_idr);?></font></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_usd);?></font></td>
                        	</tr>
						<?php }?>
                </table>
                <hr size="1" />
            <?php }?>
        </td>
	</tr>    
</table>
<?php }elseif($x==3){?>
<table width="100%">
	<tr>
    	<td valign="top" width="25%">
        	<?php 	if(date("N")==1)$z=1;
					elseif(date("N")==2)$z=1;
					elseif(date("N")==3)$z=1;
					elseif(date("N")==4)$z=1;
					elseif(date("N")==5)$z=1;
					elseif(date("N")==6)$z=1;
					elseif(date("N")==7)$z=1;?>
                   
            <?php if($this->session->userdata('employee_id')!=0){?>
        	<b>&raquo; Schedule</b>
        	<table class="form" style="width:100%;">
            	<tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z-1).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z-1).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d') && $list['employee_id']==$this->session->userdata['employee_id']){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+1).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+1).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+2 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+2).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+2).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+3 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+3).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+3).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+4 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td width="20%" valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+4).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+4).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+5 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
            </table>
            <hr size="1" />
            <?php }?>
            <?php if($this->session->userdata('employee_id')!=0){?>
            	<b>&raquo; Activity</b>
                <table class="form" style="width:100%">
                	<thead>
                    	<th>Date</th>
                        <th>Now</th>
                        <th>Next</th>
                    </thead>
                    <?php if($activity_dashboard)foreach($activity_dashboard as $list){
							if($list['employee_id']==$this->session->userdata['employee_id']){?>
                                <tr>
                                    <td width="10%" valign="top"><?php echo date("d/m/Y",strtotime($list['activity_date']))?></td>
                                    <td><?php echo nl2br($list['description'])?></td>
                                    <td><?php echo nl2br($list['plan_tomorrow'])?></td>
                                </tr>
                    <?php }
					}?>
                </table>
                <hr size="1" />
            <?php }?>
            
            <b>&raquo; HRD</b>
            <table class="form" style="width:100%; color:#000">
            	<thead>
                	<th width="40%">Year</th>
                    <th width="30%">In</th>
                    <th width="30%">Out</th>
                </thead>
                <?php if($employee_year)foreach($employee_year as $list){?>
                <tr>
                	<td valign="top" align="center"><?php echo $list['join_year']?></td>
                    <td valign="top" align="center"><?php echo find_2_total('count(*) as total','substring(join_date,1,4)',$list['join_year'],'employee_tb');?></td>
                    <td valign="top" align="center"><?php echo find_2_total('count(*) as total','substring(out_date,1,4)',$list['join_year'],'employee_tb');?></td>
                </tr>
                <?php }?>
            </table>
            
            <hr size="1" />
            <b>&raquo; Inventory</b>
            <table class="form" style="width:100%; color:#000">
            	<thead>
                	<th>Inventory</th>
                    <th width="10%">Checkdate</th>
                </thead>
                <?php if($inventory_list)foreach($inventory_list as $list){?>
                <tr>
                	<td valign="top"><?php echo $list['name']?></td>
                    <td valign="top" align="center"><?php echo date('d/m/Y',strtotime($list['check_date']));?></td>
                </tr>
                <?php }?>
            </table>
            <hr size="1" />
            
            <b>&raquo; Vendor</b>
            <table class="form" style="width:100%; color:#000">
            	<thead>
                	<th>Name</th>
                    <th width="40%">Last Visit</th>
                </thead>
                <?php if($vendor_list)foreach($vendor_list as $list){?>
                <tr>
                	<td valign="top"><?php echo find('name',$list['vendor_id'],'vendor_tb')?></td>
                    <td valign="top" align="center"><?php echo date('d/m/Y',strtotime($list['last_visit']));?></td>
                </tr>
                <?php }?>
            </table>
            <hr size="1" />
        </td>
        <td>&nbsp;</td>
    	<td valign="top" width="50%">
        	<?php if($this->session->userdata('employee_id')!=0){?>
            	<b>&raquo; Job Tracking</b>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking_2","privilege_tb")){?>
                    <table class="form" style="width:100%">
                        <thead>
                            <th>Deadline</th>
                            <th>Description</th>
                            <th>Approve</th>
                            <th>Status</th>
                        </thead>
                        
                        <?php if($job_tracking)foreach($job_tracking as $list){
                                if($list['assigned_to']==$this->session->userdata['employee_id']){?>
                                    <tr <?php if($list['due_date'] >= date('Y-m-d',strtotime('+0 day',strtotime(date('Y-m-d')))) && $list['due_date'] <= date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d'))))){?> style="color:#F00;" <?php }?>>
                                <td align="center" width="10%" valign="top"><?php if($list['due_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['due_date'])); else echo "-";?>
                                
                                </td>
                                <td valign="top"><a target="_blank" style="text-decoration:none; color:#000;" href="<?php echo site_url('schedule/detail_job_tracking/'.$list['id']);?>"><?php echo nl2br($list['description'])?></a></td>
                                <td valign="top" align="center">
                                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/approval_job_tracking","privilege_tb")){	?>
									<?php if($list['approval']==1){?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">Yes</a>
                                    <?php }else{?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">No</a>
                                    <?php }?>
                                <?php }else{?>
                                	<?php if($list['approval']==1){?>
                                        Yes
                                    <?php }else{?>
                                        No
                                    <?php }?>
                                <?php }?>
                                </td>
                                <td valign="top" align="center">
								<?php if($list['active']==1){?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Closed</a>
                                <?php }else{?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Open</a>
                                <?php }?>
                                </td>
                            </tr>
                            <?php }
                            }?>
                    </table>
                <?php }elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking","privilege_tb")){?>
                    <table class="form" style="width:100%">
                        <thead>
                            <th>Deadline</th>
                            <th>Description</th>
                            <th>App</th>
                            <th>Status</th>
                        </thead>
                        
                        <?php if($job_tracking)foreach($job_tracking as $list){?>
                            <tr <?php if($list['due_date'] >= date('Y-m-d',strtotime('+0 day',strtotime(date('Y-m-d')))) && $list['due_date'] <= date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d'))))){?> style="color:#F00;" <?php }?>>
                                <td align="center" width="10%" valign="top"><?php if($list['due_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['due_date'])); else echo "-";?>
                                <br />
                                <a onclick="return confirm('Send this job tracking?');" style="text-decoration:none" href="<?php echo site_url('schedule/send_job_tracking/'.$list['id']);?>">[Send]</a>
                                </td>
                                <td valign="top"><a target="_blank" style="text-decoration:none; color:#000;" href="<?php echo site_url('schedule/detail_job_tracking/'.$list['id']);?>"><?php echo nl2br($list['description'])?></a></td>
                                <td valign="top" align="center">
                                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/approval_job_tracking","privilege_tb")){	?>
									<?php if($list['approval']==1){?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">Yes</a>
                                    <?php }else{?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">No</a>
                                    <?php }?>
                                <?php }else{?>
									<?php if($list['approval']==1){?>
                                        Yes
                                    <?php }else{?>
                                        No
                                    <?php }?>
                                <?php }?>
                                </td>
                                <td valign="top" align="center">
								<?php if($list['active']==1){?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Closed</a>
                                <?php }else{?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Open</a>
                                <?php }?>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                <?php }?>
                <hr size="1" />
            <?php }?>
            <b>&raquo; Schedule Resources</b>
            <table class="form" style="width:100%">
            	<thead>
                	<th width="20%"><?php echo date('d/m')?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+1 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+2 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+3 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+4 day',strtotime(date('Y-m-d'))))?></th>
                </thead>
                <tr>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d'),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+2 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+3 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+4 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                </tr>
            </table>
            
            <table class="form" style="width:100%">
            	<thead>
                	<th width="20%"><?php echo date('d/m',strtotime('+5 day',strtotime(date('Y-m-d'))))?></th>
                	<th width="20%"><?php echo date('d/m',strtotime('+6 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+7 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+8 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+9 day',strtotime(date('Y-m-d'))))?></th>
                </thead>
                <tr>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+5 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+6 day',strtotime(date('Y-m-d')))),'schedule_to_tb')  && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d')))),'schedule_to_tb')  && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+8 day',strtotime(date('Y-m-d')))),'schedule_to_tb')  && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+9 day',strtotime(date('Y-m-d')))),'schedule_to_tb')  && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                </tr>
            </table>
            
            <table class="form" style="width:100%">
            	<thead>
                	<th width="20%"><?php echo date('d/m',strtotime('+10 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+11 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+12 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+13 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+14 day',strtotime(date('Y-m-d'))))?></th>
                </thead>
                <tr>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+10 day',strtotime(date('Y-m-d')))),'schedule_to_tb')  && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+11 day',strtotime(date('Y-m-d')))),'schedule_to_tb')  && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+12 day',strtotime(date('Y-m-d')))),'schedule_to_tb')  && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+13 day',strtotime(date('Y-m-d')))),'schedule_to_tb')  && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+14 day',strtotime(date('Y-m-d')))),'schedule_to_tb')  && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                </tr>
        </table>
    	</td>
        <td>&nbsp;</td>
        <td valign="top" style="width:50%">
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder_2","privilege_tb")){?>
    			<b>&bull; Today's reminder <?php echo date("d/m/Y");?></b>
				<?php if($reminder_today){?>
                <table class="form" style="width:100%; color:#000">
                    <thead>
                        
                        <th>Description</th>
                        
                        <th width="7%">Deadline</th>
                        <th width="10%">Department</th>
                    </thead>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder_2","privilege_tb")){?>
                                <?php foreach($reminder_today as $list){
                                        if($list['department_id']==find('department_id',$this->session->userdata('employee_id'),'employee_tb')){?>
                                            <tr>
                                                
                                                <td valign="top"><?php echo nl2br($list['description'])?></td>
                                                
                                                <td valign="top" align="center">
                                                    <?php if($list['date_deadline']<=date("Y-m-d")){?><font color="#FF0000"><?php }?>
                                                        <?php echo date("d/m/Y",strtotime($list['date_deadline']))?>
                                                    </font>
                                                </td>
                                                <td valign="top" align="center"><?php echo find('name',$list['department_id'],'department_tb');?></td>
                                            </tr>
                                <?php }
                                }
                    }elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder","privilege_tb")){
                             foreach($reminder_today as $list){?>
                                <tr>
                                    
                                    <td valign="top"><?php echo nl2br($list['description'])?></td>
                                    
                                    <td valign="top" align="center">
                                        <?php if($list['date_deadline']<=date("Y-m-d")){?><font color="#FF0000"><?php }?>
                                            <?php echo date("d/m/Y",strtotime($list['date_deadline']))?>
                                        </font>
                                    </td>
                                    <td valign="top" align="center"><?php echo find('name',$list['department_id'],'department_tb');?></td>
                                </tr>
                                <?php
                              }
                    }?>
                </table>
                <?php }else echo "&raquo; There is no reminders today";?>
                <hr size="1" />
            <?php }?>
            <?php  $total_idr = 0; $total_usd=0; $idr = 0;$usd=0;?>
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
            	<b>&raquo; Project Win</b>
                <table class="form" style="width:100%">
                	<thead>
                    	<th>Project</th>
                        <th>Invoice</th>
                        <th>Deadline</th>
                    </thead>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
						<?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
                                $idr = 0; $usd = 0;
								if($list['employee_id']==$this->session->userdata['employee_id'] && $list['review_date']!=0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr<?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                    </tr>
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        
                        <?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
							$usd = 0; $idr = 0;
								if($list['employee_id']==$this->session->userdata['employee_id'] && $list['review_date']==0000-00-00&& $list['pgi_bast']==0000-00-00){?>
                                    <tr<?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                    </tr>
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        	
					<?php }else{?>
                    	<?php  $total_idr = 0; $total_usd=0; $idr = 0;$usd=0;?>
                   	 	<?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
								$idr = 0; $usd = 0;
                                if($list['review_date']!=0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr <?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                    </tr>
							<?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;
								}
                            }?>
                            <?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
                               $usd = 0; $idr = 0;  if($list['review_date']==0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr <?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                    </tr>
							<?php $total_idr = $total_idr + $idr; 
									$total_usd = $total_usd + $usd;
								}
                            }?>
                            
						<?php }?>
                </table>
                <hr size="1" />
            <?php }?>
            
            <b>&raquo; Project Not Survey</b>
            <table class="form" style="width:100%;">
            	<thead>
                	<th>Project</th>
                    <th>Invoice</th>
                </thead>
                <?php if($project_not_survey_list)foreach($project_not_survey_list as $list){
						if($list['marketing']==0 && $list['engineering']==0 && $list['support']==0 && find('project_id',$list['pg_id'],'project_goal_tb')){?>
                			<tr>
                        		<td valign="top" width="50%"><a target="_blank" style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id']);?>"><?php echo find('name',find('project_id',$list['pg_id'],'project_goal_tb'),'project_tb')?></a></td>
                            	<td valign="top"><?php echo $list['invoice']?></td>
                            </tr>
                <?php }
				}?>
            </table>
        </td>
	</tr>    
</table>
<?php }elseif($x==4){?>
<table width="100%">
	<tr>
    	<td valign="top" width="25%">
        	<?php 	if(date("N")==1)$z=1;
					elseif(date("N")==2)$z=1;
					elseif(date("N")==3)$z=1;
					elseif(date("N")==4)$z=1;
					elseif(date("N")==5)$z=1;
					elseif(date("N")==6)$z=1;
					elseif(date("N")==7)$z=1;?>
                   
            <?php if($this->session->userdata('employee_id')!=0){?>
        	<b>&raquo; Schedule</b>
        	<table class="form" style="width:100%;">
            	<tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z-1).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z-1).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d') && $list['employee_id']==$this->session->userdata['employee_id']){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+1).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+1).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+2 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+2).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+2).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+3 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+3).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+3).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+4 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td width="20%" valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+4).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+4).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+5 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
            </table>
            <hr size="1" />
            <?php }?>
            <?php if($this->session->userdata('employee_id')!=0){?>
            	<b>&raquo; Activity</b>
                <table class="form" style="width:100%">
                	<thead>
                    	<th>Date</th>
                        <th>Now</th>
                        <th>Next</th>
                    </thead>
                    <?php if($activity_dashboard)foreach($activity_dashboard as $list){
							if($list['employee_id']==$this->session->userdata['employee_id']){?>
                                <tr>
                                    <td width="10%" valign="top"><?php echo date("d/m/Y",strtotime($list['activity_date']))?></td>
                                    <td><?php echo nl2br($list['description'])?></td>
                                    <td><?php echo nl2br($list['plan_tomorrow'])?></td>
                                </tr>
                    <?php }
					}?>
                </table>
                <hr size="1" />
            <?php }?>
        </td>
        <td>&nbsp;</td>
    	<td valign="top" width="50%">
        	<?php if($this->session->userdata('employee_id')!=0){?>
            	<b>&raquo; Job Tracking</b>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking_2","privilege_tb")){?>
                    <table class="form" style="width:100%">
                        <thead>
                            <th>Deadline</th>
                            <th>Description</th>
                            <th>Approve</th>
                            <th>Status</th>
                        </thead>
                        
                        <?php if($job_tracking)foreach($job_tracking as $list){
                                if($list['assigned_to']==$this->session->userdata['employee_id']){?>
                                    <tr <?php if($list['due_date'] >= date('Y-m-d',strtotime('+0 day',strtotime(date('Y-m-d')))) && $list['due_date'] <= date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d'))))){?> style="color:#F00;" <?php }?>>
                                <td align="center" width="10%" valign="top"><?php if($list['due_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['due_date'])); else echo "-";?>
                                
                                </td>
                                <td valign="top"><a target="_blank" style="text-decoration:none; color:#000;" href="<?php echo site_url('schedule/detail_job_tracking/'.$list['id']);?>"><?php echo nl2br($list['description'])?></a></td>
                                <td valign="top" align="center">
                                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/approval_job_tracking","privilege_tb")){	?>
									<?php if($list['approval']==1){?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">Yes</a>
                                    <?php }else{?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">No</a>
                                    <?php }?>
                                <?php }else{?>
                                	<?php if($list['approval']==1){?>
                                        Yes
                                    <?php }else{?>
                                        No
                                    <?php }?>
                                <?php }?>
                                </td>
                                <td valign="top" align="center">
								<?php if($list['active']==1){?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Closed</a>
                                <?php }else{?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Open</a>
                                <?php }?>
                                </td>
                            </tr>
                            <?php }
                            }?>
                    </table>
                <?php }elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking","privilege_tb")){?>
                    <table class="form" style="width:100%">
                        <thead>

                            <th>Deadline</th>
                            <th>Description</th>
                            <th>App</th>
                            <th>Status</th>
                        </thead>
                        
                        <?php if($job_tracking)foreach($job_tracking as $list){?>
                            <tr <?php if($list['due_date'] >= date('Y-m-d',strtotime('+0 day',strtotime(date('Y-m-d')))) && $list['due_date'] <= date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d'))))){?> style="color:#F00;" <?php }?>>
                                <td align="center" width="10%" valign="top"><?php if($list['due_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['due_date'])); else echo "-";?>
                                <br />
                                <a onclick="return confirm('Send this job tracking?');" style="text-decoration:none" href="<?php echo site_url('schedule/send_job_tracking/'.$list['id']);?>">[Send]</a>
                                </td>
                                <td valign="top"><a target="_blank" style="text-decoration:none; color:#000;" href="<?php echo site_url('schedule/detail_job_tracking/'.$list['id']);?>"><?php echo nl2br($list['description'])?></a></td>
                                <td valign="top" align="center">
                                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/approval_job_tracking","privilege_tb")){	?>
									<?php if($list['approval']==1){?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">Yes</a>
                                    <?php }else{?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">No</a>
                                    <?php }?>
                                <?php }else{?>
									<?php if($list['approval']==1){?>
                                        Yes
                                    <?php }else{?>
                                        No
                                    <?php }?>
                                <?php }?>
                                </td>
                                <td valign="top" align="center">
								<?php if($list['active']==1){?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Closed</a>
                                <?php }else{?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Open</a>
                                <?php }?>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                <?php }?>
                <hr size="1" />
            <?php }?>
            
            <b>&raquo; Schedule Resources</b>
            <table class="form" style="width:100%">
            	<thead>
                	<th width="20%"><?php echo date('d/m')?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+1 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+2 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+3 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+4 day',strtotime(date('Y-m-d'))))?></th>
                </thead>
                <tr>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d'),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+2 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+3 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+4 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                </tr>
            </table>
            
            <table class="form" style="width:100%">
            	<thead>
                	<th width="20%"><?php echo date('d/m',strtotime('+5 day',strtotime(date('Y-m-d'))))?></th>
                	<th width="20%"><?php echo date('d/m',strtotime('+6 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+7 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+8 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+9 day',strtotime(date('Y-m-d'))))?></th>
                </thead>
                <tr>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+5 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+6 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+8 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+9 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                </tr>
            </table>
            
            <table class="form" style="width:100%">
            	<thead>
                	<th width="20%"><?php echo date('d/m',strtotime('+10 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+11 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+12 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+13 day',strtotime(date('Y-m-d'))))?></th>
                    <th width="20%"><?php echo date('d/m',strtotime('+14 day',strtotime(date('Y-m-d'))))?></th>
                </thead>
                <tr>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+10 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+11 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+12 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+13 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                    <td valign="top">
                        <?php if($employee_active)foreach($employee_active as $list){
								if(!find_4_string('id','employee_id',$list['id'],'activity_date',date('Y-m-d',strtotime('+14 day',strtotime(date('Y-m-d')))),'schedule_to_tb') && ($list['department_id']==1 || $list['department_id']==2)){
                        			echo $list['firstname']."<br />";			
                        	}
						}?>
                    </td>
                </tr>
        	</table>
            <hr size="1" />
    	</td>
        <td>&nbsp;</td>
        <td valign="top" style="width:50%">
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder_2","privilege_tb")){?>
    			<b>&bull; Today's reminder <?php echo date("d/m/Y");?></b>
				<?php if($reminder_today){?>
                <table class="form" style="width:100%; color:#000">
                    <thead>
                        
                        <th>Description</th>
                        
                        <th width="7%">Deadline</th>
                        <th width="10%">Department</th>
                    </thead>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder_2","privilege_tb")){?>
                                <?php foreach($reminder_today as $list){
                                        if($list['department_id']==find('department_id',$this->session->userdata('employee_id'),'employee_tb')){?>
                                            <tr>
                                                
                                                <td valign="top"><?php echo nl2br($list['description'])?></td>
                                                
                                                <td valign="top" align="center">
                                                    <?php if($list['date_deadline']<=date("Y-m-d")){?><font color="#FF0000"><?php }?>
                                                        <?php echo date("d/m/Y",strtotime($list['date_deadline']))?>
                                                    </font>
                                                </td>
                                                <td valign="top" align="center"><?php echo find('name',$list['department_id'],'department_tb');?></td>
                                            </tr>
                                <?php }
                                }
                    }elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder","privilege_tb")){
                             foreach($reminder_today as $list){?>
                                <tr>
                                    
                                    <td valign="top"><?php echo nl2br($list['description'])?></td>
                                    
                                    <td valign="top" align="center">
                                        <?php if($list['date_deadline']<=date("Y-m-d")){?><font color="#FF0000"><?php }?>
                                            <?php echo date("d/m/Y",strtotime($list['date_deadline']))?>
                                        </font>
                                    </td>
                                    <td valign="top" align="center"><?php echo find('name',$list['department_id'],'department_tb');?></td>
                                </tr>
                                <?php
                              }
                    }?>
                </table>
                <?php }else echo "&raquo; There is no reminders today";?>
                <hr size="1" />
            <?php }?>
            <?php  $total_idr = 0; $total_usd=0; $idr = 0;$usd=0;?>
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
            	<b>&raquo; Project Win</b>
                <table class="form" style="width:100%">
                	<thead>
                    	<th>Project</th>
                        <th>Invoice</th>
                        <th>Deadline</th>
                    </thead>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
						<?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
                                $idr = 0; $usd = 0;
								if($list['employee_id']==$this->session->userdata['employee_id'] && $list['review_date']!=0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr<?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                    </tr>
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        
                        <?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
							$usd = 0; $idr = 0;
								if($list['employee_id']==$this->session->userdata['employee_id'] && $list['review_date']==0000-00-00&& $list['pgi_bast']==0000-00-00){?>
                                    <tr<?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                    </tr>
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
					<?php }else{?>
                    	<?php  $total_idr = 0; $total_usd=0; $idr = 0;$usd=0;?>
                   	 	<?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
								$idr = 0; $usd = 0;
                                if($list['review_date']!=0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr <?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                    </tr>
							<?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;
								}
                            }?>
                            <?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
                               $usd = 0; $idr = 0;  if($list['review_date']==0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr <?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                    </tr>
							<?php $total_idr = $total_idr + $idr; 
									$total_usd = $total_usd + $usd;
								}
                            }?>
                            
						<?php }?>
                </table>
                <hr size="1" />
            <?php }?>
        </td>
	</tr>    
</table>
<?php }elseif($x==5){?>
	<table width="100%">
	<tr>
    	<td valign="top" width="25%">
        	<?php 	if(date("N")==1)$z=1;
					elseif(date("N")==2)$z=1;
					elseif(date("N")==3)$z=1;
					elseif(date("N")==4)$z=1;
					elseif(date("N")==5)$z=1;
					elseif(date("N")==6)$z=1;
					elseif(date("N")==7)$z=1;?>
                   
            <?php if($this->session->userdata('employee_id')!=0){?>
        	<b>&raquo; Schedule</b>
        	<table class="form" style="width:100%;">
            	<tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z-1).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z-1).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d') && $list['employee_id']==$this->session->userdata['employee_id']){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+1).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+1).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+2 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+2).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+2).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+3 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+3).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+3).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+4 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
                <tr>
                	<td width="20%" valign="top"><?php echo date("D d/m/Y",strtotime('+'.($z+4).' day',strtotime(date('Y-m-d'))));?></td>
                    <td valign="top"><?php echo find_4_string('description','date_now',date("Y-m-d",strtotime('+'.($z+4).' day',strtotime(date('Y-m-d')))),'employee_id',$this->session->userdata('employee_id'),'schedule_tb')?>
                    
                    <?php 
					if($schedule_to_list)foreach($schedule_to_list as $list){
						if($list['activity_date']==date('Y-m-d',strtotime('+5 day',strtotime(date('Y-m-d')))) && $list['employee_id']==$this->session->userdata['employee_id'] ){
							echo "<br />- ".$list['description'];	
						}
					}?>
                    </td>
                </tr>
            </table>
            <hr size="1" />
            <?php }?>
            <?php if($this->session->userdata('employee_id')!=0){?>
            	<b>&raquo; Activity</b>
                <table class="form" style="width:100%">
                	<thead>
                    	<th>Date</th>
                        <th>Now</th>
                        <th>Next</th>
                    </thead>
                    <?php if($activity_dashboard)foreach($activity_dashboard as $list){
							if($list['employee_id']==$this->session->userdata['employee_id']){?>
                                <tr>
                                    <td width="10%" valign="top"><?php echo date("d/m/Y",strtotime($list['activity_date']))?></td>
                                    <td><?php echo nl2br($list['description'])?></td>
                                    <td><?php echo nl2br($list['plan_tomorrow'])?></td>
                                </tr>
                    <?php }
					}?>
                </table>
                <hr size="1" />
            <?php }?>
            <?php if($this->session->userdata('employee_id')!=0){?>
            	<b>&raquo; Job Tracking</b>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking_2","privilege_tb")){?>
                    <table class="form" style="width:100%">
                        <thead>
                            <th>Deadline</th>
                            <th>Description</th>
                            <th>Approve</th>
                            <th>Status</th>
                        </thead>
                        
                        <?php if($job_tracking)foreach($job_tracking as $list){
                                if($list['assigned_to']==$this->session->userdata['employee_id']){?>
                                    <tr <?php if($list['due_date'] >= date('Y-m-d',strtotime('+0 day',strtotime(date('Y-m-d')))) && $list['due_date'] <= date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d'))))){?> style="color:#F00;" <?php }?>>
                                        <td align="center" width="10%" valign="top"><?php if($list['due_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['due_date'])); else echo "-";?>
                                        </td>
                                        <td valign="top"><a target="_blank" style="text-decoration:none; color:#000;" href="<?php echo site_url('schedule/detail_job_tracking/'.$list['id']);?>"><?php echo nl2br($list['description'])?></a></td>
                                        <td valign="top" align="center">
                                        <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/approval_job_tracking","privilege_tb")){	?>
                                            <?php if($list['approval']==1){?>
                                                <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">Yes</a>
                                            <?php }else{?>
                                                <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">No</a>
                                            <?php }?>
                                        <?php }else{?>
                                            <?php if($list['approval']==1){?>
                                                Yes
                                            <?php }else{?>
                                                No
                                            <?php }?>
                                        <?php }?>
                                        </td>
                                        <td valign="top" align="center">
                                        <?php if($list['active']==1){?>
                                            <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Closed</a>
                                        <?php }else{?>
                                            <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Open</a>
                                        <?php }?>
                                        </td>
                                    </tr>
                            <?php }
                            }?>
                    </table>
                <?php }elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking","privilege_tb")){?>
                    <table class="form" style="width:100%">
                        <thead>
                            <th>Deadline</th>
                            <th>Description</th>
                            <th>App</th>
                            <th>Status</th>
                        </thead>
                        
                        <?php if($job_tracking)foreach($job_tracking as $list){?>
                            <tr  <?php if($list['due_date'] >= date('Y-m-d',strtotime('+0 day',strtotime(date('Y-m-d')))) && $list['due_date'] <= date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d'))))){?> style="color:#F00;" <?php }?>>
                                <td align="center" width="10%" valign="top"><?php if($list['due_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['due_date'])); else echo "-";?>
                                <a onclick="return confirm('Send this job tracking?');" style="text-decoration:none" href="<?php echo site_url('schedule/send_job_tracking/'.$list['id']);?>">[Send]</a>
                                </td>
                                <td valign="top"><a target="_blank" style="text-decoration:none; color:#000;" href="<?php echo site_url('schedule/detail_job_tracking/'.$list['id']);?>"><?php echo nl2br($list['description'])?></a></td>
                                <td valign="top" align="center">
                                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/approval_job_tracking","privilege_tb")){	?>
									<?php if($list['approval']==1){?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">Yes</a>
                                    <?php }else{?>
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/approval_job_tracking/'.$list['id'].'/'.$list['approval'])?>">No</a>
                                    <?php }?>
                                <?php }else{?>
									<?php if($list['approval']==1){?>
                                        Yes
                                    <?php }else{?>
                                        No
                                    <?php }?>
                                <?php }?>
                                </td>
                                <td valign="top" align="center">
								<?php if($list['active']==1){?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Closed</a>
                                <?php }else{?>
                                	<a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/active_job_tracking/'.$list['id'].'/'.$list['active'])?>">Open</a>
                                <?php }?>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                <?php }?>
                <hr size="1" />
            <?php }?>
        </td>
        <td>&nbsp;</td>
    	<td valign="top" width="50%">
        	<b>&raquo; CRM</b>
            <table class="form" style="width:100%">
            	<thead>
                	<th width="40%">Marketing</th>
                    <th width="30%">Project</th>
                    <th width="30%">Amount</th>
                </thead>
                <tr>
                	<td colspan="3"><b>Potential</b></td>
                </tr>
                <?php if($employee_active)foreach($employee_active as $list){
						if($list['department_id']==4){?>
                            <tr>
                                <td valign="top" align="right"><?php echo $list['firstname']." ".$list['lastname']?></td>
                                <td valign="top" align="right"><a target="_blank" style="text-decoration:none; color:#000;" href="<?php echo site_url('home/crm_list/'.$list['id'].'/1')?>"><?php echo find_5('count(*)as total','employee_id',$list['id'],'sales_stage',1,'project_tb')?></a></td>
                                <td valign="top" align="right"><?php echo money(find_5('sum(amount)as total','employee_id',$list['id'],'sales_stage',1,'project_tb'))?></td>
                            </tr>
                <?php }
				}?>
                <tr>
                	<td colspan="3"><b>Quotation</b></td>
                </tr>
                <?php if($employee_active)foreach($employee_active as $list){
						if($list['department_id']==4){?>
                            <tr>
                                <td valign="top" align="right"><?php echo $list['firstname']." ".$list['lastname']?></td>
                                <td valign="top" align="right"><a target="_blank" style="text-decoration:none; color:#000;" href="<?php echo site_url('home/crm_list/'.$list['id'].'/2')?>"><?php echo find_5('count(*)as total','employee_id',$list['id'],'sales_stage',2,'project_tb')?></a></td>
                                <td valign="top" align="right"><?php echo money(find_5('sum(amount)as total','employee_id',$list['id'],'sales_stage',2,'project_tb'))?></td>
                            </tr>
                <?php }
				}?>
                <tr>
                	<td colspan="3"><b>Tender / Review</b></td>
                </tr>
                <?php if($employee_active)foreach($employee_active as $list){
						if($list['department_id']==4){?>
                            <tr>
                                <td valign="top" align="right"><?php echo $list['firstname']." ".$list['lastname']?></td>
                                <td valign="top" align="right"><a target="_blank" style="text-decoration:none; color:#000;" href="<?php echo site_url('home/crm_list/'.$list['id'].'/3')?>"><?php echo find_5('count(*)as total','employee_id',$list['id'],'sales_stage',3,'project_tb')?></a></td>
                                <td valign="top" align="right"><?php echo money(find_5('sum(amount)as total','employee_id',$list['id'],'sales_stage',3,'project_tb'))?></td>
                            </tr>
                <?php }
				}?>
            </table>
            <hr size="1" />
            
            <b>Statistic</b>
            <table class="form" style="width:100%; color:#000">
            	<tr>
                	<td colspan="5"><b>Average day in project</b></td>
                </tr>
                <tr>
                	<td>Year</td>
                    <td>Q1</td>
                    <td>Q2</td>
                    <td>Q3</td>
                    <td>Q4</td>
                </tr>
                <tr>
                	<td valign="top"></td>
                    <td valign="top"></td>
                    <td valign="top"></td>
                    <td valign="top"></td>
                    <td valign="top"></td>
                </tr>
            </table>
            <hr size="1" />
            <b>&raquo; Lesson Learn</b>
            <table class="form" style="width:100%; color:#000">
            	<thead>
                	<th width="20%">Department</th>
                    <th width="80%">Title</th>
                    <th width="20%">Date</th>
                </thead>
                <tbody>
                	<?php if($lesson_learn_list)foreach($lesson_learn_list as $list){?>
                	<tr>
                    	<td valign="top" align="center"><?php echo find('name',$list['department_id'],'department_tb')?></td>
                        <td valign="top"><a target="_blank" href="<?php echo site_url('lesson_learn/detail_lesson_learn/'.$list['id']); ?>" style="text-decoration:none; color:#000"><?php echo $list['name']?></a></td>
                        <td valign="top" align="center"><?php echo date('d/m/Y',strtotime($list['input_date']));?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
    	</td>
        <td>&nbsp;</td>
        <td valign="top" style="width:50%">
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder_2","privilege_tb")){?>
    			<b>&bull; Today's reminder <?php echo date("d/m/Y");?></b>
				<?php if($reminder_today){?>
                <table class="form" style="width:100%; color:#000">
                    <thead>
                        
                        <th>Description</th>
                        
                        <th width="7%">Deadline</th>
                        <th width="10%">Department</th>
                    </thead>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder_2","privilege_tb")){?>
                                <?php foreach($reminder_today as $list){
                                        if($list['department_id']==find('department_id',$this->session->userdata('employee_id'),'employee_tb')){?>
                                            <tr>
                                                
                                                <td valign="top"><?php echo nl2br($list['description'])?></td>
                                                
                                                <td valign="top" align="center">
                                                    <?php if($list['date_deadline']<=date("Y-m-d")){?><font color="#FF0000"><?php }?>
                                                        <?php echo date("d/m/Y",strtotime($list['date_deadline']))?>
                                                    </font>
                                                </td>
                                                <td valign="top" align="center"><?php echo find('name',$list['department_id'],'department_tb');?></td>
                                            </tr>
                                <?php }
                                }
                    }elseif(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder","privilege_tb")){
                             foreach($reminder_today as $list){?>
                                <tr>
                                    
                                    <td valign="top"><?php echo nl2br($list['description'])?></td>
                                    
                                    <td valign="top" align="center">
                                        <?php if($list['date_deadline']<=date("Y-m-d")){?><font color="#FF0000"><?php }?>
                                            <?php echo date("d/m/Y",strtotime($list['date_deadline']))?>
                                        </font>
                                    </td>
                                    <td valign="top" align="center"><?php echo find('name',$list['department_id'],'department_tb');?></td>
                                </tr>
                                <?php
                              }
                    }?>
                </table>
                <?php }else echo "&raquo; There is no reminders today";?>
                <hr size="1" />
            <?php }?>
            
            <?php //if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
            	<b>&raquo; Quarter Goal</b>
                <table class="form" style="width:100%; color:#000">
                	<thead>
                    	<th width="40%">Marketing</th>
                        <th width="30%">IDR</th>
                        <th width="30%">USD</th>
                    </thead>
                    <tbody>
                    	<?php if($employee_active)foreach($employee_active as $list){
								if($list['department_id']==4){?>
                                    <tr>
                                        <td valign="top">
										<a href="<?php echo site_url('home/goal_quarter_list/'.$list['id']);?>" style="text-decoration:none; color:#000" target="_blank">
											<?php echo $list['firstname']." ".$list['lastname']?>
                                        </a>
                                        </td>
                                        <td valign="top" align="right">
                                        <?php if($amount_goal_quarter)foreach($amount_goal_quarter as $row){
												if($row['employee_id']==$list['id']){
													if($row['total_1']){
														echo money($row['total_1']);
													}else{
														echo "";	
													}
												}
										}?>
                                        </td>
                                        <td valign="top" align="right">
                                        <?php if($amount_goal_quarter)foreach($amount_goal_quarter as $row){
												if($row['employee_id']==$list['id']){
													if($row['total_2']){
														echo currency($row['total_2']);
													}else{
														echo "";	
													}
												}
										}?>
                                        </td>
                                    <tr>
                        <?php }
						}?>
                    </tbody>
                </table>
                <hr size="1" />
            <?php //}?>
            <?php  $total_idr = 0; $total_usd=0; $idr = 0;$usd=0;?>
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
            	<b>&raquo; Project Win</b>
                <table class="form" style="width:100%">
                	<thead>
                    	<th>Project</th>
                        <th>Invoice</th>
                        <th>Deadline</th>
                        <th>IDR</th>
                        <th>USD</th>
                    </thead>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
						<?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
                                $idr = 0; $usd = 0;
								if($list['employee_id']==$this->session->userdata['employee_id'] && $list['review_date']!=0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr<?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['pgi_total']); 
														$idr = $list['pgi_total'];
													}else{
														echo currency($list['pgi_total']*10/11); 
														$idr = $list['pgi_total']*10/11;
													}
											}else echo "-";?></td>
                                        <td valign="top" align="right">
											<?php if($list['total_2']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['total_2']);
														$usd = $list['total_2'];
													}else{
														echo currency($list['total_2']*10/11);
														$usd = $list['total_2']*10/11;
													}
											}else echo "-";?></td>
                                    </tr>
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        
                        <?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
							$usd = 0; $idr = 0;
								if($list['employee_id']==$this->session->userdata['employee_id'] && $list['review_date']==0000-00-00&& $list['pgi_bast']==0000-00-00){?>
                                    <tr<?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['pgi_total']); 
														$idr = $list['pgi_total'];
													}else{
														echo currency($list['pgi_total']*10/11); 
														$idr = $list['pgi_total']*10/11;
													}
											}else echo "-";?></td>
                                        <td valign="top" align="right">
											<?php if($list['total_2']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['total_2']);
														$usd = $list['total_2'];
													}else{
														echo currency($list['total_2']*10/11);
														$usd = $list['total_2']*10/11;
													}
											}else echo "-";?></td>
                                    </tr>
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        	<tr>
                                <td colspan="3"></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_idr);?></font></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_usd);?></font></td>
                        	</tr>
					<?php }else{?>
                    	<?php  $total_idr = 0; $total_usd=0; $idr = 0;$usd=0;?>
                   	 	<?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
								$idr = 0; $usd = 0;
                                if($list['review_date']!=0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr <?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['pgi_total']); 
														$idr = $list['pgi_total'];
													}else{
														echo currency($list['pgi_total']*10/11); 
														$idr = $list['pgi_total']*10/11;
													}
											}else echo "-";?></td>
                                        <td valign="top" align="right">
											<?php if($list['total_2']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['total_2']);
														$usd = $list['total_2'];
													}else{
														echo currency($list['total_2']*10/11);
														$usd = $list['total_2']*10/11;
													}
											}else echo "-";?></td>
                                    </tr>
							<?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;
								}
                            }?>
                            <?php if($quarter_win_dashboard)foreach($quarter_win_dashboard as $list){
                               $usd = 0; $idr = 0;  if($list['review_date']==0000-00-00 && $list['pgi_bast']==0000-00-00){?>
                                    <tr <?php if(strtotime(date("Y-m-d")) >= strtotime('-13 day',strtotime($list['review_date']))){ ?> style="color:#F00" <?php }?>>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php 
															if($list['review_date']!=0000-00-00) echo date("d/m/Y",strtotime($list['review_date']));
																else echo "-";
										?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['pgi_total']); 
														$idr = $list['pgi_total'];
													}else{
														echo currency($list['pgi_total']*10/11); 
														$idr = $list['pgi_total']*10/11;
													}
											}else echo "-";?></td>
                                        <td valign="top" align="right">
											<?php if($list['total_2']!=0){
													if($list['pgi_ppn']==0){
														echo currency($list['total_2']);
														$usd = $list['total_2'];
													}else{
														echo currency($list['total_2']*10/11);
														$usd = $list['total_2']*10/11;
													}
											}else echo "-";?></td>
                                    </tr>
							<?php $total_idr = $total_idr + $idr; 
									$total_usd = $total_usd + $usd;
								}
                            }?>
                            <tr>
                                <td colspan="3"></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_idr);?></font></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_usd);?></font></td>
                        	</tr>
						<?php }?>
                </table>
                <hr size="1" />
            <?php }?>
            <?php  $total_idr = 0; $total_usd=0; $idr = 0;$usd=0;?>
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
            	<b>&raquo; Project Pending Payment</b>
                <table class="form" style="width:100%">
                	<thead>
                    	<th>Project</th>
                        <th>Invoice</th>
                        <th>BAST</th>
                        <th>Outstanding IDR</th>
                        <th>Outstanding USD</th>
                    </thead>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
						<?php if($pending_payment_dashboard)foreach($pending_payment_dashboard as $list){
							$idr = 0;$usd = 0;
                                if($list['pgi_bast']!=0000-00-00 && $list['name']!='' && (($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1) || ($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1)) && $list['employee_id']==$this->session->userdata['employee_id']){?>
                                	
                                    <tr <?php if(strtotime(date("Y-m-d")) > strtotime('+1 month',strtotime($list['pgi_bast']))){ ?> style="color:#F00" <?php }?>>
                                    	<td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php echo date("d/m/Y",strtotime($list['pgi_bast']))?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')!=0){
												echo currency($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
												$idr = $list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb');
											}else echo "-";?>
                                        </td>
                                        <td valign="top" align="right">
											<?php if($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')){
												echo currency($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
												$usd = $list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb');
											}else echo "-";?>
                                        </td>
                                    </tr>
                                    
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        	<tr>
                                <td colspan="3"></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_idr);?></font></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_usd);?></font></td>
                        	</tr>
					<?php }else{?>
                   	 	<?php if($pending_payment_dashboard)foreach($pending_payment_dashboard as $list){
								$idr = 0;$usd=0;
                                if($list['pgi_bast']!=0000-00-00 && $list['name']!='' && (($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1) || ($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1))){?>
                                	
                                    <tr <?php if(strtotime(date("Y-m-d")) > strtotime('+1 month',strtotime($list['pgi_bast']))){ ?> style="color:#F00" <?php }?>>
                                    	<td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id'])?>" target="_blank"><?php echo $list['name']?></a></td>
                                        <td valign="top"><?php echo $list['pgi_invoice']?></td>
                                        <td valign="top"><?php echo date("d/m/Y",strtotime($list['pgi_bast']))?></td>
                                        <td valign="top" align="right">
											<?php if($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')!=0){
												echo currency($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
												$idr = $list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb');
											}else echo "-";?>
                                        </td>
                                        <td valign="top" align="right">
											<?php if($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')){
												echo currency($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb'));
												$usd = $list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb');
											}else echo "-";?>
                                        </td>
                                    </tr>
                                    
                        <?php $total_idr = $total_idr + $idr; $total_usd = $total_usd + $usd;}
						}?>
                        	<tr>
                                <td colspan="3"></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_idr);?></font></td>
                                <td valign="top" align="right"><font color="#000000"><?php echo currency($total_usd);?></font></td>
                        	</tr>
                    <?php }?>
                </table>
                <hr size="1" />
            <?php }?>
        </td>
	</tr>    
</table>
<?php }?>