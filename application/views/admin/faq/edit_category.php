<div id="content">
	<h2>Frequently Asked Questions &raquo; Edit Category</h2>
	<form method="post" name="edit_faq_category_form" id="edit_faq_category_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/content_page/do_edit_faq_category').'/'.$id?>">
    <?php if($detail){ ?>
    <div id="form">
    	<dl>
            <dd>Name</dd>
            <dt><input class="txtField validate[required]" type="text" name="name" id="name" value="<?php echo $detail['name']?>"/></dt>
        </dl>
    </div>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" id="edit_faq_category_submit" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/content_page/view_faq_category');?>';" /></dt>
    </dl>
    <?php } ?>
    </form>
</div>