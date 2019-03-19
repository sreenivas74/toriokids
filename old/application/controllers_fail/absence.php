<?php if(!defined("BASEPATH")) exit("Hack Attempt");
class Absence extends Ext_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('admin_logged_in')==FALSE) {
			redirect('login');
		}
		//$this->load->library('excel_reader');
		$this->load->library('PHPExcel');
		$this->load->model('absence_model');
	}
	
	function index(){
		redirect('home');
	}
	
	function update_slip_gaji(){
		$periode_from = $this->input->post('periode_from');
		$employee_id = $this->input->post('employee_id');
		if(!$periode_from || !$employee_id)redirect('home');
		
		$id = find_4_string('id','employee_id',$employee_id,'periode_from',$periode_from,'employee_salary_by_periode');
		if(!$id){
			$_SESSION['data_error'] = "data tidak ditemukan";
			redirect($_SERVER['HTTP_REFERER']);	
		}
		$this->data['slip_detail'] = $this->absence_model->get_slip_gaji($id);
		$this->data['page'] = 'absence/slip_gaji_update';
		$this->load->view('common/body', $this->data);
	}
	
	function do_update_slip_gaji(){//pre($_POST);
		$id = $this->input->post('id');
		$working_day = $this->input->post('working_day');
		$absent =  $this->input->post('absent');
		$overtime_1 = $this->input->post('overtime_1');
		$overtime_2 = $this->input->post('overtime_2');
		$overtime_1_cost = $this->input->post('overtime_1_cost');
		$overtime_2_cost = $this->input->post('overtime_2_cost');
		$late = $this->input->post('late');
		$late_cost = $this->input->post('late_cost');
		$last_dayoff = $this->input->post('last_dayoff');
		$meeting_cost = $this->input->post('meeting_cost');
		$under_payment = $this->input->post('under_payment');
		$over_payment = $this->input->post('over_payment');
		$debt = $this->input->post('debt');
		$paid = $this->input->post('paid');
		$overide = $this->input->post('overide');
		$last_debt = $this->input->post('last_debt');
		$meal = $this->input->post('meal');
		$vehicle = $this->input->post('vehicle');
		$pph21 = $this->input->post('pph21');
		$bonus_massa = $this->input->post('bonus_massa');
		$bonus_performance = $this->input->post('bonus_performance');
		$insurance = $this->input->post('insurance');
		$notes = $this->input->post('notes');
		
		$salary_monthly = $this->input->post('salary_monthly');
		$salary = $this->input->post('salary');
		
		$employee_id=$this->input->post('employee_id');
	
		$tunjangan_jabatan = find_2('tunjangan_jabatan','employee_id',$employee_id,'employee_salary_tb');
		$tunjangan_bahasa_inggris = find_2('tunjangan_bahasa_inggris','employee_id',$employee_id,'employee_salary_tb');
		$tunjangan_access_control = find_2('tunjangan_access_control','employee_id',$employee_id,'employee_salary_tb');
		$tunjangan_fire_alarm_system = find_2('tunjangan_fire_alarm_system','employee_id',$employee_id,'employee_salary_tb');
		$tunjangan_fire_suppression = find_2('tunjangan_fire_suppression','employee_id',$employee_id,'employee_salary_tb');
		$tunjangan_bas = find_2('tunjangan_bas','employee_id',$employee_id,'employee_salary_tb');
		$tunjangan_gpon = find_2('tunjangan_gpon','employee_id',$employee_id,'employee_salary_tb');
		$tunjangan_perimeter_intrusion = find_2('tunjangan_perimeter_intrusion','employee_id',$employee_id,'employee_salary_tb');
		$tunjangan_public_address = find_2('tunjangan_public_address','employee_id',$employee_id,'employee_salary_tb');
		$tunjangan_fiber_optic = find_2('tunjangan_fiber_optic','employee_id',$employee_id,'employee_salary_tb');
		$tunjangan_bpjs = find_2('tunjangan_bpjs','employee_id',$employee_id,'employee_salary_tb');	
		$potongan_bpjs = find_2('potongan_bpjs','employee_id',$employee_id,'employee_salary_tb');
		
		$this->absence_model->do_update_slip_gaji($id,$working_day,$absent,$overtime_1,$overtime_1_cost,$overtime_2,$overtime_2_cost,$late,$late_cost,$overide,$last_dayoff,$last_debt,$debt,$paid,$under_payment,$over_payment,$meal,$vehicle,$meeting_cost,$bonus_massa,$bonus_performance,$insurance,$pph21,$salary_monthly,$salary,$notes);
		
		
		$this->absence_model->do_update_slip_gaji2($id,$tunjangan_jabatan,$tunjangan_bahasa_inggris,$tunjangan_access_control,$tunjangan_fire_alarm_system,$tunjangan_fire_suppression,$tunjangan_bas,$tunjangan_gpon,$tunjangan_perimeter_intrusion,$tunjangan_fiber_optic,$tunjangan_bpjs,$potongan_bpjs);
		
		redirect('absence/approval_list');
	}
	
	function refix_employee_tunjangan(){
		
		$periode_from=$this->uri->segment(3).' 00:00:00';
		$employee_list=$this->absence_model->show_employee_active();
		//exit();
		if($employee_list)foreach($employee_list as $list){
			
			$id = find_4_string('id','employee_id',$list['id'],'periode_from',$periode_from,'employee_salary_by_periode');
				
			$employee_id=$list['id'];
		
			$tunjangan_jabatan = find_2('tunjangan_jabatan','employee_id',$employee_id,'employee_salary_tb');
			$tunjangan_bahasa_inggris = find_2('tunjangan_bahasa_inggris','employee_id',$employee_id,'employee_salary_tb');
			$tunjangan_access_control = find_2('tunjangan_access_control','employee_id',$employee_id,'employee_salary_tb');
			$tunjangan_fire_alarm_system = find_2('tunjangan_fire_alarm_system','employee_id',$employee_id,'employee_salary_tb');
			$tunjangan_fire_suppression = find_2('tunjangan_fire_suppression','employee_id',$employee_id,'employee_salary_tb');
			$tunjangan_bas = find_2('tunjangan_bas','employee_id',$employee_id,'employee_salary_tb');
			$tunjangan_gpon = find_2('tunjangan_gpon','employee_id',$employee_id,'employee_salary_tb');
			$tunjangan_perimeter_intrusion = find_2('tunjangan_perimeter_intrusion','employee_id',$employee_id,'employee_salary_tb');
			$tunjangan_public_address = find_2('tunjangan_public_address','employee_id',$employee_id,'employee_salary_tb');
			$tunjangan_fiber_optic = find_2('tunjangan_fiber_optic','employee_id',$employee_id,'employee_salary_tb');
			$tunjangan_bpjs = find_2('tunjangan_bpjs','employee_id',$employee_id,'employee_salary_tb');	
			$potongan_bpjs = find_2('potongan_bpjs','employee_id',$employee_id,'employee_salary_tb');
			$this->absence_model->do_update_slip_gaji2($id,$tunjangan_jabatan,$tunjangan_bahasa_inggris,$tunjangan_access_control,$tunjangan_fire_alarm_system,$tunjangan_fire_suppression,$tunjangan_bas,$tunjangan_gpon,$tunjangan_perimeter_intrusion,$tunjangan_fiber_optic,$tunjangan_bpjs,$potongan_bpjs);
		}
	}
	
	function absent_list(){
		$this->data['reject_list'] = $this->absence_model->get_reject_list();
		$this->data['page'] = 'absence/absent_list';
		$this->load->view('common/body', $this->data);
		
	}
	
	function approval_list(){
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","absence/salary_approval","privilege_tb"))redirect('home');
		$this->data['approval_list'] = $this->absence_model->show_approval_list();
		$this->data['employee_list'] = $this->absence_model->show_employee_active();
		$this->data['page'] = 'absence/approval_list';
		$this->load->view('common/body', $this->data);
	}	
	
	function salary_list(){
		$this->data['employee_active'] = $this->absence_model->show_employee_active();
		$this->data['page'] = 'absence/salary_list';
		$this->load->view('common/body', $this->data);
	}
	
	function delete_salary_pending($periode_from,$periode_to){
		$this->absence_model->delete_salary_pending($periode_from,$periode_to);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function update_salary(){
		$created_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userdata('admin_id');
		$employee_id = $this->input->post('employee_id');
		if($employee_id)foreach($employee_id as $list){
			
			$userid = $this->input->post('userid_'.$list);
			$salary = str_replace(',','',$this->input->post('salary_'.$list));
			$meal = str_replace(',','',$this->input->post('meal_'.$list));
			$dayoff = str_replace(',','',$this->input->post('dayoff_'.$list));
			$vehicle = str_replace(',','',$this->input->post('vehicle_'.$list));
			$overtime_1 = str_replace(',','',$this->input->post('overtime_1_'.$list));
			$overtime_2 = str_replace(',','',$this->input->post('overtime_2_'.$list));
			$insurance = str_replace(',','',$this->input->post('insurance_'.$list));
			$debt = str_replace(',','',$this->input->post('debt_'.$list));
			$pph21 = str_replace(',','',$this->input->post('pph21_'.$list));
			
			
			$tunjangan_jabatan = str_replace(',','',$this->input->post('tunjangan_jabatan_'.$list));
			$tunjangan_bahasa_inggris = str_replace(',','',$this->input->post('tunjangan_bahasa_inggris_'.$list));
			$tunjangan_access_control = str_replace(',','',$this->input->post('tunjangan_access_control_'.$list));
			$tunjangan_fire_alarm_system = str_replace(',','',$this->input->post('tunjangan_fire_alarm_system_'.$list));
			$tunjangan_fire_suppression = str_replace(',','',$this->input->post('tunjangan_fire_suppression_'.$list));
			$tunjangan_bas = str_replace(',','',$this->input->post('tunjangan_bas_'.$list));
			$tunjangan_gpon = str_replace(',','',$this->input->post('tunjangan_gpon_'.$list));
			$tunjangan_perimeter_intrusion = str_replace(',','',$this->input->post('tunjangan_perimeter_intrusion_'.$list));
			$tunjangan_public_address = str_replace(',','',$this->input->post('tunjangan_public_address_'.$list));
			$tunjangan_fiber_optic = str_replace(',','',$this->input->post('tunjangan_fiber_optic_'.$list));
			$tunjangan_bpjs = str_replace(',','',$this->input->post('tunjangan_bpjs_'.$list));
			$potongan_bpjs = str_replace(',','',$this->input->post('potongan_bpjs_'.$list));
			
			
			//echo $list."-".$salary."-";
			if(find_2('id','employee_id',$list,'employee_salary_tb')){
				$this->absence_model->update_salary($userid,$list,$salary,$meal,$dayoff,$vehicle,$overtime_1,$overtime_2,$insurance,$debt,$pph21,$created_date,$created_by,$tunjangan_jabatan,$tunjangan_bahasa_inggris,$tunjangan_access_control,$tunjangan_fire_alarm_system,$tunjangan_fire_suppression,$tunjangan_bas,$tunjangan_gpon,$tunjangan_perimeter_intrusion,$tunjangan_public_address,$tunjangan_fiber_optic,$tunjangan_bpjs,$potongan_bpjs);
				
			}else{
				$this->absence_model->insert_salary($userid,$list,$salary,$meal,$dayoff,$vehicle,$overtime_1,$overtime_2,$insurance,$debt,$pph21,$created_date,$created_by,$tunjangan_jabatan,$tunjangan_bahasa_inggris,$tunjangan_access_control,$tunjangan_fire_alarm_system,$tunjangan_fire_suppression,$tunjangan_bas,$tunjangan_gpon,$tunjangan_perimeter_intrusion,$tunjangan_public_address,$tunjangan_fiber_optic,$tunjangan_bpjs,$potongan_bpjs);
			}
			//update userid to employee
			$this->absence_model->update_userid_to_employee($userid,$list);
		}
		//exit;
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function upload($config,$file){
        $this->load->library('upload');
        $this->upload->initialize($config);
        if($this->upload->do_upload($file))
        return true;
        return false;
    }
	function test(){
		 $start = explode(':','07:30:00');
		 echo $start[0]*30;
	}
	function import_data(){
		ini_set('max_input_vars', 3000);
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);
		$employee_id = 0;
		$periode_from = $this->input->post('periode_from');
		$periode_to = $this->input->post('periode_to');
		$active_day = $this->input->post('active_day');
		
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		
		$input_date = date('Y-m-d H:i:s');
		$input_by = $this->session->userdata('admin_id');
		if(!$periode_from || !$periode_to || !is_numeric($active_day)){
			$_SESSION['absen_error'] = "<span style='color:#F00'>* Periode From / Periode To / Active Day(number) must be filled!</span>";
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		//delete old data if reupload
		$this->absence_model->delete_old_absent_data($periode_from,$periode_to,$active_day,$year,$month);
		
		//parameter
		$in = 0;
		$off = 0;
		$overide = 0;
		
		$config['upload_path'] = 'userdata/absensi/';
        $config['allowed_types'] = '*';
		
		if($this->upload($config,'excel_file')){
			$upload_data = $this->upload->data();
			$file_location =  $upload_data['full_path'];
			
			//test
			$array = array();			
			//
			//echo $array["multi"]["dimensional"]["array"];
			$inputFileName = $file_location;  
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);  
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);  
			$objReader->setReadDataOnly(true);  
			/**  Load $inputFileName to a PHPExcel Object  **/  
			$objPHPExcel = $objReader->load($inputFileName);  
			$total_sheets=$objPHPExcel->getSheetCount(); // here 4  
			$allSheetName=$objPHPExcel->getSheetNames(); // array ([0]=>'student',[1]=>'teacher',[2]=>'school',[3]=>'college')  
			$objWorksheet = $objPHPExcel->setActiveSheetIndex(0); // first sheet  
			$highestRow = $objWorksheet->getHighestRow(); // here 5  
			$highestColumn = $objWorksheet->getHighestColumn(); // here 'E'  
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);  // here 5  
			for ($row = 2; $row <= $highestRow; ++$row) {  
				$value = '';
				for ($col = 0; $col <= $highestColumnIndex; ++$col) {  
					if($col == 1){
						$value.=PHPExcel_Shared_Date::ExcelToPHPObject($objWorksheet->getCellByColumnAndRow($col, $row)->getValue())->format('Y-m-d H:i:s').'|';
						$value.=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue().'|';
					}else{
						$value.=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue().'|';
					}
				}
				/*echo $value."<br />";
			}*/
			
				$data = explode('|',$value);
				$userid = $data[0];
				$employee_id = find_2('id','userid',$userid,'employee_tb');
				$checktype = $data[3];
				$verifycode = $data[4];
				$flag ='0';
				$checkin_date = 0;
				$checkout_date = 0;
				$overtime = 0 ;
				$late = 0 ;
				//separate date and time
				$check_date = date('Y-m-d H:i:s',strtotime($data[1]));
				//echo $check_date."<br>";
				$check_date_2 = date('Y-m-d 12:00:00',strtotime($data[1]));
				//$check_time = date('H:i:s',strtotime($data[1]));
				//echo $check_time;exit;
				//get date without time 
				$check_date_no_time= explode(' ',$check_date);
				
				if(strtotime($check_date) >= strtotime(date($periode_from." 00:00:01")) && strtotime($check_date) <= strtotime(date($periode_to." 23:59:59"))){
					//echo "<i>".$check_date."</i><br>";
					//overide or no
					//echo $verifycode."<br>";
					if($verifycode== 1)$overide=0;else $overide=1;
					
					if(check_userid_date($userid,$check_date_no_time[0])){
						$id = check_userid_date($userid,$check_date_no_time[0]);
						
						if(strtotime($check_date) <= strtotime($check_date_2)){
							$temp_date = explode(' ',find('checkin_date',$id,'salary_tb'));
							$check_checkin =  explode('-',$temp_date[0]);
							
							if($check_checkin[2]==0){
								$late= check_late($check_date);
								$temp_overide = check_userid_overide($id,$overide);
								$data=array('checkin_date'=>($check_date),'overide'=>$temp_overide,'late'=>$late);
								//if($temp_overide==1){ echo "x";exit; }
								$this->absence_model->update($data,$id);
							}else{
								$id_update = check_userid_in($id,strtotime($check_date));
								if($id_update){
									$late= check_late($check_date);
									$temp_overide = check_userid_overide($id_update,$overide);
									//if($temp_overide==1){ echo "y";exit; }
									$data=array('checkin_date'=>($check_date),'overide'=>$temp_overide,'late'=>$late);
									$this->absence_model->update($data,$id_update);	
								}
							}
							
						}else{
							$id_update = check_userid_out($id,strtotime($check_date));
							if($id_update){
								$date_type = date('N',strtotime($check_date));
								if($date_type==6 || $date_type ==7){
									$overtime = 0;
									$overtime_2 = check_overtime($check_date);
								}else{
									$overtime = check_overtime($check_date);
									$overtime_2 = 0;
								}
								$temp_overide = check_userid_overide($id_update,$overide);
								//if($temp_overide==1){ echo "z";exit; }
								$data=array('checkout_date'=>($check_date),'overide'=>$temp_overide,'overtime'=>$overtime,'overtime_2'=>$overtime_2);
								$this->absence_model->update($data,$id_update);
							}
						}
					}else{
						if(strtotime($check_date) <= strtotime($check_date_2)){
							$checkin_date = $check_date ;
							$checkout_date=0;
							$overtime = 0;
							$overtime_2 = 0;
							$late= check_late($checkin_date);
							
						}else{
							$checkout_date = $check_date ;
							$checkin_date=0;
							
							$date_type = date('N',strtotime($checkout_date));
							if($date_type==6 || $date_type ==7){
								$overtime = 0;
								$overtime_2 = check_overtime($checkout_date);
							}else{
								$overtime = check_overtime($checkout_date);
								$overtime_2 = 0;
							}
						}
						
						if($employee_id){
							$data=array('userid'=>($userid),'employee_id'=>$employee_id,'periode_from'=>$periode_from,'periode_to'=>$periode_to,'checkin_date'=>$checkin_date,'checkout_date'=>$checkout_date,'active_day'=>$active_day,'absent'=>1,'off'=>0,'overide'=>$overide,'input_by'=>'admin','input_date'=>0,'overtime'=>$overtime,'overtime_2'=>$overtime_2,'late'=>$late,'month'=>$month,'year'=>$year);	
							$this->absence_model->add('salary_tb',$data);
						}
					}
				}
			}
			$this->data['absence_list'] = $data = $this->absence_model->get_absence_list(strtotime($periode_from),strtotime($periode_to));
			$this->data['company_list'] = $this->absence_model->show_company_list();
			$this->data['department_list'] = $this->absence_model->show_department_list();
			$this->data['periode_from'] = $periode_from;
			$this->data['periode_to'] = $periode_to;
			$this->data['active_day'] = $active_day;
			$this->data['page'] = 'absence/list';
			$this->load->view('common/body', $this->data);
		}else{
			$_SESSION['absen_error'] = "<span style='color:#F00'>* File excel empty / must be .XLS(2003)</span>";
			redirect($_SERVER['HTTP_REFERER']);
		}
		
	}
	function  update_salary_by_absence(){
		
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);
	
		$n = $this->input->post('qty');
		$periode_to = $this->input->post('periode_to');
		$periode_from = $this->input->post('periode_from');
		$active_day = $this->input->post('active_day');
		
		for($i = 1 ; $i<$n;$i++)
		{
			$user_id =  $this->input->post('user_id'.$i);
			$userid =  $this->input->post('user_id'.$i);
			$employee_id = find_2('id','userid',$user_id,'employee_tb');
			
			$working_day = $this->input->post('masuk'.$i);
			$absence =  $this->input->post('offday'.$i);
			$overtime = $this->input->post('overtime'.$i);
			$overtime_2 = $this->input->post('overtime_2'.$i);
			$late = $this->input->post('late'.$i);
			$target = $this->input->post('target'.$i);
			$meeting_absence = $this->input->post('not_attend_meeting'.$i);
			$under_payment = $this->input->post('under_payment'.$i);
			$over_payment = $this->input->post('over_payment'.$i);
			$debt = $this->input->post('money_box'.$i);
			$paid = $this->input->post('paid'.$i);
			$overide = $this->input->post('overide'.$i);
			$month = $this->input->post('month'.$i);
			$year = $this->input->post('year'.$i);
		
		
		
			$tunjangan_jabatan = find_2('tunjangan_jabatan','userid',$userid,'employee_salary_tb');
			$tunjangan_bahasa_inggris = find_2('tunjangan_bahasa_inggris','userid',$userid,'employee_salary_tb');
			$tunjangan_access_control = find_2('tunjangan_access_control','userid',$userid,'employee_salary_tb');
			$tunjangan_fire_alarm_system = find_2('tunjangan_fire_alarm_system','userid',$userid,'employee_salary_tb');
			$tunjangan_fire_suppression = find_2('tunjangan_fire_suppression','userid',$userid,'employee_salary_tb');
			$tunjangan_bas = find_2('tunjangan_bas','userid',$userid,'employee_salary_tb');
			$tunjangan_gpon = find_2('tunjangan_gpon','userid',$userid,'employee_salary_tb');
			$tunjangan_perimeter_intrusion = find_2('tunjangan_perimeter_intrusion','userid',$userid,'employee_salary_tb');
			$tunjangan_public_address = find_2('tunjangan_public_address','userid',$userid,'employee_salary_tb');
			$tunjangan_fiber_optic = find_2('tunjangan_fiber_optic','userid',$userid,'employee_salary_tb');
			$tunjangan_bpjs = find_2('tunjangan_bpjs','userid',$userid,'employee_salary_tb');	
			$potongan_bpjs = find_2('potongan_bpjs','userid',$userid,'employee_salary_tb');
			
			
			$data = array(
						'periode_from'=>$periode_from,
						'periode_to'	=>$periode_to,
						'user_id'=>$user_id,
						'employee_id'=>$employee_id,
						'active_day'=>$active_day,
						'working_day'=>$working_day,
						'absent'=>$absence,
						'overtime'=>$overtime,
						'overtime_2'=>$overtime_2,
						'late'=>$late,
						'target' =>$target,
						'meeting_absence'=>$meeting_absence,
						'under_payment'=>$under_payment,
						'over_payment'=>$over_payment,
						'debt'=>$debt,
						'paid'=>$paid,
						'overide'=>$overide,
						'month'=>$month,
						'year'=>$year,
						'status'=>0,
						'tunjangan_access_control'=>$tunjangan_access_control,
						'tunjangan_bahasa_inggris'=>$tunjangan_bahasa_inggris,
						'tunjangan_bas'=>$tunjangan_bas,
						'tunjangan_fiber_optic'=>$tunjangan_fiber_optic,
						'tunjangan_fire_alarm_system'=>$tunjangan_fire_alarm_system,
						'tunjangan_fire_suppression'=>$tunjangan_fire_suppression,
						'tunjangan_gpon'=>$tunjangan_gpon,
						'tunjangan_jabatan'=>$tunjangan_jabatan,
						'tunjangan_perimeter_intrusion'=>$tunjangan_perimeter_intrusion,
						'tunjangan_public_address'=>$tunjangan_public_address,
						'tunjangan_bpjs'=>$tunjangan_bpjs,
						'potongan_bpjs'=>$potongan_bpjs
						);
				//echo $periode_from."=".$periode_to."=".$user_id."<br>";
			if(!find_absent_data('id','periode_from',$periode_from,'periode_to',$periode_to,'user_id',$user_id,'absence_salary_tb')){
				$this->absence_model->add('absence_salary_tb',$data);
				$cuti = find_2('dayoff','userid',$user_id,'employee_salary_tb');
				$temp_debt = find_2('debt','userid',$user_id,'employee_salary_tb');
				$temp_paid = find_2('paid','userid',$user_id,'employee_salary_tb');
				$data_edit = array(
								'dayoff' => $cuti-$absence,
								'debt'=> $temp_debt + $debt - $paid,
								'paid'=> $temp_paid + $paid
								);
				//$this->absence_model->edit_employee_salary($data_edit,$user_id);
				
				//////
				$salary = find_2('salary','userid',$user_id,'employee_salary_tb');
				$late_cost = $late * 10000;
				$meal = find_2('meal','userid',$user_id,'employee_salary_tb');
				$vehicle =  find_2('vehicle','userid',$user_id,'employee_salary_tb');
				$overtime_1_cost = $overtime;
				$overtime_2_cost = $overtime_2;
				$pph21 =  find_2('pph21','userid',$user_id,'employee_salary_tb');
				$insurance =  find_2('insurance','userid',$user_id,'employee_salary_tb');
				
				$bonus_massa_periode = date('Y') - date('Y',strtotime(find_2('join_date','userid',$user_id,'employee_tb')));
				$bonus_massa=0;
				if($bonus_massa_periode>=2){
					$bonus_massa = find_2('meal','userid',$user_id,'employee_salary_tb')*$bonus_massa_periode*2;
				}
				$meeting_cost = 0;
				
						
								
				

				
				$data2 = array(
							'user_id'=>$user_id,
							'employee_id'=>$employee_id,
							'working_day'=>$working_day,
							'salary'=>$salary,
							'meal'=>$meal,
							'vehicle'=>$vehicle,
							'overtime_1'=>$overtime_1_cost,
							'overtime_2'=>$overtime_2_cost,
							'bonus_massa'=>$bonus_massa,
							'absent'=>$absence,
							'late'=>$late,
							'pph21'=>$pph21,
							'late_cost'=>$late_cost,
							'over_payment'=>$over_payment,
							'under_payment'=>$under_payment,
							'meeting_cost'=>$meeting_cost,
							'insurance'=>$insurance,
							'status'=>0,
							'periode_from'=>$periode_from,
							'periode_to'=>$periode_to,
							'active_day'=>$active_day,
							'debt'=>$debt,
							'overide'=>$overide,
							'month'=>$month,
							'year'=>$year,
							'paid'=>$paid,
							'tunjangan_access_control'=>$tunjangan_access_control,
							'tunjangan_bahasa_inggris'=>$tunjangan_bahasa_inggris,
							'tunjangan_bas'=>$tunjangan_bas,
							'tunjangan_fiber_optic'=>$tunjangan_fiber_optic,
							'tunjangan_fire_alarm_system'=>$tunjangan_fire_alarm_system,
							'tunjangan_fire_suppression'=>$tunjangan_fire_suppression,
							'tunjangan_gpon'=>$tunjangan_gpon,
							'tunjangan_jabatan'=>$tunjangan_jabatan,
							'tunjangan_perimeter_intrusion'=>$tunjangan_perimeter_intrusion,
							'tunjangan_public_address'=>$tunjangan_public_address,
							'tunjangan_bpjs'=>$tunjangan_bpjs,
							'potongan_bpjs'=>$potongan_bpjs
					);
					
					$this->absence_model->add('employee_salary_by_periode',$data2);
				
				/////
			}
		}
		redirect('absence/absent_list');
	}
	function update_salary_by_periode()
	{
		$n = $this->input->post('qty');
		$periode_from = $this->input->post('periode_from');
		$periode_to = $this->input->post('periode_to');
		$active_day = $this->input->post('active_day');
		
		for($i=1;$i<$n;$i++)
		{
			$user_id = $this->input->post('user_id'.$i);
			$employee_id = find_2('id','userid',$user_id,'employee_tb');
			$working_day = $this->input->post('working_day'.$i);
			$salary = $this->input->post('salary'.$i);
			$meal = $this->input->post('meal'.$i);
			$vehicle = $this->input->post('vehicle'.$i);
			$bonus_rice = $this->input->post('bonus_rice'.$i);
			$overtime_1 = $this->input->post('overtime_1'.$i);
			$overtime_2 = $this->input->post('overtime_2'.$i);
			$bonus_performance = $this->input->post('bonus_performance'.$i);
			$bonus_plus = $this->input->post('bonus_plus'.$i);
			$bonus_massa = $this->input->post('bonus_massa'.$i);
			$sim_a = $this->input->post('sim_a'.$i);
			$sim_c = $this->input->post('sim_c'.$i);
			$bonus_skill = $this->input->post('bonus_skill'.$i);
			$absent = $this->input->post('absent'.$i);
			$late = $this->input->post('late'.$i);
			$installment_loans = $this->input->post('cicilan'.$i);
			$late_cost = $this->input->post('late_cost'.$i);
			$pph21 =  find_2('pph21','userid',$user_id,'employee_salary_tb');
			$over_payment = $this->input->post('over_payment'.$i);
			$under_payment = $this->input->post('under_payment'.$i);
			$meeting_cost = $this->input->post('meeting_cost'.$i);
			$insurance = $this->input->post('insurance'.$i);
			$debt = $this->input->post('debt'.$i);
			$paid = $this->input->post('paid'.$i);
			$overide = $this->input->post('overide'.$i);
			$status = 0;
		
		
			$tunjangan_jabatan = find_2('tunjangan_jabatan','userid',$userid,'employee_salary_tb');
			$tunjangan_bahasa_inggris = find_2('tunjangan_bahasa_inggris','userid',$userid,'employee_salary_tb');
			$tunjangan_access_control = find_2('tunjangan_access_control','userid',$userid,'employee_salary_tb');
			$tunjangan_fire_alarm_system = find_2('tunjangan_fire_alarm_system','userid',$userid,'employee_salary_tb');
			$tunjangan_fire_suppression = find_2('tunjangan_fire_suppression','userid',$userid,'employee_salary_tb');
			$tunjangan_bas = find_2('tunjangan_bas','userid',$userid,'employee_salary_tb');
			$tunjangan_gpon = find_2('tunjangan_gpon','userid',$userid,'employee_salary_tb');
			$tunjangan_perimeter_intrusion = find_2('tunjangan_perimeter_intrusion','userid',$userid,'employee_salary_tb');
			$tunjangan_public_address = find_2('tunjangan_public_address','userid',$userid,'employee_salary_tb');
			$tunjangan_fiber_optic = find_2('tunjangan_fiber_optic','userid',$userid,'employee_salary_tb');
			$tunjangan_bpjs = find_2('tunjangan_bpjs','userid',$userid,'employee_salary_tb');
			$potongan_bpjs = find_2('potongan_bpjs','userid',$userid,'employee_salary_tb');
			
			$data = array(
							'user_id'=>$user_id,
							'employee_id'=>$employee_id,
							'working_day'=>$working_day,
							'salary'=>$salary,
							'meal'=>$meal,
							'vehicle'=>$vehicle,
							'bonus_rice'=>$bonus_rice,
							'overtime_1'=>$overtime_1,
							'overtime_2'=>$overtime_2,
							'bonus_performance'=>$bonus_performance,
							'bonus_plus'=>$bonus_plus,
							'bonus_massa'=>$bonus_massa,
							'sim_a'=>$sim_a,
							'sim_c'=>$sim_c,
							'bonus_skill'=>$bonus_skill,
							'absent'=>$absent,
							'late'=>$late,
							'installment_loans'=>$installment_loans,
							'pph21'=>$pph21,
							'late_cost'=>$late_cost,
							'over_payment'=>$over_payment,
							'under_payment'=>$under_payment,
							'meeting_cost'=>$meeting_cost,
							'insurance'=>$insurance,
							'status'=>$status,
							'periode_from'=>$periode_from,
							'periode_to'=>$periode_to,
							'active_day'=>$active_day,
							'debt'=>$debt,
							'paid'=>$paid,
							'overide'=>$overide,
							'tunjangan_access_control'=>$tunjangan_access_control,
							'tunjangan_bahasa_inggris'=>$tunjangan_bahasa_inggris,
							'tunjangan_bas'=>$tunjangan_bas,
							'tunjangan_fiber_optic'=>$tunjangan_fiber_optic,
							'tunjangan_fire_alarm_system'=>$tunjangan_fire_alarm_system,
							'tunjangan_fire_suppression'=>$tunjangan_fire_suppression,
							'tunjangan_gpon'=>$tunjangan_gpon,
							'tunjangan_jabatan'=>$tunjangan_jabatan,
							'tunjangan_perimeter_intrusion'=>$tunjangan_perimeter_intrusion,
							'tunjangan_public_address'=>$tunjangan_public_address,
							'tunjangan_bpjs'=>$tunjangan_bpjs,
							'potongan_bpjs'=>$potongan_bpjs
					);
					

					$this->absence_model->add('employee_salary_by_periode',$data);
					
		}
		redirect('absence/absent_list');
		
	}
	function approved_salary_detail($periode_from , $periode_to ,$type=0){
		$this->data['company_list'] = $this->absence_model->show_company_list();
		$this->data['department_list'] = $this->absence_model->show_department_list();
		$this->data['approval_list'] = $this->absence_model->get_employee_salary_by_periode_active($periode_from,$periode_to );
		$this->data['total_salary_by_division'] = $this->absence_model->total_salary_by_division_active($periode_from,$periode_to);
		$this->data['total_salary_by_department'] = $this->absence_model->total_salary_by_department_active($periode_from,$periode_to);
		//pre($this->data['approval_list']);
		$this->data['periode_from'] = $periode_from;
		$this->data['periode_to'] = $periode_to;
		$this->data['type'] = $type;
		$this->data['page'] = 'absence/list_for_approval';
		$this->load->view('common/body', $this->data);
	}
	function do_update_salary_by_periode($periode_from,$periode_to,$status){
		
		if(!find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","absence/salary_approval","privilege_tb"))redirect('home');
		$sisa_cuti = 0;
		 if($status == 5 ){
			$temp = $this->absence_model->get_employee_salary_by_periode($periode_from,$periode_to );
			if($temp)foreach($temp as $t){
				$userid = $t['user_id'];
				$off = $t['absent'];
				$tambah_utang = $t['debt'];
				$bayar_utang = $t['paid'];
				$cuti = find_2('dayoff','userid',$t['user_id'],'employee_salary_tb') - $off;
				
				if($cuti < 0)$sisa_cuti = 0;
				else $sisa_cuti = $cuti;
				
				$this->absence_model->cut_cuti($userid,$sisa_cuti,$tambah_utang,$bayar_utang);
				
			}	
		}
		$this->absence_model->do_update_salary_by_periode($periode_from,$periode_to,$status);
		redirect('absence/approval_list');
	}
	function print_salary(){
		$this->load->view('absence/print_salary', $this->data);
	}
	
	function send_salary($periode_from,$periode_to,$status){
		$this->data['status'] = $status;
		$this->data['periode_from'] = $periode_from;
		$this->data['periode_to'] = $periode_to;
		
		$this->data['department_list'] = $this->absence_model->show_department_list();
		$this->data['salary_list'] = $this->absence_model->get_slip_salary_active(date('Y-m-d 00:00:00',$periode_from),date('Y-m-d 00:00:00',$periode_to));
		
		$this->load->view('absence/print_salary', $this->data);
	}
	
	function send_salary_email($periode_from,$periode_to,$status){
		$this->data['status'] = $status;
		$this->data['periode_from'] = $periode_from;
		$this->data['periode_to'] = $periode_to;
		
		$department_list = $this->absence_model->show_department_list();
		$salary_list = $this->absence_model->get_slip_salary_active(date('Y-m-d 00:00:00',$periode_from),date('Y-m-d 00:00:00',$periode_to));
		$email_content = '';
		//pre($salary_list);exit;
		//$x=1;
		if($salary_list)foreach($salary_list as $list){
			//if($list['employee_id']==10 || $list['employee_id']==3 || $list['employee_id']==4 || $list['employee_id']==6 || $list['employee_id']==35){
				//if($list['employee_id']==120 || $list['employee_id']==29 || $list['employee_id']==50 || $list['employee_id']==60){
				////////////////
				$this->data['list'] = $list;
				$email_content = $this->load->view('absence/print_salary_email',$this->data,TRUE);
				///////////////
				$to_email = find_2('email','id',$list['employee_id'],'employee_tb');
				//if($to_email)
				//echo $to_email."<br>";
				//$to_email = "david@isysedge.com";
				//$to_email = "priscila@smartsystemsecurity.com";
				$subject = "Slip Gaji - ".date('D, d F Y',$periode_from)." / ".date('D, d F Y',$periode_to);
				$this->load->library('email'); 
				$this->email->from("salary@gsindonesia.com");
				$this->email->to($to_email);
					
				$this->email->subject($subject);
				$this->email->message($email_content);  
				$this->email->send();
				//$x++;
			//}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function send_salary_email_single(){
		$periode_from = $this->input->post('periode_from');
		$periode_to = $this->input->post('periode_to');
		$id = $this->input->post('id');
		$this->data['periode_from'] = $periode_from;
		$this->data['periode_to'] = $periode_to;
		
		//$department_list = $this->absence_model->show_department_list();
		//$salary_list = $this->absence_model->get_slip_salary(date('Y-m-d 00:00:00',$periode_from),date('Y-m-d 00:00:00',$periode_to));
		$email_content = '';
		
		//if($salary_list)foreach($salary_list as $list){
			$this->data['list'] = $list = $this->absence_model->get_employee_salary_detail($id);;
			$email_content = $this->load->view('absence/print_salary_email',$this->data,TRUE);
			//echo $email_content;exit;
			///////////////
			$to_email = find_2('email','id',$list['employee_id'],'employee_tb');
			
			$subject = "Slip Gaji - ".date('D, d F Y',$periode_from)." / ".date('D, d F Y',$periode_to);
			$this->load->library('email'); 
			$this->email->from("salary@gsindonesia.com");
			$this->email->to($to_email);
				
			$this->email->subject($subject);
			$this->email->message($email_content);  
			$this->email->send();
		//}
		//redirect($_SERVER['HTTP_REFERER']);
	}
	
	function reject_salary_detail($periode_from , $periode_to,$type = 0){
		$this->data['company_list'] = $this->absence_model->show_company_list();
		$this->data['department_list'] = $this->absence_model->show_department_list();
		$this->data['reject_list'] = $this->absence_model->get_employee_salary_by_periode_reject($periode_from,$periode_to );
		$this->data['periode_from'] = $periode_from;
		$this->data['periode_to'] = $periode_to;
		$this->data['type'] = $type;
		$this->data['page'] = 'absence/reject_list';
		$this->load->view('common/body', $this->data);
	}
	
	function do_update_rejected_salary_by_periode(){
		$n = $this->input->post('qty');
		$type = $this->input->post('type');
		$periode_from = $this->input->post('periode_from');
		$periode_to = $this->input->post('periode_to');
		$active_day = $this->input->post('active_day');
		for($i=1;$i<$n;$i++)
		{
			$userid = $this->input->post('userid'.$i);
			$id = $this->input->post('id_'.$i);
			//echo $i."-".$id."-".$type."<br>";
			
			$working_day = $this->input->post('working_day'.$i);
			$overtime_1 = $this->input->post('overtime_1'.$i);
			$overtime_2 = $this->input->post('overtime_2'.$i);
			
			$absent = $this->input->post('absent'.$i);
			$late = $this->input->post('late'.$i);
			$late_cost = $this->input->post('late_cost'.$i);
			$pph21 = find_2('pph21','userid',$userid,'employee_salary_tb');
			$over_payment = $this->input->post('over_payment'.$i);
			$under_payment = $this->input->post('under_payment'.$i);
			$meeting_cost = $this->input->post('meeting_cost'.$i);
			$insurance = find_2('insurance','userid',$userid,'employee_salary_tb');
			$debt = $this->input->post('debt'.$i);
			$paid = $this->input->post('paid'.$i);
			$overide = $this->input->post('overide'.$i);
			$status = 0;
			$target = $this->input->post('target'.$i);
			$bonus_performance = $this->input->post('bonus_performance'.$i);
			
			$notes = $this->input->post('notes'.$i);
			
			$join_date = find_2('join_date','userid',$userid,'employee_tb');
			if($join_date!='0000-00-00'){
				$bonus_massa_year_count = strtotime(date('Y-m-d')) - strtotime($join_date);
				$bonus_massa_year = date('Y',$bonus_massa_year_count)-1970;
				if($bonus_massa_year>=2){
					//$bonus_massa = $bonus_massa_year;
					$bonus_massa = find_2('meal','userid',$userid,'employee_salary_tb')*$bonus_massa_year*2;
				}else{
					$bonus_massa = 0;	
				}
			}else $bonus_massa = 0;
			
			$meal = $working_day * find_2('meal','userid',$userid,'employee_salary_tb');
			$vehicle = find_2('vehicle','userid',$userid,'employee_salary_tb');
			if(find_2('department_id','userid',$userid,'employee_tb')==1){
				$overtime_cost = find_2('overtime_1','userid',$userid,'employee_salary_tb') * $overtime_1;
				$overtime_cost_2 = find_2('overtime_2','userid',$userid,'employee_salary_tb') * $overtime_2;
			}else{
				$overtime_cost = 0;	
				$overtime_cost_2 = find_2('overtime_2','userid',$userid,'employee_salary_tb') * $overtime_2;
			}
			
			$cut = $pph21 + $late_cost + $over_payment + $paid + $insurance + $meeting_cost ;
			
			$gaji_pokok = find_2('salary','userid',$userid,'employee_salary_tb');
			$last_debt = find_2('debt','userid',$userid,'employee_salary_tb');
			$last_dayoff = find_2('dayoff','userid',$userid,'employee_salary_tb');
			
			$salary_on_hold = 0;
			if(find_2('department_id','userid',$userid,'employee_tb')==4){
				if(!$target){
					$gaji_pokok = $gaji_pokok/2;
					$salary_on_hold = $gaji_pokok;
				}
			}
			
			$cuti = $absent;
			if($last_dayoff<=0)$last_dayoff=0;
			$sisa_cuti = $last_dayoff - $cuti;
			if($sisa_cuti>=0){
				$total_gaji_pokok = $gaji_pokok;
				$meal = $active_day * find_2('meal','userid',$userid,'employee_salary_tb');
			}else{
				$total_gaji_pokok = (($active_day + $sisa_cuti)*$gaji_pokok/$active_day);
				$meal = ($active_day + $sisa_cuti) * find_2('meal','userid',$userid,'employee_salary_tb');
			}
			
			
			$tunjangan_jabatan = find_2('tunjangan_jabatan','userid',$userid,'employee_salary_tb');
			$tunjangan_bahasa_inggris = find_2('tunjangan_bahasa_inggris','userid',$userid,'employee_salary_tb');
			$tunjangan_access_control = find_2('tunjangan_access_control','userid',$userid,'employee_salary_tb');
			$tunjangan_fire_alarm_system = find_2('tunjangan_fire_alarm_system','userid',$userid,'employee_salary_tb');
			$tunjangan_fire_suppression = find_2('tunjangan_fire_suppression','userid',$userid,'employee_salary_tb');
			$tunjangan_bas = find_2('tunjangan_bas','userid',$userid,'employee_salary_tb');
			$tunjangan_gpon = find_2('tunjangan_gpon','userid',$userid,'employee_salary_tb');
			$tunjangan_perimeter_intrusion = find_2('tunjangan_perimeter_intrusion','userid',$userid,'employee_salary_tb');
			$tunjangan_public_address = find_2('tunjangan_public_address','userid',$userid,'employee_salary_tb');
			$tunjangan_fiber_optic = find_2('tunjangan_fiber_optic','userid',$userid,'employee_salary_tb');
			$tunjangan_bpjs = find_2('tunjangan_bpjs','userid',$userid,'employee_salary_tb');
			$potongan_bpjs = find_2('potongan_bpjs','userid',$userid,'employee_salary_tb');
			
			$total_tunjangan=$tunjangan_jabatan+$tunjangan_bahasa_inggris+$tunjangan_access_control+$tunjangan_fire_alarm_system+$tunjangan_fire_suppression+$tunjangan_bas+$tunjangan_gpon+$tunjangan_perimeter_intrusion+$tunjangan_public_address+$tunjangan_fiber_optic+$tunjangan_bpjs-$potongan_bpjs;
			
			//$salary = $total_gaji_pokok + $meal + $vehicle + $overtime_cost + $overtime_cost_2 + $bonus_massa + $bonus_performance + $under_payment + $debt - $cut;
			//utang tidak termasuk..hanya pemberitahuan
			$salary = $total_gaji_pokok + $meal + $vehicle + $overtime_cost + $overtime_cost_2 + $bonus_massa + $bonus_performance + $under_payment - $cut + $total_tunjangan;
			
			if(find_2('department_id','userid',$userid,'employee_tb')==3){
				$total_gaji_pokok =	find_2('salary','userid',$userid,'employee_salary_tb');		
				$salary = $total_gaji_pokok - $cut;
				$bonus_massa = 0;
			}
			
			
			$data = array(
					'working_day'=>$working_day,
					'salary'=>$salary,
					'salary_monthly'=>$total_gaji_pokok,
					'salary_on_hold'=>$salary_on_hold,
					'meal'=>$meal,
					'vehicle'=>$vehicle,
					'overtime_1'=>$overtime_1,
					'overtime_2'=>$overtime_2,
					'overtime_1_cost'=>$overtime_cost,
					'overtime_2_cost'=>$overtime_cost_2,
					'bonus_massa'=>$bonus_massa,
					'bonus_performance'=>$bonus_performance,
					'absent'=>$absent,
					'late'=>$late,
					'pph21'=>$pph21,
					'late_cost'=>$late_cost,
					'over_payment'=>$over_payment,
					'under_payment'=>$under_payment,
					'meeting_cost'=>$meeting_cost,
					'insurance'=>$insurance,
					'status'=>$status,
					'debt'=>$debt,
					'paid'=>$paid,
					'overide'=>$overide,
					'target'=>$target,
					'last_debt'=>$last_debt,
					'last_dayoff'=>$last_dayoff,
					'notes'=>$notes,
					'tunjangan_access_control'=>$tunjangan_access_control,
					'tunjangan_bahasa_inggris'=>$tunjangan_bahasa_inggris,
					'tunjangan_bas'=>$tunjangan_bas,
					'tunjangan_fiber_optic'=>$tunjangan_fiber_optic,
					'tunjangan_fire_alarm_system'=>$tunjangan_fire_alarm_system,
					'tunjangan_fire_suppression'=>$tunjangan_fire_suppression,
					'tunjangan_gpon'=>$tunjangan_gpon,
					'tunjangan_jabatan'=>$tunjangan_jabatan,
					'tunjangan_perimeter_intrusion'=>$tunjangan_perimeter_intrusion,
					'tunjangan_public_address'=>$tunjangan_public_address,
					'tunjangan_bpjs'=>$tunjangan_bpjs,
					'potongan_bpjs'=>$potongan_bpjs,
					'bonus_perfomance_update'=>1
					);
			$this->absence_model->edit('employee_salary_by_periode',$data,$id);
			
			//change status to absen 2 approval
			/*if($type == 2 || $type == 3 || $type == 4){
				$type=3;
				$this->absence_model->update_status_absence($id,$type);
			}else{
				$type = 0;
				$this->absence_model->update_status_absence($id,$type);
			}*/
				
		}
		//exit;
		if($type == 2 || $type == 3 || $type == 4){
			$type=3;
			$this->absence_model->update_status_absence_2($periode_from,$periode_to,$type);
		}else{
			$type = 0;
			$this->absence_model->update_status_absence_2($periode_from,$periode_to,$type);
		}
		
		$_SESSION['admin_notif'] = 'Salary Has Been Updated';
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_step($periode_from,$periode_to,$step){
		$this->absence_model->change_step($periode_from,$periode_to,$step);
		redirect($_SERVER['HTTP_REFERER']);
	}
}?>