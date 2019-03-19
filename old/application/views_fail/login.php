<h2>Welcome, Please Login</h2>
<?php if(isset($errLogin)) echo "<font color='red'>".$errLogin."</font>";?>
<form id="myform" action="<?php echo site_url('login/do_login')?>" method="post">
    <table class="form">
        <tr>
            <td>ID Login</td>
            <td><input type="text" name="username" /></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="password" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="Login" /></td>
        </tr>
    </table>
</form>
<a href="<?php echo site_url('home/forget_password')?>">Forget password ?</a>