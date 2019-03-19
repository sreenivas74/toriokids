<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Order Detail</title>
<style>

	.container{
		width:660px;
		display:block;
		overflow:hidden;
		border-radius:20px;
		margin:20px;
		text-align:center;
	}
	.myOrderDetail table{
			width:660px;
		}
		.myOrderDetail table tr{text-align:left;}
			.myOrderDetail table tr td{
				padding:10px 0;
			}
			.myOrderDetail table tr td span{display:block;}
			.myOrder table tr td a:hover{
				color:#716558;
				text-decoration:underline;
			}
			.row1{
				background:#4D4D4D;
				color:#FFF;
				padding:0;
			}
	.shippingOrder{
				width:640px;
				display:block;
				overflow:hidden;
				text-align:left;
				font-size:16px;
				padding:10px 10px 0;
			}
				.shippingOrder table{
					width:660px;
					display:block;
					margin-top:20px;
				}
					.shippingOrder table tr td{
						padding:10px 0;
						border-bottom:1px solid #DDDDDD;				
					}
					.shippingOrderLeft{
						width:150px;
						text-align:left;
						font-weight:bold;
						float:left;
						font-size:12px;
						padding-left:10px;
					}
					.shippingOrderRight{
						width:500px;
						float:right;
						text-align:left;
						font-size:12px;
					}
	.grandTotalLeft{
		width:420px;
		display:block;
		float:left;
		text-align:right;
		text-transform:uppercase;
		background:#4D4D4D;
		font-size:18px;
	}
	.grandTotalRight{
		display:block;
		overflow:hidden;
		float:right;
		font-size:18px;
		padding-right:20px;
	}
	.myOrderDetail{
			width:100%;
			margin:0;
			font-family:'VarelaRoundRegular', Arial, Helvetica, sans-serif;
		}
</style>
</head>
<body onload="window.print();setTimeout('window.close()', 10);" style="color:black;font-size:14px; font-family:'Times New Roman', Times, serif;">
<div class="container">
    <h2 style="text-align:left;color:#333"><b>ORDER DETAIL</b></h2>
    <h4 style="text-align:left;color:#333">Order Invoice #<?php echo $shipping['order_number'];?></h4>
    <h4 style="text-align:left;color:#333">Order Date: <?php echo date("d F Y",strtotime($shipping['transaction_date']));?></h4>
    <div class="myOrderDetail">
        <table>
            <tr class="row1">
                <td width="260px" style="padding-left:20px;">Product Name</td>
                <td width="50px" align="center">Quantity</td>
                <td align="center" style="padding-right:20px;">Unit Price</td>
                <td align="center" style="padding-right:20px;">Subtotal</td>
                <td align="center" style="padding-right:20px;">Discount</td>
                <td align="center" style="padding-right:20px;">Total</td>
            </tr>
            <?php $total_price=0;
                if($order)foreach($order as $list){?>
            <tr style="border-bottom:1px solid #DDDDDD;">
                <td style="padding-left:20px;"><?php echo $list['name'];?></td>
                <td align="center"><?php echo $list['quantity'] ?></td>
                <td align="right" style="padding-right:20px;"><?php echo money($list['msrp']);?></td>
                <td align="right" style="padding-right:20px;"><?php echo money($list['msrp']*$list['quantity']);?></td>
                <td align="right" style="padding-right:20px;"><?php if ($list['discount_price']!=0) echo '('.money($list['discount_price']).')';else echo '-';?></td>
                <td align="right" style="padding-right:20px;"><?php echo money($list['total']);?></td>
                <?php 
                        $total_price+=$list['total'];
                ?>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="6" class="row1">
                <div class="grandTotalLeft">Total</div>
                <div class="grandTotalRight"><?php echo money($total_price);?></div>
                </td>
            </tr>
            <?php if($shipping['discount_price']!=0){?>
            <tr>
                <td colspan="6" class="row1">
                <div class="grandTotalLeft">Discount <?php $discount=(($shipping['discount_price']/$total_price)*100); echo $discount."%";?></div>
                <div class="grandTotalRight"><?php echo money($shipping['discount_price']);?></div>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="6" class="row1">
                <div class="grandTotalLeft">Shipping Cost</div>
                <div class="grandTotalRight"><?php echo money($shipping['shipping_cost']);?></div>
                </td>
            </tr>
            <tr>
                <td colspan="6" class="row1">
                <div class="grandTotalLeft">Grand Total</div>
                <div class="grandTotalRight"><?php echo money($total_price + $shipping['shipping_cost'] - $shipping['discount_price']);?></div>
                </td>
            </tr>
        </table>
    </div>
    <div class="shippingOrder">
        <h2 style="text-align:left;color:#333">Shipping Address</h2>
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
                        <?php /*?><?php echo find('name', $shipping['province'], 'jne_province_tb');?><br /><?php */?>
                        <?php echo api_city_name($shipping['city']).", ".api_province_name($shipping['province']);?><br />
                        <?php echo $shipping['zipcode']?>
                   </div>
                </td>
            </tr>
        </table>
	</div>
</div>
</body>
</html>