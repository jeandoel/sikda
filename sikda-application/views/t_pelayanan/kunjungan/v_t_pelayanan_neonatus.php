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
.declabel{width:9px}
.declabel2{width:215px}
.declabel3{width:70px}
.decinput{width:99px}
</style>

<script>
$(document).ready(function(){
		$('#form1transaksi_pemeriksaanneonatus_add').ajaxForm({
			beforeSend: function() {
			achtungShowLoader();
		},
		uploadProgress: function(event, position, total, percentComplete) {
		},
		complete: function(xhr) {			
			if(xhr.responseText!=='OK'){
				$.achtung({message: xhr.responseText, timeout:5});
			}else{
				$.achtung({message: 'Proses Berhasil', timeout:5});
				$("#t203","#tabs").empty();
				$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
			}
			achtungHideLoader();
		}
		});	
		
		
		jQuery("#listprodukanak").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 735,
			height: 'auto',
			colNames:['Kode Produk','Tindakan Bayi/Anak','Harga','Jumlah', 'Keterangan'],
			colModel :[ 
			{name:'kdprodukanak',index:'kdprodukanak', width:55,align:'center',hidden:true}, 
			{name:'produkanak',index:'produkanak', width:801},
			{name:'harga',index:'harga', width:200},
			{name:'jumlahtindakananak',index:'jumlahtindakananak', width:200},
			{name:'keterangantindakananak',index:'keterangantindakananak', width:300}
			],
			rowNum:35,
			viewrecords: true
		}); 
		
		$("#carabayaradd").chained("#jenispasienadd");
		
		jQuery("#listprodukibu").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 735,
			height: 'auto',
			colNames:['Kode Produk','Tindakan Ibu','Harga','Jumlah'],
			colModel :[ 
			{name:'kdprodukibu',index:'kdprodukibu', width:55,align:'center',hidden:true}, 
			{name:'produkibu',index:'produkibu', width:801},
			{name:'hargai',index:'hargai', width:200},
			{name:'jumlahtindakanibu',index:'jumlahtindakanibu', width:200},
			],
			rowNum:35,
			viewrecords: true
		}); 
		
		jQuery("#listalergineonatus").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 1049,
			height: 'auto',
			colNames:['Kode Obat','Obat'],
			colModel :[ 
			{name:'kd_obatalergineonatus',index:'kd_obatalergineonatus', width:35,align:'center'}, 
			{name:'obatalergineonatus',index:'obatalergineonatus', width:300}
			],
			rowNum:35,
			viewrecords: true
		}); 
		
		jQuery("#listobatneonatus").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 1049,
			height: 'auto',
			colNames:['Kode Obat','Obat', 'Dosis','Satuan','Harga','Jumlah'],
			colModel :[ 
			{name:'kd_obatneonatus',index:'kd_obatneonatus', width:55,align:'center'}, 
			{name:'obatneonatus',index:'obatneonatus', width:300}, 
			{name:'dosis',index:'dosis', width:81}, 
			{name:'satuanobatneonatus',index:'satuanobatneonatus', width:81}, 
			{name:'hargaobatneonatus',index:'hargaobatneonatus', width:81}, 
			{name:'jumlahobatneonatus',index:'jumlahobatneonatus', width:51,align:'center'}
			],
			rowNum:35,
			viewrecords: true
		});	
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			var produkibuid = 0;
		$('#tambahprodukibuid').click(function(){
			if($('#produkibusearch_tmpval').val()){
				if($('#kuantitastindakanidibu').val()==''){
					alert("Silahkan Lengkapi Kolom 'Qty'");
					$('#kuantitastindakanidibu').focus();return false;
				}
			var myfirstrow = {kdprodukibu:$('#produkibusearch_tmpval').val(), produkibu:$('#produkibusearch_tmptext').val(), hargai:$('#hargatindakanidibu').val(), jumlahtindakanibu:$('#kuantitastindakanidibu').val()};
				jQuery("#listprodukibu").addRowData(produkibuid+1, myfirstrow);
				$('#produkibusearch').val('');
				$('#produkibusearch_tmptext').val('');
				$('#produkibusearch_tmpval').val('');
				$('#hargatindakanidibu').val('');
				$('#kuantitastindakanidibu').val('');
				if(confirm('Tambah Tindakan Lain?')){
					$('#produkibusearch').focus();					
				}else{
					$('#keluhanibu').focus();
				}
			}else{
				alert('Silahkan Pilih Tindakan.');
			}
		})
				
		
		var produkanakid = 0;
		$('#tambahprodukanakid').click(function(){
			if($('#produkanaksearch_tmpval').val()){
				if($('#kuantitastindakanidanak').val()==''){
					alert("Silahkan Lengkapi Kolom 'Qty'");
					$('#kuantitastindakanidanak').focus();return false;
				}
				var myfirstrow = {kdprodukanak:$('#produkanaksearch_tmpval').val(), produkanak:$('#produkanaksearch_tmptext').val(), harga:$('#hargatindakanidanak').val(), jumlahtindakananak:$('#kuantitastindakanidanak').val(), keterangantindakananak:$('#keterangantindakanidneo').val()};
				jQuery("#listprodukanak").addRowData(produkanakid+1, myfirstrow);
				$('#produkanaksearch').val('');
				$('#produkanaksearch_tmptext').val('');
				$('#produkanaksearch_tmpval').val('');
				$('#keterangantindakanidneo').val('');
				$('#hargatindakanidanak').val('');
				$('#kuantitastindakanidanak').val('');
				if(confirm('Tambah Tindakan Lain?')){
					$('#produkanaksearch').focus();					
				}
				else{
					$('#produkibusearch').focus();
				}
			}else{
				alert('Silahkan Pilih Tindakan.');
			}
		})
		
		$('#alergiobatselectidneonatus').change(function(){
			var c = this.checked ?'checked':'unchecked';
			if(c=='checked'){
				$('#showhidealergitableneonatus').show();
				$('#obatsearchalergineonatus').focus();
			}else{
				$('#showhidealergitableneonatus').hide();
				jQuery("#listalergineonatus").clearGridData();
			}
		});
		
		var obatidneonatus = 0;
		$('#tambahobatidneonatus').click(function(){
			if($('#obatneonatus_tmpval').val()){
				if($('#kuantitasobatidneonatus').val()==''){
					alert("Silahkan Lengkapi Kolom 'Qty'");
					$('#kuantitasobatidneonatus').focus();return false;
				}
				var myfirstrow = {kd_obatneonatus:$('#obatneonatus_tmpval').val(), obatneonatus:$('#obatneonatus_tmptext').val(), dosis:$('#dosisobatidneonatus').val(), satuanobatneonatus:$('#satuanobatidneonatus').val(), hargaobatneonatus:$('#hargaobatidneonatus').val(), jumlahobatneonatus:$('#kuantitasobatidneonatus').val()};
				jQuery("#listobatneonatus").addRowData(obatidneonatus+1, myfirstrow);
				$('#obatsearchneonatus').val('');
				$('#dosisobatidneonatus').val('');
				$('#kuantitasobatidneonatus').val('');
				$('#satuan_obatidneonatus').val('');
				$('#hargaobatidneonatus').val('');
				$('#obatneonatus_tmptext').val('');
				$('#obatneonatus_tmpval').val('');
				if(confirm('Tambah Obat Lain?')){
					$('#obatsearchneonatus').focus();					
				}else{
					$('#Simpanan').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})
				
		var obatalergiidneonatus = 0;
		$('#tambahobatalergiidneonatus').click(function(){
			if($('#obatneonatus_tmpvalalergi').val()){
				var myfirstrow = {kd_obatalergineonatus:$('#obatneonatus_tmpvalalergi').val(), obatalergineonatus:$('#obatneonatus_tmptextalergi').val()};
				jQuery("#listalergineonatus").addRowData(obatalergiidneonatus+1, myfirstrow);
				$('#obatsearchalergineonatus').val('');
				$('#obatneonatus_tmptextalergi').val('');
				$('#obatneonatus_tmpvalalergi').val('');
				if(confirm('Tambah Data Alergi Obat Lain?')){
					$('#obatsearchalergineonatus').focus();					
				}else{
					$('#obatsearchneonatus').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})		
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$('#hapusprodukibuid').click(function(){
			jQuery("#listprodukibu").clearGridData();
		})
		
		$('#hapusprodukanakid').click(function(){
			jQuery("#listprodukanak").clearGridData();
		})
		
		$('#hapusobatidneonatus').click(function(){
			jQuery("#listobatneonatus").clearGridData();
		})
		
		$('#hapusobatalergiidneonatus').click(function(){
		jQuery("#listalergineonatus").clearGridData();
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
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$("#form1transaksi_pemeriksaanneonatus_add").validate({focusInvalid:true});

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


			$('#form1transaksi_pemeriksaanneonatus_add :submit').click(function(e) {
			e.preventDefault();
			if($("#form1transaksi_pemeriksaanneonatus_add").valid()) {
				if(kumpularray())$('#form1transaksi_pemeriksaanneonatus_add').submit();
			}
			return false;
		});

		var searchdataproduk = <?=$dataproduktindakan?>;
		$( "#produkanaksearch" ).catcomplete({
			delay: 0,
			source: searchdataproduk,
			select: function( event, ui ) {
				var lb = ui.item.label.split("=>");
				var lb1 = lb[1].split(':');
				$('#hargatindakanidanak').val(lb1[1]);
				$('#produkanaksearch_tmpval').val(ui.item.id);
				$('#produkanaksearch_tmptext').val(lb[0]);
				$('#keterangantindakanidneo').focus();
			}
		});
		
		var searchdataprodukibu = <?=$dataproduktindakan?>;
		$( "#produkibusearch" ).catcomplete({
			delay: 0,
			source: searchdataprodukibu,
			select: function( event, ui ) {
				var lb = ui.item.label.split("=>");
				var lb1 = lb[1].split(':');
				$('#hargatindakanidibu').val(lb1[1]);
				$('#produkibusearch_tmpval').val(ui.item.id);
				$('#produkibusearch_tmptext').val(lb[0]);
				$('#kuantitastindakanidibu').focus();
			}
		});		
		
		$( "#obatsearchneonatus" ).catcomplete({
			source: "t_pemeriksaan_neonatus/obatsource",
			minLength: 1,
			select: function( event, ui ) {
				var lb = ui.item.label.split("=>");
				var lb1 = lb[1].split(':');	
				if(parseInt(lb1[1])<1){alert('Maaf Stok Obat Kosong, Silahkan Pilih Obat Lain');$( "#obatsearchneonatus" ).val('');$( "#obatneonatus_tmptextnostock" ).val('no');return false;}
				var lb2 = lb[2].split(':');
				$('#hargaobatidneonatus').val(lb2[1]);
				$('#obatneonatus_tmpval').val(ui.item.id);
				$('#obatneonatus_tmptext').val(lb[0]);
			}
		});

		$( "#obatsearchalergineonatus" ).catcomplete({
			source: "t_pemeriksaan_neonatus/obatsource_alergi",
			minLength: 1,
			select: function( event, ui ) {
				$('#obatneonatus_tmpvalalergi').val(ui.item.id);
				$('#obatneonatus_tmptextalergi').val(ui.item.label);
			}
		});
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
   var n = $(":text,:radio,:checkbox,select,textarea").length;
   if (e.which == 13) 
   {
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		if(nextIndex < n && $(this).valid()){
			if($(this).attr('id')=='keterangantindakanidneo'){
				if($('#produkanaksearch_tmpval').val()){
					$('#tambahprodukanakid').focus();return false;
				}else{
					$('#produkibusearch').focus();
				}				
			}
			if($(this).attr('id')=='kuantitastindakanidibu'){				
				if($('#produkibusearch_tmpval').val()){
					$('#tambahprodukibuid').focus();return false;
				}else{
					$('#keluhanibu').focus();
				}
			}
			if($(this).attr('id')=='kuantitasobatidneonatus'){				
				if($('#obatneonatus_tmpval').val()){
					$('#tambahobatidneonatus').focus();return false;
				}else{
					$('#Simpanan').focus();
				}
			}
			if($(this).attr('id')=='alergiobatselectidneonatus'){
				$( "#obatsearchneonatus" ).focus();
				$('#alergiobatselectidneonatus').css('outline-color', 'white');
			}
			if($(this).attr('id')=='obatsearchneonatus'){
				if($('#obatneonatus_tmptextnostock').val()=='no'){$( "#obatneonatus_tmptextnostock" ).val('');$( "#obatsearchneonatus" ).focus();return false;}
			}
			if($(this).attr('id')=='obatsearchalergineonatus'){				
				if($('#obatneonatus_tmpvalalergi').val()){
					$('#tambahobatalergiidneonatus').focus();return false;
				}else{
					$('#obatsearchneonatus').focus();
				}
			}
			
			$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
		}else{			
			if($("#form1transaksi_pemeriksaanneonatus_add").valid()) {
				if(kumpularray())$('#form1transaksi_pemeriksaanneonatus_add').submit();
			}
			return false;
		}
   }
   });
		
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
		if($('#listprodukibu').getGridParam("records")>0){
			var rows= jQuery("#listprodukibu").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#produkibu_final").val(JSON.stringify(paras));
		}
		
		
		if($('#listprodukanak').getGridParam("records")>0){
			var rows= jQuery("#listprodukanak").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#produkanak_final").val(JSON.stringify(paras));
		}
		
		if($('#listobatneonatus').getGridParam("records")>0){
			var rows= jQuery("#listobatneonatus").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#obatneonatus_final").val(JSON.stringify(paras));
		}
		
		if($('#listalergineonatus').getGridParam("records")>0){
			var rows= jQuery("#listalergineonatus").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#alergineonatus_final").val(JSON.stringify(paras));
		}
		
	return true;
				
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$("#form1transaksi_pemeriksaanneonatus_add").validate({
		rules: {
			tanggal_lahir: {
				date:true,
				required: true
			},
			tanggal_daftar: {
				date:true,
				required: true
			},
			tglkunjungan: {
				date:true,
				required: true
			}
		},
		messages: {
			tanggal_lahir: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			},tanggal_daftar: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			},tglkunjungan: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			}
		}
	});
	$("#tglkunjungan").mask("99/99/9999");
		
		
	$('#pemeriksaan_neonatus_id_hidden').click(function(){
		var kd_pasien = $('#get_kd_pasien_neo').val();
			$("#dialogcari_pemeriksaan_neonatus_id").dialog({
				autoOpen: false,
				modal:true,
				width: 1030,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_pemeriksaan_neonatus_id').load('t_pemeriksaan_neonatus/pemeriksaanneonatuspopup?id_caller=form1transaksi_pemeriksaanneonatus_add',
				{'kd_pasien':kd_pasien}, function() {
				$("#dialogcari_pemeriksaan_neonatus_id").dialog("open");
			});
		});	
		
		

</script>
<script>
	$("input[name = 'batal']").click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div id="dialogcari_pemeriksaan_neonatus_id" title="Riwayat Kunjungan"></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1transaksi_pemeriksaanneonatus_add" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_pemeriksaan_neonatus/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Rekam Medis#</label>
		<input type="text" name="text" value="<?=$data->KD_PASIEN?>" disabled />
		<input type="hidden" name="kd_pasien_hidden" id="get_kd_pasien_neo" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="hidden" name="kd_kunjungan_hidden" id="textid" value="<?=$data->ID_KUNJUNGAN?>" />
		<input type="hidden" name="kd_unit_hidden" id="textid" value="<?=$data->KD_UNIT?>" />
		<input type="hidden" name="kd_urutmasuk_hidden" id="textid" value="<?=$data->URUT_MASUK?>" />
		<input type="hidden" name="kia_anak" id="textid" value="<?php echo $mykd2?>" />
		</span>
		<span>
		<label>NIK</label>
		<input type="text" name="text" value="<?=$data->NIK?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="nama_lengkap" value="<?=$data->NAMA_PASIEN?>" disabled />
		</span>
		<span>
		<label>Golongan Darah</label>
		<input type="text" name="text" value="<?=$data->KD_GOL_DARAH?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Pasien</label>
		<input type="text" name="jenis_pasien" value="<?=$data->CUSTOMER?>" disabled />
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
		<?=getComboJenispasien($data->KD_CUSTOMER,'jenis_pasien','jenis_pasient_pelayananaddrj','required','inline')?>
		<?=getComboCarabayar($data->CARA_BAYAR,'cara_bayar','carabayart_pelayananaddrj','required','inline')?>		
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Daftar* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_daftar" id="tglmaster" value="<?=$data->TGL_MASUK?>" required  />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle">Data Anak Saat Lahir</div>
	<fieldset>
		<span>
		<label>Anak ke*</label>
		<input type="text" name="anak_ke" id="anak_ket_registrasi_bayi_add"  value="<?=isset($dataanak->ANAK_KE)?$dataanak->ANAK_KE:''?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Berat Lahir (gram)</label>
		<input type="text" name="berat_lahir" id="berat_lahirt_registrasi_bayi_add"  value="<?=isset($dataanak->BERAT_LAHIR)?$dataanak->BERAT_LAHIR:''?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Panjang Badan Lahir (cm)</label>
		<input type="text" name="panjang_badan" id="panjang_badant_registrasi_bayi_add"  value="<?=isset($dataanak->PANJANG_BADAN)?$dataanak->PANJANG_BADAN:''?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Lingkar Kepala Lahir (cm)</label>
		<input type="text" name="lingkar_kepala" id="lingkar_kepalat_registrasi_bayi_add"  value="<?=isset($dataanak->LINGKAR_KEPALA)?$dataanak->LINGKAR_KEPALA:''?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Kunjungan</label>
		<input type="text" name="tglkunjungan" id="tglkunjungan" class="mydate" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>
	<div class="subformtitle">Pemeriksaan Neonatus</div>
	<fieldset>
		<span>
			<label>Kunjungan ke</label>
			<select name="kunjunganke" id="kunjunganke">
				<option value="KN1">KN1</option>
				<option value="KN2">KN2</option>
				<option value="KN3">KN3</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Berat Badan (kg)</label>
		<input type="text" name="beratbadan" id="beratbadan" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Panjang Badan (cm)</label>
		<input type="text" name="panjangbadan" id="panjangbadan" value="" required />
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
		<label class="declabel3">Jenis Kasus</label>
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
	<table id="listprodukanak"></table>
	<fieldset id="produkanak">
		<span>
		<label class="declabel2">Memeriksa Bayi/Anak</label>
		<input type="text" name="text" value="" id="produkanaksearch" style="width:195px;"/>
		<input type="hidden" name="produkanaksearch_tmpval" id="produkanaksearch_tmpval" />
		<input type="hidden" name="produkanaksearch_tmptext" id="produkanaksearch_tmptext" />
		</span>
		<span>
		<label class="declabel3">Harga</label>
		<input type="text" name="hargatindakanidanak" id="hargatindakanidanak" style="width:101px" />
		</span>	
		<span>
		<label style="width:37px">Qty</label>
		<input type="text" name="kuantitastindakanidanak" id="kuantitastindakanidanak"  style="width:39px" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
			<label class="declabel2">Keterangan Tindakan</label>
			<input type="text" name="keterangantindakananak" id="keterangantindakanidneo" style="width:195px" />
		</span>
		<br/>
		<span>
			<input type="button" value="Tambah" id="tambahprodukanakid" />
			<input type="button" value="Hapus" id="hapusprodukanakid" />	
			<input type="hidden" id="produkanak_final" name="produkanak_final" />
		</span>
	</fieldset>
	<br/>
	<table id="listprodukibu"></table>
	<fieldset id="produkibu">
		<span>
		<label class="declabel2">Tindakan Ibu</label>
		<input type="text1" name="text1" value="" id="produkibusearch" style="width:195px;" />		
		<input type="hidden" name="produkibusearch_tmpval" id="produkibusearch_tmpval" />
		<input type="hidden" name="produkibusearch_tmptext" id="produkibusearch_tmptext" />
		</span>
		<span>
		<label class="declabel3">Harga</label>
		<input type="text" name="hargatindakanidibu" id="hargatindakanidibu" style="width:101px" />
		</span>	
		<span>
		<label style="width:37px">Qty</label>
		<input type="text" name="kuantitastindakanidibu" id="kuantitastindakanidibu"  style="width:39px" />
		</span>
		<br/>
		<span>
		<input type="button" value="Tambah" id="tambahprodukibuid" />
		<input type="button" id="hapusprodukibuid" value="Hapus" />
		<input type="hidden" id="produkibu_final" name="produkibu_final" />
		</span>
	</fieldset>		
	<fieldset>
		<span>
		<label>Keluhan Ibu</label>
		<textarea name="keluhan" id="keluhanibu" rows="2" cols="27"> </textarea> 
		</span>
	</fieldset>
	<fieldset>
		<?=getComboDokterPemeriksa('','nama_pemeriksa','pemeriksa','required','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboDokterPetugas('','nama_petugas','petugas','required','inline')?>
	</fieldset>
	<br/>
	<div class="subformtitle">Pemberian Obat/Vitamin</div>
	<div class="subformtitle">Alergi Obat</div>
	<fieldset>
		<span>
			<label class="declabel2">Alergi Obat?</label>
			<input type="checkbox" name="alergiobat" id="alergiobatselectidneonatus" value="ya">
		</span>
	</fieldset>
	<div id="showhidealergitableneonatus" style="display:none">
	<table id="listalergineonatus"></table>
	<fieldset id="fieldstindakanneonatusalergi">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearchalergineonatus" style="width:255px;" />
		<input type="hidden" name="obatneonatus_tmpval" id="obatneonatus_tmpvalalergi" />
			<input type="hidden" name="obatneonatus_tmptext" id="obatneonatus_tmptextalergi" />
			<input type="hidden" name="alergineonatus_final" id="alergineonatus_final" />
			<input type="button" value="Tambah" id="tambahobatalergiidneonatus" />
			<input type="button" value="Hapus" id="hapusobatalergiidneonatus" />
		</span>
	</fieldset>
	</div>
	<div class="subformtitle">Obat</div>
	<table id="listobatneonatus"></table>
	<fieldset id="fieldstindakanneonatus">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearchneonatus" style="width:255px;" />
		</span>
		<span>
		<label style="width:70px">Aturan Pakai</label>
			<input type="text" name="dosisobatidneonatus" id="dosisobatidneonatus" style="width:55px" />
		</span>
		<?=getComboSatuan('','satuanobatneonatus','satuanobatidneonatus','','inline')?>
		<span>
		<label style="width:37px">Qty</label>
			<input type="text" name="kuantitastindakanneonatus" id="kuantitasobatidneonatus"  style="width:39px" />
			<input type="hidden" name="obatneonatus_tmpval" id="obatneonatus_tmpval" />
			<input type="hidden" name="obatneonatus_tmptext" id="obatneonatus_tmptext" />
			<input type="hidden" name="hargaobatidneonatus" id="hargaobatidneonatus" />
			<input type="hidden" name="obatneonatus_tmptextnostock" id="obatneonatus_tmptextnostock" />
			<input type="hidden" name="obatneonatus_final" id="obatneonatus_final" />
			<input type="hidden" name="diagnosa_final" id="diagnosa_final" />
			<input type="button" value="Tambah" id="tambahobatidneonatus" />
			<input type="button" value="Hapus" id="hapusobatidneonatus" />
		</span>		
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" id="Simpanan" name="bt1" value="Simpan"/>
		</span>
		<span>
	<input type="button" name="batal" value="Batal"  />
	&nbsp; - &nbsp; 
	<input type="button" name="popup" id="pemeriksaan_neonatus_id_hidden" value="Riwayat Kunjungan"  />
	</span>
	</fieldset>	
</form>