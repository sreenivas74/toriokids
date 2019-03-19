<header id="headerCon">
    <div class="headerBox">
        <div id="logoContainer"><h1><a id="logo" href="<?php echo site_url('home');?>" title="Torio Kids">Torio Kids</a></h1>
        </div>
        <div class="headerRight">
            <div class="headerRightTop">
                <div class="login">
                <?php if($this->session->userdata('user_logged_in')==FALSE){?>
                    Please <a class="loginBtn" href="<?php echo site_url('login');?>">login</a> or <a class="regBtn" href="<?php echo site_url('login');?>">register</a> Here
                </div>
                <p>Selamat berbelanja di Torio!</p>
                <?php } else {?>
                <a class="loginBtn" href="<?php echo site_url('my_account/dashboard');?>">My Account</a> | <a class="regBtn" href="<?php echo site_url('logout');?>">Logout</a>
                </div>
                <p>Welcome, <?php echo $this->session->userdata('name')?></p>
                <?php } ?>
            </div>
            <div class="headerRightBot">
            	
                <div class="shoppingCart">
                    <div class="shoppingCartLeft">
                        <div class="notif"><a href="<?php echo site_url('shopping_cart');?>" class="total_item notifNumber"><?php echo $total_item;?></a></div>
                    </div>
                    <div class="shoppingCartRight">
                        <p class="bigBlueColor" id="total_prices"><?php echo money($total_price);?></p>
                        <input type="submit" class="checkoutBtn" value="Checkout" onclick="window.location='<?php echo site_url('shopping_cart')?>';"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="fixedHeader">
        	<div class="fixedHeadeBox">
            	<h1><a href="<?php echo base_url()?>" id="fixedLogo">Torio Kids</a></h1>
                <ul>
	                <li><a href="<?php echo site_url('product/sale')?>" class="fixedSellItems">Sale Items</a></li>
                	<li><a href="<?php echo site_url('product/best_seller')?>" class="fixedBestSeller">Best Seller</a></li> 
                </ul>
                <ul>
                    <li>
                    	<div class="fixedSearch">
                        	<span>Search</span>
                            <div class="fixedSearchBox">
                                <form name="search_form2" id="search_form2" method="get" action="<?php echo site_url('product/search');?>">
                                    <input type="text" name="search" id="search2"/>
                    				<a href="#" class="searchBtn" onclick="validate2();return false;" >Search!</a>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li>
                    	<div class="fixedCart">
                        	<div class="fixedCartBg">
                            	<div class="fixedNotif">
                                	<a href="<?php echo site_url('shopping_cart');?>" class="total_item"><?php echo $total_item;?></a>
                                </div>
                            </div>
                            <a href="<?php echo site_url('shopping_cart');?>" class="fixedViewCart">View Cart</a>
                    	</div>
                    </li>
                    <li>
                    	<a href="<?php echo site_url('shopping_cart');?>" class="fixedCheckout">Checkout</a>
                    </li>
                    <li>
                    	<a href="#" class="backToTop">back to top</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<script type="text/javascript">
function validate2()
{
	var keyword2 = $('#search2').val();
	if (keyword2=="")
	{
//		alert('Minimum 3 characters for search');
		return false;
	}
	else 
	{	
		$('#search_form2').submit();
		return true;
	}
}
</script>