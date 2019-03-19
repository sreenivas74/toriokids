<script type="text/javascript">
	function message_no(id){
		description=prompt('Information');
				$.ajax({
					type: "POST",
					url: '<?php echo site_url('client/update_last_check_date_2/');?>',
					data:'description='+description+'&id='+id ,
					success: function(){
						location.reload();
					}
				});
	}
</script>
<h2>Client</h2>

<table id="flexi" style="display:none" class="content"></table>
<script type="text/javascript">
$("#flexi").flexigrid({
	url: '<?php echo site_url('client/client_flexi'); ?>',
	dataType: 'json',
	colModel : [
		{display: 'Action', name : 'action', width : 125, sortable : false, align: 'center'},
		{display: 'Name', name : 'name', width : 150, sortable : true, align: 'left'},
		{display: 'Industri', name : 'industry', width : 100, sortable : false, align: 'center'},
		{display: 'Employee', name : 'employee', width : 120, sortable : true, align: 'center'},
		{display: 'Status', name : 'status', width : 50, sortable : false, align: 'center'},
		{display: 'Product', name : 'product', width : 100, sortable : false, align: 'center'},
		{display: 'Lokasi', name : 'location', width : 100, sortable : false, align: 'center'},
		{display: 'CP 1', name : 'cp_1', width : 100, sortable : false, align: 'center'},
		{display: 'CP 2', name : 'cp_2', width : 100, sortable : false, align: 'center'},
		{display: 'Phone', name : 'phone', width : 100, sortable : false, align: 'center'},
		{display: 'handphone', name : 'handphone', width : 100, sortable : false, align: 'center'},
		{display: 'Fax', name : 'fax', width : 100, sortable : false, align: 'center'},
		{display: 'Email', name : 'email', width : 100, sortable : false, align: 'center'}
	],
	
	searchitems : [
		{display: 'Name', name : 'name', isdefault: true}
	],
	sortname: "",
	sortorder: "",
	usepager: true,
	title: 'Client List',
	useRp: true,
	rp: 20,
	singleSelect: true,
	showTableToggleBtn: false,
	showToggleBtn: false, 
	height: 300
});
</script>