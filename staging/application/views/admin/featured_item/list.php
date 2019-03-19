<div id="content">
    <h2>Featured Items &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/featured_item/add');?>"><span>Add</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="10%">Action</th>
                <th width="20%">Title</th>
                <th width="20%">Link</th>
                <th width="20%">Image</th>
                <th width="20%">Description</th>
                <th width="8%" colspan="2">Precedence</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($featured_item)foreach($featured_item as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/featured_item/change_active_featured_item').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/featured_item/edit').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo $list['title'];?></td>
                <td valign="top"><?php echo $list['link'];?></td>
                <td><?php if($list['image']!=""){?>
                    <img width="200" src="<?php echo base_url();?>userdata/featured/<?php echo $list['image'];?>" /><?php }?>
            	</td>
                <td valign="top"><?php echo $list['description'];?></td>
    			<td valign="top">
    			 <?php if ($list['precedence'] != last_precedence('featured_item_tb')){?>
                	<a href="<?php echo site_url('torioadmin/featured_item/down_precedence_featured_item/'.$list['id']);?>">Up</a>
                <?php }?>
                </td>
                <td valign="top">
               <?php if ($list['precedence'] != first_precedence('featured_item_tb')){?>
    				<a href="<?php echo site_url('torioadmin/featured_item/up_precedence_featured_item/'.$list['id']);?>">Down</a> 
				<?php }?>
                </td>
    		</tr>
    		<?php $no++; } else if(!$featured_item){ ?> 
            <tr>
                <td colspan="7"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>