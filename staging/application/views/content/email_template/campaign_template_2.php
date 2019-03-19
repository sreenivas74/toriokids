<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="target-densitydpi=device-dpi; width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
<meta name="HandheldFriendly" content="true" />
<title>Torio Kids</title>
<style type="text/css">
.ExternalClass {width:100%;}
.ExternalClass, .ExternalClass p, .ExternalClass span,
.ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
body {
	-webkit-text-size-adjust:none;
	-ms-text-size-adjust:none;} 
body {
	margin:0;
	padding:0;}
table td {border-collapse:collapse;}    
p {margin:0; padding:0; margin-bottom:0;}
h1, h2, h3, h4, h5, h6 {
	color: #000;
	line-height: 100%;}
a, a:link {
	color:#C1C14E;
    text-decoration: none;}
a:visited { color: #000; text-decoration: none;} 
a:focus   { color: #000; text-decoration: none;}  
a:hover   { color: #000; text-decoration: none;}  
body, #body_style {
	background-color:#fff;
	min-height:1000px;
	color:#000;
	font-family: 'Lato', sans-serif;;
	font-size:14px;}
span.yshortcuts { color:#000; background-color:none; border:none;}
span.yshortcuts:hover, span.yshortcuts:active, span.yshortcuts:focus {color:#000; background-color:none; border:none;}
.productImageBox{
	width:277px;
	float:left;
	overflow:hidden;
}
.productImg{
	width:277px;
	height:277px;
	display:block;
	overflow:hidden;
}
/*for mobile devices*/
@media only screen and (max-width: 640px) {
	table{width:300px;}
	img[class="resize"] {
		width: 300px !important;
		text-align:center;}
	img[class="resize4columns"]{
		width: 150px !important;
		text-align:center;
		display:block;}
	td[class="title"]{
		font-size:30px !important;}
	td[class="twoColumns"]{
		width:280px !important;
		text-align:center;
		display:block;}
	tr[class="4Columns"]{
		width:300px !important;
		text-align:center;
		display:block;}
	tr[class="4Columns"]{
		width:300px !important;
		text-align:center;
		display:block;}
	tr[class="twoColumns"]{
		width:300px !important;
		text-align:center;
		display:block;}
}

</style>
</head>

<body style="background:#fff; min-height:1000px; color:#000;font-family: 'Arial', sans-serif;; font-size:14px; line-height:20px;"
alink="#C1C14E" link="#C1C14E" bgcolor="#fff" text="#000" yahoo="fix">

<table cellpadding="0" cellspacing="0" border="0" width="560" align="center">
  <tr bgcolor="#fff">
    <td style="padding:20px"><a href="<?php echo base_url() ?>" target="_blank" title=""><img alt="Torio Kids." title="Torio Kids." src="http://www.toriokids.com/templates/images/logo.png" style="display:block; border:0;width:200px;" /></a></td>
  </tr>
  <tr bgcolor="#fff">
  	<td style="padding: 10px 20px;"><a href="<?php if($detail['link']!='') echo 'http://'.$detail['link']; else echo "javascript:void(0)"; ?>" <?php if($detail['link']) echo "target='_blank'"; ?>><img class="resize" src="<?php echo base_url() ?>userdata/campaign/<?php echo $detail['image'] ?>" style="display:block; border:0; width:560px;" /></a></td>
  </tr>
  <tr>
  	<td style="padding:0 35px;font-family:Arial, Helvetica, sans-serif;">
    	<h3 style="font-family:Arial, Helvetica, sans-serif;">Hi, <?php echo $detail['greeting_name'] ?></h3>
        <?php echo $detail['description'] ?>
		<a href="<?php if($detail['button_link']) echo 'http://'.$detail['button_link']; else echo base_url(); ?>" style="margin:20px 0;text-align:center;display:block;"><img style="display:inline-block;" src="<?php echo base_url() ?>userdata/shop_now.png"></a>
    </td>
  </tr>
</table>
<div style="max-width:560px;width:100%;margin:0 auto;display:block;color:#716558;background:#FBD400;text-align:center;font-family: Arial, Helvetica, sans-serif;font-size:15px;padding:5px 0">JANGAN LEWATKAN HARGA PROMO INI !</div>
<?php $product = json_decode($detail['product_id']);?>
<div style="max-width:560px;width:100%;margin:0 auto;overflow:hidden;">
<div style="width:50%;float:left;overflow:hidden;">
    <div style="width:100%;height:auto;overflow:hidden;">
        <a href="<?php echo site_url('product/view_product_detail/'.find('alias', $product[0]->product_id, 'product_tb')) ?>"><img width="100%" src="<?php echo base_url() ?>userdata/product/<?php echo find_first_image($product[0]->product_id) ?>"></a>
    </div>
    <div style="overflow:hidden;text-align:center;">
        <h4 style="margin:0 0 10px;"><a href="<?php echo site_url('product/view_product_detail/'.find('alias', $product[0]->product_id, 'product_tb')) ?>" style="color:#000000;font-family: Arial, Helvetica, sans-serif;font-size:15px;"><?php echo find('name', $product[0]->product_id, 'product_tb') ?></a></h4>
        <div style="color:#EC487B;font-family:Arial, Helvetica, sans-serif;font-size:15px;font-weight:700;">
            <?php echo money($product[0]->price_after) ?>
        </div>
        <div style="color:#6D6E71;font-family:Arial, Helvetica, sans-serif;font-size:9px;text-decoration:line-through;">
            <?php echo money($product[0]->price_before) ?>
        </div>
        <a href="<?php echo site_url('product/view_product_detail/'.find('alias', $product[0]->product_id, 'product_tb')) ?>"><img src="<?php echo base_url() ?>userdata/ShopNow2.png"></a>
    </div>
</div>

<div style="width:50%;float:left;overflow:hidden;">
    <div style="width:100%;height:auto;overflow:hidden;">
        <a href="<?php echo site_url('product/view_product_detail/'.find('alias', $product[1]->product_id, 'product_tb')) ?>"><img width="100%" src="<?php echo base_url() ?>userdata/product/<?php echo find_first_image($product[1]->product_id) ?>"></a>
    </div>
    <div style="overflow:hidden;text-align:center;">
        <h4 style="margin:0 0 10px;"><a href="<?php echo site_url('product/view_product_detail/'.find('alias', $product[1]->product_id, 'product_tb')) ?>" style="color:#000000;font-family: Arial, Helvetica, sans-serif;font-size:15px;"><?php echo find('name', $product[1]->product_id, 'product_tb') ?></a></h4>
        <div style="color:#EC487B;font-family:Arial, Helvetica, sans-serif;font-size:15px;font-weight:700;">
            <?php echo money($product[1]->price_after) ?>
        </div>
        <div style="color:#6D6E71;font-family:Arial, Helvetica, sans-serif;font-size:9px;text-decoration:line-through;">
            <?php echo money($product[1]->price_before) ?>
        </div>
        <a href="<?php echo site_url('product/view_product_detail/'.find('alias', $product[1]->product_id, 'product_tb')) ?>"><img src="<?php echo base_url() ?>userdata/ShopNow2.png"></a>
    </div>
</div>

<div style="width:50%;float:left;overflow:hidden;">
    <div style="width:100%;height:auto;overflow:hidden;">
        <a href="<?php echo site_url('product/view_product_detail/'.find('alias', $product[2]->product_id, 'product_tb')) ?>"><img width="100%" src="<?php echo base_url() ?>userdata/product/<?php echo find_first_image($product[2]->product_id) ?>"></a>
    </div>
    <div style="overflow:hidden;text-align:center;">
        <h4 style="margin:0 0 10px;"><a href="<?php echo site_url('product/view_product_detail/'.find('alias', $product[2]->product_id, 'product_tb')) ?>" style="color:#000000;font-family: Arial, Helvetica, sans-serif;font-size:15px;"><?php echo find('name', $product[2]->product_id, 'product_tb') ?></a></h4>
        <div style="color:#EC487B;font-family:Arial, Helvetica, sans-serif;font-size:15px;font-weight:700;">
            <?php echo money($product[2]->price_after) ?>
        </div>
        <div style="color:#6D6E71;font-family:Arial, Helvetica, sans-serif;font-size:9px;text-decoration:line-through;">
            <?php echo money($product[2]->price_before) ?>
        </div>
        <a href="<?php echo site_url('product/view_product_detail/'.find('alias', $product[2]->product_id, 'product_tb')) ?>"><img src="<?php echo base_url() ?>userdata/ShopNow2.png"></a>
    </div>
</div>


<div style="width:50%;float:left;overflow:hidden;">
    <div style="width:100%;height:auto;overflow:hidden;">
        <a href="<?php echo site_url('product/view_product_detail/'.find('alias', $product[3]->product_id, 'product_tb')) ?>"><img width="100%" src="<?php echo base_url() ?>userdata/product/<?php echo find_first_image($product[3]->product_id) ?>"></a>
    </div>
    <div style="overflow:hidden;text-align:center;">
        <h4 style="margin:0 0 10px;"><a href="<?php echo site_url('product/view_product_detail/'.find('alias', $product[3]->product_id, 'product_tb')) ?>" style="color:#000000;font-family: Arial, Helvetica, sans-serif;font-size:15px;"><?php echo find('name', $product[3]->product_id, 'product_tb') ?></a></h4>
        <div style="color:#EC487B;font-family:Arial, Helvetica, sans-serif;font-size:15px;font-weight:700;">
            <?php echo money($product[3]->price_after) ?>
        </div>
        <div style="color:#6D6E71;font-family:Arial, Helvetica, sans-serif;font-size:9px;text-decoration:line-through;">
            <?php echo money($product[3]->price_before) ?>
        </div>
        <a href="<?php echo site_url('product/view_product_detail/'.find('alias', $product[3]->product_id, 'product_tb')) ?>"><img src="<?php echo base_url() ?>userdata/ShopNow2.png"></a>
    </div>
</div>
</div>
<div style="max-width:560px;width:100%;margin:0 auto;border-top:5px solid #FBD400;overflow:hidden;text-align:center;">
	<div style="text-align:center;font-family:Arial, Helvetica, sans-serif;font-size:11px;width:100%;max-width:560px;margin:0 auto;">
		<?php /*?>,<p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p><br><?php */?><br>
        <p>Ayo bergabung di social media <a href="#" style="color:#000;">TORIOKIDS.COM</a> untuk mendapatkan promo terbaru.</p><br>
        <a href="http://www.facebook.com/Toriokids" style="margin:0 5px 0 0;"><img src="<?php echo base_url() ?>userdata/fbBtn.png"></a>
        <a href="https://twitter.com/Toriokids" style="margin:0 0 0 5px;"><img src="<?php echo base_url() ?>userdata/twBtn.png"></a>
    </div>
</div>
</body>
</html>