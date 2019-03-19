<div id="content">
	<h2>Secondary Navigation &raquo; Edit</h2>
	<form method="post" id="edit_secondary_menu_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/secondary_menu/do_edit').'/'.$id?>">
    <?php if($detail){ ?>
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField" type="text" name="name" value="<?php echo $detail['name']?>"/></dt>
    </dl>
    <dl>
    	<dd>Link</dd>
        <dd><span class="descriptionTxt">Example: https://www.google.co.id/</span></dd>
        <dt><input class="txtField" type="text" name="link" value="<?php echo $detail['link']?>"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/secondary_menu');?>';" /></dt>
    </dl>
    <?php } ?>
    </form>
</div>