<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Stamps extends CI_Controller{
	function Stamps()
	{
		parent::__construct();	
		if($this->session->userdata('user_logged_in')==false)redirect("login");	

		$this->data['page_title']="Stamps";				
	}
	
	function index()
	{	
		$user_id=$this->session->userdata('user_id');
		$token='931f92e41b8f368783c27fcb4dc5f1d7579c1281';
		$user_email='cozmo_mb@yahoo.com';
		$merchant='75488';
		$stamps = array(
							'token'=>$token,
							'merchant'=>$merchant,
							'user_email'=>$user_email
								 );
		$data = $stamps; 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://stamps.co.id/api/rewards/?merchant='.$data['merchant'].'&token='.$data['token'].'&user_email='.$data['user_email'].'');                   
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,  CURLOPT_HTTPHEADER,  array(
			'Content-Type: application/json')
			);
		$result  =  curl_exec($ch);  
		$zz=json_decode($result,true);
		$this->data['list_reward']=$zz;
		$this->data['content'] = 'content/stamps';
		$this->load->view('common/body', $this->data);	
	}
	

}
?>