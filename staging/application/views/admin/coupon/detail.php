<div id="content">
    <h2>Coupons &raquo; Detail &raquo; History</h2>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th >No</th>
                <th>Action </th>
                <th>Name</th>
                <th>Email</th>
                <th>Date Transaction</th>
                <th>Sub Total</th>
                <th>Discount</th>
  				<th>Grand Total</th>
           </tr>
        </thead>
        <tbody>
        <?php $no=1 ?>
    	     <?php foreach($history_list as $list){?>
           <tr>
                <td valign="top"><?php echo $no++?></td>
                 <td valign="top"><a href="<?php echo site_url('torioadmin/order/detail').'/'.$list['order_id'];?>">Detail</a> </td>
                <td valign="top"><?php echo $list['full_name']?></td>
 				<td valign="top"><?php echo $list['email']?></td>
                <td valign="top"><?php echo $list['date_transaction']?></td>  
                 <td valign="top"><?php echo money($list['sub_total'])?></td>  
                <td valign="top"><?php echo money($list['discount'])?> </td>  
                <td valign="top"><?php echo money($list['grand_total'])?> </td> 
    		</tr>
              <?php }?>
        </tbody>
    </table>
</div>