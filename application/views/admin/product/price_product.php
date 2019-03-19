<script>
$(function() {
	$( "#start" ).datetimepicker({
	});
	$( "#end" ).datetimepicker({
	});
});

function sale_validator(){
	var start_date = $('#start').val();
	var end_date = $('#end').val();
	if(!start_date){ alert("Start date is required"); $('#start').focus(); return false; }
	if(!end_date){ alert("End date is required");  $('#end').focus(); return false; }
	
	var start = Date.parse(start_date);
	var end = Date.parse(end_date);
	//console.log(start+' - '+end);
	
	if(start > end){
		alert("End date can't be earlier than start date");
		$('#end').focus();
		return false;
	}
}
</script>
<div id="content">
    <h2>Product &raquo; Price List</h2>
  <div id="submenu">
        <ul>
            <li><a class="defBtn" href="#" onClick="update_price();return false;"><span>Update</span></a> <a class="defBtn" href="#" onClick="$('#row_schedule').toggle();"><span>Set Schedule</span></a> <a class="defBtn" href="<?php echo site_url('torioadmin/product/download_csv_price');?>"><span>Download Template Discount</span></a> <a class="defBtn" href="javascript:void(0)" onclick="$('#upload_csv').toggle();"><span>Upload Template Discount</span></a> </li>
        </ul>
    </div>
    <div id="row_schedule" style="display:none">
    	<form method="post" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/do_add_sale_schedule');?>" onsubmit="return sale_validator();">
    	<dl>
            <dd>Start Date</dd>
            <dt><input class="txtField" type="text" name="start" id="start" value="<?php if($schedule) echo $schedule['start_time'] ?>" readonly /></dt>
        </dl>
        <dl>
            <dd>End Date</dd>
            <dt><input class="txtField" type="text" name="end" id="end" value="<?php if($schedule) echo $schedule['end_time'] ?>" readonly /></dt>
        </dl>
        <dl>
        	<dd></dd>
            <dt><input type="submit" value="Submit" /></dt>
        </dl>
        </form>
    </div>
    
    <div id="upload_csv" style="display:none">
    	<form method="post" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/upload_csv_price');?>">
        <span style="color:red">*Don't forget to <u>backup database</u>.
        <br />*Don't forget save csv to <u>Windows Comma Separated</u>.</span>
    	<dl>
            <dd>File (CSV)</dd>
            <dt><input type="file" name="attachment" id="attachment" required /></dt>
        </dl>
        <dl>
        	<dd></dd>
            <dt><input type="submit" value="Submit" /></dt>
        </dl>
        </form>
    </div>
    <?php if($schedule){ ?>
    <div>
    	<span><?php echo "Start: ".date('d F Y, H:i:s', strtotime($schedule['start_time'])) ?></span><br />
        <span><?php echo "End: ".date('d F Y, H:i:s', strtotime($schedule['end_time'])) ?></span>
    </div>
    <?php }?>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                
                <th width="20%">Name</th>
           
                <th width="10%">MSRP</th>
                <th width="10%">Discount</th>
                <th width="10%">Selling Price</th>
                <th width="10%">Sale</th>
       
            </tr>
        </thead>
        <tbody>
        <form method="post" id="submit_product_price" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/submit_product_price');?>">
        <?php $no=1; 
			  if($product_list)foreach($product_list as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><input type="text" class="txtField msrp_price" name="msrp[]" value="<?php echo $list['msrp'];?>"></td>
               
    			<td valign="top"><input type="text" class="txtField discount_price" name="discount[]" value="<?php echo $list['discount']?>"  /></td>
    			<td valign="top">
                <input type="hidden" name="id[]" value="<?php echo $list['id']?>">
				<input type="text" class="txtField selling_price" name="price[]" value="<?php echo $list['price'];?>"></td>
    			<td valign="top"><input type="checkbox" name="sale<?php echo $list['id']?>" value="1" <?php if($list['sale_product']==1)echo "checked"?> /></td>
    		</tr>
    		<?php $no++; } else if(!$product_list){ ?> 
            <tr>
                <td colspan="10"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
           </form>
        </tbody>
    </table>
     <div id="submenu">
        <ul>
            <li><a class="defBtn" href="#" onClick="update_price();return false;"><span>Update</span></a></li>
       </ul>
  </div>
</div>
<script>
function update_price(){
	 if(confirm('Confirm?')){
		$('#submit_product_price').submit();
	 }
}


$(document).ready(function(e) {
    $(".msrp_price").keyup(function(){
		discount=$(this).parents('tr').find('.discount_price').val();
		discount=parseInt(discount);
		
		msrp_price=$(this).val();
		msrp_price=parseInt(msrp_price);
		
		selling_price=(msrp_price*(100-discount)/100);
		
		$(this).parents('tr').find('.selling_price').val(selling_price);
	});
    $(".discount_price").keyup(function(){
		discount=$(this).val();
		discount=parseInt(discount);
		
		msrp_price=$(this).parents('tr').find('.msrp_price').val();
		msrp_price=parseInt(msrp_price);
		
		selling_price=(msrp_price*(100-discount)/100);
		
		if(!isNaN(selling_price))
		$(this).parents('tr').find('.selling_price').val(selling_price);
		else 
		$(this).parents('tr').find('.selling_price').val(0);
		
		if($(this).val()>0){
			$(this).parents('tr').find('input[type=checkbox]').attr('checked','checked');
		}
		else{
			$(this).parents('tr').find('input[type=checkbox]').removeAttr('checked');
		}
	});
    $(".selling_price").keyup(function(){
		
		selling_price=$(this).val();
		selling_price=parseInt(selling_price);
		
		msrp_price=$(this).parents('tr').find('.msrp_price').val();
		msrp_price=parseInt(msrp_price);
		
		discount=((msrp_price-selling_price)/msrp_price)*100;
		discount=discount.toFixed(2);
		
		if(!isNaN(discount))
		$(this).parents('tr').find('.discount_price').val(discount);
		else 
		$(this).parents('tr').find('.discount_price').val(0);
	});
});
</script>