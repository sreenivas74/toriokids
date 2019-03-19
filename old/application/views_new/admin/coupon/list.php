<div id="content">
    <h2>Coupons &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/coupon/individual').'/';?>"><span>Add</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th >No</th>
                <th>Action</th>
                <th>Name</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Quantity Used</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Type</th>
                <th>Value</th>
                <th>Min</th>
                <th>Max</th>
           </tr>
        </thead>
        <tbody>
        <?php $no=1 ?>
    	     <?php foreach($coupoun_list as $list){?>
           <tr>
                <td valign="top"><?php echo $no++?></td>
                <td valign="top"><a href="<?php echo site_url('torioadmin/coupon/edit/'.$list['id'].'/')?>" >Edit</a> |  <a href="<?php echo site_url('torioadmin/coupon/dodelete/'.$list['id'].'/')?>" onclick="return confirm('Confirm Delete?');" >Delete</a> |  <a href="<?php echo site_url('torioadmin/coupon/detailhistory/'.$list['id'].'/')?>" >Detail</a>|<br />

<a href="<?php echo site_url('torioadmin/coupon/adduser/'.$list['id'].'/')?>" >Add User</a></td>
                <td valign="top"><?php echo $list['name']?></td>
				 <td valign="top">	<?php if ($list['image']!=""){?>
                     <img src="<?php echo base_url()?>userdata/voucher/<?php echo $list['image']?>" width="100">
                    <?php }else {?>
                    <img src="<?php echo base_url()?>userdata/voucher/voucher.jpg" width="100">
                    <?php } ?></td>
            
                <td valign="top"><?php echo $list['quantity']?></td>
                <td valign="top"><?php echo $list['quantity_used']?></td>  
                <td valign="top"><?php echo $list['start_date']?></td>  
                <td valign="top"><?php echo $list['end_date']?></td>  
                <td valign="top"><?php if ($list['type']==1)echo 'Percentage';  else echo'Value';?> </td>  
                <td valign="top"><?php if ($list['type']==1)echo discount($list['value']); else echo money($list['value'])?> </td> 
                <td valign="top"><?php echo money($list['minimum_sub'])?> </td>  
                <td valign="top"><?php echo money($list['maximum_sub'])?> </td> 
    		</tr>
              <?php }?>
        </tbody>
    </table>
</div>