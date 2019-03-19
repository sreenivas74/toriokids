<?php if($city){?>
	<option value=0>-- select province first --</option>
	<?php foreach($city as $list){?>
	<option value=<?php echo $list['id'] ?>><?php echo $list['name'] ?></option>
    <?php }?>
<?php }else{?>
	<option value="none">-- select province first --</option>
<?php }?>