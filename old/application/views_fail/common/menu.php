<?php
$pageURL = 'http';
$pageURL .= "://";
if ($_SERVER["SERVER_PORT"] != "80") {
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}
?>
<?php if($this->session->userdata('admin_id') && $pageURL!=base_url().'ticket/'){?>
<div id="mainmenu">
    <ul>
    	<li><a href="<?php echo base_url();?>">Dashboard</a></li>
   	 	<li><a href="#" onclick="return false;">Project</a>
        	<ul>
            	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/add_crm","privilege_tb")){?>
            		<li><a href="<?php echo site_url('project/add_crm');?>">+ Add CRM</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_crm","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_crm_2","privilege_tb")){?>
                	<li><a href="<?php echo site_url('project/list_crm')?>">CRM List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_project_goal_2","privilege_tb")){?>
                	<li><a href="<?php echo site_url('project/list_project_goal')?>">Project Goal List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/add_employee_activity","privilege_tb")){?>
                	<li><a href="<?php echo site_url('project/add_employee_activity')?>">+ Add Employee Activity</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_employee_activity","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_employee_activity_2","privilege_tb")){?>
                	<li><a href="<?php echo site_url('project/list_employee_activity')?>">Employee Activity List</a></li>
                <?php }?>
            </ul>
        </li>
        <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/view_payment","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/view_budget","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/add_rf","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/view_rf","privilege_tb")){?>
        <li><a href="#" onclick="return false;">Request Funds</a>
        	<ul>
            	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/view_budget","privilege_tb")){?>
            	<li><a href="<?php echo site_url('budget/all_list')?>">Budget List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/view_payment","privilege_tb")){?>
                <li><a href="<?php echo site_url('budget/payment_list')?>">Payment List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/add_rf","privilege_tb")){?>
                <li><a href="<?php echo site_url('budget/add_request_budget')?>">Add Request Funds</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","budget/view_rf","privilege_tb")){?>
                <li><a href="<?php echo site_url('budget/request_budget_list')?>">Request Fund List</a></li>
                <?php }?>
                
                <li><a href="<?php echo site_url('budget/payment_table')?>">Payment Table</a></li>
               <?php /*?> <li><a href="<?php echo site_url('budget/reimburse_list')?>">Reimburse List</a></li>
                <li><a href="<?php echo site_url('budget/bs_list')?>">BS List</a></li><?php */?>
            </ul>
        </li>
        <?php }?>
        <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","purchase_order/view_rs","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","purchase_order/view_stock","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","purchase_order/add_rs","privilege_tb")){?>
        <li><a href="#" onclick="return false;">Purchasing</a>
        	<ul>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","purchase_order/add_rs","privilege_tb")){?>
            		<li><a href="<?php echo site_url('purchase_order/add_request_stock');?>">Add Request Stock</a></li>
                <?php }?>
                 <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","purchase_order/view_rs","privilege_tb")){?>
            		<li><a href="<?php echo site_url('purchase_order/request_stock_list');?>">Request Stock List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","purchase_order/view_stock","privilege_tb")){?>
            		<li><a href="<?php echo site_url('purchase_order/all_stock');?>">Stock</a></li>
                <?php }?>
                	<li><a href="<?php echo site_url('purchase_order/payment_list')?>">Payment List</a></li>
            </ul>
        </li>
        <?php }?>
        <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_schedule","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_schedule_2","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/add_schedule","privilege_tb")){?>
        <li><a href="#" onclick="return false;">Schedule</a>
        	<ul>
            	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/add_schedule","privilege_tb")){?>
            		<li><a href="<?php echo site_url('schedule/add_schedule_to')?>">+ Add Schedule To</a></li>
				<?php }?>
            	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/add_schedule","privilege_tb")){?>
            		<li><a href="<?php echo site_url('schedule/add_schedule')?>">+ Add Next Week Schedule</a></li>
				<?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_schedule","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_schedule_2","privilege_tb")){?>
                	<li><a href="<?php echo site_url('schedule/list_schedule')?>">Next Week Schedule List</a></li>
				<?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/add_job_tracking","privilege_tb")){?>
                	<li><a href="<?php echo site_url('schedule/add_job_tracking')?>">+ Add Job Tracking</a></li>
				<?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","schedule/list_job_tracking_2","privilege_tb")){?>
                	<li><a href="<?php echo site_url('schedule/list_job_tracking')?>">Job Tracking List</a></li>
				<?php }?>
            </ul>
        </li>
        <?php }?>
        
        <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/add_reminder","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder_2","privilege_tb")){?>
        <li><a href="#" onclick="return false;">Reminder</a>
        	<ul>
            	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/add_reminder","privilege_tb")){?>
            		<li><a href="<?php echo site_url('reminder/add_reminder')?>">+ Add Reminder</a></li>
				<?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","reminder/list_reminder_2","privilege_tb")){?>
                	<li><a href="<?php echo site_url('reminder/list_reminder')?>">Reminder List</a></li>
				<?php }?>
            </ul>
        </li>
        <?php }?>
        
        <?php  	if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/add_brand","privilege_tb")
				|| find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/list_brand","privilege_tb")
				|| find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/add_category","privilege_tb")
				|| find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/list_category","privilege_tb")
				|| find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/add_product","privilege_tb")
				|| find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/list_product","privilege_tb")
				){?>
        <li><a href="#" onclick="return false;">Product</a>
        	<ul>
            	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/add_brand","privilege_tb")){?>
            		<li><a href="<?php echo site_url('product/add_brand');?>">+ Add Brand</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/list_brand","privilege_tb")){?>
                	<li><a href="<?php echo site_url('product/list_brand')?>">Brand List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/add_category","privilege_tb")){?>
                	<li><a href="<?php echo site_url('product/add_category');?>">+ Add Category</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/list_category","privilege_tb")){?>
                	<li><a href="<?php echo site_url('product/list_category')?>">Category List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/add_product","privilege_tb")){?>
            		<li><a href="<?php echo site_url('product/add_product');?>">+ Add Product</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","product/list_product","privilege_tb")){?>
                <li><a href="<?php echo site_url('product/list_product')?>">Product List</a></li>
                <?php }?>
            </ul>
        </li>
        <?php }?>
    	<?php  if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/list_inventory","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/list_inventory_2","privilege_tb") ||find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/add_inventory","privilege_tb") ){?>
        <li><a href="#" onclick="return false;">Inventory</a>
        	<ul>
            	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/add_inventory","privilege_tb")){?>
            		<li><a href="<?php echo site_url('inventory/add_inventory');?>">+ Add Inventory</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/list_inventory","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","inventory/list_inventory_2","privilege_tb")){?>
                	<li><a href="<?php echo site_url('inventory/list_inventory')?>">Inventory List</a></li>
                <?php }?>
            </ul>
        </li>
    	<?php }?>
        <?php  if( find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/list_vendor","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/add_vendor","privilege_tb")){?>
        <li><a href="#" onclick="return false;">Vendor</a>
        	<ul>
            	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/add_vendor","privilege_tb")){?>
            		<li><a href="<?php echo site_url('vendor/add_vendor');?>">+ Add Vendor</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","vendor/list_vendor","privilege_tb")){?>
            		<li><a href="<?php echo site_url('vendor/list_vendor')?>">Vendor List</a></li>
                <?php }?>
            </ul>
        </li>
        <?php }?>
        
        <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/list_client","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/list_client_2","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/add_client","privilege_tb") ){?>
        <li><a href="#" onclick="return false;">Client</a>
        	<ul>
            	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/add_client","privilege_tb")){?>
            		<li><a href="<?php echo site_url('client/add_client');?>">+ Add Client</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/list_client","privilege_tb")  || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","client/list_client_2","privilege_tb")){?>
            		<li><a href="<?php echo site_url('client/list_client')?>">Client List</a></li>
                <?php }?>
            </ul>
        </li>
        <?php }?>
        
        <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/list_employee","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/add_employee","privilege_tb") ){?>
        <li><a href="#" onclick="return false;">Employee</a>
        	<ul>
            	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/add_employee","privilege_tb")){?>
            		<li><a href="<?php echo site_url('employee/add_employee')?>">+ Add Employee</a></li>
                <?php }?>
            	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/list_employee","privilege_tb")){?>
            		<li><a href="<?php echo site_url('employee/list_employee')?>">Employee List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","employee/list_employee_group","privilege_tb")){?>
            		<li><a href="<?php echo site_url('employee/list_employee_group')?>">Employee Group</a></li>
                <?php }?>
            </ul>
        </li>
        <?php }?>
       
        <?php //if( find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","book/list_book","privilege_tb") ||  find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","currency/list_currency","privilege_tb") ||  find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","prefix/list_prefix","privilege_tb") ||  find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","profil/list_profil","privilege_tb") || $this->session->userdata('admin_privilege') ==1 ){?>
        <li><a href="#" onclick="return false;">Setting</a>
        	<ul>
                <li><a href="<?php echo site_url('currency/list_currency')?>">Currency</a></li>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lesson_learn/add_lesson_learn","privilege_tb")){?>
                	<li><a href="<?php echo site_url('lesson_learn/add_lesson_learn')?>">+ Add Lesson Learn</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lesson_learn/list_lesson_learn","privilege_tb")){?>
                	<li><a href="<?php echo site_url('lesson_learn/list_lesson_learn')?>">Lesson Learn List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","industry/add_industry","privilege_tb")){?>
                	<li><a href="<?php echo site_url('industry/add_industry')?>">+ Add Industry</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","industry/list_industry","privilege_tb")){?>
               		<li><a href="<?php echo site_url('industry/list_industry')?>">Industry List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lead_source/add_lead_source","privilege_tb")){?>
                    <li><a href="<?php echo site_url('lead_source/add_lead_source')?>">+ Add Lead Source</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","lead_source/list_lead_source","privilege_tb")){?>
                    <li><a href="<?php echo site_url('lead_source/list_lead_source')?>">Lead Source List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","company/add_company","privilege_tb")){?>
                    <li><a href="<?php echo site_url('company/add_company')?>">+ Add Company</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","company/list_company","privilege_tb")){?>
                    <li><a href="<?php echo site_url('company/list_company')?>">Company List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","department/add_department","privilege_tb")){?>
                    <li><a href="<?php echo site_url('department/add_department')?>">+ Add Deparment</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","department/list_department","privilege_tb")){?>
                    <li><a href="<?php echo site_url('department/list_department')?>">Department List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/add_bank","privilege_tb")){?>
                    <li><a href="<?php echo site_url('project/add_bank')?>">+ Add Bank</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_bank","privilege_tb")){?>
                    <li><a href="<?php echo site_url('project/list_bank')?>">Bank List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/add_activity_category","privilege_tb")){?>
                    <li><a href="<?php echo site_url('project/add_activity_category')?>">+ Add Activity Category</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","project/list_activity_category","privilege_tb")){?>
                    <li><a href="<?php echo site_url('project/list_activity_category')?>">Activity Category List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","resource/list_resource","privilege_tb")){?>
                    <li><a href="<?php echo site_url('resource/list_resource')?>">Resource List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","warehouse/list_warehouse","privilege_tb")){?>
                    <li><a href="<?php echo site_url('warehouse/list_warehouse')?>">Warehouse List</a></li>
                <?php }?>
                <?php if($this->session->userdata('admin_privilege')==1){?>
                	<li><a href="<?php echo site_url('admin/privilege_user')?>">Privilege User</a></li>
                <?php }?>
                <?php if($this->session->userdata('admin_privilege')==1){?>
                	<li><a href="<?php echo site_url('admin/list_admin')?>">Admin</a></li>
                <?php }?>
                
                <li><a href="<?php echo site_url('setting/approval_list')?>">Request Fund Approval</a></li>
                <li><a href="<?php echo site_url('setting/auto_approver')?>">Auto Approver</a></li>
                <li><a href="<?php echo site_url('setting/change_password')?>">Change Password</a></li>
                
                
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","rak/add_rak","privilege_tb")){?>
                    <li><a href="<?php echo site_url('rak/add')?>">+ Add Rak</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","rak/list_rak","privilege_tb")){?>
                    <li><a href="<?php echo site_url('rak')?>">Rak List</a></li>
                <?php }?>
                
            </ul>
        </li>
        <?php //}?>
        <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_project_goal_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_payment_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_survey_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_daily_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_bonus_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_crm_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_crm_report_2","privilege_tb")){?>
            <li><a href="#" onclick="return false;">Report</a>
                <ul>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_project_goal_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_project_goal_report_2","privilege_tb")){?>
                        <li><a href="<?php echo site_url('report/list_project_goal_report');?>">Project Goal Report</a></li>
                    <?php }?>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_crm_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_crm_report_2","privilege_tb")){?>
                        <li><a href="<?php echo site_url('report/list_crm_report');?>">CRM Report</a></li>
                    <?php }?>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_bonus_report","privilege_tb")){?>
                        <li><a href="<?php echo site_url('report/list_bonus_report');?>">Bonus Report</a></li>
                    <?php }?>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_payment_report","privilege_tb")){?>
                        <li><a href="<?php echo site_url('report/list_payment_report');?>">Payment Report</a></li>
                    <?php }?>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_outstanding_report","privilege_tb")){?>
                        <li><a href="<?php echo site_url('report/list_outstanding_report');?>">Outstanding Report</a></li>
                    <?php }?>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_daily_report","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_daily_report_2","privilege_tb")){?>
                        <li><a href="<?php echo site_url('report/list_employee_daily_report');?>">Employee Daily Report</a></li>
                    <?php }?>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_schedule_daily_report","privilege_tb")){?>
                        <li><a href="<?php echo site_url('report/list_employee_schedule_daily_report');?>">Schedule VS Daily Report</a></li>
                    <?php }?>
                    <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_employee_report","privilege_tb")){?>
                        <li><a href="<?php echo site_url('report/list_employee_report');?>">Employee Report</a></li>
                    <?php }?>
                    
                     <?php /// aa//
					 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/project_report","privilege_tb")){?>
                        <li><a href="<?php echo site_url('report/report_project');?>">Project Report</a></li>
                    <?php }?>
                    
                       <?php /// aa//
					 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_report_bs","privilege_tb")){?>
                        <li><a href="<?php echo site_url('report/report_bs_list');?>">BS List</a></li>
                    <?php }?>
                    
                       <?php /// aa//
					 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_report_reimburse","privilege_tb")){?>
                        <li><a href="<?php echo site_url('report/report_reimburse_to_client');?>">Reimburse List</a></li>
                    <?php }?>
                    
                    <?php
					
			 if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_report_outstanding_project","privilege_tb")){?>
                            
                      <li><a href="<?php echo site_url('report/report_all_outstanding');?>">All Outstanding Project</a></li>
                   <?php } ?>
                    
                    <?php 
                     if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/list_report_outstanding_project","privilege_tb")){?>
                            
                      <li><a href="<?php echo site_url('report/report_project_list');?>">Report Project List</a></li>
                   <?php } ?>
                    
                    
                       <?php 
                     if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/detail_project_report","privilege_tb")){?>
                            
                      <li><a href="<?php echo site_url('report/detail_project_report');?>">Detail Project Report</a></li>
                   <?php } ?>
                    
                    
                    
                        <?php 
                     if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","report/report_history_search","privilege_tb")){?>
                            
                      <li><a href="<?php echo site_url('report/report_history_search');?>">Search History list</a></li>
                   <?php } ?>
                    
                    
                    
                    
                    
                </ul>
            </li>
        <?php }?>
        <li><a href="<?php echo site_url('myprofile/detail_profile');?>">My Profile</a></li>
        <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","ticket/ticket_list","privilege_tb")){?>
        <li><a href="<?php echo site_url('ticket/ticket_list');?>">Ticket</a></li>
        <?php }?>
        <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","survey/survey_list","privilege_tb")){?>
        <li><a href="#" onclick="return false;">Survey</a>
        	<ul>
            	<li><a href="<?php echo site_url('survey/question_list')?>">Questions</a></li>
                <li><a href="<?php echo site_url('survey/survey_list')?>">Survey</a></li>
            </ul>
        </li>
        <?php }?>
        <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","absence/absence_list","privilege_tb") || find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","absence/salary_list","privilege_tb")){?>
        <li><a href="#" onclick="return fales;">Absence</a>
        	<ul>
            	<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","absence/absence_list","privilege_tb")){?>
            		<li><a href="<?php echo site_url('absence/absent_list')?>">Upload</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","absence/salary_list","privilege_tb")){?>
                	<li><a href="<?php echo site_url('absence/salary_list')?>">Salary List</a></li>
                <?php }?>
                <?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","absence/salary_approval","privilege_tb")){?>
                	<li><a href="<?php echo site_url('absence/approval_list')?>">approval List</a></li>
                <?php }?>
            </ul>
        </li>
        <?php }?>
         <li><a href="<?php echo site_url('faq');?>">FAQ</a>
         <ul>
			<?php if(find_4_string("id","privilege_user_id",$this->session->userdata('admin_privilege'),"module","faq_category/list","privilege_tb")){?>
         <li><a href="<?php echo site_url('faq/category');?>">FAQ Category</a></li>
			<?php }?>
         <li><a href="<?php echo site_url('faq');?>">FAQ List</a></li>
         </ul>
         
         </li>
        <li><a href="<?php echo site_url('logout/do_logout') ?>">Sign Out (<?php echo $this->session->userdata('admin_fullname');?>)</a></li>
    </ul>    	
</div>
<?php }?>