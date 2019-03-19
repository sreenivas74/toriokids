<script type="text/javascript" src="<?php echo base_url();?>templates/js/jquery.tablednd.0.7.min.js"></script>
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
<h2>Privilege User</h2>
<div id="submenu">
    <ul>
        <li><a href="#" class="add_user">+ Add</a></li>
    </ul>
</div>
<div id="add_user" style="display:none;">
<hr>
    <form id="myform" name="myform" action="<?php echo site_url('admin/privilege_user_do_add');?>" method="post">
        <table class="form">
            <tr>
                <td>Name:</td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
            	<td></td>
                <td><input type="submit" name="submit" id="submit" value="add" onclick="enterform();"></td>
            </tr>
        </table>
    </form>
</div>
<table class="form" width="50%" id="table-1">
	<thead>
    	<th>Action</th>
        <th>Name</th>
    </thead>
    <?php if($privilege_user)foreach($privilege_user as $list){?>
    <tr id="<?php echo $list['id']?>">
    	<td><a href="<?= site_url("admin/privilege_user_setting/".$list['id'])?>">Setting</a></td>
        <td><?= $list['name'];?></td>
    </tr>
    <?php }?>
</table>
<script>
    $(document).ready(function(){
        $('.add_user').click(function(){
            $('#add_user').toggle("fast");
            return false;
        });
		
		$("#table-1").tableDnD({
			onDragClass: 'tableCellOnDrag',
			onDrop: function(table, row){
				
				$.ajax({
					type: "POST",
					url: '<?php echo site_url('admin/update_precedence')?>',
					data: $.tableDnD.serialize(),
					success: function(){
						
					}
				});
			}
		});
		
    });
</script>