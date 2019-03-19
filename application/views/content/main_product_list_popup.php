<div class="popupContent2">
    <div class="imgQuick" style="display:none;">
        <img src="<?php echo base_url();?>userdata/product/<?php echo find_2_prec('image', 'product_id', $product['id'], 'product_image_tb');?>" alt="<?php echo $product['name'];?>"/>
    </div>
    <div class="item_loader" style="top:144px;">
        <img src="<?php echo base_url();?>templates/images/ajax-loader.gif" />
    </div>
    
    <?php //for flash sale
	$sale_id=0; if($sale_array){ 
		foreach($sale_array as $sale){ 
			if($sale['product_id']==$product['id'])
			{ 
				$sale_id=$sale['flash_sale_id'];
			}
		}
	}?>
    
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
	?>
    
    <?php //price for id price if flash sale 
		$discount_flash_sale = 0;
		if($sale_id!=0){
			$percentage = find('percentage',$sale_id,'flash_sale_tb');
			$discount_flash_sale = $product['msrp']-($product['msrp']*$percentage/100);
		}
	?>
    
    <div class="quickDetailPopup">
        <h3 class="proName"><?php echo $product['name'];?></h3>
        
        	<?php if($product['best_seller']==1){?><div class="best"></div><?php }?>
			<?php if($product['sale_product']==1 && $product['discount']>0 && $schedule_sale){?><div class="discFlagPopup"><?php echo round($product['discount'])?>% OFF</div><?php }?>
            <?php if($sale_id==0){?>
            	<?php /*if no flash sale for this product*/ ?>
				<?php if($product['msrp']>$product['price'] && $schedule_sale){?>
                    <span class="priceDetailDiscount"><?php echo money($product['price']);?></span>
                    <span class="priceDetail"><?php echo money($product['msrp']);?></span>
                    <?php }else{?>
                    <span class="priceDetailNormal"><?php echo money($product['msrp']);?></span>
                <?php }?>
            <?php }else{?>
            	<?php $percentage = find('percentage',$sale_id,'flash_sale_tb'); ?>
                <span class="priceDetailDiscount"><?php echo money($product['msrp']-($product['msrp']*$percentage/100));?></span>
                <span class="priceDetail"><?php echo money($product['msrp']);?></span>
            <?php }?>
        	<form id="buy_form" class="popup_form" name="buy_form" method="post" enctype="multipart/form-data" action="#" onsubmit="return false;">
                <input type="hidden" name="product_id" value="<?php echo $product['id'];?>" />
                <input type="hidden" name="price" id="price" value="<?php if($sale_id==0){ 
					if($schedule_sale) echo $product['price']; else echo $product['msrp']; 
				}else echo $discount_flash_sale;?>"/>
                <input type="hidden" name="product_name" id="product_name" value="<?php echo $product['name'];?>"/>
                <input type="hidden" name="actual_weight" id="actual_weight" value="<?php echo $product['weight'];?>"/>
                <input type="hidden" name="sku_id" id="sku_id" value="0"/>
                <input type="hidden" name="msrp" id="msrp" value="<?php echo $product['msrp']; ?>"/>
            	<input type="hidden" name="discount" id="discount" value="<?php echo $discount; ?>" />
                <input type="hidden" name="sale_id" id="sale_id" value="<?php echo $sale_id ?>"/>
                <input type="hidden" name="stock" id="stock" value="" />
                <input type="hidden" name="cart_qty" id="cart_qty" value="" />
                <input class="addQuantity" type="hidden" id="qty_buy" name="quantity"  value="1"/>
                <div class="size2">
                    <p class="blueColor">Please Select Your Size:</p>
                    <ul class="sizeImg2">
                    <?php $i=1; if($sku) foreach($sku as $sk){
                        if($product['id']==$sk['product_id']){?>
                        <li>
                            <a class="sku_item" onclick="changeClass(this, <?php echo $sk['id']?>)" href="javascript:void(0);" data-status="<?php echo ($sk['active']==1)?1:0?>"><?php echo $sk['size']?></a>
                        </li>
                    <?php }$i++;} ?>
                    </ul>
					<div class="errorMsg2 err_popup" style="display:none;"><span id="prd_sku_name">This item</span> is sold out! :(</div>
                </div>
                <input class="addToCart" id="add_to_cart_popup" type="submit" value="Add to Shopping Bag" onclick="buy_item();return false;" />
        	</form>
    </div>
</div>

<div id="stockUnavailable" class="popup" style="display:none;">
    <div class="popupContent">
        <p>Stock Unavailable</p>
        <input id="closeNotif" class="addToCart" type="submit" value="OK" onclick="close_popup2();"/>
    </div>
    <div class="close_stock"></div>
</div>
<script>


function changeClass (newElement2, id) {
	 
	$(".sku_item").each(function(){
		$(this).removeClass('selected');
	});
	
	
	
	if($(newElement2).data('status')==1){
		$(".err_popup").hide();
		$(newElement2).addClass('selected');
		$(".popup_form #sku_id").val(id);
		$.ajax({
			type:"POST",
			url:base_url+'product/check_stock',
			data:{id:id},
			dataType:"JSON",
			success: function(temp){
				$('#stock').val(temp.stock);
				$('#cart_qty').val(temp.cart_qty);
			}
		});
		$("#add_to_cart_popup").val('Add to Shopping Bag');
	}
	else{
		name=$(newElement2).text();
		$(newElement2).addClass('selected');
		$(".popup_form #sku_id").val('-1');
		$(".err_popup #prd_sku_name").text(name);
		$(".err_popup").show();
		$("#add_to_cart_popup").val('Sold out');
	}
}

function buy_item(){
	qty_buy=$("#qty_buy").val();
	product_name=$("#product_name").val();
	var stock = $('#stock').val();
	var cart_qty = $('#cart_qty').val();
	var sale_id = $('#sale_id').val();
	if(qty_buy==0){
		alert("Quantity cannot be 0");
		return false;
	}else{
		if($("#sku_id").val()>0){
			if(sale_id!=0){
				if((parseInt(qty_buy)+parseInt(cart_qty))>stock){
					$("#overlay").fadeIn();	
					$('#stockUnavailable').fadeToggle();
					return false;
				}
			}
			
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
					
					$("#stock").val(temp.stock);
					$("#cart_qty").val(temp.cart_qty);
					$(".total_item").html(qty);
					$("#total_prices").html(price);
					$("#quickPopup").hide();
					addcart_popup();
				}
			});		
		}
		else if($("#sku_id").val()=='-1'){
			alert('This item is sold out');
		}
		else{
			alert("Please select your size");
		}
	}
}

function addcart_popup(){
	$("#addToCartPopup").fadeToggle();		
}

function close_popup(){
	$("#addToCartPopup").fadeOut();	
	$("#stockUnavailable").fadeOut();	
	$("#overlay").fadeOut();	
}

function close_popup2(){
	$("#stockUnavailable").fadeOut();		
}

$(document).ready(function(){
	$(".close").click(function(){
		close_popup();
	});	
	
	$('.close_stock').click(function(){
		close_popup2();
	});
	
	$(".imgQuick img").load(function(){
		$(this).parents('.popupContent2').find('.item_loader').hide();
		$(this).parents('.popupContent2').find('.imgQuick').fadeIn();
	});
});	
</script>
