<script type="text/javascript">
<?php /*?>$(function() {
	<?php if($this->session->flashdata('add_notif')){?>
		alert(<?php echo $this->session->flashdata('add_notif'); ?>);
	<?php }?>
	
	var province_list = [
	<?php $s=1;
	if($province); $arr_2 = array(); foreach($province as $list){
				$c = htmlspecialchars($list['name']);
				array_push($arr_2, $c);
			}?>
			<?php $temp = array_unique($arr_2); foreach($temp as $b){
				if ($s==1){ ?>
				"<?php echo $b;?>" 
			<?php } else{ ?>
				,"<?php echo $b;?>"
			<?php }?>
		<?php $s++;}?>
	];
	
	$("#province").autocomplete({
		source: province_list
	});
});<?php */?>

function get_city(value){
	$.ajax({
		type:"POST",
		data:{province_name : value},
		url: base_url+'torioadmin/order/get_city',
		dataType:"JSON",
		success: function(data){
			if(data){
				$('#city').html(data.content);
				$('#shipping_cost').html(data.fee);
			}
		}
	});
}

function get_method(id){

		$.ajax({
			type:"post",
			data:{id : id},
			url: base_url+'torioadmin/order/get_method',
			dataType:"JSON",
			success: function(data){
				if(data) $('#shipping_cost').html(data.content);
			}
		});
	
}
</script>

<div id="content">

<h2>Order &raquo; Add</h2>
<?php if($this->session->flashdata('add_notif')) echo "<font color='green'>".$this->session->flashdata('add_notif')."</font>";?><br>
<form name="order_form" id="order_form" method="post" action="#" >
<table class="defAdminTable" width="70%">
	<tbody>
        <tr>
        	<td style="width:20% !important">Recipient Name</td>
            <td><input type="text" class="txtField" name="recipient_name" id="recipient_name" /> <span style="color:red">*</span></td>
        </tr>
        <tr>
        	<td>Email</td>
            <td><input type="text" class="txtField" name="email" id="email" /> <span style="color:red">*</span></td>
        </tr>
        <tr>
        	<td>Phone</td>
            <td><input type="text" class="txtField" name="phone" id="phone" /> <span style="color:red">*</span></td>
        </tr>
        <tr>
        	<td>Shipping Address</td>
            <td><textarea class="txtField" name="address" id="address" /> </textarea> <span style="color:red">*</span></td>
        </tr>
        <tr>
        	<td>Zipcode</td>
            <td><input type="text" class="txtField" name="zipcode" id="zipcode" /> <span style="color:red">*</span></td>
        </tr>
        <tr>
        	<td>Province and City</td>
            <td><input type="text" class="txtField autokecamatan" name="province_name" id="province_name" onchange="fill_value_recipient(this.value)" /> <span style="color:red">*</span></td>
        </tr>
        <input type="hidden" name="province" id="province_id" />
        <input type="hidden" name="city" id="city_id" />
        <script>
		function fill_value_recipient(city_typed){
			if(city_typed==''){
				$("#city_id").val('0');
				$("#province_id").val('0');
				$('#method').html('<select class="txtField" name="shipping_cost" id="shipping_cost"><option value="">-- select city first --</option></select> <span style="color:red">*</span>');
			}
		}
		</script>
        
        <?php /*?><tr>
        	<td>City</td>
            <td><select class="txtField" name="city" id="city" onchange="get_method(this.value);">
            	<option value="0">-- select province first --</option>
                <?php if($city) foreach($city as $city_list){ ?>
                <option value="<?php echo $city_list['id'] ?>" ><?php echo $city_list['name'] ?></option>
                <?php }?>
            </select> <span style="color:red">*</span></td>
        </tr><?php */?>
        <tr>
        	<td>Payment Type</td>
            <td><select class="txtField" name="payment" id="payment">
            	<option value="1" selected>Bank Transfer</option>
            </select> <span style="color:red">*</span></td>
        </tr>
        <tr>
        	<td>Shipping Cost</td>
            <td id="method"><select class="txtField" name="shipping_cost" id="shipping_cost">
            	<option value="none">-- select city first --</option>
            </select> <span style="color:red">*</span></td>
        </tr>
    </tbody>
</table>
</form>
<h5><i><span style="color:red">*</span> is required</i></h5><br><br>


<h2>Order &raquo; Products</h2>

<table class="defAdminTable" width="100%">
	<thead>
    	<tr>
            <th width="20%">Product</th>
            <th width="10%">Selling Price</th>
            <th width="5%">Weight</th>
            <th width="5%">Quantity</th>
            <th width="15%">Total</th>
        </tr>
    </thead>
    <tbody>
   
