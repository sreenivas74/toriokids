<div id="content">
	<h2>E-store logo &raquo; Add</h2>
	<form method="post" id="add_store_logo_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/store_logo/do_add');?>">
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
        <dd></dd>
       <dt><input type="submit" id="add_store_logo_submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/store_logo');?>';" /></dt>
    </dl>
    </form>
</div>