<div id="content">
<h2>Shipping And Policy &raquo; Edit</h2>
<form method="post" >
<dl>
    <dd>Shipping</dd>
    <dt><textarea class="txtField" name="shipping"><?php if($data) echo $data['shipping'] ?></textarea></dt>
    <input type="hidden" name="id" value="<?php if($data) echo $data['id'] ?>"/>
</dl>
<dl>
    <dd>Policy</dd>
    <dt><textarea class="txtField" name="policy"><?php if($data) echo $data['policy'] ?></textarea></dt>
</dl>
<dl>
    <dd></dd>
    <dt><input type="submit" class="defBtn" value="Submit" /></dt>
</dl>
</form>
</div>