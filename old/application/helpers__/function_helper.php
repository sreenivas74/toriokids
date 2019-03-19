<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Number Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/number_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Formats a numbers as bytes, based on size, and adds the appropriate suffix
 *
 * @access	public
 * @param	mixed	// will be cast as int
 * @return	string
 */
 
 
if ( ! function_exists('check_user_purchased_archive')){
	function check_user_purchased_archive($user_id,$month,$year)
	{		
		$q="select * from e_mag_subscription_user_tb where user_id='".esc($user_id)."'";
		
		$result=mysql_fetch_assoc(mysql_query($q));
	}	
}

if ( ! function_exists('check_module_action_privilege')){
	function check_module_action_privilege($privilege,$module,$action)
	{
		if($privilege!=1){
			$q="select * from privilege_module_tb where privilege_id='".$privilege."' and module_id='".$module."' and `action`='".$action."'";
			$result=mysql_fetch_assoc(mysql_query($q));
			
			if($result)return 1;
			else return 0;
		}
		else return 1;
	}	
}

if ( ! function_exists('check_session_id')){
	function check_session_id($session_id)
	{
		$q="select * from doku_tb where `session_id`='".$session_id."'";
		$result=mysql_fetch_assoc(mysql_query($q));
		
		if($result)return 1;
		else return 0;
	}	
}

if ( ! function_exists('getSizeImage'))
{	function getSizeImage ($image)
    {
        $imgData = getimagesize($image);
        $retval['width'] = $imgData[0];
        $retval['height'] = $imgData[1];
        $retval['mime'] = $imgData['mime'];
        return $retval;
    }
}

if ( ! function_exists('check_alias'))
{
	function check_alias($table,$alias)
	{
		$sql="select * from `".esc($table)."` where `alias`='".strtolower(esc($alias))."'";
		$result=mysql_fetch_assoc(mysql_query($sql));
		
		if($result)return 1;
		else return 0;
	}	
}

if ( ! function_exists('get_alias_id'))
{
	function get_alias_id($table,$alias)
	{
		$q="select id from `".esc($table)."` where `alias`='".strtolower(esc($alias))."'";
		$result=mysql_fetch_assoc(mysql_query($q));
		
		return $result['id'];
	}	
}

if ( ! function_exists('make_alias'))
{
	function make_alias($string)
	{
		$string=strtolower($string);
		
		$string=str_replace('&','n',$string);
		
		$string=preg_replace('/[^a-z0-9]/', "-", $string);
		
		$string=trim($string,'-');
		
		$string=str_replace('---','-',$string);
		$string=str_replace('--','-',$string);
		
		return $string;
	}	
}
 
if ( ! function_exists('find_first_calendar'))
{
	function find_first_calendar()
	{
		$result=mysql_fetch_assoc(mysql_query('select id from calendar_tb where active = 1 order by id desc limit 1'));
		return $result['id'];
	}	
}

if ( ! function_exists('find_last_calendar'))
{
	function find_last_calendar()
	{
		$result=mysql_fetch_assoc(mysql_query('select id from calendar_tb where active = 1 order by id asc limit 1'));
		return $result['id'];
	}	
} 

if ( ! function_exists('find_prev_calendar'))
{
	function find_prev_calendar($id)
	{
		$result=mysql_fetch_assoc(mysql_query("select id from calendar_tb where active = 1 and id > ".$id." order by id asc limit 1"));
		return $result['id'];
	}	
} 

if ( ! function_exists('find'))
{
	function find($coloumn,$id,$table)
	{
		//echo 'select '.$coloumn.' from '.$table.' where id='.$id;
		$result=mysql_fetch_assoc(mysql_query("select ".$coloumn." from ".$table." where id='".$id."'"));
		return $result[$coloumn];
	}	
}

if ( ! function_exists('find_1'))
{
	function find_1($coloumn,$table)
	{
		//echo 'select '.$coloumn.' from '.$table.' where id='.$id;
		$result=mysql_fetch_assoc(mysql_query("select ".$coloumn." from ".$table.""));
		return $result['total'];
	}	
}

if ( ! function_exists('find_2'))
{
	function find_2($coloumn,$data,$data_2,$table)
	{
		//echo 'select '.$coloumn.' from '.$table.' where id='.$id;
		$result=mysql_fetch_assoc(mysql_query("select ".$coloumn." from ".$table." where ".$data."='".$data_2."'"));
		return $result[$coloumn];
	}	
}

