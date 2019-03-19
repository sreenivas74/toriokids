<script type="text/javascript">
function changeClass_d (newElement, id) {
	
	$(".sku_item_d").each(function(){
		$(this).removeClass('selected');
	});
	
	if($(newElement).data('status')==1){
		$("#quantity_boxs").show();
		$(newElement).addClass('selected');
		$("#sku_id_d").val(id);
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
		$("#add_to_cart_btn").val('Add to Shopping Bag');
	}
	else{
		$("#sku_id_d").val('-1');
		$("#quantity_boxs").hide();
		$(newElement).addClass('selected');
		$("#add_to_cart_btn").val('Sold out');
	}
}

function minus(id)
{
	var quan = $("#qty_buy").val();
	var quant = parseInt(quan);
	if(quant==1 || quant-1<1){
		return false;
	}else{
		var quanti = quant-1;
		$('#qty_buy').val(quanti);
	}
}

function add(id)
{
	var quan = $("#qty_buy").val();
	var quant = parseInt(quan)+1;
	$('#qty_buy').val(quant);
}

function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
	{
		return false;
	}
	else 
	{	
		return true;
	}
}

function buy_item_d(){
	qty_buy=$("#qty_buy").val();
	product_name=$("#product_name").val();
	var stock = $('#stock').val();
	var cart_qty = $('#cart_qty').val();
	var sale_id = $('#sale_id').val();
	if(qty_buy==0){
		alert("Quantity cannot be 0");
		return false;
	}else{
		if($("#sku_id_d").val()>0){
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
				data: $("#buy_form_d").serialize(),
				dataType:"JSON",	
				beforeSend:function(){
					$("#overlay").fadeIn();	
					$("#prd_popup_name").html('<?php echo $product['name'];?>');
				},		  
				success: function(temp){
					ga('send', 'event', 'button', 'click', 'add-to-cart');
					qty=temp.qty;
					price=temp.price;		   
					
					$("#stock").val(temp.stock);
					$("#cart_qty").val(temp.cart_qty);
					$(".total_item").html(qty);
					$(".notifNumber").html(qty);
					$("#total_prices").html(price);
					addcart_popup();
				}
			});	
		}
		else if($("#sku_id_d").val()=='-1'){
			alert('This item is sold out');
		}
		else{
			alert('Please select your size');
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

	
</script>
<?php /*?><div class="noBg">
    <a href="<?php //echo site_url('product/view_product_per_category'.'/'.$cat_al);?>"><?php //echo $cat['name'];?></a> &gt; <a><?php //if(in_array($list['alias'],$temp)) echo $sub_cat['name'];?></a>
</div><?php */?>
<?php if($clock_end){ ?>
<div class="flashSale">
    <a href="#">
        <img src="<?php echo base_url() ?>userdata/smallbanner/flash_sale.png" />
        <span class="flashSaleTxt">Come & Get it! This Day Only!  <span id="clock"></span></span>
    </a>
</div>
<?php }?>
<div class="productDetails">
    <div class="slide">
        <?php if($product['best_seller']==1){?>
        <div class="best2"></div>
        <?php }?>
		<?php if($product['sale_product']==1 && $product['discount']>0){?><div class="discFlag"><?php echo round($product['discount'])?>% OFF</div><?php }?>
        <div class="slideProduct">
            <ul class="bxProduct">
            	<?php if($image)foreach($image as $img){?>
                <li>
                    <img alt="<?php echo $product['name'];?>" src="<?php echo base_url();?>userdata/product/<?php echo $img['image'];?>" title="<?php echo $product['name'];?>" />
                </li>
                <?php } ?>
            </ul>
        </div>

    </div>
    <div class="productDetailRight">
        <h3 class="proName"><?php echo $product['name'];?></h3>
        
        <?php //for flash sale
		$sale_id=0; if($sale_array){ 
			foreach($sale_array as $sale){ 
				if($sale['product_id']==$product['id'])
				{ 
					$sale_id=$sale['flash_sale_id'];
				}
			}
		}?>
        
        <?php if($sale_id==0){?>
			<?php if($product['sale_product']==0){?>        
                <span class="priceDetailNormal"><?php echo money($product['price']);?></span>
            <?php /*this is normal price*/}
            else{?>
                <?php if($product['msrp']>$product['price']){?>
                <span class="priceDetailDiscount"><?php echo money($product['price']);?></span>
                <span class="priceDetail"><?php echo money($product['msrp']);?></span>
                <?php }else{?>
                <span class="priceDetailNormal"><?php echo money($product['price']);?></span>
                <?php }?>
            <?php 
            }?>
        <?php }else{?>
        	<?php $percentage = find('percentage',$sale_id,'flash_sale_tb'); ?>
        	<span class="priceDetailDiscount"><?php echo money($product['msrp']-($product['msrp']*$percentage/100));?></span>
            <span class="priceDetail"><?php echo money($product['msrp']);?></span>
        <?php }?>
        
        <?php $discount=0; 
		if($sale_id!=0)
		{
			$discount=1;
		}else{
			if($product['msrp'] > $product['price'])
				{
					$discount=1;
			}
			else if($product['msrp'] <= $product['price'])
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
        
        <div class="productDetail">
            <p><?php echo $product['description'];?></p>
        </div>
        <form id="buy_form_d" name="buy_form_d" method="post" enctype="multipart/form-data" action="#" onsubmit="return false;">
            <input type="hidden" name="product_id" value="<?php echo $product['id'];?>" />
            <input type="hidden" name="price" id="price" value="<?php if($sale_id==0) echo $product['price']; else echo $discount_flash_sale;?>"/>
            <input type="hidden" name="product_name" id="product_name" value="<?php echo $product['name'];?>"/>
            <input type="hidden" name="actual_weight" id="actual_weight" value="<?php echo $product['weight'];?>"/>
            <input type="hidden" name="msrp" id="msrp" value="<?php echo $product['msrp']; ?>"/>
            <input type="hidden" name="discount" id="discount" value="<?php echo $discount; ?>" />
			<input type="hidden" name="sku_id" id="sku_id_d" value="0"/>
            <input type="hidden" name="sale_id" id="sale_id" value="<?php echo $sale_id ?>"/>
            <input type="hidden" name="stock" id="stock" value="" />
            <input type="hidden" name="cart_qty" id="cart_qty" value="" />
            
            <?php if($sku){?>
            <div class="size">
                <p class="blueColor">Please Select Your Size:</p>
                <ul class="sizeImg">
				<?php $i=1; if($sku) foreach($sku as $sk){
                    if($product['id']==$sk['product_id']){?>
                    <li>
                    	<a class="sku_item_d" onclick="changeClass_d(this, <?php echo $sk['id']?>)" href="javascript:void(0);" data-status="<?php echo ($sk['active']==1)?1:0?>"><?php echo $sk['size']?></a>
                    </li>
				<?php }$i++;} ?>
                </ul>
				<div class="errorMsg2 err_detail" style="display:none;"><span id="prd_sku_name">This item</span> is sold out! :(</div>
            </div>
            <div class="quantity" id="quantity_boxs">
                <p class="blueColor">Quantity:</p>
                <div class="quantityCon">
                    <a href="javascript:void(0);" id="addQuantity" onclick="add(<?php echo $product['id']; ?>)" class="plusPcs"></a>
                    <input class="addQuantity" type="text" id="qty_buy" name="quantity" onKeyPress="return isNumberKey(event)" value="1"/> PCS
                    <a href="javascript:void(0);" class="minPcs" id="minQuantity" onclick="minus(<?php echo $product['id']; ?>)"></a> 
                </div>
            </div>
                <input class="addToCart" id="add_to_cart_btn" type="submit" onclick="buy_item_d();return false;" value="Add to Shopping Bag" />
			<?php } ?>
        </form>
        <p class="blueColor">Share it to your friends via:</p>
        <div class="socialNetworkIcon"><a class="fbShare" href="javascript:void(0);" url="<?php echo str_replace('_path=feed&','',$fb_link);?>"><img src="<?php echo base_url();?>templates/images/f_logo.png" alt="Facebook" title="Facebook" /></a>
        </div>
        <div class="socialNetworkIcon"><a class="twShare" href="javascript:void(0);" txt="<?php echo $tw_link;?>"><img src="<?php echo base_url();?>templates/images/t_logo.png" alt="Twitter" title="Twitter" /></a>
        </div>
    </div>
</div>
<?php if($related){?>
<div class="bigBreadCrumb">Recommended Products</div>
<div class="product">
    <ul class="recItemsSlider" id="recItemsSlider">
    <?php if($related)foreach($related as $rel){?>
        <li>
            <div class="productCon2">
                <?php if($rel['best_seller']==1){?><div class="best"></div><?php }?>
		<?php if($rel['sale_product']==1 && $rel['discount']>0){?><div class="discFlag"><?php echo round($rel['discount'])?>% OFF</div><?php }?>
                
                    <div class="productImage">
                        <a href="<?php echo site_url('product/view_product_detail'.'/'.$rel['alias']);?>"><img src="<?php echo base_url();?>userdata/product/<?php echo find_2_prec('image', 'product_id', $rel['product_id_to'], 'product_image_tb');?>" title="<?php echo $rel['name'];?>" alt="<?php echo $rel['name'];?>"/></a>
                <?php /*?><a href="<?php echo site_url('product/view_product_detail'.'/'.find_2('alias', 'id', $rel['product_id_to'], 'product_tb'));?>" class="viewDetail"></a><?php */?>
                
                
                    <a href="#" class="quickDetail" rel="<?php echo $rel['alias'];?>">Quick View</a>
                    </div>
                                           
                <?php /*?><div class="item_loader">
                    <img src="<?php echo base_url();?>templates/images/ajax-loader.gif" />
                </div><?php */?>
                <div class="productTxt">
                    <h3 class="productName"><a href="<?php echo site_url('product/view_product_detail'.'/'.$rel['alias']);?>"><b><?php echo $rel['name'];?></b></a></h3>
                    
					<?php
					if($rel['msrp']>$rel['price']){?>            
					<span class="discount"><?php echo money($rel['price']);?></span>
					<span class="afterDiscount"><?php echo money($rel['msrp']);?></span>
					<?php }else{?>
					<span class="normal"><?php echo money($rel['price']);?></span>
                    <?php }?>
					<div class="ageRange"><?php echo $rel['template_name']?></div>
                </div>
            </div>
        </li>
	<?php } ?>
    </ul>
</div>
<?php } ?>


<div id="addToCartPopupssss" class="popup" style="display:none;">
    <div class="popupContent">
        <p><?php echo $product['name'];?> has been successfully added to your cart</p>
        <input id="closeNotif" class="addToCart" type="submit" value="OK" onclick="close_popup();"/>
    </div>
    <div class="close"></div>
</div>

<div id="addToCartPopup" class="popup" style="display:none;">
    <div class="popupContent">
        <p><span id="prd_popup_name"></span> has been successfully added to your cart</p>
        <input id="closeNotif" class="addToCart" type="submit" value="OK" onclick="close_popup();"/>
    </div>
    <div class="close"></div>
</div>

<div id="stockUnavailable" class="popup" style="display:none;">
    <div class="popupContent">
        <p>Stock Unavailable</p>
        <input id="closeNotif" class="addToCart" type="submit" value="OK" onclick="close_popup();"/>
    </div>
    <div class="close"></div>
</div>

<div id="quickPopup" class="popup2" style="display:none;">

    <div id="quick_pop_up">
    </div>
    <div class="close2"></div>
</div>

<?php /*?>
<script>
	$(document).ready(function(){
		$(".productImage a img").each(function(){
			$(this).load(function(){
				$(this).parents('.productCon2').find('.item_loader').hide();
				$(this).parents('.productCon2').find('.productImage').fadeIn();
			});
		});
	});
</script><?php */?>