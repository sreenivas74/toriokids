<html>
<header>
<title>Order PDF</title>
<style>
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td{margin:0;padding:0;}table{border-collapse:collapse;border-spacing:0;margin:0;padding:0;}fieldset,img{border:0;}address,caption,cite,code,dfn,em,strong,th,var{font-style:normal;font-weight:normal;}ol,ul {list-style:none;}caption,th {text-align:left;}h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal;}q:before,q:after{content:'';}abbr,acronym {border:0;}

body{
	font-family:'VarelaRoundRegular', Arial, Helvetica, sans-serif;
	font-size:11px;

}
.largerfont{
font-size:13px;	
}
	table{
		margin:0 0 10px;
	}
	table tr td{
		border:solid 1px #999;
		padding:5px;
		vertical-align:top;
	}
	table.noborder tr td{
		border:none;
		padding:5px;
		vertical-align:top;
	}
	table.withborder tr td{
		border:solid 1px #999;
		padding:5px;
		vertical-align:top;
	}
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
				
				text-decoration:underline;
			}
			.row1{
			
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
		width:200px;
		display:block;
		float:left;
		text-align:right;
		text-transform:uppercase;
		background:#4D4D4D;
		font-size:18px;
	}
	.grandTotalRight{
		width:240px;
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
</header>
<body id="pdf">
<table class="noborder">
    <tr>
	    <td><img src="<?php echo base_url()?>templates/images/logo.png"></td>
    </tr>
</table><br>
<br>
<table class="noborder largerfont">
    <tr>
    	<td><b>Order No</b></td>
   	  	<td>: <?php echo $shipping['order_number'];?></td>
    </tr>
    <tr>
    	<td><b>Order Date</b></td><td>: <?php echo date("d F Y",strtotime($shipping['transaction_date']));?></td>
    </tr>
</table><br>
<br>

<table width="100%" class="noborder">
    <tr>
        <td colspan="7"><h3>
          <div align="center">Thank You For Your Order</div></h3></td>
    </tr>
</table> 
<br>
<br>

<table width="100%">
    <tr>
        <td width="5%" align="center"><b>No</b></td>
        <td width="28%"><b>Product Name</b></td>
        <td width="7%" align="center"><b>Size</b></td>
        <td width="7%" align="center"><b>Quantity</b></td>
        <td width="14%" align="center"><b>Unit Price</b></td>
        <td width="15%" align="center"><b>Subtotal</b></td>
        <td width="14%" align="center"><b>Discount</b></td>
        <td width="17%" align="center"><b>Total</b></td>
    </tr>
	<?php 
    $no=1; 
    $total_price=0;
    if($order){
    foreach($order as $list){
  
	$price=$list['price'];
		$subtotal=$price*$list['quantity'];
    $total=$list['total'];
    ?>
    <tr>
        <td align="left"><?php echo $no?></td>
        <td align="left"><?php echo find('name',$list['product_id'],'product_tb');?></td>
        <td align="left"><?php echo find('size',$list['sku_id'],'sku_tb')?></td>
        <td align="center"><?php echo $list['quantity'] ?></td>
        <td align="right"><div align="right"><?php echo money($price);?></div></td>
        
            <td valign="top" align="right"><?php echo money($subtotal);?></td>
        <td align="right"><div align="right"><?php if ($list['discount_price']!=0) echo '('.money($list['discount_price']).')';else echo '-';?></div></td>
        <td align="right"><div align="right"><?php echo money($list['total']);?></div></td>
        <?php 
        $total_price+=$list['total'];
        ?>
    </tr>
	<?php $no++; }?>
    <?php }?>
    <tr>
        <td colspan="7">
        <div align="right"><b>Total</b></div> 
        </td>     
        <td>
        <div align="right"><?php echo money($total_price);?></div>
        </td>        
    </tr>
	<?php if($shipping['discount_price']!=0){?>
    <tr>
        <td colspan="7"><div align="right"><b>Discount</b></div></td>
        <td><div align="right"><?php echo money($shipping['discount_price']);?></div></td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="7"><div align="right"><b>Shipping Cost</b></div></td>     
        <td><div align="right"><?php echo ($shipping['shipping_cost']==0)?"FREE":money($shipping['shipping_cost']);?></div></td>        
    </tr>
    <tr>
        <td colspan="7"><div align="right"><b>Grand Total</b></div></td>     
        <td><div align="right"><?php echo money($total_price + $shipping['shipping_cost'] - $shipping['discount_price']);?></div></td>        
    </tr>	
</table>
<br>
<br>

<table width="100%" class="noborder">
    <tr>
        <td width="50%">
        	<div style="float:left;">
                <table width="100%" class="withborder">
                    <tr>
                        <td colspan="2"><div align="center"><b>Shipping Information</b></div></td>
                    </tr>
                    <tr>
                        <td><b>Name</b></td><td><?php echo $detail['recipient_name'];?></td>
                    </tr>
                    <tr>
                        <td><b>Address</b></td><td><?php echo nl2br($detail['shipping_address']);?><br>
                        <?php if($detail['city']){?><?php echo find('name', $detail['city'], 'jne_city_tb');?><?php }else {?><?php }?><br>
                        <?php echo $detail['zipcode'];?></td>
                    </tr>
                    <tr>
                    	<td><b>Phone</b></td><td><?php echo $detail['phone'];?></td>
                    </tr>
                    <tr>
                        <td><b>Mobile</b></td><td><?php echo $detail['mobile'];?></td>
                    </tr>
                </table>
            </div>
        </td>
        <td width="50%">
        	<div style="float:right;">
                <table width="100%" class="withborder">
                    <tr>
                        <td colspan="2"><div align="center"><b>Billing / Sender Information</b></div></td>
                    </tr>
                    <tr>
                        <td><b>Name</b></td><td><?php echo $sender_detail['full_name'];?></td>
                    </tr>
                    <tr>
                        <td><b>Address</b></td><td><?php echo nl2br($sender_detail['address']);?><br>
                    <?php if($detail['city']){?><?php echo find('name', $sender_detail['city'], 'jne_city_tb');?><?php }else {?><?php }?><br><?php echo $sender_detail['postcode'];?></td>
                    </tr>
                    <tr>
                        <td><b>Phone</b></td><td><?php echo $sender_detail['telephone'];?></td>
                    </tr>
                    <tr>    
                        <td><b>Mobile</b></td><td><?php echo $sender_detail['mobile'];?></td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%" class="noborder">
                <tr>
                    <td>Payment Method:<br></td>
                </tr>
                <tr>
                    <td><b><?php if ($detail['payment_type']==1)echo 'Bank Transfer';else echo 'Credit Card';?></b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>


</body>
</html>