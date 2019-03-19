<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="profileWrapper">
                        <h3>ADDRESS BOOK</h3>
                        <?php $this->load->view('content/profile/my_profile_menu'); ?>
                        <div class="profileContent">
                            <?php if($address) foreach ($address as $list) { ?>
                        	<div class="addressRow">
                                <?php if($list['default_address']==1){ ?>
                                <p class="defaultAddress">Default Address</p>
                                <?php } ?>
                                <table class="addressTable">
                                    <tr>
                                        <td colspan="2" class="addressCategory"><?php echo $list['label'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td><?php echo $list['shipping_address'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Province</td>
                                        <td><?php echo find('name',$list['province'],'jne_province_tb') ?></td>
                                    </tr>
                                    <tr>
                                        <td>City</td>
                                        <td><?php echo find('name',$list['city'],'jne_city_tb') ?></td>
                                    </tr>
                                    <tr>
                                        <td>Zipcode</td>
                                        <td><?php echo $list['zipcode'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td><?php echo $list['phone'] ?></td>
                                    </tr>
                                </table>
                                <div class="addressBtn">
                                    <?php if($list['default_address']==1){ ?>
                                	<a href="<?php echo site_url('my_profile/edit_address').'/'.$list['id'] ?>">Edit address</a>
                                    <?php }else{ ?>
                                    <a href="<?php echo site_url('my_profile/do_set_default').'/'.$list['id'] ?>">Set as default</a> |
                                    <a href="<?php echo site_url('my_profile/edit_address').'/'.$list['id'] ?>">Edit address</a>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                            <a href="<?php echo site_url('my_profile/add_address') ?>" class="defBtn">add new address</a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>