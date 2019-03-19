<div id="content">
    <h2>Content Page &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/content_page/add');?>"><span>Add</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
                <th width="2%">No</th>
                <th width="10%">Action</th>
                <th width="20%">Name</th>
                <th width="20%">Link</th>
                <th width="40%">Content</th>
                <th width="8%">Precedence</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($detail)foreach($detail as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/content_page/change_active_content_page').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/content_page/edit').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><?php echo site_url('content/'.$list['alias']);?></td>
                <td valign="top"><?php if(strlen($list['content'])<100) echo $list['content']; else echo substr(strip_tags($list['content']), 0 , 100)."...";?></td>
    			<td valign="top">
    			<?php if ($list['precedence'] != first_precedence('content_page_tb')){?>
    				<a href="<?php echo site_url('torioadmin/content_page/up_precedence_content_page/'.$list['id']);?>">Up</a> 
				<?php }
					if($list['precedence']!=first_precedence('content_page_tb') and  $list['precedence'] != last_precedence('content_page_tb')) echo " | ";
    				if ($list['precedence'] != last_precedence('content_page_tb')){?>
    				<a href="<?php echo site_url('torioadmin/content_page/down_precedence_content_page/'.$list['id']);?>">Down</a>
    			<?php }?>
                </td>
    		</tr>
    		<?php $no++; } else if(!$detail){ ?> 
            <tr>
                <td colspan="6"><?php echo "No Stored Data"; ?></td>
    		</tr>
            <?php } ?>
        </tbody>
    </table>
</div>