<script>
$(document).ready(function(){
	<?php if($check_sale>0){ ?>
		alert('Flash sale is over. Your cart now will be updated to original price.');
	<?php }?>
});


function show_stamps(){
	$("#stamps_tools").show();		
	$("#voucher_tools").hide();			
}
function show_voucher(){
	$("#stamps_tools").hide();		
	$("#voucher_tools").show();			
}
</script>

<?php if($clock_end && $flash_sale_type==2){ ?>
<div class="flashSale">
    <div class="desktopFlashSale">
        <a href="#">
            <img src="<?php echo base_url() ?>userdata/smallbanner/flash_sale.png" alt="flashSaleImg" />
            <div class="fsCd"></div>
        </a>
    </div>
    <div class="mobileFlashSale">
        <a href="#">
            <div class="fsCd"></div>
        </a>
        <span class="flashSaleTxt">Ayo belanja! Produk terbatas! Hanya 3 jam saja!</span>
    </div>
</div>
<?php }?>

<?php if($upcoming_time && $flash_sale_type==2){ ?>
<div class="beforeFlashSale">
    <div class="desktopFlashSale">
        <a href="#">
            <img src="<?php echo base_url() ?>userdata/smallbanner/before_flash_sale.png" alt="flashSaleImg" />
            <div class="beforeFsCd"></div>
        </a>
    </div>
    <div class="mobileFlashSale">
        <a href="#">
            <div class="beforeFsCd"></div>
        </a>
        <span class="flashSaleTxt">Tunggu tanggal 5 Februari 2015!</span>
    </div>
</div>
<?php }?>
<div class="shopCartContent">

    <h2>Payment</h2>
    <div class="stepShopping">
        <a href="<?php echo site_url('shopping_cart');?>"><div class="firstStepDone">Shopping Cart</div></a>
        <a href="<?php echo site_url('shopping_cart/shipping');?>"><div class="otherStepDone">Shipping</div></a>
        <div class="lastStepDone">Payment</div>
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
<?php if($cart_list)foreach($cart_list as $list){$diff=($list['quantity']*$list['msrp'])-$list['total'];?>  
<div class="<?php echo alternator('midShopCartInfo', 'midShopCartInfo2');?>">
    <div class="shopCartImgCon">
        <div class="shopCartImg">
        	<a href="<?php echo site_url('product/view_product_detail'.'/'.$list['alias'])?>" title="<?php echo $list['name'].' ('.$list['size'].')';?>"><img src="<?php echo base_url();?>userdata/product/med/<?php echo find_2_prec2('image', 'product_id', $list['product_id'], 'product_image_tb');?>" /></a>
        </div>
    </div>
    <div class="shopCartDetail">
        <div class="productNameCart"><a href="<?php echo site_url('product/view_product_detail'.'/'.$list['alias'])?>" title="<?php echo $list['name'].' ('.$list['size'].')';?>"><?php echo $list['name'].' ('.$list['size'].')';?></a>
        <span class="msgProduct" id="stock_<?php echo $list['id'] ?>" style="display:none"></span></div>
        <div class="rightBox"><?php echo $list['quantity'];?></div>
        <div class="rightBox del"><?php echo money($list['msrp']);?></div>
        <?php if($diff>0){?>
        <div class="rightBox linethrough"><?php echo money($list['quantity']*$list['msrp']);?></div>
        <?php }
		else{?>
        <div class="rightBox del"><?php echo money($list['quantity']*$list['msrp']);?></div>
		<?php }?>

        <div class="rightBox del"><?php if($diff<1)echo "-";else echo "(".money($diff).")"; ?></div>
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
//hide voucher
/*if ($voucher_list) foreach($voucher_list as $list5){?>
<div class="<?php echo alternator('midShopCartInfo', 'midShopCartInfo2');?>">
    <div class="shopCartImgCon">
        <div class="shopCartImg">
        <?php if ($list5['image_voucher']!=""){?>
        <img src="<?php echo base_url()?>userdata/voucher/<?php echo $list5['image_voucher']?>">
		<?php }else {?>
        <img src="<?php echo base_url()?>userdata/voucher/voucher.jpg">
		<?php } ?>
        </div>
    </div>
  <div class="shopCartDetail">
<div class="productNameCart"><?php echo $list5['voucher_name']?> </div>
<div class="rightBox"><?php echo $list5['quantity'] ?></div>
<div class="rightBox">-</div>
<div class="rightBox">-</div>
<div class="rightBox"><?php echo money($list5['total']) ?></div>
<div class="rightBox">-</div>
    </div>
<?php }*/?>

<input type="hidden" name="guest" id="guest" value="0"/>
<input type="hidden" name="total" id="total" value="<?php if(!$discount_cart) echo $total_price;
					else{
						if($total_price>=$discount_cart['minimum_purchase'])
						{
							echo $total_price-$discount_cart['discount'];
						}
						else
						{
							echo $total_price;
						}
					}?>"/>
<input type="hidden" name="total_doku" id="total_doku" value="<?php echo $total_price;?>"/>
<input type="hidden" name="discount_cart" id="discount_cart" value="<?php if(!$discount_cart) echo 0;
					else{
						echo $discount_cart['discount'];
					}?>"/>
<input type="hidden" name="shipping_fee" id="shipping_fee" value="<?php echo $shipping_fee;?>"/>
<input type="hidden" name="shipping_cost" id="shipping_cost" value="<?php echo $shipping_cost;?>"/>
<input type="hidden" name="ceil_weight" id="ceil_weight" value="<?php echo ceil($total_actual_weight);?>"/>
<div class="topShopCartInfo"></div>
<div class="botShopCartInfo">
    <div class="botLeftCart">
    <?php /*if($voucher_list or $stamps_list){?>
        <div class="promotionWrap">
            <div class="buttonBox">
            <?php if ($voucher_list==true){ ?>
                <div class="voucherBox"><img src="<?php echo base_url()?>templates/images/voucher-img.png">You have coupon applied</div>
                                 
                <a href="<?php echo site_url('shopping_cart/deletevoucher_shop'.'/')?>" class="rmv">Cancel, I want to remove.</a>				
            <?php }?>
             
             <?php if ($stamps_list==true){ ?>
                <div class="stampBox"><img src="<?php echo base_url()?>templates/images/stamp-img.png">You have stamp applied</div>
                <a href="#" class="rmv">Cancel, I want to remove.</a>  
              
             <?php } ?>
           
            </div>
        </div>
        <?php }*/?>
        <h3>Shipping Detail</h3>
        <table>
            <tr>          
                <td width="30%" class="field1">Recipent Name</td>
                <td width="70%" class="field2"><?php echo $address['recipient_name'];?></td>
            </tr>
            <tr>
                <td class="field1">Mobile / Phone</td>
                <td class="field2"><?php echo $address['phone'];?></td>
            </tr>
            <?php /*?><tr>
                <td class="field1">Mobile</td>
                <td class="field2"><?php echo $address['mobile'];?></td>
            </tr><?php */?>
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
                <td class="field2"><?php echo api_city_name($address['city']); //find('name', $address['city'], 'jne_city_tb');?></td>
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
                    <td width="200">Total</td>
                    <td width="50">IDR.</td>
                    <td width="150" style="text-align:right"><div class="totalPrice"><?php echo money2($total_price);?></div></td>
                </tr>
                <?php if($discount_cart){
						if($total_price>=$discount_cart['minimum_purchase']){ ?>
                    <tr>
                        <td width="200">Discount Promo</td>
                        <td width="50">IDR.</td>
                        <td width="150" style="text-align:right;"><div class="totalPrice"><?php echo money2($discount_cart['discount']);?></div></td>
                    </tr>
                <?php }
				}?>
				<?php if ($voucher_list)foreach($voucher_list as $list5){?>
                <tr>
                    <td width="200" style="color:#C1272D;">Discount</td>
                    <td width="50" style="color:#C1272D;">IDR.</td>
                    
					<input type="hidden" name="voucher" id="voucher" value="<?php echo $list5['voucher_id'];?>"/>  
                    <?php /*?><?php if($total_harga_diskon['totalsemua']<$list5['maximum_sub']){ 
					$totalbelanja=$total_harga_diskon['totalsemua']?>
                    <?php } else { ?>
                    <?php $totalbelanja=$list5['maximum_sub'] ?>
                    <?php } ?>
                    <td width="150" style="text-align:right;color:#C1272D;"><div class="totalPrice"><?php
					if($list5['type_voc']==1){
					$discount=($totalbelanja*$list5['value'])/100; echo money2($discount);?>
        			<?php }else{ ?>
                   	<?php
					$discount=$list5['value']; echo money2($discount);?>	
					<?php } ?>             		
                   </div></td><?php */?>
                   
                   <td width="150" style="text-align:right;color:#C1272D;">
                   <div class="totalPrice">    
                   		<?php $discount+=$list5['total']; echo money2($discount); ?>       		
                   </div>
                   </td>
                </tr>         
                <?php }?>
				<?php if ($stamps_list){?>
                <tr>
                    <td width="200" style="color:#C1272D;">Discount<td width="50" style="color:#C1272D;">IDR.</td>   
                    <td width="150" style="text-align:right;color:#C1272D;"><div class="totalPrice">
                   <?php $discount=$stamps_list['total']?>
                   <?php echo money2($discount)?>             		
                   </div></td>
                </tr>
                <?php } ?>
                <tr>
                    <td width="200">Shipping Cost</td>
                    <td width="50">IDR.</td>
                    <td width="150" style="text-align:right"><div class="totalPrice"><?php echo ($shipping_cost==0)?"FREE":money2($shipping_cost);?></div></td>
                </tr>              
                <tr>
                    <td width="200">Grand Total</td>
                    <td width="50">IDR.</td>
                    <td width="150" style="text-align:right;"><div class="totalPrice"><?php 
					if(!$discount_cart) echo money2($total_price + $shipping_cost - $discount);
					else{
						if($total_price>=$discount_cart['minimum_purchase'])
						{
							echo money2($total_price-$discount_cart['discount']+ $shipping_cost - $discount);
						}
						else
						{
							echo money2($total_price + $shipping_cost - $discount);
						}
					}
					?></div></td>
                </tr>  
			</table>
        </div>
        <div class="botRightCartPayment">
            <table>
                <tr>
                    <td><h3>Select Your Payment Method</h3></td>
                </tr>
                
                <tr>
                    <td width="150">
                        <label>
                            <input type="radio" name="paymentMethod" value="bank_transfer">
                            Bank Transfer
                        </label>
                        <div id="bankTransferInfo">
                            <p>Langkah pembayaran dengan Manual Transfer BCA:</p>
                            <ol>
                                <li><p>Catatlah nomor order Anda yang akan tertera di halaman berikut.</p></li>
                                <li><p>Transfer jumlah total ke account<br>
                                    <strong style="color:#9E005D;">
                                    a/n PT Torio Multi Nasional<br>
                                    253.351.3000<br>
                                    BCA Green Garden</strong><br>
                                    Masukan nomor order Anda di keterangan dan simpan struk/email sebagai bukti.<br>
                                    Pembayaran harus dilakukan paling lambat dua hari dari tanggal order, atau order otomatis dibatalkan.</p></li>
                                <li><p>Konfirmasi pembayaran Anda di halaman konfirmasi.</p></li>
                                <li><p>Setelah Anda mengkonfirmasi, maka kami baru memulai memproses order Anda. Update status order akan dikabarkan melalui email.</p></li>
                            </ol>
                        </div>

                        <form id="bank_transfer_form" name="bank_transfer_form" action="#" method="post">
                        
                            <input type="hidden" name="status" value="1" />
                        </form>
                    </td>
                </tr>
                
                <tr>
                    <td width="150">
                        <label>
                            <input type="radio" name="paymentMethod" value="credit_card">
                           Credit Card
                        </label>
                        <form id="doku_payment_request" name="doku_payment_request" action="#" method="post">
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
                    <td width="150"><a href="javascript:void(0);" class="proceed" onclick="payment_method();">Submit</a></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
function do_checkout(){
	if(confirm("You are going to use bank transfer as your payment method, click OK to continue.")){
		$("#bank_transfer_form").attr('action','<?php echo site_url('shopping_cart/do_checkout_2')?>');
		$("#bank_transfer_form").submit();
	}
}

function submit_form()
{
	var check = 1;
		
	$.ajax({
		type:"POST",
		url:base_url+'shopping_cart/check_stock_cart',
		dataType:"JSON",
		async:false,
		success: function(data){
			var id = data.product_id;
			if(data.check==0){ check=1;
			}
			else
			{
				check=0;
				
				id.forEach(function(entry){
					$('#stock_'+entry).html('*stock not available');
					$('#stock_'+entry).attr('style', 'display:block;color:red;font-size:10px;');
				});
				
				alert('Stock Unavailable');
			}
		}
	});
	
	if(check==0) return false;
	
	var ship_cost = parseInt($("#shipping_cost").val());
	var ceil_weight = parseInt($("#ceil_weight").val());
	var shipping_fee = parseInt($("#shipping_fee").val());
	var voucher = parseInt($("#voucher").val());
	var temp = parseInt($("#total").val());
	var discount_cart = parseInt($("#discount_cart").val());
	var total = temp+ship_cost;
	
	$.ajax({
		type: "POST",
		url: '<?php echo site_url('ccpayment/doku_payment');?>',
		data: "user_id="+<?php echo $user['id'];?>+"&total="+total+"&ceil_weight="+ceil_weight+"&shipping_fee="+shipping_fee+"&voucher="+voucher,
		beforeSend:function(){
			$("#").html('<img src="<?php echo base_url();?>templates/images/ajax-loader.gif">');
			$(".sbt").hide();
			$(".sbt").parent().html('<img src="<?php echo base_url();?>templates/images/ajax-loader.gif">');
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
			
			<?php if($this->session->userdata('fb_id')!='' or $this->session->userdata('fb_id')!=0){?>
			fb_autopost();
			<?php }?>
			$("#doku_payment_request").attr('action','<?php echo DOKU_URL;?>');
			$("#doku_payment_request").submit();
		}
	});
}

function payment_method()
{
	var user_city = <?php echo find('city', $this->session->userdata('user_id'), 'user_tb'); ?>;
	var user_province = <?php echo find('province', $this->session->userdata('user_id'), 'user_tb'); ?>;
	
	if(user_city==0 || user_province==0){
		$("#errorMyAccount").fadeToggle();
		return false;
	}
	
	var selected  = $("input[type='radio'][name='paymentMethod']:checked");
	var selectedVal = "";
	if(selected.length > 0)selectedVal = selected.val();
	if(selectedVal=='bank_transfer'){
		do_checkout();
	}else if(selectedVal=='credit_card'){
		submit_form();
	}else {}
	
}

function close_popup(){
	window.location.href='<?php echo site_url('my_account/edit_profile') ?>';
	//$("#errorMyAccount").fadeOut();	
	//$("#overlay").fadeOut();	
}

$(document).ready(function(){
	$("#submit_btn").click(function(){
		$("#voucher_form").submit();
		return false;
	});	
});	

</script>