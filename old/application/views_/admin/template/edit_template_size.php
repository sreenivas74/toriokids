<div id="content">
	<h2>Template Name &raquo; Edit</h2>
	<form method="post" id="edit_template_name_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/template/do_edit_template_size').'/'.$id;?>">
    <?php if($detail){ ?>
    <dl>
        <dd>Size</dd>
        <dt><input class="txtField" type="text" name="size" value="<?php echo $detail['size'];?>"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/template/view_template_size').'/'.$detail['template_name_id'];?>';" /></dt>
    </dl>
    <?php } ?>
    </form>
</div>