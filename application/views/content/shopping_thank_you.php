<section>
        	<div class="contentWrapper">
            	<div class="mainWrapper nobanner">
                	<div class="shopcartWrapper">
                        <div class="thankyouBox">
                        	<h1>THANK YOU</h1>
                            <p>You will receive an order confirmation email with details of your order and a link to track its progress.</p>
                            <br>
                            <p>If you have an account, you can view your order status and history from the "<a href="<?php echo site_url('my_order');?>" target="_blank">My Orders</a>" menu in your profile.</p>
                            <br>
                            <p>Please confirm to us once you have made your payment by clicking the button below : <br><br><a class="defBtn" style="color: #fff;" href="<?php echo site_url('payment_confirmation') ?>">Confirm Payment</a></p>
                            <br><br>
                            <?php /* ?>
                            <p>Jika ingin berlngganan newsletter kami, 
bisa mengisi email Anda dibawah ini</p>
							<br>
                            <form method="post" id="form_news" action="<?php echo site_url('newsletter/process') ?>">
							<input placeholder="Type Your Email" name="email"><a href="javascript:void(0)" id="news_submit" class="subscribeBtn">subscribe</a>
                            </form>
                            <?php */ ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<script>
$('#news_submit').click(function(){
    $('#form_news').submit();
});
</script>