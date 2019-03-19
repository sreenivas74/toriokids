<!-- GUEST -->
<script>

$(window).load(function(){
	$(".combodate select").uniform();
});

$(document).ready(function(){
	<?php if($check_sale>0){ ?>
		alert('Flash sale is over. Your cart now will be updated to original price.');
	<?php }?>
});


$(function(){
	$('#dob').combodate({
		firstItem: 'name',	
		errorClass:'error_date',
		maxYear:<?php echo date("Y");?>,
		minYear:1920
	});
});

$(document).ready(function(){
	$(".input_required").change(function(){
		ok=0;
		$(".input_required").each(function(){
			if($(this).val()!="")ok=1;
			else ok=0;
		});
		if(ok==1)$("#required_con").hide();
		else $("#required_con").show();
	});
	$("#cancel_coupon").click(function(){
		$("#coupon_code").val('');	
	});
	$('.rmv').click(function(){
		$("#used_loader").show();
		$.ajax({
			type: "POST",
			url: '<?php echo site_url('shopping_cart/delete_coupon');?>',
			data: $("#voucher_form").serialize(),
			dataType:"JSON",			  
			success: function(result){
				//alert(result.msg);
				if(result.status==1){							
					$('#promo_used').fadeOut(500,function(){
						$('#promo_start').fadeIn(500);	
					});
					
					$("#grand_total_table").fadeOut(500,function(){
						$(this).html(result.content);	
						$(this).fadeIn(500);
					});
					
				}
				
				<?php /*?>$("#facebooktype2").show();<?php */?>
				$("#used_loader").hide();
			}
		});	
		
		
		return false;
		//window.location=base_url+'/shopping_cart/deletevoucher_shop';
	})
	$(".redeemBtn").click(function(){
		stamps_redeem();return false;
	});

	$("#submit_voucher_btn").click(function(){
		
		voucher_submit();
		return false;
	});
});	

$(document).ready(function() {
    $('#coupon_code').keydown(function(event) {
        if (event.keyCode == 13) {
            voucher_submit();
            return false;
         }
    });
});
function submit_form_update()
{          
	$("#shopping_cart").attr('action', '<?php echo site_url('shopping_cart/do_update');?>');
	$("#shopping_cart").submit();
}

function voucher_submit()
{          
	if($("#coupon_code").val()!=""){
		$("#voucher_form_loader").show();
		$("#button_con").hide();
		$.ajax({
			type: "POST",
			url: '<?php echo site_url('shopping_cart/add_coupon_guest');?>',
			data: $("#voucher_form").serialize(),
			dataType:"JSON",			  
			success: function(result){
				
				if(result.status==1){					
					$('.voucherCon').fadeOut(500, function(){
						<?php /*?>$('#facebooktype2').hide();<?php */?>
						$('#promo_used').fadeIn(500);
						$("#applied_voucher").show();
						$("#voucher_form_loader").hide();
						$("#button_con").show();
						$("#coupon_code").val('');
					});
					
					$("#grand_total_table").fadeOut(500,function(){
						$(this).html(result.content);	
						$(this).fadeIn(500);
					});				
				}
				else {
					alert(result.msg);						
					$("#voucher_form_loader").hide();
					$("#button_con").show();
				}
			}
		});	
		
	//	$("#voucher_form").submit();
	}
	else 
		return false;
}

function minus(id)
{
	var quan = $("#quantity_"+id).val();
	var quant = parseInt(quan);
	if(quant==0 || quant-1<0){
		return false;
	}else{
		var quanti = quant-1;
		$('#quantity_'+id).val(quanti);
	}
}

