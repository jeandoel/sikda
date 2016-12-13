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
	$('#form1t_pelayanan_imunisasi').ajaxForm({
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
	
	jQuery("#listpetugasimunisasi").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 705,
		height: 'auto',
		colNames:['Kode Petugas','Petugas','Keterangan'],
		colModel :[ 
		{name:'kd_petugas',index:'kd_petugas', width:55,align:'center',hidden:true}, 
		{name:'petugas',index:'petugas', width:100}, 
		{name:'keterangan',index:'keterangan', width:100}, 
		],
		rowNum:35,
		viewrecords: true
	});
		
	jQuery("#listimunisasi").jqGrid({
		datatype: 'clientSide',
		rownumbers:true,
		width: 580,
		height: 'auto',
		colNames:['a'/*,'a'*/,'Jenis Imunisasi',/*'Vaksin',*/'Jumlah'],
		colModel :[ 
		{name:'jenisimunisasi',index:'jenisimunisasi', hidden:true}, 
		//{name:'namavaksin',index:'namavaksin', hidden:true},
		{name:'s',index:'s', width:200,align:'center'},
		//{name:'c',index:'c', width:200,align:'center'},
		{name:'jumlah',index:'jumlah', width:200,align:'center', hidden:true}
		],
		rowNum:35,
		viewrecords: true
	}); 
	
	var imunisasiid = 0;
	$('#tambahimunisasi').click(function(){
		if($('#jenisimunisasi').val() /*&& $('#namavaksin').val()*/){
		var myfirstrow = {jumlah:$('#jumlahid').val(), s:$('#jenisimunisasi option:selected').text(), /*c:$('#namavaksin option:selected').text(),*/ jenisimunisasi:$('#jenisimunisasi').val()};//, namavaksin:$('#namavaksin').val()};
			jQuery("#listimunisasi").addRowData(imunisasiid+1, myfirstrow);
			$('#jenisimunisasi option').attr('selected',false);
			$('#jenisimunisasi option').removeAttr('selected');
			//$('#namavaksin option').attr('selected',false);
			//$('#namavaksin option').removeAttr('selected');
			if(confirm('Tambah Data imunisasi & vaksin lain?')){
				$('#jenisimunisasi').focus();					
			}else{
				$('#pemeriksa').focus();
			}
		}else{
			alert('Silahkan Lengkapi Tindakan.');
		}
	})

	var petugasimunisasiid = 0;
	$('#tambahpetugasimunisasiid').click(function(){
		if($('#petugasimunisasisearch_tmpval').val()){
			var myfirstrow = {kd_petugas:$('#petugasimunisasisearch_tmpval').val(), petugas:$('#petugasimunisasisearch_tmptext').val(),keterangan:$('#pembinaid:checked').val()};
			jQuery("#listpetugasimunisasi").addRowData(petugasimunisasiid+1, myfirstrow);
			$('#petugasimunisasisearch').val('');
			$('#petugasimunisasisearch_tmpval').val('');
			$('#petugasimunisasisearch_tmptext').val('');
			$('#pembinaid').prop('checked',false);
			$('#pembinaid').removeProp('checked');
			if(confirm('Tambah Data Petugas Lain?')){
				$('#petugasimunisasisearch').focus();					
			}
		}else{
			alert('Silahkan Pilih Petugas.');
		}
	})
	
	$('#hapuspetugasimunisasiid').click(function(){
		jQuery("#listpetugasimunisasi").clearGridData();
	})
	
	$('#hapusimunisasi').click(function(){
		jQuery("#listimunisasi").clearGridData();
	})
	
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
	
	$( "#petugasimunisasisearch" ).catcomplete({
		source: "t_imunisasi/petugasimunisasisource",
		minLength: 2,
		select: function( event, ui ) {
		//log( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
			$('#petugasimunisasisearch_tmpval').val(ui.item.id);
			$('#petugasimunisasisearch_tmptext').val(ui.item.label);
	}
});


	$(':submit').click(function(e) {
		e.preventDefault();
		if($(this).closest("form").valid()) {
			if(kumpularray())$(this).closest("form").submit();
		}
		return false;
	});
	
	function kumpularray(){
		if($('#listimunisasi').getGridParam("records")>0){
			var rows= jQuery("#listimunisasi").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#imunisasi_final").val(JSON.stringify(paras));
		}
		if($('#listpetugasimunisasi').getGridParam("records")>0){
			var rows= jQuery("#listpetugasimunisasi").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#petugasimunisasi_final").val(JSON.stringify(paras));
		}
		return true;
	}
	
	$('#namavaksin').chained('#jenisimunisasi');
});

