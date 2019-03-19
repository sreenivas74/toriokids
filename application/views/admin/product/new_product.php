<div id="content">
	<h2>Product Status</h2>
	<form method="post" id="submit_related_product_form" enctype="multipart/form-data" action="<?php echo site_url('torioadmin/product/submit_product_status'.'/');?>">
    
    <input type="submit" class="defBtn" value="Submit"/>
    <table class="defAdminTable prodStatus" width="100%">
	<thead>
    	<tr>
            <th width="10%">No</th>
            <th width="30%">Name</th>
             <th width="15%">New Product</th>
              <th width="15%">Featured Product</th>
            <th width="15%">Active/Inactive</th>
            <th width="15%">Best Seller</th>
        </tr>
    </thead>
    <tbody>
    
		<?php 
        $no=1; 
        if($product)foreach($product as $list){?>
        <tr>
        <td valign="top" style="width:10%" ><?php echo $no;?></td>
        <td valign="top" style="width:30%" ><?php echo $list['name'];?></td>
        <input type="hidden" name="id[]" id="id_<?php echo $list['id'] ?>" value="<?php echo $list['id'] ?>" />
        <td valign="top" width="15%" style="text-align:center">
         <input type="checkbox" name="new_product[]" value="<?php echo $list['id'] ?>" <?php if($list['flag']==1)echo "checked=\"checked\"";?>>
        </td>
         <td valign="top" width="15%" style="text-align:center">
    <input type="checkbox" name="featured[]" value="<?php echo $list['id'] ?>" <?php if($list['featured']==1)echo "checked=\"checked\"";?>>
         
        </td>
         <td valign="top" width="15%" style="text-align:center">
       <input type="checkbox" name="active[]" value="<?php echo $list['id'] ?>" <?php if($list['active']==1)echo "checked=\"checked\"";?>> 
        </td>
         <td valign="top" width="15%" style="text-align:center">
  
            
               <input type="checkbox" name="sale_product[]" value="<?php echo $list['id'] ?>" <?php if($list['best_seller']==1)echo "checked=\"checked\"";?>>
	
        </td>
        
      <?php $no++;}?>
      <tr>
      <td colspan="6"><input type="submit" class="defBtn" value="Submit"/	></td>
      </tr>
    </tbody>
</table>






    </form>
</div>