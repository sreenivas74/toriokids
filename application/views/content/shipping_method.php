<script>
function shipping(fee){
    var total = $('#total').val();
    // $.ajax({
    //     type:"POST",
    //     dataType:"json",
    //     url:'<?php echo site_url('shopping_cart/check_shipping');?>',
    //     data:{fee:fee},
    //     success:function(temp){

    //     }
    // })
    if(fee=="free"){
        var feee=0;
        $("#shipping_table").fadeOut(500,function(){
                        $(this).html('<td>Shipping</td><td>Rp Free</td>');   
                        $(this).fadeIn(500);
        }); 
    }else{
        var feee=fee;
        $("#shipping_table").fadeOut(500,function(){
                        $(this).html('<td>Shipping</td><td>Rp '+addCommas(feee)+',-</td>');   
                        $(this).fadeIn(500);
        }); 
    }
    
    $("#shipping_table").show();

     $("#estimated").fadeOut(500,function(){
                        $(this).html('<td rowspan="2"><p>(Estimated Day 10- days)</p></td>');   
                        $(this).fadeIn(500);
    }); 


    total_shipping = parseInt(total)+parseInt(feee);

    $("#total_all").fadeOut(500,function(){
                        $(this).html('<td>Rp '+addCommas(total_shipping)+',-</td>');   
                        $(this).fadeIn(500);
    }); 

}

