<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	/**
	 * Berie Helper -- Just Functions and Stuffs
	 *
	 * PHP version 5
	 * @author    Berie
	*/
	
	
	function getComboPenyebabkematian($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_PENYEBAB_KEMATIAN,PENYEBAB_KEMATIAN from mst_penyebab_kematian")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Penyebab'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_PENYEBAB_KEMATIAN']?'selected':'';
				$field.='<option value="'.$row['KD_PENYEBAB_KEMATIAN'].'" class="'.$row['KD_PENYEBAB_KEMATIAN'].'" '.$sel.' >'.$row['PENYEBAB_KEMATIAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboPemeriksa($nid='',$name,$id,$required='',$inline='') {		

		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_DOKTER,NAMA,JABATAN from mst_dokter where kd_puskesmas='".$CI->session->userdata('kd_puskesmas')."'")->result_array();
		
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
				$field.='<option value="'.$row['KD_DOKTER'].'" '.$sel.' >'.$row['NAMA'].' - Jabatan : '.$row['JABATAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboDokterPetugas($nid='',$name,$id,$required='',$inline='') {		
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
	
	function getComboJenislokasi($nid='',$name,$id,$required='',$inline='') {		
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
	
	function getComboKecamatan($nid='',$name,$id,$required='',$inline='') {		
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
	
	/*function getComboKelurahan($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_KELURAHAN,KELURAHAN,KD_KECAMATAN from mst_kelurahan")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Desa/Kelurahan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_KELURAHAN']?'selected':'';
				$field.='<option value="'.$row['KD_KELURAHAN'].'" class="'.$row['KD_KECAMATAN'].'" '.$sel.' >'.$row['KELURAHAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}*/
	
	function getComboJenisimunisasi1($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_JENIS_IMUNISASI,JENIS_IMUNISASI from mst_jenis_imunisasi")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Jenis Imunisasi'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_JENIS_IMUNISASI']?'selected':'';
				$field.='<option value="'.$row['KD_JENIS_IMUNISASI'].'" class="'.$row['KD_JENIS_IMUNISASI'].'" '.$sel.' >'.$row['JENIS_IMUNISASI'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboVaksin($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select a.KD_OBAT, b.HARGA_JUAL, NAMA_OBAT, KD_JENIS_IMUNISASI from apt_mst_obat a join apt_mst_harga_obat b ON a.KD_OBAT=b.KD_OBAT where KD_GOL_OBAT='VAKSIN'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Vaksin'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_OBAT']?'selected':'';
				$field.='<option value="'.$row['KD_OBAT'].'" class="'.$row['KD_JENIS_IMUNISASI'].'" '.$sel.' >'.$row['NAMA_OBAT'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboVaksin1($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select a.KD_OBAT, b.HARGA_JUAL, NAMA_OBAT, KD_JENIS_IMUNISASI from apt_mst_obat a join apt_mst_harga_obat b ON a.KD_OBAT=b.KD_OBAT where KD_GOL_OBAT='VAKSIN'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Vaksin'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_OBAT']?'selected':'';
				$field.='<option value="'.$row['KD_OBAT'].'-'.$row['HARGA_JUAL'].'" class="'.$row['KD_JENIS_IMUNISASI'].'" '.$sel.' >'.$row['NAMA_OBAT'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboJenissarana($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_SARANA_POSYANDU,NAMA_SARANA_POSYANDU from mst_sarana_posyandu")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Jenis Sarana'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_SARANA_POSYANDU']?'selected':'';
				$field.='<option value="'.$row['KD_SARANA_POSYANDU'].'" class="'.$row['KD_SARANA_POSYANDU'].'" '.$sel.' >'.$row['NAMA_SARANA_POSYANDU'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboSatuanbarang($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_SATUAN,NAMA_SATUAN from mst_satuan")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Satuan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_SATUAN']?'selected':'';
				$field.='<option value="'.$row['KD_SATUAN'].'" class="'.$row['KD_SATUAN'].'" '.$sel.' >'.$row['NAMA_SATUAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
?>