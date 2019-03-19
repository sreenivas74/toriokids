<?php if(!defined('BASEPATH')) exit('Hack attemp?');

class Flexigrid_model extends Ext_Model{

	function __construct(){
		parent::__construct();
	}
	
	function countRec($fname,$tname) {
		$sql ="SELECT count($fname) as total FROM $tname";
		return $this->fetch_single_row($sql);
	}
	
	function countRec2($fname,$tname) {
		$sql ="SELECT count($fname) as total FROM $tname";
		return $this->fetch_multi_row($sql);
	}
	
	function get_flexi($sql) {		
		return $this->fetch_single_row($sql);
	}
	
	function get_flexi_result2($sql) {		
		return $this->fetch_multi_row($sql);
	}
	
	function get_flexi_result($selection,$sort,$limit,$query,$qtype,$where,$tname)
	{
		$sql = "SELECT $selection FROM $tname $where $sort $limit";
		//echo $sql;exit;
		return $this->fetch_multi_row($sql);
	}
}
?>