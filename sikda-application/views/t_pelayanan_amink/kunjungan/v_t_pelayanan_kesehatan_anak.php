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
	
	jQuery("#listalergirawatjalan").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 1049,
			height: 'auto',
			colNames:['Kode Obat','Obat'],
			colModel :[ 
			{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
			{name:'obat',index:'obat', width:300}
			],
			rowNum:35,
			viewrecords: true
		}); 
		
		jQuery("#listobatrawatjalan").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 1049,
			height: 'auto',
			colNames:['Kode Obat','Obat', 'Dosis','Satuan','Jumlah'],
			colModel :[ 
			{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
			{name:'obat',index:'obat', width:300}, 
			{name:'dosis',index:'dosis', width:81}, 
			{name:'satuan_obat',index:'satuan_obat', width:81}, 
			{name:'jumlah',index:'jumlah', width:51,align:'center'}
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
	
	$('#alergiobatselectid').change(function(){
			var c = this.checked ?'checked':'unchecked';
			if(c=='checked'){
				$('#showhidealergitable').show();
				$('#obatsearchalergi').focus();
			}else{
				$('#showhidealergitable').hide();
			}
		});
		
		var obatid = 0;
		$('#tambahobatid').click(function(){
			if($('#obat_tmpval').val()){
				var myfirstrow = {kd_obat:$('#obat_tmpval').val(), obat:$('#obat_tmptext').val(), dosis:$('#dosisobatid').val(), jumlah:$('#kuantitasobatid').val(), satuan:$('#satuanobatid').val()};
				jQuery("#listobatrawatjalan").addRowData(obatid+1, myfirstrow);
				$('#obatsearch').val('');
				$('#dosisobatid').val('');
				$('#kuantitasobatid').val('');
				$('#satuan_obatid').val('');
				$('#kuantitasobatid').val('');
				$('#obat_tmptext').val('');
				$('#obat_tmpval').val('');
				if(confirm('Tambah Obat Lain?')){
					$('#obatsearch').focus();					
				}else{
					$('#statuskeluarid').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})
				
		var obatalergiid = 0;
		$('#tambahobatalergiid').click(function(){
			if($('#obat_tmpvalalergi').val()){
				var myfirstrow = {kd_obat:$('#obat_tmpvalalergi').val(), obat:$('#obat_tmptextalergi').val()};
				jQuery("#listalergirawatjalan").addRowData(obatalergiid+1, myfirstrow);
				$('#obatsearchalergi').val('');
				$('#obat_tmptextalergi').val('');
				$('#obat_tmpvalalergi').val('');
				if(confirm('Tambah Data Alergi Obat Lain?')){
					$('#obatsearchalergi').focus();					
				}else{
					$('#obatsearch').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})		
		
	$('#hapuspenyakitid').click(function(){
			jQuery("#listpenyakit").clearGridData();
		})
		
	$('#hapustindakanid').click(function(){
			jQuery("#listtindakan").clearGridData();
		})
		
	$('#hapusobatid').click(function(){
			jQuery("#listobatrawatjalan").clearGridData();
		})
		
	$('#hapusobatalergiid').click(function(){
		jQuery("#listalergirawatjalan").clearGridData();
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

$( "#obatsearch" ).catcomplete({
	source: "t_pemeriksaan_kesehatan_anak/obatsource",
	minLength: 1,
	select: function( event, ui ) {
		$('#obat_tmpval').val(ui.item.id);
		$('#obat_tmptext').val(ui.item.label);
	}
});

$( "#obatsearchalergi" ).catcomplete({
	source: "t_pemeriksaan_kesehatan_anak/obatsource",
	minLength: 1,
	select: function( event, ui ) {
		$('#obat_tmpvalalergi').val(ui.item.id);
		$('#obat_tmptextalergi').val(ui.item.label);
	}
});

$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
   var n = $(":text,:radio,:checkbox,select,textarea").length;
   if (e.which == 13) 
   {
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		if(nextIndex < n && $(this).valid()){
			if($(this).attr('id')=='selectjenisdiagnosaid'){
				if($('#penyakitsearch_tmpval').val()){
					$('#tambahpenyakitid').focus();return false;
				}
			}
			if($(this).attr('id')){
				if($('#tindakansearch_tmpval').val()){
					$('#tambahtindakanid').focus();return false;
				}	
			}
			
			if($(this).attr('id')=='selectjenisdiagnosaid'){
				if($('#icdsearch_tmpval').val()){
					$('#tambahdiagnosaid').focus();return false;
				}else{
					$('#produktindakansearch').focus();
				}
			}
			if($(this).attr('id')=='kuantitasobatid'){				
				if($('#obat_tmpval').val()){
					$('#tambahobatid').focus();return false;
				}else{
					$('#statuskeluarid').focus();
				}
			}
			if($(this).attr('id')=='obatsearchalergi'){				
				if($('#obat_tmpvalalergi').val()){
					$('#tambahobatalergiid').focus();return false;
				}else{
					$('#obatsearch').focus();
				}
			}
			
			$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
		}else{			
			if($("#form1t_pemeriksaan_kesehatan_anak_add").valid()) {
				if(kumpularray())$('#form1t_pemeriksaan_kesehatan_anak_add').submit();
			}
			return false;
		}
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
		
		if($('#listobatrawatjalan').getGridParam("records")>0){
			var rows= jQuery("#listobatrawatjalan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#obat_final").val(JSON.stringify(paras));
		}
		
		if($('#listalergirawatjalan').getGridParam("records")>0){
			var rows= jQuery("#listalergirawatjalan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#alergi_final").val(JSON.stringify(paras));
		}
		
		return true;
				
	}
</script>
<script>
	$('#backlistt_pemeriksaan_kesehatan_anak').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
	$("#form1t_pemeriksaan_kesehatan_anak_add input[name = 'batal'], #backlistt_pemeriksaan_kesehatan_anak").click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	});
</script>
<div class="mycontent">
<div class="formtitle">Tambah Transaksi Pemeriksaan Kesehatan Anak</div>
<div class="backbutton"><span class="kembali" id="backlistt_pemeriksaan_kesehatan_anak">kembali ke list</span></div>
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
	<fieldset>
		<span>
		<label>Tanggal Periksa</label>
		<input id="tgl_periksa" class="mydate" type="text" name="tgl_periksa" value="<?=date('d/m/Y')?>" required>
		</span>
	</fieldset>
	<br/>
	<table id="listpenyakit"></table>
	<fieldset id="fieldspenyakit">
		<span>
		<label>Masalah / Penyakit</label>
		<input type="text" name="text" value="" id="penyakitsearch" />
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
		<label>Tindakan</label>
		<input type="text" name="text" value="" id="tindakansearch" />
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
	<br/>
	<div class="subformtitle">Pemberian Obat/Vitamin</div>
	<br/>
	<div class="subformtitle">Alergi Obat</div>
	<fieldset>
		<span>
			<label class="declabel2">Alergi Obat?</label>
			<input type="checkbox" name="alergiobat" id="alergiobatselectid" value="ya">
		</span>
	</fieldset>
	<div id="showhidealergitable" style="display:none">
	<table id="listalergirawatjalan"></table>
	<fieldset id="fieldstindakanrawatjalanalergi">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearchalergi" style="width:255px;" />
		<input type="hidden" name="obat_tmpval" id="obat_tmpvalalergi" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptextalergi" />
			<input type="hidden" name="alergi_final" id="alergi_final" />
			<input type="button" value="Tambah" id="tambahobatalergiid" />
			<input type="button" value="Hapus" id="hapusobatalergiid" />
		</span>
	</fieldset>
	</div>
	<div class="subformtitle">Obat</div>
	<table id="listobatrawatjalan"></table>
	<fieldset id="fieldstindakanrawatjalan">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearch" style="width:255px;" />
		</span>
		<span>
		<label style="width:57px">Dosis</label>
			<input type="text" name="hargatindakan" id="dosisobatid" style="width:55px" />
		</span>
		<?=getComboSatuan('','satuan_obat','satuan_obat','','inline')?>
		<span>
		<label style="width:37px">Qty</label>
			<input type="text" name="kuantitastindakan" id="kuantitasobatid"  style="width:39px" />
			<input type="hidden" name="obat_tmpval" id="obat_tmpval" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptext" />
			<input type="hidden" name="obat_final" id="obat_final" />
			<input type="button" value="Tambah" id="tambahobatid" />
			<input type="button" value="Hapus" id="hapusobatid" />
		</span>		
	</fieldset>
	<br/>
	<?=getComboStatuskeluar('DILAYANI','status_keluar','statuskeluarid','required','')?>
	
	<fieldset>
		<span>
		<input type="button" name="batal" value="Batal" />
		&nbsp; - &nbsp;
		<input type="submit" name="bt1" value="Simpan"/>
		</span>
	</fieldset>	
</form>
</div >