<?php if($method){?>
	<option value="none">-- select city first --</option>
    <?php if($method['regular_fee']>0){ ?>
	<option value="<?php echo $method['regular_fee'] ?>" <?php if(isset($type)) if($type==0) echo "selected"; ?>><?php echo money($method['regular_fee'])." (".$method['regular_etd'].")" ?></option>
    <?php }?>
    
    <?php if($method['express_fee']>0){?>
    <option value="<?php echo $method['express_fee'] ?>" <?php if(isset($type)) if($type==1) echo "selected"; ?>><?php echo money($method['express_fee'])." (".$method['express_etd'].")" ?></option>
    <?php }?>
<?php }else{?>
	<option value="none">-- select city first --</option>
<?php }?>