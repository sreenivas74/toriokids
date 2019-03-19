<!DOCTYPE html>
<html><head>
<meta charset="utf-8" />
<meta name="viewport" content="target-densitydpi=device-dpi; width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
<meta name="HandheldFriendly" content="true" />
<meta name="description" content="Torio Kids, high quality children wear in Indonesia" />
<meta name="keywords" content="Torio Kids, baby, children, clothes, children wear, pakaian bayi, pakaian anak, pakaian, Indonesia, torio, toriokids, online shop, baju anak, baju bayi" />
<meta name="robots" content="index, follow" />
<title><?php if(isset($page_title))echo $page_title.' |';?> Torio Kids</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>templates/css/fontAttach/fontattach.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>templates/css/jquery.bxslider.css">
<link rel="lightbox[gallery]" type="text/css" href="<?php echo base_url() ?>templates/css/lightbox.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>templates/css/selectordie.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>templates/css/toriokids2016.css">
<script> var base_url='<?php echo base_url();?>';</script>
<script type="text/javascript" src="<?php echo base_url() ?>templates/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>templates/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>templates/js/selectordie.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>templates/js/main.js"></script>

<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
/* window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?2Ws8rj42phhFpVmfjyDhrX2NKZONeedb';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script'); */
</script>
<!--End of Zopim Live Chat Script-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43719516-2', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>
<div id="wrapper">

	<?php $this->load->view('common/header');?>
	<?php $this->load->view('common/menu');?>
    <?php $this->load->view($content);?>
    <?php $this->load->view('common/footer');?>
</div>
 	<?php $this->load->view('common/popup');?>

</body>
</html>