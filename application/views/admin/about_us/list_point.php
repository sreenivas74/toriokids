<div id="content">
    <h2>About Us &raquo; Point</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/about_us/add_point');?>"><span>Add</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="10%">Action</th>
                <th width="20%">Title</th>
                <th width="20%">Image</th>
                <th width="20%">Description</th>
                <th width="8%" colspan="2">Precedence</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($about_us)foreach($about_us as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/about_us/change_active_about_us_point').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/about_us/edit_point').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo $list['title'];?></td>
                <td><?php if($list['image']!=""){?>
                    <img width="200" src="<?php echo base_url();?>userdata/about_us/<?php echo $list['image'];?>" /><?php }?>
            	</td>
                <td valign="top"><?php echo $list['description'];?></td>
    			<td valign="top">
    			 <?php if ($list['precedence'] != last_precedence('about_us_point_tb')){?>
                	<a href="<?php echo site_url('torioadmin/about_us/down_precedence_about_us_point/'.$list['id']);?>">Up</a>
                <?php }?>
                </td>
                <td valign="top">
               <?php if ($list['precedence'] != first_precedence('about_us_point_tb')){?>
    				<a href="<?php echo site_url('torioadmin/about_us/up_precedence_about_us_point/'.$list['id']);?>">Down</a> 
				<?php }?>
                </td>
    		</tr>
    		<?php $no++; } else if(!$about_us){ ?> 
            <tr>
                <td colspan="7"><?php echo "No about us Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>