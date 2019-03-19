<script type="text/javascript">
function submit_form()
{
	<?php if($this->session->userdata('fb_id')!='' or $this->session->userdata('fb_id')!=0){?>
	fb_autopost();
	<?php }?>
	$(".payment").html('<img src="<?php echo base_url();?>templates/images/ajax-loader.gif">');
	$("#checkout_form").attr('action', '<?php echo site_url('shopping_cart/do_checkout');?>');
	$("#checkout_form").submit();
}
</script>
<div class="shopCartContent">
    <h2>My Shopping Cart</h2>
    <div class="stepShopping">
        <div class="firstStepDone"><a href="<?php echo site_url('shopping_cart');?>">Review Your<br />Shopping Cart</a></div>
        <div class="otherStepDone"><a href="<?php echo site_url('shopping_cart/shipping');?>">Enter Shipping<br />Information</a></div>
        <div class="otherStepDone"><a href="<?php echo site_url('shopping_cart/checkout_summary');?>">Review &amp; Confirm<br />Your Order</a></div>
        <div class="otherStepDone">Payment</div>
        <div class="lastStep">You are all set!</div>
    </div>
</div>
<div class="botShopCartInfo">
    <div class="botLeftCart">
        <h3>Bank Transfer Information</h3>
        <p>Langkah pembayaran dengan Manual Transfer BCA:</p>
        <ol>
            <li><p>Catatlah nomor order Anda yang akan tertera di halaman berikut.</p></li>
            <li><p>Transfer jumlah total ke account<br>
                <strong style="color:#9E005D;">
                a/n PT Mitra Prima Indah<br>
                2533022707<br>
                BCA Green Garden</strong><br>
                Masukan nomor order Anda di keterangan dan simpan struk/email sebagai bukti.<br>
                Pembayaran harus dilakukan paling lambat dua hari dari tanggal order, atau order otomatis dibatalkan.</p></li>
            <li><p>Konfirmasi pembayaran Anda di halaman konfirmasi.</p></li>
            <li><p>Setelah Anda mengkonfirmasi, maka kami baru memulai memproses order Anda. Update status order akan dikabarkan melalui email.</p></li>
        </ol>
    </div>
    <div class="botLeftCart">
        <h3>Shipping Detail</h3>
        <table>
            <tr>
                <td class="field1">Recipent Name</td>
                <td class="field2"><?php echo $address['recipient_name'];?></td>
            </tr>
            <tr>
                <td class="field1">Phone Number</td>
                <td class="field2"><?php echo $address['phone'];?></td>
            </tr>
            <tr>
                <td class="field1">Mobile</td>
                <td class="field2"><?php echo $address['mobile'];?></td>
            </tr>
            <tr class="field4">
                <td class="field3">Shipping Address</td>
                <td class="field2"><?php echo nl2br($address['shipping_address']);?></td>
            </tr><?php /*?>
            <tr>
                <td class="field1">Province</td>
                <td class="field2"><?php echo find('name', $address['province'], 'jne_province_tb');?></td>
            </tr><?php */?>
            <tr>
                <td class="field1">City</td>
                <td class="field2"><?php echo find('name', $address['city'], 'jne_city_tb');?></td>
            </tr>
            <tr>
                <td class="field1">Zip Code</td>
                <td class="field2"><?php echo $address['zipcode'];?></td>
            </tr>
        </table>
        <div class="finePrints">
            <p>By placing your order, you agree to TorioKids.com's <a target="_blank" href="<?php echo base_url()."content/privacy-policy-4"?>">privacy policy</a> &amp; <a target="_blank" href="<?php echo base_url()."content/terms-n-conditions-5"?>">conditions of use</a></p>
            <p>Within 2 days of delivery, you may return new, unopened merchandise in its original condition. Exceptions and restrictions apply. See TorioKids.com's <a href="<?php echo base_url()."content/terms-n-conditions-5"?>" target="_blank">returns policy</a></p>
        </div>
    </div>
</div>
<div class="topShopCartInfo">
    <div class="leftShopCartInfo2">Item</div>
    <div class="rightShopCartInfo2">
    	<div class="rightBox">Quantity</div>
        <div class="rightBox">Unit Price</div>
    	<div class="rightBox">Subtotal</div>
        <div class="rightBox">Discount</div>
        <div class="rightBlackBox">Total</div>
    </div>
</div>
<form id="checkout_form" name="checkout_form" action="#" method="post">
<input type="hidden" name="recipient_name" id="recipient_name" value="<?php echo $address['recipient_name']?>"/>
<input type="hidden" name="shipping_address" id="shipping_address" value="<?php echo $address['shipping_address'];?>"/>
<input type="hidden" name="phone" id="phone" value="<?php echo $address['phone'];?>"/>
<input type="hidden" name="city" id="city" value="<?php echo $address['city'];?>"/>
<input type="hidden" name="province" id="province" value="<?php echo $address['province'];?>"/>
<input type="hidden" name="zipcode" id="zipcode" value="<?php echo $address['zipcode'];?>"/>
<input type="hidden" name="mobile" id="mobile" value="<?php echo $address['mobile'];?>"/>
<input type="hidden" name="total" id="total" value="<?php echo $total_price;?>"/>
<?php if($cart_list)foreach($cart_list as $list){?>  
<div class="<?php echo alternator('midShopCartInfo', 'midShopCartInfo2');?>">
    <div class="shopCartDetail2">
        <div class="productNameCart3"><a href="<?php echo site_url('product/view_product_detail'.'/'.$list['alias'])?>" title="View Detail"><?php echo $list['name'];?></a></div>
        <div class="rightBox"><?php echo $list['quantity'];?></div>
        <div class="rightBox"><?php echo money($list['msrp']);?></div>
        <div class="rightBox"><?php echo money($list['quantity']*$list['msrp']);?></div>
        <div class="rightBox"><?php $diff=($list['quantity']*$list['msrp'])-$list['total'];if($diff<1)echo "-";else echo "(".money($diff).")"; ?></div>
        <div class="rightBox"><?php echo money($list['total']);?></div>
        <?php
			$total_actual_weight+=$list['actual_weight'];	
		?>
    </div>
</div>
<?php } 
	$shipping_cost=ceil($total_actual_weight)*$shipping_fee;
