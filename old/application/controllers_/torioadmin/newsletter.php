<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Newsletter extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if ($this->session->userdata('admin_logged_in')==false) {
			redirect('torioadmin/login');
		}
		$this->load->model('newsletter_model');	
	}
	
	function index()
	{
		$this->data['newsletter']=$this->newsletter_model->newsletter_list();
		$this->data['content']='admin/newsletter/newsletter_list';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function inactive()
	{
		$this->data['newsletter']=$this->newsletter_model->newsletter_inactive();
		$this->data['content']='admin/newsletter/newsletter_inactive';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function active()
	{
		$this->data['newsletter']=$this->newsletter_model->newsletter_active();
		$this->data['content']='admin/newsletter/newsletter_active';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function download_csv_form()
	{
		$newsletter_list=$this->newsletter_model->newsletter_list();
		
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=Newsletter List.csv');
		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		fputcsv($output,array('no' ,'email'));
		if ($newsletter_list) foreach ($newsletter_list as $list){
			
			fputcsv($output, $list);
		}
		fputcsv($output,array());		
	}
	
	function download_csv_form_active()
	{
		$newsletter_list=$this->newsletter_model->newsletter_active();
		
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=Newsletter List.csv');
		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		fputcsv($output,array('no' ,'email'));
		if ($newsletter_list) foreach ($newsletter_list as $list){
			
			fputcsv($output, $list);
		}
		fputcsv($output,array());		
	}
	
	function download_csv_form_inactive()
	{
		$newsletter_list=$this->newsletter_model->newsletter_inactive();
		
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=Newsletter List.csv');
		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		fputcsv($output,array('no' ,'email'));
		if ($newsletter_list) foreach ($newsletter_list as $list){
			
			fputcsv($output, $list);
		}
		fputcsv($output,array());		
	}
	
	function active2($id,$active)
	{
		if($active==1){
			$active=0;	
		}else{
			$active=1;	
		}
		$this->newsletter_model->active($id,$active);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete($id)
	{
		$this->newsletter_model->delete_newsletter($id);
		redirect($_SERVER['HTTP_REFERER']);
	}

}
