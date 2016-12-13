<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	/**
	 * Pemkes Helper -- Just Functions and Stuffs
	 *
	 * PHP version 5
	 * @author    Berie
	*/
	function getComboPenyakit($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_PENYAKIT,PENYAKIT from mst_icd")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Penyakit/Masalah'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_PENYAKIT']?'selected':'';
				$field.='<option value="'.$row['KD_PENYAKIT'].'" '.$sel.' >'.$row['PENYAKIT'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	/*function getComboTindakan($nid='',$name,$id,$required='',$inline='') {		
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
	*/
	/*function getComboPemeriksa($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_DOKTER,NAMA,JABATAN from mst_dokter")->result_array();
		
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
				$field.='<option value="'.$row['KD_DOKTER'].'" '.$sel.' >'.$row['NAMA'].''.$sel.' - Jabatan : '.$row['JABATAN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	*/
	
	/*function getComboPetugas($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_DOKTER,NAMA,JABATAN from mst_dokter")->result_array();
		
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
				$field.='<option value="'.$row['KD_DOKTER'].'" '.$sel.' >'.$row['NAMA'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}*/
	
	
	function getComboLetakJanin($nid='',$name,$id,$required='',$inline='',$hidden='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datakasus = $db->query("select KD_LETAK_JANIN,LETAK_JANIN from mst_letak_janin")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		$hidden = $hidden?'style="display:none"':'';
		
		$field='';
		$field.=$fieldset.'
		<span '.$hidden.'>
		<label>Letak Janin</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datakasus as $row){
				$sel = $nid==$row['KD_LETAK_JANIN']?'selected':'';
				$field.='<option value="'.$row['KD_LETAK_JANIN'].'" '.$sel.' >'.$row['LETAK_JANIN'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	
?>