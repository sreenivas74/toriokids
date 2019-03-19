<script>
$(function() {
	$( ".schedule_time" ).datetimepicker({
	});
});

</script>

<div id="content">
    <h2>Campaign &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/campaign/add');?>"><span>Add</span></a></a></li>
        </ul>
    </div>
    Server Time : <?php echo date("d F Y, H:i:s") ?>
<table class="defAdminTable" width="100%">
	<thead>
    	<tr>
			<th width="2%">No</th>
			<th width="9%">Action</th>
            <th width="10%">Subject Email</th>
			<th width="8%">Title</th>
            <th width="8%">Schedule Time</th>
            <th width="18%">Active</th>
            <th width="3%">Set to MC</th>
       	</tr>
    </thead>
    <tbody>
    <?php 
	$no=1;	
	if($campaign)foreach($campaign as $list){?>
    <tr>
    	<td><?php echo $no;?></td>
    	<td><a href="<?php echo site_url('torioadmin/campaign/edit').'/'.$list['id'];?>">Edit</a> | <a href="<?php echo site_url('torioadmin/campaign/delete').'/'.$list['id'];?>" onclick="return confirm('Confirm Delete?');">Delete</a> | <a target="_blank" href="<?php echo site_url('torioadmin/campaign/preview')."/".$list['id'] ?>">Preview</a></td>
        <td><?php echo $list['subject'];?></td>
    	<td><?php echo $list['title'];?></td>
        <td><?php if($list['schedule_time']!=0) echo date('d/m/Y H:i:s', $list['schedule_time']); else echo "No schedule"; ?></td>
        <td><?php if($list['active']==1){?>
    	  <a href="<?php echo site_url('torioadmin/campaign/active/'.$list['id'].'/'.$list['active']);?>">Active</a> <br> 
		  
			  <?php if($list['campaign_id']!='' && $list['sent']==0){?>  <a class="defBtn" href="<?php echo site_url('cronjob_mailchimp/send_campaign');?>" onclick="return confirm('Blast this campaign now?')"><span>Blast Now!</span></a> <a class="defBtn" href="javascript:void(0)" onclick="show_row(<?php echo $list['id'] ?>)"><span>Schedule</span></a> <a class="defBtn"  href="javascript:void(0)" onclick="show_rowtest(<?php echo $list['id'] ?>)"><span>Send Test Email</span></a><?php }
              else if($list['campaign_id']=='')
              { ?> 
                <a class="defBtn" href="<?php echo site_url('cronjob_mailchimp/create_campaign');?>"><span>Add Campaign to Mailchimp</span></a> 
              <?php }
              else{?>
                <a class="defBtn" target="_blank" href="<?php echo site_url('cronjob_mailchimp/view_campaign');?>"><span>View Campaign</span></a> <?php if($list['schedule_time']!=0){ 
				$now = time(); if($list['schedule_time']>=$now){?><a class="defBtn" href="<?php echo site_url('cronjob_mailchimp/unschedule_campaign');?>"><span>Unschedule</span></a><?php }
				}?>
              <?php }?>
	  <?php }else{?>
      <a href="<?php echo site_url('torioadmin/campaign/active/'.$list['id'].'/'.$list['active']);?>">inactive</a>
      <?php } ?></td>
      	<td><?php if($list['sent']==1) echo "Yes"; else echo "No"; ?></td>
      </tr>
      <tr class="row" id="row_<?php echo $list['id'] ?>" style="display:none">
      	<td></td>
        <td colspan="6">
        <form name="schedule_form" method="post" enctype="multipart/form-data" action="<?php echo site_url('cronjob_mailchimp/schedule_campaign') ?>">
            <input type="hidden" name="campaign_id" value="<?php echo $list['id'] ?>" />
            <input type="text" name="schedule_time" class="schedule_time" id="schedule_time_<?php echo $list['id'] ?>" />
            <input type="submit" value="Submit" onclick="return confirm('Submit this campaign schedule?')"  />
        </form>
        </td>
      </tr>
      <tr class="row" id="rowtest_<?php echo $list['id'] ?>" style="display:none">
      	<td></td>
        <td colspan="6">
        <form name="test_form" method="post" enctype="multipart/form-data" action="<?php echo site_url('cronjob_mailchimp/test_campaign') ?>">
            <input type="hidden" name="campaign_id" value="<?php echo $list['id'] ?>" />
            <span>Email ( Multiple email with <span style="color:red; font-size:18px;"><strong>;</strong></span> )</span><br />
            <input type="text" class="txtField" name="email" class="email" id="email_<?php echo $list['id'] ?>" />
            <input type="submit" value="Submit"  />
        </form>
        </td>
      </tr>
    <?php $no++; }?>
    
    </tbody>
</table>
</div>

<script>
function show_row(id){
	$('.schedule_time').val('');
	$('.row').hide();
	$('#row_'+id).show();
}

function show_rowtest(id){
	$('.schedule_time').val('');
	$('.row').hide();
	$('#rowtest_'+id).show();
}
</script>