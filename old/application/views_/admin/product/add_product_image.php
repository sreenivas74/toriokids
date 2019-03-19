<div id="content">
	<h2>Product Image &raquo; Add</h2>
	<form method="post" id="add_product_image_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/do_add_product_image').'/'.$product_id;?>">
    <dl>
    <dl>
        <dd>Image</dd>
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/product/view_product_image_list').'/'.$product_id;?>';" /></dt>
    </dl>
    </form>
</div>