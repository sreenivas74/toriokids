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
<h2>+ Add company</h2>
    <form id="myform" name="myform" action="<?php echo site_url('company/do_add_company');?>" method="post">
        <table class="form">
            <tr>
                <td>Name:</td>
                <td><input type="text" name="name" ></td>
            </tr>
            <tr>
                <td>Alias:</td>
                <td><input type="text" name="alias" ></td>
            </tr>
            <tr>
            	<td>Active</td>
                <td>
                <select name="active">
                	<option value="0">no</option>
                    <option value="1" selected >yes</option>
                </select></td>
            </tr>
            <tr>
            	<td></td>
                <td><input type="submit" name="submit" id="submit" value="add" onclick="enterform();"></td>
            </tr>
        </table>
    </form>