if ( ! function_exists('find_2_desc'))
{
	function find_2_desc($coloumn,$data,$data_2,$table)
	{
		//echo 'select '.$coloumn.' from '.$table.' where id='.$id;
		$result=mysql_fetch_assoc(mysql_query('select '.$coloumn.' from '.$table.' where '.$data.'='.$data_2.' order by id desc'));
		return $result[$coloumn];
	}	
}

if ( ! function_exists('find_2_prec'))
{
	function find_2_prec($coloumn,$data,$data_2,$table)
	{
		//echo 'select '.$coloumn.' from '.$table.' where id='.$id;
		$result=mysql_fetch_assoc(mysql_query('select '.$coloumn.' from '.$table.' where '.$data.'='.$data_2.' order by precedence'));
		return $result[$coloumn];
	}	
}

if ( ! function_exists('find_2_prec2'))
{
	function find_2_prec2($coloumn,$data,$data_2,$table)
	{
		//echo 'select '.$coloumn.' from '.$table.' where id='.$id;
		$result=mysql_fetch_assoc(mysql_query('select '.$coloumn.' from '.$table.' where '.$data.'='.$data_2.' and active=1 order by precedence'));
		return $result[$coloumn];
	}	
}

if ( ! function_exists('find_3'))
{
	function find_3($coloumn,$data,$data_2,$table)
	{
		//echo 'select '.$coloumn.' from '.$table.' where id='.$id;
		$result=mysql_fetch_assoc(mysql_query('select '.$coloumn.' from '.$table.' where '.$data.'='.$data_2.''));
		return $result['total'];
	}	
}

if ( ! function_exists('find_4'))
{
	function find_4($coloumn,$data,$data_2,$data_3,$data_4,$table)
	{
		//echo 'select '.$coloumn.' from '.$table.' where id='.$id;
		$result=mysql_fetch_assoc(mysql_query('select '.$coloumn.' from '.$table.' where '.$data.'='.$data_2.' and '.$data_3.' = '.$data_4.''));
		return $result[$coloumn];
	}	
}

if ( ! function_exists('find_4_precedence'))
{
	function find_4_precedence($coloumn,$data,$data_2,$data_3,$data_4,$table)
	{
		//echo 'select '.$coloumn.' from '.$table.' where id='.$id;
		$result=mysql_fetch_assoc(mysql_query('select '.$coloumn.' from '.$table.' where '.$data.'='.$data_2.' and '.$data_3.' = '.$data_4.''));
		return $result[$coloumn];
	}	
}

if ( ! function_exists('find_5'))
{
	function find_5($coloumn,$data,$data_2,$data_3,$data_4,$table)
	{
		//echo 'select '.$coloumn.' from '.$table.' where id='.$id;
		$result=mysql_fetch_assoc(mysql_query('select '.$coloumn.' from '.$table.' where ('.$data.'='.$data_2.' OR '.$data_3.' = '.$data_4.')'));
		return $result[$coloumn];
	}	
}

if ( ! function_exists('pre'))
{
	function pre($var)
	{
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}	
}


if ( ! function_exists('last_id'))
{
	function last_id($table)
	{
		$result=mysql_fetch_assoc(mysql_query('select id from '.$table.' order by id desc'));
		return $result['id'];
	}	
}

if ( ! function_exists('last_precedence'))
{
	function last_precedence($table)
	{
		$result=mysql_fetch_assoc(mysql_query('select precedence from '.$table.' order by precedence desc'));
		return $result['precedence'];
	}	
}

if ( ! function_exists('last_order_id'))
{
	function last_order_id($table)
	{
		$result=mysql_fetch_assoc(mysql_query('select id from '.$table.' order by id desc'));
		return $result['id'];
	}	
}


if ( ! function_exists('last_precedence_calendar'))
{
	function last_precedence_calendar($table)
	{
		$result=mysql_fetch_assoc(mysql_query('select month_precedence from '.$table.' order by month_precedence desc'));
		return $result['month_precedence'];
	}	
}

if ( ! function_exists('last_precedence_2'))
{
	function last_precedence_2($table,$data_1,$data_2)
	{
		$result=mysql_fetch_assoc(mysql_query('select precedence from '.$table.' where '.$data_1.' = '.$data_2.' order by precedence desc'));
		return $result['precedence'];
	}	
}

