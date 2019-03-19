	<script>
function load_address(id){
	if(id==0){
	$("#recipient").val('');
	$("#phone").val('');
	$("#shipping").val('');
	$("#zipcode").val('');
	$("#area_code").val('');
	//$("#mobile").val('');
	$("#select_province").val('0');
	$("#city").val('0');
	$("#uniform-select_province span").html('Select Province');
	$("#select_province option").removeAttr("selected", "selected");
	$("#uniform-city span").html('Select City');
	$("#city option").removeAttr("selected", "selected");
	load_shipping_method(0);
	}else{
	$.ajax({
		type: "POST",
		url: '<?php echo site_url('shopping_cart/load_address').'/';?>'+id,
		beforeSend:function(){
			$("#loader_2").html('<img src="<?php echo base_url();?>templates/images/ajax-loader.gif">');
			$("#loader_2").show();
			$("#recipient_list").hide();
		},
		dataType:"JSON",
		success: function(temp){
			console.log(temp);
		//data=temp.split('|',8);
				<?php /*?>$("#user_address_id").val(data[0]);
				$("#recipient").val(data[1]);
				$("#shipping").val(data[2]);
				$("#phone").val(data[3]);
				$("#mobile").val(data[4]);
				$("#select_province").val(data[5]);
				var province_temp = data[5];<?php */?>
				
				$("#loader_2").hide();
				$("#loader_2").html();
				
				
				$("#user_address_id").val(temp.id);
				$("#recipient").val(temp.recipient_name);
				$("#shipping").val(temp.shipping_address);
				$("#phone").val(temp.phone);
				$("#select_province").val(temp.province);
				var province_temp = temp.province;
				
				var city = temp.city;
				var zipcode = temp.zipcode;
			
				//var city = temp.city;
				$("#recipient_list").show();
				$("#city").val(city);
				
				$("#autokecamatan").val(temp.jne_kecamatan_name);
				load_shipping_method(city);
				
				$("#zipcode").val(zipcode);
				//$("#loader").html('&nbsp;'); <-- removed, moved to #loader_2
		}
	});
	}
}

function load_city(id){
	
	if(id!=0){
		$.ajax({
			type: "POST",
			url: '<?php echo site_url('shopping_cart/load_city').'/';?>'+id,
			beforeSend:function(){
			$("#show_city").html('<img src="<?php echo base_url();?>templates/images/ajax-loader.gif">');
			},
			success: function(temp){
				$("#city").val('0');
				$("#show_city").html(temp);
			}
		});
		}else {
			$("#city").val('0');
		}
}

function load_shipping_method(id){
	if(id!=0){
		$.ajax({
			type: "POST",
			url: '<?php echo site_url('shopping_cart/load_shipping_method').'/';?>'+id,
			beforeSend:function(){
			$("#ship_met").html('<img src="<?php echo base_url();?>templates/images/ajax-loader.gif">');
			},
			success: function(temp){
				$("#ship_met").html(temp);
			}
		});
		}else {
			$("#ship_method").val('0');
		}
}

function submit_form()
{
	if($("#autokecamatan").val()=='' && ($("#city").val()==0 || $("#city").val()=='')){
		alert('Please select city');
		$("#address_checkout_form").attr("onsubmit","return false;");
	}
	else if($("#ship_method").val()=="")
	{
		alert('Please select your shipping method');
		$("#address_checkout_form").attr("onsubmit","return false;");
	}else{
		var province=$("#select_province").val();
		var city=$("#city").val();
		if(province!='' && city!=''){
			$("#address_checkout_form").removeAttr("onsubmit");
			submit_shipping_address();
		}
	}
}
</script>
<?php if($clock_end && $flash_sale_type==2){ ?>
<div class="flashSale">
    <div class="desktopFlashSale">
        <a href="#">
            <img src="<?php echo base_url() ?>userdata/smallbanner/flash_sale.png" alt="flashSaleImg" />
            <div class="fsCd"></div>
        </a>
    </div>
    <div class="mobileFlashSale">
        <a href="#">
            <div class="fsCd"></div>
        </a>
        <span class="flashSaleTxt">Ayo belanja! Produk terbatas! Hanya 3 jam saja!</span>
    </div>
</div>
<?php }?>

