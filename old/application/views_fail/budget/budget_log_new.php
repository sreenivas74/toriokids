
<?php   $rf_17 = "budget/budget_log";
		$rf_18 = "budget/budget_summary";
if($budget_log){?>
    <hr style="border:dotted #000 1px" />
    <b>Logs</b><br /><br />
    <div style="">
        <?php foreach($budget_log as $list){?>
    
        <!-- get total -->
        <?php $total = 0;
        if($budget_log_list)foreach($budget_log_list as $listitem){
            if($listitem['budget_id']==$list['budget_id'] && $listitem['is_moved']==0){
                $total+=$listitem['item_total'];
            }
        }?>
        <div style="height:300px;overflow:auto; border:solid #666 1px; margin:0 5px 5px 0;">
            <div style="padding:3px;">
                <?php echo "<b>".$list['bname']." </b>"?>
                <table class="logging" width="100%">
                    <tr>
                        <td style="border:solid #999 1px;"><b>No</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Amount</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Request Number</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Description</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Created</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Approval 1</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Approval 2</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Approval 3</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Approval 4</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Payment Date</b></td>
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
                            <tr class="list">
                                <td style="text-align:right;border:solid #999 1px;"><?php echo $no;?></td>
                                <td style="border:solid #999 1px;" align="right"><?php echo number_format($listitem['item_total'])?></td>
                                <?php /*?><td style="text-align:center"><?php echo $listitem['request_number']?></td><?php */?>
                                
                                <td style="border:solid #999 1px;"><?php if($request_budget_id){?><a target="_blank" href="<?php echo site_url('budget/detail/'.$request_budget_id)?>"><?php echo $listitem['request_number']?></a><?php }else{?><?php echo $listitem['request_number']?><?php }?></td>
                                <td style="border:solid #999 1px;"><?php echo $listitem['description']?></td>
                                <td style="border:solid #999 1px;">
                                    <?php echo date('d F Y',strtotime($listitem['created_date']));
                                    if($listitem['created_by']==0)echo " - admin";
                                    else echo " - ".find('firstname',$listitem['created_by'],'employee_tb')." ".find('lastname',$listitem['created_by'],'employee_tb');
                                    ?>
                                </td>
                                <td style="border:solid #999 1px;">
                                <?php echo ($listitem['approval_by']!=0)?find('firstname',$listitem['approval_by'],'employee_tb')." ".find('lastname',$listitem['approval_by'],'employee_tb'):"-";?>
                                </td>
                                <td style="border:solid #999 1px;">
                                <?php echo ($listitem['approval_2_by']!=0)?find('firstname',$listitem['approval_2_by'],'employee_tb')." ".find('lastname',$listitem['approval_2_by'],'employee_tb'):"-";?>
                                </td>
                                <td style="border:solid #999 1px;">
                                <?php echo ($listitem['approval_3_by']!=0)?find('firstname',$listitem['approval_3_by'],'employee_tb')." ".find('lastname',$listitem['approval_3_by'],'employee_tb'):"-";?>
                                </td>
                                <td style="border:solid #999 1px;">
                                <?php echo ($listitem['approval_4_by']!=0)?find('firstname',$listitem['approval_4_by'],'employee_tb')." ".find('lastname',$listitem['approval_4_by'],'employee_tb'):"-";?>
                                </td>
                                <td style="border:solid #999 1px;"><?php echo get_rf_payment_date($request_budget_id)?></td>
                            </tr>
                    <?php $no++;
                        }
                    }?>
                </table>
            </div>
        </div>
    <?php }?>
    </div>
        
    
        
    <!-- summary -->
    
    <?php /*?>
    <hr style="border:dotted #000 1px" />
    <b>Summary</b><br /><br />
    <div style="padding:3px;"><?php $percentage=($total/$list['amount'])*100;?>
                
        <table width="554" class="logging">
            <tr>
                <td width="38" style="border:solid #999 1px;"><b>No</b></td>
                <td width="133" style="border:solid #999 1px;text-align:center"><b>Budget Name</b></td>
                <td width="127" style="border:solid #999 1px;text-align:center"><b>Total</b></td>
                <td width="139" style="border:solid #999 1px;text-align:center"><b>Used</b></td>
                <td width="93" style="border:solid #999 1px;text-align:center"><b>Percentage</b></td>
            </tr>
            <?php 
            $no = 1;foreach($budget_log as $list){?>
            <!-- get total -->
            <?php $total = 0;
            if($budget_log_list)foreach($budget_log_list as $listitem){
                if($listitem['budget_id']==$list['budget_id'] && $listitem['is_moved']==0){
                    $total+=$listitem['item_total'];
                }
            }?>
            <tr class="list">
                <td style="text-align:right;border:solid #999 1px;"><?php echo $no;?></td>
                <td style="border:solid #999 1px;"><?php echo $list['bname']?></td>
                <td style="border:solid #999 1px;" align="right"><?php echo number_format($total)?></td>
                <td style="border:solid #999 1px;" align="right"><?php echo number_format($list['amount'])?></td>
                <td style="border:solid #999 1px;" align="right"><?php $percentage=($total/$list['amount'])*100;echo round($percentage,2)." %"?></td>
                
            </tr>
            <?php $no++;?>
        <?php }?>
        </table>
    </div>
    <?php */?>
    
    <!-- summarh-->
    
    

