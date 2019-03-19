<h2>Payment Table</h2>

<form name="payment_filter" id="payment_filter" method="post" enctype="multipart/form-data" action="<?php echo site_url('budget/payment_table')?>" onsubmit="return false;">
	<table>
    	<tr>
        	<td style="width:90px">Status</td>
            <td colspan="5"><label><input type="radio" name="status" value="0" <?php if($status==0)echo "checked=\"checked\""?> /> Not Done</label> <label style="margin-left:50px;"><input type="radio" name="status" value="1" <?php if($status==1)echo "checked=\"checked\""?> /> Done</label></td>
         
        </tr>
        <tr>
        	<td colspan="6">&nbsp;</td>
        </tr>
    	<tr>
        	<td style="width:60px">Project</td>
            <td colspan="5">
            <input type="text" name="project_name" id="project_name" readonly="readonly" value="<?php echo $project_name?>" onclick="$('#project_list').toggle();" />
			<input type="hidden" name="project_id" id="project_id" value="<?php echo $project_id?>" />            
            <div id="project_list" style="display:none">
        <table id="flexi2"></table>
        <script type="text/javascript">
        $("#flexi2").flexigrid({
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
			
			$.ajax({
				url:"<?php echo site_url('budget/cek_project_win/')?>/"+id,
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
            </td>
        </tr>
        <tr>
        	<td colspan="6">&nbsp;</td>
        </tr>
        <tr>
        	<td style="width:60px">Pay Date From</td>
            <td><input type="text" name="from" class="date_selection" value="<?php echo $from?>" /></td>
            <td>&nbsp;</td>
            <td style="width:30px">To</td>
            <td><input type="text" name="to" class="date_selection" value="<?php echo $to?>" /></td>
            <td>&nbsp;<input type="button" value="Submit" style="height:27px" id="search_btn" /></td>
        </tr>
    </table>
</form>
<script>
	$(document).ready(function(){
		$("#search_btn").click(function(){
			$("#payment_filter").removeAttr('onsubmit').submit();	
		});
		$('.date_selection').datepicker({
			numberOfMonths: 1,
			showButtonPanel: true,
			yearRange: "-80:+80",
			changeYear: true,
			dateFormat: "yy-mm-dd",
			minDate: "-80y"
		});
	});
</script>
<table id="flexi" style="display:none" class="content"></table>
<script type="text/javascript">
$("#flexi").flexigrid({
	url: '<?php echo site_url('budget/payment_table_flexi').'/'.$project_id.'/'.$status.'/'.$from.'/'.$to; ?>',
	dataType: 'json',
	colModel : [
		{display: 'Action', name : 'action', width : 30, sortable : false, align: 'center'},
		{display: 'Request Number', name : 'request_number', width : 110, sortable : true, align: 'left'},
		{display: 'Project Name', name : 'p.name', width : 110, sortable : true, align: 'left'},
		{display: 'Bank', name : 'b.name', width : 150, sortable : true, align: 'left'},
		{display: 'Method', name : 'method', width : 100, sortable : true, align: 'right'},
		{display: 'Type', name : 'pay_type', width : 80, sortable : true, align: 'center'},
		{display: 'Amount', name : 'amount', width : 100, sortable : true, align: 'center'},
		{display: 'Item', name : 'request_budget_item_id', width : 100, sortable : true, align: 'center'},
		{display: 'Status', name : 'status', width : 100, sortable : true, align: 'center'},
		{display: 'Pay Date', name : 'pay_date', width : 100, sortable : true, align: 'center'},
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