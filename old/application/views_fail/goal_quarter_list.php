<b><?php echo find('firstname',$employee_id,'employee_tb')." ".find('lastname',$employee_id,'employee_tb')?></b>
<table class="form">
	<thead>
    	<th>Project Name</th>
    </thead>
    <tbody>
    	<?php if($goal_quarter_list)foreach($goal_quarter_list as $list){?>
    	<tr>
        	<td><a target="_blank" href="<?php echo site_url('project/detail_project_goal/'.$list['pg_id']);?>" style="text-decoration:none; color:#000"><?php echo $list['p_name']?></a></td>
        </tr>
        <?php }?>
    </tbody>
</table>