<?php }?>

<?php  
$list_itemss=array();
//pre($po_client_item);
if($request_item){
	foreach($request_item as $list){
		$list_itemss[]=$list['project_goal_po_client_item_id'];
	}
}

if($po_client_item){?>

    <hr style="border:dotted #000 1px" />
    <b>Logs</b><br /><br />

    <!-------- --->
    <div style="">
		<?php $xx=0;
        foreach($po_client_item as $list){ if(in_array($list['id'],$list_itemss)){?>
        
        <!-- get total -->
        <?php //pre($list);
			$total_per_item=0;
            if($request_budget_item)foreach($request_budget_item as $listitem){
                if($listitem['project_goal_po_client_item_id']==$list['id'])
                $total_per_item+=$listitem['total_item'];
            }
            ?>
        <?php $percentage=($total_per_item/$list['total'])*100;?>
                    
        <div style="height:300px;overflow:auto; border:solid #666 1px; margin:0 5px 5px 0;">
            <div style="padding:3px;"><?php //$percentage=($total/$list['amount'])*100;?>
                
                    
                    <?php echo "<b>".$list['item']." </b>"?>
				<table class="logging" width="100%">
                    <tr>
                        <td style="border:solid #999 1px;"><b>No</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Amount</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Request Number</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Description</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Created</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Approval 1</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Approval 2</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Approval 3</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Approval 4</b></td>
                        <td style="border:solid #999 1px;text-align:center"><b>Payment Date</b></td>
                    </tr>
            <?php 
                $no = 1;$totalxxx=0;//pre($budget_log_list_2);
                if($request_budget_item)foreach($request_budget_item as $listitem){
                    if($listitem['project_goal_po_client_item_id']==$list['id']){
                        $request_budget_id=$listitem['request_budget_id'];
                        //$item_total=find('total',
                        if($listitem['log_status']==0)$color='black';
                        else if($listitem['log_status']==1)$color='blue';
                        else $color="green";
                        ?>
                    <tr class="list">
                        <td style="text-align:right;border:solid #999 1px;"><?php echo $no;?></td>
                        <td style="border:solid #999 1px;" align="right"><?php echo number_format($listitem['total']);$totalxxx+=$listitem['total'];?></td>
                        <?php /*?><td style="text-align:center"><?php echo $listitem['request_number']?></td><?php */?>
                        
                        <td style="border:solid #999 1px;"><?php if($request_budget_id){?><a target="_blank" href="<?php echo site_url('budget/detail/'.$request_budget_id)?>"><?php echo $listitem['request_budget_number']?></a><?php }else{?><?php echo $listitem['request_budget_number']?><?php }?></td>
                        <td style="border:solid #999 1px;"><?php echo $listitem['description']?></td>
                        <td style="border:solid #999 1px;">
                            <?php echo date('d F Y',strtotime($listitem['created_date']));
                            if($listitem['created_by']==0)echo " - admin";
                            else echo " - ".find('firstname',$listitem['created_by'],'employee_tb')." ".find('lastname',$listitem['created_by'],'employee_tb');
                            ?>
                        </td>
                        <td style="border:solid #999 1px;">
                        <?php echo ($listitem['approval_by']!=0)?find('firstname',$listitem['approval_by'],'employee_tb')." ".find('lastname',$listitem['approval_by'],'employee_tb'):"-";?>
                        </td>
                        <td style="border:solid #999 1px;">
                        <?php echo ($listitem['approval_2_by']!=0)?find('firstname',$listitem['approval_2_by'],'employee_tb')." ".find('lastname',$listitem['approval_2_by'],'employee_tb'):"-";?>
                        </td>
                        <td style="border:solid #999 1px;">
                        <?php echo ($listitem['approval_3_by']!=0)?find('firstname',$listitem['approval_3_by'],'employee_tb')." ".find('lastname',$listitem['approval_3_by'],'employee_tb'):"-";?>
                        </td>
                        <td style="border:solid #999 1px;">
                        <?php echo ($listitem['approval_4_by']!=0)?find('firstname',$listitem['approval_4_by'],'employee_tb')." ".find('lastname',$listitem['approval_4_by'],'employee_tb'):"-";?>
                        </td>
                        <td style="border:solid #999 1px;"><?php echo get_rf_payment_date($request_budget_id)?></td>
                    </tr>
            <?php $no++;
                }
            }?>
				</table>
			</div>
		</div>
        <?php 
		
		
		}}?>
	</div>
    <!-------- --->
    
<!-- summary -->

<?php /*?>
    <hr style="border:dotted #000 1px" />
    <b>Summary</b><br /><br />
    <div style="">
        <div style="padding:3px;"><?php //$percentage=($total/$list['total'])*100;?>
                    
            <table width="554" class="logging">
                <tr>
                    <td width="38" style="border:solid #999 1px;"><b>No</b></td>
                    <td width="133" style="border:solid #999 1px;text-align:center"><b>Budget Name</b></td>
                    <td width="127" style="border:solid #999 1px;text-align:center"><b>Total</b></td>
                    <td width="139" style="border:solid #999 1px;text-align:center"><b>Used</b></td>
                    <td width="93" style="border:solid #999 1px;text-align:center"><b>Percentage</b></td>
                </tr>
            <?php 
            $no = 1;
            foreach($po_client_item as $list){?>
            
                <!-- get total -->
                <?php $total = 0;
                if($request_budget_item)foreach($request_budget_item as $listitem){
                    if($listitem['project_goal_po_client_item_id']==$list['id']){
                        $total+=$listitem['total'];
                    }
                }?>
                <tr class="list">
                    <td style="text-align:right;border:solid #999 1px;"><?php echo $no;?></td>
                    <td style="border:solid #999 1px;"><?php echo $list['item']?></td>
                    <td style="border:solid #999 1px;" align="right"><?php echo number_format($total)?></td>
                    <td style="border:solid #999 1px;" align="right"><?php echo number_format($list['total'])?></td>
                    <td style="border:solid #999 1px;" align="right"><?php $percentage=($total/$list['total'])*100;echo round($percentage,2)." %"?></td>
                </tr>
            <?php $no++;?>
            <?php }?>
            </table>
        </div>
    </div>

<?php */?>
<!-- summarh-->

    
    
<?php }?>	