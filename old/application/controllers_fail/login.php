<?php if(!defined("BASEPATH")) exit("Hack Attempt");
	class Login extends Ext_Controller{
		function __construct(){
			parent::__construct();
			if($this->sentry->admin_is_logged_in() == TRUE) redirect('home');
			$this->data['loginPage'] = '1';
			$this->load->model('admin_model');
		}
		
		function index(){
			$this->data['page'] = 'login';
			$this->load->view('common/body', $this->data);
		}
		function do_login(){
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));
			
			if(!$username || !$password){
				$this->data['errLogin'] = 'Invalid username or password';
				$this->data['page'] = 'login';
				$this->load->view('common/body',$this->data);
			}
			else{
				$login = $this->admin_model->login($username, $password);
				$month_before=date("Y-m-d",strtotime("-3 Months"));
				$newdate=date("Y-m-d");
				if ($login != NULL) {
					if(($login['last_change_password']>=$month_before) && ($login['last_change_password']<=$newdate))
						{
							
									$sess_admin = array (
										   'admin_logged_in' => true,
										   'admin_id' => $login['id'],
										   'employee_id' => $login['employee_id'],
										   'admin_fullname' => $login['name'],
										   'admin_username' => $login['username'],
										   'admin_last_login' => $login['last_login'],
										   'admin_created_date' => $login['created_date'],
										   'admin_privilege' => $login['privilege_id'],
										   'admin_departemen_id'=>find('department_id',$login['employee_id'],'employee_tb')
										);
									$this->session->set_userdata($sess_admin);
									$this->admin_model->updateLastLogin($login['id']);
									
									redirect ('home');
					
							}else{
							
								$sess_admin = array (
										   'admin_logged_in' => FALSE,
										   'admin_id' => $login['id'],
										   'employee_id' => $login['employee_id'],
										   'admin_fullname' => $login['name'],
										   'admin_username' => $login['username'],
										   'admin_last_login' => $login['last_login'],
										   'admin_created_date' => $login['created_date'],
										   'admin_privilege' => $login['privilege_id'],
										   'admin_departemen_id'=>find('department_id',$login['employee_id'],'employee_tb')
										);
								$this->session->set_userdata($sess_admin);
								$this->admin_model->updateLastLogin($login['id']);
								redirect ('change_password');
							}
				}
				else {
					$this->data['page'] = 'login';
					$this->data['errLogin'] = 'Invalid username or password';
					$this->load->view('common/body', $this->data);
				}
			}
		}
		
	}