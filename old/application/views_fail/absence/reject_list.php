
<h2>Recap Detail - Periode ( <?php echo date("d F Y",($periode_from))?> - <?php echo date("d F Y",($periode_to))?> ) </h2>

<form name="salary_form" method="post" action="<?php echo site_url('absence/do_update_rejected_salary_by_periode/')?>" enctype="multipart/form-data">
<input type="hidden" value="<?php echo $type?>" name="type" />
<input type="hidden" value="<?php echo count($reject_list)+1?>" name="qty" /> 
<input type="hidden" value="<?php echo date("Y-m-d 00:00:00",($periode_from))?>" name="periode_from" />
<input type="hidden" value="<?php echo date("Y-m-d 00:00:00",($periode_to))?>" name="periode_to" />
<input type="hidden" value="<?php echo find_active_day(date("Y-m-d 00:00:00",($periode_from)),date("Y-m-d 00:00:00",($periode_to)))?>" name="active_day" />
<input type="submit" value="update" onclick="return confirm('Are you sure?');return false;" style="padding:4px;" />
<input type="button" value="abensi list" onclick="window.location = '<?php echo site_url('absence/absent_list')?>'" style="padding:4px;" />
<br /><br />
<span style="background-color:#0FF">&nbsp;</span> : SSS, <span style="background-color:#FF0">&nbsp;</span> : WSI
<?php if(isset($_SESSION['admin_notif']))echo "<br /><span class='warning'>* ".$_SESSION['admin_notif']."</span><br />";?>
<div style="position:fixed; width:1154px; height:40px; overflow:hidden">
<table class="form" <?php if($type >1)echo "style=width:100%; color:#000";else echo "style=width:50%; color:#000";?>>
	<thead>
    	<tr><th>No</th>
    	<th>Employee</th>
        
        <th>Absent</th>
        <th>off</th>
        <th>Telat</th>
        <th>Overtime 1</th>
        <th>Overtime 2</th>
        <th>Overide</th>
        
        <?php if($type >1){?>
        	<th>Target</th>
            <th>Bonus Performance</th>
            <th>Potongan Telat Masuk</th>
            <th>Kelebihan Pembayaran</th>
            <th>Kekurangan Pembayaran</th>
            <th>Celengan</th>
            <th>Tambah Utang</th>
            <th>Bayar Utang</th>
        <?php }?>
        </tr>
    </thead>
    <tbody style="opacity:0;">
    <?php $n = 1 ;

	if($department_list)foreach($department_list as $list2){?>
    	<tr>
        	<td colspan="13"><b><?php echo $list2['name']?></b></td>
        </tr>
        <?php if($company_list)foreach($company_list as $list3){?>
			<?php if($reject_list)foreach($reject_list as $list){
                    if($list2['id']==find_2('department_id','userid',$list['user_id'],'employee_tb') && $list3['id']==find_2('company_id','userid',$list['user_id'],'employee_tb')){?>
                    
                    <tr <?php if(find_2('company_id','userid',$list['user_id'],'employee_tb')==2){ echo "style=background-color:#0FF"; }elseif(find_2('company_id','userid',$list['user_id'],'employee_tb')==3){ echo "style=background-color:#FF0"; }?>> 
                        <td align="right"><?php echo $n;?></td>
                        <td>
                        <a href="#" onclick="open_note(<?php echo $list['id']?>);return false;"><img src="<?php echo base_url()?>images/assign.png" width="10px" /></a>
                        
                        <input type="hidden"  value="<?php echo $list['user_id']?>" /><?php echo find_2('firstname','userid',$list['user_id'],'employee_tb')." ".find_2('lastname','userid',$list['user_id'],'employee_tb');?>
                        <input type="hidden" value="<?php echo $list['id']?>" />
                        </td>
                        
                        <td align="center">
                        <?php if($type==2){?>
                            <?php echo $list['working_day']?>
                            <input style="width:30px;" type="hidden" value="<?php echo $list['working_day'] ?>"  />
                        <?php }else{?>
                            <input style="width:30px;" type="text" value="<?php echo $list['working_day'] ?>" />
                        <?php }?>
                        </td>
                        <td align="center">
                        <?php if($type==2){?>
                            <?php echo $list['absent']?>
                            <input style="width:30px;" type="hidden" value="<?php echo $list['absent'] ?>" />
                        <?php }else{?>
                            <input style="width:30px;" type="text" value="<?php echo $list['absent'] ?>" />
                        <?php }?>
                        </td>
                        <td align="center">
                        <?php if($type==2){?>
                            <?php echo $list['late']?>
                            <input style="width:30px;" type="hidden" value="<?php echo $list['late'] ?>" />
                        <?php }else{?>
                            <input style="width:30px;" type="text" value="<?php echo $list['late'] ?>" />
                        <?php }?>
                        </td>
                        <td align="center">
                        <?php if(find_2('department_id','userid',$list['user_id'],'employee_tb')==1){?>
                                <?php if($type==2){?>
                                    <?php echo $list['overtime_1']?>
                                    <input style="width:30px;" type="hidden" value="<?php echo $list['overtime_1'] ?>"  />
                                <?php }else{?>
                                    <input style="width:30px;" type="text" value="<?php echo $list['overtime_1'] ?>"  />
                                <?php }?>
                            <?php }else{?>
                                -
                                <input  type="hidden" value="<?php echo $list['overtime_1'] ?>"/>
                            <?php }?>
                        </td>
                        <td align="center">
                        <?php if(find_2('department_id','userid',$list['user_id'],'employee_tb')==1){?>
                                <?php if($type==2){?>
                                    <?php echo $list['overtime_2']?>
                                    <input style="width:30px;" type="hidden" value="<?php echo $list['overtime_2'] ?>"  />
                                <?php }else{?>
                                    <input style="width:30px;" type="text" value="<?php echo $list['overtime_2'] ?>"  />
                                <?php }?>
                            <?php }else{?>
								<?php if($type==2){?>
                                	<?php echo $list['overtime_2']?>
                                    <input  type="hidden" style="width:30px;"  value="<?php echo $list['overtime_2'] ?>"  />
                                <?php }else{?>
                                	<input  type="text" style="width:30px;"  value="<?php echo $list['overtime_2'] ?>"  />
                                <?php }?>
                            <?php }?>
                        </td>
                        <td align="center">
                        <?php if($type==2){?>
                            <?php echo $list['overide']?>
                            <input style="width:30px;" type="hidden" value="<?php echo $list['overide'] ?>"  />
                        <?php }else{?>
                            <input style="width:30px;" type="text" value="<?php echo $list['overide'] ?>"/>
                        <?php }?>
                        </td>
                        <?php if($type>1){?>
                        <td align="center">
                        <?php if(find_2('department_id','userid',$list['user_id'],'employee_tb')==4){?>
                                <input type="checkbox" value="1" <?php if($list['target'])echo "checked=checked";?>  />
                        <?php }else{?>
                                -
                        <?php }?>
                        </td>
                        
                        <?php if($list['bonus_performance']>0){
                            $performance = $list['bonus_performance'];	
                        }else{
                            if(!$list['late'] && !$list['absent']){
                                if($list['bonus_perfomance_update']==0){
                               	 $performance = 4*find_2('meal','userid',$list['user_id'],'employee_salary_tb');	
								}else{
								 $performance=0;
								}
                            }else{
                                $performance = 0;	
                            }
                        }?>
                        <td align="center"><input style="width:70px;" type="text" value="<?php echo $performance?>" /></td>
                        <td align="center">
                        <?php 
						if($list['late_cost']){
							$late_cost = $list['late_cost'];
						}else{
							if(find_2('department_id','userid',$list['user_id'],'employee_tb')==6){
									$late_cost = $list['late']*25000;
							}else{
								$late_cost = $list['late']*10000;
							}
						}?>
                            
                        <input style="width:70px;" type="text" value="<?php echo $late_cost?>" />
                        </td>
                        <td align="center"><input style="width:70px;" type="text" value="<?php echo $list['over_payment'] ?>"/></td>
                        <td align="center"><input style="width:70px;" type="text" value="<?php echo $list['under_payment'] ?>" /></td>
                        <td align="center"><input style="width:70px;" type="text" value="<?php echo $list['meeting_cost'] ?>"/></td>
                       
                        <td align="center"><input type="text" style="width:70px;" value="<?php echo $list['debt']?>"/></td>
                        <td align="center"><input type="text" style="width:70px;" value="<?php echo $list['paid']?>"/></td>
                        <?php }?>
                    </tr>
            <?php $n++;
                    }
            }
		}
	}?>
               
    </tbody>
