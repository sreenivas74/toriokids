<div id="content">
	<h2>Secondary Navigation &raquo; Add</h2>
	<form method="post" id="add_secondary_menu_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/secondary_menu/do_add');?>">
    <?php /* ?>
    <dl>
        <dd>Category</dd>
        <dt>
        	<select class="txtField" name="category">
                <option value="" label="-- Select Category --">-- Select Category --</option>
                <option value="1">Help</option>
                <option value="2">About Torio Kids</option>
                <?php /*?><option value="3">Connect With Us</option><?php ?>
            </select>
        </dt>
    </dl>
    <?php */ ?>
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField" type="text" name="name"/></dt>
    </dl>
    <dl>
    	<dd>External Link</dd>
        <dd><span class="descriptionTxt">Example: https://www.google.co.id/</span></dd>
        <dt><input class="txtField" type="text" name="link"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/secondary_menu');?>';" /></dt>
    </dl>
    </form>
</div>