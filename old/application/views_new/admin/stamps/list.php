<div id="content">
<h2>Stamps Rewards List</h2>

<table class="defAdminTable" width="100%">
	<thead>
    	<tr>
            <th >No</th>
            <th >Code</th>
            <th Name</th>
            <th >Image</th>
            <th >Stamps to Redeem</th>

        </tr>
    </thead>
    <tbody>
    <?php $no=1?>
	<?php foreach($list_reward['rewards'] as $list) {?>
    <tr>
    <td valign="top"><?php echo $no++?></td>
    <td valign="top"><?php echo $list['code']?></td>
    <td valign="top"><?php echo $list['name']?></td>
    <td valign="top"><img src="<?php echo $list['image_url']?>" width="100" /></td>     
    <td valign="top"><?php echo $list['stamps_to_redeem']?></td> 

    </tr>
	<?php } ?>
    
    </tbody>
</table>

</div>