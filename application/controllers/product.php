<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('Bitly');
		$this->load->model('category_model');
		$this->load->model('product_model');
		$this->load->model('shopping_cart_model');
		$this->load->model('advertisement_model','adv');
		$this->load->model('store_model');
		$this->load->model('store_logo_model');
		$this->load->model('channel_model');
		$this->load->model('footer_menu_model');
		$this->data['advertisement']=$this->adv->get_active_advertisement_list();
		$this->data['page_title']="";
		
		$this->data['channel']= $this->channel_model->get_channel_list_active();
		$this->data['store']= $this->store_model->get_store_list_active();
		$this->data['store_logo']= $this->store_logo_model->get_store_logo_list_active();
		$this->data['footer'] = $this->footer_menu_model->get_active_footer_menu_list();

		$this->load->model('template_model');
		$this->data['template']=$this->template_model->get_template_name_list_active();
		$this->load->model('secondary_menu_model');
		$this->data['secondary'] = $this->secondary_menu_model->get_active_secondary_menu_list();

		if($this->session->userdata('user_logged_in')){
			$user_id=$this->session->userdata('user_id');
			$this->data['cart_session']=$this->shopping_cart_model->get_shopping_cart_list_user2($user_id);
		}else{
			$session_id=session_id();
			$this->data['cart_session']=$this->shopping_cart_model->get_shopping_cart_list_guest2($session_id);
		}
		
	}
	
	function index()
	{
		redirect('home');
	}  
	
	function size(){
		
		$this->data['page']='size';
		
		$this->load->library('pagination');
		$alias=$this->uri->segment(3,0);
		$template_id=get_alias_id('template_name_tb',$alias);
		
		$total_item=$this->product_model->product_total_by_template($template_id);
		$config['base_url'] = site_url('product/size').'/'.$alias;
		$config['total_rows'] = $total_item;
		$config['per_page'] = 12;
		$config['uri_segment'] = 4;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['cur_tag_open'] = '<a class="selected" href="#">';
		$config['cur_tag_close'] = '</a>';
		
		$this->pagination->initialize($config);

		$offset = $this->uri->segment($config['uri_segment']);
		if (!$offset) $offset = 0;
		
		$num = $config['per_page'];
		
		$this->data['per_page']=$num;
		$this->data['curr_page'] = ceil(($offset)/$num)+1;
		
		$this->data['product'] = $this->product_model->get_product_by_template($template_id,$offset, $num);
		$this->data['pagination'] = $this->pagination->create_links();
		
		$detail=$this->data['template_detail']=$this->template_model->get_selected_template_name_data($template_id);
		
		$this->data['page_title'].=$detail['name'];
		$this->data['content'] = 'content/product_by_template';
		$this->load->view('common/body', $this->data);
	}
	
	
	function best_seller(){
		$best_seller = 1;
		$new_arrival1 = $this->input->get('new_arrival');
		$sale1 = $this->input->get('sale');
		$size1 = $this->input->get('size');
		$sub_category1 = $this->input->get('sub_category');
		if($new_arrival1){ $new_arrival=$new_arrival1; }else{ $new_arrival=""; }
		if($sale1){ $sale=$sale1; }else{ $sale=""; }
		if($size1){ $size=$size1; }else{ $size=""; }
		if($sub_category1){ $sub_category=$sub_category1; }else{ $sub_category=""; }

		$this->data['page']='best_seller';
		$this->data['page_title'].="Best Seller Items";
		$this->load->library('pagination');

		$this->data['total_best_seller']=$this->product_model->get_best_seller_total($sub_category,$new_arrival,$sale,$size);
		$total_item=$this->data['total_best_seller'];

		$config['base_url'] = site_url('product/best_seller');
		$config['total_rows'] = $total_item;
		$config['per_page'] = 12;
		$config['uri_segment'] = 3;
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '>&nbsp;&nbsp;&nbsp;Next';
		$config['prev_link'] = 'Previous&nbsp;&nbsp;&nbsp;<';
		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
		//$config['page_query_string'] = TRUE;
		if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");

		$config['cur_tag_open'] = '<li><a class="recentPage" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$this->pagination->initialize($config);

		$offset = $this->uri->segment($config['uri_segment']);
		if (!$offset) $offset = 0;
		
		$num = $config['per_page'];
		
		$this->data['per_page']=$num;
		$this->data['curr_page'] = ceil(($offset)/$num)+1;
		
		$this->data['product'] = $this->product_model->get_best_seller_paging($offset, $num,$sub_category,$new_arrival,$sale,$size);
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->data['size']=$size;
		$this->data['best_seller']=$best_seller;
		$this->data['new_arrival']=$new_arrival;
		$this->data['sale']=$sale;
		$this->data['sub_category2']=$sub_category1;

		$this->data['content'] = 'content/best_seller';
		$this->load->view('common/body', $this->data);	
	}
	
	function sale(){
		$best_seller1 = $this->input->get('best_seller');;
		$new_arrival1 = $this->input->get('new_arrival');
		$sale1 = 1;
		$size1 = $this->input->get('size');
		$sub_category1 = $this->input->get('sub_category');
		if($new_arrival1){ $new_arrival=$new_arrival1; }else{ $new_arrival=""; }
		if($best_seller1){ $best_seller=$best_seller1; }else{ $best_seller=""; }
		if($size1){ $size=$size1; }else{ $size=""; }
		if($sub_category1){ $sub_category=$sub_category1; }else{ $sub_category=""; }

		$this->data['page']='sale';
		$this->data['page_title'].="Sale Items";
		
		//check flash sale
		$current_time = date('Y-m-d H:i:s');
		$flash_sale = array();
		$sale_array = array();
		$flash_sale_type = 0;
		$flash_sale = $this->data['flash_sale'] = $this->sale_model->get_sale_by_time($current_time);
		if($flash_sale) foreach($flash_sale as $list){
			$sale_product = $this->sale_model->get_item_by_flash_sale_id($list['id'],$sub_category,$new_arrival,$best_seller,$size);
			if($sale_product) foreach($sale_product as $product)
			{
				array_push($sale_array, $product);
			}
		}

		// if($flash_sale){
		// 	$sale_type = $this->sale_model->get_sale_type();
		// 	if($sale_type)
		// 	{
		// 		$flash_sale_type = $sale_type['type'];
		// 	}
		// 	else
		// 	{
		// 		$flash_sale_type = 1;
		// 	}
		// }
		
		// $this->data['flash_sale_type']=$flash_sale_type;
		// $this->data['sale_array']=$sale_array;

		$this->data['total_sale']=$this->product_model->get_sale_total($sub_category,$new_arrival,$best_seller,$size);
		if(!$sale_array){
			
			$this->load->library('pagination');
			$total_item=$this->data['total_sale'];
			$config['base_url'] = site_url('product/sale');
			$config['total_rows'] = $total_item;
			$config['per_page'] = 12;
			$config['uri_segment'] = 3;
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '>&nbsp;&nbsp;&nbsp;Next';
			$config['prev_link'] = 'Previous&nbsp;&nbsp;&nbsp;<';
			$config['first_link'] = '';
			$config['last_link'] = '';

			$config['cur_tag_open'] = '<li><a class="recentPage" href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);

			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			
			$this->pagination->initialize($config);
	
			$offset = $this->uri->segment($config['uri_segment']);
			if (!$offset) $offset = 0;
			
			$num = $config['per_page'];
			
			$this->data['per_page']=$num;
			$this->data['curr_page'] = ceil(($offset)/$num)+1;
			
			$this->data['product'] = $this->product_model->get_sale_paging($offset, $num,$sub_category,$new_arrival,$best_seller,$size);
			$this->data['pagination'] = $this->pagination->create_links();
			
			$this->load->model('content_page_model');
			$this->data['content_page']=$this->content_page_model->get_content_sale_page();
			$this->load->model('banner_model');
			$this->data['sale_banner']=$this->banner_model->get_active_sale_banner();

			$this->data['size']=$size;
			$this->data['best_seller']=$best_seller;
			$this->data['new_arrival']=$new_arrival;
			$this->data['sale']=$sale1;
			$this->data['sub_category2']=$sub_category1;

			$this->data['content'] = 'content/sale';
			$this->load->view('common/body', $this->data);	
		}
		else
		{
			$product = array();
			$this->data['pagination'] = '';
			foreach($sale_array as $sale){
				$temp = $this->product_model->get_product_by_id_on_flash_sale($sale['product_id']);
				array_push($product, $temp);
			}
			
			$this->data['product'] = $product;
			$this->load->model('content_page_model');
			$this->data['content_page']=$this->content_page_model->get_content_sale_page();

			$this->data['size']=$size;
			$this->data['best_seller']=$best_seller;
			$this->data['new_arrival']=$new_arrival;
			$this->data['sale']=$sale1;
			$this->data['sub_category2']=$sub_category1;
			$this->data['content'] = 'content/sale';
			$this->load->view('common/body', $this->data);	
		}
	}
	
	
	function view_product_per_category($alias)
	{
		$cat_name = find_2('name', 'alias', $alias, 'category_tb');
		$cat_id = find_2('id', 'alias', $alias, 'category_tb');
		$this->data['page_title'].="For ".$cat_name;
		//$this->data['product']=$this->product_model->get_active_product_list($cat_name);
		$this->data['cat']=$this->category_model->get_selected_category_data2($alias);
		$this->data['sub_cat']=$this->category_model->get_menu_category_by($cat_id);
		$this->data['alias']=$alias;
		$this->data['cat_id']=$cat_id;
		
		
		$cat_id=get_alias_id('category_tb',$alias);
		
		$this->load->library('pagination');
		$total_item=$this->product_model->count_get_active_product_list($cat_id);
		$config['base_url'] = site_url('product/view_product_per_category').'/'.$alias;
		$config['total_rows'] = $total_item;
		$config['per_page'] = 12;
		$config['uri_segment'] = 4;
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '>&nbsp;&nbsp;&nbsp;Next';
		$config['prev_link'] = 'Previous&nbsp;&nbsp;&nbsp;<';
		$config['first_link'] = '';
		$config['last_link'] = '';

		$config['cur_tag_open'] = '<li><a class="recentPage" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$this->pagination->initialize($config);

		$offset = $this->uri->segment($config['uri_segment']);
		if (!$offset) $offset = 0;
		
		$num = $config['per_page'];
		
		$this->data['per_page']=$num;
		$this->data['curr_page'] = ceil(($offset)/$num)+1;
		
		
		$this->data['product'] = $this->product_model->get_active_product_list_paging($cat_id, $offset, $num);
		$this->data['pagination'] = $this->pagination->create_links();
		
		
		$this->data['content'] = 'content/main_product_list';
		$this->load->view('common/body', $this->data);		
	}
	
	function view_new_arrival($alias)
	{
		$cat_name = find_2('name', 'alias', $alias, 'category_tb');
		$this->data['page_title'].=$cat_name;
		//$this->data['product']=$this->product_model->get_active_new_product_list($cat_name);
		$this->data['cat']=$this->category_model->get_selected_category_data2($alias);
		$this->data['alias']=$alias;
		
		
		
		
		$this->load->library('pagination');
		$total_item=$this->product_model->count_active_new_product_list($cat_name);
		$config['base_url'] = site_url('product/view_new_arrival').'/'.$alias;
		$config['total_rows'] = $total_item;
		$config['per_page'] = 12;
		$config['uri_segment'] = 4;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['cur_tag_open'] = '<a class="selected" href="#">';
		$config['cur_tag_close'] = '</a>';
		
		$this->pagination->initialize($config);

		$offset = $this->uri->segment($config['uri_segment']);
		if (!$offset) $offset = 0;
		
		$num = $config['per_page'];
		
		$this->data['per_page']=$num;
		$this->data['curr_page'] = ceil(($offset)/$num)+1;
		
		$this->data['product'] = $this->product_model->get_active_new_product_list_paging($cat_name, $offset, $num);
		$this->data['pagination'] = $this->pagination->create_links();
		
		
		
		$this->data['content'] = 'content/new_arrival_list';
		$this->load->view('common/body', $this->data);		
	}
	
	function search()
	{
		//$search = $this->input->post('search');
		$search = $this->input->get('search');
		if($search==""){
			$this->data['alert']="*Please type your keyword for search";
			$this->data['page_title'].='Search Results for "'.$search.'"';
			$this->data['keyword']=$search;
			$this->data['product']='';
			$this->data['content'] = 'content/search_product';
			$this->load->view('common/body', $this->data);		
		}
		else {
			$this->data['alert']= "";
			$this->data['page_title'].='Search Results for "'.$search.'"';
			$temp = array();
			
			$query = "select p.*, tp.name as template_name from product_tb p
			left join template_name_tb tp on tp.id=p.template_id where p.active=1 AND p.name LIKE '%".esc($search)."%'";
				
				
		
			$this->data['keyword']=$search;
			$this->data['product']=$this->product_model->search_product($query);
			$this->data['content'] = 'content/search_product';
			$this->load->view('common/body', $this->data);	
		}
	}
	
	function view_product_per_sub_category($alias, $cat_id)
	{
		$this->data['cat_id'] = $cat_id;
		$sub_name=find_2('name', 'alias', $alias, 'sub_category_tb');
		$this->data['cat']=$this->category_model->get_selected_category_data($cat_id);
		$this->data['page_title'].=$sub_name.' For '.$this->data['cat']['name'];
		$this->data['sub_cat2']=$this->category_model->get_menu_category_by($cat_id);
//		$this->data['product']=$this->product_model->get_active_product_list2($sub_name, $this->data['cat']['name']);	
		$this->data['sub_cat']=$this->category_model->get_selected_sub_category_data2($alias);
		$this->data['alias']=$this->data['cat']['alias'];	
		
		
		$sub_id=get_alias_id('sub_category_tb',$alias);
		
		$this->load->library('pagination');
		$total_item=$this->product_model->count_active_product_list2($sub_id, $this->data['cat']['id']);
		$config['base_url'] = site_url('product/view_product_per_sub_category').'/'.$alias.'/'.$cat_id;
		$config['total_rows'] = $total_item;
		$config['per_page'] = 12;
		$config['uri_segment'] = 5;
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '>&nbsp;&nbsp;&nbsp;Next';
		$config['prev_link'] = 'Previous&nbsp;&nbsp;&nbsp;<';
		$config['first_link'] = '';
		$config['last_link'] = '';

		$config['cur_tag_open'] = '<li><a class="recentPage" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$this->pagination->initialize($config);

		$offset = $this->uri->segment($config['uri_segment']);
		if (!$offset) $offset = 0;
		
		$num = $config['per_page'];
		
		$this->data['per_page']=$num;
		$this->data['curr_page'] = ceil(($offset)/$num)+1;
		
		$this->data['sub_name'] = $sub_name;
		
		$this->data['product'] = $this->product_model->get_active_product_list2_paging($sub_id, $cat_id, $offset, $num);
		$this->data['pagination'] = $this->pagination->create_links();
		
		$this->data['content'] = 'content/sub_product_list';
		$this->load->view('common/body', $this->data);		
	}
	
	function product_detail(){
		$alias=$this->input->post('alias');
		$id = find_2('id', 'alias', $alias, 'product_tb');
		$this->data['product']=$this->product_model->get_selected_product_data($id);
		$this->data['sku']=$this->product_model->get_sku_list($id);
		$this->load->view('content/main_product_list_popup',$this->data);
		
	}
	
	function view_product_detail($alias='',$cat_id="",$sub_cat="")
	{
		if(!$alias)redirect('not_found');
		$id = find_2('id', 'alias', $alias, 'product_tb');
		if(!$id)redirect('not_found');
		$product_detail=$this->data['product']=$this->product_model->get_selected_product_data3($id);
		if(!$product_detail)redirect('not_found');
		
		$product_name=$product_detail['name'];
		// $url=site_url('product/view_product_detail').'/'.$product_detail['alias'];
		$this->input_add_on($id,$product_name);

		if($cat_id == "" && $sub_cat==""){
			$this->data['cat_name'] = "best_seller";
		}
		else if($sub_cat==""){
			$cat_name = find('name',$cat_id,'category_tb');
			$this->data['cat_name'] = $cat_name;
			$this->data['sub_cat_name'] = "";
		}
		else{
			$cat_name = find('name',$cat_id,'category_tb');
			$this->data['cat_name'] = $cat_name;

			$sub_cat_name = find('name',$sub_cat,'sub_category_tb');
			$this->data['sub_cat_name'] = $sub_cat_name;
		}
		// $this->data['bitly']=$this->bitly->shorten($url);
		$this->data['cat_al'] = strips($this->data['product']['category_name']);
		$cat_al = explode('/', $this->data['cat_al']);
		
		if($cat_al)foreach($cat_al as $ca){
			$this->data['cat']=$this->category_model->get_selected_category_data($ca);
			$this->data['sub_cat']=$this->category_model->get_selected_sub_category_data3($this->data['cat']['id']);	
		}
		
		$sca = strips($this->data['product']['sub_category_name']);
		$this->data['sub_cat_al'] = explode('/', $sca);
		$this->data['image']=$this->product_model->get_active_product_image_list2($id);
		$this->data['sku']=$this->product_model->get_sku_list_active($id);
		// pre($this->data['sku']);die;
		$this->data['related']=$this->product_model->get_selected_active_related_product($id);
		// $this->data['fb_link']="https://www.facebook.com/dialog/feed?app_id=".APP_ID."&link=".urlencode(base_url())."&picture=".urlencode(base_url()."templates/images/logo.png")."&name=".urlencode("Torio Kids")."&description=".urlencode("I really love this ".$product_detail['name']." from TorioKids - ".$this->data['bitly'])."&redirect_uri=".urlencode(site_url('product/close_window'));
		// $this->data['tw_link']=urlencode("I really love this ".$product_detail['name']." from TorioKids - ".$this->data['bitly']);
		
		$this->data['page_title'].=$this->data['product']['name'];
		$this->load->model('shipping_policy_model');
		$this->data['data'] = $this->shipping_policy_model->get_detail();
		$this->data['content'] = 'content/product_detail_prot';
		$this->load->view('common/body', $this->data);		
	}
	
	function close_window()
	{
		$this->load->view('content/close_window');
	}
	
	function input_add_on($product_id,$product_name){
	$data_input = array('domain_id'=>DOMAIN_ID,
						'product_id'=>$product_id,
						'product_name'=>$product_name,
						'date'=>date("Y-m-d H:i:s")
	); 
	
	/*if($data_input['domain_id']=='' || $data_input['product_id']=='' || $data_input['product_name']==''){
	exit();	
	}*/
	
	
	$ch = curl_init('http://loophole.isysedge.com/home/insert_sql/');
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $data_input);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,  CURLOPT_HTTPHEADER,  array(
	'Accept: text/xml,application/xml')
	);
	
						
		$result  =  curl_exec($ch);  
		//echo $result;
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	curl_close($ch);
	
	}
	
	function check_stock(){
		$id = $this->input->post('id');
		$sku_id = $id;
		$stock = find('stock', $id, 'sku_tb');
		
		if($this->session->userdata('user_logged_in')==true){
			$user_id=$this->session->userdata('user_id');
			$cart_list=$this->shopping_cart_model->check_quantity_cart($user_id, $sku_id);	
		}
		else{
			$session_id=session_id();
			$cart_list=$this->shopping_cart_model->check_quantity_cart2($session_id, $sku_id);
		}
		
		if(!$cart_list){
			$quantity=0;
		}else{
			$quantity=$cart_list['quantity'];
		}
		
		echo json_encode(array('stock'=>$stock, 'cart_qty'=>$quantity));
	}

	function filter(){
		$best_seller = $this->input->get('best_seller');
		$new_arrival = $this->input->get('new_arrival');
		$sale = $this->input->get('sale');

		$size = $this->input->get('size');
		//pre($size);exit;
		$sub_category1 = $this->input->get('category');
		$category_name = $this->input->get('category_name');

		//$this->data['cat_id'] = $cat_id;
		//$sub_name=find_2('name', 'alias', $alias, 'sub_category_tb');

		$category_id=find_2('id','name',$category_name, 'category_tb');
		//echo $category_id;exit;

		$this->data['cat']=$this->category_model->get_selected_category_data($category_id);
		$this->data['sub_cat']=$this->category_model->get_menu_category_by($category_id);
		$this->data['page_title'].='Filter For '.$this->data['cat']['name'];
//		$this->data['product']=$this->product_model->get_active_product_list2($sub_name, $this->data['cat']['name']);	
		//$this->data['sub_cat']=$this->category_model->get_selected_sub_category_data2($alias);
		//$this->data['alias']=$this->data['cat']['alias'];
		
		
		//$sub_id=get_alias_id('sub_category_tb',$alias);
		
		$this->load->library('pagination');
		$total_item=$this->product_model->count_filter_product($sub_category1, $category_id, $best_seller, $new_arrival, $sale, $size);
		$config['base_url'] = site_url('product/filter');
		$config['total_rows'] = $total_item;
		$config['per_page'] = 12;
		$config['uri_segment'] = 3;
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '>&nbsp;&nbsp;&nbsp;Next';
		$config['prev_link'] = 'Previous&nbsp;&nbsp;&nbsp;<';
		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
		//$config['page_query_string'] = TRUE;
		if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");

		$config['cur_tag_open'] = '<li><a class="recentPage" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$this->pagination->initialize($config);

		$offset = $this->uri->segment($config['uri_segment']);
		if (!$offset) $offset = 0;
		
		$num = $config['per_page'];
		
		$this->data['per_page']=$num;
		$this->data['curr_page'] = ceil(($offset)/$num)+1;

		$this->data['size']=$size;
		$this->data['best_seller']=$best_seller;
		$this->data['new_arrival']=$new_arrival;
		$this->data['sale']=$sale;
		$this->data['sub_category1']=$sub_category1;
		
		$this->data['product'] = $this->product_model->filter_get_active_product_list2_paging($sub_category1, $category_id, $best_seller, $new_arrival, $sale, $size, $offset, $num);
		$this->data['pagination'] = $this->pagination->create_links();
		//pre($this->data['product']);exit;
		$this->data['content'] = 'content/filter_product_list';
		$this->load->view('common/body', $this->data);
	}
}