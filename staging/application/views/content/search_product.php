<section>
            <div class="contentWrapper">
                <div class="mainWrapper nobanner">
                    <div class="productWrapper">
                        <h4><?php echo $page_title ?></h4>
                        
                        <div class="productBox">
                            <?php if($product)foreach($product as $pro){?>
                            <?php $sale_id=0; if($sale_array){ 
                                    foreach($sale_array as $sale){ 
                                        if($sale['product_id']==$pro['id'])
                                        { 
                                            $sale_id=$sale['flash_sale_id'];
                                        }
                                    }
                            }?>
                            <div class="productPanel">
                                <?php if(!$sale_array){?>
                                            <?php if($pro['sale_product']==1 && $pro['discount']>0 && $schedule_sale){?>
                                            <div class="saleTag">
                                                <p><span class="disc"><?php echo round($pro['discount'])?></span>%<br><span>OFF</span></p>
                                            </div>
                                            <?php }?>
                                <?php }?>
                                <div class="productImage">
                                    <a href="<?php echo site_url('product/view_product_detail'.'/'.$pro['alias'])?>"  title="<?php echo $pro['name'];?>"><img src="<?php echo base_url();?>userdata/product/<?php echo find_2_prec('image', 'product_id', $pro['id'], 'product_image_tb');?>" alt="<?php echo $pro['name'];?>"/></a>
                                </div>
                                <div class="productDesc">
                                    <a href="<?php echo site_url('product/view_product_detail'.'/'.$pro['alias'])?>" title="<?php echo $pro['name'];?>"><span class="productName"><?php echo $pro['name'];?></span></a>
                                    <?php if($sale_id==0){?>
                                        <?php 
                                        if($pro['msrp']>$pro['price'] && $schedule_sale){?>            
                                        <span class="productPrice"><?php echo money($pro['price']);?></span>
                                        <span class="productPrice normal"><?php echo money($pro['msrp']);?></span>
                                        <?php }else{?>
                                        <span class="productPrice"><?php echo money($pro['msrp']);?></span>
                                        <?php }?>
                                    <?php }else{?>
                                        <?php $percentage = find('percentage',$sale_id,'flash_sale_tb'); ?>
                                        <span class="productPrice"><?php echo money($pro['msrp']-($pro['msrp']*$percentage/100));?></span>
                                        <span class="productPrice normal"><?php echo money($pro['msrp']);?></span>
                                    <?php }?>
                                    <span class="productInfo"><?php echo $pro['template_name']?></span>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        
                    </div>
                </div>

             <!-- <div class="mediaBox">
                    <div class="subscribeBox">
                        <input placeholder="Sign Up Your Email &amp; Get Updates">
                        <a href="#" class="subscribeBtn">SUBSCRIBE</a>
                    </div>
                    <div class="fbLink">
                        <p>Get Connected with Us</p>
                        <a href="#" class="facebookBtn">Facebook</a>
                    </div>
                </div> -->
                <div class="storepartnerSection">
                    <p>Find Out the Quality of Torio Kids at</p>
                    <div class="storeList">
                        <ul>
                            <?php if($store)foreach ($store as $list) { ?>
                            <li><a <?php if($list['link']){ ?>href="<?php echo $list['link'] ?>"<?php } ?>><img src="<?php echo base_url() ?>/userdata/e-store/<?php echo $list['image'] ?>"></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <!-- <div class="directChannel"><a href="#" class="orangeLink">Find Out Our Direct Channel</a></div> -->
                    <p>Our Products are also Available at</p>
                    <div class="partnerList">
                        <ul>
                            <?php if($channel) foreach ($channel as $a) { ?>
                            <li><a href="<?php echo $a['link'] ?>" target="_blank"><img src="<?php echo base_url() ?>/userdata/e-channel/<?php echo $a['image'] ?>"></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <script>
    $('#clear').click(function(){
       $('.optionTab').removeAttr('checked'); 
    }); 
</script>