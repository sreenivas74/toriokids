<script>
$(function() {
        $("#city").autocomplete({ 
          source: '<?php echo site_url('shopping_cart/get_kecamatan')?>',
           max:30,
            select: function( event, de ) {
                //alert(de.item.id);
                $("#city_billing").val(de.item.id);
                load_shipping_method(de.item.id);   
                                            
            }
                
        });

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
            url: '<?php echo site_url('shopping_cart/add_coupon_guest');?>',
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

function load_shipping_method(id){
    if(id!=0){
        $.ajax({
            type: "POST",
            url: '<?php echo site_url('shopping_cart/load_shipping_method').'/';?>'+id,
            beforeSend:function(){
            $("#ship_met").html('<img src="<?php echo base_url();?>templates/images/ajax-loader.gif">');
            },
            success: function(temp){
                $("#ship_met").html(temp);
            }
        });
        }else {
            $("#ship_method").val('0');
        }
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
                        	<div class="customerData">
                            	<div class="type">
                                    <form id="form_login_submit" method="post" action="<?php echo site_url('login') ?>">
                                	<p>member?</p>
                                    <input type="hidden" id="login_type" name="login_type" value="customer_info">
                                    <a href="javascript:void(0)" id="login_sub">Login here</a>
                                    </form>
                                </div>
                                <div class="type">
                                    <form id="form_register_submit" method="post" action="<?php echo site_url('registration') ?>">
                                	<p>Not A member?</p>
                                    <input type="hidden" id="register_type" name="register_type" value="1">
                                    <a href="javascript:void(0)" id="register_sub">register</a>
                                    </form>
                                </div>
                                    <?php $address_guest=$this->session->userdata('customer_guest');
                                    //pre($address_guest);exit;
                                    if($address_guest){
                                        $customer_name=$address_guest['customer_name'];
                                        $customer_email=$address_guest['customer_email'];
                                        $customer_phone=$address_guest['customer_phone'];
                                        $customer_address=$address_guest['customer_address'];
                                        $customer_city=$address_guest['customer_city'];
                                        $customer_province=$address_guest['customer_province'];
                                        $customer_zipcode=$address_guest['customer_zipcode']; 
                                        $city_billing=$address_guest['city_billing'];   
                                    }
                                    else{
                                        $customer_name='';
                                        $customer_email='';
                                        $customer_phone='';
                                        $customer_address='';   
                                        $customer_city=''; 
                                        $customer_province=''; 
                                        $customer_zipcode=''; 
                                        $city_billing='';
                                    }
                                    ?>
                                <form method="post" id="formcustomer" action="<?php echo site_url('shopping_cart/do_customer_information') ?>">
                                <div class="type">
                                	<p>check out As GUESt?</p>
                                    <div class="inputField logGuest">
                                        <input type="hidden" name="user_address_id" id="user_address_id"  value="0">
                                        <input class="defTxtInput" name="name" id="name" placeholder="First Name*" value="<?php echo $customer_name ?>">
                                        <input class="defTxtInput" name="phone" id="phone" placeholder="Phone Number*" value="<?php echo $customer_phone ?>">
                                        <input class="defTxtInput" name="email" id="email" placeholder="Email*" value="<?php echo $customer_email ?>">
                                        <textarea class="defTxtInput" name="address" id="address" placeholder="Address*"><?php echo $customer_address ?></textarea>
                                        <input class="defTxtInput" name="city"  id="city" placeholder="City*" value="<?php echo $customer_city ?>" onchange="fill_value(this.value);">
                                        
                                        <input type="hidden" name="select_city" id="city_billing" value="<?php echo $city_billing ?>" onchange="load_shipping_method(this.value);" />  
                                        <script>
                                        function fill_value_billing(city_typed){
                                            if(city_typed==''){
                                                $("#city_billing").val('0');
                                            }
                                        }
                                        </script>
                                        <?php /* ?>
                                        <select name="province">
                                            <option value="placeholder">Province*</option>
                                            <?php if($province) foreach ($province as $a) { ?>
                                            <option value="BCA"><?php echo $a['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php */ ?>
                                        <input class="defTxtInput" name="zipcode" id="zipcode" placeholder="ZIP Code*" value="<?php echo $customer_zipcode ?>">
                                	</div>
                                </div>
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
                                        <td>Rp <?php $discount+=$list5['total']; echo money2($discount); ?></td>
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
                        	<a href="javascript:void(0)" id="continue" class="defBtn">CONTINUE to SHIPPING METHOD</a>
                            <a href="<?php echo site_url('shopping_cart') ?>" class="returnShop">< Return to shopping cart</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
<script>
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
    $("#login_sub").click(function(){
        $('#form_login_submit').submit();
    });
    $("#register_sub").click(function(){
        $('#form_register_submit').submit();
    });

    $("#continue").click(function(){
        if($("#name").val()==""){
            alert('Please enter your name');
            $('#name').addClass('error');
            return false;
        }
        else{
            $('#name').removeClass('error');
        }
        if($("#phone").val()==""){
            alert('Please enter your phone number');
            $('#phone').addClass('error');
            return false;
        }
        else{
            $('#phone').removeClass('error');
        }

        if(isNaN($("#phone").val())){
            alert('Phone number must be number');
            $('#phone').addClass('error');
            return false;
        }
        else{
            $('#phone').removeClass('error');
        }

        if($("#email").val()==""){
            alert('Please enter your email');
            $('#email').addClass('error');
            return false;
        }
        else{
            $('#email').removeClass('error');
        }
        if(!validateEmail($("#email").val())){
            alert('Invalid email format');
            $('#email').addClass('error');
            return false;
        }
        else{
            $('#email').removeClass('error');
        }
        if($("#address").val()==""){
            alert('Please enter your address');
            $('#address').addClass('error');
            return false;
        }
        else{
            $('#address').removeClass('error');
        }
        if($("#city").val()==""){
            alert('Please enter your city');
            $('#city').addClass('error');
            return false;
        }
        else{
            $('#city').removeClass('error');
        }
        if($("#zipcode").val()==""){
            alert('Please enter your zipcode');
            $('#zipcode').addClass('error');
            return false;
        }
        else{
            $('#zipcode').removeClass('error');
        }
        
        $("#formcustomer").submit();
        
        
    });
</script>