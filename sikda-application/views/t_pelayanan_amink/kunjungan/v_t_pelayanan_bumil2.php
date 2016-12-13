<style>
.ui-menu-item{
	font-size:.59em;
	color:blue!important;
}
.ui-autocomplete-category {
	font-weight: bold;
	padding: .1em .1.5em;
	margin: .8em 0 .2em;
	line-height: 1.5;
	font-size:.71em;
}
.ui-autocomplete{
	width:355px!important;
}
.inputaction1{
	width:255px;font-weight:bold;
}
.inputaction2{
	width:255px;font-weight:bold;color:#0B77B7
}
.labelaction{
	font-weight:bold;font-size:1.05em;color:#0B77B7;width:175px;
}
.declabel{width:91px}
.declabel2{width:175px}
.decinput{width:99px}
</style>
<script>
//$('#tanggal_kembaliid').datepicker({dateFormat: "dd/mm/yy",changeYear: true});
//$("#tanggal_kembaliid").mask("99/99/9999");
$(document).ready(function(){
	$('#form1t_kunjungan_ibu_hamil_add').ajaxForm({
		beforeSend: function() {
			achtungShowLoader();	
		},
		uploadProgress: function(event, position, total, percentComplete) {
		},
		complete: function(xhr) {
			achtungHideLoader();
			if(xhr.responseText!=='OK'){
				$.achtung({message: xhr.responseText, timeout:5});
			}else{
				$.achtung({message: 'Proses Tambah Data Berhasil', timeout:5});
				$("#t333","#tabs").empty();
				$("#t333","#tabs").load('t_kunjungan_ibu_hamil'+'?_=' + (new Date()).getTime());
			}
		}
	})
	
	$("#form1t_kunjungan_ibu_hamil_add").validate({
		rules: {
				tgl_kunjungan_ibu_hamil: {
				date:true,
				required: true
			}
		},
		messages: {
				tgl_kunjungan_ibu_hamil: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			}
		}
	});
	
jQuery("#listtindakan_bumil").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 600,
			height: 'auto',
			colNames:['Kode Tindakan','Tindakan'],
			colModel :[ 
			{name:'kd_tindakan',index:'kd_tindakan', width:55,align:'center',hidden:true}, 
			{name:'tindakan',index:'tindakan', width:81}
			],
			rowNum:35,
			viewrecords: true
		});
			var tindakanbumilid = 0;
		$('#tambahtindakanbumilid').click(function(){
			if($('#tindakanbumilsearch_tmpval').val()){
				var myfirstrow = {kd_tindakan:$('#tindakanbumilsearch_tmpval').val(),tindakan:$('#tindakanbumilsearch_tmptext').val()};
				jQuery("#listtindakan_bumil").addRowData(tindakanbumilid+1, myfirstrow);
				$('#tindakanbumilsearch').val('');
				$('#tindakanbumilsearch_tmpval').val('');
				$('#tindakanbumilsearch_tmptext').val('');
				if(confirm('Tambah Data Diagnosa Tindakan?')){
					$('#tindakanbumilsearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Diagnosa.');
			}
		});	
		$('#hapustindakanbumilid').click(function(){
			jQuery("#listtindakan_bumil").clearGridData();
		});
	});
		
			

$("#form1t_kunjungan_ibu_hamil_add").validate({focusInvalid:true});

$.widget( "custom.catcomplete", $.ui.autocomplete, {
	_renderMenu: function( ul, items ) {
		var that = this,
		currentCategory = "";
		$.each( items, function( index, item ) {
		if ( item.category != currentCategory ) {
			ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
			currentCategory = item.category;
		}
			that._renderItemData( ul, item );
		});
	}
});

$('#form1t_kunjungan_ibu_hamil_add :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_kunjungan_ibu_hamil_add").valid()) {
		if(kumpularray())$('#form1t_kunjungan_ibu_hamil_add').submit();
	}
	return false;
});
	
