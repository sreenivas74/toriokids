<style>	
	body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td{margin:0;padding:0;}table{border-collapse:collapse;border-spacing:0;margin:0;padding:0;}fieldset,img{border:0;}address,caption,cite,code,dfn,em,strong,th,var{font-style:normal;font-weight:normal;}ol,ul {margin:0; padding:0;quotation_detail-style:none;}caption,th {text-align:left;}h1,h2,h3,h4,h5,h6,p{font-size:100%;font-weight:normal;margin:0;}q:before,q:after{content:'';}abbr,acronym {border:0;}
	#container{
		font-size:11px;
	}
	table{
		border:solid 1px;
		font-size:11px;
	}
	table tr td{
		border:solid 1px;
		padding:2px;
	}
	table tr th{
		background-color:#CCC;
		border:solid 1px;
		padding:2px;
	}
	.clearBorder{
		border:0;	
	}
</style>
<page backtop="31mm" backbottom="12mm" backleft="0mm" backright="8mm" footer="page" style="font-size: 10pt;">
	
<page_header>
<table style="border:none; width:750px">
    <tr>
        <td style="width:100px; border:none;"><img src="<?php echo base_url()?>images/<?php echo LOGO?>" width="130" height="80" /></td>
        <td style="width:350px; border:none; text-align:left; vertical-align:top; border-right:solid 1px;">
        <b><?php echo PRINT_PT_TITLE;?></b><br />
     	Fungsi Form No.02/Fin/Rev.0/2013<br>
        Untuk transaksi permohonan dana  pembayaran tagihan bulanan,<br>
		VENDOR, ATK & RT<br>
        No. Dokumen: <?php echo $request_detail['request_number']?>
       	</td>
        <td style="width:250px; border:none; text-align:left; vertical-align:top; border:solid 1px;">
        <div style="font-size:9px"><i>Diisi oleh accounting.</i></div>
        Sumber Dana : <br>
        No. Akun : <br>
        Received Date : <br>
        Transfered Date : 
        </td>
    </tr>
</table>
<div id="container">
Warna form putih<br>
<?php if($request_detail['pname']){?>
Project : <b><?php echo $request_detail['pname']?></b><br>
<?php }?>
Tanggal Permohonan : <?php echo date("d F Y",strtotime($request_detail['request_date']))?><br>
Reimburse : <?php if($request_detail['reimburse']==1)echo "yes"; else echo "no"?><br>
Divisi User : <?php echo find('name',find('department_id',$request_detail['created_by'],'employee_tb'),'department_tb')?><br>
Print By  : <?php echo $print_by['firstname'];?> <?php echo $print_by['lastname'];?> <br />
<br>
    <div id="itemList">
    	<table style="width:680px">
        	<tr>
            	<td style="width:10px">No</td>
                <td style="width:100px">Nama Barang</td>
                <td style="width:40px; text-align:center">Quantity</td>
                <td style="width:30px; text-align:center">Price</td>
                <td style="width:70px; text-align:center">Total</td>
                <td style="width:90px">Vendor</td>
                <td style="width:60px">No Acc</td>
                <td style="width:100px">Bagian Dari PO/Budget</td>
            </tr>
            <?php $no = 1; $total=0;
			if($request_item)foreach($request_item as $list){$total+=$list['total'];?>
            	<tr>
                	<td style="text-align:right"><?php echo $no?></td>
                    <td><?php echo $list['description']?></td>
                    <td style="text-align:right"><?php echo number_format($list['quantity'])?></td>
                    <td style="text-align:right"><?php echo number_format($list['price'])?></td>
                    <td style="text-align:right"><?php echo number_format($list['total'])?></td>
                            
                    <td><?php //echo (is_numeric($list['vendor_name']))? "number":"not";
                    if($list['vendor_name']!='' && $list['vendor_name']!='a' && is_numeric($list['vendor_name']))
                    echo find('name',$list['vendor_name'],'vendor_tb');
                    else echo $list['vendor_name']?></td>
                    <td><?php echo $list['bank_name']." - ".$list['acc_number']."<br>".$list['acc_name']?></td>
                    <td>
                    	<?php 
						if($request_detail['pid']!=0){
							echo find('item',$list['project_goal_po_client_item_id'],'project_goal_po_client_item_tb');
						}else{
							echo find('name',$list['budget_id'],'budget_tb');
						}?>
                    </td>
                </tr>
            <?php $no++;
			}?>
            <tr>
            	<td></td>
            	<td></td>
            	<td></td>
            	<td></td>
            	<td align="right"><?php echo number_format($total)?></td>
            	<td></td>
            	<td></td>
            	<td></td>
            </tr>
            
               <?php if($request_detail['is_ppn']==1){ ?>
			<tr>
			 <td colspan="4" align="right">PPN</td>
			 <td align="right"><?php echo number_format($total*0.1); ?></td>
			 <td colspan="3"></td>
		   </tr>
		   <tr>
			 <td colspan="4" align="right">Grand Total</td>
			 <td align="right"><?php echo number_format($total*1.1); ?></td>
			 <td colspan="3"></td>
		   </tr>
         <?php } ?>
        </table>
    </div>
    <div>
    <br><br>
    <table style="border:none; width:750px">
    	<tr>
        	<td style="width:150px; text-align:center; border:none">Dibuat oleh,<br><br><br><br><br><br>(....................)<br>HRD/Purchasing</td>
            <td style="width:150px; text-align:center; border:none">Diketahui oleh,<br><br><br><br><br><br>(....................)<br><?php if($request_detail['approval_2_date']!='0000-00-00 00:00:00'){
			$approval_date = date('d F Y',strtotime($request_detail['approval_2_date']));
			if($request_detail['approval_2_by']==0)$approval_by = 'admin';
			else $approval_by = find('firstname',$request_detail['approval_2_by'],'employee_tb')." ".find('lastname',$request_detail['approval_2_by'],'employee_tb');
			echo $approval_by;
			?>    
            
 <?php 		}else{
			echo "Leader Project";
		} ?></td>
            <td style="width:150px; text-align:center; border:none"><br><br><br><br><br><br>(....................)<br><?php if($request_detail['approval_3_date']!='0000-00-00 00:00:00'){
			$approval_date = date('d F Y',strtotime($request_detail['approval_3_date']));
			if($request_detail['approval_3_by']==0)$approval_by = 'admin';
			else $approval_by = find('firstname',$request_detail['approval_3_by'],'employee_tb')." ".find('lastname',$request_detail['approval_3_by'],'employee_tb');
			echo $approval_by;
			?>    
 <?php 		}else{
			echo "Marketing";
		} ?></td>
            <td style="width:200px; text-align:center; border:none">Disetujui oleh,<br><br><br><br><br><br>(....................)<br><?php if($request_detail['approval_4_date']!='0000-00-00 00:00:00'){
			$approval_date = date('d F Y',strtotime($request_detail['approval_4_date']));
			if($request_detail['approval_4_by']==0)$approval_by = 'admin';
			else $approval_by = find('firstname',$request_detail['approval_4_by'],'employee_tb')." ".find('lastname',$request_detail['approval_4_by'],'employee_tb');
			echo $approval_by;
			?>    
 <?php 		}else{
			echo "IW/RD/AA";
		} ?></td>
        </tr>
        <tr>
        
        </tr>
    </table>
    </div>
</div>


</page_header>

<page_footer>
    
</page_footer> 
</page>