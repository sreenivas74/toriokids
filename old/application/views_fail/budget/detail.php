<?php $subtotall=0; $mandatorycomment=0;?>
<style>
	table tr td{
		border:solid #999 1px;
		padding:2px;	
	}
	table.payment_table tr td{
		border:none;
		padding:2px;	
	}
	table.payment_table tr{
		background:#F4F4F4;
		border:solid #CCC 1px;
	}
	table.logging tr td{
		border:none;
		border-bottom:solid #000 2px;
		padding:2px;	
	}
	table.logging tr.list td{
		border:none;
		border-bottom:solid #999 1px;
		padding:2px;
	}
	table.logging tr.list:nth-child(odd) td{
		background:#F2F2F2;	
	}
	table.logging tr.list:nth-child(even) td{
		background:#FFF;
	}
	
	table.dottedTable tr td{
		border:dashed #999 1px;	
	}
</style>

<b>Request Fund Detail</b>
<?php  if(isset($_SESSION['notif'])){
		echo "<br><span style=color:#00F>".$_SESSION['notif']."</span>";
		unset($_SESSION['notif']);	
}?>
<hr style="border:dotted 1px" />
<b><?php echo $request_detail['request_number']?></b><br />
<div style="width:800px;">
	<div style="width:400px; float:left">
        Project : <?php if($request_detail['pname'])echo $request_detail['pname'];else "-";?><br />
        Amount : <?php echo number_format($request_detail['total'])?><br />
        <?php /*?>PPN :   <?php if($request_detail['is_ppn']==1)echo "Yes"; else echo "No"?> <br /><?php */?>
        
        Bon Sementara : 
        <?php if($request_detail['bs']==1)echo "Yes"; else echo "No"?> <?php if($request_detail['bs']==1)echo "[".find('firstname',$request_detail['bs_employee_id'],'employee_tb')." ".find('lastname',$request_detail['bs_employee_id'],'employee_tb')."]"?>
        <br />
Reimburse ke Client:
<?php if($request_detail['reimburse']==1)echo "Yes"; else echo "No"?>
<?php /*?><br />
PPN:
<?php if($request_detail['is_ppn']==1)echo "Yes"; else echo "No"?>
<?php */?><br />
        Notes : <?php echo $request_detail['notes']?><br />
        

        <?php if(isset($po_client))if($po_client['approval_level']=='3'){?>
        		Approval Budget : Yes
			<?php }elseif($po_client['approval_level']=='0'){?>
           	 <span style="color:red">Approval Budget : No</span>
            <?php }else{ ?>
             	Approval Budget : -    
        <?php }else{ ?>
             	Approval Budget : -    
        <?php } ?>
    </div>
    
