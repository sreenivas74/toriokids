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
	if(isNaN(minimum)==true){ alert('Minimum purchase number only'); return false; }
	if(isNaN(discount)==true){ alert('Discount number only'); return false; }
}
</script>
<div id="content">
	<h2>Discount Cart &raquo; Edit</h2>
	<form method="post" id="edit_discount_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/discount_cart/do_edit');?>">
    <input type="hidden" name="disc_cart_id" value="<?php echo $detail['id']?>"/>
    <dl>
        <dd>Date Start</dd>
        <dt><input class="txtField validate[required] disc_date" type="text" name="date_start" id="date_start" readonly value="<?php echo $detail['date_start']?>"/></dt>
    </dl>
    <dl>
        <dd>Date End</dd>
        <dt><input class="txtField validate[required] disc_date" type="text" name="date_end" id="date_end" readonly value="<?php echo $detail['date_end']?>"/></dt>
    </dl>
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField validate[required]" type="text" name="name" id="name" value="<?php echo $detail['name']?>"/></dt>
    </dl>
    <dl>
        <dd>Minimum Purchase</dd>
        <dt><input class="txtField validate[required]" type="text" name="minimum" id="minimum" value="<?php echo $detail['minimum_purchase']?>"/></dt>
    </dl>
    <dl>
        <dd>Discount</dd>
        <dt><input class="txtField validate[required]" type="text" name="discount" id="discount" value="<?php echo $detail['discount']?>"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/discount_cart');?>';" /></dt>
    </dl>
    </form>
</div>