<div id="content">
	<h2>JNE &raquo; Add Province</h2>
	<form method="post" name="add_province_form" id="add_province_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/jne/do_add_province');?>">
        <dl>
            <dd>Province</dd>
            <dt><input class="txtField validate[required]" type="text" name="province" id="province"/></dt>
        </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" id="add_province_submit" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/jne/view_province');?>';" /></dt>
    </dl>
    </form>
</div>