<div id="content">
	<h2>E-Store &raquo; Edit Banner</h2>
	<form method="post" id="edit_store_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/store/do_edit_banner');?>" >
    <?php if($detail){ ?>
    <dl>
        <dd>Title</dd>
        <dt><input class="txtField validate[required]" type="text" name="title" id="title" value="<?php echo $detail['title']?>"/></dt>
    </dl>
    <dl>
        <dd>Image</dd>
        <dt>
		<?php if($detail['image']!=""){?>
        <img width="200" src="<?php echo base_url();?>/userdata/e-store/<?php echo $detail['image']; ?>" /> <br />
        <?php }?>
    	</dt>  
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" id="edit_store_submit" class="defBtn" value="Submit"/></dt>
    </dl>
    <?php } ?>
    </form>
</div>