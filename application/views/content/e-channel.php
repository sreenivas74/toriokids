<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper banner">
                	<div class="banner">
                    	<img src="<?php echo base_url() ?>userdata/e-channel/<?php echo $banner['image'] ?>">
                        <h1><?php echo $banner['title'] ?></h1>
                    </div>
                	<div class="storeWrapper">
                        <h3>Our E-channel</h3>
                        <p>You can purchase Torio products from our e-commerce partners in Indonesia and overseas</p>
                        <div class="partnerList">
                            <ul>
                                <?php if($channel) foreach ($channel as $list) { ?>
                                <li><a href="<?php echo $list['link'] ?>" target="_blank"><img src="<?php echo base_url() ?>userdata/e-channel/<?php echo $list['image'] ?>"></a></li>
                                <?php  } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
</section>