<!--jika tidak approved-->
<?php if($request_detail['not_approval']==1){?>

     <div style="width:400px; float:left">
 
     
     <?php 
	 	if($request_detail['not_approval_date']!='0000-00-00 00:00:00'){
			$approval_date = date('d F Y',strtotime($request_detail['not_approval_date']));
			if($request_detail['not_approval_by']==0)$approval_by = 'admin';
			else $approval_by = find('firstname',$request_detail['approval_4_by'],'employee_tb')." ".find('lastname',$request_detail['not_approval_by'],'employee_tb');
		?>
			            
              Not Approval :  <?php echo $approval_date.", ".$approval_by;?>
           <span id="approval_4_comment" ><br />
           Comment Not Approval
           <textarea readonly="readonly" rows="5" cols="50" style="resize:none;"><?php echo $request_detail['not_approval_comment'];?></textarea> 
			</span> <br />
            
	<?php }
	 
	 
	 if($request_detail['paid_date']!='0000-00-00 00:00:00'){
			$paid_date = date('d F Y',strtotime($request_detail['paid_date']));
			if($request_detail['paid_by']==0)$paid_by = 'admin';
			else $paid_by = find('firstname',$request_detail['paid_by'],'employee_tb')." ".find('lastname',$request_detail['paid_by'],'employee_tb');
			echo "Paid : ".$paid_date.", ".$paid_by;
		}else{
			echo "Paid : -";
		}
		echo "<br />";
		$created_date = date('d F Y',strtotime($request_detail['created_date']));
		if($request_detail['created_by']==0)$created_by = 'admin';
		else $created_by = find('firstname',$request_detail['created_by'],'employee_tb')." ".find('lastname',$request_detail['created_by'],'employee_tb');
		echo "Created : ".$created_date.", ".$created_by;
		echo "<br />";
		if($request_detail['updated_date']!='0000-00-00'){
			$updated_date = date('d F Y',strtotime($request_detail['updated_date']));
			if($request_detail['created_by']==0)$updated_by = 'admin';
			else $updated_by = find('firstname',$request_detail['updated_by'],'employee_tb')." ".find('lastname',$request_detail['updated_by'],'employee_tb');
			echo "Updated : ".$updated_date.", ".$updated_by;
		}else{
			echo "Updated : -";
		}
		?>
     </div>
 <?php }else{?>
     
    <div style="width:400px; float:left">
    	<?php
		if($request_detail['approval_date']!='0000-00-00 00:00:00'){
			$approval_date = date('d F Y',strtotime($request_detail['approval_date']));
			if($request_detail['approval_by']==0)$approval_by = 'admin';
			else $approval_by = find('firstname',$request_detail['approval_by'],'employee_tb')." ".find('lastname',$request_detail['approval_by'],'employee_tb');
			?>
            
          Approval 1 :  <?php echo $approval_date.", ".$approval_by;?>
           <span id="approval_1_comment"><br />
           Comment Approval 1<br>
           <textarea readonly="readonly" rows="5" cols="50" style="resize:none;"><?php echo $request_detail['approval_comment'];?></textarea> 
			</span>            
            
            
            <?php
			
			
			
		}else{
			echo "Approval 1 : -";
		}
		echo "<br />";
		if($request_detail['approval_2_date']!='0000-00-00 00:00:00'){
			$approval_date = date('d F Y',strtotime($request_detail['approval_2_date']));
			if($request_detail['approval_2_by']==0)$approval_by = 'admin';
			else $approval_by = find('firstname',$request_detail['approval_2_by'],'employee_tb')." ".find('lastname',$request_detail['approval_2_by'],'employee_tb');
			?>
            
            
            
           Approval 2 :  <?php echo $approval_date.", ".$approval_by;?>
           <span id="approval_2_comment"><br />
           Comment Approval 2<br>
           <textarea readonly="readonly" rows="5" cols="50" style="resize:none;"><?php echo $request_detail['approval_2_comment'];?></textarea> 
			</span>            
            
            <?php
		}else{
			echo "Approval 2 : -";
		}
		echo "<br />";
		if($request_detail['approval_3_date']!='0000-00-00 00:00:00'){
			$approval_date = date('d F Y',strtotime($request_detail['approval_3_date']));
			if($request_detail['approval_3_by']==0)$approval_by = 'admin';
			else $approval_by = find('firstname',$request_detail['approval_3_by'],'employee_tb')." ".find('lastname',$request_detail['approval_3_by'],'employee_tb');
			
			?>
			   Approval 3 :  <?php echo $approval_date.", ".$approval_by;?>
           <span id="approval_3_comment"><br />
           Comment Approval 3<br>
           <textarea readonly="readonly" rows="5" cols="50" style="resize:none;"><?php echo $request_detail['approval_3_comment'];?></textarea> 
			</span>     
			
	<?php 		
			
		}else{
			echo "Approval 3 : -";
		}
		echo "<br />";
		if($request_detail['approval_4_date']!='0000-00-00 00:00:00'){
			$approval_date = date('d F Y',strtotime($request_detail['approval_4_date']));
			if($request_detail['approval_4_by']==0)$approval_by = 'admin';
			else $approval_by = find('firstname',$request_detail['approval_4_by'],'employee_tb')." ".find('lastname',$request_detail['approval_4_by'],'employee_tb');
		?>
			            
              Approval 4 :  <?php echo $approval_date.", ".$approval_by;?>
           <span id="approval_4_comment" ><br />
           Comment Approval 4<br>
           <textarea readonly="readonly" rows="5" cols="50" style="resize:none;"><?php echo $request_detail['approval_4_comment'];?></textarea> 
			</span> 
	
    <?	}else{
			echo "Approval 4 : -";
		}
		echo "<br />";
		if($request_detail['paid_date']!='0000-00-00 00:00:00'){
			$paid_date = date('d F Y',strtotime($request_detail['paid_date']));
			if($request_detail['paid_by']==0)$paid_by = 'admin';
			else $paid_by = find('firstname',$request_detail['paid_by'],'employee_tb')." ".find('lastname',$request_detail['paid_by'],'employee_tb');
			echo "Paid : ".$paid_date.", ".$paid_by;
		}else{
			echo "Paid : -";
		}
		echo "<br />";
		$created_date = date('d F Y',strtotime($request_detail['created_date']));
		if($request_detail['created_by']==0)$created_by = 'admin';
		else $created_by = find('firstname',$request_detail['created_by'],'employee_tb')." ".find('lastname',$request_detail['created_by'],'employee_tb');
		echo "Created : ".$created_date.", ".$created_by;
		echo "<br />";
		if($request_detail['updated_date']!='0000-00-00'){
			$updated_date = date('d F Y',strtotime($request_detail['updated_date']));
			if($request_detail['created_by']==0)$updated_by = 'admin';
			else $updated_by = find('firstname',$request_detail['updated_by'],'employee_tb')." ".find('lastname',$request_detail['updated_by'],'employee_tb');
			echo "Updated : ".$updated_date.", ".$updated_by;
		}else{
			echo "Updated : -";
		}
		?>
    </div>
    
    <?php } ?>
</div>
<div style="clear:both;"></div><br />

  <?php if($request_detail['is_lock']!='1'){?>

	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/edit_rf","privilege_tb")){?>
  
		<input style="width:80px; height:27px; margin:2px 0;" type="button" value="Update" onclick="edit_request_tab(<?php echo $request_detail['id']?>)" />
       
    <?php }?>
    <?php } ?>
<script>
	function edit_request_tab(id){
		var request_id = $('#request_id').val();
		
		$('.allform').hide();
		$('#edit_request_tab').html('');
		$.ajax({
			url:'<?php echo site_url('budget/get_edit_request/')?>/'+id,
			success: function(temp){
				$('#edit_request_tab').html(temp);
				$('#edit_request_tab').show();
			}
		});
	}
