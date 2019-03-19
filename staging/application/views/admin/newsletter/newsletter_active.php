<div id="content">
<h2>Newsletter Active &raquo; List</h2>
<div id="submenu">
    <ul>
        <li><a class="defBtn" href="<?php echo site_url('torioadmin/newsletter/download_csv_form_active');?>"><span>Download CSV newsletter</span></a></li>
    </ul>
</div>
<?php if($newsletter!=""){?>
<table class="defAdminTable" width="100%">
	<thead>
    	<tr>
            <th width="2%">No</th>
            <th width="15%">Action</th>
            <th width="20%">Email</th>
            <th width="20%">Status</th>
        </tr>
    </thead>
    <tbody>
<?php 
$no=1; 
if($newsletter)foreach($newsletter as $list){?>
    <tr>
    <td valign="top"><?php echo $no;?></td>
    <td valign="top"><a href="<?php echo site_url('torioadmin/newsletter/delete').'/'.$list['id'];?>" onclick="return confirm('Confirm Delete?');">Delete</a></td>
    <td valign="top"><?php echo $list['email'];?></td>
    <td valign="top">
        <?php 
if($list['status']==1){?>
Active | <a href="<?php echo site_url('torioadmin/newsletter/active2/'.$list['id'].'/'.$list['status']);?>">Change</a>
<?php 
}
else{?>
Inactive | <a href="<?php echo site_url('torioadmin/newsletter/active2/'.$list['id'].'/'.$list['status']);?>">Change</a>
<?php 
} 
?>       
        </td>  
    </tr>
    <?php $no++; }?>
    
    </tbody>
</table>
<?php } else{ ?>
<?php }?>
</div>