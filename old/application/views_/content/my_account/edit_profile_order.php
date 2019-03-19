
<?php $this->load->view('content/my_account/my_account_menu');?>
<div class="editContainer">
    <div class="noBg">
    <a href="<?php echo site_url('home');?>">Home </a>&gt;<a  href="<?php echo site_url('my_account');?>"> My Account </a>&gt;<a class="selectedBreadCrumb"> My Order</a>
    </div>
    <div class="editAccCon">
        <div class="editAccBox">
            <h2>My Orders</h2>        
            <div class="myOrder"><?php if(isset($_SESSION['confirm'])){?><div class="messageCon"><p>Your payment confirmation has been successfully sent.</p></div><br/><?php $_SESSION['confirm']=NULL;} ?>
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
                        <td><a href="<?php echo site_url('my_order/detail/'.$list['id'])?>" title="View Detail">#<?php echo $list['order_number'];?></a></td>
                        <td><?php echo display_date_full_admin($list['transaction_date']);?></td>
                        <td><?php echo money($list['total']+$list['shipping_cost']-$list['discount_price']);?></td>
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
                        <a href="<?php echo site_url('my_order/confirm_payment/'.$list['id'])?>">Confirm Payment</a>  |
                        <?php } ?><a href="<?php echo site_url('my_order/detail/'.$list['id'])?>">Detail</a></td>
                    </tr>
                    <?php }else{?>
                   
                    <tr>
                        <td colspan="5" class="row1">You don't have any order yet</td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div> 
    </div>
</div>