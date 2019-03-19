<div class="shopCartContent">
    <h2>My Shopping Cart</h2>
    <div class="stepShopping">
        <div class="firstStepDone"><a href="<?php echo site_url('shopping_cart');?>">Review Your<br />Shopping Cart</a></div>
        <div class="otherStepDone"><a href="<?php echo site_url('shopping_cart/shipping');?>">Enter Shipping<br />Information</a></div>
        <div class="otherStepDone">Review &amp; Confirm<br />Your Order</div>
        <div class="otherStep">Payment</div>
        <div class="lastStep">You are all set!</div>
    </div>
</div>
<div class="topShopCartInfo">
    <div class="leftShopCartInfo">Item</div>
    <div class="rightShopCartInfo">
    	<div class="rightBox">Quantity</div>
        <div class="rightBox">Unit Price</div>
    	<div class="rightBox">Subtotal</div>
        <div class="rightBox">Discount</div>
        <div class="rightBlackBox">Total</div>
    </div>
</div>
<?php if($cart_list)foreach($cart_list as $list){?>  
<div class="<?php echo alternator('midShopCartInfo', 'midShopCartInfo2');?>">
    <div class="shopCartImgCon">
        <div class="shopCartImg">
        	<a href="<?php echo site_url('product/view_product_detail'.'/'.$list['alias'])?>" title="<?php echo $list['name'].' ('.$list['size'].')';?>"><img src="<?php echo base_url();?>userdata/product/thumbs/<?php echo find_2_prec2('image', 'product_id', $list['product_id'], 'product_image_tb');?>" /></a>
        </div>
    </div>
    <div class="shopCartDetail">
        <div class="productNameCart"><a href="<?php echo site_url('product/view_product_detail'.'/'.$list['alias'])?>" title="<?php echo $list['name'].' ('.$list['size'].')';?>"><?php echo $list['name'].' ('.$list['size'].')';?></a></div>
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
<input type="hidden" name="total" id="total" value="<?php echo $total_price;?>"/>
<input type="hidden" name="shipping_fee" id="shipping_fee" value="<?php echo $shipping_fee;?>"/>
<input type="hidden" name="shipping_cost" id="shipping_cost" value="<?php echo $shipping_cost;?>"/>
<input type="hidden" name="ceil_weight" id="ceil_weight" value="<?php echo ceil($total_actual_weight);?>"/>
<div class="topShopCartInfo"></div>
<div class="botShopCartInfo">
    <div class="botLeftCart">
    <h3>Shipping Detail</h3>
    <table>
      <tr>
        <td width="30%" class="field1">Recipent Name</td>
        <td width="70%" class="field2"><?php echo $address['recipient_name'];?></td>
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
      </tr>
      <?php /*?><tr>
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
    </div>
    <div class="botRightCartCon">

        <div class="botRightCart">
            <table>
                <tr>
                    <td width="200"><h3>Total</h3></td>
                    <td width="50">IDR.</td>
                    <td width="150"><div class="totalPrice"><?php echo money2($total_price);?></div></td>
                </tr>
                <?php if($coupoun_diskon){?>
                <tr>
                    <td width="200"><h3><span style="color:#9E005D;">Discount Voucher</span></h3><br />
					<span style="font-size:12px; color:#9E005D;"><br /> </span>
					</td>
                    <td width="50">IDR.</td>
                    <?php if($total_price<$coupoun_diskon['maximum_sub']){ 
					$totalbelanja=$total_price?>
                    <?php } else { ?>
                    <?php $totalbelanja=$coupoun_diskon['maximum_sub'] ?>
                    <?php } ?>
                    <td width="150"><div class="totalPrice"><span style="color:#9E005D;"><?php
					if($coupoun_diskon['type']==1){
					$discountvoucher=($totalbelanja*$coupoun_diskon['value'])/100; echo money2($discount);?>
        			<?php }else{ ?>
                   	<?php
					$discount=$coupoun_diskon['value']; echo money2($discount);?>	
					<?php } ?>
             		
                    </span></div></td>
                </tr>
                <?php } ?>
                <tr>
                    <td width="200"><h3>Shipping Cost</h3></td>
                    <td width="50">IDR.</td>
                    <td width="150"><div class="totalPrice"><?php echo ($shipping_cost==0)?"FREE":money2($shipping_cost);?></div></td>
                </tr>
                <tr>
                    <td width="200"><h3>Grand Total</h3></td>
                    <td width="50">IDR.</td>
                    <td width="150" style="text-align:right;"><div class="totalPrice"><?php echo money2($total_price + $shipping_cost - $discountvoucher);?></div></td>
                </tr>
          <tr>
          <div id="voucherinfo" ></div>
          </tr>
            </table>
        </div>
        <div class="botRightCart">
            <table>
                <tr>
                    <td><h3>Select Your Payment Method</h3></td>
                </tr>
                <tr>
                    <td width="150">
                        <label>
                            <input type="radio" name="paymentMethod" value="bank_transfer">
                            <img src="<?php echo base_url();?>templates/images/bank_transfer.png">
                        </label>
                    </td>
                </tr>
                <tr>
                    <td width="150">
                        <label>
                            <input type="radio" name="paymentMethod" value="credit_card">
                            <img src="<?php echo base_url();?>templates/images/credit_card.png">
                        </label>
                        <form id="doku_payment_request" name="doku_payment_request" action="<?php echo DOKU_URL;?>" method="post">
                            <input type="hidden" name="MALLID" id="MALLID" value="<?php echo MALLID?>"/>
                            <input type="hidden" name="CHAINMERCHANT" id="CHAINMERCHANT" value="NA"/>
                            <input type="hidden" name="AMOUNT" id="AMOUNT" />
                            <input type="hidden" name="PURCHASEAMOUNT" id="PURCHASEAMOUNT"/>
                            <input type="hidden" name="TRANSIDMERCHANT" id="TRANSIDMERCHANT" >
                            <input type="hidden" name="WORDS" id="WORDS"/>
                            <input type="hidden" name="REQUESTDATETIME" id="REQUESTDATETIME" value="<?php echo date('YmdHis');?>"/>
                            <input type="hidden" name="CURRENCY" id="CURRENCY" value="360"/>
                            <input type="hidden" name="PURCHASECURRENCY" id="PURCHASECURRENCY" value="360"/>
                            <input type="hidden" name="SESSIONID" id="SESSIONID"/>
                            <input type="hidden" name="NAME" id="NAME" value="<?php echo $user['full_name'];?>"/>
                            <input type="hidden" name="EMAIL" id="EMAIL" value="<?php echo $user['email'];?>"/>
                            <input type="hidden" name="PAYMENTCHANNEL" id="PAYMENTCHANNEL"/>
                            <input type="hidden" name="BASKET" id="BASKET"/>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td width="150"><a href="javascript:void(0);" class="sbt" onclick="payment_method();">Submit</a></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
function submit_form()
{
	var ship_cost = parseInt($("#shipping_cost").val());
	var ceil_weight = parseInt($("#ceil_weight").val());
	var shipping_fee = parseInt($("#shipping_fee").val());
	var temp = parseInt($("#total").val());
	var total = temp+ship_cost;
	$.ajax({
			type: "POST",
			url: '<?php echo site_url('ccpayment/doku_payment');?>',
			data: "user_id="+<?php echo $user['id'];?>+"&total="+total+"&ceil_weight="+ceil_weight+"&shipping_fee="+shipping_fee,
			beforeSend:function(){
				$("#").html('<img src="<?php echo base_url();?>templates/images/ajax-loader.gif">');
			},
			success: function(temp){
				data=temp.split('|',6);
				$("#TRANSIDMERCHANT").val(data[0]);
				$("#AMOUNT").val(data[1]);
				$("#PURCHASEAMOUNT").val(data[1]);
				$("#WORDS").val(data[2]);
				$("#SESSIONID").val(data[4]);
				$("#PAYMENTCHANNEL").val(data[3]);
				$("#BASKET").val(data[5]);
				$("#doku_payment_request").submit();
			}
		});
}
function payment_method()
{
	var selected  = $("input[type='radio'][name='paymentMethod']:checked");
	var selectedVal = "";
	if(selected.length > 0)selectedVal = selected.val();
	if(selectedVal=='bank_transfer'){
		window.location.assign("<?php echo site_url('shopping_cart/bank_payment_page/'.$list['id']);?>");
	}else if(selectedVal=='credit_card'){
		submit_form();
	}else {}
	
}

$(document).ready(function(){
	$("#submit_btn").click(function(){
		$("#voucher_form").submit();
		return false;
	});	
});	

</script>