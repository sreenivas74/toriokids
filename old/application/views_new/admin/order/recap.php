<script>
function cek()
{
	if($('#date_to').val()=='' ||$('#date').val()=='' ){alert('insert date');}
	else
	{
		$('#filter_recap').removeAttr("onSubmit").submit();
	}
}
</script>
<div id="content">
<h2>Recap List</h2>
<form name="filter_recap" id="filter_recap" method="post" action="<?php echo site_url('torioadmin/order/filter');?>" onSubmit="cek();return false;">
Filter by : 
    <select name="txtStatus" id="txtStatus">
        <option value="ALL" <?php status_selected($status,"") ?>>ALL</option>
        <option value="0" <?php status_selected($status,"0") ?>>Pending</option>
        <option value="1" <?php status_selected($status,"1") ?>>Processed</option>
        <option value="3" <?php status_selected($status,"3") ?>>Cancelled</option>
        <option value="2" <?php status_selected($status,"2") ?>>Delivered</option>
        <option value="4" <?php status_selected($status,"4") ?>>Shipped</option>
    </select>
 From <input class="date"  type="text" name="date" id="date" value="<?php if($from)echo $from; ?>"/> to  <input class="date"  type="text" name="date_to" id="date_to" value="<?php if($to)echo $to; ?>"/> <input type="submit" value="go"/>
<input type="submit" style="display:none;"/>
</form>
<?php if($recap!=""){?>
<table class="defAdminTable" width="100%">
	<thead>
    	<tr>
            <th width="2%">No</th>
            <th width="10%">Action</th>
            <th width="15%">Order Number</th>
            <th width="15%">Payment Type</th>
            <th width="20%">User Name</th>
            <th width="15%">Total</th>
            <th width="15%">Transaction Date</th>
            <th width="10%">Status</th>
        </tr>
    </thead>
    <tbody>
<?php 
$no=1; 
$total = 0 ; 
if($recap)foreach($recap as $list){?>
			 <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top"><a href="<?php echo site_url('torioadmin/order/detail').'/'.$list['id'];?>">Detail</a> </td>
                <td valign="top"><?php echo $list['order_number'];?></td>
    <td valign="top"><?php if($list['payment_type']==1) echo "Bank Transfer"; else echo "Credit Card<br>Transaction ID:[".$list['transidmerchant'].']'?></td>
                <td valign="top"><?php echo find('full_name',$list['user_id'],'user_tb');?></td>     
                <td valign="top"><?php echo money($list['total']-$list['discount_price']+$list['shipping_cost']);?></td> 
                <td valign="top"><?php echo date("d F Y",strtotime($list['transaction_date']));?></td> 
                <td valign="top">
                    <?php 
                        if($list['status']==0)echo "Pending";
                        else if($list['status']==1)echo "Processed";
                        else if($list['status']==2)echo "Delivered";
                        else if($list['status']==4)echo "Shipped";
                        else echo "Cancelled";
                    ?>
                </td>
            </tr>
                
                <?php $total += ($list['total']-$list['discount_price']+$list['shipping_cost']); $no++; 
	}?>
    </tbody>
</table>
<?php } else{ ?>
<?php }?>
total: <?php echo money($total)?>
</div>