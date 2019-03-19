<div id="content">
    <h2>Welcome to Toriokids Content Management System</h2>
    <p><b>Content Management System is a tool where you can easily manage what's inside your website.</b></p>
    <p>Please login below with your administrator account that we have provided earlier...</p>
    <h3>Login:</h3>
    <p>Enter your administrator username and password below.</p>
    <form class="loginForm" name="admin_login_form" method="post" action="<?php echo site_url('torioadmin/login/do_login');?>">
        <dl>
            <dt><label class="autoFade" for="username"></label><input name="username" id="username" class="txtField" type="text" placeholder="username"/></dt>
        </dl>
        <dl>
            <dt><label class="autoFade" for="password"></label><input name="password" id="password" class="txtField" type="password" placeholder="password"/></dt>
        </dl>
        <dl>
            <dd></dd>
            <dt><input type="submit" class="defBtn" value="Login" /></dt>
            <label class="error"><?php if(isset($error)){ echo $error;}?></label>
        </dl>
    </form>
</div>