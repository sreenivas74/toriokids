<script type="text/javascript">
$(document).ready(function(){
	$('.disc_date').datepicker({
			numberOfMonths: 1,
			showButtonPanel: true,
			yearRange: "-80:+80",
			changeYear: true,
			dateFormat: "yy-mm-dd",
			minDate: "-80y"
		});
});	
</script>
<div id="content">
	<h2>Discount &raquo; Add</h2>
	<form method="post" id="add_discount_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/discount/do_add');?>">
    <dl>
        <dd>Date Start</dd>
        <dt><input class="txtField validate[required] disc_date" type="text" name="date_start" readonly id="date_start"/></dt>
    </dl>
    <dl>
        <dd>Date End</dd>
        <dt><input class="txtField validate[required] disc_date" type="text" name="date_end" readonly id="date_end"/></dt>
    </dl>
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField validate[required]" type="text" name="name" id="name"/></dt>
    </dl>
    <dl>
        <dd>Percentage</dd>
        <dt><input class="txtField validate[required]" type="text" name="percentage" id="percentage"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" id="add_discount_submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/discount');?>';" /></dt>
    </dl>
    </form>
</div>