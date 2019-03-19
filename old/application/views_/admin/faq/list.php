<div id="content">
    <h2>Frequently Asked Question &raquo; List</h2>
    <div id="submenu">
        <ul>
            <li><a class="defBtn" href="<?php echo site_url('torioadmin/content_page/add_faq');?>"><span>Add</span></a></li>
        </ul>
    </div>
    <dl>
        <dd>Category</dd>
        <dt>
        <form name="select_category_form" method="post" action="<?php echo site_url('torioadmin/content_page/view_faq')?>">
            <select class="txtField" style="width:200px" name="category" onChange="document.select_category_form.submit()">
            	<option value="0">-- Category --</option>
                <option value="all" <?php if($cat == "all"){?> selected="selected"<?php } ?>>View All</option>
                <?php if($category)foreach($category as $cate){ ?>
                <option value="<?php echo $cate['id']?>" <?php if($cat == $cate['id']){?> selected="selected"<?php } ?>><?php echo $cate['name']?></option>
				<?php } ?>
            </select>
        </form>
        </dt>
    </dl>
    <table class="defAdminTable" width="100%">
        <thead>
        	<tr>
            	<th width="2%">No</th>
                <th width="10%">Action</th>
                <th width="10%">Category</th>
                <th width="20%">Question</th>
                <th width="30%">Answer</th>
                <?php if($cat!="all"){ ?><th width="8%" colspan="2">Precedence</th><?php }?>
            </tr>
        </thead>
        <tbody>
        <?php if($cat!=null){ ?>
        <?php $no=1; 
			  if($detail)foreach($detail as $list){?>
            <tr>
                <td valign="top"><?php echo $no;?></td>
                <td valign="top">
                <a href="<?php echo site_url('torioadmin/content_page/change_active_faq').'/'.$list['id'].'/'.$list['active']; ?>"> <?php if($list['active']==1)echo "Active"; else echo "Inactive"; ?> </a> | 
                <a href="<?php echo site_url('torioadmin/content_page/edit_faq').'/'.$list['id'];?>">Edit</a>
                </td>
                <td valign="top"><?php echo find('name', $list['faq_category_id'], 'faq_category_tb');?></td>
                <td valign="top"><?php echo $list['question'];?></td>
                <td valign="top"><?php if(strlen($list['answer'])<100) echo $list['answer']; else echo substr(strip_tags($list['answer']), 0 , 100)."...";?></td>
                 <?php if($cat!="all"){ ?>
    			<td valign="top">
                <?php if ($list['precedence'] != first_precedence_2('faq_tb', 'faq_category_id', $list['faq_category_id'])){?>
    				<a href="<?php echo site_url('torioadmin/content_page/up_precedence_faq/'.$list['id'].'/'.$list['faq_category_id']);?>">Up</a> 
				<?php }?>
                </td>
                <td valign="top">
    			<?php if ($list['precedence'] != last_precedence_2('faq_tb', 'faq_category_id', $list['faq_category_id'])){?>
    				<a href="<?php echo site_url('torioadmin/content_page/down_precedence_faq/'.$list['id'].'/'.$list['faq_category_id']);?>">Down</a>
    			<?php }?>
                </td>
                <?php }?>
    		</tr>
    		<?php $no++; } else if(!$detail){ ?> 
            <tr>
                <td colspan="6"><?php echo "No Stored Data"; ?></td>
        	</tr>
            <?php }} ?>
        </tbody>
    </table>
</div>