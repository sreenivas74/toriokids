<div id="content">
	<h2>E-Store &raquo; Edit</h2>
	<form method="post" id="edit_store_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/store/do_edit').'/'.$id;?>" >
    <input type="hidden" name="flag" value="1" id="flag" />
    <?php if($detail){ ?>
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField validate[required]" type="text" name="name" id="title" value="<?php echo $detail['name']?>"/></dt>
    </dl>
    <dl>
        <dd>Image</dd>
        <dt>
		<?php if($detail['image']!=""){?>
        <img width="200" src="<?php echo base_url();?>/userdata/e-store/<?php echo $detail['image']; ?>" /> <br />
        <a onclick="return confirm('Are You sure to delete this image?');" href="<?php echo site_url('torioadmin/store/delete_store_picture').'/'.$detail['id'];?>">Delete This</a>
        <?php }?>
    	</dt>  
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd>Link</dd>
        <dt><input class="txtField" type="text" name="link" id="title" value="<?php echo $detail['link']?>"/></dt>
    </dl>
    <dl>
        <dd>Address</dd>
        <dt><textarea class="txtField" type="text" name="address" id="content_redactor"><?php echo $detail['address']?></textarea></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" id="edit_store_submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/store');?>';" /></dt>
    </dl>
    <?php } ?>
    </form>
</div>