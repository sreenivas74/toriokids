<div id="content">
<h2>Order &raquo; Detail</h2>
<div id="submenu">
    <ul>
        <li><a class="defBtn" href="<?php echo site_url('torioadmin/order');?>"><span>Back</span></a> <?php if($detail['status']==0 and $detail['payment_type']==1){?><a class="defBtn" href="<?php echo site_url('torioadmin/order/send_reminder').'/'.$detail['id'];?>" onclick="return confirm('Send reminder?');"><span>Send Reminder</span></a><?php }?> 
        </li>
    </ul>
</div>
<table class="defAdminTable" width="100%">
	<tbody>
        <tr>
        	<td>Order Number</td>
            <td><?php echo $detail['order_number'];?></td>
        </tr>
        <tr>
        	<td>Transaction ID</td>
            <td><?php if($detail['transidmerchant'])echo $detail['transidmerchant'];?></td>
        </tr>
        <tr>
        	<td>Order Date</td>
            <td><?php echo date("d F Y",strtotime($detail['transaction_date']));?></td>
        </tr>
        <tr>
        	<td>Order Status</td>
            <td>
				<?php 
                   /* if($detail['status']==0)echo "Pending";
                    else if($detail['status']==1)echo "Processed";*/
				?>
                
                <form id="order_form" method="post" action="#" onsubmit="return false;">
                	<input type="hidden" name="order_id" value="<?php echo $detail['order_number'];?>"  />
                    <input type="hidden" name="id" value="<?php echo $detail['id'];?>"  />
<input type="hidden" name="email_stamps" value="<?php echo find('email',$detail['user_id'],'user_tb');?>" />
<input type="hidden" name="grand_total" value="<?php echo $detail['total']-$detail['discount_price']+$detail['shipping_cost'];?>" />
                	<select name="status_id">
                    	<option value="0" <?php if($detail['status']==0)echo "selected=\"selected\"";?>>Pending</option>
                    	<option value="1" <?php if($detail['status']==1)echo "selected=\"selected\"";?>>Processed</option>
                    	<option value="4" <?php if($detail['status']==4)echo "selected=\"selected\"";?>>Shipped</option>
                    	<option value="2" <?php if($detail['status']==2)echo "selected=\"selected\"";?>>Delivered</option>
                    	<option value="3" <?php if($detail['status']==3)echo "selected=\"selected\"";?>>Cancelled</option>
                    </select>
                    <input type="button" value="Change Status" class="defBtn" onclick="confirm_payment();" />
                </form>
                <script>
					function confirm_payment(){
						if(confirm('Change order status')==1){
							$("#order_form").attr('action','<?php echo site_url('torioadmin/order/update_order_status');?>');
							$("#order_form").removeAttr('onsubmit');
							$("#order_form").submit();
						}
						else {
							return false;
						}
					}
				</script>
            </td>
        </tr>
        <tr>
        	<td>Payment Type</td>
            <td><?php if($detail['payment_type']==1) echo "Bank Transfer"; else echo "Credit Card"?></td>
        </tr>
    	<tr>
        	<td>User Name</td>
            <td><?php echo find('full_name',$detail['user_id'],'user_tb');?></td>
        </tr>
        <tr>
        	<td>Recipient Name</td>
            <td> <?php echo $detail['recipient_name'];?></td>
        </tr>
        <tr>
        	<td>Phone</td>
            <td><?php echo $detail['phone'];?></td>
        </tr>
        <tr>
        	<td>Shipping Address</td>
            <td><?php echo nl2br($detail['shipping_address']);?></td>
        </tr>
        <tr>
        	<td>Zipcode</td>
            <td><?php echo $detail['zipcode'];?></td>
        </tr>
        <tr>
        	<td>City</td>
            <td><?php if($detail['city']){?><?php echo find('name', $detail['city'], 'jne_city_tb');?><?php }else {?><?php }?></td>
        </tr>
        <?php /*?><tr>
        	<td>Shipping Cost</td>
            <td><?php echo money($detail['shipping_cost']);?><?php /*?><form name="shipping_cost_form" id="shipping_cost_form" method="post" action="<?php echo site_url('torioadmin/order/update_shipping_cost');?>" >
    <input type="hidden" name="order_id" id="order_id" value="<?php echo $detail['id'];?>"  />
 	<input class="txtField" type="text" name="shipping_cost" id="shipping_cost" value="<?php echo $detail['shipping_cost'];?>"  />
    <input type="submit" class="defBtn" value="Submit"/>
    </form><?php </td>
        </tr><?php */?>
        <tr>
        	<td>Total</td>
            <td><?php echo money($detail['total']);?></td>
        </tr>
        <?php if($detail['discount_price']>0){?>
        <tr>
        	<td>Discount <?php $discount=(($detail['discount_price']/$detail['total'])*100); echo $discount."%";?></td>
            <td><?php echo money($detail['discount_price']);?></td>
        </tr>
        <?php }?>
        <tr>
        	<td>Shipping Cost</td>
            <td><?php echo money($detail['shipping_cost']);?></td>
        </tr>
        <tr>
        	<td>Grand Total</td>
            <td><?php echo money($detail['total']-$detail['discount_price']+$detail['shipping_cost']);?></td>
        </tr>
    </tbody>
