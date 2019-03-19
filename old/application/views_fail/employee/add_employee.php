<script category="text/javascript">
function enterform() {
	$(document).ready(function() {
		$("#myform").validate({
			rules : {
				firstname : {
					required : true
				},
				lastname : {
					required : true	
				},
				wife : {
					number : true	
				},
				child : {
					number : true	
				},
				email : {
					email : true,
					required : true	
				}
			},
			messages : {
				firstname : " *",
				lastname : " *",
				wife : " *number",
				child : " *number",
				email : " *"
			}
		});
		
		if($("#myform").validate().form() == true){
			$("#myform").submit();
			$("a#btnGo").css("display","none");
			alert("Your Employee's Data has been added");
			return true;
		}
		else{
			return false;
		}
	})
}

$(document).ready(function(){
	$('#join_date').datepicker({
		numberOfMonths: 1,
		showButtonPanel: true,
		yearRange: "-80:+80",
		changeYear: true,
		dateFormat: "yy-mm-dd",
		minDate: "-80y"
	});
});
$(document).ready(function(){
	$('#birth_date').datepicker({
		numberOfMonths: 1,
		showButtonPanel: true,
		yearRange: "-80:+80",
		changeYear: true,
		dateFormat: "yy-mm-dd",
		minDate: "-80y"
	});
});
</script>
<h2>Employee &raquo; + Add Employee</h2>
<form action="<?php echo site_url('employee/do_add_employee');?>" name="myform" id="myform" method="post">
<table>
	<tr>
    	<td>
            <table class="form">
                <thead>
                    <th colspan="2">Add Employee</th>
                </thead>
                <tr>
                    <td class="field">Privilege:</td>
                    <td>
                        <select name="privilege_id">
                        		<option value="0">--No Privilige--</option>
                            <?php if($privilege)foreach($privilege as $list){?>
                                <option value="<?= $list['id'];?>"><?= $list['name'];?></option>
                            <?php }?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="field">Category:</td>
                    <td><select name="category">
                            <option value="0">--No Category--</option>
                            <option value="1">Technician</option>
                            <option value="2">Web</option>
                            <option value="3">Marketing</option>
                        </select></td>
                </tr>
                <tr>
                    <td class="field">Firstname:</td>
                    <td><input type="text" name="firstname" /> *</td>
                </tr>
                <tr>
                    <td class="field">Lastname:</td>
                    <td><input type="text" name="lastname" />  *</td>
                </tr>
                <tr>
                    <td class="field">Company:</td>
                    <td><select name="company_id">
                    		<option value="-1">--Select Company--</option>
                    	<?php if($company)foreach($company as $list){?>
                        	<option value="<?= $list['id'];?>"><?= $list['name'];?></option>
                        <?php }?>
                    </select></td>
                </tr>
                <tr>
                    <td class="field">NIK:</td>
                    <td><input type="text" name="nik" /></td>
                </tr>
                <tr>
                    <td class="field">Join Date:</td>
                    <td><input type="text" name="join_date" id="join_date" /></td>
                </tr>
                <tr>
                    <td class="field">Birth Date:</td>
                    <td><input type="text" name="birth_date" id="birth_date" /></td>
                </tr>
                <tr>
                    <td class="field">Birth Place:</td>
                    <td><input type="text" name="birth_place" /></td>
                </tr>
                <tr>
                    <td class="field">Education:</td>
                    <td><input type="text" name="education" /></td>
                </tr>
                <tr>
                    <td class="field">School:</td>
                    <td><input type="text" name="school" /></td>
                </tr>
                <tr>
                    <td class="field">Certificate:</td>
                    <td><input type="text" name="certificate" /></td>
                </tr>
                <tr>
                    <td class="field">Grade:</td>
                    <td><input type="text" name="grade" /></td>
                </tr>
                <tr>
                    <td class="field">Department:</td>
                    <td><select name="department_id">
                    		<option value="-1">--Select Department--</option>
                    	<?php if($department)foreach($department as $list){?>
                        	<option value="<?= $list['id'];?>"><?= $list['name'];?></option>
                        <?php }?>
                    </select></td>
                </tr>
                <tr>
                    <td class="field">Job Title:</td>
                    <td><input type="text" name="job_title" /></td>
                </tr>
                <tr>
                    <td class="field">No KTP:</td>
                    <td><input type="text" name="no_ktp" /></td>
                </tr>
                <tr>
                    <td class="field">Address KTP:</td>
                    <td><textarea name="address_ktp" ></textarea></td>
                </tr>
                <tr>
                    <td class="field">Address Now:</td>
                    <td><textarea name="address_now" ></textarea></td>
                </tr>
                <tr>
                    <td class="field">GSM 1:</td>
                    <td><input type="text" name="gsm_1" /></td>
                </tr>
                <tr>
                    <td class="field">GSM 2:</td>
                    <td><input type="text" name="gsm_2" /></td>
                </tr>
                <tr>
                    <td class="field">Phone:</td>
                    <td><input type="text" name="phone" /></td>
                </tr>
                <tr>
                    <td class="field">Pin BB:</td>
                    <td><input type="text" name="pin_bb" /></td>
                </tr>
                <tr>
                    <td class="field">Email:</td>
                    <td><input type="text" name="email" /> *</td>
                </tr>
                <tr>
                    <td class="field">Name Reference:</td>
                    <td><input type="text" name="name_reference" /></td>
                </tr>
                <tr>
                    <td class="field">Phone Reference:</td>
                    <td><input type="text" name="phone_reference" /></td>
                </tr>
                <tr>
                    <td class="field">Relation Reference:</td>
                    <td><input type="text" name="relation_reference" /></td>
                </tr>
                <tr>
                    <td class="field">Marriage Status:</td>
                    <td><input type="text" name="marriage_status" /></td>
                </tr>
                <tr>
                    <td class="field">Wife:</td>
                    <td><input type="text" name="wife" /></td>
                </tr>
                <tr>
                    <td class="field">Child:</td>
                    <td><input type="text" name="child" /></td>
                </tr>
                <tr>
                    <td class="field">Religion:</td>
                    <td><input type="text" name="religion" /></td>
                </tr>
                <tr>
                    <td class="field">Account Number:</td>
                    <td><input type="text" name="account_number" /> * exp : (BCA)123 4567 890</td>
                </tr>
                <tr>
                    <td class="field">SIM A:</td>
                    <td>
                        <input style="width:10px;" checked="checked" type="radio" name="sim_a" value="0" id="sim_a_0" />
                        no
                        <input style="width:10px;" type="radio" name="sim_a" value="1" id="sim_a_1" />
                        yes
                    </td>
                </tr>
                <tr>
                    <td class="field">SIM C:</td>
                    <td><input style="width:10px;" checked="checked" type="radio" name="sim_c" value="0" id="sim_c_0" />
                        no
                        <input style="width:10px;" type="radio" name="sim_c" value="1" id="sim_c_1" />
                        yes</td>
                </tr>
                <tr>
                    <td class="field">Motor:</td>
                    <td><input style="width:10px;" checked="checked" type="radio" name="motor" value="0" id="motor_0" />
                        no
                        <input style="width:10px;" type="radio" name="motor" value="1" id="motor_1" />
                        yes</td>
                </tr>
                <tr>
                    <td class="field">Type:</td>
                    <td>
                        <input style="width:10px;" type="radio" name="type" value="0" id="type_0"  checked="checked"  />
                        	Information
                        <input style="width:10px;" type="radio" name="type" value="1" id="type_1" />
                        	Goal
                    </td>
                </tr>
                <tr>
                    <td class="field">Status:</td>
                    <td>
                        <input style="width:10px;" type="radio" name="status" value="0" id="status_0" />
                        no
                        <input style="width:10px;"  checked="checked" type="radio" name="status" value="1" id="status_1" />
                        yes
                    </td>
                </tr>
                <tr>
                    <td class="field">&nbsp;</td>
                    <td class="submit">
                    <input type="submit" name="submit" id="submit" value="Submit" onClick="enterform()" style="width:60px;">
                    <input type="reset" name="reset" id="reset" value="Reset" style="width:60px;"></td>
                </tr>
            </table>
		</td>
        <td valign="top">
        	<table class="form">
            	<thead>
                	<th>&raquo; User Login</th>
                </thead>
            	<tr>
                	<td>
        				&raquo; &raquo; Username = <b>[email]</b><br />
						&raquo; &raquo; Password Default = <b>[Sent By Email]</b>
                	</td>
               	</tr>
                <tr>
                	<td>
               	    &bull; Example : email = <b>a@b.com</b><br />
                        &bull; Username : <b>a@b.com</b><br />
                        &bull; Password : <b>gsi</b>
                    </td>
                </tr>
        	</table>
        </td>
	</tr>
</table>
</form>  	