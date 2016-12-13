<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	/**
	 * Berie Helper -- Just Functions and Stuffs
	 *
	 * PHP version 5
	 * @author    Berie
	*/
	
	function getComboProduk($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_PRODUK, PRODUK from mst_produk")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Tindakan untuk Anak'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_PRODUK']?'selected':'';
				$field.='<option value="'.$row['KD_PRODUK'].'" class="'.$row['KD_PRODUK'].'" '.$sel.' >'.$row['PRODUK'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
	function getComboProduk1($nid='',$name,$id,$required='',$inline='') {		
		$CI =&get_instance();
		$db = $CI->load->database('sikda', TRUE);
		$datalokasi = $db->query("select KD_PRODUK, PRODUK from mst_produk")->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<span>
		<label>Tindakan untuk Ibu'.$starsign.'</label>
		<select name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - silahkan pilih - </option>';
			foreach($datalokasi as $row){
				$sel = $nid==$row['KD_PRODUK']?'selected':'';
				$field.='<option value="'.$row['KD_PRODUK'].'" class="'.$row['KD_PRODUK'].'" '.$sel.' >'.$row['PRODUK'].'</option>';
			}
		$field.='
		</select>
		</span>
		'.$fieldsetend;
		
		return $field;
	}
	
?>