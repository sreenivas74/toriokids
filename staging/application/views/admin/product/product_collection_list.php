<div id="content">
    <h2>Product &raquo; Collection <?php echo find('name', $this->uri->segment(4), 'product_collection_tb') ?> &raquo; List</h2>
    
    <?php if($this->session->flashdata('notif_add')){ ?><span style="color:limegreen">Success add product.</span><?php }?>
    <?php if($this->session->flashdata('notif_update')){ ?><span style="color:limegreen">Success update SKU code</span><?php }?>
    
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/product/collection') ?>"><span>Back</span></a> <a class="defBtn" href="javascript:void(0)" onclick="$('#add_product').toggle()"><span>Add Product to this Collection</span></a></li>
        </ul>
    </div>
    
    <div id="add_product" style="display:none">
    <?php if($product){ ?>
    <form name="collection_form" id="collection_form" method="post" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/do_add_collection_product/'.$this->uri->segment(4)) ?>">
        <dl>
        <?php foreach($product as $list){ ?>
                <dd><label><input type="checkbox" name="id[]" id="id_<?php echo $list['id'] ?>" value="<?php echo $list['id'] ?>" />
                <?php echo $list['name'] ?></label></dd>
        <?php }?>
        </dl>
    	<dl><input type="submit" value="Submit" /></dl>
    </form>
    <?php }?>
    </div>
    
    <?php if($collection_product){ ?>
    <table class="defAdminTable" width="65%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="35%">Product Name</th>
                <th width="13%">SKU Code</th>
                <th width="15%">Action</th>
            </tr>
        </thead>
        <tbody>
        <form name="update_sku_form" id="update_sku_form" method="post" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/update_collection_sku') ?>">
        <?php $no=1; 
			foreach($collection_product as $list){?>
            <input type="hidden" name="id[]" value="<?php echo $list['id'] ?>" />
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top"><?php echo $list['name'] ?></td>
                <td valign="top"><input type="text" name="sku_<?php echo $list['id'] ?>" value="<?php echo $list['sku_code'] ?>" /></td>
                <td valign="top" style="text-align:center"><a href="<?php echo site_url('torioadmin/product/remove_product_collection/'.$list['id']) ?>" onclick="return confirm('Remove product <?php echo $list['name'] ?> from this collection?')">Remove</a></td>
    		</tr>
    		<?php $no++; }?>
        </form>
        </tbody>
    </table>
    <input type="button" value="Update SKU Code" onclick="submit_form()" />
    <?php }?>
</div>

<script>
function submit_form(){
	if(confirm('Update SKU Code?')){
		$('#update_sku_form').submit();
	}
}
</script>
