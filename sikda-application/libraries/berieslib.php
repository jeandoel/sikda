<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class berieslib {
	var $CI;
	var $db;
	function berieslib()
	{
		$this->CI =& get_instance();
		$this->db = $this->CI->load->database('brsk', TRUE);
	}

	
	
}
?>