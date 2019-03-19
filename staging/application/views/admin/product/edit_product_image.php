<div id="content">
	<h2>Product Image &raquo; Edit</h2>
	<form method="post" id="edit_product_image_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/do_edit_product_image').'/'.$id;?>">
    <?php if($detail){ ?>
    <dl>
        <dd>Image</dd>
        <dt>
		<?php if($detail['image']!=""){?>
        <img width="200" src="<?php echo base_url();?>/userdata/product/<?php echo $detail['image']; ?>" /> <br />
        <a onclick="return confirm('Are You sure to delete this image?');" href="<?php echo site_url('torioadmin/product/delete_product_image').'/'.$detail['id'];?>">Delete This</a>
        <?php }?>
    	</dt>  
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/product/view_product_image_list').'/'.$detail['product_id'];?>';" /></dt>
    </dl>
    <?php } ?>
    </form>
</div>