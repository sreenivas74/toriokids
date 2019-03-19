<div id="content">
    <h2>Template Size &raquo; <?php echo find('name', $this->uri->segment(4), 'template_name_tb')?></h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/template/add_template_size').'/'.$this->uri->segment(4);?>"><span>Add Template Size</span></a> <a class="defBtn" href="<?php echo site_url('torioadmin/template');?>"><span>Back</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="15%">Action</th>
                <th width="75%">size</th>
                <th width="8%">Precedence</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($template)foreach($template as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/template/edit_template_size').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo $list['size'];?></td>
    			<td valign="top">
    			<?php if ($list['precedence'] != first_precedence('template_size_tb')){?>
    				<a href="<?php echo site_url('torioadmin/template/up_precedence_template_size/'.$list['id']);?>">Up</a> 
				<?php }
					if($list['precedence']!=first_precedence('template_size_tb') and  $list['precedence'] != last_precedence('template_size_tb')) echo " | ";
    				if ($list['precedence'] != last_precedence('template_size_tb')){?>
    				<a href="<?php echo site_url('torioadmin/template/down_precedence_template_size/'.$list['id']);?>">Down</a>
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