<div id="content">
	<h2>Frequently Asked Questions &raquo; Edit</h2>
	<form method="post" name="edit_faq_form" id="edit_faq_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/content_page/do_edit_faq').'/'.$id?>">
    <?php if($detail){ ?>
    <div id="form">
    	<dl>
            <dd>Category</dd>
            <dt><select class="txtField validate[required]" name="faq_category_id" id="faq_category_id">
                <option label="-- Category --">-- Category --</option>
				<?php if($category)foreach($category as $cat){ ?>
                <option value="<?php echo $cat['id']?>" <?php if($detail['faq_category_id']==$cat['id'])echo "selected=\"selected\"";?>><?php echo $cat['name']?></option>
				<?php } ?>
            </select></dt>
        </dl>
    	<dl>
            <dd>Question</dd>
            <dt><input class="txtField validate[required]" type="text" name="question" id="question" value="<?php echo $detail['question']?>"/></dt>
        </dl>
        <dl>
            <dd>Answer</dd>
            <dt><textarea class="txtField" type="text" name="answer" id="content_redactor"><?php echo $detail['answer']?></textarea></dt>
        </dl>
    </div>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" id="edit_faq_submit" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/content_page/view_faq');?>';" /></dt>
    </dl>
    <?php } ?>
    </form>
</div>