<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Coupoun extends CI_Controller{
	
	function check_coupoun()
	{	
		$this->load->model('coupoun_model');	
		$coupoun=$this->input->post('fieldValue');	
		$fieldId=$this->input->post('fieldId');			
		$temp=$this->coupoun_model->get_voucher_list($coupoun);	
		if($temp)echo '["'.$fieldId.'",1]';
		else echo '["'.$fieldId.'",0]';
	}
	
}
?>