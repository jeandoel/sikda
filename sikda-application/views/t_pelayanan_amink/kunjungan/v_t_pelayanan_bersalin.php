<script>
$(document).ready(function(){
		$('#form1masterkesehatanibubersalindanbayiadd').ajaxForm({
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
		
		//nampilin grid//
		jQuery("#listkeadaanbayi").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 580,
		height: 'auto',
		colNames:['Kode Keadaan Bayi Saat Lahir','Keadaan Bayi Saat Lahir'],
		colModel :[ 
		{name:'kd_keadaan_bayi_lahir',index:'kd_keadaan_bayi_lahir', width:55,align:'center',hidden:true},
		{name:'keadaan_bayi_lahir',index:'keadaan_bayi_lahir', width:801}, 
		],
		rowNum:35,
		viewrecords: true
	}); 
		
	jQuery("#listasuhanbayi").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 580,
		height: 'auto',
		colNames:['Kode Asuhan Bayi Baru Lahir','Asuhan Bayi Baru Lahir'],
		colModel :[ 
		{name:'kd_asuhan_bayi_lahir',index:'kd_asuhan_bayi_lahir', width:55,align:'center',hidden:true},
		{name:'asuhan_bayi_lahir',index:'asuhan_bayi_lahir', width:801}, 
		],
		rowNum:35,
			viewrecords: true
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
				if($('#keadaanbayisearch_tmpval').val()){
					$('#tambahkeadaanbayiid').focus();return false;
				}
			}
			if($(this).attr('id')){
				if($('#asuhanbayisearch_tmpval').val()){
					$('#tambahasuhanbayiid').focus();return false;
				}	
			}
			
			$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
		}else{			
			if($("#form1masterkesehatanibubersalindanbayiadd").valid()) {
				if(kumpularray())$('#form1masterkesehatanibubersalindanbayiadd').submit();
			}
			return false;
		}
   }
});
///////////////////////////////////////////////////////////////////////////////////////////////////
function formatterPelayanan(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue=='SUDAH'){
			content += '-';
		}else{
			content  += '<a rel="'+cellvalue+'" class="lab-blue">Pelayanan</a>';
		}
		return content;
	}
	
	
	var keadaanbayiid = 0;
		$('#tambahkeadaanbayiid').click(function(){
			if($('#keadaanbayisearch_tmpval').val()){
				var myfirstrow = {kd_keadaan_bayi_lahir:$('#keadaanbayisearch_tmpval').val(),keadaan_bayi_lahir:$('#keadaanbayisearch_tmptext').val()};
				jQuery("#listkeadaanbayi").addRowData(keadaanbayiid+1, myfirstrow);
				$('#keadaanbayisearch').val('');
				$('#keadaanbayisearch_tmpval').val('');
				$('#keadaanbayisearch_tmptext').val('');
				if(confirm('Tambah Data Keadaan Bayi?')){
					$('#keadaanbayisearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Keadaan Bayi.');
			}
		})	
		
	var asuhanbayiid = 0;
		$('#tambahasuhanbayiid').click(function(){
			if($('#asuhanbayisearch_tmpval').val()){
				var myfirstrow = {kd_asuhan_bayi_lahir:$('#asuhanbayisearch_tmpval').val(),asuhan_bayi_lahir:$('#asuhanbayisearch_tmptext').val()};
				jQuery("#listasuhanbayi").addRowData(asuhanbayiid+1, myfirstrow);
				$('#asuhanbayisearch').val('');
				$('#asuhanbayisearch_tmpval').val('');
				$('#asuhanbayisearch_tmptext').val('');
				if(confirm('Tambah Data Asuhan Bayi?')){
					$('#asuhanbayisearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Asuhan Bayi.');
			}
		})	
		
	$('#hapuskeadaanbayiid').click(function(){
			jQuery("#listkeadaanbayi").clearGridData();
		})
		
	$('#hapusasuhanbayiid').click(function(){
			jQuery("#listasuhanbayi").clearGridData();
		})


$("#form1masterkesehatanibubersalindanbayiadd").validate({focusInvalid:true});

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

$('#form1masterkesehatanibubersalindanbayiadd :submit').click(function(e) {
	e.preventDefault();
	if($("#form1masterkesehatanibubersalindanbayiadd").valid()) {
		if(kumpularray())$('#form1masterkesehatanibubersalindanbayiadd').submit();
	}
	return false;
});

$( "#keadaanbayisearch" ).catcomplete({
		source: "t_kesehatan_ibu_dan_anak/keadaanbayisource",
		minLength: 1,
		select: function( event, ui ) {
			$('#keadaanbayisearch_tmpval').val(ui.item.id);
			$('#keadaanbayisearch_tmptext').val(ui.item.label);
		}
});

$( "#asuhanbayisearch" ).catcomplete({
		source: "t_kesehatan_ibu_dan_anak/asuhanbayisource",
		minLength: 1,
		select: function( event, ui ) {
			$('#asuhanbayisearch_tmpval').val(ui.item.id);
			$('#asuhanbayisearch_tmptext').val(ui.item.label);
		}
});
});

