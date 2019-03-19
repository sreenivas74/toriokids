<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class New_arrivals extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('category_model');
		$this->load->model('product_model');
		$this->load->model('advertisement_model','adv');
		$this->data['advertisement']=$this->adv->get_active_advertisement_list();
		$this->data['page_title']="";
		$this->data['page']='new_arrivals';
		$this->load->model('template_model');
		$this->data['template']=$this->template_model->get_template_name_list_active();
	}
	
	function index(){
		$this->page();	
	}
	
	function page(){
		$this->data['page_title']="New Arrivals";
		$this->load->library('pagination');
		$total_item=$this->product_model->count_new_arrival();
		$config['base_url'] = site_url('new_arrivals/page');
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
		
		$this->data['product'] = $this->product_model->get_all_new_arrival( $offset, $num);
		$this->data['pagination'] = $this->pagination->create_links();
		
		
		
		$this->data['content'] = 'content/new_arrivals';
		$this->load->view('common/body', $this->data);	
	}	
}