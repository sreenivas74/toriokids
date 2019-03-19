<script>
$(document).ready(function(){
	 $('.texteditor').redactor({
			focus: true,
			toolbarExternal: '#toolbar'
	  });
});

function campaign_validator(){
	var title = document.getElementById('title');
	var greeting_name = document.getElementById('greeting_name');
	var subject = document.getElementById('subject');
	
	if(notEmpty(subject,"Subject is required")){
		if(notEmpty(title, "Title is required")){
			if(notEmpty(greeting_name, "Greeting Name is required")){
				return true;
			}
		}
	}
	return false;
}
function notEmpty(elem, helperMsg){
	if(elem.value.length == 0){
		alert(helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	return true;
}
</script>

<div id="content">
<h2>Campaign &raquo; Edit</h2>
<form method="post" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/campaign/do_edit/');?>" onsubmit="return campaign_validator();">
<input type="hidden" id="id" name="id" value="<?php echo $detail['id'] ?>" >
<dl>
    <dd>Subject (Email Subject) <span style="color:red">*</span></dd>
    <dt><input class="txtField" type="text" name="subject" id="subject" value="<?php echo $detail['subject'];?>"/></dt>
</dl>
<dl>
    <dd>Title (Email Header) <span style="color:red">*</span></dd>
    <dt><input class="txtField" type="text" name="title" id="title" value="<?php echo $detail['title'];?>"/></dt>
</dl>
<dl>
    <dd>Greeting Name <span style="color:red">*</span></dd>
    <dt><input class="txtField" type="text" name="greeting_name" id="greeting_name" value="<?php echo $detail['greeting_name'] ?>"/></dt>
</dl>
<dl>
	<dd>Previous Image</dd>
    <dt><img src="<?php echo base_url()."userdata/campaign"."/".$detail['image'] ?>" width="200px" /></dt>
</dl>
<dl>
	<dd>Image / Banner (jpg/png, width 560px) <span style="color:red">*</span></dd>
    <dt><input type="file" name="image" id="image" /></dt>
</dl>
<dl>
	<dd>Image Link (example: google.com)</dd>
    <dt><input class="txtField" type="text" name="link" id="link" value="<?php echo $detail['link'] ?>" /></dt>
</dl>
<dl>
    <dd>Description</dd>
    <dt><div id="toolbar"></div><textarea class="texteditor" name="desc" id="content_redactor"><?php echo $detail['description'];?></textarea></dt>
</dl>
<br />

<h2>Featured Product</h2>
<?php $product_json = json_decode($detail['product_id']);?>
<dl>
	<dd>Product 1 &nbsp; <select name="product_1" id="product_1">
    <?php if($product) foreach($product as $list){ ?>
    	<option value="<?php echo $list['id'] ?>" <?php if(isset($product_json[0])) if($product_json[0]->product_id==$list['id']) echo "selected" ?>><?php echo $list['name'] ?></option>
    <?php }?>
    </select> &nbsp;
    <input type="text" name="price_before_1" id="price_before_1" placeholder="Before" value="<?php if(isset($product_json[0])) echo $product_json[0]->price_before ?>" required />
    &nbsp; <input type="text" name="price_after_1" id="price_after_1" placeholder="After" value="<?php if(isset($product_json[0])) echo $product_json[0]->price_after ?>" required />
    </dd>
</dl>
<dl>
	<dd>Product 2 &nbsp; <select name="product_2" id="product_2">
    <?php if($product) foreach($product as $list){ ?>
    	<option value="<?php echo $list['id'] ?>" <?php if(isset($product_json[1])) if($product_json[1]->product_id==$list['id']) echo "selected" ?>><?php echo $list['name'] ?></option>
    <?php }?>
    </select> &nbsp;
    <input type="text" name="price_before_2" id="price_before_2" placeholder="Before" value="<?php if(isset($product_json[1])) echo $product_json[1]->price_before ?>" required />
    &nbsp; <input type="text" name="price_after_2" id="price_after_2" placeholder="After" value="<?php if(isset($product_json[1])) echo $product_json[1]->price_after ?>" required />
    </dd>
</dl>
<dl>
	<dd>Product 3 &nbsp; <select name="product_3" id="product_3">
    <?php if($product) foreach($product as $list){ ?>
    	<option value="<?php echo $list['id'] ?>" <?php if(isset($product_json[2])) if($product_json[2]->product_id==$list['id']) echo "selected" ?>><?php echo $list['name'] ?></option>
    <?php }?>
    </select> &nbsp;
    <input type="text" name="price_before_3" id="price_before_3" placeholder="Before" value="<?php if(isset($product_json[2])) echo $product_json[2]->price_before ?>" required />
    &nbsp; <input type="text" name="price_after_3" id="price_after_3" placeholder="After" value="<?php if(isset($product_json[2])) echo $product_json[2]->price_after ?>" required />
    </dd>
</dl>
<dl>
	<dd>Product 4 &nbsp; <select name="product_4" id="product_4">
    <?php if($product) foreach($product as $list){ ?>
    	<option value="<?php echo $list['id'] ?>" <?php if(isset($product_json[3])) if($product_json[3]->product_id==$list['id']) echo "selected" ?>><?php echo $list['name'] ?></option>
    <?php }?>
    </select> &nbsp;
    <input type="text" name="price_before_4" id="price_before_4" placeholder="Before" value="<?php if(isset($product_json[3])) echo $product_json[3]->price_before ?>" required />
    &nbsp; <input type="text" name="price_after_4" id="price_after_4" placeholder="After" value="<?php if(isset($product_json[3])) echo $product_json[3]->price_after ?>" required />
    </dd>
</dl>
<br />

<h2>Button "Belanja Sekarang"</h2>
<dl>
    <dd>Show/Hide</dd>
    <dt>
    	<p><label class="radioCheck"><input class="radioBtn" type="radio" name="show" value="1" <?php if($detail['show_button']==1) echo "checked"; ?> />Show</label></p>
        <p><label class="radioCheck"><input class="radioBtn" type="radio" name="show" value="0" <?php if($detail['show_button']==0) echo "checked"; ?> />Hide</label></p>
    </dt>
</dl>
<dl>
	<dd>Button Link (example: google.com)</dd>
    <dt><input class="txtField" type="text" name="button_link" id="button_link" value="<?php if($detail['button_link']) echo $detail['button_link']; ?>" /></dt>
</dl>

<dl>
    <dd></dd>
    <dt><input type="submit" class="defBtn" value="Submit" />  <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/campaign');?>';" /></dt>
</dl>
</form>
</div>