<script>
function add(id)
{
    var quan = $("#quantity_"+id).val();
    var quant = parseInt(quan)+1;
    $.ajax({
        type:"POST",
        dataType:"json",
        data:{ cart_id:id,qty:quant },
        url:base_url+'shopping_cart/check_stock',

        success: function(temp){
            if(temp.status==0){
                alert('Stok Habis');
                $('#quantity_'+id).val(temp.qty);
                return false;
            }else{
                $('#quantity_'+id).val(quant);
            }
        }
    });

    $('#quantity_'+id).val(quant);
}
function minus(id)
{
    var quan = $("#quantity_"+id).val();
    var quant = parseInt(quan);
    if(quant==1 || quant-1<1){
        return false;
    }else{
        var quanti = quant-1;
        $('#quantity_'+id).val(quanti);
    }
}
function submit_form_update()
{          
    $("#shopping_cart").attr('action', '<?php echo site_url('shopping_cart/do_update');?>');
    $("#shopping_cart").submit();
}
</script>
<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="shopcartWrapper">
                        <h3>SHOPPING CART</h3>
                        <div class="headerCart">
                        	<span>Items</span>
                            <span>Total Amount</span>
                        </div>
                        <form name="shopping_cart" id="shopping_cart" method="post" action="#" >
                        <div class="mainCart">
                            
                            <?php $total=0; if($shopping_cart)foreach ($shopping_cart as $list) { ?>
                            <input type="hidden" name="id[]" value="<?php echo $list['id'];?>" />
                            <input type="hidden" name="price_<?php echo $list['id'];?>" value="<?php echo $list['price'];?>" /> 
                            <input type="hidden" name="actual_weight_<?php echo $list['id'];?>" value="<?php echo $list['weight'];?>" />
                        	<div class="itemPanel">
                            	<div class="itemBox">
                                	<div class="image">
                                    	<img width="100%" src="<?php echo base_url() ?>userdata/product/<?php echo find_2_prec('image', 'product_id', $list['product_id'], 'product_image_tb');?>">
                                    </div>
                                    <div class="data">
                                        <p class="productName"><?php echo $list['name'] ?></p>
                                        <p class="productCategory">Size : <?php echo $list['size'] ?></p>
                                        <div class="itemQty">
                                            <p>Qty</p>
                                            <div class="numberQty">
                                                <a href="javascript:void(0)" onclick="minus(<?php echo $list['id']; ?>)">-</a>
                                                <input name="quantity_<?php echo $list['id']; ?>" id="quantity_<?php echo $list['id'];?>" placeholder="<?php echo $list['quantity'] ?>" value="<?php echo $list['quantity'] ?>">
                                                <a href="javascript:void(0)" onclick="add(<?php echo $list['id']; ?>)">+</a>
                                            </div>
                                            <a href="<?php echo site_url('shopping_cart/remove_item').'/'.$list['id'];?>" class="trashicon">deleteItem</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="itemPrice">
                                	<p>Rp <?php echo number_format($list['total']) ?>,-</p>
                                </div>
                            </div>
                            <?php $total+=$list['total']; } ?>
                        </div>
                        <?php if($discount_cart){
                        if($total_price>=$discount_cart['minimum_purchase']){ ?>
                        <div class="totalCart">
                                <p>Discount Promo</p>
                                <p>Rp <?php echo money2($discount_cart['discount']);?></p>
                        </div>
                        <?php }
                        }?>

                        <div class="totalCart">
                            <p>TOTAL</p>
                            <p>Rp <?php 
                                if(!$discount_cart) echo money2($total);
                                else{
                                    if($total>=$discount_cart['minimum_purchase'])
                                    {
                                        echo money2($total-$discount_cart['discount']);
                                    }
                                    else
                                    {
                                        echo money2($total);
                                    }
                                }?></p>
                        </div>

                        <?php if($shopping_cart){ ?>
                        <div class="buttonArea">
                        	<a  href="javascript:void(0);" onclick="submit_form_update();" class="defBtn">UPDATE CART</a>
                            <a href="<?php echo site_url('shopping_cart/customer_information') ?>" class="defBtn">CHECK OUT</a>
                        </div>
                        <?php } ?>
                        </form>
                        <a href="<?php echo base_url() ?>" class="continueShop">< Continue Shopping</a>
                    </div>
                </div>
            </div>
        </section>