<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Jne extends CI_Controller {
	function __construct(){
		parent::__construct();
		if($this->session->userdata('admin_logged_in')==FALSE)redirect('torioadmin/login');	
		$this->load->model('jne_model');
	}
	
	function index()
	{
		$this->data['jne']=$this->jne_model->get_jne_city_data();
		$this->data['content']='admin/jne/list';
		$this->load->view('common/admin/body',$this->data);
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
		$data = array(	'jne_province_id'=>$province,
						'name'=>$city,
						'regular_fee'=>$regular_fee,
						'regular_etd'=>$regular_etd,
						'express_fee'=>$express_fee,
						'express_etd'=>$express_etd,
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
		$data = array(	'jne_province_id'=>$province,
						'name'=>$city,
						'regular_fee'=>$regular_fee,
						'regular_etd'=>$regular_etd,
						'express_fee'=>$express_fee,
						'express_etd'=>$express_etd);	
		$where = array('id'=>$city_id);		
		$this->jne_model->update_data('jne_city_tb',$data, $where);
		redirect('torioadmin/jne');
	}
	
	function upload_csv_form($id)
	{
		$detail=$this->product_model->get_product($id);
		$product_option=$this->product_model->get_option_csv($detail['option_type']);
		$product_item=$this->product_model->get_product_item_csv($id);
		$productitem= count($product_item);
		$productoption= count($product_option);
		$productoption2= $productoption + 4;
		$productoption3= $productoption2 + $productitem;
		$kota=$this->jne_model->get_jne_province_data();
		$kecamatan=$this->jne_model->get_jne_city_data();
		$data_entries2='';

		chmod("userdata/product/csv/",0777);
	   
		$config['upload_path'] = "userdata/product/csv/";
		$config['allowed_types'] = 'csv';
		$config['encrypt_name'] = true;
	   
		if($this->upload($config,'attachment')){
			$data=$this->upload->data();
			$attachment = $data['file_name'];
		}
	   
		$path = "userdata/product/csv/".$attachment;
		$row = 0;
		if (($handle = fopen($path, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 6000, ",")) !== FALSE) {
				
				$row++;
				if($row>=$productoption2){
					$data_entries[] = $data ;
				}
				if($row>=$productoption3){
					$data_entries2[] = $data;
				}
				
			}
		fclose($handle);
		}
		
		if($data_entries2)foreach($data_entries2 as $list){
			
			$product = $id;
			$product_name = $list[3];
			$product_option = $list[2];
			$price = $list[4];
			$active = $list[5];	
			$picture = $list[6];

			$this->product_model->insert_csv($product,$product_name,$product_option,$price,$active,$picture);
		}
		
		if($data_entries)foreach($data_entries as $list){
			$kota_kabupaten_id = $list[0];
			$name = $id;
			$kecamatan_name = $list[2];
			$regular = $list[2];
			$price = $list[4];
			$active = $list[5];	
			$picture = $list[6];
			
			$this->product_model->edit_csv($product_item_id,$product_id,$product_item_name,$product_option,$price,$active,$picture);
		}
		redirect($_SERVER['HTTP_REFERER']);
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
}