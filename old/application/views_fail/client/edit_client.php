<script type="text/javascript">
function enterform() {
	$(document).ready(function() {
		$("#myform").validate({
			rules : {
				name : {
					required : true
				},
				cp_1 : {
					required : true	
				},
				phone : {
					required : true	
				}
			},
			messages : {
				name : " *",
				cp_1 : " *",
				phone : " *"
			}
		});
		
		if($("#myform").validate().form() == true){
			$("#myform").submit();
			$("a#btnGo").css("display","none");
			return true;	
		}
		else{
			return false;
		}
	})
}
</script>
<h2>Client &raquo; - Edit</h2>
<form action="<?php echo site_url('client/do_edit_client/'.$client['id']);?>" enctype="multipart/form-data" name="myform" id="myform" method="post">
    <table class="form">
        <thead>
            <th colspan="2">Edit Client</th>
        </thead>
        <tr>
            <td class="field">Name:</td>
            <td><input type="text" name="name" value="<?= $client['name']?>" /></td>
        </tr>
        <tr>
            <td class="field">Industry:</td>
            <td>
            <select name="industry">
            <?php if($industry)foreach($industry as $list){?>
                <option value="<?= $list['id']?>" <?php if($client['industry']==$list['id']){?> selected="selected" <?php }?>><?= $list['name']?></option>
            <?php }?>
            </select>
           </td>
        </tr>
        <tr>
            <td class="field">Product:</td>
            <td><input type="text" name="product" value="<?= $client['product']?>"/></td>
        </tr>
       	<tr>
            <td class="field">Employee:</td>
            <td><?php if($client['employee_id']!=0){
					echo find('firstname', $client['employee_id'],'employee_tb')." ".find('lastname', $client['employee_id'],'employee_tb');
			}else{
				echo "admin";		
			}?><input type="hidden" name="employee_id" value="<?php  echo $client['employee_id']?>" /></td>
        </tr>
        <tr>
            <td class="field">Location:</td>
            <td><input type="text" name="location" value="<?= $client['location']?>" /></td>
        </tr>
        <tr>
            <td class="field">CP 1:</td>
            <td><input type="text" name="cp_1" value="<?= $client['cp_1']?>"/></td>
        </tr>
        <tr>
            <td class="field">CP 2:</td>
            <td><input type="text" name="cp_2" value="<?= $client['cp_2']?>"/></td>
        </tr>
        <tr>
            <td class="field">Phone:</td>
            <td><input type="text" name="phone" value="<?= $client['phone']?>" /></td>
        </tr>
        <tr>
            <td class="field">Handphone:</td>
            <td><input type="text" name="handphone" value="<?= $client['handphone']?>"/></td>
        </tr>
        <tr>
            <td class="field">Fax:</td>
            <td><input type="text" name="fax" value="<?= $client['fax']?>"/></td>
        </tr>
        <tr>
            <td class="field">Email:</td>
            <td><input type="text" name="email" value="<?= $client['email']?>"/></td>
        </tr>
        <tr>
            <td class="field">Attachment:</td>
            <td>
            file : <?php echo $client['attachment']?><br />
            <input type="file" name="attachment" /></td>
        </tr>
        <tr>
            <td class="field">Status:</td>
            <td>
            	<select name="active">
                	<option value="0">non-active</option>
                    <option value="1" selected="selected">active</option>
            	</select>
            </td>
        </tr>
        <tr>
            <td class="field">&nbsp;</td>
            <td class="submit">
            <input type="submit" name="submit" id="submit" value="Submit" onClick="enterform()" style="width:60px;">
            <input type="reset" name="reset" id="reset" value="Reset" style="width:60px;">
            </td>
        </tr>
    </table>
</form>
<a href="<?php echo site_url('client/list_client');?>">Back</a>