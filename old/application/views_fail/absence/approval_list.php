<h2>Approval List</h2>
<a href="#" onclick="$('#update_slip_gaji').show();return false;"><img src="<?php echo base_url()?>images/edit.png" width="10" /> Personal Update</a>
<div id="update_slip_gaji" class="slip_gaji" style="display:none; padding-left:15px;">
	<hr size="1" />
	<form name="update_slip_gaji_form" method="post" action="<?php echo site_url('absence/update_slip_gaji');?>">
    	<dl>
        	<dd>Periode &nbsp;&nbsp;
            <select name="periode_from">
            	<?php if($approval_list)foreach($approval_list as $list){
						if($list['status']==5){?>
            				<option value="<?php echo $list['periode_from']?>"><?php echo date("d F Y",strtotime($list['periode_from'])) ?> - <?php echo date("d F Y",strtotime($list['periode_to'])) ?></option>
                <?php }
				}?>
            </select>
            </dd>
        </dl>
        <dl>
        	<dd>Employee
            <select name="employee_id">
            	<?php if($employee_list)foreach($employee_list as $list){?>
            		<option value="<?php echo $list['id']?>"><?php echo $list['firstname']." ".$list['lastname']?></option>
                <?php }?>
            </select>
            </dd>
        </dl>
        <dl>
        	<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" value="update" onclick="return confirm('Update this employee salary?');return false;" /> <input type="button" value="cancel" onclick="$('.slip_gaji').hide();return false;" /></dd>
        </dl>
    </form>
	<hr size="1" />
</div>
<br /><br />
<?php if($approval_list) { ?>
<table class="form" style="width:50%; color:#000">
	<thead>
    	<tr><th>No</th>
    	<th>Periode</th>
        <th>Action</th>
        <th>Status</th>
        <th>Change Step</th></tr>
    </thead>
    <tbody>
    	<?php 
		$n = 0 ;
		if($approval_list)foreach($approval_list as $list) { ?>
        <tr>
            <td align="right"><?php echo $n+1; ?> </td>
            <td><?php echo date("d F Y",strtotime($list['periode_from'])) ?> - <?php echo date("d F Y",strtotime($list['periode_to'])) ?></td>
            <td align="center">
            <a href="<?php echo site_url('absence/approved_salary_detail').'/'.strtotime($list['periode_from']).'/'.strtotime($list['periode_to']).'/'.$list['status']?>">View</a>
            | 
            <a target="_blank" href="<?php echo site_url('absence/send_salary').'/'.strtotime($list['periode_from']).'/'.strtotime($list['periode_to']).'/'.$list['status']?>">Preview</a>
            
            <?php //if($list['status']==5){?>
            
             | 
            <a href="<?php echo site_url('absence/send_salary_email').'/'.strtotime($list['periode_from']).'/'.strtotime($list['periode_to']).'/'.$list['status']?>" onclick="return confirm('Send Salary for this periode <?php echo "(".date("d F Y",strtotime($list['periode_from'])) ?> - <?php echo date("d F Y",strtotime($list['periode_to'])).") ?";?>');return false;">Email</a>
            <?php //}?>
            </td>
            <td align="center">
			<?php if($list['status']==0)echo "Absen 1 Approval"; 
					elseif($list['status']==3)echo "absen 2 approval";
					elseif($list['status']==5)echo "Approved"?>
            </td>
            <td>
            <?php if($list['status']!=5){?>
            <a onclick="return confirm('Change step to approval I?');return false;" href="<?php echo site_url('absence/change_step/'.$list['periode_from'].'/'.$list['periode_to'].'/0')?>">Approval I</a> / <a onclick="return confirm('Change step to approval II?');return false;"  href="<?php echo site_url('absence/change_step/'.$list['periode_from'].'/'.$list['periode_to'].'/3')?>">Approval II</a>
            <?php }else echo "-";?>
            </td>
        </tr>
        <?php $n++;} ?>
    </tbody>
    </table>
<?php } else {echo "belum ada";} ?>