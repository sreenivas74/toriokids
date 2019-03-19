<section>
            <div class="contentWrapper">
                <div class="mainWrapper nobanner">
                    <div class="productWrapper">
                        <h1>SALE</h1>
                        <h4>All The Special Deals!</h4>
                        <br>
                        <div class="breadCrumb">
                            <ul>
                                <li><a href="#">SHOP</a></li>
                                <li><a href="#">SALE</a></li>
                                <li>ALL COLLECTIONS</li>
                            </ul>
                        </div>
                        <a href="#" class="filterslideBtn">Filter By</a>
                        <div class="filterBox">
                            <div class="filterWrapper">
                                <a href="#" class="mobilecloseBtn" onClick="hide_filter();">closebutton</a>
                                <div class="categoryTab">
                                    <form method="get" id="formID" action="<?php echo site_url('product/sale'); ?>">
                                    <h4>Category</h4>
                                    <?php if($category)foreach($category as $list){ echo $list['name'];?>
                                    <ul class="optionBox">
                                        <?php if($sub_category)foreach($sub_category as $slist){ 
                                        if($slist['category_id']==$list['id']){ ?>
                                        <li><input type="checkbox" value="<?php echo $slist['id'] ?>" name="sub_category[]" <?php if($sub_category2) foreach ($sub_category2 as $a) { if($slist['id']==$a){ echo "checked"; } }?> class="optionTab" id="category<?php echo $slist['id'] ?>"><label for="category<?php echo $slist['id'] ?>"><?php echo $slist['name'];?></label></li>
                                        <?php } } ?>
                                    </ul>
                                    <?php } ?>
                                </div>
                                <div class="categoryTab">
                                    <h4>Size</h4>
                                    <ul class="optionBox">
                                        <?php $no=0; if($template)foreach($template as $temp){ ?>
                                        <li><input type="checkbox" value="<?php echo $temp['id'] ?>" <?php if($size) foreach ($size as $s) { if($temp['id']==$s){ echo "checked"; } }?> name="size[]" class="optionTab" id="size<?php echo $no ?>"><label for="size<?php echo $no ?>"><?php echo $temp['name'] ?></label></li>
                                        <?php $no++; } ?>
                                    </ul>
                                </div>
                                <div class="categoryTab">
                                    <h4>Status</h4>
                                    <ul class="optionBox">
                                        <li><input type="checkbox" value="1" <?php if($new_arrival==1){ echo "checked"; } ?> name="new_arrival" class="optionTab" id="status1"><label for="status1">NEW ARRIVAL</label></li>
                                        <li><input type="checkbox" value="1" <?php if($best_seller==1){ echo "checked"; } ?> name="best_seller" class="optionTab" id="status2"><label for="status2">BEST SELLER</label></li>
                                        <li><input type="checkbox" value="1" <?php if($sale==1){ echo "checked"; } ?> name="sale" class="optionTab" id="status3"><label for="status3">SALE</label></li>
                                    </ul>
                                </div>
                                <div class="filterbuttonBox">
                                    <a href="javascript:void(0)" id="submit"  class="button">Apply Filter</a>
                                    <a href="javascript:void(0)" id="clear" class="button">Clear All</a>
                                    <br>
                                    <a href="#" onClick="hide_filter();return false;">Close</a>
                                </div>
                            </form>
                            </div>
                        </div>



                        <?php if(!$sale_array){ ?>
                            <?php if($product && $schedule_sale){?>
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
                                            <?php if($pro['sale_product']==1 && $pro['discount']>0){?>
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
                                            <?php if(!$sale_array){ ?>
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
                            <?php }else{ ?>
                            <br><br>
                            <h4>Currently there are no products in this category</h4>
                            <?php } ?>

                        <?php }else{ ?>

                        <?php if($product){?>
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
                                    <div class="productImage">
                                        <a href="<?php echo site_url('product/view_product_detail'.'/'.$pro['alias'])?>"  title="<?php echo $pro['name'];?>"><img src="<?php echo base_url();?>userdata/product/<?php echo find_2_prec('image', 'product_id', $pro['id'], 'product_image_tb');?>" alt="<?php echo $pro['name'];?>"/></a>
                                    </div>
                                    <div class="productDesc">
                                        <a href="<?php echo site_url('product/view_product_detail'.'/'.$pro['alias'])?>" title="<?php echo $pro['name'];?>"><span class="productName"><?php echo $pro['name'];?></span></a>
                                        <?php if(!$sale_array){ ?>
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
                        <?php }else{ ?>
                            <br><br>
                            <h4>Currently there are no products in this category</h4>
                        <?php } ?>

                        <?php } ?>





                    </div>
                </div>
            </div>
        </section>

        <script>
    $('#clear').click(function(){
       $('.optionTab').removeAttr('checked'); 
    }); 
</script>