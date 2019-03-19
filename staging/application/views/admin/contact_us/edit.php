<div id="content">
	<h2>Contact Us &raquo; Edit</h2>
	<form method="post" id="edit_about_us_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/contact_us/do_edit');?>" >
    <?php if($detail){ ?>
    <dl>
        <dd>Title</dd>
        <dt><input class="txtField validate[required]" type="text" name="title" id="title" value="<?php echo $detail['title']?>"/></dt>
    </dl>
    <dl>
        <dd>Image</dd>
        <dt>
		<?php if($detail['image']!=""){?>
        <img width="200" src="<?php echo base_url();?>/userdata/contact_us/<?php echo $detail['image']; ?>" /> <br />
        <?php }?>
    	</dt>  
        <dt><input type="file" class="txtField" name="image"/></dt>
    </dl>
    <dl>
        <dd>Address</dd>
        <dt><textarea class="txtField validate[required]" name="address"><?php echo $detail['address']?></textarea></dt>
    </dl>
    <dl>
        <dd>Fax</dd>
        <dt><input class="txtField validate[required]" type="text" name="fax" id="title" value="<?php echo $detail['fax']?>"/></dt>
    </dl>
    <dl>
        <dd>Email</dd>
        <dt><input class="txtField validate[required]" type="text" name="email" id="title" value="<?php echo $detail['email']?>"/></dt>
    </dl>
    <dl>
        <dd>Operating Hours</dd>
        <dt><input class="txtField validate[required]" type="text" name="operating" id="title" value="<?php echo $detail['operating_hours']?>"/></dt>
    </dl>

    <dl>
        <dd>US Representative</dd>
        <dt><input class="txtField validate[required]" type="text" name="us_representative" id="title" value="<?php echo $detail['us_representative']?>"/></dt>
    </dl>

    <dl>
        <dd>Phone</dd>
        <dt><input class="txtField validate[required]" type="text" name="phone" id="title" value="<?php echo $detail['phone']?>"/></dt>
    </dl>

    <dl>
        <dd>Email Representative</dd>
        <dt><input class="txtField validate[required]" type="text" name="email_representative" id="title" value="<?php echo $detail['email_representative']?>"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" id="edit_about_us_submit" class="defBtn" value="Submit"/></dt>
    </dl>
    <?php } ?>
    </form>
</div>