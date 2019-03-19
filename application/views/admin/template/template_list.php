<div id="content">
    <h2>Template &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/template/add_template');?>"><span>Add</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="15%">Action</th>
                <th width="75%">Name</th>
                <th width="8%">Precedence</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($template)foreach($template as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top"><a href="<?php echo site_url('torioadmin/template/active_template').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a>  |
                <a href="<?php echo site_url('torioadmin/template/edit_template_name').'/'.$list['id'];?>">Edit</a> | <a href="<?php echo site_url('torioadmin/template/view_template_size').'/'.$list['id'];?>">View</a>
                </td>
                <td valign="top"><?php echo $list['name'];?></td>
    			<td valign="top">
    			<?php if ($list['precedence'] != first_precedence('template_name_tb')){?>
    				<a href="<?php echo site_url('torioadmin/template/up_precedence_template_name/'.$list['id']);?>">Up</a> 
				<?php }
					if($list['precedence']!=first_precedence('template_name_tb') and  $list['precedence'] != last_precedence('template_name_tb')) echo " | ";
    				if ($list['precedence'] != last_precedence('template_name_tb')){?>
    				<a href="<?php echo site_url('torioadmin/template/down_precedence_template_name/'.$list['id']);?>">Down</a>
    			<?php }?>
                </td>
    		</tr>
    		<?php $no++; } else if(!$template){ ?> 
            <tr>
                <td colspan="6"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>