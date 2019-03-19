<script>
	$("select.recipient").uniform();
</script>
<select class="recipient" name="select_city" id="city" onchange="load_shipping_method(this.value);">
	<option value="">Select City</option>
	<?php if($city)foreach($city as $list3){?>
   <option value="<?php echo $list3['id'];?>" act="<?php echo $list3['name']?>" <?php if($city_id==$list3['id'])echo "selected=\"selected\"";?>><?php echo $list3['name']?></option>
    <?php }?>
</select>
<span class="notifCity">Please <a href="<?php echo site_url('contact_us');?>" target="_blank">contact us</a> if your city isn't listed here</span>