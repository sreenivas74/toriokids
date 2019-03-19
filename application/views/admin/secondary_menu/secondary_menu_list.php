<div id="content">
    <h2>Secondary Navigation &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/secondary_menu/add');?>"><span>Add</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="20%">Action</th>
                <!-- <th width="20%">Category</th> -->
                <th width="30%">Name</th>
                <th width="30%">Link</th>
                <th width="8%">Precedence</th>
            </tr>
        </thead>
        <tbody>

        <?php $no=1; 
			  if($secondary_menu)foreach($secondary_menu as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/secondary_menu/change_active_secondary_menu').'/'.$list['id'].'/'.$list['active'] ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/secondary_menu/edit').'/'.$list['id'];?>">Edit</a> | <a href="<?php echo site_url('torioadmin/secondary_menu/delete/'.$list['id']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><?php echo $list['link'];?></td>
               
    			<td valign="top">
    			<?php if ($list['precedence'] != first_precedence('secondary_menu_tb')){?>
    				<a href="<?php echo site_url('torioadmin/secondary_menu/up_precedence_secondary_menu/'.$list['id']);?>">Up</a> 
				<?php }
					if($list['precedence']!=first_precedence('secondary_menu_tb') and  $list['precedence'] != last_precedence('secondary_menu_tb')) echo " | ";
    				if ($list['precedence'] != last_precedence('secondary_menu_tb')){?>
    				<a href="<?php echo site_url('torioadmin/secondary_menu/down_precedence_secondary_menu/'.$list['id']);?>">Down</a>
    			<?php }?>
                </td>
    		</tr>
    		<?php $no++; } else if(!$secondary_menu){ ?> 
            <tr>
                <td colspan="6"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>