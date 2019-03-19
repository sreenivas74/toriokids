<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<html xmlns="urnchemas-microsoft-comfficeffice" xmlns="urnchemas-microsoft-comffice:excel" xmlns="http://www.w3.org/TR/REC-html40"> 

<meta http-equiv=Content-Type content="text/html; charset=windows-1252"> 
<meta name=ProgId content=Excel.Sheet>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
Tanggal Order : <?php echo $detail['transaction_date'];?><br>
Invoice No : <?php echo $detail['order_number'];?><br><br>

    <table border="1" class="tableContent" width="100%">
        <thead>
            <tr>
              <th colspan="6" bgcolor="#999999"><b>Order Item(s)</b></th>
            </tr>
            <tr bgcolor="#CCCCCC">
              <th><b>No</b></th>
              <th><b>Product Name</b></th>
              <th><b>Option</b></th>
              <th><b>Qty</b></th>
              <th><b>Price/Unit</b></th>
              <th><b>Total</b></th>
            </tr>
            
        </thead>
        <tbody>
        <?php 
		$no=1; 
		$total_price=0;
		if($item){
			foreach($item as $list){
			$price=($list['discount_price']>0)?$list['discount_price']:$list['price'];
			$total=$price*$list['quantity'];
			?>
			<tr class="form_data">	
				<td valign="top" align="right"><?php echo $no;?></td>
				<td valign="top" align="right"><?php echo find('name',$list['product_id'],'product_tb');?></td>
				<td valign="top" align="right"><?php  if(find('name',$list['product_id'],'product_tb')){?><?php echo find('name',$list['product_id'],'product_tb');?><?php }else {?>&nbsp;<?php }?></td>      
				<td valign="top" align="right"><?php echo $list['quantity'];?></td>
                <td valign="top" align="right"><?php echo money($price);?></td>  
				<?php if(($list['status'])!='-1'){ ?>
				<td valign="top" align="right"><?php echo money($total);?></td>
				<?php }else {?>
				<td valign="top" align="right"><?php echo "IDR 0,-";?></td>
				<?php }?>  
                <?php $total_price+=$total;?> 
			</tr>
			<?php $no++; }?>
        <?php }?>
            <tr class="form_data">	
                
                <td valign="top" align="right" colspan="5" bgcolor="#CCCCCC">Grand Total</td>  
                <td valign="top" align="right" bgcolor="#99FF99"><?php echo money($total_price);?></td>     
            </tr>
        </tbody>
    </table><br>
    
    <table border="1" class="tableContent" width="50%">
        <thead>
        	<tr>
              <th colspan="4" bgcolor="#999999"><b>Shipping</b></th>
            </tr>
            <tr bgcolor="#CCCCCC">
              <th><b>Nama</b></th>
              <th><b>Alamat</b></th>
              <th><b>Telephone</b></th>
              <th><b>Hp</b></th>
            </tr>  
        </thead>
        <tbody>
			<tr class="form_data">	
				<td valign="top" align="right"><?php echo $detail['recipient_name'];?></td>
				<td valign="top" align="right"><?php echo $detail['shipping_address'];?></td>
                <?php 
				$phone = $detail['phone'];
				$phone1 = substr($phone,0,1);
				$phone2 = substr($phone,1);
				$mobilep = $detail['mobile'];
				$mobilep1 = substr($mobilep,0,1);
				$mobilep2 = substr($mobilep,1);
				?>
				<td valign="top" align="right"><?php if($phone1=='0'){ echo "62".$phone2; }else{ echo $phone;}?></td>      
				<td valign="top" align="right"><?php if($mobilep1=='0'){ echo "62".$mobilep2; }else{ echo $mobilep;}?></td>
			</tr>
			<tr class="form_data">	
                <td valign="top" align="right" colspan="3" bgcolor="#CCCCCC">Kirim Atas Nama:</td>  
                <td valign="top" align="right" bgcolor="#99FF99"><?php echo $detail['recipient_name'];?></td>     
            </tr>
        </tbody>
    </table><br>
    
    <table border="1" class="tableContent" width="50%">
        <thead>
            <tr>
              <th colspan="4" bgcolor="#999999"><b>Billing</b></th>
            </tr>
            <tr bgcolor="#CCCCCC">
              <th><b>Nama</b></th>
              <th><b>Alamat</b></th>
              <th><b>Telephone</b></th>
              <th><b>Hp</b></th>
            </tr>  
        </thead>
        <tbody>
			<tr class="form_data">	
				<td valign="top" align="right"><?php echo find('full_name',$detail['user_id'],'user_tb');?></td>
				<td valign="top" align="right">
				<?php echo nl2br(find('address',$detail['user_id'],'user_tb'));?><br />
                <?php $city=find('city',$detail['user_id'],'user_tb');
                echo find('name',$city,'jne_city_tb')?><br />
                <?php echo find('postcode',$detail['user_id'],'user_tb');?>
                </td>
                <?php 
				$telephone = find('telephone',$detail['user_id'],'user_tb');
				$telephone1 = substr($telephone,0,1);
				$telephone2 = substr($telephone,1);
				$mobile = find('mobile',$detail['user_id'],'user_tb');
				$mobile1 = substr($mobile,0,1);
				$mobile2 = substr($mobile,1);
				?>
                <td valign="top" align="right"><?php if($telephone1=='0'){ echo "62".$telephone2; }else{ echo $telephone;}?></td>      
				<td valign="top" align="right"><?php if($mobile1=='0'){ echo "62".$mobile2; }else{ echo $mobile;}?></td>
			</tr>
        </tbody>
    </table><br>
    
    <table border="1" class="tableContent" width="50%">
        <thead>   
            <tr>
              <th colspan="2" bgcolor="#999999"><b>Shipping</b></th>
            </tr> 
            <tr bgcolor="#CCCCCC">
              <th colspan="2"><b>Shipping Cost</b></th>
      
            </tr>  
        </thead>
        <tbody>
			<tr class="form_data">	
				<td valign="top" align="right" colspan="2" align="center"><?php if($detail['shipping_cost']==0){?><?php echo 'Free'?> <?php }else{?> <?php echo $detail['shipping_cost'] ?> <?php }?></td>
			</tr>
        </tbody>
    </table>
    </body>
    </html>