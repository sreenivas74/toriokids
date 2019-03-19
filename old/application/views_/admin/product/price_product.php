<div id="content">
    <h2>Product &raquo; Price List</h2>
  <div id="submenu">
        <ul>
            <li><a class="defBtn" href="#" onClick="update_price();return false;"><span>Update</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                
                <th width="20%">Name</th>
           
                <th width="10%">MSRP</th>
                <th width="10%">Discount</th>
                <th width="10%">Selling Price</th>
       
            </tr>
        </thead>
        <tbody>
        <form method="post" id="submit_product_price" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/submit_product_price');?>">
        <?php $no=1; 
			  if($product_list)foreach($product_list as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><input type="text" class="txtField msrp_price" name="msrp[]" value="<?php echo $list['msrp'];?>"></td>
               
    			<td valign="top"><input type="text" class="txtField discount_price" name="discount[]" value="<?php echo $list['discount']?>"  /></td>
    			<td valign="top">
                <input type="hidden" name="id[]" value="<?php echo $list['id']?>">
				<input type="text" class="txtField selling_price" name="price[]" value="<?php echo $list['price'];?>"></td>
    		</tr>
    		<?php $no++; } else if(!$product_list){ ?> 
            <tr>
                <td colspan="9"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
           </form>
        </tbody>
    </table>
     <div id="submenu">
        <ul>
            <li><a class="defBtn" href="#" onClick="update_price();return false;"><span>Update</span></a></li>
        </ul>
    </div>
</div>
<script>
function update_price(){
	 if(confirm('Confirm?')){
		$('#submit_product_price').submit();
	 }
}


$(document).ready(function(e) {
    $(".msrp_price").keyup(function(){
		discount=$(this).parents('tr').find('.discount_price').val();
		discount=parseInt(discount);
		
		msrp_price=$(this).val();
		msrp_price=parseInt(msrp_price);
		
		selling_price=(msrp_price*(100-discount)/100);
		
		$(this).parents('tr').find('.selling_price').val(selling_price);
	});
    $(".discount_price").keyup(function(){
		discount=$(this).val();
		discount=parseInt(discount);
		
		msrp_price=$(this).parents('tr').find('.msrp_price').val();
		msrp_price=parseInt(msrp_price);
		
		selling_price=(msrp_price*(100-discount)/100);
		
		if(!isNaN(selling_price))
		$(this).parents('tr').find('.selling_price').val(selling_price);
		else 
		$(this).parents('tr').find('.selling_price').val(0);
		
	});
    $(".selling_price").keyup(function(){
		
		selling_price=$(this).val();
		selling_price=parseInt(selling_price);
		
		msrp_price=$(this).parents('tr').find('.msrp_price').val();
		msrp_price=parseInt(msrp_price);
		
		discount=((msrp_price-selling_price)/msrp_price)*100;
		discount=discount.toFixed(2);
		
		if(!isNaN(discount))
		$(this).parents('tr').find('.discount_price').val(discount);
		else 
		$(this).parents('tr').find('.discount_price').val(0);
	});
});
</script>