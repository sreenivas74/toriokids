<div id="content">
	<h2>JNE &raquo; Edit Province</h2>
	<form method="post" name="edit_province_form" id="edit_province_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/jne/do_edit_province').'/'.$province_id;?>">
        <dl>
            <dd>Province</dd>
            <dt><input class="txtField validate[required]" type="text" name="province" id="province" value="<?php echo $province['name']?>"/></dt>
        </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" id="edit_province_submit" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/jne/view_province');?>';" /></dt>
    </dl>
    </form>
</div>