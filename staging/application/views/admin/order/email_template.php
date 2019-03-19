<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Torio Kids</title>
	
</head>
<body > 

    <div>

        <table>
            
            	<td>&nbsp;</td>
            </tr>
            <tr>
                <td><p style="margin:10px 0;">
                
                <?php echo nl2br($message);?>  
                  <br /><br />
                    To download order, please click on this link<br />
                    <a target ="_blank" href="<?php echo site_url('home/download_order'.'/'.$detail['id']);?>"><?php echo site_url('home/download_order'.'/'.$detail['id']);?></a>
                    <br />
                    Or if clicking the link above does not work, you can try to copy and paste it into your browser.
                    <br /><br /><br />
                    
                   
                    </p>
              </td>
            </tr>
          
        </table>
    </div>
</body>
</html>