<?php if($detail)foreach($detail as $list){?>
	<p>
<label style="padding-right:15px;">
	<input style="margin:0 5px;" type="checkbox" class="checkBox"  value="<?php echo $list['size'];?>" name="template_size[]"><?php echo $list['size'];?> <a href="javascript:void(0)" onclick="remove_template(this);">Delete</a>
</label>
 </p>
<?php }?>