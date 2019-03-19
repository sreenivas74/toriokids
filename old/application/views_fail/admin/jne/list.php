<script type="text/javascript">
	function show(){
		$("#show").show();
	}
</script>
<div id="content">
    <h2>JNE &raquo; List</h2>
    <div id="submenu">
        <ul>
        	<li><?php /*?><a class="defBtn" href="<?php echo site_url('torioadmin/jne/view_province');?>"><span>Province List</span></a><?php */?> <a class="defBtn" href="<?php echo site_url('torioadmin/jne/add_city');?>"><span>Add City</span></a> 
            <a class="defBtn" href="<?php echo site_url('torioadmin/jne/mass_edit');?>"><span>Mass Edit</span></a>
      <?php /*?> <a class="defBtn" href="<?php echo site_url('torioadmin/jne/download_csv_form').'/'.$this->uri->segment(4);?>"><span>Download CSV Template</span></a> <?php */?>
            <a class="defBtn" href="#" onclick="show(); return false;"><span>Upload CSV Template</span></a></li>
        </ul>
    </div>
    <span id="show" style="display:none;">
	<h3>Upload Excel File</h3>
	<form method="post" name="myform" id="myform" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/jne/upload_csv_form')?>">
    <dl>
        <dd>Excel File</dd>
        <dt><input type="file" class="txtField" name="attachment" /></dt>
    </dl>
    <dl>
        <dd></dd>
        <dt><input type="submit" class="defBtn" value="Submit" onclick="enterform();"/></dt>
    </dl>
    </form>
</span>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="10%">Action</th>
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
                <td valign="top"><?php echo $no;?>
                <input type="hidden" name="jne_id" value="<?php echo $list['id'];?>" id="jne_id<?php echo $list['id'];?>" />
                <input type="hidden" name="jne_precedence" value="<?php echo $list['precedence'];?>" id="jne_precedence<?php echo $list['id'];?>" />
                </td>
                <td valign="top"><a href="<?php echo site_url('torioadmin/jne/edit_city').'/'.$list['id'];?>">Edit</a></td>
                <td valign="top"><?php echo $list['province_name'];?></td>
                <td valign="top"><?php echo $list['name']?></td>
                <td valign="top"><?php echo money($list['regular_fee']);?></td>
                <td valign="top"><?php echo $list['regular_etd'];?></td>
    			<td valign="top"><?php echo money($list['express_fee']);?></td>
                <td valign="top"><?php echo $list['express_etd'];?></td>
                <td valign="top"><?php echo money($list['min_purchase']);?></td>
               
    		</tr>
    		<?php $no++; } else if(!$jne){ ?> 
            <tr>
                <td colspan="9"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<span id="show" style="display:none;">
	<h3>Upload CSV</h3>
	<form method="post" name="myform" id="myform" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product_item/upload_csv_form')?>">
    <dl>
        <dd>CSV</dd>
        <dt><input type="file" class="txtField" name="attachment" /></dt>
    </dl>
    <dl>
        <dd></dd>
        <dt><input type="submit" class="defBtn" value="Submit" onclick="enterform();"/></dt>
    </dl>
    </form>
</span>


<script type="text/javascript">

$(document).ready(function() {
	
	// Initialise the table
	$("#table-1").tableDnD({
		onDragClass: 'tableCellOnDrag',
		onDrop: function(table, row){
			var rows = table.tBodies[0].rows;
			var prev_id=parseFloat($('tr#'+row.id).prev().attr('id'));
			var next_id=parseFloat($('tr#'+row.id).next().attr('id'));
			var curr_id=parseFloat($('#jne_id'+row.id).val());
			
			if(isNaN(prev_id)){
				//alert('most top');
				prev_id='t';
			}
			if(isNaN(next_id)){
				//alert('most bottom');
				next_id='b';
			}
			
			$.ajax({
				type: "POST",
				url: '<?php echo site_url('torioadmin/jne/reposition_precedence');?>',
				data: 'curr_id='+curr_id+'&prev_id='+prev_id+'&next_id='+next_id,	
				success: function(){
					
				}
			});
		}
	});
});
</script>