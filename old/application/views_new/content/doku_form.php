<script language="JavaScript" type="text/javascript">
//document.getElementById('param_pass').submit();
$(document).ready(function(){
	document.getElementById('param_pass').submit();
});
</script>
<div class="shopCartContent">
    <h2>Shopping Cart</h2>
    <div class="stepShopping">
        <div class="firstStepDone">Shopping Cart</div>
        <div class="otherStep">Shipping</div>
        <div class="lastStep">Payment</div>
    </div>
</div>
<div class="boxConNoBg">
<form name="param_pass" id="param_pass" method="post" action="<?php echo site_url('ccpayment/do_checkout');?>">
    <input name="order_number" type="hidden" id="order_number" value="<?php echo $order_number?>">
    <input name="purchase_amt" type="hidden" id="purchase_amt" value="<?php echo $purchase_amt?>">
    <input name="status_code" type="hidden" id="status_code" value="<?php echo $status_code?>">
    <input name="session_id" type="hidden" id="session_id" value="<?php echo $session_id?>">
</form>
<noscript>
If you are not redirected please <a href="<?php echo $redirect_url; ?>">click here</a> to confirm your order.
</noscript>
</div>