<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Template extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
		$this->load->model('template_model');	
	}
	
	function index()
	{
		$this->data['template']=$this->template_model->get_template_name_list();
		$this->data['content']='admin/template/template_list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function view_template_size($name_id)
	{
		$this->data['template']=$this->template_model->get_template_size_list($name_id);
		$this->data['content']='admin/template/template_size_list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function add_template()
	{	
		$this->data['content']='admin/template/add_template';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add_template()
	{	
		$name = $this->input->post('name');
		$size = $this->input->post('size');
		$precedence = last_precedence('template_name_tb') + 1;
		$this->template_model->insert_template_name($name, $precedence);
		
		$name_id = mysql_insert_id();
		$alias = make_alias($name)."_".$name_id;
		$this->template_model->update_alias($name_id, $alias);
		
		
		$total_size = count($size);
		for($i=0; $i<$total_size; $i++){
			$cek = last_precedence_flexible('precedence', 'template_size_tb', 'template_name_id', $name_id);
			if($cek==NULL)
			{
				$precedence_size = 1;
			} else 
			{
				$precedence_size = $cek + 1;	
			}
			$this->template_model->insert_template_size($name_id, $size[$i], $precedence_size);
		}	
		
		
		
		
		redirect('torioadmin/template');
	}
	
	function edit_template_name($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->template_model->get_selected_template_name_data($id);
		$this->data['content']='admin/template/edit_template_name';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function add_template_size($name_id)
	{	
		$this->data['name_id'] = $name_id;
		$this->data['content']='admin/template/add_template_size';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add_template_size($name_id)
	{	
		$size = $this->input->post('size');
		$cek = last_precedence_flexible('precedence', 'template_size_tb', 'template_name_id', $name_id);
		if($cek==NULL)
		{
			$precedence = 1;
		} else 
		{
			$precedence = $cek + 1;	
		}
		$this->template_model->insert_template_size($name_id, $size, $precedence);
		redirect('torioadmin/template/view_template_size'.'/'.$name_id);
	}
	
	function edit_template_size($id)
	{
		$this->data['id'] = $id;
		$this->data['detail']=$this->template_model->get_selected_template_size_data($id);
		$this->data['content']='admin/template/edit_template_size';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit_template_name($id)
	{
		$name = $this->input->post('name');
		$this->template_model->update_template_name($id, $name);
		
		
		$alias = make_alias($name)."_".$id;
		$this->template_model->update_alias($id, $alias);
		
		redirect('torioadmin/template');
	}
	
	function do_edit_template_size($id)
	{
		$size = $this->input->post('size');
		$name_id = $this->template_model->get_selected_template_size_data($id);
		$this->template_model->update_template_size($id, $size);
		redirect('torioadmin/template/view_template_size'.'/'.$name_id['template_name_id']);
	}
	
	function up_precedence_template_name($id){
	
		$this->template_model->up_precedence_template_name($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function up_precedence_template_size($id){
	
		$this->template_model->up_precedence_template_size($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_template_name($id){
	
		$this->template_model->down_precedence_template_name($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}	
	
	function down_precedence_template_size($id){
	
		$this->template_model->down_precedence_template_size($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}	
	
	
	function active_template($id, $active)
	{
		if($active == 0) $active = 1; else $active = 0;
		$this->template_model->update_active($id,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
}
?>