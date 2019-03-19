<div id="content">
	<h2>Small Footer Banner &raquo; Edit</h2>
	<form method="post" id="edit_home_banner_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/small_footer_banner/do_edit').'/'.$id?>"  onsubmit="return false;">
    <input type="hidden" name="flag" value="1" id="flag" />
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
        <dd>Image(optimize: 940x120 px)</dd>
        <dt>
		<?php if($detail['image']!=""){?>
        <img width="200" src="<?php echo base_url();?>/userdata/small_footer_banner/<?php echo $detail['image']; ?>" /> <br />
        <a onclick="return confirm('Are You sure to delete this image?');" href="<?php echo site_url('torioadmin/small_footer_banner/delete_small_footer_banner_picture').'/'.$detail['id'];?>">Delete This</a>
        <?php }?>
    	</dt>  
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" id="edit_home_banner_submit" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/small_footer_banner/view_banner_list').'/'.$type?>';" /></dt>
    </dl>
    </form>
</div>