</script>

<input style="width:80px; height:27px; margin:2px 0;" type="button" value="Print" onclick="window.open('<?php echo site_url('budget/print_rf/'.$request_detail['id'])?>')" />

<!--jika tidak approved-->
<?php if($request_detail['not_approval']==0){?>

<?php if($request_detail['approval']==0){?>
	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/approve_1_rf","privilege_tb")){?>
		<input style="width:130px; height:27px; margin:2px 0;" type="button" value="Approval Engineering" onclick="approval(1,<?php echo $request_detail['id']?>)" />
    <?php }?>
<?php }?>
<?php if($request_detail['approval_2']==0){?>
	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/approve_2_rf","privilege_tb")){?>
	<input style="width:120px; height:27px; margin:2px 0;" type="button" value="Approval Support" onclick="approval(2,<?php echo $request_detail['id']?>)" />
    <?php }?>
<?php }?>
<?php if($request_detail['approval_3']==0){?>
	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/approve_3_rf","privilege_tb")){?>
		<input style="width:120px; height:27px; margin:2px 0;" type="button" value="Approval Marketing" onclick="approval(3,<?php echo $request_detail['id']?>)" />
        <?php }?>
<?php }?>
<?php if($request_detail['is_lock']!='1'){?>
<?php if($request_detail['approval_4']==0){?>
	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/approve_4_rf","privilege_tb")){?>
		<input style="width:120px; height:27px; margin:2px 0;" type="button" value="Final Approval" onclick="approval(4,<?php echo $request_detail['id']?>)" />
    <?php }?>
    
<?php }?>
<?php }?>


<!--tutup tidak approve tidak approved-->
<?php } ?>
<?php if($request_detail['is_lock']!='1'){?>
<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/delete_rf","privilege_tb")){
	if($request_detail['approval']==0 || $request_detail['approval_2']==0 || $request_detail['approval_3']==0 || $request_detail['approval_4']==0  ){ if(!$payment_list){?>
	<input style="width:80px; height:27px; margin:2px 0;" type="button" value="Delete" onclick="delete_rf(<?php echo $request_detail['id']?>)" />
<?php }}}?>
<?php } ?>
<script>
	function delete_rf(id){
		var x = confirm('Delete this request?');
		if(x==true){
			window.location = "<?php echo site_url('budget/delete_rf/')?>/"+id;	
		}
	}
</script>
<?php if($request_detail['is_lock']!='1'){?>
<?php if($request_detail['not_approval']!=1 && $request_detail['approval_4']!=1){?>
	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/add_payment","privilege_tb")){?>
    
		
        <input style="width:120px; height:27px; margin:2px 0;" type="button" value="Not Approve" onclick="approval(5,<?php echo $request_detail['id']?>)" />

    <?php }?>
  <?php } ?>
 <?php } ?>


  <?php if($request_detail['is_lock']!='1'){?>

<?php if($request_detail['approval_4']==1){?>
	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/add_payment","privilege_tb")){?>
	<input style="width:80px; height:27px; margin:2px 0;" type="button" onclick="$('#payment_tab').toggle();" value="Payment"  />
    <?php }?>
  <?php }?>
    <div id="payment_tab" style="display:none; margin:5px; border:dashed #000 1px" class="allform">
    	<div style="padding:5px;">
            <form name="payment_form" id="payment_form" method="post" action="<?php echo site_url('budget/add_request_payment/'.$request_detail['id'])?>">
            <input type="hidden" name="approved_by" value="<?php echo $request_detail['approval_4_by']?>" />
                <table class="payment_table">
                    <tr>
                        <td style="width:220px">Bank : 
                            <select name="bank_id" style="width:170px">
                                <option value="0">Select Bank</option>
                                <?php if($bank_list)foreach($bank_list as $list){?>
                                        <option value="<?php echo $list['id']?>"><?php echo $list['name']?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td style="width:170px">Method : 
                            <select name="method" style="width:100px">
                                <option value="0">Transfer</option>
                                <option value="1">Cash</option>
                            </select>
                        </td>
                         <td style="width:150px">Type : 
                            <select name="pay_type" style="width:100px" id="pay_type_payment">
                                <option value="0">Payment</option>
                                <option value="1">Receive</option>
                            </select>
                        </td>
                        <td style="width:180px">Amount : <input type="text" style="width:100px" name="amount" id="amount_payment" onkeyup="formatAmountWithoutPoint(this.value,0,'amount_payment')" /></td>
                        <td> Item : 
                        <?php if($request_item){?>
                            <select name="request_budget_item_id" style="width:100px">
                                <option value="" style="color:#F00;">All</option>
                                <?php if($request_item)foreach($request_item as $listitem){?>
                                    <option value="<?php echo $listitem['id']?>"><?php echo $listitem['bname'].find('item',$listitem['pitem'],'stock_tb')?></option>
                                <?php }?>
                            </select>
                            
                        <?php }?>
                            <?php if($request_item)foreach($request_item as $listitem){?>
                            <input type="hidden" value="<?php echo $listitem['id']?>" name="listitem[]"/>
                            <?php } ?>
                        </td>
                        <td style="width:230px"> Date : <input type="text" readonly="readonly" class="date_selection" style="width:100px" name="pay_date" />
                        <input type="button" value="Pay" onclick="payment();" style="height:27px; width:60px" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php }?>



