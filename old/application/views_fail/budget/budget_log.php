<style>
	table.logging tr td{
		border:none;
		border-bottom:solid #000 2px;
		padding:2px;	
	}
	table.logging tr.list td{
		border:none;
		border-bottom:solid #999 1px;
		padding:2px;
	}
	table.logging tr.list:nth-child(odd) td{
		background:#F2F2F2;	
	}
	table.logging tr.list:nth-child(even) td{
		background:#FFF;
	}
</style>
<b><a href="<?php echo site_url('budget/all_list')?>">Budget List</a> &raquo; <?php echo $budget_name?></b><br><br>
<table class="logging" style="width:1080px">
    <tr>
        <td style="width:10px">No</td>
        <td style="width:100px; text-align:center">Amount</td>
        <td style="width:150px; text-align:center">Request Number</td>
        <td style="width:150px; text-align:center">Request Date</td>
        <td style="width:100px; text-align:center">Bank Name</td>
        <td style="width:200px; text-align:center">Acc Name</td>
        <td style="width:150px; text-align:center">Acc Number</td>
        <td style="width:220px; text-align:center">Created</td>
    </tr>
    <?php 
    $no = 1;
    if($budget_log_list)foreach($budget_log_list as $listitem){?>
        <tr class="list">
            <td style="text-align:right"><?php echo $no;?></td>
            <td style="text-align:center"><?php echo number_format($listitem['amount'])?></td>
            <td style="text-align:center"><a style="text-decoration:none" href="<?php echo site_url('budget/detail/'.$listitem['rbid'])?>"><?php echo $listitem['request_number']?></a></td>
            <td style="text-align:center"><?php echo date("d F Y",strtotime($listitem['request_date']))?></td>
            <td style="text-align:center"><?php echo $listitem['bank_name']?></td>
            <td style="text-align:center"><?php echo $listitem['acc_name']?></td>
            <td style="text-align:center"><?php echo $listitem['acc_number']?></td>
            <td style="text-align:center;">
                <?php echo date('d F Y',strtotime($listitem['created_date']));
                if($listitem['created_by']==0)echo " - admin";
                else echo " - ".find('firstname',$listitem['created_by'],'employee_tb')." ".find('lastname',$listitem['created_by'],'employee_tb');
                ?>
            </td>
        </tr>
    <?php $no++;
    }?>
</table>