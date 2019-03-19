<h2>Request Fund List</h2>
<?php if(isset($_SESSION['notif'])){
		echo "<span style='color:#F00'>".$_SESSION['notif']."</span><br /><br />";
		unset($_SESSION['notif']);	
}?>

<form name="payment_filter" id="payment_filter" method="get" enctype="multipart/form-data" action="<?php echo site_url('budget/request_budget_list')?>" onsubmit="return false;">
	<table width="100%">
    	<tr>
        	<td width="7%">Type</td>
            <td width="52%"><label><input type="radio" name="status" id="status" class="tipe_s" value="0" <?php if($status==0)echo "checked=\"checked\""?> /> Request Fund</label> <label style="margin-left:20px;"><input type="radio" class="tipe_s" name="status" id="status" value="1" <?php if($status==1)echo "checked=\"checked\""?> /> PO Non Stock</label></td>
            <td width="41%">&nbsp;</td>
         
        </tr>
    	<tr id="outstanding_type" <?php if($status==1){?>style="display:none;"<?php }?>>
        	<td>Paid</td>
            <td width="52%"><label><input type="radio" name="fullpayment" id="fullpayment" value="a" <?php if($fullpayment=='a')echo "checked=\"checked\""?> /> All</label><label style="margin-left:84px;"><input type="radio" name="fullpayment" id="fullpayment" value="1"  <?php if($fullpayment=='1')echo "checked=\"checked\""?> /> Yes</label> <label style="margin-left:84px;"><input type="radio" id="fullpayment" name="fullpayment"  value="2"  <?php if($fullpayment=='2')echo "checked=\"checked\""?> /> No</label>  
        </tr>
          	<tr id="final_approval"> 
        	<td width="7%">Final Approval</td>
            <td width="52%"><label><input type="radio" name="final_approve" id="final_approve" value="a" <?php if($final_approval=='a')echo "checked=\"checked\""?> /> All</label><label style="margin-left:84px;"><input type="radio" name="final_approve" id="final_approve" value="1"  <?php if($final_approval=='1')echo "checked=\"checked\""?> /> Yes</label> <label style="margin-left:84px;"><input type="radio" id="final_approve" name="final_approve"  value="2"  <?php if($final_approval=='2')echo "checked=\"checked\""?> /> No</label>  </td>
            <td width="41%">&nbsp;</td>
         
        </tr>
          	<tr id="not_approval"> 
        	<td width="7%">Not Approved</td>
            <td width="52%"><label><input type="radio" name="not_approve" id="not_approve" value="a" <?php if($not_approve=='a')echo "checked=\"checked\""?> /> All</label><label style="margin-left:84px;"><input type="radio" name="not_approve" id="not_approve" value="1"  <?php if($not_approve=='1')echo "checked=\"checked\""?> /> Yes</label> <label style="margin-left:84px;"><input type="radio" id="not_approve" name="not_approve"  value="2"  <?php if($not_approve=='2')echo "checked=\"checked\""?> /> No</label>  </td>
            <td width="41%">&nbsp;</td>
         
        </tr>
        <tr>
        	<td colspan="3">&nbsp;</td>
        </tr>
        
        <tr>
        	<td colspan="3"><input type="button" value="Submit" style="height:27px" id="search_btn" /></td>
        </tr>
        <tr>
        	<td colspan="3">&nbsp;</td>
        </tr>
    </table>
</form>

<script>
	$(document).ready(function(){
		$("#search_btn").click(function(){
			window.location='<?php echo site_url('budget/request_budget_list')?>/'+$("#status:checked").val()+'/'+$("#fullpayment:checked").val()+'/'+$("#final_approve:checked").val()+'/'+$("#not_approve:checked").val();
		});
		$(".tipe_s").click(function(){
			if($(this).val()==0){
				$("#outstanding_type").show();
				$("#final_approval").show();
				$("#not_approval").show();
			}
			else{
				$("#outstanding_type").hide();
				$("#final_approval").hide();
				$("#not_approval").hide();
			}
		});
	});
</script>
<table id="flexi" style="display:none" class="content"></table>
<?php if($status==0){?>
<script type="text/javascript">
$("#flexi").flexigrid({
	url: '<?php echo site_url('budget/request_flexi').'/'.$fullpayment.'/'.$final_approval.'/'.$not_approve; ?>',
	dataType: 'json',
	colModel : [
		{display: 'Action', name : 'action', width : 30, sortable : false, align: 'center'},
		{display: 'Request Number', name : 'request_number', width : 110, sortable : true, align: 'left'},
		{display: 'Project', name : 'pname', width : 150, sortable : true, align: 'left'},
		{display: 'BS', name : 'bs', width : 50, sortable : true, align: 'center'},
		{display: 'Reimburse', name : 'reimburse', width : 70, sortable : true, align: 'center'},
		{display: 'Amount', name : 'total', width : 100, sortable : true, align: 'right'},
		{display: 'Outstanding', name : 'outstanding', width : 100, sortable : false, align: 'right'},
		{display: 'Request Date', name : 'total', width : 80, sortable : true, align: 'center'},
		{display: 'Approval', name : 'approval', width : 100, sortable : true, align: 'center'},
		{display: 'Paid', name : 'paid', width : 100, sortable : true, align: 'center'},
		{display: 'Created', name : 'created_date', width : 100, sortable : true, align: 'center'}
	],
	
	searchitems : [
		{display: 'Request Number', name : 'request_number', isdefault: true},
		{display: 'Project Name', name : 'p.name', isdefault: true}
	],
	sortname: "",
	sortorder: "",
	usepager: true,
	useRp: true,
	rp: 20,
	singleSelect: true,
	showTableToggleBtn: false,
	showToggleBtn: false, 
	height: 300,
	width:972
});
</script>
<?php }else{?>

<script type="text/javascript">
$("#flexi").flexigrid({
	url: '<?php echo site_url('budget/po_non_stock_flexi'); ?>',
	dataType: 'json',
	colModel : [
		{display: 'Action', name : 'action', width : 30, sortable : false, align: 'center'},
		{display: 'PO Number', name : 'po_number', width : 110, sortable : true, align: 'left'},
		{display: 'Project', name : 'pname', width : 150, sortable : true, align: 'left'},
		{display: 'Amount', name : 'total', width : 100, sortable : true, align: 'right'},
		<?php /*?>{display: 'Outstanding', name : 'outstanding', width : 100, sortable : true, align: 'right'},<?php */?>
		{display: 'Request Date', name : 'total', width : 80, sortable : true, align: 'center'},
		{display: 'Approval', name : 'approval', width : 100, sortable : true, align: 'center'},
		{display: 'Created', name : 'created_date', width : 100, sortable : true, align: 'center'},
		{display: 'Last Updated', name : 'updated_date', width : 100, sortable : true, align: 'center'}
	],
	
	searchitems : [
		{display: 'Request Number', name : 'request_number', isdefault: true},
		{display: 'Project Name', name : 'p.name', isdefault: true}
	],
	sortname: "",
	sortorder: "",
	usepager: true,
	useRp: true,
	rp: 20,
	singleSelect: true,
	showTableToggleBtn: false,
	showToggleBtn: false, 
	height: 300,
	width:972
});
</script>
<?php }?>