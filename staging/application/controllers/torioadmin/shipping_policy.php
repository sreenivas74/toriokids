<?php if(!defined('BASEPATH')) exit('no direct script access allowed'); 
	class Shipping_policy extends CI_Controller {
		function __construct(){
			parent::__construct();
				if($this->session->userdata('admin_logged_in')==FALSE)
					redirect('torioadmin/login');		
		}

	function edit(){
		if($_POST){
			$id = $this->input->post('id');
			$shipping = $this->input->post('shipping');
			$policy = $this->input->post('policy');

			$this->db->update('shipping_policy_tb', array('shipping'=>$shipping, 'policy'=> $policy, 'updated_date'=>date('Y-m-d')), array('id'=>$id));
			// echo $id; die;
			redirect($_SERVER['HTTP_REFERER']);
		}
		$this->load->model('shipping_policy_model');
		$this->data['data'] = $this->shipping_policy_model->get_detail();
		$this->data['content'] = 'admin/s_policy/edit';
		$this->load->view('common/admin/body', $this->data);
	}
}