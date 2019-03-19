
<h2 style="text-transform:uppercase;"><?php if($type==3)echo "absen 2 approval";
		else echo "absen 1 approval";?> detail - Periode ( <?php echo date("d F Y",($periode_from))?> - <?php echo date("d F Y",($periode_to))?> )</h2>
<?php if($type==3){ $app = 5; $rej = 4;}else { $app = 2; $rej = 1;}?>

<?php if($type!=5){?>
<a style="text-decoration:none" href="<?php echo site_url('absence/do_update_salary_by_periode').'/'.$periode_from.'/'.$periode_to.'/'.$app ?>"><input type="button" value="Approve" onclick="return confirm('Are you sure to approve?');" style="padding:2px;" /></a>
<a style="text-decoration:none" href="<?php echo site_url('absence/do_update_salary_by_periode').'/'.$periode_from.'/'.$periode_to.'/'.$rej ?>"><input type="button" value="Reject" onclick="return confirm('Are you sure to reject?');" style="padding:2px;" /></a>
<?php }?>

<input type="button" value="approval list" onclick="window.location = '<?php echo site_url('absence/approval_list')?>'" /><br /><br />
<?php if($total_salary_by_division)foreach($total_salary_by_division as $list){?>
		<?php if($list['company_id']==1){?>
        			&bull; <b>GSI</b> -> <?php echo currency($list['total_gaji']);?> 
        <?php }elseif($list['company_id']==2){?>
        			&bull; <span style="background-color:#0FF">&nbsp;</span> : <b>SSS</b> -> <?php echo currency($list['total_gaji']);?> 
        <?php }else{?>
        			&bull; <span style="background-color:#FF0">&nbsp;</span> : <b>WSI</b> -> <?php echo currency($list['total_gaji']);?>
        <?php }?>
<?php }?><br />
<a href="javascript:void(0)" onclick="$('#totalgajidetail').show();">Detail Total Salary</a>
<div id="totalgajidetail" style="display:none">
<hr size="1" />
<table>
	<tr>
    	<th><b>Company</b></th>
        <th><b>Deparment</b></th>
        <th style="width:70px;"><b>Salary</b></th>
        <th style="width:70px;"><b>Celengan</b></th>
        <th style="width:70px;"><b>Late</b></th>
    </tr>
	<?php if($total_salary_by_department)foreach($total_salary_by_department as $list){?>
        <tr>
        	<td style="padding:2px;"><?php echo find('name',$list['company_id'],'company_tb')?></td>
            <td style="padding:2px;"><?php echo find('name',$list['department_id'],'department_tb')?></td>
            <td style="padding:2px; text-align:right"><?php echo currency($list['total_gaji'])?></td>
            <td style="padding:2px; text-align:right"><?php echo currency($list['total_celengan'])?></td>
            <td style="padding:2px; text-align:right"><?php echo currency($list['total_late'])?></td>
        </tr>
    <?php }?>
</table>
<a href="javascript:void(0)" onclick="$('#totalgajidetail').hide();">Close</a>
<hr size="1" />
</div>
<style>
	#sidePanel {
		 position:fixed;
		 height:48px;
		 overflow:hidden;
		 z-index:1000;
	}
	.form{
		font-size:10px;
	}
	.tableContent thead th, .form thead th {
		font-size:10px;
	}
