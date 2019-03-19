<td></td>
<td>
<form name="edit_client_information_<?php echo $client_information['id']?>" method="post" action="<?php echo site_url('client/edit_client_information/'.$client_information['id'])?>" enctype="multipart/form-data">
<textarea name="description"><?php echo $client_information['description']?></textarea>
<br />
<input type="submit" name="submit" id="submit" value="Edit"> <a href="#" onClick="close_client_information(<?php echo $client_information['id']?>);return false;">Close</a>
</form>
</td>
<td></td>