?>
<?php 
//hide dulu
/*if ($voucher_list) foreach($voucher_list as $list5){?>
 <div class="midShopCartInfo">
  <div class="shopCartDetail2">
        <div class="productNameCart3">&nbsp<?php echo $list5['voucher_name'];?></div>
        <div class="rightBox"><?php echo $list5['quantity'];?></div>
        <div class="rightBox">-</div>
        <div class="rightBox">-</div>
        <div class="rightBox"><?php echo money($list5['total']);?></div>
        <div class="rightBox">-</div>
 </div>
 </div>
<?php }*/?>
<input type="hidden" name="actual_weight" id="actual_weight" value="<?php echo $total_actual_weight;?>"/>
<input type="hidden" name="ceil_weight" id="ceil_weight" value="<?php echo ceil($total_actual_weight);?>"/>

<div class="topShopCartInfo"></div>
<div class="botShopCartInfo">
    <div class="botLeftCart"></div>
    <div class="botRightCartCon">
        <div class="botRightCart">
        	<table>
                <tr>
                    <td width="200">Total</td>
                    <td width="50">IDR.</td>
                    <td width="150" style="text-align:right"><div class="totalPrice"><?php echo money2($total_price);?></div></td>
                     <input type="hidden" name="total_price" id="total_price" value="<?php echo $total_price;?>"/>
                </tr>
                <?php if($disc){?>
                <?php /*?><tr>
                    <td width="200"><span style="color:#9E005D;">discount 20%</span><br />
					<span style="font-size:12px; color:#9E005D;">Soft opening promotion<br />valid until 30 September 2013</span>
					</td>
                    <td width="50">IDR.</td>
                    <td width="150"><div class="totalPrice"><span style="color:#9E005D;"><?php $discount=($total_price*$disc['percentage'])/100; echo money2($discount);?></span></div>
                    </td>
                </tr><?php */?>
               
                   <input type="hidden" name="discount" id="discount" value="<?php if($disc)echo $discount;else echo 0;?>"/>
                <?php } ?>
             
                   <?php if ($voucher_list) foreach($voucher_list as $list5){?>
                <tr>
                   <td width="200" style="color:#C1272D;">Discount</td>
					</td>
                    <td width="50" style="color:#C1272D;">IDR.</td>
                    <?php if($total_price<$list5['maximum_sub']){ 
					$totalbelanja=$total_price?>
                    <?php } else { ?>
                    <?php $totalbelanja=$list5['maximum_sub'] ?>
                    <?php } ?>
                    <td width="150" style="color:#C1272D;text-align:right;"><div class="totalPrice"><?php
					if($list5['type_voc']==1){
					$discount=($totalbelanja*$list5['value'])/100; echo money2($discount);?>
        			<?php }else{ ?>
                   	<?php
					$discount=$list5['value']; echo money2($discount);?>	
					<?php } ?>
                    <input type="hidden" name="voucher_id" id="voucher_id" value="<?php if($voucher_list)echo $list5['voucher_id'];else echo 0;?>"/>					
             	   	<input type="hidden" name="discount" id="discount" value="<?php if($voucher_list)echo $discount;else echo 0;?>"/>	
                    </div></td>
                </tr>
                <?php } ?>
                <?php $stapms_list="";if ($stamps_list){?>
                <tr>
                    <td width="200" style="color:#C1272D;">Discount Stamps					</td>
                    <td width="50" style="color:#C1272D;">IDR.</td>
   
                    <td width="150" style="text-align:right;color:#C1272D;"><div class="totalPrice">
                   <?php $discount=$stamps_list['total']?>
                   <?php echo money2($discount)?>
                   <input type="hidden" name="discount" id="discount" value="<?php if($stamps_list)echo $discount;else echo 0;?>"/>
             		
                   </div></td>
                </tr>
                <?php } ?>
                <tr>
                    <td width="200">Shipping Cost</td>
                    <td width="50">IDR.</td>
                    <td width="150" style="text-align:right"><div class="totalPrice"><?php echo ($shipping_cost==0)?"FREE":money2($shipping_cost);?></div></td>
                    <input type="hidden" name="shipping_cost" id="shipping_cost" value="<?php echo $shipping_cost;?>"/>
                </tr>
                <tr>
                    <td width="200">Grand Total</td>
                    <td width="50">IDR.</td>
                    <td width="150" style="text-align:right;"><div class="totalPrice"><?php echo money2($total_price + $shipping_cost - $discount);?></div>
                      <input type="hidden" name="grand_total" id="grand_total" value="<?php echo $total_price+$shipping_cost-$discount;?>"/>
                    </td>
                </tr>
            </table>
        </div>
        <div class="payment">
            <a href="javascript:void(0);" onclick="submit_form();" class="bankTrans"></a>
            <a href="<?php echo site_url('shopping_cart/checkout_summary');?>" class="cancel">Cancel, Back to Review Page</a>
        </div>
    </div>
</div>
</form>