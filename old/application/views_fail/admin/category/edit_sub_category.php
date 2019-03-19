<div id="content">
	<h2>Sub Category &raquo; Edit</h2>
	<form method="post" id="edit_sub_category_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/category/do_edit_sub').'/'.$id;?>">
    <?php if($detail){ ?>
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField" type="text" name="name" value="<?php echo $detail['name']?>"/></dt>
    </dl>
    <dl>
        <dd>Banner Image (optimize:700 x 240 px)</dd>
        <dt>
		<?php if($detail['banner_image']!=""){?>
        <img width="200" src="<?php echo base_url();?>/userdata/sub_category_banner/<?php echo $detail['banner_image']; ?>" /> <br />
        <a onclick="return confirm('Are You sure to delete this image?');" href="<?php echo site_url('torioadmin/category/delete_sub_category_picture').'/'.$detail['id'];?>">Delete This</a>
        <?php }?>
    	</dt>  
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/category/view_sub_category_list').'/'.$detail['category_id'];?>';" /></dt>
    </dl>
    <?php } ?>
    </form>
</div>