$( "#tindakanbumilsearch" ).catcomplete({
		source: "t_kunjungan_ibu_hamil/produksource",
		minLength: 1,
		select: function( event, ui ) {
			$('#tindakanbumilsearch_tmpval').val(ui.item.id);
			$('#tindakanbumilsearch_tmptext').val(ui.item.label);
		}
});	

$('#kunjungan_ibu_hamil_id_hidden').focus(function(){
			$("#dialogcari_kunjungan_ibu_hamil_id").dialog({
				autoOpen: false,
				modal:true,
				width: 1000,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_kunjungan_ibu_hamil_id').load('t_kunjungan_ibu_hamil/kunjungan_ibu_hamil_popup?id_caller=form1t_kunjungan_ibu_hamil_add', function() {
				$("#dialogcari_kunjungan_ibu_hamil_id").dialog("open");
			});
	});

$("#tgl_kunjungan_ibu_hamil").mask("99/99/9999");
</script>
<script>
	function kumpularray(){

		if($('#listtindakan_bumil').getGridParam("records")>0){
			var rows= jQuery("#listtindakan_bumil").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#tindakanbumil_final").val(JSON.stringify(paras));
		}

		return true;
				
	}
</script>
<script>
	$('#backlistt_kunjungan_ibu_hamil').click(function(){
		$("#t333","#tabs").empty();
		$("#t333","#tabs").load('t_kunjungan_ibu_hamil'+'?_=' + (new Date()).getTime());
	})
	$("#form1t_kunjungan_ibu_hamil_add input[name = 'batal'], #backlistt_kunjungan_ibu_hamil").click(function(){
		$("#t333","#tabs").empty();
		$("#t333","#tabs").load('t_kunjungan_ibu_hamil'+'?_=' + (new Date()).getTime());
	});
