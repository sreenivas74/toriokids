<div id="content">
	<h2>Category Banner &raquo; Edit</h2>
	<form method="post" id="edit_category_banner_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/category_banner/do_edit').'/'.$id?>">
    <input type="hidden" name="flag" value="1" id="flag" />
    <?php if($detail){ ?>
    <dl>
        <dd>Name</dd>
        <dt><input class="txtField validate[required]" type="text" name="name" id="name" value="<?php echo $detail['name']?>"/></dt>
    </dl>
     <dl>
    	<dd>Link</dd>
        <dd><span class="descriptionTxt">Example: https://www.google.co.id/</span></dd>
        <dt><input class="txtField" type="text" name="link" value="<?php echo $detail['link']?>"/></dt>
    </dl>
    <dl>
        <dd>Image</dd>
        <dt>
		<?php if($detail['image']!=""){?>
        <img width="200" src="<?php echo base_url();?>/userdata/category_banner/<?php echo $detail['image']; ?>" /> <br />
        <a onclick="return confirm('Are You sure to delete this image?');" href="<?php echo site_url('torioadmin/category_banner/delete_category_banner_picture').'/'.$detail['id'];?>">Delete This</a>
        <?php }?>
    	</dt>  
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" id="edit_category_banner_submit" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/category_banner/view_banner_list')?>';" /></dt>
    </dl>
    <?php } ?>
    </form>
</div>