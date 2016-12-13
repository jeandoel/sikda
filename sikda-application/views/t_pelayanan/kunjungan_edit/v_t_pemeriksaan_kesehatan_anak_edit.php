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
		$('#form1t_pemeriksaan_kesehatan_anak_edit').ajaxForm({
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

		jQuery("#listt_pemeriksaan_kesehatan_anak_penyakit").jqGrid({ 
		url:'t_pemeriksaan_kesehatan_anak/t_penyakitxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Penyakit','Penyakit', 'Jenis Kasus','Jenis Diagnosa'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
			{name:'kd_penyakit',index:'kd_penyakit', width:55,align:'center'}, 
			{name:'penyakit',index:'penyakit', width:801}, 
			{name:'jenis_kasus',index:'jenis_kasus', width:81}, 
			{name:'jenis_diagnosa',index:'jenis_diagnosa', width:81}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_pemeriksaan_kesehatan_anak_penyakit'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id='<?=$data->KD_PELAYANAN?>';
				$('#listt_pemeriksaan_kesehatan_anak_penyakit').setGridParam({postData:{'myid':id}})
			}			
	}).navGrid('#pagert_pemeriksaan_kesehatan_anak_penyakit',{search:false});
	
	jQuery("#listt_pemeriksaan_kesehatan_anak_tindakan").jqGrid({ 
		url:'t_pemeriksaan_kesehatan_anak/t_tindakanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Tindakan','Tindakan', 'Harga','Jumlah','Keterangan'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_tindakan',index:'kd_tindakan', width:60}, 
				{name:'tindakan',index:'tindakan', width:465}, 
				{name:'harga',index:'harga', width:81}, 
				{name:'jumlah',index:'jumlah', width:51,align:'center'},
				{name:'keterangan',index:'keterangan', width:400}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_pemeriksaan_kesehatan_anak_tindakan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id2='<?=$data->KD_PELAYANAN?>';
				$('#listt_pemeriksaan_kesehatan_anak_tindakan').setGridParam({postData:{'myid2':id2}})
			}			
	}).navGrid('#pagert_pemeriksaan_kesehatan_anak_tindakan',{search:false});
	
	jQuery("#listt_pemeriksaan_kesehatan_anak_obat").jqGrid({ 
		url:'t_pemeriksaan_kesehatan_anak/t_obatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml",
		colNames:['Kode Obat','Obat', 'Dosis','Harga','Jumlah'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
				{name:'obat',index:'obat', width:300}, 
				{name:'dosis',index:'dosis', width:81}, 
				{name:'harga',index:'harga', width:81},
				{name:'jumlah',index:'jumlah', width:51,align:'center'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_pemeriksaan_kesehatan_anak_obat'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id3='<?=$data->KD_PELAYANAN?>';
				$('#listt_pemeriksaan_kesehatan_anak_obat').setGridParam({postData:{'myid3':id3}})
			}			
	}).navGrid('#pagert_pemeriksaan_kesehatan_anak_obat',{search:false});
	
	jQuery("#listt_pemeriksaan_kesehatan_anak_alergi").jqGrid({ 
		url:'t_pemeriksaan_kesehatan_anak/t_alergixml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml",
		colNames:['Kode Obat','Obat'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,	
		colModel:[ 
				{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
				{name:'obat',index:'obat', width:300}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_pemeriksaan_kesehatan_anak_alergi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id4='<?=$data->KD_PASIEN?>';
				$('#listt_pemeriksaan_kesehatan_anak_alergi').setGridParam({postData:{'myid4':id4}})
			}			
	}).navGrid('#pagert_pemeriksaan_kesehatan_anak_alergi',{search:false});
	
	
	var diagnosatid = 0;
		$('#tambahdiagnosaid').click(function(){
			if($('#icdsearch_tmpval').val()){
				var myfirstrow = {kd_penyakit:$('#icdsearch_tmpval').val(), penyakit:$('#icdsearch_tmptext').val(), jenis_kasus:$('#selectjeniskasusid').val(), jenis_diagnosa:$('#selectjenisdiagnosaid').val()};
				jQuery("#listt_pemeriksaan_kesehatan_anak_penyakit").addRowData(diagnosatid+1, myfirstrow);
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
		
		var tindakanid = 0;
		$('#tambahtindakanid').click(function(){
			if($('#produktindakansearch_tmpval').val()){
				if($('#kuantitastindakanid').val()==''){
					alert("Silahkan Isi Kolom 'Qty'");
					$('#kuantitastindakanid').focus();return false;
				}
				var myfirstrow = {kd_tindakan:$('#produktindakansearch_tmpval').val(), tindakan:$('#produktindakansearch_tmptext').val(), harga:$('#hargatindakanid').val(), jumlah:$('#kuantitastindakanid').val(), keterangan:$('#keterangantindakanid').val()};
				jQuery("#listt_pemeriksaan_kesehatan_anak_tindakan").addRowData(tindakanid+1, myfirstrow);
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
		
		var obatid = 0;
		$('#tambahobatid').click(function(){
			if($('#obat_tmpval').val()){
				if($('#kuantitasobatid').val()==''){
					alert("Silahkan Isi Kolom 'Qty'");
					$('#kuantitasobatid').focus();return false;
				}
				var myfirstrow = {kd_obat:$('#obat_tmpval').val(), obat:$('#obat_tmptext').val(), dosis:$('#dosisobatid').val(), jumlah:$('#kuantitasobatid').val(), satuan:$('#satuanobatid').val(), harga:$('#hargaobattmpid').val()};
				jQuery("#listt_pemeriksaan_kesehatan_anak_obat").addRowData(obatid+1, myfirstrow);
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
				jQuery("#listt_pemeriksaan_kesehatan_anak_alergi").addRowData(obatalergiid+1, myfirstrow);
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
		
		$('#hapusobatid').click(function(){
			jQuery("#listt_pemeriksaan_kesehatan_anak_obat").clearGridData();
		})
		
		$('#hapusobatalergiid').click(function(){
			jQuery("#listt_pemeriksaan_kesehatan_anak_alergi").clearGridData();
		})
		
		$('#hapusdiagnosaid').click(function(){
			jQuery("#listt_pemeriksaan_kesehatan_anak_penyakit").clearGridData();
		})
		
		$('#hapustindakanid').click(function(){
			jQuery("#listt_pemeriksaan_kesehatan_anak_tindakan").clearGridData();
		})
		
	
});

$("#form1t_pemeriksaan_kesehatan_anak_edit").validate({focusInvalid:true});

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

$('#form1t_pemeriksaan_kesehatan_anak_edit :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_pemeriksaan_kesehatan_anak_edit").valid()) {
		if(kumpularray())$('#form1t_pemeriksaan_kesehatan_anak_edit').submit();
	}
	return false;
});

$( "#icdsearch" ).catcomplete({
	source: "t_pemeriksaan_kesehatan_anak/icdsource",
	minLength: 2,
	select: function( event, ui ) {
	//log( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
		$('#icdsearch_tmpval').val(ui.item.id);
		$('#icdsearch_tmptext').val(ui.item.label);
		//$('#selectjeniskasusid').focus();
	}
});

$( "#obatsearch" ).catcomplete({
	source: "t_pemeriksaan_kesehatan_anak/obatsource",
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

$( "#obatsearchalergi" ).catcomplete({
	source: "t_pemeriksaan_kesehatan_anak/obatsource_alergi",
	minLength: 2,
	select: function( event, ui ) {
		$('#obat_tmpvalalergi').val(ui.item.id);
		$('#obat_tmptextalergi').val(ui.item.label);
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

</script>
<script>
//$('#tglt_pelayanan').datepicker({dateFormat: "yy-mm-dd",changeYear: true,yearRange: "-100:+0"});
	function kumpularray(){
		if($('#listt_pemeriksaan_kesehatan_anak_penyakit').getGridParam("records")>0){
			var rows= jQuery("#listt_pemeriksaan_kesehatan_anak_penyakit").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#diagnosa_final").val(JSON.stringify(paras));
		}
		if($('#listt_pemeriksaan_kesehatan_anak_obat').getGridParam("records")>0){
			var rows= jQuery("#listt_pemeriksaan_kesehatan_anak_obat").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#obat_final").val(JSON.stringify(paras));
		}
		if($('#listt_pemeriksaan_kesehatan_anak_alergi').getGridParam("records")>0){
			var rows= jQuery("#listt_pemeriksaan_kesehatan_anak_alergi").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#alergi_final").val(JSON.stringify(paras));
		}
		if($('#listt_pemeriksaan_kesehatan_anak_tindakan').getGridParam("records")>0){
			var rows= jQuery("#listt_pemeriksaan_kesehatan_anak_tindakan").jqGrid('getRowData');
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
		$('#backlistt_pemeriksaan_kesehatan_anak').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Check Pemeriksaan Anak</div>
<div class="backbutton"><span class="kembali" id="backlistt_pemeriksaan_kesehatan_anak">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pemeriksaan_kesehatan_anak_edit" method="post" action="<?=site_url('t_pemeriksaan_kesehatan_anak/editprocess')?>" enctype="multipart/form-data ">

	<fieldset>
		<span>
		<label>Tanggal Pelayanan</label>
		<input type="text" name="tgl_periksa" id="tgl_periksa" value="<?=$data->TANGGAL_KUNJUNGAN?>" />
		<input type="hidden" name="id" id="kd_pemeriksaan_anak" value="<?=$data->KD_PEMERIKSAAN_ANAK?>" />
		<input type="hidden" name="kd_pasien_hidden" id="textid" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="hidden" name="kd_kunjungan_hidden" id="textid" value="<?=$data->ID_KUNJUNGAN?>" />
		<input type="hidden" name="kd_pelayanan_hidden" id="textid" value="<?=$data->KD_PELAYANAN?>" />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle">Diagnosa</div>
	<div class="paddinggrid">
	<table id="listt_pemeriksaan_kesehatan_anak_penyakit"></table>
	<div id="pagert_pemeriksaan_kesehatan_anak_penyakit"></div>
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
	<br/>
	<div class="subformtitle">Tindakan</div>
	<div class="paddinggrid">
	<table id="listt_pemeriksaan_kesehatan_anak_tindakan"></table>
	<div id="pagert_pemeriksaan_kesehatan_anak_tindakan"></div>
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
	<br/>
	<div class="subformtitle">Alergi</div>
	<div class="paddinggrid">
	<table id="listt_pemeriksaan_kesehatan_anak_alergi"></table>
	<div id="pagert_pemeriksaan_kesehatan_anak_alergi"></div>
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
	<table id="listt_pemeriksaan_kesehatan_anak_obat"></table>
	<div id="pagert_pemeriksaan_kesehatan_anak_obat"></div>
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
			
			<input type="hidden" name="diagnosa_final" id="diagnosa_final" />
			<input type="hidden" name="obat_final" id="obat_final" />
			<input type="hidden" name="alergi_final" id="alergi_final" />
			<input type="hidden" name="tindakan_final" id="tindakan_final" />
			
		</span>		
	</fieldset>
	<br/>
	<fieldset>
		<?=getComboPemeriksa($data->DOKTER,'kolom_nama_pemeriksa','kolom_nama_pemeriksa','required','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboPetugas($data->PETUGAS,'kolom_nama_petugas','kolom_nama_petugas','required','inline')?>
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
		<!-- <input type="button" name="batal" value="Batal" /> -->
		<!-- &nbsp; - &nbsp; -->
		<input type="submit" name="bt1" value="Simpan"/>
		</span>
	</fieldset>	
</form>
</div >