<style>
	table.noneBorder tr td{
		border:none;
	}
</style>
<div style="margin:4px">
    <form name="edit_request_budget_form" id="edit_request_budget_form" method="post" action="<?php echo site_url('budget/do_edit_request_budget/'.$request_detail['id'])?>">
    	<input type="hidden" id="request_id" value="<?php echo $request_detail['id']?>" />
    	<input type="hidden" name="bs" value="<?php echo $request_detail['bs']?>" />
    	<input type="hidden" name="current_total" value="<?php echo ($request_detail['total'])?>" />
      
        <div style="width:600px">
            <div style="width:400px; float:left">
                <table class="noneBorder myform" width="400px" >
                    <tr>
                        <td>Request Date</td>
                        <td><input type="text" class="date_selection" name="request_date" id="request_date" readonly="readonly" value="<?php echo date('Y-m-d',strtotime($request_detail['request_date']))?>" /></td>
                    </tr>
                    
                    <tr>
                        <td valign="top">Project</td>
                        <td><input type="text" name="project_name" id="project_name" readonly="readonly" value="<?php echo find('name',$request_detail['project_id'],'project_tb')?>" onclick="$('#project_list').toggle();" />
                            <input type="hidden" name="project_id" id="project_id" value="<?php echo $request_detail['project_id']?>" /><br />
                            <span style="font-size:9px">*empty it if operational expenses</span>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="width:200px; float:left">
                <table class="noneBorder myform" style="width:50px">
                    <?php /*?><tr>
                        <td>PPn</td>
                        <td><input type="checkbox" name="is_ppn" id="is_ppn" value="1" <?php if($request_detail['is_ppn'])echo "checked=checked"?>></td>
                    </tr><?php */?>
                    
                    <tr>
                        <td>Bon Sementara</td>
                        <td><input type="checkbox" name="bs" id="bs" value="1" onclick="$('#employee_name').toggle();$('#employee_name').val('');$('#employee_list').val('');" <?php if($request_detail['bs'])echo "checked=checked"?>>
                            <input type="text" readonly="readonly" id="employee_name" name="employee_name" <?php if($request_detail['bs']==0){?>style="display:none"<?php }?> onclick="$('#employee_list').toggle();" value="<?php echo find('firstname',$request_detail['bs_employee_id'],'employee_tb').' '.find('lastname',$request_detail['bs_employee_id'],'employee_tb')?>" />
                            <input type="hidden" id="employee_id" name="employee_id" value="<?php echo $request_detail['bs_employee_id']?>" />
                        </td>
                    </tr>
                    <tr>
                    	<td>Reimburse ke Client</td>
                        <td><input type="checkbox" name="reimburse" id="reimburse" value="1" <?php if($request_detail['reimburse'])echo "checked=checked"?>></td>
                    </tr>
                </table>
            </div>
        </div>
        
    <div style="clear:both"></div><br />
    <div id="employee_list" style="display:none">
        <table id="flexi2"></table>
        <script type="text/javascript">
        $("#flexi2").flexigrid({
            url: '<?php echo site_url('employee/employee_flexi_request_fund'); ?>',
            dataType: 'json',
            colModel : [
                {display: 'Project Name', name : 'name', width : 70, sortable : true, align: 'left'},
				{display: 'Company', name : 'company', width : 150, sortable : false, align: 'center'},
				{display: 'Firstname', name : 'firstname', width : 100, sortable : true, align: 'left'},
				{display: 'Lastname', name : 'lastname', width : 100, sortable : true, align: 'left'}
            ],
            
            searchitems : [
                {display: 'Firstname', name : 'firstname', isdefault: true},
                {display: 'Lasstname', name : 'lastname', isdefault: true}
            ],
            sortname: "",
            sortorder: "",
            usepager: true,
            useRp: true,
            rp: 50,
            singleSelect: true,
            showTableToggleBtn: false,
            showToggleBtn: false, 
            height: 300,
            width: 550
        });
		function add_employee_bs(name,id){
			$("#employee_name").val(name);
			$("#employee_id").val(id);
			$("#employee_list").hide();
		}
        </script>
    </div>
        <div style="clear:both"></div><br />
        <div id="project_list" style="display:none">
            <table id="flexi"></table>
            <script type="text/javascript">
            $("#flexi").flexigrid({
                url: '<?php echo site_url('project/crm_flexi_2'); ?>',
                dataType: 'json',
                colModel : [
                    {display: 'Project Name', name : 'name', width : 220, sortable : true, align: 'left'},
                    {display: 'Client', name : 'client_id', width : 150, sortable : false, align: 'left'},
                    {display: 'Marketing', name : 'employee_id', width : 100, sortable : false, align: 'center'}
                ],
                
                searchitems : [
                    {display: 'Project Name', name : 'name', isdefault: true}
                ],
                sortname: "",
                sortorder: "",
                usepager: true,
                useRp: true,
                rp: 50,
                singleSelect: true,
                showTableToggleBtn: false,
                showToggleBtn: false, 
                height: 300,
                width: 550
            });
            
            function get_project(id,name){
                $('#project_id').val(id);
                $('#project_name').val(name);
                $('#project_list').hide();
				
				var request_id = $('#request_id').val();
				
				$.ajax({
					url:"<?php echo site_url('budget/cek_edit_project_win/')?>/"+id+'/'+request_id,
					success: function(temp){
						var data = temp.split("|");
						if(data[0]==1){
							$('#item_selection').html('');
							$('#item_selection').html(data[1]);
						}else{
							$('#item_selection').html('');
							$('#item_selection').html(data[1]);
						}
					}
				})
            }
            </script>
        </div>
        
        <div id="item_selection">
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
                <?php $i = 1;
				$before_ppn=0;$after_ppn=0;
                if($request_item)foreach($request_item as $listitem){
					$ppn=$listitem['ppn'];
					$before_ppn+=$listitem['subtotal'];
					if($ppn==1)
					$after_ppn+=$listitem['subtotal']*1.1;
					else
					$after_ppn+=$listitem['subtotal'];
					?>
                <tr>
                    <td>
                    <input type="hidden" name="request_budget_item_id1_<?php echo $i?>" value="<?php echo $listitem['id']?>">
                    
                    <?php if($budget_list){?>
                        <select name="item1_<?php echo $i?>" id="item_<?php echo $i?>" style="width:100px">
                            <option value="" style="color:#F00;">remove model</option>
                            <?php if($budget_list)foreach($budget_list as $list){?>
                                <option value="<?php echo $list['id']?>" <?php if($listitem['budget_id']==$list['id'])echo "selected"?>><?php echo $list['name']?></option>
                            <?php }?>
                        </select>
                    <?php }elseif($po_client_item){?>
                    	<select name="poitem1_<?php echo $i?>" id="item_<?php echo $i?>" style="width:100px">
                            <option value="" style="color:#F00;">remove model</option>
                            <?php if($po_client_item)foreach($po_client_item as $list){?>
                                <option value="<?php echo $list['id']?>" <?php if($listitem['project_goal_po_client_item_id']==$list['id'])echo "selected"?>><?php echo find('item',$list['item'],'stock_tb');?></option>
                            <?php }?>
                        </select>
                    <?php }?>
                    
                    </td>
                  
                    <td><textarea name="desc1_<?php echo $i?>" style="width:350px; height:15px; margin:0; padding:0;"><?php echo $listitem['description']?></textarea></td>
                    <td> <input name="vendor1_<?php echo $i?>" type="hidden" id="vendor1_<?php echo $i?>" value="<?php echo $listitem['vendor_name'];?>"/>
                        <select style="width:100px" onchange="get_no_rekening('<?php echo $i?>',this.value);" >
                        <option value="a">Select Vendor</option>
                        <?php if($vendor_list)foreach($vendor_list as $list_vendor){?>
                        <option value="<?php echo $list_vendor['id']?>| <?php echo $list_vendor['account_number']?>|<?php echo $list_vendor['account_name'];?> | <?php echo $list_vendor['bank'];?>" <?php if($list_vendor['id']==$listitem['vendor_name'])echo "selected=\"selected\"";?>><?php echo $list_vendor['name'];?></option>
                        <?php } ?>
                        </select></td>
                     <td><input type="text" value="<?php echo $listitem['quantity']?>" name="qty1_<?php echo $i?>" id="qty1_<?php echo $i?>" onkeyup="formatAmount(this.value,<?php echo $i?>,'qty1','total1_','qty1_','price1_','disc1_','subtotal1','item_product_total','subtotal3','subtotal','disc3','discount','ppn3','is_ppn','total3')" style="width:50px; text-align:center;" /></td>
                      
                      <td>  <input type="text" name="price1_<?php echo $i?>" id="price1_<?php echo $i?>" value="<?php echo number_format($listitem['price'])?>" style="width:100px; text-align:right" onkeyup="formatAmount(this.value,<?php echo $i?>,'price1','total1_','qty1_','price1_','disc1_','subtotal1','item_product_total','subtotal3','subtotal','disc3','discount','ppn3','is_ppn','total3')" />
                        </td>
<td>                       
                            <input type="text" name="disc1_<?php echo $i?>" id="disc1_<?php echo $i?>" onkeyup="formatAmount(this.value,<?php echo $i?>,'disc1','total1_','qty1_','price1_','disc1_','subtotal1','item_product_total','subtotal3','subtotal','disc3','discount','ppn3','is_ppn','total3')" style="width:40px; text-align:center" value="<?php echo number_format($listitem['discount'])?>"/>
                            </td>
                        
                     <td>
                            <input type="text" name="total1_<?php echo $i?>" id="total1_<?php echo $i?>"  readonly="readonly" style="width:100px; text-align:right" value="<?php echo number_format($listitem['subtotal']);?>"/></td>
                            <td><input type="checkbox" name="ppn_check_<?php echo $i?>"  id="ppn_check_<?php echo $i?>"  onclick="formatAmount('99',<?php echo $i?>,'total_after_ppn_','total1_','qty1_','price1_','disc1_','subtotal1','item_product_total','subtotal3','subtotal','disc3','discount','ppn3','is_ppn','total3')" value="1" <?php if($listitem['ppn']==1){?> checked="checked" <?php }?>/></td>
                            <td><input type="text" style="text-align:right"  class="for_get_total_ppn"  name="total_after_ppn_<?php echo $i ?>" id="total_after_ppn_<?php echo $i ?>" readonly="readonly" value="<?php echo ($listitem['ppn']==1)?number_format($listitem['subtotal']*1.1):number_format($listitem['subtotal']);?>"/>
                            <input type="hidden"  name="total_after_ppn_2<?php echo $i ?>" id="total_after_ppn_2<?php echo $i ?>" readonly="readonly"/></td>
                        
                    <td><input type="text" id="bank_name1_<?php echo $i?>" name="bank_name1_<?php echo $i?>" value="<?php echo $listitem['bank_name']?>" style="width:80px"></td>
                    <td><input type="text" id="acc_name1_<?php echo $i?>"  name="acc_name1_<?php echo $i?>" value="<?php echo $listitem['acc_name']?>" style="width:100px"></td>
                    <td><input type="text" id="acc_number1_<?php echo $i?>" name="acc_number1_<?php echo $i?>" value="<?php echo $listitem['acc_number']?>" style="width:100px"></td>
                </tr>
                <?php $i++;
                }?>
                <input type="hidden" name="item_product_total" id="item_product_total" value="<?php echo $i-1?>" />
                <?php if($budget_list){?>
                <script>
                    function add_item_product(){
						var total = parseInt($('#item_product_total').val())+1;
						$('#item_product_total').val(total);
						
						var select_item='<select name="item1_'+total+'" style="width:100px"><option value="">select model</option><?php foreach($budget_list as $list){?><option value="<?php echo $list['id']?>"><?php echo $list['name']?></option><?php }?></select>';
						
						
						
						var str_data = '<tr><td>'+select_item+'</td><td><textarea name="desc1_'+total+'" style="width:350px; height:15px; margin:0; padding:0;"></textarea></td><td><input type="hidden" name="vendor1_'+total+'" style="width:100px"><select style="width:100px" onchange=get_no_rekening('+total+',this.value)><option>Select Vendor</option><?php if($vendor_list)foreach($vendor_list as $list_vendor){?><option value="<?php echo $list_vendor['id']?>| <?php echo $list_vendor['account_number']?>|<?php echo $list_vendor['account_name'];?> | <?php echo $list_vendor['bank'];?>"><?php echo $list_vendor['name']?></option><?php }?></select></td><td><input value="" type="text" name="qty1_'+total+'" id="qty1_'+total+'" onkeyup=formatAmount(this.value,'+total+',"qty1","total1_","qty1_","price1_","disc1_","subtotal1","item_product_total","subtotal3","subtotal","disc3","discount","ppn3","is_ppn","total3") style="width:50px; text-align:center;" /></td><td><input type="text" name="price1_'+total+'" id="price1_'+total+'" onkeyup=formatAmount(this.value,'+total+',"price1","total1_","qty1_","price1_","disc1_","subtotal1","item_product_total","subtotal3","subtotal","disc3","discount","ppn3","is_ppn","total3") style="width:100px; text-align:right"/></td><td><input type="text" name="disc1_'+total+'" id="disc1_'+total+'" onkeyup=formatAmount(this.value,'+total+',"disc1","total1_","qty1_","price1_","disc1_","subtotal1","item_product_total","subtotal3","subtotal","disc3","discount","ppn3","is_ppn","total3") style="width:40px; text-align:center"/></td><td><input type="text" id="total1_'+total+'" name="total1_'+total+'" value="" readonly="readonly" style="width:100px; text-align:right"/> </td><td><input type="text" id="bank_name1_'+total+'" name="bank_name1_'+total+'" style="width:80px"></td><td><input type="text" name="acc_name1_'+total+'" id="acc_name1_'+total+'" style="width:100px"></td><td><input type="text" id="acc_number1_'+total+'" name="acc_number1_'+total+'" style="width:100px"></td></tr>';
                        $('#item_product').append(str_data);
                    }
                    
                    function get_price(price,dest){
                        $('#'+dest).val(price);
                    }
                </script>
                <?php }else{?>
                <script>
				
                    function add_item_product(){
                        var total = parseInt($('#item_product_total').val())+1;
                        $('#item_product_total').val(total);
						<?php if($po_client_item){?>
						var select_item='<select name="poitem1_'+total+'" style="width:100px"><option value="">select model</option><?php foreach($po_client_item as $list){?><option value="<?php echo $list['id']?>"><?php echo find('item',$list['item'],'stock_tb')?></option><?php }?></select>';
						<?php }?>
                       var str_data = '<tr><td>'+select_item+'</td><td><textarea name="desc1_'+total+'" style="width:350px; height:15px; margin:0; padding:0;"></textarea></td><td><input type="hidden" name="vendor1_'+total+'" style="width:100px"><select style="width:100px" onchange=get_no_rekening('+total+',this.value)><option>Select Vendor</option><?php if($vendor_list)foreach($vendor_list as $list_vendor){?><option value="<?php echo $list_vendor['id']?>| <?php echo $list_vendor['account_number']?>|<?php echo $list_vendor['account_name'];?> | <?php echo $list_vendor['bank'];?>"><?php echo $list_vendor['name']?></option><?php }?></select></td><td><input value="" type="text" name="qty1_'+total+'" id="qty1_'+total+'" onkeyup=formatAmount(this.value,'+total+',"qty1","total1_","qty1_","price1_","disc1_","subtotal1","item_product_total","subtotal3","subtotal","disc3","discount","ppn3","is_ppn","total3") style="width:50px; text-align:center;" /></td><td><input type="text" name="price1_'+total+'" id="price1_'+total+'" onkeyup=formatAmount(this.value,'+total+',"price1","total1_","qty1_","price1_","disc1_","subtotal1","item_product_total","subtotal3","subtotal","disc3","discount","ppn3","is_ppn","total3") style="width:100px; text-align:right"/></td><td><input type="text" name="disc1_'+total+'" id="disc1_'+total+'" onkeyup=formatAmount(this.value,'+total+',"disc1","total1_","qty1_","price1_","disc1_","subtotal1","item_product_total","subtotal3","subtotal","disc3","discount","ppn3","is_ppn","total3") style="width:40px; text-align:center"/></td><td><input type="text" id="total1_'+total+'" name="total1_'+total+'" value="" readonly="readonly" style="width:100px; text-align:right"/> </td><td><input type="hidden" name="total_after_ppn_2'+total+'" id="total_after_ppn_2'+total+'" readonly="readonly"/><input type="checkbox" name="ppn_check_'+total+'" id="ppn_check_'+total+'"  onclick=formatAmount("99",'+total+',"total_after_ppn_","total1_","qty1_","price1_","disc1_","subtotal1","item_product_total","subtotal3","subtotal","disc3","discount","ppn3","is_ppn","total3") value="1"/></td><td><input type="text" style="text-align:right"  class="for_get_total_ppn" name="total_after_ppn_'+total+'" id="total_after_ppn_'+total+'" readonly="readonly"/></td><td><input type="text" id="bank_name1_'+total+'" name="bank_name1_'+total+'" style="width:80px"></td><td><input type="text" name="acc_name1_'+total+'" id="acc_name1_'+total+'" style="width:100px"></td><td><input type="text" id="acc_number1_'+total+'" name="acc_number1_'+total+'" style="width:100px"></td></tr>';
                        $('#item_product').append(str_data);
                    }
                    
                    function get_price(price,dest){
                        $('#'+dest).val(price);
                    }
                </script>
                <?php }?>
            </table>
       </div>
       <table width="1106px" id="item_product" style="display:block">
            <tr style="background:#F6F6F6">
                <td width="780px" style="text-align:right">Sub Total &nbsp;</td>
                <?php /*?><td width="120px"><input type="text" id="subtotal1" name="subtotal1" value="<?php echo number_format($request_detail['total_before_ppn'])?>" readonly="readonly" style="width:100px; text-align:right"/></td><?php */?>
                
                <td width="120px"><input type="text" id="subtotal1" name="subtotal1" value="<?php echo number_format($before_ppn)?>" readonly="readonly" style="width:100px; text-align:right"/></td>
                   <td >Total</td>
           <td><input type="text" id="grand_total_after_ppn" name="grand_total_after_ppn" value="<?php echo number_format($after_ppn)?>" readonly="readonly" style="width:100px; text-align:right"/></td>
           <?php /*?><td><input type="text" id="grand_total_after_ppn" name="grand_total_after_ppn" value="<?php echo number_format($request_detail['total'])?>" readonly="readonly" style="width:100px; text-align:right"/></td><?php */?>
            </tr>
        </table>
        
        
        
            
        <input type="button" value="+ product" onclick="add_item_product()" /><br /><br />
            
        <table width="845px" border="0" id="item_product">
                <tr style="display:none">
                    <td width="730px" style="text-align:right;">Sub Total &nbsp;</td>
                    <td width="106px"><input type="text" name="subtotal3" id="subtotal3" value="0" readonly="readonly" style="width:100px; text-align:right"/></td>
                </tr>
                <tr style="display:none">
                    <td width="730px" style="text-align:right;">Discount % <input type="text" style="width:20px; text-align:center" name="discount" id="discount" value="0" onkeyup="formatAmount(this.value,'','discount','','','','','','','subtotal3','subtotal','disc3','discount','ppn3','is_ppn','total3')"  />&nbsp;</td>
                    <td width="106px"><input type="text" name="disc3" id="disc3" value="0" readonly="readonly" style="width:100px; text-align:right"/></td>
                </tr>
                <tr style="display:none">
                    <td width="730px" style="text-align:right;">PPN &nbsp;</td>
                    <td width="106px"><input type="text" name="ppn3" id="ppn3" value="0" readonly="readonly" style="width:100px; text-align:right"/></td>
                </tr>
                <tr style="display:none">
                    <td width="730px" style="text-align:right;">Total &nbsp;</td>
                    <td width="106px"><input type="text" name="total3" id="total3" value="0" readonly="readonly" style="width:100px; text-align:right;"/></td>
                </tr>
            </table>
        
        <b>Notes</b><br />
        <textarea name="notes" rows="1" cols="80"><?php echo $request_detail['notes']?></textarea><br /><br />
        <?php if($request_detail['bs']==1 && !find_2('id','request_budget_id',$request_detail['id'],'request_budget_log_tb')){?>
        	<input type="checkbox" name="budget_log_check" value="1" /> <span style="color:#F00">*check this if this request is not "BS" anymore. The old one will be saved.</span><br /><br />
        <?php }?>
    
    	<input type="button" value="Update" onclick="enterform_request();" style="height:27px" />
