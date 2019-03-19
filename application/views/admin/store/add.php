<div id="content">
	<h2>E-Store &raquo; Add</h2>
	<form method="post" id="add_store_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/store/do_add');?>">
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField validate[required]" type="text" name="name" id="title"/></dt>
    </dl>
    <dl>
        <dd>Image (optimize: 300x183 px)</dd>
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd>Link</dd>
        <dt><input class="txtField" type="text" name="link" id="title"/></dt>
    </dl>
    <dl>
        <dd>Address</dd>
        <dt><textarea class="txtField" type="text" name="address" id="content_redactor"></textarea></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" id="add_store_submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/store');?>';" /></dt>
    </dl>
    </form>
</div>