</style>
<!--<div style="position:fixed; height:48px; overflow:hidden">-->
<div id="sidePanel">
<table class="form" <?php if($type==3) echo "style=width:1380px;color:#000;";else echo "style=width:50%; color:#000";?>>
	<thead>
    	<tr><th>Employee</th>
        <th>Absent</th>
        <th>Cuti</th>
        <th>Sisa Cuti</th>
        <th>Telat</th>
        <th>Overtime 1</th>
        <th>Overtime 2</th>
        <th>Overide</th>
        <?php if($type==3 || $type == 5){?>
        <th>Total Gaji</th>
        <th>Target</th>
        <th >Gaji Pokok</th>
        <th>Overtime 1 cost</th>
        <th>Overtime 2 cost</th>
        <th>Uang Makan</th>
        <th>Uang Sewa Motor</th>
        <th>Bonus Massa</th>
        <th>Bonus Performance</th>
        <th>Sisa Utang</th>
        <th>Tambah Utang</th>
        <th>Bayar Utang</th>
        <th>Pot. Telat Masuk</th>
        <th>Pot. PPH21</th>
        <th>Kelebihan Pembayaran</th>
        <th>Kekurangan Pembayaran</th>
        <th>Celengan</th>
        <th>JHT</th>
        <?php }?></tr>
    </thead>
    <tbody style="opacity:0; height:1px;">
    <?php $n = 1;
	$total = 0;
    if($department_list)foreach($department_list as $list2){
		$total = 0;
		?>
        <tr style="background:#CCC">
        	<td colspan="<?php if($type==3 || $type == 5)echo "31";else echo "13";?>"><b><?php echo $list2['name']?></b></td>
        </tr>
        <?php if($company_list)foreach($company_list as $list3){?>
			<?php if($approval_list)foreach($approval_list as $list){
                if($list2['id']==find_2('department_id','userid',$list['user_id'],'employee_tb') && $list3['id']==find_2('company_id','userid',$list['user_id'],'employee_tb')){?>
                    <tr <?php if(find_2('company_id','userid',$list['user_id'],'employee_tb')==2){ echo "style=background-color:#0FF"; }elseif(find_2('company_id','userid',$list['user_id'],'employee_tb')==3){ echo "style=background-color:#FF0"; }?>> 
                        <td><?php echo find_2('firstname','userid',$list['user_id'],'employee_tb')." ".find_2('lastname','userid',$list['user_id'],'employee_tb');hidden_input($n,'user_id', $list['user_id']);?>
                        </td>
                        <td align="center"><?php echo $list['working_day']?></td>
                        <td align="center"><?php echo $list['absent']?></td>
                        <td align="center"><?php echo $list['last_dayoff'];?></td>
                        <td align="center"><?php echo $list['late']?></td>
                        <td align="center"><?php echo currency($list['overtime_1'])?></td>
                        <td align="center"><?php echo currency($list['overtime_2'])?></td>
                        <td align="center"><?php echo $list['overide']?></td>
                        <?php if($type==3 || $type == 5){
							$total_get = $list['salary_monthly']+$list['meal']+$list['bonus_massa']+$list['vehicle']+$list['bonus_performance']+$list['under_payment']+$list['overtime_2_cost']+$list['overtime_1_cost']+$list['tunjangan_jabatan']+$list['tunjangan_bahasa_inggris']+$list['tunjangan_access_control']+$list['tunjangan_fire_alarm_system']+$list['tunjangan_fire_suppression']+$list['tunjangan_bas']+$list['tunjangan_gpon']+$list['tunjangan_perimeter_intrusion']+$list['tunjangan_public_address']+$list['tunjangan_fiber_optic']+$list['tunjangan_bpjs'];
							$total_pot = $list['paid']+$list['late_cost']+$list['pph21']+$list['over_payment']+$list['meeting_cost']+$list['insurance']+$list['potongan_bpjs'];
							?>
                        <td align="center"><b><?php echo currency($total_get-$total_pot)?></b></td>
                        <?php $total = $total + ($total_get-$total_pot);?>
                        <td align="center">
                            <?php if(find_2('department_id','userid',$list['user_id'],'employee_tb')==4){?>
                            <?php /*?><input type="checkbox" disabled="disabled"  <?php if($list['target'])echo "checked=checked";?> /><?php */?>
                                <?php if($list['target']){?>
                                        <img src="<?php echo base_url()?>images/active.png" width="15" />
                                <?php }else{?>
                                         <img src="<?php echo base_url()?>images/delete.png" width="10" />
                                <?php }?>
                            <?php }else echo "-";?>
                        </td>
                        <td align="center"><?php echo currency($list['salary_monthly']) ?></td>
                        <td align="center"><?php echo currency($list['overtime_1_cost']);?></td>
                        <td align="center"><?php echo currency($list['overtime_2_cost']);?></td>
                        <td align="center"><?php echo currency($list['meal'])?></td>
                        <td align="center"><?php echo currency($list['vehicle'])?></td>
                        
                        <td align="center"><?php echo currency($list['bonus_massa'])?></td>
                        <td align="center"><?php echo currency($list['bonus_performance'])?></td>
                        <td style="background:#F00" align="center"><?php echo currency($list['last_debt'])?></td>
                        <td align="center"><?php echo currency($list['debt'])?></td>
                        <td align="center"><?php echo currency($list['paid'])?></td>
                        <td align="center"><?php echo currency($list['late_cost'])?></td>
                        <td align="center"><?php echo currency($list['pph21'])?></td>
                        <td align="center"><?php echo currency($list['over_payment'])?></td>
                        <td align="center"><?php echo currency($list['under_payment'])?></td>
                        <td align="center"><?php echo currency($list['meeting_cost'])?></td>
                        <td align="center"><?php echo currency($list['insurance'])?></td>
                        <?php }?>
                    </tr>
            <?php $n++;
                    }
            }
		}?>
        <?php if($type==3 || $type==5){?>
                <tr>
                    <td colspan="8"></td>
                    <td bgcolor="#CCCCCC"><b><?php echo currency($total)?></b></td>
                    <td colspan="22"></td>
                </tr>
        <?php }?>
        
	<?php }?>
    </tbody>
