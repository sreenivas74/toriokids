<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('Bitly');
		$this->load->model('category_model');
		$this->load->model('product_model');
		$this->load->model('shopping_cart_model');
		$this->load->model('advertisement_model','adv');
		$this->data['advertisement']=$this->adv->get_active_advertisement_list();
		$this->data['page_title']="";
		
		
		$this->load->model('template_model');
		$this->data['template']=$this->template_model->get_template_name_list_active();
		
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

		$this->data['page']='best_seller';
		$this->data['page_title'].="Best Seller Items";
		$this->load->library('pagination');
		$total_item=$this->data['total_best_seller'];
		$config['base_url'] = site_url('product/best_seller');
		$config['total_rows'] = $total_item;
		$config['per_page'] = 12;
		$config['uri_segment'] = 3;
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
		
		$this->data['product'] = $this->product_model->get_best_seller_paging($offset, $num);
		$this->data['pagination'] = $this->pagination->create_links();
		
		
		$this->data['content'] = 'content/best_seller';
		$this->load->view('common/body', $this->data);	
	}
	
	function sale(){
		$this->data['page']='sale';
		$this->data['page_title'].="Sale Items";
		
		//check flash sale
		$current_time = date('Y-m-d H:i:s');
		$flash_sale = array();
		$sale_array = array();
		$flash_sale_type = 0;
		$flash_sale = $this->data['flash_sale'] = $this->sale_model->get_sale_by_time($current_time);
		if($flash_sale) foreach($flash_sale as $list){
			$sale_product = $this->sale_model->get_item_by_flash_sale_id($list['id']);
			if($sale_product) foreach($sale_product as $product)
			{
				array_push($sale_array, $product);
			}
		}
		
		if(!$sale_array){
			
			$this->load->library('pagination');
			$total_item=$this->data['total_sale'];
			$config['base_url'] = site_url('product/sale');
			$config['total_rows'] = $total_item;
			$config['per_page'] = 12;
			$config['uri_segment'] = 3;
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
			
			$this->data['product'] = $this->product_model->get_sale_paging($offset, $num);
			$this->data['pagination'] = $this->pagination->create_links();
			
			$this->load->model('content_page_model');
			$this->data['content_page']=$this->content_page_model->get_content_sale_page();
			$this->load->model('banner_model');
			$this->data['sale_banner']=$this->banner_model->get_active_sale_banner(); 
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
			$this->data['content'] = 'content/sale';
			$this->load->view('common/body', $this->data);	
		}
	}
	
	
	function view_product_per_category($alias)
	{
		$cat_name = find_2('name', 'alias', $alias, 'category_tb');
		$this->data['page_title'].="For ".$cat_name;
		//$this->data['product']=$this->product_model->get_active_product_list($cat_name);
		$this->data['cat']=$this->category_model->get_selected_category_data2($alias);
		$this->data['alias']=$alias;
		
		
		$cat_id=get_alias_id('category_tb',$alias);
		
		$this->load->library('pagination');
		$total_item=$this->product_model->count_get_active_product_list($cat_id);
		$config['base_url'] = site_url('product/view_product_per_category').'/'.$alias;
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
	
	function view_product_detail($alias='')
	{
		if(!$alias)redirect('not_found');
		$id = find_2('id', 'alias', $alias, 'product_tb');
		if(!$id)redirect('not_found');
		$product_detail=$this->data['product']=$this->product_model->get_selected_product_data3($id);
		if(!$product_detail)redirect('not_found');
		
		$product_name=$product_detail['name'];
		$url=site_url('product/view_product_detail').'/'.$product_detail['alias'];
		$this->input_add_on($id,$product_name);
		$this->data['bitly']=$this->bitly->shorten($url);
		$this->data['cat_al'] = strips($this->data['product']['category_name']);
		$cat_al = explode('/', $this->data['cat_al']);
		
		if($cat_al)foreach($cat_al as $ca){
			$this->data['cat']=$this->category_model->get_selected_category_data($ca);
			$this->data['sub_cat']=$this->category_model->get_selected_sub_category_data3($this->data['cat']['id']);	
		}
		
		$sca = strips($this->data['product']['sub_category_name']);
		$this->data['sub_cat_al'] = explode('/', $sca);
		$this->data['image']=$this->product_model->get_active_product_image_list2($id);
		$this->data['sku']=$this->product_model->get_sku_list($id);
		$this->data['related']=$this->product_model->get_selected_active_related_product($id);
		$this->data['fb_link']="https://www.facebook.com/dialog/feed?app_id=".APP_ID."&link=".urlencode(base_url())."&picture=".urlencode(base_url()."templates/images/logo.png")."&name=".urlencode("Torio Kids")."&description=".urlencode("I really love this ".$product_detail['name']." from TorioKids - ".$this->data['bitly'])."&redirect_uri=".urlencode(site_url('product/close_window'));
		$this->data['tw_link']=urlencode("I really love this ".$product_detail['name']." from TorioKids - ".$this->data['bitly']);
		
		
		$this->data['page_title'].=$this->data['product']['name'];
		
		$this->data['content'] = 'content/product_detail';
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
}