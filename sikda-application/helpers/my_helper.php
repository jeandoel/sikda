<?php
function getComboJenispersalinan($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_CARA_PERSALINAN, CARA_PERSALINAN from mst_cara_persalinan")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Jenis Persalinan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_CARA_PERSALINAN']?'selected':'';
				$field.='<option value="'.$row['KD_CARA_PERSALINAN'].'" '.$sel.' >'.$row['CARA_PERSALINAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
function getComboJeniskelahiran($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_JENIS_KELAHIRAN, JENIS_KELAHIRAN from mst_jenis_kelahiran")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Jenis Kelahiran'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_JENIS_KELAHIRAN']?'selected':'';
				$field.='<option value="'.$row['KD_JENIS_KELAHIRAN'].'" '.$sel.' >'.$row['JENIS_KELAHIRAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	function getComboKesehatan($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_KEADAAN_KESEHATAN, KEADAAN_KESEHATAN from mst_keadaan_kesehatan")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Keadaan Ibu'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_KEADAAN_KESEHATAN']?'selected':'';
				$field.='<option value="'.$row['KD_KEADAAN_KESEHATAN'].'" '.$sel.' >'.$row['KEADAAN_KESEHATAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	function getComboStatushamil($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_STATUS_HAMIL, STATUS_HAMIL from mst_status_hamil")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Status Hamil'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid=='Melahirkan'?'selected':'';
				$field.='<option value="'.$row['KD_STATUS_HAMIL'].'" '.$sel.' >'.$row['STATUS_HAMIL'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	function getComboDokter($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_DOKTER, NAMA, JABATAN from mst_dokter where kd_puskesmas='".$CI->session->userdata('kd_puskesmas')."'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Penolong Persalinan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_DOKTER']?'selected':'';
				$field.='<option value="'.$row['KD_DOKTER'].'" '.$sel.' >'.$row['NAMA'].'::'.$row['JABATAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getCombopetugas($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_DOKTER, NAMA, JABATAN from mst_dokter where kd_puskesmas='".$CI->session->userdata('kd_puskesmas')."'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Penolong Persalinan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_DOKTER']?'selected':'';
				$field.='<option value="'.$row['KD_DOKTER'].'" '.$sel.' >'.$row['NAMA'].'::'.$row['JABATAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboDokter10($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_DOKTER, NAMA, JABATAN from mst_dokter where kd_puskesmas='".$CI->session->userdata('kd_puskesmas')."'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Penolong Persalinan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_DOKTER']?'selected':'';
				$field.='<option value="'.$row['KD_DOKTER'].'" '.$sel.' >'.$row['NAMA'].'::'.$row['JABATAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getCombopetugas10($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_DOKTER, NAMA, JABATAN from mst_dokter where kd_puskesmas='".$CI->session->userdata('kd_puskesmas')."'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Petugas Pemeriksa'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_DOKTER']?'selected':'';
				$field.='<option value="'.$row['KD_DOKTER'].'" '.$sel.' >'.$row['NAMA'].'::'.$row['JABATAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboDokter1($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_DOKTER, NAMA, JABATAN from mst_dokter where KD_PUSKESMAS='".$CI->session->userdata('kd_puskesmas')."'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Nama Pemeriksa'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_DOKTER']?'selected':'';
				$field.='<option value="'.$row['KD_DOKTER'].'" '.$sel.' >'.$row['NAMA'].'::'.$row['JABATAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboDokter2($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_DOKTER, NAMA, JABATAN from mst_dokter where KD_PUSKESMAS='".$CI->session->userdata('kd_puskesmas')."'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Nama Petugas'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_DOKTER']?'selected':'';
				$field.='<option value="'.$row['KD_DOKTER'].'" '.$sel.' >'.$row['NAMA'].'::'.$row['JABATAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboKeadaanbayilahir($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_KEADAAN_BAYI_LAHIR, KEADAAN_BAYI_LAHIR from mst_keadaan_bayi_lahir")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Keadaan Bayi saat Lahir'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_KEADAAN_BAYI_LAHIR']?'selected':'';
				$field.='<option value="'.$row['KD_KEADAAN_BAYI_LAHIR'].'" '.$sel.' >'.$row['KEADAAN_BAYI_LAHIR'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
		function getComboAsuhanbayilahir($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_ASUHAN_BAYI_LAHIR, ASUHAN_BAYI_LAHIR from mst_asuhan_bayi_lahir")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Asuhan Bayi saat Lahir'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_ASUHAN_BAYI_LAHIR']?'selected':'';
				$field.='<option value="'.$row['KD_ASUHAN_BAYI_LAHIR'].'" '.$sel.' >'.$row['ASUHAN_BAYI_LAHIR'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	function getComboKetwaktu($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_KET_WAKTU, KET_WAKTU from mst_ket_waktu")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Keterangan Waktu'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_KET_WAKTU']?'selected':'';
				$field.='<option value="'.$row['KD_KET_WAKTU'].'" '.$sel.' >'.$row['KET_WAKTU'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboPosisi($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$dataposisi = $db->query("select POSISI from mst_posisi")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Jabatan</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($dataposisi as $row){
				$sel = $nid==$row['POSISI']?'selected':'';
				$field.='<option value="'.$row['POSISI'].'" '.$sel.' >'.$row['POSISI'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}

	function getComboKasus($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datakasus = $db->query("select KD_JENIS_KASUS,VARIABEL_NAME from mst_kasus where KD_JENIS_KASUS='Pneumonia'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Kasus Ditemukan</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datakasus as $row){
				$sel = $nid==$row['KD_JENIS_KASUS']?'selected':'';
				$field.='<option value="'.$row['KD_JENIS_KASUS'].'" '.$sel.' >'.$row['VARIABEL_NAME'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboKasus1($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datakasus = $db->query("select KD_JENIS_KASUS,VARIABEL_NAME from mst_kasus where KD_JENIS_KASUS='Pneumonia'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Kasus Ditangani Puskesmas</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datakasus as $row){
				$sel = $nid==$row['KD_JENIS_KASUS']?'selected':'';
				$field.='<option value="'.$row['KD_JENIS_KASUS'].'" '.$sel.' >'.$row['VARIABEL_NAME'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboKasus2($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datakasus = $db->query("select KD_JENIS_KASUS,VARIABEL_NAME from mst_kasus where KD_JENIS_KASUS='Pneumonia'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Kasus Dirujuk RS</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datakasus as $row){
				$sel = $nid==$row['KD_JENIS_KASUS']?'selected':'';
				$field.='<option value="'.$row['KD_JENIS_KASUS'].'" '.$sel.' >'.$row['VARIABEL_NAME'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboKasus3($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datakasus = $db->query("select KD_JENIS_KASUS,VARIABEL_NAME from mst_kasus where KD_JENIS_KASUS='Pneumonia'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Kasus Kematian</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datakasus as $row){
				$sel = $nid==$row['KD_JENIS_KASUS']?'selected':'';
				$field.='<option value="'.$row['KD_JENIS_KASUS'].'" '.$sel.' >'.$row['VARIABEL_NAME'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}

	function getComboLevel($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$dataposisi = $db->query("select KD_UNIT_LAYANAN from mst_unit_pelayanan")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Level'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($dataposisi as $row){
				$sel = $nid==$row['KD_UNIT_LAYANAN']?'selected':'';
				$field.='<option value="'.$row['KD_UNIT_LAYANAN'].'" '.$sel.' >'.$row['KD_UNIT_LAYANAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboLevel1($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		//$dataposisi = $db->query("select KD_UNIT_LAYANAN,NAMA_UNIT from mst_unit_pelayanan where KD_UNIT_LAYANAN not like 'LAIN'")->result_array();//sebelum perubahan bulan mei 2014
		$dataposisi = $db->query("select KD_UNIT_LAYANAN,NAMA_UNIT from mst_unit_pelayanan where KD_UNIT_LAYANAN LIKE 'PUSKESMAS'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Level'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>;
			<option value="KABUPATEN" >KABUPATEN</option>;
			<!--<option value="PUSTU" >PUSTU</option>-->';
			foreach($dataposisi as $row){
				$sel = $nid==$row['KD_UNIT_LAYANAN']?'selected':'';
				$field.='<option value="'.$row['KD_UNIT_LAYANAN'].'" '.$sel.' >'.$row['NAMA_UNIT'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboVendor($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$dataposisi = $db->query("select KD_VENDOR,VENDOR from apt_mst_vendor")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Diterima dari'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($dataposisi as $row){
				$sel = $nid==$row['KD_VENDOR']?'selected':'';
				$field.='<option value="'.$row['KD_VENDOR'].'" '.$sel.' >'.$row['VENDOR'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboPemilikobat($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$dataposisi = $db->query("select KD_MILIK_OBAT,KEPEMILIKAN from apt_mst_milik_obat")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Pemilik Obat</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($dataposisi as $row){
				$sel = $nid==$row['KD_MILIK_OBAT']?'selected':'';
				$field.='<option value="'.$row['KD_MILIK_OBAT'].'" '.$sel.' >'.$row['KEPEMILIKAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboPenerima($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$dataposisi = $db->query("select KD_UNIT_FAR,NAMA_UNIT_FAR from apt_mst_unit")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Unit Penerima'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($dataposisi as $row){
				$sel = $nid==$row['KD_UNIT_FAR']?'selected':'';
				$field.='<option value="'.$row['KD_UNIT_FAR'].'" '.$sel.' >'.$row['NAMA_UNIT_FAR'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboPenerima1($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$dataposisi = $db->query("select KD_UNIT_FAR,NAMA_UNIT_FAR from apt_mst_unit")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Unit Yang Mengeluarkan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($dataposisi as $row){
				$sel = $nid==$row['KD_UNIT_FAR']?'selected':'';
				$field.='<option value="'.$row['KD_UNIT_FAR'].'" '.$sel.' >'.$row['NAMA_UNIT_FAR'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboKategoriKIA($nid='',$name,$id,$required='',$inline='',$hidden='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datakasus = $db->query("select KD_KATEGORI_KIA,KATEGORI_KIA from mst_kategori_kia")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		$hidden = $hidden?'style="display:none"':'';
		
		$field='';
		$field.=$fieldset.'
		<span '.$hidden.'>
		<label>Kategori KIA</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datakasus as $row){
				$sel = $nid==$row['KD_KATEGORI_KIA']?'selected':'';
				$field.='<option value="'.$row['KD_KATEGORI_KIA'].'" '.$sel.' >'.$row['KATEGORI_KIA'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}

	function getComboPeriksaIbu($nid='',$name,$id,$required='',$inline='',$hidden='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datakasus = $db->query("select KD_KUNJUNGAN_KIA,KUNJUNGAN_KIA from mst_kunjungan_kia")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		$hidden = $hidden?'style="display:none"':'';
		
		$field='';
		$field.=$fieldset.'
		<span id="'.$id.'" '.$hidden.'>
		<label>Kunjungan KIA</label>
		<select name="'.$name.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datakasus as $row){
				$sel = $nid==$row['KD_KUNJUNGAN_KIA']?'selected':'';
				$field.='<option value="'.$row['KD_KUNJUNGAN_KIA'].'" '.$sel.' >'.$row['KUNJUNGAN_KIA'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}

	function getComboPeriksaAnak($nid='',$name,$id,$required='',$inline='',$hidden='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datakasus = $db->query("select KD_KUNJUNGAN_KIA_ANAK,KUNJUNGAN_KIA_ANAK from mst_kunjungan_kia_anak")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		$hidden = $hidden?'style="display:none"':'';
		
		$field='';
		$field.=$fieldset.'
		<span '.$hidden.' id="'.$id.'" >
		<label>Kunjungan KIA</label>
		<select style="padding-bottom:5px;" name="'.$name.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datakasus as $row){
				$sel = $nid==$row['KD_KUNJUNGAN_KIA_ANAK']?'selected':'';
				$field.='<option value="'.$row['KD_KUNJUNGAN_KIA_ANAK'].'" '.$sel.' >'.$row['KUNJUNGAN_KIA_ANAK'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboJenisPasienImunisasi($nid='',$name,$id,$required='',$inline='',$disabled='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$dataposisi = $db->query("select KD_JENIS_PASIEN,JENIS_PASIEN from mst_jenis_pasien")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Kategori Pasien'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' '.$disabled.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($dataposisi as $row){
				$sel = $nid==$row['KD_JENIS_PASIEN']?'selected':'';
				$field.='<option value="'.$row['KD_JENIS_PASIEN'].'" '.$sel.' >'.$row['JENIS_PASIEN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboKecamatan1($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_KECAMATAN,KECAMATAN from mst_kecamatan")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Kecamatan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_KECAMATAN']?'selected':'';
				$field.='<option value="'.$row['KD_KECAMATAN'].'" class="'.$row['KD_KECAMATAN'].'" '.$sel.' >'.$row['KECAMATAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboJenisLokasi1($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_KATEGORI_IMUNISASI,KATEGORI_IMUNISASI from mst_kategori_jenis_lokasi_imunisasi")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Jenis Lokasi KIPI'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_KATEGORI_IMUNISASI']?'selected':'';
				$field.='<option value="'.$row['KD_KATEGORI_IMUNISASI'].'" class="'.$row['KD_KATEGORI_IMUNISASI'].'" '.$sel.' >'.$row['KATEGORI_IMUNISASI'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboKeadaanKesehatan($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_KEADAAN_KESEHATAN,KEADAAN_KESEHATAN from mst_keadaan_kesehatan")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Kondisi Akhir'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_KEADAAN_KESEHATAN']?'selected':'';
				$field.='<option value="'.$row['KD_KEADAAN_KESEHATAN'].'" class="'.$row['KD_KEADAAN_KESEHATAN'].'" '.$sel.' >'.$row['KEADAAN_KESEHATAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboJenisLokasiimunisasi($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_KATEGORI_IMUNISASI,KATEGORI_IMUNISASI from mst_kategori_jenis_lokasi_imunisasi")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Jenis Lokasi'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_KATEGORI_IMUNISASI']?'selected':'';
				$field.='<option value="'.$row['KD_KATEGORI_IMUNISASI'].'" class="'.$row['KD_KATEGORI_IMUNISASI'].'" '.$sel.' >'.$row['KATEGORI_IMUNISASI'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboLevelSub($nid='',$name,$id,$required='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_UNIT_FAR, NAMA_UNIT_FAR from apt_mst_unit")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$field='';
		$field.='
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_UNIT_FAR']?'selected':'';
				$field.='<option value="'.$row['KD_UNIT_FAR'].'" class="'.$row['KD_UNIT_FAR'].'" '.$sel.' >'.$row['NAMA_UNIT_FAR'].'</option>';
			}
		$field.='
		</select>';
		
		return $field;
	}
	
	function getComboSubLevel($nid='',$name,$id,$required='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_SUB_LEVEL, NAMA_SUB_LEVEL from sys_setting_def")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$field='';
		$field.='
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >';
			foreach($datalokasi as $row){
				$sel = $nid==$row['NAMA_SUB_LEVEL']?'selected':'';
				$field.='<option value="'.$row['NAMA_SUB_LEVEL'].'" class="'.$row['KD_SUB_LEVEL'].'" '.$sel.' >'.$row['NAMA_SUB_LEVEL'].'</option>';
			}
		$field.='
		</select>';
		
		return $field;
	}
	
?>