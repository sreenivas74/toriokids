<script>
	$("select.recipient").uniform();
</script>
<select class="recipient" name="shipping_method" id="ship_method">
   <?php if( $sm['min_purchase']>0 and $total_price <= $sm['min_purchase'] ){?>
   <?php if($sm['regular_fee']!=""){?><option value="<?php echo $sm['regular_fee'];?>">Regular (<?php if($sm['regular_fee']==0)echo "Free"." ".$sm['regular_etd']; else echo money($sm['regular_fee'])." ".$sm['regular_etd'];?>)</option><?php } ?>
   
 <?php }else{ ?>
                    	<?php if($sm['min_purchase']>0){?>
                    <option value="0">Regular (Free)</option>
                    	<?php }else{?><option value="<?php echo $sm['regular_fee'];?>">Regular (<?php if($sm['regular_fee']==0)echo "Free"." ".$sm['regular_etd']; else echo money($sm['regular_fee'])." ".$sm['regular_etd'];?>)</option>
                        <?php }?>
 <?php } ?>
   
   
   
   
   
     <?php if($sm['express_fee']!=""){?>
     
     <?php if($sm['express_fee']>0){?>
     <option value="<?php echo $sm['express_fee'];?>">Express (<?php if($sm['express_fee']==0)echo "Free"." ".$sm['express_etd']; else echo money($sm['express_fee'])." ".$sm['express_etd'];?>)</option><?php } ?>
     <?php } ?>
</select>