<?php if($request_detail['is_lock']==0){?>

<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/lock_rf","privilege_tb")){?>
    	<input style="width:80px; height:27px; margin:2px 0;" type="button" onclick="lock('<?php echo $request_detail['is_lock']?>')" value="Lock"  />
       <?php }else{ ?>
       	Your Request Fund Unlocked
       <?php } ?>
<?php }else{?>
<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/unlock_rf","privilege_tb")){?>
    
<input style="width:80px; height:27px; margin:2px 0;" type="button"  onclick="lock('<?php echo $request_detail['is_lock']?>')" value="Unlock"  />

<?php }else{ ?>
	Your Request Fund Locked
<?php } ?>

<?php } ?>

<script>
function lock(lock_status){
id='<?php echo $request_detail['id'];?>';
if(lock_status==0){
	kata='Lock request fund?';
	lock=1;
}else{
	kata='Unlocked request fund?';	
	lock=0;
	}
if (confirm(kata)){
		$.ajax({
						type: "POST",
						url: "<?php echo site_url('budget/lock_budget');?>",
						data: {
							id:id,
							lock:lock,
						},
						success: function(data){
							location.reload();		
						}	
			});


	}else{
	
}





}
</script>




<!-- edit -->
<div id="edit_request_tab" style="display:none; margin:5px; border:solid #999 1px; background:#F2F2F2" class="allform"></div>


<span style="display:none" id="comment_approve_form">
<br /><br />

<label id="name_comment"> Comment </label><br />
<input type="hidden" value=""  id="type_comment_approve"/>
<input type="hidden" value="" id="request_id_value" />
<textarea name="comment" id="comment_approve" rows="10" cols="50"></textarea><br /><br />
<input type="submit" value="submit" onclick="submit_form_click();" />

</span>



<?php 
   $rf_17 = "budget/budget_log";
