<div id="content">
	<h2>Template Size &raquo; Add</h2>
    <div><a href="#" id="btnAdd" class="defBtn">Add More Template Size</a></div>
	<form method="post" id="add_template_size_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/template/do_add_template_size').'/'.$name_id;?>">
    <div id="form">
        <dl>
            <dd>Size</dd>
            <dt><input class="txtField" type="text" name="size"/></dt>
        </dl>
    </div>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/template/view_template_size').'/'.$name_id;?>';" /></dt>
    </dl>
    </form>
</div>