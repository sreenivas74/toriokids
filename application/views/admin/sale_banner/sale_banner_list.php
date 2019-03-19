<script>
$(document).ready(function() {
	
	// Initialise the table
	$("#table-1").tableDnD({
		onDragClass: 'tableCellOnDrag',
		onDrop: function(table, row){
			
			$.ajax({
				type: "POST",
				url: '<?php echo site_url('torioadmin/sale_banner/update_precedence')?>',
				data: $.tableDnD.serialize(),
				success: function(){
					
				}
			});
		}
	});
});
</script>
<div id="content">
    <h2>Sale Banner &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/sale_banner/add');?>"><span>Add</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%" id="table-1">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="10%">Action</th>
                <th width="20%">Name</th>
                <th width="20%">Link</th>
                <th width="20%">Image</th>
                <th width="8%" colspan="2">Precedence</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; $check_active = 0; 
				if($detail) foreach($detail as $det){
					if($det['active']==1) $check_active++;
				}
				
			  if($detail)foreach($detail as $list){
				  ;?>
            <tr id="<?php echo $list['id']?>">
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/sale_banner/change_active_sale_banner').'/'.$list['id'].'/'.$list['active']; ?>" onclick="return check_active(<?php echo $check_active; ?>, <?php echo $list['active'] ?>)"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/sale_banner/edit').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><?php echo $list['link'];?></td>
                <td><?php if($list['image']!=""){ ?>
                    <img width="200" src="<?php echo base_url();?>userdata/sale_banner/<?php echo $list['image'];?>" /><?php }?>
            	</td>
    			<td valign="top">
    			
					<?php if ($list['precedence'] != last_precedence('sale_banner_tb')){?>
    				<a href="<?php echo site_url('torioadmin/sale_banner/down_precedence_sale_banner/'.$list['id']);?>">Up</a>
    			<?php }?>
                </td>
                <td valign="top">
    		
                <?php if ($list['precedence'] != first_precedence('sale_banner_tb')){?>
    				<a href="<?php echo site_url('torioadmin/sale_banner/up_precedence_sale_banner/'.$list['id']);?>">Down</a> 
				<?php }?>
                
                </td>
    		</tr>
    		<?php $no++; } else if(!$detail){ ?> 
            <tr>
                <td colspan="7"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>
function check_active(value, active){
	if(value>0 && active==0){
		alert("Active sale banner can be only one.");
		return false;
	}
	else{
		return true;
	}
}
</script>