if(find_4_string("id","module",$rf_17,"privilege_user_id",$this->session->userdata('admin_privilege'),"privilege_tb")){?> 
<?php  
$list_itemss=array();
if($request_item){
	foreach($request_item as $list){
		$list_itemss[]=$list['project_goal_po_client_item_id'];
	}
}

if($po_client_item){?>

<!-- summary -->


    <hr style="border:dotted #000 1px" />
    <b>Summary</b><br /><br />
    <div style="">
        <div style="padding:3px;">
                    
            <table width="554" class="logging">
                <tr>
                    <td width="38" style="border:solid #999 1px;"><b>No</b></td>
                    <td width="133" style="border:solid #999 1px;text-align:center"><b>Budget Name</b></td>
                    <td width="127" style="border:solid #999 1px;text-align:center"><b>Used</b></td>
                    <td width="139" style="border:solid #999 1px;text-align:center"><b>Total Budget</b></td>
                    <td width="93" style="border:solid #999 1px;text-align:center"><b>Percentage</b></td>
                </tr>
            <?php 
            $no = 1;$total_a=$total_b=0;
            foreach($po_client_item as $list){?>
            
                <!-- get total -->
                <?php $total = 0;$rbid=0;$ppn=0;
                if($request_budget_item)foreach($request_budget_item as $listitem){
					if($listitem['request_budget_id']!=$rbid){
						$rbid=$listitem['request_budget_id'];
						$ppn=find('is_ppn',$rbid,'request_budget_tb');
					}
                    if($listitem['project_goal_po_client_item_id']==$list['id']){
						if($ppn==0)
                        $total+=$listitem['total'];
						else
						$total+=($listitem['total']*1.1);
                    }
                }
				$pgp_id=0;$ppn2=0;
				if($po_request_non_stock_item)foreach($po_request_non_stock_item as $listitem){
					if($listitem['project_goal_po_id']!=$pgp_id){
						$pgp_id=$listitem['project_goal_po_id'];
						$ppn=find('is_ppn',$pgp_id,'project_goal_po_tb');
					}
                    if($listitem['project_goal_po_client_item_id']==$list['id']){
						if($ppn==0)
                        $total+=$listitem['total'];
						else
						$total+=($listitem['total']*1.1);
                    }
				}
				
				if($po_request_stock_item)foreach($po_request_stock_item as $listitem){
					
                    if($listitem['project_goal_po_client_item_id']==$list['id']){
						$total+=$listitem['qty']*$listitem['price'];
                    }
				}
				if($list['total']>0 && $total>0)$percentage=($total/$list['total'])*100;else $percentage=0;
				if($percentage>90)$mandatorycomment=1;
				?>
                <tr class="list">
                    <td style="text-align:right;border:solid #999 1px;"><?php echo $no;?></td>
                    <td style="border:solid #999 1px;"><?php echo find('item',$list['item'],'stock_tb');?></td>
                    <td style="border:solid #999 1px;" align="right"><?php echo number_format($total);$total_a+=$total;?></td>
                    <td style="border:solid #999 1px;" align="right"><?php echo number_format($list['total']);$total_b+=$list['total'];?></td>
                    <td style="border:solid #999 1px;<?php if($percentage>90)echo "background-color:red;color:white;"?>" align="right"><?php echo round($percentage,2)." %";?>
                    
                    </td>
                </tr>
            <?php $no++;?>
            <?php }?>
            <?php if($total_a>0 && $total_b>0)$percentage2=($total_a/$total_b)*100;else $percentage2=0;?>
                <tr class="list">
            	<td style="border:solid #999 1px;" colspan="2"><b>Total</b></td>
                <td style="border:solid #999 1px;" align="right"><?php echo number_format($total_a)?></td>
                <td style="border:solid #999 1px;" align="right"><?php echo number_format($total_b)?></td>
                <td style="border:solid #999 1px;<?php if($percentage2>90)echo "background-color:red;color:white;"?>" align="right"><?php echo round($percentage2,2)." %";?></td>
            </tr>
            </table>
        </div>
    </div>
<!-- summarh-->
<br />
<?php }?>	


<?php  
if($budget_log){?>
    
    <hr style="border:dotted #000 1px" />
    <b>Summary</b><br /><br />
    <div style="padding:3px;">
                
        <table width="554" class="logging">
            <tr>
                <td width="38" style="border:solid #999 1px;"><b>No</b></td>
                <td width="133" style="border:solid #999 1px;text-align:center"><b>Budget Name</b></td>
                <td width="127" style="border:solid #999 1px;text-align:center"><b>Total</b></td>
                <td width="139" style="border:solid #999 1px;text-align:center"><b>Used</b></td>
                <td width="93" style="border:solid #999 1px;text-align:center"><b>Percentage</b></td>
            </tr>
            <?php 
            $no = 1;$total_a=$total_b=0;
			foreach($budget_log as $list){?>
            <!-- get total -->
            <?php $total = 0;
            if($budget_log_list)foreach($budget_log_list as $listitem){
                if($listitem['budget_id']==$list['budget_id'] && $listitem['is_moved']==0){
                    $total+=$listitem['item_total'];
                }
            }?>
            <?php 
				if($list['amount']>0 && $total>0)$percentage=($total/$list['amount'])*100;else $percentage=0;
				if($percentage>90)$mandatorycomment=1;
				?>
            <tr class="list">
                <td style="text-align:right;border:solid #999 1px;"><?php echo $no;?></td>
                <td style="border:solid #999 1px;"><?php echo $list['bname']?></td>
                <td style="border:solid #999 1px;" align="right"><?php echo number_format($total);$total_a+=$total;?></td>
                <td style="border:solid #999 1px;" align="right"><?php echo number_format($list['amount']);$total_b+=$list['amount'];?></td>
				<td style="border:solid #999 1px;<?php if($percentage>90)echo "background-color:red;color:white;"?>" align="right"><?php echo round($percentage,2)." %";?></td>
                
            </tr>
            <?php $no++;?>
        <?php }?>
        <?php if($total_a > 0 && $total_b>0)$percentage2=($total_a/$total_b)*100;else $percentage2=0;?>
                <tr class="list">
            	<td style="border:solid #999 1px;" colspan="2"><b>Total</b></td>
                <td style="border:solid #999 1px;" align="right"><?php echo number_format($total_a)?></td>
                <td style="border:solid #999 1px;" align="right"><?php echo number_format($total_b)?></td>
                <td style="border:solid #999 1px;<?php if($percentage2>90)echo "background-color:red;color:white;"?>" align="right"><?php echo round($percentage2,2)." %";?></td>
            </tr>
        </table>
    </div>
    
    
    <!-- summarh-->
    
    

<?php }?>

<?php }?>	
<script>
	function approval(type,request_id){
		
		
		
		if(type==1){
			$('#name_comment').html('Comment Engineering');
		$('#comment_approve_form').show();
		}else if(type==2){
			$('#name_comment').html('Comment Support');	
		$('#comment_approve_form').show();
		}else if(type==3){
			$('#name_comment').html('Comment Marketing');	
		$('#comment_approve_form').show();
		}else if(type==4){
			<?php 
			if($request_detail['approval']==1 && $request_detail['approval_2']==1 && $request_detail['approval_3']==1){?>
			$('#name_comment').html('Comment Final Approval');
			$('#comment_approve_form').show();
			<?php }else{
				$msg="Approval ";
				if($request_detail['approval']==0)$msg.=" 1";
				if($request_detail['approval_2']==0)$msg.=" 2";
				if($request_detail['approval_3']==0)$msg.=" 3";
				
				$msg.=" Not Complete";
				?>
			
			if(confirm('<?php echo $msg?>. Continue?')){
				$('#name_comment').html('Comment Final Approval');
				
				$('#comment_approve_form').show();
			}
				
				
			<?php }?>
			
		}else if(type==5){
		
			$('#name_comment').html('Comment Not Approval');
				$('#comment_approve_form').show();
		}
		
		$("#type_comment_approve").val(type);
		$("#request_id_value").val(request_id);	
		/*var x = confirm('Approve this request?');
		if(x==true){
			window.location = '<?php echo site_url('budget/approve_request_budget/')?>/'+type+'/'+request_id;
		}
		return false;*/
	}
	
	function approval_1_toogle(){
		$("#approval_1_comment").toggle();
	}
	function approval_2_toogle(){
		$("#approval_2_comment").toggle();
	}
	function approval_3_toogle(){
		$("#approval_3_comment").toggle();
	}
	function approval_4_toogle(){
		$("#approval_4_comment").toggle();
	}
	
	
	
	function submit_form_click(){
		var name_comment=$("#comment_approve").val();
		var type=$("#type_comment_approve").val();		
		var request_id=$("#request_id_value").val();
		<?php if($mandatorycomment==1){?>
		if(name_comment==''){
			alert('Comment must be filled');
			return true;
		}
		<?php }?>	
		var x = confirm('Approve this request?');
			if(x==true){
				$.ajax({
					type: "POST",
					dataType:"JSON",
					url: "<?php echo site_url('budget/approve_request_budget');?>",
					data: {
						name_comment:name_comment,
						type:type,
						request_id:request_id
					},
					success: function(data){
						location.reload();		
					}	
				});
			}
	}
	
	function payment(){
		var x = confirm('Confirm this payment?');
		if(x==true){
			var pay = parseInt($('#amount_payment').val().replace(/,/g,""));
			var pay_total = parseInt($('#total_pay').html().replace(/,/g,""));
			var type_payment=	$( "#pay_type_payment option:selected" ).text();
			if(type_payment=='Receive'){
					$('#payment_form').submit();
				
			}else{
			
				if(pay<=pay_total && pay >= 0 && pay != ''){
					$('#payment_form').submit();
				}else{
					
					alert('Payment cannot be empty or more than total payment.');	
				}
			}
		}
		return false;
	}
