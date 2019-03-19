<div id="content">
    <h2>Category &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/category/add');?>"><span>Add</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="15%">Action</th>
                <th width="20%">Name</th>
                <th width="20%">Alias</th>
                <th width="25%">Description</th>
                <th width="20%">Banner Image</th>
                <th width="8%">Precedence</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($category)foreach($category as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/category/change_active_category').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/category/edit').'/'.$list['id'];?>">Edit</a> | 
                <a href="<?php echo site_url('torioadmin/category/view_sub_category_list').'/'.$list['id'];?>">View</a>
                </td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><?php echo $list['alias'];?></td>
                <td valign="top"><?php echo $list['description'];?></td>
                <td><?php if($list['banner_image']!=""){?>
                    <img width="200" src="<?php echo base_url();?>userdata/category_banner/<?php echo $list['banner_image'];?>" /><?php }?>
            	</td>
    			<td valign="top">
    			<?php if ($list['precedence'] != first_precedence('category_tb')){?>
    				<a href="<?php echo site_url('torioadmin/category/up_precedence_category/'.$list['id']);?>">Up</a> 
				<?php }
					if($list['precedence']!=first_precedence('category_tb') and  $list['precedence'] != last_precedence('category_tb')) echo " | ";
    				if ($list['precedence'] != last_precedence('category_tb')){?>
    				<a href="<?php echo site_url('torioadmin/category/down_precedence_category/'.$list['id']);?>">Down</a>
    			<?php }?>
                </td>
    		</tr>
    		<?php $no++; } else if(!$category){ ?> 
            <tr>
                <td colspan="6"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>