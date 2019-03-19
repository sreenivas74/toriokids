<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Survey extends Ext_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('survey_model');
	}
	
	function index(){
		redirect('home');
	}
	
	//question
	function question_list(){
		if($this->session->userdata('admin_logged_in')==FALSE)redirect('login');
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","survey/survey_list","privilege_tb")){ redirect('home'); }
		$this->data['department_list'] = $this->survey_model->show_department();
		$this->data['department_question_list'] = $this->survey_model->show_department_by_question();
		$this->data['question_list'] = $this->survey_model->show_question();
		$this->data['page'] = "survey/question_list";
		$this->load->view('common/body',$this->data);
	}
	
	function do_add_question(){
		if($this->session->userdata('admin_logged_in')==FALSE)redirect('login');
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","survey/survey_list","privilege_tb")){ redirect('home'); }
		$department_id = $this->input->post('department_id');
		$question = $this->input->post('question');
		$type = $this->input->post('type');
		
		$precedence = last_precedence_flexible('precedence','question_tb','department_id',$department_id)+1;
		
		$this->survey_model->do_add_question($department_id,$question,$type,$precedence);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function do_edit_question($id){
		if($this->session->userdata('admin_logged_in')==FALSE)redirect('login');
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","survey/survey_list","privilege_tb")){ redirect('home'); }
		$question = $this->input->post('question');
		$type = $this->input->post('type');
		
		$this->survey_model->do_edit_question($id,$question,$type);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_question($id){
		if($this->session->userdata('admin_logged_in')==FALSE)redirect('login');
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","survey/survey_list","privilege_tb")){ redirect('home'); }
		$this->survey_model->delete_question($id);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function up_question($id,$department_id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","survey/survey_list","privilege_tb")){ redirect('home'); }
		if($this->session->userdata('admin_logged_in')==FALSE)redirect('login');
		$this->survey_model->up_question($id,$department_id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	function down_question($id,$department_id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","survey/survey_list","privilege_tb")){ redirect('home'); }
		if($this->session->userdata('admin_logged_in')==FALSE)redirect('login');
		$this->survey_model->down_question($id,$department_id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	//end of question
	
	//survey
	function survey_list(){
		if($this->session->userdata('admin_logged_in')==FALSE)redirect('login');
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","survey/survey_list","privilege_tb")){ redirect('home'); }
		$this->data['survey_result_new_list'] = $this->survey_model->show_survey_result_new();
		$this->data['survey_result_replied_list'] = $this->survey_model->show_survey_result_replied();
		$this->data['page'] = "survey/survey_list";
		$this->load->view('common/body',$this->data);	
	}
	
	function delete_survey($id){
		$survey_id = find('survey_id',$id,'survey_result_tb');
		$this->survey_model->delete_survey($id,$survey_id);
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function send_survey(){
		if($this->session->userdata('admin_logged_in')==FALSE)redirect('login');
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","survey/survey_list","privilege_tb")){ redirect('home'); }
		$send_date = date('Y-m-d H:i:s');
		$email = $this->input->post('email');
		$project_id = $this->input->post('project_id');
		
		if(!$project_id || !$email){
			$_SESSION['survey_error'] = 'Project and Email can not be empty';
			redirect($_SERVER['HTTP_REFERER']);	
		}
		
		$this->survey_model->send_survey($project_id,$email,$send_date);
		
		$survey_id = mysql_insert_id();
		
		$data = explode(",",$email);
		
		$no = 1;
		if($data)foreach($data as $list){
			$survey_number = date("Y/m/d/h/i/s")."/".$no;
			$this->survey_model->survey_result($survey_id,$project_id,$list,$survey_number,$send_date);
			$survey_result_id = mysql_insert_id();
			//send email\
			$to_email = $list;
			$subject = "Survey #".$survey_number;
			
			$email_content = "
				Hello,<br />
				Salam Sejahtera<br />
				Sebelumnya kami sangat berterima kasih atas kepercayaan yang telah anda berikan,<br />
				Kami akan selalu menjaga kepercayaan ini dan memberikan pelayanan yang terbaik bagi anda/ perusahaan anda<br />
				Guna meningkatkan mutu layanan dan kualitas kerja yang lebih baik dimasa yang akan datang,<br />
				Kami sangat berterima kasih apabila anda berpartisipasi dan berkenan meluangkan waktu anda untuk mengisi survey kepuasan pelanggan ini serta memberikan saran,<br />
				pada tempat yang telah kami sediakan ".site_url('survey/quiz/'.$survey_result_id.'/'.str_replace('/','.',$survey_number))."<br /><br />
				
				Terima kasih.
				
			";
			
			//echo $subject."<br />";
			//echo $email_content;exit;
			$this->load->library('email'); 
			$this->email->from("cs@cctvcameraindonesia.com");
			$this->email->to($to_email);
				
			$this->email->subject($subject);
			$this->email->message($email_content);  
			$this->email->send();
			//
			$no++;
		}
		$_SESSION['survey_error'] = 'Survey has been sent';
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function quiz_answer($id,$survey_number=null){
		if($this->session->userdata('admin_logged_in')==FALSE)redirect('login');
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","survey/survey_list","privilege_tb")){ redirect('home'); }
		
		$survey_number = str_replace("_","/",$survey_number);
		if(!find_4_string('id','survey_number',esc($survey_number),'id',esc($id),'survey_result_tb')){
			redirect("home");
		}
		
		$this->data['survey_number'] = $survey_number;
		$this->data['id'] = $id;
		
		$this->data['department_list'] = $this->survey_model->show_department_by_answer($id);
		$this->data['question_and_answer_list'] = $this->survey_model->show_question_and_answer($id);
		
		$this->load->view('survey/answer',$this->data);
	}
	
	//for client
	function quiz($id,$survey_number=null){
		$survey_number = str_replace("_","/",$survey_number);
		
		if(!find_4_string('id','survey_number',esc($survey_number),'id',esc($id),'survey_result_tb')){
			redirect("http://google.com");
		}
		
		$this->data['survey_number'] = $survey_number;
		$this->data['id'] = $id;
		
		$this->data['department_list'] = $this->survey_model->show_department_by_question();
		$this->data['question_list'] = $this->survey_model->show_question_active();
		
		$this->load->view('survey',$this->data);
	}
	
	function send_quiz(){
		$survey_result_id = $this->input->post('survey_result_id');
		$pic = $this->input->post('pic');
		$reply_date = date('Y-m-d H:i:s');
		$company = $this->input->post('company');
		$location = $this->input->post('location');
		$phone = $this->input->post('phone');
		$description = $this->input->post('description');
		
		if(!$pic || !$company || !$location){
			$_SESSION['quiz_notif'] = 'PIC / Company / Location can not be empty';
			redirect($_SERVER['HTTP_REFERER']); 	
		}
		
		$question_id = $this->input->post('question_id');
		
		if($question_id)foreach($question_id as $list){
			$answer = $this->input->post('answer'.$list);
			$department_id = $this->input->post('department_id'.$list);
			$this->survey_model->send_quiz_answer($survey_result_id,$list,$answer,$department_id);
		}
		
		$this->survey_model->send_quiz($survey_result_id,$company,$pic,$location,$phone,$reply_date,$description);
		
		//$_SESSION['quiz_notif'] = "Survey Has Been Send to Golden Solution Indonesia<br />Thank You";
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	//end of client
	
}?>