</script>

<hr style="border:dotted #000 1px" />
<table>
	<tr style="background-color:#CCC">
    	<td style="width:10px">No</td>
        <td style="width:200px">Budget</td>
        <td style="width:200px">PO Item</td>
        <td style="width:300px">Description</td>
        <td style="width:100px">Vendor</td>
        <td style="width:100px">Quantity</td>
        <td style="width:100px">Unit Rate</td>
        <td style="width:100px">Discount</td>
        <td style="width:50px">Subtotal</td>
        <td style="width:50px">PPN</td>
        <td style="width:50px">Total</td>
        <td style="width:50px">Bank</td>
        <td style="width:100px">Acc Name</td>
        <td style="width:100px">Acc Number</td>
    </tr>
    <?php 
	$no = 1;$total_items=0;
	if($request_item){foreach($request_item as $list){$total_items+=$list['total'];$list_itemss[]=$list['project_goal_po_client_item_id'];?>
        <tr>
            <td style="text-align:right"><?php echo $no;?></td>
            <td><?php echo $list['bname']?></td>
            <td><?php $a=find('item',$list['pitem'],'stock_tb');
			
			if($a)echo $a;else echo $list['pitem'];
			;?></td>
            <td><?php echo $list['description']?></td>
            <td><?php //echo (is_numeric($list['vendor_name']))? "number":"not";
			if($list['vendor_name']!='' && $list['vendor_name']!='a' && is_numeric($list['vendor_name']))
			echo find('name',$list['vendor_name'],'vendor_tb');
			else echo ($list['vendor_name']!='a')?$list['vendor_name']:""?></td>
            <td style="text-align:right"><?php echo number_format($list['quantity'])?></td>
            <td style="text-align:right"><?php echo number_format($list['price'])?></td>
            <td style="text-align:right"><?php echo number_format($list['discount']).'%'?></td>
            <td style="text-align:right"><?php echo number_format($list['subtotal'])?></td>
            <td style="text-align:center"><?php echo ($list['ppn']==1)?"Yes":"No";?></td>
            <td style="text-align:right"><?php echo number_format($list['total'])?></td>
            <td><?php echo $list['bank_name']?></td>
            <td><?php echo $list['acc_name']?></td>
            <td><?php echo $list['acc_number']?></td>
        </tr>
    <?php $no++; $subtotall+=$list['subtotal']; 
	}?>
        <tr>
            <td colspan="8"></td>
            <td style="text-align:right"><?php echo number_format($subtotall);?></td>
            <td>&nbsp;</td>
			<td><?php echo number_format($total_items)?></td>
            <td></td>
            <td></td>
        </tr>
        <?php /*if($request_detail['is_ppn']==1){ ?>
			<tr>
			 <td colspan="8" align="right">PPN</td>
			 <td><?php echo number_format($total_items*0.1); ?></td>
			 <td colspan="4"></td>
		   </tr>
		   <tr>
			 <td colspan="8" align="right">Grand Total</td>
			 <td><?php echo number_format($total_items*1.1); ?></td>
			 <td colspan="4"></td>
		   </tr>
         <?php }*/ ?>
    <?php 
	}?>
</table>
<?php if($request_log){?>
<div>
	<?php $total_difference = $request_detail['total']-$request_log['total'];
	if($total_difference<0){
		echo "<span style='color:#F00'><br />over payments : ".number_format(abs($total_difference))."</span>";	
	}else{
		echo "<span style='color:#00F'><br />deficiency payments : ".number_format(abs($total_difference))."</span>";
	}
	?>
</div>
<?php }?>

