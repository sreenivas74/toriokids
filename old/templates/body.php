<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="description" content="Torio Kids, high quality children wear in Indonesia" />
<meta name="keywords" content="Torio Kids, baby, children, clothes, children wear, pakaian bayi, pakaian anak, pakaian, Indonesia, torio, toriokids, online shop, baju anak, baju bayi" />
<meta name="robots" content="index, follow" />
<title><?php if(isset($page_title))echo $page_title.' |';?> Torio Kids</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>templates/css/fontAttach/stylesheet.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>templates/css/torio.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>templates/css/jquery.bxslider.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>templates/css/uniform.default.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>templates/css/smoothness/jquery-ui-1.9.2.custom.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>templates/css/validationEngine.jquery.css"/>
<link href="<?php echo base_url();?>templates/css/jquery.jscrollpane.css" rel="stylesheet" type="text/css">
<link rel="icon" type="image/png" href="<?php echo base_url();?>favicon.png" />
<script> var base_url='<?php echo base_url();?>';</script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/jquery.min.1.8.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/jquery.uniform.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/jquery.slides.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/jquery.bxSlider.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/placeholder.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/combodate.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/mwheelIntent.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/main.js"></script>
<!--[if lt IE 9]>
<script src="<?php echo base_url();?>templates/js/html5shiv.js"></script>
<![endif]-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43719516-1', 'toriokids.com');
  ga('send', 'pageview');

</script>
</head>
<body>
<div id="container">
	<?php $this->load->view('common/header');?>
	<?php $this->load->view('common/menu');?>
    <section id="<?php if($this->uri->segment(2)=="view_product_detail")echo "content2";else echo "content";?>">
        <?php $this->load->view($content);?>
    </section>
    <?php $this->load->view('common/footer');?>
    
	<div id="overlay" class="overlay"></div>
    <div id="popUpFbCon" class="popup popUpFb">
        <div class="popupContent">
            <h3>Dapatkan Special Discount</h3><br>
            <p>Like Torio Kids Facebook Page &amp; Dapatkan Special Discount 20%<br><br>
            <div class="fb-like" data-href="http://www.facebook.com/toriokids" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div></p>
        </div>
        <div class="close"></div>
    </div>
    <div id="fb_coupon_popup" class="popup">
        <div class="popupContent">
            <h3>Terima kasih sudah like facebook fanpage toriokids!</h3><br>
           <div class="proceed"><a href="#" onClick="apply_fb_voucher();return false;">Next</a></div>
        </div>
    </div>
</div>

</div>
</body>
</html>
    
 <div id="fb-root"></div>
    <script>

	
function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }
    return true;
}
      window.fbAsyncInit = function() {
        FB.init({
          appId : <?php echo APP_ID?>,
          status: true,
          cookie: true,
          xfbml : true,
          oauth : true,
        });
		<?php //if(!isset($_SESSION['id'])){?>
        FB.Event.subscribe('auth.login', function(response) {
          //parent.location.relad();
		//  facebookLogin();
        });
			FB.Event.subscribe('edge.create', function(response2){
				console.log('like this');
				var like_app_page = 1;
				
								
				$.ajax({
					
					type:"POST",
					url: '<?php echo base_url().'home/facebook/';?>',
					data: {like : '1'},
					success: function(data){
						/*$("#overlay_1").fadeOut(500);
						$(".popUpFb").fadeOut(500);
						$(".overlay").fadeOut(500);	*/				
						// location.reload();
						$(".popUpFb").fadeOut(500,function(){
							$("#fb_coupon_popup").fadeIn(500);
						});
					}
				});
			});
			
			FB.Event.subscribe('edge.remove', function(response3) {
				console.log('unlike this');
				var like_app_page = 2;
				//$("#overlay_1, .popUpFb").hide();
				/*$.ajax({
					type:"POST",
					url: '<?php echo base_url().'home/facebook/';?>',
					data: {like : '2'},
					success: function(data){
						
						$("#overlay_1").fadeOut(500);
						$(".popUpFb").fadeOut(500);
					}
				});*/location.reload();
			});
		<?php //}?>
      };
 
      (function(d){
        var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/en_US/all.js";
        d.getElementsByTagName('head')[0].appendChild(js);
      }(document));
    </script>
 <script>
 function fb_autopost(){
	   FB.init({
          appId : <?php echo APP_ID; ?>,
          cookie: true,
          status: true,
          xfbml : true,
          oauth : true,
        });

FB.api('/me/feed', 'post', { message: 'Saya baru saja mendapatkan special discount 20% dari Toriokids.- Ayo dapatkan diskon 20% dari Torio Kids, Like Facebook Torio Kids & kunjungi website kita di toriokids.com !',link:'www.toriokids.com',picture:'http://www.toriokids.com/torio2/userdata/toriokids_fb_post.jpg' }, function(response) {
					  if (!response || response.error) {
						//alert('Error occured');
					  } else {
						//alert('Post ID: ' + response.id);
					  }
					});	
}
 </script>