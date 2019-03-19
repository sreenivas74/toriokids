<script>
function setting_validator(){
	var value = document.getElementById('value');
		if(notEmpty(value,"Value is required")){
			return true;
		}
	
	return false;
}
function notEmpty(elem, helperMsg){
	if(elem.value.length == 0){
		alert(helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	return true;
}
</script>
<div id="content">
<h2>Setting &raquo; <?php echo $this->uri->segment(4);?> &raquo; Edit</h2>
<form method="post" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/setting/do_edit/');?>" onsubmit="return setting_validator();">
<input type="hidden" name="name" id="name" value="<?php echo $name;?>">
<dl>
    <dd>Value</dd>
    <dt><input class="txtField" type="text" name="value" id="value" value="<?php echo $detail['value'];?>"/></dt>
</dl>
<dl>
    <dd></dd>
    <dt><input type="submit" class="defBtn" value="Submit" />  <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/setting');?>';" /></dt>
</dl>
</form>
</div>