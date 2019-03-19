<div id="content">
	<h2>Content &raquo; Add</h2>
	<form method="post" name="add_content_page_form" id="add_content_page_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/content_page/do_add');?>">
    <div id="form">
    	<dl>
            <dd>Name</dd>
            <dt><input class="txtField" type="text" name="name"/></dt>
        </dl>
        <dl>
            <dd>Content</dd>
            <dt><textarea class="txtField" type="text" name="content" id="content_redactor"></textarea></dt>
        </dl>
    </div>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/content_page');?>';" /></dt>
    </dl>
    </form>
</div>