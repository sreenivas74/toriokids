<div id="content">
<h2>Order List (Bank Transfer)</h2>

<?php if($order!=""){?>
<table class="defAdminTable" width="100%">
	<thead>
    	<tr>
            <th width="2%">No</th>
            <th width="10%">Action</th>
            <th width="15%">Order Number</th>
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
    <td valign="top"><a href="<?php echo site_url('torioadmin/order/detail').'/'.$list['id'];?>">Detail</a> | <a href="<?php echo site_url('torioadmin/order/download_order').'/'.$list['id'];?>">PDF</a> </td>
    <td valign="top"><?php echo $list['order_number'];?></td>
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