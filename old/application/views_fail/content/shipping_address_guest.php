<script>
<?php if($this->session->flashdata('notif')){?>
alert('<?php echo $this->session->flashdata('notif')?>');
<?php }?>
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
		$("#address_checkout_form2").attr("onsubmit","return false;");
	}
	else if($("#ship_method").val()=="")
	{
		alert('Please select your shipping method');
		$("#address_checkout_form2").attr("onsubmit","return false;");
	}else{
		$("#address_checkout_form2").removeAttr("onsubmit");submit_shipping_address_guest();
	}
}
$(document).ready(function(){
	$("#check1").click(function(){
		if($(this).is(":checked")){
			$("#recipient").val($("#personal_name").val());
			$("#shipping").val($("#personal_billing_address").val());
			$("#phone").val($("#personal_phone").val());
		}
		else{
			$("#recipient").val('');
			$("#shipping").val('');
			$("#phone").val('');
		}
	});
});

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
</script>

<?php //pre($this->session->userdata)?>
<?php if($clock_end){ ?>
<div class="flashSale">
    <a href="#">
        <img src="<?php echo base_url() ?>userdata/smallbanner/flash_sale.png" />
        <span class="flashSaleTxt">Come & Get it! This Day Only!  <span id="clock"></span></span>
    </a>
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
        	<h3>Personal Info</h3>
        </div>
	<?php $address_guest=$this->session->userdata('address_guest');
	
	if($address_guest){
		$personal_name=$address_guest['personal_name'];
		$personal_email=$address_guest['personal_email'];
		$personal_phone=$address_guest['personal_phone'];
		$personal_billing_address=$address_guest['personal_billing_address'];
		
		$recipient=$address_guest['recipient'];
		$phone=$address_guest['phone'];
		$shipping=$address_guest['shipping_address'];
		$zipcode=$address_guest['zipcode'];
		//$citys=$address_guest['city'];
		
	}
	else{
		
		
		$personal_name='';
		$personal_email='';
		$personal_phone='';
		$personal_billing_address='';
		
		$recipient='';
		$phone='';
		$shipping='';
		$zipcode='';
		
	}
	?>
        <form id="address_checkout_form2" name="address_checkout_form2" method="post" action="#" onsubmit="return false;">
        <div class="shippingCon">
        	<div class="shippingBox">
            	<div class="shippingCol">
                	<div class="shipping">
                        <dd>Name</dd>
                        <dt><input type="text" class="textTxt validate[required]" name="personal_name" id="personal_name" value="<?php echo $personal_name;?>" /></dt>
                    </div>
                    <div class="shipping">
                        <dd>Email</dd>
                        <dt><input type="text" class="textTxt validate[required,custom[email]]" name="personal_email" id="personal_email" value="<?php echo $personal_email;?>" /></dt>
                    </div>
                    <div class="shipping">
                        <dd>Mobile / Phone</dd>
                        <dt><input type="text" class="textTxt validate[required]" name="personal_phone" id="personal_phone" value="<?php echo $personal_phone;?>" /></dt>
                    </div>
                    <div class="shipping">
                        <dd>Billing Address</dd>
                        <dt><textarea rows="6" class="addressTxt validate[required]" name="personal_billing_address" id="personal_billing_address"><?php echo $personal_billing_address;?></textarea></dt>
                    </div>
                </div>
            </div>
        </div>
        <div class="topShopCartInfo">
        	<h3>Shipping Info</h3>
        </div>
        	<div class="labelCon">
        		<input id="check1" type="checkbox" class="checkbox_01" name="check" value="check1">  
    			<label for="check1" class="label_01">Same as above</label>
            </div> 
            
            <div class="shippingBox">
            	<div class="shippingCol"> 
                	<div class="shipping">
                        <dd>Recipient Name</dd>
                        <dt><input type="text" name="recipient" class="textTxt validate[required]" id="recipient" value="<?php echo $recipient;?>" /></dt>	
                    </div>
                </div>
                <div class="shippingCol">
                    <div class="shipping">
                        <dd>Phone / Mobile</dd>
                		<dt><input type="text" class="textTxt validate[required]" name="phone" id="phone" value="<?php echo $phone;?>" /></dt>
                    </div>
                </div>
            </div>
            <div class="shippingBox2">
           		<div class="shippingCol">
                	<div class="shipping">
                        <dd>Shipping Address</dd>
                		<dt><textarea rows="6" name="shipping" id="shipping" class="addressTxt validate[required]"><?php echo $shipping;?></textarea></dt>
                    </div>
                </div>
                <div class="shippingCol">
                	<div class="shipping">
                        <span id="kecamatan_view" >
                        <dd>City</dd>
                        <dt id="show_kecamtan">
                   
                            <span class="shippingInfoCon">
                            <input type="text" class="textTxt validate[required]" id="autokecamatan" onchange="fill_value(this.value);" />
                            <input type="hidden" name="select_city" id="city" onchange="load_shipping_method(this.value);" />  
                            
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
                        <dd>Zip Code</dd>
                		<dt><input type="text" name="zipcode" id="zipcode" class="textTxt validate[required]" maxlength="5" value="<?php echo $zipcode;?>" /></dt>
                    </div>
                    <div class="shipping">
                        <dd>Shipping Method</dd>
                		<dt id="ship_met">
                            <span class="shippingInfoCon">
                            <select class="recipient validate[required]" name="shipping_method" id="ship_method">
                        		<option value="">Select City First</option>
                            </select>
                            </span>
                        </dt>
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
        <a href="javascript:void(0);" id="address_checkout_submit2" onclick="submit_form();">Proceed to Next Step</a>
        </div>
    </div>
</div>
</form>