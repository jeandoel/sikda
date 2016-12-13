<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

//------------------------CUSTOM-------------------------------------------

define('TMP_PATH',FCPATH.'tmp/');

$month_list = '
				<option value="01">Januari</option>
				<option value="02">Februari</option>
				<option value="03">Maret</option>
				<option value="04">April</option>
				<option value="05">Mei</option>
				<option value="06">Juni</option>
				<option value="07">Juli</option>
				<option value="08">Agustus</option>
				<option value="09">September</option>
				<option value="10">Oktober</option>
				<option value="11">November</option>
				<option value="12">Desember</option>
			';
define('MONTH_LIST',$month_list);

$year_list = '
				<option value="'.(date('Y')).'">'.(date('Y')).'</option>
				<option value="'.(date('Y')-1).'">'.(date('Y')-1).'</option>
				<option value="'.(date('Y')-2).'">'.(date('Y')-2).'</option>
				<option value="'.(date('Y')-3).'">'.(date('Y')-3).'</option>
				<option value="'.(date('Y')-4).'">'.(date('Y')-4).'</option>
				<option value="'.(date('Y')-5).'">'.(date('Y')-5).'</option>
				<option value="'.(date('Y')-6).'">'.(date('Y')-6).'</option>
				<option value="'.(date('Y')-7).'">'.(date('Y')-7).'</option>
			';
define('YEAR_LIST',$year_list);

$arrtkasus = 'nid_kasus,subject_kasus,judul_kasus,nid_lokasi,ntgl_kejadian,nketerangan,file_laporan,nid_kategori,nstatus_kasus,ninput_tgl,ninput_oleh,nupdate_tgl,nupdate_oleh';
define('TBL_LAPORANKASUS',$arrtkasus);

$arrtkategori = 'nid_kategori,nnama_kategori,ninput_oleh,ninput_tgl,nupdate_oleh,nupdate_tgl';
define('TBL_MKATEGORI',$arrtkategori);

$arrtlokasi = 'nid_lokasi,nnama_lokasi,ninput_oleh,ninput_tgl,nupdate_oleh,nupdate_tgl';
define('TBL_MLOKASI',$arrtlokasi);

/* End of file constants.php */
/* Location: ./brskapplication/config/constants.php */