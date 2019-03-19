<script>
$(document).ready(function(){
  $("#btnAdd").click(function(){
	 var str='<div class="template"><dl><dd>Size</dd><dt><input class="txtField" type="text" name="size[]"/></dt></dl><dl><dd></dd><dt><a href="#" onclick="remove_template(this);">Remove</a></dt></div>';
    $("#form").append(str);
	return false;
  });
  
});
function remove_template(obj){
	$(obj).parents('div.template').remove();return false;
}
</script>
<div id="content">
	<h2>Template Name &raquo; Add</h2>
    <div><a href="#" id="btnAdd" class="defBtn">Add More Template Size</a></div>
	<form method="post" id="add_template_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/template/do_add_template');?>">
    <div id="form">
        <dl>
            <dd>Name</dd>
            <dt><input class="txtField" type="text" name="name"/></dt>
        </dl>
        <dl>
            <dd>Size</dd>
            <dt><input class="txtField" type="text" name="size[]"/></dt>
        </dl>
    </div>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/template');?>';" /></dt>
    </dl>
    </form>
</div>