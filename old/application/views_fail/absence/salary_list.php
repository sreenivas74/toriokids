<style>
	a{
		text-decoration:none;
		color:#000;	
	}
	a:hover{
		color:#00F;	
	}
	
	table.tableAbsence thead th{
		background:#CCC;
		border:solid #000 1px;
		padding:4px;
	}
	
	table.tableAbsence tbody tr td{
		border:solid #000 1px;
		padding:4px;
	}
</style>
<h2>Salary List ( Master Data )</h2>
<form name="salary_form" method="post" action="<?php echo site_url('absence/update_salary/')?>" enctype="multipart/form-data">
<input type="submit" value="update" onclick="return confirm('Are you sure?');return false;" style="padding:4px;" /><br /><br />
<div style="overflow:none;">
<div style="position:fixed; height:42px; overflow:hidden;display:none;">
<table class="tableAbsence" style="color:#000; border:solid #000 1px;" width="100%">
	<thead>
    	<tr><th style="width:40px">USERID</th>
    	<th style="width:30px">Emp No</th>
        <th style="width:85px">Name</th>
        <th style="width:85px">Gaji Pokok</th>
        <th style="width:85px">Uang Makan</th>
        <th style="width:85px">Cuti</th>
        <th style="width:85px">Sewa Motor</th>
        <th style="width:85px">Lembur/jam</th>
        <th style="width:85px">Lembur Weekend</th>
        <th style="width:85px">JHT</th>
        <th style="width:85px">Bonus Massa</th>
        <th style="width:85px">Sisa Hutang</th>
        <th style="width:85px">PPH</th>
        
        
        <th style="width:85px">Tunjangan<br />Jabatan</th>
        <th style="width:85px">Tunjangan<br />Bahasa Inggris</th>
        <th style="width:85px">Tunjangan<br />Access Control</th>
        <th style="width:85px">Tunjangan<br />Fire Alarm system</th>
        <th style="width:85px">Tunjangan <br />Fire Suppression</th>
        <th style="width:85px">Tunjangan<br /> BAS</th>
        <th style="width:85px">Tunjangan <br />GPON</th>
        <th style="width:85px">Tunjangan<br /> Perimeter intrusion</th>
        <th style="width:85px">Tunjangan <br />Public Address</th>
        <th style="width:85px">Tunjangan <br />Fiber Optic</th>
        <th style="width:85px">Tunjangan <br />BPJS</th>
        <th style="width:85px">Potongan <br />BPJS</th>
        
        <th style="width:120px">Last Update</th></tr>
    </thead>
    <tbody style="opacity:0;">
    	
    </tbody>
</table>
</div>
<table class="tableAbsence" style="color:#000">
	<thead>
    	<tr><th style="width:40px">USERID</th>
    	<th style="width:30px">Emp No</th>
        <th style="width:85px">Name</th>
        <th style="width:85px">Gaji Pokok</th>
        <th style="width:85px">Uang Makan</th>
        <th style="width:85px">Cuti</th>
        <th style="width:85px">Sewa Motor</th>
        <th style="width:85px">Lembur/jam</th>
        <th style="width:85px">Lembur Weekend</th>
        <th style="width:85px">JHT</th>
        <th style="width:85px">Bonus Massa</th>
        <th style="width:85px">Sisa Hutang</th>
        <th style="width:85px">PPH</th>
        
        
        
        <th style="width:85px">Tunjangan<br />Jabatan</th>
        <th style="width:85px">Tunjangan<br />Bahasa Inggris</th>
        <th style="width:85px">Tunjangan<br />Access Control</th>
        <th style="width:85px">Tunjangan<br />Fire Alarm system</th>
        <th style="width:85px">Tunjangan <br />Fire Suppression</th>
        <th style="width:85px">Tunjangan<br /> BAS</th>
        <th style="width:85px">Tunjangan <br />GPON</th>
        <th style="width:85px">Tunjangan<br /> Perimeter intrusion</th>
        <th style="width:85px">Tunjangan <br />Public Address</th>
        <th style="width:85px">Tunjangan <br />Fiber Optic</th>
        <th style="width:85px">Tunjangan <br />BPJS</th>
        <th style="width:85px">Potongan <br />BPJS</th>
        <th style="width:120px">Last Update</th></tr>
    </thead>
    <tbody><?php //pre($employee_active);?>
    	<?php if($employee_active)foreach($employee_active as $list){?>
        	
                <tr>
                	<td><input type="text" name="userid_<?php echo $list['id']?>" style="width:30px;" value="<?php echo find_2('userid','employee_id',$list['id'],'employee_salary_tb')?>"></td>
                    <td style="text-align:right"><?php echo substr($list['nik'],-3,3)?></td>
                    <td><a target="_blank" href="<?php echo site_url('employee/detail_employee/'.$list['id'])?>"><?php echo $list['firstname']." ".$list['lastname']?></a></td>
                    <td><input type="text" name="salary_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('salary','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="meal_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('meal','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="dayoff_<?php echo $list['id']?>" style="width:70px;" value="<?php echo find_2('dayoff','employee_id',$list['id'],'employee_salary_tb')?>"></td>
                    <td><input type="text" name="vehicle_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('vehicle','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="overtime_1_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('overtime_1','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="overtime_2_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('overtime_2','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="insurance_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('insurance','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td style="text-align:center">
                    <?php 
					$join_date = $list['join_date'];
					if($join_date!='0000-00-00'){
						$bonus_massa_year_count = strtotime(date('Y-m-d')) - strtotime($join_date);
						$bonus_massa_year = date('Y',$bonus_massa_year_count)-1970;
						if($bonus_massa_year>=2){
							$bonus_massa = find_2('meal','employee_id',$list['id'],'employee_salary_tb')*$bonus_massa_year*2;
						}else{
							$bonus_massa = 0;	
						}
					}else $bonus_massa = 0;
					echo currency($bonus_massa);?>
                    </td>
                    <td><input type="text" name="debt_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('debt','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="pph21_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('pph21','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    
                    
                    <td><input type="text" name="tunjangan_jabatan_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('tunjangan_jabatan','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="tunjangan_bahasa_inggris_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('tunjangan_bahasa_inggris','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="tunjangan_access_control_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('tunjangan_access_control','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="tunjangan_fire_alarm_system_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('tunjangan_fire_alarm_system','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="tunjangan_fire_suppression_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('tunjangan_fire_suppression','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="tunjangan_bas_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('tunjangan_bas','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="tunjangan_gpon_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('tunjangan_gpon','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="tunjangan_perimeter_intrusion_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('tunjangan_perimeter_intrusion','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="tunjangan_public_address_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('tunjangan_public_address','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="tunjangan_fiber_optic_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('tunjangan_fiber_optic','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    
                    <td><input type="text" name="tunjangan_bpjs_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('tunjangan_bpjs','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    <td><input type="text" name="potongan_bpjs_<?php echo $list['id']?>" style="width:70px;" value="<?php echo currency(find_2('potongan_bpjs','employee_id',$list['id'],'employee_salary_tb'))?>"></td>
                    
                    
                    <td><?php if(find_2('created_date','employee_id',$list['id'],'employee_salary_tb'))echo date('d M Y H:i',strtotime(find_2('created_date','employee_id',$list['id'],'employee_salary_tb')))?></td>
                </tr>
                <input type="hidden" name="employee_id[]" value="<?php echo $list['id']?>" />
        <?php }?>
    </tbody>
</table></div>
</form>