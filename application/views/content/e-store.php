<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper banner">
                	<div class="banner">
                    	<img src="<?php echo base_url() ?>/userdata/e-store/<?php echo $banner['image'] ?>">
                        <h1><?php echo $banner['title'] ?></h1>
                    </div>
                	<div class="storeWrapper">
                        <h3>Our STORE</h3>
                        <p>Torio telah hadir di berbagai tempat yang tersebar di mall Jakarta dan Tangerang </p>
                        <div class="storeBox">
                            <?php if($store)foreach ($store as $list) { ?>
                        	<div class="storePanel">
                            	<div class="storeImage">
                                	<img src="<?php base_url() ?>userdata/e-store/<?php echo $list['image'] ?>">
                                </div>
                                <span class="storeName"><?php echo $list['name'] ?></span>
                                <span><?php echo $list['address'] ?></span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>