<div class="popupContent2">
    <div class="imgQuick" style="display:none;">
        <img src="<?php echo base_url();?>userdata/product/<?php echo find_2_prec('image', 'product_id', $product['id'], 'product_image_tb');?>" alt="<?php echo $product['name'];?>"/>
    </div>
    <div class="item_loader" style="top:144px;">
        <img src="<?php echo base_url();?>templates/images/ajax-loader.gif" />
    </div>
    <div class="quickDetailPopup">
        <h3 class="proName"><?php echo $product['name'];?></h3>
        
        	<?php if($product['best_seller']==1){?><div class="best"></div><?php }?>
			<?php if($product['sale_product']==1 && $product['discount']>0){?><div class="discFlagPopup"><?php echo round($product['discount'])?>% OFF</div><?php }?>
        	<?php if($product['msrp']>$product['price']){?>
            <span class="priceDetailDiscount"><?php echo money($product['price']);?></span>
            <span class="priceDetail"><?php echo money($product['msrp']);?></span>
            <?php }else{?>
       		<span class="priceDetailNormal"><?php echo money($product['price']);?></span>
            <?php }?>
        	<form id="buy_form" name="buy_form" method="post" enctype="multipart/form-data" action="#" onsubmit="return false;">
                <input type="hidden" name="product_id" value="<?php echo $product['id'];?>" />
                <input type="hidden" name="price" id="price" value="<?php echo $product['price'];?>"/>
                <input type="hidden" name="product_name" id="product_name" value="<?php echo $product['name'];?>"/>
                <input type="hidden" name="actual_weight" id="actual_weight" value="<?php echo $product['weight'];?>"/>
                <input type="hidden" name="sku_id" id="sku_id" value="<?php if($sku)if($sku[0]) echo $sku[0]['id'];?>"/>
                <input class="addQuantity" type="hidden" id="qty_buy" name="quantity"  value="1"/>
                <div class="size2">
                    <p class="blueColor">Select Size:</p>
                    <ul class="sizeImg2">
                    <?php $i=1; if($sku) foreach($sku as $sk){
                        if($product['id']==$sk['product_id']){?>
                        <li>
                            <a class="sku_item <?php if($i==1)echo "selected"?>" onclick="changeClass(this, <?php echo $sk['id']?>)" href="javascript:void(0);" ><?php echo $sk['size']?></a>
                        </li>
                    <?php }$i++;} ?>
                    </ul>
                </div>
                <input class="addToCart" type="submit" value="Add to Shopping Bag" onclick="buy_item();return false;" />
        	</form>
    </div>
</div>
<script>

function changeClass (newElement, id) {
	 $("#sku_id").val(id);
	 
	$(".sku_item").each(function(){
		$(this).removeClass('selected');
	});
	
	$(newElement).addClass('selected');
}

function buy_item(){
	qty_buy=$("#qty_buy").val();
	product_name=$("#product_name").val();
	if(qty_buy==0){
		alert("Quantity cannot be 0");
		return false;
	}else{
		$.ajax({
			type: "POST",
			url: '<?php echo site_url('shopping_cart/add_to_cart');?>',
			data: $("#buy_form").serialize(),
			dataType:"JSON",		
			beforeSend:function(){
				$("#prd_popup_name").html('<?php echo $product['name'];?>');
			},	  
			success: function(temp){
				ga('send', 'event', 'button', 'click', 'add-to-cart');
				qty=temp.qty;
				price=temp.price;		   
				
				$(".total_item").html(qty);
				$("#total_prices").html(price);
				$("#quickPopup").hide();
				addcart_popup();
			}
		});		
	}
}

function addcart_popup(){
	$("#addToCartPopup").fadeToggle();		
}

function close_popup(){
	$("#addToCartPopup").fadeOut();	
	$("#overlay").fadeOut();	
}

$(document).ready(function(){
	$(".close").click(function(){
		close_popup();
	});	
	
	$(".imgQuick img").load(function(){
		$(this).parents('.popupContent2').find('.item_loader').hide();
		$(this).parents('.popupContent2').find('.imgQuick').fadeIn();
	});
});	
</script>
