<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	/**
	 * Ernes Helper -- Just Functions and Stuffs
	 *
	 * PHP version 5
	 * @author    Ernes
	*/
	function ernesstr_replace($string="",$find=array(),$replace=array()){
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
	
	
	function getComboJabatan($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_DOKTER,JABATAN from mst_dokter where kd_puskesmas='".$CI->session->userdata('kd_puskesmas')."' ")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Jabatan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_DOKTER']?'selected':'';
				$field.='<option value="'.$row['KD_DOKTER'].'" class="'.$row['KD_DOKTER'].'" '.$sel.' >'.$row['JABATAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboKeadaanibu($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_KEADAAN_KESEHATAN,KEADAAN_KESEHATAN from mst_keadaan_kesehatan ")->result_array();
		
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
				$field.='<option value="'.$row['KD_KEADAAN_KESEHATAN'].'" class="'.$row['KD_KEADAAN_KESEHATAN'].'" '.$sel.' >'.$row['KEADAAN_KESEHATAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboKeadaanbayi($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_KEADAAN_KESEHATAN,KEADAAN_KESEHATAN from mst_keadaan_kesehatan ")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Keadaan Bayi'.$starsign.'</label>
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
	
	function getComboKomplikasinifas($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_KOMPLIKASI_NIFAS,KOMPLIKASI_NIFAS from mst_komplikasi_nifas ")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Komplikasi Nifas'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_KOMPLIKASI_NIFAS']?'selected':'';
				$field.='<option value="'.$row['KD_KOMPLIKASI_NIFAS'].'" class="'.$row['KD_KOMPLIKASI_NIFAS'].'" '.$sel.' >'.$row['KOMPLIKASI_NIFAS'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboJenisimunisasi($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_JENIS_IMUNISASI,JENIS_IMUNISASI from mst_jenis_imunisasi ")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>JENIS IMUNISASI'.$starsign.'</label>
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
	
	
	?>