</table>
</div>
<table class="form" <?php if($type >1)echo "style=width:100%; color:#000";else echo "style=width:50%; color:#000";?>>
	<thead>
    	<tr><th>No</th>
    	<th>Employee</th>
        
        <th>Absent</th>
        <th>off</th>
        <th>Telat</th>
        <th>Overtime 1</th>
        <th>Overtime 2</th>
        <th>Overide</th>
        
        <?php if($type >1){?>
        	<th>Target</th>
            <th>Bonus Performance</th>
            <th>Potongan Telat Masuk</th>
            <th>Kelebihan Pembayaran</th>
            <th>Kekurangan Pembayaran</th>
            <th>Celengan</th>
            <th>Tambah Utang</th>
            <th>Bayar Utang</th>
        <?php }?>
        </tr>
    </thead>
    <tbody>
    <?php $n = 1 ;
	if($department_list)foreach($department_list as $list2){?>
    	<tr>
        	<td colspan="13"><b><?php echo $list2['name']?></b></td>
        </tr>
        <?php if($company_list)foreach($company_list as $list3){?>
			<?php if($reject_list)foreach($reject_list as $list){
                    if($list2['id']==find_2('department_id','userid',$list['user_id'],'employee_tb') && $list3['id']==find_2('company_id','userid',$list['user_id'],'employee_tb')){?>
                    
                    <tr <?php if(find_2('company_id','userid',$list['user_id'],'employee_tb')==2){ echo "style=background-color:#0FF"; }elseif(find_2('company_id','userid',$list['user_id'],'employee_tb')==3){ echo "style=background-color:#FF0"; }?>> 
                        <td align="right"><?php echo $n;?></td>
                        <td>
                        <a href="#" onclick="open_note(<?php echo $list['id']?>);return false;"><img src="<?php echo base_url()?>images/assign.png" width="10px" /></a>
                        <input type="hidden" name="userid<?php echo $n;?>" value="<?php echo $list['user_id']?>" /><?php echo find_2('firstname','userid',$list['user_id'],'employee_tb')." ".find_2('lastname','userid',$list['user_id'],'employee_tb');?>
                        <input type="hidden" name="id_<?php echo $n?>" value="<?php echo $list['id']?>" />
                        </td>
                        
                        <td align="center">
                        <?php if($type==2){?>
                            <?php echo $list['working_day']?>
                            <input style="width:30px;" type="hidden" value="<?php echo $list['working_day'] ?>" name="working_day<?php echo $n;?>" />
                        <?php }else{?>
                            <input style="width:30px;" type="text" value="<?php echo $list['working_day'] ?>" name="working_day<?php echo $n;?>" />
                        <?php }?>
                        </td>
                        <td align="center">
                        <?php if($type==2){?>
                            <?php echo $list['absent']?>
                            <input style="width:30px;" type="hidden" value="<?php echo $list['absent'] ?>" name="absent<?php echo $n;?>" />
                        <?php }else{?>
                            <input style="width:30px;" type="text" value="<?php echo $list['absent'] ?>" name="absent<?php echo $n;?>" />
                        <?php }?>
                        </td>
                        <td align="center">
                        <?php if($type==2){?>
                            <?php echo $list['late']?>
                            <input style="width:30px;" type="hidden" value="<?php echo $list['late'] ?>" name="late<?php echo $n;?>" />
                        <?php }else{?>
                            <input style="width:30px;" type="text" value="<?php echo $list['late'] ?>" name="late<?php echo $n;?>"/>
                        <?php }?>
                        </td>
                        <td align="center">
                        
                        <?php if(find_2('department_id','userid',$list['user_id'],'employee_tb')==1){?>
                                <?php if($type==2){?>
                                    <?php echo $list['overtime_1']?>
                                    <input style="width:30px;" type="hidden" value="<?php echo $list['overtime_1'] ?>" name="overtime_1<?php echo $n;?>" />
                                <?php }else{?>
                                    <input style="width:30px;" type="text" value="<?php echo $list['overtime_1'] ?>" name="overtime_1<?php echo $n;?>" />
                                <?php }?>
                            <?php }else{?>
                                -
                                <input  type="hidden" value="<?php echo $list['overtime_1'] ?>" name="overtime_1<?php echo $n;?>" />
                            <?php }?>
                        </td>
                        <td align="center">
                        <?php if(find_2('department_id','userid',$list['user_id'],'employee_tb')==1){?>
                                <?php if($type==2){?>
                                    <?php echo $list['overtime_2']?>
                                    <input style="width:30px;" type="hidden" value="<?php echo $list['overtime_2'] ?>" name="overtime_2<?php echo $n;?>" />
                                <?php }else{?>
                                    <input style="width:30px;" type="text" value="<?php echo $list['overtime_2'] ?>" name="overtime_2<?php echo $n;?>" />
                                <?php }?>
                            <?php }else{?>
								<?php if($type==2){?>
                                	<?php echo $list['overtime_2']?>
                                    <input  type="hidden" style="width:30px;"  value="<?php echo $list['overtime_2'] ?>" name="overtime_2<?php echo $n;?>" />
                                <?php }else{?>
                                	<input  type="text" style="width:30px;"  value="<?php echo $list['overtime_2'] ?>" name="overtime_2<?php echo $n;?>" />
                                <?php }?>
                            <?php }?>
                        </td>
                        <td align="center">
                        <?php if($type==2){?>
                            <?php echo $list['overide']?>
                            <input style="width:30px;" type="hidden" value="<?php echo $list['overide'] ?>" name="overide<?php echo $n;?>" />
                        <?php }else{?>
                            <input style="width:30px;" type="text" value="<?php echo $list['overide'] ?>" name="overide<?php echo $n;?>"/>
                        <?php }?>
                        </td>
                        <?php if($type>1){?>
                        <td align="center">
                        <?php if(find_2('department_id','userid',$list['user_id'],'employee_tb')==4){?>
                                <input name="target<?php echo $n;?>" type="checkbox" value="1" <?php if($list['target'])echo "checked=checked";?>  />
                        <?php }else{?>
                                -
                        <?php }?>
                        </td>
                        <?php if($list['bonus_performance']>0){
                            $performance = $list['bonus_performance'];	
                        }else{
                            if(!$list['late'] && !$list['absent']){
								if($list['bonus_perfomance_update']==0){
                               	 $performance = 4*find_2('meal','userid',$list['user_id'],'employee_salary_tb');	
								}else{
								 $performance=0;
								}
                            }else{
                                $performance = 0;	
                            }
                        }?>
                        <td align="center"><input style="width:70px;" type="text" value="<?php echo $performance?>" name="bonus_performance<?php echo $n;?>" /></td>
                        <td align="center">
                        <?php 
						if($list['late_cost']){
							$late_cost = $list['late_cost'];
						}else{
							if(find_2('department_id','userid',$list['user_id'],'employee_tb')==6){
									$late_cost = $list['late']*25000;
							}else{
								$late_cost = $list['late']*10000;
							}
						}?>
                            
                        <input style="width:70px;" type="text" value="<?php echo $late_cost?>" name="late_cost<?php echo $n;?>" />
                        </td>
                        <td align="center"><input style="width:70px;" type="text" value="<?php echo $list['over_payment'] ?>" name="over_payment<?php echo $n;?>" /></td>
                        <td align="center"><input style="width:70px;" type="text" value="<?php echo $list['under_payment'] ?>" name="under_payment<?php echo $n;?>"  /></td>
                        <td align="center"><input style="width:70px;" type="text" value="<?php echo $list['meeting_cost'] ?>" name="meeting_cost<?php echo $n;?>" /></td>
                       
                        <td align="center"><input type="text" style="width:70px;" value="<?php echo $list['debt']?>" name="debt<?php echo $n;?>" /></td>
                        <td align="center"><input type="text" style="width:70px;" value="<?php echo $list['paid']?>" name="paid<?php echo $n;?>" /></td>
                        <?php }?>
                    </tr>
                    <tr id="open_note<?php echo $list['id']?>" class="open_note" style="display:none">
                    	<td></td>
                    	<td colspan="7" style="vertical-align:text-top">
                        Notes: <br />
						<textarea style="height:30px; width:400px" name="notes<?php echo $n;?>"><?php echo $list['notes']?></textarea>
                        </td>
                    </tr>
                    
            <?php $n++;
                    }
            }
		}
	}?>
               
    </tbody>
</table>
</form>


<script>
	function open_note(id){
		$('.open_note').hide();
		$('#open_note'+id).show();
	}
</script>