<?php if(!defined('BASEPATH')) exit("Hacking Attempt?");
class Test_campaign extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
		
	function index(){
		if(!$_POST['email']) redirect('torioadmin/campaign');
		
		$this->load->model('cronjob_model');
		$detail=$this->cronjob_model->get_active_campaign();
		$mailchimpapi=$this->cronjob_model->get_mailchip_api();
		$mailchimpid=$this->cronjob_model->get_mailchip_id();
		$email = $this->input->post('email');
		$test_email = explode(';', $email);
		
		require_once 'MailChimp.class.php';
		$MailChimp = new MailChimp($mailchimpapi['value']);
		$_params = array("apikey"=>$mailchimpapi['value'], "cid" => $detail['campaign_id'],"test_emails"=>$test_email, 'send_type'=>"html");
		$temp = $MailChimp->call('campaigns/send-test',$_params);
		redirect($_SERVER['HTTP_REFERER']);
	}
}