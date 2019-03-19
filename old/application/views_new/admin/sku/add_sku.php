<div id="content">
	<h2>SKU &raquo; Add</h2>
	<form method="post" id="add_sku_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/do_add_sku').'/'.$product_id;?>">
    <dl>
        <dd>Size</dd>
        <dt><input class="txtField" type="text" name="size"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/product/view_sku_list').'/'.$product_id;?>';" /></dt>
    </dl>
    </form>
</div>