<?php if($upcoming_time && $flash_sale_type==2){ ?>
<div class="beforeFlashSale">
    <div class="desktopFlashSale">
        <a href="#">
            <img src="<?php echo base_url() ?>userdata/smallbanner/before_flash_sale.png" alt="flashSaleImg" />
            <div class="beforeFsCd"></div>
        </a>
    </div>
    <div class="mobileFlashSale">
        <a href="#">
            <div class="beforeFsCd"></div>
        </a>
        <span class="flashSaleTxt">Tunggu tanggal 5 Februari 2015!</span>
    </div>
</div>
<?php }?>
<div class="shopCartContent">
    <h2>Shipping</h2>
    <div class="stepShopping">
        <a href="<?php echo site_url('shopping_cart');?>"><div class="firstStepDone">
            Shopping Cart
        </div>
        </a>
        <div class="otherStepDone">
            Shipping
        </div>
        <div class="lastStep">
            Payment
        </div>
    </div>
</div>
<div class="topShopCartInfo">
</div>
<form id="address_checkout_form" name="address_checkout_form" method="post" action="#" onsubmit="return false;">
<div class="shippingCon">
    <div class="shippingBox">
        <div class="shippingCol">
        	<div class="shipping">
                <dd>Select Recipient</dd>
                <dt>
                	<dd id="loader_2" style="display:none"></dd>
                	<span id="recipient_list"><select class="recipient" name="select_recipient" onchange="load_address(this.value);">
                        <option value="">Create New</option>
                        <?php if($address)foreach($address as $list){?>
                       <option value="<?php echo $list['id'];?>" <?php if($detail)if($list['id']==$detail['id'])echo "selected=\"selected\"";?>><?php echo $list['recipient_name']?></option>
                        <?php }?>
                    </select></span>
                </dt>
            </div>
            <div class="shipping">
                <dd>Recipient Name <span class="redStar">*</span></dd>
                <dt><input type="text" name="recipient" class="textTxt validate[required]" id="recipient" value="<?php if($detail)echo $detail['recipient_name']?>"/></dt>
            </div>
        </div>
        <div class="shippingCol">
        	<div class="shipping" id="space">
                <dd>&nbsp;</dd>
                <dt>&nbsp;</dt>
            </div>
            <div class="shipping">
                <dd>Phone / Mobile <span class="redStar">*</span></dd>
                <dt><input type="text" class="textTxt validate[required]" name="phone" id="phone" value="<?php if($detail)echo $detail['phone']?>"/></dt>
            </div>
            <?php /*?><div class="shipping">
                <dd>Mobile <span class="redStar">*</span></dd>
                <dt><input type="text" class="textTxt validate[required]" name="mobile" id="mobile" value="<?php if($detail)echo $detail['mobile']?>"/></dt>
            </div><?php */?>
        </div>
    </div>
    <div class="shippingBox2">
        <div class="shippingCol">
            <div class="shipping">
                <dd>Shipping Address <span class="redStar">*</span></dd>
                <dt><textarea rows="3" name="shipping" id="shipping" class="addressTxt validate[required]"><?php if($detail)echo strip_tags($detail['shipping_address'])?></textarea></dt>
            </div>
            <div class="shipping" id="requireMsg">
            
			        <div style="display:block;overflow:hidden;">
                   		<span class="redStar">*</span> is required
                    </div>
            </div>
        </div>
        <div class="shippingCol">
            <?php /*?><div class="shipping">
                <dd>Province</dd>
                <dt>
                    <select class="recipient" name="select_province" id="select_province" onchange="load_city(this.value);">
                        <option value="">Select Province</option>
                        <?php if($province)foreach($province as $list2){?>
                       <option value="<?php echo $list2['id'];?>" act="<?php echo $list2['name']?>" <?php if($detail)if($list2['id']==$detail['province'])echo "selected=\"selected\""?>><?php echo $list2['name']?></option>
                        <?php }?>
                    </select>
                </dt>
            </div><?php */?>
            <div class="shipping">
          <?php /*?>   <dd>Kota <span class="redStar">*</span></dd>
                <dt id="show_city">
           
					<span class="shippingInfoCon">
                    <div class="ui-widget">
                                <select id="combobox">
                                    <option value="">Select one...</option>
                                 <?php if($province)foreach($province as $list_province){?>
                                 <option <?php if($detail['province']==$list_province['id']){?> selected="selected"<?php } ?> value="<?php echo $list_province['id']?>"><?php echo $list_province['name'];?></option>
                                 <?php } ?>
                            	</select>
                            </div>
                    
              		<input type="hidden" name="select_province" id="select_province"  value="<?php echo $detail['province']?>" onchange="load_city(this.value);" />                  
                    
                   <br/><br />
                
                    </span>
                </dt>
                <?php */?>
                
                <span id="kecamatan_view" >
                <dd>City <span class="redStar">*</span></dd>
                <dt id="show_kecamtan">
					<span class="shippingInfoCon">
					<input type="text" class="textTxt validate[required]" id="autokecamatan" value="<?php if($detail['province'] && $detail['city']) echo api_province_name($detail['province'])." | ".api_city_name($detail['city']);?>" onchange="fill_value(this.value);" />
              		<input type="hidden" name="select_city" id="city" value="<?php echo $detail['city']?>" onchange="load_shipping_method(this.value);" />  
                    
                    <script>
					function fill_value(city_typed){
						if(city_typed==''){
							$("#city").val('0');
						}
					}
					</script>
                    
                    <span class="notifCity">Please <a href="<?php echo site_url('contact_us');?>" target="_blank">contact us</a> if your city isn't listed here</span>
                    </span>
                </dt>
                </span>
                
            </div>
            <div class="shipping">
                <dd>Zip Code <span class="redStar">*</span></dd>
                <dt><input type="text" name="zipcode" id="zipcode" class="textTxt validate[required]" maxlength="5" value="<?php if($detail)echo $detail['zipcode']?>"/></dt>
            </div>
            <div class="shipping">
                <dd>Shipping Method <span class="redStar">*</span></dd>
                <dt id="ship_met">
                	<select class="recipient validate[required]" name="shipping_method" id="ship_method">
                    
                   
					<?php if( $total_price <= $sm['min_purchase'] && $sm['min_purchase']>0 ){?>
                        
								<?php if($sm['regular_fee']!=""){?><option value="<?php echo $sm['regular_fee'];?>">Regular (<?php if($sm['regular_fee']==0)echo "Free"." ".$sm['regular_etd'] . ' days'; else echo money($sm['regular_fee'])." ".$sm['regular_etd'] . ' days';?>)</option>
								<?php } ?>   
                                    
					<?php }else{ ?>
                    	<?php if($sm['min_purchase']>0){?>
                    <option value="0">Regular (Free)</option>
                    	<?php }else{?><option value="<?php echo $sm['regular_fee'];?>">Regular (<?php if($sm['regular_fee']==0)echo "Free"." ".$sm['regular_etd'] . ' days'; else echo money($sm['regular_fee'])." ".$sm['regular_etd'] . ' days';?>)</option>
                        <?php }?>
                    <?php } ?>
                    
                                    
                                    
                        <?php if($sm['express_fee']!=""){?>   
                        <?php if($sm['express_fee']>0){?>
                        <option value="<?php echo $sm['express_fee'];?>">Express (<?php if($sm['express_fee']==0)echo "Free"." ".$sm['express_etd']. ' days'; else echo money($sm['express_fee'])." ".$sm['express_etd']. ' days';?>)</option><?php } ?>
                    <?php } ?>
                    </select>
                </dt>
            </div>
        </div>
    </div>
