<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Faq extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('general_model');
		$this->load->model('faq_model');
		$this->load->model('employee_model');
		$this->faq_1 = "faq/list";
        $this->faq_2 = "faq/add";
        $this->faq_3 = "faq/edit";
        $this->faq_4 = "faq/delete";
	
	}
	
	function index($search=null){	
		$this->data['department'] = $this->employee_model->show_department();
		$this->data['faq_1']=$this->faq_1;
		$this->data['faq_2']=$this->faq_2;
		$this->data['faq_3']=$this->faq_3;
		$this->data['faq_4']=$this->faq_4;
		$employee_id=$this->session->userdata('employee_id');
		$departemen_id=$this->session->userdata('admin_departemen_id');
		$status=$this->input->post('status');
		$search=$this->input->post('search');
		$departemen=$this->input->post('departemen');
		$admin_id=$this->session->userdata('admin_id');
		if($status!=1){
			if($employee_id=='0'){
				$this->data['faq_list']=$this->faq_model->show_faq();
				//$dept_id=$departemen;
				//$this->data['faq_list']=$this->faq_model->show_faq_by_departemen2($dept_id);
			}else{
				$this->data['faq_list']=$this->faq_model->show_faq_by_departemen2($departemen_id,$admin_id);
			}
		}else{
			
			if($employee_id=='0'){
				//$this->data['faq_list']=$this->faq_model->show_faq_by_search($search);
				$dept_id=$departemen;
				$this->data['faq_list']=$this->faq_model->show_faq_by_departemen_search2($dept_id,$search,$admin_id);
			}else{
				$this->data['faq_list']=$this->faq_model->show_faq_by_departemen_search2($departemen_id,$search,$admin_id);
			}
		
		}
		$this->data['status']=$status;
		$this->data['search']=$search;
		$this->data['departemen']=$departemen;
		$this->data['page'] = 'faq/list';
		$this->load->view('common/body', $this->data);	
	}
	
	
	function add(){
			
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module",$this->faq_2,"privilege_tb")){
			$this->data['category']=$this->faq_model->show_faq_category();
			$this->data['department'] = $this->employee_model->show_department();
			$this->data['page'] = 'faq/add';
			$this->load->view('common/body', $this->data);	
		}else{
			redirect('home');
		}
	
	}
	function do_add(){

		$category=$this->input->post('category');
		//$departemen=$this->input->post('departemen');
		$newdate=date("Y-m-d H:i:s");
		$admin_id=$this->session->userdata('admin_id');
		$name=$this->input->post('title');
		$question=$this->input->post('question');
		$answer=$this->input->post('answer');
		$active=$this->input->post('active');
		$department_id=json_encode($this->input->post('department_id'));
		
		
		
		$database=array('name'=>$name,
						'category_id'=>$category,
						'departemen_id'=>$department_id,
						'question'=>$question,
						'answer'=>$answer,
						'active'=>$active,
						'created_date'=>$newdate,
						'created_by'=>$admin_id);
		$this->general_model->insert_data('faq_tb',$database);
		redirect('faq');
	
	}
	function edit($id){
		if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module",$this->faq_3,"privilege_tb")){
			$this->data['detail']=$this->faq_model->show_faq_by_id($id);
			$this->data['category']=$this->faq_model->show_faq_category();
			$this->data['department'] = $this->employee_model->show_department();
			$this->data['page'] = 'faq/edit';
			$this->load->view('common/body', $this->data);	
		}else{
			redirect('home');
		}
	}
	function do_edit($id){
		$newdate=date("Y-m-d H:i:s");
		$category=$this->input->post('category');
		//$departemen=$this->input->post('departemen');
		$admin_id=$this->session->userdata('admin_id');
		$name=$this->input->post('title');
		$question=$this->input->post('question');
		$answer=$this->input->post('answer');
		$active=$this->input->post('active');
		$department_id=json_encode($this->input->post('department_id'));
		$database=array('name'=>$name,
						'question'=>$question,
						'category_id'=>$category,
						'departemen_id'=>$department_id,
						'answer'=>$answer,
						'active'=>$active,
						'last_updated_date'=>$newdate,
						'last_updated_by'=>$admin_id);
		$this->general_model->update_data('faq_tb',$database,array('id'=>$id));
		redirect('faq');
	}
	
	function delete($id){
		$this->general_model->delete_data('faq_tb',array('id'=>$id));
		redirect('faq');
	}
	
	function category(){
			$this->data['faq_list']=$this->faq_model->show_faq_category();
			$this->data['page'] = 'faq/categorylist';
			$this->load->view('common/body', $this->data);	
	}
	function add_category(){
			$this->data['page'] = 'faq/categoryadd';
			$this->load->view('common/body', $this->data);	
	}
	function do_add_category(){
		$title=$this->input->post('title');
		$database=array('title'=>$title);
		$this->general_model->insert_data('faq_category_tb',$database);
		redirect('faq/category');
	}
	
	function edit_category($id){
			$this->data['detail']=$this->faq_model->show_faq_category_by_id($id);
			$this->data['page'] = 'faq/categoryedit';
			$this->load->view('common/body', $this->data);	
	}
	
	function do_edit_category($id){
		$title=$this->input->post('title');
		$database=array('title'=>$title);
		$this->general_model->update_data('faq_category_tb',$database,array('id'=>$id));
		redirect('faq/category');
	}
	function delete_category($id){
		$this->general_model->delete_data('faq_category_tb',array('id'=>$id));
		redirect('faq/category');
	}

	
	
}