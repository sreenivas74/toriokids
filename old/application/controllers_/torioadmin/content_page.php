<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Content_page extends CI_Controller {
	function __construct(){
		parent::__construct();
		if($this->session->userdata('admin_logged_in')==FALSE)redirect('torioadmin/login');	
		$this->load->model('content_page_model');
	}
	
	function index()
	{
		$this->data['detail']=$this->content_page_model->get_content_page_data();
		$this->data['content']='admin/content_page/content_page_list';
		$this->load->view('common/admin/body',$this->data);
	} 
	
	function add()
	{
		$this->data['content']='admin/content_page/add';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function do_add()
	{
		$name = $this->input->post('name');
		$content = $this->input->post('content');
		$precedence = last_precedence('content_page_tb') + 1;
		$active = 1;
		$database = array(	'name'=>$name, 
							'content'=>$content,
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->content_page_model->insert_data('content_page_tb',$database);
		$id = mysql_insert_id();
		$alias = make_alias($name)."-".$id;
		$data = array ('alias'=>$alias);
		$this->content_page_model->update_data($id, $data, 'content_page_tb');
		redirect('torioadmin/content_page');
	}
	
	function add_image()
	{
		$image='';
		$config['upload_path'] = 'userdata/content';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['encrypt_name'] = TRUE; 
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('file'))
		{
			redirect($_SERVER['HTTP_REFERER']);
		}
		else
		{
			$data = $this->upload->data();
			$image = $data['file_name'] ; 
		}
		$array = array('filelink' => base_url()."userdata/content/".$image);
		echo stripslashes(json_encode($array));
	}
	
	function edit($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->content_page_model->get_selected_content_page_data($id);
		$this->data['content']='admin/content_page/edit';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function do_edit($id)
	{
		$name = $this->input->post('name');
		$alias = make_alias($name)."-".$id;
		$content = $this->input->post('content');
		$database = array(	'name'=>$name,
							'alias'=>$alias, 
							'content'=>$content );		
		$this->content_page_model->update_data($id,$database, 'content_page_tb');
		redirect('torioadmin/content_page');
	}
	
	function change_active_content_page($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$database = array('active'=>$active);
		$this->content_page_model->update_data($id,$database, 'content_page_tb');		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_content_page($id){
	
		$this->content_page_model->up_precedence_content_page($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_content_page($id){
	
		$this->content_page_model->down_precedence_content_page($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	//faq category
	function view_faq_category()
	{
		$this->data['detail']=$this->content_page_model->get_faq_category_data();
		$this->data['content']='admin/faq/category_list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function add_faq_category()
	{
		$this->data['content']='admin/faq/add_category';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function do_add_faq_category()
	{
		$name = $this->input->post('name');
		$precedence = last_precedence('faq_category_tb') + 1;
		$active = 1;
		$database = array(	'name'=>$name, 
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->content_page_model->insert_data('faq_category_tb',$database);
		redirect('torioadmin/content_page/view_faq_category');
	}
	
	function edit_faq_category($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->content_page_model->get_selected_faq_category_data($id);
		$this->data['content']='admin/faq/edit_category';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function do_edit_faq_category($id)
	{
		$name = $this->input->post('name');
		$database = array(	'name'=>$name);		
		$this->content_page_model->update_data($id,$database, 'faq_category_tb');
		redirect('torioadmin/content_page/view_faq_category');
	}
	
	function change_active_faq_category($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$database = array('active'=>$active);
		$this->content_page_model->update_data($id,$database, 'faq_category_tb');		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_faq_category($id)
	{
		$this->content_page_model->up_precedence_faq_category($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_faq_category($id)
	{
		$this->content_page_model->down_precedence_faq_category($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}		
	
	//faq
	function view_faq()
	{
		$category = $this->input->post('category');
		
		if($category!=""){
			if($category=="all"){
				$this->data['detail']=$this->content_page_model->get_faq_data();
			}else{
				$this->data['detail']=$this->content_page_model->get_faq_data2($category);
			}
			$this->data['cat']=$category;
		}else
		{
			$this->data['cat']="all";
			$this->data['detail']=$this->content_page_model->get_faq_data();
		}
		$this->data['category']=$this->content_page_model->get_faq_category_data();
		$this->data['content']='admin/faq/list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function add_faq()
	{
		$this->data['category']=$this->content_page_model->get_faq_category_data();
		$this->data['content']='admin/faq/add';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function do_add_faq()
	{
		$faq_category_id = $this->input->post('faq_category_id');
		$question = $this->input->post('question');
		$answer = $this->input->post('answer');
		$cek = last_precedence_flexible('precedence', 'faq_tb', 'faq_category_id', $faq_category_id);
		if($cek==NULL)
		{
			$precedence = 1;
		} else 
		{
			$precedence = $cek + 1;	
		}
		$active = 1;
		$database = array(	'faq_category_id'=>$faq_category_id, 
							'question'=>$question, 
							'answer'=>$answer,
							'precedence'=>$precedence,
							'active'=>$active );		
		$this->content_page_model->insert_data('faq_tb',$database);
		redirect('torioadmin/content_page/view_faq');
	}
	
	function edit_faq($id)
	{
		$this->data['id'] = $id;
		$this->data['category']=$this->content_page_model->get_faq_category_data();
		$this->data['detail']=$this->content_page_model->get_selected_faq_data($id);
		$this->data['content']='admin/faq/edit';
		$this->load->view('common/admin/body',$this->data);	
	}
	
	function do_edit_faq($id)
	{
		$faq_category_id = $this->input->post('faq_category_id');
		$question = $this->input->post('question');
		$answer = $this->input->post('answer');
		$faq_id = find('faq_category_id', $id, 'faq_tb');
		$cek = last_precedence_flexible('precedence', 'faq_tb', 'faq_category_id', $faq_category_id);
		if($faq_category_id==$faq_id)
		{
			$precedence = find('precedence', $id, 'faq_tb');
		}else
		{
			if($cek==NULL)
			{
				$precedence = 1;
			} else 
			{
				$precedence = $cek + 1;	
			}
		}
		
		$database = array(	'faq_category_id'=>$faq_category_id, 
							'question'=>$question,
							'answer'=>$answer,
							'precedence'=>$precedence, );		
		$this->content_page_model->update_data($id,$database, 'faq_tb');
		redirect('torioadmin/content_page/view_faq');
	}
	
	function change_active_faq($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$database = array('active'=>$active);
		$this->content_page_model->update_data($id,$database, 'faq_tb');		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_faq($id, $faq_category_id)
	{
		$this->content_page_model->up_precedence_faq($id, $faq_category_id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_faq($id, $faq_category_id)
	{
		$this->content_page_model->down_precedence_faq($id, $faq_category_id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}	
}