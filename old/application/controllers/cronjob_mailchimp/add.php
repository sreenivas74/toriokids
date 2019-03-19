<?php if(!defined('BASEPATH')) exit("Hacking Attempt?");
class Add extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
		
	function index(){
		$this->load->model('cronjob_model');
		$new=$this->cronjob_model->get_new_mailinglist();
		$mailchimpapi=$this->cronjob_model->get_mailchip_api();
		$mailchimpid=$this->cronjob_model->get_mailchip_id();
		require_once 'MailChimp.class.php';
		$MailChimp = new MailChimp($mailchimpapi['value']);
		$id = $mailchimpid['value'];
		if($new)foreach($new as $list){
			//print_r($list);
			$email = array('email'=>$list['email_address'],'euid' => '','leid'=>'');
			$emailType = 'html';
			$mergeVar = array ('EMAIL' => $list['email_address'],'FNAME' => $list['first_name'],'LNAME' => $list['last_name']);
			print_r($mergeVar);
			//$email2 = array('email'=>'matthew@isysedge.com','euid' => '4b551b7d6c','leid'=>'75716029');
			$batchProtoype = array ('email' => $email , 'email_type' => $emailType , 'merge_vars' => $mergeVar);
			$batch[] = $batchProtoype;
		}
			if($batch){
				$optin = false;
				$up_exist = true;
				$replace_int = false;
				$_params = array ('id' => $id , 'batch' => $batch , 'double_optin' => $optin , 'update_existing' => $up_exist , 'replace_interests' => $replace_int);
				print_r($_params);
				echo "<pre>";
				$mail=$MailChimp->call('lists/batch-subscribe',$_params);
				print_r($mail);//$id,$batch,$optin,$up_exist,$replace_int);
				
				echo "</pre>";
				$update_list=$mail->adds;
				
				if($update_list)foreach($update_list as $list2){
					pre($list2);
						$this->cronjob_model->update_mailinglist($list2->euid,$list2->leid,$list2->email);
				}
				
			}

	}
}