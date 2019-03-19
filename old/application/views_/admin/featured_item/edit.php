<div id="content">
	<h2>Featured Item &raquo; Edit</h2>
	<form method="post" id="edit_featured_item_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/featured_item/do_edit').'/'.$id;?>" onsubmit="return false;">
    <input type="hidden" name="flag" value="1" id="flag" />
    <?php if($detail){ ?>
    <dl>
        <dd>Title</dd>
        <dt><input class="txtField validate[required]" type="text" name="title" id="title" value="<?php echo $detail['title']?>"/></dt>
    </dl>
    <dl>
    	<dd>Link</dd>
        <dd><span class="descriptionTxt">Example: https://www.google.co.id/</dd>
        <dt><input class="txtField" type="text" name="link" value="<?php echo $detail['link']?>"/></dt>
    </dl>
    <dl>
        <dd>Image</dd>
        <dt>
		<?php if($detail['image']!=""){?>
        <img width="200" src="<?php echo base_url();?>/userdata/featured/<?php echo $detail['image']; ?>" /> <br />
        <a onclick="return confirm('Are You sure to delete this image?');" href="<?php echo site_url('torioadmin/featured_item/delete_featured_item_picture').'/'.$detail['id'];?>">Delete This</a>
        <?php }?>
    	</dt>  
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd>Description</dd>
        <dt><textarea class="txtField" type="text" name="description"><?php echo $detail['description']?></textarea></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" id="edit_featured_item_submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/featured_item');?>';" /></dt>
    </dl>
    <?php } ?>
    </form>
</div>