$('#tglmaster').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistkesehatanibudananak').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<script>
	function kumpularray(){
		if($('#listkeadaanbayi').getGridParam("records")>0){
			var rows= jQuery("#listkeadaanbayi").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#keadaanbayi_final").val(JSON.stringify(paras));
		}
		if($('#listasuhanbayi').getGridParam("records")>0){
			var rows= jQuery("#listasuhanbayi").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#asuhanbayi_final").val(JSON.stringify(paras));
		}

		return true;
				
	}
	
$('#pupupkunjungan_bersalin').focus(function(){
			$("#dialog_kunjungan_bersalin").dialog({
				autoOpen: false,
				modal:true,
				width: 1200,
				height: 600,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			
			$('#dialog_kunjungan_bersalin').load('t_kesehatan_ibu_dan_anak/riwayatkunjunganbersalinpopup?id_caller=form1masterkesehatanibubersalindanbayiadd', function() {
				$("#dialog_kunjungan_bersalin").dialog("open");
			});
		});	
		//// Radio Choosen ///
		$('#alergiobatselectid').change(function(){
			var c = this.checked ?'checked':'unchecked';
			if(c=='checked'){
				$('#showhidealergitable').show();
				$('#obatsearchalergi').focus();
			}else{
				$('#showhidealergitable').hide();
			}
		});
		/// Grid Alergi Obat ///
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
		/// Tambah Obat Alergi ///
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
		// Autocomplate List Alergi Obat //
		
		$( "#obatsearchalergi" ).catcomplete({
			source: "t_pemeriksaan_kesehatan_anak/obatsource",
			minLength: 1,
			select: function( event, ui ) {
				$('#obat_tmpvalalergi').val(ui.item.id);
				$('#obat_tmptextalergi').val(ui.item.label);
			}
		});
		// Hapus Alergi Obat //
		$('#hapusobatalergiid').click(function(){
		jQuery("#listalergirawatjalan").clearGridData();
		})
		
		////////// Grid List Obat ////////////
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
		// Autocomplate List Obat //
		$( "#obatsearch" ).catcomplete({
		source: "t_pemeriksaan_kesehatan_anak/obatsource",
		minLength: 1,
		select: function( event, ui ) {
		$('#obat_tmpval').val(ui.item.id);
		$('#obat_tmptext').val(ui.item.label);
	}
	});
	// Tambah Obat //
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
	// Hapus Obat //
	$('#hapusobatid').click(function(){
			jQuery("#listobatrawatjalan").clearGridData();
		})
		
		
</script>
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
<div class="mycontent">
<div id="dialog_kunjungan_bersalin" title="Riwayat Kunjungan Bersalin"></div>
<div class="formtitle">Kesehatan Ibu Bersalin dan Bayi</div>
<div class="backbutton"><span class="kembali" id="backlistkesehatanibudananak">kembali ke list</span></div>
</br>
<div class="subformtitle">Ibu Bersalin</div>
<span id='errormsg'></span>
<form name="frApps" id="form1masterkesehatanibubersalindanbayiadd" method="post" action="<?=site_url('t_kesehatan_ibu_dan_anak/addprocess')?>" enctype="multipart/form-data">
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
		<span>
		<label>Unit Pelayanan</label>
		<input type="text" name="text" value="<?=$data->UNIT?>" disabled />
		</span>	
		<span>
		<label>Tanggal Pelayanan*</label>
		<input type="text" name="tanggal_daftar" id="tanggal_daftart_pelayananaddrj" class="mydate" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Kunjungan</label>
		<input type="text" name="kode_kunjungan_bersalin" id="" value="Kunjungan <?=$data->KUNJUNGAN_KIA?>" disabled />
		</span>
		<span>
		<label>Unit Pelayanan</label>
		<input type="text" name="text" value="<?=$data->UNIT?>" disabled />
		</span>	
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Daftar* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_daftar" id="tglmaster" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jam Kelahiran</label>
		<input type="text" name="jam_kelahiran" id="" value="" required  />		
		</span>
		<?=getComboKetwaktu('','ket_waktu','ket_waktu','','inline')?>
	</fieldset>
	<fieldset>
		<span>
		<label>Umur Kehamilan(minggu)*</label>
		<input type="text" name="umur_kehamilan" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	<fieldset>
		<?=getComboDokter('','dokter','dokter','required','inline')?>		
	</fieldset>
	<fieldset>
		<?=getComboPetugas('','petugas','petugas','required','inline')?>		
	</fieldset>
	<fieldset>
		<?=getComboJenispersalinan('','jenis_persalinan','jenis_persalinan','required','inline')?>		
	</fieldset>
	<fieldset>
		<?=getComboJeniskelahiran('','jenis_kelahiran','jenis_kelahiran','required','inline')?>	
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Bayi</label>
		<input type="text" name="jumlah_bayi" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
		<fieldset>
		<?=getComboKesehatan('','keadaan_kesehatan','keadaan_kesehatan','required','inline')?>	
	</fieldset>
	
	<fieldset>
		<?=getComboStatushamil('','status_hamil','status_hamil','required','inline')?>	
	</fieldset>
	
<div class="subformtitle">Bayi saat Lahir</div>
        <fieldset>
		<span>
		<label>Anak Ke</label>
		<input type="text" name="anak_ke" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	 <fieldset>
		<span>
		<label>Berat Lahir (gram)</label>
		<input type="text" name="berat_lahir" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	  <fieldset>
		<span>
		<label>Panjang Badan(cm)</label>
		<input type="text" name="panjang_badan" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	   <fieldset>
		<span>
		<label>Lingkar Kepala(cm)</label>
		<input type="text" name="lingkar_kepala" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
        <fieldset>
		<span>
		<label>Jenis Kelamin</label>
		<input type="radio" name="jk" value="L">Laki - Laki
		<input type="radio" name="jk" value="P">Perempuan
		</span>
	</fieldset>
	<table id="listkeadaanbayi"></table>
	<fieldset id="fieldskeadaanbayi">
		<span>
		<label>Keadaan Bayi Saat Lahir</label>
		<input type="text" name="keadaan_bayi_lahir" value="" id="keadaanbayisearch"/>
		</span>
		<span>
		<input type="hidden" name="keadaanbayisearch_tmpval" id="keadaanbayisearch_tmpval" />
		<input type="hidden" name="keadaanbayisearch_tmptext" id="keadaanbayisearch_tmptext" />
		<input type="hidden" name="keadaanbayi_final" id="keadaanbayi_final" />
		<input type="button" value="Tambah" id="tambahkeadaanbayiid" />
		<input type="button" id="hapuskeadaanbayiid" value="Hapus" />
		</span>
	</fieldset>
	<br/>
	<table id="listasuhanbayi"></table>
	<fieldset id="fieldsasuhanbayi">
		<span>
		<label>Asuhan Bayi Baru Lahir</label>
		<input type="text" name="asuhan_bayi_lahir" value="" id="asuhanbayisearch"/>
		</span>	
		<span>
		<input type="hidden" name="asuhanbayisearch_tmpval" id="asuhanbayisearch_tmpval" />
		<input type="hidden" name="asuhanbayisearch_tmptext" id="asuhanbayisearch_tmptext" />
		<input type="hidden" name="asuhanbayi_final" id="asuhanbayi_final" />
		<input type="button" value="Tambah" id="tambahasuhanbayiid" />
		<input type="button" id="hapusasuhanbayiid" value="Hapus" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan Tambahan</label>
		<textarea name="ket_tambahan" rows="3" cols="45"></textarea>
		</span>	
	</fieldset>
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
		<input type="submit" name="bt1" value="Proses Data"/>
		<input type="button" name="tanggal" id="pupupkunjungan_bersalin" value="Riwayat Kunjungan"  />
		</span>
	</fieldset>	
</form>
</div >