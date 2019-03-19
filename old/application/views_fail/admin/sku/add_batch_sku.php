<script>
$(document).ready(function(){
	$("#add_template").click(function(){
		var name = $("#template").val();
		var temp = $.ajax({			
		   type: "POST",
		   url: '<?php echo site_url('torioadmin/product/template_detail');?>/'+name,
		   success: function(data){					    
			 	$('.template_form').append(data);
				
		   }
		})	
		$('.add_size').show();
		$('#submit_all').show();
	});
	
	$("#clear").click(function(){
		$(".template_form").html('');
		$(".add_size").hide();
		$("#submit_all").hide();
	});
	
	$("#add_field").click(function(){
		$('#fielda').show();
	})
});
function remove_template(obj){
	$(obj).parents('p').remove();return false;
}
function generate_template(){
	var size = $("#size").val();
	var x='<p><label style="padding-right:15px;"><input  style="margin:0 5px;" id="inlineCheckbox" type="checkbox" class="checkBox" value="'+size+'" name="template_size[]">'+size+' <a href="javascript:void(0)" onclick="remove_template(this);">Delete</a></label></p>';
	$('.template_form').append(x);
}
</script>
<div id="content">
	<h2>SKU &raquo; Add Batch</h2>
    <div>
    	<dl>
            <dd>Template Name</dd>
            <dt>
            	<select class="txtField" name="template" id="template">
                    <option value="0" label="-- Pilih Template --">-- Pilih Template --</option>
                    <?php if($template)foreach($template as $temp){ ?>
                    <option value="<?php echo $temp['id']?>"><?php echo $temp['name']?></option>
                    <?php } ?>
            	</select>
            </dt>
    	</dl>
        <dl>
            <dd></dd>
            <dt><input id="add_template" type="submit" class="defBtn" value="Add"/> <input type="button" id="clear" class="defBtn" value="Clear" /> <input type="button" class="defBtn" value="Back" onclick="window.location='<?php echo site_url('torioadmin/product/view_sku_list').'/'.$product_id;?>';" /></dt>
        </dl>
    </div>
    <form method="post" id="add_batch_sku_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/do_add_batch_sku').'/'.$product_id;?>">
    <div class="template_form"></div>
    <div class="add_size" style="display:none;"><input id="add_field" type="button" class="defBtn" value="Add New"/></div>
    <div id="fielda" style="display:none;">
    	<dl>
        	<dd>Size</dd>
            <dt><input class="txtField" type="text" name="size" id="size"/></dt>
        </dl>
        <dl>
        	<dd></dd>
            <dt><a href="javascript:void(0)" onclick="generate_template();">Submit</a></dt>
        </dl>
    </div>
    <div id="submit_all" style="display:none;"><input type="submit" class="defBtn" value="Submit All"/></div>
    </form>
</div>