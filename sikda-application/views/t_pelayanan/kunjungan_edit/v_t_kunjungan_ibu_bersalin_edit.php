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
		$('#form1t_pelayanan_bersalin_edit').ajaxForm({
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
					$.achtung({message: 'Proses Ubah Data Berhasil', timeout:5});
					$("#t203","#tabs").empty();
					$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		jQuery("#listdiagnosarawatjalan").jqGrid({ 
		url:'t_pelayanan/diagnosarawatjalan_xml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Penyakit', 'Penyakit', 'Jenis Kasus','Jenis Diagnosa'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel :[ 
			{name:'kd_penyakit',index:'kd_penyakit', width:55,align:'center'}, 
			{name:'penyakit',index:'penyakit', width:801}, 
			{name:'jenis_kasus',index:'jenis_kasus', width:81}, 
			{name:'jenis_diagnosa',index:'jenis_diagnosa', width:81}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_diagnosarawatjalan'),
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id1='<?=$data->KD_PELAYANAN?>';
				$('#listdiagnosarawatjalan').setGridParam({postData:{'myid1':id1}})
			}	
	}).navGrid('#pagert_diagnosarawatjalan',{search:false,edit:false,add:false,del:false});
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
	})
	
		jQuery("#listkeadaanbayi").jqGrid({
		url:'t_kesehatan_ibu_dan_anak/t_keadaanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode','Keadaan Bayi Saat Lahir'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows : true,	
		colModel :[ {name:'kd_keadaan_bayi_lahir',index:'kd_keadaan_bayi_lahir', width:55,hidden:true}, 
					{name:'keadaan_bayi_lahir',index:'keadaan_bayi_lahir', width:801} 
		],
			rowNum:35,
			pager: jQuery('#pagert_keadaanbayi'),
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id5='<?=$data->KD_KUNJUNGAN_BERSALIN?>';
				$('#listkeadaanbayi').setGridParam({postData:{'myid5':id5}})
			}			
		}).navGrid('#pagert_keadaanbayi',{search:false}); 
		
		jQuery("#listasuhanbayi").jqGrid({
		url:'t_kesehatan_ibu_dan_anak/t_asuhanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode','Asuhan Bayi Baru Lahir'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows : true,	
		colModel :[ 
		{name:'kd_asuhan_bayi_lahir',index:'kd_asuhan_bayi_lahir', width:55,hidden:true}, 
		{name:'asuhan_bayi_lahir',index:'asuhan_bayi_lahir', width:801}, 
		],
			rowNum:35,
			pager: jQuery('#pagert_asuhanbayi'),
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id6='<?=$data->KD_KUNJUNGAN_BERSALIN?>';
				$('#listasuhanbayi').setGridParam({postData:{'myid6':id6}})
			}			
		}).navGrid('#pagert_asuhanbayi',{search:false});
		//////////// Modul Tindakan dan Harga ////////////////////
		jQuery("#listtindakanrawatjalan").jqGrid({
			url:'t_kesehatan_ibu_dan_anak/t_tindakanxml', 
			emptyrecords: 'Nothing to display',
			datatype: "xml", 
			colNames:['Kode Tindakan','Tindakan', 'Harga','Jumlah','Keterangan'],
			rownumbers:true,
			width: 1049,
			height: 'auto',
			mtype: 'POST',
			altRows : true,
			colModel :[ 
			{name:'kd_tindakan',index:'kd_tindakan', width:55,align:'center'}, 
			{name:'tindakan',index:'tindakan', width:300}, 
			{name:'harga',index:'harga', width:81}, 
			{name:'jumlah',index:'jumlah', width:51,align:'center'},
			{name:'keterangan',index:'keterangan', width:400}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_tindakanrawatjalan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id2='<?=$data->KD_PELAYANAN?>';
				$('#listtindakanrawatjalan').setGridParam({postData:{'myid2':id2}})
			}		
		}).navGrid('#pagert_tindakanrawatjalan',{search:false});

		jQuery("#listalergirawatjalan").jqGrid({
			url:'t_kesehatan_ibu_dan_anak/t_alergixml', 
			emptyrecords: 'Nothing to display',
			datatype: "xml",
			colNames:['Kode Obat','Obat'],
			rownumbers:true,
			width: 1049,
			height: 'auto',
			mtype: 'POST',
			altRows : true,
			colModel :[ 
			{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
			{name:'obat',index:'obat', width:300}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_alergirawatjalan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id4='<?=$data->KD_PASIEN?>';
				$('#listalergirawatjalan').setGridParam({postData:{'myid4':id4}})
			}			
		}).navGrid('#pagert_alergirawatjalan',{search:false});
		
		jQuery("#listobatrawatjalan").jqGrid({
			url:'t_kesehatan_ibu_dan_anak/t_obatxml', 
			emptyrecords: 'Nothing to display',
			datatype: "xml",
			colNames:['Kode Obat','Obat', 'Dosis','Harga','Jumlah'],
			rownumbers:true,
			width: 1049,
			height: 'auto',
			mtype: 'POST',
			altRows : true,
			colModel :[ 
			{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
			{name:'obat',index:'obat', width:300}, 
			{name:'dosis',index:'dosis', width:81}, 
			{name:'harga',index:'harga', width:81},
			{name:'jumlah',index:'jumlah', width:51,align:'center'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_obatrawatjalan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id3='<?=$data->KD_PELAYANAN?>';
				$('#listobatrawatjalan').setGridParam({postData:{'myid3':id3}})
			}		
		}).navGrid('#pagert_obatrawatjalan',{search:false});
		
		
		var tindakanid = 0;
		$('#tambahtindakanid').click(function(){
			if($('#produktindakansearch_tmpval').val()){
				if($('#kuantitastindakanid').val()==''){
					alert("Silahkan Isi Kolom 'Qty'");
					$('#kuantitastindakanid').focus();return false;
				}
				var myfirstrow = {kd_tindakan:$('#produktindakansearch_tmpval').val(), tindakan:$('#produktindakansearch_tmptext').val(), harga:$('#hargatindakanid').val(), jumlah:$('#kuantitastindakanid').val(), keterangan:$('#keterangantindakanid').val()};
				jQuery("#listtindakanrawatjalan").addRowData(tindakanid+1, myfirstrow);
				$('#produktindakansearch').val('');
				$('#keterangantindakanid').val('');
				$('#hargatindakanid').val('');
				$('#kuantitastindakanid').val('');
				$('#produktindakansearch_tmptext').val('');
				$('#produktindakansearch_tmpval').val('');
				if(confirm('Tambah Data Diagnosa Lain?')){
					$('#produktindakansearch').focus();					
				}else{
					$('#alergiobatselectid').focus();
					$('#alergiobatselectid').css('outline-color', 'yellow');
					$('#alergiobatselectid').css('outline-style', 'solid');
					$('#alergiobatselectid').css('outline-width', 'thick');
				}
			}else{
				alert('Silahkan Pilih Tindakan.');
			}
		});
		
		
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
				}else{
					$('#asuhanbayisearch').focus();
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
				}else{
					$('#ket_tambahan').focus();
				}
			}else{
				alert('Silahkan Pilih Asuhan Bayi.');
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
		
		
		var obatid = 0;
		$('#tambahobatid').click(function(){
			if($('#obat_tmpval').val()){
				if($('#kuantitasobatid').val()==''){
					alert("Silahkan Isi Kolom 'Qty'");
					$('#kuantitasobatid').focus();return false;
				}
				var myfirstrow = {kd_obat:$('#obat_tmpval').val(), obat:$('#obat_tmptext').val(), dosis:$('#dosisobatid').val(), jumlah:$('#kuantitasobatid').val(), satuan:$('#satuanobatid').val(), harga:$('#hargaobattmpid').val()};
				jQuery("#listobatrawatjalan").addRowData(obatid+1, myfirstrow);
				$('#obatsearch').val('');
				$('#dosisobatid').val('');
				$('#kuantitasobatid').val('');
				$('#satuan_obatid').val('');
				$('#kuantitasobatid').val('');
				$('#obat_tmptext').val('');
				$('#obat_tmpval').val('');
				$('#hargaobattmpid').val('');
				if(confirm('Tambah Obat Lain?')){
					$('#obatsearch').focus();					
				}else{
					$('#nama_pemeriksa').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})
		
		$('#hapustindakanid').click(function(){
			jQuery("#listtindakanrawatjalan").clearGridData();
		})
		
		$('#hapuskeadaanbayiid').click(function(){
			jQuery("#listkeadaanbayi").clearGridData();
		})
		
	$('#hapusasuhanbayiid').click(function(){
			jQuery("#listasuhanbayi").clearGridData();
		})
		
		$('#hapusobatid').click(function(){
			jQuery("#listobatrawatjalan").clearGridData();
		})
		
		$('#hapusobatalergiid').click(function(){
		jQuery("#listalergirawatjalan").clearGridData();
		})

});

$("#form1t_pelayanan_bersalin_edit").validate({focusInvalid:true});

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
		
		$('#form1t_pelayanan_bersalin_edit :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_pelayanan_bersalin_edit").valid()) {
		if(kumpularray())$('#form1t_pelayanan_bersalin_edit').submit();
	}
	return false;
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

$( "#obatsearchalergi" ).catcomplete({
			source: "t_kesehatan_ibu_dan_anak/obatsource_alergi",
			minLength: 1,
			select: function( event, ui ) {
				$('#obat_tmpvalalergi').val(ui.item.id);
				$('#obat_tmptextalergi').val(ui.item.label);
			}
		});
		
		
		$( "#obatsearch" ).catcomplete({
				source: "t_kesehatan_ibu_dan_anak/obatsource",
				minLength: 2,
				select: function( event, ui ) {
					var lb = ui.item.label.split("=>");
					var lb1 = lb[1].split(':');
					if(parseInt(lb1[1])<1){alert('Maaf Stok Obat Kosong, Silahkan Pilih Obat Lain');$( "#obatsearch" ).val('');$( "#obat_tmptextnostock" ).val('no');return false;}
					var lb2 = lb[2].split(':');
					$('#hargaobattmpid').val(lb2[1]);
					$('#obat_tmpval').val(ui.item.id);
					$('#obat_tmptext').val(lb[0]);
				}
			});


		var searchdataproduk = <?=$dataproduktindakan?>;
		$( "#produktindakansearch" ).catcomplete({
			delay: 0,
			source: searchdataproduk,
			select: function( event, ui ) {
				var lb = ui.item.label.split("=>");
				var lb1 = lb[1].split(':');
				$('#hargatindakanid').val(lb1[1]);
				$('#produktindakansearch_tmpval').val(ui.item.id);
				$('#produktindakansearch_tmptext').val(lb[0]);
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
		if($('#listtindakanrawatjalan').getGridParam("records")>0){
			var rows= jQuery("#listtindakanrawatjalan").jqGrid('getRowData');
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
	$('#backlisttransaksi_pemeriksaanneonatus').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Check Kunjungan Ibu Bersalin</div>
<div class="backbutton"><span class="kembali" id="backlisttransaksi_pemeriksaanneonatus">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" id="form1t_pelayanan_bersalin_edit" action="<?=site_url('t_kesehatan_ibu_dan_anak/editprocess')?>" enctype="multipart/form-data" >
	<fieldset>
		<span>
		<label>Kode Kunjungan Ibu Bersalin</label>
		<input type="text" placeholder="Otomatis" readonly name="kodebersalin" id="kodebersalin" value="" />
		<input type="hidden" name="kd_pasien_hidden" id="textid" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kodebersalin" id="textid" value="<?=$data->KD_KUNJUNGAN_BERSALIN?>" />
		<input type="hidden" name="kd_pasien_hidden" id="textid" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="hidden" name="kd_kunjungan_hidden" id="textid" value="<?=$data->ID_KUNJUNGAN?>" />
		<input type="hidden" name="kd_pelayanan_hidden" id="textid" value="<?=$data->KD_PELAYANAN?>" />
		</span>
		<span>
		<label>Tanggal Kunjungan</label>
		<input type="text" readonly name="tanggal_daftar" id="tglkunjungan" value="<?=$data->TANGGAL_PERSALINAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jam Kelahiran</label>
		<input type="text" readonly name="jam_kelahiran" id="jam_kelahiran" value="<?=$data->JAM_KELAHIRAN?>" />
		</span>
		<span>
		<label>Umur Kehamilan</label>
		<input type="text" readonly name="umur_kehamilan" id="umur_kehamilan" value="<?=$data->UMUR_KEHAMILAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Persalinan</label>
		<input type="text" readonly name="jenis_persalinan" id="jenis_persalinan" value="<?=$data->CARA_PERSALINAN?>" />
		</span>
		<span>
		<label>Jenis Kelahiran</label>
		<input type="text" readonly name="jenis_kelahiran" id="jenis_kelahiran" value="<?=$data->JENIS_KELAHIRAN?>" />
		<input type="hidden" readonly name="kd_cara_persalinan" id="kd_cara_persalinan" value="<?=$data->KD_CARA_PERSALINAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Bayi</label>
		<input type="text" readonly name="jumlah_bayi" id="jumlah_bayi" value="<?=$data->JML_BAYI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keadaan Ibu</label>
		<input type="text" readonly name="keadaan_kesehatan" id="keadaan_kesehatan" value="<?=$data->KEADAAN_KESEHATAN?>" />
		<input type="hidden" readonly name="kd_keadaan_kesehatan" id="kd_keadaan_kesehatan" value="<?=$data->KD_KEADAAN_KESEHATAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Status Hamil</label>
	<input type="text" readonly name="status_hamil" id="status_hamil" value="<?=$data->STATUS_HAMIL?>" />
	<input type="hidden" readonly name="kd_status_hamil" id="kd_status_hamil" value="<?=$data->KD_STATUS_HAMIL?>" />
		</span>
	</fieldset>
		
<div class="subformtitle">Bayi saat Lahir</div>
        <fieldset>
		<span>
		<label>Anak Ke</label>
		<input type="text" name="anak_ke" id="tempat_lahirt_pendaftaranadd" value="<?=$data->ANAK_KE?>"  />		
		</span>
		<span>
		<label>Panjang Badan(cm)</label>
		<input type="text" name="panjang_badan" id="tempat_lahirt_pendaftaranadd" value="<?=$data->PANJANG_BADAN?>" required  />		
		</span>	
	</fieldset>
	 <fieldset>
		<span>
		<label>Berat Lahir (gram)</label>
		<input type="text" name="berat_lahir" id="tempat_lahirt_pendaftaranadd" value="<?=$data->BERAT_LAHIR?>" required  />		
		</span>	
		<span>
		<label>Lingkar Kepala(cm)</label>
		<input type="text" name="lingkar_kepala" id="tempat_lahirt_pendaftaranadd" value="<?=$data->LINGKAR_KEPALA?>" required  />		
		</span>	
	</fieldset>
        <fieldset>
		<span>
		<label>Jenis Kelamin</label>
		<input type="text" name="jk" id="" value="<?=$data->JENIS_KELAMIN?>" required  />
		</span>
	</fieldset>
	<br/>
	<div class="paddinggrid">
		<table id="listkeadaanbayi"></table>
		<div id="pagert_keadaanbayi"></div>
	</div>
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
	<div class="paddinggrid">
		<table id="listasuhanbayi"></table>
		<div id="pagert_asuhanbayi"></div>
	</div>
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
	<br/>
		<div class="subformtitle">Diagnosa</div>
	<div class="paddinggrid">
	<table id="listdiagnosarawatjalan"></table>
	<div id="pagert_diagnosarawatjalan"></div>
	</div>
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
	<div class="subformtitle">Tindakan</div>
		<div class="paddinggrid">
		<table id="listtindakanrawatjalan"></table>
		<div id="pagert_tindakanrawatjalan"></div>
		</div>
		<fieldset id="fieldstindakanrawatjalan">
		<span>
		<label class="declabel2">Cari Tindakan</label>
		<input type="text" name="text" value="" id="produktindakansearch" style="width:255px;" />
		</span>
		<span>
		<label class="declabel">Harga</label>
		<input type="text" name="hargatindakan" id="hargatindakanid" style="width:101px" />
		</span>	
		<span>
		<label style="width:37px">Qty</label>
		<input type="text" name="kuantitastindakan" id="kuantitastindakanid" style="width:39px" />
		<input type="hidden" name="produktindakansearch_tmpval" id="produktindakansearch_tmpval" />
		<input type="hidden" name="produktindakansearch_tmptext" id="produktindakansearch_tmptext" />		
		</span>
	</fieldset>
	<fieldset>
		<span>
			<label class="declabel2">Keterangan Tindakan</label>
			<input type="text" name="keterangantindakan" id="keterangantindakanid" style="width:583px" />
			<input type="button" value="Tambah" id="tambahtindakanid" />
			<input type="button" value="Hapus" id="hapustindakanid" />
		</span>
	</fieldset>
	<div class="subformtitle">Pemberian Obat / Vitamin</div>
	<br/>
		<div class="subformtitle">Alergi</div>
		<div class="paddinggrid">
		<table id="listalergirawatjalan"></table>
		<div id="pagert_alergirawatjalan"></div>
		</div>
		<fieldset id="fieldstindakanrawatjalanalergi">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearchalergi" style="width:255px;" />
		<input type="hidden" name="obat_tmpval" id="obat_tmpvalalergi" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptextalergi" />
			<input type="button" value="Tambah" id="tambahobatalergiid" />
			<input type="button" value="Hapus" id="hapusobatalergiid" />
		</span>
	</fieldset>
	<br/>
		<div class="subformtitle">Obat</div>
		<div class="paddinggrid">
		<table id="listobatrawatjalan"></table>
		<div id="pagert_obatrawatjalan"></div>
	</div>
	<fieldset id="fieldstindakanrawatjalan">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearch" style="width:255px;" />
		</span>
		<span>
		<label style="width:77px">Aturan Pakai</label>
			<input type="text" name="hargatindakan" id="dosisobatid" style="width:55px" />
		</span>
		<?=getComboSatuan('','satuan_obat','satuanobatid','','inline')?>
		<span>
		<label style="width:37px">Qty</label>
			<input type="text" name="kuantitastindakan" id="kuantitasobatid"  style="width:39px" />
			<input type="hidden" name="obat_tmpval" id="obat_tmpval" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptext" />
			<input type="hidden" name="hargaobattmpid" id="hargaobattmpid" />
			<input type="hidden" name="obat_tmptextnostock" id="obat_tmptextnostock" />
			<input type="button" value="Tambah" id="tambahobatid" />
			<input type="button" value="Hapus" id="hapusobatid" />
			<input type="hidden" name="obat_final" id="obat_final" />
			<input type="hidden" name="alergi_final" id="alergi_final" />
			<input type="hidden" name="tindakan_final" id="tindakan_final" />
			<input type="hidden" name="diagnosa_final" id="diagnosa_final" />
			
		</span>		
	</fieldset>
	<fieldset>
		<?=getComboDokter10($data->DOKTER_PEMERIKSA,'dokter','dokter','required','inline')?>		
	</fieldset>
	<fieldset>
		<?=getComboPetugas10($data->DOKTER_PETUGAS,'petugas','petugas','required','inline')?>		
	</fieldset>
	<div class="subformtitle">Keterangan</div>
	<fieldset>
		<span>
		<label>Catatan Apotek</label>
		<textarea type="text" readonly name="komentar" id="komentar_id" disabled=disabled rows="auto" cols="26"> <?=$data->CATATAN_APOTEK?> </textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Catatan Dokter</label>
		<textarea type="text"  name="catatan_dokter" id=""  rows="auto" cols="26"></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >
