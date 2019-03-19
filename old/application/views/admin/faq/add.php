<div id="content">
	<h2>Frequently Asked Questions &raquo; Add</h2>
	<form method="post" name="add_faq_form" id="add_faq_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/content_page/do_add_faq');?>">
    <div id="form">
    	<dl>
            <dd>Category</dd>
            <dt><select class="txtField validate[required]" name="faq_category_id" id="faq_category_id">
                <option label="-- Category --">-- Category --</option>
				<?php if($category)foreach($category as $cat){ ?>
                <option value="<?php echo $cat['id']?>"><?php echo $cat['name']?></option>
				<?php } ?>
            </select></dt>
        </dl>
    	<dl>
            <dd>Question</dd>
            <dt><input class="txtField validate[required]" type="text" name="question" id="question"/></dt>
        </dl>
        <dl>
            <dd>Answer</dd>
            <dt><textarea class="txtField" type="text" name="answer" id="content_redactor"></textarea></dt>
        </dl>
    </div>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit" id="add_faq_submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/content_page/view_faq');?>';" /></dt>
    </dl>
    </form>
</div>