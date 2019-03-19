<?php if(!defined('BASEPATH')) exit("Hacking Attempt?");
class Schedule_campaign extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
		
	function index(){
		if(!$_POST['schedule_time']) redirect('mudpieadmin/campaign');
		
		$this->load->model('cronjob_model');
		$detail=$this->cronjob_model->get_active_campaign();
		$mailchimpapi=$this->cronjob_model->get_mailchip_api();
		$mailchimpid=$this->cronjob_model->get_mailchip_id();
		$schedule_time = strtotime($_POST['schedule_time']);
		$schedule_time_campaign = date('Y-m-d H:i:s', $schedule_time-7*60*60);
		if($schedule_time) $this->cronjob_model->update_schedule_time($detail['id'], $schedule_time);
		#echo $schedule_time."<br>";
		#echo date('Y-m-d H:i:s', $schedule_time)."<br>";
		#echo $schedule_time_campaign;
		
		require_once 'MailChimp.class.php';
		$MailChimp = new MailChimp($mailchimpapi['value']);
		$_params = array("apikey"=>$mailchimpapi['value'], "cid" => $detail['campaign_id'],"schedule_time"=>$schedule_time_campaign);
		/*echo "<pre>";
		print_r($MailChimp->call('campaigns/schedule',$_params));
		echo "</pre>";*/
		
		$MailChimp->call('campaigns/schedule', $_params);
		
		$this->cronjob_model->set_sent_flag($detail['id']);
		
		redirect($_SERVER['HTTP_REFERER']);
		
	}
}