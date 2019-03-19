<h2>Forget Password</h2>

<form id="myform" action="<?php echo site_url('home/do_forget_password')?>" method="post">
    <table class="form">
        <tr>
            <td>ID Login</td>
            <td><input type="text" name="username" /></td>
        </tr>
      
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="submit" /> <input onClick="window.location='<?php echo site_url(); ?>'" type="button" value="back" style="width:50px"/></td>
        </tr>
    </table>
</form>
