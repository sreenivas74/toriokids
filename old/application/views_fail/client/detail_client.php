<script type="text/javascript">
	function get_client_information(id){
		$('#get_client_information_'+id).html('').load('<?php echo site_url('client/get_client_information');?>/'+id);
		$('#get_client_information_'+id).show();
	}
	
	function close_client_information(id){
		$('#get_client_information_'+id).hide();	
	}
</script>
<h2>Client &raquo; Detail</h2>
<table>
	<tr>
    	<td valign="top">
            <table class="form">
                <thead>
                    <th colspan="2">Client Detail</th>
                </thead>
                <tr>
                    <td>Employee</td>
                    <td>
					<?php 
					if($client['employee_id']!=0){
						echo find('firstname',$client['employee_id'],'employee_tb')." ".find('lastname',$client['employee_id'],'employee_tb');
					}else{
						echo "admin";	
					}?></td>
                </tr>
                <tr>
                    <td width="50%">Client Name</td>
                    <td><?php  echo $client['name']?></td>
                </tr>
                <tr>
                    <td>Location</td>
                    <td><?= $client['location'];?></td>
                </tr>
                <tr>
                    <td>Product</td>
                    <td><?= $client['product'];?></td>
                </tr>
                <tr>
                    <td>Industry</td>
                    <td><?php echo find('name',$client['industry'],'industry_tb');?></td>
                </tr>
                <tr>
                    <td>CP 1</td>
                    <td><?= $client['cp_1'];?></td>
                </tr>
                <tr>
                    <td>CP 2</td>
                    <td><?= $client['cp_2'];?></td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td><?= $client['phone'];?></td>
                </tr>
                <tr>
                    <td>Handphone</td>
                    <td><?= $client['handphone'];?></td>
                </tr>
                <tr>
                    <td>Fax</td>
                    <td><?= $client['fax'];?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?= $client['email'];?></td>
                </tr>
                <tr>
                    <td>Attachment</td>
                    <td>
                    	<?php if($client['attachment']!=""){?>
                    		<a href="<?php echo base_url();?>userdata/attachment/<?php echo $client['attachment']?>" target="_blank">Open Attachment</a>
                            <img src="<?php echo base_url();?>userdata/attacment/<?php echo $client['attachment']?>" />
                        <?php }?>
                    </td>
                </tr>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/edit_client","privilege_tb")){?>
                <tr>
                	<td></td>
                	<td><a href="<?php echo site_url('client/edit_client/'.$client['id']);?>">[Edit]</a></td>
                </tr>
                <?php }?>
            </table>
		</td>
        <td>&nbsp;</td>
        <td valign="top">
        	
        </td>
	</tr>
</table>
<hr size="1"/>
<h2>Information</h2>
<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/edit_client","privilege_tb")){?>
	<a href="#" class="add_info_client">+ Add</a><br><br>
<?php }?>
<div id="add_info_client" style="display:none;">
    <form id="myform" name="myform" action="<?php echo site_url('client/do_add_client_information/'.$client['id']);?>" method="post">
        <table class="form">
            <tr>
                <td>Description</td>
                <td><textarea name="description"></textarea></td>
            </tr>
            <tr>
            	<td></td>
                <td><input type="submit" name="submit" id="submit" value="add"></td>
            </tr>
        </table>
    </form>
</div>
<table class="form"  style="width:100%;">
	<thead>
    	<th width="4%">&raquo;</th>
    	<th width="80%">Description</th>
        <th width="20">Input by</th>
    </thead>
    <?php if($client_information)foreach($client_information as $list){?>
    	<tr>
        	<td valign="top">
            <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/edit_client","privilege_tb")){?>
            <a href="#" onclick="get_client_information(<?php echo $list['id'];?>);return false;">O</a> | 
            <a href="<?php echo site_url('client/delete_client_information/'.$list['id']);?>" onclick="return confirm('Are you sure?');">X</a>
            <?php }else{?> &bull; <?php }?>
            </td>
        	<td valign="top"><?php echo nl2br($list['description']);?></td>
            <td valign="top"><?php if($list['input_by']!=0)
							echo find('firstname',$list['input_by'],'employee_tb')." ".find('lastname',$list['input_by'],'employee_tb');
							else echo "admin";?>
            				<br /><?php echo date('d/m/Y',strtotime($list['input_date']))?></td>
        </tr>
        <tr id="get_client_information_<?php echo $list['id']?>"></tr>
    <?php }?>
</table>
<script>
    $(document).ready(function(){
        $('.add_info_client').click(function(){
            $('#add_info_client').toggle("fast");
            return false;
        });
    });
</script>
<a href="<?php echo site_url('client/list_client');?>">Back</a>