<script type="text/javascript">
function enterform(){
	$("#ticket_form").validate({
		rules : {
			name : {
				required : true
			},
			pic : {
				required : true
			},
			email : {
				required : true,
				email : true
			},
			complaint : {
				required : true
			}
		},
		messages: {
			name : "<span style='vertical-align:top'>*</span>",
			pic : "<span style='vertical-align:top'>*</span>",
			email : "<span style='vertical-align:top'>*</span>",
			complaint : "<span style='vertical-align:top'>*</span>"
	   }
	});
	
	if($("#ticket_form").validate().form() == true){
		$("#ticket_form").submit();
		return true;	
	}
	else{
		return false;
	}
}

function open_ticket(){
	$('#open_ticket').slideDown();	
}
</script>
<style>
	a{
		color:#000;	
	}
	a:hover{
		color:#00F;
	}
	
	.warning{
		color:#F00;
	}
	
	#ticket{
		display:block;
		width:800px;
	}
	#ticket_logo_left{
		display:block;
		float:left;
		width:200px;
	}
	#ticket_logo_right{
		display:block;
		float:left;
		width:600px;
	}
		#ticket_logo_right h2{
			margin:17px 0 0 0;
			font-family:Tahoma, Geneva, sans-serif;
			font-size:30px;
		}
	#ticket_content{
		clear:both;
		display:block;
	}
	#ticket_content_left{
		display:block;
		width:500px;
		float:left;
	}
	#ticket_content_right{
		display:block;
		width:300px;
		float:left;
	}
	
	.button_send{
		padding:3px 5px;	
	}
	p.title{
		font-family:Tahoma, Geneva, sans-serif;
		font-size:14px;
		font-weight:bold;	
	}
</style>
<div id="ticket">
	<div id="ticket_logo_left"><img src="<?php echo base_url()?>images/gsi_logo.jpg" /></div>
    <div id="ticket_logo_right"><h2>Customer Ticket</h2></div>
    
    <div id="ticket_content">
    	<p>Jika anda mempunyai pertanyaan mengenai produk dan layanan PT. Golden Solution Indonesia atau ingin menyampaikan <b>Informasi, Saran, Pengalaman,</b> ataupun <b>Keluhan</b> yang dapat memperbaiki kinerja kami, silahkan mengisi formulir di bawah.</p>
    	<hr size="1" />
        <div id="ticket_content_left">
        	<p class="title">Ticket</p>
            <hr size="1" width="90%" align="left" />
            <form name="ticket_form" id="ticket_form" method="post" enctype="multipart/form-data" action="<?php echo site_url('ticket/add_ticket')?>">
                <table style="width:100%; border:none; margin:2px; padding:20px; color:#000">
                    <thead>
                        <th colspan="2"></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="20%" valign="top">Company</td>
                            <td><textarea name="name" id="name" rows="1" cols="40"></textarea></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td valign="top">Name</td>
                            <td><textarea name="pic" rows="1" cols="40"></textarea></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td valign="top">Email</td>
                            <td><textarea name="email" id="email" rows="1" cols="40"></textarea></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td valign="top">Phone</td>
                            <td><textarea name="phone" id="phone" rows="1" cols="40"></textarea></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td valign="top">Problem</td>
                            <td><textarea name="complaint" id="complaint" rows="5" cols="40"></textarea></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td valign="top"></td>
                            <td><input type="submit" class="button_send" value="Send" onclick="enterform();return false;" />
                            <br /><br />
                            <?php if(isset($_SESSION['required_field']))echo $_SESSION['required_field'];?></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <div id="ticket_content_right">
           	<p class="title">Login to see your ticket history</p>
            <hr size="1" />
            <style>
				dd{
					padding:5px;	
				}
				dt{
					padding:3px;
				}
			</style>
            <span class="warning"><?php if(isset($_SESSION['admin_notif']))echo "<br /><br />".$_SESSION['admin_notif'];?></span>
            <form name="ticket_login_form" method="post" action="<?php echo site_url('ticket/index/');?>">
                <dl>
                    <dd>Login</dd>
                    <dt><input type="text" name="login" style="width:150px; padding:2px;" /></dt>
                </dl>
                <dl>
                    <dd>Password</dd>
                    <dt><input type="password" name="password" style="width:150px; padding:2px;"/></dt>
                </dl>
                <dl>
                    <dd></dd>
                    <dt><input type="submit" class="button_send" value="login" /></dt>
                </dl>
            </form>
            <hr size="1" />
            <div style="border-style:solid; border-radius:5px; margin:3px;">
            	<div style="padding:5px;">
                    <p class="title">Contact Us Directly</p>
                    <hr size="1" />
                    <p><b>PT. Golden Solution Indonesia</b>
                    <br /><br />
                    Jalan Kyai Caringin<br />
                    No. 2A Cideng, Jakarta Pusat<br />
                    Telp : (021) 3483 5030<br />
                    Fax : (021) 3447 368
                    </p>
            	</div>
            </div>
        </div>
    </div>
</div>

