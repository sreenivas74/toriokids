<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Golden Solution</title>

<?php echo link_tag('css/diana.css');?>
<?php echo link_tag('css/extraCon.css'); ?>
<?php echo link_tag('css/theme/jquery-ui.css'); ?>
<?php echo link_tag('css/flexigrid/flexigrid.css'); ?>
<link href="<?php echo base_url()?>templates/css/redactor.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/navMenu.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/flexigrid.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/resetForm.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/function_helper.js"></script>

	<script type="text/javascript" src="<?php echo base_url();?>templates/js/redactor.js"></script>
</head>

<body>
	<?php $this->load->view('common/header');?>
    <?php if( (!isset($loginPage)) && ($this->sentry->admin_is_logged_in() == TRUE) ) {
    	$this->load->view('common/menu');
	}?>
    <div id="contentCon">
        <div id="contentHome">
        <?php $this->load->view($page);?>
        </div>
    </div>
    <?php $this->load->view('common/footer');?>
    
    <?php if(isset($_SESSION['required_field']))unset($_SESSION['required_field']);?>
    <?php if(isset($_SESSION['ticket_notif']))unset($_SESSION['ticket_notif']);?>
    <?php if(isset($_SESSION['survey_error']))unset($_SESSION['survey_error']);?>
    <?php if(isset($_SESSION['admin_notif']))unset($_SESSION['admin_notif']);?>
</body>
</html>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui.js"></script>