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
					$("#t401","#tabs").empty();
					$("#t401","#tabs").load('t_kunjungan_nifas'+'?_=' + (new Date()).getTime());
				}
			}
		});
		jQuery("#listtindakan").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 600,
			height: 'auto',
			colNames:['Kode Tindakan','Tindakan','Keterangan'],
			colModel :[ 
			{name:'kd_tindakan',index:'kd_tindakan', width:55,align:'center'}, 
			{name:'tindakan',index:'tindakan', width:81},
			{name:'keterangan',index:'keterangan', width:400}
			],
			rowNum:35,
			viewrecords: true
		});
		
var tindakanid = 0;
		$('#tambahtindakanid').click(function(){
			if($('#tindakansearch_tmpval').val()){
				var myfirstrow = {kd_tindakan:$('#tindakansearch_tmpval').val(),tindakan:$('#tindakansearch_tmptext').val(),keterangan:$('#keterangantindakanid').val()};
				jQuery("#listtindakan").addRowData(tindakanid+1, myfirstrow);
				$('#tindakansearch').val('');
				$('#tindakansearch_tmpval').val('');
				$('#tindakansearch_tmptext').val('');
				$('#keterangantindakanid').val('');
				if(confirm('Tambah Data Diagnosa Tindakan?')){
					$('#tindakansearch').focus();					
				}
			}else{
				alert('Silahkan Pilih Diagnosa.');
			}
			
		$('#hapustindakanid').click(function(){
			jQuery("#listtindakan").clearGridData();
		})
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

$('#showhide_kesimpulan_nifas').on('change', function() {
		if($(this).val()=='akhir_nifas'){
			$('#kesimpulannifasplaceholder').empty();
			$('#kesimpulannifasplaceholder').load('t_kunjungan_nifas/kesimpulanakhirnifas?_=' + (new Date()).getTime());
		}else{
			$('#kesimpulannifasplaceholder').empty();
		}
	});

$('#kunjungannifasadd :submit').click(function(e) {
	e.preventDefault();
	if($("#kunjungannifasadd").valid()) {
		if(kumpularray())$('#kunjungannifasadd').submit();
	}
	return false;
});

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
$( "#tindakansearch" ).catcomplete({
		source: "t_kunjungan_nifas/produksource",
		minLength: 1,
		select: function( event, ui ) {
			$('#tindakansearch_tmpval').val(ui.item.id);
			$('#tindakansearch_tmptext').val(ui.item.label);
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
			if($(this).attr('id')=='selectjenisdiagnosaid'){
				if($('#tindakansearch_tmpval').val()){
					$('#tambahtindakanid').focus();return false;
				}
			}
						
			$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
		}else{			
			if($("#kunjungannifasadd").valid()) {
				if(kumpularray())$('#kunjungannifasadd').submit();
			}
			return false;
		}
   }
});
		$( "#tindakansearch" ).catcomplete({
		source: "t_kunjungan_nifas/produksource",
		minLength: 1,
		select: function( event, ui ) {
			$('#tindakansearch_tmpval').val(ui.item.id);
			$('#tindakansearch_tmptext').val(ui.item.label);
		}
});	
	 $("#tanggal_daftart_pendaftaranadd").mask("99/99/9999");

$("#tanggal_daftart_pendaftaranadd").datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	function kumpularray(){

		if($('#listtindakan').getGridParam("records")>0){
			var rows= jQuery("#listtindakan").jqGrid('getRowData');
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
	$('#backlistkunjungan').click(function(){
		$("#t401","#tabs").empty();
		$("#t401","#tabs").load('t_kunjungan_nifas'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Kunjungan Nifas</div>
<div class="backbutton"><span class="kembali" id="backlistkunjungan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="kunjungannifasadd" method="post" action="<?=site_url('t_kunjungan_nifas/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal*</label>
		<input type="text" name="tanggal_daftart_pendaftaranadd" id="tanggal_daftart_pendaftaranadd" class="mydate" value="<?=date('d/m/Y')?>" required  />
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
				<option value="-">Negatif</option>
				<option value="+">Positif</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Buang Air kecil</label>
			<select name="bak">
				<option value="">---Silahkan Pilih---</option>
				<option value="-">Negatif</option>
				<option value="+">Positif</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Produksi ASI</label>
		<input type="text" name="produksi_asi" id="produksi_asi" value="" required />
		</span>
	</fieldset>
	<table id="listtindakan"></table>
	<fieldset id="fieldstindakan">
		<span>
		<label class="declabel2">Cari Tindakan</label>
		<input type="text" name="text" value="" id="tindakansearch" style="width:255px;" />
		</span>
		<span>
		<input type="hidden" name="tindakansearch_tmpval" id="tindakansearch_tmpval" />
		<input type="hidden" name="tindakansearch_tmptext" id="tindakansearch_tmptext" />
		<input type="hidden" name="tindakan_final" id="tindakan_final" />
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
	<fieldset>
		<span>
		<label>Nasehat</label>
		<textarea name="nasehat" id="nasehat" rows="3" cols="45" required></textarea>
		</span>
	</fieldset>
	<fieldset>
	<?=getComboPemeriksa('','pemeriksa','pemeriksa','required','inline')?>
	</fieldset>
	<fieldset>
	<?=getComboPetugas('','petugas','petugas','required','inline')?>
	</fieldset>
		
	<fieldset>
		<span>
		<label>Status Hamil</label>
			<select name="showhide_kesimpulan_nifas" value="stat_hamil" id="showhide_kesimpulan_nifas">
				<option value="">Pilih Status Hamil</option>
				<option value="masa_nifas">Masa Nifas</option>
				<option value="akhir_nifas">Akhir Nifas</option>				
			</select>
		</span>
	</fieldset>
	<div id="kesimpulannifasplaceholder"><!-- placeholder for loaded kesimpulan akhir nifas --></div>
	<br/>
	<br/>
	
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Simpan"/>
		&nbsp; - &nbsp;
		<input type="button" name="batal" value="Riwayat Kunjungan" />
		</span>
	</fieldset>	
	
</form>
</div >