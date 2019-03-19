<?php if(!defined('BASEPATH')) exit("Hacking Attempt?");
class View_campaign extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
		
	function index(){
		$this->load->model('cronjob_model');
		$detail=$this->cronjob_model->get_active_campaign();
		$mailchimpapi=$this->cronjob_model->get_mailchip_api();
		$mailchimpid=$this->cronjob_model->get_mailchip_id();
		$options=array(
			'view'=>'preview'
		);
		require_once 'MailChimp.class.php';
		$MailChimp = new MailChimp($mailchimpapi['value']);
		$_params = array("apikey"=>$mailchimpapi['value'], "cid" => $detail['campaign_id'],"options"=>$options);
		$temp = $MailChimp->call('campaigns/content',$_params);
		echo $temp->html;
	}
}