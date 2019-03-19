<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cronjob_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_new_mailinglist(){
		$q="select *from newsletter_tb where status_subscribe='0'";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function update_mailinglist($euid,$leid,$email){
		$q="update newsletter_tb set euid='".esc($euid)."', leid='".esc($leid)."', status_subscribe='1' where email='".esc($email)."'";
		$this->db->query($q);
	}
	
	function get_synch_mailinglist(){
		$q="select *from newsletter_tb where status_subscribe='1' and edited='1'";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function update_edited_mailinglist($id){
		$q="update newsletter_tb set edited='0' where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function update_delete_mailinglist($id){
		$q="update newsletter_tb set status_subscribe='3', euid='', leid='' where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function get_delete_mailinglist(){
		$q="select *from newsletter_tb where status_subscribe='2'";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_mailchip_api(){
		$q="select value from mailchimp_tb where name='mailchimp_api_key'";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	function get_mailchip_id(){
		$q="select value from mailchimp_tb where name='mailchimp_id'";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	///// campaign
	
	function add_campaign($title,$subject,$desc,$image,$link,$active,$show,$button_link,$json_product_id,$greeting_name){
		$q="insert into campaign_tb(`title`,`subject`,`description`,`image`,`link`,`active`,`show_button`,`button_link`,`product_id`,`greeting_name`)values('".esc($title)."','".esc($subject)."','".esc($desc)."','".esc($image)."','".esc($link)."','".esc($active)."','".esc($show)."','".esc($button_link)."','".esc($json_product_id)."', '".esc($greeting_name)."')";
		$this->db->query($q);
	}
	
	function edit_campaign($id,$title,$subject,$desc,$link,$show,$button_link, $json_product_id,$greeting_name){
		$q="update campaign_tb set title='".esc($title)."', subject='".esc($subject)."', description='".esc($desc)."', link='".esc($link)."', show_button='".esc($show)."', button_link='".esc($button_link)."', product_id='".esc($json_product_id)."', greeting_name='".esc($greeting_name)."' where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function update_image_campaign($id, $image){
		$q="update campaign_tb set image='".esc($image)."' where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function update_campaignid($id,$campaign_id){
		$q="update campaign_tb set campaign_id='".esc($campaign_id)."' where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function set_all_campaign_inactive(){
		$q = "update campaign_tb set active=0";
		$this->db->query($q);
	}
	
	function get_all_campaign(){
		$q="select *from campaign_tb";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_all_campaign_order_desc(){
		$q="select *from campaign_tb order by id desc";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	function get_campaign($id){
		$q="select *from campaign_tb where id='".esc($id)."'";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	function get_active_campaign(){
		$q="select *from campaign_tb where active='1'";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	function delete_campaign($id){
		$q="delete from campaign_tb where `id`='".esc($id)."'";
		$this->db->query($q);
	}
	
	function active($id,$status){
		$q = "update campaign_tb set active = '".esc($status)."' where id = '".esc($id)."'";
		$query = $this->db->query($q);	
	}
	
	function active2($id,$status){
		$q = "update campaign_tb set active = '".esc($status)."' where id != '".esc($id)."'";
		$query = $this->db->query($q);	
	}
	
	function set_sent_flag($id){
		$q = "update campaign_tb set sent=1 where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function unset_sent_flag($id){
		$q = "update campaign_tb set sent=0 where id='".esc($id)."'";
		$this->db->query($q);
	}
	
	function update_schedule_time($id, $time){
		$q = "update campaign_tb set schedule_time='".esc($time)."' where id='".esc($id)."'";
		$this->db->query($q);
	}
}