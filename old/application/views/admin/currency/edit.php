<div id="content">
	<h2>Currency &raquo; Edit</h2>
	<form method="post" id="edit_content_page_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/currency/do_edit');?>">
    <dl>
        <dd>Rate</dd>
        <dt><input class="txtField" type="text" name="rate" value="<?php echo $detail['rate']?>"/></dt>
    </dl>
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" value="Submit"/></dt>
    </dl>
    </form>
</div>