<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = 'sikda';
$active_record = TRUE;

/*$db['default']['hostname'] = "//172.16.10.8:1521/orcl";
$db['default']['username'] = "SIMBMN";
$db['default']['password'] = "simbmn";
$db['default']['database'] = "";
$db['default']['dbdriver'] = "oci8";
$db['default']['dbprefix'] = "";
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";*/

$db['sikda']['hostname'] = 'localhost';
$db['sikda']['username'] = 'root';
$db['sikda']['password'] = 'root';
$db['sikda']['database'] = 'sikda_puskesmas';
$db['sikda']['dbdriver'] = 'mysql';
$db['sikda']['dbprefix'] = '';
$db['sikda']['pconnect'] = TRUE;
$db['sikda']['db_debug'] = TRUE;
$db['sikda']['cache_on'] = FALSE;
$db['sikda']['cachedir'] = '';
$db['sikda']['char_set'] = 'utf8';
$db['sikda']['dbcollat'] = 'utf8_general_ci';
$db['sikda']['swap_pre'] = '';
$db['sikda']['autoinit'] = TRUE;
$db['sikda']['stricton'] = FALSE;

/*$db['sikdaold']['hostname'] = 'localhost';
$db['sikdaold']['username'] = 'root';
$db['sikdaold']['password'] = 'root';
$db['sikdaold']['database'] = 'sikda';
$db['sikdaold']['dbdriver'] = 'mysql';
$db['sikdaold']['dbprefix'] = '';
$db['sikdaold']['pconnect'] = TRUE;
$db['sikdaold']['db_debug'] = TRUE;
$db['sikdaold']['cache_on'] = FALSE;
$db['sikdaold']['cachedir'] = '';
$db['sikdaold']['char_set'] = 'utf8';
$db['sikdaold']['dbcollat'] = 'utf8_general_ci';
$db['sikdaold']['swap_pre'] = '';
$db['sikdaold']['autoinit'] = TRUE;
$db['sikdaold']['stricton'] = FALSE;*/

/* End of file database.php */
/* Location: ./application/config/database.php */