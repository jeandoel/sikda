<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	/**
	 * Berie Helper -- Just Functions and Stuffs
	 *
	 * PHP version 5
	 * @author    Berie
	*/
	function beriestr_replace($string="",$find=array(),$replace=array()){
		$result = '';
		$i=0;
		foreach($replace as $rep){
			$newrep[] = $rep=='todate'?"DATE_FORMAT(".$find[0].", '%d-%M-%Y') as ".$find[0]:$rep;
			$i++;
		}
		
		$result = str_replace($find,$newrep,$string);
		$result = trim($result,',');
		$result = str_replace(',,',',',$result);

		return $result;
	}
	
	function getComboJeniskelamin($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_JENIS_KELAMIN,JENIS_KELAMIN from mst_jenis_kelamin")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Jenis Kelamin'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_JENIS_KELAMIN']?'selected':'';
				$field.='<option value="'.$row['KD_JENIS_KELAMIN'].'" '.$sel.' >'.$row['JENIS_KELAMIN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboJenispasien($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_CUSTOMER,CUSTOMER from mst_kel_pasien")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Kel/Jenis Pasien'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid===$row['KD_CUSTOMER']?'selected':'';
				$field.='<option value="'.$row['KD_CUSTOMER'].'" class="'.$row['KD_CUSTOMER'].'" '.$sel.' >'.$row['CUSTOMER'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboDokterdanPetugas($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_DOKTER,NAMA from mst_dokter where kd_puskesmas='".$CI->session->userdata('kd_puskesmas')."'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Petugas 2'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_DOKTER']?'selected':'';
				$field.='<option value="'.$row['KD_DOKTER'].'" class="'.$row['KD_DOKTER'].'" '.$sel.' >'.$row['NAMA'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboDokterdanPetugas20($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_DOKTER,NAMA from mst_dokter where kd_puskesmas='".$CI->session->userdata('kd_puskesmas')."'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Dokter Pemeriksa'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_DOKTER']?'selected':'';
				$field.='<option value="'.$row['KD_DOKTER'].'" class="'.$row['KD_DOKTER'].'" '.$sel.' >'.$row['NAMA'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboCarabayar($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_BAYAR,CARA_BAYAR,KD_CUSTOMER from mst_cara_bayar")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Cara/Bayar'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid===$row['KD_BAYAR']?'selected':'';
				$field.='<option value="'.$row['KD_BAYAR'].'" class="'.$row['KD_CUSTOMER'].'" '.$sel.' >'.$row['CARA_BAYAR'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboProvinsi($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_PROVINSI,PROVINSI from mst_provinsi")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Provinsi'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_PROVINSI']?'selected':'';
				$field.='<option value="'.$row['KD_PROVINSI'].'" class="'.$row['KD_PROVINSI'].'" '.$sel.' >'.$row['PROVINSI'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboKelurahan($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_PROVINSI,PROVINSI from mst_provinsi")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Provinsi'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_PROVINSI']?'selected':'';
				$field.='<option value="'.$row['KD_PROVINSI'].'" class="'.$row['KD_PROVINSI'].'" '.$sel.' >'.$row['PROVINSI'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboPuskesmasByKec($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_PUSKESMAS,PUSKESMAS from mst_puskesmas where KD_KECAMATAN='".$CI->session->userdata('kd_kecamatan')."'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Puskesmas'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_PUSKESMAS']?'selected':'';
				$field.='<option value="'.$row['KD_PUSKESMAS'].'" class="'.$row['KD_PUSKESMAS'].'" '.$sel.' >'.$row['PUSKESMAS'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboPuskesmasByKab($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_PUSKESMAS,PUSKESMAS from mst_puskesmas where KD_KABUPATEN='".$CI->session->userdata('kd_kabupaten')."'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Puskesmas'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_PUSKESMAS']?'selected':'';
				$field.='<option value="'.$row['KD_PUSKESMAS'].'" class="'.$row['KD_PUSKESMAS'].'" '.$sel.' >'.$row['PUSKESMAS'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboPuskesmasByKabb($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_PUSKESMAS,PUSKESMAS from mst_puskesmas where SUBSTRING(KD_PUSKESMAS,2,4)='".$CI->session->userdata('kd_kabupaten')."'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_PUSKESMAS']?'selected':'';
				$field.='<option value="'.$row['KD_PUSKESMAS'].'" class="'.$row['KD_PUSKESMAS'].'" '.$sel.' >'.$row['PUSKESMAS'].'</option>';
			}
		$field.='
		</select>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboKelurahanByKec($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_KELURAHAN,KELURAHAN from mst_kelurahan where KD_KECAMATAN='".$CI->session->userdata('kd_kecamatan')."'")->result_array();
		
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
				$field.='<option value="'.$row['KD_KELURAHAN'].'" class="'.$row['KD_KELURAHAN'].'" '.$sel.' >'.$row['KELURAHAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboKecamatanByKab($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_KECAMATAN,KECAMATAN from mst_kecamatan where KD_KABUPATEN='".$CI->session->userdata('kd_kabupaten')."'")->result_array();
		
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
	
	function getComboKabupatenByProv($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_PROVINSI,PROVINSI from mst_provinsi where KD_PROVINSI='".$CI->session->userdata('kd_provinsi')."'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Kabupaten'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_PROVINSI']?'selected':'';
				$field.='<option value="'.$row['KD_PROVINSI'].'" class="'.$row['KD_PROVINSI'].'" '.$sel.' >'.$row['PROVINSI'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboAgama($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_AGAMA,AGAMA from mst_agama")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Agama'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_AGAMA']?'selected':'';
				$field.='<option value="'.$row['KD_AGAMA'].'" class="'.$row['KD_AGAMA'].'" '.$sel.' >'.$row['AGAMA'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboGoldarah($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_GOL_DARAH,GOL_DARAH from mst_gol_darah")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Golongan Darah'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_GOL_DARAH']?'selected':'';
				$field.='<option value="'.$row['KD_GOL_DARAH'].'" class="'.$row['KD_GOL_DARAH'].'" '.$sel.' >'.$row['GOL_DARAH'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboPendidikan($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_PENDIDIKAN,PENDIDIKAN from mst_pendidikan")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Pendidikan Akhir'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_PENDIDIKAN']?'selected':'';
				$field.='<option value="'.$row['KD_PENDIDIKAN'].'" class="'.$row['KD_PENDIDIKAN'].'" '.$sel.' >'.$row['PENDIDIKAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboPekerjaan($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_PEKERJAAN,PEKERJAAN from mst_pekerjaan")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Pekerjaan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_PEKERJAAN']?'selected':'';
				$field.='<option value="'.$row['KD_PEKERJAAN'].'" class="'.$row['KD_PEKERJAAN'].'" '.$sel.' >'.$row['PEKERJAAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboRas($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_RAS,RAS from mst_ras")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Ras/Suku'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_RAS']?'selected':'';
				$field.='<option value="'.$row['KD_RAS'].'" class="'.$row['KD_RAS'].'" '.$sel.' >'.$row['RAS'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboStatusnikah($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_STATUS,STATUS from mst_status_marital")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Status Nikah'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_STATUS']?'selected':'';
				$field.='<option value="'.$row['KD_STATUS'].'" class="'.$row['KD_STATUS'].'" '.$sel.' >'.$row['STATUS'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboUnitlayanan($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_UNIT_LAYANAN,NAMA_UNIT from mst_unit_pelayanan")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Unit Layanan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_UNIT_LAYANAN']?'selected':'';
				$field.='<option value="'.$row['KD_UNIT_LAYANAN'].'" class="'.$row['KD_UNIT_LAYANAN'].'" '.$sel.' >'.$row['NAMA_UNIT'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboUnitlayanandsb($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_UNIT_LAYANAN,NAMA_UNIT from mst_unit_pelayanan")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = 'readonly';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Unit Layanan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$required.' >';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_UNIT_LAYANAN']?'selected':'';
				$field.='<option  disabled="disabled" value="'.$row['KD_UNIT_LAYANAN'].'" class="'.$row['KD_UNIT_LAYANAN'].'" '.$sel.' >'.$row['NAMA_UNIT'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboUnitlayanandsbpks($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_UNIT_LAYANAN,NAMA_UNIT from mst_unit_pelayanan where NAMA_UNIT<>'PUSKESMAS'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = 'readonly';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<select name="'.$name.'" id="'.$id.'" '.$required.' >';
			foreach($datalokasi as $row){
				$field.='<option value="'.$row['KD_UNIT_LAYANAN'].'" class="'.$row['KD_UNIT_LAYANAN'].'"  >'.$row['NAMA_UNIT'].'</option>';
			}
		$field.='
		</select>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboPoliklinik($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_UNIT,UNIT from mst_unit where PARENT = 2")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Poliklinik'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_UNIT']?'selected':'';
				$field.='<option value="'.$row['KD_UNIT'].'" class="'.$row['KD_UNIT'].'" '.$sel.' >'.$row['UNIT'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboSpesialisasi2($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_UNIT,UNIT from mst_unit where PARENT = 99")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Spesialisasi'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_UNIT']?'selected':'';
				$field.='<option value="'.$row['KD_UNIT'].'" class="'.$row['KD_UNIT'].'" '.$sel.' >'.$row['UNIT'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboPoliklinikPlus($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_UNIT,UNIT from mst_unit where PARENT = 2")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Konsul Poli Lain?'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - pilih poli- </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_UNIT']?'selected':'';
				$field.='<option value="'.$row['KD_UNIT'].'" class="'.$row['KD_UNIT'].'" '.$sel.' >'.$row['UNIT'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboPoliklinik2($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_UNIT,UNIT from mst_unit where PARENT = 2")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Poliklinik'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="all" '.$selected.'> - semua unit poli - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_UNIT']?'selected':'';
				$field.='<option value="'.$row['KD_UNIT'].'" class="'.$row['KD_UNIT'].'" '.$sel.' >'.$row['UNIT'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboSpesialisasi($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_SPESIAL,SPESIALISASI from mst_spesialisasi")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Spesialisasi'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_SPESIAL']?'selected':'';
				$field.='<option value="'.$row['KD_SPESIAL'].'" class="'.$row['KD_SPESIAL'].'" '.$sel.' >'.$row['SPESIALISASI'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboRuangan($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_RUANGAN,NAMA_RUANGAN from mst_ruangan where KD_PUSKESMAS='".$CI->session->userdata('kd_puskesmas')."'")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Ruangan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_RUANGAN']?'selected':'';
				$field.='<option value="'.$row['KD_RUANGAN'].'" class="'.$row['KD_RUANGAN'].'" '.$sel.' >'.$row['NAMA_RUANGAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboKamar($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("SELECT DISTINCT NAMA_KAMAR FROM mst_kamar")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Nama Kamar'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['NAMA_KAMAR']?'selected':'';
				$field.='<option value="'.$row['NAMA_KAMAR'].'" class="'.$row['NAMA_KAMAR'].'" '.$sel.' >'.$row['NAMA_KAMAR'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboStatuskeluar($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("SELECT DISTINCT KD_STATUS,KETERANGAN FROM mst_status_keluar_pasien")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Status Keluar Pasien'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_STATUS']?'selected':'';
				$field.='<option value="'.$row['KD_STATUS'].'" class="'.$row['KD_STATUS'].'" '.$sel.' >'.$row['KETERANGAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboSatuan($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("SELECT k.SAT_KCL_OBAT as SATUAN FROM apt_mst_sat_kecil k UNION ALL SELECT b.SAT_BESAR_OBAT FROM apt_mst_sat_besar b")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label style="width:55px">Satuan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.'  style="width:75px">';
			foreach($datalokasi as $row){
				$sel = $nid==$row['SATUAN']?'selected':'';
				$field.='<option value="'.$row['SATUAN'].'" class="'.$row['SATUAN'].'" '.$sel.' >'.$row['SATUAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getChartSmall($ChartType='',$field='')
	{		
		require_once ('./assets/include/jpgraph/src/jpgraph.php');		
		
		$CI =& get_instance();
		$db = $CI->load->database('sikda', TRUE);
		
		if($field=='nnama_kategori'){
		$result = $db->query("SELECT COUNT(nid_kasus) AS jumlah,k.nnama_kategori AS tahun FROM tbl_laporankasus l 
							join tbl_mkategori k on k.nid_kategori=l.nid_kategori 
							GROUP BY k.nnama_kategori")->result_array();
		}elseif($field=='ntgl_kejadian'){
			$result = $db->query("SELECT COUNT(nid_kasus) AS jumlah,DATE_FORMAT(ntgl_kejadian,'%Y') AS tahun FROM tbl_laporankasus where YEAR(ntgl_kejadian) > YEAR(DATE_SUB(CURDATE(), INTERVAL 6 YEAR)) GROUP BY DATE_FORMAT(ntgl_kejadian,'%Y')")->result_array();
		}else{
			$result = $db->query("SELECT COUNT(nid_kasus) AS jumlah,".$field." AS tahun FROM tbl_laporankasus where YEAR(ntgl_kejadian) > YEAR(DATE_SUB(CURDATE(), INTERVAL 6 YEAR)) GROUP BY ".$field)->result_array();
		}
		
		$arraydata=array();
		$arrayyear=array();
		foreach($result as $res){
			$arraydata[] = $res['jumlah'];
			$arrayyear[] = $res['tahun'];
		}
		$databary=$arraydata?$arraydata:array(0);
		
		if($ChartType=='Bar'){
			require_once ('./assets/include/jpgraph/src/jpgraph_bar.php');		
			
			$graph = new Graph(300,125,'auto');	
			$graph->SetScale("textlin");
			$graph->SetShadow();
			$graph->img->SetMargin(30,30,25,40);

			$graph->xaxis->SetTickLabels($arrayyear);

			$b1 = new BarPlot($databary);
			
			$graph->Add($b1);

			return $graph;
		}elseif($ChartType=='Pie'){
			require_once ('./assets/include/jpgraph/src/jpgraph_pie.php');
			require_once ('./assets/include/jpgraph/src/jpgraph_pie3d.php');
			
			$graph = new PieGraph(300,115);
			$graph->SetShadow();

			$p1 = new PiePlot3D($databary);
			$p1->SetSize(0.5);
			$p1->SetCenter(0.35,0.5);
			$p1->SetLegends($arrayyear?$arrayyear:array(0));

			$graph->legend->Pos(0.05,0.5,"midle","center");
			$graph->legend->SetLayout(LEGEND_VERT);

			$graph->Add($p1);
			return $graph;
		}elseif($ChartType=='Line'){
			require_once ('./assets/include/jpgraph/src/jpgraph_line.php');
			
			$graph = new Graph(300,125,'auto');
			$graph->SetScale('intlin');

			$lineplot=new LinePlot($databary);
			$graph->Add($lineplot);
			
			$graph->xaxis->SetTickLabels($arrayyear);
			$graph->xaxis->SetTextTickInterval(2);

			return $graph;
		}
	}
	
	function getMidleTableHelper()
	{				
		$CI =& get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$total=0;$thismonth=0;$sixmonth=0;
		$total = $db->query("SELECT COUNT(nid_kasus) AS total FROM tbl_laporankasus")->row();
		$thismonth = $db->query("SELECT COUNT(nid_kasus) AS total FROM tbl_laporankasus where ntgl_kejadian BETWEEN DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-01')")->row();
		$sixmonth = $db->query("SELECT COUNT(nid_kasus) AS total FROM tbl_laporankasus where ntgl_kejadian  > now() - INTERVAL 6 MONTH")->row();
		return '
			<h4 class="amount" rel="total">'.$total->total.'</h4>
			<table class="rptRevenue" rel="total">
				<tr class="thead">
					<th>Periode</th>
					<th>Jumlah</th>
				</tr>
				<tr>
					<td>Bulan Lalu</td>
					<td>'.$thismonth->total.'</td>
				</tr>
				<tr class="last">
					<td>6 Bulan Terakhir</td>
					<td>'.$sixmonth->total.'</td>
				</tr>
			</table>
		';
	}
	
	function bulan(){
		$montharray = array();
		$montharray['JANUARI'] 		= '01';
		$montharray['FEBRUARI'] 	= '02';
		$montharray['MARET'] 		= '03';
		$montharray['APRIL'] 		= '04';
		$montharray['MEI'] 			= '05';
		$montharray['JUNI'] 		= '06';
		$montharray['JULI'] 		= '07';
		$montharray['AGUSTUS'] 		= '08';
		$montharray['SEPTEMBER'] 	= '09';
		$montharray['OKTOBER'] 		= '10';
		$montharray['NOVEMBER'] 	= '11';
		$montharray['DESEMBER'] 	= '12';
		return $montharray;
	}
	
?>