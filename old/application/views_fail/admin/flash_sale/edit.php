<script>
function sale_validator(){
	var name = $('#name').val();
	var percentage = $('#percentage').val();
	var start_date = $('#start').val();
	var end_date = $('#end').val();
	
	if(!name){ alert("Name is required"); return false; }
	if(!percentage){ alert("Percentage is required"); return false; }
	if(isNaN(percentage)==true){ alert("Percentage must numeric"); return false; }
	if(parseInt(percentage)<1 || parseInt(percentage)>100){ alert("Percentage range only from 1 - 100"); return false; }
	if(!start_date){ alert("Start date is required"); return false; }
	if(!end_date){ alert("End date is required"); return false; }
	
	var start = Date.parse(start_date);
	var end = Date.parse(end_date);
	//console.log(start+' - '+end);
	
	if(start > end){
		alert("End date can't be earlier than start date");
		return false;
	}
	
}

function checkValue(value, msg){
	if(value==''){
		alert(msg);
		return false;
	}
}

function notNumber(elem, helperMsg){
	if(isNaN(elem.value)==true){
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function notEmpty(elem, helperMsg){
	if(elem.value.length == 0){
		alert(helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	return true;
}
function not0(elem, elem2, helperMsg){
	if(elem <= 0){
		alert(helperMsg);
		elem2.focus(); // set the focus to this input
		return false;
	}
	return true;
}

$(function() {
	$( "#start" ).datetimepicker({
	});
	$( "#end" ).datetimepicker({
	});
});
</script>

<div id="content">
    <h2>Flash Sale &raquo; <?php echo find('name',$detail['id'],'flash_sale_tb'); ?> &raquo; Edit</h2>
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/sale/do_edit_flash_sale');?>" onsubmit="return sale_validator();">
    <input type="hidden" name="flash_sale_id" value="<?php echo $detail['id'] ?>" />
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField" type="text" name="name" id="name" value="<?php echo $detail['name'] ?>" /></dt>
    </dl>
    <dl>
        <dd>Percentage (1 - 100)</dd>
        <dt><input class="txtField" type="text" name="percentage" id="percentage" value="<?php echo $detail['percentage'] ?>" /></dt>
    </dl>
    <dl>
        <dd>Start Date</dd>
        <dt><input class="txtField" type="text" name="start" id="start" value="<?php echo date('m/d/Y H:i', strtotime($detail['start_time'])) ?>" readonly /></dt>
    </dl>
    <dl>
        <dd>End Date</dd>
        <dt><input class="txtField" type="text" name="end" id="end" value="<?php echo date('m/d/Y H:i', strtotime($detail['end_time'])) ?>" readonly /></dt>
    </dl>
    <dl>
        <dd></dd>
        <dt><input type="submit" class="defBtn" value="Submit" />  <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/sale/flash_sale');?>';" /></dt>
    </dl>
    </form>
</div>