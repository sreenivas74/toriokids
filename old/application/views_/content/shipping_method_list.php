<script>
	$("select.recipient").uniform();
</script>
<select class="recipient" name="shipping_method" id="ship_method">
   <?php if($sm['regular_fee']!=""){?><option value="<?php echo $sm['regular_fee'];?>">Regular (<?php if($sm['regular_fee']==0)echo "Free"." ".$sm['regular_etd']; else echo money($sm['regular_fee'])." ".$sm['regular_etd'];?>)</option><?php } ?>
     <?php if($sm['express_fee']!=""){?><option value="<?php echo $sm['express_fee'];?>">Express (<?php if($sm['express_fee']==0)echo "Free"." ".$sm['express_etd']; else echo money($sm['express_fee'])." ".$sm['express_etd'];?>)</option><?php } ?>
</select>