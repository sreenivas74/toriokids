<div id="content">
    <h2>SKU &raquo; <?php echo find('name', $this->uri->segment(4), 'product_tb')?></h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/product/add_sku').'/'.$this->uri->segment(4);?>"><span>Add SKU</span></a> <a class="defBtn" href="<?php echo site_url('torioadmin/product/add_batch_sku').'/'.$this->uri->segment(4);?>"><span>Add Batch SKU</span></a> <a class="defBtn" href="<?php echo site_url('torioadmin/product');?>"><span>Back</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="15%">Action</th>
                <th width="30%">Name</th>
                <th width="20%">Size</th>
                <th width="8%">Precedence</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($sku)foreach($sku as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/product/change_active_sku').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | <a href="<?php echo site_url('torioadmin/product/edit_sku').'/'.$list['id'];?>">Edit</a>
                </td>
    			<td valign="top"><?php echo $list['name'];?></td>
    			<td valign="top"><?php echo $list['size'];?></td>
                <td valign="top">
                <?php if ($list['precedence'] != first_precedence_2('sku_tb', 'product_id', $list['product_id'])){?>
    				<a href="<?php echo site_url('torioadmin/product/up_precedence_sku/'.$list['id'].'/'.$list['product_id']);?>">Up</a> 
				<?php }
					if($list['precedence']!=first_precedence_2('sku_tb', 'product_id', $list['product_id']) and  $list['precedence'] != last_precedence_2('sku_tb', 'product_id', $list['product_id'])) echo " | ";
    				if ($list['precedence'] != last_precedence_2('sku_tb', 'product_id', $list['product_id'])){?>
    				<a href="<?php echo site_url('torioadmin/product/down_precedence_sku/'.$list['id'].'/'.$list['product_id']);?>">Down</a>
    			<?php }?>
                </td>
    		</tr>
    		<?php $no++; } else if(!$sku){ ?> 
            <tr>
                <td colspan="5"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>