<form name="order_item_form" id="order_item_form" method="post" action="#" >
<?php 
$no=1; 
if($product){
	foreach($product as $list){
	$price=find('price', $list['product_id'],'product_tb');
	$msrp=find('msrp', $list['product_id'],'product_tb');
	$weight=find('weight', $list['product_id'],'product_tb');
	?>
    <tr class="form_data">	
        <?php /*?><td valign="top"><input type="checkbox" class="product" name="product[]" id="product_<?php echo $list['id']?>" value="<?php echo $list['id'] ?>" onclick="check_product(<?php echo $list['id'] ?>,this)" /></td><?php */?>
        <?php /*?><input type="hidden" name="sku_id[]" id="sku_id" value="<?php echo $list['id'] ?>" /><?php */?>
        <td valign="top"><?php echo $list['name'];?></td>
        <td valign="top" align="right"><input type="text" class="price" name="price_<?php echo $list['id'] ?>" id="price_<?php echo $list['id'] ?>" value="<?php if($schedule_sale) echo $price; else echo $msrp;?>"></td>
        <td valign="top" align="right"><?php echo $weight." Kg" ?><input type="hidden" class="weight" name="weight_<?php echo $list['id'] ?>" id="weight_<?php echo $list['id'] ?>" value="<?php echo $weight?>"></td>      
        <td valign="top" align="right"><input type="text" class="quantity" name="qty_<?php echo $list['id'] ?>" id="qty_<?php echo $list['id'] ?>" onKeyUp="change_total(<?php echo $list['id'] ?>)" /></td>
        <td valign="top" align="right"><span class="total_each" id="total_<?php echo $list['id'] ?>"><?php echo money(0)?></span><input type="hidden" class="total_price" name="total_price_<?php echo $list['id'] ?>" id="total_price_<?php echo $list['id'] ?>"></td>
        
    </tr>
    
    <?php $no++; }?>
    <tr>
    	<td colspan="3"></td>
        <td>Sub Total</td>
        <td><span id="grand_total"><?php echo money(0) ?></span><input type="hidden" class="grand_total_price" name="grand_total_price" id="grand_total_price"></td>
    </tr>
    <tr>
    	<td colspan="3"></td>
        <td>Total Shipping Cost</td>
        <td><span id="total_shipping"><?php echo money(0) ?></span><input type="hidden" class="total_shipping_price" name="total_shipping_price" id="total_shipping_price"></td>
    </tr>
    <tr>
    	<td colspan="3"></td>
        <td>Grand Total</td>
        <td><span id="grand_total_2"><?php echo money(0) ?></span><input type="hidden" class="total_grand2" name="total_grand2" id="total_grand2"></td>
    </tr>
    
<?php }?>   
    </tbody>
</table>
</form>
<a class="defBtn" href="javascript:void(0)" onclick="resets()"><span>Reset</span></a> <a class="defBtn" href="javascript:void(0)" onclick="form_submit();"><span>Add</span></a>
</div>

<script>
$( document ).ready(function() {
   $(".autokecamatan").autocomplete({	
	  source: '<?php echo site_url('shopping_cart/get_kecamatan')?>',
	   max:30,
		select: function( event, de ) {
			//alert(de.item.id);
			$("#city_id").val(de.item.id);
			$("#province_id").val(de.item.province_id);
			get_method(de.item.id);		
		}
	});
});

function form_submit(){
	var name = $('#recipient_name').val();
	var address = $('#address').val();
	var phone = $('#phone').val();
	var email = $('#email').val();
	var zipcode = $('#zipcode').val();
	var province = $('#province_id').val();
	var city = $('#city_id').val();
	var payment = $('#payment').val();
	var cost = $('#shipping_cost').val();
	var total_qty=0;
	
	var product = [ 
		<?php $no=0; foreach($product as $list){
			if($no==0) echo $list['id'];
			else echo ",".$list['id'];
		$no++;}?>
	];
	
	var id_all = [];
	var qty_all = [];
	var price_all = [];
	
	product.forEach(function(entry){
		var qty = parseInt($('#qty_'+entry).val());
		var price = parseInt($('#price_'+entry).val());
		if(qty && qty > 0 && price && price > 0)
		{
			id_all.push(entry);
			qty_all.push(qty);
			price_all.push(price);
			total_qty++;
		}
	});
	
	if(!name || !address || province==0 || !phone || !email || !zipcode || city==0 || payment==0 || cost=="none")
	{
		alert('Please input all the required fields.');
		return false;
	}
	
	if(total_qty==0)
	{
		alert('At least one product with quantity required.');
		return false;
	}
	else
	{
		if(confirm('Add this order?'))
		{
			var $form = $('#order_form');
		 
			var data2 = {id : id_all, qty : qty_all, price : price_all};
			 
			data2 = $form.serialize() + '&' + $.param(data2);
			
			$.ajax({
				type:'POST',
				url:base_url+'torioadmin/order/add_order_manual',
				data:data2,
				//dataType:'JSON',
				success: function(data){
					if(data==1){
						window.location=base_url+'torioadmin/order/add';
					}
				}
			});
		}
	}
}

