<?php if(!defined('BASEPATH')) exit("Hacking Attempt?");
class Delete extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
		
	function index(){
		$this->load->model('cronjob_model');
		$delete=$this->cronjob_model->get_delete_mailinglist();
		$mailchimpapi=$this->cronjob_model->get_mailchip_api();
		$mailchimpid=$this->cronjob_model->get_mailchip_id();
		require_once 'MailChimp.class.php';
		$MailChimp = new MailChimp($mailchimpapi['value']);
		$id = $mailchimpid['value'];
		if($delete)foreach($delete as $list){
			//print_r($list);
			$delete = true;
			$goobye = false;
			$notify = false;
			
			$batch[] = array('email'=>$list['email_address'],'euid' =>$list['euid'],'leid'=>$list['leid']);
			$this->cronjob_model->update_delete_mailinglist($list['id']);
		}
			$_params = array ('id' => $id , 'batch' => $batch , 'delete_member' => $delete , 'send_goodbye' => $goobye , 'send_notify' => $notify);
			
			echo "<pre>";
			print_r($_params);
			print_r($MailChimp->call('lists/batch-unsubscribe',$_params));
			echo "</pre>";
			}
	
}