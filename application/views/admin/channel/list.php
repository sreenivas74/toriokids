<div id="content">
    <h2>E-Channel &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/channel/add');?>"><span>Add</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="10%">Action</th>
                <th width="20%">Name</th>
                <th width="20%">Link</th>
                <th width="20%">Image</th>
                
                <th width="8%" colspan="2">Precedence</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($channel)foreach($channel as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/channel/change_active_channel').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/channel/edit').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><?php echo $list['link'];?></td>
                <td><?php if($list['image']!=""){?>
                    <img width="200" src="<?php echo base_url();?>userdata/e-channel/<?php echo $list['image'];?>" /><?php }?>
            	</td>
                
    			<td valign="top">
    			 <?php if ($list['precedence'] != last_precedence('channel_tb')){?>
                	<a href="<?php echo site_url('torioadmin/channel/down_precedence_channel/'.$list['id']);?>">Up</a>
                <?php }?>
                </td>
                <td valign="top">
               <?php if ($list['precedence'] != first_precedence('channel_tb')){?>
    				<a href="<?php echo site_url('torioadmin/channel/up_precedence_channel/'.$list['id']);?>">Down</a> 
				<?php }?>
                </td>
    		</tr>
    		<?php $no++; } else if(!$channel){ ?> 
            <tr>
                <td colspan="7"><?php echo "No channel Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>