 <script>
 function deletecart(id){
    $.ajax({
        type:"POST",
        url:base_url+'shopping_cart/delete_shopping_cart',
        data:{id:id},
        dataType:"JSON",
        success: function(temp){
            alert('produk di hapus');
            $("#cart_"+temp.cart_id).fadeOut(500),function(){
                $("#cart_"+temp.cart_id).remove();
            };
            var total = parseInt($('#total_cart').val()) - parseInt(temp.total);
            
            $('#total_cart').val(total);
            $('#cart_tot').html(addCommas(total));
        }
    });
 }

function changeClass(newElement, id){
    //alert(id);
    $("#sku_id_d").val(id);

}

 </script>
 <?php //for flash sale
        
        $sale_id=0; if($sale_array){ 
            foreach($sale_array as $sale){ 
                if($sale['product_id']==$product['id'])
                { 
                    $sale_id=$sale['flash_sale_id'];
                }
            }
        }?>
        
        
        <?php /*?>//old version
        <?php if($sale_id==0){?>
            <?php if($product['sale_product']==0){?>        
                <span class="priceDetailNormal"><?php echo money($product['msrp']);?></span>
            <?php }
            else{?>
                <?php if($product['msrp']>$product['price'] && $schedule_sale){?>
                <span class="priceDetailDiscount"><?php echo money($product['price']);?></span>
                <span class="priceDetail"><?php echo money($product['msrp']);?></span>
                <?php }else{?>
                <span class="priceDetailNormal"><?php echo money($product['msrp']);?></span>
                <?php }?>
            <?php 
            }?>
        <?php }else{?>
            <?php $percentage = find('percentage',$sale_id,'flash_sale_tb'); ?>
            <span class="priceDetailDiscount"><?php echo money($product['msrp']-($product['msrp']*$percentage/100));?></span>
            <span class="priceDetail"><?php echo money($product['msrp']);?></span>
        <?php }?><?php */?>
        
        
        <?php $discount=0; 
        if($sale_id!=0)
        {
            $discount=1;
        }else{
            if($product['msrp'] > $product['price'] && $schedule_sale)
                {
                    $discount=1;
            }
            else if($product['msrp'] <= $product['price'] || !$schedule_sale)
            {
                $discount=0;
            }
            else
            {
                $discount=0;
            }
        }
        #echo $discount;
        #echo "msrp = ".$product['msrp'];
        #echo "<br>price after discount = ".$product['price'];
        ?>
        
        <?php //price for id price if flash sale 
            $discount_flash_sale = 0;
            if($sale_id!=0){
                $percentage = find('percentage',$sale_id,'flash_sale_tb');
                $discount_flash_sale = $product['msrp']-($product['msrp']*$percentage/100);
            }
        ?>
        <section>
            <div class="contentWrapper">
                <div class="mainWrapper nobanner">
                	<div class="productWrapper">
                        <div class="breadCrumb">
                        	<ul>
                            	<li><a href="#">SHOP</a></li>
                                <?php if($cat_name!="best_seller"){ ?>
                                <?php if($sub_cat_name == ""){ ?>
                                <li><a href="#"><?php echo $cat_name ?></a></li>
                                <?php }else{ ?>
                                <li><a href="#"><?php echo $cat_name ?></a></li>
                                <li><a href="#"><?php echo $sub_cat_name ?></a></li>
                                <?php } ?>
                                <?php }else{ ?>
                                <li><a>BEST SELLER</a></li>
                                <?php } ?>
                                <li><?php echo $product['name'];?></li>
                            </ul>
                        </div>
                        <div class="productdetailBox">
                        	<div class="imageBox">
                            	<div class="productSlideshow">
                                    <ul class="productSlider">
                                    	<?php if($image)foreach($image as $img){?>
                                        <li><img src="<?php echo base_url();?>userdata/product/<?php echo $img['image'];?>"/></li>
                                    	<?php } ?>    
                                    </ul>
                                    <div id="bx-pager">
                                    <?php $no = 0; ?>
                                    <?php if($image)foreach($image as $img){?>
                                        <a data-slide-index="<?php echo $no; ?>" href=""><img src="<?php echo base_url();?>userdata/product/<?php echo $img['image'];?>" /></a>
                                    <?php $no++ ?>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="descBox">
                            	<h2 class="descName"><?php echo $product['name'];?></h2>

                                 <?php if($sale_id==0){?>
                                        <?php if($product['msrp']>$product['price'] && $schedule_sale){?>
                                        <h2 class="descPrice"><?php echo money($product['price']);?> </h2>
                                        <?php }else{?>
                                        <h2 class="descPrice"><?php echo money($product['msrp']);?></h2>
                                        <?php }?>
                                <?php }else{?>
                                    <?php $percentage = find('percentage',$sale_id,'flash_sale_tb'); ?>
                                    <h2 class="descPrice"><?php echo money($product['msrp']-($product['msrp']*$percentage/100));?></h2>
                                <?php }?>

                                <form id="buy_form_d" name="buy_form_d" method="post" enctype="multipart/form-data" action="#" onsubmit="return false;">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id'];?>" />
                                    <input type="hidden" name="price" id="price" value="<?php if($sale_id==0){ 
                                        if($schedule_sale) echo $product['price']; else echo $product['msrp']; 
                                    }else echo $discount_flash_sale;?>"/>
                                    <input type="hidden" name="product_name" id="product_name" value="<?php echo $product['name'];?>"/>
                                    <input type="hidden" name="actual_weight" id="actual_weight" value="<?php echo $product['weight'];?>"/>
                                    <input type="hidden" name="msrp" id="msrp" value="<?php echo $product['msrp']; ?>"/>
                                    <input type="hidden" name="discount" id="discount" value="<?php echo $discount; ?>" />
                                    <input type="hidden" name="sku_id" id="sku_id_d" value="0"/>
                                    <input type="hidden" name="sale_id" id="sale_id" value="<?php echo $sale_id ?>"/>
                                    <input type="hidden" name="quantity" id="quantity" value="1"/>
                                    <input type="hidden" name="stock" id="stock" value="" />
                                    <input type="hidden" name="cart_qty" id="cart_qty" value="" />
                                    <input type="hidden" name="url_image" id="img_url" value="<?php echo base_url();?>userdata/product/<?php echo find_2_prec('image', 'product_id', $product['id'], 'product_image_tb');?>" />

                                <select onchange="changeClass(this, value)">
                                    <option value="0">Please Select Size</option>
                                    <?php $i=1; if($sku) foreach($sku as $sk){ ?>
                                    <option  value="<?php echo $sk['id']?>"><?php echo $sk['size']?></option>
                                    <?php } ?>
                                </select>
                                <a href="#" class="sizeChart">See Size Chart</a>
                                <a href="javascript:void(0)" onClick="add_item_to_cart(); return false;" class="defBtn addtoCart">Add to Cart</a>
                                </form>
                                <ul class="productTnc">
                                	<li>
                                        <h4>Shipping</h4>
                                        <p><?php if($data) echo $data['shipping'] ?></p>
                                    </li>
                                    <li>
                                        <h4>Return Policy</h4>
                                        <p><?php if($data) echo $data['policy'] ?></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
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
                            <?php if($store)foreach ($store as $list) { ?>
                            <li><a <?php if($list['link']){ ?>href="<?php echo $list['link'] ?>"<?php } ?>><img src="<?php echo base_url() ?>userdata/e-store/<?php echo $list['image'] ?>"></a></li>
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
                