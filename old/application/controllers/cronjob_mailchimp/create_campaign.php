<?php if(!defined('BASEPATH')) exit("Hacking Attempt?");
class Create_campaign extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
		
	function index(){
		$this->load->model('cronjob_model');
		$this->data['detail'] = $detail=$this->cronjob_model->get_active_campaign();
		$mailchimpapi=$this->cronjob_model->get_mailchip_api();
		$mailchimpid=$this->cronjob_model->get_mailchip_id();
		require_once 'MailChimp.class.php';
		$MailChimp = new MailChimp($mailchimpapi['value']);
		$id = $mailchimpid['value'];
		$type = 'regular';
		$options = array (
		"list_id" => $id, 
		"subject" =>  $detail['subject'],
		"from_email" => 'noreply@toriokids.com', //noreply@mudpie.co.id
		"from_name" => 'Torio Kids',
		"to_name" => '*|FNAME|*',
		"title" => $detail['title']
		);
		$this->data['description']=$detail['description'];
		$content = array (
			//'html' => $this->load->view('admin/temp_content',$this->data,true)
			//'html' => $this->load->view('content/email_template/campaign_template', $this->data, TRUE) //old version
			'html' => $this->load->view('content/email_template/campaign_template_2', $this->data, TRUE)
		);
		$_params = array("type" => $type, "options" => $options, "content" => $content);
		
		$mail=$MailChimp->call('campaigns/create',$_params);
		$campaign_id=$mail->id;
		
		$this->cronjob_model->update_campaignid($detail['id'],$campaign_id);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
}