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
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>templates/css/validationEngine.jquery.css"/>
<script> var base_url='<?php echo base_url();?>';</script>
<script type="text/javascript" src="<?php echo base_url() ?>templates/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>templates/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>templates/js/selectordie.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
  <div class="socmedBox">
      <p>Follow Us!</p>
      <a href="https://facebook.com/TorioKids" target="_blank" class="fbIcon">facebook</a>
      <a href="https://www.instagram.com/TorioKids/" target="_blank" class="instaIcon">instagram</a>
  </div>
</div>
 	<?php $this->load->view('common/popup');?>
  
<script>
$("#submit").click(function() {
        $("#formID").submit();
    });
$("#submit_search").click(function() {
        $("#search_form").submit();
    });
</script>
<script>
window.fbAsyncInit = function() {
    FB.init({
      appId      : <?php echo APP_ID?>,
      xfbml      : true,
      version    : 'v2.5'
    });
  };

(function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

$(document).ready(function() {
    $('.facebook_login').click(function(e){
      e.preventDefault();
    //checkLoginState();
      facebookLogin();
  });
});

function checkLoginState() {
<?php 

$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
$chrome   = stripos($_SERVER['HTTP_USER_AGENT'],"Chrome");
$crios   = stripos($_SERVER['HTTP_USER_AGENT'],"crios");

if( ($iPod || $iPhone ) && ($crios || $chrome)){?>
  alert("Facebook login is disabled for Chrome IOS. Please use safari to continue");
<?php }else{?>
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
<?php }?>
  }

function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      facebookLogin();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
    FB.login();
      console.log( 'Please log ' +
        'into this app.');
    facebookLogin();
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
    //FB.login();
      console.log( 'Please log ' +
        'into Facebook.');
    facebookLogin();
    }
  }

function facebookLogin() {
        var login_type = $('#login_type').val();
        FB.login(function(response) {
            if (response.authResponse) {

            var token=response.authResponse.accessToken;
            FB.api('/me?fields=email,name', function(response) {
    
          $.ajax({
            type: "POST",
            url: '<?php echo site_url('login/facebooklogin/');?>',
            dataType:"JSON",
            data: {
              name : response.name,
              email:response.email,
              facebook_id:response.id,
              data_facebook:response,
              token:token
            },
            dataType:"JSON",
            success: function(data){
              if(!data.phone){
                if(login_type==1){
                  window.location="<?php echo site_url('registration/complete_profile') ?>/"+login_type;
                }
                else if(login_type=="customer_info"){
                  window.location="<?php echo site_url('registration/complete_profile') ?>/"+1;
                }
                else{
                  window.location='<?php echo site_url('registration/complete_profile')?>';
                }
              }
              else{
                if(login_type=="customer_info"){
                  window.location='<?php echo site_url('shopping_cart/customer_information')?>';
                }
                else if(login_type==1){
                  window.location='<?php echo site_url('shopping_cart/customer_information')?>';
                }
                else{
                  window.location='<?php echo site_url('home')?>';
                }
              }

            }
          });//ajax
        
        });//fb.api
            }
        },{scope: 'public_profile,email'});
    }
</script>
<?php if($this->session->flashdata('notif')){?>
<script>
    alert('<?php echo $this->session->flashdata('notif')?>');
</script>
<?php }?>
<script>
$(document).ready(function(){
    <?php if(isset($error_tujuan)){ ?>
        // $('.defTxtInput').addClass('error');
        $('#bank_tujuan').closest('.sod_select').addClass('error');
        // alert('bisa');
    <?php } ?>
    <?php if(isset($error_metode)){ ?>
        // $('.defTxtInput').addClass('error');
        $('#metode').closest('.sod_select').addClass('error');
        // alert('bisa');
    <?php } ?>
});
</script>
</body>
</html>