if ( ! function_exists('last_precedence_3'))
{
	function last_precedence_3($table,$data_1,$data_2,$data_3,$data_4)
	{
		$result=mysql_fetch_assoc(mysql_query('select precedence from '.$table.' where '.$data_1.' = '.$data_2.' and '.$data_3.' = '.$data_4.' order by precedence desc'));
		return $result['precedence'];
	}	
}

if ( ! function_exists('last_precedence_flexible'))
{
	function last_precedence_flexible($precedence,$table,$data_1,$data_2)
	{
		$result=mysql_fetch_assoc(mysql_query('select '.$precedence.' from '.$table.' where '.$data_1.' = '.$data_2.' order by '.$precedence.' desc'));
		return $result[$precedence];
	}	
}
if ( ! function_exists('last_feature_precedence'))
{
	function last_feature_precedence($inside_month_id)
	{
		$result=mysql_fetch_assoc(mysql_query("select feature_precedence from article_tb where inside_month_id='".esc($inside_month_id)."' order by feature_precedence desc"));
		return $result['feature_precedence'];
	}	
}

if ( ! function_exists('first_precedence'))
{
	function first_precedence($table)
	{
		$result=mysql_fetch_assoc(mysql_query('select precedence from '.$table.' order by precedence asc'));
		return $result['precedence'];
	}	
}

if ( ! function_exists('first_precedence_calendar'))
{
	function first_precedence_calendar($table)
	{
		$result=mysql_fetch_assoc(mysql_query('select month_precedence from '.$table.' order by month_precedence asc'));
		return $result['month_precedence'];
	}	
}

if ( ! function_exists('first_precedence_2'))
{
	function first_precedence_2($table,$data_1,$data_2)
	{
		$result=mysql_fetch_assoc(mysql_query('select precedence from '.$table.' where '.$data_1.' = '.$data_2.' order by precedence asc'));
		return $result['precedence'];
	}	
}

if ( ! function_exists('first_precedence_3'))
{
	function first_precedence_3($table,$data_1,$data_2,$data_3,$data_4)
	{
		$result=mysql_fetch_assoc(mysql_query('select precedence from '.$table.' where '.$data_1.' = '.$data_2.' and '.$data_3.' = '.$data_4.' order by precedence asc'));
		return $result['precedence'];
	}	
}

if ( ! function_exists('first_precedence_flexible'))
{
	function first_precedence_flexible($precedence,$table,$data_1,$data_2)
	{
		$result=mysql_fetch_assoc(mysql_query('select '.$precedence.' from '.$table.' where '.$data_1.' = '.$data_2.' order by '.$precedence.' asc'));
		return $result[$precedence];
	}	
}
if ( ! function_exists('first_feature_precedence'))
{
	function first_feature_precedence($inside_month_id)
	{
		$result=mysql_fetch_assoc(mysql_query("select feature_precedence from article_tb where inside_month_id='".esc($inside_month_id)."' order by feature_precedence asc"));
		return $result['feature_precedence'];
	}	
}
if ( ! function_exists('first_precedence_sub_article'))
{
	function first_precedence_sub_article($article)
	{
		$result=mysql_fetch_assoc(mysql_query("select * from sub_article_tb where article_id='".esc($article)."' order by precedence asc limit 1"));
		return $result['id'];
	}	
}

if ( ! function_exists('alert'))
{
	function alert($content)
	{
		echo "<script language='javascript'>alert('$content');</script>";
	}
	
}


if ( ! function_exists('check_double_two'))
{
	function check_double_two($value,$column,$value2,$column2,$table)
	{
		$sql="SELECT * from $table where $column='$value' and $column2='$value2'";
		$result=mysql_query($sql);
		
		$count=mysql_num_rows($result);
		
		if ($count)
		{
			return 0;
		}
		else 
		{
			return 1;
		}
	}	
}

if ( ! function_exists('display_date'))
{
	function display_date($date)
	{
		if($date!="0000-00-00")
		{
		$y=substr($date,0,4);
		$m=substr($date,5,2);
		$d=substr($date,8,2);
		$date_format=date("d M y",mktime(0,0,0,$m,$d,$y));
		}
		else
		{
		$date_format="-";
		}	
		return $date_format;
	}
}