function add(id)
{
	var quan = $("#quantity_"+id).val();
	var quant = parseInt(quan)+1;
	$('#quantity_'+id).val(quant);
	/*var check = 0;
	
	$.ajax({
		type:"POST",
		url:base_url+'shopping_cart/check_current_stock',
		data:{id:id, qty:quant},
		dataType:"JSON",
		async:false,
		success: function(data){
			if(data.check==0){ check=0;
			}
			else
			{
				check=1;
			}
		}
	});
	
	if(check==1){
		$("#overlay").fadeIn();	
		$('#stockUnavailable').fadeToggle();
		return false;
	}else{
		$('#quantity_'+id).val(quant);
	}*/
	
	
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

function show_popup()
{
	$("#overlay").fadeToggle();
	$("#completePopup").fadeToggle();
}

function proceed(){
	mobile=$("#mobile").val();
	telephone=$("#telephone").val();
	address=$("#address").val();
	select_city=$("#select_city").val();
	postcode=$("#postcode").val();
		
	if(mobile!="" && telephone!="" && address!="" && select_city!="" && postcode!=""){
		
		$.ajax({
		   type: "POST",
		   url: '<?php echo site_url('shopping_cart/default_address');?>',
		   data: $("#account_form2").serialize(),			  
		   success: function(){
//			show_popup();
			window.location='<?php echo site_url('shopping_cart/shipping');?>';
		   }
		});	
	}
}

function check_stock(){
	var check = 1;
		
	$.ajax({
		type:"POST",
		url:base_url+'shopping_cart/check_stock_cart',
		dataType:"JSON",
		async:false,
		success: function(data){
			var id = data.product_id;
			if(data.check==0){ check=1;
			}
			else
			{
				check=0;
				
				id.forEach(function(entry){
					$('#stock_'+entry).html('*stock not available');
					$('#stock_'+entry).attr('style', 'display:block;color:red;font-size:10px;');
				});
				
				alert('Stock Unavailable');
			}
		}
	});
	
	if(check==0) return false;
	else{ 
		$("#checkout_guest").attr("href",base_url+'login/checkout');
		return true;
	}
}

function close_popup2(){
	$('#overlay').fadeOut();
	$("#stockUnavailable").fadeOut();		
}
</script>
<?php if($clock_end){ ?>
<div class="flashSale">
    <a href="#">
        <img src="<?php echo base_url() ?>userdata/smallbanner/flash_sale.png" />
        <span class="flashSaleTxt">Come & Get it! This Day Only!  <span id="clock"></span></span>
    </a>
</div>
<?php }?>
<div class="shopCartContent">
    <h2>Shopping Cart</h2>
    <div class="stepShopping">
        <div class="firstStepDone">Shopping Cart</div>
        <div class="otherStep">Shipping</div>
        <div class="lastStep">Payment</div>
    </div>
</div>
<div class="topShopCartInfo">
    <div class="leftShopCartInfo">Item</div>
    <div class="rightShopCartInfo">
    	<div class="rightBox">Quantity</div>
        <div class="rightBox">Unit Price</div>
    	<div class="rightBox">Subtotal</div>
        <div class="rightBox">Discount</div>
        <div class="rightBlackBox">Total</div>
    </div>
</div>

<?php 	/*$total_harga_diskon=0; 
		foreach($shopping_cart as $sc){
			if($sc['discount'] == 0)
			{
				$total_harga_diskon += $sc['total'];
			}
}*/?>

<form name="shopping_cart" id="shopping_cart" method="post" enctype="multipart/form-data" action="#" >
<?php if($shopping_cart)foreach($shopping_cart as $list){ $diff=($list['quantity']*$list['msrp'])-$list['total'];?>
<input type="hidden" name="id[]" value="<?php echo $list['id'];?>" />
<input type="hidden" name="price_<?php echo $list['id'];?>" value="<?php echo $list['price'];?>" /> 
<input type="hidden" name="actual_weight_<?php echo $list['id'];?>" value="<?php echo $list['weight'];?>" />   

<?php $notavailable_cart=array(); if($this->session->flashdata('notavailable_cart')){
	$notavailable_cart = json_decode($this->session->flashdata('notavailable_cart'));
}?>
 
<div class="<?php echo alternator('midShopCartInfo', 'midShopCartInfo2');?>">
    <div class="shopCartImgCon">
        <div class="shopCartImg">
            <a href="<?php echo site_url('product/view_product_detail'.'/'.$list['alias'])?>" title="<?php echo $list['name'].' ('.$list['size'].')';?>"><img src="<?php echo base_url();?>userdata/product/med/<?php echo find_2_prec2('image', 'product_id', $list['product_id'], 'product_image_tb');?>" /></a>
        </div>
    </div>
    <div class="shopCartDetail">
        <div class="productNameCart"><a href="<?php echo site_url('product/view_product_detail'.'/'.$list['alias'])?>" title="<?php echo $list['name'].' ('.$list['size'].')';?>"><?php echo $list['name'].' ('.$list['size'].')';?></a>
        <?php if($notavailable_cart){ ?>
        	<?php foreach($notavailable_cart as $not){ 
				if($not==$list['id']){?>
        		<span class="msgProduct" id="stock_<?php echo $list['id'] ?>" style="display:block; color:blue">*Current stock available: <?php echo $list['quantity'] ?></span>
        <?php }
			}
		}else{?>
        		<span class="msgProduct" id="stock_<?php echo $list['id'] ?>" style="display:none"></span>
        <?php }?>
        </div>
        <div class="rightBox">
            <div class="quantityWrap">
                <a href="javascript:void(0);" class="minQuan" id="minQuantity_<?php echo $list['id']; ?>" onclick="minus(<?php echo $list['id']; ?>)"></a>
                <input type="text" class="insertTxt" name="quantity_<?php echo $list['id']; ?>" id="quantity_<?php echo $list['id'];?>" value="<?php echo $list['quantity'];?>" onKeyPress="return isNumberKey(event)"/>
                <a href="javascript:void(0);" id="addQuantity_<?php echo $list['id']; ?>" onclick="add(<?php echo $list['id']; ?>)" class="addQuan"></a>
            </div>
        </div>
        <div class="rightBox del"><?php echo money($list['msrp']);?></div>
        <?php if($diff>0){?>
        <div class="rightBox linethrough"><?php echo money($list['quantity']*$list['msrp']);?></div>
        <?php }
		else
		{?>
        <div class="rightBox del"><?php echo money($list['quantity']*$list['msrp']);?></div>
		<?php }?>
        <div class="rightBox del"><?php if($diff<1)echo "-";else echo "(".money($diff).")"; ?></div>
        <div class="rightBox"><?php echo money($list['total']);?></div>
        <a href="<?php echo site_url('shopping_cart/remove_item').'/'.$list['id'];?>" class="remove"></a>
    </div>
</div>

<?php } else {?>
<div class="midShopCartInfo">
    <p style="padding:15px 15px 15px 15px; text-align:center">You don't have any item in your shopping cart</p>
</div>
<?php } ?>
<?php $discount="";$voucher_list;?>

<?php if ($voucher_list) foreach($voucher_list as $list5){?>
<div class="<?php echo alternator('midShopCartInfo', 'midShopCartInfo2');?>">
    <div class="shopCartImgCon">
        <div class="shopCartImg">
        <?php if ($list5['image_voucher']!=""){?>
        <img src="<?php echo base_url()?>userdata/voucher/<?php echo $list5['image_voucher']?>">
		<?php }else {?>
        <img src="<?php echo base_url()?>userdata/voucher/voucher.jpg">
		<?php } ?>
        </div>
    </div>
    <div class="shopCartDetail">
        <div class="productNameCart"><?php echo $list5['voucher_name']?> </div>
        <div class="rightBox"><?php echo $list5['quantity'] ?></div>
        <div class="rightBox">-</div>
        <div class="rightBox">-</div>
        <div class="rightBox"><?php echo money($list5['total']) ?></div>
        <div class="rightBox">-</div>
    	<a href="<?php echo site_url('shopping_cart/deletevoucher').'/'.$list['id'];?>"class="remove"></a>
    </div>
</div>
<?php }?>


<?php if($shopping_cart){?>
<div class="topShopCartInfo" id="cartMobile">
    <div class="updateCart">
        <a href="javascript:void(0);" onclick="submit_form_update();">Update Cart</a>
    </div>
    <div class="clearCart">
        <a href="<?php echo site_url('shopping_cart/clear_shopping_cart')?>">Clear Shopping Cart</a>
    </div>
</div>
<?php } ?>

</form>

<div class="botShopCartInfo">
	<div class="botLeftCart">
  <?php 
  if(!$this->session->userdata('user_logged_in')){
		if(!$voucher_list && !$get_discount_stamps && $shopping_cart){?>
        <div class="promotionWrap" style="display:none"> <?php //remove display none if want to show coupon ?>
			<div class="buttonBox" id="promo_used" style="display:none;">
                
                <div class="voucherBox" id="applied_voucher" style="display:none;cursor:default;"><img src="<?php echo base_url()?>templates/images/voucher-img.png">You have coupon applied</div>
                
                
                <?php /*?><div id="facebooktype3" style="display:none;cursor:default;"><a class="likeFb" onclick="return false;"><img src="<?php echo base_url()?>templates/images/likes.png">20% OFF Applied!</a></div><?php */?>
                
                <a href="#" class="rmv" >Cancel, I want to remove.</a>
                <div style="text-align:right;display:none;" id="used_loader">
                	<img src="<?php echo base_url();?>templates/images/ajax-loader.gif" />
            	</div>
            </div>
            <div class="buttonBox" id="promo_start">
            <?php if(isset($_SESSION['coupon_error'])){?>
                <div class="error_coupon" style="color:red;">
                    <p><?php echo $_SESSION['coupon_error'];?><br /></p>
                </div>
            <?php unset($_SESSION['coupon_error']);
            }?>
                <a href="#" class="voucherBox" id="voucher_btn"><img src="<?php echo base_url()?>templates/images/voucher-img.png"> Have a coupon code ?</a>
               
					<?php /*?><span id="facebook_2" >	<a href="#" class="likeFb" onclick="facebookvoucher();return false;" id="facebooktype2"><img src="<?php echo base_url()?>templates/images/likes.png">Get 20% OFF Now!</a></span><?php */?>      
                      
            </div>
            <div class="voucherCon">
                Enter your Coupon Code
                <form id="voucher_form" name="voucher_form" method="post" action="#" onsubmit="return false;">
                <input type="text" name="coupoun" id="coupon_code">
                <div class="buttonCon" id="button_con">
                    <a href="#" id="cancel_coupon" title="Cancel">cancel</a>   
                    <input type="submit" value="Apply" id="submit_voucher_btn">
                </div>
                <div class="buttonCon" id="voucher_form_loader" style="display:none;">
                	<img src="<?php echo base_url();?>templates/images/ajax-loader.gif">
                </div>
                </form>           
            </div>
             
         </div>  
        		<?php
		}
		else{?>
		<?php }		
  }?>
	</div>
  
	<div class="botRightCartCon">
		<div class="botRightCart">
            <table id="grand_total_table">                     
             <?php if($voucher_list){?>
                <tr>
                    <td width="200">Total Price</td>
                    <td width="50">IDR.</td>
                    <td width="150" style="text-align:right;"><div class="totalPrice"><?php echo money2($total_price);?></div></td>
                </tr>
                <?php }?>
                 <?php if ($voucher_list) foreach($voucher_list as $list5){?>
                <tr>
                    <td width="200" style="color:#C1272D;">Discount</td>                    
                    <td width="50" style="color:#C1272D;">IDR.</td>
                    <?php if($total_price<$list5['maximum_sub']){ 
                    $totalbelanja=$total_price?>
                    <?php } else { ?>
                    <?php $totalbelanja=$list5['maximum_sub'] ?>
                    <?php } ?>
                    <td width="150" style="text-align:right;color:#C1272D;">
                        <div class="totalPrice">
                        <?php if($list5['type_voc']==1){
                        $discount=($totalbelanja*$list5['value'])/100; echo money2($discount);?>
                        <?php }else{ ?>
                        <?php
                        $discount=$list5['value']; echo money2($discount);?>	
                        <?php } ?>
                        </div>
                    </td>
                </tr>
        <?php } ?>
        		<tr>
                    <td width="200">Discounted Items</td>
                    <td width="50">IDR.</td>
                    <td width="150" style="text-align:right;"><div class="totalPrice"><?php echo money2($total_price-$total_harga_diskon['totalsemua']);?></div></td>
                </tr>
                <tr>
                    <td width="200">Non-discounted Items</td>
                    <td width="50">IDR.</td>
                    <td width="150" style="text-align:right;"><div class="totalPrice"><?php echo money2($total_harga_diskon['totalsemua']);?></div></td>
                </tr>
                 <?php if($discount_cart){
						if($total_price>=$discount_cart['minimum_purchase']){ ?>
                    <tr>
                        <td width="200">Discount Promo</td>
                        <td width="50">IDR.</td>
                        <td width="150" style="text-align:right;"><div class="totalPrice"><?php echo money2($discount_cart['discount']);?></div></td>
                    </tr>
                <?php }
				}?>
                <tr>
                    <td width="200">Grand Total</td>
                    <td width="50">IDR.</td>
                    <td width="150" style="text-align:right;"><div class="totalPrice"><?php if(!$discount_cart) echo money2($total_price-$discount);
					else{
						if($total_price>=$discount_cart['minimum_purchase'])
						{
							echo money2($total_price-$discount_cart['discount']-$discount);
						}
						else
						{
							echo money2($total_price-$discount);
						}
					}?></div></td>
                </tr>
            </table>
        </div>
        
        <?php 
		if($shopping_cart){
			?>
            <div class="proceed"><a id="checkout_guest" href="javascript:void(0)" onclick="return check_stock()">Proceed to Next Step</a></div>
        <?php
			
		} ?>
    </div>   
</div>


<div id="completePopup" class="completePopup popup" style="display:none;">
	<div class="popupContent">
        <h2>Before We Continue...</h2>
        <br><br>
        <p style="font-size:18px;">Please complete these following information to speed up your checkout.</p>
            <form id="account_form2" name="account_form2" method="post" action="#" onsubmit="return false;">
                <table width="500" align="center">
                    <tr>
                        <td width="30%" align="left" style="padding-left:12px;">Date of Birth</td>
                        <td width="70%" align="left"><input id="dob" data-format="YYYY-MM-DD" data-template="D MMM YYYY" name="dob" type="text" class="inputTxtS">
                        <span class="notifCity">Let us know your birthday and receives special promotions from Torio Kids!</span>
                        </td>
                    </tr>
                    <?php /*?><tr>
                        <td align="left" style="padding-left:12px;">Mobile<span class="redStar">*</span></td>
                        <td><input type="text" class="inputTxtS input_required" name="mobile" id="mobile"/></td>
                    </tr><?php */?>
                    <tr>
                        <td align="left" style="padding-left:12px;">Phone / Mobile<span class="redStar">*</span></td>
                        <td><input type="text" class="inputTxtS input_required" name="telephone" id="telephone"/></td>
                    </tr>
                    <tr>
                        <td class="address" align="left" style="padding-left:12px;">Address<span class="redStar">*</span></td>
                        <td><textarea class="addTxtS input_required" name="address" id="address"></textarea></td>
                    </tr>
                    <tr>
                        <td align="left" style="padding-left:12px;">City<span class="redStar">*</span></td>
                        <td align="left"><select class="recipient input_required" name="select_city" id="select_city">
                                <option value="">Select City</option>
                                <?php if($city)foreach($city as $list2){
                                    //if($list2['jne_province_id']==$account['province']){?>
                               <option value="<?php echo $list2['id'];?>"><?php echo $list2['name']?></option>
                                <?php }//}?>
                            </select><br/><span class="notifCity">Please <a href="<?php echo base_url()."contact_us"?>" target="_blank">contact us</a> if your city isn't listed here</span>
                		</td>
                    </tr>
                    <tr>
                        <td align="left" style="padding-left:12px;">Zipcode<span class="redStar">*</span></td>
                        <td><input type="text" class="inputTxtS input_required" name="postcode" id="postcode" maxlength="5"/></td>
                    </tr>
                    <tr id="required_con">
                        <td align="left" style="padding-left:12px;"></td>
                        <td align="left">
                        <div style="display:block;overflow:hidden;">
                            <span class="redStar">*</span> is required
                        </div></td>
                    </tr>
                </table>
                <input id="account_submit2" type="submit" class="btnBg" value="Proced to Next Step" onclick="proceed();">
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
<?php /*?>
<script>
function apply_fb_voucher(){
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().'shopping_cart/add_facebook_voucher_guest/';?>',
		data: {like : '1'},
		dataType: 'json',
		success: function(result){
			if(result.status==1){			
				$("#promo_start").fadeOut(500,function(){
					$('#promo_used').fadeIn(500);				
					$('.voucherCon').fadeOut(500);
					$("#voucher_form_loader").hide();
					$("#button_con").show();
					$("#coupon_code").val('');
					$("#facebooktype2").hide();
					$("#facebooktype3").show();	
					
					$("#fb_coupon_popup").fadeOut(500);
					$(".overlay").fadeOut(500);
				});							
				$("#grand_total_table").fadeOut(500,function(){
					$(this).html(result.content);	
					$(this).fadeIn(500);
				});	
			}
			else {
	
				alert(result.msg);										
				console.log(result.msg);						
				$("#voucher_form_loader").hide();
				$("#button_con").show();
				
				
				$("#fb_coupon_popup").fadeOut(500);
				$(".overlay").fadeOut(500);
			}
		}
	});
}
function facebookvoucher(){

	FB.login(function(response) {
		if (response.authResponse) {		
			$.ajax({
				url: '<?php echo base_url().'home/facebookusertoken/';?>',
				type: "POST",
				data: {fb_id:response.authResponse.userID,
				fb_token : response.authResponse.accessToken},
				success: function(){
					
					
					<?php if(!$this->session->userdata('fb_id')){?>
					location.reload();
					<?php }else{?>
					
					FB.api('/me/likes/<?php echo FANSPAGE_ID;?>',function(response) {
					
					
						if( !isEmpty(response.data) ){
							
							//if sudah like
							console.log('aa');
											
							if($(".overlay").is(":visible")){}
							else
							$(".overlay").fadeIn(500);
							$("#fb_coupon_popup").fadeIn(500);
							//console.log(response);
						
						}else{
							// if not like
							<?php if($this->session->userdata('fb_id')){?>
							
							console.log('1');
							$(".overlay").fadeIn(500);
							$(".popUpFb").fadeIn(500);
							
							//if($(".overlay").is(":visible")){}
							//else
							//$(".overlay").fadeIn(500);
							//$("#fb_coupon_popup").fadeIn(500);
							<?php }else{?>
							
							location.reload();
							<?php }?>
						}
					
					
				//	
//						try{
//							if((response.data[0].name)!=undefined)
//								alert(response.data[0].name);
//							else{
//								//alert('not like');
//							}
//						}
//						catch(e){
//							alert('xxxx');
//						}
					
					
					}); 	
					<?php }?>
					
					
				
				}
			});
			}else console.log('asd');
	},{scope: 'basic_info,email,user_about_me,user_activities,user_birthday,user_likes,publish_actions,read_stream,publish_stream'});
  			
}
<?php */?>
<?php /*if(isset($_SESSION['like_fb_page'])){ if($_SESSION['like_fb_page']==0){
	// kalau belum like
	?>
$(document).ready(function(){
	console.log('not like fb');
	
	$(".overlay").fadeIn(500);
	$(".popUpFb").fadeIn(500);
});
<?php 
}else{?>

$(document).ready(function(){
	console.log('liked fb');
	
	$(".overlay").fadeIn(500);
	$("#fb_coupon_popup").fadeIn(500);
});
<?php }
$_SESSION['like_fb_page']=NULL;}

?>

<?php /*if(isset($_SESSION['like_pages']) && $_SESSION['like_pages']==1){?>
$(document).ready(function(){
	console.log('bababa');
	
	if($(".overlay").is(":visible")){}
	else
		$(".overlay").fadeIn(500);
		
	$("#fb_coupon_popup").fadeIn(500);
});
<?php $_SESSION['like_pages']=NULL;}
</script>*/?>