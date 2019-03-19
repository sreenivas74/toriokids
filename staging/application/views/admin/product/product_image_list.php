<div id="content">
    <h2>Product Image &raquo; <?php echo find('name', $this->uri->segment(4), 'product_tb')?></h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/product/add_product_image').'/'.$this->uri->segment(4);?>"><span>Add Image</span></a> <a class="defBtn" href="<?php echo site_url('torioadmin/product');?>"><span>Back</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="15%">Action</th>
                <th width="20%">Image</th>
                <th width="8%">Precedence</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($product)foreach($product as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/product/change_active_product_image').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | <a href="<?php echo site_url('torioadmin/product/edit_product_image').'/'.$list['id'];?>">Edit</a>
                </td>
                <td><?php if($list['image']!=""){?>
                    <img width="200" src="<?php echo base_url();?>userdata/product/<?php echo $list['image'];?>" /><?php }?>
            	</td>
    			<td valign="top">
    			<?php if ($list['precedence'] != first_precedence_2('product_image_tb', 'product_id', $list['product_id'])){?>
    				<a href="<?php echo site_url('torioadmin/product/up_precedence_product_image/'.$list['id'].'/'.$list['product_id']);?>">Up</a> 
				<?php }
					if($list['precedence']!=first_precedence_2('product_image_tb', 'product_id', $list['product_id']) and  $list['precedence'] != last_precedence_2('product_image_tb', 'product_id', $list['product_id'])) echo " | ";
    				if ($list['precedence'] != last_precedence_2('product_image_tb', 'product_id', $list['product_id'])){?>
    				<a href="<?php echo site_url('torioadmin/product/down_precedence_product_image/'.$list['id'].'/'.$list['product_id']);?>">Down</a>
    			<?php }?>
                </td>
    		</tr>
    		<?php $no++; } else if(!$product){ ?> 
            <tr>
                <td colspan="6"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>