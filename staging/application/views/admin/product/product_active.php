<div id="content">
	<h2>Active Product</h2>
	<form method="post" id="submit_related_product_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/submit_product_active'.'/');?>">
    <dl>
        <dd>Choose Active Product</dd>
        <dt>
            <?php if($new_product) foreach ($new_product as $list){ ?>
            	<input type="hidden" name="id[]" value="<?php echo $list['id']?>"></dt>
                <label><input type="checkbox" name="product_id_to[]" value="<?php echo $list['id'] ?>" <?php if($list['active']==1)echo "checked=\"checked\"";?>> <?php echo $list['name'];?></label><br />
			<?php } ?>
        </dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/></dt>
    </dl>
    </form>
</div>