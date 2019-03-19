<div id="content">
    <h2>Small Footer Banner &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/small_footer_banner/add');?>"><span>Add</span></a></li>
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
                                <a href="<?php echo site_url('torioadmin/small_footer_banner/change_active_small_footer_banner').'/'.$list['id'].'/'.$list['active']; ?>"><?php if($list['active']==0){?>
Inactive<?php }else echo "Active";?></a>
   
                 | 
                <a href="<?php echo site_url('torioadmin/small_footer_banner/edit').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo $list['name'];?></td>
                <td valign="top"><?php echo $list['link'];?></td>
                <td><?php if($list['image']!=""){ ?>
                    <img width="200" src="<?php echo base_url();?>userdata/small_footer_banner/<?php echo $list['image'];?>" /><?php }?>
            	</td>
    		</tr>
            <?php $no++;} ?>
        </tbody>
    </table>
</div>