</table>
</div>
<table class="form" <?php if($type==3) echo "style=width:1380px; color:#000";else echo "style=width:50%; color:#000";?>>
	<thead>
    	<tr><th>Employee</th>
        <th>Absent</th>
        <th>Cuti</th>
        <th>Sisa Cuti</th>
        <th>Telat</th>
        <th>Overtime 1</th>
        <th>Overtime 2</th>
        <th>Overide</th>
        <?php if($type==3 || $type == 5){?>
        <th>Total Gaji</th>
        <th>Target</th>
        <th >Gaji Pokok</th>
        <th>Overtime 1 cost</th>
        <th>Overtime 2 cost</th>
        <th>Uang Makan</th>
        <th>Uang Sewa Motor</th>
        <th>Bonus Massa</th>
        <th>Bonus Performance</th>
        <th>Sisa Utang</th>
        <th>Tambah Utang</th>
        <th>Bayar Utang</th>
        <th>Pot. Telat Masuk</th>
        <th>Pot. PPH21</th>
        <th>Kelebihan Pembayaran</th>
        <th>Kekurangan Pembayaran</th>
        <th>Celengan</th>
        <th>JHT</th>
        <?php }?></tr>
    </thead>
    <tbody>
    <?php $n = 1;
	$total = 0;//pre($approval_list[0]);
	
    if($department_list)foreach($department_list as $list2){
		$total = 0;
		?>
        <tr style="background:#CCC">
        	<td colspan="<?php if($type==3 || $type == 5)echo "31";else echo "13";?>"><b><?php echo $list2['name']?></b></td>
        </tr>
        <?php if($company_list)foreach($company_list as $list3){?>
			<?php if($approval_list)foreach($approval_list as $list){
                if($list2['id']==find_2('department_id','userid',$list['user_id'],'employee_tb') && $list3['id']==find_2('company_id','userid',$list['user_id'],'employee_tb')){?>
                    <tr <?php if(find_2('company_id','userid',$list['user_id'],'employee_tb')==2){ echo "style=background-color:#0FF"; }elseif(find_2('company_id','userid',$list['user_id'],'employee_tb')==3){ echo "style=background-color:#FF0"; }?>> 
                        <td>
						<?php echo find_2('firstname','userid',$list['user_id'],'employee_tb')." ".find_2('lastname','userid',$list['user_id'],'employee_tb');hidden_input($n,'user_id', $list['user_id']);?>
                        <a href="javascript:void(0);" onclick="send_email_single('<?php echo $periode_from?>','<?php echo $periode_to?>',<?php echo $list['id']?>);"> 
                        	<img src="<?php echo base_url()?>images/email.png" width="15" height="15" />
                        </a>
                        </td>
                        <td align="center"><?php echo $list['working_day']?></td>
                        <td align="center"><?php echo $list['absent']?></td>
                        <td align="center"><?php echo $list['last_dayoff'];?></td>
                        <td align="center"><?php echo $list['late']?></td>
                        <td align="center"><?php echo currency($list['overtime_1'])?></td>
                        <td align="center"><?php echo currency($list['overtime_2'])?></td>
                        <td align="center"><?php echo $list['overide']?></td>
                        
                        <?php if($type==3 || $type == 5){
							$total_get = $list['salary_monthly']+$list['meal']+$list['bonus_massa']+$list['vehicle']+$list['bonus_performance']+$list['under_payment']+$list['overtime_2_cost']+$list['overtime_1_cost']+$list['tunjangan_jabatan']+$list['tunjangan_bahasa_inggris']+$list['tunjangan_access_control']+$list['tunjangan_fire_alarm_system']+$list['tunjangan_fire_suppression']+$list['tunjangan_bas']+$list['tunjangan_gpon']+$list['tunjangan_perimeter_intrusion']+$list['tunjangan_public_address']+$list['tunjangan_fiber_optic']+$list['tunjangan_bpjs'];
							$total_pot = $list['paid']+$list['late_cost']+$list['pph21']+$list['over_payment']+$list['meeting_cost']+$list['insurance']+$list['potongan_bpjs'];
							?>
                        <td align="center"><b><?php echo currency($total_get-$total_pot)?></b></td>
                        <?php $total = $total + ($total_get-$total_pot);?>
                        <td align="center">
                            <?php if(find_2('department_id','userid',$list['user_id'],'employee_tb')==4){?>
                            <?php /*?><input type="checkbox" disabled="disabled"  <?php if($list['target'])echo "checked=checked";?> /><?php */?>
                                <?php if($list['target']){?>
                                        <img src="<?php echo base_url()?>images/active.png" width="15" />
                                <?php }else{?>
                                         <img src="<?php echo base_url()?>images/delete.png" width="10" />
                                <?php }?>
                            <?php }else echo "-";?>
                        </td>
                        <td align="center"><?php echo currency($list['salary_monthly']) ?></td>
                        <td align="center"><?php echo currency($list['overtime_1_cost']);?></td>
                        <td align="center"><?php echo currency($list['overtime_2_cost']);?></td>
                        <td align="center"><?php echo currency($list['meal'])?></td>
                        <td align="center"><?php echo currency($list['vehicle'])?></td>
                        
                        <td align="center"><?php echo currency($list['bonus_massa'])?></td>
                        <td align="center"><?php echo currency($list['bonus_performance'])?></td>
                        <td style="background:#F00" align="center"><?php echo currency($list['last_debt'])?></td>
                        <td align="center"><?php echo currency($list['debt'])?></td>
                        <td align="center"><?php echo currency($list['paid'])?></td>
                        <td align="center"><?php echo currency($list['late_cost'])?></td>
                        <td align="center"><?php echo currency($list['pph21'])?></td>
                        <td align="center"><?php echo currency($list['over_payment'])?></td>
                        <td align="center"><?php echo currency($list['under_payment'])?></td>
                        <td align="center"><?php echo currency($list['meeting_cost'])?></td>
                        <td align="center"><?php echo currency($list['insurance'])?></td>
                        <?php }?>
                    </tr>
                    <?php if($list['notes']){?>
                    <tr>
                    	<td></td>
                    	<td colspan="12" style="vertical-align:text-top">
                        Notes: <?php echo $list['notes']?>
                        </td>
                    </tr>
                    <?php }?>
            <?php $n++;
                    }
            }
		}?>
        <?php if($type==3 || $type==5){?>
                <tr>
                    <td colspan="8"></td>
                    <td bgcolor="#CCCCCC"><b><?php echo currency($total)?></b></td>
                    <td colspan="22"></td>
                </tr>
        <?php }?>
        
	<?php }?>
    </tbody>
</table>

<script>
	var base_url = '<?php echo base_url()?>';
	function send_email_single(periode_from,periode_to,id){
		$.ajax({
			type:"POST",
			url:base_url+'absence/send_salary_email_single/',
			data: { periode_from : periode_from, periode_to : periode_to, id : id },
			success: function(data){
				alert('Email has been send.');
			}
		});
	}
</script>