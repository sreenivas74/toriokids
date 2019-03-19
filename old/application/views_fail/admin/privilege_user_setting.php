<script category="text/javascript">
function enterform() {
	$(document).ready(function() {
		$("#myform").validate({
			rules : {
				name : {
					required : true
				}
			},
			messages : {
				name : " *"
			}
		});
		
		if($("#myform").validate().form() == true){
			$("#myform").submit();
			alert("Privilege User Name has been changed");
			return true;
		}
		else{
			return false;
		}
	})
}
</script>
<h2>Privilege User &raquo; Setting &raquo; <?= find("name",$this->uri->segment(3),"privilege_user_tb")?></h2>
<form name="myform" id="myform" action="<?= site_url('admin/edit_privilege_user/'.$privilege_user['id']);?>" method="post" enctype="multipart/form-data">
<table>
	<tr>
		<td>Name :</td>
        <td><input type="text" value="<?= $privilege_user['name'];?>" name="name"></td>
        <td><input type="submit" name="submit" id="submit" value="Submit" onclick="enterform();" /></td>
    </tr>
</table>
</form><br>
<form name="privilege" id="privilege" method="post" enctype="multipart/form-data" action="<?php echo site_url('admin/add_privilege_user_setting/'.$privilege_user['id']);?>">
<table class="form" style="width:100%;">
	<thead>
    	<th>Modul</th>
        <th style="text-align:center">View</th>
        <th style="text-align:center">Add</th>
        <th style="text-align:center">Edit</th>
        <th style="text-align:center">Delete</th>
        <th style="text-align:center">Detail</th>
    </thead>
    <tr>
    	<?php 	
			$absence_1 = "absence/absence_list";
			$absence_2 = "absence/salary_list";
			$absence_3 = "absence/salary_approval";
			$absence_4 = "absence/salary_edit";
        ?>
    	<td valign="top"><b>Absence</b></td>
		
       	<td align="center">
        	<table width="100%">
            	<tr align="center">
                	<td width="30%">Upload</td>
                    <td width="30%">Salary</td>
                    <td>Salary Approval</td>
               	</tr>
                <tr align="center">
                    <td><input type="checkbox" name="absence_1" value="<?php echo $absence_1?>" <?php if(find_4_string('id','module',$absence_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="absence_2" value="<?php echo $absence_2?>" <?php if(find_4_string('id','module',$absence_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="absence_3" value="<?php echo $absence_3?>" <?php if(find_4_string('id','module',$absence_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                </tr>
            </table>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	<input type="checkbox" name="absence_4" value="<?php echo $absence_4?>" <?php if(find_4_string('id','module',$absence_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    <tr>
    	<?php 	
			$ticket_1 = "ticket/ticket_list";
			$ticket_2 = "ticket/ticket_add";
			$ticket_3 = "ticket/ticket_edit";
			$ticket_4 = "ticket/ticket_delete";
        ?>
    	<td><b>Ticket</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="ticket_1" value="<?php echo $ticket_1;?>" <?php if(find_4_string('id','module',$ticket_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="ticket_2" value="<?php echo $ticket_2;?>" <?php if(find_4_string('id','module',$ticket_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="ticket_3" value="<?php echo $ticket_3;?>" <?php if(find_4_string('id','module',$ticket_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="ticket_4" value="<?php echo $ticket_4;?>" <?php if(find_4_string('id','module',$ticket_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<?php 	
			$survey_1 = "survey/survey_list";
			$survey_2 = "survey/survey_add";
			$survey_3 = "survey/survey_edit";
			$survey_4 = "survey/survey_delete";
        ?>
    	<td><b>Survey</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="survey_1" value="<?php echo $survey_1;?>" <?php if(find_4_string('id','module',$survey_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="survey_2" value="<?php echo $survey_2;?>" <?php if(find_4_string('id','module',$survey_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="survey_3" value="<?php echo $survey_3;?>" <?php if(find_4_string('id','module',$survey_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="survey_4" value="<?php echo $survey_4;?>" <?php if(find_4_string('id','module',$survey_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<td class="6"><b>Project</b></td>
    </tr>
    <tr>
		<?php 	$project_1 = "project/list_crm";
				$project_12 = "project/list_crm_2";
                $project_2 = "project/add_crm";
                $project_3 = "project/edit_crm";
                $project_4 = "project/delete_crm";
                $project_5 = "project/detail_crm";
        ?>
        <td  valign="top" style="color:#666">&raquo;&raquo; <b>CRM</b></td>
       	<td align="center">
        	<table width="100%">
            	<tr align="center">
                	<td>All</td>
                    <td>Self</td>
               	</tr>
                <tr align="center">
                    <td><input type="checkbox" name="project_1" value="<?php echo $project_1?>" <?php if(find_4_string('id','module',$project_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_12" value="<?php echo $project_12?>" <?php if(find_4_string('id','module',$project_12,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                </tr>
            </table>
        </td>
      	<td align="center">
        	<input type="checkbox" name="project_2" value="<?php echo $project_2?>" <?php if(find_4_string('id','module',$project_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="project_3" value="<?php echo $project_3?>" <?php if(find_4_string('id','module',$project_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="project_4" value="<?php echo $project_4?>" <?php if(find_4_string('id','module',$project_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="project_5" value="<?php echo $project_5?>" <?php if(find_4_string('id','module',$project_5,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
      	</td>
    </tr>
    <tr>
		<?php 	$project_13 = "project/list_project_goal";
				$project_14 = "project/list_project_goal_2";
                $project_15 = "project/edit_project_goal";
                $project_16 = "project/detail_project_goal";
				
				$project_17 = "project/view_number";
				$project_18 = "project/view_payment";
				$project_19 = "project/view_bonus";
				$project_20 = "project/view_employee_activity";
        ?>
        <td  valign="top" style="color:#666">&raquo;&raquo; <b>Project Goal</b></td>
       	<td align="center">
        	<table width="100%">
            	<tr align="center">
                	<td>All</td>
                    <td>Self</td>
                    <td>Number</td>
                    <td>Payment</td>
                    <td>Bonus</td>
                    <td>Activity</td>
               	</tr>
                <tr align="center">
                    <td><input type="checkbox" name="project_13" value="<?php echo $project_13?>" <?php if(find_4_string('id','module',$project_13,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_14" value="<?php echo $project_14?>" <?php if(find_4_string('id','module',$project_14,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_17" value="<?php echo $project_17?>" <?php if(find_4_string('id','module',$project_17,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_18" value="<?php echo $project_18?>" <?php if(find_4_string('id','module',$project_18,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_19" value="<?php echo $project_19?>" <?php if(find_4_string('id','module',$project_19,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_20" value="<?php echo $project_20?>" <?php if(find_4_string('id','module',$project_20,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                </tr>
            </table><br />
            
            <?php 
			$project_21 = 'project/view_quotation';
			$project_22 = 'project/view_po';
			$project_23 = 'project/view_request_fund';
			$project_24 = 'project/view_receive_item';
			$project_25 = 'project/view_delivery_item';
			$project_26 = 'project/view_summary';
			$project_33 = 'project/view_timeline';
			$project_36 = 'project/view_purchase_request';
			
			$project_34 = 'project/budget_approved';
			$project_35 = 'project/budget_unapproved';
			?>
            
            <table width="100%">
            	<tr align="center">
                	<td>Quotation</td>
                    <td>PO</td>
                    <td>Request Fund</td>
                    <td>Receive Item</td>
                    <td>Delivery Item</td>
                    <td>Summary</td>
                    <td>Timeline</td>
                    <td>Purchase Request</td>
                </tr>
                <tr align="center">
                	<td><input type="checkbox" name="project_21" value="<?php echo $project_21?>" <?php if(find_4_string('id','module',$project_21,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_22" value="<?php echo $project_22?>" <?php if(find_4_string('id','module',$project_22,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_23" value="<?php echo $project_23?>" <?php if(find_4_string('id','module',$project_23,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_24" value="<?php echo $project_24?>" <?php if(find_4_string('id','module',$project_24,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_25" value="<?php echo $project_25?>" <?php if(find_4_string('id','module',$project_25,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_26" value="<?php echo $project_26?>" <?php if(find_4_string('id','module',$project_26,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_33" value="<?php echo $project_33?>" <?php if(find_4_string('id','module',$project_33,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_36" value="<?php echo $project_36?>" <?php if(find_4_string('id','module',$project_36,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                </tr>
               
            </table>
            <table width="100%">
            	<tr align="center">
                	<td>Project Budget Approve</td>
                    <td>Project Budget Unapprove</td>
                  
                </tr><br />
                <tr align="center">
                	<td><input type="checkbox" name="project_34" value="<?php echo $project_34?>" <?php if(find_4_string('id','module',$project_34,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    
                    <td><input type="checkbox" name="project_35" value="<?php echo $project_35?>" <?php if(find_4_string('id','module',$project_35,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                </tr>
               
            </table>
        </td>
      	<td align="center"></td>
      	<td align="center">
        	<input type="checkbox" name="project_15" value="<?php echo $project_15?>" <?php if(find_4_string('id','module',$project_15,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        
        
         <?php 
			$project_27 = 'project/delete_quotation';
			$project_28 = 'project/delete_po';
			$project_29 = 'project/delete_request_fund';
			$project_30 = 'project/delete_receive_item';
			$project_31 = 'project/delete_delivery_item';
			$project_32 = 'project/delete_summary';
			$project_37 = 'project/delete_timeline';
			$project_38 = 'project/delete_purchase_request';
			?>
            
            <table width="100%">
            	<tr align="center">
                	<td>Quotation</td>
                    <td>PO</td>
                    <td>Request Fund</td>
                    <td>Receive Item</td>
                    <td>Delivery Item</td>
                    <td>Summary</td>
                    <td>Timeline</td>
                    <td>Purchase Request</td>
                </tr>
                <tr align="center">
                	<td><input type="checkbox" name="project_27" value="<?php echo $project_27?>" <?php if(find_4_string('id','module',$project_27,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_28" value="<?php echo $project_28?>" <?php if(find_4_string('id','module',$project_28,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_29" value="<?php echo $project_29?>" <?php if(find_4_string('id','module',$project_29,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_30" value="<?php echo $project_30?>" <?php if(find_4_string('id','module',$project_30,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_31" value="<?php echo $project_31?>" <?php if(find_4_string('id','module',$project_31,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_32" value="<?php echo $project_32?>" <?php if(find_4_string('id','module',$project_32,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_37" value="<?php echo $project_37?>" <?php if(find_4_string('id','module',$project_37,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_38" value="<?php echo $project_38?>" <?php if(find_4_string('id','module',$project_38,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                </tr>
            </table>
        
        </td>
      	<td align="center">
        	<input type="checkbox" name="project_16" value="<?php echo $project_16?>" <?php if(find_4_string('id','module',$project_16,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
      	</td>
    </tr>
    <tr>
		<?php 	$project_6 = "project/list_employee_activity";
				$project_7 = "project/list_employee_activity_2";
                $project_8 = "project/add_employee_activity";
                $project_9 = "project/edit_employee_activity";
                $project_10 = "project/delete_employee_activity";
                $project_11 = "project/detail_employee_activity";
        ?>
        <td  valign="top" style="color:#666">&raquo;&raquo; <b>Employee Activity</b></td>
       	<td align="center">
        	<table width="100%">
            	<tr align="center">
                	<td>All</td>
                    <td>Self</td>
               	</tr>
                <tr align="center">
                    <td><input type="checkbox" name="project_6" value="<?php echo $project_6?>" <?php if(find_4_string('id','module',$project_6,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="project_7" value="<?php echo $project_7?>" <?php if(find_4_string('id','module',$project_7,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        		</tr>
        	</table>
        </td>
      	<td align="center">
        	<input type="checkbox" name="project_8" value="<?php echo $project_8?>" <?php if(find_4_string('id','module',$project_8,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="project_9" value="<?php echo $project_9?>" <?php if(find_4_string('id','module',$project_9,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="project_10" value="<?php echo $project_10?>" <?php if(find_4_string('id','module',$project_10,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="project_11" value="<?php echo $project_11?>" <?php if(find_4_string('id','module',$project_11,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
      	</td>
    </tr>
    <tr>
    	<td colspan="6" style="background-color:#CCC"></td>
    </tr>
    <tr>
    	<td class="6"><b>Request Funds</b></td>
    </tr>
    <tr>
		<?php 	$rf_1 = "budget/view_rf";
				$rf_2 = "budget/add_rf";
                $rf_3 = "budget/edit_rf";
                $rf_4 = "budget/delete_rf";
				$rf_5 = "budget/approve_1_rf";
				$rf_6 = "budget/approve_2_rf";
				$rf_7 = "budget/approve_3_rf";
				$rf_8 = "budget/approve_4_rf";
				$rf_19 = "budget/lock_rf";
				$rf_20 = "budget/unlock_rf";
        ?>
        <td  valign="top" style="color:#666">&raquo;&raquo; <b>Request Funds</b></td>
       	<td align="center">
        	<table width="100%">
            	<tr align="center">
                	<td>View</td>
                    <td>Approval 1</td>
                    <td>Approval 2</td>
                    <td>Approval 3</td>
                    <td>Approval 4</td>
                    <td>Lock</td>
                    <td>Unlock</td>
                </tr>
                <tr align="center">
                	<td><input type="checkbox" name="rf_1" value="<?php echo $rf_1?>" <?php if(find_4_string('id','module',$rf_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="rf_5" value="<?php echo $rf_5?>" <?php if(find_4_string('id','module',$rf_5,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="rf_6" value="<?php echo $rf_6?>" <?php if(find_4_string('id','module',$rf_6,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="rf_7" value="<?php echo $rf_7?>" <?php if(find_4_string('id','module',$rf_7,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="rf_8" value="<?php echo $rf_8?>" <?php if(find_4_string('id','module',$rf_8,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>                
                   <td><input type="checkbox" name="rf_19" value="<?php echo $rf_19?>" <?php if(find_4_string('id','module',$rf_19,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="rf_20" value="<?php echo $rf_20?>" <?php if(find_4_string('id','module',$rf_20,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
              
                </tr>
            </table>
        </td>
      	<td align="center"><input type="checkbox" name="rf_2" value="<?php echo $rf_2?>" <?php if(find_4_string('id','module',$rf_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        <td align="center"><input type="checkbox" name="rf_3" value="<?php echo $rf_3?>" <?php if(find_4_string('id','module',$rf_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        <td align="center"><input type="checkbox" name="rf_4" value="<?php echo $rf_4?>" <?php if(find_4_string('id','module',$rf_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        <td align="center"></td>
    </tr>
    <tr>
		<?php 	$rf_9 = "budget/view_payment";
				$rf_10 = "budget/add_payment";
				$rf_11 = "budget/edit_payment";
				$rf_12 = "budget/delete_payment";
				$rf_13 = "budget/confirm_payment";
				$rf_18 = "budget/unconfirm_payment";
        ?>
        <td  valign="top" style="color:#666">&raquo;&raquo; <b>Payment</b></td>
       	<td align="center">
        <table width="100%">
        	<tr align="center">
            	<td>View</td>
                <td>Confirm</td>
                <td>Unconfirm</td>
            </tr>
        	<tr align="center">
            	<td><input type="checkbox" name="rf_9" value="<?php echo $rf_9?>" <?php if(find_4_string('id','module',$rf_9,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                <td><input type="checkbox" name="rf_13" value="<?php echo $rf_13?>" <?php if(find_4_string('id','module',$rf_13,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                  <td><input type="checkbox" name="rf_18" value="<?php echo $rf_18?>" <?php if(find_4_string('id','module',$rf_18,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
            </tr>
        </table>
            
        </td>
      	<td align="center"><input type="checkbox" name="rf_10" value="<?php echo $rf_10?>" <?php if(find_4_string('id','module',$rf_10,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        <td align="center"><input type="checkbox" name="rf_11" value="<?php echo $rf_11?>" <?php if(find_4_string('id','module',$rf_11,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        <td align="center"><input type="checkbox" name="rf_12" value="<?php echo $rf_12?>" <?php if(find_4_string('id','module',$rf_12,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        <td align="center"></td>
    </tr>
    
    <tr>
		<?php 	
				$rf_14 = "budget/view_budget";
				$rf_15 = "budget/add_budget";
				$rf_16 = "budget/edit_budget";
				$rf_17 = "budget/budget_log";
			
        ?>
        <td  valign="top" style="color:#666">&raquo;&raquo; <b>Budget</b></td>
       	<td align="center">
        <input type="checkbox" name="rf_14" value="<?php echo $rf_14?>" <?php if(find_4_string('id','module',$rf_14,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
            
        </td>
      	<td align="center"><input type="checkbox" name="rf_15" value="<?php echo $rf_15?>" <?php if(find_4_string('id','module',$rf_15,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        <td align="center"><input type="checkbox" name="rf_16" value="<?php echo $rf_16?>" <?php if(find_4_string('id','module',$rf_16,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
      	<td align="center">&nbsp;</td>
      	<td align="center">&nbsp;</td>
    </tr>
    
    
    <tr>
		
        <td  valign="top" style="color:#666">&raquo;&raquo; <b>Budget Logs and Summary</b></td>
       	<td align="center">
        <input type="checkbox" name="rf_17" value="<?php echo $rf_17?>" <?php if(find_4_string('id','module',$rf_17,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
            
        </td>
      	<td align="center"></td>
      	<td align="center">&nbsp;</td>
      	<td align="center">&nbsp;</td>
    </tr>
    
  
    
    
    
    
    <tr>
    	<td colspan="6" style="background-color:#CCC"></td>
    </tr>
    <tr>
    	<td class="6"><b>Purchasing</b></td>
    </tr>
    <tr>
		<?php 	$rs_1 = "purchase_order/view_rs";
				$rs_2 = "purchase_order/add_rs";
                $rs_3 = "purchase_order/edit_rs";
                $rs_4 = "purchase_order/delete_rs";
				$rs_5 = "purchase_order/approve_rs";
				$rs_6 = "purchase_order/approve_2_rs";
				$rs_7 = "purchase_order/approve_3_rs";
				$rs_8 = "purchase_order/approve_4_rs";
        ?>
        <td  valign="top" style="color:#666">&raquo;&raquo; <b>Request Stock</b></td>
       	<td align="center">
        	<table width="100%">
            	<tr align="center">
                	<td>View</td>
                    <td>Approval 1</td>
                    <td>Approval 2</td>
                    <td>Approval 3</td>
                    <td>Approval 4</td>
                </tr>
                <tr align="center">
                	<td><input type="checkbox" name="rs_1" value="<?php echo $rs_1?>" <?php if(find_4_string('id','module',$rs_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    
                    
                    <td><input type="checkbox" name="rs_5" value="<?php echo $rs_5?>" <?php if(find_4_string('id','module',$rs_5,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="rs_6" value="<?php echo $rs_6?>" <?php if(find_4_string('id','module',$rs_6,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="rs_7" value="<?php echo $rs_7?>" <?php if(find_4_string('id','module',$rs_7,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="rs_8" value="<?php echo $rs_8?>" <?php if(find_4_string('id','module',$rs_8,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td> 
                    
                    
                </tr>
            </table>
        </td>
      	<td align="center"><input type="checkbox" name="rs_2" value="<?php echo $rs_2?>" <?php if(find_4_string('id','module',$rs_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        <td align="center"><input type="checkbox" name="rs_3" value="<?php echo $rs_3?>" <?php if(find_4_string('id','module',$rs_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        <td align="center"><input type="checkbox" name="rs_4" value="<?php echo $rs_4?>" <?php if(find_4_string('id','module',$rs_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        <td align="center"></td>
    </tr>
    <tr>
		<?php 	$po_5 = "purchase_order/view_stock";
				$po_6 = "purchase_order/add_stock";
                $po_7 = "purchase_order/edit_stock";
                $po_8 = "purchase_order/delete_stock";
        ?>
        <td  valign="top" style="color:#666">&raquo;&raquo; <b>Stock</b></td>
       	<td align="center"><input type="checkbox" name="po_5" value="<?php echo $po_5?>" <?php if(find_4_string('id','module',$po_5,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
      	<td align="center"><input type="checkbox" name="po_6" value="<?php echo $po_6?>" <?php if(find_4_string('id','module',$po_6,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        <td align="center"><input type="checkbox" name="po_7" value="<?php echo $po_7?>" <?php if(find_4_string('id','module',$po_7,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        <td align="center"><input type="checkbox" name="po_8" value="<?php echo $po_8?>" <?php if(find_4_string('id','module',$po_8,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        <td align="center"></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<?php 	
				$schedule_1 = "schedule/list_schedule";
				$schedule_5 = "schedule/list_schedule_2";
                $schedule_2 = "schedule/add_schedule";
                $schedule_3 = "schedule/edit_schedule";
                $schedule_4 = "schedule/detail_schedule";
        ?>
    	<td valign="top"><b>Schedule</b></td>
		
       	<td align="center">
        	
            <table width="100%">
            	<tr align="center">
                	<td>All</td>
                    <td>Self</td>
               	</tr>
                <tr align="center">
                    <td><input type="checkbox" name="schedule_1" value="<?php echo $schedule_1?>" <?php if(find_4_string('id','module',$schedule_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="schedule_5" value="<?php echo $schedule_5?>" <?php if(find_4_string('id','module',$schedule_5,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        		</tr>
        	</table>
        </td>
      	<td align="center">
        	<input type="checkbox" name="schedule_2" value="<?php echo $schedule_2?>" <?php if(find_4_string('id','module',$schedule_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="schedule_3" value="<?php echo $schedule_3?>" <?php if(find_4_string('id','module',$schedule_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
    	</td>
        <td align="center">
        	<input type="checkbox" name="schedule_4" value="<?php echo $schedule_4?>" <?php if(find_4_string('id','module',$schedule_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<?php 	
				$schedule_6 = "schedule/list_job_tracking";
				$schedule_7 = "schedule/list_job_tracking_2";
                $schedule_8 = "schedule/add_job_tracking";
                $schedule_9 = "schedule/edit_job_tracking";
                $schedule_10 = "schedule/detail_job_tracking";
				$schedule_11 = "schedule/delete_job_tracking";
				$schedule_12 = "schedule/approval_job_tracking";
        ?>
    	<td valign="top"><b>Job Tracking</b></td>
		
       	<td align="center">
        	
            <table width="100%">
            	<tr align="center">
                	<td>All</td>
                    <td>Self</td>
                    <td>Approval</td>
               	</tr>
                <tr align="center">
                    <td><input type="checkbox" name="schedule_6" value="<?php echo $schedule_6?>" <?php if(find_4_string('id','module',$schedule_6,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="schedule_7" value="<?php echo $schedule_7?>" <?php if(find_4_string('id','module',$schedule_7,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="schedule_12" value="<?php echo $schedule_12?>" <?php if(find_4_string('id','module',$schedule_12,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        		</tr>
        	</table>
        </td>
      	<td align="center">
        	<input type="checkbox" name="schedule_8" value="<?php echo $schedule_8?>" <?php if(find_4_string('id','module',$schedule_8,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="schedule_9" value="<?php echo $schedule_9?>" <?php if(find_4_string('id','module',$schedule_9,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="schedule_11" value="<?php echo $schedule_11?>" <?php if(find_4_string('id','module',$schedule_11,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td align="center">
        	<input type="checkbox" name="schedule_10" value="<?php echo $schedule_10?>" <?php if(find_4_string('id','module',$schedule_10,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<?php 	
				$reminder_1 = "reminder/list_reminder";
				$reminder_6 = "reminder/list_reminder_2";
                $reminder_2 = "reminder/add_reminder";
                $reminder_3 = "reminder/edit_reminder";
                $reminder_4 = "reminder/detail_reminder";
				$reminder_5 = "reminder/delete_reminder";
        ?>
    	<td valign="top"><b>Reminder</b></td>
       	<td align="center">
        	<table width="100%">
            	<tr align="center">
                	<td width="50%">All</td>
                    <td>Self (based on department)</td>
               	</tr>
                <tr align="center">
                    <td><input type="checkbox" name="reminder_1" value="<?php echo $reminder_1?>" <?php if(find_4_string('id','module',$reminder_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="reminder_6" value="<?php echo $reminder_6?>" <?php if(find_4_string('id','module',$reminder_6,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                </tr>
            </table>
        </td>
      	<td align="center">
        	<input type="checkbox" name="reminder_2" value="<?php echo $reminder_2?>" <?php if(find_4_string('id','module',$reminder_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="reminder_3" value="<?php echo $reminder_3?>" <?php if(find_4_string('id','module',$reminder_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="reminder_5" value="<?php echo $reminder_5?>" <?php if(find_4_string('id','module',$reminder_5,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td align="center">
        	<input type="checkbox" name="reminder_4" value="<?php echo $reminder_4?>" <?php if(find_4_string('id','module',$reminder_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
		<?php 	$employee_1 = "employee/list_employee";
                $employee_2 = "employee/add_employee";
                $employee_3 = "employee/edit_employee";
                $employee_4 = "employee/delete_employee";
                $employee_5 = "employee/detail_employee";
				
				$employee_6 = "employee/list_employee_group";
				$employee_7 = "employee/add_employee_group";
				$employee_8 = "employee/delete_employee_group";
        ?>
        <td><b>Employee</b></td>
       	<td align="center">
        	<input type="checkbox" name="employee_1" value="<?php echo $employee_1?>" <?php if(find_4_string('id','module',$employee_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="employee_2" value="<?php echo $employee_2?>" <?php if(find_4_string('id','module',$employee_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="employee_3" value="<?php echo $employee_3?>" <?php if(find_4_string('id','module',$employee_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="employee_4" value="<?php echo $employee_4?>" <?php if(find_4_string('id','module',$employee_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="employee_5" value="<?php echo $employee_5?>" <?php if(find_4_string('id','module',$employee_5,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
      	</td>
    </tr>
    <tr>
		<?php 	$employee_1 = "employee/list_employee";
                $employee_2 = "employee/add_employee";
                $employee_3 = "employee/edit_employee";
                $employee_4 = "employee/delete_employee";
                $employee_5 = "employee/detail_employee";
				
				$employee_6 = "employee/list_employee_group";
				$employee_7 = "employee/add_employee_group";
				$employee_8 = "employee/delete_employee_group";
        ?>
        <td><b>Employee Group / Team</b></td>
            <td align="center">
                <input type="checkbox" name="employee_6" value="<?php echo $employee_6?>" <?php if(find_4_string('id','module',$employee_6,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
            </td>
            <td align="center">
                <input type="checkbox" name="employee_7" value="<?php echo $employee_7?>" <?php if(find_4_string('id','module',$employee_7,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
            </td>
            <td align="center">
                
            </td>
            <td align="center">
                <input type="checkbox" name="employee_8" value="<?php echo $employee_8?>" <?php if(find_4_string('id','module',$employee_8,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
            </td>
            <td align="center">
                
            </td>
        </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<td  valign="top"><b>Client</b></td>
		<?php 	$client_1 = "client/list_client";
				$client_2 = "client/list_client_2";
                $client_3 = "client/add_client";
                $client_4 = "client/edit_client";
                $client_5 = "client/delete_client";
                $client_6 = "client/detail_client";
        ?>
       	<td align="center">
        	<table width="100%">
            	<tr align="center">
                	<td>All</td>
                    <td>Self</td>
               	</tr>
                <tr align="center">
        			<td><input type="checkbox" name="client_1" value="<?php echo $client_1?>" <?php if(find_4_string('id','module',$client_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
            		<td><input type="checkbox" name="client_2" value="<?php echo $client_2?>" <?php if(find_4_string('id','module',$client_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
            	<tr>
            </table>
        </td>
      	<td align="center">
        	<input type="checkbox" name="client_3" value="<?php echo $client_3?>" <?php if(find_4_string('id','module',$client_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="client_4" value="<?php echo $client_4?>" <?php if(find_4_string('id','module',$client_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="client_5" value="<?php echo $client_5?>" <?php if(find_4_string('id','module',$client_5,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="client_6" value="<?php echo $client_6?>" <?php if(find_4_string('id','module',$client_6,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
      	</td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<td><b>Vendor</b></td>
		<?php 	$vendor_1 = "vendor/list_vendor";
                $vendor_2 = "vendor/add_vendor";
                $vendor_3 = "vendor/edit_vendor";
                $vendor_4 = "vendor/delete_vendor";
                $vendor_5 = "vendor/detail_vendor";
        ?>
       	<td align="center">
        	<input type="checkbox" name="vendor_1" value="<?php echo $vendor_1?>" <?php if(find_4_string('id','module',$vendor_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="vendor_2" value="<?php echo $vendor_2?>" <?php if(find_4_string('id','module',$vendor_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="vendor_3" value="<?php echo $vendor_3?>" <?php if(find_4_string('id','module',$vendor_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="vendor_4" value="<?php echo $vendor_4?>" <?php if(find_4_string('id','module',$vendor_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="vendor_5" value="<?php echo $vendor_5?>" <?php if(find_4_string('id','module',$vendor_5,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
      	</td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<td><b>Inventory</b></td>
		<?php 	$inventory_1 = "inventory/list_inventory";
				$inventory_6 = "inventory/list_inventory_2";
                $inventory_2 = "inventory/add_inventory";
                $inventory_3 = "inventory/edit_inventory";
                $inventory_4 = "inventory/delete_inventory";
                $inventory_5 = "inventory/detail_inventory";
        ?>
       	<td align="center">
        	<table width="100%">
            	<tr align="center">
                	<td>All</td>
                    <td>Self</td>
               	</tr>
                <tr align="center">
        			<td><input type="checkbox" name="inventory_1" value="<?php echo $inventory_1?>" <?php if(find_4_string('id','module',$inventory_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
            		<td><input type="checkbox" name="inventory_6" value="<?php echo $inventory_6?>" <?php if(find_4_string('id','module',$inventory_6,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
            	<tr>
            </table>
        </td>
      	<td align="center">
        	<input type="checkbox" name="inventory_2" value="<?php echo $inventory_2?>" <?php if(find_4_string('id','module',$inventory_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="inventory_3" value="<?php echo $inventory_3?>" <?php if(find_4_string('id','module',$inventory_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="inventory_4" value="<?php echo $inventory_4?>" <?php if(find_4_string('id','module',$inventory_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="inventory_5" value="<?php echo $inventory_5?>" <?php if(find_4_string('id','module',$inventory_5,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
      	</td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<td colspan="6"><b>Product</b></td>
    </tr>
    <tr>
    	<?php 	
				$brand_1 = "product/list_brand";
                $brand_2 = "product/add_brand";
                $brand_3 = "product/edit_brand";
                $brand_4 = "product/delete_brand";
				
				$category_1 = "product/list_category";
                $category_2 = "product/add_category";
                $category_3 = "product/edit_category";
                $category_4 = "product/delete_category";
				
				$product_1 = "product/list_product";
                $product_2 = "product/add_product";
                $product_3 = "product/edit_product";
                $product_4 = "product/delete_product";
        ?>
    	<td style="color:#666">&raquo;&raquo; <b>Brand</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="brand_1" value="<?php echo $brand_1?>" <?php if(find_4_string('id','module',$brand_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="brand_2" value="<?php echo $brand_2?>" <?php if(find_4_string('id','module',$brand_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="brand_3" value="<?php echo $brand_3?>" <?php if(find_4_string('id','module',$brand_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="brand_4" value="<?php echo $brand_4?>" <?php if(find_4_string('id','module',$brand_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td style="color:#666">&raquo;&raquo; <b>Category</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="category_1" value="<?php echo $category_1?>" <?php if(find_4_string('id','module',$category_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="category_2" value="<?php echo $category_2?>" <?php if(find_4_string('id','module',$category_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="category_3" value="<?php echo $category_3?>" <?php if(find_4_string('id','module',$category_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="category_4" value="<?php echo $category_4?>" <?php if(find_4_string('id','module',$category_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td style="color:#666">&raquo;&raquo; <b>Product</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="product_1" value="<?php echo $product_1?>" <?php if(find_4_string('id','module',$product_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="product_2" value="<?php echo $product_2?>" <?php if(find_4_string('id','module',$product_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="product_3" value="<?php echo $product_3?>" <?php if(find_4_string('id','module',$product_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="product_4" value="<?php echo $product_4?>" <?php if(find_4_string('id','module',$product_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<?php 	
				$lesson_1 = "lesson_learn/list_lesson_learn";
                $lesson_2 = "lesson_learn/add_lesson_learn";
                $lesson_3 = "lesson_learn/edit_lesson_learn";
                $lesson_4 = "lesson_learn/delete_lesson_learn";
        ?>
    	<td><b>Lesson Learn</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="lesson_1" value="<?php echo $lesson_1?>" <?php if(find_4_string('id','module',$lesson_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="lesson_2" value="<?php echo $lesson_2?>" <?php if(find_4_string('id','module',$lesson_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="lesson_3" value="<?php echo $lesson_3?>" <?php if(find_4_string('id','module',$lesson_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="lesson_4" value="<?php echo $lesson_4?>" <?php if(find_4_string('id','module',$lesson_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<?php 	
				$industry_1 = "industry/list_industry";
                $industry_2 = "industry/add_industry";
                $industry_3 = "industry/edit_industry";
                $industry_4 = "industry/delete_industry";
        ?>
    	<td><b>Industry</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="industry_1" value="<?php echo $industry_1?>" <?php if(find_4_string('id','module',$industry_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="industry_2" value="<?php echo $industry_2?>" <?php if(find_4_string('id','module',$industry_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="industry_3" value="<?php echo $industry_3?>" <?php if(find_4_string('id','module',$industry_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="industry_4" value="<?php echo $industry_4?>" <?php if(find_4_string('id','module',$industry_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<?php 	
				$lead_source_1 = "lead_source/list_lead_source";
                $lead_source_2 = "lead_source/add_lead_source";
                $lead_source_3 = "lead_source/edit_lead_source";
                $lead_source_4 = "lead_source/delete_lead_source";
        ?>
    	<td><b>Lead Source</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="lead_source_1" value="<?php echo $lead_source_1?>" <?php if(find_4_string('id','module',$lead_source_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="lead_source_2" value="<?php echo $lead_source_2?>" <?php if(find_4_string('id','module',$lead_source_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="lead_source_3" value="<?php echo $lead_source_3?>" <?php if(find_4_string('id','module',$lead_source_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="lead_source_4" value="<?php echo $lead_source_4?>" <?php if(find_4_string('id','module',$lead_source_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<?php 	
				$company_1 = "company/list_company";
                $company_2 = "company/add_company";
                $company_3 = "company/edit_company";
                $company_4 = "company/delete_company";
        ?>
    	<td><b>Company</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="company_1" value="<?php echo $company_1?>" <?php if(find_4_string('id','module',$company_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="company_2" value="<?php echo $company_2?>" <?php if(find_4_string('id','module',$company_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="company_3" value="<?php echo $company_3?>" <?php if(find_4_string('id','module',$company_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="company_4" value="<?php echo $company_4?>" <?php if(find_4_string('id','module',$company_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<?php 	
				$department_1 = "department/list_department";
                $department_2 = "department/add_department";
                $department_3 = "department/edit_department";
                $department_4 = "department/delete_department";
        ?>
    	<td><b>Deparment</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="department_1" value="<?php echo $department_1?>" <?php if(find_4_string('id','module',$department_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="department_2" value="<?php echo $department_2?>" <?php if(find_4_string('id','module',$department_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="department_3" value="<?php echo $department_3?>" <?php if(find_4_string('id','module',$department_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="department_4" value="<?php echo $department_4?>" <?php if(find_4_string('id','module',$department_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<?php 	
				$bank_1 = "project/list_bank";
                $bank_2 = "project/add_bank";
                $bank_3 = "project/edit_bank";
                $bank_4 = "project/delete_bank";
        ?>
    	<td><b>Bank</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="bank_1" value="<?php echo $bank_1?>" <?php if(find_4_string('id','module',$bank_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="bank_2" value="<?php echo $bank_2?>" <?php if(find_4_string('id','module',$bank_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="bank_3" value="<?php echo $bank_3?>" <?php if(find_4_string('id','module',$bank_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="bank_4" value="<?php echo $bank_4?>" <?php if(find_4_string('id','module',$bank_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<?php 	
				$activity_category_1 = "project/list_activity_category";
                $activity_category_2 = "project/add_activity_category";
                $activity_category_3 = "project/edit_activity_category";
                $activity_category_4 = "project/delete_activity_category";
        ?>
    	<td><b>Activity Category</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="activity_category_1" value="<?php echo $activity_category_1?>" <?php if(find_4_string('id','module',$activity_category_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="activity_category_2" value="<?php echo $activity_category_2?>" <?php if(find_4_string('id','module',$activity_category_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="activity_category_3" value="<?php echo $activity_category_3?>" <?php if(find_4_string('id','module',$activity_category_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="activity_category_4" value="<?php echo $activity_category_4?>" <?php if(find_4_string('id','module',$bank_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<?php 	
				$resource_1 = "resource/list_resource";
                $resource_2 = "resource/add_resource";
                $resource_3 = "resource/edit_resource";
        ?>
    	<td><b>Resource</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="resource_1" value="<?php echo $resource_1?>" <?php if(find_4_string('id','module',$resource_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="resource_2" value="<?php echo $resource_2?>" <?php if(find_4_string('id','module',$resource_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="resource_3" value="<?php echo $resource_3?>" <?php if(find_4_string('id','module',$resource_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center"></td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<?php 	
				$warehouse_1 = "warehouse/list_warehouse";
                $warehouse_2 = "warehouse/add_warehouse";
                $warehouse_3 = "warehouse/edit_warehouse";
        ?>
    	<td><b>Warehouse</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="warehouse_1" value="<?php echo $warehouse_1?>" <?php if(find_4_string('id','module',$warehouse_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="warehouse_2" value="<?php echo $warehouse_2?>" <?php if(find_4_string('id','module',$warehouse_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="warehouse_3" value="<?php echo $warehouse_3?>" <?php if(find_4_string('id','module',$warehouse_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center"></td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    
    <tr>
    	<?php 	
				$rak_1 = "rak/list_rak";
                $rak_2 = "rak/add_rak";
                $rak_3 = "rak/edit_rak";
                $rak_4 = "rak/delete_rak";
        ?>
    	<td><b>Rak</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="rak_1" value="<?php echo $rak_1?>" <?php if(find_4_string('id','module',$rak_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="rak_2" value="<?php echo $rak_2?>" <?php if(find_4_string('id','module',$rak_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="rak_3" value="<?php echo $rak_3?>" <?php if(find_4_string('id','module',$rak_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="rak_4" value="<?php echo $rak_4?>" <?php if(find_4_string('id','module',$rak_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    <tr>
    	<td colspan="6"><b>Report</b></td>
    </tr>
    <tr>
    	<?php 	
				$report_1 = "report/list_project_goal_report";
				$report_2 = "report/list_employee_report";
				$report_3 = "report/list_payment_report";
				$report_4 = "report/list_survey_report";
				$report_5 = "report/list_crm_report";
				$report_6 = "report/list_employee_daily_report";
				$report_7 = "report/list_employee_schedule_daily_report";
				$report_8 = "report/list_bonus_report";
				
				$report_9 = "report/list_project_goal_report_2";
				$report_10 = "report/list_crm_report_2";
				$report_11 = "report/list_employee_daily_report_2";
				$report_12 = "report/list_project_goal_nominal_report";
				$report_13 = "report/list_outstanding_report";
				$report_14 = "report/list_report_bs";
				$report_15 = "report/list_report_reimburse";
				$report_16 = "report/list_report_outstanding_project";
				$report_17 = "report/report_project_list";
				$report_18 = "report/detail_project_report";
				$report_19 = "report/report_history_search";
				$report_20 = "report/project_report";
			
        ?>
    	<td style="color:#666"><b>&raquo;&raquo; Project Goal</b></td>
		
       	<td align="center">
            <table width="100%">
            	<tr align="center">
                	<td>All</td>
                    <td>Self</td>
                    <td>Nominal</td>
               	</tr>
                <tr align="center">
                    <td><input type="checkbox" name="report_1" value="<?php echo $report_1?>" <?php if(find_4_string('id','module',$report_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="report_9" value="<?php echo $report_9?>" <?php if(find_4_string('id','module',$report_9,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="report_12" value="<?php echo $report_12?>" <?php if(find_4_string('id','module',$report_12,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        		</tr>
        	</table>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td style="color:#666"><b>&raquo;&raquo; CRM</b></td>
		
       	<td align="center">
        	<!--<input type="checkbox" name="report_5" value="<?php echo $report_5?>" <?php if(find_4_string('id','module',$report_5,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>-->
            <table width="100%">
            	<tr align="center">
                	<td>All</td>
                    <td>Self</td>
               	</tr>
                <tr align="center">
                    <td><input type="checkbox" name="report_5" value="<?php echo $report_5?>" <?php if(find_4_string('id','module',$report_5,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="report_10" value="<?php echo $report_10?>" <?php if(find_4_string('id','module',$report_10,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        		</tr>
        	</table>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td style="color:#666"><b>&raquo;&raquo; Employee</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="report_2" value="<?php echo $report_2?>" <?php if(find_4_string('id','module',$report_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td style="color:#666"><b>&raquo;&raquo; Employee Daily</b></td>
		
       	<td align="center">
        	<!--<input type="checkbox" name="report_6" value="<?php echo $report_6?>" <?php if(find_4_string('id','module',$report_6,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>-->
            <table width="100%">
            	<tr align="center">
                	<td>All</td>
                    <td>Self</td>
               	</tr>
                <tr align="center">
                    <td><input type="checkbox" name="report_6" value="<?php echo $report_6?>" <?php if(find_4_string('id','module',$report_6,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
                    <td><input type="checkbox" name="report_11" value="<?php echo $report_11?>" <?php if(find_4_string('id','module',$report_11,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/></td>
        		</tr>
        	</table>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td style="color:#666"><b>&raquo;&raquo; Employee Schedule VS Daily</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="report_7" value="<?php echo $report_7?>" <?php if(find_4_string('id','module',$report_7,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td style="color:#666"><b>&raquo;&raquo; Payment</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="report_3" value="<?php echo $report_3?>" <?php if(find_4_string('id','module',$report_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td style="color:#666"><b>&raquo;&raquo; Outstanding</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="report_13" value="<?php echo $report_13?>" <?php if(find_4_string('id','module',$report_13,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td style="color:#666"><b>&raquo;&raquo; Survey</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="report_4" value="<?php echo $report_4?>" <?php if(find_4_string('id','module',$report_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td style="color:#666"><b>&raquo;&raquo; Bonus</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="report_8" value="<?php echo $report_8?>" <?php if(find_4_string('id','module',$report_8,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    
    <tr>
    	<td style="color:#666"><b>&raquo;&raquo; BS List</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="report_14" value="<?php echo $report_14?>" <?php if(find_4_string('id','module',$report_14,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    
    <tr>
    	<td style="color:#666"><b>&raquo;&raquo; Reimburse List</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="report_15" value="<?php echo $report_15?>" <?php if(find_4_string('id','module',$report_15,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
       <tr>
    	<td style="color:#666"><b>&raquo;&raquo; All Outstanding Project List</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="report_16" value="<?php echo $report_16?>" <?php if(find_4_string('id','module',$report_16,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    
    <tr>
    	<td style="color:#666"><b>&raquo;&raquo; Project Report List</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="report_17" value="<?php echo $report_17?>" <?php if(find_4_string('id','module',$report_17,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    
    <tr>
    	<td style="color:#666"><b>&raquo;&raquo; Detail Project Report List</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="report_18" value="<?php echo $report_18?>" <?php if(find_4_string('id','module',$report_18,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td style="color:#666"><b>&raquo;&raquo; Search History List</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="report_19" value="<?php echo $report_19?>" <?php if(find_4_string('id','module',$report_19,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
   
    <tr>
    	<td style="color:#666"><b>&raquo;&raquo; Project Report</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="report_20" value="<?php echo $report_20?>" <?php if(find_4_string('id','module',$report_20,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
      	<td align="center">
        	
    	</td>
        <td></td>
    </tr>
    
    <tr>
    	<?php 	
				$faq_1 = "faq/list";
                $faq_2 = "faq/add";
                $faq_3 = "faq/edit";
                $faq_4 = "faq/delete";
        ?>
    	<td><b>FAQ</b></td>
		
       	<td align="center">
        	<?php /*?><input type="checkbox" name="faq_1" value="<?php echo $faq_1?>" <?php if(find_4_string('id','module',$faq_1,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/><?php */?>
        </td>
      	<td align="center">
        	<input type="checkbox" name="faq_2" value="<?php echo $faq_2?>" <?php if(find_4_string('id','module',$faq_2,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="faq_3" value="<?php echo $faq_3?>" <?php if(find_4_string('id','module',$faq_3,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="faq_4" value="<?php echo $faq_4?>" <?php if(find_4_string('id','module',$faq_4,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<?php 	
				$faq_5 = "faq_category/list";
                $faq_6 = "faq_category/add";
                $faq_7 = "faq_category/edit";
                $faq_8 = "faq_category/delete";
        ?>
    	<td><b>FAQ Category</b></td>
		
       	<td align="center">
        	<input type="checkbox" name="faq_5" value="<?php echo $faq_5?>" <?php if(find_4_string('id','module',$faq_5,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
        </td>
      	<td align="center">
        	<input type="checkbox" name="faq_6" value="<?php echo $faq_6?>" <?php if(find_4_string('id','module',$faq_6,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="faq_7" value="<?php echo $faq_7?>" <?php if(find_4_string('id','module',$faq_7,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
      	<td align="center">
        	<input type="checkbox" name="faq_8" value="<?php echo $faq_8?>" <?php if(find_4_string('id','module',$faq_8,'privilege_user_id',$privilege_user['id'],'privilege_tb')){?> checked="checked" <?php }?>/>
    	</td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="6" style="background:#CCC"></td>
    </tr>
    
    
    <tr>
    	<td colspan="6" align="center"><input type="submit" name="submit2" id="submit2" value="Submit" />
        <a style="text-decoration:none" href="<?php echo site_url('admin/privilege_user');?>"><input type="button" style="width:60px;" value="back" /></a>		
        </td>
    </tr>
</table>
</form>