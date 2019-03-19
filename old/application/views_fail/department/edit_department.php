<script type="text/javascript">
function enterform(){
		$("#myform").validate({
			rules : {
				name : {
					required : true
				}
			},
			messages: {
				name : "*"
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
<h2>- Edit Department</h2>

    <form id="myform" name="myform" action="<?php echo site_url('department/do_edit_department/'.$department['id']);?>" method="post">
        <table class="form">
            <tr>
                <td>Name:</td>
                <td><input type="text" name="name" value="<?= $department['name'];?>" ></td>
            </tr>
             <tr>
            	<td>Active</td>
                <td>
                <select name="active">
                	<option value="0" <?php if($department['active']==0){?> selected <?php }?>>no</option>
                    <option value="1" <?php if($department['active']==1){?> selected <?php }?>>yes</option>
                </select></td>
            </tr>
            <tr>
            	<td></td>
                <td><input type="submit" name="submit" id="submit" value="edit" onclick="enterform();"></td>
            </tr>
        </table>
    </form>