</div>
<div class="topShopCartInfo"></div>
<div class="botShopCartInfo">
    <div class="botLeftCart">
        <p>Please enter your information and the shipping address information above. Review and ensure that the data is correct before you confirm your order. Torio is not responsible for failure of delivery in result of mistaken address and/or any other shipping information.</p>
    </div>
    <div class="botRightCartCon">
        <div class="proceed">
        <a href="javascript:void(0);" id="address_checkout_submit" onclick="submit_form();">Proceed to Next Step</a>
        </div>
    </div>
</div>
</form>


<script>
  $(function() {
		$("#autokecamatan").autocomplete({	
		  source: '<?php echo site_url('shopping_cart/get_kecamatan')?>',
		   max:30,
			select: function( event, de ) {
				//alert(de.item.id);
				$("#city").val(de.item.id)
				load_shipping_method(de.item.id);									
			}
				
		});
	});		

function clear_id_province(){
	//$("#select_province").val('');
	 //$("#kecamatan_view").hide();
}
function clear_id_city(){
	//$("#city").val('');
}
function get_kecamatan_terbaru(category){
	var target_url='<?php echo site_url('shopping_cart/get_kecamatan_2')?>';
	if(category!="")			
		$("#view_kecamatan_new").html('').load(target_url+'/'+category);
}
$(document).ready(function(e) {

    get_kecamatan_terbaru('<?php echo $detail['province']?>');

});

</script>