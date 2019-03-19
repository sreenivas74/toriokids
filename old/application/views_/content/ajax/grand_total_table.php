<?php $discount=0;?>
	 <?php if($voucher_list){?>
        <tr>
            <td width="200">Total Price</td>
            <td width="50">IDR.</td>
            <td width="150" style="text-align:right;"><div class="totalPrice"><?php echo money2($total_price);?></div></td>
        </tr>
        <?php }?>
         <?php if ($voucher_list) foreach($voucher_list as $list5){?>
        <tr>
            <td width="200" style="color:#C1272D;">Discount</td>                    
            <td width="50" style="color:#C1272D;">IDR.</td>
            <?php if($total_price<$list5['maximum_sub']){ 
            $totalbelanja=$total_price?>
            <?php } else { ?>
            <?php $totalbelanja=$list5['maximum_sub'] ?>
            <?php } ?>
            <td width="150" style="text-align:right;color:#C1272D;">
                <div class="totalPrice">
                <?php if($list5['type_voc']==1){
                $discount=($totalbelanja*$list5['value'])/100; echo money2($discount);?>
                <?php }else{ ?>
                <?php
                $discount=$list5['value']; echo money2($discount);?>	
                <?php } ?>
                </div>
            </td>
        </tr>
<?php } ?>
<?php if($get_discount_stamps){?>
        <tr>
            <td width="200">Total Price</td>
            <td width="50">IDR.</td>
            <td width="150" style="text-align:right;"><div class="totalPrice"><?php echo money2($total_price);?></div></td>
        </tr>
        <tr>
            <td width="200" style="color:#C1272D;">Discount</td>                    
            <td width="50" style="color:#C1272D;">IDR.</td>
            <?php $discount=$get_discount_stamps['total']?>
            <td width="150" style="text-align:right;color:#C1272D;"><div class="totalPrice"><?php echo money2($discount) ?> </div>
        </tr>
  <?php } ?>
        <tr>
            <td width="200">Grand Total</td>
            <td width="50">IDR.</td>
            <td width="150" style="text-align:right;"><div class="totalPrice"><?php echo money2($total_price-$discount);?></div></td>
        </tr>
