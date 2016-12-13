<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	function __construct(){
		parent::__construct();
	}
 
	function myvalid_date($str)
	{
		if ( preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $str) ) 
		{
			$CI =&get_instance();
			$arr = explode("/", $str);    // splitting the array
			$yyyy = $arr[2];            // first element of the array is year
			$mm = $arr[1];              // second element is month
			$dd = $arr[0];              // third element is days
			if( checkdate($mm, $dd, $yyyy) ){
				return true;
			}else{
				$CI->form_validation->set_message('myvalid_date', "%s Tidak Valid.");
				return false;
			}
		} 
		else 
		{
			$CI->form_validation->set_message('myvalid_date', "Format %s salah. Gunakan Format dd/mm/yyyy.");
			return FALSE;
		}
	}
}
?>