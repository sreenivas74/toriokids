
<h2>Slip Gaji Update Periode ( <?php echo date("d F Y",(strtotime($slip_detail['periode_from'])))?> - <?php echo date("d F Y",strtotime($slip_detail['periode_to']))?> )</h2>
<form name="do_update_slip_gaji_form" method="post" action="<?php echo site_url('absence/do_update_slip_gaji')?>">
<table class="form" style="width:50%; color:#000">
	<input type="hidden" name="id" value="<?php echo $slip_detail['id']?>">
	<input type="hidden" name="employee_id" value="<?php echo $slip_detail['employee_id']?>">
	<tr>
    	<td style="width:40%">Name</td>
        <td><?php echo find('firstname',$slip_detail['employee_id'],'employee_tb')." ".find('lastname',$slip_detail['employee_id'],'employee_tb')?></td>
    </tr>
    <tr>
    	<td style="width:30%">Department</td>
        <td><?php echo find('name',find('department_id',$slip_detail['employee_id'],'employee_tb'),'department_tb')?></td>
    </tr>
    <tr>
    	<td>Hari Kerja</td>
        <td><?php echo $slip_detail['active_day']?></td>
    </tr>
    <tr>
    	<td>Masuk</td>
        <td><input type="text" style="width:30px" name="working_day" value="<?php echo $slip_detail['working_day']?>"></td>
    </tr>
    <tr>
    	<td>Tidak Masuk</td>
        <td><input type="text" style="width:30px" name="absent" value="<?php echo $slip_detail['absent']?>"></td>
    </tr>
    <tr>
    	<td>Overide</td>
        <td><input type="text" style="width:30px" name="overide" value="<?php echo $slip_detail['overide']?>"></td>
    </tr>
    <tr>
    	<td>Telat / Potongan</td>
        <td><input type="text" style="width:30px" name="late" value="<?php echo $slip_detail['late']?>"> / <input type="text" name="late_cost" style="width:70px" value="<?php echo $slip_detail['late_cost']?>"></td>
    </tr>
    <tr>
    	<td>Sisa Cuti</td>
        <td><input type="text" name="last_dayoff" style="width:30px" value="<?php echo $slip_detail['last_dayoff']?>"></td>
    </tr>
    <tr>
    	<td>Overtime 1</td>
        <td><input type="text" name="overtime_1" style="width:30px" value="<?php echo $slip_detail['overtime_1']?>"> / <input type="text" name="overtime_1_cost" style="width:70px" value="<?php echo $slip_detail['overtime_1_cost']?>"></td>
    </tr>
    <tr>
    	<td>Overtime 2</td>
        <td><input type="text" name="overtime_2" style="width:30px" value="<?php echo $slip_detail['overtime_2']?>"> / <input type="text" name="overtime_2_cost" style="width:70px" value="<?php echo $slip_detail['overtime_2_cost']?>"></td>
    </tr>
    <tr>
    	<td>Uang Makan</td>
        <td><input type="text" style="width:70px" name="meal" value="<?php echo $slip_detail['meal']?>"></td>
    </tr>
    <tr>
    	<td>Uang Kendaraan</td>
        <td><input type="text" style="width:70px" name="vehicle" value="<?php echo $slip_detail['vehicle']?>"></td>
    </tr>
    <tr>
    	<td>Bonus Massa</td>
        <td><input type="text" style="width:70px" name="bonus_massa" value="<?php echo $slip_detail['bonus_massa']?>"></td>
    </tr>
    <tr>
    	<td>Bonus Performance</td>
        <td><input type="text" style="width:70px" name="bonus_performance" value="<?php echo $slip_detail['bonus_performance']?>"></td>
    </tr>
    <tr>
    	<td>Rapel</td>
        <td><input type="text" style="width:70px" name="under_payment" value="<?php echo $slip_detail['under_payment']?>"></td>
    </tr>
    <tr>
    	<td>Potongan Pph 21</td>
        <td><input type="text" style="width:70px" name="pph21" value="<?php echo $slip_detail['pph21']?>"></td>
    </tr>
    <tr>
    	<td>Potongan Insurance</td>
        <td><input type="text" style="width:70px" name="insurance" value="<?php echo $slip_detail['insurance']?>"></td>
    </tr>
    <tr>
    	<td>Potongan Kelebihan Pembayaran</td>
        <td><input type="text" style="width:70px" name="over_payment" value="<?php echo $slip_detail['over_payment']?>"></td>
    </tr>
    <tr>
    	<td>Potongan Tidak Hadir Meeting</td>
        <td><input type="text" style="width:70px" name="meeting_cost" value="<?php echo $slip_detail['meeting_cost']?>"></td>
    </tr>
    <tr>
    	<td>Saldo Pinjaman Awal Bulan</td>
        <td><input type="text" style="width:70px" name="last_debt" value="<?php echo abs($slip_detail['last_debt'])?>"></td>
    </tr>
    <tr>
    	<td>Tambah Utang</td>
        <td><input type="text" style="width:70px" name="debt" value="<?php echo abs($slip_detail['debt'])?>"></td>
    </tr>
    <tr>
    	<td>Cicilan Pinjaman</td>
        <td><input type="text" style="width:70px" name="paid" value="<?php echo abs($slip_detail['paid'])?>"></td>
    </tr>
    <tr>
    	<td>Gaji Pokok</td>
        <td><input type="text" style="width:70px" name="salary_monthly" value="<?php echo abs($slip_detail['salary_monthly'])?>"></td>
    </tr>
    <tr>
    	<td>Total Gaji</td>
        <td><input type="text" style="width:70px" name="salary" value="<?php echo abs($slip_detail['salary'])?>"></td>
    </tr>
    <?php /*pre($slip_detail)?>
    
    <tr>
    	<td>Tunjangan Jabatan</td>
        <td><input type="text" style="width:70px" name="tunjangan_jabatan" value="<?php echo abs($slip_detail['tunjangan_jabatan'])?>"></td>
    </tr>
    <tr>
    	<td>Tunjangan Bahasa Inggris</td>
        <td><input type="text" style="width:70px" name="tunjangan_bahasa_inggris" value="<?php echo abs($slip_detail['tunjangan_bahasa_inggris'])?>"></td>
    </tr>
    <tr>
    	<td>Tunjangan Access Control</td>
        <td><input type="text" style="width:70px" name="tunjangan_access_control" value="<?php echo abs($slip_detail['tunjangan_access_control'])?>"></td>
    </tr>
    <tr>
    	<td>Tunjangan Fire Alarm System</td>
        <td><input type="text" style="width:70px" name="tunjangan_fire_alarm_system" value="<?php echo abs($slip_detail['tunjangan_fire_alarm_system'])?>"></td>
    </tr>
    <tr>
    	<td>Tunjangan Fire Suppression</td>
        <td><input type="text" style="width:70px" name="tunjangan_fire_suppression" value="<?php echo abs($slip_detail['tunjangan_fire_suppression'])?>"></td>
    </tr>
    <tr>
    	<td>Tunjangan BAS</td>
        <td><input type="text" style="width:70px" name="tunjangan_bas" value="<?php echo abs($slip_detail['tunjangan_bas'])?>"></td>
    </tr>
    <tr>
    	<td>Tunjangan GPON</td>
        <td><input type="text" style="width:70px" name="tunjangan_gpon" value="<?php echo abs($slip_detail['tunjangan_gpon'])?>"></td>
    </tr
    ><tr>
    	<td>Tunjangan Perimeter Intrusion</td>
        <td><input type="text" style="width:70px" name="tunjangan_perimeter_intrusion" value="<?php echo abs($slip_detail['tunjangan_perimeter_intrusion'])?>"></td>
    </tr>
    <tr>
    	<td>Tunjangan Public Address</td>
        <td><input type="text" style="width:70px" name="tunjangan_public_address" value="<?php echo abs($slip_detail['tunjangan_public_address'])?>"></td>
    </tr>
    <tr>
    	<td>Tunjangan Fiber Optic</td>
        <td><input type="text" style="width:70px" name="tunjangan_fiber_optic" value="<?php echo abs($slip_detail['tunjangan_fiber_optic'])?>"></td>
    </tr>
    <tr>
    	<td>Tunjangan BPJS</td>
        <td><input type="text" style="width:70px" name="tunjangan_bpjs" value="<?php echo abs($slip_detail['tunjangan_bpjs'])?>"></td>
    </tr>
    <tr>
    	<td>Potongan BPJS</td>
        <td><input type="text" style="width:70px" name="potongan_bpjs" value="<?php echo abs($slip_detail['potongan_bpjs'])?>"></td>
    </tr>
    <?php */?>
    <tr>
    	<td>Notes</td>
        <td><textarea style="width:300px; height:30px" name="notes"><?php echo $slip_detail['notes']?></textarea></td>
    </tr>
    <tr>
    	<td></td>
        <td><input type="submit" onClick="return confirm('Confirm this update?');return false;"> <input style="width:60px;" type="button" onClick="window.location = '<?php echo base_url()?>absence/approval_list';" value="back"></td>
    </tr>
</table>
</form>