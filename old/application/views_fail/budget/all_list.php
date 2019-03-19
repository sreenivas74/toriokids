<h2>Budget List</h2>
<?php if(isset($_SESSION['notif'])){
		echo "<span style='color:#F00'>".$_SESSION['notif']."</span><br /><br />";
		unset($_SESSION['notif']);	
}?>
<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/add_budget","privilege_tb")){?>
	<input type="button" value="+ Add Budget" style="height:27px" onClick="$('.all_form').hide();$('#add_budget').show()">
<?php }?>
<div class="all_form" id="add_budget" style="display:none">
<hr />
<form name="add_budget_form" method="post" action="<?php echo site_url('budget/add_budget');?>">
	<table style="width:500px;">
    	<tr>
        	<td style="width:100px;padding:2px;">Name</td>
            <td style="padding:2px;"><input type="text" name="name"></td>
        </tr>
        <tr>
        	<td style="padding:2px;" valign="top">Periode Start</td>
            <td style="padding:2px;">
            	<select name="month_start">
                	<option value="">Month</option>
                    <?php for($i=1;$i<13;$i++){?>
                    	<option value="<?php echo $i?>"><?php echo date('F',strtotime(date('Y-'.$i.'-d')))?></option>
                    <?php }?>
                </select>
                <select name="year_start">
                	<option value="">Year</option>
                    <?php for($i=-2;$i<3;$i++){?>
                    	<option value="<?php echo date('Y')-$i?>" <?php if((date('Y')-$i)==date('Y'))echo "selected=selected"?>><?php echo date('Y')-$i?></option>
                    <?php }?>
                </select>
            </td>
        </tr>
        <tr>
        	<td style="padding:2px;" valign="top">Periode End</td>
            <td style="padding:2px;">
            	<select name="month_end">
                	<option value="">Month</option>
                    <?php for($i=1;$i<13;$i++){?>
                    	<option value="<?php echo $i?>"><?php echo date('F',strtotime(date('Y-'.$i.'-d')))?></option>
                    <?php }?>
                </select>
                <select name="year_end">
                	<option value="">Year</option>
                    <?php for($i=-2;$i<3;$i++){?>
                    	<option value="<?php echo date('Y')-$i?>" <?php if((date('Y')-$i)==date('Y'))echo "selected=selected"?>><?php echo date('Y')-$i?></option>
                    <?php }?>
                </select>
            </td>
        </tr>
        <tr>
        	<td style="padding:2px;">Amount</td>
            <td style="padding:2px;"><input type="text" id="amount" onkeyup="formatAmountWithoutPoint(this.value,0,'amount')" name="amount"></td>
        </tr>
        
        <tr>
        	<td></td>
            <td><input type="submit" value="submit" style="height:27px"></td>
        </tr>
    </table>
</form>
<hr />
</div>
<div class="all_form" id="edit_budget" style="display:none">
<hr />
<h2>Edit Form</h2>
<form name="edit_budget_form" method="post" action="<?php echo site_url('budget/edit_budget');?>">
	<input type="hidden" name="budget_id" id="budget_id">
	<table style="width:500px;">
    	<tr>
        	<td style="width:100px;padding:2px;">Name</td>
            <td style="padding:2px;"><input type="text" id="name" name="name"></td>
        </tr>
        <tr>
        	<td style="padding:2px;" valign="top">Periode Start</td>
            <td style="padding:2px;">
            	<select name="month_start" id="month_start">
                	<option value="">Month</option>
                    <?php for($i=1;$i<13;$i++){?>
                    	<option value="<?php echo $i?>"><?php echo date('F',strtotime(date('Y-'.$i.'-d')))?></option>
                    <?php }?>
                </select>
                <select name="year_start" id="year_start">
                	<option value="">Year</option>
                    <?php for($i=-2;$i<3;$i++){?>
                    	<option value="<?php echo date('Y')-$i?>"><?php echo date('Y')-$i?></option>
                    <?php }?>
                </select>
            </td>
        </tr>
        <tr>
        	<td style="padding:2px;" valign="top">Periode End</td>
            <td style="padding:2px;">
            	<select name="month_end" id="month_end">
                	<option value="">Month</option>
                    <?php for($i=1;$i<13;$i++){?>
                    	<option value="<?php echo $i?>"><?php echo date('F',strtotime(date('Y-'.$i.'-d')))?></option>
                    <?php }?>
                </select>
                <select name="year_end" id="year_end">
                	<option value="">Year</option>
                    <?php for($i=-2;$i<3;$i++){?>
                    	<option value="<?php echo date('Y')-$i?>"><?php echo date('Y')-$i?></option>
                    <?php }?>
                </select>
            </td>
        </tr>
        <tr>
        	<td style="padding:2px;">Amount</td>
            <td style="padding:2px;"><input type="text" id="amount_2" onkeyup="formatAmountWithoutPoint(this.value,0,'amount_2')"  name="amount"></td>
        </tr>
        <tr>
        	<td></td>
            <td><input type="submit" value="update" style="height:27px;"></td>
        </tr>
    </table>
</form>
<hr />
</div>

<br /><br />
<table id="flexi" style="display:none" class="content"></table>
<script type="text/javascript">
$("#flexi").flexigrid({
	url: '<?php echo site_url('budget/budget_flexi'); ?>',
	dataType: 'json',
	colModel : [
		{display: 'Action', name : 'action', width : 60, sortable : false, align: 'center'},
		{display: 'Name', name : 'item', width : 100, sortable : true, align: 'left'},
		{display: 'Used / Total Amount', name : 'amount', width : 200, sortable : true, align: 'center'},
		{display: 'Periode Start', name : 'periode_start', width : 60, sortable : true, align: 'center'},
		{display: 'Periode End', name : 'periode_end', width : 60, sortable : true, align: 'center'},
		{display: 'Active', name : 'active', width : 40, sortable : true, align: 'center'},
		{display: 'Created', name : 'updated', width : 200, sortable : false, align: 'center'},
		{display: 'Updated', name : 'updated', width : 200, sortable : false, align: 'center'}
	],
	
	searchitems : [
		{display: 'Name', name : 'name', isdefault: true}
	],
	sortname: "",
	sortorder: "",
	usepager: true,
	title: '',
	useRp: true,
	rp: 20,
	singleSelect: true,
	showTableToggleBtn: false,
	showToggleBtn: false, 
	height: 300,
	width:1011
});

function edit_budget(id){
	$.ajax({
		url:"<?php echo site_url('budget/get_detail_budget')?>/"+id,
		success: function(temp){
			var data = temp.split("|");
			$('#budget_id').val(id);
			$('#name').val(data[0]);
			$('#month_start').val(data[1]);
			$('#year_start').val(data[2]);
			$('#month_end').val(data[3]);
			$('#year_end').val(data[4]);
			$('#amount_2').val(data[5]);
			$('.all_form').hide();
			$('#edit_budget').show();
		}
	});
}

function active_budget(id,active){
	$.ajax({
		url:"<?php echo site_url('budget/active_budget')?>/"+id+'/'+active,
		success: function(temp){
			$(".pReload").trigger("click");	
		}
	});
}
</script>