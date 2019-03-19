<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Stamps extends CI_Controller{
	function __construct(){
		parent::__construct();	
		if($this->session->userdata('admin_logged_in')==false)redirect('torioadmin/login');
	}
	
	function index()
	{
		$token='931f92e41b8f368783c27fcb4dc5f1d7579c1281';
		$merchant='75488';
		$stamps = array(
							'token'=>$token,
							'merchant'=>$merchant
								 );
		$data = json_encode($stamps); 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://stamps.co.id/api/rewards/');                     
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,  CURLOPT_HTTPHEADER,  array(
			'Content-Type: application/json')
			);
		$result  =  curl_exec($ch);  
		$zz=json_decode($result,true);
		$this->data['list_reward']=$zz;
		$this->data['content']='admin/stamps/list';
		$this->load->view('common/admin/body',$this->data);
	}
	
}
?>