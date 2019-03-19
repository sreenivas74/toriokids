<script type="text/javascript">
function enterform(){
		$("#myform").validate({
			rules : {
				name : {
					required : true
				},
				username : {
					required : true	
				},
				password : {
					required : true	
				}
			},
			messages: {
				name : "*",
				username : "*",
				password : "*"
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
<h2>Profil</h2>
<div id="submenu">
    <ul>
        <li><a href="#" class="add">+ Add</a></li>
    </ul>
</div>
<div id="add" style="display:none;">
<hr>

    <form id="myform" name="myform" action="<?php echo site_url('admin/do_add_admin');?>" method="post">
        <table class="form">
            <tr>
                <td>Name:</td>
                <td><input type="text" name="name" ></td>
            </tr>
            <tr>
            	<td>Username</td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr>
            	<td>Password</td>
                <td><input type="text" name="password"></td>
            </tr>
            <tr>
            	<td>Employee</td>
                <td><select name="employee_id">
                		<option value="0">--Not An Employee--</option>
                	<?php if($list_employee)foreach($list_employee as $list){?>
                    	<option value="<?= $list['id'];?>"><?= $list['firstname']." ".$list['lastname'];?></option>
                    <?php }?>
                </select></td>
            </tr>
            <tr>
            	<td>Privilege</td>
                <td>
                <select name="privilege_id">
                <?php if($list_privilege)foreach($list_privilege as $list){?>
                	<?php if($list['id'] != 1){?>
                		<option value="<?= $list['id']?>"><?= $list['name']?></option>
                    <?php }?>
                <?php }?>
                </select>
                </td>
            </tr>
            <tr>
            	<td></td>
                <td><input type="submit" name="submit" id="submit" value="add" onclick="enterform();"></td>
            </tr>
        </table>
    </form>
</div>
<table class="form">
	<thead>
    	<th>Name</th>
        <th>Username</th>
        <th>Created Date</th>
        <th>Last Login</th>
        <th>Employee</th>
        <th>Privilege</th>
        <th>Action</th>
    </thead>
    <?php if($list_admin)foreach($list_admin as $list){?>
    <tr>
    	<td><?= $list['name'];?></td>
        <td><?= $list['username'];?></td>
        <td><?= $list['created_date'];?></td>
        <td><?= $list['last_login'];?></td>
        <td><?= find('firstname',$list['employee_id'],'employee_tb')." ".find('lastname',$list['employee_id'],'employee_tb');?></td>
        <td><?= find('name',$list['privilege_id'],"privilege_user_tb");?></td>
        <td><a href="<?= site_url("admin/edit_admin/".$list['id']);?>">Edit</a> / <a href="<?= site_url("admin/delete_admin/".$list['id']);?>" onClick="return confirm('Are you sure?');">Delete</a></td>
    </tr>
    <?php }?>
</table>
<script>
	$(document).ready(function(){
        $('.add').click(function(){
            $('#add').toggle("fast");
            return false;
        });
    });
</script>