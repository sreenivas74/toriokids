<script type="text/javascript">
$(document).ready(function(){
	$('.periode_date').datepicker({
		numberOfMonths: 1,
		showButtonPanel: true,
		yearRange: "-80:+80",
		changeYear: true,
		dateFormat: "yy-mm-dd",
		minDate: "-80y"
	});
});
</script>
<h2>Absence</h2>
<form name="absence_form" action="<?php echo site_url('absence/import_data/')?>" method="post" enctype="multipart/form-data">
	<dl>
    	<dd>File</dd>
        <dt><input type="file" name="excel_file" value="excel file"></dt>
    </dl><br />
    <dl>
    	<dd>Bulan : 
        	<select name="month">
				<?php for($i=1;$i<13;$i++){?>
                    <option value="<?php echo $i?>"><?php echo date('F',strtotime(date('Y-'.$i.'-01')))?></option>
                <?php }?>
            </select>
            
            Tahun : 
            <select name="year">
				<?php for($i=0;$i<10;$i++){?>
                    <option value="<?php echo date('Y')-$i;?>"><?php echo date('Y')-$i;?></option>
                <?php }?>
            </select>
    	</dd>
    </dl>
    <dl>
    	<dd>Periode</dd>
        <dt><input type="text" name="periode_from" class="periode_date" /> - <input type="text" name="periode_to" class="periode_date" /></dt>
    </dl>
    <dl>
    	<dd>Jumlah Hari Masuk</dd>
        <dt><input type="text" name="active_day" /> *banyaknya hari masuk ( dipotong dengan hari libur )</dt>
    </dl>
    <dl>
    	<dd></dd>
        <dt><br /><input type="submit" value="upload">
        	<?php if(isset($_SESSION['absen_error']))echo "<br /><br />".$_SESSION['absen_error'];
			unset($_SESSION['absen_error']);
			?>
        </dt>
    </dl>
</form>
<br />
<br />
<h2>Salary Reject List</h2>
<?php 
if($reject_list) { ?>
<table class="form" style="width:50%; color:#000">
	<thead>
    	<tr><th>No</th>
    	<th>Periode</th>
        <th>Edit</th>
        <th>Status</th></tr>
    </thead>
    <tbody>
    	<?php 
		$n = 1 ;
		if($reject_list)foreach($reject_list as $list){?>
        <tr>
            <td align="right"><?php echo $n; ?> </td>
            <td>
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","absence/salary_edit","privilege_tb")){?>
            	<a onclick="return confirm('Delete this salary?');return false;" href="<?php echo site_url('absence/delete_salary_pending').'/'.strtotime($list['periode_from']).'/'.strtotime($list['periode_to'])?>"><img src="<?php echo base_url()?>images/delete.png" width="10" /></a>
            <?php }else echo "-";?>
            <?php echo date("d F Y",strtotime($list['periode_from'])) ?> - <?php echo date("d F Y",strtotime($list['periode_to'])) ?></td>
            <td align="center">
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","absence/salary_edit","privilege_tb")){?>
				<?php if($list['status']<5){?>
                <a href="<?php echo site_url('absence/reject_salary_detail').'/'.strtotime($list['periode_from']).'/'.strtotime($list['periode_to']).'/'.$list['status']?>"><img src="<?php echo base_url()?>images/edit.png" width="10" /></a> 
                <?php }else echo "approved"?>
            <?php }else echo "-";?>
           </td>
           <td align="center">
		   <?php if($list['status']==0)echo "Pending Absen 1 Approval"; 
		   			elseif($list['status']==1)echo "Absen 1 Rejected";
					elseif($list['status']==2)echo "Absen 1 Approved";
					elseif($list['status']==3)echo "Pending absen 2 approval";
					elseif($list['status']==4)echo "Absen 2 rejected";
					else echo "Absen 2 approved";?></td>
      	</tr>
       <?php $n++;}?>
    </tbody>
    </table>
<?php } ?>