<?php if($request_log){?>
	<div style="background:#EEE; font-style:italic">
	<?php 
	$request_log_item = json_decode($request_log['data_2'],true);
	?>
	<hr style="border:dotted #000 1px" />
	<b>BS Log</b><br /><br />
    <table class="dottedTable">
        <tr style="background-color:#DDD">
            <td style="width:10px">No</td>
            <td style="width:200px">Budget</td>
            <td style="width:200px">PO Item</td>
            <td style="width:300px">Description</td>
            <td style="width:100px">Vendor</td>
            <td style="width:100px">Quantity</td>
            <td style="width:100px">Unit Rate</td>
            <td style="width:50px">Total</td>
            <td style="width:50px">Bank</td>
            <td style="width:100px">Acc Name</td>
            <td style="width:100px">Acc Number</td>
        </tr>
        <?php 
        $no = 1;
        if($request_log_item)foreach($request_log_item as $list){?>
            <tr>
                <td style="text-align:right"><?php echo $no;?></td>
                <td><?php echo $list['bname']?></td>
                <td><?php echo $list['pitem']?></td>
                <td><?php echo $list['description']?></td>
                <td><?php //echo (is_numeric($list['vendor_name']))? "number":"not";
                if($list['vendor_name']!='' && $list['vendor_name']!='a' && is_numeric($list['vendor_name']))
                echo find('name',$list['vendor_name'],'vendor_tb');
                else echo $list['vendor_name']?></td>
                <td style="text-align:right"><?php echo number_format($list['quantity'])?></td>
                <td style="text-align:right"><?php echo number_format($list['price'])?></td>
                <td style="text-align:right"><?php echo number_format($list['total'])?></td>
                <td><?php echo $list['bank_name']?></td>
                <td><?php echo $list['acc_name']?></td>
                <td><?php echo $list['acc_number']?></td>
            </tr>
        <?php $no++; 
        }?>
    </table>
    </div>
<?php }?>

