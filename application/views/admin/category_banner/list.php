<script>
$(document).ready(function() {
	
	// Initialise the table
	$("#table-1").tableDnD({
		onDragClass: 'tableCellOnDrag',
		onDrop: function(table, row){
			
			$.ajax({
				type: "POST",
				url: '<?php echo site_url('torioadmin/home_banner/update_precedence')?>',
				data: $.tableDnD.serialize(),
				success: function(){
					
				}
			});
		}
	});
});
</script>
<div id="content">
    <h2>Category Banner&raquo; List</h2>
    <div id="submenu">
        <?php /* ?>
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/category_banner/add');?>"><span>Add</span></a></li>
        </ul>
        <?php */ ?>
    </div>
    <table class="defAdminTable" width="100%" id="table">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="10%">Action</th>
                <th width="20%">Name</th>
                <th width="20%">Link</th>
                <th width="20%">Image</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($detail)foreach($detail as $list){?>
            <tr id="<?php echo $list['id']?>">
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/category_banner/change_active_category_banner').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/category_banner/edit').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><?php echo $list['link'];?></td>
                <td><?php if($list['image']!=""){ ?>
                    <img width="100%" src="<?php echo base_url();?>userdata/category_banner/<?php echo $list['image'];?>" /><?php }?>
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