<script>
	$("select.recipient").uniform();
</script>
<select class="recipient" name="select_city" id="city">
	<option value="">Select City</option>
	<?php if($city)foreach($city as $list2){?>
   <option value="<?php echo $list2['id'];?>" ><?php echo $list2['name']?></option>
    <?php }?>
</select><br/><span class="notifCity">Please <a href="<?php echo site_url('contact_us');?>" target="_blank">contact us</a> if your city isn't listed here</span>