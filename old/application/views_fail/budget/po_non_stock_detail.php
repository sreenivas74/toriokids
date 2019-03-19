<style>

	table.po_list tr td{
		border:dashed #999 1px;
		padding:2px;
	}
	table.noBorder tr td{
		border:none;
		border-bottom:dotted #999 1px;
		border-right:dotted #999 1px;	
	}
	
	table.logging tr td{
		border:none;
		border-bottom:solid #000 2px;
		padding:2px;	
	}
	table.logging tr.list td{
		border:none;
		border-bottom:solid #999 1px;
		padding:2px;
	}
	table.logging tr.list:nth-child(odd) td{
		background:#F2F2F2;	
	}
	table.logging tr.list:nth-child(even) td{
		background:#FFF;
	}
</style>


<div><b>PO Request Non Stock</b></div>
<hr size="1" style="color:#CCC" />
    <p>
    <b><?php echo $detail['po_number']?></b><br />
    
    <div style="width:600px">
        <div style="width:400px; float:left;">
        Vendor : <?php echo $detail['vendor_name']?><br />
        PO Date : <?php echo date("d F Y",strtotime($detail['po_date']));?><br />
        Delivery : <?php echo $detail['delivery_date']?><br />
        Payment terms : <?php echo $detail['payment_term']?>
        </div>
        <div style="float:left; width:200px">
            <?php if($detail['approval']==1){?>
                Status : APPROVED<br />
                Approved By : <?php if($detail['approval_by']==0)echo "admin";
                                    else echo find('firstname',$detail['approval_by'],'employee_tb')." ".find('lastname',$detail['approval_by'],'employee_tb')?><br />
                Approved Date : <?php echo date("d F Y",strtotime($detail['approval_date']))?>
            <?php }?>
        </div>
    </div>
    
    
    </p>
    <div style="clear:both"></div>
    <table class="po_list" style="width:860px;">
        <tr style="background-color:#CCC">
            <td style="width:20px">No</td>
            <td style="width:200px">PO Reference</td>
            <td style="width:300px">Description</td>
            <td style="text-align:center; width:45px">Qty</td>
            <td style="text-align:center; width:45px">Unit</td>
            <td style="width:100px">Unit Rate</td>
            <td style="width:50px">Disc %</td>
            <td style="width:100px;">Total <?php if($detail['currency_type']==0)echo "IDR";else echo "USD"?></td>
        </tr>
        <?php $no = 1;?>
        <?php if($po_request_non_stock_item)foreach($po_request_non_stock_item as $detailitem){
                if($detailitem['project_goal_po_id']==$detail['id']){?>
                    <tr>
                        <td style="text-align:right"><?php echo $no?></td>
                        <td><?php echo $detailitem['po_item']?></td>
                        <td><?php echo $detailitem['description']?></td>
                        <td style="text-align:center"><?php echo $detailitem['qty']?></td>
                        <td style="text-align:center"><?php if($detailitem['unit_type']==0)echo "unit";else echo "lot";?></td>
                        <td style="text-align:right"><?php echo number_format($detailitem['price'])?></td>
                        <td style="text-align:center"><?php echo $detailitem['discount']?></td>
                        <td style="text-align:right"><?php echo number_format($detailitem['total'])?></td>
                    </tr>
        <?php $no++;
                }
            }?>
            <tr>
                <td colspan="7" style="text-align:right">Subtotal</td>
                <td style="text-align:right"><?php echo number_format($detail['subtotal'])?></td>
            </tr>
            <tr>
                <td colspan="7" style="text-align:right">Discount</td>
                <td style="text-align:right"><?php echo number_format($detail['discount_value'])?></td>
            </tr>
            <tr>
                <td colspan="7" style="text-align:right">PPN</td>
                <td style="text-align:right"><?php echo number_format($detail['ppn'])?></td>
            </tr>
            <tr>
                <td colspan="7" style="text-align:right">Total</td>
                <td style="text-align:right"><?php echo number_format($detail['total'])?></td>
            </tr>
            <tr style="border:none">
                <td colspan="8" style="border:none">Notes : <?php echo $detail['notes']?></td>
            </tr>
            <tr>
                <td colspan="8" style="border:none">
                <?php  if($detail['approval']==0){?>
                    <input type="button" value="Approve" style="height:27px" onclick="window.location = '<?php echo site_url('project/approve_po_non_stock/'.$detail['id'])?>'" />
                <?php }elseif($detail['approval']==1){?>
                    <input type="button" value="Print PDF" style="height:27px" onclick="" />
                <?php }?>
                    <input type="button" value="Update" style="height:27px" onclick="update_po_non_stock(<?php echo $detail['id']?>,<?php echo $crm['id']?>)" />
                    <input type="button" value="Delete" style="height:27px" onclick="delete_po_non_stock(<?php echo $detail['id']?>)" />
                    
                    <?php //if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/add_payment","privilege_tb")){?>
                    
            <?php /*if($detail['approval']==1){?>
                    <input style="width:80px; height:27px; margin:2px 0;" type="button" onclick="$('#payment_tab').toggle();" value="Payment"  />
                    <?php }?>
                    <?php //}*/?>
                </td>
            </tr>
    </table>
    
    <div id="update_po_non_stock<?php echo $detail['id']?>" style="display:hidden"></div>
    
    <div id="payment_tab" style="display:none; margin:5px; border:dashed #000 1px" class="allform">
        <div style="padding:5px;">
            <form name="payment_form" id="payment_form" method="post" action="<?php echo site_url('budget/add_po_non_stock_payment/'.$detail['id'])?>">
                <table class="payment_table">
                    <tr>
                        <td style="width:220px">Bank : 
                            <select name="bank_id" style="width:170px">
                                <option value="0">Select Bank</option>
                                <?php if($bank_list)foreach($bank_list as $list){?>
                                        <option value="<?php echo $list['id']?>"><?php echo $list['name']?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td style="width:170px">Method : 
                            <select name="method" style="width:100px">
                                <option value="0">Transfer</option>
                                <option value="1">Cash</option>
                            </select>
                        </td>
                         <td style="width:150px">Type : 
                            <select name="pay_type" style="width:100px">
                                <option value="0">Payment</option>
                                <option value="1">Receive</option>
                            </select>
                        </td>
                        <td style="width:180px">Amount : <input type="text" style="width:100px" name="amount" id="amount_payment" onkeyup="formatAmountWithoutPoint(this.value,0,'amount_payment')" /></td>
                        <?php /*?><td> Item : 
                        <?php if($request_item){?>
                            <select name="request_budget_item_id" style="width:100px">
                                <option value="" style="color:#F00;">All</option>
                                <?php if($request_item)foreach($request_item as $listitem){?>
                                    <option value="<?php echo $listitem['id']?>"><?php echo $listitem['bname'].$listitem['pitem']?></option>
                                <?php }?>
                            </select>
                        <?php }?>
                        </td><?php */?>
                        <td style="width:230px"> Date : <input type="text" readonly="readonly" class="date_selection" style="width:100px" name="pay_date" />
                        <input type="button" value="Pay" onclick="payment();" style="height:27px; width:60px" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    
    
<?php $total = 0;
/*if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/view_payment","privilege_tb")){?>
	<?php if($payment_list){?>
    <hr style="border:dotted #000 1px" />
    <b>Payment</b><br /><br />
    <table class="logging">
        <tr>
            <td style="width:10px">No</td>
            <td style="width:250px">Bank</td>
            <td style="text-align:center; widows:170px">Method</td>
            <td style="text-align:center; widows:150px">Type</td>
            <td style="width:150px; text-align:center">Amount</td>
            <td style="width:150px; text-align:center">Pay Date</td>
            <td style="width:250px; text-align:center">Created</td>
            <td style="width:100px"></td>
        </tr>
        <?php 
        $no = 1; $total = 0;//pre($payment_list);
        foreach($payment_list as $list){?>
            <tr class="list" <?php if($list['pay_type']==1)echo "style='color:#00F; font-style:italic !important;'"?>>
                <td style="text-align:right;"><?php echo $no?></td>
                <td><?php echo $list['bname']?></td>
                <td style="text-align:center"><?php if($list['method']==1)echo "Cash";else echo "Transfer";?></td>
                <td style="text-align:center"><?php if($list['pay_type']==1)echo "Received";else echo "Payment";?></td>
                <td style="text-align:center"><?php echo number_format($list['amount'])?></td>
                <td style="text-align:center"><?php echo date('d F Y',strtotime($list['pay_date']))?></td>
                <td style="text-align:center"><?php echo date('d F Y',strtotime($list['created_date']))?> - 
                    <?php if($list['created_by']==0)echo "admin";else echo find('firstname',$list['created_by'],'employee_tb')." ".find('lastname',$list['created_by'],'employee_tb')?>
                </td>
                <td style="text-align:center">
                <?php if($list['status']==0){?>
                	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/edit_payment","privilege_tb")){?>
                    	<a href="javascript:void(0)" onclick="$('.payment_edit').hide();$('#payment_<?php echo $list['id']?>').show();"><img src="<?php echo base_url()?>images/edit.png" width="10"></a>
                    <?php }?>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/delete_payment","privilege_tb")){?>
                    	<a href="<?php echo site_url('budget/remove_po_non_stock_payment/'.$list['id'])?>" onclick="return confirm('Cancel this payment?')" style="color:#F00; text-decoration:none"><img src="<?php echo base_url()?>images/delete.png" width="10"></a>
                    <?php }?>
                <?php }else{?>
                	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/delete_payment","privilege_tb")){?>
                    	<a href="<?php echo site_url('budget/remove_po_non_stock_payment/'.$list['id'])?>" onclick="return confirm('Cancel this payment?')" style="color:#F00; text-decoration:none"><img src="<?php echo base_url()?>images/delete.png" width="10"></a> 
                    <?php }?>
                    confirmed<br /> <?php echo date('d F Y',strtotime($list['done_date']))?>
                <?php }?>
                </td>
            </tr>
            <tr class="payment_edit" style="background:#F2F2F2; display:none" id="payment_<?php echo $list['id']?>">
            	<form name="edit_payment<?php echo $list['id']?>" method="post" action="<?php echo site_url('budget/update_po_non_stock_payment/'.$list['id'])?>">
                <input type="hidden" name="project_goal_po_id" value="<?php echo $list['project_goal_po_id']?>" />
                <td></td>
                <td>
                    <select name="bank_id" style="width:170px">
                        <?php if($bank_list)foreach($bank_list as $listbank){?>
                                <option value="<?php echo $listbank['id']?>" <?php if($list['bid']==$listbank['id'])echo "selected=selected"?>><?php echo $listbank['name']?></option>
                        <?php }?>
                    </select>
                </td>
                <td style="width:170px; text-align:center">
                    <select name="method" style="width:100px">
                        <option value="0">Transfer</option>
                        <option value="1" <?php if($list['method']==1)echo "selected=selected"?>>Cash</option>
                    </select>
                </td>
                <td style="width:150px; text-align:center"> 
                    <select name="pay_type" style="width:100px">
                        <option value="0">Payment</option>
                        <option value="1" <?php if($list['pay_type']==1)echo "selected=selected"?>>Receive</option>
                    </select>
                </td>
                <td style="text-align:center"><input type="text" style="width:100px" name="amount" id="amount_payment<?php echo $list['id']?>" onkeyup="formatAmountWithoutPoint(this.value,0,'amount_payment<?php echo $list['id']?>')" value="<?php echo number_format($list['amount'])?>" /></td>
                
                <td style="text-align:center"><input type="text" readonly="readonly" class="date_selection" style="width:100px" value="<?php echo $list['pay_date']?>" name="pay_date" /></td>
                <td colspan="2" style="text-align:center"><input type="submit" value="update" style="height:27px; width:60px" /></td>
                </form>
            </tr>
        <?php $no++; 
        if($list['pay_type']==0){
            $total+=$list['amount'];
        }else{
            $total-=$list['amount'];	
        }
        }?>
        <tr>
            <td colspan="4" style="text-align:right">Total</td>
            <td style="text-align:center"><b><?php echo number_format($total)?></b></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:right"><i>Difference</i></td>
            <td style="text-align:center; color:#F00"><i><?php echo number_format($detail['total']-$total)?></i>
            
            </td>
            <td colspan="3"></td>
        </tr>
    </table>
    <?php }?>
<?php }*/?>
    
<div id="total_pay" style="display:none"><?php echo $detail['total']-$total?></div>
<script>
		function update_po_stock(po_id,project_id){
			$('#update_po_stock'+po_id).html('');
			$.ajax({
				url:'<?php echo site_url('project/get_update_po_stock/')?>/'+po_id+'/'+project_id,
				success: function(temp){
					$('#update_po_stock'+po_id).html(temp);
					$('#update_po_stock'+po_id).show();
				}
			});
		}
		
		function update_po_non_stock(po_id,project_id){
			$('#update_po_non_stock'+po_id).html('');
			$.ajax({
				url:'<?php echo site_url('project/get_update_po_non_stock/')?>/'+po_id+'/'+project_id,
				success: function(temp){
					$('#update_po_non_stock'+po_id).html(temp);
					$('#update_po_non_stock'+po_id).show();
				}
			});
		}
		
		function delete_po_stock(id){
			var x = confirm('Delete this PO Stock?');
			if(x==true){
				window.location = "<?php echo site_url('project/delete_po_stock')?>/"+id;
			}
		}
		
		function delete_po_non_stock(id){
			var x = confirm('Delete this PO Non Stock?');
			if(x==true){
				window.location = "<?php echo site_url('project/delete_po_non_stock')?>/"+id;
			}
		}
		
		
		function payment(){
			var x = confirm('Confirm this payment?');
			if(x==true){
				var pay = parseInt($('#amount_payment').val().replace(/,/g,""));
				var pay_total = parseInt($('#total_pay').html().replace(/,/g,""));
				
				if(pay<=pay_total && pay >= 0 && pay != ''){
					$('#payment_form').submit();
				}else{
					alert('Payment cannot be empty or more than total payment.');	
				}
			}
			return false;
		}
				
		$('.date_selection').datepicker({
			numberOfMonths: 1,
			showButtonPanel: true,
			yearRange: "-80:+80",
			changeYear: true,
			dateFormat: "yy-mm-dd",
			minDate: "-80y"
		});
</script>