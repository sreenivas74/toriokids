<div id="content">
<h2>Lazada Ads &raquo; Edit</h2>
<form method="post" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/ads/do_edit/');?>">
<dl>
    <dd>Desktop Ads (728x90)</dd>
    <dt><textarea class="txtField" name="ads_desktop"><?php if($ads_desktop) echo $ads_desktop['value'] ?></textarea></dt>
</dl>
<dl>
    <dd>Mobile Ads (300x250)</dd>
    <dt><textarea class="txtField" name="ads_mobile"><?php if($ads_mobile) echo $ads_mobile['value'] ?></textarea></dt>
</dl>
<dl>
    <dd></dd>
    <dt><input type="submit" class="defBtn" value="Submit" /></dt>
</dl>
</form>
</div>