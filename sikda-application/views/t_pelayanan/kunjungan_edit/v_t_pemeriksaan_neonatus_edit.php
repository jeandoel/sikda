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
		$('#form1transaksi_pemeriksaanneonatus_edit').ajaxForm({
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
	
	jQuery("#listt_tindakan_anak").jqGrid({ 
		url:'t_pemeriksaan_neonatus/t_tindakan_anakxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode','Tindakan','Harga','Jumlah','Keterangan'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'kdprodukanak',index:'kdprodukanak', width:465,hidden:true}, 
				{name:'produkanak',index:'produkanak', width:465}, 
				{name:'harga',index:'harga', width:465}, 
				{name:'jumlahtindakananak',index:'jumlahtindakananak', width:465}, 
				{name:'keterangantindakananak',index:'keterangantindakananak', width:400}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_tindakan_anak'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id='<?=$data->KD_PELAYANAN?>';
				$('#listt_tindakan_anak').setGridParam({postData:{'myid':id}})
			}			
	}).navGrid('#pagert_tindakan_anak',{search:false});
	
	jQuery("#listt_tindakan_ibu").jqGrid({ 
		url:'t_pemeriksaan_neonatus/t_tindakan_ibuxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode','Tindakan', 'Harga','Jumlah'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kdprodukibu',index:'kdprodukibu', width:465,hidden:true}, 
				{name:'produkibu',index:'produkibu', width:465}, 
				{name:'harga',index:'harga', width:81}, 
				{name:'jumlahtindakanibu',index:'jumlahtindakanibu', width:51,align:'center'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_tindakan_ibu'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id2='<?=$data->KD_PELAYANAN?>';
				$('#listt_tindakan_ibu').setGridParam({postData:{'myid2':id2}})
			}			
	}).navGrid('#pagert_tindakan_ibu',{search:false});
	
	jQuery("#listt_pemeriksaan_neonatus_obat").jqGrid({ 
		url:'t_pemeriksaan_neonatus/t_obatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml",
		colNames:['Kode','Obat','Dosis','Harga','Jumlah'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_obatneonatus',index:'kd_obatneonatus', width:55,hidden:true},
				{name:'obatneonatus',index:'obatneonatus', width:300}, 
				{name:'dosis',index:'dosis', width:300}, 
				//{name:'satuanobatneonatus',index:'satuanobatneonatus', width:51,align:'center'},
				{name:'hargaobatneonatus',index:'hargaobatneonatus', width:81},
				{name:'jumlahobatneonatus',index:'jumlahobatneonatus', width:51,align:'center'}
				
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_pemeriksaan_neonatus_obat'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id3='<?=$data->KD_PELAYANAN?>';
				$('#listt_pemeriksaan_neonatus_obat').setGridParam({postData:{'myid3':id3}})
			}			
	}).navGrid('#pagert_pemeriksaan_neonatus_obat',{search:false});
	
	jQuery("#listt_pemeriksaan_neonatus_alergi").jqGrid({ 
		url:'t_pemeriksaan_neonatus/t_alergixml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml",
		colNames:['Kode','Nama Obat'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,	
		colModel:[ 
				{name:'kd_obatalergineonatus',index:'kd_obatalergineonatus', width:50,align:'center'}, 
				{name:'obatalergineonatus',index:'obatalergineonatus', width:100}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_pemeriksaan_neonatus_alergi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id4='<?=$data->KD_PASIEN?>';
				$('#listt_pemeriksaan_neonatus_alergi').setGridParam({postData:{'myid4':id4}})
			}			
	}).navGrid('#pagert_pemeriksaan_neonatus_alergi',{search:false});
	

		var produkibuid = 0;
		$('#tambahprodukibuid').click(function(){
			if($('#produkibusearch_tmpval').val()){
				if($('#kuantitastindakanidibu').val()==''){
					alert("Silahkan Isi Kolom 'Qty'");
					$('#kuantitastindakanidibu').focus();return false;
				}
				var myfirstrow = {kdprodukibu:$('#produkibusearch_tmpval').val(), produkibu:$('#produkibusearch_tmptext').val(), harga:$('#hargatindakanidibu').val(), jumlahtindakanibu:$('#kuantitastindakanidibu').val()};
				jQuery("#listt_tindakan_ibu").addRowData(produkibuid+1, myfirstrow);
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
				var myfirstrow = {kdprodukanak:$('#produkanaksearch_tmpval').val(), produkanak:$('#produkanaksearch_tmptext').val(), harga:$('#hargatindakanidanak').val(), jumlahtindakananak:$('#kuantitastindakanidanak').val(), keterangantindakananak:$('#keterangantindakanidneo').val()};
				jQuery("#listt_tindakan_anak").addRowData(produkanakid+1, myfirstrow);
				$('#produkanaksearch').val('');
				$('#produkanaksearch_tmptext').val('');
				$('#produkanaksearch_tmpval').val('');
				$('#keterangantindakanidneo').val('');
				/*$('#hargatindakanidanak').val('');
				$('#kuantitastindakanidanak').val('');*/
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
		
		
		var obatidneonatus = 0;
		$('#tambahobatidneonatus').click(function(){
			if($('#obatneonatus_tmpval').val()){
				if($('#kuantitasobatidneonatus').val()==''){
					alert("Silahkan Isi Kolom 'Qty'");
					$('#kuantitasobatidneonatus').focus();return false;
				}
				var myfirstrow = {kd_obatneonatus:$('#obatneonatus_tmpval').val(), obatneonatus:$('#obatneonatus_tmptext').val(), dosis:$('#dosisobatidneonatus').val(), satuanobatneonatus:$('#satuanobatidneonatus').val(), hargaobatneonatus:$('#hargaobatidneonatus').val(), jumlahobatneonatus:$('#kuantitasobatidneonatus').val()};
				jQuery("#listt_pemeriksaan_neonatus_obat").addRowData(obatidneonatus+1, myfirstrow);
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
				jQuery("#listt_pemeriksaan_neonatus_alergi").addRowData(obatalergiidneonatus+1, myfirstrow);
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
		
			$('#hapusprodukibuid').click(function(){
			jQuery("#listt_tindakan_ibu").clearGridData();
		})
		
		$('#hapusprodukanakid').click(function(){
			jQuery("#listt_tindakan_anak").clearGridData();
		})
		
		$('#hapusobatidneonatus').click(function(){
			jQuery("#listt_pemeriksaan_neonatus_obat").clearGridData();
		})
		
		$('#hapusobatalergiidneonatus').click(function(){
		jQuery("#listt_pemeriksaan_neonatus_alergi").clearGridData();
		})
		
	
});

$("#form1transaksi_pemeriksaanneonatus_edit").validate({focusInvalid:true});

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
		
		$('#form1transaksi_pemeriksaanneonatus_edit :submit').click(function(e) {
			e.preventDefault();
			if($("#form1transaksi_pemeriksaanneonatus_edit").valid()) {
				if(kumpularray())$('#form1transaksi_pemeriksaanneonatus_edit').submit();
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
			}
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
		if($('#listt_tindakan_ibu').getGridParam("records")>0){
			var rows= jQuery("#listt_tindakan_ibu").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#produkibu_final").val(JSON.stringify(paras));
		}
		
		
		if($('#listt_tindakan_anak').getGridParam("records")>0){
			var rows= jQuery("#listt_tindakan_anak").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#produkanak_final").val(JSON.stringify(paras));
		}
		
		if($('#listt_pemeriksaan_neonatus_obat').getGridParam("records")>0){
			var rows= jQuery("#listt_pemeriksaan_neonatus_obat").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#obatneonatus_final").val(JSON.stringify(paras));
		}
		
		if($('#listt_pemeriksaan_neonatus_alergi').getGridParam("records")>0){
			var rows= jQuery("#listt_pemeriksaan_neonatus_alergi").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#alergineonatus_final").val(JSON.stringify(paras));
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
<div class="formtitle">Detail Pemeriksaan Neonatus</div>
<div class="backbutton"><span class="kembali" id="backlisttransaksi_pemeriksaanneonatus">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" id="form1transaksi_pemeriksaanneonatus_edit" action="<?=site_url('t_pemeriksaan_neonatus/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Pemeriksaan Neonatus</label>
		<input type="text" placeholder="Otomatis" readonly name="kodepemeriksaanneonatus" id="kodepemeriksaanneonatus" value="" />
		<input type="hidden" readonly name="id" id="kodepemeriksaanneonatus" value="<?=$data->KD_PEMERIKSAAN_NEONATUS?>" />
		<input type="hidden" name="kd_pasien_hidden" id="textid" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="hidden" name="kd_kunjungan_hidden" id="textid" value="<?=$data->ID_KUNJUNGAN?>" />
		<input type="hidden" name="kd_pelayanan_hidden" id="textid" value="<?=$data->KD_PELAYANAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal</label>
		<input type="text" readonly name="tglkunjungan" id="tglkunjungan" value="<?=$data->TANGGAL_KUNJUNGAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kunjungan ke</label>
		<input type="text" readonly name="kunjunganke" id="kunjunganke" value="<?=$data->KUNJUNGAN_KE?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Berat Badan (kg)</label>
		<input type="text" readonly name="beratbadan" id="beratbadan" value="<?=$data->BERAT_BADAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Panjang Badan (cm)</label>
		<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->PANJANG_BADAN?>" />
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
			<input type="hidden" name="diagnosa_final" id="diagnosa_final" />
		</span>
	</fieldset>
	<div class="subformtitle">Memeriksa Bayi/Anak</div>
		<div class="paddinggrid">
		<table id="listt_tindakan_anak"></table>
		<div id="pagert_tindakan_anak"></div>
		</div>
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
	<div class="subformtitle">Tindakan Ibu</div>
		<div class="paddinggrid">
		<table id="listt_tindakan_ibu"></table>
		<div id="pagert_tindakan_ibu"></div>
		</div>
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
	<br/>
	<fieldset>
		<span>
		<label>Keluhan</label>
		<input type="text" readonly name="keluhan" id="keluhan" value="<?=$data->KELUHAN?>" />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle">Alergi</div>
	<div class="paddinggrid">
	<table id="listt_pemeriksaan_neonatus_alergi"></table>
	<div id="pagert_pemeriksaan_neonatus_alergi"></div>
	</div>
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
	<br/>
	<div class="subformtitle">Obat</div>
	<div class="paddinggrid">
	<table id="listt_pemeriksaan_neonatus_obat"></table>
	<div id="pagert_pemeriksaan_neonatus_obat"></div>
	</div>
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
			<input type="button" value="Tambah" id="tambahobatidneonatus" />
			<input type="button" value="Hapus" id="hapusobatidneonatus" />
		</span>		
	</fieldset>
	<br/>
	<fieldset>
		<?=getComboDokterPemeriksa($data->PEMERIKSA,'nama_pemeriksa','pemeriksa','required','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboDokterPetugas($data->PETUGAS,'nama_petugas','petugas','required','inline')?>
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
		<input type="submit" id="Simpanan" name="bt1" value="Simpan"/>
		</span>
	</fieldset>	
</form>
</div >
