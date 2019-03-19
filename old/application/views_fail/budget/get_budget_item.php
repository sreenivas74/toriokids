<table width="1218" border="1" id="item_product"  class="myform">
    <tr style="background:#F6F6F6">
        <td width="106px" style="text-align:center">Budget</td>
        <td width="352px" style="text-align:center">Desc</td>
        <td width="106px" style="text-align:center">Vendor</td>
        <td width="56px" style="text-align:center">Quantity</td>
        
        <td width="106px" style="text-align:center">Unit Rate</td>  
		<td width="106px" style="text-align:center">Discount</td> 
        <td width="86px" style="text-align:center">Subtotal</td>
        <td width="86px" style="text-align:center">PPN</td>
        <td width="86px" style="text-align:center">Total</td>
        
        <td width="86px" style="text-align:center">Bank</td>
        <td width="106px" style="text-align:center">Acc. Name</td>
        <td width="106px" style="text-align:center">Acc. Number</td>
    </tr>
    
        <?php for($i=1;$i<6;$i++){?>
        <tr>
            <td>
            
                <select name="item1_<?php echo $i?>" style="width:100px">
                    <option value="">select model</option>
                    <?php if($budget_list)foreach($budget_list as $list){?>
                                    <option value="<?php echo $list['id']?>"><?php echo $list['name']?></option>
                                <?php }?>
                </select>
            </td>
            <td><textarea name="desc1_<?php echo $i?>" style="width:350px; height:15px; margin:0; padding:0;"></textarea></td>
            <td> <input name="vendor1_<?php echo $i?>" type="hidden" id="vendor1_<?php echo $i?>"/>
            <select style="width:100px" onchange="get_no_rekening('<?php echo $i?>',this.value);" >
            <option value="a">Select Vendor</option>
            <?php if($vendor_list)foreach($vendor_list as $list_vendor){?>
            <option value="<?php echo $list_vendor['id']?> |  <?php echo $list_vendor['account_number']?>|<?php echo $list_vendor['account_name'];?> | <?php echo $list_vendor['bank'];?>"><?php echo $list_vendor['name'];?></option>
            <?php } ?>
            </select>
            </td>
			<td><input type="text" value="" name="qty1_<?php echo $i?>" id="qty1_<?php echo $i?>" onkeyup="formatAmount(this.value,<?php echo $i?>,'qty1','total1_','qty1_','price1_','disc1_','subtotal1','item_product_total','subtotal3','subtotal','disc3','discount','ppn3','is_ppn','total3')" style="width:50px; text-align:center;" /></td>   
            <td><input type="text" name="price1_<?php echo $i?>" id="price1_<?php echo $i?>" onkeyup="formatAmount(this.value,<?php echo $i?>,'price1','total1_','qty1_','price1_','disc1_','subtotal1','item_product_total','subtotal3','subtotal','disc3','discount','ppn3','is_ppn','total3')" style="width:100px; text-align:right"/></td>
            <td><input type="text" name="disc1_<?php echo $i?>" id="disc1_<?php echo $i?>" onkeyup="formatAmount(this.value,<?php echo $i?>,'disc1','total1_','qty1_','price1_','disc1_','subtotal1','item_product_total','subtotal3','subtotal','disc3','discount','ppn3','is_ppn','total3')" style="width:40px; text-align:center"/></td>
            <td><input type="text" name="total1_<?php echo $i?>" id="total1_<?php echo $i?>" value="0" readonly="readonly" style="width:100px; text-align:right"/></td>
            
            
           
            <td><input type="checkbox" name="ppn_check_<?php echo $i?>"  id="ppn_check_<?php echo $i?>"  onclick="formatAmount('99',<?php echo $i?>,'total_after_ppn_','total1_','qty1_','price1_','disc1_','subtotal1','item_product_total','subtotal3','subtotal','disc3','discount','ppn3','is_ppn','total3')" value="1"/></td>
            <td><input type="text" style="text-align:right"  class="for_get_total_ppn"  name="total_after_ppn_<?php echo $i ?>" id="total_after_ppn_<?php echo $i ?>" readonly="readonly"/>
            <input type="hidden"  name="total_after_ppn_2<?php echo $i ?>" id="total_after_ppn_2<?php echo $i ?>" readonly="readonly"/></td>
            
            
            <td><input type="text"  id="bank_name1_<?php echo $i?>" name="bank_name1_<?php echo $i?>" style="width:80px"></td>
            <td><input type="text" id="acc_name1_<?php echo $i?>"  name="acc_name1_<?php echo $i?>" style="width:100px"></td>
            <td><input type="text" id="acc_number1_<?php echo $i?>" name="acc_number1_<?php echo $i?>" style="width:100px"></td>
        </tr>
        <?php }?>
        <input type="hidden" name="item_product_total" id="item_product_total" value="5" />
        
    
