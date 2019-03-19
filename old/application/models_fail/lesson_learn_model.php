<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Lesson_learn_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function show_department_active(){
		$sql = "select * from department_tb where active = 1 order by name";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_lesson_learn(){
		$sql = "select * from lesson_learn_tb order by input_date desc limit 10";
		return $this->fetch_multi_row($sql);	
	}
	
	function show_lesson_learn_by_id($id){
		$sql = "select * from lesson_learn_tb where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function do_add_lesson_learn($department_id,$name,$description,$picture){
		$sql = "insert into lesson_learn_tb (department_id,name,description,picture,input_date,input_by)
				values ('".esc($department_id)."',
						'".esc($name)."',
						'".esc($description)."',
						'".esc($picture)."',
						'".esc(date('Y-m-d'))."',
						'".esc($this->session->userdata('employee_id'))."')";
		$this->execute_dml($sql);	
	}
	
	function do_edit_lesson_learn($id,$department_id,$name,$description,$picture){
		$sql = "update lesson_learn_tb set 	department_id = '".esc($department_id)."',
											name = '".esc($name)."',
											description = '".esc($description)."',
											picture = '".esc($picture)."'
											where id = '".esc($id)."'";
		$this->execute_dml($sql);
	}
	
	function delete_lesson_learn($id){
		$sql = "delete from lesson_learn_tb where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function open_lesson_learn($id,$open){
		$sql = "update 	lesson_learn_tb set open = '".esc($open)."'
						where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
}?>