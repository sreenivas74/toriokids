<div id="content">
	<h2>Frequently Asked Questions &raquo; Add Category</h2>
	<form method="post" name="add_faq_category_form" id="add_faq_category_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/content_page/do_add_faq_category');?>">
    <div id="form">
    	<dl>
            <dd>Name</dd>
            <dt><input class="txtField validate[required]" type="text" name="name" id="name"/></dt>
        </dl>
    </div>
    <dl>
        <dd></dd>
       <dt><input type="submit" id="add_faq_category_submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/content_page/view_faq_category');?>';" /></dt>
    </dl>
    </form>
</div>