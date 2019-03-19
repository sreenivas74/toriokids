<form name="crm_deadline" action="<?php echo site_url('home/crm_deadline_send_email');?>">
	<input type="submit" value="send email">
</form><hr size="1">
<h2>CRM deadline 1 month from now</h2>
<table class="form" style="width:100%">
    <thead>
        <th>Project Name</th>
        <th>Marketing</th>
        <th>Client</th>
        <th>Nominal</th>
        <th>Expected Close Date</th>
    </thead>
    <tbody>
    	<?php if($crm_deadline_list)foreach($crm_deadline_list as $list){?>
            <tr>
                <td valign="top"><b><?php echo $list['name']?></b></td>
                <td valign="top"><?php echo find('firstname',$list['employee_id'],'employee_tb')." ".find('lastname',$list['employee_id'],'employee_tb');?></td>
                <td valign="top"><?php echo find('name',$list['client_id'],'client_tb');?></td>
                <td valign="top" align="right"><?php echo currency($list['amount']);?></td>
                <td valign="top" align="center"><?php if($list['expected_close_date']!=0000-00-00)echo date('d/m/Y',strtotime($list['expected_close_date']));?></td>
            </tr>
       	<?php }?>
    </tbody>
</table>

<h2>CRM 1 Month No-Update</h2>
<table class="form" style="width:100%">
    <thead>
        <th>Project Name</th>
        <th>Marketing</th>
        <th>Client</th>
        <th>Nominal</th>
        <th>Expected Close Date</th>
        <th>Last Update</th>
    </thead>
    <tbody>
    	<?php if($crm_updated_list)foreach($crm_updated_list as $list){
			if($list['sales_stage']!=4){?>
            <tr>
                <td valign="top"><b><?php echo $list['name']?></b></td>
                <td valign="top"><?php echo find('firstname',$list['employee_id'],'employee_tb')." ".find('lastname',$list['employee_id'],'employee_tb');?></td>
                <td valign="top"><?php echo find('name',$list['client_id'],'client_tb');?></td>
                <td valign="top" align="right"><?php echo currency($list['amount']);?></td>
                <td valign="top" align="center"><?php if($list['expected_close_date']!=0000-00-00)echo date('d/m/Y',strtotime($list['expected_close_date']));?></td>
                <td valign="top" align="center"><?php if($list['update_date']!=0000-00-00)echo date('d/m/Y',strtotime($list['update_date']));?></td>
            </tr>
       	<?php }
		}?>
    </tbody>
</table>

<h2>Pending Payment</h2>
<table class="form" style="width:100%">
    <thead>
        <th>Project</th>
        <th>Invoice</th>
        <th>BAST</th>
        <th>Outstanding IDR</th>
        <th>Outstanding USD</th>
    </thead>
    <?php if($pending_payment_dashboard)foreach($pending_payment_dashboard as $list){
				//$idr = 0;$usd=0;
				if($list['pgi_bast']!=0000-00-00 && $list['name']!='' && (($list['pgi_total'] - find_2_total('sum(dp_idr)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1) || ($list['total_2'] - find_2_total('sum(dp_usd)as total','project_goal_invoice_id',$list['pgi_id'],'project_goal_payment_tb')>1))){?>
					
					<tr>
						<td valign="top"><?php echo $list['name']?></td>
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
					
		<?php } }?>
</table>

<?php for($x=0;$x<8;$x++){
		if($x==0){?>
    	<h2><?php echo date('D d/m/Y');?></h2>
        <table class="form" style="width:100%">
            <thead>
                <th width="15%">Name</th>
                <th>Description</th>
                <th width="15%">PIC</th>
                <th width="10%">Telp</th>
                <th width="10%">Jam</th>
            </thead>
            <tbody>
                <?php if($department_list)foreach($department_list as $list){
                    if($list['id'] == 4){?>
                    <tr>
                        <td colspan="5"><b><?php echo $list['name']?></b></td>
                    </tr>
                    <?php if($employee_active)foreach($employee_active as $list2){
                            if($list2['department_id'] == $list['id']){?>
                                <tr>
                                    <td valign="top" colspan="5">&bull; <?php echo $list2['firstname']." ".$list2['lastname']?></td>
                                </tr>
                                <?php if(find_4_string('description','date_now',date('Y-m-d'),'employee_id',$list2['id'],'schedule_tb') || find_4_string('description','activity_date',date('Y-m-d'),'employee_id',$list2['id'],'project_employee_activity_tb')){?>
                                    <tr>
                                        <td></td>
                                        <td valign="top">
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/detail_schedule/'.find_4_string('id','date_now',date('Y-m-d'),'employee_id',$list2['id'],'schedule_tb'))?>"><?php echo find_4_string('description','date_now',date('Y-m-d'),'employee_id',$list2['id'],'schedule_tb')?></a><br />
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_employee_activity/'.find_4_string('id','activity_date',date('Y-m-d'),'employee_id',$list2['id'],'project_employee_activity_tb'))?>"><?php echo find_4_string('description','activity_date',date('Y-m-d'),'employee_id',$list2['id'],'project_employee_activity_tb')?></a>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php }?>
                                <?php
                                    if($schedule_to_list)foreach($schedule_to_list as $list3){
                                        if($list3['activity_date']==date('Y-m-d') && $list3['employee_id']==$list2['id']){?>
                                        <tr>
                                            <td></td>
                                            <td valign="top"><?php echo nl2br($list3['description']);?></td>
                                            <td valign="top"><?php echo nl2br($list3['pic']);?></td>
                                            <td valign="top"><?php echo nl2br($list3['phone']);?></td>
                                            <td valign="top"><?php echo nl2br($list3['time']);?></td>
                                        </tr>
                                    <?php }
                                    }?>
                        <?php }
                        }?>
                        <tr>
                            <td colspan="5" bgcolor="#999999"></td>
                        </tr>
                <?php }}?>
            </tbody>
        </table>
    <?php }else{?>
    	<h2><?php echo date('D d/m/Y',strtotime('+'.$x.' day',strtotime(date('Y-m-d'))));?></h2>
        <table class="form" style="width:100%">
            <thead>
                <th width="15%">Name</th>
                <th>Description</th>
                <th width="15%">PIC</th>
                <th width="10%">Telp</th>
                <th width="10%">Jam</th>
            </thead>
            <tbody>
                <?php if($department_list)foreach($department_list as $list){
                    if($list['id'] == 4){?>
                    <tr>
                        <td colspan="5"><b><?php echo $list['name']?></b></td>
                    </tr>
                    <?php if($employee_active)foreach($employee_active as $list2){
                            if($list2['department_id'] == $list['id']){?>
                                <tr>
                                    <td valign="top" colspan="5">&bull; <?php echo $list2['firstname']." ".$list2['lastname']?></td>
                                </tr>
                                <?php if(find_4_string('description','date_now',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb') || find_4_string('description','activity_date',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'project_employee_activity_tb')){?>
                                    <tr>
                                        <td></td>
                                        <td valign="top"><a style="text-decoration:none; color:#000" href="<?php echo site_url('schedule/detail_schedule/'.find_4_string('id','date_now',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb'))?>"><?php echo find_4_string('description','date_now',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')?></a><br />
                                        <a style="text-decoration:none; color:#000" href="<?php echo site_url('project/detail_employee_activity/'.find_4_string('id','activity_date',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'project_employee_activity_tb'))?>"><?php echo find_4_string('description','activity_date',date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'project_employee_activity_tb')?></a>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php }?>
                                <?php
                                    if($schedule_to_list)foreach($schedule_to_list as $list3){
                                        if($list3['activity_date']==date('Y-m-d',strtotime('+'.$x.' day',strtotime(date('Y-m-d')))) && $list3['employee_id']==$list2['id']){?>
                                        <tr>
                                            <td></td>
                                            <td valign="top"><?php echo nl2br($list3['description']);?></td>
                                            <td valign="top"><?php echo nl2br($list3['pic']);?></td>
                                            <td valign="top"><?php echo nl2br($list3['phone']);?></td>
                                            <td valign="top"><?php echo nl2br($list3['time']);?></td>
                                        </tr>
                                    <?php }
                                    }?>
                        <?php }
                        }?>
                        <tr>
                            <td colspan="5" bgcolor="#999999"></td>
                        </tr>
                <?php }}?>
            </tbody>
        </table>
    <?php }?>
<?php }?>