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
.declabel2{width:215px}
.decinput{width:99px}
</style>
<script>
$('document').ready(function() {		
	$('#form1t_imunisasi_kipi').ajaxForm({
		beforeSend: function() {
			achtungShowLoader();
		},
		uploadProgress: function(event, position, total, percentComplete) {
		},
		complete: function(xhr) {			
			if(xhr.responseText!=='OK'){
				$.achtung({message: xhr.responseText, timeout:5});
			}else{
				$.achtung({message: 'Proses Tambah Data Berhasil', timeout:5});
				$("#t215","#tabs").empty();
				$("#t215","#tabs").load('t_imunisasi'+'?_=' + (new Date()).getTime());
			}
			achtungHideLoader();
		}
	});

	$("#kelurahant_pendaftaranadd").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getKelurahanByKecamatanId')?>");
	
	jQuery("#list_petugas").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 705,
		height: 'auto',
		colNames:['Kode Petugas','Petugas'],
		colModel :[ 
		{name:'kd_petugas',index:'kd_petugas', width:55,align:'center',hidden:true}, 
		{name:'petugas',index:'petugas', width:300}
		],
		rowNum:35,
		viewrecords: true
	}); 
	
		
	jQuery("#listimunisasivaksin").jqGrid({ 
		url:'t_imunisasi/t_data_petugas', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Jenis Imunisasi', 'Vaksin'],
		rownumbers:true,
		width: 705,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'jenis_imunisasi',index:'jenis_imunisasi', width:465}, 
				{name:'vaksin',index:'vaksin', width:81}, 
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_imunisasi_kipi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id2='<?=$KD_TRANS_IMUNISASI?>';
				$('#listimunisasivaksin').setGridParam({postData:{'id2':id2}})
			}			
	}).navGrid('#pagert_imunisasi_kipi',{search:false});
	

	var petugasid = 0;
	$('#tambahpetugasid').click(function(){
		if($('#petugas_tmpval').val()){
			var myfirstrow = {kd_petugas:$('#petugas_tmpval').val(), petugas:$('#petugas_tmptext').val()};
			jQuery("#list_petugas").addRowData(petugasid+1, myfirstrow);
			$('#petugassearch').val('');
			$('#petugas_tmptext').val('');
			$('#petugas_tmpval').val('');
			if(confirm('Tambah Data Petugas Lain?')){
				$('#petugassearch').focus();					
			}else{
				$('#gejala').focus();
			}
		}else{
			alert('Silahkan Pilih Petugas.');
		}
	})
	
	$('#hapuspetugasid').click(function(){
		jQuery("#list_petugas").clearGridData();
	})
	
	$("#form1t_imunisasi_kipi").validate({
		rules: {
			tgl_kipi: {
				date:true,
				required: true
			}
		},
		messages: {
			tgl_kipi: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			}
		}
	});

})

$("#form1t_imunisasi_kipi").validate({focusInvalid:true});

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

$('#form1t_imunisasi_kipi :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_imunisasi_kipi").valid()) {
		if(kumpularray())$('#form1t_imunisasi_kipi').submit();
	}
	return false;
});

$( "#petugassearch" ).catcomplete({
		source: "t_imunisasi_kipi/petugassource",
		minLength: 2,
		select: function( event, ui ) {
			$('#petugas_tmpval').val(ui.item.id);
			$('#petugas_tmptext').val(ui.item.label);
		}
});

$("#tgl_kipi").focus();

$("#tgl_kipi").mask("99/99/9999");

		$("#kabupaten_kotat_pendaftaranadd").remoteChained("#provinsit_pendaftaranadd", "<?=site_url('t_masters/getKabupatenByProvinceId')?>");
		$("#kecamatant_pendaftaranadd").remoteChained("#kabupaten_kotat_pendaftaranadd", "<?=site_url('t_masters/getKecamatanByKabupatenId')?>");
		$("#kelurahant_pendaftaranadd").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getKelurahanByKecamatanId')?>");

</script>
<script>

	function kumpularray(){
		if($('#list_petugas').getGridParam("records")>0){
			var rows= jQuery("#list_petugas").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#petugas_final").val(JSON.stringify(paras));
		}
		return true;
				
	}

</script>
<script>
	$("#form1t_imunisasi_kipi input[name = 'batal'], #backlistt_imunisasi_kipi").click(function(){
		$("#t215","#tabs").empty();
		$("#t215","#tabs").load('t_imunisasi'+'?_=' + (new Date()).getTime());
	});
	$("#desa_kipi").remoteChained("#kec_kipi", "<?=site_url('t_masters/getDesaByKecamatanId')?>");	 
