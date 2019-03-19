<?php if(!defined('BASEPATH')) exit("Hacking Attempt?");
class Update_campaign extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
		
	function index(){
		$this->load->model('cronjob_model');
		$this->data['detail']=$detail=$this->cronjob_model->get_active_campaign();
		$mailchimpapi=$this->cronjob_model->get_mailchip_api();
		$mailchimpid=$this->cronjob_model->get_mailchip_id();
		
		$options = array (
		"subject" =>  $detail['subject'],
		"from_email" => 'noreply@mudpie.co.id', //noreply@mudpie.co.id
		"from_name" => 'Mavolin',
		"to_name" => '*|FNAME|*',
		"title" => $detail['title']
		);
		
		$content=array(
			'html' => $this->load->view('content/email_template/campaign_template', $this->data, TRUE)
		);
		require_once 'MailChimp.class.php';
		$MailChimp = new MailChimp($mailchimpapi['value']);
		$_params_content = array("apikey"=>$mailchimpapi['value'], "cid" => $detail['campaign_id'],"name"=>'content', 'value'=>$content);
		$_params_options = array("apikey"=>$mailchimpapi['value'], "cid" => $detail['campaign_id'],"name"=>'options', 'value'=>$options);
		
		$MailChimp->call('campaigns/update',$_params_content);
		$MailChimp->call('campaigns/update',$_params_options);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
}