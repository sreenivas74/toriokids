<b><?php echo find('firstname',$employee_id,'employee_tb')." ".find('lastname',$employee_id,'employee_tb')?></b> - 
<b><?php if($sales_stage == 1)echo "Potential";
			elseif($sales_stage == 2)echo "Quotation";
			elseif($sales_stage == 3)echo "Tender/Review";
			else echo "others";?></b>
<table class="form">
	<thead>
    	<th>Project Name</th>
    </thead>
    <tbody>
    	<?php if($crm_project_list)foreach($crm_project_list as $list){?>
    	<tr>
        	<td><a target="_blank" href="<?php echo site_url('project/detail_crm/'.$list['id']);?>" style="text-decoration:none; color:#000"><?php echo $list['name']?></a></td>
        </tr>
        <?php }?>
    </tbody>
</table>