<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Jne extends CI_Controller {
	function __construct(){
		parent::__construct();
		if($this->session->userdata('admin_logged_in')==FALSE)redirect('torioadmin/login');	
		$this->load->model('jne_model');
	}
	
	function index()
	{
		$this->data['jne']=$this->jne_model->get_jne_data_new_all();
		$this->data['content']='admin/jne/list';
		$this->load->view('common/admin/body',$this->data);
	} 
	
	function mass_edit(){
		
		$this->data['jne']=$this->jne_model->get_jne_data_new_all();
		$this->data['content']='admin/jne/mass_edit';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_mass_edit(){
		$jne_id=$this->input->post('jne_id');
		//pre($jne_id);
		
		if($jne_id)foreach($jne_id as $row){
			$city_id=$row;
			$regular_fee = $this->input->post('regular_fee'.$row);
			$regular_etd = $this->input->post('regular_etd'.$row);
			$express_fee = $this->input->post('express_fee'.$row);
			$express_etd = $this->input->post('express_etd'.$row);
			$min_purchase= $this->input->post('min_purchase'.$row);
			$data = array(	
							'regular_fee'=>$regular_fee,
							'regular_etd'=>$regular_etd,
							'express_fee'=>$express_fee,
							'express_etd'=>$express_etd,
							'min_purchase'=>$min_purchase);	
			$where = array('id'=>$city_id);		
			$this->jne_model->update_data('jne_city_tb',$data, $where);
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	function view_province()
	{
		$this->data['province']=$this->jne_model->get_jne_province_data();
		$this->data['content']='admin/jne/province_list';
		$this->load->view('common/admin/body',$this->data);
	} 
	
	function add_province()
	{
		$this->data['content']='admin/jne/add_province';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add_province()
	{
		$province = $this->input->post('province');
		$database = array('name'=>$province);		
		$this->jne_model->insert_data('jne_province_tb',$database);
		redirect('torioadmin/jne/view_province');
	}
	
	function edit_province($province_id)
	{
		$this->data['province']=$this->jne_model->get_selected_jne_province_data($province_id);
		$this->data['province_id']=$province_id;
		$this->data['content']='admin/jne/edit_province';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit_province($province_id)
	{
		$province = $this->input->post('province');
		$data = array('name'=>$province);	
		$where = array('id'=>$province_id);		
		$this->jne_model->update_data('jne_province_tb',$data, $where);
		redirect('torioadmin/jne/view_province');
	}
	
	function add_city()
	{
		$this->data['province']=$this->jne_model->get_jne_province_data();
		$this->data['content']='admin/jne/add_city';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_add_city()
	{
		$province = $this->input->post('province');
		$city = $this->input->post('city');
		$regular_fee = $this->input->post('regular_fee');
		$regular_etd = $this->input->post('regular_etd');
		$express_fee = $this->input->post('express_fee');
		$express_etd = $this->input->post('express_etd');
		$precedence = last_precedence('jne_city_tb') + 1;
		$min_purchase=$this->input->post('min_purchase');
		$data = array(	'jne_province_id'=>$province,
						'name'=>$city,
						'regular_fee'=>$regular_fee,
						'regular_etd'=>$regular_etd,
						'express_fee'=>$express_fee,
						'express_etd'=>$express_etd,
						'min_purchase'=>$min_purchase,
						'precedence'=>$precedence);		
		$this->jne_model->insert_data('jne_city_tb',$data);
		redirect('torioadmin/jne');
	}
	
	function edit_city($city_id)
	{
		$this->data['province']=$this->jne_model->get_jne_province_data();
		$this->data['city']=$this->jne_model->get_shipping_method($city_id);
		$this->data['city_id']=$city_id;
		$this->data['content']='admin/jne/edit_city';
		$this->load->view('common/admin/body',$this->data);
	}
	
	function do_edit_city($city_id)
	{
		$province = $this->input->post('province');
		$city = $this->input->post('city');
		$regular_fee = $this->input->post('regular_fee');
		$regular_etd = $this->input->post('regular_etd');
		$express_fee = $this->input->post('express_fee');
		$express_etd = $this->input->post('express_etd');
		$min_purchase=$this->input->post('min_purchase');
		$data = array(	'jne_province_id'=>$province,
						'name'=>$city,
						'regular_fee'=>$regular_fee,
						'regular_etd'=>$regular_etd,
						'express_fee'=>$express_fee,
						'min_purchase'=>$min_purchase,
						'express_etd'=>$express_etd);	
		$where = array('id'=>$city_id);		
		$this->jne_model->update_data('jne_city_tb',$data, $where);
		redirect('torioadmin/jne');
	}
	
	function upload_csv_form()
	{	

		
		$kota=$this->jne_model->get_jne_province_data();
		$kecamatan=$this->jne_model->get_jne_city_data();
		$data_entries2='';
		chmod("userdata/jne/",0777);
	   
		$config['upload_path'] = "userdata/jne/";
		$config['allowed_types'] = '*';
		$config['encrypt_name'] = true;
	   	$this->load->library('upload', $config);
		if($this->upload->do_upload('attachment')){
			$data=$this->upload->data();
			$attachment = $data['file_name'];
		}
		$kota_baru=array();
		$kota_id=array();
		foreach($kota as $list2){
			$kota_baru[]=$list2['name'];
			$kota_id[$list2['name']]=$list2['id'];
		}
		
		$kecamatan_baru=array();
		$kecamatan_id=array();
		foreach($kecamatan as $list3){
			$kecamatan_baru[]=$list3['name'];
			$kecamatan_id[$list3['name']]=$list3['id'];
		}
		
		$path = "userdata/jne/".$attachment;
		$row = 0;
		if (($handle = fopen($path, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 6000, ",")) !== FALSE) {	
				if($row>5){	
					if($data[0]!=""){
						$data_entries[] = $data ;
					}
				}
				$row++;
			}
		fclose($handle);
		}


		$zz=0;
		if($data_entries)foreach($data_entries as $list){
		
			if(!in_array($list[2],$kota_baru)){
				//insert new
				$province_name=$list[2];
				if($list[2]!=""){
					$this->jne_model->insert_csv_province($province_name);
					$kota_baru[]=$list[2];
					$jne_province_id=mysql_insert_id();					
					$kota_id[$list[2]]=$jne_province_id;
					
					if($list[3]!=""){
						if(!in_array($list[3],$kecamatan_baru)){
							$kecamatan_name=$list['3'];
							$reguler=intval($list['5']);
							$reguler_etd=$list['6'];
							$oke=intval($list['9']);
							if($oke!=''){
							$oke_etd=1;
							}else{
							$oke_etd='';
							}
							$this->jne_model->insert_csv_city($jne_province_id,$kecamatan_name,$reguler,$reguler_etd,$oke,$oke_etd);
							$kecamatan_baru[]=$list[3];
							$kecamatan_id[$list[3]]=mysql_insert_id();
						}
						else{
							//update kecamatan
							$id=$kecamatan_id[$list[3]];
							$kecamatan_name=$list['3'];
							$reguler=intval($list['5']);
							$reguler_etd=$list['6'];
							$oke=intval($list['9']);
						if($oke!=''){
							$oke_etd=1;
							}else{
							$oke_etd='';
							}
							$this->jne_model->update_csv_city($id,$jne_province_id,$kecamatan_name,$reguler,$reguler_etd,$oke,$oke_etd);
						}
					}
				}
				
			 
			}else{
				//city exists
				$jne_province_id=$kota_id[$list[2]];
			
				if($list[3]!=""){
					if(!in_array($list[3],$kecamatan_baru)){
						$kecamatan_name=$list['3'];
						$reguler=$list['5'];
						$reguler_etd=$list['6'];
						$oke=$list['9'];
						if($oke!=''){
							$oke_etd=1;
							}else{
							$oke_etd='';
							}
						$this->jne_model->insert_csv_city($jne_province_id,$kecamatan_name,$reguler,$reguler_etd,$oke,$oke_etd);
						$kecamatan_baru[]=$list[3];
						$kecamatan_id[$list[3]]=mysql_insert_id();
					}
					else{
						
						$id=$kecamatan_id[$list[3]];
							$kecamatan_name=$list['3'];
							$reguler=intval($list['5']);
							$reguler_etd=$list['6'];
							$oke=$list['9'];
							if($oke!=''){
							$oke_etd=1;
							}else{
							$oke_etd='';
							}
							$this->jne_model->update_csv_city($id,$jne_province_id,$kecamatan_name,$reguler,$reguler_etd,$oke,$oke_etd);
					}
				}
			
				
			}		
		}
	
			redirect('torioadmin/jne/');
	}
	
	function download_csv_form()
	{	
		//$fname="Tarif_JNE ".date('M')."_".date('Y');
		$fname="Tarif_JNE";
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename='.$fname.'.csv');
		
		$output = fopen('php://output', 'w');
		$province=$this->jne_model->get_jne_province_data();
		fputcsv($output,array('jne_kota_kabupaten_tb', '*Please do not delete this'));
		fputcsv($output,array('id', 'name'));
		if ($province) foreach ($province as $list){
			fputcsv($output, $list);
		}
		fputcsv($output,array());
		$city=$this->jne_model->get_jne_city_data();
		fputcsv($output,array('jne_kecamatan_tb', '*Please do not delete this'));
		fputcsv($output,array('id', 'jne_kota_kabupaten_id' , 'district_name', 'regular_tarif', 'regular_etd', 'oke_tarif', 'oke_etd', 'yes_tarif', 'yes_etd'));
		if ($city) foreach ($city as $list2){
			fputcsv($output, $list2);
		}	
	}
	
	function up_precedence_jne_city($id){
	
		$this->jne_model->up_precedence_jne_city($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	function down_precedence_jne_city($id){
	
		$this->jne_model->down_precedence_jne_city($id);
	
		redirect ($_SERVER['HTTP_REFERER']);
	}
	
	
	
	function reposition_precedence(){
		
		$curr_id=$this->input->post('curr_id');
		$prev_id=$this->input->post('prev_id');
		$next_id=$this->input->post('next_id');
		
		
		$curr_detail=$this->jne_model->get_shipping_method($curr_id);
		if($prev_id=='t'){
			echo "move to first";
			$new_precedence=1;
			$between_list=$this->jne_model->get_precedence_in_between($new_precedence,$curr_detail['precedence']);
			if($between_list)foreach($between_list as $list){
				$new_to=$list['precedence']+1;
				$this->jne_model->update_precedence($list['id'],$new_to);
			}
		}
		else if($next_id=='b'){
			echo "move to last";
			$new_precedence=last_precedence('jne_city_tb');
			$between_list=$this->jne_model->get_precedence_in_between($curr_detail['precedence'],$new_precedence+1);
			if($between_list)foreach($between_list as $list){
				$new_to=$list['precedence']-1;
				$this->jne_model->update_precedence($list['id'],$new_to);
			}
		}
		else {
			
			//prev after dropped
			$prev_detail=$this->jne_model->get_shipping_method($prev_id);
			
			
			//next after dropped
			$next_detail=$this->jne_model->get_shipping_method($next_id);
		
/*		
			$curr_next=$this->product_model->get_next_precedence($curr_detail['precedence']);
			$curr_next_precedence=$curr_next['precedence'];
*/			
			if($next_detail['precedence']<$curr_detail['precedence']){	
			
			
				// if curr item move up	
				$new_precedence=$next_detail['precedence'];
				$between_list=$this->jne_model->get_precedence_in_between($new_precedence,$curr_detail['precedence']);
				if($between_list)foreach($between_list as $list){
					$new_to=$list['precedence']+1;
					$this->jne_model->update_precedence($list['id'],$new_to);
				}
				echo "move up";
			}
			else{
				//if curr item move down
				
				$new_precedence=$prev_detail['precedence'];
				$max_precedence=$next_detail['precedence'];
				
				
				$between_list=$this->jne_model->get_precedence_in_between($curr_detail['precedence'],$max_precedence);
				
				if($between_list)foreach($between_list as $list){
					$new_to=$list['precedence']-1;
					$this->jne_model->update_precedence($list['id'],$new_to);
				}
				echo "move down";
			}
		}
		//update curr to new place
		$this->jne_model->update_precedence($curr_id,$new_precedence);
		
	}
	
	function fix_precedence(){		
		$jne=$this->jne_model->get_jne_city_data();	
		
		$no=1;
		if($jne){
			foreach($jne as $list){
				
				$this->jne_model->update_precedence($list['id'],$no);
				$no++;
			}
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function cheat_jne_city(){
		$this->load->model('user_model');
		$this->load->model('general_model');
		$all_address = $this->user_model->get_address_list();
		
		//change address to API
		if($all_address) foreach($all_address as $address){
			$id = $address['id'];
			$city = $address['city'];
			if($city!=0){
				$api = api_get_city($city);
				$province = $api['jne_province_id'];
				
				$data = array(
					'city'=>$city,
					'province'=>$province
				);
				
				$where = array('id'=>$id);
				
				$this->general_model->update_data('user_address_tb', $data, $where);
			}
		}
		
		$user = $this->user_model->user_list();
		
		if($user) foreach($user as $list){
			$id = $list['id'];
			$city = $list['city'];
			if($city!=0){
				$api = api_get_city($city);
				$province = $api['jne_province_id'];
			
				$data = array(
					'city'=>$city,
					'province'=>$province
				);
				
				$where = array('id'=>$id);
				
				$this->general_model->update_data('user_tb', $data, $where);
			}
		}
	}
}