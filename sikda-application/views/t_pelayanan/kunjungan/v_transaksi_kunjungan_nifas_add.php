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
	$('#kunjungannifasadd').ajaxForm({
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
	jQuery("#listtindakan").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 1049,
		height: 'auto',
		colNames:['Kode Tindakan','Tindakan', 'Harga','Jumlah','Keterangan'],
		colModel :[ 
		{name:'kd_tindakan',index:'kd_tindakan', width:55,align:'center',fixed:true}, 
		{name:'tindakannifas',index:'tindakannifas', width:300,fixed:true}, 
		{name:'harganifas',index:'harganifas', width:100,fixed:true}, 
		{name:'total',index:'total', width:100,align:'center',fixed:true},
		{name:'keterangannifas',index:'keterangannifas', width:200,fixed:true}
		],
		rowNum:35,
		viewrecords: true
	});
	
		jQuery("#listalergirawatjalan1").jqGrid({
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
	
	jQuery("#listobatrawatjalan1").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 1049,
		height: 'auto',
		colNames:['Kode Obat','Obat', 'Dosis','Satuan','Harga','Jumlah'],
		colModel :[ 
		{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
		{name:'obat',index:'obat', width:300}, 
		{name:'dosis',index:'dosis', width:81}, 
		{name:'satuan',index:'satuan', width:81},
		{name:'hargaobt',index:'hargaobt', width:81},
		{name:'jumlah',index:'jumlah', width:51,align:'center'}
		],
		rowNum:35,
		viewrecords: true
	});
	var tindakanid = 0;
	$('#tambahtindakanidnifas').click(function(){
		if($('#tindakansearch_tmpval').val()){
			if($('#kuantitastindakanidnifas').val()==''){
				alert("Silahkan Lengkapi Kolom 'Qty'");
				$('#kuantitastindakanidnifas').focus();return false;
			}
			var myfirstrow = {kd_tindakan:$('#tindakansearch_tmpval').val(), tindakannifas:$('#tindakansearch_tmptext').val(), harganifas:$('#hargatindakanidnifas').val(), total:$('#kuantitastindakanidnifas').val(), keterangannifas:$('#keterangantindakanidnifas').val()};
			jQuery("#listtindakan").addRowData(tindakanid+1, myfirstrow);
			$('#tindakansearch').val('');
			$('#keterangantindakanidnifas').val('');
			$('#hargatindakanidnifas').val('');
			$('#kuantitastindakanidnifas').val('');
			$('#tindakansearch_tmptext').val('');
			$('#tindakansearch_tmpval').val('');
			if(confirm('Tambah Data Diagnosa Lain?')){
				$('#tindakansearch').focus();					
			}else{
				$('#nasehat').focus();
			}
		}else{
			alert('Silahkan Pilih Tindakan.');
		}
	});		
	
	$('#alergiobatselectidnifas').change(function(){
		var c = this.checked ?'checked':'unchecked';
		if(c=='checked'){
			$('#showhidealergitable').show();
			$('#obatsearchalerginifas').focus();
		}else{
			$('#showhidealergitable').hide();
			jQuery("#listalergirawatjalan1").clearGridData();
		}
	});
	
	
	var obatid1 = 0;
	$('#tambahobatidnifas').click(function(){
		if($('#obat_tmpval').val()){
			if($('#kuantitasobatid').val()==''){
				alert("Silahkan Lengkapi Kolom 'Qty'");
				$('#kuantitasobatid').focus();return false;
			}
			var myfirstrow = {kd_obat:$('#obat_tmpval').val(), obat:$('#obat_tmptext').val(), dosis:$('#dosisobatid').val(), jumlah:$('#kuantitasobatid').val(), satuan:$('#satuan_obatid').val(), hargaobt:$('#hargaobattmpidnifas').val()};
			jQuery("#listobatrawatjalan1").addRowData(obatid1+1, myfirstrow);
			$('#obatsearchnifas').val('');
			$('#dosisobatid').val('');
			$('#satuan_obatid').val('');
			$('#kuantitasobatid').val('');
			$('#obat_tmptext').val('');
			$('#obat_tmpval').val('');
			$('#hargaobattmpidnifas').val('');
			if(confirm('Tambah Obat Lain?')){
				$('#obatsearchnifas').focus();					
			}else{
				$('#statuskeluarid').focus();
			}
		}else{
			alert('Silahkan Pilih Obat.');
		}
	})
			
	var obatalergiid1 = 0;
	$('#tambahobatalergiidnifas').click(function(){
		if($('#obat_tmpvalalergi').val()){
			var myfirstrow = {kd_obat:$('#obat_tmpvalalergi').val(), obat:$('#obat_tmptextalergi').val()};
			jQuery("#listalergirawatjalan1").addRowData(obatalergiid1+1, myfirstrow);
			$('#obatsearchalerginifas').val('');
			$('#obat_tmptextalergi').val('');
			$('#obat_tmpvalalergi').val('');
			if(confirm('Tambah Data Alergi Obat Lain?')){
				$('#obatsearchalerginifas').focus();					
			}else{
				$('#obatsearchnifas').focus();
			}
		}else{
			alert('Silahkan Pilih Obat.');
		}
	})	
				
	$('#hapustindakanidnifas').click(function(){
		jQuery("#listtindakan").clearGridData();
	})
	
	$('#hapusobatidnifas').click(function(){
		jQuery("#listobatrawatjalan1").clearGridData();
	})
	
	$('#hapusobatalergiidnifas').click(function(){
	jQuery("#listalergirawatjalan1").clearGridData();
	})
	
	jQuery("#listdiagnosarawatjalan").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 1049,
		height: 'auto',
		colNames:['Kode Penyakit','Penyakit', 'Jenis Kasus','Jenis Diagnosa'],
		colModel :[ 
		{name:'kd_penyakit',index:'kd_penyakit', width:55,align:'center'}, 
		{name:'penyakit',index:'penyakit', width:801}, 
		{name:'jenis_kasus',index:'jenis_kasus', width:81}, 
		{name:'jenis_diagnosa',index:'jenis_diagnosa', width:81}
		],
		rowNum:35,
		viewrecords: true
	}); 
	var diagnosatid = 0;
	$('#tambahdiagnosaid').click(function(){
		if($('#icdsearch_tmpval').val()){
			var myfirstrow = {kd_penyakit:$('#icdsearch_tmpval').val(), penyakit:$('#icdsearch_tmptext').val(), jenis_kasus:$('#selectjeniskasusid').val(), jenis_diagnosa:$('#selectjenisdiagnosaid').val()};
			jQuery("#listdiagnosarawatjalan").addRowData(diagnosatid+1, myfirstrow);
			$('#icdsearch').val('');
			$('#icdsearch_tmptext').val('');
			$('#icdsearch_tmpval').val('');
			if(confirm('Tambah Data Diagnosa Lain?')){
				$('#icdsearch').focus();					
			}else{
				$('#produktindakansearch').focus();
			}
		}else{
			alert('Silahkan Pilih Diagnosa.');
		}
	})
	$('#hapusdiagnosaid').click(function(){
		jQuery("#listdiagnosarawatjalan").clearGridData();
	});
	$( "#icdsearch" ).catcomplete({
		source: "t_pelayanan/icdsource",
		minLength: 2,
		select: function( event, ui ) {
		//log( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
			$('#icdsearch_tmpval').val(ui.item.id);
			$('#icdsearch_tmptext').val(ui.item.label);
			//$('#selectjeniskasusid').focus();
		}
	});
	
});
	
	$("#kunjungannifasadd").validate({focusInvalid:true});

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

	$('#kunjungannifasadd :submit').click(function(e) {
		e.preventDefault();
		if($("#kunjungannifasadd").valid()) {
			if(kumpularray())$('#kunjungannifasadd').submit();
		}
		return false;
	});

	$( "#obatsearchnifas" ).catcomplete({
		source: "t_pelayanan/obatsource",
		minLength: 1,
		select: function( event, ui ) {
			var lb = ui.item.label.split("=>");
			var lb1 = lb[1].split(':');
			if(parseInt(lb1[1])<1){alert('Maaf Stok Obat Kosong, Silahkan Pilih Obat Lain');$( "#obatsearchnifas" ).val('');$( "#obat_tmptextnostock" ).val('no');return false;}
			var lb2 = lb[2].split(':');
			$('#hargaobattmpidnifas').val(lb2[1]);
			$('#obat_tmpval').val(ui.item.id);
			$('#obat_tmptext').val(lb[0]);
			
			
		}
	});

	$( "#obatsearchalerginifas" ).catcomplete({
		source: "t_pelayanan/obatsource_alergi",
		minLength: 1,
		select: function( event, ui ) {
			$('#obat_tmpvalalergi').val(ui.item.id);
			$('#obat_tmptextalergi').val(ui.item.label);
		}
	});

	var searchdataproduk = <?=$dataproduktindakan?>;
	$( "#tindakansearch" ).catcomplete({
		delay: 0,
		source: searchdataproduk,
		select: function( event, ui ) {
			var lb = ui.item.label.split("=>");
			var lb1 = lb[1].split(':');
			$('#hargatindakanidnifas').val(lb1[1]);
			$('#tindakansearch_tmpval').val(ui.item.id);
			$('#tindakansearch_tmptext').val(lb[0]);
		}
	});
		
	$('#stat_hamil').on('change', function() {
			if($(this).val()=='akhir_nifas'){
				$('#kesimpulannifasplaceholder').empty();
				$('#kesimpulannifasplaceholder').load('t_kunjungan_nifas/kesimpulanakhirnifas?_=' + (new Date()).getTime());
			}else{
				$('#kesimpulannifasplaceholder').empty();
			}


	$("#kunjungannifasadd").validate({
			rules: {
					tanggal_daftart_pendaftaranadd: {
					date:true,
					required: true
				}
			},
			messages: {
					tanggal_daftart_pendaftaranadd: {
					date: "Silahkan Masukkan Tanggal Sesuai Format",
					required:"Silahkan Lengkapi Data"
				}
			}
		});

	});

	$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
	   var n = $(":text,:radio,:checkbox,select,textarea").length;
	   if (e.which == 13) 
	   {
			e.preventDefault();
			var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
			var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
			if(nextIndex < n && $(this).valid()){
				if($(this).attr('id')=='keterangantindakanidnifas'){
					if($('#tindakansearch_tmpval').val()){
						$('#tambahtindakanidnifas').focus();return false;
					}else{
						$('#alergiobatselectidnifas').focus();
						$('#alergiobatselectidnifas').css('outline-color', 'yellow');
						$('#alergiobatselectidnifas').css('outline-style', 'solid');
						$('#alergiobatselectidnifas').css('outline-width', 'thick');
					}				
				}
				if($(this).attr('id')=='kuantitasobatid'){				
					if($('#obat_tmpval').val()){
						$('#tambahobatidnifas').focus();return false;
					}else{
						$('#statuskeluarid').focus();
					}
				}
				if($(this).attr('id')=='obatsearchalerginifas'){				
					if($('#obat_tmpvalalergi').val()){
						$('#tambahobatalergiidnifas').focus();return false;
					}else{
						$('#obatsearchnifas').focus();
					}
				}
				
				if($(this).attr('id')=='obatsearchnifas'){
					if($('#obat_tmptextnostock').val()=='no'){$( "#obat_tmptextnostock" ).val('');$( "#obatsearchnifas" ).focus();return false;}
				}
				
				if($(this).attr('id')=='alergiobatselectidnifas'){
					$( "#obatsearchnifas" ).focus();
					$('#alergiobatselectidnifas').css('outline-color', 'white');
				}
				
				$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
			}else{			
				if($("#kunjungannifasadd").valid()) {
					//$(':text,:radio,:checkbox,select,textarea')[nextIndex-1].blur();
					if(kumpularray())$('#kunjungannifasadd').submit();
				}
				return false;
			}
	   }
	});

	$('#popupkunjungan_hidden').click(function(){
		var get_kd_pasien = $('#get_kd_pasien').val();
				$("#dialogtransaksi_cari_kunjungan_nifas").dialog({
					autoOpen: false,
					modal:true,
					width: 1000,
					height: 600,
					buttons : {
						"Cancel" : function() {
						  $(this).dialog("close");
						}
					}
				});
				
				$('#dialogtransaksi_cari_kunjungan_nifas').load('t_kunjungan_nifas/masterkunjungannifaspopup?id_caller=kunjungannifasadd',
					{'get_kd_pasien':get_kd_pasien}, function() {
					$("#dialogtransaksi_cari_kunjungan_nifas").dialog("open");
				});
			});
			
		 $("#tanggal_daftart_pendaftaranadd").mask("99/99/9999");

	$("#tanggal_daftart_pendaftaranadd").datepicker({dateFormat: "dd-mm-yy",changeYear: true});
	$("#carabayart_pendaftaranadd").chained("#jenis_pasient_pendaftaranadd");
