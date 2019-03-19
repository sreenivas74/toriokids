<script>
function countdown_validator(){
	var name = $('#name').val();
	var image = $('#image').val();
	var start_date = $('#start').val();
	var end_date = $('#end').val();
	
	if(!name){ alert("Name is required"); return false; }
	//if(!image){ alert("Image is required"); return false; }
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
    <h2>Countdown &raquo; <?php echo find('name',$detail['id'],'countdown_tb'); ?> &raquo; Edit</h2>
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/countdown/do_edit_countdown');?>" onsubmit="return countdown_validator();">
    <input type="hidden" name="countdown_id" value="<?php echo $detail['id'] ?>" />
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField" type="text" name="name" id="name" value="<?php echo $detail['name'] ?>" /></dt>
    </dl>
    <dl>
    	<dd>Previous Image</dd>
        <dt><img src="<?php echo base_url() ?>userdata/countdown/<?php echo $detail['image'] ?>" width="20%" /></dt>
    </dl>
    <dl>
        <dd>Banner Image</dd>
        <dt><input class="txtField" type="file" name="image" id="image" /></dt>
    </dl>
    
    <dl>
    	<dd>Previous Image Mobile</dd>
        <dt><img src="<?php echo base_url() ?>userdata/countdown/mobile/<?php echo $detail['image_mobile'] ?>" width="20%" /></dt>
    </dl>
    <dl>
        <dd>Banner Image Mobile</dd>
        <dt><input class="txtField" type="file" name="image_mobile" id="image_mobile" /></dt>
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
        <dt><input type="submit" class="defBtn" value="Submit" />  <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/countdown');?>';" /></dt>
    </dl>
    </form>
</div>