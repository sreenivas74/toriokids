

<div id="content">

	<h2>Email &raquo; Sent</h2>
  
  	<?php if($email_counter){ ?>
    	<span>Sent : <?php echo count($email_counter) ?> time(s)</span>
        <div>
        	<?php foreach($email_counter as $list){ 
            	echo date('d F Y H:i:s', strtotime($list['send_time']))." ( ".$list['email_to']." )<br>";
             }?>
        </div>
    <?php }?>
  	
   <form id="set_email" method="POST" action="#" onSubmit="return false;">  
    <dl><dd>Email</dd>
    <dd><input type="text" value="<?php echo $sent_email['email'];?>" name="email" id="email_send"> <input type="button" value="Change Email" onClick="change_email();"></dd>
    
    </dl>
    </form>
	<form method="post" name="add_product_form" id="add_product_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/order/send_email_form'.'/'.$detail['id']);?>">
  
        <dl>
            <dd>Subject</dd>
            <dt><input class="txtField validate[required]" type="text" name="subject" id="subject" value="Order Received - <?php echo $detail['order_number'];?>" readonly/></dt>
        </dl>
       
        <dl>
            <dd>Content</dd>
            <dt><textarea class="txtField" type="text" name="message"></textarea></dt>
        </dl>
      
       
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" id="add_product_submit" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/order');?>';" /></dt>
    </dl>
    </form>
</div>
<script>

$(document).ready(function() {
    $('#email_send').keydown(function(event) {
        if (event.keyCode == 13) {
           change_email();
            return false;
         }
    });
});
function change_email(){
	var email=$("#email_send").val();
	if(confirm('are you sure?')){
			
			$.ajax({
				type: "POST",
				url: '<?php echo base_url().'torioadmin/order/change_email';?>',
				data: {
							email:email,
					
				},
				success: function(data){
					alert('email successfully changed');
					 
				}
			});
		
		
		}else{
		//return false;
	}
}
</script>

