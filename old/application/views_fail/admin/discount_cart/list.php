<div id="content">
    <h2>Discount Cart &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/discount_cart/add');?>"><span>Add</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="10%">Action</th>
                <th width="10%">Date Start</th>
                <th width="10%">Date End</th>
                <th width="15%">Name</th>
                <th width="10%">Minimum Purchase</th>
                <th width="10%">Discount Value</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($detail)foreach($detail as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/discount_cart/change_status_discount').'/'.$list['id'].'/'.$list['status']; ?>"> <?php if($list['status']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/discount_cart/edit').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo $list['date_start'];?></td>
                <td valign="top"><?php echo $list['date_end'];?></td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><?php echo money($list['minimum_purchase']);?></td>
                <td valign="top"><?php echo money($list['discount']);?></td>
    		</tr>
    		<?php $no++; } else if(!$detail){ ?> 
            <tr>
                <td colspan="7"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>