</table>
<script>
            function add_item_product(){
				
                var total = parseInt($('#item_product_total').val())+1;
                $('#item_product_total').val(total);
                    var str_data = '<tr><td><select name="item1_'+total+'" style="width:100px"><option value="">select model</option><?php if($budget_list)foreach($budget_list as $list){?><option value="<?php echo $list['id']?>"><?php echo $list['name']?></option><?php }?></select></td><td><textarea name="desc1_'+total+'" style="width:350px; height:15px; margin:0; padding:0;"></textarea></td><td><input type="hidden" name="vendor1_'+total+'" style="width:100px"><select style="width:100px" onchange=get_no_rekening('+total+',this.value)><option>Select Vendor</option><?php if($vendor_list)foreach($vendor_list as $list_vendor){?><option value="<?php echo $list_vendor['id']?>| <?php echo $list_vendor['account_number']?>|<?php echo $list_vendor['account_name'];?> | <?php echo $list_vendor['bank'];?>"><?php echo $list_vendor['name']?></option><?php }?></select></td><td><input value="" type="text" name="qty1_'+total+'" id="qty1_'+total+'" onkeyup=formatAmount(this.value,'+total+',"qty1","total1_","qty1_","price1_","disc1_","subtotal1","item_product_total","subtotal3","subtotal","disc3","discount","ppn3","is_ppn","total3") style="width:50px; text-align:center;" /></td><td><input type="text" name="price1_'+total+'" id="price1_'+total+'" onkeyup=formatAmount(this.value,'+total+',"price1","total1_","qty1_","price1_","disc1_","subtotal1","item_product_total","subtotal3","subtotal","disc3","discount","ppn3","is_ppn","total3") style="width:100px; text-align:right"/></td><td><input type="text" name="disc1_'+total+'" id="disc1_'+total+'" onkeyup=formatAmount(this.value,'+total+',"disc1","total1_","qty1_","price1_","disc1_","subtotal1","item_product_total","subtotal3","subtotal","disc3","discount","ppn3","is_ppn","total3") style="width:40px; text-align:center"/></td><td><input type="text" name="total1_'+total+'" id="total1_'+total+'" value="" readonly="readonly" style="width:100px; text-align:right"/></td><td><input type="checkbox" name="ppn_check_'+total+'"  id="ppn_check_'+total+'"  onclick="formatAmount(99,'+total+',\'total_after_ppn_\',\'total1_\',\'qty1_\',\'price1_\',\'disc1_\',\'subtotal1\',\'item_product_total\',\'subtotal3\',\'subtotal\',\'disc3\',\'discount\',\'ppn3\',\'is_ppn\',\'total3\')" value="1"/></td><td><input type="text" style="text-align:right"  class="for_get_total_ppn"  name="total_after_ppn_'+total+'" id="total_after_ppn_'+total+'" readonly="readonly"/><input type="hidden"  name="total_after_ppn_2'+total+'" id="total_after_ppn_2'+total+'" readonly="readonly"/></td><td><input type="text" id="bank_name1_'+total+'" name="bank_name1_'+total+'" style="width:80px"></td><td><input type="text" name="acc_name1_'+total+'" id="acc_name1_'+total+'" style="width:100px"></td><td><input type="text" id="acc_number1_'+total+'" name="acc_number1_'+total+'" style="width:100px"></td></tr>';
                $('#item_product').append(str_data);
            }
            
            /*function get_price(price,dest){
                $('#'+dest).val(price);
            }*/
        </script>