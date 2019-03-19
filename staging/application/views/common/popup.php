<div class="popupWrapper">
    	<div class="overlay" onClick="hide_popup();"></div>
        <div class="popupBox" id="searchPopup">
            <a href="javascript:void(0)" class="closeBtn" onClick="hide_popup();"></a>
            <h3>SEARCH</h3>
            <form name="search_form" id="search_form" method="get" action="<?php echo site_url('product/search');?>">
            <input placeholder="Search Here" name="search" id="searchText">
            <a href="javascript:void(0)" id="submit_search" class="defBtn">Search Your Style</a>
            </form>
        </div>
    </div>

 <div class="cartsidenavBox">
            <div class="cartsideNav">
                <div class="header">
                    <a href="#" class="cartcloseBtn" onClick="hide_temporarycart(); return false;">closebutton</a>
                    <h3>YOUR cart</h3>	
                </div>
                <div class="itemWrapper">
                	<?php $total=0; if($cart_session) foreach ($cart_session as $list) { ?>
                    <?php
                        $sale_id=0; if($sale_array){ 
                                    foreach($sale_array as $sale){ 
                                        if($sale['product_id']==$list['id'])
                                        { 
                                            $sale_id=$sale['flash_sale_id'];
                                        }
                                    }
                                }
                    ?>

                    <div id="cart_<?php echo $list['id'] ?>" class="itemPanel">
                        <div class="itemBox">
                            <div class="image">
                                <img width="100%" src="<?php echo base_url() ?>userdata/product/<?php echo find_2_prec('image', 'product_id', $list['product_id'], 'product_image_tb');?>">
                            </div>
                            <div class="data">
                                <p class="productName"><?php echo $list['name'] ?></p>
                                <p class="productCategory">Size: <?php echo $list['size'] ?></p>

                                <?php if($sale_id==0){?>
                                        <?php if($list['msrp']>$list['price'] && $schedule_sale){?>
                                        <p class="productPrice"><?php echo money($list['price']);?> </p>
                                        <?php }else{?>
                                        <p class="productPrice">Rp <?php echo number_format($list['msrp_price']) ?></p>
                                        <?php }?>
                                <?php }else{?>
                                    <?php $percentage = find('percentage',$sale_id,'flash_sale_tb'); ?>
                                    <p class="productPrice"><?php echo money($list['msrp_price']-($list['msrp_price']*$percentage/100));?></p>
                                <?php }?>
                                <a href="javascript:void(0)" onclick="deletecart(<?php echo $list['id'] ?>)" class="trashicon">deleteItem</a>
                            </div>
                        </div>
                    </div>
					<?php $total += $list['total']; } ?>
                    
                </div>
                <div class="cartnavSummary">
                    <p class="info">Belum termasuk biaya shipping.</p>
                    <div class="summaryBox">
                    	<div class="totalWrapper">
                        	<p>Total</p>
                        	<span id="totalPrice">Rp <label id="cart_tot"><?php echo number_format($total) ?></label>,-</span>
                        </div>
                        <input type="hidden" value="<?php echo $total ?>" id="total_cart" />
                        <a href="<?php echo site_url('shopping_cart') ?>" class="defBtn">GO TO SHOPPING CART</a>
                    </div>
                </div>
			</div>
</div>