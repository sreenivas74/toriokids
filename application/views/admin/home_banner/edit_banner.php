<div id="content">
	<h2>Banner &raquo; Edit</h2>
	<form method="post" id="edit_home_banner_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/home_banner/do_edit').'/'.$id?>"  onsubmit="return false;">
    <input type="hidden" name="flag" value="1" id="flag" />
    <?php if($detail){ ?>
    <dl>
        <dd><?php if($type==2){ ?>Title<?php }else{ ?>Name <?php } ?></dd>
        <dt><input class="txtField validate[required]" type="text" name="name" id="name" value="<?php echo $detail['name']?>"/></dt>
    </dl>
     <dl>
    	<dd>Link</dd>
        <dd><span class="descriptionTxt">Example: https://www.google.co.id/</span></dd>
        <dt><input class="txtField" type="text" name="link" value="<?php echo $detail['link']?>"/></dt>
    </dl>
    <dl>
        <dd>Image Desktop</dd>
        <dt>
		<?php if($detail['image']!=""){?>
        <img width="200" src="<?php echo base_url();?>/userdata/home_banner/<?php echo $detail['image']; ?>" /> <br />
        <a onclick="return confirm('Are You sure to delete this image?');" href="<?php echo site_url('torioadmin/home_banner/delete_home_banner_picture').'/'.$detail['id'];?>">Delete This</a>
        <?php }?>
    	</dt>  
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd>Image Mobile</dd>
        <dt>
        <?php if($detail['image_mobile']!=""){?>
        <img width="200" src="<?php echo base_url();?>/userdata/home_banner/<?php echo $detail['image_mobile']; ?>" /> <br />
        <?php }?>
        </dt>  
        <dt><input type="file" class="txtField" name="image_mobile"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" id="edit_home_banner_submit" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/home_banner/view_banner_list').'/'.$type?>';" /></dt>
    </dl>
    <?php } ?>
    </form>
</div>