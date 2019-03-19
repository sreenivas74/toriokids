<?php if(!defined('BASEPATH')) exit("Hacking Attempt?");
class Send_campaign extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
		
	function index(){
		$this->load->model('cronjob_model');
		$detail=$this->cronjob_model->get_active_campaign();
		$mailchimpapi=$this->cronjob_model->get_mailchip_api();
		$mailchimpid=$this->cronjob_model->get_mailchip_id();
		require_once 'MailChimp.class.php';
		$MailChimp = new MailChimp($mailchimpapi['value']);
		$_params = array('apikey'=>$mailchimpapi['value'], "cid" => $detail['campaign_id']);
		/*echo "<pre>";
		print_r($MailChimp->call('campaigns/send',$_params));
		echo "</pre>";*/
		
		$MailChimp->call('campaigns/send',$_params);
		
		$this->cronjob_model->set_sent_flag($detail['id']);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
}