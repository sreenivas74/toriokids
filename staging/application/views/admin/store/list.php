<div id="content">
    <h2>E-Store &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/store/add');?>"><span>Add</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="10%">Action</th>
                <th width="20%">Name</th>
                <th width="20%">Image</th>
                <th width="20%">Address</th>
                <th width="20%">Link</th>
                <th width="8%" colspan="2">Precedence</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($store)foreach($store as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/store/change_active_store').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/store/edit').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td><?php if($list['image']!=""){?>
                    <img width="200" src="<?php echo base_url();?>userdata/e-store/<?php echo $list['image'];?>" /><?php }?>
            	</td>
                <td valign="top"><?php echo $list['address'];?></td>
                <td valign="top"><?php echo $list['link'];?></td>
    			<td valign="top">
    			 <?php if ($list['precedence'] != last_precedence('store_tb')){?>
                	<a href="<?php echo site_url('torioadmin/store/down_precedence_store/'.$list['id']);?>">Up</a>
                <?php }?>
                </td>
                <td valign="top">
               <?php if ($list['precedence'] != first_precedence('store_tb')){?>
    				<a href="<?php echo site_url('torioadmin/store/up_precedence_store/'.$list['id']);?>">Down</a> 
				<?php }?>
                </td>
    		</tr>
    		<?php $no++; } else if(!$store){ ?> 
            <tr>
                <td colspan="7"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>