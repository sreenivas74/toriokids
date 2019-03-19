<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Footer_menu extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('footer_menu_model');	
		$this->load->model('content_page_model');
	}
	
	function index($cat=NULL)
	{
		if($this->input->post('category')){
		$category = $this->input->post('category');
		}else{
			$category = 4;
		}

		$this->data['footer_menu']=$this->footer_menu_model->get_footer_menu_list();

		if($cat)$this->data['cat']=$cat;
		else $this->data['cat']=$category;
		$this->data['content']='admin/footer_menu/footer_menu_list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function add()
	{	
		$this->data['content_page']=$this->content_page_model->get_active_content_page_list();
		$this->data['content']='admin/footer_menu/add_footer_menu';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add()
	{	
		//$cat = $this->input->post('cat');
		//$category = $this->input->post('category');
		$type = $this->input->post('type');
		$content_alias = $this->input->post('content_alias');
		$link = $this->input->post('link');	
		$name = $this->input->post('name');		
		$cek = last_precedence('footer_menu_tb');
		if($cek==NULL)
		{
			$precedence = 1;
		} else 
		{
			$precedence = $cek + 1;	
		}
		$active=1;
		$this->footer_menu_model->insert_footer_menu($name, $type, $content_alias, $link, $active, $precedence);
		redirect('torioadmin/footer_menu');
	}
	
	function edit($id)
	{
		$this->data['id'] = $id;
		//$this->data['cat']=$cat;
		$this->data['content_page']=$this->content_page_model->get_active_content_page_list();
		$this->data['detail']=$this->footer_menu_model->get_selected_footer_menu_data($id);
		$this->data['content']='admin/footer_menu/edit_footer_menu';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit($id)
	{
		//$cat = $this->input->post('cat');
		$name = $this->input->post('name');
		$type = $this->input->post('type');
		$content_alias = $this->input->post('content_alias');
		$link = $this->input->post('link');	
		$name = $this->input->post('name');	
		$this->footer_menu_model->update_footer_menu($id, $name, $type, $content_alias, $link);
		redirect('torioadmin/footer_menu');
	}
	
	function change_active_footer_menu($id, $active, $cat)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->footer_menu_model->update_active_footer_menu($id, $active);
		redirect('torioadmin/footer_menu');
	}
	
	function up_precedence_footer_menu($id)
	{
		$this->footer_menu_model->up_precedence_footer_menu($id);
		redirect('torioadmin/footer_menu');
	}
	
	function down_precedence_footer_menu($id, $category, $cat)
	{
		$this->footer_menu_model->down_precedence_footer_menu($id, $category);
		redirect('torioadmin/footer_menu/index/'.$cat);
	}	
	
	function delete($id){
		$this->footer_menu_model->delete_footer_menu($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>