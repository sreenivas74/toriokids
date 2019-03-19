

<?php $this->load->view('content/my_account/my_account_menu');?>
<div class="dashboardContainer">
	<?php $this->load->view('content/my_account/my_account_menu_mobile')?>
    <h3>Welcome, <?php echo $account['full_name'];?>!</h3>
    <div class="dashboardCon">
        <div class="dashboard">
            <div class="dashboardLeft">
                <h4>My Profile</h4>
                <span>Personal Information</span>
                <table>
                    <tr>
                        <td>Name:</td>
                        <td><?php echo $account['full_name'];?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?php echo $account['email'];?></td>
                    </tr>
                </table>
                <div class="bottom">
                    <a href="<?php echo site_url('my_account/view_profile');?>">View Profile</a> | <a href="<?php echo site_url('my_account/edit_profile');?>">Edit Profile</a> | <a href="<?php echo site_url('change_password');?>">Change Password</a>
                </div>
            </div>
            <div class="dashboardRight">
                <h4>Address Book</h4>
                <span>Default Shipping Address</span>
                <table>
                    <tr class="field7">
                        <td colspan="2"><?php if($shipping!=NULL && $shipping['shipping_address']!=""){?>Address: <?php echo $shipping['shipping_address'];?><?php }else{?><i>You have no shipping address yet</i><?php } ?></td>
                    </tr>
                </table>
                <div class="bottom">
                    <a href="<?php echo site_url('my_addresses');?>">View All Addresses</a> | <a href="<?php echo site_url('my_addresses/add');?>">Add a Shipping Address</a>
                </div>
            </div>
        </div>
        <div class="mainDashboard">
            <h4>Order History</h4>
            <div class="myOrder">
                <table>
                    <tr class="row1">
                        <td width="132">Order No.</td>
                        <td width="132">Order Date</td>
                        <td width="132">Order Total</td>
                        <td width="132">Status</td>
                        <td width="200">&nbsp;</td>
                    </tr>
                    <?php if($order_user)foreach($order_user as $list){?>
                    <tr style="border-bottom:1px solid #DDDDDD;">
                        <td><a href="<?php echo site_url('my_order/detail/'.$list['id'])?>">#<?php echo $list['order_number'];?></a></td>
                        <td><?php echo date("d F Y",strtotime($list['transaction_date'])) ?></td>
                        <td><?php echo money($list['total']);?></td>
                        <td>
							<?php 
                                if($list['status']==0)echo "Pending";
                                else if($list['status']==1)echo "Processed";
                                else if($list['status']==2)echo "Delivered";
                                else if($list['status']==4)echo "Shipped";
                                else echo "Cancelled";
                            ?>
                        </td>
                        <td>     <?php if($list['status']==0 and $list['bank']==''){?>
                        <a href="<?php echo site_url('my_order/confirm_payment/'.$list['id'])?>">Confirm Payment</a> 
                        <?php } ?><a href="<?php echo site_url('my_order/detail/'.$list['id'])?>">Details</a></td>
                    </tr>
                    <?php }?>
                    
                    <tr>
                        <td colspan="5" class="row1"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>