<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Salary</title>

<style>
body{
	font-size:14px;	
}
#header{
	display:block;
	width:980px;
	height:70px;
	overflow:hidden;
}
	#header_left{
		display:block;
		width:200px;
		float:left;
	}
	#header_right{
		display:block;
		width:770px;
		padding-top:5px;
	}
#content{
	clear:both;
	display:block;
	width:980px;
}

</style>

</head>
<body>
<?php $sisa_cuti = 0;?>
<?php if(find_2('department_id','userid',$list['user_id'],'employee_tb')>2){?>
        <?php if(find_2('company_id','userid',$list['user_id'],'employee_tb')==1){?>
        <div id="header">
            <div id="header_left">
                <img src="<?php echo base_url()?>images/gsi_logo.jpg" /><br />
            </div>
            <div id="header_right">
                <b>PT GOLDEN SOLUTION INDONESIA</b><br />
                Jl. Kyai Caringin No. 2A<br />
                Cideng - Jakarta Pusat
            </div>
        </div>
            <?php }elseif(find_2('company_id','userid',$list['user_id'],'employee_tb')==2){?>
        <div id="header">
            <div id="header_left">
                <img src="<?php echo base_url()?>images/sss.png" width="157" /><br />
            </div>
            <div id="header_right">
                <b>PT SMART SYSTEM SECURITY</b><br />
                Jl. Kyai Caringin No. 2A<br />
                Cideng - Jakarta Pusat
            </div>
        </div>
            <?php }elseif(find_2('company_id','userid',$list['user_id'],'employee_tb')==3){?>
        <div id="header">
            <div id="header_left">
            	<img src="<?php echo base_url()?>images/wsi.jpg" width="157" /><br />
            </div>
            <div id="header_right">
                <b>PT WEB SOLUTION INDONESIA</b><br />
                Jl. Kyai Caringin No. 2A<br />
                Cideng - Jakarta Pusat
            </div>
        </div>
            <?php }elseif(find_2('company_id','userid',$list['user_id'],'employee_tb')==7){?>
        <div id="header" style="overflow:visible;">
            
            <div id="header_left">
            	<img src="<?php echo base_url()?>images/parama.jpg" width="980" /><br />
            
            </div>
        </div>
          	<?php } ?>
            
        <div id="content">
        <hr size="1" />
        <b>SLIP GAJI <?php echo date('d/m/Y',$periode_to)?></b>
        <br /><br />
            <table border="0" width="100%">
                <tr>
                    <td width="25%" valign="top">Code</td>
                    <td width="20%" valign="top"><b><?php echo find_2('nik','userid',$list['user_id'],'employee_tb')?></b></td>
                    <td width="2%"></td>
                    <td width="25%"></td>
                    <td width="20%"></td>
                </tr>
                <tr>
                    <td valign="top">Nama</td>
                    <td valign="top"><?php echo find_2('firstname','userid',$list['user_id'],'employee_tb')." ".find_2('lastname','userid',$list['user_id'],'employee_tb')?></td>
                    <td></td>
                    <td valign="top">Grade</td>
                    <td valign="top"><?php echo find_2('grade','userid',$list['user_id'],'employee_tb')?></td>
                </tr>
                <tr>
                    <td valign="top">Jumlah Hari Masuk</td>
                    <td valign="top" align="right"><?php echo $list['working_day']?></td>
                    <td></td>
                    <td valign="top">Jabatan</td>
                    <td valign="top"><?php echo find_2('job_title','userid',$list['user_id'],'employee_tb')?></td>
                </tr>
                <tr>
                    <td valign="top">Telat</td>
                    <td valign="top" align="right"><?php echo $list['late']?></td>
                    <td></td>
                    <td valign="top">Departemen</td>
                    <td valign="top"><?php echo find('name',find_2('department_id','userid',$list['user_id'],'employee_tb'),'department_tb')?></td>
                </tr>
                <tr>
                    <td valign="top">Lembur Weekend / Hari Besar (hari)</td>
                    <td valign="top" align="right"><?php if($list['overtime_2'])echo currency($list['overtime_2']);else echo "-";?></td>
                    <td></td>
                    <td valign="top">Jumlah Hari Kerja</td>
                    <td valign="top" align="right"><?php echo $list['active_day']?></td>
                </tr>
                <tr>
                    <td valign="top"></td>
                    <td valign="top" align="right"></td>
                    <td></td>
                    <td valign="top">Saldo Cuti</td>
                    <td valign="top" align="right"><?php echo $list['last_dayoff']?></td>
                </tr>
                <tr>
                    <td valign="top"></td>
                    <td valign="top" align="right"></td>
                    <td></td>
                    <td valign="top">Cuti</td>
                    <td valign="top" align="right"><?php echo $list['absent']?></td>
                </tr>
                <tr>
                    <td valign="top"></td>
                    <td valign="top" align="right"></td>
                    <td></td>
                    <td valign="top">Sisa Cuti</td>
                    <td valign="top" align="right">
						<?php 	$sisa_cuti = abs($list['last_dayoff'])-abs($list['absent']);
								if($sisa_cuti>0)echo $sisa_cuti;else echo "0";
						?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" bgcolor="#000000"></td>
                </tr>
                <tr>
                    <td colspan="2"><b>PENERIMAAN</b></td>
                    <td></td>
                    <td colspan="2"><b>POTONGAN</b></td>
                </tr>
                <tr>
                    <td colspan="5" bgcolor="#000000"></td>
                </tr>
                <tr>
                    <td valign="top">Gaji Pokok</td>
                    <td valign="top" align="right">
					<?php echo currency(find_2('salary','userid',$list['user_id'],'employee_salary_tb'))?></td>
                    <td></td>
                    <td valign="top">Cicilan Pinjaman</td>
                    <td valign="top" align="right"><?php if($list['paid'])echo currency($list['paid']);else echo "-";?></td>
                </tr>
                <tr>
                    <td valign="top"></td>
                    <td valign="top" align="right"></td>
                    <td></td>
                    <td valign="top">Potongan Telat Masuk</td>
                    <td valign="top" align="right"><?php if($list['late_cost'])echo currency($list['late_cost']);else echo "-";?></td>
                </tr>
                <tr>
                	<td valign="top">Gaji yang diterima (Full/Proporsional)</td>
                    <td valign="top" align="right">
						<?php echo currency($list['salary_monthly'])?>
                    </td>
                    <td></td>
                    <td valign="top">Potongan PPH 21</td>
                    <td valign="top" align="right"><?php if($list['pph21'])echo currency($list['pph21']);else echo "-";?></td>
                    
                </tr>
                <tr>
                    <td valign="top">Lembur (hari)</td>
                        <td valign="top" align="right"><?php if($list['overtime_2_cost'])echo currency($list['overtime_2_cost']);else echo "-";?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                	<td valign="top">Uang Makan</td>
                    <td valign="top" align="right"><?php echo currency($list['meal'])?></td>
                    <td></td>
                    <td valign="top">Potongan Kelebihan Pembayaran Bulan Lalu</td>
                    <td valign="top" align="right"><?php if($list['over_payment'])echo currency($list['over_payment']);else echo "-";?></td>
                </tr>
                <tr>
                	<td valign="top">Uang Sewa Motor</td>
                    <td valign="top" align="right"><?php if($list['vehicle'])echo currency($list['vehicle']);else echo "-";?></td>
                    <td></td>
                    <td valign="top">Penalti Celengan</td>
                    <td valign="top" align="right"><?php if($list['meeting_cost'])echo currency($list['meeting_cost']);else echo "-";?></td>
                </tr>
                <tr>
                	<td valign="top">*Bonus Performance</td>
                    <td valign="top" align="right"><?php if($list['bonus_performance'])echo currency($list['bonus_performance']);else echo "-";?></td>
                    <td></td>
                    <td valign="top">JHT</td>
                    <td valign="top" align="right"><?php if($list['insurance'])echo currency($list['insurance']);else echo "-";?></td>
                </tr>
                <tr>
                	<td valign="top">**Bonus Massa</td>
                    <td valign="top" align="right"><?php if($list['bonus_massa'])echo currency($list['bonus_massa']);else echo "-";?></td>
                    <td></td>
                    <?php if(find_2('company_id','userid',$list['user_id'],'employee_tb')==1){?>
                    	<td valign="top">Salary On Hold Based on Performance</td>
                    	<td valign="top" align="right"><?php if($list['salary_on_hold'])echo currency($list['salary_on_hold']); else echo "-";?></td>
                    <?php }else{?>
                        <td valign="top"></td>
                        <td valign="top" align="right"></td>
                    <?php }?>
                </tr>
                <tr>
                	<td valign="top">Rapel</td>
                    <td valign="top" align="right"><?php if($list['under_payment'])echo currency($list['under_payment']);else echo "-";?></td>
                    <td></td>
                    <td valign="top"></td>
                    <td valign="top" align="right"></td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
                <?php 
                $total_get = $list['salary_monthly']+$list['meal']+$list['bonus_massa']+$list['vehicle']+$list['bonus_performance']+$list['under_payment']+$list['overtime_2_cost']+$list['overtime_1_cost'];
                ?>
                <?php 
				$employee_detail=get_employee_detail($list['employee_id']);
				?>
                <?php if($employee_detail['tunjangan_jabatan']>0){
					$total_get+=$employee_detail['tunjangan_jabatan'];
					?>
                <tr>
                  <td valign="top">Tunjangan Jabatan</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_jabatan'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($employee_detail['tunjangan_bahasa_inggris']>0){
					$total_get+=$employee_detail['tunjangan_bahasa_inggris'];?>
                <tr>
                  <td valign="top">Tunjangan Bahasa Inggris</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_bahasa_inggris'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($employee_detail['tunjangan_access_control']>0){
					$total_get+=$employee_detail['tunjangan_access_control'];?>
                
                <tr>
                  <td valign="top">Tunjangan Access control</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_access_control'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_fire_alarm_system']>0){
					$total_get+=$employee_detail['tunjangan_fire_alarm_system'];?>
                <tr>
                  <td valign="top">Tunjangan Fire Alarm system</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_fire_alarm_system'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_fire_suppression']>0){
					$total_get+=$employee_detail['tunjangan_fire_suppression'];?>
                <tr>
                  <td valign="top">Tunjangan Fire Suppression</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_fire_suppression'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($employee_detail['tunjangan_bas']>0){
					$total_get+=$employee_detail['tunjangan_bas'];?>
                <tr>
                  <td valign="top">Tunjangan BAS</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_bas'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_gpon']>0){
					$total_get+=$employee_detail['tunjangan_gpon'];?>
                <tr>
                  <td valign="top">Tunjangan GPON</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_gpon'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($employee_detail['tunjangan_perimeter_intrusion']>0){
					$total_get+=$employee_detail['tunjangan_perimeter_intrusion'];?>
                <tr>
                  <td valign="top">Tunjangan Perimeter intrusion</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_perimeter_intrusion'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_public_address']>0){
					$total_get+=$employee_detail['tunjangan_public_address'];?>
                <tr>
                  <td valign="top">Tunjangan Public Address</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_public_address'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_fiber_optic']>0){
					$total_get+=$employee_detail['tunjangan_fiber_optic'];?>
                <tr>
                  <td valign="top">Tunjangan Fiber Optic</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_fiber_optic'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($list['tunjangan_bpjs']>0 || $list['potongan_bpjs']>0){
					$total_get+=$list['tunjangan_bpjs'];
					//$total_pot+=$list['potongan_bpjs'];?>
                <tr>
                  <td valign="top">Tunjangan BPJS</td>
                  <td valign="top" align="right"><?php echo currency($list['tunjangan_bpjs'])?></td>
                  <td></td>
                  <td valign="top">Potongan BPJS</td>
                  <td valign="top" align="right"><?php echo currency($list['potongan_bpjs'])?></td>
                </tr>
                <?php }?>
                <tr>
                    <td valign="top"><b>Total Penerimaan</b></td>
                    <td valign="top" align="right"><b><?php echo currency($total_get);?>
                    </b></td>
                    <td></td>
                    <td valign="top"><b>Total Potongan</b></td>
                    <td valign="top" align="right"><b>
                    
                    <?php $total_pot = $list['paid']+$list['late_cost']+$list['pph21']+$list['over_payment']+$list['meeting_cost']+$list['insurance']+$list['potongan_bpjs'];
					echo currency($total_pot);?>
                    </b></td>
                </tr>
                <tr>
                    <td colspan="5" bgcolor="#000000"></td>
                </tr>
                <tr>
                    <td valign="top">Take Home Pay</td>
                    <td valign="top" align="right"><b><?php echo currency($total_get-$total_pot)?></b></td>
                    
                    <?php /*?><td valign="top" align="right"><b><?php echo currency($list['salary'])?></b></td><?php */?>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="5" bgcolor="#000000">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5"><b>NOTE</b></td>
                </tr>
                <tr>
                    <td colspan="2" bgcolor="#000000"></td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td valign="top">Saldo Pinjaman per Awal Bulan</td>
                    <td align="right"><?php if($list['last_debt'])echo currency(abs($list['last_debt']));else echo "-";?></td>
                    <td></td>
                    <td colspan="2">** Karyawan dengan massa kerja lebih dari 2 tahun</td>
                </tr>
                <tr>
                    <td valign="top">Pinjaman Bulan Ini</td>
                    <td align="right"><?php if($list['debt'])echo currency(abs($list['debt']));else echo "-";?></td>
                    <td></td>
                    <td colspan="2">* Karyawan dengan absensi tidak telat dan selalu masuk</td>
                </tr>
                <tr>
                    <td valign="top">Cicilan Pinjaman</td>
                    <td align="right"><?php if($list['paid'])echo currency(abs($list['paid']));else echo "-";?></td>
                    <td></td>
                    <td colspan="2">- Klaim dapat dilakukan max 7 hari setelah mendapatkan slip gaji</td>
                </tr>
                <tr>
                    <td valign="top">Saldo Pinjaman per Akhir Bulan</td>
                    <td align="right"><?php if((abs($list['last_debt'])+abs($list['debt'])-abs($list['paid']))<0)echo currency(abs((abs($list['last_debt'])+abs($list['debt'])-abs($list['paid']))));elseif((abs($list['last_debt'])+abs($list['debt'])-abs($list['paid']))>0)echo currency(abs(abs($list['last_debt'])+abs($list['debt'])-abs($list['paid']))); else echo "-";?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php if($list['notes']){?>
                <tr>
                    <td colspan="5" bgcolor="#000000"></td>
                </tr>
                <tr>
                	<td valign="top" colspan="5"><?php echo nl2br($list['notes'])?></td>
                </tr>
                <?php }?>
            </table>
        </div>
		<?php }elseif(find_2('department_id','userid',$list['user_id'],'employee_tb')==2){?>
        <!-- support-->
        <div id="header">
        <?php if(find_2('company_id','userid',$list['user_id'],'employee_tb')==1){?>
            <div id="header_left">
                <img src="<?php echo base_url()?>images/gsi_logo.jpg" /><br />
            </div>
            <div id="header_right">
                <b>PT GOLDEN SOLUTION INDONESIA</b><br />
                Jl. Kyai Caringin No. 2A<br />
                Cideng - Jakarta Pusat
            </div>
            <?php }elseif(find_2('company_id','userid',$list['user_id'],'employee_tb')==2){?>
            <div id="header_left">
                <img src="<?php echo base_url()?>images/sss.png" width="157" /><br />
            </div>
            <div id="header_right">
                <b>PT SMART SYSTEM SECURITY</b><br />
                Jl. Kyai Caringin No. 2A<br />
                Cideng - Jakarta Pusat
            </div>
            <?php }else{?>
            <div id="header_left">
            	<img src="<?php echo base_url()?>images/wsi.jpg" width="157" /><br />
            </div>
            <div id="header_right">
                <b>PT WEB SOLUTION INDONESIA</b><br />
                Jl. Kyai Caringin No. 2A<br />
                Cideng - Jakarta Pusat
            </div>
            <?php }?>
            
        </div>
        <div id="content">
        <hr size="1" />
        <b>SLIP GAJI <?php echo date('d/m/Y',$periode_to)?></b>
        <br /><br />
            <table border="0" width="100%">
                <tr>
                    <td width="25%" valign="top">Code</td>
                    <td width="20%" valign="top"><b><?php echo find_2('nik','userid',$list['user_id'],'employee_tb')?></b></td>
                    <td width="2%"></td>
                    <td width="25%"></td>
                    <td width="20%"></td>
                </tr>
                <tr>
                    <td valign="top">Nama</td>
                    <td valign="top"><?php echo find_2('firstname','userid',$list['user_id'],'employee_tb')." ".find_2('lastname','userid',$list['user_id'],'employee_tb')?></td>
                    <td></td>
                    <td valign="top">Grade</td>
                    <td valign="top"><?php echo find_2('grade','userid',$list['user_id'],'employee_tb')?></td>
                </tr>
                <tr>
                    <td valign="top">Jumlah Hari Masuk</td>
                    <td valign="top" align="right"><?php echo $list['working_day']?></td>
                    <td></td>
                    <td valign="top">Jabatan</td>
                    <td valign="top"><?php echo find_2('job_title','userid',$list['user_id'],'employee_tb')?></td>
                </tr>
                <tr>
                    <td valign="top">Telat</td>
                    <td valign="top" align="right"><?php echo $list['late']?></td>
                    <td></td>
                    <td valign="top">Departemen</td>
                    <td valign="top"><?php echo find('name',find_2('department_id','userid',$list['user_id'],'employee_tb'),'department_tb')?></td>
                </tr>
                <tr>
                    <td valign="top">Lembur Weekend / Hari Besar (hari)</td>
                    <td valign="top" align="right"><?php if($list['overtime_2'])echo currency($list['overtime_2']);else echo "-";?></td>
                    <td></td>
                    <td valign="top">Jumlah Hari Kerja</td>
                    <td valign="top" align="right"><?php echo $list['active_day']?></td>
                </tr>
                <tr>
                    <td valign="top"></td>
                    <td valign="top" align="right"></td>
                    <td></td>
                    <td valign="top">Saldo Cuti</td>
                    <td valign="top" align="right"><?php echo $list['last_dayoff']?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td valign="top">Cuti</td>
                    <td valign="top" align="right"><?php echo $list['absent']?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td valign="top">Sisa Cuti</td>
                    <td valign="top" align="right">
						<?php 	$sisa_cuti = abs($list['last_dayoff'])-abs($list['absent']);
								if($sisa_cuti>0)echo $sisa_cuti;else echo "0";
						?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" bgcolor="#000000"></td>
                </tr>
                <tr>
                    <td colspan="2"><b>PENERIMAAN</b></td>
                    <td></td>
                    <td colspan="2"><b>POTONGAN</b></td>
                </tr>
                <tr>
                    <td colspan="5" bgcolor="#000000"></td>
                </tr>
                <tr>
                    <td valign="top">Gaji Pokok</td>
                    <td valign="top" align="right">
					<?php echo currency(find_2('salary','userid',$list['user_id'],'employee_salary_tb'))?></td>
                    <td></td>
                    <td valign="top">Cicilan Pinjaman</td>
                    <td valign="top" align="right"><?php if($list['paid'])echo currency($list['paid']);else echo "-";?></td>
                </tr>
                <tr>
                    <td valign="top"></td>
                    <td valign="top" align="right"></td>
                    <td></td>
                    <td valign="top">Potongan Telat Masuk</td>
                    <td valign="top" align="right"><?php if($list['late_cost'])echo currency($list['late_cost']);else echo "-";?></td>
                </tr>
                <tr>
                	<td valign="top">Gaji yang diterima (Full/Proporsional)</td>
                    <td valign="top" align="right">
						<?php echo currency($list['salary_monthly'])?>
                    </td>
                    <td></td>
                    <td valign="top">Potongan PPH 21</td>
                    <td valign="top" align="right"><?php if($list['pph21'])echo currency($list['pph21']);else echo "-";?></td>
                    
                </tr>
                <tr>
                	<td valign="top">Lembur Weekend / Hari Libur (Hari)</td>
                    <td valign="top" align="right"><?php if($list['overtime_2_cost'])echo currency($list['overtime_2_cost']);else echo "-";?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                	<td valign="top">Uang Makan</td>
                    <td valign="top" align="right"><?php echo currency($list['meal'])?></td>
                    <td></td>
                    <td valign="top">Potongan Kelebihan Pembayaran Bulan Lalu</td>
                    <td valign="top" align="right"><?php if($list['over_payment'])echo currency($list['over_payment']);else echo "-";?></td>
                </tr>
                <tr>
                	<td valign="top">Uang Sewa Motor</td>
                    <td valign="top" align="right"><?php if($list['vehicle'])echo currency($list['vehicle']);else echo "-";?></td>
                    <td></td>
                    <td valign="top">Penalti Celengan</td>
                    <td valign="top" align="right"><?php if($list['meeting_cost'])echo currency($list['meeting_cost']);else echo "-";?></td>
                </tr>
                <tr>
                	<td valign="top">*Bonus Performance</td>
                    <td valign="top" align="right"><?php if($list['bonus_performance'])echo currency($list['bonus_performance']);else echo "-";?></td>
                    <td></td>
                    <td valign="top">JHT</td>
                    <td valign="top" align="right"><?php if($list['insurance'])echo currency($list['insurance']);else echo "-";?></td>
                </tr>
                <tr>
                	<td valign="top">**Bonus Massa</td>
                    <td valign="top" align="right"><?php if($list['bonus_massa'])echo currency($list['bonus_massa']);else echo "-";?></td>
                    <td></td>
                    <td valign="top">Penalti Celengan Support</td>
                    <td valign="top" align="right">-</td>
                </tr>
                <tr>
                	<td valign="top">Rapel</td>
                    <td valign="top" align="right"><?php if($list['under_payment'])echo currency($list['under_payment']);else echo "-";?></td>
                    <td></td>
                    <td valign="top"></td>
                    <td valign="top" align="right"></td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
				<?php 
                $total_get = $list['salary_monthly']+$list['meal']+$list['bonus_massa']+$list['vehicle']+$list['bonus_performance']+$list['under_payment']+$list['overtime_2_cost'];
                ?>
                <?php 
				$employee_detail=get_employee_detail($list['employee_id']);
				?>
                <?php if($employee_detail['tunjangan_jabatan']>0){
					$total_get+=$employee_detail['tunjangan_jabatan'];
					?>
                <tr>
                  <td valign="top">Tunjangan Jabatan</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_jabatan'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($employee_detail['tunjangan_bahasa_inggris']>0){
					$total_get+=$employee_detail['tunjangan_bahasa_inggris'];?>
                <tr>
                  <td valign="top">Tunjangan Bahasa Inggris</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_bahasa_inggris'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($employee_detail['tunjangan_access_control']>0){
					$total_get+=$employee_detail['tunjangan_access_control'];?>
                
                <tr>
                  <td valign="top">Tunjangan Access control</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_access_control'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_fire_alarm_system']>0){
					$total_get+=$employee_detail['tunjangan_fire_alarm_system'];?>
                <tr>
                  <td valign="top">Tunjangan Fire Alarm system</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_fire_alarm_system'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_fire_suppression']>0){
					$total_get+=$employee_detail['tunjangan_fire_suppression'];?>
                <tr>
                  <td valign="top">Tunjangan Fire Suppression</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_fire_suppression'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($employee_detail['tunjangan_bas']>0){
					$total_get+=$employee_detail['tunjangan_bas'];?>
                <tr>
                  <td valign="top">Tunjangan BAS</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_bas'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_gpon']>0){
					$total_get+=$employee_detail['tunjangan_gpon'];?>
                <tr>
                  <td valign="top">Tunjangan GPON</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_gpon'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($employee_detail['tunjangan_perimeter_intrusion']>0){
					$total_get+=$employee_detail['tunjangan_perimeter_intrusion'];?>
                <tr>
                  <td valign="top">Tunjangan Perimeter intrusion</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_perimeter_intrusion'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_public_address']>0){
					$total_get+=$employee_detail['tunjangan_public_address'];?>
                <tr>
                  <td valign="top">Tunjangan Public Address</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_public_address'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_fiber_optic']>0){
					$total_get+=$employee_detail['tunjangan_fiber_optic'];?>
                <tr>
                  <td valign="top">Tunjangan Fiber Optic</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_fiber_optic'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($list['tunjangan_bpjs']>0 || $list['potongan_bpjs']>0){
					$total_get+=$list['tunjangan_bpjs'];
					//$total_pot+=$list['potongan_bpjs'];?>
                <tr>
                  <td valign="top">Tunjangan BPJS</td>
                  <td valign="top" align="right"><?php echo currency($list['tunjangan_bpjs'])?></td>
                  <td></td>
                  <td valign="top">Potongan BPJS</td>
                  <td valign="top" align="right"><?php echo currency($list['potongan_bpjs'])?></td>
                </tr>
                <?php }?>
                <tr>
                    <td valign="top"><b>Total Penerimaan</b></td>
                    <td valign="top" align="right"><b><?php echo currency($total_get);?>
                    </b></td>
                    <td></td>
                    <td valign="top"><b>Total Potongan</b></td>
                    <td valign="top" align="right"><b>
                    
                    <?php $total_pot = $list['paid']+$list['late_cost']+$list['pph21']+$list['over_payment']+$list['meeting_cost']+$list['insurance']+$list['potongan_bpjs'];
					echo currency($total_pot);?>
                    </b></td>
                </tr>
                <tr>
                    <td colspan="5" bgcolor="#000000"></td>
                </tr>
                <tr>
                    <td valign="top">Take Home Pay</td>
                    <td valign="top" align="right"><b><?php echo currency($total_get-$total_pot)?></b></td>
                    
                    <?php /*?><td valign="top" align="right"><b><?php echo currency($list['salary'])?></b></td><?php */?>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="5" bgcolor="#000000">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5"><b>NOTE</b></td>
                </tr>
                <tr>
                    <td colspan="2" bgcolor="#000000"></td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td valign="top">Saldo Pinjaman per Awal Bulan</td>
                    <td align="right"><?php if($list['last_debt'])echo currency(abs($list['last_debt']));else echo "-";?></td>
                    <td></td>
                    <td colspan="2">** Karyawan dengan massa kerja lebih dari 2 tahun</td>
                </tr>
                <tr>
                    <td valign="top">Pinjaman Bulan Ini</td>
                    <td align="right"><?php if($list['debt'])echo currency(abs($list['debt']));else echo "-";?></td>
                    <td></td>
                    <td colspan="2">* Karyawan dengan absensi tidak telat dan selalu masuk</td>
                </tr>
                <tr>
                    <td valign="top">Cicilan Pinjaman</td>
                    <td align="right"><?php if($list['paid'])echo currency(abs($list['paid']));else echo "-";?></td>
                    <td></td>
                    <td colspan="2">- Klaim dapat dilakukan max 7 hari setelah mendapatkan slip gaji</td>
                </tr>
                <tr>
                    <td valign="top">Saldo Pinjaman per Akhir Bulan</td>
                    <td align="right"><?php if((abs($list['last_debt'])+abs($list['debt'])-abs($list['paid']))<0)echo currency(abs((abs($list['last_debt'])+abs($list['debt'])-abs($list['paid']))));elseif((abs($list['last_debt'])+abs($list['debt'])-abs($list['paid']))>0)echo currency(abs(abs($list['last_debt'])+abs($list['debt'])-abs($list['paid']))); else echo "-";?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php if($list['notes']){?>
                <tr>
                    <td colspan="5" bgcolor="#000000"></td>
                </tr>
                <tr>
                	<td valign="top" colspan="5"><?php echo nl2br($list['notes'])?></td>
                </tr>
                <?php }?>
            </table>
        </div>
        <?php }elseif(find_2('department_id','userid',$list['user_id'],'employee_tb')==1){?>
        <!-- engineering-->
        <div id="header">
        <?php if(find_2('company_id','userid',$list['user_id'],'employee_tb')==1){?>
            <div id="header_left">
                <img src="<?php echo base_url()?>images/gsi_logo.jpg" /><br />
            </div>
            <div id="header_right">
                <b>PT GOLDEN SOLUTION INDONESIA</b><br />
                Jl. Kyai Caringin No. 2A<br />
                Cideng - Jakarta Pusat
            </div>
            <?php }elseif(find_2('company_id','userid',$list['user_id'],'employee_tb')==2){?>
            <div id="header_left">
                <img src="<?php echo base_url()?>images/sss.png" width="157" /><br />
            </div>
            <div id="header_right">
                <b>PT SMART SYSTEM SECURITY</b><br />
                Jl. Kyai Caringin No. 2A<br />
                Cideng - Jakarta Pusat
            </div>
            <?php }else{?>
            <div id="header_left">
            	<img src="<?php echo base_url()?>images/wsi.jpg" width="157" /><br />
            </div>
            <div id="header_right">
                <b>PT WEB SOLUTION INDONESIA</b><br />
                Jl. Kyai Caringin No. 2A<br />
                Cideng - Jakarta Pusat
            </div>
            <?php }?>
            
        </div>
        <div id="content">
        <hr size="1" />
        <b>SLIP GAJI <?php echo date('d/m/Y',$periode_to)?></b>
        <br /><br />
            <table border="0" width="100%">
                <tr>
                    <td width="25%" valign="top">Code</td>
                    <td width="20%" valign="top"><b><?php echo find_2('nik','userid',$list['user_id'],'employee_tb')?></b></td>
                    <td width="2%"></td>
                    <td width="25%"></td>
                    <td width="20%"></td>
                </tr>
                <tr>
                    <td valign="top">Nama</td>
                    <td valign="top"><?php echo find_2('firstname','userid',$list['user_id'],'employee_tb')." ".find_2('lastname','userid',$list['user_id'],'employee_tb')?></td>
                    <td></td>
                    <td valign="top">Grade</td>
                    <td valign="top"><?php echo find_2('grade','userid',$list['user_id'],'employee_tb')?></td>
                </tr>
                <tr>
                    <td valign="top">Jumlah Hari Masuk</td>
                    <td valign="top" align="right"><?php echo $list['working_day']?></td>
                    <td></td>
                    <td valign="top">Jabatan</td>
                    <td valign="top"><?php echo find_2('job_title','userid',$list['user_id'],'employee_tb')?></td>
                </tr>
                <tr>
                    <td valign="top">Telat</td>
                    <td valign="top" align="right"><?php echo $list['late']?></td>
                    <td></td>
                    <td valign="top">Departemen</td>
                    <td valign="top"><?php echo find('name',find_2('department_id','userid',$list['user_id'],'employee_tb'),'department_tb')?></td>
                </tr>
                <tr>
                    <td valign="top">Lembur harian(jam)</td>
                    <td valign="top" align="right"><?php if($list['overtime_1'])echo currency($list['overtime_1']);else echo "-";?></td>
                    <td></td>
                    <td valign="top">Jumlah Hari Kerja</td>
                    <td valign="top" align="right"><?php echo $list['active_day']?></td>
                </tr>
                <tr>
                    <td valign="top">Lembur Weekend / Hari Besar (hari)</td>
                    <td valign="top" align="right"><?php if($list['overtime_2'])echo currency($list['overtime_2']);else echo "-";?></td>
                    <td></td>
                    <td valign="top">Saldo Cuti</td>
                    <td valign="top" align="right"><?php echo $list['last_dayoff']?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td valign="top">Cuti</td>
                    <td valign="top" align="right"><?php echo $list['absent']?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td valign="top">Sisa Cuti</td>
                    <td valign="top" align="right">
						<?php 	$sisa_cuti = abs($list['last_dayoff'])-abs($list['absent']);
								if($sisa_cuti>0)echo $sisa_cuti;else echo "0";
						?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" bgcolor="#000000"></td>
                </tr>
                <tr>
                    <td colspan="2"><b>PENERIMAAN</b></td>
                    <td></td>
                    <td colspan="2"><b>POTONGAN</b></td>
                </tr>
                <tr>
                    <td colspan="5" bgcolor="#000000"></td>
                </tr>
                <tr>
                    <td valign="top">Gaji Pokok</td>
                    <td valign="top" align="right">
					<?php echo currency(find_2('salary','userid',$list['user_id'],'employee_salary_tb'))?></td>
                    <td></td>
                    <td valign="top">Cicilan Pinjaman</td>
                    <td valign="top" align="right"><?php if($list['paid'])echo currency($list['paid']);else echo "-";?></td>
                </tr>
                <tr>
                    <td valign="top"></td>
                    <td valign="top" align="right"></td>
                    <td></td>
                    <td valign="top">Potongan Telat Masuk</td>
                    <td valign="top" align="right"><?php if($list['late_cost'])echo currency($list['late_cost']);else echo "-";?></td>
                </tr>
                <tr>
                	<td valign="top">Gaji yang diterima (Full/Proporsional)</td>
                    <td valign="top" align="right">
						<?php echo currency($list['salary_monthly'])?>
                    </td>
                    <td></td>
                    <td valign="top">Potongan PPH 21</td>
                    <td valign="top" align="right"><?php if($list['pph21'])echo currency($list['pph21']);else echo "-";?></td>
                    
                </tr>
                <tr>
                	<td valign="top">Uang Makan</td>
                    <td valign="top" align="right"><?php echo currency($list['meal'])?></td>
                    <td></td>
                    <td valign="top">Potongan Kelebihan Pembayaran Bulan Lalu</td>
                    <td valign="top" align="right"><?php if($list['over_payment'])echo currency($list['over_payment']);else echo "-";?></td>
                </tr>
                <tr>
                	<td valign="top">Uang Sewa Motor</td>
                    <td valign="top" align="right"><?php if($list['vehicle'])echo currency($list['vehicle']);else echo "-";?></td>
                    <td></td>
                    <td valign="top">Penalti Celengan</td>
                    <td valign="top" align="right"><?php if($list['meeting_cost'])echo currency($list['meeting_cost']);else echo "-";?></td>
                </tr>
                <tr>
                	<td valign="top">***Lembur Harian (jam)</td>
                    <td valign="top" align="right"><?php if($list['overtime_1_cost'])echo currency($list['overtime_1_cost'])?></td>
                    <td></td>
                    <td valign="top">JHT</td>
                    <td valign="top" align="right"><?php if($list['insurance'])echo currency($list['insurance']);else echo "-";?></td>
                </tr>
                <tr>
                	<td valign="top">***Lembur Weekend/Hari (Hari)</td>
                    <td valign="top" align="right"><?php if($list['overtime_2_cost'])echo currency($list['overtime_2_cost'])?></td>
                    <td></td>
                    <td valign="top"></td>
                    <td valign="top" align="right"></td>
                </tr>
                <tr>
                	<td valign="top">*Bonus Performance</td>
                    <td valign="top" align="right"><?php if($list['bonus_performance'])echo currency($list['bonus_performance']);else echo "-";?></td>
                    <td></td>
                    <td valign="top"></td>
                    <td valign="top" align="right"></td>
                </tr>
                <tr>
                	<td valign="top">**Bonus Massa</td>
                    <td valign="top" align="right"><?php if($list['bonus_massa'])echo currency($list['bonus_massa']);else echo "-";?></td>
                    <td></td>
                    <td valign="top"></td>
                    <td valign="top" align="right"></td>
                </tr>
                <tr>
                	<td valign="top">Rapel</td>
                    <td valign="top" align="right"><?php if($list['under_payment'])echo currency($list['under_payment']);else echo "-";?></td>
                    <td></td>
                    <td valign="top"></td>
                    <td valign="top" align="right"></td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
                
                <?php 
                $total_get = $list['salary_monthly']+$list['meal']+$list['bonus_massa']+$list['vehicle']+$list['bonus_performance']+$list['under_payment']+$list['overtime_2_cost']+$list['overtime_1_cost'];
                ?>
                <?php 
				$employee_detail=get_employee_detail($list['employee_id']);
				?>
                <?php if($employee_detail['tunjangan_jabatan']>0){
					$total_get+=$employee_detail['tunjangan_jabatan'];
					?>
                <tr>
                  <td valign="top">Tunjangan Jabatan</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_jabatan'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($employee_detail['tunjangan_bahasa_inggris']>0){
					$total_get+=$employee_detail['tunjangan_bahasa_inggris'];?>
                <tr>
                  <td valign="top">Tunjangan Bahasa Inggris</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_bahasa_inggris'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($employee_detail['tunjangan_access_control']>0){
					$total_get+=$employee_detail['tunjangan_access_control'];?>
                
                <tr>
                  <td valign="top">Tunjangan Access control</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_access_control'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_fire_alarm_system']>0){
					$total_get+=$employee_detail['tunjangan_fire_alarm_system'];?>
                <tr>
                  <td valign="top">Tunjangan Fire Alarm system</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_fire_alarm_system'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_fire_suppression']>0){
					$total_get+=$employee_detail['tunjangan_fire_suppression'];?>
                <tr>
                  <td valign="top">Tunjangan Fire Suppression</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_fire_suppression'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($employee_detail['tunjangan_bas']>0){
					$total_get+=$employee_detail['tunjangan_bas'];?>
                <tr>
                  <td valign="top">Tunjangan BAS</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_bas'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_gpon']>0){
					$total_get+=$employee_detail['tunjangan_gpon'];?>
                <tr>
                  <td valign="top">Tunjangan GPON</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_gpon'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($employee_detail['tunjangan_perimeter_intrusion']>0){
					$total_get+=$employee_detail['tunjangan_perimeter_intrusion'];?>
                <tr>
                  <td valign="top">Tunjangan Perimeter intrusion</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_perimeter_intrusion'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_public_address']>0){
					$total_get+=$employee_detail['tunjangan_public_address'];?>
                <tr>
                  <td valign="top">Tunjangan Public Address</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_public_address'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                
                <?php }?>
                <?php if($employee_detail['tunjangan_fiber_optic']>0){
					$total_get+=$employee_detail['tunjangan_fiber_optic'];?>
                <tr>
                  <td valign="top">Tunjangan Fiber Optic</td>
                  <td valign="top" align="right"><?php echo currency($employee_detail['tunjangan_fiber_optic'])?></td>
                  <td></td>
                  <td valign="top">&nbsp;</td>
                  <td valign="top" align="right">&nbsp;</td>
                </tr>
                <?php }?>
                <?php if($list['tunjangan_bpjs']>0 || $list['potongan_bpjs']>0){
					$total_get+=$list['tunjangan_bpjs'];
					//$total_pot-=$list['potongan_bpjs'];?>
                <tr>
                  <td valign="top">Tunjangan BPJS</td>
                  <td valign="top" align="right"><?php echo currency($list['tunjangan_bpjs'])?></td>
                  <td></td>
                  <td valign="top">Potongan BPJS</td>
                  <td valign="top" align="right"><?php echo currency($list['potongan_bpjs'])?></td>
                </tr>
                <?php }?>
                <tr>
                    <td valign="top"><b>Total Penerimaan</b></td>
                    <td valign="top" align="right"><b><?php echo currency($total_get);?>
                    </b></td>
                    <td></td>
                    <td valign="top"><b>Total Potongan</b></td>
                    <td valign="top" align="right"><b>
                    
                    <?php $total_pot = $list['paid']+$list['late_cost']+$list['pph21']+$list['over_payment']+$list['meeting_cost']+$list['insurance']+$list['potongan_bpjs'];
					echo currency($total_pot);?>
                    </b></td>
                </tr>
                <tr>
                    <td colspan="5" bgcolor="#000000"></td>
                </tr>
                <tr>
                    <td valign="top">Take Home Pay</td>
                    <td valign="top" align="right"><b><?php echo currency($total_get-$total_pot)?></b></td>
                    
                    <?php /*?><td valign="top" align="right"><b><?php echo currency($list['salary'])?></b></td><?php */?>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="5" bgcolor="#000000">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5"><b>NOTE</b></td>
                </tr>
                <tr>
                    <td colspan="2" bgcolor="#000000"></td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td valign="top">Saldo Pinjaman per Awal Bulan</td>
                    <td align="right"><?php if($list['last_debt'])echo currency(abs($list['last_debt']));else echo "-";?></td>
                    <td></td>
                    <td colspan="2">** Karyawan dengan massa kerja lebih dari 2 tahun</td>
                </tr>
                <tr>
                    <td valign="top">Pinjaman Bulan Ini</td>
                    <td align="right"><?php if($list['debt'])echo currency(abs($list['debt']));else echo "-";?></td>
                    <td></td>
                    <td colspan="2">* Karyawan dengan absensi tidak telat dan selalu masuk</td>
                </tr>
                <tr>
                    <td valign="top">Cicilan Pinjaman</td>
                    <td align="right"><?php if($list['paid'])echo currency(abs($list['paid']));else echo "-";?></td>
                    <td></td>
                    <td colspan="2">- Klaim dapat dilakukan max 7 hari setelah mendapatkan slip gaji</td>
                </tr>
                <tr>
                    <td valign="top">Saldo Pinjaman per Akhir Bulan</td>
                    <td align="right"><?php if((abs($list['last_debt'])+abs($list['debt'])-abs($list['paid']))<0)echo currency(abs((abs($list['last_debt'])+abs($list['debt'])-abs($list['paid']))));elseif((abs($list['last_debt'])+abs($list['debt'])-abs($list['paid']))>0)echo currency(abs(abs($list['last_debt'])+abs($list['debt'])-abs($list['paid']))); else echo "-";?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php if($list['notes']){?>
                <tr>
                    <td colspan="5" bgcolor="#000000"></td>
                </tr>
                <tr>
                	<td valign="top" colspan="5"><?php echo nl2br($list['notes'])?></td>
                </tr>
                <?php }?>
            </table>
        </div>
        <?php }?>
</body>
</html>