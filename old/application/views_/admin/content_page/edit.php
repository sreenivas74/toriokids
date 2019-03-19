<div id="content">
	<h2>Content Page &raquo; Edit</h2>
	<form method="post" id="edit_content_page_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/content_page/do_edit').'/'.$id;?>">
    <?php if($detail){?>
    <div id="form">
    	<dl>
            <dd>Name</dd>
            <dt><input class="txtField" type="text" name="name" value="<?php echo $detail['name']?>"/></dt>
        </dl>
        <dl>
            <dd>Content</dd>
            <dt><textarea class="txtField" type="text" name="content" id="content_redactor"><?php echo $detail['content']?></textarea></dt>
        </dl>
    </div>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/content_page');?>';" /></dt>
    </dl>
    <?php }?>
    </form>
</div>