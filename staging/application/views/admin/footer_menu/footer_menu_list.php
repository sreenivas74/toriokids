<div id="content">
    <h2>Footer Menu &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/footer_menu/add');?>"><span>Add</span></a></li>
        </ul>
    </div>
    <?php /* ?>
    <dl>
        <dd>Category</dd>
        <dt>
        <form name="select_category_form" method="post" action="<?php echo site_url('torioadmin/footer_menu')?>">
            <select class="txtField" style="width:200px" name="category" onChange="document.select_category_form.submit()">
               	<option value="4" <?php if($cat == 4){?> selected="selected"<?php } ?>>View All</option>
                <option value="1" <?php if($cat == 1){?> selected="selected"<?php } ?>>Help</option>
                <option value="2" <?php if($cat == 2){?> selected="selected"<?php } ?>>About Torio Kids</option>
                <?php /*?><option value="3" <?php if($cat == 3){?> selected="selected"<?php } ?>>Connect With Us</option><?php ?>
                
            </select>
        </form>
        </dt>
    </dl>
    <?php */ ?>
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
        <?php if($cat!=null){ ?>
        <?php $no=1; 
			  if($footer_menu)foreach($footer_menu as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/footer_menu/change_active_footer_menu').'/'.$list['id'].'/'.$list['active'] ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/footer_menu/edit').'/'.$list['id'];?>">Edit</a> | <a href="<?php echo site_url('torioadmin/footer_menu/delete/'.$list['id']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
                <!-- <td valign="top"><?php if($list['category']==1)echo "Help"; else if($list['category']==2)echo "About Torio Kids"; else echo "Connect With Us";?></td> -->
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><?php echo $list['link'];?></td>
               
    			<td valign="top">
    			<?php if ($list['precedence'] != first_precedence('footer_menu_tb')){?>
    				<a href="<?php echo site_url('torioadmin/footer_menu/up_precedence_footer_menu/'.$list['id']);?>">Up</a> 
				<?php }
					if($list['precedence']!=first_precedence('footer_menu_tb') and  $list['precedence'] != last_precedence('footer_menu_tb')) echo " | ";
    				if ($list['precedence'] != last_precedence('footer_menu_tb')){?>
    				<a href="<?php echo site_url('torioadmin/footer_menu/down_precedence_footer_menu/'.$list['id']);?>">Down</a>
    			<?php }?>
                </td>
    		</tr>
    		<?php $no++; } else if(!$footer_menu && $cat!=0){ ?> 
            <tr>
                <td colspan="6"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php }} ?>
        </tbody>
    </table>
</div>