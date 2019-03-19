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
    <h2><?php if($type==1)echo "Large Banner";else echo "Small Banner"?> &raquo; List</h2>
    <?php if($type==2){?>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/home_banner/add').'/'.$type;?>"><span>Add</span></a></li>
        </ul>
    </div>
    <?php }else { ?>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/home_banner/add').'/'.$type;?>"><span>Add</span></a></li>
        </ul>
    </div>
    <?php } ?>
    <table class="defAdminTable" width="100%" id="table-<?php echo $type?>">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="10%">Action</th>
                <th width="20%"><?php if($type==2){ ?>Title<?php }else{ ?>Name<?php } ?></th>
                <th width="20%">Link</th>
                <th width="20%">Image</th>
                <th width="20%">Image Mobile</th>
                <?php if($type!=2){?>
                <th width="8%" colspan="2">Precedence</th><?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($detail)foreach($detail as $list){?>
            <tr id="<?php echo $list['id']?>">
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/home_banner/change_active_home_banner').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/home_banner/edit').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><?php echo $list['link'];?></td>
                <td><?php if($list['image']!=""){ ?>
                    <img width="100%" src="<?php echo base_url();?>userdata/home_banner/<?php echo $list['image'];?>" /><?php }?>
            	</td>
                <td><?php if($list['image_mobile']!=""){ ?>
                    <img width="100%" src="<?php echo base_url();?>userdata/home_banner/<?php echo $list['image_mobile'];?>" /><?php }?>
                </td>
                <?php if($type!=2){?>
    			<td valign="top">
    			
					<?php if ($list['precedence'] != last_precedence_2('home_banner_tb', 'type', $list['type'])){?>
    				<a href="<?php echo site_url('torioadmin/home_banner/down_precedence_home_banner/'.$list['id'].'/'.$list['type']);?>">Up</a>
    			<?php }?>
                </td>
                <td valign="top">
    		
                <?php if ($list['precedence'] != first_precedence_2('home_banner_tb', 'type', $list['type'])){?>
    				<a href="<?php echo site_url('torioadmin/home_banner/up_precedence_home_banner/'.$list['id'].'/'.$list['type']);?>">Down</a> 
				<?php }?>
                
                </td>
                <?php } ?>
    		</tr>
    		<?php $no++; } else if(!$detail){ ?> 
            <tr>
                <td colspan="7"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>