<div id="content">
    <h2>Flash Sale &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/sale/add_flash_sale') ?>">Add</a> <a class="defBtn" href="<?php echo site_url('torioadmin/sale/edit_stock') ?>">Edit Stock</a></li>
        </ul>
    </div>
    <?php echo "Server time : ".date('d F Y H:i:s'); ?>
    <form name="type_form">
    <label><input type="radio" name="type" class="type_sale" value=1 <?php if($type) if(isset($type)) if($type['type']==1) echo "checked"; ?> /> Discount</label>  <label><input type="radio" name="type" class="type_sale" value=2 <?php if($type) if(isset($type)) if($type['type']==2) echo "checked"; ?> /> Flash Sale</label>
    </form>
<table class="defAdminTable" width="82%">
	<thead>
    	<tr>
			<th width="2%">No</th>
			<th width="10%">Action</th>
            <th width="20%">Name</th>
            <th width="10%">Percentage</th>
            <th width="20%">Start Date</th>
            <th width="20%">End Date</th>
        </tr>
    </thead>
    <tbody>
    <?php 
	$no=1;	
	if($sale)foreach($sale as $list){?>
    <tr>
    	<td><?php echo $no;?></td>
    	<td><a href="<?php echo site_url('torioadmin/sale/edit_flash_sale').'/'.$list['id'];?>">Edit</a> | <a href="<?php echo site_url('torioadmin/sale/delete_flash_sale').'/'.$list['id'] ?>" onclick="return confirm('Delete this flash sale?')">Delete</a></td>
    	<td><a href="<?php echo site_url('torioadmin/sale/flash_sale_item').'/'.$list['id'] ?>"><?php echo $list['name'] ?></a></td>
        <td><?php echo $list['percentage'];?></td>
        <td><?php echo date('d F Y H:i:s', strtotime($list['start_time']));?></td>
        <td><?php echo date('d F Y H:i:s', strtotime($list['end_time']));?></td>
      </tr>
    <?php $no++; }?>
    
    </tbody>
</table>
</div>

<script>
$("input:radio[name=type]").click(function() {
    var value = $(this).val();
	
	$.ajax({
		type:"POST",
		url:base_url+'torioadmin/sale/change_sale_type/'+value,
		success: function(temp){
		}
	});
});
</script>