<h2>Salary Upload by Excel ( <?php echo date("d F Y",strtotime($periode_from))?> - <?php echo date("d F Y",strtotime($periode_to))?>)</h2>

<form name="salary_upload_update_form" method="post" action="<?php echo site_url('absence/update_salary_by_absence/')?>" enctype="multipart/form-data">
<input type="submit" value="Finish" onclick="return confirm('Are you sure?');" style="padding:4px;" /><br /><br />
<h2>active day = <?php echo $active_day ?></h2>
<span style="background-color:#0FF">&nbsp;</span> : SSS, <span style="background-color:#FF0">&nbsp;</span> : WSI
<table class="form" style="width:50%; color:#000">
	<thead>
    	<th>No</th>
    	<th>Name</th>
    	<th>Masuk</th>
        <th>Cuti</th>
        <th>Overtime 1</th>
        <th>Overtime 2</th>
        <th>Telat</th>
        <th>Overide</th>
    </thead>
    <tbody>
    <?php $n = 1 ;
    	if($department_list)foreach($department_list as $list2){?>
        <tr>
        	<td colspan="13"><b><?php echo $list2['name']?></b></td>
        </tr>
        <?php if($company_list)foreach($company_list as $list3){?>
			<?php if($absence_list)foreach($absence_list as $list){
				if($list2['id']==find_2('department_id','userid',$list['userid'],'employee_tb') && $list3['id']==find_2('company_id','userid',$list['userid'],'employee_tb')){?>
        	
                <tr <?php if(find_2('company_id','userid',$list['userid'],'employee_tb')==2){ echo "style=background-color:#0FF"; }elseif(find_2('company_id','userid',$list['userid'],'employee_tb')==3){ echo "style=background-color:#FF0"; }?>>
                	<td align="right"><?php echo $n;?></td>
					<td><?php echo find_2('firstname','userid',$list['userid'],'employee_tb')." ".find_2('lastname','userid',$list['userid'],'employee_tb')?><input type="hidden" name="user_id<?php echo $n?>" value="<?php echo $list['userid']?>" style="width:70px;" /></td>
                    <td align="center">
					<?php $total_masuk = $list['masuk'];
					$sisa = 0;
					if($total_masuk > $active_day){
						$sisa = $total_masuk - $active_day;	
						$total_masuk = $active_day;
					}
					echo $total_masuk;?>
                    
                    <input type="hidden" name="masuk<?php echo $n?>" value="<?php echo $total_masuk ?>" style="width:70px;" />
                    <td align="center"><?php echo $active_day - $total_masuk?><input type="hidden" name="offday<?php echo $n?>" value="<?php echo $active_day - $total_masuk?>" style="width:70px;" /></td>
                    <td>
                    <?php if(find_2('department_id','userid',$list['userid'],'employee_tb')==1){?>
                    	<input type="text" name="overtime<?php echo $n?>" value="<?php echo $list['overtime']?>" style="width:30px;" />
                    <?php }else echo "-";?>
                    </td>
                    <td>
                    <?php if(find_2('department_id','userid',$list['userid'],'employee_tb')==1){?>
                    	<input type="text" name="overtime_2<?php echo $n?>" value="<?php echo $list['overtime_2']+$sisa;?>" style="width:30px;"  />
                    <?php }else{?>
                    	<input type="text" name="overtime_2<?php echo $n?>" value="<?php echo $sisa;?>" style="width:30px;"  />
                    <?php }?>
                    </td>
                    <?php if($tidak_absen = find_tidak_absen('count(*)as total','userid',$list['userid'],'periode_from',$periode_from,'periode_to',$periode_to,'salary_tb'))?>
                    <td><input type="text" value="<?php echo $list['late']+$tidak_absen?>" name="late<?php echo $n?>" style="width:30px;" /></td>
                    <td><input type="text" value="<?php echo $list['overide']?>" name="overide<?php echo $n?>" style="width:30px;" /></td>
                    <input type="hidden" name="month<?php echo $n?>" value="<?php echo $list['month']?>" />
                    <input type="hidden" name="year<?php echo $n?>" value="<?php echo $list['year']?>" />
                    <?php /*?><input style="width:30px;"  type="checkbox" id="target<?php echo $n?>" name="target<?php echo $n?>" value="1"/><?php */?>
                    <input style="width:70px;"  type="hidden" id="not_attend_meeting<?php echo $n?>" name="not_attend_meeting<?php echo $n?>"/>
                    <input style="width:70px;"  type="hidden" id="over_payment<?php echo $n?>" name="over_payment<?php echo $n?>"/>
                    <input style="width:70px;"  type="hidden" id="under_payment<?php echo $n?>" name="under_payment<?php echo $n?>"/>
                    <?php //echo currency(find_2('debt','userid',$list['userid'],'employee_salary_tb'))?>
                    <input style="width:70px;"  type="hidden" id="money_box<?php echo $n?>" name="money_box<?php echo $n?>"/>
                     <input style="width:70px;"  type="hidden" id="paid<?php echo $n?>" name="paid<?php echo $n?>"/>
                </tr>
                
        <?php $n++;
				}
			}
		}
	}?>
                <input type="hidden" id="active_day" name="active_day" value="<?php  echo $active_day ?>"/></td>
                <input type="hidden" id="qty" name="qty" value="<?php echo $n ?>" />
                <input type="hidden" id="periode_from" name="periode_from" value="<?php echo $periode_from ?>" />
                <input type="hidden" id="periode_to" name="periode_to" value="<?php echo $periode_to ?>" />
    </tbody>
</table>

</form>