<script type="text/javascript">
function enterform(){
		$("#myform").validate({
			rules : {
				name : {
					required : true
				},
				username : {
					required : true	
				}
			},
			messages: {
				name : "*",
				username : "*"
		   }
		});
		
		if($("#myform").validate().form() == true){
			$("#myform").submit();
			return true;	
		}
		else{
			return false;
		}
	}
</script>
<h2>Profil &raquo; Edit</h2>
<div id="submenu">
    <ul>
        <li><a href="<?= site_url("admin/list_admin")?>">Back</a></li>
    </ul>
</div>
<form id="myform" name="myform" action="<?php echo site_url('admin/do_edit_admin/'.$list_admin['id']);?>" method="post">
    <table class="form">
        <tr>
            <td>Name:</td>
            <td><input type="text" name="name" value="<?= $list_admin['name']?>"></td>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type="text" name="username" value="<?= $list_admin['username']?>"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="text" name="password"> * leave it empty if you don't want change it</td>
        </tr>
        <tr>
            	<td>Employee</td>
                <td><select name="employee_id">
                		<option value="0">--Not An Employee--</option>
                	<?php if($list_employee)foreach($list_employee as $list){?>
                    	<option value="<?= $list['id'];?>" <?php if($list_admin['employee_id']==$list['id']){?> selected="selected"<?php }?>><?= $list['firstname']." ".$list['lastname'];?></option>
                    <?php }?>
                </select></td>
            </tr>
        <tr>
            <td>Privilege</td>
            <td>
            <?php if($list_admin['privilege_id']==1){?>
				SUPER ADMINISTRATOR
                <input type="hidden" name="privilege_id" value="1" />
			<?php }else{?>
            <select name="privilege_id">
				<?php if($list_privilege)foreach($list_privilege as $list){?>
                    <?php if($list['id'] != 1){?>
                        <option value="<?= $list['id']?>" <?php if($list_admin['privilege_id']==$list['id']){?> selected <?php }?>><?= $list['name']?></option>
                    <?php }?>
                <?php }?>
            </select>
            <?php }?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" id="submit" value="edit" onclick="enterform();"></td>
        </tr>
    </table>
</form>