<?php if($advertisement)foreach($advertisement as $list){?>
<div class="advertise">
	<a href="<?php if($list['link']!="")echo $list['link'];else echo "#";?>" <?php if($list['link']!="")echo "target=\"_blank\"";?>><img src="<?php echo base_url().'userdata/advertisement/'.$list['image'];?>" title="<?php echo $list['name'];?>" alt="<?php echo $list['name'];?>" /></a>
</div> 
<?php }?>