</script>
<div class="mycontent">
<div class="formtitle">Imunisasi KIPI</div>
<div class="backbutton"><span class="kembali" id="backlistt_imunisasi_kipi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_imunisasi_kipi" method="post" onsubmit="bt1.disabled = true; return true;" action="<?=site_url('t_imunisasi_kipi/addprocess')?>" enctype="multipart/form-data">
	<div class="subformtitle">Data Pasien</div>
	<fieldset>
		<span>
			<label>Tanggal Imunisasi</label>
			<input type="text" name="" id="" value="<?=$TANGGAL?>" class="mydate" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Rekam Medis</label>
		<input type="text" name="rekam_medis" id="" value="<?=$KD_PASIEN?>" readonly />
		<input type="hidden" name="kd_trans_imunisasi_hidden" id="" value="<?=$KD_TRANS_IMUNISASI?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="" id=""value="<?=$NAMA_LENGKAP?>" readonly  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tanggal Lahir</label>
		<input type="text" name="" id="" value="<?=$TGL_LAHIR?>" class="mydate" readonly  />		
		</span>
	</fieldset>
	<?=getComboJeniskelamin($KD_JENIS_KELAMIN,'jenis_kelamin','jenis_kelamint_pasienadd','required','')?>
	<fieldset>
		<span>
		<label>Alamat</label>
		<textarea type="text" name="" id="" rows="3" cols="45" readonly><?=$ALAMAT?></textarea>
		</span>
	</fieldset>
	</fieldset>
	<?=getComboProvinsi($KD_PROVINSI,'provinsipasien','provinsit_pendaftaranadd','required','')?>
	<fieldset>
	<span>
	<label>Kab/Kota</label>
		<select name="kabupaten_kotapasien" id="kabupaten_kotat_pendaftaranadd">
			<option value="<?=$KD_KABKOTA?>">--</option>
		</select>
	</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
			<select name="kecamatanpasien" id="kecamatant_pendaftaranadd">
				<option value="<?=$KD_KECAMATAN?>">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Desa/Kelurahan</label>
			<select name="desa_kelurahanpasien" id="kelurahant_pendaftaranadd">
				<option value="<?=$KD_KELURAHAN?>">--</option>
			</select>
		</span>
	</fieldset>
	<div class="subformtitle">Jenis Imunisasi</div>
		<div class="paddinggrid">
		<table id="listimunisasivaksin"></table>
		<div id="pagert_imunisasi_kipi"></div>
		</div>
	<br/>
	
	<div class="subformtitle">Data Imunisasi KIPI</div>
	
	<fieldset>
		<span>
			<label>Tanggal KIPI</label>
			<input type="text" name="tgl_kipi" id="" value="<?=date('Y-m-d');?>" class="mydate" />
		</span>
	</fieldset>
	<?=getComboJenislokasi('','jenis_lokasi','jenis_lokasit_imunisasiadd','required','')?>	
	<fieldset>
		<span>
		<label>Nama Lokasi KIPI</label>
		<input type="text" name="nama_lokasi_kipi" id="" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat KIPI</label>
		<textarea type="text" name="alamat_kipi" id="" rows="3" cols="45" ></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
			<input type="text" name="kecamatanlokasi" id="kec_kipi" value="<?=$kecamatan?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Desa/Kelurahan</label>
			<select name="desalokasi" id="desa_kipi">
				<option value="<?=$KD_KELURAHAN?>" selected:selected ></option>
			</select>
		</span>
	</fieldset>
	</br>

	

	<table id="list_petugas"></table>
	<fieldset id="fieldspetugas">
	<span>
		<label class="declabel2">Petugas</label>
		<input type="text" name="text" value="" id="petugassearch" style="width:255px;" />
		<input type="hidden" name="petugas_tmpval" id="petugas_tmpval" />
		<input type="hidden" name="petugas_tmptext" id="petugas_tmptext" />		
		<input type="button" value="Tambah" id="tambahpetugasid" />
		<input type="button" value="Hapus" id="hapuspetugasid" />
		<input type="hidden" name="petugas_final" id="petugas_final" />
	</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Gejala</label>
		<span>
			<input type="checkbox" id="gejala" name="gejala[]" value="demam" >Demam<br/>
			<input type="checkbox" name="gejala[]" value="bengkak" >Bengkak di Lokasi Suntikan<br/>
			<input type="checkbox" name="gejala[]" value="merah" >Merah di Lokasi Suntikan<br/>
			<input type="checkbox" name="gejala[]" value="muntah" >Muntah<br/>
		</span>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Gejala Lain</label>
		<textarea type="text" name="gejala[]" id="gejala_lain" value="" rows="3" cols="45" ></textarea>
		</span>
	</fieldset>
	</fieldset><fieldset>
		<?=getComboKeadaanKesehatan('','kondisiakhir','kondisiakhir','required','inline')?>	
	</fieldset>
	<br/>
	<fieldset>
		<span>
		<input type="button" name="batal" value="Batal" />
		&nbsp; - &nbsp;
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
	
	
</form>
</div >