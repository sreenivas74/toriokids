<div id="content">
	<h2>Featured Item &raquo; Add</h2>
	<form method="post" id="add_featured_item_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/featured_item/do_add');?>">
    <dl>
        <dd>Title</dd>
        <dt><input class="txtField validate[required]" type="text" name="title" id="title"/></dt>
    </dl>
    <dl>
    	<dd>Link</dd>
        <dd><span class="descriptionTxt">Example: https://www.google.co.id/</dd>
        <dt><input class="txtField" type="text" name="link"/></dt>
    </dl>
    <dl>
        <dd>Image (optimize: 300x183 px)</dd>
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd>Description</dd>
        <dt><textarea class="txtField" type="text" name="description"></textarea></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" id="add_featured_item_submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/featured_item');?>';" /></dt>
    </dl>
    </form>
</div>