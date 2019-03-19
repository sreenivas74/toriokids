<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="profileWrapper">
                    	<h3>my profile</h3>
                        <div class="mainProfile">
                        	<div class="userPP">
                            	<img <?php if($account['profile_picture']!=""){ ?> src="<?php echo base_url() ?>userdata/profile_picture/<?php echo $account['profile_picture'] ?>" <?php }?> >
                                <?php /* ?><a href="#" class="changePP">changepp</a><?php */ ?>
                            </div>
                            <div class="userData">
                            	<p class="userName"><?php echo $account['full_name'] ?></p>
                                <p><?php echo $account['email'] ?></p>
                                <p><?php echo $account['telephone'] ?></p>
                                <?php if($account['date_of_birth']!='0000-00-00'){ ?>
                            	<p><?php echo date('d F Y',strtotime($account['date_of_birth'])) ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <?php $this->load->view('content/profile/my_profile_menu'); ?>
                        <div class="profileContent mobilenone">
                        	<h4>Last Transaction</h4>
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
                                    </tr>
                                    <tr class="mobileorderBtn">
                                        <td><a href="<?php echo site_url('my_order/detail/'.$list['id']) ?>">DETAILS</a></td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr><td colspan="4">You Have No Transaction<td></tr>
                                    <?php } ?>
                                    
                                </tbody>
                            </table>
                            <h4>Default Address</h4>
                            <?php if($shipping){ ?>
                            <table class="addressTable">
                            	<tr>
                                	<td colspan="2" class="addressCategory"><?php echo $shipping['label'] ?></td>
                                </tr>
                                <tr>
                                	<td>Address</td>
                                    <td><?php echo $shipping['shipping_address'] ?></td>
                                </tr>
                                <tr>
                                	<td>Province</td>
                                    <td><?php echo find('name',$shipping['province'],'jne_province_tb') ?></td>
                                </tr>
                                <tr>
                                	<td>City</td>
                                    <td><?php echo find('name',$shipping['city'],'jne_city_tb') ?></td>
                                </tr>
                                <tr>
                                	<td>Zipcode</td>
                                    <td><?php echo $shipping['zipcode'] ?></td>
                                </tr>
                                <tr>
                                	<td>Phone</td>
                                    <td><?php echo $shipping['phone'] ?></td>
                                </tr>
                            </table>
                            <?php }else{ ?>
                            <p>No Address</p>
                            <?php } ?>
                            <a href="<?php echo site_url('my_profile/my_address') ?>" class="defBtn">See My Address Book</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>