if ( ! function_exists('display_date_full'))
{
	function display_date_full($date)
	{
		if($date!="0000-00-00 00:00:00")
		{
		$y=substr($date,0,4);
		$m=substr($date,5,2);
		$d=substr($date,8,2);
		$h=substr($date,11,2);
		$min=substr($date,14,2);
		$s=substr($date,17,2);
	
		$date_format=date("d M y, H:i",mktime($h,$min,$s,$m,$d,$y));
		
		}
		else
		{
		$date_format="-";
		}	
		return $date_format;
	}
}


if ( ! function_exists('display_date_admin'))
{
	function display_date_admin($date)
	{
		if($date!="0000-00-00")
		{
		$y=substr($date,0,4);
		$m=substr($date,5,2);
		$d=substr($date,8,2);
		$date_format=date("d-M-Y",mktime(0,0,0,$m,$d,$y));
		}
		else
		{
		$date_format="-";
		}	
		
		return $date_format;
	}
}

if ( ! function_exists('display_date_full_admin'))
{
	function display_date_full_admin($date)
	{
		if($date!="0000-00-00 00:00:00")
		{
		$y=substr($date,0,4);
		$m=substr($date,5,2);
		$d=substr($date,8,2);
		$h=substr($date,11,2);
		$min=substr($date,14,2);
		$s=substr($date,17,2);
		$date_format=date("d-M-Y H:i",mktime($h,$min,$s,$m,$d,$y));
		}
		else
		{
		$date_format="-";
		}	
		
		return $date_format;
	}
}




if ( ! function_exists('money'))
{
	function money($input)
	{
		return 'IDR. '.number_format($input, '0', ',', '.');
		
	}

}

if ( ! function_exists('discount'))
{
	function discount($input)
	{
		return number_format($input, '0', ',', '.').'%';
		
	}

}

if ( ! function_exists('money2'))
{
	function money2($input)
	{
		return number_format($input, '0', ',', '.').',-';
		
	}

}

if ( ! function_exists('set_active_special'))
{
	function set_active_special($table,$active_or_no,$id)
	{
		mysql_query("update $table set active_or_no= $active_or_no where id=$id");
		
	}	
}



if ( ! function_exists('get_picture_thumbnail'))
{
	function get_picture_thumbnail($picture,$name='')
	{
		if($picture)
		{
			
			return '<img src="'.site_url('userdata/thumbnail/'.$picture).'"  align="'.$name.'" title="'.$name.'"/>';
			
		}else
		{
			return '<img src="'.site_url('images/admin/no_pic-promo.jpg').'"  align="'.$name.'" title="'.$name.'"/>';
			
		}
	 	
	 }	
}


if ( ! function_exists('get_picture_real'))
{
	function get_picture_real($picture,$name='')
	{
		if($picture)
		{
			
			return '<img src="'.site_url('userdata/real/'.$picture).'" align="'.$name.'" title="'.$name.'"/>';
			
		}else
		{
			return '<img src="'.site_url('images/admin/no_pic-promo-big.jpg').'"  align="'.$name.'" title="'.$name.'"/>';
			
		}
	 	
	 }	
}


if ( ! function_exists('delete_picture'))
{
	function delete_picture($table,$coloumn,$id)
	{
		$picture_before=find($coloumn,$id,$table);
		mysql_query("update $table set $coloumn= '' where id=$id");
		unlink("userdata/real/".$picture_before);
		unlink("userdata/thumbnail/".$picture_before);
		
	}	
}



if ( ! function_exists('check_double_two_return_value'))
{
	function check_double_two_return_value($return,$value,$column,$value2,$column2,$table)
	{
		$result=mysql_fetch_assoc(mysql_query("SELECT * from $table where $column='$value' and $column2='$value2'"));
		return $result[$return];
		
	}

}

if ( ! function_exists('last_login'))
{
	function last_login($user_id)
	{
		mysql_query("update arc_user set last_login='".date("Y-m-d H:i:s")."' where id = ".$user_id."");
	}

}

if ( ! function_exists('checkordeby'))
{
	function checkordeby($newshortby,$shortbyactive,$orderby)
	{
		if($newshortby==$shortbyactive)
		{
			return ($orderby=='asc')?'desc':'asc';	
		}else
		{
			return 'asc';	
		}
		
	}

}

if ( ! function_exists('find_first_id_item_color'))
{
	function find_first_id_item_color($product_item_id)
	{
		$result=mysql_fetch_assoc(mysql_query('select id from arc_product_item_color where product_item_id='.$product_item_id.' and active_or_no=1 order by id asc'));
		return $result['id'];
	}	
}

