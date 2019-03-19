<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Torio Kids</title>
	<style type="text/css">
		.ExternalClass {width:100%;}
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
			line-height: 100%;
			}
		body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
		body {margin:0; padding:0;}
		table td {border-collapse:collapse;}
		
		p {margin:0; padding:0; margin-bottom:0;}
				
		h1, h2, h3, h4, h5, h6 {
		   color: black;
		   line-height: 100%;
		   }
		a, a:link {
		   color:#0071BC;
		   text-decoration: underline;
		   }
		body, #body_style {
			color:#000;
			font-family:Arial, Helvetica, sans-serif;
			font-size:12px;
		}
		h1, h2, h3, h4, h5, h6{
			color:#000;
		}
		a:visited { color: #0071BC; text-decoration: none}
		a:focus   { color: #0071BC; text-decoration: underline}
		a:hover   { color: #0071BC; text-decoration: underline}
	</style>
</head>
<body style="background:#FFF; color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px" 
alink="#ff9900" link="#ff9900" bgcolor="#FFF" text="#000000" yahoo="fix"> 

    <div id="body_style" style="padding:15px;">

        <table cellpadding="0" cellspacing="10" border="0" bgcolor="#fff" width="800" align="center" style="line-height:18px; padding:0; border:5px solid #DBF291; background:#fff;">
            <tr>
                <td>
                    <a href="<?php echo base_url();?>"><img alt="Torio Kids." title="Torio Kids." src="<?php echo base_url();?>templates/images/logo.png" style="display:block; border:0; margin:10px 0 0;" /></a>
                </td>
            </tr>
            <tr>
            	<td style="border-bottom:1px solid #FCD400;">&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <h1 style="margin:20px 0; color:#D4155B; font-size:18px;">Hi, <?php echo $detail;?>!</h1>
                    
                    <p style="margin:10px 0;">
                    Thank you for signing up an account with <a href="<?php echo base_url();?>" style="color:#9E005D;">Torio Kids.</a>.
                    <br /><br />
                    To verify your account with us, please click on this link<br />
                    <a target ="_blank" href="<?php echo $verify_link;?>"><?php echo $verify_link;?></a>
                    <br />
                    Or if clicking the link above does not work, you can try to copy and paste it into your browser.
                    <br /><br /><br />
                    
                    If, for any reason, you do not wish to continue the registration process, or you have received this message in error, please click on this link<br />
                    <a target ="_blank" href="<?php echo $cancel_link;?>"><?php echo $cancel_link;?></a>
                    <br />
                    Or if clicking the link above does not work, you can try to copy and paste it into your browser.
                    <br /><br />
                    Please feel free to ask us any questions, or  tell us anything about the registration process, or make any other constructive comments by sending an e-mail to <span style="color:#9E005D">info@toriokids.com</span>
                    </p>
                </td>
            </tr>
            <tr>
            	<td style="padding:40px 5px 20px; font-size:12px;">
                	Regards,
                    <br /><br />
                    <strong>Torio Kids</strong>
                </td>
            </tr>
            <tr>
                <td style="font-size:10px; padding:20px 20px; width:800px; height:100 px; vertical-align:top; display:table-cell; background:#DBF291; color:#A67C52;">
                    <a target ="_blank" style="float:left; margin:0 20px 0 0;" href="<?php echo base_url();?>"><img src="<?php echo base_url();?>templates/images/smallLogo.png" /></a><p align="right" style="line-height:28px;">&copy; <?php echo date("Y") ?> Torio Kids. All Rights Reserved.</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>