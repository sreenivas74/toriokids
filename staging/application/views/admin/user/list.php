<div id="content">
    <h2>User &raquo; List</h2>
    <dl>
        <dt>
        <form name="select_user_form" method="post" action="<?php echo site_url('torioadmin/user/index')?>">
            <select class="txtField" style="width:200px" name="user" onChange="document.select_user_form.submit()">
                <option value="2" <?php if($us == 2){?> selected="selected"<?php } ?>>View All</option>
                <option value="1" <?php if($us == 1){?> selected="selected"<?php } ?>>Active List</option>
                <option value="0" <?php if($us == 0){?> selected="selected"<?php } ?>>Inactive List</option>
                <?php if($us == "search"){?><option value="search" <?php if($us == 0){?> selected="selected"<?php } ?>>Search Result</option><?php } ?>
            </select>
        </form>
        </dt>
    </dl>
    <div id="submenu">
        <form name="search_user" id="search_user" method="post" action="<?php echo site_url('torioadmin/user/search');?>">
            Search (name,email) : 
            <input type="text" name="keyword" id="keyword" class="txtField" value="<?php echo $keyword?>"/>
            <input type="submit" style="display:none;"/>
        </form>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="12%">Action</th>
                <th width="17%">Name</th>
                <th width="17%">Email</th>
                <th width="17%">Mobile Phone</th>
                <th width="15%">Registration Date</th>
                <th width="20%">Last Login</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($user)foreach($user as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/user/change_status_user').'/'.$list['id'].'/'.$list['status']; ?>"> <?php if($list['status']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/user/detail').'/'.$list['id'];?>"> Detail </a>
                </td>
                <td valign="top"><?php echo $list['full_name'];?></a></td> 
                <td valign="top"><?php echo $list['email'];?></td> 
                <td valign="top"><?php echo $list['mobile'];?></td>
                <td valign="top"><?php echo date("d F y",strtotime($list['created_date']));?></td>
                <td valign="top"><?php if($list['last_login']!='0000-00-00')echo date("d F Y",strtotime($list['last_login']));?></td>
    		</tr>
    		<?php $no++; } else if(!$user){ ?> 
            <tr>
                <td colspan="7"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>