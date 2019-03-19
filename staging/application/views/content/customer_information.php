<script>
$(function() {
$("#submit_voucher_btn").click(function(){
        voucher_submit();
        return false;
    });
});
function voucher_submit()
{          
    var coupoun = $('#coupoun').val();
    if($("#coupon_code").val()!=""){
        $.ajax({
            type: "POST",
            url: '<?php echo site_url('shopping_cart/add_coupon');?>',
            data: {coupoun : coupoun},
            dataType:"JSON",              
            success: function(result){
                
                if(result.status==1){                   
                    $('.voucherCon').fadeOut(500, function(){
                        <?php /*?>$('#facebooktype2').hide();<?php */?>
                        //$('#promo_used').fadeIn(500);
                       // $("#applied_voucher").show();
                        //$("#voucher_form_loader").hide();
                        //$("#button_con").show();
                        $("#coupon_code").val('');
                    });
                    
                    $("#grand_total_table").fadeOut(500,function(){
                        $(this).html(result.content);   
                        $(this).fadeIn(500);
                    });             
                }
                else {
                    alert(result.msg);                      
                    $("#voucher_form_loader").hide();
                    $("#button_con").show();
                }
            }
        }); 
        
    //  $("#voucher_form").submit();
    }
    else 
        return false;
}    

function load_address(id){
    $.ajax({
        type: "POST",
        url: '<?php echo site_url('shopping_cart/load_address').'/';?>'+id,
        dataType:"JSON",
        success: function(temp){
            console.log(temp);
                
                $('#customer_phone').html(temp.phone);
                $('#customer_name').html(temp.recipient_name);
                $('#customer_email').html(temp.email);
                $('#customer_address').html(temp.shipping_address);
                $('#customer_zipcode').html(temp.zipcode);
                $('#customer_city').html(temp.province_name+', '+temp.city_name);

                $("#user_address_id").val(temp.id);
                $("#name").val(temp.recipient_name);
                $("#address").val(temp.shipping_address);
                $("#phone").val(temp.phone);
                $("#email").val(temp.email);
                $("#city_billing").val(temp.city);
                $("#zipcode").val(temp.zipcode);

                var province_temp = temp.province;
                
                $("#autokecamatan").val(temp.jne_kecamatan_name);
                
        }
    });
}
</script>

<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="customerWrapper">
                        <h3>Customer information</h3>
                        <div class="breadCrumb">
                        	<ul>
                            	<li>Customer Information ></li>
                            	<li><a href="#">Shipping Method ></a></li>
                                <li><a href="#">Payment Method</a></li>
                            </ul>
                        </div>
                        <div class="customerdataBox">
                        	<div class="customerData loggedin">
                            	<h2>recipient name</h2>
                                <?php if($address){ ?>
                                <select name="select_recipient" onchange="load_address(this.value);">
                                    <?php if($address)foreach($address as $list){?>
                                    <option value="<?php echo $list['id'];?>" <?php if($detail)if($list['id']==$detail['id'])echo "selected=\"selected\"";?>><?php echo $list['label'] ?></option>
                                    <?php } ?>
                                </select>
                                <?php }else{ ?>
                                <p>You don't have address yet. Please add your address by clicking the button below.</p>
                                <?php } ?>
                                <form method="post" id="form_add_address" action="<?php echo site_url('my_profile/add_address') ?>">
                                <input type="hidden" name="address_type" value="1">
                                <a href="javascript:void(0)" id="submit_address" class="addAddress">Add Address</a>
                                </form>
                                <div class="customerAddress">
                                	<p>
                                    <span class="customerName" id="customer_name"><?php if($detail)echo $detail['recipient_name']?></span><br>
                                    <span id="customer_phone"><?php if($detail)echo $detail['phone']?></span><br>
                                    <span id="customer_address"><?php if($detail)echo $detail['shipping_address']?></span><br>
                                    <span id="customer_city"><?php if($detail){ echo find('name',$detail['province'],'jne_province_tb') ?>, <?php echo find('name',$detail['city'],'jne_city_tb'); } ?></span><br>
                                    <span id="customer_zipcode"><?php if($detail)echo $detail['zipcode']?></span>
                                    </p>
                                </div>
                                <form method="post" id="formcustomer" action="<?php echo site_url('shopping_cart/do_customer_information') ?>">
                                <input type="hidden" name="user_address_id" id="user_address_id"  value="<?php if($detail)echo $detail['id']?>">
                                <input type="hidden" name="name" id="name"  value="<?php if($detail)echo $detail['recipient_name']?>">
                                <input type="hidden" name="phone" id="phone" value="<?php if($detail)echo $detail['phone']?>">
                                <input type="hidden" name="email" id="email"  value="<?php if($detail)echo $detail['email']?>">
                                <input type="hidden" name="address" id="address" value="<?php if($detail)echo $detail['shipping_address'] ?>">
                                <input type="hidden" name="city"  id="city" value="<?php if($detail)echo $detail['city'] ?>">
                                <input type="hidden" name="zipcode"  id="zipcode" value="<?php if($detail)echo $detail['zipcode'] ?>">
                                        
                                <input type="hidden" name="select_city" id="city_billing" value="<?php if($detail)echo $detail['city'] ?>" /> 
                                </form> 
                                        
                            </div>
                            <div class="customerorderData">
                            	<?php $subtotal=0; if($shopping_cart) foreach ($shopping_cart as $list) { ?>
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
                                        <p>Rp  <?php echo number_format($list['total']) ?>,-</p>
                                    </div>
                                </div>
                                <?php $subtotal += $list['total']; } ?>
                                
                                <div class="promoVoucher">
                                    <form id="voucher_form" name="voucher_form" method="post" action="#" onsubmit="return false;">
                                	<input name="coupoun" id="coupoun" placeholder="Gift Card or Discount Code">
                                    <a href="javascript:void(0)" id="submit_voucher_btn" class="applyBtn">Apply</a>
                                    </form>
                                </div>
                                <table id="grand_total_table">
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
                                    <?php if ($voucher_list) foreach($voucher_list as $list5){?>
                                    <tr>
                                    	<td>Discount</td>
                                        <td>Rp <?php $discount+=$list5['total']; echo money2($discount); ?> </td>
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
                                    <tr>
                                    	<td>TOTAL</td>
                                        <td>Rp <?php 
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
                                </table>
                            </div>
                        </div>
                        <div class="buttonArea">
                        	<a href="javascript:void(0)" id="continue"  class="defBtn">CONTINUE to SHIPPING METHOD</a>
                            <a href="<?php echo site_url('shopping_cart') ?>" class="returnShop">< Return to shopping cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<script>
$("#continue").click(function(){
    $("#formcustomer").submit();
});

$("#submit_address").click(function(){
    $("#form_add_address").submit();
});

</script>