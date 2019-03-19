<section>
            <div class="contentWrapper">
                <div class="mainWrapper nobanner">
                    <div class="productWrapper">
                        <h1><?php echo $cat['name'];?></h1>
                        <h4><?php echo $cat['description'];?></h4>
                        <br>
                        <div class="breadCrumb">
                            <ul>
                                <li><a href="#">SHOP</a></li>
                                <li><a href="#"><?php echo $cat['name'];?></a></li>
                                <li>ALL COLLECTIONS</li>
                            </ul>
                        </div>
                        <a href="#" class="filterslideBtn">Filter By</a>
                        <div class="filterBox">
                            <div class="filterWrapper">
                                <a href="#" class="mobilecloseBtn" onClick="hide_filter();">closebutton</a>
                                
                                <div class="categoryTab">
                                    <form method="get" id="formID" action="<?php echo site_url('product/filter'); ?>">
                                    <h4>Category</h4>
                                    <ul class="optionBox">
                                        <?php $no=0; if($sub_cat)foreach($sub_cat as $list){ ?>
                                        <li><input type="checkbox" value="<?php echo $list['id'] ?>" name="category[]" class="optionTab" id="category<?php echo $no ?>"><label for="category<?php echo $no ?>"><?php echo $list['name'] ?></label></li>
                                        <?php $no++; } ?>
                                        <input type="hidden" value="<?php echo $cat['name'] ?>" name="category_name" >
                                    </ul>
                                </div>
                                <div class="categoryTab">
                                    <h4>Size</h4>
                                    <ul class="optionBox">
                                        <?php $no=0; if($template)foreach($template as $temp){ ?>
                                        <li><input type="checkbox" value="<?php echo $temp['id'] ?>" name="size[]" class="optionTab" id="size<?php echo $no ?>"><label for="size<?php echo $no ?>"><?php echo $temp['name'] ?></label></li>
                                        <?php $no++; } ?>
                                    </ul>
                                </div>
                                <div class="categoryTab">
                                    <h4>Status</h4>
                                    <ul class="optionBox">
                                        <li><input type="checkbox" value="1" class="optionTab" name="new_arrival" id="status1"><label for="status1">NEW ARRIVAL</label></li>
                                        <li><input type="checkbox" value="1" class="optionTab" name="best_seller" id="status2"><label for="status2">BEST SELLER</label></li>
                                        <li><input type="checkbox" value="1" class="optionTab" name="sale" id="status3"><label for="status3">SALE</label></li>
                                    </ul>
                                </div>
                                <div class="filterbuttonBox">
                                    <a href="javascript:void(0)" id="submit" class="button">Apply Filter</a>
                                    <a href="javascript:void(0)" id="clear" class="button">Clear All</a>
                                    <br>
                                    <a href="#" onClick="hide_filter();return false;">Close</a>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
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
                                <?php }else{?>
                                        <?php if($sale_id!=0){?>
                                        <div class="saleTag">
                                                <p><span class="disc"><?php echo round(find('percentage',$sale_id,'flash_sale_tb'))?></span>%<br><span>OFF</span></p>
                                            </div>
                                        <?php } ?>
                                <?php } ?>
                                <div class="productImage">
                                    <a href="<?php echo site_url('product/view_product_detail'.'/'.$pro['alias'].'/'.$cat_id)?>"  title="<?php echo $pro['name'];?>"><img src="<?php echo base_url();?>userdata/product/<?php echo find_2_prec('image', 'product_id', $pro['id'], 'product_image_tb');?>" alt="<?php echo $pro['name'];?>"/></a>
                                </div>
                                <div class="productDesc">
                                    <a href="<?php echo site_url('product/view_product_detail'.'/'.$pro['alias'].'/'.$cat_id)?>" title="<?php echo $pro['name'];?>"><span class="productName"><?php echo $pro['name'];?></span></a>
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
                        <?php if($pagination){?>
                        <div class="pagingWrapper">
                            <ul>
                                <?php echo $pagination;?>
                            </ul>
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <!--<div class="mediaBox">
                    <div class="subscribeBox">
                        <input placeholder="Sign Up Your Email &amp; Get Updates">
                        <a href="#" class="subscribeBtn">SUBSCRIBE</a>
                    </div>
                    <div class="fbLink">
                        <p>Get Connected with Us</p>
                        <a href="#" class="facebookBtn">Facebook</a>
                    </div>
                </div>-->
                <div class="storechannelBtn">
                    <a href="<?php echo site_url('e_store') ?>">STORE</a>
                    <a href="<?php echo site_url('e_channel') ?>">E-CHANNEL</a>
                </div>
                <div class="storepartnerSection">
                    <p>Find Out the Quality of Torio Kids at</p>
                    <div class="storeList">
                        <!--<ul>
                            <li><a href="#"><img src="../userdata/iconsogo.png"></a></li>
                            <li><a href="#"><img src="../userdata/iconcentral.png"></a></li>
                            <li><a href="#"><img src="../userdata/iconlotte.png"></a></li>
                            <li><a href="#"><img src="../userdata/iconlotus.png"></a></li>
                            <li><a href="#"><img src="../userdata/iconaeonmall.png"></a></li>
                        </ul>-->
                        <ul>
                            <?php if($store_logo)foreach ($store_logo as $list) { ?>
                            <li><a <?php if($list['link']){ ?>href="<?php echo $list['link'] ?>"<?php } ?>><img src="<?php echo base_url() ?>/userdata/e-store_logo/<?php echo $list['image'] ?>"></a></li>
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