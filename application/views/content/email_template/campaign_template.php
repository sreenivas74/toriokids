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
	color: #808285;
	line-height: 100%;}
a, a:link {
	color:#C1C14E;
    text-decoration: none;}
a:visited { color: #808285; text-decoration: none;} 
a:focus   { color: #808285; text-decoration: none;}  
a:hover   { color: #808285; text-decoration: none;}  
body, #body_style {
	background-color:#fff;
	min-height:1000px;
	color:#000;
	font-family: 'Lato', sans-serif;;
	font-size:14px;}
span.yshortcuts { color:#000; background-color:none; border:none;}
span.yshortcuts:hover, span.yshortcuts:active, span.yshortcuts:focus {color:#000; background-color:none; border:none;}

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
	tr[class="twoColumns"]{
		width:300px !important;
		text-align:center;
		display:block;}
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
}

</style>
</head>

<body style="background:#fff; min-height:1000px; color:#808285;font-family: 'Arial', sans-serif;; font-size:14px; line-height:20px;"
alink="#C1C14E" link="#C1C14E" bgcolor="#fff" text="#808285" yahoo="fix">

<table cellpadding="0" cellspacing="0" border="0" width="600" align="center">
  <tr bgcolor="#cbebf8">
    <td align="center" style="padding:20px"><a href="#" target="_blank" title=""><img alt="Torio Kids." title="Torio Kids." src="http://www.toriokids.com/templates/images/logo.png" style="display:block; border:0; margin:10px auto;" /></a></td>
  </tr>
  <tr bgcolor="#cbebf8" style="padding: 0 20px;" >
    <td class="title" style="text-align:center; font-size:48px; padding:5px 20px; color:#0071bc; line-height:48px;"><?php echo $detail['title'] ?></td>
  </tr>
  <tr bgcolor="#cbebf8">
  	<td style="padding: 10px 20px;"><a href="<?php if($detail['link']!='') echo $detail['link']; else echo "javascript:void(0)"; ?>" <?php if($detail['link']) echo "target='_blank'"; ?>><img class="resize" src="<?php echo base_url()."userdata/campaign/".$detail['image'] ?>" style="display:block; border:0; width:560px;" /></a></td>
  </tr><tr bgcolor="#cbebf8">
    <td style="padding: 20px; text-align:left;"><p><?php echo nl2br($detail['description']) ?></p>
    <p>&nbsp;</p>
    <?php if($detail['show_button']==1){ ?>
    <p align="center"><a href="<?php if($detail['button_link']) echo $detail['button_link']; else echo base_url(); ?>"><strong>BELANJA SEKARANG &gt;&gt;</strong></a></p>
    <?php }?>
    </td>
  </tr>
</table>
<table align="center" width="600px" border="0" bgcolor="#cbebf8" style="font-size:12px; text-align:center; padding-top:5px;">
  <tr>
	<td>Do not reply to this message. If you have any further question please e-mail us at cs@toriokids.com</td>
  </tr>
</table>

</body>
</html>