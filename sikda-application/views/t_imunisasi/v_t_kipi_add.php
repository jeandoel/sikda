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
				$("#t211","#tabs").empty();
				$("#t211","#tabs").load('t_imunisasi_kipi'+'?_=' + (new Date()).getTime());
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
		$("#t211","#tabs").empty();
		$("#t211","#tabs").load('t_imunisasi_kipi'+'?_=' + (new Date()).getTime());
	});
</script>
<div class="mycontent">
<div class="subformtitle">Pendaftaran Imunisasi KIPI</div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_imunisasi_kipi" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_imunisasi_kipi/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Rekam Medis</label>
		<input type="text" name="rekam_medis" id="" value="" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="" id="" value="" readonly  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tanggal Lahir</label>
		<input type="text" name="" id="" value="" class="mydate" readonly  />		
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Kelamin</label>
		<input type="text" name="" id="" value="" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat</label>
		<textarea type="text" name="" id="" value="" rows="3" cols="45" readonly></textarea>
		</span>
	</fieldset>
	</fieldset>
	<?=getComboProvinsi($this->session->userdata('kd_provinsi'),'provinsipasien','provinsit_pendaftaranadd','required','')?>
	<fieldset>
	<span>
	<label>Kab/Kota</label>
		<select name="kabupaten_kotapasien" id="kabupaten_kotat_pendaftaranadd">
			<option value="">--</option>
		</select>
	</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
			<select name="kecamatanpasien" id="kecamatant_pendaftaranadd">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Desa/Kelurahan</label>
			<select name="desa_kelurahanpasien" id="kelurahant_pendaftaranadd">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Vaksin</label>
		<input type="text" name="" id="" value="" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Vaksin</label>
		<input type="text" name="" id="" value="" readonly />
		</span>
	</fieldset>	
	<fieldset>
		<span>
			<label>Tanggal Imunisasi</label>
			<input type="text" name="" id="" value="" class="mydate" readonly />
		</span>
	</fieldset>
	
	<br/>
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
	<br/>
	
</form>
</div >