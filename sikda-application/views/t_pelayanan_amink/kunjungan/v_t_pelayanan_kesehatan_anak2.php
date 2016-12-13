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
$(document).ready(function(){
	$('#form1t_pemeriksaan_kesehatan_anak_add').ajaxForm({
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
				$("#t203","#tabs").empty();
				$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
			}
		}
	});	
	
	$("#form1t_pemeriksaan_kesehatan_anak_add").validate({
	rules: {
			tgl_periksa: {
			date:true,required: true
			}
	},
	messages: {
			tgl_periksa: {
			date: "Silahkan Masukkan Tanggal Sesuai Format",required:"Silahkan Lengkapi Data"
		}
	}
	});
	
	jQuery("#listpenyakit").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 600,
		height: 'auto',
		colNames:['Kode Penyakit','Penyakit'],
		colModel :[ 
		{name:'kd_penyakit',index:'kd_penyakit', width:100,align:'center',hidden:true},
		{name:'penyakit',index:'penyakit', width:500}, 
		],
		rowNum:35,
		viewrecords: true
	}); 
		
	jQuery("#listtindakan").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 600,
		height: 'auto',
		colNames:['Kode Tindakan','Tindakan'],
		colModel :[ 
		{name:'kd_tindakan',index:'kd_tindakan', width:100,align:'center',hidden:true},
		{name:'tindakan',index:'tindakan', width:500}, 
		],
		rowNum:35,
			viewrecords: true
		}); 
		
	var penyakitid = 0;
		$('#tambahpenyakitid').click(function(){
			if($('#penyakitsearch_tmpval').val()){
				var myfirstrow = {kd_penyakit:$('#penyakitsearch_tmpval').val(),penyakit:$('#penyakitsearch_tmptext').val()};
				jQuery("#listpenyakit").addRowData(penyakitid+1, myfirstrow);
				$('#penyakitsearch').val('');
				$('#penyakitsearch_tmpval').val('');
				$('#penyakitsearch_tmptext').val('');
				if(confirm('Tambah Diagnosa Penyakit?')){
					$('#penyakitsearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Diagnosa Penyakit.');
			}
		})	
		
	var tindakanid = 0;
		$('#tambahtindakanid').click(function(){
			if($('#tindakansearch_tmpval').val()){
				var myfirstrow = {kd_tindakan:$('#tindakansearch_tmpval').val(),tindakan:$('#tindakansearch_tmptext').val()};
				jQuery("#listtindakan").addRowData(tindakanid+1, myfirstrow);
				$('#tindakansearch').val('');
				$('#tindakansearch_tmpval').val('');
				$('#tindakansearch_tmptext').val('');
				if(confirm('Tambah Diagnosa Tindakan?')){
					$('#tindakansearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Diagnosa Tindakan.');
			}
		})	
		
	$('#hapuspenyakitid').click(function(){
			jQuery("#listpenyakit").clearGridData();
		})
		
	$('#hapustindakanid').click(function(){
			jQuery("#listtindakan").clearGridData();
		})
});

$("#form1t_pemeriksaan_kesehatan_anak_add").validate({focusInvalid:true});

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

$('#form1t_pemeriksaan_kesehatan_anak_add :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_pemeriksaan_kesehatan_anak_add").valid()) {
		if(kumpularray())$('#form1t_pemeriksaan_kesehatan_anak_add').submit();
	}
	return false;
});

$( "#penyakitsearch" ).catcomplete({
		source: "t_pemeriksaan_kesehatan_anak/icdsource",
		minLength: 1,
		select: function( event, ui ) {
			$('#penyakitsearch_tmpval').val(ui.item.id);
			$('#penyakitsearch_tmptext').val(ui.item.label);
		}
});

$( "#tindakansearch" ).catcomplete({
		source: "t_pemeriksaan_kesehatan_anak/produksource",
		minLength: 1,
		select: function( event, ui ) {
			$('#tindakansearch_tmpval').val(ui.item.id);
			$('#tindakansearch_tmptext').val(ui.item.label);
		}
});

$("#tgl_periksa").mask("99/99/9999");

</script>
<script>
function kumpularray(){
		if($('#listpenyakit').getGridParam("records")>0){
			var rows= jQuery("#listpenyakit").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#penyakit_final").val(JSON.stringify(paras));
		}
		
		if($('#listtindakan').getGridParam("records")>0){
			var rows= jQuery("#listtindakan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#tindakan_final").val(JSON.stringify(paras));
		}
		
		return true;
				
	}
</script>
<script>
	
	$("#form1t_pemeriksaan_kesehatan_anak_add input[name = 'batal'], #backlistt_pemeriksaan_kesehatan_anak").click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	});
</script>
<div class="mycontent">
<div class="formtitle">Pelayanan Kesehatan Anak/Bayi</div>
<div class="backbutton"><span class="kembali" id="">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pemeriksaan_kesehatan_anak_add" method="post" action="<?=site_url('t_pemeriksaan_kesehatan_anak/addprocess')?>" enctype="multipart/form-data">
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
	<div class="subformtitle">Pelayanan</div>
	<fieldset>		
		<?=getComboJenispasien('','jenis_pasien','jenis_pasient_pendaftaranadd','required','inline')?>
		<?=getComboCarabayar('','cara_bayar','carabayart_pendaftaranadd','required','inline')?>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Ayah</label>
		<input type="text" name="" id="" value="" disabled  />
		</span>
		<span>
		<label>Nama Ibu</label>
		<input type="text" name="" id=""  value="" disabled  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Kunjungan</label>
		<input type="text" name="" id="" value="" disabled  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tanggal Pelayanan</label>
		<input id="tgl_periksa" class="mydate" type="text" name="tgl_periksa" value="<?=date('d/m/Y')?>" required>
		</span>
	</fieldset>
	<br/>
	<table id="listpenyakit"></table>
	<fieldset id="fieldspenyakit">
		<span>
		<label class="declabel2">Masalah / Penyakit</label>
		<input type="text" name="text" value="" id="penyakitsearch" style="width:255px;" />
		</span>
		<span>
		<input type="hidden" name="penyakitsearch_tmpval" id="penyakitsearch_tmpval" />
		<input type="hidden" name="penyakitsearch_tmptext" id="penyakitsearch_tmptext" />
		<input type="hidden" name="penyakit_final" id="penyakit_final" />
		<input type="button" value="Tambah" id="tambahpenyakitid" />
		<input type="button" id="hapuspenyakitid" value="Hapus" />
		</span>
	</fieldset>
	<br/>
	<table id="listtindakan"></table>
	<fieldset id="fieldstindakan">
		<span>
		<label class="declabel2">Tindakan</label>
		<input type="text" name="text" value="" id="tindakansearch" style="width:255px;" />
		</span>
		<span>
		<input type="hidden" name="tindakansearch_tmpval" id="tindakansearch_tmpval" />
		<input type="hidden" name="tindakansearch_tmptext" id="tindakansearch_tmptext" />
		<input type="hidden" name="tindakan_final" id="tindakan_final" />
		<input type="button" value="Tambah" id="tambahtindakanid" />
		<input type="button" id="hapustindakanid" value="Hapus" />
		</span>
	</fieldset>
	<br/>
	<fieldset>
		<?=getComboPemeriksa('','kolom_nama_pemeriksa','kolom_nama_pemeriksa','required','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboPetugas('','kolom_nama_petugas','kolom_nama_petugas','required','inline')?>
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