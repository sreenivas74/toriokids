<div id="content">
	<h2>SKU &raquo; Edit</h2>
	<form method="post" id="edit_sku_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/do_edit_sku').'/'.$id;?>">
    <?php if($detail){ ?>
    <dl>
        <dd>Size</dd>
        <dt><input class="txtField" type="text" name="size" value="<?php echo $detail['size']?>"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/product/view_sku_list').'/'.$detail['product_id'];?>';" /></dt>
    </dl>
    <?php } ?>
    </form>
</div>