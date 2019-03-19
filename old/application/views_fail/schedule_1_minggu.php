<?php 	if(date("N")==1)$z=1;
elseif(date("N")==2)$z=1;
elseif(date("N")==3)$z=1;
elseif(date("N")==4)$z=1;
elseif(date("N")==5)$z=1;
elseif(date("N")==6)$z=1;
elseif(date("N")==7)$z=1;?>

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
    	<?php if($department_list)foreach($department_list as $list){?>
            <tr>
                <td colspan="5"><b><?php echo $list['name']?></b></td>
            </tr>
            <?php if($employee_active)foreach($employee_active as $list2){
					if($list2['department_id'] == $list['id']){?>
                        <tr>
                            <td valign="top" colspan="5">&bull; <?php echo $list2['firstname']." ".$list2['lastname']?>
                            <div id="add_schedule_to" style="display:none">
                            	
                            </div>
                            </td>
                        </tr>
                        <?php if(find_4_string('description','date_now',date('D d/m/Y'),'employee_id',$list2['id'],'schedule_tb')){?>
                            <tr>
                                <td></td>
                                <td valign="top"><?php echo find_4_string('description','date_now',date('D d/m/Y'),'employee_id',$list2['id'],'schedule_tb')?>
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
        <?php }?>
    </tbody>
</table>

<h2><?php echo date('D d/m/Y',strtotime('+1 day',strtotime(date('Y-m-d'))));?></h2>
<table class="form" style="width:100%">
    <thead>
        <th width="15%">Name</th>
        <th>Description</th>
        <th width="15%">PIC</th>
        <th width="10%">Telp</th>
        <th width="10%">Jam</th>
    </thead>
    <tbody>
    	<?php if($department_list)foreach($department_list as $list){?>
            <tr>
                <td colspan="5"><b><?php echo $list['name']?></b></td>
            </tr>
            <?php if($employee_active)foreach($employee_active as $list2){
					if($list2['department_id'] == $list['id']){?>
                        <tr>
                            <td valign="top" colspan="5">&bull; <?php echo $list2['firstname']." ".$list2['lastname']?></td>
                        </tr>
                        <?php if(find_4_string('description','date_now',date('Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')){?>
                            <tr>
                                <td></td>
                                <td valign="top"><?php echo find_4_string('description','date_now',date('Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php }?>
                        <?php
                            if($schedule_to_list)foreach($schedule_to_list as $list3){
                                if($list3['activity_date']==date('Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d')))) && $list3['employee_id']==$list2['id']){?>
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
        <?php }?>
    </tbody>
</table>

<h2><?php echo date('D d/m/Y',strtotime('+2 day',strtotime(date('Y-m-d'))));?></h2>
<table class="form" style="width:100%">
    <thead>
        <th width="15%">Name</th>
        <th>Description</th>
        <th width="15%">PIC</th>
        <th width="10%">Telp</th>
        <th width="10%">Jam</th>
    </thead>
    <tbody>
    	<?php if($department_list)foreach($department_list as $list){?>
            <tr>
                <td colspan="5"><b><?php echo $list['name']?></b></td>
            </tr>
            <?php if($employee_active)foreach($employee_active as $list2){
					if($list2['department_id'] == $list['id']){?>
                        <tr>
                            <td valign="top" colspan="5">&bull; <?php echo $list2['firstname']." ".$list2['lastname']?></td>
                        </tr>
                        <?php if(find_4_string('description','date_now',date('Y-m-d',strtotime('+2 day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')){?>
                            <tr>
                                <td></td>
                                <td valign="top"><?php echo find_4_string('description','date_now',date('Y-m-d',strtotime('+2 day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php }?>
                        <?php
                            if($schedule_to_list)foreach($schedule_to_list as $list3){
                                if($list3['activity_date']==date('Y-m-d',strtotime('+2 day',strtotime(date('Y-m-d')))) && $list3['employee_id']==$list2['id']){?>
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
        <?php }?>
    </tbody>
</table>

<h2><?php echo date('D d/m/Y',strtotime('+3 day',strtotime(date('Y-m-d'))));?></h2>
<table class="form" style="width:100%">
    <thead>
        <th width="15%">Name</th>
        <th>Description</th>
        <th width="15%">PIC</th>
        <th width="10%">Telp</th>
        <th width="10%">Jam</th>
    </thead>
    <tbody>
    	<?php if($department_list)foreach($department_list as $list){?>
            <tr>
                <td colspan="5"><b><?php echo $list['name']?></b></td>
            </tr>
            <?php if($employee_active)foreach($employee_active as $list2){
					if($list2['department_id'] == $list['id']){?>
                        <tr>
                            <td valign="top" colspan="5">&bull; <?php echo $list2['firstname']." ".$list2['lastname']?></td>
                        </tr>
                        <?php if(find_4_string('description','date_now',date('Y-m-d',strtotime('+3 day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')){?>
                            <tr>
                                <td></td>
                                <td valign="top"><?php echo find_4_string('description','date_now',date('Y-m-d',strtotime('+3 day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php }?>
                        <?php
                            if($schedule_to_list)foreach($schedule_to_list as $list3){
                                if($list3['activity_date']==date('Y-m-d',strtotime('+3 day',strtotime(date('Y-m-d')))) && $list3['employee_id']==$list2['id']){?>
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
        <?php }?>
    </tbody>
</table>

<h2><?php echo date('D d/m/Y',strtotime('+4 day',strtotime(date('Y-m-d'))));?></h2>
<table class="form" style="width:100%">
    <thead>
        <th width="15%">Name</th>
        <th>Description</th>
        <th width="15%">PIC</th>
        <th width="10%">Telp</th>
        <th width="10%">Jam</th>
    </thead>
    <tbody>
    	<?php if($department_list)foreach($department_list as $list){?>
            <tr>
                <td colspan="5"><b><?php echo $list['name']?></b></td>
            </tr>
            <?php if($employee_active)foreach($employee_active as $list2){
					if($list2['department_id'] == $list['id']){?>
                        <tr>
                            <td valign="top" colspan="5">&bull; <?php echo $list2['firstname']." ".$list2['lastname']?></td>
                        </tr>
                        <?php if(find_4_string('description','date_now',date('Y-m-d',strtotime('+4 day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')){?>
                            <tr>
                                <td></td>
                                <td valign="top"><?php echo find_4_string('description','date_now',date('Y-m-d',strtotime('+4 day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php }?>
                        <?php
                            if($schedule_to_list)foreach($schedule_to_list as $list3){
                                if($list3['activity_date']==date('Y-m-d',strtotime('+4 day',strtotime(date('Y-m-d')))) && $list3['employee_id']==$list2['id']){?>
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
        <?php }?>
    </tbody>
</table>

<h2><?php echo date('D d/m/Y',strtotime('+5 day',strtotime(date('Y-m-d'))));?></h2>
<table class="form" style="width:100%">
    <thead>
        <th width="15%">Name</th>
        <th>Description</th>
        <th width="15%">PIC</th>
        <th width="10%">Telp</th>
        <th width="10%">Jam</th>
    </thead>
    <tbody>
    	<?php if($department_list)foreach($department_list as $list){?>
            <tr>
                <td colspan="5"><b><?php echo $list['name']?></b></td>
            </tr>
            <?php if($employee_active)foreach($employee_active as $list2){
					if($list2['department_id'] == $list['id']){?>
                        <tr>
                            <td valign="top" colspan="5">&bull; <?php echo $list2['firstname']." ".$list2['lastname']?></td>
                        </tr>
                        <?php if(find_4_string('description','date_now',date('Y-m-d',strtotime('+5 day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')){?>
                            <tr>
                                <td></td>
                                <td valign="top"><?php echo find_4_string('description','date_now',date('Y-m-d',strtotime('+5 day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php }?>
                        <?php
                            if($schedule_to_list)foreach($schedule_to_list as $list3){
                                if($list3['activity_date']==date('Y-m-d',strtotime('+5 day',strtotime(date('Y-m-d')))) && $list3['employee_id']==$list2['id']){?>
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
        <?php }?>
    </tbody>
</table>

<h2><?php echo date('D d/m/Y',strtotime('+6 day',strtotime(date('Y-m-d'))));?></h2>
<table class="form" style="width:100%">
    <thead>
        <th width="15%">Name</th>
        <th>Description</th>
        <th width="15%">PIC</th>
        <th width="10%">Telp</th>
        <th width="10%">Jam</th>
    </thead>
    <tbody>
    	<?php if($department_list)foreach($department_list as $list){?>
            <tr>
                <td colspan="5"><b><?php echo $list['name']?></b></td>
            </tr>
            <?php if($employee_active)foreach($employee_active as $list2){
					if($list2['department_id'] == $list['id']){?>
                        <tr>
                            <td valign="top" colspan="5">&bull; <?php echo $list2['firstname']." ".$list2['lastname']?></td>
                        </tr>
                        <?php if(find_4_string('description','date_now',date('Y-m-d',strtotime('+6 day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')){?>
                            <tr>
                                <td></td>
                                <td valign="top"><?php echo find_4_string('description','date_now',date('Y-m-d',strtotime('+6 day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php }?>
                        <?php
                            if($schedule_to_list)foreach($schedule_to_list as $list3){
                                if($list3['activity_date']==date('Y-m-d',strtotime('+6 day',strtotime(date('Y-m-d')))) && $list3['employee_id']==$list2['id']){?>
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
        <?php }?>
    </tbody>
</table>

<h2><?php echo date('D d/m/Y',strtotime('+7 day',strtotime(date('Y-m-d'))));?></h2>
<table class="form" style="width:100%">
    <thead>
        <th width="15%">Name</th>
        <th>Description</th>
        <th width="15%">PIC</th>
        <th width="10%">Telp</th>
        <th width="10%">Jam</th>
    </thead>
    <tbody>
    	<?php if($department_list)foreach($department_list as $list){?>
            <tr>
                <td colspan="5"><b><?php echo $list['name']?></b></td>
            </tr>
            <?php if($employee_active)foreach($employee_active as $list2){
					if($list2['department_id'] == $list['id']){?>
                        <tr>
                            <td valign="top" colspan="5">&bull; <?php echo $list2['firstname']." ".$list2['lastname']?></td>
                        </tr>
                        <?php if(find_4_string('description','date_now',date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')){?>
                            <tr>
                                <td></td>
                                <td valign="top"><?php echo find_4_string('description','date_now',date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d')))),'employee_id',$list2['id'],'schedule_tb')?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php }?>
                        <?php
                            if($schedule_to_list)foreach($schedule_to_list as $list3){
                                if($list3['activity_date']==date('Y-m-d',strtotime('+7 day',strtotime(date('Y-m-d')))) && $list3['employee_id']==$list2['id']){?>
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
        <?php }?>
    </tbody>
</table>