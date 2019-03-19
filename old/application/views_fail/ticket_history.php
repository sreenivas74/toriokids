<script type="text/javascript">
	function open_problem(){
		$('#open_problem').slideDown();	
	}
	
	function close_problem(){
		$('#open_problem').slideUp();	
	}
</script>
<style>
	table{
		color:#000;
	}
	table tr th{
		font-weight:bold;
		padding:5px;
	}
	table tr td{
		padding:5px;
	}
	.warning{
		color:#F00;	
	}
</style>
<h2>Ticket #<?php echo $login;?> <?php if($ticket_detail['status']==1){?> <span class="warning"> [ Closed ] </span><?php }?>
</h2>
Problem : <br />
<b>
<?php if($ticket_detail['complaint'])echo date('d/m/Y',strtotime($ticket_detail['created_date']));?>
 - 
<?php echo nl2br($ticket_detail['complaint'])?>
</b>
<br /><br />
<table border="1" width="70%">
	<tr bgcolor="#999999">
    	<th width="10%">Date</th>
    	<th width="35%">Customer</th>
        <th width="10%">Date</th>
        <th width="35%">Customer Service</th>
    </tr>
    <?php  
	$ticket_response = find_ticket_response($ticket_detail['id']);
	while($list = mysql_fetch_assoc($ticket_response)){?>
    	<tr>
        	<td valign="top" <?php if(!$list['problem']){?>bgcolor="#CCCCCC"<?php }?>><?php if($list['problem'])echo date('d/m/Y',strtotime($list['send_date_2']))?><br />
        	<?php if($list['problem'])echo date('H:i:s',strtotime($list['send_date_2']))?></td>
            <td valign="top" <?php if(!$list['problem']){?>bgcolor="#CCCCCC"<?php }?>><?php echo nl2br($list['problem'])?></td>
            <td valign="top" <?php if(!$list['response']){?>bgcolor="#CCCCCC"<?php }?>><?php if($list['response'])echo date('d/m/Y',strtotime($list['send_date']))?><br />
        	<?php if($list['response'])echo date('H:i:s',strtotime($list['send_date']))?></td>
            <td valign="top" <?php if(!$list['response']){?>bgcolor="#CCCCCC"<?php }?>><?php echo nl2br($list['response'])?></td>
        </tr>
        
	<?php }
	?>
    <tr>
    	<td valign="top"><?php //if($ticket_detail['complaint'])echo date('d/m/Y',strtotime($ticket_detail['created_date']))?><br />
        	<?php //if($ticket_detail['complaint'])echo date('H:i:s',strtotime($ticket_detail['created_date']))?>
        </td>
        <td valign="top"><?php //echo nl2br($ticket_detail['complaint'])?></td>
        <td valign="top"><?php if($ticket_detail['respond'])echo date('d/m/Y',strtotime($ticket_detail['last_update']))?><br />
        	<?php if($ticket_detail['respond'])echo date('H:i:s',strtotime($ticket_detail['last_update']))?>
        </td>
        <td valign="top"><?php echo nl2br($ticket_detail['respond'])?></td>
    </tr>
</table>
<br /><br />
+ Add <?php if($ticket_detail['status']==0){?>
	<a href="#" onclick="open_problem();return false;">New Response</a> or 
<?php }?>
<a href="<?php echo site_url('ticket')?>">New Ticket</a>
<div id="open_problem" style="display:none;">
	<br />
	<form name="open_problem_form" method="post" enctype="multipart/form-data" action="<?php echo site_url('ticket/do_add_problem/');?>">
    	<input type="hidden" name="ticket_id" value="<?php echo $ticket_detail['id']?>" />
        <input type="hidden" name="login" value="<?php echo $login?>" />
        <input type="hidden" name="password" value="<?php echo $password?>" />
        <dl>
        	<dd><b>Problem</b></dd>
            <dt><textarea name="problem" cols="50" rows="3"></textarea></dt>
        </dl>
        <dl>
        	<dd><input type="submit" value="add problem" /><input type="button" value="close" onclick="close_problem();return false;" /></dd>
        </dl>
    </form>
</div>
<br />
<span class="warning">
<?php if(isset($_SESSION['ticket_notif']))echo "<br />*".$_SESSION['ticket_notif'];?>
</span>