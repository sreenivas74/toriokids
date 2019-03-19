<div id="content">
	
    <h2>Coupons  &raquo; Add &raquo; User</h2>
	<form method="post" id="add_coupoun" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/coupon/doadduser');?>">
    <input type="hidden" name="voc_id" value="<?php echo $da?>" />
     <dl>
        <dd>User</dd>
        <dt><select class="txtField validate[required]" name="userid" id="userid">
        <option value="">--- PLEASE SELECT BELOW ---</option>
         <?php if($user) foreach($user as $list){?>
          <option value="<?php echo $list['id']?>"><?php echo $list['full_name']?> (<?php echo $list['email']?>)</option>     
       	<?php } ?>
       </select></dt>
    </dl>
        <dd></dd>
 <dl>
       <dt><input type="submit" class="defBtn" id="addindividu" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/coupoun/').'/';?>';"/></dt>
    </dl>
    </form>
     <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th >No</th>
     			<th >Action</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Date Used</th>
             
           </tr>
        </thead>
        <tbody>
        <?php $no=1 ?>
    	     <?php foreach($user_list_voc as $list){?>
           <tr>
                <td valign="top"><?php echo $no++?></td>
              	<td valign="top">
                <?php if ($list['status']==0) {?>
                 <a href="<?php echo site_url('torioadmin/coupoun/dodeleteuser/'.$list['id'].'/')?>" onclick="return confirm('Confirm Delete?');" >Delete</a>
                 <?php }else {?>
                 
				 <?php }?>
                 </td>
                <td valign="top"><?php echo $list['full_name']?></td>
                <td valign="top"><?php echo $list['email']?></td>
                <td valign="top"><?php if ($list['status']==0) {?><?php echo "Not Used" ?><?php }else{?> <?php echo "Used"?><?php }?></td>  
             <td valign="top"> 
			 <?php if ($list['status']==1){?>
			 <?php echo date("d M Y",strtotime($list['date_used']));?>
			 <?php }?>
             </td> 
            </tr>
              <?php }?>
        </tbody>
    </table>
</div>
</div>
