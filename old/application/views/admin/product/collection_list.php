<div id="content">
    <h2>Product &raquo; Collection List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="javascript:void(0)" onclick="$('#add_collection').toggle()"><span>Add</span></a></li>
        </ul>
    </div>
    
    <div id="add_collection" style="display:none">
    <form name="collection_form" id="collection_form" method="post" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/do_add_collection') ?>" onsubmit="return collection_validation()">
    	<dl>
            <dd>Name</dd>
            <dt><input class="txtField validate[required]" type="text" name="name" id="name" style="width:300px"/>
            <input type="submit" value="Submit" /></dt>
            
        </dl>
    </form>
    </div>
    <table class="defAdminTable" width="50%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="18%">Action</th>
                <th width="20%">Collection Name</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($collection)foreach($collection as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top"><a href="javascript:void(0)" onclick="$('#collection_edit_<?php echo $list['id'] ?>').toggle()">Edit</a> | <a href="<?php echo site_url('torioadmin/product/delete_collection/'.$list['id']) ?>" onclick="return confirm('Delete this collection?')">Delete</a></td>
                <td valign="top"><a href="<?php echo site_url('torioadmin/product/view_collection_product/'.$list['id']) ?>"><?php echo $list['name'];?></a></td>
    		</tr>
            <tr id="collection_edit_<?php echo $list['id'] ?>" style="display:none">
            <form name="edit_collection_form" id="edit_collection_form" method="post" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/do_edit_collection') ?>" onsubmit="return edit_collection(<?php echo $list['id'] ?>)">
            	<td></td>
                <td colspan="2">
                <input type="hidden" name="id" value="<?php echo $list['id'] ?>"/>
                <input class="txtField validate[required]" type="text" name="edit_name" id="edit_name_<?php echo $list['id'] ?>" style="width:200px"/>
            <input type="submit" value="Submit" /></td>
            </form>
            </tr>
    		<?php $no++; } else if(!$collection){ ?> 
            <tr>
                <td colspan="3"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
function collection_validation(){
	var name=$('#name').val();
	if(name.length==0){
		alert('Collection name is required.'); $('#name').focus(); return false;
	}
}

function edit_collection(id){
	var name = $('#edit_name_'+id).val();
	if(name.length==0){
		alert('Collection name is required.'); $('#edit_name_'+id).focus(); return false;
	}
}
</script>