<section>
        	<div class="contentWrapper">
                <div class="mainWrapper banner">
                	<div class="banner">
                    	<img src="<?php echo base_url() ?>userdata/about_us/<?php echo $banner['image'] ?>">
                        <h1><?php echo $banner['title'] ?></h1>
                    </div>
                    <div class="aboutusWrapper">

                        <?php if($about)foreach ($about as $list) { ?> 
                        <?php if($list['position']==1){ $class="Right"; }else{ $class="Left"; } ?>  
                    	<div class="aboutusPanel">
                        	<div class="aboutusBox">
                            	<div class="contentElement">
                                    <div class="wrap<?php echo $class ?>">
                                        <img src="<?php echo base_url() ?>userdata/about_us/<?php echo $list['image'] ?>">
                                    </div>
                                    <h3><?php echo $list['title'] ?></h3>
                                    <p><?php echo $list['description'] ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="aboutusPanel">
                            <?php if($point)foreach ($point as $a) { ?> 
                        	<div class="aboutuspoinBox">
                            	<div class="aboutusPoin">
                                	<div class="contentElement">
                                        <img src="<?php echo base_url() ?>userdata/about_us/<?php echo $a['image'] ?>">
                                        <h3><?php echo $a['title'] ?></h3>
                                        <p><?php echo $a['description'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
</section>