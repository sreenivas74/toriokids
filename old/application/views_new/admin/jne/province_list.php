<div id="content">
    <h2>JNE &raquo; Province List</h2>
    <div id="submenu">
        <ul>
        	<li><a class="defBtn" href="<?php echo site_url('torioadmin/jne/add_province');?>"><span>Add Province</span></a> <a class="defBtn" href="<?php echo site_url('torioadmin/jne');?>"><span>Back</span></a>
           <?php /*?> <a class="defBtn" href="<?php echo site_url('torioadmin/jne/download_csv_form').'/'.$this->uri->segment(4);?>"><span>Download CSV Template</span></a> <?php 
            <a class="defBtn" href="#" onclick="show(); return false;"><span>Upload CSV Template</span></a>*/?></li>
        </ul>
    </div>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="10%">Action</th>
                <th width="50%">Province</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; 
			  if($province)foreach($province as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/jne/edit_province').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo $list['name']?></td>
    		</tr>
    		<?php $no++; } else if(!$province){ ?> 
            <tr>
                <td colspan="3"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php } ?>
        </tbody>
    </table>
</div>