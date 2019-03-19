<div class="noBg">
    <a href="<?php echo site_url('home');?>">Home </a>&gt;<a> <?php echo $detail['name']?></a>
</div>
<div class="contentElement">
    <h2><?php echo $detail['name']?></h2><br/>
    <?php echo $detail['content']?>
</div>
<div class="contactUsCon">
    <form id="contact_us_form" name="contact_us_form" method="post" enctype="multipart/form-data" action="#" onsubmit="return false;">
        <h2>Send Us a Message</h2>
        <table>
            <tr>
                <td width="30%">Name <span class="redStar">*</span></td>
                <td width="70%"><input type="text" class="inputTxt validate[required]" name="name" id="name"/></td>
            </tr>
            <tr>
                <td>Email <span class="redStar">*</span></td>
                <td><input type="text" class="inputTxt validate[required]" name="email" id="email"/></td>
            </tr>
            <tr>
                <td>Phone Number <span class="redStar">*</span></td>
                <td><input type="text" class="inputTxt validate[required]" name="phone_number" id="phone_number"/></td>
            </tr>
            <tr>
                <td class="address">Message <span class="redStar">*</span></td>
                <td><textarea class="addTxt validate[required]" name="message" id="message"></textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                        <div style="display:block;overflow:hidden;">
                            <span class="redStar">*</span> is required
                        </div>
                     <input type="submit" class="okContact" id="contact_us_submit" value="SEND"/>
                </td>
            </tr>
        </table>
    </form><br /><br />
</div>