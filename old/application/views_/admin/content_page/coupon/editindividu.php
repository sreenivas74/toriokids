<div id="content">
	<h2>Coupons  &raquo; Edit &raquo; Individual</h2>
	<form method="post" id="add_coupoun" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/coupon/doeditindividu/'.$edit_list['id']);?>">
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField validate[required]" type="text" name="name" id="name" value="<?php echo $edit_list['name']?>"/></dt>
    </dl>
  	  <dl>
      <dd> 
      
      <?php if ($edit_list['image']!=""){?>
                     <img src="<?php echo base_url()?>userdata/voucher/<?php echo $edit_list['image']?>" width="100">
                    <?php }?>
      
      </dd>
           <dd>Image</dd>
            <dt><input type="file" name="image" class="txtField validate[required]" id="image"></dt>
        </dl>
    <dl>
        <dd>Code</dd>
        <dt><input class="txtField validate[required]" type="text" name="code" id="code" value="<?php echo $edit_list['code_voucher']?>"/></dt>
    </dl>
     <dl>
        <dd>Quantity</dd>
        <dt><input class="txtField validate[required]" type="text" name="qty" id="qty" value="<?php echo $edit_list['quantity']?>"/></dt>
    </dl>
       <dl>
        <dd>Date Start</dd>
        <dt><input class="txtField validate[required] disc_date" type="text" name="date_start" readonly id="date_start" value="<?php echo $edit_list['start_date']?>"/></dt>
    </dl>
    <dl>
        <dd>Date End</dd>
        <dt><input class="txtField validate[required] disc_date" type="text" name="date_end" readonly id="date_end" value="<?php echo $edit_list['end_date']?>"/></dt>
    </dl>
     <dl>
        <dd>Type Used</dd>
        <dt><select class="txtField validate[required]" name="type_used" id="type_used">
        <option value="">--- PLEASE SELECT BELOW ---</option>
          <option value="1" <?php if(1==$edit_list['type_used'])echo "selected=\"selected\"";?>>All</option>
          <option value="2" <?php if(2==$edit_list['type_used'])echo "selected=\"selected\"";?>>Specified Email</option>        
       </select></dt>
    </dl>
     <dl>
        <dd>Type</dd>
        <dt><select class="txtField validate[required]" name="type" id="type">
        <option value="">--- PLEASE SELECT BELOW ---</option>
          <option value="1" <?php if(1==$edit_list['type'])echo "selected=\"selected\"";?>>By Percentage</option>
          <option value="2" <?php if(2==$edit_list['type'])echo "selected=\"selected\"";?>>By Value</option>        
       </select></dt>
    </dl>
    <dl>
        <dd>Value</dd>
        <dt><input class="txtField validate[required]" type="text" name="value" id="value" value="<?php echo $edit_list['value']?>" /></dt>
    </dl>
     <dl>
        <dd>Minimum Subtotal</dd>
        <dt><input class="txtField validate[required]" type="text" name="min" id="min" value="<?php echo $edit_list['minimum_sub']?>"/></dt>
    </dl>
      <dl>
        <dd>Maximum Subtotal</dd>
        <dt><input class="txtField validate[required]" type="text" name="max" id="max" value="<?php echo $edit_list['maximum_sub']?>"/></dt>
    </dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" id="addindividu" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/coupon/');?>';"/></dt>
    </dl>
    </form>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('.disc_date').datepicker({
			numberOfMonths: 1,
			showButtonPanel: true,
			yearRange: "-80:+80",
			changeYear: true,
			dateFormat: "yy-mm-dd",
			minDate: "d"
		});
});	
</script