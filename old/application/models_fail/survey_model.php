<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Survey_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}

	function do_add_question($department_id,$question,$type,$precedence){
		$sql = "insert into question_tb (department_id, question,type,precedence,active)
				values	('".esc($department_id)."',
						'".esc($question)."',
						'".esc($type)."',
						'".esc($precedence)."',
						'1')";
		$this->execute_dml($sql);	
	}
	
	function delete_survey($id,$survey_id){
		$sql = "delete from survey_result_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);
		
		$sql = "delete from survey_tb where id = '".esc($survey_id)."'";
		$this->execute_dml($sql);
	}
	
	function do_edit_question($id,$question,$type){
		$sql = "update question_tb set question = '".esc($question)."', type = '".esc($type)."' where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function show_department(){
		$sql = "select * from department_tb order by name";
		return $this->fetch_multi_row($sql);
	}
	
	function show_department_by_question(){
		$sql = "select * from question_tb group by department_id";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_question(){
		$sql = "select * from question_tb order by precedence";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_question_active(){
		$sql = "select * from question_tb where active = 1 order by precedence";
		return $this->fetch_multi_row($sql);	
	}
	
	function delete_question($id){
		$sql = "delete from question_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function up_question($id,$department_id){
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from question_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from question_tb where precedence < '.$from['precedence'].' and department_id = '.$department_id.' order by precedence desc'));
		
		$sql1 = "update		question_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		question_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->execute_dml($sql1);
		$this->execute_dml($sql2);
	}
	function down_question($id,$department_id){
		$from=mysql_fetch_assoc(mysql_query('select id, precedence from question_tb where id = '.$id));
		$to=mysql_fetch_assoc(mysql_query('select id, precedence from question_tb where precedence > '.$from['precedence'].' and department_id = '.$department_id.' order by precedence asc'));
	
		$sql1 = "update		question_tb
				set 		`precedence` = '".esc($to['precedence'])."'
				where 		`id` = '".esc($from['id'])."'";
		$sql2 = "update		question_tb
				set 		`precedence` = '".esc($from['precedence'])."'
				where 		`id` = '".esc($to['id'])."'";
		
		$this->execute_dml($sql1);
		$this->execute_dml($sql2);
		
	}
	
	//survey
	function show_survey_result_new(){
		$sql = "select * from survey_result_tb where status = 0 order by send_date desc limit 30";
		return $this->fetch_multi_row($sql);
	}
	
	function show_survey_result_replied(){
		$sql = "select * from survey_result_tb where status = 1 order by send_date desc limit 100";
		return $this->fetch_multi_row($sql);
	}
	
	function send_survey($project_id,$email,$send_date){
		$sql = "insert into survey_tb (project_id,email,send_date)
				values	('".esc($project_id)."',
						'".esc($email)."',
						'".esc($send_date)."')";
		$this->execute_dml($sql);	
	}
	
	function survey_result($survey_id,$project_id,$list,$survey_number,$send_date){
		$sql = "insert into survey_result_tb (survey_id,project_id,email_address,survey_number,send_date)
				values ('".esc($survey_id)."',
						'".esc($project_id)."',
						'".esc($list)."',
						'".esc($survey_number)."',
						'".esc($send_date)."')";
		$this->execute_dml($sql);	
	}
	
	function send_quiz($survey_result_id,$company,$pic,$location,$phone,$reply_date,$description){
		$sql = "update survey_result_tb set company = '".esc($company)."',
											pic = '".esc($pic)."',
											location = '".esc($location)."',
											phone = '".esc($phone)."',
											reply_date = '".esc($reply_date)."',
											description = '".esc($description)."',
											status = '1'
											where id = '".esc($survey_result_id)."'";
		$this->execute_dml($sql);	
	}
	
	function send_quiz_answer($survey_result_id,$question_id,$answer,$department_id){
		$sql = "insert into survey_answer_tb (survey_result_id,question_id,answer,department_id)
				values ('".esc($survey_result_id)."',
						'".esc($question_id)."',
						'".esc($answer)."',
						'".esc($department_id)."')";
		$this->execute_dml($sql);	
	}
	
	function show_department_by_answer($survey_result_id){
		$sql = "select * from survey_answer_tb where survey_result_id = '".esc($survey_result_id)."' group by department_id";
		return $this->fetch_multi_row($sql);
	}
	
	function show_question_and_answer($survey_result_id){
		$sql = "select * from survey_answer_tb where survey_result_id = '".esc($survey_result_id)."'";
		return $this->fetch_multi_row($sql);	
	}
}?>