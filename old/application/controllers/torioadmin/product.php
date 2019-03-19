<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Product extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('product_model');	
		$this->load->model('category_model');	
		$this->load->model('template_model');
		$this->load->model('general_model');
	}
	
	function index()
	{
		$this->data['product']=$this->product_model->get_product_list();
		$this->data['content']='admin/product/product_list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	//produk
	function add_product()
	{	
		$this->data['template']=$this->template_model->get_template_name_list();
		$this->data['category'] = $this->category_model->get_active_category_list();
		$this->data['sub_category'] = $this->category_model->get_active_sub_category_list();
		$this->data['content']='admin/product/add_product';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add_product()
	{	

		$ca = $this->input->post('category_name');
		$sca = $this->input->post('sub_category_name');
		if($ca==null){
			$category_name ="";
		}else{
			$category_name = json_encode($ca);
		}
		if($sca==null){
			$sub_category_name ="";
		}else{
			$sub_category_name = json_encode($sca);
		}
		$name = $this->input->post('name');
		$flag = $this->input->post('flag');
		$best_seller = $this->input->post('best_seller');
		$weight = $this->input->post('weight');
		$price = $this->input->post('price');
		$msrp = $this->input->post('msrp');
		$discount=$this->input->post('discount');
		
		$description = $this->input->post('description');
		$featured = $this->input->post('featured');
		
		$template_id=$this->input->post('template_id');
		$active = $this->input->post('active');
		
		
	
		if($msrp>$price)
		$sale_product=1;
		else
		$sale_product=0;
		
		$this->product_model->insert_product($category_name, str_replace('\\','',$sub_category_name), $name, $price, $description, $active, $flag, $weight,$sale_product,$msrp, $best_seller,$featured,$template_id,$discount);
		$id = mysql_insert_id();
		$alias = make_alias($name)."_".$id;
		$this->product_model->update_alias($id, $alias);
		redirect('torioadmin/product');
	}
	
	function edit_product($id)
	{
		$this->data['template']=$this->template_model->get_template_name_list();
		$this->data['id'] = $id;
		$this->data['detail']=$this->product_model->get_selected_product_data($id);
		if($this->data['detail']['category_name']!=null){
			$this->data['category_name']=json_decode($this->data['detail']['category_name'],1);
		}else $this->data['category_name']= array('');
		if($this->data['detail']['sub_category_name']!=null){
			$this->data['sub_category_name']=json_decode($this->data['detail']['sub_category_name'],1);
		}else $this->data['sub_category_name']= array('');
		$this->data['category'] = $this->category_model->get_active_category_list();
		$this->data['sub_category'] = $this->category_model->get_active_sub_category_list();
		$this->data['content']='admin/product/edit_product';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit_product($id)
	{
		
		$ca = $this->input->post('category_name');
		$sca = $this->input->post('sub_category_name');
		if($ca==null){
			$category_name ="";
		}else{
			$category_name = json_encode($ca);
		}
		if($sca==null){
			$sub_category_name ="";
		}else{
			$sub_category_name = json_encode($sca);
		}
		$name = $this->input->post('name');
		$flag = $this->input->post('flag');
		$weight = $this->input->post('weight');
		$price = $this->input->post('price');
		$msrp = $this->input->post('msrp');
		$discount=$this->input->post('discount');
		$description = $this->input->post('description');
		$best_seller = $this->input->post('best_seller');
		$featured = $this->input->post('featured');
		$template_id=$this->input->post('template_id');
			
		
		if($msrp>$price)
		$sale_product=1;
		else
		$sale_product=0;
		
		$this->product_model->update_product($id, $category_name,str_replace('\\','',$sub_category_name), $name, $price, $description, $flag, $weight,$sale_product,$msrp, $best_seller,$featured,$template_id,$discount);
		$alias = make_alias($name)."_".$id;
		$this->product_model->update_alias($id, $alias);
		redirect('torioadmin/product');
	}
	
	function change_active_product($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->product_model->update_active_product($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_new_product($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->product_model->update_new_product($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_sale_product($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->product_model->update_sale_product($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	function change_featured_product($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->product_model->update_featured_product($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}

	//produk image
	function view_product_image_list($product_id)
	{
		$this->data['product']=$this->product_model->get_product_image_list($product_id);
		$this->data['content']='admin/product/product_image_list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function add_product_image($product_id)
	{	
		$this->data['product_id'] = $product_id;
		$this->data['content']='admin/product/add_product_image';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add_product_image($product_id)
	{	
		$cek = last_precedence_flexible('precedence', 'product_image_tb', 'product_id', $product_id);
		if($cek==NULL)
		{
			$precedence = 1;
		} else 
		{
			$precedence = $cek + 1;	
		}
		
		$image='';	
			$config['upload_path'] = 'userdata/';
			$config['allowed_types'] = 'jpg|gif|png';
			$config['encrypt_name'] = TRUE;		
			$this->load->library('upload', $config);
			if($this->upload->do_upload('image'))
			{				
				$data = $this->upload->data(); 			
				$source             = "userdata/".$data['file_name'] ;
				$destination		= "userdata/product";
				$destination2		= "userdata/product/med/" ;
				$destination3		= "userdata/product/thumbs/" ;
				
				chmod($source, 0777) ;
				$this->load->library('image_lib') ;
				$sourceSize = getSizeImage($source);
				$sourceRatio = $sourceSize['height']/$sourceSize['width'];
				
				$img['image_library'] = 'GD2';
				$img['maintain_ratio']= true;
					
				//// Making THUMBNAIL ///////
				$img['width']  = 460;
				$img['height'] = $img['width'] * $sourceRatio;
				$img['quality']      = '100%';
				$img['source_image'] = $source ;
				$img['new_image']    = $destination;
				$this->image_lib->initialize($img);
				$this->image_lib->resize();
				$this->image_lib->clear() ;	
				
				$img['width']  = 160;
				$img['height'] = $img['width'] * $sourceRatio;
		 		$img['quality']      = '100%';
				$img['source_image'] = $source ;
				$img['new_image']    = $destination2;
				$this->image_lib->initialize($img);
				$this->image_lib->resize();
				$this->image_lib->clear() ;	
				
				$img['width']  = 80;
				$img['height'] = $img['width'] * $sourceRatio;
		 		$img['quality']      = '100%';
				$img['source_image'] = $source ;
				$img['new_image']    = $destination3;
				$this->image_lib->initialize($img);
				$this->image_lib->resize();
				$this->image_lib->clear() ;	
				
				unlink($source);
				$image=$data['file_name'];
				
			}
			$active=1;
		
		$this->product_model->insert_product_image($product_id, $image, $precedence, $active);
		redirect('torioadmin/product/view_product_image_list'.'/'.$product_id);
	}
	
	function edit_product_image($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->product_model->get_selected_product_image_data($id);
		$this->data['content']='admin/product/edit_product_image';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function delete_product_image($id){		
		$data=$this->product_model->get_selected_product_image_data($id);
		
		$old_picture=$data['image'];				
		
		if($old_picture!=""){
			$old_src="userdata/product/".$old_picture ;
			$old_src2="userdata/product/med/".$old_picture ;
			$old_src3="userdata/product/thumbs/".$old_picture ;
			if(file_exists($old_src))unlink($old_src);
			if(file_exists($old_src2))unlink($old_src2);
			if(file_exists($old_src3))unlink($old_src3);
		}
		
		$this->product_model->delete_product_image($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function do_edit_product_image($id)
	{
		$old_image = $this->product_model->get_selected_product_image_data($id);
		$image = $old_image['image'];
		$config['upload_path'] = 'userdata/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('image'))
		{		
		
			$data = $this->upload->data(); 			
			$source             = "userdata/".$data['file_name'] ;
			$destination		= "userdata/product/" ;
			$destination2		= "userdata/product/med/" ;
			$destination3		= "userdata/product/thumbs/" ;
			chmod($source, 0777) ;
			$this->load->library('image_lib') ;
			$sourceSize = getSizeImage($source);
			$sourceRatio = $sourceSize['height']/$sourceSize['width'];
			
			if ($image){
			//DELETE OLD FILES
			if(file_exists($destination))unlink($destination."".$image);
			if(file_exists($destination2))unlink($destination2."".$image);
			if(file_exists($destination3))unlink($destination3."".$image);
			}
			$img['image_library'] = 'GD2';
			$img['maintain_ratio']= true;
				
			//// Making THUMBNAIL ///////
			$img['width']  = 460;
			$img['height'] = $img['width'] * $sourceRatio;
			$img['quality']      = '100%';
			$img['source_image'] = $source ;
			$img['new_image']    = $destination;
			$this->image_lib->initialize($img);
			$this->image_lib->resize();
			$this->image_lib->clear() ;	
				
			$img['width']  = 160;
			$img['height'] = $img['width'] * $sourceRatio;
			$img['quality']      = '100%';
			$img['source_image'] = $source ;
			$img['new_image']    = $destination2;
			$this->image_lib->initialize($img);
			$this->image_lib->resize();
			$this->image_lib->clear() ;	
			
			$img['width']  = 80;
			$img['height'] = $img['width'] * $sourceRatio;
			$img['quality']      = '100%';
			$img['source_image'] = $source ;
			$img['new_image']    = $destination3;
			$this->image_lib->initialize($img);
			$this->image_lib->resize();
			$this->image_lib->clear() ;	
			
			unlink($source);
			$image=$data['file_name']; 
		}
		$this->product_model->update_product_image($id, $image);
		redirect('torioadmin/product/view_product_image_list'.'/'.$old_image['product_id']);
	}
	
	function change_active_product_image($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->product_model->update_active_product_image($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_product_image($id, $product_id)
	{
		$this->product_model->up_precedence_product_image($id, $product_id);
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_product_image($id, $product_id)
	{
		$this->product_model->down_precedence_product_image($id, $product_id);
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	//sku
	function view_sku_list($product_id)
	{
		$this->data['sku']=$this->product_model->get_sku_list($product_id);
		$this->data['content']='admin/sku/sku_list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function add_sku($product_id)
	{	
		$this->data['product_id'] = $product_id;
		$this->data['content']='admin/sku/add_sku';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add_sku($product_id)
	{	
		$product = $this->product_model->get_selected_product_data($product_id);
		$product_name = $product['name'];
		$size = $this->input->post('size');
		$name = $product_name." ".$size;
		$cek = last_precedence_flexible('precedence', 'sku_tb', 'product_id', $product_id);
		if($cek==NULL)
		{
			$precedence = 1;
		} else 
		{
			$precedence = $cek + 1;	
		}
		$active = 1;
		
		$this->product_model->insert_sku($product_id, $name, $size, $precedence, $active);
		redirect('torioadmin/product/view_sku_list'.'/'.$product_id);
	}
	
	function edit_sku($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->product_model->get_selected_sku_data($id);
		$this->data['content']='admin/sku/edit_sku';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit_sku($id)
	{
		$size = $this->input->post('size');
		$sku = $this->product_model->get_selected_sku_data($id);
		$product = $this->product_model->get_selected_product_data($sku['product_id']);
		$product_name = $product['name'];
		$name = $product_name." ".$size;
		$this->product_model->update_sku($id, $size, $name);
		redirect('torioadmin/product/view_sku_list'.'/'.$sku['product_id']);
	}
	
	function change_active_sku($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->product_model->update_active_sku($id, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_sku($id, $product_id)
	{
		$this->product_model->up_precedence_sku($id, $product_id);
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_sku($id, $product_id)
	{
		$this->product_model->down_precedence_sku($id, $product_id);
		redirect ($_SERVER['HTTP_REFERER']);
	}	
	
	//batch sku
	function template_detail($id)
	{
		$this->data['detail']=$this->template_model->get_template_size_list($id);
		$this->load->view('admin/sku/get_template_size', $this->data);	
	}
	
	function add_batch_sku($product_id)
	{
		$this->data['product_id'] = $product_id;
		$this->data['template']=$this->template_model->get_template_name_list();	
		$this->data['sku']=$this->product_model->get_sku_list($product_id);
		$this->data['content']='admin/sku/add_batch_sku';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add_batch_sku($product_id)
	{	
		$product = $this->product_model->get_selected_product_data($product_id);
		$product_name = $product['name'];
		$active = 1;
		$size = $this->input->post('template_size');
		$total_size = count($size);
		for($i=0; $i<$total_size; $i++){
			$name = $product_name." ".$size[$i];
			$precedence = last_precedence('sku_tb') + 1;
				$this->product_model->insert_sku($product_id, $name, $size[$i], $precedence, $active);
		}	
		redirect('torioadmin/product/view_sku_list'.'/'.$product_id);
	}
	
	//Related Product
	function view_related_product($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->product_model->get_selected_product_data($id);
		$this->data['product']=$data=$this->product_model->get_active_related_product($id);
		$this->data['cek']=$this->product_model->get_selected_related_product($id);
		$this->data['content']='admin/product/related_product';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function submit_related_product($product_id_from)
	{
		$product_id_to = $this->input->post('product_id_to');
		$total_product = count($product_id_to);
		$this->product_model->delete_related($product_id_from);
		$this->product_model->delete_related2($product_id_from);
		if($product_id_to){
			for($i=0; $i<$total_product; $i++){
				$this->product_model->insert_related_product($product_id_from, $product_id_to[$i]);
				$this->product_model->insert_related_product2($product_id_from, $product_id_to[$i]);
			}	
		}
		redirect('torioadmin/product');
	}
	
	function view_product_status(){
		$this->data['product']=$this->product_model->get_product_list();
		$this->data['content']='admin/product/new_product';
		$this->load->view('common/admin/body',$this->data);	
	}
	function submit_new_product(){
		$product_id_to=$this->input->post('product_id_to');
		$product_list=$this->product_model->get_product_list();
		if($product_list)foreach($product_list as $list){
			if(in_array($list['id'], $product_id_to)){
				$flag=1;
				$id=$list['id'];
				$this->product_model->update_new_product($id, $flag);
			}else{
				$flag=0;
				$id=$list['id'];
				$this->product_model->update_new_product($id, $flag);
			}	
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function submit_product_status(){
		
		$featured=$this->input->post('featured');
		$active=$this->input->post('active');
		$sale_product=$this->input->post('sale_product');
		$new_product=$this->input->post('new_product');
		
		
		$product_list=$this->product_model->get_product_list();
		if($product_list)foreach($product_list as $list){
			$featured_1=0;
		$active_1=0;
		$sale_product_1=0;
		$new_product_1=0;
			if(in_array($list['id'], $featured)){
				$featured_1=1;
			} 
			if(in_array($list['id'], $active)){
				$active_1=1;
			} 
			if(in_array($list['id'], $sale_product)){
				$sale_product_1=1;
			}
			if(in_array($list['id'], $new_product)){
				$new_product_1=1;
			}
		$id=$list['id'];
		$database=array('flag'=>$new_product_1,'featured'=>$featured_1,'active'=>$active_1,'best_seller'=>$sale_product_1);
		$this->general_model->update_data('product_tb',$database,array('id'=>$id));			
			
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function view_product_active(){
		$this->data['new_product']=$this->product_model->get_product_list();
		$this->data['content']='admin/product/product_active';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function submit_product_active(){
		$product_id_to=$this->input->post('product_id_to');
		$product_list=$this->product_model->get_product_list();
		if($product_list)foreach($product_list as $list){
			if(in_array($list['id'], $product_id_to)){
				$flag=1;
				$id=$list['id'];
				$this->product_model->update_active_product($id, $flag);
			}else{
				$flag=0;
				$id=$list['id'];
				$this->product_model->update_active_product($id, $flag);
			}	
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	
	
	function view_sale_product(){
		$this->data['sale_product']=$this->product_model->get_product_list();
		$this->data['content']='admin/product/sale_product';
		$this->load->view('common/admin/body',$this->data);	
	}
	function submit_sale_product(){
		$product_id_to=$this->input->post('product_id_to');
		$product_list=$this->product_model->get_product_list();
		if($product_list)foreach($product_list as $list){
			if(in_array($list['id'], $product_id_to)){
				$active=1;
				$id=$list['id'];
				$this->product_model->update_sale_product($id, $active);
			}else{
				$active=0;
				$id=$list['id'];
				$this->product_model->update_sale_product($id, $active);
			}	
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	function view_featured_product(){
		$this->data['sale_product']=$this->product_model->get_product_list();
		$this->data['content']='admin/product/featured_product';
		$this->load->view('common/admin/body',$this->data);	
	}
	function submit_featured_product(){
		$product_id_to=$this->input->post('product_id_to');
		$product_list=$this->product_model->get_product_list();
		if($product_list)foreach($product_list as $list){
			if(in_array($list['id'], $product_id_to)){
				$active=1;
				$id=$list['id'];
				$this->product_model->update_featured_product($id, $active);
			}else{
				$active=0;
				$id=$list['id'];
				$this->product_model->update_featured_product($id, $active);
			}	
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function view_price_product(){
		$this->data['schedule'] = $this->product_model->get_sale_schedule();
		$this->data['product_list']=$this->product_model->get_product_list_price();
		$this->data['content']='admin/product/price_product';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function submit_product_price(){
		$id=$this->input->post('id');
		$price=$this->input->post('price');
		$msrp=$this->input->post('msrp');
		$discount=$this->input->post('discount');
		$total_product=count($id);
		
		//die(pre($_POST));
		
		for($i=0; $i<$total_product; $i++){
			//if($msrp[$i]>$price[$i])
			//$sale=1;
			//else
			//$sale=0;
			
			$sale=$this->input->post('sale'.$id[$i]);
			
			$database=array('price'=>$price[$i],'msrp'=>$msrp[$i],'discount'=>$discount[$i],'sale_product'=>$sale);
			$where=array('id'=>$id[$i]);
			$this->product_model->update_data('product_tb',$database,$where);
			
		//	if($id[$i]==33)pre($database);
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	function view_product_best_seller(){
		$this->data['new_product']=$this->product_model->get_product_list();
		$this->data['content']='admin/product/product_best_seller';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function submit_product_best_seller(){
		$product_id_to=$this->input->post('product_id_to');
		$product_list=$this->product_model->get_product_list();
		if($product_list)foreach($product_list as $list){
			if(in_array($list['id'], $product_id_to)){
				$flag=1;
				$id=$list['id'];
				$this->product_model->update_best_seller($id, $flag);
			}else{
				$flag=0;
				$id=$list['id'];
				$this->product_model->update_best_seller($id, $flag);
			}	
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function featured_precedence(){
		$this->data['product'] = $this->product_model->get_featured_product();
		$this->data['content']='admin/product/featured_product_precedence';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function update_featured_precedence(){
		$this->product_model->null_featured_precedence();
		$all_data=$this->input->post('table-1');
		
		$no=count($all_data);
		if($all_data)foreach($all_data as $list){
			$database=array('featured_precedence'=>$no);
			$where =array('id'=>$list);
			$this->general_model->update_data('product_tb',$database,$where);	
			$no--;		
		}
	}
	
	function collection(){
		$this->data['collection']=$this->product_model->get_all_collection();
		$this->data['content']='admin/product/collection_list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add_collection(){
		$name = $this->input->post('name');
		$this->product_model->add_collection($name);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function do_edit_collection(){
		$id = $this->input->post('id');
		$name = $this->input->post('edit_name');
		$this->product_model->edit_collection($id, $name);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_collection($id){
		$this->product_model->set_collection_id_to_0($id);
		
		$this->product_model->delete_collection($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function view_collection_product($id){
		$this->data['product'] = $this->product_model->get_product_with_no_collection();
		$this->data['collection_product'] = $this->product_model->get_product_with_collection($id);
		$this->data['content']='admin/product/product_collection_list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add_collection_product($collection_id){
		if(!$_POST) redirect($_SERVER['HTTP_REFERER']);
		
		$id = $this->input->post('id');
		foreach($id as $list){
			$this->product_model->update_product_collection_id($list, $collection_id);
		}
		
		$this->session->set_flashdata('notif_add', 1);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function update_collection_sku(){
		if(!$_POST) redirect($_SERVER['HTTP_REFERER']);
		
		$id = $this->input->post('id');
		if($id) foreach($id as $list){
			$sku_code = $this->input->post('sku_'.$list);
			$product_id = $list;
			$this->product_model->update_sku_code($product_id, $sku_code);
		}
		
		$this->session->set_flashdata('notif_update', 1);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function remove_product_collection($id){
		$this->product_model->remove_product_collection($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function do_add_sale_schedule(){
		$start = strtotime($this->input->post('start'));
		$end = strtotime($this->input->post('end'));
		
		$start_time = date('Y-m-d H:i:s', $start);
		$end_time = date('Y-m-d H:i:s', $end);
		$active=1;
		
		$this->load->model('general_model');
		$this->general_model->truncate_data('product_sale_schedule_tb');
		
		$this->product_model->insert_sale_schedule($start_time, $end_time, $active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	//export import product price
	function download_csv_price(){
		$this->load->model('product_model');
		$detail=$this->product_model->get_product_list_price();
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=TorioProduct.csv');
		$output = fopen('php://output', 'w');
		fputcsv($output,array('SKU Code','Product Name', 'Price (MSRP)', 'Discount (in %)', 'Active/Inactive'));
		if ($detail) foreach ($detail as $list){
			fputcsv($output,array($list['sku_code'],$list['name'], $list['msrp'], $list['discount'], $list['active']));
		}
	}
	
	function upload_csv_price(){
		$this->load->model('product_model');

		$config['upload_path'] = "userdata/product/csv/";
		$config['allowed_types'] = 'csv'; //csv
		$config['encrypt_name'] = TRUE;
		
		$this->load->library('upload', $config);
		
		if($this->upload->do_upload('attachment')){
			$data=$this->upload->data();
			$attachment = $data['file_name'];
		}
		else
		{
			echo $this->upload->display_errors();
			exit();
		}

		//echo $this->upload->display_errors();
		$path = "userdata/product/csv/".$attachment;
		$data_entries=array();
		$row = 0;
		if (($handle = fopen($path, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$row++;
				if($row>1){
					//if($data[0]!=0){
						$data_entries[] = $data;
					//}
				}
			}
		fclose($handle);
		}
		
		if($data_entries)foreach($data_entries as $list){
			
			$sku_code = $list[0];
			$product_name = $list[1];
			$msrp = $list[2];
			$discount = $list[3];
			$active = $list[4];
			
			$product_id = 0;
			if($sku_code!=''){
				$product_id = find_2('id', 'sku_code', $sku_code, 'product_tb');
			}else{
				$product_id = find_2('id', 'name', $product_name, 'product_tb');
			}
			
			if($product_id!=0){
				if($discount!=0){
					$price = $msrp-($msrp*$discount/100);
					$sale_flag = 1;
				}
				else{
					$price = $msrp;
					$sale_flag = 0;
				}
				
				$data = array(
					'msrp'=>$msrp,
					'discount'=>$discount,
					'price'=>$price,
					'sale_product'=>$sale_flag
				);
				
				$where = array('id'=>$product_id);
				$this->general_model->update_data('product_tb', $data, $where);
			}
		}
		
		unlink("userdata/product/csv/".$attachment);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>