<?php $total = 0;
if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/view_payment","privilege_tb")){?>
	<?php if($payment_list){?>
    <hr style="border:dotted #000 1px" />
    <b>Payment</b><br /><br />
    <table class="logging">
        <tr>
            <td style="width:10px">No</td>
            <td style="width:250px">Bank</td>
            <td style="text-align:center; widows:170px">Method</td>
            <td style="text-align:center; widows:150px">Type</td>
            <td style="width:150px; text-align:center">Amount</td>
            <td style="width:150px">Item</td>
            <td style="width:150px; text-align:center">Pay Date</td>
            <td style="width:250px; text-align:center">Created</td>
            <td style="width:100px"></td>
              <td style="width:100px"></td>
            
        </tr>
        <?php 
        $no = 1; $total = 0;
        foreach($payment_list as $list){?>
            <tr class="list" <?php if($list['pay_type']==1)echo "style='color:#00F; font-style:italic !important;'"?>>
                <td style="text-align:right;"><?php echo $no?></td>
                <td><?php echo $list['bname']?></td>
                <td style="text-align:center"><?php if($list['method']==1)echo "Cash";else echo "Transfer";?></td>
                <td style="text-align:center"><?php if($list['pay_type']==1)echo "Received";else echo "Payment";?></td>
                <td style="text-align:center"><?php echo number_format($list['amount'])?></td>
                <td>
                <?php 
                if($list['request_budget_item_id']==0)echo "all";
                else{
                    $budget_id = find('budget_id',$list['request_budget_item_id'],'request_budget_item_tb');
                    $project_goal_po_client_item_id = find('project_goal_po_client_item_id',$list['request_budget_item_id'],'request_budget_item_tb');	
                    if($budget_id!=0)echo find('name',$budget_id,'budget_tb');
                    elseif($project_goal_po_client_item_id!=0)echo find('item',find('item',$project_goal_po_client_item_id,'project_goal_po_client_item_tb'),'stock_tb');
                }
                ?>
                </td>
                <td style="text-align:center"><?php echo date('d F Y',strtotime($list['pay_date']))?></td>
                <td style="text-align:center"><?php echo date('d F Y',strtotime($list['created_date']))?> - 
                    <?php if($list['created_by']==0)echo "admin";else echo find('firstname',$list['created_by'],'employee_tb')." ".find('lastname',$list['created_by'],'employee_tb')?>
                </td>
                <td style="text-align:center">
                <?php if($list['status']==0){?>
                	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/edit_payment","privilege_tb")){?>
                    	<a href="javascript:void(0)" onclick="$('.payment_edit').hide();$('#payment_<?php echo $list['id']?>').show();"><img src="<?php echo base_url()?>images/edit.png" width="10"></a>
                    <?php }?>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/delete_payment","privilege_tb")){?>
                    	<a href="<?php echo site_url('budget/remove_payment/'.$list['id'])?>" onclick="return confirm('Cancel this payment?')" style="color:#F00; text-decoration:none"><img src="<?php echo base_url()?>images/delete.png" width="10"></a>
                    <?php }?>
                <?php }else{?>
                	<?php /*if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/delete_payment","privilege_tb")){?>
                    	<a href="<?php echo site_url('budget/remove_payment/'.$list['id'])?>" onclick="return confirm('Cancel this payment?')" style="color:#F00; text-decoration:none"><img src="<?php echo base_url()?>images/delete.png" width="10"></a> 
                    <?php }*/?>
                    Confirmed<br /> <?php echo date('d F Y',strtotime($list['done_date']))?>
                <?php }?>
                </td>
                  <td style="width:100px">
                     <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/unconfirm_payment","privilege_tb")){?>
                  <?php if($list['status']!=0){?>
                  <a href="<?php echo site_url('budget/unconfirm_paymet').'/'.$list['id']?>" onclick="return confirm('are you sure');">Unconfirmed</a>
                  <?php } ?>
                  
                <?php }?>
                  </td>
            
            </tr>
            <tr class="payment_edit" style="background:#F2F2F2; display:none" id="payment_<?php echo $list['id']?>">
            	<form name="edit_payment<?php echo $list['id']?>" method="post" action="<?php echo site_url('budget/update_payment/'.$list['id'])?>">
                <input type="hidden" name="request_budget_id" value="<?php echo $list['request_budget_id']?>" />
                <td></td>
                <td>
                    <select name="bank_id" style="width:170px">
                        <?php if($bank_list)foreach($bank_list as $listbank){?>
                                <option value="<?php echo $listbank['id']?>" <?php if($list['bid']==$listbank['id'])echo "selected=selected"?>><?php echo $listbank['name']?></option>
                        <?php }?>
                    </select>
                </td>
                <td style="width:170px; text-align:center">
                    <select name="method" style="width:100px">
                        <option value="0">Transfer</option>
                        <option value="1" <?php if($list['method']==1)echo "selected=selected"?>>Cash</option>
                    </select>
                </td>
                <td style="width:150px; text-align:center"> 
                    <select name="pay_type" style="width:100px" id="check_pay_type">
                        <option value="0">Payment</option>
                        <option value="1" <?php if($list['pay_type']==1)echo "selected=selected"?>>Receive</option>
                    </select>
                </td>
                <td style="text-align:center"><input type="text" style="width:100px;" name="amount" id="amount_payment<?php echo $list['id']?>" onkeyup="formatAmountWithoutPoint(this.value,0,'amount_payment<?php echo $list['id']?>')" value="<?php echo number_format($list['amount'])?>" /></td>
                
                <td>
                <?php if($request_item){?>
                    <select name="request_budget_item_id" style="width:100px">
                        <option value="" style="color:#F00;">All</option>
                        <?php if($request_item)foreach($request_item as $listitem){?>
                            <option value="<?php echo $listitem['id']?>" <?php if($list['request_budget_item_id']==$listitem['id'])echo "selected=selected"?>><?php echo $listitem['bname'].find('item',$listitem['pitem'],'stock_tb')?></option>
                        <?php }?>
                    </select>
                <?php }?>
                </td>
                
                <td style="text-align:center"><input type="text" readonly="readonly" class="date_selection" style="width:100px" value="<?php echo $list['pay_date']?>" name="pay_date" /></td>
                <td colspan="2" style="text-align:center"><input type="submit" value="update" style="height:27px; width:60px" /></td>
                </form>
                
            </tr>
        <?php $no++; 
        if($list['pay_type']==0){
            $total+=$list['amount'];
        }else{
            $total-=$list['amount'];	
        }
        }?>
        <tr>
            <td colspan="4" style="text-align:right">Total</td>
            <td style="text-align:center"><b><?php echo number_format($total)?></b></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:right"><i>Difference</i></td>
            <td style="text-align:center; color:#F00"><i><?php echo number_format($request_detail['total']-$total)?></i>
            
            </td>
            <td colspan="5"></td>
        </tr>
    </table>
    <?php }?>
<?php }?>
<div id="total_pay" style="display:none"><?php echo $request_detail['total']-$total?></div>



<?php 
   $rf_17 = "budget/budget_log";
if(find_4_string("id","module",$rf_17,"privilege_user_id",$this->session->userdata('admin_privilege'),"privilege_tb")){?> 
<!--budget log!-->
<?php $this->load->view('budget/budget_log_new')?>
<?php } ?>


<?php //$this->load->view('budget/request_budget_log')?>
<div style="clear:both"></div>
<hr style="border:dotted #000 1px" />
<input style="width:180px; height:27px; margin:2px 0;" type="button" value="Back to request budget list" onclick="window.location='<?php echo site_url('budget/request_budget_list')?>'" />
<?php 
if($request_detail['pid']){
	$project_goal = find_2('id','project_id',$request_detail['pid'],'project_goal_tb');
	if($project_goal){?>
		<input style="width:180px; height:27px; margin:2px 0;" type="button" value="Back to project detail" onclick="window.location='<?php echo site_url('project/detail_project_goal/'.$project_goal.'#budget_tab_site')?>'" />
    <?php	
	}
}
?>

<script>
	$('.date_selection').datepicker({
		numberOfMonths: 1,
		showButtonPanel: true,
		yearRange: "-80:+80",
		changeYear: true,
		dateFormat: "yy-mm-dd",
		minDate: "-80y"
	});
</script>