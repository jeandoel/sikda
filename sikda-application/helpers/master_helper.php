<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	/**
	 * Berie Helper -- Just Functions and Stuffs
	 *
	 * PHP version 5
	 * @author    Berie
	*/
	function masterstr_replace($string="",$find=array(),$replace=array()){
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
	function getComboDokterPemeriksa($nid='',$name,$id,$required='',$inline='') {		
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
	
	
	function getComboTindakan($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_PRODUK,PRODUK from mst_produk")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Tindakan'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_PRODUK']?'selected':'';
				$field.='<option value="'.$row['KD_PRODUK'].'" '.$sel.' >'.$row['PRODUK'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	
	function getComboJeniskb($nid='',$name,$id,$required='',$inline='') {
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_JENIS_KB,JENIS_KB from mst_jenis_kb")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Jenis KB'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_JENIS_KB']?'selected':'';
				$field.='<option value="'.$row['KD_JENIS_KB'].'" class="'.$row['KD_JENIS_KB'].'" '.$sel.' >'.$row['JENIS_KB'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
?>