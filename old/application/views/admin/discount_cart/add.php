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

function validation_discount(){
	var minimum = $('#minimum').val();
	var discount = $('#discount').val();
	var start = Date.parse($('#date_start').val());
	var end = Date.parse($('#date_end').val());
	
	if(start >= end){ alert('End date can not be earlier or same with start date'); return false; }
	
	if(isNaN(minimum)==true){ alert('Minimum purchase number only'); return false; }
	if(isNaN(discount)==true){ alert('Discount number only'); return false; }
}
</script>
<div id="content">
	<h2>Discount Cart &raquo; Add</h2>
	<form method="post" id="add_discount_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/discount_cart/do_add');?>" onsubmit="return validation_discount()">
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
        <dd>Minimum Purchase</dd>
        <dt><input class="txtField validate[required]" type="text" name="minimum" id="minimum"/></dt>
    </dl>
    <dl>
        <dd>Discount</dd>
        <dt><input class="txtField validate[required]" type="text" name="discount" id="discount"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/discount_cart');?>';" /></dt>
    </dl>
    </form>
</div>