$('#kategoripasienid').on('change', function() {
	if ($(this).val()=='') {
		$('#formkategori_pasiensiswa').hide();
		$('#formkategori_pasienwushamil').hide();
		$('#formkategori_pasienwustdkhamil').hide();
	}else if ($(this).val()=='6') {
		$('#formkategori_pasiensiswa').hide();
		$('#formkategori_pasienwushamil').show();
		$('#formkategori_pasienwustdkhamil').show();
	}
	else if ($(this).val()=='5') {
		$('#formkategori_pasiensiswa').hide();
		$('#formkategori_pasienwushamil').show();
		$('#formkategori_pasienwustdkhamil').hide();
	}else if ($(this).val()=='7'|| $(this).val()=='8'){
		$('#formkategori_pasiensiswa').hide();
		$('#formkategori_pasienwushamil').hide();
	}else {
		$('#formkategori_pasiensiswa').show();
		$('#formkategori_pasienwushamil').hide();
	}
})

$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
	var n = $(":text,:radio,:checkbox,select,textarea").length;
	if (e.which == 13) 
	{
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		if(nextIndex < n && $(this).valid()){
			$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
		}else{			
			if($(this).closest("form").valid()) {
				$(this).closest("form").submit();
			}
			return false;
		}
	}
});

$("form").validate({
	rules: {
		hpht: {
			date:true,
			required: true
		}
	},
	messages: {
		hpht: {
			date: "Silahkan Masukkan Tanggal Sesuai Format",
			required:"Silahkan Lengkapi Data"
		}
	}
});

$('#hpht').mask('99/99/9999');
</script>
<?=getComboJenisPasienImunisasi('','kategoripasien','kategoripasienid','required','')?>

<fieldset style="display:none" id="formkategori_pasiensiswa">
	<span>
	<label>Nama Ibu</label>
	<input type="text" name="namaibu" id="namaibu" value="<?=isset($dataibu->NAMA_IBU)?$dataibu->NAMA_IBU:''?>"  />
	</span>
	<span>
</fieldset>	

<div style="display:none" id="formkategori_pasienwushamil">
<fieldset>	
	<span>
	<label>Nama Suami</label>
	<input type="text" name="namasuami" id="namasuami" value="<?=isset($datasuami->NAMA_SUAMI)?$datasuami->NAMA_SUAMI:''?>"  />
	</span>
</fieldset>
<div id="formkategori_pasienwustdkhamil">
<fieldset>	
	<span>
	<label>HPHT</label>
	<input type="text" class="mydate" name="hpht" id="hpht" value="<?=date('d/m/Y')?>"  />
	</span>
</fieldset>
<fieldset>	
	<span>
	<label>Kehamilan ke</label>
	<input type="text" name="kehamilanke" id="kehamilanke" value=""  />
	</span>
</fieldset>
<fieldset>	
	<span>
	<label>Jarak Kehamilan</label>
	<input type="text" name="jarakkehamilan" id="jarakkehamilan" value=""  />
	</span>
</fieldset>
</div>
</div>
<br/>
<table id="listimunisasi"></table>
<fieldset><?=getComboJenisimunisasi1('','imunisasi','jenisimunisasi','','inline')?>
	<span>
	<input type="hidden" name="jumlah" id="jumlahid" value="1" style="width:50px" />
	<input type="hidden" name="imunisasi_final" id="imunisasi_final" value=""  />
	<input type="button" value="Tambah" id="tambahimunisasi" />
	<input type="button" id="hapusimunisasi" value="Hapus" />
	</span>
</fieldset>
<!--<fieldset>	
	<?=getComboVaksin1('','vaksin','namavaksin','','inline')?>
	
</fieldset>-->
<br/>
<div class="subformtitle">Petugas</div>
<table id="listpetugasimunisasi"></table>
<fieldset id="fieldspetugasimunisasi">
	<span>
	<label>Cari Petugas</label>
	<input type="text" name="text" value="" id="petugasimunisasisearch" />
	</span>
	<span>
		<input type="checkbox" name="pembina" id="pembinaid" value="1">Pembina Wilayah
	</span>
	<span>
	<input type="hidden" name="petugasimunisasisearch_tmpval" id="petugasimunisasisearch_tmpval" />
	<input type="hidden" name="petugasimunisasisearch_tmptext" id="petugasimunisasisearch_tmptext" />
	<input type="hidden" name="petugasimunisasi_final" id="petugasimunisasi_final" />
	<input type="button" value="Tambah" id="tambahpetugasimunisasiid" />
	<input type="button" value="Hapus" id="hapuspetugasimunisasiid" />
	</span>
</fieldset>
<br/><?=getComboStatuskeluar('','status_keluar','status_keluar_id','required','')?>





