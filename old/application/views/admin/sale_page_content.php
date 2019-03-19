<div id="content">
	<h2>Sale Page Content &raquo; Edit</h2>
	<form method="post" id="edit_content_page_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/sale_page/do_edit');?>">
    <?php if($detail){?>
    <div id="form">
        <dl>
            <dd>Content</dd>
            <dt><textarea class="txtField" type="text" name="content" id="content_redactor"><?php echo $detail['content']?></textarea></dt>
        </dl>
          <dl>
            <dd>Active</dd>
            <dt><label><input class="radioBtn" type="radio" name="active" id="active" value="1"  <?php if($detail['active']==1)echo "checked=\"checked\""?> /> Yes </label></br>
                <label><input class="radioBtn" type="radio" name="active" id="active" value="0" <?php if($detail['active']==0)echo "checked=\"checked\""?> /> No </label>
            </dt>
        </dl>
    </div>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/></dt>
    </dl>
    <?php }?>
    </form>
</div>