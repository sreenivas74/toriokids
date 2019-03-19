<style>
	table.payment_list tr td{
		border:dotted #999 2px;
		margin:3px;
		padding:3px;
	}
</style>
<script>
	$(document).ready(function(){
		$('.date_selection').datepicker({
			numberOfMonths: 1,
			showButtonPanel: true,
			yearRange: "-80:+80",
			changeYear: true,
			dateFormat: "yy-mm-dd",
			minDate: "-80y"
		});
	});
</script>
<h2>Request Funds &raquo; Payment List</h2>
<form name="payment_filter" method="post" enctype="multipart/form-data" action="<?php echo site_url('budget/payment_list')?>">
	<table>
    	<tr>
        	<td style="width:30px">From</td>
            <td><input type="text" name="from" class="date_selection" value="<?php echo $from?>" /></td>
            <td>&nbsp;</td>
            <td style="width:30px">To</td>
            <td><input type="text" name="to" class="date_selection" value="<?php echo $to?>" /></td>
            <td>&nbsp;<input type="submit" value="submit" style="height:27px" /></td>
        </tr>
    </table>
</form>
<hr size="1" />
<form name="payment_submit_form" method="post" action="<?php echo site_url('budget/confirm_payment')?>">
	<input type="hidden" name="from" class="date_selection" value="<?php echo $from?>" />
    <input type="hidden" name="to" class="date_selection" value="<?php echo $to?>" />
<table class="payment_list">
	<tr style="background:#CCC">
    	<td>No</td>
        
        <td style="width:200px">From</td>
        <td style="width:200px">To</td>
        <td style="width:50px; text-align:center">Method</td>
        <td style="width:50px; text-align:center">Type</td>
        <td style="width:70px; text-align:">Amount</td>
        <td style="width:120px; text-align:center">Request Number</td>
        <td style="width:100px; text-align:center">Approval</td>
        <td style="width:150px;text-align:center">Project</td>
        <td style="width:100px">Budget</td>
        <td style="width:100px">Description</td>
        <td style="width:50px; text-align:center">Done</td>
    </tr>
    <?php $no = 1;$total = 0;$total_1 = 0;$total_2 = 0;

	if($payment_list)foreach($payment_list as $list){?>
    	<input name="request_payment_id[]" type="hidden" value="<?php echo $list['id']?>" />
    	<tr>
        	<td style="text-align:right"><?php echo $no;?></td>
            <td><?php echo $list['bname']?></td>
            <td>
            
            <?php if($list['created_date']>='2014-10-13'){?>
				<?php 
				if($list['request_budget_item_id']!=0){
					echo $list['transfer_account_bank'];
				}elseif($list['request_budget_item_id']==0){
				
					$data_bank=explode("|", $list['transfer_account_bank']);
			//		pre($data_bank);
					if($data_bank)foreach($data_bank as $list_data_bank){
						echo $list_data_bank;
						echo "<hr>";
					}
					
					
				}?>
               <?php }else{?>
               
               
               		<?php 
				if($list['request_budget_item_id']!=0){
					echo $list['bank_name']." ".$list['acc_name']." ".$list['acc_number'];
				}elseif($list['request_budget_item_id']==0){
					echo find_budget_transfer_to($list['request_budget_id']);
				}?>
               
             <?php } ?>  
              
            </td>
            <td style="text-align:center"><?php if($list['method']==1)echo "cash";else echo "transfer"?></td>
            <td style="text-align:center"><?php if($list['pay_type']==1)echo "received"; else echo "payment";?></td>
            <td style="text-align:right"><?php echo number_format($list['amount'])?></td>
            <td style="text-align:center"><a style="text-decoration:none" target="_blank" href="<?php echo site_url('budget/detail/'.$list['request_budget_id'])?>"><?php echo $list['request_number']?></a>
            <hr style="border:dashed #CCC 1px" />
            <?php echo date('d F Y',strtotime($list['pay_date']))?>
            </td>
            <td style="text-align:center">
            	<?php 
				
					if($list['approved_by']==0)echo "admin";
					else{
						echo find('firstname',$list['approved_by'],'employee_tb');	
					}
				?>
            </td>
            <td style="text-align:center"><?php echo ($list['project_id'])?find('name',$list['project_id'],'project_tb'):"";?></td>
            <td valign="top">
            <?php 
			if($list['request_budget_item_id']==0){
				echo find_all_budget($list['request_budget_id']);
			}else{
				if($list['budget_id']!=0){
					echo find('name',$list['budget_id'],'budget_tb');
					echo "<br>";
					echo (find_budget_left($list['budget_id']));
					
				}elseif($list['project_goal_po_client_item_id']!=0){
					echo find('item',$list['project_goal_po_client_item_id'],'project_goal_po_client_item_tb');
					echo "<br>";
					echo (find_budget_po_left($list['project_goal_po_client_item_id']));
				}
			}?>
            </td>
            <td valign="top"><?php 
			if($list['request_budget_item_id']==0){
				echo find_all_budget_description($list['request_budget_id']);
			}else echo $list['description'];
			
			?></td>
            <td style="text-align:center">
            	<?php if($list['status']==0){?>
                	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/confirm_payment","privilege_tb")){?>
            			<input type="checkbox" value="1" name="cek_<?php echo $list['id']?>" />
                	<?php }?>
                <?php }else echo "confirmed";?>
           	</td>
        </tr>
    <?php $no++; 
	
	if($list['pay_type'] == 0)$total_1+=$list['amount'];
	if($list['pay_type'] == 1)$total_2+=$list['amount'];
	
	$total+=$list['amount'];
	}?>
    <tr>
    	<td style="text-align:right; border:none" colspan="5" valign="top"><b>Payment<br />Received<hr size="1" />Total<b></td>
        <td style="text-align:right; border:none" valign="top"><?php echo number_format($total_1)?><br /><?php echo number_format($total_2)?><hr size="1" /><?php echo number_format($total)?></td>
    </tr>
    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/confirm_payment","privilege_tb") && $payment_list){?>
        <tr>
            <td colspan="12" style="text-align:right; border:none"><input type="submit" value="confirm payment" style="height:27px" /></td>
        </tr>
    <?php }?>
</table>

</form>