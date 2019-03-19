<div id="content">
	<h2>Small Footer Banner &raquo; Add</h2>
	<form method="post" id="add_home_banner_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/small_footer_banner/do_add').'/'.$type;?>">
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField validate[required]" type="text" name="name" id="name"/></dt>
    </dl>
    <dl>
    	<dd>Link</dd>
        <dd><span class="descriptionTxt">Example: https://www.google.co.id/</span></dd>
        <dt><input class="txtField" type="text" name="link"/></dt>
    </dl>
    <dl>
        <dd>Image(optimize: 940x120 px)</dd>
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" id="add_home_banner_submit" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/small_footer_banner/view_banner_list').'/'.$type;?>';"/></dt>
    </dl>
    </form>
</div>