</script>
<script>
	function kumpularray(){
		if($('#listdiagnosarawatjalan').getGridParam("records")>0){
			var rows= jQuery("#listdiagnosarawatjalan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#diagnosa_final").val(JSON.stringify(paras));
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
		
		if($('#listobatrawatjalan1').getGridParam("records")>0){
			var rows= jQuery("#listobatrawatjalan1").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#obat_final").val(JSON.stringify(paras));
		}
		
		if($('#listalergirawatjalan1').getGridParam("records")>0){
			var rows= jQuery("#listalergirawatjalan1").jqGrid('getRowData');
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
	$("input[name = 'batal']").click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
	$('#jenis_pasient_pendaftaranadd').focus();
</script>
<div id="dialogtransaksi_cari_kunjungan_nifas" title="Riwayat Kunjungan Nifas"></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="kunjungannifasadd" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_kunjungan_nifas/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Rekam Medis#</label>
		<input type="text" name="text" value="<?=$data->KD_PASIEN?>" disabled />
		<input type="hidden" name="kd_pasien_hidden" id="get_kd_pasien" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="hidden" name="kd_kunjungan_hidden" id="textid" value="<?=$data->ID_KUNJUNGAN?>" />
		<input type="hidden" name="kd_unit_hidden" id="textid" value="<?=$data->KD_UNIT?>" />
		<input type="hidden" name="kd_urutmasuk_hidden" id="textid" value="<?=$data->URUT_MASUK?>" />
		<input type="hidden" name="kia_ibu" id="textid" value="<?php echo $mykd?>" />
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
		<label>Tanggal Daftar</label>
		<input type="text" name="tanggal_daftart_pendaftaranadd" id="tanggal_daftart_pendaftaranadd" class="mydate" value="<?=$data->TGL_MASUK?>" disabled />
		</span>	
	</fieldset>
	<fieldset>		
		<?=getComboJenispasien($data->KD_CUSTOMER,'jenis_pasien','jenis_pasient_pendaftaranadd','required','inline')?>
		<?=getComboCarabayar($data->CARA_BAYAR,'cara_bayar','carabayart_pendaftaranadd','required','inline')?>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Pelayanan*</label>
		<input type="text" name="tanggal_daftar" id="tanggal_daftart_pelayananaddrj" class="mydate" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keluhan Sekarang*</label>
		<textarea name="keluhan" rows="3" cols="45" required></textarea>
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tekanan Darah (mmHG)*</label>
		<input type="text" name="tekanan_darah" id="tekanan_darah" value="" required  />		
		</span>		
	</fieldset>
	<fieldset>
		<span>
		<label>Nadi /menit*</label>
		<input type="text" name="nadi" id="nadi" value="" required  />		
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Nafas /menit</label>
		<input type="text" name="nafas" id="nafas" value="" required/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Suhu</label>
		<input type="text" name="suhu" id="suhu" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kontraksi Rahim</label>
		<input type="text" name="kontraksi" id="kontraksi" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Perdarahan</label>
		<input type="text" name="perdarahan" id="perdarahan" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Warna Lokhia</label>
		<input type="text" name="warna_lokhia" id="warna_lokhia" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Lokhia</label>
		<input type="text" name="jumlah_lokhia" id="jumlah_lokhia" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Bau Lokhia</label>
		<input type="text" name="bau_lokhia" id="bau_lokhia" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Buang Air Besar</label>
			<select name="bab">
				<option value="">---Silahkan Pilih---</option>
				<option value="negatif (-)">Negatif</option>
				<option value="positif (+)">Positif</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Buang Air kecil</label>
			<select name="bak">
				<option value="">---Silahkan Pilih---</option>
				<option value="negatif (-)">Negatif</option>
				<option value="positif (+)">Positif</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Produksi ASI</label>
		<input type="text" name="produksi_asi" id="produksi_asi" value="" required />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle">Diagnosa</div>
	<table id="listdiagnosarawatjalan"></table>
	<fieldset id="fieldsdiagnosarawatjalan">
		<span>
		<label class="declabel2">Cari Jenis Penyakit / ICD10</label>
		<input type="text" name="text" value="" id="icdsearch" style="width:255px;" />
		</span>
		<span>
		<label class="declabel">Jenis Kasus</label>
		<select class="decinput" name="selectjeniskasus" id="selectjeniskasusid">
			<option value="Baru">Kasus Baru</option>
			<option value="Lama">Kasus Lama</option>
		</select>
		</span>	
		<span>
		<label class="decinput">Jenis Diagnosa</label>
		<select class="decinput" name="selectjenisdiagnosa" id="selectjenisdiagnosaid">
			<option value="Primer">Primer</option>
			<option value="Sekunder">Sekunder</option>
			<option value="Komplikasi">Komplikasi</option>
		</select>
		<input type="hidden" name="icdsearch_tmpval" id="icdsearch_tmpval" />
		<input type="hidden" name="icdsearch_tmptext" id="icdsearch_tmptext" />
		<input type="button" value="Tambah" id="tambahdiagnosaid" />
		<input type="button" id="hapusdiagnosaid" value="Hapus" />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle">Tindakan</div>
	<table id="listtindakan"></table>
	<fieldset id="fieldstindakan">
		<span>
			<label class="declabel2">Cari Tindakan</label>
			<input type="text" name="tindakannifas" value="" id="tindakansearch" style="width:255px;" />
		</span>
		<span>
			<label class="declabel">Harga</label>
			<input type="text" name="hargatindakan" id="hargatindakanidnifas" style="width:101px" />
		</span>	
		<span>
			<label style="width:37px">Qty</label>
			<input type="text" name="kuantitastindakan" id="kuantitastindakanidnifas" style="width:39px" />
			<input type="hidden" name="tindakansearch_tmpval" id="tindakansearch_tmpval" />
			<input type="hidden" name="tindakansearch_tmptext" id="tindakansearch_tmptext" />		
		</span>
		<br/>
		<span>
			<label class="declabel2">Keterangan Tindakan</label>
			<input type="text" name="keterangantindakan" id="keterangantindakanidnifas" style="width:583px" />
			<input type="hidden" name="tindakan_final" id="tindakan_final" />
			<input type="button" value="Tambah" id="tambahtindakanidnifas" />
			<input type="button" value="Hapus" id="hapustindakanidnifas" />
		</span>
	</fieldset>
	<br/>
	<fieldset>
		<span>
		<label>Nasehat</label>
		<textarea name="nasehat" id="nasehat" rows="3" cols="45" required></textarea>
		</span>
	</fieldset>
	<fieldset>
	<?=getComboPemeriksa('','pemeriksa','pemeriksa','required','inline')?>
	<?=getComboDokterPetugas('','petugas','petugas','required','inline')?>
	</fieldset>
		<fieldset>
		<span>
		<label>Status Hamil</label>
			<select name="stat_hamil"  id="stat_hamil">
				<option value="">Pilih Status Hamil</option>
				<option value="masa_nifas">Masa Nifas</option>
				<option value="akhir_nifas">Akhir Nifas</option>				
			</select>
		</span>
	</fieldset>
	<div id="kesimpulannifasplaceholder"><!-- placeholder for loaded kesimpulan akhir nifas --></div>
	<br/>	
	<div class="subformtitle">Pemberian Obat/Vitamin</div>
	<br/>
	<div class="subformtitle">Alergi Obat</div>
	<fieldset>
		<span>
			<label class="declabel2">Alergi Obat?</label>
			<input type="checkbox" name="alergiobat" id="alergiobatselectidnifas" value="ya">
		</span>
	</fieldset>
	<div id="showhidealergitable" style="display:none">
	<table id="listalergirawatjalan1"></table>
	<fieldset id="fieldstindakanrawatjalanalergi">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearchalerginifas" style="width:255px;" />
		<input type="hidden" name="obat_tmpvalalergi" id="obat_tmpvalalergi" />
			<input type="hidden" name="obat_tmptextalergi" id="obat_tmptextalergi" />
			<input type="hidden" name="alergi_final" id="alergi_final" />
			<input type="button" value="Tambah" id="tambahobatalergiidnifas" />
			<input type="button" value="Hapus" id="hapusobatalergiidnifas" />
		</span>
	</fieldset>
	</div>
	<br/>
	<div class="subformtitle">Obat</div>
	<table id="listobatrawatjalan1"></table>
	<fieldset id="fieldstindakanrawatjalan">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearchnifas" style="width:255px;" />
		</span>
		<span>
		<label style="width:77px">Aturan Pakai</label>
			<input type="text" name="hargatindakan" id="dosisobatid" style="width:55px" />
		</span>
		<?=getComboSatuan('','satuan_obat','satuan_obatid','','inline')?>
		<span>
		<label style="width:37px">Qty</label>
			<input type="text" name="kuantitastindakan" id="kuantitasobatid"  style="width:39px" />
			<input type="hidden" name="obat_tmpval" id="obat_tmpval" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptext" />
			<input type="hidden" name="hargaobattmpidnifas" id="hargaobattmpidnifas" />
			<input type="hidden" name="obat_tmptextnostock" id="obat_tmptextnostock" />
			<input type="button" value="Tambah" id="tambahobatidnifas" />
			<input type="button" value="Hapus" id="hapusobatidnifas" />
			
			<input type="hidden" name="diagnosa_final" id="diagnosa_final" />
			<input type="hidden" name="obat_final" id="obat_final" />
			
		</span>		
	</fieldset>
	<br/>
	<?=getComboStatuskeluar('DILAYANI','status_keluar','statuskeluarid','required','')?>
	<br/>
	<br/>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Simpan"/>
		&nbsp; - &nbsp;
		<input type="button" name="batal" value="Batal"/>
		&nbsp; - &nbsp;
		<input type="button" name="tanggal" id="popupkunjungan_hidden" value="Riwayat Kunjungan"  />
		</span>
	</fieldset>	
	
</form>