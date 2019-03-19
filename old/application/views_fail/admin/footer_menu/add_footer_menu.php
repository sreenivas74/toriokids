<div id="content">
	<h2>Footer Menu &raquo; Add</h2>
	<form method="post" id="add_footer_menu_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/footer_menu/do_add');?>">
    <input class="txtField" type="hidden" name="cat" value="<?php echo $cat;?>"/>
    <dl>
        <dd>Category</dd>
        <dt>
        	<select class="txtField" name="category">
                <option value="" label="-- Select Category --">-- Select Category --</option>
                <option value="1">Help</option>
                <option value="2">About Torio Kids</option>
                <?php /*?><option value="3">Connect With Us</option><?php */?>
            </select>
        </dt>
    </dl>
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
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/footer_menu/index/'.$cat);?>';" /></dt>
    </dl>
    </form>
</div>