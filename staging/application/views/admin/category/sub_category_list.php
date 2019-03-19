<div id="content">
    <h2>Sub Category &raquo; <?php echo find('name', $this->uri->segment(4), 'category_tb')?></h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/category/add_sub').'/'.$this->uri->segment(4);?>"><span>Add Sub</span></a> <a class="defBtn" href="<?php echo site_url('torioadmin/category');?>"><span>Back</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="10%">Action</th>
                <th width="35%">Name</th>
                <th width="25%">Alias</th>
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
                <a href="<?php echo site_url('torioadmin/category/change_active_sub_category').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/category/edit_sub').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><?php echo $list['alias'];?></td>
                <td><?php if($list['banner_image']!=""){?>
                    <img width="200" src="<?php echo base_url();?>userdata/sub_category_banner/<?php echo $list['banner_image'];?>" /><?php }?>
            	</td>
    			<td valign="top">
    			<?php if ($list['precedence'] != first_precedence_2('sub_category_tb', 'category_id', $list['category_id'])){?>
    				<a href="<?php echo site_url('torioadmin/category/up_precedence_sub_category/'.$list['id'].'/'.$list['category_id']);?>">Up</a> 
				<?php }
					if($list['precedence']!=first_precedence_2('sub_category_tb', 'category_id', $list['category_id']) and  $list['precedence'] != last_precedence_2('sub_category_tb', 'category_id', $list['category_id'])) echo " | ";
    				if ($list['precedence'] != last_precedence_2('sub_category_tb', 'category_id', $list['category_id'])){?>
    				<a href="<?php echo site_url('torioadmin/category/down_precedence_sub_category/'.$list['id'].'/'.$list['category_id']);?>">Down</a>
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