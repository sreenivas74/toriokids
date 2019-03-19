<div id="content">
    <h2>Flash Sale &raquo; Edit Stock</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/sale/flash_sale') ?>">Back</a></li>
        </ul>
    </div>
<table class="defAdminTable" width="60%">
	<thead>
    	<tr>
			<th width="2%">No</th>
			<th width="35%">Product</th>
            <th width="15%">SKU</th>
            <th width="8%">Stock</th>
        </tr>
    </thead>
    <tbody>
    <form name="stock_form" id="stock_form" method="post" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/sale/update_stock') ?>">
    <?php 
	$no=1;	
	
	if($sku)foreach($sku as $list){?>
    <tr>
    	<td><?php echo $no;?></td>
    	<td><?php echo find('name', $list['product_id'], 'product_tb') ?></td>
    	<td><?php echo $list['size'] ?></td>
        <input type="hidden" name="id[]" value="<?php echo $list['id'] ?>" />
        <td><input type="text" name="qty_<?php echo $list['id'] ?>" id="qty_<?php echo $list['id'] ?>" value="<?php echo $list['stock'] ?>" /></td>
      </tr>
    <?php $no++; }?>
    </form>
    </tbody>
</table>
<input type="button" value="Submit" onclick="$('#stock_form').submit()" />
</div>