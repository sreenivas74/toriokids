<script type="text/javascript">
	function show(){
		$("#show").show();
	}
	
function update_jne(){
	 if(confirm('Confirm?')){
		$('#jne_form').submit();
	 }
}
</script>
<div id="content">
    <h2>JNE &raquo; Edit List</h2>
    
        <form method="post" id="jne_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/jne/do_mass_edit');?>">
    <table class="defAdminTable" width="100%" id="table-1">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                 <th width="24%">Province</th>
                <th width="24%">City</th>
                <th width="10%">Regular Fee</th>
                <th width="10%">Regular ETD</th>
                <th width="10%">Express Fee</th>
                <th width="10%">Express ETD</th>
                <th width="10%">Min Purchase</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($jne)foreach($jne as $list){?>
            <tr id="<?php echo $list['id'];?>">
                <td valign="top"><?php echo $no;?><input type="hidden" name="jne_id[]" value="<?php echo $list['id'];?>" id="jne_id<?php echo $list['id'];?>" /></td>
                  <td valign="top"><?php echo $list['province_name'];?></td>
                <td valign="top"><?php echo $list['name']?></td>
                <td valign="top"><input type="text" name="regular_fee<?php echo $list['id']?>" value="<?php echo $list['regular_fee']?>"></td>
                <td valign="top"><input type="text" name="regular_etd<?php echo $list['id']?>" value="<?php echo $list['regular_etd']?>"></td>
    			<td valign="top"><input type="text" name="express_fee<?php echo $list['id']?>" value="<?php echo $list['express_fee']?>"></td>
                <td valign="top"><input type="text" name="express_etd<?php echo $list['id']?>" value="<?php echo $list['express_etd']?>"></td>
                 <td valign="top"><input type="text" name="min_purchase<?php echo $list['id']?>" value="<?php echo $list['min_purchase']?>"></td>
            </tr>
    		<?php $no++; } else if(!$jne){ ?> 
            <tr>
                <td colspan="6"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
    
           </form>
     <div id="submenu">
        <ul>
            <li><a class="defBtn" href="#" onClick="update_jne();return false;"><span>Update</span></a></li>
        </ul>
    </div>
</div>