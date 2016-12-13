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
		$('#form1t_pelayanan_kb_add').ajaxForm({
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
		
		
		$("#carabayart_pendaftaranadd").chained("#jenis_pasient_pendaftaranadd");
		
			jQuery("#listtindakan").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 578,
			height: 'auto',
			colNames:['Kode Produk','Tindakan'],
			colModel :[ 
			{name:'kdproduk',index:'kdproduk', width:55,align:'center',hidden:true}, 
			{name:'produk',index:'produk', width:801}
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
		
		
		var tindakanid = 0;
		$('#tambahtindakanid').click(function(){
			if($('#tindakansearch_tmpval').val()){
				var myfirstrow = {kdproduk:$('#tindakansearch_tmpval').val(), produk:$('#tindakansearch_tmptext').val()};
				jQuery("#listtindakan").addRowData(tindakanid+1, myfirstrow);
				$('#tindakansearch').val('');
				$('#tindakansearch_tmptext').val('');
				$('#tindakansearch_tmpval').val('');
				if(confirm('Tambah Data Tindakan Lain?')){
					$('#tindakansearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Tindakan.');
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
		
		
		$('#hapustindakanid').click(function(){
			jQuery("#listtindakan").clearGridData();
		})
		
		$('#hapusobatid').click(function(){
			jQuery("#listobatrawatjalan").clearGridData();
		})
		
	$('#hapusobatalergiid').click(function(){
		jQuery("#listalergirawatjalan").clearGridData();
	})
		
	
		
		$("#form1t_pelayanan_kb_add").validate({
		rules: {

				tanggalpemeriksaan: {
				date:true,
				required:true
			}
		},
		messages: {
				tanggalpemeriksaan: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			}
		}
	});
	
	$("#tanggalpemeriksaan").mask("99/99/9999");
	
	
})


$("#form1t_pelayanan_kb_add").validate({focusInvalid:true});

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

$('#form1t_pelayanan_kb_add :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_pelayanan_kb_add").valid()) {
		if(kumpularray())$('#form1t_pelayanan_kb_add').submit();
	}
	return false;
});

$( "#tindakansearch" ).catcomplete({
	source: "t_pelayanan_kb/tindakansource",
	minLength: 1,
	select: function( event, ui ) {
	//log( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
		$('#tindakansearch_tmpval').val(ui.item.id);
		$('#tindakansearch_tmptext').val(ui.item.label);
		//$('#selectjeniskasusid').focus();
	}
});


$( "#obatsearch" ).catcomplete({
	source: "t_pelayanan_kb/obatsource",
	minLength: 1,
	select: function( event, ui ) {
		$('#obat_tmpval').val(ui.item.id);
		$('#obat_tmptext').val(ui.item.label);
	}
});

$( "#obatsearchalergi" ).catcomplete({
	source: "t_pelayanan_kb/obatsource",
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
			if($("#form1t_pelayanan_kb_add").valid()) {
				if(kumpularray())$('#form1t_pelayanan_kb_add').submit();
			}
			return false;
		}
   }
});

function kumpularray(){
		if($('#listtindakan').getGridParam("records")>0){
			var rows= jQuery("#listtindakan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
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
	
	
	$('#t_pelayanan_kb_hidden').focus(function(){
			$("#dialogcari_t_pelayanan_kb_popup_id").dialog({
				autoOpen: false,
				modal:true,
				width: 1000,
				height: 380,
				buttons : {
					"Keluar" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_t_pelayanan_kb_popup_id').load('t_pelayanan_kb/tpelayanankbpopup?id_caller=form1t_pelayanan_kb_add', function() {
				$("#dialogcari_t_pelayanan_kb_popup_id").dialog("open");
			});
		});


</script>
<script>
	
		$('#backlistt_pelayanan_kb').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div id="dialogcari_t_pelayanan_kb_popup_id" title="Pelayanan KB"></div>
<div class="formtitle">Pelayanan KB</div>
<div class="backbutton"><span class="kembali" id="backlistt_pelayanan_kb">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pelayanan_kb_add" method="post" action="<?=site_url('t_pelayanan_kb/addprocess')?>" enctype="multipart/form-data">
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
		<?=getComboJenispasien($data->KD_CUSTOMER,'jenis_pasien','jenis_pasient_pendaftaranadd','required','inline')?>
		<?=getComboCarabayar('','cara_bayar','carabayart_pendaftaranadd','required','inline')?>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Suami</label>
		<input type="text" name="keluhan" id="text2" disabled=disabled value="" required />
		</span>
		<span>
		<label>Jenis Kunjungan</label>
		<input type="text" name="keluhan" id="text2" disabled=disabled value="Kunjungan <?=$data->KUNJUNGAN_KIA?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal</label>
		<input type="text" name="tanggalpemeriksaan" id="tanggalpemeriksaan" class="mydate" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>
	
	<fieldset>
		<?=getComboJeniskb('','kdjeniskb','jeniskbt_pelayanan_kb_add','required','inline')?>	
	</fieldset>
	<fieldset>
		<span>
		<label>Keluhan</label>
		<input type="text" name="keluhan" id="text2" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Anamnese</label>
		<textarea name="anamnese" id="text3" cols="26" rows="5" value="" required />
		</span>
	</fieldset>
	<br/>
	<table id="listtindakan"></table>
	<fieldset id="fieldsdiagnosarawatjalan">
		<span>
		<label>Tindakan</label>
		<input type="text" name="text" value="" id="tindakansearch" />
		<input type="hidden" name="tindakansearch_tmpval" id="tindakansearch_tmpval" />
		<input type="hidden" name="tindakansearch_tmptext" id="tindakansearch_tmptext" />
		<input type="hidden" name="tindakan_final" id="tindakan_final" />
		<input type="button" value="Tambah" id="tambahtindakanid" />
		<input type="button" id="hapustindakanid" value="Hapus" />
		</span>
	</fieldset>
		<fieldset>
		<?=getComboDokterPemeriksa('','pemeriksa','pemeriksa','required','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboDokterPetugas('','petugas','petugas','required','inline')?>
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
	<fieldset>
		<span>
		<input type="button" name="batal" value="Batal" />
		&nbsp; - &nbsp;
		<input type="submit" name="bt1" value="Simpan"/>
		&nbsp; - &nbsp;
		<input type="button" name="" id="t_pelayanan_kb_hidden" value="Riwayat Hidup"/>
		</span>
	</fieldset>	
</form>
</div >