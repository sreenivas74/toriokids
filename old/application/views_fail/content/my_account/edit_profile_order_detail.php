
<?php $this->load->view('content/my_account/my_account_menu');?>
<div class="editContainer">
	<?php $this->load->view('content/my_account/my_account_menu_mobile')?>
    <div class="noBg">
    <a href="<?php echo site_url('home');?>">Home </a>&gt;<a  href="<?php echo site_url('my_account');?>"> My Account </a>&gt;<a class="selectedBreadCrumb"> My Orders Detail</a>
    </div>
    <div class="editAccCon">
        <div class="editAccBox">
            <h2>My Orders Detail</h2>
           
            <div class="myOrderDetail" id="topOrderMobile">
        	<table width="50%">
                <tr style="border-bottom:1px solid #DDDDDD;">
                    <td width="37%"><p><strong>Order Number</strong></p></td><td width="2%"><p>:</p></td>
                    <td width="61%"><p>#<?php echo $shipping['order_number'];?></p></td>
                </tr>
                <tr style="border-bottom:1px solid #DDDDDD;">
                    <td><p><strong>Order Date</strong></p></td><td><p>:</p></td>
                    <td><p><?php echo display_date_full_admin($shipping['transaction_date']);?></p></td>
                </tr>
                <tr style="border-bottom:1px solid #DDDDDD;">
                    <td><p><strong>Order Status</strong></p></td><td><p>:</p></td>
                    <td><p><?php 
							if($shipping['status']==0)echo "Pending";
							else if($shipping['status']==1)echo "Processed";
							else if($shipping['status']==2)echo "Delivered";
          					else if($shipping['status']==4)echo "Shipped";
							else echo "Cancelled";
						?>	</p>			
        			</td>
                </tr>
                <?php if($shipping['payment_type']==1){?>
                <tr style="border-bottom:1px solid #DDDDDD;">
                    <td><p><strong>Payment Confirmation</strong></p></td><td><p>:</p></td>
                    <td><p><?php 
							if($shipping['status']==0){
								if($shipping['bank']=='')echo "Not Confirmed";
								else echo "Confirmed";
							}?>	</p>			
        			</td>
                </tr>
                <?php }?>
            </table>
            </div>
            <div class="myOrderDetail" id="middleOrderMobile">
                <table>
                    <tr class="row1">
                        <td width="23%" style="padding-left:10px;">Product Name</td>
                        <td width="5%" align="center">Qty</td>
                        <td align="right" width="17.5%" style="padding:0 5px;">Unit Price</td>
                        <td align="right" width="17.5%" style="padding:0 5px;">Subtotal</td>
                        <td align="right" width="17.5%" style="padding:0 5px;">Discount</td>
                        <td align="right" width="17.5%" style="padding:0 10px 0 5px;">Total</td>
                    </tr>
                    <?php $total_price=0;
						if($order)foreach($order as $list){?>
                    <tr style="border-bottom:1px solid #DDDDDD;">
                        <td style="padding-left:10px;"><?php echo find('name',$list['product_id'],'product_tb');?> <span>Size : <?php echo find('size',$list['sku_id'],'sku_tb')?></span></td>
                        <td align="center"><?php echo $list['quantity'] ?></td>
                        <td align="right" style="padding:0 5px;"><?php echo money($list['msrp']);?></td>
                        <td align="right" style="padding:0 5px;"><?php echo money($list['msrp']*$list['quantity']);?></td>
                        <td align="right" style="padding:0 5px;"><?php if ($list['discount_price']!=0) echo '('.money($list['discount_price']).')';else echo '-';?></td>
                        <td align="right" style="padding-right:0 5px;"><?php echo money($list['total']);?></td>
                        <?php 
								$total_price+=$list['total'];
						?>
                    </tr>
                    <?php } ?>
                    <tr class="grandTotalMbl">
                    	<td colspan="6" class="row1">
                        <div class="grandTotalLeft">Total</div>
                        <div class="grandTotalRight"><?php echo money($total_price);?></div>
                        </td>
                    </tr>
                    <?php if($shipping['discount_price']!=0){?>
                    <tr class="grandTotalMbl">
                    	<td colspan="6" class="row1">
                        <div class="grandTotalLeft">Discount</div>
                        <div class="grandTotalRight"><?php echo money($shipping['discount_price']);?></div>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr class="grandTotalMbl">
                        <td colspan="6" class="row1">
                        <div class="grandTotalLeft">Shipping Cost</div>
                        <div class="grandTotalRight"><?php echo ($shipping['shipping_cost']==0)?"FREE":money($shipping['shipping_cost']);?></div>
                        </td>
                    </tr>
					<tr class="grandTotalMbl">
                        <td colspan="6" class="row1">
                        <div class="grandTotalLeft">Grand Total</div>
                        <div class="grandTotalRight"><?php echo money($total_price + $shipping['shipping_cost'] - $shipping['discount_price']);?></div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="shippingOrder">
            	<h2>Shipping Address</h2>
                <table>
                    <tr>
                        <td colspan="5">
                            <div class="shippingOrderLeft">Recipient Name:</div>
                            <div class="shippingOrderRight"><?php echo $shipping['recipient_name'];?></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <div class="shippingOrderLeft">Address:</div>
                            <div class="shippingOrderRight">
								<?php echo nl2br($shipping['shipping_address']);?><br />
                                <?php echo $shipping['city_name'].', '.$shipping['province_name'];?><br />
                                <?php echo $shipping['zipcode']?>
                           </div>
                        </td>
                    </tr>
                </table>
            </div>
            <a href="<?php echo site_url('my_order');?>" class="orangeBtn">Back to My Order List</a>
            <?php if($shipping['bank']=='' && $shipping['payment_type']==1){?>
            	<a href="<?php echo site_url('my_order/confirm_payment/'.$shipping['id']);?>" class="orangeBtn">Confirm Payment</a>        		
			<?php }?>
		</div> 
    </div>
</div>