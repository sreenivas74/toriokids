<div id="content">
	<h2>About_us &raquo; Edit</h2>
	<form method="post" id="edit_about_us_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/about_us/do_edit').'/'.$id;?>" >
    <input type="hidden" name="flag" value="1" id="flag" />
    <?php if($detail){ ?>
    <dl>
        <dd>Title</dd>
        <dt><input class="txtField validate[required]" type="text" name="title" id="title" value="<?php echo $detail['title']?>"/></dt>
    </dl>
    <dl>
        <dd>Image</dd>
        <dt>
		<?php if($detail['image']!=""){?>
        <img width="200" src="<?php echo base_url();?>/userdata/about_us/<?php echo $detail['image']; ?>" /> <br />
        <a onclick="return confirm('Are You sure to delete this image?');" href="<?php echo site_url('torioadmin/about_us/delete_about_us_picture').'/'.$detail['id'];?>">Delete This</a>
        <?php }?>
    	</dt>  
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd>Description</dd>
        <dt><textarea class="txtField" type="text" name="description" id="content_redactor"><?php echo $detail['description']?></textarea></dt>
    </dl>
    <dl>
        <dd>Position</dd>
        <dt><input type="radio" name="position" value="1" <?php if($detail['position']==1){ echo"checked"; } ?> /> Text left image right <br /> <input type="radio" name="position" value="2" <?php if($detail['position']==2){ echo"checked"; } ?>  /> Text right image left</dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" id="edit_about_us_submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/about_us');?>';" /></dt>
    </dl>
    <?php } ?>
    </form>
</div>