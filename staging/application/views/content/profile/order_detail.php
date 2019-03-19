<section>
        	<div class="contentWrapper">
                <div class="mainWrapper nobanner">
                	<div class="orderWrapper">
                    	<div class="orderRow">
                        	<div class="orderBox">
                                <?php $total_price=0;
                                if($order)foreach($order as $list){?>
                            	<div class="productOrder">
                                	<img src="<?php echo base_url();?>userdata/product/med/<?php echo find_2_prec2('image', 'product_id', $list['product_id'], 'product_image_tb');?>">
                                    <p><?php echo find('name',$list['product_id'],'product_tb');?></p>
                                    <table>
                                    	<tr>
                                        	<td>Color</td>
                                            <td>:</td>
                                            <td>Blue</td>
                                        </tr>
                                        <tr>
                                        	<td>Size</td>
                                            <td>:</td>
                                            <td><?php echo find('size',$list['sku_id'],'sku_tb')?></td>
                                        </tr>
                                        <tr>
                                        	<td>Qty</td>
                                            <td>:</td>
                                            <td><?php echo $list['quantity'] ?></td>
                                        </tr> 
                                    </table>
                                    <p>Rp <?php echo money2($list['msrp']*$list['quantity']);?></p>
                                </div>
                                <?php 
                                $total_price+=$list['total'];
                                ?>
                                <?php } ?>
                                <table class="transactionDetail">
                                	<tr>
                                    	<td>SUBTOTAL</td>
                                        <td>Rp <?php echo money2($total_price);?></td>
                                    </tr>
                                    <?php if($shipping['discount_price']!=0){?>
                                    <tr>
                                        <td>DISCOUNT</td>
                                        <td>Rp <?php echo money2($shipping['discount_price']);?></td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                    	<td>BIAYA PENGIRIMAN</td>
                                        <td><?php echo ($shipping['shipping_cost']==0)?"FREE":'Rp '.money2($shipping['shipping_cost']);?></td>
                                    </tr>
                                    <tr>
                                    	<td>TOTAL YANG HARUS DIBAYAR</td>
                                        <td>Rp <?php echo money2($total_price + $shipping['shipping_cost'] - $shipping['discount_price']);?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="orderRow">
                        	<div class="orderBox">
                            	<h3>Shipping Address</h3>
                                <table class="userAddress">
                                	<tr>
                                    	<td>Name</td>
                                        <td><?php echo $shipping['recipient_name'];?></td>
                                    </tr>
                                    <tr>
                                    	<td>Address</td>
                                        <td><?php echo nl2br($shipping['shipping_address']);?></td>
                                    </tr>
                                    <tr>
                                    	<td>Country</td>
                                        <td>Indonesia</td>
                                    </tr>
                                    <tr>
                                    	<td>Province</td>
                                        <td><?php echo $shipping['province_name'] ?></td>
                                    </tr>
                                    <tr>
                                    	<td>City</td>
                                        <td><?php echo $shipping['city_name'] ?></td>
                                    </tr>
                                    <tr>
                                    	<td>Zipcode</td>
                                        <td><?php echo $shipping['zipcode']?></td>
                                    </tr>
                                    <tr>
                                    	<td>Phone</td>
                                        <td><?php echo $shipping['phone']?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="orderRow">
                        	<div class="orderBox">
                            	<h3>DETAIL TRANSACTION</h3>
                                <?php if($shipping['status']!=0){ ?>
                                
                                <p>You have confirm your payment</p>
                                <?php } ?>
                                <br>
                                <p>Bank BCA Green Garden<br>a/n PT Torio Multi Nasional<br>No. Rekening : 253.351.3000</p>
                                <br>
                                <?php if($shipping['status']==0){ ?>
                                <a href="<?php echo site_url('payment_confirmation') ?>"><u>Confirm Payment</u></a>
                                <?php } ?>
                                <br>

                                <a href="<?php echo site_url('my_order') ?>">< Return to My Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>