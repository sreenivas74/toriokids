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

<table width="100%">
    <tr>
        <td width="10%"><b>Order Number</b></td>
        <td width="8%" align="center"><b>Order Date</b></td>
        <td width="7%" align="center"><b>Status</b></td>
        <td width="25%" align="center"><b>Product Name</b></td>
        <td width="14%" align="center"><b>Quantity</b></td>
        <td width="15%" align="center"><b>MSRP Price</b></td>
        <td width="14%" align="center"><b>Discounted Price</b></td>
        <td width="14%" align="center"><b>Total</b></td>
        <td width="17%" align="center"><b>City</b></td>
        <td width="17%" align="center"><b>Username</b></td>
         <td width="17%" align="center"><b>Recipient Name</b></td>
    </tr>
    <?php if($order_item_list)foreach($order_item_list as $list2){?>
    <tr>
    	<td><?php echo $list2['order_number'];?></td>
        <td><?php echo display_date($list2['transaction_date']);?></td>
        <td><?php if($list2['status']==0){echo 'Pending';}elseif($list2['status']==1){echo 'Processed';}elseif($list2['status']==2){echo 'Delivered';}elseif($list2['status']==3){echo 'Cancelled';}else echo'Shipped'; ?></td>
        <td><?php echo $list2['product_name']?></td>
        <td><?php echo $list2['quantity']?></td>
        <td><?php echo $list2['price']?></td>
        <td><?php echo $list2['discount_price']?></td>
        <td><?php echo $list2['total']?></td>
        <td><?php echo $list2['city_name']?></td>
        <td><?php echo $list2['full_name']?></td>
           <td><?php echo $list2['recipient_name']?></td>
    </tr>
    
    <?php } ?>
	
  
    
	
</table>
<br>
<br>




</body>
</html>