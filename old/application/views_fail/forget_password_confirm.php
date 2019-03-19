<h2>Forget Password,</h2>

    <table class="form"  >
        <tr style="border:none">
            <td colspan="3" style="border:none">Terima kasih,</td>
          
        </tr>
        <tr>
        <td style="border:none"><?php echo $quote?></td>
        </tr>
        
        <tr style="border:none">
            <td colspan="3" style="border:none">&nbsp;</td>
          
        </tr>
    <?php if($keterangan==2){?>
    <tr>
    <td style="border:none"><a href="<?php echo site_url('home/forget_password')?>"> Forget Password</a></Td>
    
    </tr>
    <?php }?>
    <?php if($keterangan==1){?>
    <tr>
    <td style="border:none"><a href="<?php echo site_url('home/')?>"> Login</a></Td>
    
    </tr>
    <?php }?>
    
       
    </table>
