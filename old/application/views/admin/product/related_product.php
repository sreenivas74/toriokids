<div id="content">
	<h2>Recommended Products &raquo; <?php echo $detail['name'];?> </h2>
	<form method="post" id="submit_related_product_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/submit_related_product'.'/'.$id);?>">
    <dl>
        <dd>Choose Recommended Products</dd>
        <dt>
            <?php if($product) foreach ($product as $list){ ?>
                <label><input type="checkbox" name="product_id_to[]" value="<?php echo $list['id'] ?>" <?php for($i=0;$i<count($cek);$i++){ if(in_array($list['id'], $cek[$i]))echo "checked=\"checked\"";}?>> <?php echo $list['name'];?></label><br />
			<?php } ?>
        </dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/product');?>';" /></dt>
    </dl>
    </form>
</div>