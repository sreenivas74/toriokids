<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Secondary_menu extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('secondary_menu_model');	
		$this->load->model('content_page_model');
	}
	
	function index($cat=NULL)
	{
		$this->data['secondary_menu']=$this->secondary_menu_model->get_secondary_menu_list();
		$this->data['content']='admin/secondary_menu/secondary_menu_list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function add()
	{	
		$this->data['content_page']=$this->content_page_model->get_active_content_page_list();
		$this->data['content']='admin/secondary_menu/add_secondary_menu';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add()
	{	
		//$cat = $this->input->post('cat');
		//$category = $this->input->post('category');
		//$type = $this->input->post('type');
		//$content_alias = $this->input->post('content_alias');
		$link = $this->input->post('link');	
		$name = $this->input->post('name');		
		$cek = last_precedence('secondary_menu_tb');
		if($cek==NULL)
		{
			$precedence = 1;
		} else 
		{
			$precedence = $cek + 1;	
		}
		$active=1;
		$this->secondary_menu_model->insert_secondary_menu($name, $link, $active, $precedence);
		redirect('torioadmin/secondary_menu');
	}
	
	function edit($id)
	{
		$this->data['id'] = $id;
		//$this->data['cat']=$cat;
		$this->data['content_page']=$this->content_page_model->get_active_content_page_list();
		$this->data['detail']=$this->secondary_menu_model->get_selected_secondary_menu_data($id);
		$this->data['content']='admin/secondary_menu/edit_secondary_menu';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit($id)
	{
		//$cat = $this->input->post('cat');
		$name = $this->input->post('name');
		//$type = $this->input->post('type');
		//$content_alias = $this->input->post('content_alias');
		$link = $this->input->post('link');	
		$name = $this->input->post('name');	
		$this->secondary_menu_model->update_secondary_menu($id, $name, $link);
		redirect('torioadmin/secondary_menu');
	}
	
	function change_active_secondary_menu($id, $active, $cat)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->secondary_menu_model->update_active_secondary_menu($id, $active);
		redirect('torioadmin/secondary_menu');
	}
	
	function up_precedence_secondary_menu($id)
	{
		$this->secondary_menu_model->up_precedence_secondary_menu($id);
		redirect('torioadmin/secondary_menu');
	}
	
	function down_precedence_secondary_menu($id)
	{
		$this->secondary_menu_model->down_precedence_secondary_menu($id);
		redirect('torioadmin/secondary_menu');
	}	
	
	function delete($id){
		$this->secondary_menu_model->delete_secondary_menu($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>