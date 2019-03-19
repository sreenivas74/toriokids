<script>
$(document).ready(function() {
	
	// Initialise the table
	$("#table-1").tableDnD({
		onDragClass: 'tableCellOnDrag',
		onDrop: function(table, row){
			
			$.ajax({
				type: "POST",
				url: '<?php echo site_url('torioadmin/product/update_featured_precedence')?>',
				data: $.tableDnD.serialize(),
				success: function(){
					
				}
			});
		}
	});
});
</script>
<div id="content">
    <h2>Featured Product Precedence</h2>
    <table class="defAdminTable" width="45%" id="table-1">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="35%">Name</th>
                <th width="8%">Image</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($product)foreach($product as $list){?>
            <tr id="<?php echo $list['id']?>">
                <td valign="top"><?php echo $no;?></td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td><?php if(find_2_prec2('image', 'product_id', $list['id'], 'product_image_tb')!=""){?>
                    <img width="30" src="<?php echo base_url();?>userdata/product/<?php echo find_2_prec2('image', 'product_id', $list['id'], 'product_image_tb');?>" /><?php }?>
            	</td>
    		</tr>
    		<?php $no++; } else if(!$product){ ?> 
            <tr>
                <td colspan="7"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>