<?php if($this->session->userdata('admin_logged_in')==TRUE){?>
<div id="nav">
    <h2>Admin Menu</h2>
    <ul>
        <li><strong>Order</strong>
          	  <ul>
                <li><a href="<?php echo site_url('torioadmin/order');?>">All Order List</a></li>
                <li><a href="<?php echo site_url('torioadmin/order/bank');?>">Order (Bank Transfer)</a></li>
                <li><a href="<?php echo site_url('torioadmin/order/cc');?>">Order (Credit Card)</a></li>
                <li><a href="<?php echo site_url('torioadmin/order/recap');?>">Recap</a></li>
              </ul>
          </li>
        <li><strong>Banner</strong>
        	<ul>
            	<li><a href="<?php echo site_url('torioadmin/home_banner/view_banner_list/1'); ?>">Large Banner</a></li>
            	<li><a href="<?php echo site_url('torioadmin/home_banner/view_banner_list/2'); ?>">Small Banner</a></li>
            	<li><a href="<?php echo site_url('torioadmin/small_footer_banner/view_banner_list'); ?>">Small Footer Banner</a></li>
                <li><a href="<?php echo site_url('torioadmin/featured_item'); ?>">Featured Items</a></li>
            </ul>
        </li>
		<li><strong>Torio Coupons</strong>
        	<ul>
            	<li><a href="<?php echo site_url('torioadmin/coupon/'); ?>">List Coupons</a></li>
            	
            </ul>
        </li>
        <li><strong>Product</strong>
        	<ul>
            	<li><a href="<?php echo site_url('torioadmin/category'); ?>">Category List</a></li>
                <li><a href="<?php echo site_url('torioadmin/product'); ?>">Product List</a></li>
               <?php /*?> <li><a href="<?php echo site_url('torioadmin/discount'); ?>">Discount List</a></li><?php */?>
                <li><a href="<?php echo site_url('torioadmin/jne'); ?>">JNE List</a></li>
                <li><a href="<?php echo site_url('torioadmin/product/view_new_product'); ?>">New Product</a></li>
          <?php /*?>      <li><a href="<?php echo site_url('torioadmin/product/view_sale_product'); ?>">Sale Product</a></li><?php */?>
                <li><a href="<?php echo site_url('torioadmin/product/view_featured_product'); ?>">Featured Product</a></li>
                 <li><a href="<?php echo site_url('torioadmin/product/view_product_active'); ?>">Product Active / inactive</a></li>
                <li><a href="<?php echo site_url('torioadmin/product/view_price_product'); ?>">Product Price</a></li>
            </ul>
        </li>
        <li><a href="<?php echo site_url('torioadmin/template'); ?>">Template List</a></li>
        <li><a href="<?php echo site_url('torioadmin/footer_menu'); ?>">Footer Menu</a></li>	
        <li><strong>Content</strong>
        	<ul>
            	<li><a href="<?php echo site_url('torioadmin/content_page'); ?>">Content Page</a></li>
                <li><a href="<?php echo site_url('torioadmin/content_page/view_faq_category'); ?>">FAQ Category</a></li>
                <li><a href="<?php echo site_url('torioadmin/content_page/view_faq'); ?>">Frequently Asked Questions</a></li>
       			<li><a href="<?php echo site_url('torioadmin/sale_page'); ?>">Sale Page Content</a></li>	
            </ul>
        </li>
        <li><a href="<?php echo site_url('torioadmin/user/index/2');?>">User List</a></li>
        <li><strong>Newsletter</strong>
        	<ul>
            	<li><a href="<?php echo site_url('torioadmin/newsletter'); ?>">View All</a></li>
            	<li><a href="<?php echo site_url('torioadmin/newsletter/active'); ?>">Active Subscribers</a></li>
                <li><a href="<?php echo site_url('torioadmin/newsletter/inactive'); ?>">Inactive Subscribers</a></li>
            </ul>
        </li>
        <li><strong>Stamps</strong>
            <ul>
                <li><a href="<?php echo site_url('torioadmin/stamps');?>">Stamps Rewards List</a></li>
                <li><a href="<?php echo site_url('torioadmin/stamps/add');?>">Add Rewards</a></li>
            </ul>
        </li>
        <li><a href="<?php echo site_url('torioadmin/advertisement'); ?>">Advertisement</a></li>
        <li><a href="<?php echo site_url('torioadmin/currency'); ?>">Currency</a></li>	
         <li><a href="<?php echo site_url('torioadmin/order/clear_shopping_cart'); ?>" onclick="return confirm('are you sure?')">Clear Shopping Cart</a></li>	
        <li><a href="<?php echo site_url('torioadmin/logout'); ?>">Logout</a></li>
    </ul>
</div>
<?php } else {?>
<div id="nav">
    <h2>Admin Login</h2>
    <ul>
        <li><a href="<?php echo site_url('torioadmin/login'); ?>">Login</a></li>
    </ul>
</div>
<?php }?>