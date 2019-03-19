<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		session_start();
		self::$instance =& $this;
		
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		date_default_timezone_set('Asia/Jakarta'); 
		$this->load->model('category_model');
		$this->load->model('shopping_cart_model');
		$this->load->model('footer_menu_model');
		$this->load->model('content_page_model');
		$this->load->model('product_model');
		$this->load->model('discount_model');
		$this->load->model('sale_model');
		$this->load->model('countdown_model');
		$this->data['sku'] = $this->product_model->get_active_sku_list();
		$arr = array();
		foreach($this->data['sku'] as $list){
			array_push($arr, $list['id']);
		}
		
		$this->data['all_sku_id'] = json_encode($arr);
		
		//sale schedule
		$now3 = date('Y-m-d H:i:s');
		$schedule_core = $this->data['schedule_sale'] = $this->product_model->get_sale_schedule_by_time($now3);
		
		$this->data['help']=$this->footer_menu_model->get_active_help_list();
		$this->data['about_us']=$this->footer_menu_model->get_active_about_us_list();
		$this->data['connect_us']=$this->footer_menu_model->get_active_connect_us_list();
		$this->data['category']=$this->category_model->get_active_category_list();
		$this->data['sub_category']=$this->category_model->get_active_sub_category_list();
		$this->data['content_page']=$this->content_page_model->get_active_content_page_list2();
		$this->data['newsletter_email']="";
		$this->data['alias']="";
		if($this->session->userdata('user_logged_in')==false){
			$session_id=session_id();
			$cart = $this->shopping_cart_model->get_shopping_cart_list2($session_id);
			$total_diskon = $this->shopping_cart_model->get_total_value_guest($session_id);
			$price=0;
			$qty=0;
			for($i=0; $i<count($cart);$i++){
				if($cart[$i]['sale_id']==0)
				{
					if($schedule_core){
						$price=$price+$cart[$i]['sell_price']*$cart[$i]['quantity'];
					}
					else
					{
						$price=$price+$cart[$i]['msrp']*$cart[$i]['quantity'];
					}
				}
				else
				{
					$time = date('Y-m-d H:i:s');
					$check = $this->sale_model->check_promo($cart[$i]['sale_id'], $time);
					if($check)
					{
						$price=$price+$cart[$i]['price']*$cart[$i]['quantity'];
					}else
					{
						if($schedule_core){
							$price=$price+$cart[$i]['sell_price']*$cart[$i]['quantity'];
						}else{
							$price=$price+$cart[$i]['msrp']*$cart[$i]['quantity'];
						}
					}
				}
				$qty=$qty+$cart[$i]['quantity'];
			}
			$this->data['total_price'] = $price;
			$this->data['total_harga_diskon'] = $total_diskon;
			$this->data['total_item'] = $qty;
		}else{
			//user
			$user_id=$this->session->userdata('user_id');
			$cart = $this->shopping_cart_model->get_shopping_cart_list_user2($user_id);
			$total_diskon = $this->shopping_cart_model->get_total_value($user_id);
			$price=0;
			$qty=0;
			for($i=0; $i<count($cart);$i++){
				if($cart[$i]['sale_id']==0)
				{				
					if($schedule_core){
						$price=$price+$cart[$i]['sell_price']*$cart[$i]['quantity'];
					}else{
						$price=$price+$cart[$i]['msrp']*$cart[$i]['quantity'];
					}
				}
				else
				{	
					$time = date('Y-m-d H:i:s');
					$check = $this->sale_model->check_promo($cart[$i]['sale_id'], $time);
					if($check)
					{
						$price=$price+$cart[$i]['price']*$cart[$i]['quantity'];
					}else
					{
						if($schedule_core){
							$price=$price+$cart[$i]['sell_price']*$cart[$i]['quantity'];
						}else{
							$price=$price+$cart[$i]['msrp']*$cart[$i]['quantity'];
						}
					}
				}
				$qty=$qty+$cart[$i]['quantity'];
			}
		
			$this->data['total_price'] = $price;
			$this->data['total_item'] = $qty;
			$this->data['total_harga_diskon'] = $total_diskon;
		}
		
		//for discount cart (minimum purchase get discount)
		$time_now = date('Y-m-d');
		$this->data['discount_cart'] = $this->discount_model->get_current_discount_cart($time_now);
		
		//for flash sale
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
		
		
		if($flash_sale){
			$sale_type = $this->sale_model->get_sale_type();
			if($sale_type)
			{
				$flash_sale_type = $sale_type['type'];
			}
			else
			{
				$flash_sale_type = 1;
			}
		}
		
		$this->data['flash_sale_type']=$flash_sale_type;
		$this->data['sale_array']=$sale_array;
		
		//for countdown flash sale
		$difftime=0; $clock_end=0;
		if($flash_sale && $flash_sale_type==2){
			$sale_id = $flash_sale[0]['id'];
			$now = time();
			$start = strtotime(find('start_time',$sale_id,'flash_sale_tb'));
			$end = strtotime(find('end_time',$sale_id,'flash_sale_tb'));
			$difftime= $end-$now;
			$clock_end = $difftime;
			//$clock_end=date('Y/m/d H:i:s', strtotime(find('end_time',$sale_id,'flash_sale_tb')));
		}
		$this->data['diff']=$difftime;
		
		$this->data['clock_end']=$clock_end;
		
		$now2 = time(); $upcoming_time = 0; $upcoming_sale = '';
		if(!$clock_end){
			$upcoming_sale = $this->sale_model->get_upcoming_sale($current_time);
			//pre($upcoming_sale);
			if($upcoming_sale){
				$next_time = strtotime($upcoming_sale['start_time']);
				$temp_time = $next_time-$now2;
				if($temp_time > 0) $upcoming_time=$temp_time;
				
				if(!$flash_sale){
					$this->data['flash_sale_type']=2;
				}
			}
		}
		
		$this->data['upcoming_time'] = $upcoming_time;
		$this->data['upcoming_sale'] = $upcoming_sale;
		
		//for countdown module
		$upcoming_cd_time = 0;
		$upcoming_cd = $this->countdown_model->get_upcoming_countdown($current_time);
		//pre($upcoming_sale);
		if($upcoming_cd){
			$next_time_cd = strtotime($upcoming_cd['start_time']);
			$temp_time_cd = $next_time_cd-$now2;
			if($temp_time_cd > 0) $upcoming_cd_time=$temp_time_cd;
		}
		
		$this->data['upcoming_cd_time'] = $upcoming_cd_time;
		$this->data['upcoming_cd'] = $upcoming_cd;
		
		
		$this->data['total_best_seller']=$this->product_model->get_best_seller_total();
		$this->data['total_sale']=$this->product_model->get_sale_total();
		
		
		
		log_message('debug', "Controller Class Initialized");
	}

	public static function &get_instance()
	{
		return self::$instance;
	}
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */