<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Berie Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Berie H
 */

// ------------------------------------------------------------------------

if ( ! function_exists('BerieChangeMonthToDb'))
{
	function BerieChangeMonthToDb($month='')
	{			
		switch($month){
			case 'Januari': return 1; break;
			case 'Februari':return 2; break;
			case 'Maret':return 3; break;
			case 'April':return 4; break;
			case 'Mei':return 5; break;
			case 'Juni':return 6; break;
			case 'Juli':return 7; break;
			case 'Agustus':return 8; break;
			case 'September':return 9; break;
			case 'Oktober':return 10; break;
			case 'November':return 11; break;
			case 'Desember':return 12; break;
		}
	}
}


/* End of file berie_helper.php */