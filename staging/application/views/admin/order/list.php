<div id="content">
<h2>Order List</h2>
<form name="search_order" id="search_order" method="post" action="<?php echo site_url('torioadmin/order/search');?>">
search(order number, username) : <input type="text" name="keyword" id="keyword"/>
<input type="submit" style="display:none;"/>
</form>

<div id="submenu">
    <ul>
        <li><a class="defBtn" href="<?php echo site_url('torioadmin/order/export_excel');?>"><span>Download Order</span></a> 
        </li>
    </ul>
</div>

* (<span style="color:limegreen">Order Number</span>): email sent.

<?php if($order!=""){?>
<table class="defAdminTable" width="100%">
	<thead>
    	<tr>
            <th width="2%">No</th>
            <th width="16%">Action</th>
            <th width="15%">Order Number</th>
            <th width="20%">Payment Type</th>
            <th width="20%">User Name</th>
            <th width="20%">Recipient Name</th>
            <th width="15%">Total</th>
            <th width="15%">Transaction Date</th>
            <th width="10%">Status</th>
        </tr>
    </thead>
    <tbody>
<?php 
$no=1; 
if($order)foreach($order as $list){?>
    <tr>
    <td valign="top"><?php echo $no;?></td>
    <td valign="top"><a href="<?php echo site_url('torioadmin/order/detail').'/'.$list['id'];?>">Detail</a> | <a href="<?php echo site_url('torioadmin/order/download_order').'/'.$list['id'];?>">PDF</a> | <a href="<?php echo site_url('torioadmin/order/email'.'/'.$list['id']);?>">Email</a> </td>
    <td valign="top"><?php $check = check_email_sent($list['id']); if($check>0) echo "<span style='color:limegreen'>"; ?><?php echo $list['order_number'];?><?php if($check>0) echo "</span>"; ?></td>
    <td valign="top"><?php if($list['payment_type']==1) echo "Bank Transfer"; else echo "Credit Card<br>Transaction ID:[".$list['transidmerchant'].']'?></td>
    <td valign="top"><?php echo find('full_name',$list['user_id'],'user_tb');?></td>  
      <td valign="top"><?php echo $list['recipient_name'];?></td>     
    <td valign="top"><?php echo money($list['total']);?></td> 
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
    
    <?php $no++; }?>
    
    </tbody>
</table>
<?php } else{ ?>
<?php }?>
</div>