function resets(){
	$('.total_each').html("Rp 0,-");
	$('#grand_total').html("Rp 0,-");
	$('#total_shipping').html("Rp 0,-");
	$('#grand_total_2').html("Rp 0,-");
	$('.total_price').val(0);
	$('.grand_total_price').val(0);
	document.order_item_form.reset();
	$('#recipient_name').val('');
	$('#address').val('');
	$('#province').val('');
	$('#city').val(0);
	$('#zipcode').val('');
	$('#payment').val(0);
	$('#phone').val('');
	$('#email').val('');
	$('#shipping_cost').val('none');
}

function check_product(id,cb){
	if(cb.checked){
		$('#qty_'+id).removeAttr('disabled');
	}
	else
	{
		//initialize data of product ID which we disable
		var qty=$('#qty_'+id).val();
		var method = $('#shipping_cost').val();
		var weight = $('#weight_'+id).val();
		var total_weight = parseInt(qty*weight);
		var shipping_cost = parseInt(total_weight*method);
		
		//initialize 3 price of total (sub total, shipping total, and grand total)
		var total = $('#total_price_'+id).val();
		var grand_total = $('#grand_total_price').val();
		var shipping_total = $('#total_shipping_price').val();
		var grand_total_final = $('#total_grand2').val();
		
		//refresh new price for sub total
		var temp = grand_total-total;
		$('#total_'+id).html("Rp 0,-");
		$('#grand_total').html(temp);
		$('#grand_total_price').val(temp);
		
		//refresh new price for shipping total
		$('#total_shipping').html(shipping_total-shipping_cost);
		$('#total_shipping_price').val(shipping_total-shipping_cost);
		
		//refresh new price for grand total
		$('#grand_total_2').html(grand_total_final-total-shipping_cost);
		$('#total_grand2').val(grand_total_final-total-shipping_cost);
		
		//disable qty attribute
		$('#qty_'+id).val("");
		$('#qty_'+id).attr('disabled', 'disabled');
	}
}

function change_total(id){
	var qty = $('#qty_'+id).val();
	var selling_price = $('#price_'+id).val();
	var total = qty*selling_price;
	
	$('#total_'+id).html("Rp "+total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+",-");
	$('#total_price_'+id).val(total);

	var product = [ 
		<?php $no=0; foreach($product as $list){
			if($no==0) echo $list['id'];
			else echo ",".$list['id'];
		$no++;}?>
	];
		
	var total_weight=0;
	var total_shipping=0;
	var grand_total=0;
	
	product.forEach(function(entry){
		var temp = parseInt($('#total_price_'+entry).val());
		var weight = parseFloat($('#weight_'+entry).val());
		var qty = parseInt($('#qty_'+entry).val());
		//console.log(weight);
		if(temp && weight && qty)
		{
			var total2 = temp;
			var weight2 = weight*qty;
			grand_total = parseInt(grand_total+total2);
			total_weight = total_weight+weight2;
			//console.log(total2);
			//console.log(total_weight);
		}
	});
	total_weight = Math.ceil(total_weight);
	console.log(total_weight);
	
	//set new sub total price
	
	
	$('#grand_total_price').val(grand_total);
	$('#grand_total').html("Rp "+grand_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+",-");
	
	var method = $('#shipping_cost').val();
	if(isNaN(method)==false)
	{
		total_shipping = parseInt(method*total_weight);
	}
	
	//set new shipping total price
	$('#total_shipping_price').val(total_shipping);
	$('#total_shipping').html("Rp "+total_shipping.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+",-");
	
	//set new grand total price
	var grand_total_final = parseInt(grand_total+total_shipping);
	$('#total_grand2').val(grand_total_final);
	$('#grand_total_2').html("Rp "+grand_total_final.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+",-");
}

function get_shipping_method(city_id){
	$.ajax({
		type:"POST",
		url:base_url+'shopping_cart/get_shipping_method',
		data:{city_id:city_id},
		dataType:"JSON",
		success: function(temp){
			$('#method').html(temp.content);
		}
	});
}
</script>