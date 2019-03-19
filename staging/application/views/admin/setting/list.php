<div id="content">
    <h2>Setting &raquo; Toriokids Mailchimp</h2>
<table class="defAdminTable" width="40%">
	<thead>
    	<tr>
			<th width="10%">Mailchimp API Key</th>
            <th width="10%">Mailchimp Id</th>
        </tr>
    </thead>
    <tbody>
    
    <tr>
    	<td><?php if($setting){ ?><?php echo $setting[0]['value'];?><br><a href="<?php echo site_url('torioadmin/setting/edit').'/'.$setting[0]['name'];?>">Edit</a><?php }?></td>
        <td><?php if($setting){ ?><?php echo $setting[1]['value'];?><br><a href="<?php echo site_url('torioadmin/setting/edit').'/'.$setting[1]['name'];?>">Edit</a><?php }?></td>
      </tr>
    </tbody>
</table>
</div>