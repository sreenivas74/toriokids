<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Lesson_learn extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
		redirect('login');
		}
		$this->load->model('lesson_learn_model');
		$this->load->model('flexigrid_model');
	}
	
	function list_lesson_learn(){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lesson_learn/list_lesson_learn","privilege_tb")) redirect('home');
		$this->data['lesson_learn_list'] = $this->lesson_learn_model->show_lesson_learn();
		$this->data['page'] = 'lesson_learn/list_lesson_learn';
		$this->load->view('common/body',$this->data); 	
	}
	
	function add_lesson_learn(){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lesson_learn/add_lesson_learn","privilege_tb")) redirect('home');
		$this->data['department'] = $this->lesson_learn_model->show_department_active();
		$this->data['page'] = 'lesson_learn/add_lesson_learn';
		$this->load->view('common/body', $this->data);	
	}
	
	function lesson_learn_flexi(){
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		if (!$sortname) $sortname = 'input_date';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 50;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');
		
		//customable
		$selection="*";
		$where = "";
		if ($query) $where = " where $qtype LIKE '%$query%' ";
		$tname="lesson_learn_tb";
		//customable
		$result = $this->flexigrid_model->get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname);
		$total1= $this->flexigrid_model->countRec("id"," $tname $where");
		//customable
		$total=$total1['total'];

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if($result) foreach($result as $row){
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lesson_learn/delete_lesson_learn","privilege_tb")){
				$delete = " | <a href=\"".site_url('lesson_learn/delete_lesson_learn/'.$row['id'])."\" onclick=\"return confirm(\'Are you sure?\');\">Delete</a>";
			 }else{
				$delete = "";
			 }
			 
			 $detail = " | <a href=\"".site_url('lesson_learn/detail_lesson_learn/'.$row['id'])."\">Detail</a>";
			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:[";
			
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lesson_learn/edit_lesson_learn","privilege_tb")){
				$json .= "'<a href=\"".site_url('lesson_learn/edit_lesson_learn/'.$row['id'])."\">Edit</a>".$delete.$detail."'";
			 }else{
				 $json .= "'".$delete.$detail."'";
			 }
			
			$json .= ",'".esc(find('name',$row['department_id'],'department_tb'))."'";
			$json .= ",'".esc($row['name'])."'";
			$json .= ",'".esc(nl2br($row['description']))."'";
			
			if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lesson_learn/edit_lesson_learn","privilege_tb")){
				if($row['open']==0){
					$json .= ",'<a href=\"".site_url('lesson_learn/open_lesson_learn/'.$row['id'].'/'.$row['open'])."\">yes</a>'";
				}else{
					$json .= ",'<a href=\"".site_url('lesson_learn/open_lesson_learn/'.$row['id'].'/'.$row['open'])."\">no</a>'";
				}
			}else{
				if($row['open']==1){
					$json .= ",'no'";
				}else{
					$json .= ",'yes'";
				}	
			}
			
			$json .= "]}";
			$rc = true;		
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
	}
	
	function detail_lesson_learn($id){
		$this->data['lesson_learn'] = $this->lesson_learn_model->show_lesson_learn_by_id($id);
		$this->data['page'] = 'lesson_learn/detail_lesson_learn';
		$this->load->view('common/body', $this->data);
	}
	
	function do_add_lesson_learn(){
		$deparment_id = $this->input->post('department_id');
		$name = $this->input->post('name');
		$description = $this->input->post('description');
		
		$picture='';	
			$config['upload_path'] = 'userdata/';
			$config['allowed_types'] = 'jpg|gif|png';
			$config['encrypt_name'] = TRUE;		
			$this->load->library('upload', $config);
			if($this->upload->do_upload('picture'))
			{				
				$data = $this->upload->data(); 			
				$source             = "userdata/".$data['file_name'] ;
				$destination		= "userdata/attachment/";
				chmod($source, 0777) ;
				$this->load->library('image_lib') ;
				$sourceSize = getSizeImage($source);
				
				$img['image_library'] = 'GD2';
				$img['maintain_ratio']= false;
					
				$img['width']   = $sourceSize['width'] ;
				$img['height'] = $sourceSize['height'];
		 		$img['quality']      = '100%';
				$img['source_image'] = $source ;
				$img['new_image']    = $destination;
				$this->image_lib->initialize($img);
				$this->image_lib->resize();
				$this->image_lib->clear();	
				
				unlink($source);
				$picture=$data['file_name'];
			}
		
		$this->lesson_learn_model->do_add_lesson_learn($deparment_id,$name,$description,$picture);
		
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	
	function edit_lesson_learn($id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lesson_learn/edit_lesson_learn","privilege_tb")) redirect('home');
		$this->data['department'] = $this->lesson_learn_model->show_department_active();
		$this->data['lesson_learn'] = $this->lesson_learn_model->show_lesson_learn_by_id($id);
		$this->data['page'] = 'lesson_learn/edit_lesson_learn';
		$this->load->view('common/body', $this->data);	
	}
	
	function do_edit_lesson_learn($id){
		$deparment_id = $this->input->post('department_id');
		$name = $this->input->post('name');
		$description = $this->input->post('description');
		
		$oldPicture = $this->lesson_learn_model->show_lesson_learn_by_id($id);
		$picture=$oldPicture['picture'];
		$config['upload_path'] = 'userdata/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['encrypt_name'] = TRUE;					
		$this->load->library('upload', $config);

		if($this->upload->do_upload('picture'))
		{		
		
			$data = $this->upload->data(); 			
			$source             = "userdata/".$data['file_name'] ;
			$destination		= "userdata/attachment/" ;
			chmod($source, 0777) ;
			$this->load->library('image_lib') ;
			$sourceSize = getSizeImage($source);
			
			if ($picture){
			//DELETE OLD FILES
			unlink($destination."".$picture);
			}
			
			
			$img['image_library'] = 'GD2';
				
			$img['width']   = $sourceSize['width'];
			$img['height'] = $sourceSize['height'];
			$img['maintain_ratio'] = false;
			$img['quality']      = '100%';
			$img['source_image'] = $source ;
			$img['new_image']    = $destination;
			$this->image_lib->initialize($img);
			$this->image_lib->resize();
			$this->image_lib->clear() ;	
			
			unlink($source);
			$picture=$data['file_name']; 
		} 
		
		$this->lesson_learn_model->do_edit_lesson_learn($id,$deparment_id,$name,$description,$picture);
		
		redirect($_SERVER['HTTP_REFERER']);	
	}
	
	function open_lesson_learn($id,$open){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lesson_learn/edit_lesson_learn","privilege_tb")) redirect('home');
		if($open==1){
			$open = 0;
		}else{
			$open = 1;	
		}
		
		$this->lesson_learn_model->open_lesson_learn($id,$open);
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function delete_lesson_learn($id){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lesson_learn/delete_lesson_learn","privilege_tb")) redirect('home');
		$this->lesson_learn_model->delete_lesson_learn($id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
}?>