</table>
<?php /*if($detail['payment_type']==1 && $detail['status']==0){?>
<div id="submenu">
    <ul>
        <li><a class="defBtn" href="<?php echo site_url('torioadmin/order/confirm_payment_bank_transfer')."/".$detail['id'];?>" onclick="return confirm('Are You sure to confirm this payment?');"><span>Confirm Payment</span></a></li>
    </ul>
</div>
<?php } */?>
<?php /*?><div id="submenu">
    <ul>
        <li><a class="defBtn edit_btn" href="#" id="edit_order_item"><span>Edit</span></a><a class="defBtn edit_btn" style="display:none;" href="#" id="cancel_edit_order_item"><span>Cancel</span></a> <a class="defBtn" href="<?php echo site_url('torioadmin/order/recalculate/'.$detail['id']) ?>"><span>Recalculate</span></a><a class="defBtn" href="<?php echo site_url('torioadmin/order/email_message/'.$detail['id']) ?>"><span>Email</span></a></li>
    </ul>
</div>
<br /><?php */?>
<script type="text/javascript">
	
$(".edit_btn").click(function(){
	$("#cancel_edit_order_item").toggle();
	$("#edit_order_item").toggle();
	$(".form_row").toggle();	
	$(".form_data").toggle();
	$("#td_submit").toggle();
	return false;
});

function update_total(no){
	var price=parseInt($("#price_"+no).val());
	var quantity=parseInt($("#quantity_"+no).val());
	
	var total=price*quantity;
	$("#total_"+no).val(total);
		
}
function update_ppi(no)
{
	var total=parseInt($("#total_"+no).val());
	var quantity=parseInt($("#quantity_"+no).val());
	
	var price=total/quantity;
	$("#price_"+no).val(price);
}
$('#dob').datepicker({
		numberOfMonths: 1,
		showButtonPanel: true,
		yearRange: "-80:+80",
		changeYear: true,
		dateFormat: "yy-mm-dd",
		minDate: "-80y"
	});
</script>
<h2>Order &raquo; Item</h2>

<form name="order_item_form" id="order_item_form" method="post" action="<?php echo site_url('torioadmin/order/update_order_item');?>" >
<input type="hidden" name="order_id" value="<?php echo $detail['id'];?>" />
<table class="defAdminTable" width="100%">
	<thead>
    	<tr>
            <th width="4%">No</th>
            <th width="20%">Product</th>
            <th width="10%">Size</th>
            <th width="20%">MSRP Price</th>
            <th width="5%">Quantity</th>
            <th width="15%">Subtotal</th>
            <th width="15%">Discount</th>
            <th width="15%">Total</th>
            <?php /*?><th width="15%">Delivery Time</th><?php */?>
        </tr>
    </thead>
    <tbody>
<?php 
$no=1; 
if($item){
	foreach($item as $list){
	//$price=($list['discount_price']>0)?$list['discount_price']:$list['price'];
	$price=$list['price'];
	$subtotal=$price*$list['quantity'];
	$total=$list['price']*$list['quantity'];
	?>
    <tr class="form_data">	
        <td valign="top"><?php echo $no;?></td>
        <td valign="top"><?php echo find('name',$list['product_id'],'product_tb');?></td>
       	<td valign="top" align="right"><?php echo find('size',$list['sku_id'],'sku_tb')?></td>
        <td valign="top" align="right"><?php echo money($price);?></td>      
        <td valign="top" align="right"><?php echo $list['quantity'];?></td>
        <td valign="top" align="right"><?php echo money($subtotal);?></td>
        <td valign="top" align="right"><?php echo "(".money($list['discount_price']).")";?></td>
        <?php if($detail['status']!='-1'){ ?>
        <td valign="top" align="right"><?php echo money($list['total']);?></td>
        <?php }else {?>
        <td valign="top" align="right"><?php echo "IDR 0,-";?></td>
		<?php }?>
        <?php /*?><td valign="top" align="right"><?php echo $list['delivery_time'];?></td> <?php */?>   
    </tr>
    
    <?php $no++; }
	$no=1;
	foreach($item as $list){
	//$price=($list['discount_price']>0)?$list['discount_price']:$list['price'];
	$price=$list['price']+$list['discount_price'];
	$subtotal=$price*$list['quantity'];
	$total=$list['price']*$list['quantity'];
	?>
    <tr class="form_row" style="display:none;">	
        <td valign="top"><?php echo $no;?></td>
        <td valign="top"><?php echo find('name',$list['product_id'],'product_tb');?></td> 
        <td valign="top" align="right"><?php echo find('size',$list['sku_id'],'sku_tb')?></td>
        <td valign="top" align="right"><?php echo "IDR ";?><input type="text" name="price_<?php echo $list['id'];?>" id="price_<?php echo $list['id'];?>" value="<?php echo $price;?>" onchange="update_total(<?php  echo $list['id']; ?>)"  /></td>
        <td align="right"><input type="text" name="quantity_<?php echo $list['id'];?>" id="quantity_<?php echo $list['id'];?>" value="<?php echo $list['quantity'];?>" onChange="update_total(<?php echo $list['id'];?>);" /></td>
        <td valign="top" align="right"><?php echo money($subtotal);?></td>
        <td valign="top" align="right"><?php echo "(".money($list['discount_price']).")";?></td>
        <td align="right"><input type="text" name="total_<?php echo $list['id'];?>" id="total_<?php echo $list['id'];?>" value="<?php echo $total;?>" onchange="update_ppi(<?php echo $list['id'];?>)"/></td>     
        <input type="hidden" name="order_item_id[]" id="order_item_id" value="<?php echo $list['id'];?>"  />
         <td align="right"><input type="text" name="delivery_time_<?php echo $list['id'];?>" id="delivery_time_<?php echo $list['id'];?>" value="<?php echo $list['delivery_time'];?>"/></td>   
    </tr>
    
    <?php $no++; }?>
            <tr id="td_submit" style="display:none;">
            	<td colspan="9"><input type="submit" class="defBtn" id="order_item_submit" value="Save" /></td>
            </tr>
<?php }
?>   
    </tbody>
</table>
</form>
</div>