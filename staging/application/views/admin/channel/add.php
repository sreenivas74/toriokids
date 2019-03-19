<div id="content">
	<h2>E-Channel &raquo; Add</h2>
	<form method="post" id="add_channel_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/channel/do_add');?>">
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField validate[required]" type="text" name="name" id="title"/></dt>
    </dl>
    <dl>
        <dd>Link</dd>
        <dt><input class="txtField validate[required]" type="text" name="link" id="title"/></dt>
    </dl>
    <dl>
        <dd>Image</dd>
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" id="add_channel_submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/channel');?>';" /></dt>
    </dl>
    </form>
</div>