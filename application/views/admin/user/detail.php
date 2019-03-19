<div id="content">
<?php if($user['full_name']){?><h2><?php echo $user['full_name'];?> &raquo; Detail</h2><?php }else {?><?php }?>
<div id="submenu">
    <ul>
        <li><a class="defBtn" href="<?php echo site_url('torioadmin/user/index/2');?>"><span>Back</span></a></li>
    </ul>
</div>
<?php if($user!=""){?>
    <table class="defAdminTable" width="100%">
        <tbody>
            <tr>
                <td>Name</td>
                <td><?php if($user['full_name']){?><?php echo $user['full_name'];?><?php }else {?><?php }?></td>
            </tr>
             <tr>
                <td>Stamps ID </td>
                <td><?php if($user['stamps_id']!='0'){?><?php echo $user['stamps_id'];?><?php }else { echo '-'?><?php }?></td>
            </tr>
            <tr>
                <td>Date of Birth</td>
                <td><?php if($user['date_of_birth']!='0000-00-00'){?><?php echo $user['date_of_birth'];?><?php }else {?><?php }?></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><?php if($user['address']){?><?php echo $user['address'];?><?php }else {?><?php }?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php if($user['email']){?><?php echo $user['email'];?><?php }else {?><?php }?></td>
            </tr>
            <?php /*?><tr>
                <td>Province</td>
                <td><?php if($user['province']){?><?php echo find('name', $user['province'], 'jne_province_tb');?><?php }else {?><?php }?></td>
            </tr><?php */?>
            <tr>
                <td>City</td>
                <td><?php if($user['city']){?><?php echo find('name', $user['city'], 'jne_city_tb');?><?php }else {?><?php }?></td>
            </tr>
            <tr>
                <td>Zipcode</td>
                <td><?php if($user['postcode']){?><?php echo $user['postcode'];?><?php }else {?><?php }?></td>
            </tr>
            <tr>
                <td>Telephone</td>
                <td> <?php if($user['telephone']){?><?php echo $user['telephone'];?><?php }else {?><?php }?></td>
            </tr>
            <tr>
                <td>Mobile</td>
                <td><?php if($user['mobile']){?><?php echo $user['mobile'];?><?php }else {?><?php }?></td>
            </tr>
            <tr>
                <td>Registration Date</td>
                <td><?php if($user['created_date'])echo date("d F y",strtotime($user['created_date']))?></td>
            </tr>
            <tr>
                <td>Last Login</td>
                <td><?php if($user['last_login']!='0000-00-00')echo date("d F y",strtotime($user['last_login']))?></td>
            </tr>
        </tbody>
    </table>
        <h2>Order History</h2>
      <table class="defAdminTable" width="100%">
	<thead>
    	<tr>
            <th width="2%">No</th>
            <th width="15%">Action</th>
            <th width="20%">Order Number</th>
            <th width="20%">User Name</th>
            <th width="15%">Total</th>
            <th width="15%">Transaction Date</th>
            <th width="15%">Status</th>
        </tr>
    </thead>
    <tbody>
<?php 
$no=1; 
if($order)foreach($order as $list){?>
    <tr>
    <td valign="top"><?php echo $no;?></td>
    <td valign="top"><a href="<?php echo site_url('torioadmin/order/detail').'/'.$list['id'];?>">Details</a> </td>
    <td valign="top"><?php echo $list['order_number'];?></td>
    <td valign="top"><?php echo find('full_name',$list['user_id'],'user_tb');?></td>     
    <td valign="top"><?php echo money($list['total']);?></td> 
    <td valign="top"><?php echo date("d F Y",strtotime($list['transaction_date']));?></td> 
    <td valign="top">
		<?php 
				if($list['status']==0)echo "Pending";
				else if($list['status']==1)echo "Processed";
        ?>    
    </td>
    </tr>
    <?php $no++; }?>
    </tbody>
</table>
<?php } else{ ?>
<?php }?>
</div>