</script>
<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="customerWrapper">
                        <h3>Shipping method</h3>
                        <div class="breadCrumb">
                        	<ul>
                            	<li><a href="#">Customer Information ></a></li>
                            	<li>Shipping Method ></li>
                                <li><a href="#">Payment Method</a></li>
                            </ul>
                        </div>
                        <div class="customerdataBox">
                            
                        	<div class="customerData loggedin">
                            	<h2>choose your shipping method</h2>
                                <form method="post" id="formShipping" action="#">
                                <ul class="methodTab">
                                    <?php if( $sm['min_purchase']>0 and $total_price <= $sm['min_purchase'] ){?>
                                	   <?php if($sm['regular_fee']!=""){?><li><input type="radio" value="<?php echo $sm['regular_fee'] ?>" name="method" class="methodTab" id="method1" onclick="shipping(<?php echo $sm['regular_fee'] ?>)"><label for="method1"><span></span>Regular ( <?php if($sm['regular_fee']==0) { echo "Free"; }else{ echo money($sm['regular_fee']); } ?> )<p>Estimated delivery time <?php echo $sm['regular_etd'] ?>  days</p></label></li><?php } ?>
                                    <?php }else{ ?>
                                        <?php if($sm['min_purchase']>0){?>
                                        <li><input type="radio" value="0" name="method" class="methodTab" id="method1" onclick="shipping('free')"><label for="method1"><span></span>Regular (Free)<p>Estimated delivery time <?php echo $sm['regular_etd'] ?> days</p></label></li>
                                        <?php }else{ ?>
                                        <li><input type="radio" value="<?php echo $sm['regular_fee'] ?>" name="method" class="methodTab" id="method1" onclick="shipping(<?php echo $sm['regular_fee'] ?>)"><label for="method1"><span></span>Regular ( <?php if($sm['regular_fee']==0) { echo "Free"; }else{ echo money($sm['regular_fee']); } ?> )<p>Estimated delivery time <?php echo $sm['regular_etd'] ?> days</p></label></li>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if($sm['express_fee']!=""){?>
                                        <?php if($sm['express_fee']>0){?>
                                        <li><input type="radio" value="<?php echo $sm['express_fee'];?>" name="method" class="methodTab" id="method2" onclick="shipping(<?php echo $sm['express_fee'] ?>)"><label for="method2"><span></span>Express ( <?php if($sm['express_fee']==0) { echo "Free"; }else{ echo money($sm['express_fee']); } ?> )<p>Estimated delivery time <?php echo $sm['express_etd'] ?> days</p></label></li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                                </form>
                                <?php $address_guest=$this->session->userdata('customer_guest');
                                    if($address_guest){
                                        $customer_name=$address_guest['customer_name'];
                                        $customer_email=$address_guest['customer_email'];
                                        $customer_phone=$address_guest['customer_phone'];
                                        $customer_address=$address_guest['customer_address'];
                                        $customer_city=$address_guest['customer_city'];
                                        $customer_province=$address_guest['customer_province'];
                                        $customer_zipcode=$address_guest['customer_zipcode']; 
                                        $user_address_id=$address_guest['user_address_id'];   
                                    }
                                    else{
                                        $customer_name='';
                                        $customer_email='';
                                        $customer_phone='';
                                        $customer_address='';   
                                        $customer_city=''; 
                                        $customer_province=''; 
                                        $customer_zipcode=''; 
                                    }
                                ?>
                                <div class="customerAddress">
                                	<p>
                                    <span class="customerName"><?php echo $customer_name ?></span><br>
                                    <?php echo $customer_phone ?><br>
                                    <?php if(!$this->session->userdata('user_logged_in')){ ?>
                                    <?php echo $customer_email ?><br>
                                    <?php } ?>
                                    <?php echo $customer_address ?><br>
                                    <?php echo find('name',$customer_province,'jne_province_tb') ?>, <?php echo find('name',$customer_city,'jne_city_tb') ?><br>
                                    <?php echo $customer_zipcode ?>
                                    </p>
                                    <a href="<?php echo site_url('shopping_cart/customer_information') ?>" class="editAddress">Edit Shipping Address</a>
                                </div>
                            </div>
                            <div class="customerorderData">
                                <?php $subtotal=0; if($cart_list)foreach ($cart_list as $list) { ?>
                            	<div class="itemPanel">
                                    <div class="itemBox">
                                        <div class="image">
                                            <img width="100%" src="<?php echo base_url() ?>userdata/product/<?php echo find_2_prec('image', 'product_id', $list['product_id'], 'product_image_tb');?>">
                                        </div>
                                        <div class="data">
                                            <p class="productName"><?php echo $list['name'] ?></p>
                                            <p class="productCategory">Size: <?php echo $list['size'] ?> | Qty: <?php echo $list['quantity'] ?></p>
                                        </div>
                                    </div>
                                    <div class="itemPrice">
                                        <p>Rp <?php echo number_format($list['total']) ?>,-</p>
                                    </div>
                            	</div>
                                <?php $subtotal += $list['total']; } ?>
                                <table>
                                	<tr>
                                    	<td>SUBTOTAL</td>
                                        <td>Rp <?php echo number_format($subtotal); ?>,-</td>
                                    </tr>
                                    <?php if($discount_cart){
                                            if($total_price>=$discount_cart['minimum_purchase']){ ?>
                                        <tr>
                                            <td>Discount Promo</td>
                                            <td>Rp <?php echo money2($discount_cart['discount']);?></td>
                                        </tr>
                                    <?php }
                                    }?>

                                    <?php if($voucher_list) foreach ($voucher_list as $list5) { ?>
                                    <tr>
                                    	<td>Discount</td>
                                        <td>Rp <?php $discount+=$list5['total']; echo number_format($discount); ?>,-</td>
                                    </tr>
                                    <?php } ?>
                                     <?php if ($stamps_list){?>
                                    <tr>
                                        <td>Discount</td>   
                                        <td>Rp 
                                       <?php $discount=$stamps_list['total']?>
                                       <?php echo money2($discount)?>                   
                                       </td>
                                    </tr>
                                    <?php } ?>

                                    <tr style="display:none" id="shipping_table">
                                    	<td>Shipping</td>
                                        <td></td>
                                    </tr>
                                    <?php /* ?>
                                    <tr id="estimated">
                                        <td rowspan="2"><p>(Estimated Day 10- days)</p></td>
                                    </tr>
                                    <?php */ ?>
                                    <tr>
                                    	<td>TOTAL</td>
                                        <td id="total_all">Rp <?php 
                                        if(!$discount_cart) echo money2($total_price - $discount);
                                        else{
                                            if($total_price>=$discount_cart['minimum_purchase'])
                                            {
                                                echo money2($total_price-$discount_cart['discount'] - $discount);
                                            }
                                            else
                                            {
                                                echo money2($total_price - $discount);
                                            }
                                        }
                                        ?></td>
                                    </tr>
                                    <input type="hidden" value="<?php 
                                        if(!$discount_cart) echo ($total_price - $discount);
                                        else{
                                            if($total_price>=$discount_cart['minimum_purchase'])
                                            {
                                                echo ($total_price-$discount_cart['discount'] - $discount);
                                            }
                                            else
                                            {
                                                echo ($total_price - $discount);
                                            }
                                        }
                                        ?>" id="total">
                                </table>
                            </div>
                        </div>
                        <div class="buttonArea">
                        	<a href="javascript:void(0)" onclick="shipping_method();" id="submit_payment" class="defBtn">CONTINUE to payment METHOD</a>
                            <a href="<?php echo site_url('shopping_cart/customer_information') ?>" class="returnShop">< Return to customer information</a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>

<script>
function shipping_method()
{
    var selected  = $("input[type='radio'][name='method']:checked");
    var selectedVal = "";
    if(selected.length > 0)selectedVal = selected.val();

    if(selectedVal!=''){
        $("#formShipping").attr('action','<?php echo site_url('shopping_cart/payment_method')?>');
        $("#formShipping").submit();
    }
    else{
        alert('Please select your shipping method');
    }
    
}
</script>