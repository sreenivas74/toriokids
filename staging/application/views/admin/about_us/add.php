<div id="content">
	<h2>About Us &raquo; Add</h2>
	<form method="post" id="add_about_us_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/about_us/do_add');?>">
    <dl>
        <dd>Title</dd>
        <dt><input class="txtField validate[required]" type="text" name="title" id="title"/></dt>
    </dl>
    <dl>
        <dd>Image</dd>
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd>Description</dd>
        <dt><textarea class="txtField" type="text" name="description" id="content_redactor"></textarea></dt>
    </dl>
    <dl>
        <dd>Position</dd>
        <dt><input type="radio" name="position" value="1" /> Text left image right <br /> <input type="radio" name="position" value="2" /> Text right image left</dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" id="add_about_us_submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/about_us');?>';" /></dt>
    </dl>
    </form>
</div>