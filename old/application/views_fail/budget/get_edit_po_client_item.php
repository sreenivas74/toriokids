<table width="875px" border="1" id="item_product"  class="myform">
    <tr style="background:#F6F6F6">
        <td width="106px" style="text-align:center">Budget</td>
        <td width="352px" style="text-align:center">Desc</td>
        <td width="106px" style="text-align:center">Vendor</td>
        
        <td width="106px" style="text-align:center">Unit Rate</td>
        
        <td width="86px" style="text-align:center">Bank</td>
        <td width="106px" style="text-align:center">Acc. Name</td>
        <td width="106px" style="text-align:center">Acc. Number</td>
    </tr>
    <?php $i = 1;
    if($request_item)foreach($request_item as $listitem){?>
    <tr>
        <td>
        <input type="hidden" name="request_budget_item_id1_<?php echo $i?>" value="<?php echo $listitem['id']?>">
        <select name="poitem1_<?php echo $i?>" style="width:100px">
            <option value="">select model</option>
            <?php if($po_client_item)foreach($po_client_item as $list){?>
                <option value="<?php echo $list['id']?>" <?php if($listitem['project_goal_po_client_item_id']==$list['id'])echo "selected"?>><?php echo $list['item']?></option>
            <?php }?>
        </select>
        
        </td>
        <td><textarea name="desc1_<?php echo $i?>" style="width:350px; height:15px; margin:0; padding:0;"><?php echo $listitem['description']?></textarea></td>
        <td><input type="hidden" name="vendor1_'+total+'" style="width:100px"><select style="width:100px" onchange=get_no_rekening('+total+',this.value)><option>Select Vendor</option><?php if($vendor_list)foreach($vendor_list as $list_vendor){?><option value="<?php echo $list_vendor['id']?>| <?php echo $list_vendor['account_number']?>|<?php echo $list_vendor['name'];?>"><?php echo $list_vendor['name']?></option><?php }?></select></td>
            <input type="hidden" value="1" name="qty1_<?php echo $i?>" id="qty1_<?php echo $i?>" onkeyup="formatAmount(this.value,<?php echo $i?>,'qty1','total1_','qty1_','price1_','disc1_','subtotal1','item_product_total','subtotal3','subtotal','disc3','discount','ppn3','is_ppn','total3')" style="width:50px; text-align:center;" />
            <input type="hidden" name="disc1_<?php echo $i?>" id="disc1_<?php echo $i?>" onkeyup="formatAmount(this.value,<?php echo $i?>,'disc1','total1_','qty1_','price1_','disc1_','subtotal1','item_product_total','subtotal3','subtotal','disc3','discount','ppn3','is_ppn','total3')" style="width:40px; text-align:center"/>
            <input type="hidden" name="total1_<?php echo $i?>" id="total1_<?php echo $i?>" value="<?php echo number_format($listitem['price'])?>" readonly="readonly" style="width:100px; text-align:right"/>
            
            
        <td><input type="text" name="price1_<?php echo $i?>" id="price1_<?php echo $i?>" value="<?php echo number_format($listitem['price'])?>" onkeyup="formatAmount(this.value,<?php echo $i?>,'price1','total1_','qty1_','price1_','disc1_','subtotal1','item_product_total','subtotal3','subtotal','disc3','discount','ppn3','is_ppn','total3')" style="width:100px; text-align:right"/></td>
            
        <td><input type="text" name="bank_name1_<?php echo $i?>" value="<?php echo $listitem['bank_name']?>" style="width:80px"></td>
        <td><input type="text" name="acc_name1_<?php echo $i?>" value="<?php echo $listitem['acc_name']?>" style="width:100px"></td>
        <td><input type="text" name="acc_number1_<?php echo $i?>" value="<?php echo $listitem['acc_number']?>" style="width:100px"></td>
    </tr>
    <?php $i++;
    }?>
    <input type="hidden" name="item_product_total" id="item_product_total" value="<?php echo $i-1?>" />
    <script>
        function add_item_product(){
            var total = parseInt($('#item_product_total').val())+1;
            $('#item_product_total').val(total);
            var str_data = '<tr><input type="hidden" name="request_budget_item_id1_'+total+'" value=""><td><select name="item1_'+total+'" style="width:100px"><option value="">select model</option><?php if($po_client_item)foreach($po_client_item as $list){?><option value="<?php echo $list['id']?>"><?php echo $list['item']?></option><?php }?></select></td><td><textarea name="desc1_'+total+'" style="width:350px; height:15px; margin:0; padding:0;"></textarea></td><td><input type="text" name="vendor1_'+total+'" style="width:100px"></td><input value="1" type="hidden" name="qty1_'+total+'" id="qty1_'+total+'" onkeyup=formatAmount(this.value,'+total+',"qty1","total1_","qty1_","price1_","disc1_","subtotal1","item_product_total","subtotal3","subtotal","disc3","discount","ppn3","is_ppn","total3") style="width:50px; text-align:center;" /><td><input type="text" name="price1_'+total+'" id="price1_'+total+'" onkeyup=formatAmount(this.value,'+total+',"price1","total1_","qty1_","price1_","disc1_","subtotal1","item_product_total","subtotal3","subtotal","disc3","discount","ppn3","is_ppn","total3") style="width:100px; text-align:right"/></td><input type="hidden" name="disc1_'+total+'" id="disc1_'+total+'" onkeyup=formatAmount(this.value,'+total+',"disc1","total1_","qty1_","price1_","disc1_","subtotal1","item_product_total","subtotal3","subtotal","disc3","discount","ppn3","is_ppn","total3") style="width:40px; text-align:center"/><input type="hidden" id="total1_'+total+'" name="total1_'+total+'" value="0" readonly="readonly" style="width:100px; text-align:right"/> <td><input type="text" name="bank_name1_'+total+'" style="width:80px"></td><td><input type="text" name="acc_name1_'+total+'" style="width:100px"></td><td><input type="text" name="acc_number1_'+total+'" style="width:100px"></td></tr>';
            $('#item_product').append(str_data);
        }
        
        function get_price(price,dest){
            $('#'+dest).val(price);
        }
    </script>
</table>