<div id="content">
	<h2>Sub Category &raquo; Add</h2>
	<form method="post" id="add_sub_category_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/category/do_add_sub').'/'.$category_id;?>">
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField" type="text" name="name"/></dt>
    </dl>
    <dl>
        <dd>Banner Image (optimize:700 x 240 px)</dd>
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/category/view_sub_category_list').'/'.$category_id;?>';" /></dt>
    </dl>
    </form>
</div>