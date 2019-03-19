
<?php $this->load->view('content/my_account/my_account_menu');?>           
<div class="editContainer">
    <div class="noBg">
    <a href="<?php echo site_url('home');?>">Home </a>&gt;<a  href="<?php echo site_url('my_account');?>"> My Account </a>&gt;<a class="selectedBreadCrumb"> My Addresses</a>
    </div>
    <div class="editAccCon">
        <div class="editAccBox">                   
    	<h2>My Addresses</h2>
        <div class="addAdressesCon">
            <?php if(isset($_SESSION['flag'])){?><div class="messageCon">Address has been saved successfully.</div><?php $_SESSION['flag']=NULL;}?>
            <?php if(!$address){?><div class="messageCon">You haven't saved any addresses yet.</div><?php }?>
            <a href="<?php echo site_url('my_addresses/add');?>" class="addAdresses">Add Addresses</a>
            <?php if($address){?>Please find below the addresses you've saved previously. Click on the name to edit its details.<?php }?>
        </div>
       <?php if($address){?>
       <div class="myAddresses">
            <table>
                <tr class="row1">
                    <td width="40">&nbsp;</td>
                    <td width="118">&nbsp;</td>
                    <td width="152">Recipient Name</td>
                    <td width="92">Mobile / Phone</td>
                    <td width="147">Address</td>
                    <td width="105">Zip Code</td>
                    <td width="24" >&nbsp;</td>
                </tr>
                <?php if($address)foreach($address as $list){?>
                <tr style="border-bottom:1px solid #DDDDDD;">
                    <td><a onclick="return confirm('Are You sure to delete this address?');" href="<?php echo site_url('my_addresses/delete_address').'/'.$list['id'];?>" title="Remove Address"><img src="<?php echo base_url();?>templates/images/remove.png" /></a></td>
                    <td><?php if($list['default_address']==1)echo "Default Address";else{?><a href="<?php echo site_url('my_addresses/do_set_default').'/'.$list['id'];?>">Set as Default</a><?php }?></td>
                    <td><a href="<?php echo site_url('my_addresses/edit').'/'.$list['id'];?>" title="Edit Address"><?php echo $list['recipient_name'];?></a></td>
                    <td><?php echo $list['phone'];?></td>
                    <td><?php echo nl2br($list['shipping_address']);?></td>
                    <td><?php echo $list['zipcode'];?></td>
                    <td><a href="<?php echo site_url('my_addresses/edit/'.$list['id'])?>">Edit</a></td>
                </tr>
            	<?php }?>
                <tr>
                    <td colspan="7" class="row1"></td>
                </tr>
            </table>
        </div>
        <?php }?>
        </div>
    </div>
</div>