if ( ! function_exists('get_month_name'))
{
	function get_month_name($month)
	{
		
		if ($month == 1){
			$bulan = "January";
		}
		else if($month == 2) {
			$bulan = "February";
		}
		else if($month == 3) {
			$bulan = "March";
		}
		else if($month == 4) {
			$bulan = "April";
		}
		else if($month == 5) {
			$bulan = "May";
		}
		else if($month == 6) {
			$bulan = "June";
		}
		else if($month == 7) {
			$bulan = "July";
		}
		else if($month == 8) {
			$bulan = "August";
		}
		else if($month == 9) {
			$bulan = "September";
		}
		else if($month == 10) {
			$bulan = "October";
		}
		else if($month == 11) {
			$bulan = "November";
		}
		else if($month == 12) {
			$bulan = "December";
		}
		
		return $bulan;
	}	
}
if ( ! function_exists('format_tanggal'))
{
	function format_tanggal($date)
	{
		$tanggal = strtotime($date);
		$hari = date("D", $tanggal);
		$bulan = date("M", $tanggal);
		$jam = date("H", $tanggal);
		$menit = date("i", $tanggal);
		
		//hari
		if ($hari == "Mon") {
			$hari = "Senin";
		}
		else if ($hari == "Tue") {
			$hari = "Selasa";
		}
		else if ($hari == "Wed") {
			$hari = "Rabu";
		}
		else if ($hari == "Thu") {
			$hari = "Kamis";
		}
		else if ($hari == "Fri") {
			$hari = "Jumat";
		}
		else if ($hari == "Sat") {
			$hari = "Sabtu";
		}
		else if ($hari == "Sun") {
			$hari = "MInggu";
		}
		
		//bulan'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
		if ($bulan == "Jan"){
			$bulan = "Januari";
		}
		else if($bulan == "Feb") {
			$bulan = "Februari";
		}
		else if($bulan == "Mar") {
			$bulan = "Maret";
		}
		else if($bulan == "Apr") {
			$bulan = "April";
		}
		else if($bulan == "May") {
			$bulan = "Mei";
		}
		else if($bulan == "Jun") {
			$bulan = "Juni";
		}
		else if($bulan == "Jul") {
			$bulan = "Juli";
		}
		else if($bulan == "Aug") {
			$bulan = "Agustus";
		}
		else if($bulan == "Sep") {
			$bulan = "September";
		}
		else if($bulan == "Oct") {
			$bulan = "Oktober";
		}
		else if($bulan == "Nov") {
			$bulan = "November";
		}
		else if($bulan == "Dec") {
			$bulan = "Desember";
		}
		
		$mix_all = $hari.", ".date("j", $tanggal)." ".$bulan." ".date("Y", $tanggal)." - ".$jam.".".$menit;
		
		return $mix_all;
	}	
}

if ( ! function_exists('format_tanggal_zodiac'))
{
	function format_tanggal_zodiac($date)
	{
		$tanggal = strtotime($date);
		$hari = date("D", $tanggal);
		$bulan = date("M", $tanggal);
		
		
		//hari
		if ($hari == "Mon") {
			$hari = "Senin";
		}
		else if ($hari == "Tue") {
			$hari = "Selasa";
		}
		else if ($hari == "Wed") {
			$hari = "Rabu";
		}
		else if ($hari == "Thu") {
			$hari = "Kamis";
		}
		else if ($hari == "Fri") {
			$hari = "Jumat";
		}
		else if ($hari == "Sat") {
			$hari = "Sabtu";
		}
		else if ($hari == "Sun") {
			$hari = "MInggu";
		}
		
		//bulan'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
		if ($bulan == "Jan"){
			$bulan = "Januari";
		}
		else if($bulan == "Feb") {
			$bulan = "Februari";
		}
		else if($bulan == "Mar") {
			$bulan = "Maret";
		}
		else if($bulan == "Apr") {
			$bulan = "April";
		}
		else if($bulan == "May") {
			$bulan = "Mei";
		}
		else if($bulan == "Jun") {
			$bulan = "Juni";
		}
		else if($bulan == "Jul") {
			$bulan = "Juli";
		}
		else if($bulan == "Aug") {
			$bulan = "Agustus";
		}
		else if($bulan == "Sep") {
			$bulan = "September";
		}
		else if($bulan == "Oct") {
			$bulan = "Oktober";
		}
		else if($bulan == "Nov") {
			$bulan = "November";
		}
		else if($bulan == "Dec") {
			$bulan = "Desember";
		}
		
		$mix_all = date("j", $tanggal)." ".$bulan;
		
		return $mix_all;
	}	
}
if ( ! function_exists('curPageURL'))
{
	function curPageURL() {
 		$pageURL = 'http';
 		$pageURL .= "://";
 		if ($_SERVER["SERVER_PORT"] != "80") {
  			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 		} else {
  			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 		}
 	return $pageURL;
	}
}
	