</script>
<div class="mycontent">
<div id="dialogcari_kunjungan_ibu_hamil_id" title="Riwayat Kunjungan"></div>
<div class="formtitle">Ibu Hamil</div>
<div class="backbutton"><span class="kembali" id="">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_kunjungan_ibu_hamil_add" method="post" action="<?=site_url('t_kunjungan_ibu_hamil/addprocess')?>" enctype="multipart/form-data">
		<fieldset>
		<span>
		<label>Rekam Medis#</label>
		<input type="text" name="text" value="<?=$data->KD_PASIEN?>" disabled />
		<input type="hidden" name="kd_pasien_hidden" id="textid" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="hidden" name="kd_kunjungan_hidden" id="textid" value="<?=$data->KD_KUNJUNGAN?>" />
		<input type="hidden" name="kd_unit_hidden" id="textid" value="<?=$data->KD_UNIT?>" />
		<input type="hidden" name="kd_urutmasuk_hidden" id="textid" value="<?=$data->URUT_MASUK?>" />
		<input type="hidden" name="showhide_kunjungan" id="textid" value="rawat_inap" />
		</span>
		<span>
		<label>NIK</label>
		<input type="text" name="text" value="<?=$data->NIK?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="text" value="<?=$data->NAMA_PASIEN?>" disabled />
		</span>
		<span>
		<label>Golongan Darah</label>
		<input type="text" name="text" value="<?=$data->KD_GOL_DARAH?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Pasien</label>
		<input type="text" name="text" value="<?=$data->CUSTOMER?>" disabled />
		</span>
		<span>
		<label>Tanggal Lahir</label>
		<input type="text" name="text" value="<?=$data->TGL_LAHIR?>" disabled />
		</span>
	</fieldset>
		<fieldset>
			<span>
				<label>Tanggal Kunjungan*</label>
				<input type="text" name="tgl_kunjungan" id="tgl_kunjungan_ibu_hamil" value="<?=date('d/m/Y')?>" class="mydate" />
			</span>
		</fieldset>
		<fieldset>
			<span>
				<label>Kunjungan Ke</label>
				<input type="text" name="kunjungan_ke" id="kunjungan_ke" value=""/>
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Keluhan Sekarang</label>
				<textarea placeholder="Sebutkan Keluhan" name="keluhan" id="keluhan_ibu_hamil" value="" style="width:195px;height:75px"></textarea>
			</span>
		</fieldset>
		<fieldset>
			<span>
				<label>Tekanan Darah (mmHg)</label>
				<input type="text" name="tekanan_darah" id="tekanan_darah_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Berat Badan (Kg)</label>
				<input type="text" name="berat_badan" id="berat_badan_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Umur Kehamilan (minggu)</label>
				<input type="text" name="umur_hamil" id="umur_kehamilan_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Tinggi Fundus (cm)</label>
				<input type="text" name="tinggi_fundus" id="tinggi_fundus_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
		<?=getComboLetakJanin('','letak_janin','letak_janin','required','inline')?>
		</fieldset>
		<fieldset>
			<span>
				<label>Denyut Jantung Janin per Menit</label>
				<input type="text" name="denyut_jantung" id="denyut_jantung_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Kaki Bengkak</label>
				<select name="kaki_bengkak" id="kaki_bengkak_ibu_hamil">
					<option value="">- silahkan pilih -</option>
					<option value="+">Positif (+)</option>
					<option value="-">Negatif (-)</option>
				</select>
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Lab Darah HB (gram%)</label>
				<input type="text" name="lab_darah" id="lab_darah_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Lab Urine Reduksi</label>
				<input type="text" name="lab_urin_reduksi" id="lab_urin_reduksi_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Lab Urine Protein</label>
				<input type="text" name="lab_urin_protein" id="lab_urin_protein_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<table id="listtindakan_bumil"></table>
		<fieldset id="fieldstindakan">
			<span>
			<label class="declabel2">Tindakan</label>
			<input type="text" name="text" value="" id="tindakanbumilsearch" style="width:255px;" />
			</span>
			<span>
			<input type="hidden" name="tindakanbumilsearch_tmpval" id="tindakanbumilsearch_tmpval" />
			<input type="hidden" name="tindakanbumilsearch_tmptext" id="tindakanbumilsearch_tmptext" />
			<input type="hidden" name="tindakanbumil_final" id="tindakanbumil_final" />
			<input type="button" value="Tambah" id="tambahtindakanbumilid" />
			<input type="button" id="hapustindakanbumilid" value="Hapus" />
			</span>
		</fieldset>
		<fieldset>
			<span>
				<label>Pemeriksaan Khusus</label>
				<select name="pemeriksaan_khusus" id="pemeriksaan_khusus_ibu_hamil">
					<option value="">- silahkan pilih -</option>
					<option value=""></option>
					<option value=""></option>
				</select>
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Penyebab Kematian</label>
				<select name="sebab_mati" id="sebab_mati_ibu_hamil">
					<option value="">- silahkan pilih -</option>
					<option value=""></option>
					<option value=""></option>
				</select>
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Status Hamil</label>
				<input type="text" name="status_hamil" id="status_hamil_ibu_hamil"  value="Belum Melahirkan"  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Nasehat yang Disampaikan</label>
				<textarea type="text" name="nasehat" id="nasehat_ibu_hamil" value="" style="width:195px;height:75px"></textarea>
			</span>
		</fieldset>	
		<fieldset>
		<?=getComboPemeriksa('','nama_pemeriksa','nama_pemeriksa','required','inline')?>
		</fieldset>
		<fieldset>
			<?=getComboPetugas('','nama_petugas','nama_petugas','required','inline')?>
			<span>
			<input type="button" name="popup" id="kunjungan_ibu_hamil_id_hidden" value="Lihat Kunjungan">
			</span>
		</fieldset>
		<fieldset>
			<span>
			<input type="button" name="batal" value="Batal" />
			&nbsp; - &nbsp;
			<input type="submit" name="bt1" value="Simpan"/>
			</span>
		</fieldset>	
</form>
</div >