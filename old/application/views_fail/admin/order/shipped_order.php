<div id="content">
<h2>Shipped Order</h2>
<table class="defAdminTable" width="100%">
	<thead>
    	<tr>
            <th width="2%">No</th>
            <th width="20%">Order Number</th>
            <th width="20%">User Name</th>
            <th width="15%">Total</th>
            <th width="15%">Transaction Date</th>
        </tr>
    </thead>
    <tbody>
<?php 
$no=1; 
if($recap)foreach($recap as $list2){?>
    <tr>
    <td valign="top"><?php echo $no;?></td>
    <td valign="top"><?php echo $list2['order_number'];?></td>
    <td valign="top"><?php echo find('full_name',$list2['user_id'],'user_tb');?></td>     
    <td valign="top"><?php echo money($list2['total']);?></td> 
    <td valign="top"><?php echo date("d F Y",strtotime($list2['transaction_date']));?></td> 
    </tr>
    <?php $no++;}?>
    </tbody>
</table>

</div>