<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Torio Kids</title>
	<style type="text/css">
		.ExternalClass {width:100%;}
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
			line-height: 100%;
			}
		body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
		body {margin:0; padding:0;}
		table td {border-collapse:collapse;}
		
		p {margin:0; padding:0; margin-bottom:0;}
				
		h1, h2, h3, h4, h5, h6 {
		   color: black;
		   line-height: 100%;
		   }
		a, a:link {
		   color:#0071BC;
		   text-decoration: underline;
		   }
		body, #body_style {
			color:#000;
			font-family:Arial, Helvetica, sans-serif;
			font-size:12px;
		}
		h1, h2, h3, h4, h5, h6{
			color:#000;
		}
		a:visited { color: #0071BC; text-decoration: none}
		a:focus   { color: #0071BC; text-decoration: underline}
		a:hover   { color: #0071BC; text-decoration: underline}
	</style>
</head>
<body style="background:#FFF; color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px" 
alink="#ff9900" link="#ff9900" bgcolor="#FFF" text="#000000" yahoo="fix"> 

    <div id="body_style" style="padding:15px;"> 
    	
        <table cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" width="800" align="center" style="line-height:18px; padding:10px; border:5px solid #DBF291; background:#fff;">
        	<tr>
            	<td>
                    <a href="<?php echo base_url();?>"><img alt="Torio Kids." title="Torio Kids." src="<?php echo base_url();?>templates/images/logo.png" style="display:block; border:0; margin:10px 0 0;" /></a>
                </td>
            </tr>
            <tr>
            	<td style="border-bottom:1px solid #FCD400;">&nbsp;</td>
            </tr>
            <tr>
                <td><br>
                    <h1 style="margin:10px 0; color:#D4155B; font-size:18px;">Hi, <?php echo $user['full_name'];?>!</h1>
                    
                    <p style="margin:30px 0; font-size:12px;">
                    <?php if($order['status']==1){?>
                    Thank you for your payment, we are now preparing your order. Your item(s) will be delivered to your door within 2-3 business days.<br />
                    <?php }else{?>
                    Your order has been shipped. Your item(s) will be delivered to your door within 2-3 business days.<br/>
                    <?php }?>
                    Wishing you and your loved ones a wonderful day :)
                    <br /><br />
                    Below are the details of your order information:
                    </p>
                    
                    <h2 style="margin:10px 0; color:#333333; font-size:14px;">Order Invoice #<?php echo $order['order_number'];?></h2>
                    <h2 style="margin:10px 0; color:#333333; font-size:14px;">Order Date: <?php echo date('d F Y',strtotime($order['transaction_date']));?></h2>
                    
                    <?php if($order['status']!=1){?>
                    <div style="border:1px solid #000000; margin-bottom:10px;padding-left:10px;">
                        <h2 style="margin:10px 0; color:#333333; font-size:14px; border-bottom:1px solid #000000; display:inline-block; padding-bottom:5px;">Track Your Order</h2>
                        <p style="font-size:12px;margin-bottom:10px;">Your Tracking Number is <?php echo $order['no_resi']?>.<br>To track your order, click <a href="http://jne.co.id/" target="_blank">here</a> and input your tracking number on the form provided.</p>
                    </div>
                    <?php }?>
                    
                    
                    <table width="100%" style="font-size:11px; border:1px solid #4D4D4D;" cellpadding="10">
                        <thead style="font-size:13px; background:#4D4D4D; color:#fff;">
                            <tr>
                            	<th width="35px">No.</th>
                                <th>Item</th>
                                <th width="55px">Quantity</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                                <th>Discount</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                      
                        <?php $total_price=0; $no=1; $total_semua=0; 
								if($order_item)foreach($order_item as $list){?>
                            <tr align="center">
                            	<td style="border-bottom:1px solid #3e065a;"><?php echo $no;?></td>
                                <td style="border-bottom:1px solid #3e065a; text-align:left;"><?php if($list['sku_code']!='') echo '('.$list['sku_code'].') ' ?><?php echo $list['name'].' ('.$list['size'].')';?></td>
                                <td style="border-bottom:1px solid #3e065a;"><?php echo $list['quantity'];?></td>
                                <td style="border-bottom:1px solid #3e065a;"><?php echo money($list['msrp']);?></td>
                                <td style="border-bottom:1px solid #3e065a; text-align:right;"><?php echo money($list['msrp']*$list['quantity']);?></td>
                                <td style="border-bottom:1px solid #3e065a; text-align:right;">   <?php $diff=($list['quantity']*$list['msrp'])-$list['total'];if($diff<1)echo "-";else echo "(".money($diff).")"; ?></td>
                                <td style="border-bottom:1px solid #3e065a; text-align:right;"><?php echo money($list['total']);?></td>
                                <?php $total_price+=$list['total']?>
                                <?php ?>
                            
                            </tr>
                            <?php $no++;}?>
                            <tr style="font-size:13px; background:#4D4D4D; color:#fff;">
                                <td colspan="6" align="right"><b>Sub Total</b></td>
                                <td style="text-align:right;"><b><?php echo money($total_price);?></b></td>
                            </tr>
                            <?php if($order['discount_price']!=0){?>
                            <tr style="font-size:13px; background:#4D4D4D; color:#fff;">
                                <td colspan="6" align="right"><b>Discount <?php $discount=(($order['discount_price']/$total_price)*100); echo $discount."%";?></b></td>
                                <td style="text-align:right;"><b><?php echo money($order['discount_price']);?></b></td>
                            </tr>
                            <?php } ?>
                            <tr style="font-size:13px; background:#4D4D4D; color:#fff;">
                                <td colspan="6" align="right"><b>Shipping Cost</b></td>
                                <td style="text-align:right;"><b><?php if($order['shipping_cost']=='0'){ echo "FREE"; }else { echo money($order['shipping_cost']); }?></b></td>
                            </tr>
                            <tr style="font-size:13px; background:#4D4D4D; color:#fff;">
                                <td colspan="6" align="right"><b>Grand Total</b></td>
                                <td style="text-align:right;"><b><?php echo money($total_price + $order['shipping_cost'] - $order['discount_price']);?></b></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-top:20px;">
                    <h2 style="margin:10px 0; color:#333333; font-size:14px;">Shipping Information</h2>
                    
                    <table width="100%" style="margin:0px 0; font-size:12px; border:none;" cellpadding="5">
                    	<tr>
                            <td width="20%" style="font-weight:bold; background:#ddd;">Shipping Method:</td>
                            <?php $api = api_get_city($order['city']);
							
							/*$reg=find('regular_fee',$order['city'],'jne_city_tb'); 
							$exp=find('express_fee',$order['city'],'jne_city_tb');*/
							
							$reg = $api['regular_fee'];
							$exp = $api['express_fee'];
			
							$method=0; if($reg==$order['shipping_method_fee']) $method=0; 
							if($exp==$order['shipping_method_fee']) $method=1;  ?>
                            <td width="80%" style="background:#ddd;"><strong><?php if($method==0) echo "REGULAR"; if($method==1) echo "EXPRESS"; ?></strong></td>
                        </tr>
                        <tr>
                            <td width="20%" style="font-weight:bold; background:#ddd;">Recipient Name:</td>
                            <td width="80%" style="background:#ddd;"><strong><?php echo $order['recipient_name'];?></strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold; vertical-align:top; background:#ddd">Address:</td>
                            <td style="background:#ddd;">
                                <?php echo nl2br($order['shipping_address']);?><br />
								<?php /*?><?php echo find('name', $order['province'], 'jne_province_tb');?><br /><?php */?>
                                <?php echo $order['city_name'].", ".$order['province_name'];?><br />
                                <?php echo $order['zipcode']?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold; vertical-align:top; background:#ddd">Phone / Mobile:</td>
                            <td style="background:#ddd;"><strong><?php echo $order['phone'];?></strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-top:20px;">
                    <h2 style="margin:10px 0; color:#333333; font-size:14px;">Billing/Sender Information</h2>
                    
                    <table width="100%" style="margin:0px 0; font-size:12px; border:none;" cellpadding="5">
                        <tr>
                            <td width="20%" style="font-weight:bold; background:#ddd;">Name:</td>
                            <td width="80%" style="background:#ddd;"><strong><?php echo $user['full_name'];?></strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold; vertical-align:top; background:#ddd">Address:</td>
                            <td style="background:#ddd;">
                                 <?php echo nl2br($user['address']);?><br />
                                 <?php /*?><?php echo find('name', $user['province'], 'jne_province_tb');?><br /><?php */?>
                                 <?php if($user['city'] && $user['province']) echo api_city_name($user['city']).", ".api_province_name($user['province']);
								 else if($user['city'] && !$user['province']) echo api_city_name($user['city']);
								 else if(!$user['city'] && $user['province']) echo api_province_name($user['province'])?><br />
                                 <?php echo $user['postcode'];?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold; vertical-align:top; background:#ddd">Phone / Mobile:</td>
                            <td style="background:#ddd;"><strong><?php echo $user['telephone'];?></strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold; vertical-align:top; background:#ddd">Email:</td>
                            <td style="background:#ddd;"><strong><?php echo $user['email'];?></strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-top:20px;">
                	<?php if($order['payment_type']==1){?>
                	<h2 style="color:#333333; font-size:14px;">Payment method</h2>
                    <p style="margin-top:10px; font-size:12px;">Bank Transfer<br />
                    </p>
                    <br/><?php } ?>
                    <p style="font-size:12px;">For more information, please go to <a style="color:#9E005D;" href="<?php echo base_url();?>" target="_blank">toriokids.com</a></p>
                </td>
            </tr>
            <tr>
            	<td style="padding:40px 5px 20px; font-size:12px;">
                	Regards,
                    <br /><br />
                    <strong>Torio Kids</strong>
                </td>
            </tr>
           <tr>
                <td style="font-size:10px; padding:20px 20px; width:800px; height:100 px; vertical-align:top; display:table-cell; background:#DBF291; color:#A67C52;">
                    <a target ="_blank" style="float:left; margin:0 20px 0 0;" href="<?php echo base_url()?>"><img src="<?php echo base_url()?>templates/images/smallLogo.png" /></a><p align="right" style="line-height:28px;">&copy; <?php echo date("Y") ?> Torio Kids. All Rights Reserved.</p>
                </td>
            </tr>
        </table>
    </div> <!--end wrapper-->
</body>
</html>    