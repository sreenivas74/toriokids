<?php if(!defined('BASEPATH')) exit("Hacking Attempt?");
class Unschedule_campaign extends CI_Controller{
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
		$_params = array("apikey"=>$mailchimpapi['value'], "cid" => $detail['campaign_id']);
		
		$MailChimp->call('campaigns/unschedule', $_params);
		
		$this->cronjob_model->unset_sent_flag($detail['id']);
		$this->cronjob_model->update_schedule_time($detail['id'], 0);
		
		redirect($_SERVER['HTTP_REFERER']);
		
	}
}