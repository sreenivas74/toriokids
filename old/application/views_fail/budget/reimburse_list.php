<h2>Reimburse List</h2>
<table id="flexi" style="display:none" class="content"></table>
<script type="text/javascript">
$("#flexi").flexigrid({
	url: '<?php echo site_url('budget/flexi_reimburse_list'); ?>',
	dataType: 'json',
	colModel : [
		{display: 'Action', name : 'action', width : 95, sortable : false, align: 'center'},
		{display: 'Project Name', name : 'p_name', width : 200, sortable : true, align: 'left'},
		{display: 'Amount', name : 'client_id', width : 200, sortable : false, align: 'left'},
		{display: 'Marketing', name : 'employee_id', width : 100, sortable : false, align: 'center'},
		{display: 'Update Date', name : 'update_date', width : 100, sortable : false, align: 'center'},

	
	searchitems : [
		{display: 'Project Name', name : 'p.name', isdefault: true},
		{display: 'Client Name', name : 'c.name'},
		
	],
	sortname: "",
	sortorder: "",
	usepager: true,
	title: 'CRM List',
	useRp: true,
	rp: 20,
	singleSelect: true,
	showTableToggleBtn: false,
	showToggleBtn: false, 
	height: 300
});
</script>