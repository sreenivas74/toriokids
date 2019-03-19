<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="profileWrapper">
                    	<h3>my ORDERS</h3>
                        <?php $this->load->view('content/profile/my_profile_menu'); ?>
                        <div class="profileContent">
                            <table class="orderTable">
                            	<thead>
                                    <tr>
                                        <th>Order No.</th>
                                        <th>Order Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($order_user){ foreach ($order_user as $list) { ?>
                                    <tr>
                                        <td><a href="<?php echo site_url('my_order/detail/'.$list['id']) ?>"><?php echo $list['order_number'] ?></a></td>
                                        <td><?php echo date('d/m/Y', strtotime($list['transaction_date'])) ?></td>
                                        <td><?php echo money2($list['total']) ?></td>
                                        <?php if($list['status']==0){
                                                $status="Pending";
                                            } else if($list['status']==1){
                                                $status="Processed";
                                            } else if($list['status']==2){
                                                $status="Delivered";
                                            } else if($list['status']==3){
                                                $status="Canceled";
                                            } else if($list['status']==4){
                                                $status="Shipped";
                                            }
                                        ?>
                                        <td><?php echo $status ?></td>
                                        <td><a href="<?php echo site_url('my_order/detail/'.$list['id']) ?>">Details</a></td>
                                    </tr>
                                    <tr class="mobileorderBtn">
                                        <td><a href="<?php echo site_url('my_order/detail/'.$list['id']) ?>">DETAILS</a></td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr><td colspan="4">You Have No Transaction<td></tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>