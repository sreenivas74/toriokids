<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="customerWrapper">
                        <h3>SUMMARY</h3>
                        <div class="breadCrumb">
                        	<ul>
                            	<li><a href="#">Customer Information ></a></li>
                            	<li><a href="#">Shipping Method ></a></li>
                                <li>Payment Method</li>
                            </ul>
                        </div>
                        <div class="customerdataBox">
                        	<div class="customerData loggedin">
                            	<h2>your PAyment method</h2>
                                <p>BANK TRANSFER</p>
                                <div class="bankNotif">
                                	<span>Please Transfer To:</span>
                                    <p>
                                    	PT Torio Multi Nasional<br>
                                    	253.351.3000<br>
                                        BCA Green Garden
                                    </p>
                                </div>
                                
                                <div class="customerAddress">
                                	<p>
                                    <?php if($this->session->userdata('user_logged_in')){ ?>
                                    <span class="customerName"><?php echo $address['recipient_name'] ?></span><br>
                                    <?php echo $address['phone'] ?><br>
                                    <?php echo $address['shipping_address'] ?><br>
                                    <?php echo find('name',$address['province'],'jne_province_tb') ?>, <?php echo find('name',$address['city'],'jne_city_tb') ?><br>
                                    <?php echo $address['zipcode'] ?>
                                    </p>
                                    <?php }else{ ?>
                                    <span class="customerName"><?php echo $shipping_info['customer_name'] ?></span><br>
                                    <?php echo $shipping_info['customer_phone'] ?><br>
                                    <?php echo $shipping_info['customer_email'] ?><br>
                                    <?php echo $shipping_info['customer_address'] ?><br>
                                    <?php echo find('name',$shipping_info['customer_province'],'jne_province_tb') ?>, <?php echo find('name',$shipping_info['customer_city'],'jne_city_tb') ?><br>
                                    <?php echo $shipping_info['customer_zipcode'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="customerorderData">
                            	<?php $subtotal=0; if($cart_list) foreach ($cart_list as $list) { ?>
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
                                <?php $subtotal += $list['total']; $total_actual_weight+=$list['actual_weight']; } ?>
                                <?php $shipping_cost=ceil($total_actual_weight)*$shipping_fee; echo $shipping_cost; ?>

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
                                <input type="hidden" name="discount_cart" id="discount_cart" value="<?php if(!$discount_cart) echo 0;
                                                    else{
                                                        echo $discount_cart['discount'];
                                                    }?>"/>
                                <input type="hidden" name="shipping_fee" id="shipping_fee" value="<?php echo $shipping_fee;?>"/>
                                <input type="hidden" name="shipping_cost" id="shipping_cost" value="<?php echo $shipping_cost;?>"/>
                                <input type="hidden" name="ceil_weight" id="ceil_weight" value="<?php echo ceil($total_actual_weight);?>"/>
                                <form id="bank_transfer_form" name="bank_transfer_form" action="#" method="post">
                        
                                    <input type="hidden" name="guest" id="guest" value="1"/>
                                    <input type="hidden" name="status" value="1" />
                                </form>
                                
                                <table>
                                    <tr>
                                        <td>SUBTOTAL</td>
                                        <td>Rp <?php echo number_format($subtotal) ?>,-</td>
                                    </tr>
                                    <?php if($discount_cart){
                                            if($total_price>=$discount_cart['minimum_purchase']){ ?>
                                        <tr>
                                            <td>Discount Promo</td>
                                            <td>Rp <?php echo money2($discount_cart['discount']);?></td>
                                        </tr>
                                    <?php }
                                    }?>

                                    <?php if ($voucher_list)foreach($voucher_list as $list5){?>
                                    <input type="hidden" name="voucher" id="voucher" value="<?php echo $list5['voucher_id'];?>"/>  
                                    <tr>
                                        <td>Discount</td>
                                        <td>Rp <?php $discount+=$list5['total']; echo number_format($discount); ?> ,-</td>
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
                                        <td>Shipping</td>
                                        <td>Rp <?php echo ($shipping_cost==0)?"FREE":money2($shipping_cost);?></td>
                                    </tr>
                                    <?php /* ?>
                                    <tr>
                                        <td rowspan="2"><p>(Estimated Day 10- days)</p></td>
                                    </tr>
                                    <?php */ ?>
                                    <tr>
                                        <td>TOTAL</td>
                                        <td>Rp <?php if(!$discount_cart) echo money2($total_price + $shipping_cost - $discount);
                                        else{
                                            if($total_price>=$discount_cart['minimum_purchase'])
                                            {
                                                echo money2($total_price-$discount_cart['discount']+ $shipping_cost - $discount);
                                            }
                                            else
                                            {
                                                echo money2($total_price + $shipping_cost - $discount);
                                            }
                                        }?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="buttonArea">
                        	<a href="javascript:void(0)" onclick="payment_method();" class="defBtn">CONfirm order</a>
                            <a href="<?php echo site_url('shopping_cart') ?>" class="returnShop">< Review Back Your Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
        function payment_method(){
                $("#bank_transfer_form").attr('action','<?php echo site_url('shopping_cart/do_checkout_3')?>');
                $("#bank_transfer_form").submit();
            
        }
        </script>