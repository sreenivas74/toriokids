<div id="content">
    <h2>Product &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/product/add_product');?>"><span>Add</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="18%">Action</th>
                <th width="10%">Image</th>
                <th width="10%">SKU Code</th>
                <th width="20%">Name</th>
                <th width="8%">Weight</th>
                <th width="10%">Selling Price<br />
[MSRP]</th>
                <th width="10%">New Product</th>
                <th width="10%">Sale Product</th>
                <th width="10%">Featured Product</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1;
			  if($product)foreach($product as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/product/change_active_product').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/product/edit_product').'/'.$list['id'];?>">Edit</a> | <a href="<?php echo site_url('torioadmin/product/view_product_image_list').'/'.$list['id'];?>">Image</a> | <a href="<?php echo site_url('torioadmin/product/view_sku_list').'/'.$list['id'];?>">SKU</a> | <a href="<?php echo site_url('torioadmin/product/view_related_product').'/'.$list['id'];?>">Recommended</a>
                </td>
                <td valign="top"><?php if(find_2_prec2('image', 'product_id', $list['id'], 'product_image_tb')!=""){?>
                    <img width="100" height="100" src="<?php echo base_url();?>userdata/product/<?php echo find_2_prec2('image', 'product_id', $list['id'], 'product_image_tb');?>" /><?php }?>
            	</td>
                <td><?php echo $list['sku_code']; ?></td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><?php echo $list['weight'];?> kg</td>
    			<td valign="top"><?php echo money($list['price']).'<br>
				['.money($list['msrp']).']';?></td>
                <td valign="top"><?php if($list['flag']==1)echo "Yes"; else echo "No"?> | <a href="<?php echo site_url('torioadmin/product/change_new_product/'.$list['id'].'/'.$list['flag'])?>">Change</a></td>
                <td valign="top">
                <?php if($list['sale_product']==1)echo "Yes"; else echo "No"?></td>
                <td valign="top">
                 <?php if($list['featured']==1)echo "Yes"; else echo "No"?> | <a href="<?php echo site_url('torioadmin/product/change_featured_product/'.$list['id'].'/'.$list['featured'])?>">Change </a></td>
    		</tr>
    		<?php $no++; } else if(!$product){ ?> 
            <tr>
                <td colspan="9"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>