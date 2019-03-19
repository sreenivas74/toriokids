<div id="content">
	<h2>Template Name &raquo; Edit</h2>
	<form method="post" id="edit_template_name_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/template/do_edit_template_name').'/'.$id;?>">
    <?php if($detail){ ?>
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField" type="text" name="name" value="<?php echo $detail['name'];?>"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/template');?>';" /></dt>
    </dl>
    <?php } ?>
    </form>
</div>