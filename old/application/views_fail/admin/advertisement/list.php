<div id="content">
    <h2>Advertisement &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/advertisement/add');?>"><span>Add</span></a></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="10%">Action</th>
                <th width="20%">Name</th>
                <th width="20%">Link</th>
                <th width="20%">Image</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($detail)foreach($detail as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/advertisement/change_active_advertisement').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a>
                 | 
                <a href="<?php echo site_url('torioadmin/advertisement/edit').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><?php echo $list['link'];?></td>
                <td><?php if($list['image']!=""){ ?>
                    <img width="200" src="<?php echo base_url();?>userdata/advertisement/<?php echo $list['image'];?>" /><?php }?>
            	</td>
    		</tr>
            <?php $no++;} ?>
        </tbody>
    </table>
</div>