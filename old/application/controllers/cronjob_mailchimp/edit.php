<?php if(!defined('BASEPATH')) exit("Hacking Attempt?");
class Edit extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
		
	function index(){
		$this->load->model('cronjob_model');
		$synch=$this->cronjob_model->get_synch_mailinglist();
		$mailchimpapi=$this->cronjob_model->get_mailchip_api();
		$mailchimpid=$this->cronjob_model->get_mailchip_id();
		require_once 'MailChimp.class.php';
		$this->load->library('mailchimp');
		$MailChimp = new MailChimp($mailchimpapi['value']);
		$id = $mailchimpid['value'];
		if($synch)foreach($synch as $list){
			//print_r($list);
			$email=array("email"=>$list['email_address'],'euid'=>$list['euid'],'leid'=>$list['leid']);
			$merge_vars=array('FNAME'=>$list['first_name'],'LNAME'=>$list['last_name']);
		
				$up_exist = true;
				$_params = array ('id' => $id , 'email' => $email , 'merge_vars'=>$merge_vars , 'update_existing' => $up_exist);
				print_r($_params);
				echo "<pre>";
				$mail=$MailChimp->call('lists/update-member',$_params);
				print_r($mail);//$id,$batch,$optin,$up_exist,$replace_int);
				
				echo "</pre>";
				
				$this->cronjob_model->update_edited_mailinglist($list['id']);
			}
	}
}