</form>
</div>
<script>
	function enterform_request(){
		var request_date = $('#request_date').val();
		if(!request_date){
			alert('Please insert your request date.');
			return false;
		}else{
			if(confirm('Update Data?'))
			$('#edit_request_budget_form').submit();
		}
	}
	
	function formatAmount(number,id,variable,dest,src1,src2,src3,subtotal,src4,subtotal_dest,subtotal_src,disc_dest,disc_src,ppn_dest,ppn_src,total_dest) {
		//console.log(number);
		if(number!=''){ //validation for checkbox ppn
			// remove all the characters except the numeric values
			number = number.replace( /[^0-9]/g, '' );
			
			// change the splitter to "."
			number = number.replace( /\./g, '.' );
		}
	
		if(id!=''){
			// format the amount
			x = number.split( ',' );
			x1 = x[0];
			x2 = x.length > 1 ? ',' + x[1] : '';
			if(id!=0){
				$('#'+variable+'_'+id).val(formatAmountNoDecimals( x1 ) + x2);
			}else{
				$('#'+variable+'_'+id).val(formatAmountNoDecimals( x1 ) + x2);
			}
			
			//calculate total per item
			var qty = parseInt($('#'+src1+id).val().replace( /[^0-9]/g, '' ));
			var unitrate = parseInt($('#'+src2+id).val().replace( /[^0-9]/g, '' ));
			var disc = parseInt($('#'+src3+id).val().replace( /[^0-9]/g, '' ));
		
			if(!qty)qty = 0;
			if(!unitrate)unitrate = 0;
			if(!disc)disc = 0;
			
			var totalunit = (qty*unitrate) - ((qty*unitrate)*disc/100);
			$("#total_after_ppn_2"+id).val(Math.floor(totalunit*1.1));
			$('#'+dest+id).val(Math.floor(totalunit));
			formatAmountA(id,dest);
			////////////////////////////////////////////////////////////
			
			//calculate subtotal per group
			var group_total = parseInt($('#'+src4).val().replace( /[^0-9]/g, '' ));
			var subtotal_group = 0;
			for(var i = 1;i <= group_total ; i++){
				if($('#'+dest+i).val()!='')
				subtotal_group+= parseInt($('#'+dest+i).val().replace( /[^0-9]/g, '' ));	
			}
			
			$('#'+subtotal).val(Math.floor(subtotal_group));
			formatAmountA('',subtotal);
			////////////////////////////////////////////////////////////////
		}else if(number!=''){
			// format the amount
			x = number.split( ',' );
			x1 = x[0];
			x2 = x.length > 1 ? ',' + x[1] : '';
			if(id!=0){
				$('#'+variable).val(formatAmountNoDecimals( x1 ) + x2);
			}else{
				$('#'+variable).val(formatAmountNoDecimals( x1 ) + x2);
			}
		}
		
		//calculate all
		
		
		
		
		
			//subtotal
			var grand_total_ppn=get_grand_total_ppn();
			var subtotal_all = 0;
			console.log(grand_total_ppn);
		
			for(var i = 1;i <= 1 ; i++){ // 2 depends on group total
				subtotal_all+= parseInt($('#'+subtotal_src+i).val().replace( /[^0-9]/g, '' ));	
				
			}
		
	
				///kasi id nya disini coi//

			$('#'+subtotal_dest).val(Math.floor(subtotal_all));
			
			$('#grand_total_after_ppn').val(Math.floor(grand_total_ppn));
			formatAmountA('',subtotal_dest);
			formatAmountA('','grand_total_after_ppn');

		
			
			
			//discount
			var discount_all = 0;
			discount_all = parseInt(parseInt($('#'+subtotal_dest).val().replace( /[^0-9]/g, '' ))*parseInt((parseInt($('#'+disc_src).val().replace( /[^0-9]/g, '' ))))/100);
			$('#'+disc_dest).val(Math.floor(discount_all));
			formatAmountA('',disc_dest);
			
			//ppn
			var ppn_all = 0;
			<?php /*?>if(document.getElementById(ppn_src).checked==true){
				ppn_all = parseInt((parseInt($('#'+subtotal_dest).val().replace( /[^0-9]/g, '' )) - parseInt(parseInt($('#'+subtotal_dest).val().replace( /[^0-9]/g, '' ))*parseInt((parseInt($('#'+disc_src).val().replace( /[^0-9]/g, '' ))))/100))*0.1);
			}<?php */?>
			$('#'+ppn_dest).val(Math.floor(ppn_all));
			formatAmountA('',ppn_dest);
			
			//total
			var total_all = 0;
			<?php /*?>if(document.getElementById(ppn_src).checked==true){
				total_all = parseInt($('#'+subtotal_dest).val().replace( /[^0-9]/g, '' )) - parseInt(parseInt($('#'+subtotal_dest).val().replace( /[^0-9]/g, '' ))*parseInt((parseInt($('#'+disc_src).val().replace( /[^0-9]/g, '' ))))/100) + parseInt((parseInt($('#'+subtotal_dest).val().replace( /[^0-9]/g, '' )) - parseInt(parseInt($('#'+subtotal_dest).val().replace( /[^0-9]/g, '' ))*parseInt((parseInt($('#'+disc_src).val().replace( /[^0-9]/g, '' ))))/100))*0.1);
			}else{
				total_all = parseInt($('#'+subtotal_dest).val().replace( /[^0-9]/g, '' )) - parseInt(parseInt($('#'+subtotal_dest).val().replace( /[^0-9]/g, '' ))*parseInt((parseInt($('#'+disc_src).val().replace( /[^0-9]/g, '' ))))/100);
			}
			$('#'+total_dest).val(Math.floor(total_all));
			formatAmountA('',total_dest);<?php */?>
		///////////////////////////////////////////////////////////
	}
	
	function formatAmountA(id,dest) {
		var number = $('#'+dest+id).val();
		var number2= $('#total_after_ppn_2'+id).val();
	//	console.log(number2);
		//console.log(number2);
		
		// remove all the characters except the numeric values
		number = number.replace( /[^0-9]/g, '' );
		number2 = number2.replace( /[^0-9]/g, '' );
	
		//console.log(number2);
		// change the splitter to "."
		
		number = number.replace( /\./g, '.' );
		number2 = number2.replace( /\./g, '.' );
	
		// format the amount
		x = number.split( ',' );
		x1 = x[0];
		x2 = x.length > 1 ? ',' + x[1] : '';
		y = number2.split( ',' );
		y1 = y[0];
		y2 = y.length > 1 ? ',' + y[1] : '';
		if(id!=0){
			$('#'+dest+id).val(formatAmountNoDecimals( x1 ) + x2);
			
			if ($('#ppn_check_'+id).is(":checked"))
			{
			  // it is checked
			  $("#total_after_ppn_"+id).val(formatAmountNoDecimals( y1 ) + y2);
			}else{
				$("#total_after_ppn_"+id).val(formatAmountNoDecimals( x1 ) + x2);
			}
			
			
			
		}else{
			
			$('#'+dest+id).val(formatAmountNoDecimals( x1 ) + x2);
			if ($('#ppn_check_'+id).is(":checked"))
			{
				$("#total_after_ppn_"+id).val(formatAmountNoDecimals( y1 ) + y2);
			}else{
				$("#total_after_ppn_"+id).val(formatAmountNoDecimals( x1 ) + x2);	
			}
			
		}
	}
	
function get_grand_total_ppn(){
value=0;


	 $(".for_get_total_ppn").each(function() {
            var i = parseInt($(this).val().replace( /[^0-9]/g, '' ));

            if (!isNaN(i))
            {
                value += i;
            }
        });
		
	return value;
}

	$('.date_selection').datepicker({
		numberOfMonths: 1,
		showButtonPanel: true,
		yearRange: "-80:+80",
		changeYear: true,
		dateFormat: "yy-mm-dd",
		minDate: "-80y"
	});
	function get_no_rekening(i,datavalue){
		//alert(datavalue);
		var data_temp = datavalue.split('|');
		
		vendor_id=data_temp[0];
		vendor_account=data_temp[1];
		vendor_name=data_temp[2];
		bank=data_temp[3];
		
	//	alert(i);
		$("#vendor1_"+i).val(vendor_id);
		$("#acc_number1_"+i).val(vendor_account);
		$("#acc_name1_"+i).val(vendor_name);
		$("#bank_name1_"+i).val(bank);
		//alert("#acc_number1_"+i);
		//alert($("#vendor1_"+i).data('data-nilai'));
		
		
	}

</script>