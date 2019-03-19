<div id="content">
	<h2>JNE &raquo; Add City</h2>
	<form method="post" name="add_city_form" id="add_city_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/jne/do_add_city');?>">
        <dl>
            <dd>Province</dd>
            <dt>
            	<select class="txtField" name="province">
                    <option value="" label="-- Select province --">-- Select Province --</option>
                    <?php if($province)foreach($province as $prov){?>
                    <option value="<?php echo $prov['id']?>"><?php echo $prov['name']?></option>
                    <?php } ?>
                </select>
            </dt>
        </dl>
        <dl>
            <dd>City</dd>
            <dt><input class="txtField validate[required]" type="text" name="city" id="city"/></dt>
        </dl>
        <dl>
            <dd>Regular Fee</dd>
            <dt><input class="txtField" type="text" name="regular_fee" id="regular_fee"/></dt>
        </dl>
        <dl>
            <dd>Regular ETD</dd>
            <dt><input class="txtField" type="text" name="regular_etd" id="regular_etd"/></dt>
        </dl>
        <dl>
            <dd>Express Fee</dd>
            <dt><input class="txtField" type="text" name="express_fee" id="express_fee"/></dt>
        </dl>
        <dl>
            <dd>Express ETD</dd>
            <dt><input class="txtField" type="text" name="express_etd" id="express_etd"/></dt>
        </dl>
         <dl>
            <dd>Min Purchase</dd>
            <dt><input class="txtField" type="text" name="min_purchase" id="min_purchase"/></dt>
        </dl>
        
    <dl>
        <dd></dd>
       <dt><input type="submit" class="defBtn" id="add_city_submit" value="Submit"/> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/jne');?>';" /></dt>
    </dl>
    </form>
</div>