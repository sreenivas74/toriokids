<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Absence_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function get_employee_salary_detail($id){
		$sql = "select * from employee_salary_by_periode where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);	
	}
	
	function get_slip_gaji($id){
		$sql = "select * from employee_salary_by_periode where id = '".esc($id)."'";
		return $this->fetch_single_row($sql);
	}
	
	function total_salary_by_division($periode_from,$periode_to){
		$from = date("Y-m-d",($periode_from))." 00:00:00";
		$to = date("Y-m-d",($periode_to))." 00:00:00";
		$sql = "SELECT company_id,sum(salary)as total_gaji FROM employee_salary_by_periode esp
				left join employee_tb e on esp.employee_id = e.id
				where periode_from >= '".esc($from)."' and periode_to <= '".esc($to)."'
				group by company_id
				order by company_id";
		return $this->fetch_multi_row($sql);	
	}
	
	function total_salary_by_division_active($periode_from,$periode_to){
		$from = date("Y-m-d",($periode_from))." 00:00:00";
		$to = date("Y-m-d",($periode_to))." 00:00:00";
		$sql = "SELECT company_id,sum(salary)as total_gaji FROM employee_salary_by_periode esp
				left join employee_tb e on esp.employee_id = e.id
				where e.status=1 and periode_from >= '".esc($from)."' and periode_to <= '".esc($to)."'
				group by company_id
				order by company_id";
		return $this->fetch_multi_row($sql);	
	}
	
	function total_salary_by_department($periode_from,$periode_to){
		$from = date("Y-m-d",($periode_from))." 00:00:00";
		$to = date("Y-m-d",($periode_to))." 00:00:00";
		$sql = "SELECT company_id,department_id,sum(salary)as total_gaji,sum(meeting_cost)as total_celengan,sum(late_cost)as total_late FROM employee_salary_by_periode esp
				left join employee_tb e on esp.employee_id = e.id
				where periode_from >= '".esc($from)."' and periode_to <= '".esc($to)."'
				group by company_id,department_id
				order by company_id,department_id";
		return $this->fetch_multi_row($sql);	
	}
	
	function total_salary_by_department_active($periode_from,$periode_to){
		$from = date("Y-m-d",($periode_from))." 00:00:00";
		$to = date("Y-m-d",($periode_to))." 00:00:00";
		$sql = "SELECT company_id,department_id,sum(salary)as total_gaji,sum(meeting_cost)as total_celengan,sum(late_cost)as total_late FROM employee_salary_by_periode esp
				left join employee_tb e on esp.employee_id = e.id
				where e.status=1 and periode_from >= '".esc($from)."' and periode_to <= '".esc($to)."'
				group by company_id,department_id
				order by company_id,department_id";
		return $this->fetch_multi_row($sql);	
	}
	
	function do_update_slip_gaji($id,$working_day,$absent,$overtime_1,$overtime_1_cost,$overtime_2,$overtime_2_cost,$late,$late_cost,$overide,$last_dayoff,$last_debt,$debt,$paid,$under_payment,$over_payment,$meal,$vehicle,$meeting_cost,$bonus_massa,$bonus_performance,$insurance,$pph21,$salary_monthly,$salary,$notes){
		$sql = "update employee_salary_by_periode set
				working_day = '".esc($working_day)."',
				absent = '".esc($absent)."',
				overtime_1 = '".esc($overtime_1)."',
				overtime_2 = '".esc($overtime_2)."',
				overtime_1_cost = '".esc($overtime_1_cost)."',
				overtime_2_cost = '".esc($overtime_2_cost)."',
				overide = '".esc($overide)."',
				late = '".esc($late)."',
				late_cost = '".esc($late_cost)."',
				last_dayoff = '".esc($last_dayoff)."',
				last_debt = '".esc($last_debt)."',
				debt = '".esc($debt)."',
				paid = '".esc($paid)."',
				under_payment = '".esc($under_payment)."',
				over_payment = '".esc($over_payment)."',
				meal = '".esc($meal)."',
				vehicle = '".esc($vehicle)."',
				meeting_cost = '".esc($meeting_cost)."',
				bonus_massa = '".esc($bonus_massa)."',
				bonus_performance = '".esc($bonus_performance)."',
				insurance = '".esc($insurance)."',
				pph21 = '".esc($pph21)."',
				salary = '".esc($salary)."',
				salary_monthly = '".esc($salary_monthly)."',
				notes = '".esc($notes)."'
				where id = '".esc($id)."'";
		$this->db->query($sql);	
	}
	
	function do_update_slip_gaji2($id,$tunjangan_jabatan,$tunjangan_bahasa_inggris,$tunjangan_access_control,$tunjangan_fire_alarm_system,$tunjangan_fire_suppression,$tunjangan_bas,$tunjangan_gpon,$tunjangan_perimeter_intrusion,$tunjangan_fiber_optic,$tunjangan_bpjs,$potongan_bpjs){
		
		$sql = "update employee_salary_by_periode set
				tunjangan_jabatan = '".esc($tunjangan_jabatan)."',
				tunjangan_bahasa_inggris = '".esc($tunjangan_bahasa_inggris)."',
				tunjangan_access_control = '".esc($tunjangan_access_control)."',
				tunjangan_fire_alarm_system = '".esc($tunjangan_fire_alarm_system)."',
				tunjangan_fire_suppression = '".esc($tunjangan_fire_suppression)."',
				tunjangan_bas = '".esc($tunjangan_bas)."',
				tunjangan_gpon = '".esc($tunjangan_gpon)."',
				tunjangan_perimeter_intrusion = '".esc($tunjangan_perimeter_intrusion)."',
				tunjangan_fiber_optic = '".esc($tunjangan_fiber_optic)."',
				tunjangan_bpjs = '".esc($tunjangan_bpjs)."',
				potongan_bpjs = '".esc($potongan_bpjs)."'
				where id = '".esc($id)."'";//echo $sql."<br>";
		$this->db->query($sql);	
	}
	
	function change_step($periode_from,$periode_to,$step){
		$sql = "update employee_salary_by_periode set status = '".esc($step)."' where periode_from = '".esc($periode_from)."' and periode_to = '".esc($periode_to)."'";
		$this->db->query($sql);
	}
	
	function show_company_list(){
		$sql = "select * from company_tb order by id";
		return $this->fetch_multi_row($sql);		
	}
	
	function get_slip_salary($periode_from,$periode_to){
		$sql = "select * from employee_salary_by_periode where periode_from = '".esc($periode_from)."' and periode_to = '".esc($periode_to)."'";
		
		$sql=" select a.*, b.nik, b.firstname, b.lastname, b.grade, b.job_title from employee_salary_by_periode a
left join employee_tb b on a.employee_id=b.id
where periode_from = '".esc($periode_from)."' and periode_to = '".esc($periode_to)."'";
		//echo $sql;
		return $this->fetch_multi_row($sql);	
	}
	
	function get_slip_salary_active($periode_from,$periode_to){
		$sql = "select * from employee_salary_by_periode where periode_from = '".esc($periode_from)."' and periode_to = '".esc($periode_to)."'";
		
		$sql=" select a.*, b.nik, b.firstname, b.lastname, b.grade, b.job_title from employee_salary_by_periode a
left join employee_tb b on a.employee_id=b.id
where periode_from = '".esc($periode_from)."' and periode_to = '".esc($periode_to)."' and b.status=1";
		//echo $sql;
		return $this->fetch_multi_row($sql);	
	}
	
	function update_status_absence($id,$type){
		$sql = "update employee_salary_by_periode set status = ".esc($type)." where id = '".esc($id)."'";
		$this->execute_dml($sql);	
	}
	
	function update_status_absence_2($periode_from,$periode_to,$type){
		$sql = "update employee_salary_by_periode set status = ".esc($type)." where periode_from = '".esc($periode_from)."' and periode_to = '".esc($periode_to)."'";
		$this->execute_dml($sql);
	}
	
	function delete_old_absent_data($periode_from,$periode_to,$active_day,$year,$month){
		$sql = "delete from salary_tb where periode_from = '".esc($periode_from)."' and periode_to = '".esc($periode_to)."' and active_day = '".esc($active_day)."' and year = '".esc($year)."' and month = '".esc($month)."'";
		$this->execute_dml($sql);
	}
	
	function get_salary_periode_detail_by_userid($userid){
		$sql = "select * from employee_salary_by_periode where user_id = '".esc($userid)."'";
		return $this->fetch_single_row($sql);
	}
	
	function update_to_old_data($userid,$absent,$debt,$paid){
		$sql = "update employee_salary_tb set dayoff = (dayoff + ".esc($absent)."), debt = (debt - ".esc($debt)." + ".esc($paid).") where userid = '".esc($userid)."'";
		$this->execute_dml($sql);	
	}
	
	function delete_salary_pending($periode_from,$periode_to){
		$sql = "delete from salary_tb where periode_from = '".esc(date('Y-m-d',$periode_from))."' and periode_to = '".esc(date('Y-m-d',$periode_to))."'";
		$this->execute_dml($sql);	
		
		$sql = "delete from absence_salary_tb where periode_from = '".esc(date('Y-m-d',$periode_from))."' and periode_to = '".esc(date('Y-m-d',$periode_to))."'";
		$this->execute_dml($sql);
		
		$sql = "delete from employee_salary_by_periode where periode_from = '".esc(date('Y-m-d',$periode_from))."' and periode_to = '".esc(date('Y-m-d',$periode_to))."'";
		$this->execute_dml($sql);
	}
	
	function update_to_new_data($userid,$absent,$debt,$paid){
		if(!$absent)$absent = 0;
		if(!$debt)$debt = 0;
		if(!$paid)$paid = 0;
		$sql = "update employee_salary_tb set dayoff = (dayoff - ".esc($absent)."), debt = (debt + ".(esc($debt))." - ".esc($paid).") where userid = '".esc($userid)."'";
		
		$this->execute_dml($sql);	
	}
	
	function add($tabel,$data)
	{
		 $this->db->insert($tabel, $data);
	}
	//upload file salary monthly//////////////////////////////////////////////////////////////////////////////////
	function insert_salary_monthly($userid,$employee_id,$periode_from,$periode_to,$checkin_date,$checkout_date,$active_day,$in,$off,$overide,$input_by,$input_date){
		$data_1 = '';$data_2 = '';
		if($checkin_date){$data_1 = ",checkin_date";$data_2 = $checkin_date;}
		if($checkout_date){$data_1 = ",checkout_date";$data_2 = $checkout_date;}
		$sql = "insert into salary_tb (userid,employee_id,periode_from,periode_to,active_day,absent,off,overide,input_by,input_date".$data_1.")
				values ('".esc($userid)."',
						'".esc($employee_id)."',
						'".esc($periode_from)."',
						'".esc($periode_to)."',
						'".esc($active_day)."',
						'".esc($in)."',
						'".esc($off)."',
						'".esc($overide)."',
						'".esc($input_by)."',
						'".esc($input_date)."'
						'".esc($data_2)."')";
		$this->db->query($sql);	
	}
	
	
	function update_salary_monthly($userid,$employee_id,$periode_from,$periode_to,$checkin_date,$checkout_date,$active_day,$in,$off,$overide,$input_by,$input_date){
		$data = '';
		if($checkin_date)$data = ", checkin_date = '".esc($checkin_date)."' ";
		if($checkout_date)$data = ", checkin_date = '".esc($checkout_date)."' ";
		$sql = "update salary_tb set 	absent = (absent + ".esc($in)."),
										off = (off + ".esc($off)."),
										overide = (overide + ".esc($overide).")
										".$data."
										where userid = '".esc($userid)."'
										and employee_id = '".esc($employee_id)."'
										and periode_from = '".esc($periode_from)."'
										and periode_to = '".esc($periode_to)."'";
		$this->db->query($sql);
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function show_employee_active(){
		$sql = "select * from employee_tb where status = 1 order by firstname,lastname";
		return $this->fetch_multi_row($sql);	
	}
	
	function insert_salary($userid,$list,$salary,$meal,$dayoff,$vehicle,$overtime_1,$overtime_2,$insurance,$debt,$pph21,$created_date,$created_by,$tunjangan_jabatan,$tunjangan_bahasa_inggris,$tunjangan_access_control,$tunjangan_fire_alarm_system,$tunjangan_fire_suppression,$tunjangan_bas,$tunjangan_gpon,$tunjangan_perimeter_intrusion,$tunjangan_public_address,$tunjangan_fiber_optic,$tunjangan_bpjs,$potongan_bpjs){
		$sql = "insert into employee_salary_tb (userid,employee_id,salary,meal,dayoff,vehicle,overtime_1,overtime_2,insurance,debt,pph21,created_date,created_by,tunjangan_jabatan,tunjangan_bahasa_inggris,tunjangan_access_control,tunjangan_fire_alarm_system,tunjangan_fire_suppression,tunjangan_bas,tunjangan_gpon,tunjangan_perimeter_intrusion,tunjangan_public_address,tunjangan_fiber_optic,tunjangan_bpjs,potongan_bpjs)
				values ('".esc($userid)."',
						'".esc($list)."',
						'".esc($salary)."',
						'".esc($meal)."',
						'".esc($dayoff)."',
						'".esc($vehicle)."',
						'".esc($overtime_1)."',
						'".esc($overtime_2)."',
						'".esc($insurance)."',
						'".esc($debt)."',
						'".esc($pph21)."',
						'".esc($created_date)."',
						'".esc($created_by)."',
						'".esc($tunjangan_jabatan)."',
						'".esc($tunjangan_bahasa_inggris)."',
						'".esc($tunjangan_access_control)."',
						'".esc($tunjangan_fire_alarm_system)."',
						'".esc($tunjangan_fire_suppression)."',
						'".esc($tunjangan_bas)."',
						'".esc($tunjangan_gpon)."',
						'".esc($tunjangan_perimeter_intrusion)."',
						'".esc($tunjangan_public_address)."',
						'".esc($tunjangan_fiber_optic)."',
						'".esc($tunjangan_bpjs)."',
						'".esc($potongan_bpjs)."')";
		$this->execute_dml($sql);
	}
	function update($data,$id)
	{
		$this->db->update('salary_tb',$data,array('id'=>$id));	
	}
	function update_salary($userid,$list,$salary,$meal,$dayoff,$vehicle,$overtime_1,$overtime_2,$insurance,$debt,$pph21,$created_date,$created_by,$tunjangan_jabatan,$tunjangan_bahasa_inggris,$tunjangan_access_control,$tunjangan_fire_alarm_system,$tunjangan_fire_suppression,$tunjangan_bas,$tunjangan_gpon,$tunjangan_perimeter_intrusion,$tunjangan_public_address,$tunjangan_fiber_optic,$tunjangan_bpjs,$potongan_bpjs){
	 	$sql = "update employee_salary_tb set 	userid = '".esc($userid)."',
												salary = '".esc($salary)."',
												meal = '".esc($meal)."',
												dayoff = '".esc($dayoff)."',
												vehicle = '".esc($vehicle)."',
												overtime_1 = '".esc($overtime_1)."',
												overtime_2 = '".esc($overtime_2)."',
												insurance = '".esc($insurance)."',
												debt = '".esc($debt)."',
												pph21 = '".esc($pph21)."',
												created_date = '".esc($created_date)."',
												created_by = '".esc($created_by)."',
												
												tunjangan_jabatan = '".esc($tunjangan_jabatan)."',
												tunjangan_bahasa_inggris = '".esc($tunjangan_bahasa_inggris)."',
												tunjangan_access_control = '".esc($tunjangan_access_control)."',
												tunjangan_fire_alarm_system = '".esc($tunjangan_fire_alarm_system)."',
												tunjangan_fire_suppression = '".esc($tunjangan_fire_suppression)."',
												tunjangan_bas = '".esc($tunjangan_bas)."',
												tunjangan_gpon = '".esc($tunjangan_gpon)."',
												tunjangan_perimeter_intrusion = '".esc($tunjangan_perimeter_intrusion)."',
												tunjangan_public_address = '".esc($tunjangan_public_address)."',
												tunjangan_fiber_optic = '".esc($tunjangan_fiber_optic)."',
												tunjangan_bpjs = '".esc($tunjangan_bpjs)."',
												potongan_bpjs = '".esc($potongan_bpjs)."'
												where employee_id = '".esc($list)."'";
		$this->execute_dml($sql);	
	}
	
	function show_department_list(){
		$sql = "select * from department_tb where active = 1 order by id";
		return $this->fetch_multi_row($sql);	
	}
	
	function update_userid_to_employee($userid,$employee_id){
		$sql = "update employee_tb set userid = '".esc($userid)."' where id = '".esc($employee_id)."'";
		$this->db->query($sql);	
	}
	function get_absence_list($periode_from,$periode_to)
	{
		//$sql = "select userid, sum(`absent`) as masuk , sum(`overtime`) as overtime, sum(`late`) as late from salary_tb where UNIX_TIMESTAMP(`periode_from`)>= '".esc($periode_from)."' and UNIX_TIMESTAMP(`periode_to`)<= '".esc($periode_to)."' group by userid";
		$sql = "select userid, sum(`absent`) as masuk , sum(`overtime`) as overtime , sum(`overtime_2`) as overtime_2, sum(`late`) as late, sum(overide) as overide, year , month from salary_tb where periode_from >= '".esc(date('Y-m-d',$periode_from))."' and periode_to <= '".esc(date('Y-m-d',$periode_to))."' group by userid";
		
		return $this->fetch_multi_row($sql);	
	}
	function get_absence_salary_list($periode_from,$periode_to)
	{
		//$sql = "select * from absence_salary_tb where UNIX_TIMESTAMP(`periode_from`)>= '".esc($periode_from)."' and UNIX_TIMESTAMP(`periode_to`)<= '".esc($periode_to)."'";
		$sql = "select * from absence_salary_tb where periode_from = '".esc(date('Y-m-d',$periode_from))."' and periode_to <= '".esc(date('Y-m-d',$periode_to))."'";
		return $this->fetch_multi_row($sql);	
	}
	function show_approval_list()
	{
	 $sql = "select DISTINCT periode_from , periode_to , status from employee_salary_by_periode where status = 0 or status = 3 or status = 5 order by periode_from desc";
	 return $this->fetch_multi_row($sql);
	 
	}
	function get_employee_salary_by_periode($periode_from , $periode_to)
	{
		$sql = "select * from employee_salary_by_periode where periode_from >= '".esc(date('Y-m-d',$periode_from))."' and periode_to <= '".esc(date('Y-m-d',$periode_to))."'";
		
		
		$sql = "select * from employee_salary_by_periode where periode_from = '".esc($periode_from)."' and periode_to = '".esc($periode_to)."'";
		
		$sql=" select a.*, b.nik, b.firstname, b.lastname, b.grade, b.job_title from employee_salary_by_periode a
left join employee_tb b on a.employee_id=b.id
where periode_from >= '".esc(date('Y-m-d',$periode_from))."' and periode_to <= '".esc(date('Y-m-d',$periode_to))."'";
		//echo $sql;
		
		return $this->fetch_multi_row($sql);
		
	}
	
	function get_employee_salary_by_periode_active($periode_from , $periode_to)
	{
		$sql = "select * from employee_salary_by_periode where periode_from >= '".esc(date('Y-m-d',$periode_from))."' and periode_to <= '".esc(date('Y-m-d',$periode_to))."'";
		
		
		$sql = "select * from employee_salary_by_periode where periode_from = '".esc($periode_from)."' and periode_to = '".esc($periode_to)."'";
		
		$sql=" select a.*, b.nik, b.firstname, b.lastname, b.grade, b.job_title from employee_salary_by_periode a
left join employee_tb b on a.employee_id=b.id
where periode_from >= '".esc(date('Y-m-d',$periode_from))."' and periode_to <= '".esc(date('Y-m-d',$periode_to))."'";
		//echo $sql;
		
		//echo $sql;
		return $this->fetch_multi_row($sql);
		
	}
	
	function cut_cuti($userid,$off,$tambah_utang,$bayar_utang){
		$sql = "update employee_salary_tb set 	dayoff = '".esc($off)."',
												debt = debt + ".esc($tambah_utang)." - ".esc($bayar_utang).",
												paid = paid + ".esc($bayar_utang)."
												where userid = '".esc($userid)."'";
		$this->execute_dml($sql);
	}
	
	function get_employee_salary_by_periode_reject($periode_from , $periode_to)
	{
		$sql = "select * from employee_salary_by_periode where periode_from >= '".esc(date('Y-m-d',$periode_from))."' and periode_to <= '".esc(date('Y-m-d',$periode_to))."'";
		return $this->fetch_multi_row($sql);
	}
	function do_update_salary_by_periode($periode_from,$periode_to,$status)
	{
		$sql = "update employee_salary_by_periode set status = '".esc($status)."'  where periode_from >= '".esc(date('Y-m-d',$periode_from))."' and periode_to <= '".esc(date('Y-m-d',$periode_to))."'";
		$this->db->query($sql);	
	}
	function get_reject_list()
	{
	$sql = "select distinct periode_from , periode_to,status from employee_salary_by_periode order by periode_from desc";
		return $this->fetch_multi_row($sql);
	}
	function edit($tabel , $data,$id)
	{
		$this->db->update($tabel,$data,array('id'=>$id));	
	}
	function edit1($tabel , $data,$id)
	{
		$this->db->update($tabel,$data,array('userid'=>$id));	
	}
	function edit_employee_salary($data,$id)
	{
		$this->db->update('employee_salary_tb',$data,array('userid'=>$id));	
	}

}?>