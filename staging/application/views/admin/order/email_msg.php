<div id="content">
<h2>Order &raquo; Email Message</h2>
<div id="submenu">
    <ul>
        <li><a class="defBtn" href="<?php echo site_url('torioadmin/order/detail/'.$detail['id']);?>" ><span>Back</span></a></li>
    </ul>
</div>
<table class="defAdminTable" width="100%">
	<tbody>
    	<tr>
        	<td>Order ID</td>
            <td><?php echo $detail['id'];?></td>
        </tr>
        <tr>
        	<td>Order Number</td>
            <td><?php echo $detail['order_number'];?></td>
        </tr>
    	<tr>
        	<td>User Name</td>
            <td><?php echo find('full_name',$detail['user_id'],'user_tb');?></td>
        </tr>
        <tr>
        	<td>Recipient Name</td>
            <td> <?php echo $detail['recipient_name'];?></td>
        </tr>
        <tr>
        	<td>Phone</td>
            <td><?php echo $detail['phone'];?></td>
        </tr>
        <tr>
        	<td>Shipping Address</td>
            <td><?php echo nl2br($detail['shipping_address']);?></td>
        </tr>
        <tr>
        	<td>Zipcode</td>
            <td><?php echo $detail['zipcode'];?></td>
        </tr>
        <tr>
        	<td>City</td>
            <td><?php echo $detail['city'];?></td>
        </tr>
        <tr>
        	<td>Status</td>
            <td>
					<?php if($detail['status']==0)echo "New"?>
					<?php if($detail['status']==1)echo "Approved"?>
					<?php if($detail['status']==-1)echo "Cancelled"?>
					<?php if($detail['status']==2)echo "Shipped"?>
                    <?php if($detail['status']==3)echo "On Process"?>
            </td>
        </tr>
        <tr>
        	<td>Shipping Cost</td>
            <td><?php echo money(find('shipping_cost',$detail['id'],'order_tb'));?></td>
        </tr>
        <tr>
        	<td>Total</td>
            <td><?php echo money($detail['total']);?></td>
        </tr>
    </tbody>
</table>
Message:
<form name="email_msg_form" id="email_msg_form" method="post" action="<?php echo site_url('torioadmin/order/update_send_email/'.$detail['id']);?>"/>
<input type="hidden" name="order_id" id="order_id" value="<?php echo $detail['id'];?>"  />
<textarea class="txtField" name="msg" id="msg"></textarea><br>
<input type="submit" class="defBtn" value="Submit"/>
</form>

<table class="defAdminTable" width="100%">
	<thead>
    	<tr>
            <th width="4%">No</th>
            <th width="20%">Created Date</th>
            <th width="20%">Message</th>
        </tr>
    </thead>
    <tbody>
<?php 
$no=1; 
if($message)foreach($message as $list){
	?>
    <tr class="form_data">	
        <td valign="top"><?php echo $no;?></td>
        <td valign="top"><?php echo $list['created_date'];?></td> 
        <td valign="top"><?php echo $list['msg'];?></td>      
    </tr>
    
    <?php $no++; }?>
    </tbody>
</table>

<script type="text/javascript">

$().ready(function() {
	var opts = {
		cssClass : 'el-rte',
		height   : 300,
		toolbar  : 'maxi',
		cssfiles : ['<?php echo base_url();?>templates/css/elrte.full.css']
	}
	$('#msg').elrte(opts);
})

	
$(".edit_btn").click(function(){
	$("#cancel_edit_order_item").toggle();
	$("#edit_order_item").toggle();
	$(".form_row").toggle();	
	$(".form_data").toggle();
	$("#td_submit").toggle();
	return false;
});

function update_total(no){
	var price=parseInt($("#price_"+no).val());
	var quantity=parseInt($("#quantity_"+no).val());
	
	var total=price*quantity;
	$("#total_"+no).val(total);
	$("#total2_"+no).html(add_comma(total));	
}
$('#dob').datepicker({
		numberOfMonths: 1,
		showButtonPanel: true,
		yearRange: "-80:+80",
		changeYear: true,
		dateFormat: "yy-mm-dd",
		minDate: "-80y"
	});
</script>
</div>