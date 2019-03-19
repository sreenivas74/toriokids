<div id="content">
    <h2>Countdown &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/countdown/add') ?>">Add</a></li>
        </ul>
    </div>
    <?php echo "Server time : ".date('d F Y H:i:s'); ?>
  
    <table class="defAdminTable" width="100%">
        <thead>
            <tr>
                <th width="2%">No</th>
                <th width="10%">Action</th>
                <th width="20%">Name</th>
                <th width="30%">Image</th>
                <th width="30%">Image Mobile</th>
                <th width="20%">Start Date</th>
                <th width="20%">End Date</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $no=1;	
        if($countdown)foreach($countdown as $list){?>
        <tr>
            <td><?php echo $no;?></td>
            <td><a href="<?php echo site_url('torioadmin/countdown/edit_countdown').'/'.$list['id'];?>">Edit</a> | <a href="<?php echo site_url('torioadmin/countdown/delete_countdown').'/'.$list['id'] ?>" onclick="return confirm('Delete this countdown?')">Delete</a></td>
            <td><?php echo $list['name'] ?></td>
            <td><img src="<?php echo base_url() ?>userdata/countdown/<?php echo $list['image'] ?>" width="100%" /></td>
            <td><img src="<?php echo base_url() ?>userdata/countdown/mobile/<?php echo $list['image_mobile'] ?>" width="100%" /></td>
            <td><?php echo date('d F Y H:i:s', strtotime($list['start_time']));?></td>
            <td><?php echo date('d F Y H:i:s', strtotime($list['end_time']));?></td>
          </tr>
        <?php $no++; }?>
        
        </tbody>
    </table>
</div>