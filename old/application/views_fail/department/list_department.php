<h2>Department List</h2>
<table id="flexi" style="display:none" class="content"></table>
<script type="text/javascript">
$("#flexi").flexigrid({
	url: '<?php echo site_url('department/department_flexi'); ?>',
	dataType: 'json',
	colModel : [
		{display: 'Action', name : 'action', width : 55, sortable : false, align: 'center'},
		{display: 'name', name : 'name', width : 100, sortable : true, align: 'left'},
		{display: 'Active', name : 'active', width : 50, sortable : true, align: 'left'}
	],
	
	searchitems : [
		{display: 'name', name : 'name', isdefault: true}
	],
	sortname: "",
	sortorder: "",
	usepager: true,
	title: 'Department List',
	useRp: true,
	rp: 50,
	singleSelect: true,
	showTableToggleBtn: false,
	showToggleBtn: false, 
	height: 500
});
</script>