if ( ! function_exists('esc')) //alias: mysql_real_escape_string()
{
	function esc($string)
	{
		$result=mysql_real_escape_string($string);
		return $result;
	}	
}

if(! function_exists('br2nl')){
	function br2nl($string) { 
		return preg_replace('`<br(?: /)?>([\\n\\r])`', ' ', $string); 
	}
}

if ( ! function_exists('get_privilege'))
{
	function get_privilege($privilege_id,$module)
	{
		if($privilege_id!=1){
			$result=mysql_query("select * from privilege_modules_tb where privilege_id='$privilege_id' && modules_id='$module'");
			$cek=mysql_fetch_array($result);
			return $cek['show'];
		}else{
			return 1;	
		}
	}
}

if ( ! function_exists('strips'))
{
	function strips($string)
	{	
		$string=str_replace('["','',$string);
		$string=str_replace('"]','',$string);
		$string=str_replace('","','/',$string);
		
		return $string;
	}	
}

if ( ! function_exists('nospace'))
{
	function nospace($string)
	{	
		$string=str_replace(' ','_',$string);
		$string=str_replace('(','_',$string);
		$string=str_replace(')','_',$string);
		$string=str_replace('/','_',$string);
		return $string;
	}	
}
if ( ! function_exists('space'))
{
	function space($string)
	{	
		$string=str_replace('_',' ',$string);
		
		return $string;
	}	
}

if ( ! function_exists('find_sender'))
{
	function find_sender($name)
	{
		
		$sql=" select * from user_tb where `full_name` ='".esc($name)."'";
		$result=mysql_fetch_assoc(mysql_query($sql));
		return $result;
		
	}	
}

if ( ! function_exists('find_recipient'))
{
	function find_recipient($name)
	{
		$sql=" select * from order_tb where `recipient_name` = '".esc($name)."'";
		$result=mysql_fetch_assoc(mysql_query($sql));
		return $result;
		
	}	
}

if ( ! function_exists('filter_by_date'))
{
	function filter_by_date($date,$from,$to)
	{
		$date = strtotime($date);
		$from = strtotime($from);
		$to   = strtotime($to);
		if($date >= $from and $date <= $to)return 1;
		else return 0;
		
	}	
} 

if ( ! function_exists('status_selected'))
{
	function status_selected($status , $flag )
	{
		if($status==$flag)echo "selected";
		
	}	
} 

if ( ! function_exists('order_check'))
{
	function order_check($user,$order)
	{
		$sql=" select * from order_tb where `user_id` = '".esc($user)."' and `id`='".esc($order)."'";
		$result=mysql_fetch_assoc(mysql_query($sql));
		if($result) return 1; else return 0;
		
	}	
} 

if ( ! function_exists('check_new_arrival'))
{
	function check_new_arrival($name)
	{
		$sql=" select count(*) as total from product_tb where `active`=1 and `flag`=1 and `category_name` like '%".esc($name)."%'";
		$result=mysql_fetch_assoc(mysql_query($sql));
		return $result['total'];
	}	
} 

if ( ! function_exists('is_exist_default_address'))
{
	function is_exist_default_address($user_id)
	{
	 	$sql=" select id from user_address_tb where `default_address`=1 and `user_id`='".esc($user_id)."'";
		$result=mysql_fetch_assoc(mysql_query($sql));

		if($result)return $result['id'];
		else return 0;
	}	
} 

if ( ! function_exists('check_product_size'))
{
	function check_product_size($template_id)
	{
		$sql=" select count(*) as total from product_tb where `active`=1 and `template_id`='".esc($template_id)."' ";
		$result=mysql_fetch_assoc(mysql_query($sql));
		return $result['total'];
	}	
} 

/* End of file number_helper.php */
/* Location: ./system/helpers/number_helper.php */