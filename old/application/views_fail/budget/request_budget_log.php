
<?php if($budget_log_2){//untuk project PO?>
<hr style="border:dotted #000 1px;clear:both" />
<b>Log</b><br /><br />
<div style="width:1040px">
		<?php 
		//pre($budget_log_2);
		//pre($po_client_item);
		foreach($budget_log_2 as $list){?>
    
    	<!-- get total -->
        <?php $total = 0;
		$exists_items=array();
		if($budget_log_list_2)foreach($budget_log_list_2 as $listitem){
			$exists_items[]=$listitem['project_goal_po_client_item_id'];
			if($listitem['project_goal_po_client_item_id']==$list['project_goal_po_client_item_id']){
				$total+=$listitem['total_item'];
			}
		}?>
        <div style="width:500px; height:300px; float:left; overflow:auto; border:solid #666 1px; margin:0 5px 5px 0;">
            <div style="padding:3px;">
                <?php echo "<b>".$list['bname']." </b>[ ".number_format($total)."/".number_format($list['amount'])." ]"?>
                <table class="logging" style="width:480px">
                	<tr>
                    	<td style="width:10px">No</td>
                        <td style="width:100px; text-align:center">Amount</td>
                        <td style="width:150px; text-align:center">Request Number</td>
                        <td style="width:220px; text-align:center">Created</td>
                    </tr>
                    <?php 
					$no = 1;//pre($budget_log_list_2);
					if($budget_log_list_2)foreach($budget_log_list_2 as $listitem){
						if($listitem['project_goal_po_client_item_id']==$list['project_goal_po_client_item_id']){
							$request_budget_id=$listitem['request_budget_id'];?>
							<tr class="list">
								<td style="text-align:right"><?php echo $no;?></td>
								<td style="text-align:center"><?php echo number_format($listitem['total_item'])?></td>
								<?php /*?><td style="text-align:center"><?php echo $listitem['request_number']?></td><?php */?>
                                
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


<?php  $total = 0; 
if($po_client_item)foreach($po_client_item as $listpoclient){
	if(!in_array($listpoclient['id'],$exists_items)){
	//if($listpoclient['type']==1){?>
		<div style="width:500px; height:300px; float:left; overflow:auto; border:solid #666 1px; margin:0 5px 5px 0;">
            <div style="padding:3px;">
            	
                <?php 
				if($po_request_non_stock_item)foreach($po_request_non_stock_item as $listitem){
					if($listitem['project_goal_po_client_item_id']==$listpoclient['id']){
						$total+=$listitem['price'];
					}
				}
				if($po_request_stock_item)foreach($po_request_stock_item as $listitemstock){
					if($listitemstock['project_goal_po_client_item_id']==$listpoclient['id']){
						$total+=$listitemstock['price'];
					}
				}
				?>
                    
            	
                <?php echo "<b>".$listpoclient['item']." </b>[ ".number_format($total)."/".number_format($listpoclient['total'])." ]"?>
                <table class="logging" style="width:480px">
                	<tr>
                    	<td style="width:10px">No</td>
                        <td style="width:100px; text-align:center">Amount</td>
                        <td style="width:150px; text-align:center">PO number</td>
                        <td style="width:220px; text-align:center">Created</td>
                    </tr>
                    <?php 
					$no = 1;
					if($po_request_non_stock_item)foreach($po_request_non_stock_item as $listitem){
						if($listitem['project_goal_po_client_item_id']==$listpoclient['id']){?>
							<tr class="list" <?php if($listitem['approval_date']=='0000-00-00 00:00:00')echo "style='font-style:italic;'"?>>
								<td style="text-align:right"><?php echo $no;?></td>
								<td style="text-align:center"><?php echo number_format($listitem['price'])?></td>
								<td style="text-align:center"><a href="<?php echo site_url('budget/po_non_stock_detail/'.$listitem['project_goal_po_id'])?>" target="_blank" title="View Detail"><?php echo $listitem['po_number']?></a></td>
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
                    
                   
                    <?php 
					$no = 1;
					if($po_request_stock_item)foreach($po_request_stock_item as $listitemstock){
						if($listitemstock['project_goal_po_client_item_id']==$listpoclient['id']){?>
							<tr class="list">
								<td style="text-align:right"><?php echo $no;?></td>
								<td style="text-align:center"><?php echo number_format($listitemstock['price'])?></td>
								<td style="text-align:center">Stock</td>
								<td style="text-align:center;">
									<?php echo date('d F Y',strtotime($listitemstock['created_date']));
									if($listitemstock['created_by']==0)echo " - admin";
									else echo " - ".find('firstname',$listitemstock['created_by'],'employee_tb')." ".find('lastname',$listitemstock['created_by'],'employee_tb');
									?>
                                </td>
							</tr>
                    <?php $no++;
						}
					}?>
                    
                    
                    
                    
                </table>
            </div>
        </div>
<?php //}
	}
}?>

<?php }?>