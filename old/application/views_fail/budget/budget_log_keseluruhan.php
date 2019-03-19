

<?php 
//pre($po_client_item);
if($po_client_item){?>
<hr style="border:dotted #000 1px;clear:both" />
<b>Log</b><br /><br />
    <div style="width:1040px">
    
                       <?php //pre($po_request_stock_item);?>
                       <?php //pre($po_request_non_stock_item);?>
                       <?php //pre($request_budget_item);?>
                       <?php //pre($po_client_item)?>
                       <?php //pre($budget_log_list)?>
    <?php foreach($po_client_item as $list){//pre($list)?>
    
        <div style="width:500px; height:300px; float:left; overflow:auto; border:solid #666 1px; margin:0 5px 5px 0;">
                    <div style="padding:3px;">
                    <?php
                    $total_per_item=0;
                            if($request_budget_item)foreach($request_budget_item as $listitem){
                                if($listitem['project_goal_po_client_item_id']==$list['id'])
                                $total_per_item+=$listitem['total_item'];
                            }
                            ?>
                    <?php $percentage=($total_per_item/$list['total'])*100;?>
                    
                    <?php if($percentage>70){?><span style="color:red;"><?php }?>
                        <?php echo "<b>".$list['item']." ".$list['description']." </b>[ ".number_format($total_per_item)."/".number_format($list['total'])." ] ".round($percentage,2)." %"?>
                        
                    <?php if($percentage>70){?></span><?php }?>
                        <table class="logging" style="width:480px">
                            <tr>
                                <td style="width:10px">No</td>
                                <td style="width:100px; text-align:center">Amount</td>
                                <td style="width:150px; text-align:center">Request Number</td>
                                <td style="width:220px; text-align:center">Created</td>
                            </tr>
                           <?php 
                            $no = 1;//pre($budget_log_list_2);
                            if($request_budget_item)foreach($request_budget_item as $listitem){
                                if($listitem['project_goal_po_client_item_id']==$list['id']){
                                    $request_budget_id=$listitem['request_budget_id'];
                                    //$item_total=find('total',
                                    if($listitem['log_status']==0)$color='black';
                                    else if($listitem['log_status']==1)$color='blue';
                                    else $color="green";
                                    ?>
                                    <tr class="list" <?php echo "style=\"color:".$color."\""?>>
                                        <td style="text-align:right"><?php echo $no;?></td>
                                        <td style="text-align:center"><?php echo number_format($listitem['total_item'])?></td>
                                        <?php /*?><td style="text-align:center"><?php echo $listitem['request_number']?></td><?php */?>
                                        
                                        <td style="text-align:center"><?php if($request_budget_id){?><a target="_blank" href="<?php echo site_url('budget/detail/'.$request_budget_id)?>"><?php echo $listitem['request_budget_number']?></a><?php }else{?><?php echo $listitem['request_number']?><?php }?></td>
                                        <td style="text-align:center;">
                                            <?php echo date('d F Y',strtotime($listitem['created_date']));
                                            if($listitem['created_date']==0)echo " - admin";
                                            else echo " - ".find('firstname',$listitem['created_by'],'employee_tb')." ".find('lastname',$listitem['created_by'],'employee_tb');
                                            ?>
                                        </td>
                                    </tr>
                            <?php $no++;
                                }
                            }?>
                        </table>
                    </div>
                </div>
    <?php }?>
    
    </div>
<?php }?>




<?php if($budget_log){?>
<hr style="border:dotted #000 1px" />
<b>Logs</b><br /><br />
<div style="width:1040px">
		<?php foreach($budget_log as $list){?>
    
    	<!-- get total -->
        <?php $total = 0;
		if($budget_log_list)foreach($budget_log_list as $listitem){
			if($listitem['budget_id']==$list['budget_id'] && $listitem['is_moved']==0){
				$total+=$listitem['item_total'];
			}
		}?>
        <div style="width:500px; height:300px; float:left; overflow:auto; border:solid #666 1px; margin:0 5px 5px 0;">
            <div style="padding:3px;">
            <?php $percentage=($total/$list['amount'])*100;?>
            
            <?php if($percentage>70){?><span style="color:red;"><?php }?>
                <?php echo "<b>".$list['bname']." </b>[ ".number_format($total)."/".number_format($list['amount'])." ] ".round($percentage,2)." %"?>
                
            <?php if($percentage>70){?><span style="color:red;"><?php }?>
                <table class="logging" style="width:480px">
                	<tr>
                    	<td style="width:10px">No</td>
                        <td style="width:100px; text-align:center">Amount</td>
                        <td style="width:150px; text-align:center">Request Number</td>
                        <td style="width:220px; text-align:center">Created</td>
                    </tr>
                    <?php 
					$no = 1;//pre($budget_log_list);
					if($budget_log_list)foreach($budget_log_list as $listitem){
						if($listitem['budget_id']==$list['budget_id']){
							$request_budget_id=find('request_budget_id',$listitem['request_budget_item_id'],'request_budget_item_tb');
							if($listitem['log_status']==0)$color='black';
							else if($listitem['log_status']==1)$color='blue';
							else $color="green";
							?>
							<tr class="list" <?php echo "style=\"color:".$color."\""?>>
								<td style="text-align:right"><?php echo $no;?></td>
								<td style="text-align:center"><?php echo number_format($listitem['item_total'])?></td>
								<td style="text-align:center"><?php if($request_budget_id){?><a target="_blank" href="<?php echo site_url('budget/detail/'.$request_budget_id)?>"><?php echo $listitem['request_number']?></a><?php }else{?><?php echo $listitem['request_number']?><?php }?></td>
								<td style="text-align:center;">
									<?php echo date('d F Y',strtotime($listitem['created_date']));
									if($listitem['created_by']==0)echo " - admin";
									else echo " - ".find('firstname',$listitem['created_by'],'employee_tb')." ".find('lastname',$listitem['created_by'],'employee_tb');
									?>
                                </td>
							</tr>
                    <?php $no++;
						}
					}?>
                </table>
            </div>
        </div>
    <?php }?>
</div>
<?php }?>

