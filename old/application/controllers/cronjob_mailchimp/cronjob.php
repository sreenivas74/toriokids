<?php if(!defined('BASEPATH')) exit("Hacking Attempt?");
class Cronjob extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	
	
	function index(){
		require_once 'MailChimp.class.php';
		$this->add();
		$this->edit();
		$this->delete();
		redirect($_SERVER['HTTP_REFERER']);
	}
	function add(){
		$this->load->model('cronjob_model');
		$new=$this->cronjob_model->get_new_mailinglist();
		$mailchimpapi=$this->cronjob_model->get_mailchip_api();
		$mailchimpid=$this->cronjob_model->get_mailchip_id();
		$MailChimp = new MailChimp($mailchimpapi['value']);
		$id = $mailchimpid['value'];
		$batch=array();
		if($new)foreach($new as $list){
			//print_r($list);
			$email = array('email'=>$list['email'],'euid' => '','leid'=>'');
			$emailType = 'html';
			$mergeVar = array ('EMAIL' => $list['email']);
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
					//pre($list2);
						$this->cronjob_model->update_mailinglist($list2->euid,$list2->leid,$list2->email);
				}
				
			}
	
	}
	function edit(){
		$this->load->model('cronjob_model');
		$synch=$this->cronjob_model->get_synch_mailinglist();
		
		$mailchimpapi=$this->cronjob_model->get_mailchip_api();
		$mailchimpid=$this->cronjob_model->get_mailchip_id();
		$MailChimp = new MailChimp($mailchimpapi['value']);
		$id = $mailchimpid['value'];
		if($synch)foreach($synch as $list){
			//print_r($list);
			$email=array("email"=>$list['email'],'euid'=>$list['euid'],'leid'=>$list['leid']);
			//$merge_vars=array('FNAME'=>$list['first_name'],'LNAME'=>$list['last_name']);
		
				$up_exist = true;
				$_params = array ('id' => $id , 'email' => $email  , 'update_existing' => $up_exist);
				print_r($_params);
				echo "<pre>";
				$mail=$MailChimp->call('lists/update-member',$_params);
				print_r($mail);//$id,$batch,$optin,$up_exist,$replace_int);
				
				echo "</pre>";
				
				$this->cronjob_model->update_edited_mailinglist($list['id']);
			}
	}
	function delete(){
		$this->load->model('cronjob_model');
		$delete=$this->cronjob_model->get_delete_mailinglist();
		
		$mailchimpapi=$this->cronjob_model->get_mailchip_api();
		$mailchimpid=$this->cronjob_model->get_mailchip_id();
		$MailChimp = new MailChimp($mailchimpapi['value']);
		$id = $mailchimpid['value'];
			//print_r($list);
			$batch=array();
		if($delete)foreach($delete as $list){
			
			$batch[] = array('email'=>$list['email'],'euid' =>$list['euid'],'leid'=>$list['leid']);
			$this->cronjob_model->update_delete_mailinglist($list['id']);
		}
			if($batch){
			$delete = true;
			$goobye = false;
			$notify = false;
			$_params = array ('id' => $id , 'batch' => $batch , 'delete_member' => $delete , 'send_goodbye' => $goobye , 'send_notify' => $notify);
				echo "<pre>";
				print_r($_params);
				print_r($MailChimp->call('lists/batch-unsubscribe',$_params));
				echo "</pre>";
				}
			}
}